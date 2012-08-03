<?php
if(!class_exists('JANewsHelperPro')){
class JANewsHelperPro{
	
	function getDatas(&$helper, $params){											
		$catsid = $params->get('catsid');
		$type = $helper->get('type');
		if(!is_array($catsid)){
			$arr_cats[] = $catsid;
		}
		else{
			$arr_cats = $catsid;
		}
		$moduleid = $helper->moduleid;
		foreach ($arr_cats as $cat)
		{
			$type_arr = explode('.', $cat);
			$type = $type_arr[0];
			$catid = isset($type_arr[1])?$type_arr[1]:0;
	
			$params_cat = new JParameter('');
			$cooki_name = 'mod'.$moduleid.'_'.$type.$catid;
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
				
							
			//$catid = $helper->get('chooseCatid');
			
			$_categories = array();
			$_section = array();
			$articles = array();
			$cats = array();
			if(!$catid) continue;
			
			if($type=='sec'){
				$_section = $this->loadSection ($catid, $helper);
				$_categories = $this->loadCategories ( $catid, 'section', $helper );
				$cat_link = JRoute::_(ContentHelperRoute::getSectionRoute($_section->id));
				$cat_title = $_section->title;
				$cat_desc = $_section->description;
			}
			elseif($type=='cat'){			
				$cats = $this->loadCategories ( $catid, 'category', $helper );
				if($cats){
					foreach ($cats as $cat){
						$cat_link = JRoute::_(ContentHelperRoute::getCategoryRoute($cat->id, $cat->section));
						$cat_title = $cat->title;
						$cat_desc = $cat->description;
						$_section = $cat;					
						break;
					}
				}
			}
			if (! count ( $_section ) && !count($_categories))	return;
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
			
			if($helper->get('groupbysubcat', 0)){
				$maxSubCats = $params_cat->get('maxSubCats', $helper->get('maxSubCats', -1));	
				if($maxSubCats==-1) $maxSubCats = count($_categories);
						
				$temp = array();
				if($_categories){
					$i = 0;	
					foreach ( $_categories as $j=>$cat ) {
						$rows = $this->getArticles($cat->id, $helper, $params_cat);
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
				if($_categories){
					foreach ($_categories as $cat){
						$catids[] = $cat->id;
					}				
				}
				elseif($cats){
					$catids[] = $_section->id;
				}
				$catids = implode(',', $catids);
				$articles = $this->getArticles($catids, $helper, $params_cat);
			}
			$helper->articles[$type.$catid] = $articles;
			$helper->_section[$type.$catid]  = $_section;
			$helper->_categories[$type.$catid]  = $_categories;
			$helper->_categories_org[$type.$catid]  = $_categories_org;
			$helper->cat_link[$type.$catid] = $cat_link;
			$helper->cat_title[$type.$catid] = $cat_title;
			$helper->cat_desc[$type.$catid] = $cat_desc;
		 }
		 
	}
	
	function loadSection($secid, &$helper) {
		$sections = array ();
		
		$where = " AND `id`=$secid";
		
		$db = & JFactory::getDBO ();
		$query = "SELECT s.`id`, s.`title`, s.`description`, CASE WHEN CHAR_LENGTH(s.`alias`) THEN CONCAT_WS(\":\", s.`id`, s.`alias`) ELSE s.id END as slug ".
					"\n FROM #__sections s ".
					"\n WHERE s.`published`= 1" . $where. 
					"\n ORDER BY s.`ordering`";
		
		$db->setQuery ( $query );
		return $db->loadObject();			
	}
	
	function loadCategories($id, $type='section', &$helper) {
		if($type=='section'){
			$where = " and section='$id'";
		}
		elseif($type=='category'){
			$where = " and id='$id'";
		}
		
		$db = & JFactory::getDBO ();
		$query = "SELECT `id`, `title`, `section`, `description`, CASE WHEN CHAR_LENGTH(`alias`) THEN CONCAT_WS(\":\", `id`, `alias`) ELSE `id` END as `slug` ".
				"\n FROM `#__categories`  ".
				"\n WHERE `published`=1 " . $where . 
				"\n ORDER BY `ordering`";
		
		$db->setQuery ( $query );
		$categories = $db->loadObjectList ();

		if($categories){
			foreach ($categories as $k=>$cat){
				$categories[$k]->link = JRoute::_(ContentHelperRoute::getCategoryRoute($cat->id, $cat->section));
			}
		}
		return $categories;
	}
	
	function getArticles($catids, &$helper, $params) {
		
		global $mainframe;
		$db = & JFactory::getDBO ();
		$user = & JFactory::getUser ();
		$aid = $user->get ( 'aid', 0 );
		
		$contentConfig = &JComponentHelper::getParams ( 'com_content' );
		$noauth = ! $contentConfig->get ( 'shownoauth' );
					
		jimport ( 'joomla.utilities.date' );
		$date = new JDate ( );
		$now = $date->toMySQL ();
		
		$nullDate = $db->getNullDate ();			
		$limit = (int)$params->get('introitems', $helper->get('introitems'))+(int)$params->get('linkitems', $helper->get('linkitems'));
		if(!$limit) $limit = 4;
		$ordering = $helper->get('ordering', 'ordering');
		
		// query to determine article count
		$query = 'SELECT a.*,u.name as creator,cc.description as catdesc, cc.title as cattitle,s.description as secdesc, s.title as sectitle,' . 
				' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,' . 
				' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug,' . 
				' CASE WHEN CHAR_LENGTH(s.alias) THEN CONCAT_WS(":", s.id, s.alias) ELSE s.id END as secslug' . 
				' FROM #__content AS a' . ' INNER JOIN #__categories AS cc ON cc.id = a.catid' . 
				' INNER JOIN #__sections AS s ON s.id = a.sectionid' . 
				' LEFT JOIN #__users AS u ON a.created_by = u.id';
		
		$query .= ' WHERE a.state = 1 ' . ($noauth ? ' AND a.access <= ' . ( int ) $aid . 
						' AND cc.access <= ' . ( int ) $aid . 
						' AND s.access <= ' . ( int ) $aid : '') . 
						' AND (a.publish_up = ' . $db->Quote ( $nullDate ) . 
						' OR a.publish_up <= ' . $db->Quote ( $now ) . ' ) ' . 
						' AND (a.publish_down = ' . $db->Quote ( $nullDate ) . 
						' OR a.publish_down >= ' . $db->Quote ( $now ) . ' )' . 
						"\n AND cc.id in ($catids)". 
						' AND cc.section = s.id' . 
						' AND cc.published = 1' . 
						' AND s.published = 1';
		if ($helper->get('showcontentfrontpage') == '0')
		$query .= ' AND a.id not in (SELECT content_id FROM #__content_frontpage )';
		elseif ($helper->get('showcontentfrontpage') == '2')
		$query .= ' AND a.id in (SELECT content_id FROM #__content_frontpage )';				
		
		if ($helper->get('timerange')>0){
			$datenow = &JFactory::getDate();
			$date = $datenow->toMySQL();
			$query .= " AND ( 
							(a.modified > DATE_SUB('{$date}',INTERVAL ".$helper->get('timerange')." DAY))  
							OR 
							(a.created > DATE_SUB('{$date}',INTERVAL ".$helper->get('timerange')." DAY)) 
						)";
		}
		
		if($ordering=='rand') $query .= "\n ORDER BY RAND()";
		else $query .= "\n ORDER BY a.".$ordering;
		
		$query .= " LIMIT 0, $limit";
		
		$db->setQuery ( $query);
		$rows = $db->loadObjectList ();
		if($helper->get('JPlugins', 1)){
			JPluginHelper::importPlugin ( 'content' );
			$dispatcher = & JDispatcher::getInstance ();
			$com_params = & $mainframe->getParams ( 'com_content' );
		}					
		
		$autoresize 			= 	intval (trim( $helper->get( 'autoresize', 0) ));
		$img_w 					= 	intval (trim( $helper->get( 'width', 100 ) ));
		$img_h 					= 	intval (trim( $helper->get( 'height', 100 ) ));
		$img_align 				= 	$helper->get( 'align' , 'left');
		$showimage 				= 	$params->get( 'showimage', $helper->get( 'showimage', 0 ));
		$maxchars 				= 	intval (trim( $helper->get( 'maxchars', 200 ) ));
		$hiddenClasses 			= 	trim( $helper->get( 'hiddenClasses', '' ) );
		$showdate 				= 	$helper->get( 'showdate', 0 );
		$enabletimestamp		=	$helper->get( 'timestamp', 0 );
		
		for($i = 0; $i < count ( $rows ); $i ++) {
			$rows [$i]->cat_link = JRoute::_(ContentHelperRoute::getCategoryRoute($rows [$i]->catid, $rows [$i]->sectionid));
			$rows [$i]->created = ($rows [$i]->modified!='' && $rows [$i]->modified!='0000-00-00 00:00:00')?$rows [$i]->modified:$rows [$i]->created;
			if($enabletimestamp) $rows [$i]->created = $helper->generatTimeStamp($rows [$i]->created);
			else $rows [$i]->created = JHTML::_('date', $rows [$i]->created);
			
			$rows [$i]->text = $rows [$i]->introtext;
			if($helper->get('JPlugins', 1)){
				$dispatcher->trigger ( 'onPrepareContent', array (& $rows [$i], & $com_params, 0 ) );
			}
			$rows [$i]->introtext = $rows [$i]->text;
			$rows [$i]->link   =  JRoute::_(ContentHelperRoute::getArticleRoute($rows [$i]->slug, $rows [$i]->catslug, $rows [$i]->sectionid));
			$rows [$i]->introtext1 = $rows [$i]->introtext;
			$rows [$i]->image = $helper->replaceImage ($rows [$i], $img_align, $autoresize, $maxchars, $showimage, $img_w, $img_h, $hiddenClasses);
			if($maxchars==0) $rows [$i]->introtext1 = '';
		}			
		
		return $rows;
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