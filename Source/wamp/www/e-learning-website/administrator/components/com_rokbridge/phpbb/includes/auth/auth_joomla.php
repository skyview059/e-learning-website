<?php
/**
 * @version		$Id: auth_joomla.php 3086 2008-01-11 01:42:18Z jinx $ 
 * @package RokBridge - phpBB3 edition
 * @copyright Copyright (C) 2009 RocketTheme. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @author Johan Janssens <johan@joomlatools.org>
 */

/**
* Joomla! 1.5 auth plug-in for phpBB3
*/

/**
* Login function
*/
function login_joomla(&$username, &$user_data)
{
	global $phpbb_root_path, $db, $user, $config, $cache, $phpEx;
	
	define('LOGIN_PHPBB', true); //set define to allow to check for recursivity
	
	$password = is_array($user_data) ? $user_data['password'] : $user_data;
	$status = null;
	$juser = null;
	$result = false;

	/*
	 * Check if the login_name field exists if so use it to get the user data
	 * Note : this fields is getting added by the SMF to phpBB3 convertor.
	 */
	$sql = 'DESCRIBE '.USERS_TABLE.' login_name';
	$result = $db->sql_query($sql);
	$has_login_name = $db->sql_fetchrow();
	$db->sql_freeresult($result);
		
	if(!empty($has_login_name)) 
	{
		$sql = 'SELECT user_id, username, user_password, user_passchg, user_email, user_type, login_name
			FROM ' . USERS_TABLE . "
			WHERE login_name = '" . $db->sql_escape($username) . "'";
	}
	else
	{
		$sql = 'SELECT user_id, username, user_password, user_passchg, user_email, user_type
			FROM ' . USERS_TABLE . "
			WHERE username_clean = '" . $db->sql_escape(utf8_clean_string($username)) . "'";
	}
			
	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);
	

	if ($row)
	{
		// User inactive...
		if ($row['user_type'] == USER_INACTIVE || $row['user_type'] == USER_IGNORE)
		{

			return array(
				'status'		=> LOGIN_ERROR_ACTIVE,
				'error_msg'		=> 'ACTIVE_ERROR',
				'user_row'		=> $row,
			);
		} 
		$status = LOGIN_SUCCESS;
		
	};
	

	//load the Joomla! 1.5 site application
	if(!defined('_JEXEC') || defined('PHPBB_EMBEDDED')) 
	{
		loadJoomla15();
		
		$app = &JFactory::getApplication('site');
			
		if(!defined('PHPBB_EMBEDDED')) {
			$GLOBALS['mainframe'] =& $app;
		}
		
		// preform login
		$credentials = array('username' => $username, 'password' => $password);
		$options     = array('entry_url' => JURI::root().'index.php?option=com_user&task=login');
		
		if (class_exists('JConfigForum')) {
	    //Include the PHPBB3 configuration   
		$jconfig = new JConfigForum();    
    		if ($jconfig->remember_login ) $options['remember'] = true; // force remember me for joomla login       
		}
		
		$result = $app->login($credentials, $options);
		
		// check to see if the user is blocked		
		foreach ($app->getMessageQueue() as $message) {
			if (in_array('E_NOLOGIN_BLOCKED', $message)) {
				// clear remember me cookie
				setcookie( JUtility::getHash('JLOGIN_REMEMBER'), '', time() - 86400, '/' );
			 	return array(
					'status'		=> LOGIN_ERROR_ACTIVE,
					'error_msg'		=> 'ACTIVE_ERROR',
					'user_row'		=> $row,
				);
			}
		}
	
		$session =& JFactory::getSession();
		$session->close();
		
		if(JError::isError($result)) 
		{
			return array(
				'status'	=> LOGIN_ERROR_PASSWORD,
				'error_msg'	=> 'LOGIN_ERROR_PASSWORD',
				'user_row'	=> array('user_id' => ANONYMOUS),
			);
		}	 
	}
	
	// user not in phpbb3 db, but is in joomla
	if (!$row && $result) 
	{
		//get the joomla user
		$juser =& JFactory::getUser();
		
		// retrieve default group id
		$sql = 'SELECT group_id
				FROM ' . GROUPS_TABLE . "
				WHERE group_name = '" . $db->sql_escape('REGISTERED') . "'
				AND group_type = " . GROUP_SPECIAL;
		$result = $db->sql_query($sql);
		$group = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		
		if (!$group) {
			trigger_error('NO_GROUP');
		}

		// generate user account data
		$row = array(
			'username'		=> $username,
			//'user_password'	=> phpbb_hash($password),
			'user_email'	=> $juser->email,
			'group_id'		=> $group['group_id'],
			'user_type'		=> (string)USER_NORMAL,
			'user_ip'		=> $user->ip,
		);
		
		if(!empty($has_login_name)) {
			$row['username']   = $juser->name;
			$row['login_name'] = $username;
		}
		
		$status = LOGIN_SUCCESS_CREATE_PROFILE;
	} 
	
	// Successful login... set user_login_attempts to zero...
	return array(
		'status'		=> $status,
		'error_msg'		=> false,
		'user_row'		=> $row,
	);
}

function logout_joomla(&$data)
{
	define('LOGOUT_PHPBB', true); //set define to allow to check for recursivity
	
	//load the Joomla! 1.5 site application
	if(!defined('_JEXEC') || defined('PHPBB_EMBEDDED')) 
	{
		//load the Joomla! 1.5 site application
		loadJoomla15();
		
		$app = &JFactory::getApplication('site');
		
		if(!defined('PHPBB_EMBEDDED')) {
			$GLOBALS['mainframe'] =& $app;
		}
			
		// preform login
		error_reporting(E_ERROR); //ingore vanished session notice 
		$result = $app->logout();
	
		$session =& JFactory::getSession();
		$session->close();
		echo "<script language=\"javascript\" type=\"text/javascript\"> alert('This is what an alert message looks like.'); </script>";
	}
}

function loadJoomla15()
{
	global $phpbb_root_path;
	
	define('_JEXEC', true);
	define( 'JPATH_BASE', $phpbb_root_path.'/..');
	define( 'DS', DIRECTORY_SEPARATOR );
	
	@set_magic_quotes_runtime( 0 );
	@ini_set('zend.ze1_compatibility_mode', '0');
	
	// System includes
	require_once( JPATH_BASE.DS.'includes'.DS.'defines.php' );
	require_once( JPATH_LIBRARIES.DS.'loader.php');
	
	//Base classes
	jimport( 'joomla.base.object' 			  );
	jimport( 'joomla.environment.request'     );
	jimport( 'joomla.factory' 				  );
	jimport( 'joomla.error.error' 			  );
	jimport( 'joomla.error.exception' 		  );
	jimport( 'joomla.utilities.arrayhelper'   );
	jimport( 'joomla.utilities.compat.compat' );
	jimport( 'joomla.environment.uri' 		  );
	jimport( 'joomla.user.user'				  );
	jimport( 'joomla.utilities.utility' 	  );
	jimport( 'joomla.event.event'			  );
	jimport( 'joomla.event.dispatcher'		  );
	jimport( 'joomla.plugin.helper'			  );
	jimport( 'joomla.filter.filterinput'	  );
	jimport( 'joomla.filter.filteroutput'	  );
	
	//Register class that don't follow one file per class naming conventions
	JLoader::register('JText' , JPATH_LIBRARIES.DS.'joomla'.DS.'methods.php');
}
?>