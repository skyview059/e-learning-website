<?php
/**
 * @version	$Id: mod_rokbridge_login.php 2047 2007-10-02 00:42:56Z rhuk $ 
 * @package RokBridge - phpBB3 edition
 * @copyright Copyright (C) 2009 RocketTheme. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @author RocketTheme, LLC
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

//initiate rokbridge helper
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rokbridge'.DS.'helper.php' );
$rokbridge = new RokBridgeHelper();

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

// database parameters
$params->def('greeting', 1);
// end
if ($params->get('show_default_avatar',1)==1) {
    $default_avatar = JURI::root(true).'/'.$params->get('default_avatar','modules/mod_rokbridge_login/assets/default-avatar.png');
} else {
    $default_avatar = '';
}

// helper
$helper     = new ModRokBridgeLoginHelper($rokbridge);
$type 	    = $helper->getType();
$return	    = $helper->getReturnURL($params, $type);
$fuser      = $helper->getUser();
$pms        = $helper->getPMs();
$lastvisit  = $helper->getLastVisit();

$avatar     = $rokbridge->getAvatar($fuser, $params->get('avatar_size',55),"",$default_avatar);
$user       =& JFactory::getUser();

$lang =& JFactory::getLanguage();
$lang->load('mod_login');

require(JModuleHelper::getLayoutPath('mod_rokbridge_login'));
?>