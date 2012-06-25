<?php
/**
 * @package		Joomla
 * @subpackage	RokCandy Macros
 * @copyright Copyright (C) 2009 RocketTheme. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @author RocketTheme, LLC
 */
 
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
// Require the base controller
require_once( JPATH_COMPONENT.DS.'controller.php' );
 
// Create the controller
$controller   = new RokBridgeController( );
 
// Perform the Request task
$controller->execute( JRequest::getWord( 'task' ) );
 
// Redirect if set by the controller
$controller->redirect();