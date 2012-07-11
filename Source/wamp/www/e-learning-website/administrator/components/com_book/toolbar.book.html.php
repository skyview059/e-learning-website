<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class TOOLBAR_book {
function _DEFAULT() {
	JToolBarHelper::title( JText::_('Vina Book' ), 'generic.png' );
	JToolBarHelper::publishList();
	JToolBarHelper::unpublishList();
	JToolBarHelper::deleteList();
	JToolBarHelper::editListX();
	JToolBarHelper::addNewX();
}
function _NEW() {
	JToolBarHelper::save();
	JToolBarHelper::apply();
	JToolBarHelper::cancel();
}
}
?>