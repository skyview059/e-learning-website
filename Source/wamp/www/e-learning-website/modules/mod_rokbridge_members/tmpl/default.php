<?php 
/**
 * @version	$Id: default.php 2047 2007-10-02 00:42:56Z rhuk $ 
 * @package RokBridge - phpBB3 edition
 * @copyright Copyright (C) 2009 RocketTheme. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @author RocketTheme, LLC
 */
// no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<?php 

$output = "";
$showavatar = $params->get('showavatar',1);



if($list)
{
	foreach($list as $item)
	{
	    $show = 1;
	    if (isset($item->show_online)) {
	        $show = $item->show_online;
	    }
	    
	    if ($show):
	    
    		if ($link_format=='bridged') :
        		$profileurl = JURI::base().$bridge_path."/index.php?mode=viewprofile"."&amp;u=".$item->user_id."&amp;rb_v=memberlist";
    		else:
        		$profileurl = JURI::base().$phpbb_path."/memberlist.php?mode=viewprofile"."&amp;u=".$item->user_id;		
    		endif;
	

    		if ($showavatar==0) :
        		if ($params->get('showprofilelink',1)==1) :
        		    $output .= '<a href="'.$profileurl.'" class="rb-username" target="'.$params->get('profiletargetwin').'" >'.$item->username.'</a> ';
        		else:
        		    $output .= '<span class="rb-username">'.$item->username.'</a> ';
        		endif;	
    		
        		if ($params->get('showextra',0)==1):
        		    $output .= '<span class="rb-extrainfo">'.$item->extra_info.'</span>';
        		endif;	
    		
        		$outout .= ', ';
		
    		elseif ($showavatar==1):
        		if ($params->get('showprofilelink',1)==1) :
        		    $output .= '<a href="'.$profileurl.'" class="rb-avatar" target="'.$params->get('profiletargetwin').'" >'.$item->avatar_img.'</a> ';
        		else:
        		    $output .= '<span class="rb-avatar">'.$item->avatar_img.'</a> ';
        		endif;
    		
        	else:
        	    $output .= '<div class="rb-avatar-row">';
         		if ($params->get('showprofilelink',1)==1) :
        		    $output .= '<a href="'.$profileurl.'" class="rb-avatar" target="'.$params->get('profiletargetwin').'" >'.$item->avatar_img.'</a> ';
        		    $output .= '<a href="'.$profileurl.'" class="rb-username" target="'.$params->get('profiletargetwin').'" >'.$item->username.'</a> ';
        		else:
        		    $output .= '<span class="rb-avatar">'.$item->avatar_img.'</span> ';
        		    $output .= '<span class="rb-username">'.$item->username.'</span>';
        		endif;   
    		
        		if ($params->get('showextra',0)==1):
        		    $output .= '<span class="rb-extrainfo">'.$item->extra_info.'</span>';
        		endif;	   
        		$output .= '</div>';
        	endif;
        endif;
	}
}
echo "<div class=\"rb-latest-members\">\n";
echo (trim($output,", "));

if ($params->get('modulemode')=='online' and $params->get('showonline',1)==1):
    echo '<br /><span class="rk-onlinecount">'. JText::_('ROKBRIDGE_MEMBERS_ONLINE').' '.$count.'</span>';
endif;

echo "\n</div>";
?>

