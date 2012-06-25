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

jimport( 'joomla.application.component.view');

class RokBridgeViewRokBridge extends JView
{
	function display($tpl = null)
	{
		$document = & JFactory::getDocument(); 
		$document->setTitle( JText::_('RokBridge').": ".ROKBRIDGE_VERSION );
		$document->addStyleSheet('components/com_rokbridge/assets/rokbridge.css');
		
		JToolBarHelper::title(   JText::_( 'RokBridge' ).": ".ROKBRIDGE_VERSION,'rokbridge');
		JToolBarHelper::save();
		JToolBarHelper::cancel('cancel','Reset');
		JToolBarHelper::help( 'screen.rokbridge' );
		
		$bits = $this->get('Bits');
		
		foreach ($bits as $key => $value)
		{
			$this->assign($key, $value);
		}
		
		$this->assign('patch_class', $bits->patch_installed ? "installed":"notinstalled");
		$this->assign('userplg_class', $bits->joomla_userplg_installed ? "installed":"notinstalled");
		$this->assign('authplg_class', $bits->joomla_authplg_installed ? "installed":"notinstalled");
		$this->assign('phpbb3plg_class', $bits->phpbb3plg_installed ? "installed":"notinstalled");
		$this->assign('indexes_class', $bits->indexes_installed ? "installed":"notinstalled");
		$this->assign('phpbb3_class', $bits->phpbb3_installed ? "installed":"notinstalled");
		$this->assign('bridge_class', $bits->bridge_installed ? "installed":"notinstalled");
		$this->assign('phpbb3_version', $bits->phpbb3_version);
		
		$this->assign('userplg_status', $bits->joomla_userplg_installed ? JText::_('INSTALLED_ENABLED') : JText::_('INSTALLED_NOT_ENABLED'));
		$this->assign('userplg_note', $bits->joomla_userplg_installed ? "" : JText::_('INSTALLED_NOT_ENABLED_NOTE'));
		$this->assign('authplg_status', $bits->joomla_authplg_installed ? JText::_('INSTALLED_ENABLED') : JText::_('INSTALLED_NOT_ENABLED'));
		$this->assign('authplg_note', $bits->joomla_authplg_installed ? "" : JText::_('INSTALLED_NOT_ENABLED_NOTE'));
		$this->assign('patch_status', !$bits->patch_installed ? JText::_('NOT_INSTALLED') : JText::_('INSTALLED'));
		$this->assign('phpbb3_note', !$bits->phpbb3_installed ? JText::_('PHPBB3_INSTALL_NOT_FOUND') : "phpBB3 Version: <b>" . $bits->phpbb3_version . "</b>");
		$this->assign('phpbb3_status', !$bits->phpbb3_installed ? JText::_('NOT_INSTALLED') : JText::_('INSTALLED'));
		$this->assign('phpbb3plg_status', !$bits->phpbb3plg_installed ? JText::_('NOT_INSTALLED') : JText::_('INSTALLED'));		
		$this->assign('indexes_status', !$bits->indexes_installed ? JText::_('NOT_INSTALLED') : JText::_('INSTALLED'));
		$this->assign('bridge_status', !$bits->bridge_installed ? JText::_('NOT_INSTALLED') : JText::_('INSTALLED'));
		
		$this->assignRef('params', $this->get('Params'));
		
		parent::display($tpl);
	}
}