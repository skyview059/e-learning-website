<?php

/*------------------------------------------------------------------------
 # Yt News FrontPage  - Version 1.0
 # ------------------------------------------------------------------------
 # Copyright (C) 2009-2011 The YouTech Company. All Rights Reserved.
 # @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 # Author: The YouTech Company
 # Websites: http://www.ytcvn.com
 -------------------------------------------------------------------------*/

defined( '_JEXEC' ) or die( 'Restricted access' );
$themes = $params->get('themes',"default");
require_once (dirname(__FILE__).DS.'helper.php');


jimport("joomla.filesystem.folder");
jimport("joomla.filesystem.file");
/*-- Process---*/
$note 							= $params->get("note", 0);
$intro							= $params->get("intro", 0);
$start							= $params->get("start", 1);
$target 						= $params->get("target", '');
$jquery 						= $params->get("jquery", 0);
$play 							= $params->get("play", 'true');
//$theme 							= $params->get("theme", 'default');
$effect 						= $params->get("effect", 'fade');
$slideshow_speed 				= $params->get("slideshow_speed", 800);
$timer_speed 					= $params->get("timer_speed", 4000);
$start_clock_on_mouseOut 		= $params->get("start_clock_on_mouseOut", 'true');
$start_clock_on_mouseOutAfter 	= $params->get("start_clock_on_mouseOutAfter", 3000);
$caption_animation_speed 		= $params->get("caption_animation_speed", 800);
$background 					= $params->get("background", '#FFFFFF');
$title_color 					= $params->get("title_color", '#FFFFFF');
$prenext_show 					= $params->get("prenext_show", 1);
$caption_show 					= $params->get("caption_show", 'true');
$show_normal_title				= $params->get('show_normal_title',1);
$show_main_title				= $params->get('show_main_title',1);
$thumb_height 					= $params->get('thumb_height', "940");
$thumb_width 					= $params->get('thumb_width', "450");
$show_readmore 					= $params->get('show_readmore', "0");
$show_description 				= $params->get('show_description', "0");
$show_normal_description 		= $params->get('show_normal_description', "0");
$small_thumb_width 		        = $params->get('small_thumb_width', "0");
$small_thumb_height 		    = $params->get('small_thumb_height', "0");


$description_color 				= $params->get('description_color', "#FFFFFF");
$link_caption					= $params->get('link_caption', 1);
$link_image						= $params->get('link_image', 1);
$auto_play						= $params->get('auto_play', 1);
$show_img_on_right				= $params->get('show_img_on_right',1);
$button_theme					= $params->get('button_theme','number');
$desc_box_width					= $params->get('desc_box_width','440');
$width_content                  = $params->get('width_content','320');
$show_date                      = $params->get('show_date','1');
$total                          = $params->get('total');
$width_module                   = $params->get('width_module');


$width_content = $width_module - $thumb_width - 50;
 

$start--;
$readmore_img = '<div class="readmore_button"><p>'.JText::_('read more ').'</p></div>';

$center = round($thumb_height/2);
$bottom = 220;
$widthIe = 0;

if($center>$bottom)

$botoom = $center;


if (!defined ('YT_NEWS_FRONTPAGE')) {
	define ('YT_NEWS_FRONTPAGE', 1);

	if (!defined ('YTCJQUERY')){
		define('YTCJQUERY', 1);
		JHTML::script('ytc.jquery-1.5.min.js', JURI::base() . '/modules/'.$module->module.'/assets/js/');
	}
	JHTML::script('jquery.hoveraccordion.js',JURI::base() . '/modules/'.$module->module.'/assets/js/');
	/* Add css*/
	JHTML::stylesheet('style.css',JURI::base() . 'modules/'.$module->module.'/assets/');
	/* add JS files*/
	 

	$browser = new Browser();

	if($browser->Name=='msie' && floor($browser->Version)==6)
	{
		JHTML::stylesheet('ie6.css', JURI::base() . '/modules/'.$module->module.'/assets/');
	}
	else if($browser->Name=='msie' && floor($browser->Version)==7)
	{
		JHTML::stylesheet('ie7.css', JURI::base() . '/modules/'.$module->module.'/assets/');
	}

}

$items = modYtcNewsFrontPageHelper::process($params, $module);
//var_dump($items);die;
$count_items = count($items);
if($count_items<$total){
    $total = $count_items;    
}
if($themes == 'theme3'){
    if($total == 1){
        $widthpage_theme3 = $width_module;
    }else{
        $widthpage_theme3 = $width_module/($total - 1);
    }
}
if($total == 1 && $themes != 'theme3'){
    $width_module = $thumb_width + 22;
}
if($count_items > 0 ) {

	if ($count_items > 1) {

		foreach($items as $key=>$item)

		{

			if($key==0)

			{

				$pre = $count_items-1;

				$nex = $key+1;

			}

			elseif(($key+1)==$count_items)

			{

				$pre = $key-1;

				$nex = 0;

			}

			else

			{

				$pre = $key-1;

				$nex = $key+1;

			}



			$items[$key]['pre'] = $items[$pre]['small_thumb'];

			$items[$key]['nex'] = $items[$nex]['small_thumb'];

		}



	} else {

		$items[0]['pre'] = "";

		$items[0]['nex'] = "";

	}

}

//echo "<pre>".print_r($items,1);die;

/* Show html*/



$path = JModuleHelper::getLayoutPath( 'mod_yt_news_frontpage', $themes );

if (file_exists($path)) {

	require($path);

}

?>

