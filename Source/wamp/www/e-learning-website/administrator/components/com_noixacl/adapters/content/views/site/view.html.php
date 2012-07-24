<?php
/**
 * Check if this file is included in Joomla!
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

class ContentViewSite extends JView
{
	function display($tpl = null)
	{
		$db = JFactory::getDBO();

        /**
         * Get View Name
         */
        $viewName = ucfirst($this->getName());
        /**
         * Adapter Name
         */
        $adapterName = "content";

                /**
                 * Sections List
                 */
		$sectionsList = $this->getSectionsList();

		$adapterControl = new Adapters();
		$xml = $adapterControl->parseXMLInstallFile(JPATH_COMPONENT_ADMINISTRATOR.DS."adapters".DS."content".DS."content.xml");

		$list["sections"] = JHTML::_('select.genericlist',  $sectionsList, $adapterName.$viewName.'TableSection', 'class="inputbox" size="1" onchange="showContentSite();"', 'id', 'title');

		$this->assignRef("sectionsList", $sectionsList);
		$this->assignRef("tasks", $xml["tasks"]["site"]);
                $this->assignRef("adapterControl", $adapterControl);
                $this->assignRef("lists",$list);
		$this->assignRef("viewName", $viewName);
		$this->assignRef("adapterName", $adapterName);

		parent::display($tpl);
	}

	/**
	 * Get all structure categories by sections
	 */
        function getSectionsList()
        {
            $db			=& JFactory::getDBO();

            /**
             * Get Sections
             */
            $querySections = "SELECT s.id, s.title, grp.name AS groupname FROM #__sections AS s, #__groups AS grp WHERE s.published = 1 AND s.access = grp.id ORDER BY title";
            $db->setQuery( $querySections );
            $sectionsList = $db->loadObjectList();

            /**
             * Get Categories
             */
            foreach($sectionsList as $section){
                $queryCategoryItens = "SELECT cat.*,grp.name AS groupname, cat.parent_id AS parent FROM #__categories AS cat, #__groups AS grp WHERE cat.access = grp.id AND cat.section = {$section->id} AND cat.published = 1";
                $db->setQuery( $queryCategoryItens );
                $categoryList = $db->loadObjectList();

                $levelLimit	= 10;
                /**
                 * Estabilish the hierarchy of the menu
                 */
                $children = array();
                /**
                 * First pass - Collect Children
                 */
                foreach ($categoryList as $v)
                {
                    $pt = $v->parent_id;
                    $list = @$children[$pt] ? $children[$pt] : array();
                    array_push( $list, $v );
                    $children[$pt] = $list;
                }
                /**
                 * Second Pass - Get an indent list of the items
                 */
                $list = JHTML::_('menu.treerecurse', 0, '', array(), $children, max( 0, $levelLimit-1 ) );

                $section->categoryList = $list;
            }

            return $sectionsList;
        }
}