<?php 
/**
 * @version	$Id: default.php 2047 2007-10-02 00:42:56Z rhuk $ 
 * @package RokBridge - phpBB3 edition
 * @copyright Copyright (C) 2009 RocketTheme. All rights reserved. Based on code from Ron Severdia & BrandWorkspace.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @author RocketTheme, LLC
 */
// no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<?php 
if($list)
{
	foreach($list as $item)
	{
		$forum_id 		= $item->forum_id;
		$topic_id 		= $item->topic_id;
		$topic_title	= $item->topic_title;
		$poster_id		= $item->poster_id;
		$post_id		= $item->post_id;
		$topic_first_post = $item->topic_first_post_id;

		/* Start Build Link URL */
		$showprofilelink = trim( $params->get( 'showprofilelink',0) );
		$showcreated = trim( $params->get( 'showcreated',0 ) );
		$directpost = trim( $params->get( 'directpost',0 ) );
		$posttargetwin = trim( $params->get( 'posttargetwin','_top' ) );
		$profiletargetwin = trim( $params->get( 'profiletargetwin','_top' ) );
		$timezone = trim( $params->get( 'timezone','' ) );
		$showre = trim( $params->get( 'showre',1 ) );
		
		if ($link_format=='bridged') :
    		$url = JURI::base().$bridge_path."/index.php?f=".$forum_id."&amp;t=".$topic_id."&amp;rb_v=viewtopic";
    		$posturl = JURI::base().$bridge_path."/index.php?f=".$forum_id."&amp;t=".$topic_id."&amp;rb_v=viewtopic#p".$post_id;
    		$profileurl = JURI::base().$bridge_path."/index.php?mode=viewprofile"."&amp;u=".$poster_id."&amp;rb_v=memberlist";
		/* End Build Link URL */
		else:
    		$url = JURI::base().$phpbb_path."/viewtopic.php?f=".$forum_id."&amp;t=".$topic_id;
    		$posturl = JURI::base().$phpbb_path."/viewtopic.php?f=".$forum_id."&amp;t=".$topic_id."#p".$post_id;
    		$profileurl = JURI::base().$phpbb_path."/memberlist.php?mode=viewprofile"."&amp;u=".$poster_id;		
		endif;
	
		/* Start Building Time */
		$formatdate = trim( $params->get( 'formatdate' ) );
		$date = &JFactory::getDate($item->post_time);
		$post_time = $date->toFormat($formatdate);
		/* End Building Time */
		
		/* Start Building Username */
			if($item->username) 
				$username = $item->username;
			else 
				$username = $item->post_username;
		/* Stop Building Username */
		
	    /* Check for reply or not */
	    if ($showre && $topic_first_post != $post_id)
	        $topic_title = "Re: ".$topic_title;
		
		/* Start Output */
		echo "<div class='latest_posts'>";
				
		if ($showcreated == 1) {
		/* Output latest posts created */
			echo "<div class='latest_posts_subject'><a href=\"".$url."\" target=\"".$posttargetwin."\" >".$topic_title."</a></div>";
			if ($showprofilelink == 1 && $profiletype==1) {
			/* Output latest posts created with phpBB link on profile name */
				echo "<div class='latest_posts_date'>Posted by <a href=\"".$profileurl."\" target=\"".$profiletargetwin."\" ><strong>".$username."</strong></a> - ".$post_time." ".$timezone."</div>";
			} else if ($showprofilelink == 1 && $profiletype==2) {
			/* Output latest posts created with CB link on profile name */
				echo "<div class='latest_posts_date'>Posted by <a href=\"".$profilecburl."\" target=\"".$profiletargetwin."\" ><strong>".$username."</strong></a> - ".$post_time." ".$timezone."</div>";
			} else {
			/* Output latest posts created with no link on profile name */
				echo "<div class='latest_posts_date'>Posted by <strong>".$username."</strong> - ".$post_time." ".$timezone."</div>";	
			}
		
		} else {
		/* Output latest active posts */
			if ($directpost == 1) {
			/* Output latest active posts with direct link to last post */
				echo "<div class='latest_posts_subject'><a href=\"".$posturl."\" target=\"".$posttargetwin."\" >".$topic_title."</a></div>";
			} else {
			/* Output latest active posts with link to thread */
				echo "<div class='latest_posts_subject'><a href=\"".$url."\" target=\"".$posttargetwin."\" >".$topic_title."</a></div>";
			}
			if ($showprofilelink == 1) {
			/* Output latest active posts with link to thread and link to phpBB profile */
				echo "<div class='latest_posts_date'>Posted by <a href=\"".$profileurl."\" target=\"".$profiletargetwin."\" ><strong>".$username."</strong></a> - ".$post_time." ".$timezone."</div>";
			} else {
			/* Output latest active posts with link to thread */
				echo "<div class='latest_posts_date'>Posted by <strong>".$username."</strong> - ".$post_time." ".$timezone."</div>";	
			}
		}
		echo "</div>";
		
	}
}
?>

