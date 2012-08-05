<?php
/**
* @name			Latest News PRO
* @version		1.5.0
* @package		Joomla
* @copyright	Copyright (C) 2008 - 2010 Joomla.StefySoft.com. All rights reserved.
* @license		GNU/GPL v2
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$list = modLatestNewsProHelper::getList($params);
require(JModuleHelper::getLayoutPath('mod_latestnews_pro'));
?>