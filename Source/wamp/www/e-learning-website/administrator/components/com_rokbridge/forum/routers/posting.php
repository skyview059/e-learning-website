<?php
/**
 * @version		$Id: posting.php 2047 2007-10-02 00:42:56Z jinx $ 
 * @package RokBridge - phpBB3 edition
 * @copyright Copyright (C) 2009 RocketTheme. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @author RocketTheme, LLC
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

function PostingBuildRoute(&$query)
{
	$segments = array();
	
	if(isset($query['mode'])) {
		$segments[] = $query['mode'];
		unset($query['mode']);
	};
	
	return $segments;
}

function PostingParseRoute($segments)
{
	$vars = array();

	// Count route segments
	$count = count($segments);
	
	$vars['mode'] = $segments[0];

	return $vars;
}
?>