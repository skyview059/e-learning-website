<?php
/**
 * @package		Joomla
 * @subpackage	RokBridge
 * @copyright Copyright (C) 2009 RocketTheme. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @author RocketTheme, LLC
 */
 
// no direct access
defined('_JEXEC') or die('Restricted access'); 
 
jimport( 'joomla.application.component.controller' ); 
 
class RokBridgeController extends JController
{
	function display()
	{
		$model = & $this->getModel();
		$params = & $model->getParams();

		$bridge_path = $params->get('bridge_path');
		$phpbb3_path = $params->get('phpbb3_path');
		$link_format = $params->get('link_format','bridged');

		if ($link_format == 'bridged') 
			$this->setRedirect(JURI::base().$bridge_path);
		else 
			$this->setRedirect(JURI::base().$phpbb3_path);
	}
}