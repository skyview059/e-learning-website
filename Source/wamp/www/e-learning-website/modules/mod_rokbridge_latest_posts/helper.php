<?php
/**
 * @version	$Id: helper.php 2047 2007-10-02 00:42:56Z rhuk $ 
 * @package RokBridge - phpBB3 edition
 * @copyright Copyright (C) 2009 RocketTheme. All rights reserved. Based on code from Ron Severdia & BrandWorkspace.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @author RocketTheme, LLC
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class modRokBridgeLastPostsHelper
{
    var $rokbridge;
    
	function modRokBridgeLastPostsHelper(&$rokbridge) {
	    global $mainframe;
        
		//test for rokbridge helper
		if (!class_exists('RokBridgeHelper')) {
		    $mainframe->enqueueMessage(JText::_('Error initializing mod_rokbridge_latest_posts, RokBridge not installed.'),"error");
		    return;
		    
		}
		$this->rokbridge =& $rokbridge;
    }
	
	function &getList( $params )
	{
		$rows = null;
		$sqlStr = null;
		
        if (!($forum_db =& $this->rokbridge->getDb()))
			return array();
		
		$showcreated = trim( $params->get( 'showcreated' ) );

		$limit		= trim( $params->get( 'limit' ) );
		$include	= trim( $params->get( 'forumincl' ) );
		$include	= str_replace( ' ', '', $include );
		$include	= explode( ',', $include );
		$exclude	= trim( $params->get( 'forumexcl' ) );
		$exclude	= str_replace( ' ', '', $exclude );
		$exclude	= explode( ',', $exclude );
		$wheres		= array();
		$whereby	= '';
	
		if (count($include) && !empty($include[0])) {
			$wheres[] = "#__posts.forum_id in (". implode(",",$include) . ")";
		}
		
		if (count($exclude) && !empty($exclude[0])) {
			$wheres[] = "#__posts.forum_id not in (". implode(",",$exclude) . ")";
		}
		
		if (count($wheres)) {
			$whereby = ' WHERE '.implode(' AND ', $wheres);
		}

		if ($showcreated == 1) {
			$sqlStr = "SELECT #__topics.topic_id, #__topics.topic_title, #__posts.post_id, 
					#__posts.poster_id, #__posts.post_time, #__posts.forum_id, #__posts.post_username, 
					#__users.username, #__topics.topic_first_post_id
					FROM #__topics 
						INNER JOIN #__posts ON #__posts.topic_id = #__topics.topic_id 
						INNER JOIN #__users ON #__posts.poster_id = #__users.user_id 
					$whereby
					GROUP BY #__topics.topic_id
					ORDER BY #__topics.topic_id DESC 
					LIMIT 0, ".$limit;
		} 
		else {
			$limitsql = "select #__posts.post_id as id FROM #__posts " . $whereby . " ORDER BY #__posts.post_time DESC LIMIT 0, " .$limit;
			$forum_db->setQuery($limitsql);
			$limitrows = $forum_db->loadResultArray();
			if ($limitrows != null){	
				$limitwhere = "where #__posts.post_id in (". implode(",",$limitrows) .")";
				$sqlStr = "SELECT #__posts.post_id, #__posts.topic_id, #__posts.poster_id, 
				#__posts.post_time, #__posts.forum_id, #__posts.post_username, 
				#__topics.topic_title, #__users.username, #__topics.topic_first_post_id
				FROM #__posts 
					INNER JOIN #__topics ON #__posts.topic_id = #__topics.topic_id 
					INNER JOIN #__users ON #__posts.poster_id = #__users.user_id 
				$limitwhere
				ORDER BY #__posts.post_time DESC 
				LIMIT 0, ".$limit ;
			}	
		}
		
		if (!empty($sqlStr)) { 
			$forum_db->setQuery($sqlStr);
			$rows = $forum_db->loadObjectList();
		}
		return $rows;
	}
}