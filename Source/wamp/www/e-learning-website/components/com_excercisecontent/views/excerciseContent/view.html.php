


<?php
/**
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_2
 * @license    GNU/GPL
	*/

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the HelloWorld Component
 *
 * @package    HelloWorld
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
		if(isset($_POST["subject"]))
		{$subject = $_POST["subject"];}
		
		if(isset($_POST["num"]))
		{$num = $_POST["num"];}
		
		if(isset($_POST["chapterName"]))
		{$chapterName = $_POST["chapterName"];}
		
		if(isset($_POST["theory"]))
		{$theory = $_POST["theory"];}
		
		if($theory != "" && $num != ""){
			$theoryid = $model->getTheoryid($theory);
			$question = $model->getQuestion($theoryid,$num);
			if (isset($question))
			{
				echo "<b>Bạn đang làm bài tập môn <u>".$subject."</u> chương <u>". $chapterName. "</u> bài <u>" .$theory.  "</u> </b><br />";
				echo( $question );
				echo "<a href=\"/e-learning-website/index.php?option=com_excercisecontent&view=excerciseContent&Itemid=17\">Back</a>";	
			}	 	
			
		}else{
		
			if ($subject == "" && $chapterName =="" && $theory == "" && $num == ""){
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
			}
			
			
			
			if($subject != "" && $chapterName =="" && $theory == "" && $num == "")
			{
				$subject_id = $model->getSubjectid($subject) ;
				echo "Môn học : " . $subject . "</br>";
				echo "Chương :<select name=\"chapterName\" >";
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
				echo "</br>Bài :<select name=\"theory\" >";
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
//			
//			echo "</br>		</select>";
//			echo "Số lượng câu hỏi :<select name=\"num\">";
//			echo "<option></option>";
//			echo "<option>1</option>";
//			echo "<option>5</option>";
//			echo "<option>10</option>";
//			echo "<option>15</option>";
//			echo "		</select>";
			echo "<input type=\"submit\" value=\"Tiếp tục\"/>";
			echo "</form>";
			
			echo"Subject = " . $subject . " Chapter = " . $chapterName . " Theory = " . $theory;
			
		}
		 
		
		parent::display($tpl);	
		
		
	}
	
	
}
?>

  