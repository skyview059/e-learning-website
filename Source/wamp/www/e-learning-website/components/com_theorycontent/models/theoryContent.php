

<?php
/**
 * Theory Content Model for TheoryContent Component
 * 
 * @package    Joomla
 * @subpackage Components
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

/**
 * Theory Content Model
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class TheoryContentModelTheoryContent extends JModel
{
	/**
	 * Gets the greeting
	 * @return string The greeting to be displayed to the user
	 */
	function getChapterName()
	{
		$itemid=$_GET['Itemid'];
		
		$db =& JFactory::getDBO();
		$query = "SELECT name FROM #__menu WHERE id = " . $itemid;
		$db->setQuery( $query );
		$theoryName = $db->loadResult();
		
		$query = "SELECT subjectid FROM #__subjects WHERE subject_name = \"" . $theoryName . "\"";
		$db->setQuery( $query );
		$subjectid = $db->loadResult();
		
		$query = "SELECT DISTINCT chapter_name FROM #__theories WHERE subjectid = " . $subjectid;
		$db->setQuery( $query );
		$chapterNames= $db->loadResultArray();
			
		return $chapterNames;		
	}
	
	function getTheoryName($name)
	{
		//$name=$_GET['name'];
		$db =& JFactory::getDBO();
		$query = "SELECT theory_id,theory_name FROM #__theories WHERE chapter_name = \"" . $name . "\"";
		$db->setQuery( $query );
		$theorynames= $db->loadRowList();
		
		return $theorynames;
	
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
		if ($dat != "")
		$content = JPATH_URL.$dat;
		if (isset($content))
		{
			$file = fopen($content, "r");
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
			return "Sucess";
		}
		else
			return "Fail";
	}
	
	function getAnswerCorrect($ID) 
	{
		$db =& JFactory::getDBO();
		$query = "SELECT answer_text FROM `jos_answers` WHERE `questionid` = '".$ID."' AND `answer_correct` = 1";
		$db->setQuery( $query );
		$result = $db->loadResult();
		return $result;
	} 
	
	function getAnswer($ID) 
	{
		$db =& JFactory::getDBO();
		$query = "SELECT answer_text FROM `jos_answers` WHERE `questionid` = '".$ID."'";
		$db->setQuery( $query );
		$result= $db->loadResultArray();
		return $result;
	} 
	
	function getQuestion($theoryid,$num)
	{
		$db =& JFactory::getDBO();
		$query = "SELECT * FROM `jos_questions` WHERE theory_id = '".$theoryid	."' ORDER BY RAND( ) LIMIT ".$num;
		$db->setQuery( $query );
		$row = $db->loadRowList();
		$i  = 0  ;
		$result = "";
		if (isset($row['0']['0']))
		{
			$result = "<h4> Các câu hỏi liên quan </h4>";
		}
		else 
			$result = "Dữ liệu về câu hỏi sẽ được cập nhật sau </br>";
		while($i < sizeof($row)){
				?>
				<script type="text/javascript">
					function ans<?php echo($row[$i]['0']);?>()
					{
						var my_str = document.getElementById('<?php echo $i;?>').innerHTML;  
						var comStr='Ans for question is : <?php echo($this->getAnswerCorrect($row[$i]['0'])) ;?>';  
					    document.getElementById('<?php echo $i;?>').innerHTML = comStr;  		
					}
				</script>
				<?php
				$tmp = "";
				$allAnswer =   $this->getAnswer($row[$i]['0']);
				if(isset($allAnswer))
				{
					$tmp = "</br>".($i+1).".";
					
					$tmp .=$row[$i]['5'];
					
					$tmp .= "<br><label>";
					if(isset($allAnswer['0']))
					{
						$tmp .= "<input type=\"radio\" name=\"question_".$row[$i]['0']."\" value=\"A\" id=\"question_".$row[$i]['0']."_A\" />";
						$tmp .="A. ".$allAnswer['0'];
						$tmp .= "</label><br><label>";
					}
					if(isset($allAnswer['1']))
					{
						$tmp .= "<input type=\"radio\" name=\"question_".$row[$i]['0']."\" value=\"B\" id=\"question_".$row[$i]['0']."_B\" />";
						$tmp .="B. ".$allAnswer['1'];
						$tmp .= "</label><br><label>";
					}
					if(isset($allAnswer['2']))
					{
						$tmp .= "<input type=\"radio\" name=\"question_".$row[$i]['0']."\" value=\"C\" id=\"question_".$row[$i]['0']."_C\" />";
						$tmp .="C. ".$allAnswer['2'];
						$tmp .= "</label><br><label>";
					}
					if(isset($allAnswer['3']))
					{
						$tmp .= "<input type=\"radio\" name=\"question_".$row[$i]['0']."\" value=\"D\" id=\"question_".$row[$i]['0']."_D\" />";
						$tmp .="D. ".$allAnswer['3'];
						$tmp .= "</label><br><label>";
					}
					if(isset($allAnswer['4']))
					{
						$tmp .= "<input type=\"radio\" name=\"question_".$row[$i]['0']."\" value=\"A\" id=\"question_".$row[$i]['0']."_E\" />";
						$tmp .="E. ".$allAnswer['4'];
						$tmp .= "</label><br><label>";
					}
					if(isset($allAnswer['5']))
					{
						$tmp .= "<input type=\"radio\" name=\"question_".$row[$i]['0']."\" value=\"A\" id=\"question_".$row[$i]['0']."_F\" />";
						$tmp .="F. ".$allAnswer['5'];
						$tmp .= "</label><br><label>";
					}
					
					$tmp .=" <a onclick=\"ans".$row[$i]['0']."()\" ><u>Answer</u></a></br>";
					$tmp .="<b  id=\"$i\"  readonly></b >";
					$tmp .="<br><input name=\"question_".$row[$i]['0']."\" type=\"hidden\" value=\"".$this->getAnswerCorrect($row[$i]['0'])."\" />";			
					
					$result = $result ."<br>".$tmp;	
				}
				$i++;
		}
		$i  =  0;
		return $result;
		
	}
	
	
	 
}


?>