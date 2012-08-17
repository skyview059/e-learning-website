

<?php
/**
 * Excercise Content Model for ExcerciseContent Component
 * 
 * @subpackage Components
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );


class ExcerciseContentModelExcerciseContent extends JModel
{
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
	
	function getQuestion($input,$num,$difficulty,$choice)
	{
		$db =& JFactory::getDBO();
		if ($difficulty != "Tự động"  )
		{	
			if($choice == 1)
				$query = "SELECT * FROM `jos_questions` WHERE chapter_name = '".$input."' AND `question_difficult` = '" .$difficulty. "' ORDER BY RAND( ) LIMIT ".$num;
			if($choice == 2)
			$query = "SELECT * FROM `jos_questions` WHERE theoryid = '".$input."' AND `question_difficult` = '" .$difficulty. "' ORDER BY RAND( ) LIMIT ".$num;
		}
		else
		{	
			$query = "SELECT * FROM `jos_questions` WHERE chapter_name = '".$input."' ORDER BY RAND( ) LIMIT ".$num; 
			if($choice == 1)
				$query = "SELECT * FROM `jos_questions` WHERE chapter_name = '".$input."' ORDER BY RAND( ) LIMIT ".$num;
			if($choice == 2)
			$query = "SELECT * FROM `jos_questions` WHERE theoryid = '".$input."' ORDER BY RAND( ) LIMIT ".$num;
		}
		$db->setQuery( $query );
		$row = $db->loadRowList();
		$i  = 0  ;
		$result = "";
		if ($num > sizeof($row))
		{
			$result .="</br>Số lượng câu hỏi không đủ, hiện tại chỉ có ". sizeof($row). " câu hỏi có sẵn "  ;
		}
		while($i < sizeof($row)){								
				?>
				<script type="text/javascript">
					function ans<?php echo($row[$i]['0']);?>()
					{	
						var my_str = document.getElementById('<?php echo $i;?>').innerHTML;  
						var comStr='Đáp án của câu hỏi là : <?php echo($this->getAnswerCorrect($row[$i]['0'])) ;?>';  
					    document.getElementById('<?php echo $i ;?>').innerHTML = comStr;  
						
					}
				</script>
				<?php
				$tmp = "";
				$allAnswer =   $this->getAnswer($row[$i]['0']);
				if(isset($allAnswer))
				{
				
					$tmp = "<br>".($i+1).".";
					
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
						$tmp .= "</label><br>";
					}
					
					$tmp .=" <a onclick=\"ans".$row[$i]['0']."()\" ><u>Đáp án</u></a></br>";
					$tmp .="<b  id=\"$i\"  readonly></b ></label>";
					//$tmp .="<br><input name=\"question_".$row[$i]['0']."\" type=\"hidden\" value=\"".$this->getAnswerCorrect($row[$i]['0'])."\" />";			
					
					$result = $result ."<br>".$tmp;	
				}
				$i++;
		}
		if ($i ==0)
			echo "Bài lý thuyết này chưa có câu hỏi nào";
		$i  =  0;
		return $result;
		
	}
	
	 function getSubjectName() 
	{
		$db =& JFactory::getDBO();
		$query = "SELECT subject_name FROM `jos_subjects`";
		$db->setQuery( $query );
		$result = $db->loadResultArray();
		return $result;
	} 
	
	function getSubjectid($subject) 
	{
	
		$db =& JFactory::getDBO();
		$query = "SELECT  subjectid FROM `jos_subjects` where `subject_name` = \"".$subject."\"";
		$db->setQuery( $query );
		$result = $db->loadResult();
		return $result;
		
	} 
	
	function getChapterName($subjectid)
	{
		
		$db =& JFactory::getDBO();
		$query = "SELECT DISTINCT chapter_name FROM #__theories WHERE subjectid = " . $subjectid;
		$db->setQuery( $query );
		$chapterName= $db->loadResultArray();
		return $chapterName;
	}
	
	function getTheoryName($chapterName)
	{
		
		$db =& JFactory::getDBO();
		$query = "SELECT theory_name FROM #__theories WHERE chapter_name = \"" . $chapterName . "\"";
		$db->setQuery( $query );
		$theoryName= $db->loadResultArray();
		return $theoryName;
	
	}
	
	function getTheoryid($theoryName)
	{
		
		$db =& JFactory::getDBO();
		$query = "SELECT theory_id FROM #__theories WHERE theory_name = \"" . $theoryName . "\"";
		$db->setQuery( $query );
		$theoryid= $db->loadResult();
		return $theoryid;
	
	}
	
	
}


?>