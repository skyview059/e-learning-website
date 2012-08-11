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
class TheoryLibraryModelTheoryLibrary extends JModel
{	 
	function getNumOfSubject()
	{
		$db =& JFactory::getDBO();
		
		$query = 'SELECT COUNT( subject_name )FROM #__subjects';
		$db->setQuery( $query );
		$numOfSubject = $db->loadResult();

		return $numOfSubject;
	}
	
	function getSubject()
	{
		$db =& JFactory::getDBO();

		$query = 'SELECT subject_name FROM #__subjects';
		$db->setQuery( $query );
		
		$subjectArray = $db->loadResultArray();
		
		return $subjectArray;
	}
	
	function getSubjectImage()
	{
		$db =& JFactory::getDBO();
		
		$query = 'SELECT subject_image FROM #__subjects';
		$db->setQuery( $query );
		$subjectImageArray = $db->loadResultArray();
		
		return $subjectImageArray;
	}
	
	function getNumOfChapter($chapterName)
	{
		$db =& JFactory::getDBO();
		$query = "SELECT COUNT( DISTINCT chapter_name )
				  FROM jos_theories
				  WHERE subjectid = (
				  SELECT subjectid
				  FROM jos_subjects
				  WHERE subject_name = \"".$chapterName."\")";
		$db->setQuery( $query );
		$numOfChapter = $db->loadResult();
		return $numOfChapter;
	}
	
	function getItemIdArray(){
		$db =& JFactory::getDBO();
		
		$query = 'SELECT #__menu.id
				  FROM #__menu
				  JOIN #__subjects
				  WHERE #__menu.name = #__subjects.subject_name
				  ORDER BY #__menu.id ASC';
		$db->setQuery( $query );
		$ItemIdArray = $db->loadResultArray();
		
		return $ItemIdArray;
	}
	
	function getChapterNameArray()
	{
		$subjectArray = $this->getSubject();
		$numOfSubject = $this->getNumOfSubject();
		
		for($i=0; $i<$numOfSubject; $i++)
		{
			$db =& JFactory::getDBO();
			$query =   "SELECT DISTINCT chapter_name
						FROM #__theories
						WHERE subjectid = (SELECT subjectid
										   FROM #__subjects
										   WHERE subject_name = \"".$subjectArray[$i]."\")";
			$db->setQuery( $query );
			$chapterNameSubjectArray = $db->loadResultArray();
			
			$numOfChapter = $this->getNumOfChapter($subjectArray[$i]);
			
			for ($j=0;$j<$numOfChapter;$j++)
			{
				$chapterNameArray["$subjectArray[$i]"][$j] = $chapterNameSubjectArray[$j];
			}
		}
		return $chapterNameArray;
	}
	
}