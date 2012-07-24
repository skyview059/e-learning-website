<?php
/**
 * No Direct Access
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Users Component Controller
 *
 * @package		Joomla
 * @subpackage	Adapters
 * @since 1.5
 */
class AccessController extends Adapters
{
	/**
	 * Save Adapter
	 */
	function save($groupName)
	{
        /**
         * Checking post of adapter access
         */
		if( !empty($_POST['ada_access']) ){
			foreach($_POST['ada_access'] as $aco_section => $aco)
			{
				foreach($aco as $aco_value)
				{
					if( strpos($aco_value,';') )
					{
						list($aco_value, $axo_section, $axo_value) = explode(';',$aco_value);
					}
					else{
						$axo_section = '';
						$axo_value = '';
					}
					
					$arrRule = array(
		                "aco_section" => $aco_section,
		                "aco_value" => $aco_value,
		                "aro_section" => "users",
		                "aro_value" => $groupName,
		                "axo_section" => $axo_section,
		                "axo_value" => $axo_value
		            );
					$this->insertRule($arrRule);
					
					switch($aco_section) {
						case 'com_media':
							if ($aco_value='manage') {
								$arrRule = array(
									"aco_section" => $aco_section,
									"aco_value" => 'popup',
									"aro_section" => "users",
									"aro_value" => $groupName,
									"axo_section" => $axo_section,
									"axo_value" => $axo_value
								);
								$this->insertRule($arrRule);
							}
								
					}
				}
			}
		} 
	}
	
	/**
	 * Delete Adapter
	 */
	function delete($groupName='')
	{
		// Mike Completly changes module
		// Remove Manage user rules
		$this->deleteRules("com_users","block user",$groupName);
		$this->deleteRules("com_user","edit",$groupName);
		$this->deleteRules("com_users","manage",$groupName);
		// Remove manage login rules
		$this->deleteRules("login","site",$groupName);
		$this->deleteRules("login","administrator",$groupName);
		// Remove Core component access rules
		$this->deleteRules("com_weblinks","manage",$groupName);
		$this->deleteRules("com_banners","manage",$groupName);
		$this->deleteRules("com_components","manage",$groupName);
		$this->deleteRules("com_media","manage",$groupName);
		$this->deleteRules("com_media","popup",$groupName);
		$this->deleteRules("com_menus","manage",$groupName);
		$this->deleteRules("com_modules","manage",$groupName);
		$this->deleteRules("com_templates","manage",$groupName);
		$this->deleteRules("com_poll","manage",$groupName);
		$this->deleteRules("com_frontpage","manage",$groupName);
		$this->deleteRules("com_frontpage","edit",$groupName);
		$this->deleteRules("com_contact","manage",$groupName);
		$this->deleteRules("com_languages","manage",$groupName);
		$this->deleteRules("com_plugins","manage",$groupName);
		$this->deleteRules("com_config","manage",$groupName);
		$this->deleteRules("com_checkin","manage",$groupName);
		$this->deleteRules("com_cache","manage",$groupName);
		$this->deleteRules("com_massmail","manage",$groupName);
		$this->deleteRules("com_newsfeeds","manage",$groupName);
		$this->deleteRules("com_trash","manage",$groupName);
		// Remove manage login rules
		$this->deleteRules("login","site",$groupName);
		$this->deleteRules("login","administrator",$groupName);
		// Remove Manage Content rules
		$this->deleteRules("com_content","add",$groupName);
		$this->deleteRules("com_content","edit",$groupName);
		$this->deleteRules("com_content","publish",$groupName);
		// Remove Manage Instalation rules
		$this->deleteRules("com_installer","template",$groupName);
		$this->deleteRules("com_installer","plugin",$groupName);
		$this->deleteRules("com_installer","module",$groupName);
		$this->deleteRules("com_installer","language",$groupName);
		$this->deleteRules("com_installer","installer",$groupName);
		$this->deleteRules("com_installer","component",$groupName);

		//geting other extensions
		$db = JFactory::getDBO();
		$query = "SELECT c.* FROM #__components AS c WHERE c.iscore = 0 AND c.option != 'com_noixacl' AND c.option != ' ' AND c.enabled = 1 GROUP BY c.option";
		$db->setQuery( $query );
		$extensions = $db->loadObjectList();
		
		$ext = new stdClass();
		$ext->option = 'com_content';
		$extensions = array_merge(array( $ext ),$extensions);
		
		foreach($extensions as $extension){
			$this->deleteRules($extension->option,"administrator.block",$groupName);
			$this->deleteRules($extension->option,"site.block",$groupName);
		}

	}

}