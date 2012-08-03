<?php

if(!class_exists('JAK2HelperPro')){
class JAK2HelperPro{
	function getDatas(&$helper, $params)
	{
		
		require_once(JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
		require_once(JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'utilities.php');
		require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'models'.DS.'itemlist.php');
		$getChildren =  $params->get('getChildren', 1);
		 				
		$catsid = $params->get('k2catsid');
		if(!is_array($catsid)){
			$arr_cats[] = $catsid;
		}
		else{
			$arr_cats = $catsid;
		}
		$moduleid = $helper->moduleid;
			
		foreach ($arr_cats as $catid)
		{		 					
			$params_cat = new JParameter('');
			$cooki_name = 'mod'.$moduleid.'_'.$catid;
			if(isset($_COOKIE[$cooki_name]) && $_COOKIE[$cooki_name]!=''){
				$cookie_user_setting = $_COOKIE[$cooki_name];
				$arr_values = explode('&', $cookie_user_setting);
				if($arr_values){
					foreach ($arr_values as $row){
						list($k, $value) = explode('=', $row);
						if($k!=''){
							$params_cat->set($k, $value);
						}
					}
				}
			}
			$_section = $this->getCategory($catid);
			if(!$catid) continue;
			$_categories = K2ModelItemlist::getCategoryFirstChilds($catid, 'order');				

			if (! count ( $_section ) && !count($_categories))	return;
		
			$_categories_org = $_categories;
	
			$cookie_catsid = array();
			if($params_cat->get('cookie_catsid', '')!=''){
			$cookie_catsid = explode(',', $params_cat->get('cookie_catsid', ''));
			if($_categories){
					$temp = array();
					foreach ( $_categories as $k=>$cat ) {
						$cat->title = $cat->name;
						if(in_array($cat->id, $cookie_catsid)){
							$temp[] = $_categories[$k];
						}
					}
					$_categories = $temp;
				}
			}
			
			$cat_link = urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($_section->id.':'.urlencode($_section->alias))));
			$cat_title = $_section->name;
			$cat_desc = $_section->description;
			
			if(count ( $_section ) && count($_categories)){
				foreach ( $_categories as $k=>$cat ) {
					$_categories[$k]->title = $_categories[$k]->name;
					$_categories[$k]->link = urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($cat->id.':'.urlencode($cat->alias))));			
				}
			}								
			if($helper->get('groupbysubcat', 0))
			{
				$maxSubCats = $params_cat->get('maxSubCats', $helper->get('maxSubCats', -1));
				if($maxSubCats==-1) $maxSubCats = count($_categories);
				
				$temp = array();
				if($_categories){
					$i = 0;	
					foreach ( $_categories as $k=>$cat ) {
						$catids = array();
						$subcatids = array();
						$catids[] = $cat->id;
						if ($getChildren) 
						{
							$subcatids = K2ModelItemlist::getCategoryChilds($cat->id, true);
							$catids = array_merge($catids, $subcatids);					
						}
						
						$rows = $this->getArticles(implode(',', $catids), $helper, $params_cat);
						if($rows){
							$temp[] = $cat;
							$articles[$cat->id] = $rows;
							$i++;
							if($i==$maxSubCats) break;
						}
					}
					$_categories = $temp;
				}
			}
			else{
				$catids = array();
				$catids[] = $catid;
				if ($getChildren && count($_categories)) {
					foreach ($_categories as $cat){
						$catids[] = $cat->id;					
						$subcatids = K2ModelItemlist::getCategoryChilds($cat->id);
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
	
	function getArticles($catids, &$helper, $params) {
		
		jimport('joomla.filesystem.file');
		$limit = (int)$params->get('introitems', $helper->get('introitems'))+(int)$params->get('linkitems', $helper->get('linkitems'));
		if(!$limit) $limit = 4;				
		$ordering = $helper->get('ordering','');
		$componentParams = &JComponentHelper::getParams('com_k2');
		$limitstart = 0;

		$user = &JFactory::getUser();
		$aid = $user->get('aid');
		$db = &JFactory::getDBO();

		$jnow = &JFactory::getDate();
		$now = $jnow->toMySQL();
		$nullDate = $db->getNullDate();
		
		$query = "SELECT i.*, c.name AS categoryname,c.id AS categoryid, c.alias AS categoryalias, c.name as cattitle, c.params AS categoryparams";	
		$query .= "\n FROM #__k2_items as i LEFT JOIN #__k2_categories c ON c.id = i.catid";
		$query .= "\n WHERE i.published = 1 AND i.access <= {$aid} AND i.trash = 0 AND c.published = 1 AND c.access <= {$aid} AND c.trash = 0";
		$query .= "\n AND i.catid IN ($catids)";
		$query .= "\n AND ( i.publish_up = ".$db->Quote($nullDate)." OR i.publish_up <= ".$db->Quote($now)." )";
		$query .= "\n AND ( i.publish_down = ".$db->Quote($nullDate)." OR i.publish_down >= ".$db->Quote($now)." )";		
	
		if ($helper->get('showfeaturedItems') == '0')
		$query .= "\n AND i.featured != 1";

		if ($helper->get('showfeaturedItems') == '2')
		$query .= "\n AND i.featured = 1";
		
		if ($helper->get('timerange')>0){
			$datenow = &JFactory::getDate();
			$date = $datenow->toMySQL();
			$query .= " AND i.created > DATE_SUB('{$date}',INTERVAL ".$helper->get('timerange')." DAY) ";
		}
		
		switch ($ordering) {			
			case 'ordering':
				if ($helper->get('showfeaturedItems') == '2')
					$ordering = 'featured_ordering';
				else
					$ordering = 'ordering';
				break;

			case 'rorder':
				if ($helper->get('showfeaturedItems') == '2')
					$ordering = 'featured_ordering DESC';
				else
					$ordering = 'ordering DESC';
				break;
		
			case 'rand':
				$ordering = 'RAND()';
				break;					
		}

		if($ordering=='RAND()') $query .= "\n ORDER BY ".$ordering;
		else $query .= "\n ORDER BY i.".$ordering;
		$db->setQuery($query, 0, $limit);
		$rows = $db->loadObjectList();
		
		/*require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'models'.DS.'item.php');
		$model = new K2ModelItem;*/
		
		$autoresize 			= 	intval (trim( $helper->get( 'autoresize', 0) ));
		$img_w 					= 	intval (trim( $helper->get( 'width', 100 ) ));
		$img_h 					= 	intval (trim( $helper->get( 'height', 100 ) ));
		$img_align 				= 	$helper->get( 'align' , 'left');
		$showimage 				= 	$params->get( 'showimage', $helper->get( 'showimage', 0 ));
		$maxchars 				= 	intval (trim( $helper->get( 'maxchars', 200 ) ));
		$hiddenClasses 			= 	trim( $helper->get( 'hiddenClasses', '' ) );
		$showdate 				= 	$helper->get( 'showdate', 0 );
		$enabletimestamp		=	$helper->get( 'timestamp', 0 );
		
		if (count($rows)) {

			foreach ($rows as $j=>$row) {
				
				$row->cat_link = urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($row->categoryid.':'.urlencode($row->categoryalias))));
				
				//Clean title
				$row->title = JFilterOutput::ampReplace($row->title);
				
				//Images
				$image = '';
				if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_XL.jpg'))
				$image = JURI::root().'media/k2/items/cache/'.md5("Image".$row->id).'_XL.jpg';
				
				elseif (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_XS.jpg'))
				$image = JURI::root().'media/k2/items/cache/'.md5("Image".$row->id).'_XS.jpg';

				elseif (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_L.jpg'))
				$image = JURI::root().'media/k2/items/cache/'.md5("Image".$row->id).'_L.jpg';
				
				elseif (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_S.jpg'))
				$image = JURI::root().'media/k2/items/cache/'.md5("Image".$row->id).'_S.jpg';

				elseif (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_M.jpg'))
				$image = JURI::root().'media/k2/items/cache/'.md5("Image".$row->id).'_M.jpg';

				elseif (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_Generic.jpg'))
				$image = JURI::root().'media/k2/items/cache/'.md5("Image".$row->id).'_Generic.jpg';
				
				if($image!=''){
					$thumbnailMode = $helper->get( 'thumbnail_mode', 'crop' );
					$aspect 	   = $helper->get( 'use_ratio', '1' );
					$crop = $thumbnailMode == 'crop' ? true:false;
					$align = $img_align ? "align=\"$img_align\"" : "";
					
					$jaimage = JAImage::getInstance();
					if( $thumbnailMode != 'none' && $jaimage->sourceExited($image) ) {
						$imageURL = $jaimage->resize( $image, $img_w, $img_h, $crop, $aspect );
						$row->image = $imageURL ? "<img class=\"$img_align\" src=\"" . $imageURL . "\" alt=\"{$row->title}\" $align />" : "";
					} else {
						$width = $img_w ? "width=\"$img_w\"" : "";
						$height = $img_h ? "height=\"$img_h\"" : "";
						$row->image = "<img class=\"$img_align\" src=\"" . $image . "\" alt=\"{$row->title}\" $img_w $img_h $align />";
					}
					
					if ($maxchars && strlen ( $row->introtext ) > $maxchars) {
						$doc = JDocument::getInstance ();
						if (function_exists ( 'mb_substr' )) {
							$row->introtext1 = SmartTrim::mb_trim ( $row->introtext, 0, $maxchars, $doc->_charset );
						} else {
							$row->introtext1 = SmartTrim::trim ( $row->introtext, 0, $maxchars );
						}
					}
					elseif($maxchars==0){
						$row->introtext1 = '';
					}
				}
				else{
					$row->image = $helper->replaceImage ($row, $img_align, $autoresize, $maxchars, $showimage, $img_w, $img_h, $hiddenClasses);
					if($maxchars==0){
						$row->introtext1 = '';
					}
				}
				
				
				// Introtext
				$row->text = $row->introtext;
				
				//Read more link
				$row->link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($row->id.':'.urlencode($row->alias), $row->catid.':'.urlencode($row->categoryalias))));
				
				$helper->_params->set('parsedInModule', 1);
				
				$dispatcher = &JDispatcher::getInstance();
				
				if($helper->get('JPlugins',1)){

					//Plugins
					$results = $dispatcher->trigger('onBeforeDisplay', array(&$row, &$helper->_params, $limitstart));
					$row->event->BeforeDisplay = trim(implode("\n", $results));

					$results = $dispatcher->trigger('onAfterDisplay', array(&$row, &$helper->_params, $limitstart));
					$row->event->AfterDisplay = trim(implode("\n", $results));

					$results = $dispatcher->trigger('onAfterDisplayTitle', array(&$row, &$helper->_params, $limitstart));
					$row->event->AfterDisplayTitle = trim(implode("\n", $results));

					$results = $dispatcher->trigger('onBeforeDisplayContent', array(&$row, &$helper->_params, $limitstart));
					$row->event->BeforeDisplayContent = trim(implode("\n", $results));

					$results = $dispatcher->trigger('onAfterDisplayContent', array(&$row, &$helper->_params, $limitstart));
					$row->event->AfterDisplayContent = trim(implode("\n", $results));

					$dispatcher->trigger('onPrepareContent', array(&$row, &$helper->_params, $limitstart));
					$row->introtext = $row->text;
						
				}
				
				//Init K2 plugin events
				$row->event->K2BeforeDisplay = '';
				$row->event->K2AfterDisplay = '';
				$row->event->K2AfterDisplayTitle = '';
				$row->event->K2BeforeDisplayContent = '';
				$row->event->K2AfterDisplayContent = '';
				$row->event->K2CommentsCounter = '';
					
				
				//K2 plugins
				if($helper->get('K2Plugins',1)){
					JPluginHelper::importPlugin('k2');
					
					$results = $dispatcher->trigger('onK2BeforeDisplay', array(&$row, &$helper->_params, $limitstart));
					$row->event->K2BeforeDisplay = trim(implode("\n", $results));
	
					$results = $dispatcher->trigger('onK2AfterDisplay', array(&$row, &$helper->_params, $limitstart));
					$row->event->K2AfterDisplay = trim(implode("\n", $results));
	
					$results = $dispatcher->trigger('onK2AfterDisplayTitle', array(&$row, &$helper->_params, $limitstart));
					$row->event->K2AfterDisplayTitle = trim(implode("\n", $results));
	
					$results = $dispatcher->trigger('onK2BeforeDisplayContent', array(&$row, &$helper->_params, $limitstart));
					$row->event->K2BeforeDisplayContent = trim(implode("\n", $results));
	
					$results = $dispatcher->trigger('onK2AfterDisplayContent', array(&$row, &$helper->_params, $limitstart));
					$row->event->K2AfterDisplayContent = trim(implode("\n", $results));
	
					$dispatcher->trigger('onK2PrepareContent', array(&$row, &$helper->_params, $limitstart));
					$row->introtext = $row->text;
				}
								
				
				//Clean the plugin tags
				$row->introtext = preg_replace("#{(.*?)}(.*?){/(.*?)}#s", '', $row->introtext);
				$row->introtext = '<p>'.$row->introtext.'</p>';
				
				//Author
				if ($helper->get('showcreator')) {
					if (! empty($row->created_by_alias)) {
						$row->creator = $row->created_by_alias;
						$row->authorGender = NULL;						
					} else {
						$author = &JFactory::getUser($row->created_by);
						$row->creator = $author->name;
						$query = "SELECT `gender` FROM #__k2_users WHERE userID=".(int)$author->id;
						$db->setQuery($query, 0, 1);
						$row->authorGender = $db->loadResult();						
						//Author Link
						$row->authorLink = JRoute::_(K2HelperRoute::getUserRoute($row->created_by));
					}
				}

				$row->created = ($row->modified!='' && $row->modified!='0000-00-00 00:00:00')?$row->modified:$row->created;
				if($enabletimestamp) $row->created = $helper->generatTimeStamp($row->created);
				else $row->created = JHTML::_('date', $row->created);
				
				$rows[$j] = $row;
			}
		}
		
		return $rows;
	}
	function getCategory($catid){
		
		$user = &JFactory::getUser();
        $aid = $user->get('aid');
        $db = &JFactory::getDBO();
        $query = "SELECT *, name as title FROM #__k2_categories WHERE id={$catid} AND published=1 AND trash=0 AND access<={$aid} ";

        $db->setQuery($query);
        $row = $db->loadObject();
        
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
		        
        return $row;
	}
	
	function getTotalHits(){
		$db = & JFactory::getDBO ();
		
		$query = 'SELECT MAX(hits)' . 
				' FROM #__k2_items';
		$db->setQuery ( $query);
		return $db->loadResult ();
	}	
}
}

?>