<?php
/**
 * @package		Joomla
 * @subpackage	RokBridge
 * @copyright Copyright (C) 2009 RocketTheme. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @author RocketTheme, LLC
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');

class RokBridgeModelRokBridge extends JModel
{
	function __construct($config = array())
	{
		//remove old bridge
		$old_bridge = JRequest::getString('current_bridge_path','','post');
		$posted_params = JRequest::getVar('params','','post');
		
		if (is_array($posted_params))
		{
			$new_bridge = $posted_params['bridge_path'];

			if (trim($old_bridge) != trim($new_bridge)) {
				// new location, so delete old
				$this->removebridge($old_bridge,false);
			}
		}
		
		if ($this->_isForumInstalled() && $this->_isBridgeInstalled()) 
		{
			$current_auth = $this->_getAuthMethod();	
		
			// if plugin installed, and not set to joomla...
			if (JFile::exists ( JPATH_SITE.DS.$this->getForumPath().DS."includes".DS."auth".DS."auth_joomla.php")) {
				if ($current_auth != "joomla") $this->_setAuthMethod("joomla");
			} else {
				if ($current_auth == "joomla") $this->_setAuthMethod("db");
			}
		}
		
		parent::__construct($config);
	}
	
	function getBits()
	{
		global $mainframe;
		
		$phpbb3_path = $this->getForumPath();
		$bridge_path = $this->getBridgePath();
		
		$bits = new stdClass();
		$bits->bridge_url = JURI::root().$bridge_path;
		$bits->patch_installed = false;
		$bits->patch_note = null;
		$bits->joomla_authplg_installed = JPluginHelper::isEnabled('authentication','phpbb3_auth');
		$bits->joomla_userplg_installed = JPluginHelper::isEnabled('user','phpbb3_user');
		$bits->phpbb3plg_installed = false;
		$bits->phpbb3plg_note = null;
		$bits->phpbb3_installed = false;
		$bits->bridge_installed = false;
		$bits->bridge_note = null;
		$bits->current_bridge_path = $bridge_path;
		$bits->bridge_install_enable = true;;
		$bits->phpbb3_version = null;
		$bits->patch_full = JRequest::getInt("patchfull",0);
		$bits->indexes_installed = false;
		$bits->indexes_note = null;
		
		//check to see if the phpBB3 path exists and is valid
		if( !JFolder::exists( JPATH_SITE.DS.$phpbb3_path ) ) {
			$mainframe->enqueueMessage(JText::_('PHPBB3_PATH_NOT_FOUND'),"error");
		} elseif (!JFile::exists( JPATH_SITE.DS.$phpbb3_path.DS."config.php")) {
			$mainframe->enqueueMessage(JText::_('PHPBB3_FOUND_NOT_INSTALLED'),"error");
		} else {
			require JPATH_SITE.DS.$phpbb3_path.DS."config.php";
		
			if (isset($dbhost, $dbuser, $dbpasswd, $dbname, $table_prefix)) {
				$bits->phpbb3_installed = true;
				if (!defined('IN_PHPBB')) define('IN_PHPBB',true);
				require_once JPATH_SITE.DS.$phpbb3_path.DS."includes".DS."constants.php";
				$bits->phpbb3_version = PHPBB_VERSION;
			}
			else {
				$mainframe->enqueueMessage(JText::_('PHPBB3_FOUND_NOT_INSTALLED'),"error");
			}
		}
		
		$bits->bridge_note = JText::_('BRIDGE_NOTE');
		
		//check to see if the forum is installed 
		if (JFolder::exists( JPATH_SITE.DS.$bridge_path )) {
			//folder exists, is it the bridge?
			if ( JFile::exists( JPATH_SITE.DS.$bridge_path.DS."includes".DS."hooks.php")) {
				$bits->bridge_installed = true;
				$bits->bridge_note = JText::_('BRIDGE_INSTALLED_AT');

			} else {
			
				// check if folder is empty
				$handler = opendir(JPATH_SITE.DS.$bridge_path);
				
				$empty = true;
				
				while ($file = readdir($handler)) {
					// if file isn't this directory or its parent, add it to the results
					if ($file != "." && $file != "..") {
						$empty = false;
						break;
					}
				}
				
				closedir($handler);
				
				// if not empty, complain about invalid bridge path
				if (!$empty)
				{
					$mainframe->enqueueMessage(JText::_('BRIDGE_EXISTS_NOT_INSTALLED'),"error");
					$bits->bridge_note = JText::_('CHOOSE_VALID_BRIDGE_PATH');
					$bits->bridge_install_enable = false;
				}
			}
			if ($bits->bridge_installed) {
				//bridge installed, is it configured?
				if ( !JFile::exists( JPATH_SITE.DS.$bridge_path.DS."configuration.php")) {
					$mainframe->enqueueMessage(JText::_('SAVE_CONFIGURATION'),"error");
				}
			}
		}

		//check for auth plugin
		if ($bits->phpbb3_installed) {
			if ( JFile::exists ( JPATH_SITE.DS.$phpbb3_path.DS."includes".DS."auth".DS."auth_joomla.php")) {
				$bits->phpbb3plg_installed = true;
				$bits->phpbb3plg_note = JText::_('PHPBB3_AUTHPLG_INSTALLED');
			} else {
				$bits->phpbb3plg_note = JText::_('PHPBB3_AUTHPLG_READY');
			}
		} else {
			$bits->phpbb3plg_note = JText::_('PHPBB3_INSTALL_NOT_FOUND');
		}

		//check for indexes
		if ($bits->phpbb3_installed and $bits->bridge_installed) {
			if ($this->_checkForRokBridgeIndexes() ) {
				$bits->indexes_installed = true;
				$bits->indexes_note = JText::_('PHPBB3_INDEXES_INSTALLED');
			} else {
				$bits->indexes_note = JText::_('PHPBB3_INDEXES_READY');
			}
		} else {
			$bits->indexes_note = JText::_('PHPBB3_INSTALL_NOT_FOUND');
		}

		//check for phpbb3 patches
		if ($bits->phpbb3_installed) {
			if (version_compare(PATCH_VERSION, $bits->phpbb3_version)) {
				//small patch check
				$advsrch_file = JPATH_SITE.DS.$phpbb3_path.DS."styles".DS."prosilver".DS."template".DS."search_body.html";

				$new = "<form method=\"post\"";
				$advsrch_data = JFile::read($advsrch_file);
				if (strpos($advsrch_data, $new)) {
					$bits->patch_installed = true;
				}
				$bits->patch_note = JText::_('PATCH_SMALL_NOTE');
				$bits->patch_full = false;
			} else {
				//full patch check
			$functions_file = JPATH_SITE.DS.$phpbb3_path.DS."includes".DS."functions.php";

			$new = "return str_replace('&', '&amp;', \$redirect);";
			$functions_data = JFile::read($functions_file);
			if (strpos($functions_data,$new)) {
				$bits->patch_installed = true;
			}
			$bits->patch_note = JText::_('PATCH_NOTE');
			$bits->patch_full = true;
			}
		} else {
			$bits->patch_note =  JText::_('PHPBB3_INSTALL_NOT_FOUND');
		}
		
		return $bits;
	}
	
	function saveConfiguration($verbose=true)
	{
		global $mainframe;
		
		$component = 'com_rokbridge';

		$table =& JTable::getInstance('component');
		if (!$table->loadByOption( $component ))
		{
			JError::raiseWarning( 500, 'Not a valid component' );
			return false;
		}
		
		$post = JRequest::get( 'post' );
		
		// strip leading / if provided
		if (isset($post['params']['bridge_path'])) $post['params']['bridge_path'] = trim($post['params']['bridge_path'],"/");
		if (isset($post['params']['phpbb3_path'])) $post['params']['phpbb3_path'] = trim($post['params']['phpbb3_path'],"/");
		
		$post['option'] = $component;
		$table->bind( $post );

		if (!$table->check() || !$table->store()) {
			JError::raiseWarning( 500, $table->getError() );
			return false;
		}

		//save out bridge configuration file to 'source' and bridge_path if possible
		$params =& $this->getParams(true);
		jimport( 'joomla.filesystem.file' );
		$bridge_path = $this->getBridgePath();
		$phpbb3_path = $this->getForumPath();

		$installed_config_file = JPATH_SITE.DS.$bridge_path.DS."configuration.php";
		$installed_htaccess_file = JPATH_SITE.DS.$bridge_path.DS.".htaccess";
		$src_config_file = JPATH_ADMINISTRATOR.DS."components".DS."com_rokbridge".DS."forum".DS."configuration.php";
		$src_htaccess_file = JPATH_ADMINISTRATOR.DS."components".DS."com_rokbridge".DS."forum".DS.".htaccess";

		$remember_login = $params->get('force_remember')==0?'false':'true';
		
		$registry =& JFactory::getConfig();
		$full_live_site = $live_site = $registry->getValue('live_site');
		if ($live_site != '') {
			$full_live_site = $live_site . "/".$bridge_path;
		}
		
		$bridge_config = "<?php 
class JConfigForum 
{
	var \$phpbb_path = '".$phpbb3_path."';
	var \$sef = '".$params->get('sef_enable')."';
	var \$sef_rewrite = '".$params->get('sef_rewrite')."';
	var \$remember_login = ".$remember_login.";
	var \$live_site = '" .$full_live_site ."';
}
?>
";

		$htaccess = "RewriteEngine on
RewriteBase ".str_replace('\\','/',JURI::Root(true).DS.$bridge_path.DS)."

# Standard phpBB3 files matching
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} \.php$
RewriteRule (.+)\.php$ index.php?rb_v=$1&%{QUERY_STRING} [L]";
		
		if ($params->get('sef_rewrite',0) == 1) {
			$htaccess .= "
# RokBridge SEF rewrite
RewriteCond %{REQUEST_FILENAME}                 !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.+) index.php?$1&%{QUERY_STRING} [L]";
		}

		//if bridge installed and config file exists
		if (JFolder::exists(JPATH_SITE.DS.$bridge_path)) {
			JFile::write($installed_config_file, $bridge_config);
		}
		if (JFolder::exists(JPATH_SITE.DS.$bridge_path)) {
			JFile::write($installed_htaccess_file, $htaccess);
		}
		
		//update src anyway
		if (!JFile::write($src_config_file, $bridge_config)) {
			$mainframe->enqueueMessage(JText::_('CONFIGURATION_WRITE_FAIL'),"error"); 
		}
		if (!JFile::write($src_htaccess_file, $htaccess)) {
			$mainframe->enqueueMessage(JText::_('HTACCESS_WRITE_FAIL'),"error"); 
		}

		//$this->setRedirect( 'index.php?option=com_config', $msg );
		if ($verbose) $mainframe->enqueueMessage(JText::_('CONFIGURATION_WRITE_SUCCESS'));
	}
	
	function patchForum($undo=false, $patch_full)
	{
		global $mainframe;

		jimport( 'joomla.filesystem.file' );
		
		$patch_status = "";
		$success = true;
		
		$phpbb3_path = $this->getForumPath();

		$advsrch_file = JPATH_SITE.DS.$phpbb3_path.DS."styles".DS."prosilver".DS."template".DS."search_body.html";
		$advsrch_data = JFile::read($advsrch_file);
		
		$old_advsrch = "<form method=\"get\"";
		$new_advsrch = "<form method=\"post\"";

		if ($undo) {
			$advsrch_data = str_replace($new_advsrch,$old_advsrch,$advsrch_data);
			$patch_status = "PATCH_SMALL_UNINSTALLED";
		} else {
			$advsrch_data = str_replace($old_advsrch,$new_advsrch,$advsrch_data);
			$patch_status = "PATCH_SMALL_INSTALLED";
		}

		if (!Jfile::write($advsrch_file,$advsrch_data)) {
			$mainframe->enqueueMessage(sprintf(JText::_('CANNOT_WRITE'),$advsrch_file),"error"); 
			$success = false;   
		} else {
			$success = true;
		}

		if ($patch_full == 1) {
			$functions_file = JPATH_SITE.DS.$phpbb3_path.DS."includes".DS."functions.php";
			$functions_data = JFile::read($functions_file);
			
			$funcsadmin_file = JPATH_SITE.DS.$phpbb3_path.DS."includes".DS."functions_admin.php";
			$funcsadmin_data = JFile::read($funcsadmin_file);
			
			$old_return = "return \$phpbb_root_path . str_replace('&', '&amp;', \$redirect);";
			$new_return = "return str_replace('&', '&amp;', \$redirect);";

			
			$old_funcsadmin = "\$matches = array();";
			$new_funcsadmin = "\$matches = array();
//patch for bridged mode only
if (PHPBB_EMBEDDED===true) {
	\$rootdir = str_replace(PHPBB_ROOT_PATH,\"../\".PHPBB_BASE_PATH.\"/\", \$rootdir );
}";
			
			if ($undo) {
				$functions_data = str_replace($new_return,$old_return,$functions_data);
				$funcsadmin_data = str_replace($new_funcsadmin,$old_funcsadmin,$funcsadmin_data);
				$patch_status = "PATCH_UNINSTALLED";
			} else {
				$functions_data = str_replace($old_return,$new_return,$functions_data);
				$funcsadmin_data = str_replace($old_funcsadmin,$new_funcsadmin,$funcsadmin_data);
				$patch_status = "PATCH_INSTALLED";
			}
			
			if (!Jfile::write($functions_file,$functions_data)) {
				$mainframe->enqueueMessage(sprintf(JText::_('CANNOT_WRITE'),$functions_file),"error"); 
				$success = false;  
			} else {
				$success = true;
			}
			
				if (!Jfile::write($funcsadmin_file,$funcsadmin_data)) {
					$mainframe->enqueueMessage(sprintf(JText::_('CANNOT_WRITE'),$funcsadmin_file),"error"); 
				$success = false;   
			} else {
				$success = true;
			}
		}
		
		if ($success) $mainframe->enqueueMessage(JText::_($patch_status));
	}
	
	function addIndexes()
	{
		global $mainframe;
		
		if (!$this->_checkForRokBridgeIndexes()) {

			$post_time_index_name = "rokbridge_post_time_r"; 

			if (!($forum_db =& $this->_getHelper()->getDb())){
				$mainframe->enqueueMessage(JText::_('PHPBB3_ADDED_ROKBRIDGE_INDEXES_ERROR')); 
			}

			$sql = "ALTER TABLE `#__posts` ADD INDEX `".$post_time_index_name."` (`post_time` DESC)";
			$forum_db->setQuery($sql);
			
			if ($forum_db->query()){
				$mainframe->enqueueMessage(JText::_('PHPBB3_ADDED_ROKBRIDGE_INDEXES_ERROR')); 
			}
		}
		$mainframe->enqueueMessage(JText::_('PHPBB3_ADDED_ROKBRIDGE_INDEXES_SUCCESS')); 
	}

	function dropIndexes()
	{
		global $mainframe;
		
		if ($this->_checkForRokBridgeIndexes()) {
		
			$post_time_index_name = "rokbridge_post_time_r"; 

			if (!($forum_db =& $this->_getHelper()->getDb())){
				$mainframe->enqueueMessage(JText::_('PHPBB3_DROP_ROKBRIDGE_INDEXES_ERROR')); 
			}

			$sql = "ALTER TABLE ".$forum_db->nameQuote('#__posts')." DROP INDEX  ".$forum_db->nameQuote($post_time_index_name);
			$forum_db->setQuery($sql);

			if ($forum_db->query()){
				$mainframe->enqueueMessage(JText::_('PHPBB3_DROP_ROKBRIDGE_INDEXES_ERROR')); 
			}
		}
		$mainframe->enqueueMessage(JText::_('PHPBB3_DROP_ROKBRIDGE_INDEXES_SUCCESS')); 
	}
	
	function removeBridge($bridge_path=null,$verbose=true)
	{
		global $mainframe;
		
		if (!$bridge_path) $bridge_path = $this->getBridgePath();
		
		jimport( 'joomla.filesystem.folder' );
		jimport( 'joomla.filesystem.file' );

		$folder = JPATH_SITE.DS.$bridge_path ;
		$file   = JPATH_SITE.DS.$bridge_path.DS."includes".DS."hooks.php";
		
		if (JFile::exists($file)) {
			if (!JFolder::delete($folder)) {
			   if ($verbose) {
				  $mainframe->enqueueMessage(JText::_('BRIDGE_REMOVE_ERROR'),"error"); 
			   } else {
				  $errors = &$mainframe->_messageQueue;
				  $errors[1] = array();
			   }
			   return;
			}
		
			if ($verbose) $mainframe->enqueueMessage(JText::_('BRIDGE_REMOVE_SUCCESS')); 
		} else {
			if ($verbose) $mainframe->enqueueMessage(sprintf(JText::_('BRIDGE_NOT_VALID'),$folder),"error"); 
		}
	}
	
	function moveBridge()
	{
		global $mainframe;

		$bridge_path = $this->getBridgePath();
		
		jimport( 'joomla.filesystem.folder' );
		jimport( 'joomla.filesystem.file' );
		
		if (JFolder::exists( JPATH_SITE.DS.$bridge_path )) {
			//folder exists, is it the bridge?
			if ( JFile::exists( JPATH_SITE.DS.$bridge_path.DS."includes".DS."hooks.php")) {
				$mainframe->enqueueMessage(JText::_('BRIDGE_ALREADY_INSTALLED'),"error");
				return;
			} 
		}
				
		$src = JPATH_ADMINISTRATOR.DS."components".DS."com_rokbridge".DS."forum";
		$dest = JPATH_SITE.DS.$bridge_path;
		
		if (!JFolder::exists($dest)) {
			if (!JFolder::create($dest)) {
				$mainframe->enqueueMessage(JText::_('ERROR_CREATING_DIR').": ".$dest,"error"); 
				return;
			}        
		}

		if (!JFolder::copy($src,$dest,null,true)) {
			$mainframe->enqueueMessage(JText::_('BRIDGE_INSTALL_ERROR'),"error"); 
			return;
		}
		
		$mainframe->enqueueMessage(JText::_('BRIDGE_INSTALL_SUCCESS')); 
	}
	
	function installForumPlugin()
	{
		global $mainframe;
		
		$phpbb3_path = $this->getForumPath();
		
		$src    = JPATH_ADMINISTRATOR.DS."components".DS."com_rokbridge".DS."phpbb".DS."includes".DS."auth".DS."auth_joomla.php";
		$dest   = JPATH_SITE.DS.$phpbb3_path.DS."includes".DS."auth";    
		
		jimport( 'joomla.filesystem.file' );
		
		if (!JFile::copy($src,$dest.DS."auth_joomla.php")) {
		   $mainframe->enqueueMessage(sprintf(JText::_('CANNOT_WRITE'),$dest),"error"); 
		   return;
		}
		
		$mainframe->enqueueMessage(JText::_('PHPBB3_AUTHPLG_INSTALL_SUCCESS')); 
	}

	function removeForumPlugin()
	{
		global $mainframe;
		
		$phpbb3_path = $this->getForumPath();
		
		jimport( 'joomla.filesystem.file' );

		$file   = JPATH_SITE.DS.$phpbb3_path.DS."includes".DS."auth".DS."auth_joomla.php";

		if (!JFile::delete($file)) {
		   $mainframe->enqueueMessage(JText::_('PHPBB3_AUTHPLG_REMOVE_ERROR'),"error"); 
		   return;
		}
		
		$mainframe->enqueueMessage(JText::_('PHPBB3_AUTHPLG_REMOVE_SUCCESS')); 
	}
	
	function getForumPath()
	{
		$params =& $this->getParams();
		
		return $params->get('phpbb3_path');
	}
	
	function getBridgePath()
	{
		$params =& $this->getParams();
	
		return $params->get('bridge_path');
	}
	
	function getParams($refresh = false) 
	{
		return $this->_getHelper()->getParams($refresh);
	}
	
	function _isForumInstalled()
	{
		$return = JFolder::exists( JPATH_SITE.DS.$this->getForumPath() ) && JFile::exists( JPATH_SITE.DS.$this->getForumPath().DS."config.php");
		
		if (!$return)
			return false;
			
		require JPATH_SITE.DS.$this->getForumPath().DS."config.php";
		
		if (!isset($dbhost, $dbuser, $dbpasswd, $dbname, $table_prefix))
			return false;
			
		return true;
	}
	
	function _isBridgeInstalled()
	{
		return JFolder::exists( JPATH_SITE.DS.$this->getBridgePath() ) && JFile::exists( JPATH_SITE.DS.$this->getBridgePath().DS."includes".DS."hooks.php");
	}
	
	function _getHelper()
	{
		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rokbridge'.DS.'helper.php' );
		return new RokBridgeHelper();
	}
	
	function _checkForRokBridgeIndexes()
	{
		$post_time_index_name = "rokbridge_post_time_r"; 
		$post_time_index_exists = false;
		
		if (!($forum_db =& $this->_getHelper()->getDb()))
			return false;

		$sql = "SHOW INDEXES from #__posts";
		$forum_db->setQuery($sql);
		$post_indexs = $forum_db->loadObjectList();
		if ($post_indexs != null) { 
			foreach ($post_indexs as $index) {
				if ($index->Key_name == $post_time_index_name){
					$post_time_index_exists = true;
				}
			}
		}
		
		return $post_time_index_exists;
	}
	
	function _getAuthMethod()
	{
		if (!($forum_db =& $this->_getHelper()->getDb()))
			return false;

		$sql = "SELECT * from #__config where config_name='auth_method'";

		$forum_db->setQuery($sql);

		$auth_method = $forum_db->loadObject();
		
		return $auth_method->config_value;	
	}
	
	function _setAuthMethod($newauth)
	{		
		if (!($forum_db =& $this->_getHelper()->getDb()))
			return false;

		$sql = "SELECT * from #__config where config_name='auth_method'";

		$forum_db->setQuery($sql);

		$auth_method = $forum_db->loadObject();
			
		$auth_method->config_value = $newauth;

		if (!$forum_db->updateObject( '#__config', $auth_method, 'config_name' )) {
			echo $forum_db->stderr();
			return false;
		}
		
		return $newauth;
	}
}