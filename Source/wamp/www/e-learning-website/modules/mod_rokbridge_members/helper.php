<?php
/**
 * @version	$Id: helper.php 2047 2007-10-02 00:42:56Z rhuk $ 
 * @package RokBridge - phpBB3 edition
 * @copyright Copyright (C) 2009 RocketTheme. All rights reserved. 
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @author RocketTheme, LLC
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class modRokBridgeMembersHelper
{
    var $rokbridge;
    
	function modRokBridgeMembersHelper(&$rokbridge) {
	    global $mainframe;
        
		//test for rokbridge helper
		if (!class_exists('RokBridgeHelper')) {
		    $mainframe->enqueueMessage(JText::_('Error initializing mod_rokbridge_members, RokBridge not installed.'),"error");
		    return;
		    
		}
		$this->rokbridge =& $rokbridge;
    }
	
	function &getList($params )
	{
        $modulemode = $params->get('modulemode','latest');
        $default_avatar = JURI::root(true).'/'.$params->get('default_avatar','modules/mod_rokbridge_members/assets/default-avatar.png');
		
		if (!($forum_db =& $this->rokbridge->getDb()))
			return array();       
        
        $latest_members = array();
		
		$limit = trim($params->get( 'limit',20 ));
	
		if ($modulemode=='latest') {
    		$sql = "SELECT user_id, user_type, username, user_avatar, user_avatar_type, user_avatar_width, user_avatar_height, user_regdate, FROM_UNIXTIME(user_regdate,'%a %b %D %x %h:%i %p') AS reg_date
    		    FROM #__users
    		    WHERE user_type != 2
    			ORDER BY user_regdate DESC 
    			LIMIT 0, ".$limit ;
		} elseif ($modulemode=='top') {
		    $sql = "SELECT user_id, user_type, username, user_avatar, user_avatar_type, user_avatar_width, user_avatar_height, user_lastvisit, user_posts, FROM_UNIXTIME(user_lastvisit,'%a %b %D %x %h:%i %p') AS last_visit
    		    FROM #__users
    		    WHERE user_type != 2
    			ORDER BY user_posts DESC 
    			LIMIT 0, ".$limit ;
		} else {
            $time = (time() - (intval($params->get('onlinetime',5)) * 60));
		    $sql = "SELECT u.user_id, u.user_type, u.username, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, u.user_lastvisit, u.user_posts, s.session_time, u.user_allow_viewonline as show_online, FROM_UNIXTIME(user_lastvisit,'%a %b %D %x %h:%i %p') AS last_visit 
		        FROM #__users u, #__sessions s 
		        WHERE u.user_id = s.session_user_id AND s.session_time >= " . ($time - ((int) ($time % 30))) . " 
		        AND u.user_type != 2 AND s.session_user_id <> 1 
		        ORDER BY u.user_lastvisit 
		        DESC" ;
	    
		}

		$forum_db->setQuery($sql);
		
		$results = $forum_db->loadObjectList();
		
		// remove duplicate entries
		$rows = array();
		foreach ($results as $result) {
		    if (!array_key_exists($result->user_id,$rows)) {
		        $rows[$result->user_id] = $result;
		    }
		}
		
		/* Start Building Time */
		$formatdate = trim( $params->get( 'formatdate' ) );
	
		foreach ($rows as $row) {
		    if ($modulemode=='latest') {
    		    $date = &JFactory::getDate($row->reg_date);
        		$reg_date = $date->toFormat($formatdate);
        		$row->reg_date = $reg_date;
        		$row->extra_info = ' : '.$reg_date;
    	    } elseif ($modulemode=='top') {
    	        $row->extra_info = ' : Posts: '.$row->user_posts;
    	    } else {
    	        $row->extra_info = '';
    	        $time_online = floor((time() - intval($row->user_lastvisit))/60)+1;
    	        $row->extra_info = ' : Online '.$time_online.' mins';
    	    }
    	    $row->avatar_img = $rokbridge->getAvatar($row,$params->get('avatar_size',32),$row->extra_info,$default_avatar);
		    $latest_members[] = $row;
		}

		return $latest_members;
	}
}