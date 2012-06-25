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

function phpbb_hook_register(&$hook)
{	
	global $phpbb_root_path, $phpEx, $db, $mainframe, $config, $user;
	
	//Set configration
	//$config['ranks_path'] = JURI::root(true).'/'.$config['ranks_path'];
	
	//Set extended user object
	require_once( JPATH_BASE .DS.'includes'.DS.'user.php' );
	$user                 = new rokuser();
	
	//Register the hooks
	foreach($hook->hooks as $definition => $hooks)
	{
		foreach($hooks as $function => $data)
		{
			$callback = $definition == '__global' ? $function : $definition.'_'.$function; 
			$hook->register(array($definition, $function), array('JForumHook', $callback));
		}
	}
}

function msg_handler_hook_register($errno, $msg_text, $errfile, $errline) {
	JForumHook::msg_handler($errno, $msg_text, $errfile, $errline);		
}

class JForumHook
{
	static function append_sid($hook, $url, $params = false, $is_amp = true, $session_id = false)
	{
		global $_SID, $_EXTRA_URL;
		
		$arrParams = array();
		$arrExtra  = array();
		$anchor    = '';
		
		JForumHook::fixPage();

		$config =& JFactory::getConfig();

		if ($url == '.php') {
			$url = '/'.$config->getValue('config.phpbb_path').'/index.php';
		}

		// Assign sid if session id is not specified
		if ($session_id === false) {
			$session_id = $_SID;
		}
	
		//Clean the url and the params first
		if($is_amp) 
		{
			$url  = str_replace( '&amp;', '&', $url );
			if(!is_array($params)) {
				$params = str_replace( '&amp;', '&', $params );
			}
		}
	
		$amp_delim = ($is_amp) ? '&amp;' : '&';
		$url_delim = (strpos($url, '?') === false) ? '?' : $amp_delim;

		// Process the parameters array
		if (is_array($params))
		{
			foreach ($params as $key => $item)
			{

				if ($item === NULL)
				{
					continue;
				}

				if ($key == '#')
				{
					$anchor = '#' . $item;
					continue;
				}

				$arrParams[$key] = $item;
			}
		} 
		else
		{	
			if(strpos($params, '#') !== false) 
			{
				list($params, $anchor) = explode('#', $params, 2);
				$anchor = '#' . $anchor;
			}
		
			parse_str($params, $arrParams); 
		}
	
		//Process the extra array
		if(!empty($_EXTRA_URL)) 
		{
			$extra = implode('&', $_EXTRA_URL);
			parse_str($extra, $arrExtra); 
		}

		//Create the URL
		$uri = new JURI($url);
	
		$query = $uri->getQuery(true);	
		$query = $query + $arrParams + $arrExtra;
		
		$uri->setQuery($query);
	
		//Set session id variable
		if($session_id) {
			$uri->setVar('sid', $session_id);
		}
		
		//Set fragment
		if($anchor) {
			$uri->setFragment($anchor);
		}
		
		
		$view = basename($uri->getPath(), '.php');
			
		if(!$uri->getVar('rb_v') && $view != "style") 
		{	
			
			
			if(JRequest::getVar('rb_v') == 'adm') 
			{
				if(strpos($url, $config->getValue('config.phpbb_path')) === false) {
					$view = 'adm';
				}
			}
	
			if (stripos($url, ($config->getValue('config.phpbb_path').'/adm')) !== false) {
				$view = 'adm';
			}
			
			if($view != 'index') {
				$uri->setVar('rb_v', $view);
			}
		}
		
		if ($view != 'style') { 
			$url = 'index.php'. $uri->toString(array('query', 'fragment'));
			// {} getting lost in encoding
			$url = str_replace( array('%7B', '%7D'), array('{', '}'), $url);
			return urldecode(JURI::base().JRoute::_($url, $is_amp));
		}	
		else {
			$url = 'style.php'. $uri->toString(array('query', 'fragment'));
			$url = str_replace( array('%7B', '%7D'), array('{', '}'), $url);
			return urldecode(JPATH_ROOT.'/'.$config->getValue('config.phpbb_path').'/'.$url);
		}		
	}
	
	static function fixPage() {
		global $user, $phpEx;
		
		$uri = new JURI($user->page['page_name'] . '.' . $phpEx . '?' . $user->page['query_string']);
		$user->page['page'] = $uri->toString();
	}
	
	static  function exit_handler($hook)
	{
		global $mainframe, $_PROFILER;
	
		$data = $mainframe->_dispatchEnd();
	
		$mainframe->render($data);
	
		if(JDEBUG) 
		{
			$_PROFILER->mark( 'afterRender' );
			JResponse::appendBody(implode( '', $_PROFILER->getBuffer()));
		}
	
		echo JResponse::toString($mainframe->getCfg('gzip'));
		$mainframe->close();
	}

	static function phpbb_user_session_handler($hook)
	{
		global $phpbb_root_path, $phpbb_admin_path, $phpEx;
		global $user, $auth, $template, $cache, $db, $config;
		global $action, $module, $mode, $starttime;
	
		//Force the page_name
		$user->page['page_name'] = JRequest::getVar('rb_v');
		
		//Simple post dispatch filtering
		switch(JRequest::getVar('mode'))
		{
			case 'overview'    :
			case 'reg_details' :
			{
				//Don't allow password changes through the user control panel
				unset($_POST['new_password']);
				unset($_POST['password_confirm']);
				unset($_REQUEST['new_password']);
				unset($_REQUEST['password_confirm']);
			}
		}
	}
	
	static function template_display($hook, $handle, $include_once = true)
	{
		
	}
	
	static function msg_handler($errno, $msg_text, $errfile, $errline) {
		msg_handler($errno, $msg_text, $errfile, $errline);		
	}
}
?>