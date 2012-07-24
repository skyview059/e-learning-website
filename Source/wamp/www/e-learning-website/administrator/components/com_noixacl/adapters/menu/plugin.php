<?php
/**
 * No Direct Access
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

class PluginMenu extends Adapters
{
    function administrator(){
        $result = array(
            'task' => JRequest::getCMD('task'),
            'params' => array(
                '$menutype' => JRequest::getVar('menutype')
            )
        );

        return $result;
    }

    function site(){
        $menu = &JSite::getMenu();
        $menuActive = $menu->getActive();
        
        $arrMenuActive['menutype'] = $menuActive->menutype;
        $arrMenuActive['id'] = $menuActive->id;
        
        if( $menuActive->access == 0){
        	$arrMenuActive['menutype'] = '';
        	$arrMenuActive['id'] = '';
        }

        $result = array(
            'task' => 'access',
            'params' => array(
                '$menutype' => $arrMenuActive['menutype'],
        		'$menu_id' => $arrMenuActive['id']
            )
        );
        
        return $result;
    }
}