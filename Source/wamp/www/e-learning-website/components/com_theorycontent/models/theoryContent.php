

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
			echo "<h4><a href=\"http://localhost/e-learning-website/index.php?option=com_theorycontent&name=$column\"\">" . $column . "</a></h4>";		
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
			echo "<h4><a href=\"http://localhost/e-learning-website/index.php?option=com_theorycontent&theory=$column\"\">" . $column . "</a></h4>";	
		}
		return $name;
	
	}
	
	
	 
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
	
	function get_answer_correct($ID) 
	{
		$db =& JFactory::getDBO();
		$question = "SELECT answer_text FROM `jos_answers` WHERE `questionid` = '".$ID."' AND `answer_correct` = 1";
		$db->setQuery( $query );
		$result = $db->loadResult();
		return $result;
	} 
	
	function get_answer($ID) 
	{
		$db =& JFactory::getDBO();
		$query = "SELECT answer_text FROM `jos_answers` WHERE `questionid` = '".$ID."'";
		$result= $db->loadResultArray();
		return $result;
	} 
	
	function getQuestion($subjectid,$num)
	{
		$db =& JFactory::getDBO();
		$query = "SELECT * FROM `jos_questions` WHERE subjectiD = '".$subjectid."' ORDER BY RAND( ) LIMIT ".$num;
		$db->setQuery( $query );
		$row = $db->loadRowList();
		$i  = 1  ;
		while($i <= sizeof($row)){
				?>
				<?php /*?><script type="text/javascript">
					function ans_<?php echo($row['1'][$i]);?>()
					{
					alert("Ans for question \"<?php echo($row['6']);?>\" is : \"<?php echo(get_answer_correct($row['1'][$i])) ;?>\"");				
					}
				</script><?php */?>
				<?php
				//echo $row['1'][$i];
//				$all_ans =  get_answer($row['1'][$i]);
//				
//				
				$tmp = "<br>".$i++.".";
//				$tmp .=$row['6'][$i]." <a onclick=\"ans_".$row['1'][$i]."()\" ><u>Hint</u></a>";
//				
//				$tmp .= "<br><label>";
//				$tmp .= "<input type=\"radio\" name=\"question_".$row['1'][$i]."\" value=\"A\" id=\"question_".$row['1'][$i]."_A\" />";
//				$tmp .="A. ".$all_ans[1];
//				$tmp .= "</label><br><label>";
//				$tmp .= "<input type=\"radio\" name=\"question_".$row['1'][$i]."\" value=\"B\" id=\"question_".$row['1'][$i]."_B\" />";
//				$tmp .="B. ".$all_ans[2];
//				$tmp .= "</label><br><label>";
//				$tmp .= "<input type=\"radio\" name=\"question_".$row['1'][$i]."\" value=\"C\" id=\"question_".$row['1'][$i]."_C\" />";
//				$tmp .="C. ".$all_ans[3];
//				$tmp .= "</label><br><label>";
//				$tmp .= "<input type=\"radio\" name=\"question_".$row['1'][$i]."\" value=\"D\" id=\"question_".$row['1'][$i]."_D\" />";
//				$tmp .="D. ".$all_ans[4];
//				$tmp .= "</label>";
//				
//				$tmp .="<br><input name=\"question_".$row['1']."\" type=\"hidden\" value=\"".get_answer_correct($row['1'])."\" />";			
//				
//				$result = $result."<br>".$tmp;		
		}
		//$i  =  1;
//		return $result;
		
	}
	
	
	 
}


?>