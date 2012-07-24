<?php
/**
 * No Direct Access
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

class PluginAccess extends Adapters
{
    function administrator(){
    	$mainframe = JFactory::getApplication();
	    $acl = JFactory::getACL();
    	$user = JFactory::getUser();
        $option = JRequest::getCMD('option');
        
        if( $acl->acl_check($option,'administrator.block','users',$user->get('usertype')) )
        {
        	$mainframe->redirect('index.php', JText::_('You dont have permission to access'));
        }
    }

    function site(){
    	$mainframe = JFactory::getApplication();
    	$acl = JFactory::getACL();
    	$user = JFactory::getUser();
        $option = JRequest::getCMD('option');
        
        if( $acl->acl_check($option,'site.block','users',$user->get('usertype')) )
        {
        	$mainframe->redirect('index.php', JText::_('You dont have permission to access'));
        }
    }
}