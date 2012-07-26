

<?php
/**
 * Excercise Content Model for ExcerciseContent Component
 * 
 * @subpackage Components
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );


class excerciseContentModelexcerciseContent extends JModel
{
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
		$result = "";
		
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
	
	 function get_subject_name() 
	{
		$db =& JFactory::getDBO();
		$query = "SELECT subject_name FROM `jos_subjects`";
		$db->setQuery( $query );
		$result = $db->loadResultArray();
		return $result;
	} 
	
	function get_subject_ID($subject) 
	{
	
		$db =& JFactory::getDBO();
		$query = "SELECT  subjectid FROM `jos_subjects` where `subject_name` = \"".$subject."\"";
		$db->setQuery( $query );
		$result = $db->loadResult();
		return $result;
		
	} 
	
}


?>