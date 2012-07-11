<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once( JApplicationHelper::getPath(
'toolbar_html' ) );
switch ( $task )
{
	case 'add'  :
		TOOLBAR_book::_NEW();
		break;
	default:
		TOOLBAR_book::_DEFAULT();
		break;
}
?>