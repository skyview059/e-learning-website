

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
class theoryContentModeltheoryContent extends JModel
{
	/**
	 * Gets the greeting
	 * @return string The greeting to be displayed to the user
	 */
	function getTheoryName()
	{
		$id=$_GET['Itemid'];
		//$query = 'SELECT name FROM #__menu WHERE id = $id';
//		$db->setQuery( $query );
//		$theoryName = $db->loadResult();

		return $id;
	}
	 
	function getContent()
	{
		$db =& JFactory::getDBO();

		$query = 'SELECT theory_file_video_path FROM #__theories';
		$db->setQuery( $query );
		$video = $db->loadResult();

		return $video;
	}
	
	function getDat()
	{
		$db =& JFactory::getDBO();

		$query = 'SELECT theory_file_dat_path FROM #__theories';
		$db->setQuery( $query );
		$dat = $db->loadResult();
		$file = fopen($dat, "r") or exit("Unable to open file!");
		//Output a line of the file until the end is reached
		while(!feof($file)){
			  $buf = fgets($file);
			  $output[] = $buf;
		}
		fclose($file);
		for($i=0; $i<sizeof($output); $i++)
		{
					echo $output[$i] . "<br/>";
		}
	}
}


?>