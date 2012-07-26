

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
			echo "<h4><a href=\"/e-learning-website/index.php?option=com_theorycontent&name=$column\"\">" . $column . "</a></h4>";		
		}
				
		return $subjectid;
	}
	
	function getTheoryName()
	{
		$name=$_GET['name'];
		
		$db =& JFactory::getDBO();
		$query = "SELECT theory_id,theory_name FROM #__theories WHERE chapter_name = \"" . $name . "\"";
		$db->setQuery( $query );
		$columns= $db->loadRowList();
		foreach($columns as $column){
			echo "<h4><a href=\"/e-learning-website/index.php?option=com_theorycontent&theory=".$column['0']."\"\">" . $column['1'] . "</a></h4>";	
		}
		return $name;
	
	}
	
	function getTheoryid($theoryid)
	{
		
		$db =& JFactory::getDBO();
		$query = "SELECT theory_name FROM #__theories WHERE theory_id = \"" . $theoryid . "\"";
		$db->setQuery( $query );
		$result= $db->loadResult();
		return $result;
	
	}
	
	
	 
	function getVideo()
	{
		$theory=$_GET['theory'];
		$db =& JFactory::getDBO();

		$query = "SELECT theory_file_video_path FROM #__theories WHERE theory_id =\"" . $theory . "\"";
		$db->setQuery( $query );
		$video = $db->loadResult();

		return $video;
	}
	
	function getDat()
	{
		$theory=$_GET['theory'];
		$db =& JFactory::getDBO();

		$query = "SELECT theory_file_dat_path FROM #__theories WHERE theory_id =\"" . $theory . "\"";
		$db->setQuery( $query );
		$dat = $db->loadResult();
		if (isset($dat))
		{
			$file = fopen($dat, "r");
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
	
	function get_answer_correct($ID) 
	{
		$db =& JFactory::getDBO();
		$query = "SELECT answer_text FROM `jos_answers` WHERE `questionid` = '".$ID."' AND `answer_correct` = 1";
		$db->setQuery( $query );
		$result = $db->loadResult();
		return $result;
	} 
	
	function get_answer($ID) 
	{
		$db =& JFactory::getDBO();
		$query = "SELECT answer_text FROM `jos_answers` WHERE `questionid` = '".$ID."'";
		$db->setQuery( $query );
		$result= $db->loadResultArray();
		return $result;
	} 
	
	function getQuestion($subjectid,$num)
	{
		$db =& JFactory::getDBO();
		$query = "SELECT * FROM `jos_questions` WHERE subjectiD = '".$subjectid."' ORDER BY RAND( ) LIMIT ".$num;
		$db->setQuery( $query );
		$row = $db->loadRowList();
		$i  = 0  ;
		$result = "CÁC CÂU HỎI LIÊN QUAN ĐẾN BÀI LÝ THUYẾT </br>";
		
		while($i < sizeof($row)){
				?>
				<script type="text/javascript">
					function ans_<?php echo($row[$i]['0']);?>()
					{
						alert("Ans for question \"<?php echo($row[$i]['5']);?>\" is : \"<?php echo($this->get_answer_correct($row[$i]['0'])) ;?>\"");				
					}
				</script>
				<?php
				$tmp = "";
				$all_ans =   $this->get_answer($row[$i]['0']);
				if(isset($all_ans))
				{
					$tmp = "<br>".($i+1).".";
					
					$tmp .=$row[$i]['5']." <a onclick=\"ans_".$row[$i]['0']."()\" ><u>Hint</u></a>";
					
					$tmp .= "<br><label>";
					$tmp .= "<input type=\"radio\" name=\"question_".$row[$i]['0']."\" value=\"A\" id=\"question_".$row[$i]['0']."_A\" />";
					$tmp .="A. ".$all_ans['0'];
					$tmp .= "</label><br><label>";
					$tmp .= "<input type=\"radio\" name=\"question_".$row[$i]['0']."\" value=\"B\" id=\"question_".$row[$i]['0']."_B\" />";
					$tmp .="B. ".$all_ans['1'];
					$tmp .= "</label><br><label>";
					$tmp .= "<input type=\"radio\" name=\"question_".$row[$i]['0']."\" value=\"C\" id=\"question_".$row[$i]['0']."_C\" />";
					$tmp .="C. ".$all_ans['2'];
					$tmp .= "</label><br><label>";
					$tmp .= "<input type=\"radio\" name=\"question_".$row[$i]['0']."\" value=\"D\" id=\"question_".$row[$i]['0']."_D\" />";
					$tmp .="D. ".$all_ans['3'];
					$tmp .= "</label>";
					
					$tmp .="<br><input name=\"question_".$row[$i]['0']."\" type=\"hidden\" value=\"".$this->get_answer_correct($row[$i]['0'])."\" />";			
					
					$result = $result ."<br>".$tmp;	
				}
				$i++;
		}
		$i  =  0;
		echo $result;
		
	}
	
	
	 
}


?>