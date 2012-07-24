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
class MenuController extends Adapters
{
	/**
	 * Save Adapter
	 */
	function save($groupName)
	{
        /**
         * Checking post of adapter menu
         */
            if( !empty($_POST['menu']) ){
                $post = $_POST['menu'];

                /**
                 * Saving site rules
                 */
                if( !empty($post['Site']) ){
                    foreach($post['Site'] as $menuType => $menuTypeData){
                        $extraParams = array(
                            '$menutype' => $menuType
                        );

                        /**
                         * Group By $menu_id
                         */
                        foreach($menuTypeData as $menu_id => $view){
                            /**
                             * Getting $menu_id
                             */
                            $extraParams['$menu_id'] = $menu_id;

                            /**
                             * Saving Rule
                             */
                            $resultRuleSite = $this->saveRule("menu","site",$groupName,$view['tasks'],$extraParams);
                        }
                    }
                }

                /**
                 * Saving Admin Rules
                 */
                if( !empty($post['Admin']) ){
                    foreach($post['Admin'] as $menutype => $view){
                        $extraParams = array(
                            '$menutype' => $menutype
                        );

                        $resultRuleAdmin = $this->saveRule("menu","admin",$groupName,$view['tasks'],$extraParams);
                    }
                }

                /**
                 * Verifying result of save
                 */
                if( $resultRuleAdmin == TRUE && $resultRuleSite == TRUE ){
                    return true;
                }

                return false;
            }
	}

	/**
	 * Delete Adapter
	 */
	function delete($groupName='')
	{
		$this->deleteRules("com_menus","access",$groupName);
        $this->deleteRules("com_menus","edit",$groupName);
	}

	/**
	 * Displays a view
	 */
	function display()
	{
		parent::display();
	}
}