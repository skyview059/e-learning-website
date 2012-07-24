<?php
/**
* No Direct Access
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

class MenuViewSite extends JView
{
	function display($tpl = null)
	{
		$db = JFactory::getDBO();

        /**
         * Get Viewname
         */
        $viewName = ucfirst($this->getName());
        /**
         * Get Adapter Name
         */
        $adapterName = "menu";
		
                /**
                 * Sections List
                 */
		$menuTypes = $this->getMenuTypeList();
		
		$adapterControl = new Adapters();
		$xml = $adapterControl->parseXMLInstallFile(NOIXACL_APADTER_PATH.DS."menu".DS."menu.xml");
		
		$list["menuType"] = JHTML::_('select.genericlist',  $menuTypes, $adapterName.$viewName.'TableMenuType', 'class="inputbox" size="1" onchange="showMenuSite();"', 'id', 'title');
		
		$this->assignRef("menuTypesList", $menuTypes);
		$this->assignRef("tasks", $xml["tasks"]["site"]);
                $this->assignRef("adapterControl", $adapterControl);
		$this->assignRef("lists",$list);
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
		
		/**
		 * Get menu itens
		 */
		foreach($menuTypeList as $menuType){
			$queryMenuTypeItens = "SELECT m.*, g.name as groupname "
                        . "FROM #__menu m, #__groups g "
                        . "WHERE m.menutype = '{$menuType->menutype}' AND m.published = 1 AND m.access = g.id "
                        . "ORDER BY m.ordering ASC, m.parent, m.ordering";
                        
                        $db->setQuery( $queryMenuTypeItens );
			$menuItensList = $db->loadObjectList();
			
			$levelLimit	= 10;
                        /**
                         * Estabilish the hierarchy of the menu
                         */
			$children = array();
                        /**
                         * First Pass - Collect Children
                         */
                        if ($menuItensList) {
                            foreach ($menuItensList as $v)
                            {
                                    $pt = $v->parent;
                                    $list = @$children[$pt] ? $children[$pt] : array();
                                    array_push( $list, $v );
                                    $children[$pt] = $list;
                            }
                        }
                        /**
                         * Second Pass - Get and ident list of the items
                         */
			$list = JHTML::_('menu.treerecurse', 0, '', array(), $children, max( 0, $levelLimit-1 ) );
			
			$menuType->menuItensList = $list;
		}
		
		return $menuTypeList;
	}
	
}