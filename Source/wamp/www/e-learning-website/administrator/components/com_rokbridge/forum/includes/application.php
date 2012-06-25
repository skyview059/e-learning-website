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
* @package		Joomla
* @final
*/
class JForum extends JApplication
{
	/**
	* Class constructor
	*
	* @access protected
	* @param	array An optional associative array of configuration settings.
	* Recognized key values include 'clientId' (this list is not meant to be comprehensive).
	*/
	function __construct($config = array())
	{
		$config['clientId'] = 0;
		parent::__construct($config);
		
		//Set the root in the URI based on the application name
		JURI::root(null, str_replace('/'.JPATH_FORUM_PATH, '', JURI::base(true)));
	}
	
	/**
	* Route the application
	*
	* @access public
	*/
	function route() {
		parent::route();
	}
	
	/**
	* Dispatch the application
	*
	* @access public
	*/
	function dispatch()
	{
		$view = JRequest::getCmd('rb_v', 'index');	
		$path = $this->getCfg('phpbb_path').DS;
		
		switch($view)
		{
			case 'file' :
				$path .= 'download'.DS.'file.php'; 
				break;
			
			case 'adm' : 
				$path .= 'adm'.DS.'index.php'; 
				break;
			default    : 
				$path .= $view.'.php';
		}
		
		define('PHPBB_DB_NEW_LINK' , true);
		define('PHPBB_BASE_PATH'   , $this->getCfg('phpbb_path')); 
		define('PHPBB_ROOT_PATH'   , JPATH_ROOT.'/'.PHPBB_BASE_PATH.'/');
		define('PHPBB_ADMIN_PATH'  , PHPBB_ROOT_PATH.'adm'.DS);
		define('PHPBB_EMBEDDED'    , true);
		define('PHPBB_MSG_HANDLER' , 'msg_handler_hook_register');
		
		$this->_dispatchStart($path);
		$data = $this->_dispatchEnd();
		
		return $data;
	}
	
	/**
	* Display the application.
	*
	* @access public
	*/
	function render($contents="")
	{
		$uri = JURI::getInstance();
		$url = $uri->toString(array('scheme', 'host', 'query', 'path'));
		
		//Get the router
		$router = $this->getRouter();
		
		//Replace anchors
		$contents = str_replace('href="#', 'href="'.str_replace($uri->base(), '', $url).'#', $contents);
        $contents = str_replace(JPATH_ROOT, JURI::root(true), $contents);
        
		
		//Remove unneeded $phpbb_root_path added by build_url 
		//Note : This behavior should be fixed in a next version of phpBB3.
		$contents = str_replace(JURI::root(true).'/'.$this->getCfg('phpbb_path').'/http://', 'http://', $contents);
		
		if($router->getMode() == JROUTER_MODE_SEF) {
			$contents = preg_replace('<head>', "head>\n".'<base href="'.$uri->base().'" /', $contents, 1);
		}
		
		//Replace style links
		if(JRequest::getVar('rb_v')== 'adm') {	
			$base = $uri->root(true).'/'.$this->getCfg('phpbb_path').'/adm/';
			$contents = preg_replace("/(href|src)=\"(?!http|\/)([^\"]*)\"/", "$1=\"$base\$2\"", $contents);
		}
		
		JResponse::setBody($contents);
	}
	
	/**
	 * Return a reference to the JRouter object.
	 *
	 * @access	public
	 * @return	JRouter.
	 * @since	1.5
	 */
	function &getRouter()
	{
		$options['mode'] = $this->getCfg('sef');	
		$router =& parent::getRouter('forum', $options);
		
		return $router;
	}
	
	function _dispatchStart($path)
	{
		global $phpbb_root_path, $phpbb_admin_path, $phpEx;
		global $user, $auth, $template, $cache, $db, $config, $phpbb_hook;
		global $action, $module, $mode, $starttime;
		global $forum_id, $topic_id, $post_id, $user_id;
		
		set_include_path(JPATH_ROOT);
		
		if (!file_exists(JPATH_ROOT . DS . $path)) {
			$error = JError::raiseError(500, 'Unable to load application');
			return $error;
		}
		
		// Execute the forum
		if (preg_match("/\/file.php$/i", $path)) {
		        require_once $path;
		        ob_start();
		} else {
		        ob_start();
		        require_once $path;
	  	}
	}
	
	function _dispatchEnd()
	{
		global $phpbb_root_path, $phpbb_admin_path, $phpEx;
		global $user, $auth, $template, $cache, $db, $config, $phpbb_hook;;
		global $action, $module, $mode, $starttime;
		global $forum_id, $topic_id, $post_id, $user_id;
		
		$contents = ob_get_contents();
		ob_end_clean();
		
		restore_include_path();
		
		return $contents;
	}
	

	/**
	 * Create the configuration registry
	 *
	 * @access	private
	 * @param	string	$file 	The path to the configuration file
	 * return	JConfig
	 */
	function &_createConfiguration($file)
	{
		parent::_createConfiguration($file);
		
		require_once( JPATH_BASE.DS.'configuration.php' );

		// Create the JConfig object
		$config = new JConfigForum();

		// Get the global configuration object
		$registry =& JFactory::getConfig();

		// Load the configuration values into the registry
		$registry->loadObject($config);

		return $config;
	}
}
?>