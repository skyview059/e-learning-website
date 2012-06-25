<?php
/**
 * @version		$Id:$ 
 * @package RokBridge - phpBB3 edition
 * @copyright Copyright (C) 2009 RocketTheme. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @author RocketTheme, LLC
 */


// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
* Joomla! Forum Application class
*
* Provide many supporting API functions
*
* @package	Joomla
* @final
*/
class JForumHelper
{
	function loadPHPBB3($path) 
	{
		global $phpbb_root_path, $phpEx;
		global $db, $user, $auth, $template, $cache, $config, $phpbb_hook, $sql_db;
			
		if(!defined('IN_PHPBB')) {
			define('IN_PHPBB', true); 
		} 
		
		if(!defined('STRIP')) {
			define('STRIP', (get_magic_quotes_gpc()) ? true : false);
		} 
		
		if(!defined('JPATH_FORUM')) {
			define('JPATH_FORUM', $path);
		}
		
		// Create the JConfig object
		require_once( JPATH_FORUM.DS.'configuration.php' );
		$config = new JConfigForum();
	
		$phpbb_root_path = JPATH_ROOT.DS.$config->phpbb_path.DS;
		$phpEx           = substr(strrchr(__FILE__, '.'), 1); 
		
		//Load configuration
		require($phpbb_root_path.'config.php');
			
		// Include files
		require_once($phpbb_root_path.'includes/acm/acm_' . $acm_type . '.php');
		require_once($phpbb_root_path.'includes/cache.php');
		require_once($phpbb_root_path.'includes/template.php');
		require_once($phpbb_root_path.'includes/session.php');
		require_once($phpbb_root_path.'includes/auth.php');
		require_once($phpbb_root_path.'includes/functions.php');
		require_once($phpbb_root_path.'includes/constants.php');
		require_once($phpbb_root_path.'includes/db/' . $dbms . '.php');
		require_once(JPATH_FORUM.DS.'includes'.DS.'utf8.php');

		// Instantiate some basic classes
		$user		= new user();
		$auth		= new auth();
		$template	= new template();
		$cache		= new cache();
		$db			= new $sql_db();
		
		// Connect to DB
		$db->sql_connect($dbhost, $dbuser, $dbpasswd, $dbname, $dbport, false, true);

		// We do not need this any longer, unset for safety purposes
		unset($dbpasswd);

		// Grab global variables, re-cache if necessary
		$config = $cache->obtain_config();
		
		// Add own hook handler
		require_once($phpbb_root_path . 'includes/hooks/index.' . $phpEx);
		$phpbb_hook = new phpbb_hook(array('exit_handler', 'phpbb_user_session_handler', 'append_sid', array('template', 'display')));

		foreach ($cache->obtain_hooks() as $hook)
		{
			@include($phpbb_root_path . 'includes/hooks/' . $hook . '.' . $phpEx);
		}
	
	}
	
	function killPHPBB3()
	{
		//perform garbage collection
		garbage_collection();
	}
}
?>