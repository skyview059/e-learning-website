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

if (!defined ('_JEXEC')) {
	define( '_JEXEC', 1 );
	$path = dirname(dirname(dirname(dirname(__FILE__))));
	define('JPATH_BASE', $path );

	if (strpos(php_sapi_name(), 'cgi') !== false && !empty($_SERVER['REQUEST_URI'])) {
		//Apache CGI
		$_SERVER['PHP_SELF'] =  rtrim(dirname(dirname(dirname($_SERVER['PHP_SELF']))), '/\\');
	} else {
		//Others
		$_SERVER['SCRIPT_NAME'] =  rtrim(dirname(dirname(dirname($_SERVER['SCRIPT_NAME']))), '/\\');
	}
	
	define( 'DS', DIRECTORY_SEPARATOR );
	require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
	require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
	JDEBUG ? $_PROFILER->mark( 'afterLoad' ) : null;

	/**
	 * CREATE THE APPLICATION
	 *
	 * NOTE :
	 */
	$mainframe =& JFactory::getApplication('administrator');
	
	/**
	 * INITIALISE THE APPLICATION
	 *
	 * NOTE :
	 */
	$mainframe->initialise(array(
		'language' => $mainframe->getUserState( "application.lang", 'lang' )
	));
	
	//JPluginHelper::importPlugin('system');
	
	// trigger the onAfterInitialise events
	//JDEBUG ? $_PROFILER->mark('afterInitialise') : null;
	//$mainframe->triggerEvent('onAfterInitialise');
}

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

$user = JFactory::getUser();
if(!in_array($user->usertype, array('Super Administrator', 'Administrator', 'Manager'))){
	$result['error'] = JText::_('You dont have permission to access');
	echo json_encode($result);
	exit;
}
/**
 * modJAAnimation class.
 */
$task = isset($_REQUEST['japaramaction'])?$_REQUEST['japaramaction']:'';

if($task!=''){
	
	$lang = JFactory::getLanguage();
	$lang->load('mod_janewspro');

	JAAdminAnim::$task();
}


		
class JAAdminAnim{
	
	function saveProfile(){
		global $mainframe;						
		// Initialize some variables		
				
		$client		=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$json = JRequest::getVar('json', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$post = json_decode($json);
		$profile = JRequest::getCmd('profile');
		
		$result = array();
		if(!$profile){
			$result['error'] = JText::_('No Profile name contains space or special chracters.');
			echo json_encode($result);
			exit;
		}
		// Set FTP credentials, if given
		jimport('joomla.client.helper');
		JClientHelper::setCredentialsFromRequest('ftp');
		$ftp = JClientHelper::getCredentials('ftp');
		
		$errors = array();
		
		$file = dirname(dirname(__FILE__)).DS.'profiles'.DS.$profile.'.ini';		
			
		$params = new JParameter('');
		if(isset($post)){
			foreach ($post as $k=>$v){
				$params->set($k, $v);
			}
		}
		$data = $params->toString();
		if(JFile::exists($file)){
			@chmod($file, 0777);
		}
		$return = @JFile::write($file, $data);
							
		// Try to make the params file unwriteable
		if (!$ftp['enabled'] && @JPath::isOwner($file) && !JPath::setPermissions($file, '0555')) {
			$errors[] = sprintf(JText::_('Profile file unwritable'), $file);
		}
		if(!$return){
			$errors[] = JText::_('Operation Failed').': '.JText::sprintf('Failed to open file for writing.', $file);
		}									
		
		if($errors){
			$result['error'] = implode('<br/>', $errors);
		}
		else{
			$result['successful'] = sprintf(JText::_('SAVE PROFILE SUCCESSFULLY'), $profile);
			$result['profile'] = $profile;
			$result['type'] = 'new';
		}
		
		echo json_encode($result);
		exit;
	}
	
	function cloneProfile(){
		$profile = JRequest::getCmd('profile');
		$fromprofile = JRequest::getCmd('fromprofile');
		$template = JRequest::getCmd('template');
		$result = array();
		if(!$profile || !$fromprofile){
			$result['error'] = JText::_('No Profile name contains space or special chracters.');
			echo json_encode($result);
			exit;
		}
		
		$path = dirname(dirname(__FILE__)).DS.'profiles';
		$source = $path.DS.$fromprofile.'.ini';
		if(!JFile::exists($source) && $template){		
			$source = JPATH_SITE.DS.'templates'.DS.$template.DS.'html'.DS.'mod_janewspro'.DS.$fromprofile.'.ini';
		}
		
		$dest = $path.DS.$profile.'.ini';
		if(JFile::exists($dest)){
			$result['error'] = sprintf(JText::_('Profile "%s" already exists.'), $profile);
			echo json_encode($result);
			exit;
		}
		
		$result = array();
		if(JFile::exists($source)){
			if($error=@JFile::copy($source, $dest)==true){
				$result['successful'] = JText::_('COLNE PROFILE SUCCESSFULLY');
				$result['profile'] = $profile;	
				$result['reset'] = true;
				$result['type'] = 'clone';
			}
			else{
				$result['error'] = $error;
			}
		}
		else{
			$result['error'] = JText::_(sprintf('Profile %s not found.', $fromprofile));
		}
		echo json_encode($result);
		exit;
	}
	
	function deleteProfile(){
		
		// Initialize some variables
		
		$client		=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));		
		$template = JRequest::getCmd('template');
		$profile = JRequest::getCmd('profile');
		$errors = array();
		$result = array();
		if(!$profile){
			$result['error'] = JText::_('No profile specified');
			echo json_encode($result);
			exit;
		}

		$file = dirname(dirname(__FILE__)).DS.'profiles'.DS.$profile.'.ini';
		$return = false;
		if(JFile::exists($file)){
			$return = @JFile::delete($file);
		}
		if(!$return){
			$result['error'] = sprintf( JText::_('DELETE FAIL'), $file);
		}		
		else{
			$source = JPATH_SITE.DS.'templates'.DS.$template.DS.'html'.DS.'mod_janewspro'.DS.$profile.'.ini';
			
			if($template && JFile::exists($source)){
				$result['template'] = '1';	
				$result['successful'] = sprintf(JText::_('DELETE PROFILE SUCCESSFULLY FROM MODULE'), $profile); 	
			}
			else{
				$result['template'] = '0';	
				$result['successful'] = sprintf(JText::_('DELETE PROFILE SUCCESSFULLY'), $profile); 				
			}		
			$result['profile'] = $profile;				
			$result['type'] = 'delete';
		}		
		
		echo json_encode($result);
		exit;	
	}
	
	function changeTheme(){
		$theme = JRequest::getCmd('theme');
		$template = JRequest::getCmd('template');
		
		$html = '';
		$result['theme'] = $theme;	
		$result['type'] = 'change';	
		$result['successful'] = '';			
		
		if($theme){
			$xml_theme = JPATH_SITE.DS.'templates'.DS.$template.DS.'html'.DS.'mod_janewspro'.DS.$theme.DS.'params.xml';
			if(!JFile::exists($xml_theme) || !$template){
				$xml_theme = JPATH_SITE.DS.'modules'.DS.'mod_janewspro'.DS.'tmpl'.DS.$theme.DS.'params.xml';			
			}
			
			if(JFile::exists($xml_theme)){
				$paramsForm = new JParameter('', $xml_theme, 'template');
				$html = $paramsForm->render('japarams');
			}
		}
		
		$result['html'] = $html;
		
		echo json_encode($result);
		exit;
	}
}