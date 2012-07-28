


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
		$chapter_name = "";
		$theory = "";
		if(isset($_POST["subject"]))
		{$subject = $_POST["subject"];}
		
		if(isset($_POST["num"]))
		{$num = $_POST["num"];}
		
		if(isset($_POST["chapter_name"]))
		{$chapter_name = $_POST["chapter_name"];}
		
		if(isset($_POST["theory"]))
		{$theory = $_POST["theory"];}
		
		if($subject != ""  && $chapter_name != "" && $theory != "" && $num != ""){
			$theoryid = $model->get_theory_id($theory);
			$question = $model->getQuestion($theoryid,$num);
			if (isset($question))
			{
				echo "<b>Bạn đang làm bài tập môn <u>".$subject."</u> chương <u>". $chapter_name. "</u> bài <u>" .$theory.  "</u> </b><br />";
				echo( $question );
				echo "<a href=\"/e-learning-website/index.php?option=com_excercisecontent&view=excerciseContent&Itemid=17\">Back</a>";	
			}	 	
			
		}else{
			echo "<form action=\"\" method=\"post\">";
			echo "Môn học :<select name=\"subject\">";
			echo "<option></option>";
			$all_subject =  $model->get_subject_name() ;
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
				$subject_id = $model->get_subject_ID($subject) ;
				echo "</br>Chương :<select name=\"chapter_name\" >";
				echo "<option></option>";
				$all_chapter =  $model->get_chapter_name($subject_id) ;
				$i = 0;
				while($all_chapter[$i]!= ""){
					if ($chapter_name == $all_chapter[$i]) 
					{
						echo "<option selected=\"selected\">".$all_chapter[$i]."</option>";
					} else{
						echo "<option>".$all_chapter[$i]."</option>";
					}
					$i++;
				}	
				echo "		</select>";
					
			}
			
			if($subject !="" && $chapter_name != "")
			{
				echo "</br>Bài :<select name=\"theory\" >";
				echo "<option></option>";
				$all_theory =  $model->get_theory_name($chapter_name) ;
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
			
			echo "</br>		</select>";
			echo "Số lượng câu hỏi :<select name=\"num\">";
			echo "<option></option>";
			echo "<option>1</option>";
			echo "<option>5</option>";
			echo "<option>10</option>";
			echo "<option>15</option>";
			echo "		</select>";
			echo "<input type=\"submit\" value=\"Tiếp tục\"/>";
			echo "</form>";
			
			echo"Subject = " . $subject . " Chapter = " . $chapter_name . " Theory = " . $theory;
			
		}
		 
		
		parent::display($tpl);	
		
		
	}
	
	
}
?>

  