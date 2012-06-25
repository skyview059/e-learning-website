<?php
/**
 * @package		Joomla
 * @subpackage	RokBridge
 * @copyright Copyright (C) 2009 RocketTheme. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @author RocketTheme, LLC
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');

class RokBridgeModelRokBridge extends JModel
{
	function getParams()
	{
		$table =& JTable::getInstance('component');
		$table->loadByOption( 'com_rokbridge' );
				
		return new JParameter( $table->params, JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rokbridge'.DS.'config.xml' );
	}
}