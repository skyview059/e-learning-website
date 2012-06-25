<?php
/**
 * @version		$Id:$ 
 * @package RokBridge - phpBB3 edition
 * @copyright Copyright (C) 2009 RocketTheme. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @author RocketTheme, LLC
 */


// Set flag that this is a parent file
define( '_JEXEC', 1 );

define('JPATH_BASE', dirname(__FILE__) );
define('DS', DIRECTORY_SEPARATOR);

require_once( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once( JPATH_BASE .DS.'includes'.DS.'framework.php' );
require_once( JPATH_BASE .DS.'includes'.DS.'hooks.php' );

JDEBUG ? $_PROFILER->mark( 'afterLoad' ) : null;

/**
 * CREATE THE APPLICATION
 *
 * NOTE :
 */
$mainframe =& JFactory::getApplication('forum', array(
	'session_name' => 'site'
));

/**
 * INITIALISE THE APPLICATION
 *
 * NOTE :
 */
$mainframe->initialise(array(
	'language' => $mainframe->getUserState( "application.lang", 'lang' )
));

//JPluginHelper::importPlugin('system');

// trigger the onAfterInitialise events
JDEBUG ? $_PROFILER->mark('afterInitialise') : null;

/**
 * ROUTE THE APPLICATION
 *
 * NOTE :
 */
$mainframe->route();


// trigger the onAfterDisplay events
JDEBUG ? $_PROFILER->mark('afterRoute') : null;
//$mainframe->triggerEvent('onAfterRoute');

/**
 * DISPATCH THE APPLICATION
 *
 * NOTE :
 */
$mainframe->dispatch();


// trigger the onAfterDisplay events
JDEBUG ? $_PROFILER->mark('afterDispatch') : null;

/**
 * RENDER THE APPLICATION
 *
 * NOTE :
 */
$mainframe->render();


// trigger the onAfterDisplay events
JDEBUG ? $_PROFILER->mark( 'afterRender' ) : null;


/**
 * RETURN THE RESPONSE
 */
echo JResponse::toString($mainframe->getCfg('gzip'));

?>