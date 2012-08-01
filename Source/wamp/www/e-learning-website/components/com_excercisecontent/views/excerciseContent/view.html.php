


<?php
/**
 * @package    Joomla.Tutorials
 * @subpackage Components
	*/

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the Excercise Content Component
 *
 * @package    Excercise Content
 */

class excercisecontentViewexcerciseContent extends JView
{
	function display($tpl = null)
	{
		echo ("</br>");
		$model =& $this->getModel();
		
		$subject ="";
		$num = "";
		$chapterName = "";
		$theory = "";
		$difficulty = "";
		if(isset($_POST["subject"]))
		{$subject = $_POST["subject"];}
		
		if(isset($_POST["num"]))
		{$num = $_POST["num"];}
		
		if(isset($_POST["chapterName"]))
		{$chapterName = $_POST["chapterName"];}
		
		if(isset($_POST["theory"]))
		{$theory = $_POST["theory"];}
		
		if(isset($_POST["difficulty"]))
		{$difficulty = $_POST["difficulty"];}
		
		if($theory != "" && $num != ""  && isset($_POST["difficulty"])){
			$theoryid = $model->getTheoryid($theory);
			$question = $model->getQuestion($theoryid,$num,$difficulty);
			
			if (isset($question) && $question != "")
			{
				echo "<b>Bạn đang làm bài tập môn <u>".$subject."</u> chương <u>". $chapterName. "</u> bài <u>" .$theory.  "</u>";
				if ($difficulty != "")
				    echo  "với độ khó là <u>". $difficulty."</u></b><br />";
				else
					echo "</b><br />";
				echo( $question );
				echo "<a href=\"".JPATH_URL.$this->baseurl."/index.php?option=com_excercisecontent&view=excerciseContent&Itemid=17\">Back</a>";
					
			}	 	
			
		}else{
		
				echo "<form action=\"\" method=\"post\">";
				echo "Môn học :<select name=\"subject\">";
				echo "<option></option>";
				$all_subject =  $model->getSubjectName() ;
				$i = 0;
				while($all_subject[$i]!= ""){
					if ($subject == $all_subject[$i]) 
					{	
						echo "<option selected=\"selected\">".$all_subject[$i]."</option>";
					} else{
						echo "<option >".$all_subject[$i]."</option>";
					}
					$i++;
				}	
				echo "		</select>";
			
			
			
			if($subject != "")
			{
				$subject_id = $model->getSubjectid($subject) ;
				echo "</br>Chương :<select name=\"chapterName\" >";
				echo "<option></option>";
				$all_chapter =  $model->getChapterName($subject_id) ;
				$i = 0;
				while($all_chapter[$i]!= ""){
					if ($chapterName == $all_chapter[$i]) 
					{
						echo "<option selected=\"selected\">".$all_chapter[$i]."</option>";
					} else{
						echo "<option>".$all_chapter[$i]."</option>";
					}
					$i++;
				}	
				echo "		</select>";
					
			}
			
			if($subject !="" && $chapterName != "")
			{
				echo "</br>Bài      :<select name=\"theory\" >";
				echo "<option></option>";
				$all_theory =  $model->getTheoryName($chapterName) ;
				$i = 0;
				while($all_theory[$i]!= ""){
					if ($theory == $all_theory[$i]) 
					{
						echo "<option selected=\"selected\">".$all_theory[$i]."</option>";
					} else{
						echo "<option>".$all_theory[$i]."</option>";
					}
					$i++;
				}	
				echo "		</select>";		
			}
			
			if($subject !="" && $chapterName != "" && $theory != "")
			{
				$tmp = array (1,5,10,15);
				echo "</br>		</select>";
				echo "Số lượng câu hỏi :<select name=\"num\">";
				echo "<option></option>";
				$i = 0;
				while($tmp[$i]!= ""){
					if ($num == $tmp[$i]) 
					{
						echo "<option selected=\"selected\">".$tmp[$i]."</option>";
					} else{
						echo "<option>".$tmp[$i]."</option>";
					}
					$i++;
				}	
				echo "		</select>";
			}
			
			if($subject !="" && $chapterName != "" && $theory != "" && $num != "")
			{
				$tmp = array (1,2,3,4,5);
				echo "</br>		</select>";
				echo "Độ khó :<select name=\"difficulty\">";
				echo "<option></option>";
				$i = 0;
				while($tmp[$i]!= ""){
					echo "<option>".$tmp[$i]."</option>";
					$i++;
				}
				echo "		</select>";
			}
			echo "<input type=\"submit\" value=\"Tiếp tục\"/>";
			echo "</form>";
			if($subject != "")
				echo "<a href=\"".JPATH_URL.$this->baseurl."/index.php?option=com_excercisecontent&view=excerciseContent&Itemid=17\">Back</a>";
		}
		 
		
		parent::display($tpl);	
		
		
	}
	
	
}
?>

  