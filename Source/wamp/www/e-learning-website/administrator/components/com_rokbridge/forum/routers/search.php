<?php
/**
 * @version		$Id: search.php 2047 2007-10-02 00:42:56Z jinx $ 
 * @package RokBridge - phpBB3 edition
 * @copyright Copyright (C) 2009 RocketTheme. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @author RocketTheme, LLC
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

function SearchBuildRoute(&$query)
{
	$segments = array();
	
	if(isset($query['search_id'])) {
		$segments[] = $query['search_id'];
		unset($query['search_id']);
	};

	return $segments;
}

function SearchParseRoute($segments)
{
	$vars = array();

	// Count route segments
	$count = count($segments);
	
	$vars['search_id'] = $segments[0];

	return $vars;
}
?>