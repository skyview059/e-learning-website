<?php
/**
 * Check Access
 */
defined('_JEXEC') or die( 'Restricted access' );

/**
 * HTML View class for the Menus Adapter
 *
 * @static
 * @package		Joomla
 * @subpackage	Adapters
 * @since 1.0
 */

require_once JPATH_COMPONENT_ADMINISTRATOR.DS."controllers".DS."adapters.php";

class MenuViewAdmin extends JView
{
	function display($tpl = null)
	{
		$db = JFactory::getDBO();

        /**
         * Get Viewname
         */
        $viewName = ucfirst($this->getName());
        /**
         * Adapter Name
         */
        $adapterName = "menu";
		
                /**
                 * Sections List
                 */
		$menuTypes = $this->getMenuTypeList();
		
		$adapterControl = new Adapters();
		$xml = $adapterControl->parseXMLInstallFile(NOIXACL_APADTER_PATH.DS."menu".DS."menu.xml");
		
		$this->assignRef("menuTypesList", $menuTypes);
		$this->assignRef("tasks", $xml["tasks"]["admin"]);
                $this->assignRef("adapterControl", $adapterControl);
		$this->assignRef("viewName", $viewName);
		$this->assignRef("adapterName", $adapterName);

		parent::display($tpl);
	}
	
	/**
	 * Get all menutypes and items
	 */
	function getMenuTypeList()
	{
		$db			=& JFactory::getDBO();
		
                /**
                 * Get Menutype
                 */
		$queryMenuType = "SELECT m.id, m.title, m.menutype "
                  . "FROM #__menu_types AS m ORDER BY m.title";
		$db->setQuery( $queryMenuType );
		$menuTypeList = $db->loadObjectList();

        return $menuTypeList;
	}
	
}