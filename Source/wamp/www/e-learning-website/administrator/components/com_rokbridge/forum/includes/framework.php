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

/*
 * Joomla! system checks
 */

@set_magic_quotes_runtime( 0 );
@ini_set('zend.ze1_compatibility_mode', '0');

if (!file_exists( JPATH_CONFIGURATION . DS . 'configuration.php' ) || (filesize( JPATH_CONFIGURATION . DS . 'configuration.php' ) < 10)) {
	// TODO: Throw 500 error
	header( 'Location: ../installation/index.php' );
	exit();
}

/*
 * Joomla! system startup
 */

// System includes
require_once( JPATH_LIBRARIES		.DS.'joomla'.DS.'import.php'); 

// Pre-Load configuration
require_once( JPATH_CONFIGURATION	.DS.'configuration.php' );

// System configuration
$CONFIG = new JConfig();

if (@$CONFIG->error_reporting === 0) {
	error_reporting( 0 );
} else if (@$CONFIG->error_reporting > 0) {
	error_reporting( $CONFIG->error_reporting );
}

define( 'JDEBUG', $CONFIG->debug );

unset( $CONFIG );

// System profiler
if (JDEBUG) {
	jimport( 'joomla.error.profiler' );
	$_PROFILER =& JProfiler::getInstance( 'Application' );
}

//load compatibility libraries
jimport( 'joomla.utilities.compat.compat' );

//Set the application information
jimport( 'joomla.application.helper' );
$info =& JApplicationHelper::getClientInfo();

$obj = new stdClass();
$obj->id	= 4;
$obj->name	= 'forum';
$obj->path	= JPATH_FORUM;
$info[4]    = $obj;
unset($obj);

/*
 * Joomla! framework loading
 */

// Joomla! library imports
jimport( 'joomla.environment.uri');
jimport( 'joomla.utilities.utility' );
jimport( 'joomla.user.user');
jimport( 'joomla.event.event');
jimport( 'joomla.event.dispatcher');

//Register class that don't follow one file per class naming conventions
JLoader::register('JText' , dirname(__FILE__).DS.'methods.php');
?>