<?php
/**
 * @version $Id: install.rokbridge.php 6328 2008-10-22 21:06:47Z wonderslug $
 * @package RocketTheme
 * @subpackage	RokDownloads
 * @copyright Copyright (C) 2008 RocketTheme. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 */
 // no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');	
 
class Status {
	var $STATUS_FAIL = 'Failed';
	var $STATUS_SUCCESS = 'Success';
	var $infomsg = array();
	var $errmsg = array();
	var $status;
}

$rok_database = JFactory::getDBO();
$rok_install_status = array();

function rok_com_install() {
	return com_rokbridge_install();
}

function com_rokbridge_install() {
	global $rok_install_status;
	$db = JFactory::getDBO();
	
	$status = new Status();
	$status->status = $status->STATUS_FAIL;
	$status->component = "com_rokbridge";
	
	if (!com_rokbridge_initial_data_population($status))
	{
		return false;
	}
	
	if (count($status->errmsg) == 0) {
		$status->status = $status->STATUS_SUCCESS;
	}
	
	$rok_install_status["com_rokbridge"] = $status;
	return true;
}

function com_rokbridge_initial_data_population(&$status) {

	$default = array();
	$default['params'] = array();
	$default['params']['bridge_path'] = 'forum';
	$default['params']['phpbb3_path'] = 'distribution';
	$default['params']['sef_enabled'] = 0;
	$default['params']['sef_rewrite'] = 0;
	$default['params']['force_remember'] = 0;
	$default['params']['link_format'] = 'bridged';
	$default['option'] = 'com_rokbridge';
	
	$table =& JTable::getInstance('component');
	if (!$table->loadByOption( 'com_rokbridge' ))
	{
		$status->errmsg[] = 'Not a valid component';
		return false;
	}
	
	$table->bind( $default );

	if (!$table->check() || !$table->store()) {
		$status->errmsg[] = $table->getError();
		return false;
	}
	
	return true;
}