<?php
/**
 * @version		$Id:$ 
 * @package RokBridge - phpBB3 edition
 * @copyright Copyright (C) 2009 RocketTheme. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @author RocketTheme, LLC
 */

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

class JRouterForum extends JRouter
{
	var $_views = array();
	
	function __construct($options = array())
	{
		parent::__construct($options);
		
		$this->_views = array(
		    'adm'           => 'adm',
			'download' 		=> 'download',
			'faq'			=> 'faq',
			'file'			=> 'file',
			'mcp'			=> 'moderator',
			'memberlist'	=> 'members',
			'posting'		=> 'post',
			'report'		=> 'report',
			'search'		=> 'search',
			'ucp'			=> 'user',
			'viewforum'		=> 'forum',
			'viewonline'	=> 'online',
			'viewtopic'		=> 'topic',
			'cron'          => 'cron'
		);
	}
	
	function parse(&$uri)
	{	
		$vars = array();

		// Get the path
		$path = $uri->getPath();

		//Remove basepath
		$path = substr_replace($path, '', 0, strlen(JURI::base(true)));

		//Remove prefix
		$path = str_replace('index.php', '', $path);

		//Set the route
		$uri->setPath(trim($path , '/'));

		$vars += parent::parse($uri);
		
		return $vars;
	}
	
	function &build($url)
	{
		$uri =& parent::build($url);

		// Get the path data
		$route = $uri->getPath();

		//Add the suffix to the uri
		if($this->_mode == JROUTER_MODE_SEF && $route)
		{
			$app =& JFactory::getApplication();

			if($app->getCfg('sef_rewrite'))
			{
				//Transform the route
				$route = str_replace('index.php/', '', $route);
			}
		}
		
		//Add basepath to the uri
		$uri->setPath($route);

		return $uri;
	}
	
	
	function _parseRawRoute(&$uri)
	{
		return array();
	}
	
	function _parseSefRoute(&$uri)
	{
		$vars = array();
		
		$route = $uri->getPath();
		
		//Handle an empty URL (special case)
		if(empty($route)) {
			return array();
		} 

		$segments = explode('/', $route);
		
		$view  = preg_replace('/[^A-Z0-9_\.-]/i', '', $segments[0]);
		
		$views = array_flip($this->_views);
		$view  =  $views[$view];
		
		if(empty($view)) {
			$view = 'index';
		}
		
		array_shift($segments);
		
		// Use the component routing handler if it exists
		$path = JPATH_BASE.DS.'routers'.DS.$view.'.php';

		if (file_exists($path) && count($segments))
		{
			require_once $path;
			$function =  $view.'ParseRoute';
			$vars =  $function($segments);
		}

		//set the view		
		$vars['rb_v'] = $view;
		
		//Set the variables
		$this->setVars($vars);

		return array();
	}
	
	function _buildRawRoute(&$uri)
	{
		$route = ''; //the route created
		return $route;
	}
	
	function _buildSefRoute(&$uri)
	{
		$parts = array();
		
		// Get the route
		$route = $uri->getPath();
			
		//Get the query data
		$query = $uri->getQuery(true);
		
		// Get the view
		$view = preg_replace('/[^A-Z0-9_\.-]/i', '', $query['rb_v']);
		
		// Unset unneeded query information
		unset($query['rb_v']);

		// Use the component routing handler if it exists
		$path = JPATH_BASE.DS.'routers'.DS.$view.'.php';
		
		// Use the custom request handler if it exists
		if (file_exists($path))
		{
			require_once $path;
			$function	= $view.'BuildRoute';
			$parts		= $function($query);

		}
		
		//Translate the view
		$views = $this->_views;
		$view  = $views[$view];
		
		//add the view to the head of the parts array
		$parts = array_merge(array('rb_v' => $view), $parts);
			
		$result  = implode('/', $parts);
		$route  .= ($result != "") ? '/'.$result : null;
		
		//Set query again in the URI
		$uri->setQuery($query);
		$uri->setPath($route);
	}
}