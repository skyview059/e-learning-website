<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

class Exercise{
	var $subjectName;
	var $chapterName;
	var $theoryName;
	var $exerciseID;
	var $question;
	var $answers;
	var $key;
	
	function display(){
?>
		<div class="exercise">
			<script type="text/javascript">
				function key<?php echo $this->exerciseID;?>()
				{	
					document.getElementById("key<?php echo $this->exerciseID;?>").innerHTML="<span>Đáp án là : <?php echo "<b>".chr($this->key+64).". </b>".$this->answers[$this->key-1];?></span>";  
				}
			</script>
			<span style="font-weight:bold;font-size:17px;color:blue;"> Bài&nbsp;<?php echo $this->exerciseID; ?></span>
			<br><br>
			<?php echo $this->question; ?>
			<br>
<?php 
				for($answerNumber=0;$answerNumber<count($this->answers);$answerNumber++){
?>
					<input type="radio" name="<?php echo "ques".$this->exerciseID;?>" value="<?php echo $this->answers[$answerNumber];?>"><span><?php echo "<b>".chr($answerNumber+65).".</b> ".$this->answers[$answerNumber]."<br>";?></span>
<?php
				}
?>			
			<br>
			<button id="<?php echo "ques".$this->exerciseID;?>" onclick="key<?php echo $this->exerciseID;?>()"> Xem đáp án </button>
			<br><br>
			<div id="key<?php echo $this->exerciseID;?>"></div>
		</div>
<?php
	}
}

class ExercisesModelExercises extends JModel
{
	//get key of a question by pass a question ID
	function getKey($questionId) 
	{
		$db =& JFactory::getDBO();
		$query = "SELECT answer_text FROM #__answers WHERE questionid = '".$questionId."' AND answer_correct = 1";
		$db->setQuery( $query );
		$key = $db->loadResult();
		return $key;
	} 
	
	//get all answers of a question
	function getAnswerArray($questionId) 
	{
		$db =& JFactory::getDBO();
		$query = "SELECT answer_text FROM #__answers WHERE questionid = '".$questionId."'";
		$db->setQuery( $query );
		$answerArray = $db->loadResultArray();
		return $answerArray;
	} 
	
	//get all subjects
	function getSubjectArray() 
	{
		$db =& JFactory::getDBO();
		$query = "SELECT subject_name FROM #__subjects";
		$db->setQuery( $query );
		$subjectArray = $db->loadResultArray();
		return $subjectArray;
	}
	
	//get subject ID from DB by passing subject name
	function getSubjectId($subjectName) 
	{
		$db =& JFactory::getDBO();
		$query = "SELECT  subjectid FROM #__subjects where subject_name = \"".$subjectName."\"";
		$db->setQuery( $query );
		$result = $db->loadResult();
		return $result;
	} 
	
	function getTheoryID($theoryName)
	{
		$db =& JFactory::getDBO();
		$query = "SELECT theory_id FROM #__theories WHERE theory_name = \"" . $theoryName . "\"";
		$db->setQuery( $query );
		$theoryID= $db->loadResult();
		return $theoryID;
	}
	
	//get chapter array
	function getChapterArray($subjectId)
	{
		$db =& JFactory::getDBO();
		$query = "SELECT DISTINCT chapter_name FROM #__theories WHERE subjectid = ".$subjectId;
		$db->setQuery( $query );
		$chapterArray= $db->loadResultArray();
		return $chapterArray;
	}
	
	//get theory array
	function getTheoryArray($chapterName)
	{
		$db =& JFactory::getDBO();
		$query = "SELECT theory_name FROM #__theories WHERE chapter_name = \"".$chapterName."\"";
		$db->setQuery( $query );
		$theoryArray = $db->loadResultArray();
		return $theoryArray;
	}
	//get exercise depend on subject name, chapter name, theory name anhd difficulty level
	function getExerciseArray($subjectID,$chapterName,$theoryID,$difficulty)
	{
		$exerciseArray=array(); 
		$db =& JFactory::getDBO();
		//Connect databse table question
		
		//Get parameter
		$str = "";
		if($theoryID!=""){
			$str = " WHERE theory_id = ".$theoryID;
		}else if ($chapterName!=""){
			$str = " WHERE chapter_name = \"".$chapterName."\"";
		}else if ($subjectID!=""){
			$str = " WHERE subjectid = ".$subjectID;
		}
		if($str==""){
			$query = "SELECT * FROM #__questions ORDER BY RAND() LIMIT 0";
		}else{
			$query = "SELECT * FROM #__questions ".$str;
		}
		//echo "<br>************<br>query = ".$query."<br>******************<br>";
		$db->setQuery($query);
		$row = $db->loadRowList();
		
		for ($i=0;$i<sizeof($row);$i++)
		{
			$exercise = new Exercise();
			//Load exerciseID
			$exercise->exerciseID = $row[$i]['0'];
			//Load question text. In table jos_question, question text is in column 5
			$exercise->question = $row[$i]['5'];
			//Load answers
			//Connect databse table answers
			$query = "SELECT answerid, answer_text, answer_correct FROM #__answers WHERE questionid = ".$row[$i]['0']." ORDER BY RAND()";
			$db->setQuery($query);
			$answer = $db->loadRowList();
			
			for($j=0;$j<sizeof($answer);$j++){
				//Load answers text
				$exercise->answers[$j] = $answer[$j]['1'];
				//Load answer key - answer correct
				if($answer[$j]['2']==1){
					$exercise->key = $j+1;
				}
			}
			//Insert exercise into exercise array
			$exerciseArray[$i] = $exercise;
			unset($exercise);
		}
		/*for($k=0;$k<count($exerciseArray);$k++){
			echo "<br> Exe ".($k+1)."***".$exerciseArray[$k]->exerciseID."<br>";
			echo "<br>".$exerciseArray[$k]->question."<br>************************************************************************************************************************<br>";
			for($z=0;$z<count($exerciseArray[$k]->answers);$z++)
				echo "Answer ".($z+1)." : ".$exerciseArray[$k]->answers[$z]."<br>";
			echo "<br> Key :".$exerciseArray[$k]->key."***<br>";
		}*/
		return $exerciseArray;
	}
}