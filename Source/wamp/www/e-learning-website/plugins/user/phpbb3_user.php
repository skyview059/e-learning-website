<?php 
/**
 * @version		$Id: phpbb3.php 3087 2008-01-11 01:45:02Z jinx $ 
 * @package RokBridge - phpBB3 edition
 * @copyright Copyright (C) 2009 RocketTheme. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @author RocketTheme, LLC
 */


jimport('joomla.plugin.plugin');

/**
 * phpBB3 User plugin
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @package		Rocketwerx
 * @subpackage	phpBB3Bridge
 */
class plgUserPHPBB3_User extends JPlugin
{
	/**
	 * Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @param 	object $subject The object to observe
	 * @param 	array  $config  An array that holds the plugin configuration
	 */
	function plgUserPHPBB3_User(& $subject, $config) {
		parent::__construct($subject, $config);
	}
	
	/**
	 * Sync the user data with phpBB
	 *
	 * Method is called before user data is stored in the database
	 *
	 * @param 	array		holds the new user data
	 * @param 	boolean		true if a new user is stored
	 */
	function onBeforeStoreUser($user_data, $isnew)
	{
		//Store the user information before it is changed in a global
		$GLOBALS['TEMP_USER'] = $user_data;
		
		return true;
	}

	/**
	 * Sync the user data with phpBB
	 *
	 * Method is called after user data is stored in the database
	 *
	 * @param 	array	  	holds the old user data
	 * @param 	boolean		true if a new user is stored
	 * @param	boolean		true if user was succesfully stored in the database
	 * @param	string		message
	 */
	function onAfterStoreUser($user_data, $isnew, $succes, $msg)
	{
		global $phpbb_root_path, $phpEx;
		global $auth, $user, $template, $cache, $db, $config;
		

		//Don't continue if the user wasn't stored succesfully
		if(!$succes) {
			return false;
		}
		
	
		//Don't handle new users, syncing happens assynchronously
		if($isnew) {
			return true;
		}
		
		$table =& JTable::getInstance('component');
		$table->loadByOption( 'com_rokbridge' );
		$params = new JParameter( $table->params, JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rokbridge'.DS.'config.xml' );
		
		$path = JPATH_ROOT.DS.$params->get('bridge_path');
		
		if (!file_exists($path.DS.'includes'.DS.'helper.php'))
			return;
		
		//Include the bridge configuration
		require_once($path.DS.'includes'.DS.'helper.php');
			
		JForumHelper::loadPHPBB3($path);
		
		require_once($phpbb_root_path.DS.'includes/functions_user.php');
		
		$username = $GLOBALS['TEMP_USER']['username'];
		$fullname = $this->_fullNameSupport();
		$userid   = $this->_getUserId($username, $fullname); 
		
		// Don't try to store a user which doesn't exist yet in phpBB
		if(intval($userid) == 0) {
			return true;
		}
				
		//Activate/Deactivate the user
		$mode = $user_data['block'] ? 'deactivate' : 'activate';
		user_active_flip($mode, $userid['user_id']);
		
		if(!empty($fullname)) 
		{
			//Update the username if it was changed
			if($user_data['name'] != $GLOBALS['TEMP_USER']['name']) {
				user_update_name($GLOBALS['TEMP_USER']['name'], $user_data['name']);
			}
		
			//Store the user information
			$sql_ary = array(
				'login_name'		=> $user_data['username'],
				'username'			=> $user_data['name'],
				'username_clean'	=> utf8_clean_string($user_data['name']),
				'user_email'		=> $user_data['email'],
				'user_email_hash'	=> crc32($user_data['email']) . strlen($user_data['email']),
			);
		}
		else
		{
			//Update the username if it was changed
			if($user_data['username'] != $GLOBALS['TEMP_USER']['username']) {
				user_update_name($GLOBALS['TEMP_USER']['username'], $user_data['username']);
			}
		
			//Store the user information
			$sql_ary = array(
				'username'			=> $user_data['username'],
				'username_clean'	=> utf8_clean_string($user_data['username']),
				'user_email'		=> $user_data['email'],
				'user_email_hash'	=> crc32($user_data['email']) . strlen($user_data['email']),
			);
		}
			
		$sql = 'UPDATE ' . USERS_TABLE . '
			SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
			WHERE user_id = ' . $userid['user_id'];
		$db->sql_query($sql);
		
		//Unset the temp user global
		unset($GLOBALS['TEMP_USER']);
	}

	/**
	 * Remove all sessions for the user name
	 *
	 * Method is called after user data is deleted from the database
	 *
	 * @param 	array	  	holds the user data
	 * @param	boolean		true if user was succesfully stored in the database
	 * @param	string		message
	 */
	function onAfterDeleteUser($user_data, $succes, $msg)
	{
		global $phpbb_root_path, $phpEx;
		global $auth, $user, $template, $cache, $db, $config;
		
		
		//Don't continue if the user wasn't deleted succesfully
		if(!$succes) {
			return false;
		}
		
		$table =& JTable::getInstance('component');
		$table->loadByOption( 'com_rokbridge' );
		$params = new JParameter( $table->params, JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rokbridge'.DS.'config.xml' );
		
		$path = JPATH_ROOT.DS.$params->get('bridge_path');
		
		if (!file_exists($path.DS.'includes'.DS.'helper.php'))
			return;
				
		//Include the bridge configuration
		require_once($path.DS.'includes'.DS.'helper.php');
			
		JForumHelper::loadPHPBB3($path);
		
		require_once($phpbb_root_path.DS.'includes/functions_user.php');
		
		$username = $user_data['username'];
		$fullname = $this->_fullNameSupport();
		$userid   = $this->_getUserId($username, $fullname);
		
		// Don't try to delete a user which doesn't exist yet in phpBB
		if(empty($userid)) {
			return true;
		}
		
		//TODO :: make delete mode configurable through plugin params
		user_delete('retain', $userid['user_id']);
		
		return true;
	}

	/**
	 * This method should handle any login logic and report back to the subject
	 *
	 * @access	public
	 * @param 	array 	holds the user data
	 * @param 	array    extra options
	 * @return	boolean	True on success
	 */
	function onLoginUser($user_data, $options = array())
	{
		global $path, $phpbb_root_path, $phpEx;
		global $auth, $user, $template, $cache, $db, $config, $mainframe;
		
		//belts and suspenders to set flag to reset acl cache
		if (!defined('RESET_PHPBB_CACHE'))	define('RESET_PHPBB_CACHE',1);
		if (!isset($_SESSION['RESET_PHPBB_CACHE'])) $_SESSION['RESET_PHPBB_CACHE'] = 1;
		
		// don't perform phpbb3 login for joomla admin logins
		if( $mainframe->isAdmin() ) return true;  

		jimport( 'joomla.user.helper' );
		$name = JUserHelper::getUserId($user_data['username']);
		$instance =& JFactory::getUser($name);
		
		// If the user exists and is blocked, redirect with an error
		if (isset($instance) && $instance) {
    		if ($instance->get('block') == 1) {
    			// clear remember me cookie if set
    			setcookie( JUtility::getHash('JLOGIN_REMEMBER'), '', time() - 86400, '/' );
    			return true;
    		}
    	}
		
		if(defined('LOGIN_PHPBB')) {
			return true;
		}
		
		$table =& JTable::getInstance('component');
		$table->loadByOption( 'com_rokbridge' );
		$params = new JParameter( $table->params, JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rokbridge'.DS.'config.xml' );
		
		$path = JPATH_ROOT.DS.$params->get('bridge_path');
		
		if (!file_exists($path.DS.'includes'.DS.'helper.php'))
			return;
				
		//Include the bridge configuration
		require_once($path.DS.'includes'.DS.'helper.php');
			
		JForumHelper::loadPHPBB3($path);
		
		// Start session management
		$user->session_begin();
		$auth->acl($user->data);
		
		// Try to log the user in into phpBB3
		
		$result = $auth->login($instance->username, $user_data, 1);
			
		if($result['status'] == LOGIN_SUCCESS) {
			return true;
		}
		
		return false;
	}

	/**
	 * This method should handle any logout logic and report back to the subject
	 *
	 * @access public
	 * @param array holds the user data
	 * @return boolean True on success
	 * @since 1.5
	 */
	function onLogoutUser($user_data, $options = array())
	{
		global $phpbb_root_path, $phpEx;
		global $auth, $user, $template, $cache, $db, $config, $mainframe; 
		
		// don't perform phpbb3 login for joomla admin logins  
		     
		$me =& JFactory::getUser();  

		// don't log yourself out when you logout of the joomla admin
		if( $mainframe->isAdmin() && !$me->username ) return true;
		
		
		if(defined('LOGOUT_PHPBB')) {
			return true;
		}	
		
		$table =& JTable::getInstance('component');
		$table->loadByOption( 'com_rokbridge' );
		$params = new JParameter( $table->params, JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rokbridge'.DS.'config.xml' );
		
		$path = JPATH_ROOT.DS.$params->get('bridge_path');
		
		if (!file_exists($path.DS.'includes'.DS.'helper.php'))
			return;
				
		//Include the bridge configuration
		require_once($path.DS.'includes'.DS.'helper.php');
			
		JForumHelper::loadPHPBB3($path);
		
		require_once($phpbb_root_path.DS.'includes/functions_user.php');
		
		$username = $user_data['username'];
		$fullname = $this->_fullNameSupport();
		$userid   = $this->_getUserId($username, $fullname);

		//clear remember me cookie if set
		setcookie( JUtility::getHash('JLOGIN_REMEMBER'), '', time() - 86400, '/' );

		// Don't try to logout a user which doesn't exist yet in phpBB
		if(empty($userid)) {
			return true;
		}
		
		// Hit the user last visit field
		$sql = 'UPDATE ' . USERS_TABLE . '
				SET user_lastvisit = ' . (int) time() . '
				WHERE user_id = ' . (int) $userid['user_id'];
		$db->sql_query($sql);
		
		//Remove the session from the database
		$sql = 'DELETE FROM ' . SESSIONS_TABLE . "
			WHERE session_user_id = " . (int) $userid['user_id'];
		$db->sql_query($sql);
		
		//Remove the session keys from the database
		$sql = 'DELETE FROM ' . SESSIONS_KEYS_TABLE . "
			WHERE user_id = " . (int) $userid['user_id'];
		$db->sql_query($sql);
			
		// Start session management
		$user->session_begin();
		$auth->acl($user->data);
		
		if ($user->data['user_id'] == $userid['user_id'])
		{
			// Destroy the php session for this user
			$user->session_kill();
			$user->session_begin();
			return true;
		}
			
		return false;
	}
	
	function onLoginFailure($response) 
	{
		$app = JFactory::getApplication();
		$app->logout();
		
		JError::raiseWarning('SOME_ERROR_CODE', JText::_('E_LOGIN_AUTHENTICATE'));
	}

	/*
 	 * Check if the login_name field exists if so use it to get the user data
 	 * Note : this fields is getting added by the SMF to phpBB3 convertor.
 	 */
	
	function _fullNameSupport() 
	{
		global $db;

		$sql = 'DESCRIBE '.USERS_TABLE.' login_name';
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		
		return $row;
	}
	
	/*
	 * function to get username based on fullname support
	 */
	function _getUserId($username, $fullname) 
	{
		global $db;
		
		// if login_name exists use it
		if (!empty($fullname)) {
			$where = "login_name='" . $username . "'";
		} else {
			$where = "username_clean='" . utf8_clean_string($username) . "'";
		}
		

		// Get the user_id of the phpbb user
		$sql = "SELECT user_id FROM ".USERS_TABLE." WHERE " . $where;
		
		$result = $db->sql_query($sql);
		$userid = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		
		return $userid;
	}
	

}
?>