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

jimport( 'joomla.application.component.controller' );

class RokBridgeController extends JController
{
	function __construct($config = array())
	{
		parent::__construct($config);

		// Register Extra tasks
		$this->registerTask( 'save',  'process' );
		$this->registerTask( 'addindexes', 'process' );
		$this->registerTask( 'dropindexes', 'process' );
		$this->registerTask( 'applypatch', 'process' );
		$this->registerTask( 'removepatch', 'process' );
		$this->registerTask( 'movebridge', 'process' );
		$this->registerTask( 'removebridge', 'process' );
		$this->registerTask( 'installplugin', 'process' );
		$this->registerTask( 'removeplugin', 'process' );
	}
	
	function display( )
	{
		parent::display();
	}
	
	function process()
	{
		$model =& $this->getModel();
	
		switch(strtolower($this->getTask()))
		{
			case 'save':
				$model->saveConfiguration();
			break;
			case 'addindexes':
				$model->addIndexes();
			break;
			case 'dropindexes':
				$model->dropIndexes();
			break;
			case 'applypatch':
				$model->patchForum(false, JRequest::getInt("patchfull",0));
			break;
			case 'removepatch':
				$model->patchForum(true, JRequest::getInt("patchfull",0));
			break;
			case 'movebridge':
				$model->moveBridge();
			break;
			case 'removebridge':
				$model->removeBridge();
			break;
			case 'installplugin':
				$model->installForumPlugin();
			break;
			case 'removeplugin':
				$model->removeForumPlugin();
			break;
		}

		$this->setRedirect( 'index.php?option=com_rokbridge');		
	}
}