

<?php
/**
 * Theory Content Model for TheoryContent Component
 * 
 * @package    Joomla.Tutorials
 * @subpackage Components
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
class theoryContentModeltheoryContent extends JModel
{
	/**
	 * Gets the greeting
	 * @return string The greeting to be displayed to the user
	 */
<<<<<<< .mine
	function getChapterName()
	{
		$Itemid=$_GET['Itemid'];
		
		$db =& JFactory::getDBO();
		$query = "SELECT name FROM #__menu WHERE id = " . $Itemid;
		$db->setQuery( $query );
		$theoryName = $db->loadResult();
		
		$db =& JFactory::getDBO();
		$query = "SELECT subjectid FROM #__subjects WHERE subject_name = \"" . $theoryName . "\"";
		$db->setQuery( $query );
		$subjectid = $db->loadResult();
		
		$db =& JFactory::getDBO();
		$query = "SELECT DISTINCT chapter_name FROM #__theories WHERE subjectid = " . $subjectid;
		$db->setQuery( $query );
		$columns= $db->loadResultArray();
		foreach($columns as $column){
			echo "<h4><a href=\"index.php?option=com_theorycontent&name=$column\"\">" . $column . "</a></h4>";		
		}
				
		return $subjectid;
	}
	
	function getTheoryName()
	{
		$name=$_GET['name'];
		
		$db =& JFactory::getDBO();
		$query = "SELECT theory_name FROM #__theories WHERE chapter_name = \"" . $name . "\"";
		$db->setQuery( $query );
		$columns= $db->loadResultArray();
		foreach($columns as $column){
			echo "<h4><a href=\"index.php?option=com_theorycontent&theory=$column\"\">" . $column . "</a></h4>";	
		}
		return $name;
	
	}
	
	
	 
=======
>>>>>>> .r223
	function getVideo()
	{
		$theory=$_GET['theory'];
		$db =& JFactory::getDBO();

		$query = "SELECT theory_file_video_path FROM #__theories WHERE theory_name =\"" . $theory . "\"";
		$db->setQuery( $query );
		$video = $db->loadResult();

		return $video;
	}
	
	function getDat()
	{
		$theory=$_GET['theory'];
		$db =& JFactory::getDBO();

		$query = "SELECT theory_file_dat_path FROM #__theories WHERE theory_name =\"" . $theory . "\"";
		$db->setQuery( $query );
		$dat = $db->loadResult();
		
		
		return $dat;
		
		
		
	}
}


?>