<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
echo 'Book component he he he';

require_once( JApplicationHelper::getPath('admin_html'));
JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');
$task = JRequest::getCmd('task');

switch($task){
	case 'add':
		add1Book();
		break;
	case 'cancel';
		cancelBook();
		break;
	case 'save';
		saveBook();
		break;
	default:
		show1Book();
		break;
	}

function add1Book(){
	$lists['published'] = JHTML::_('select.booleanlist', 'published' ,'class="inputbox"', $row->published);
	HTML_book::addBook($lists);
}
function cancelBook()
{
	global $mainframe;
	$mainframe->redirect( 'index.php?option=com_book' );
}
function saveBook(){
	global $mainframe;
	$row =& JTable::getInstance('book', 'Table');
	if(!$row->bind(JRequest::get('post')))
	{
		JError::raiseError(500, $row->getError() );
	}
	$user =& JFactory::getUser();
	$row->title = JRequest::getVar( 'title', '','post', 'string',JREQUEST_ALLOWRAW );
    $row->author = JRequest::getVar( 'author', '','post', 'string',JREQUEST_ALLOWRAW );
	$row->synopsis = JRequest::getVar( 'synopsis', '','post', 'string',JREQUEST_ALLOWRAW );
    $row->content = JRequest::getVar( 'content', '','post', 'string',JREQUEST_ALLOWRAW );
	$row->created = date( 'Y-m-d H:i:s' );
	$row->created_by = $user->get('id');
	$row->modified = date( 'Y-m-d H:i:s' );
	$row->modified_by = 0;
	$row-> published = JRequest::getVar( 'published', '','post', 'int',JREQUEST_ALLOWRAW );
	if(!$row->store()){
		JError::raiseError(500, $row->getError() );
	}
	$mainframe->redirect('index.php?option=com_book', 'Message Saved');
}
function show1Book(){
	$db =& JFactory::getDBO();
	$query = " SELECT b.*, u.name AS postname, u1.name AS modifyname
			FROM #__books AS b
			LEFT JOIN #__users AS u1 ON u1.id  = b.modified_by
			LEFT JOIN  #__users AS u ON u.id  = b.created_by ";
	$db->setQuery( $query );
	$rows = $db->loadObjectList();
	if($db->getErrorNum()){
		echo $db->stderr();
		return false;
	}
	HTML_book::showBook($rows);
}
?>