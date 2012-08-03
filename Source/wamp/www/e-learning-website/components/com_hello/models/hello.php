<?php
/**
 * Hello Model for Hello World Component
 * 
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://dev.joomla.org/component/option,com_jd-wiki/Itemid,31/id,tutorials:modules/
 * @license    GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

/**
 * Hello Model
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class HelloModelHello extends JModel
{
	/**
	 * Gets the greeting
	 * @return string The greeting to be displayed to the user
	 */
	function getGreeting()
	{
		$db =& JFactory::getDBO();

		$query = 'SELECT greeting FROM #__hello';
		$db->setQuery( $query );
		$greeting = $db->loadResult();

		return $greeting;
	}
	function getSubjectName() 
	{
		$db =& JFactory::getDBO();
		$query = "SELECT subject_name FROM #__subjects";
		$db->setQuery( $query );
		$result = $db->loadResultArray();
		return $result;
	} 
}