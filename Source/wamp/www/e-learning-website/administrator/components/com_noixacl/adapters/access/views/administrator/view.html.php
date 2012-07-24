<?php
/**
* @version		$Id: view.html.php 11702 2009-03-24 00:54:27Z hackwar $
* @package		Joomla.Administrator
* @subpackage	Content
* @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
* @license		GNU General Public License, see LICENSE.php
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.application.component.view');

/**
 * HTML View class for the Articles component
 *
 * @static
 * @package		Joomla.Administrator
 * @subpackage	Content
 * @since 2.1
 */
class AccessAdapterViewAdministrator extends JView
{
	public function display($tpl = null)
	{
		$db = JFactory::getDBO();
		
		$query = "SELECT c.* FROM #__components AS c WHERE c.iscore = 0 AND c.option != 'com_noixacl' AND c.option != ' ' AND c.enabled = 1 GROUP BY c.option";
		$db->setQuery( $query );
		$extensions = $db->loadObjectList();
		
		$ext = new stdClass();
		$ext->option = 'com_content';
		$extensions = array_merge(array( $ext ),$extensions);
		
		$this->assignRef('extensions', $extensions);
		parent::display($tpl);
	}
	
	public function checkAccess($aco_section,$aco_value,$aro_section='users',$aro_value,$axo_section='',$axo_value='')
	{
		$db = JFactory::getDBO();
		$acl	= & JFactory::getACL();

		if( !empty($aco_section) )
		{
			$where[] =  "aco_section = '{$aco_section}'"; 
		}
		
		if( !empty($aco_value) )
		{
			$where[] = "aco_value = '{$aco_value}'";
		}

		if( !empty($aro_section) )
		{
			$where[] = "aro_section = '{$aro_section}'";
		}
		
		if( !empty($aro_value) )
		{
			$where[] = "aro_value = '{$aro_value}'";
		}
		
		if( !empty($axo_section) )
		{
			$where[] = "axo_section = '{$axo_section}'";
		}
		
		if( !empty($axo_value) )
		{
			$where[] = "axo_value = '{$axo_value}'";
		}
		
		$sql = "SELECT id FROM #__noixacl_rules";
		
		if( count($where) > 0 )
		{
			$sql .= " WHERE ". implode(' AND ',$where);
		}
		
		$db->setQuery( $sql );
		$access = $db->loadResult();

		if( !empty($access) ){
			return true;
		}
		
		if( $acl->acl_check($aco_section,$aco_value,$aro_section,$aro_value,$axo_section,$axo_value) > 0 )
		{
			return true;
		}
		
		return false;
	}
}