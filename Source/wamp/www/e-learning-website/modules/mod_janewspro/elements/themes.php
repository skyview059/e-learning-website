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

// Ensure this file is being included by a parent file
defined('_JEXEC') or die( 'Restricted access' );
require_once("japaramhelper.php");
/**
 * Radio List Element
 *
 * @since      Class available since Release 1.2.0
 */
class JElementThemes extends JElement
{
	function fetchElement( $name, $value, &$node, $control_name ) {
		$uri = str_replace(DS,"/",str_replace( JPATH_SITE, JURI::base (), dirname(__FILE__) ));
		$uri = str_replace("/administrator", "", $uri);
		if(!defined('japaramhelper2')){			
			JHTML::stylesheet('japaramhelper2.css', $uri."/assets/css/");
			JHTML::script('japaramhelper2.js', $uri."/assets/js/");
					
			jimport('joomla.filesystem.folder');
			jimport('joomla.filesystem.file');
			
			define('japaramhelper2', true);
		}		
		
		/* Get all themes name folder from folder themes */
		$themes = array();
		
		// get in module
		$path = JPATH_SITE.DS.'modules'.DS.'mod_janewspro'.DS.'tmpl';		
		if(!JFolder::exists($path)) return JText::_('Themes Folder not exist');
		$folders = JFolder::folders($path);
		if($folders){
			foreach ($folders as $fname){
				$themes[$fname] = $fname;
			}
		}
		
		// get in template	 
		$template = JElementJaparamhelper2::get_active_template();
		$path = JPATH_SITE.DS.'templates'.DS.$template.DS.'html'.DS.'mod_janewspro';		
		if(JFolder::exists($path)){
			$folders = JFolder::folders($path);
			if($folders){
				foreach ($folders as $fname){
					$themes[$fname] = $fname;
				}
			}
		}
			
		$HTMLThemes = array();
		if($themes){
			foreach ($themes as $fname){
				//
				$f = new stdClass();
				$f->id = $fname;
				$f->title = $fname;
				array_push($HTMLThemes, $f);
			}
		}		
		
		$html = JHTML::_('select.genericlist',  $HTMLThemes, $control_name.'['.$name.']', 'style="width:150px; position:relative" onchange="japarams2.changeTheme(this.value, false)"', 'id', 'title', $value );			
	
		return $html;
	}		
}