<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
echo '<div class="componentheading">Vina Book</div>';
jimport('joomla.application.helper');
require_once(JApplicationHelper::getPath('html'));
JTable::addIncludePath(JPATH_ADMINISTRATOR.
DS.'components'.DS.$option.DS.'tables');
switch( $task ){
  default:
    showPublishedBook($option);
    break;
}
function showPublishedBook($option)
{
  $db =& JFactory::getDBO();
  $query = "SELECT * FROM #__books WHERE published= '1' ORDER BY id DESC";
  $db->setQuery( $query );
  $rows = $db->loadObjectList();
  if ($db->getErrorNum())
  {
    echo $db->stderr();
    return false;
  }
  HTML_book::showBook($rows, $option);
}
?>