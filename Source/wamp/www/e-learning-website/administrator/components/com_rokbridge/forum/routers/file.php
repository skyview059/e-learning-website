<?php
/**
 * @version		$Id: file.php 2047 2007-10-02 00:42:56Z rhuk $ 
 * @package RokBridge - phpBB3 edition
 * @copyright Copyright (C) 2009 RocketTheme. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @author RocketTheme, LLC
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

function FileBuildRoute(&$query)
{
	$segments = array();

	return $segments;
}

function FileParseRoute($segments)
{
	$vars = array();

	// Count route segments
	$count = count($segments);

	return $vars;
}
?>