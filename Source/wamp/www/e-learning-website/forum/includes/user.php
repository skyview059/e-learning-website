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

class rokuser extends user
{
	/**
	* Extract current session page
	*
	* @param string $root_path current root path (phpbb_root_path)
	*/
	function extract_current_page($root_path)
	{
		$page = parent::extract_current_page($root_path);
		$view = JRequest::getVar('rb_v');
		
		$page['page'] = str_replace($page['page'], 'index.php', $view.'.php');
		
		return $page;
	}
}