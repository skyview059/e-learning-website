<?php
// Modulename: "SIMPLE MOOTICKER" for Joomla! 1.5.x
// Version: 1.5.4
// File: mod_simplemooticker.php
// Copyright 2008 - 2009: medien.stroeme - agentur für multimediale werbung
// Online: www.medienstroeme.de
// License:	GNU/GPL, see LICENSE.php
// Last update: 05.03.2009

 // no direct access

defined('_JEXEC') or die('Restricted access');
// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$list = modSimplemootickerHelper::getList($params);
require(JModuleHelper::getLayoutPath('mod_simplemooticker'));
?>