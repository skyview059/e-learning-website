<?php
/**
 * @version		$Id: defines.php 3057 2008-01-08 00:47:19Z jinx $ 
 * @package RokBridge - phpBB3 edition
 * @copyright Copyright (C) 2009 RocketTheme. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @author RocketTheme, LLC
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

//Joomla framework path definitions
$parts = explode( DS, JPATH_BASE );
$lastpart  = array_pop( $parts );

define( 'JPATH_ROOT',			implode( DS, $parts ) );
define( 'JPATH_SITE',			JPATH_ROOT );
define( 'JPATH_CONFIGURATION',	JPATH_ROOT );
define( 'JPATH_FORUM',			JPATH_BASE );
define( 'JPATH_FORUM_PATH',     $lastpart );
define( 'JPATH_ADMINISTRATOR',	JPATH_ROOT . DS . 'administrator' );
define( 'JPATH_INSTALLATION',	JPATH_ROOT . DS . 'installation' );
define( 'JPATH_XMLRPC', 		JPATH_ROOT . DS . 'xmlrpc' );
define( 'JPATH_LIBRARIES',		JPATH_ROOT . DS . 'libraries' );
define( 'JPATH_PLUGINS',		JPATH_ROOT . DS . 'plugins'   );
define( 'JPATH_CACHE',			JPATH_BASE . DS . 'cache');
define( 'JPATH_THEMES'	   ,	JPATH_BASE . DS . 'templates' );
?>