<?php
if (!defined('FLEXI_SECTION'))	
{
	$cparams =& JComponentHelper::getParams('com_flexicontent');
	define('FLEXI_SECTION', $cparams->get('flexi_section'));
}
if(!class_exists('JAFlexiHelperPro')){
class JAFlexiHelperPro{
	function getDatas(&$helper, $params)
	{
		require_once(JPATH_SITE.DS.'components'.DS.'com_flexicontent'.DS.'helpers'.DS.'route.php');
		$catsid = $params->get('flexi_catsid');
		if(!is_array($catsid)){
			$arr_cats[] = $catsid;
		}
		else{
			$arr_cats = $catsid;
		}
		JArrayHelper::toInteger($arr_cats);
		$moduleid = $helper->moduleid;
		$getChildren =  $params->get('getFlexiChildren', 1);
		foreach ($arr_cats as $catid)
		{		 		
			if (!$catid)continue;
			$params_cat = new JParameter('');
			$cooki_name = 'mod'.$moduleid.'_'.$catid;
			if(isset($_COOKIE[$cooki_name]) && $_COOKIE[$cooki_name]!='')
			{
				$cookie_user_setting = $_COOKIE[$cooki_name];
				$arr_values = explode('&', $cookie_user_setting);
				if($arr_values)
				{
					foreach ($arr_values as $row){
						list($k, $value) = explode('=', $row);
						if($k!=''){
							$params_cat->set($k, $value);
						}
					}
				}
			}	
			$_section = $this->loadCategories ( $catid, $helper );
			$_categories = $this->getCatFirstChilds($catid );
			$_categories_org = $_categories;
		
			$cookie_catsid = array();
			if($params_cat->get('cookie_catsid', '')!=''){
				$cookie_catsid = explode(',', $params_cat->get('cookie_catsid', ''));
				if($_categories){
					$temp = array();
					foreach ( $_categories as $k=>$cat ) {
						if(in_array($cat->id, $cookie_catsid)){
							$temp[] = $_categories[$k];
						}
					}
					$_categories = $temp;
				}
			}
			$cat_link = urldecode(JRoute::_(FlexicontentHelperRoute::getCategoryRoute($_section->id)));
			$cat_title = $_section->title;
			$cat_desc = $_section->description;
			
			if(count ( $_section ) && count($_categories)){
				foreach ( $_categories as $k=>$cat ) {
					$_categories[$k]->title = $_categories[$k]->title;
					$_categories[$k]->link = urldecode(JRoute::_(FlexicontentHelperRoute::getCategoryRoute($cat->id)));			
				}
			}								
			
			if($helper->get('groupbysubcat', 0))
			{
				if($_categories){
					foreach ( $_categories as $k=>$cat ) {
						$catids = array();
						$subcatids = array();
						$catids[] = $cat->id;
						if ($getChildren) 
						{
							$subcatids = $this->getCategoryChilds($cat->id, true);
							$catids = array_merge($catids, $subcatids);					
						}
						
						$rows = $this->getArticles(implode(',', $catids), $helper, $params_cat);
						if($rows){
							$articles[$cat->id] = $rows;
						}
					}
				}
			}
			else{
				$catids = array();
				$catids[] = $catid;
				if ($getChildren && count($_categories)) {
					foreach ($_categories as $cat){
						$catids[] = $cat->id;					
						$subcatids = $this->getCategoryChilds($cat->id);
						$catids = array_merge($catids, $subcatids);													
					}			
				}
				$articles = $this->getArticles(implode(',', $catids), $helper, $params_cat);
			}
			
			$helper->articles[$catid] = $articles;
			$helper->_section[$catid]  = $_section;
			$helper->_categories[$catid]  = $_categories;
			$helper->_categories_org[$catid]  = $_categories_org;
			$helper->cat_link[$catid] = $cat_link;
			$helper->cat_title[$catid] = $cat_title;
			$helper->cat_desc[$catid] = $cat_desc;
		}
	}
	function loadCategories($id,  &$helper) {
		
		$db = & JFactory::getDBO ();
		$query = "SELECT `id`, `title`, `section`, `description`, CASE WHEN CHAR_LENGTH(`alias`) THEN CONCAT_WS(\":\", `id`, `alias`) ELSE `id` END as `slug` ".
				"\n FROM `#__categories`  ".
				"\n WHERE published = 1 " .
				"\n AND  id='$id' " .
				"\n ORDER BY ordering";
		
		$db->setQuery ( $query );
		$cat = $db->loadObject ();

		if($cat){
			$cat->link = JRoute::_(FlexicontentHelperRoute::getCategoryRoute($cat->id));
		}
		return $cat;
	}
	function getCatFirstChilds($catid,$onlyid=false)
	{
		$db = & JFactory::getDBO ();
		if ($onlyid)
		{
			$query =  "SELECT id ";
		}
		else $query = "SELECT `id`, `title`, `section`, `description`, CASE WHEN CHAR_LENGTH(`alias`) THEN CONCAT_WS(\":\", `id`, `alias`) ELSE `id` END as `slug` ";
		$query .= "\n FROM `#__categories`  ".
				"\n WHERE published = 1 " .
				"\n AND  parent_id='$catid' " .
				"\n ORDER BY ordering";
		
		$db->setQuery ( $query );
		if ($onlyid)
		{
			return $db->loadResultArray();
		}
		$categories = $db->loadObjectList();

		if($categories){
			foreach ($categories as $k=>$cat){
				$categories[$k]->link = JRoute::_(FlexicontentHelperRoute::getCategoryRoute($cat->id));
			}
		}
		return $categories;
	}
	function getArticles($catids, &$helper, $params) {
		
		jimport('joomla.filesystem.file');
		$limit = (int)$params->get('introitems', $helper->get('introitems'))+(int)$params->get('linkitems', $helper->get('linkitems'));
		if(!$limit) $limit = 4;				
		$ordering = $helper->get('ordering','');
		$componentParams = &JComponentHelper::getParams('com_flexicontent');
		$limitstart = 0;

		$user = &JFactory::getUser();
		$db = &JFactory::getDBO();

		$jnow = &JFactory::getDate();
		$now = $jnow->toMySQL();
		$nullDate = $db->getNullDate();
				
		$query	=	'SELECT i.*,  u.name as creator,cc.description as catdesc, cc.title as cattitle,s.description as secdesc, s.title as sectitle,'  
					.' CASE WHEN CHAR_LENGTH(i.alias) THEN CONCAT_WS(":", i.id, i.alias) ELSE i.id END as slug,' 
					.' CASE WHEN CHAR_LENGTH(s.alias) THEN CONCAT_WS(":", s.id, s.alias) ELSE s.id END as secslug'
					.' FROM #__content AS i' . ' INNER JOIN #__categories AS cc ON cc.id = i.catid' 
					.' INNER JOIN #__sections AS s ON s.id = i.sectionid'  
					. ' LEFT JOIN #__flexicontent_cats_item_relations AS rel ON rel.itemid = i.id'
					. ' LEFT JOIN #__groups AS g ON g.id = i.access'
					. ' LEFT JOIN #__users AS u ON u.id = i.created_by';
			$query	.=' WHERE i.state != -1'
					. ' AND i.state != -2'
					. ' AND i.sectionid = ' . FLEXI_SECTION
					. ' AND (i.publish_up = ' . $db->Quote ( $nullDate ) . 
						' OR i.publish_up <= ' . $db->Quote ( $now ) . ' ) ' . 
						' AND (i.publish_down = ' . $db->Quote ( $nullDate ) . 
						' OR i.publish_down >= ' . $db->Quote ( $now ) . ' )' . 
						"\n AND rel.catid in ($catids)" ; 
						
		$ordering = $helper->get('ordering', 'ordering');
		if ($helper->get('showcontentfrontpage') == '0')
		{
			
			$query .= ' AND i.id not in (SELECT content_id FROM #__content_frontpage )';
		}

		else if ($helper->get('showcontentfrontpage') == '2')
		{
			$query .= ' AND i.id in (SELECT content_id FROM #__content_frontpage )';				
		}

		if($ordering=='rand') $query .= "\n ORDER BY RAND()";
		else $query .= "\n ORDER BY i.".$ordering;
		
		$db->setQuery($query, 0, $limit);
		$rows = $db->loadObjectList();
		
		$autoresize 			= 	intval (trim( $helper->get( 'autoresize', 0) ));
		$img_w 					= 	intval (trim( $helper->get( 'width', 100 ) ));
		$img_h 					= 	intval (trim( $helper->get( 'height', 100 ) ));
		$img_align 				= 	$helper->get( 'align' , 'left');
		$showimage 				= 	$params->get( 'showimage', $helper->get( 'showimage', 0 ));
		$maxchars 				= 	intval (trim( $helper->get( 'maxchars', 200 ) ));
		$hiddenClasses 			= 	trim( $helper->get( 'hiddenClasses', '' ) );
		$showdate 				= 	$helper->get( 'showdate', 0 );
		$enabletimestamp		=	$helper->get( 'timestamp', 0 );
		if($helper->get('JPlugins',1)){
					JPluginHelper::importPlugin('content');
					$dispatcher = & JDispatcher::getInstance();
		}
		if (count($rows)) {

			foreach ($rows as $j=>$row) 
			{

				//Clean title
				$row->title = JFilterOutput::ampReplace($row->title);
				$row->image = $helper->replaceImage ($row, $img_align, $autoresize, $maxchars, $showimage, $img_w, $img_h, $hiddenClasses);
				$row->text = $row->introtext;
				$row->link = urldecode(JRoute::_(FlexicontentHelperRoute::getItemRoute($row->id,$row->catid)));
				$row->cat_link = JRoute::_(FlexicontentHelperRoute::getCategoryRoute($row->catid));
				if($enabletimestamp) $row->created = $helper->generatTimeStamp($row->created);
			    else $row->created = JHTML::_('date', $row->created);
				$helper->_params->set('parsedInModule', 1);
				if ($maxchars && strlen ( $row->introtext ) > $maxchars) {
					$doc = JDocument::getInstance ();
					if (function_exists ( 'mb_substr' )) {
						$row->introtext1 = SmartTrim::mb_trim ( $row->introtext, 0, $maxchars, $doc->_charset );
					} else {
						$row->introtext1 = SmartTrim::trim ( $row->introtext, 0, $maxchars );
					}
				}
				if($helper->get('JPlugins',1)){
					$row->event = new stdClass();
					$results = $dispatcher->trigger('onPrepareContent', array (& $row,&$helper->_params, $limitstart));
					$row->event->afterDisplayTitle = trim(implode("\n", $results));
		
					$results = $dispatcher->trigger('onAfterDisplayTitle', array (& $row, &$helper->_params, $limitstart));
					$row->event->afterDisplayTitle = trim(implode("\n", $results));
		
					$results = $dispatcher->trigger('onBeforeDisplayContent', array (& $row, &$helper->_params, $limitstart));
					$row->event->beforeDisplayContent = trim(implode("\n", $results));
			
					$results = $dispatcher->trigger('onAfterDisplayContent', array (& $row, &$helper->_params, $limitstart));
					$row->event->afterDisplayContent = trim(implode("\n", $results));
						
				}
			//	$row->introtext = preg_replace("#{(.*?)}(.*?){/(.*?)}#s", '', $row->introtext);
				
				$rows[$j] = $row;
			}
		}
		
		return $rows;
	}
	function getCategoryChilds($catid, $clear = false) {

        static $array = array();
        if ($clear)
            $array = array();
        $user = &JFactory::getUser();
        $aid = (int) $user->get('aid');
        $catid = (int) $catid;
        $db = &JFactory::getDBO();
      //  $query = "SELECT * FROM #__k2_categories WHERE parent={$catid} AND published=1 AND trash=0 AND access<={$aid} ORDER BY ordering ";
       $query = "SELECT `id` FROM `#__categories`  ".
				"\n WHERE published = 1 " .
				"\n AND  parent_id='{$catid}' " .
				"\n ORDER BY ordering";
        $db->setQuery($query);
        $rows = $db->loadObjectList();

        foreach ($rows as $row) {
            array_push($array, $row->id);
            if ($this->hasChilds($row->id)) {
                $this->getCategoryChilds($row->id);
            }
        }
        return $array;
    }
    function hasChilds($id) {

        $id = (int) $id;
        $db = &JFactory::getDBO();
        $query = "SELECT * FROM #__categories WHERE parent_id={$id} AND published=1  ";
        $db->setQuery($query);
        $rows = $db->loadObjectList();

        if (count($rows)) {
            return true;
        } else {
            return false;
        }
    }
    function getTotalHits(){
		$db = & JFactory::getDBO ();
		
		$query = 'SELECT MAX(hits)' . 
				' FROM #__content';
		$db->setQuery ( $query);
		return $db->loadResult ();
	}	
}
}

?>