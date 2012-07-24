<?php
/**
 * No Direct Access
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

class PluginContent extends Adapters
{
    function administrator(){
        $db = & JFactory::getDBO();

        //get id from content
        $cid			= JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($cid, array(0));
		$id				= JRequest::getVar( 'id', $cid[0], '', 'int' );

        $sqlContent = "SELECT catid FROM #__content WHERE id = {$id}";
        $db->setQuery( $sqlContent );
        $catid = $db->loadResult();

		// MIKE: Change task if it's apply or cancel, preview and orderdown/up
		$task = JRequest::getCMD('task');

		switch($task) {
			case 'apply':
				$task= 'save';
				break;
			case 'cancel':
			case 'preview':
				$task= 'edit';
				break;
			case 'orderup':
			case 'orderdown':
				$task= 'saveorder';
				break;
			case 'accesspublic':
			case 'accessregistered':
			case 'accessspecial':
				$task= 'accesslevel';
				break;
		}
        $result = array(
            'task' => $task,
            'params' => array(
                '$catid' => $catid
            )
        );

		// MIKE: Old code below
//        $result = array(
//            'task' => $task,
//            'params' => array(
//                '$catid' => $catid
//            )
//        );

        return $result;
    }

	function site(){
        $db = & JFactory::getDBO();

        //get id from content
        $cid			= JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($cid, array(0));
		$id				= JRequest::getVar( 'id', $cid[0], '', 'int' );

//rrr
//        $sqlContent = "SELECT catid FROM #__content WHERE id = {$id}";
        $sqlContent = "SELECT cont.catid catid, cont.access contaccess, cat.access cataccess FROM #__content cont" .
			" left join #__categories cat on cont.catid=cat.id" .
			" WHERE cont.id = {$id}";
		
        $db->setQuery( $sqlContent );
		if ($db->getErrorNum()) {
			JError::raiseError( 500, $db->stderr() );
			return false;
		}
		
		$access = $db->loadObject();
		// if public then no check
		if ($access==null || (is_null($access->contaccess) || $access->contaccess == 0) && (is_null($access->cataccess) || $access->cataccess == 0))
			$catid = "";
		else
			$catid = $access->catid;


        $view = JRequest::getCMD('view');
        switch($view){
        	case 'article':
        		$task = 'access';
        		break;
        	default:
        		$task = '';
        		break;
        }
        
        $result = array(
            'task' => $task,
            'params' => array(
                '$catid' => $catid
            )
        );

		return $result;
    }
}