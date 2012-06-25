<?php
/**
 * @version		$Id: phpbb3.php 3086 2008-01-11 01:42:18Z jinx $ 
 * @package RokBridge - phpBB3 edition
 * @copyright Copyright (C) 2009 RocketTheme. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @author RocketTheme, LLC
 */

/**
 * phpBB3 Authenticate Plugin
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @package		Rocketwerx
 * @subpackage	phpBB3Bridge
 */
class plgAuthenticationPHPBB3_Auth extends JPlugin
{
	/**
	 * Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @param object $subject The object to observe
	 * @param 	array  $config  An array that holds the plugin configuration
	 */
	function plgAuthenticationPHPBB3_Auth(& $subject, $config) {
		parent::__construct($subject, $config);
	}

	/**
	 * This method should handle any authentication and report back to the subject
	 *
	 * @access	public
	 * @param   array 	$credentials Array holding the user credentials
	 * @param 	array   $options     Array of extra options
	 * @param	object	$response	 Authentication response object
	 * @return	boolean
	 * @since 1.5
	 */
	function onAuthenticate( $credentials, $options, &$response )
	{
		global $dbhost, $dbname, $dbuser, $dbpasswd, $table_prefix;
		
		// Joomla does not like blank passwords
		if (empty($credentials['password']))
		{
			$response->status = JAUTHENTICATE_STATUS_FAILURE;
			$response->error_message = 'Empty password not allowed';
			return false;
		}
			
		if(!defined('IN_PHPBB')) {
			define('IN_PHPBB', true); 
		}
		
		$table =& JTable::getInstance('component');
		$table->loadByOption( 'com_rokbridge' );
		$params = new JParameter( $table->params, JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rokbridge'.DS.'config.xml' );
		
		if (!file_exists(JPATH_ROOT.DS.$params->get('bridge_path').DS.'configuration.php'))
			return;
		
		//Include the bridge configuration
		require_once(JPATH_ROOT.DS.$params->get('bridge_path').DS.'configuration.php');
		if (!class_exists('JConfigForum')) return;
	 		
		//Create a bridge configration object
		$config = new JConfigForum();
		
		if (!file_exists(JPATH_ROOT.DS.$config->phpbb_path.DS.'config.php'))
			return;
		
		//Include the PHPBB3 configuration
		require JPATH_ROOT.DS.$config->phpbb_path.DS.'config.php';
		
		// Config is incomplete
		if (!isset($dbhost, $dbuser, $dbpasswd, $dbname, $table_prefix))
			return;
			
		//Include the PHPBB3 helper functions
		if(!defined('LOGIN_PHPBB')) 
		{
			//Include the bridge configuration
			$path = JPATH_ROOT.DS.$params->get('bridge_path');
			require_once($path.DS.'includes'.DS.'helper.php');
			
			JForumHelper::loadPHPBB3($path);
		}
			
		// Get a database object
		$options = array ( 'driver' => $dbms, 'host' => $dbhost, 'user' => $dbuser, 'password' => $dbpasswd, 'database' => $dbname, 'prefix' =>  $table_prefix );
		
		$db =& JDatabase::getInstance($options);
		
		/*
	     * Check if the login_name field exists if so use it to get the user data
	     * Note : this fields is getting added by the SMF to phpBB3 convertor.
	     */
		$fields = $db->getTableFields('#__users');
		
		if(isset($fields['#__users']['login_name']))
		{
			$query = "SELECT user_id, username, user_email, user_type, user_password, login_name, user_type"
			."\n FROM #__users"
			."\n WHERE login_name = ". $db->Quote(utf8_clean_string($credentials['username']));
		}
		else
		{
			$query = "SELECT user_id, username, user_email, user_type, user_password, user_type"
			."\n FROM #__users"
			."\n WHERE username_clean = ". $db->Quote(utf8_clean_string($credentials['username']));
		}
		
		$db->setQuery( $query );
		$result = $db->loadObject();
		
		if($result && phpbb_check_hash($credentials['password'], $result->user_password)) 
		{
			$response->status        = JAUTHENTICATE_STATUS_SUCCESS;
			$response->error_message = '';
			$response->email         = $result->user_email;
			$response->fullname      = $result->username;
		}
		else
		{
			$response->status = JAUTHENTICATE_STATUS_FAILURE;
			$response->error_message = 'Invalid response from database';
		}
	}
}
?>