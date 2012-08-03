<?php
/*
# ------------------------------------------------------------------------
# Ja NewsPro
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: JoomlArt.com
# Websites: http://www.joomlart.com - http://www.joomlancers.com.
# ------------------------------------------------------------------------
*/

// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );
require_once (dirname ( __FILE__ ) . DS . 'helpers'. DS . 'helper.php');

$files = JFolder::files(dirname ( __FILE__ ) . DS . 'helpers'. DS.'adapter');
if($files){
	foreach ($files as $file){
		require_once (dirname ( __FILE__ ) . DS . 'helpers'. DS. 'adapter' . DS . $file);
	}	
}

$helper = new modJaNewsProHelper ( $module, $params );

if (JRequest::getBool ('janajax')) {
	$moduleid = JRequest::getInt('moduleid');
	if( $moduleid != $module->id) return;
		
	$group = JRequest::getString('group');

	$cookie_value = array();
	
	$arr_catsid = JRequest::getVar('categories', array(), 'default', 'array');
	if($arr_catsid){
		$cookie_value[] = 'cookie_catsid='.implode(',', $arr_catsid);
	}
	
	if(isset($_REQUEST['showimage'])){
		$cookie_value[] = 'showimage='.JRequest::getInt('showimage', 0);
	}
	
	if(isset($_REQUEST['introitems'])){
		$cookie_value[] = 'introitems='.JRequest::getInt('introitems', 1);
	}
	
	if(isset($_REQUEST['linkitems'])){
		$cookie_value[] = 'linkitems='.JRequest::getInt('linkitems', 1);
	}
	$cookie_value[] = 'maxSubCats=-1';
	
	if($cookie_value){
		$cookie_value = implode('&', $cookie_value);
		$cookie_name = 'mod'.$moduleid.'_'.$group;		
		setcookie($cookie_name, $cookie_value, time()+30*24*3600, '/');
		$_COOKIE[$cookie_name] = $cookie_value;
	}
	//$helper->set('maxSubCats', -1);				
}
elseif(JRequest::getBool('janewspro_linear_ajax')){
	$moduleid = JRequest::getInt('moduleid');
	if( $moduleid != $module->id) return;
	
	$catid = JRequest::getInt('subcat');
	if(!$catid) return ;
	$params->set('catsid', 'cat.'.$catid);
	$params->set('flexi_catsid', $catid);
	$params->set('k2catsid', $catid);
}
$theme = $helper->get('themes', 'default');
if($theme=='linear'){
	$helper->set('groupbysubcat', 0);
}
$helper->_load ($params, $module->id);

if (!defined ('_MODE_JAMODNEWSPRO_ASSETS_')) {
	define ('_MODE_JAMODNEWSPRO_ASSETS_', 1);
	JHTML::stylesheet('style.css','modules/'.$module->module.'/assets/css/');
	
	if (is_file(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'css'.DS.$module->module.".css"))
	JHTML::stylesheet($module->module.".css", 'templates/'.$mainframe->getTemplate().'/css/');
		
	JHTML::_('behavior.mootools');
	JHTML::_('behavior.tooltip');
	JHTML::script('script.js','modules/'.$module->module.'/assets/js/');
}

if (!defined ('_MODE_JAMODNEWSPRO_ASSETS_'.$theme)) {
	define ('_MODE_JAMODNEWSPRO_ASSETS_'.$theme, 1);

	if (is_file(JPATH_SITE.DS.'modules'.DS.$module->module.DS.'tmpl'.DS.$theme.DS."style.css"))
	JHTML::stylesheet("style.css", 'modules/'.$module->module.'/tmpl/'.$theme.'/');
		
	if (is_file(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.$module->module.DS.$theme.DS."style.css"))
	JHTML::stylesheet("style.css", 'templates/'.$mainframe->getTemplate().'/html/'.$module->module.'/'.$theme.'/');
}

if(JRequest::getBool('janewspro_linear_ajax')){	
	
	$path = JModuleHelper::getLayoutPath ( $module->module, $theme.'/blog_item' );
	if (file_exists ( $path )) {
		ob_clean();
		$rows = array();
		if($helper->articles){
			foreach ($helper->articles as $secid=>$rows){					
				break;
			}
			require ($path);
		}		
		exit;
	}
}

$path = JModuleHelper::getLayoutPath ( $module->module, $theme.'/blog' );
if (file_exists ( $path )) {
	if (JRequest::getBool ('janajax')) {
		ob_clean();
		require ($path);
		exit;
	} else 
	require ($path);
}

?>