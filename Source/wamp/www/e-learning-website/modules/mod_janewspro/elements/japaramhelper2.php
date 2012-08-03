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
/**
 * Radio List Element
 *
 * @since      Class available since Release 1.2.0
 */
class JElementJaparamhelper2 extends JElement
{
	function fetchElement( $name, $value, &$node, $control_name ) {
		if(!defined('japaramhelper2')){
			$uri = str_replace(DS,"/",str_replace( JPATH_SITE, JURI::base (), dirname(__FILE__) ));
			$uri = str_replace("/administrator", "", $uri);
			
			JHTML::stylesheet('japaramhelper2.css', $uri."/assets/css/");
			JHTML::script('japaramhelper2.js', $uri."/assets/js/");
					
			jimport('joomla.filesystem.folder');
			jimport('joomla.filesystem.file');
			
			define('japaramhelper2', true);
		}
		
		$jsonData = array();
		$folder_profiles = array();
		
		/* Get all profiles name folder from folder profiles */
		$profiles = array();
		$jsonData = array();
		$jsonTempData = array();
		
		// get in template	 
		$template = $this->get_active_template();
		$path = JPATH_SITE.DS.'templates'.DS.$template.DS.'html'.DS.'mod_janewspro';		
		if(JFolder::exists($path)){
			$files = JFolder::files($path, '.ini');
			if($files){
				foreach ($files as $fname){
					$fname = substr($fname,  0, -4);					
					
					$f = new stdClass();
					$f->id = $fname;
					$f->title = $fname;
					
					$profiles[$fname] = $f;
					
					$params = new JParameter(JFile::read($path.DS.$fname.'.ini'));
					$jsonData[$fname] = $params->toArray();
					$jsonTempData[$fname] = $jsonData[$fname];
				}
			}
		}
		
		// get in module
		$path = JPATH_SITE.DS.'modules'.DS.'mod_janewspro'.DS.'profiles';		
		if(!JFolder::exists($path)) return JText::_('Profiles Folder not exist');
		$files = JFolder::files($path, '.ini');
		if($files){
			foreach ($files as $fname){
				$fname = substr($fname,  0, -4);
				
				$f = new stdClass();
				$f->id = $fname;
				$f->title = $fname;
				
				$profiles[$fname] = $f;
				
				$params = new JParameter(JFile::read($path.DS.$fname.'.ini'));
				$jsonData[$fname] = $params->toArray();
			}
		}				
		
		$HTML_Profile = JHTML::_('select.genericlist',  $profiles, ''.$control_name.'['.$name.']', 'style="width:150px;" onchange="japarams2.changeProfile(this.value)"', 'id', 'title', $value );
			
		$xml_profile = JPATH_SITE.DS.'modules'.DS.'mod_janewspro'.DS.'admin'.DS.'config.xml';
		if (file_exists($xml_profile)) {
			/* For General Tab */
			$paramsForm = new JParameter('', $xml_profile, 'template');
		}
				
		$_body = JResponse::getBody();
		ob_start ();
		require_once dirname(__FILE__).DS.'tpl.php';
		$content = ob_get_clean ();
		
		JResponse::setBody( $_body );
		return $HTML_Profile. $content;
		
	}
	
	function get_active_template(){	
		$db =& JFactory::getDBO();
	
		// Get the current default template
		$query = ' SELECT template '
				.' FROM #__templates_menu '
				.' WHERE client_id = 0'
				.' AND menuid = 0 ';
		$db->setQuery($query);
		$template = $db->loadResult();
	
		return $template;
	}
}

