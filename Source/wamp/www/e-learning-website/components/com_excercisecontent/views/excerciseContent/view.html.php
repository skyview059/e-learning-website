


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

class ExcerciseContentViewExcerciseContent extends JView
{

	function display($tpl = null)
	{
	
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
		
		if($subject != "" && $chapterName != "" && $theory != "" && $num != ""  && isset($_POST["difficulty"]) && isset($_POST["go"]) ){
			
			//$theoryid = $model->getTheoryid($theory);
			//$chaptername = $model->getTheoryid($theory);
			$question = $model->getQuestion($chapterName,$num,$difficulty);
			
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
				?>
				</br>
				<div>
				<div class="exerciseLayer">Tìm kiếm bài tập</div>
				<div class="exerciseContent">
				<?php 
				echo "<form action=\"\" method=\"post\" align=\"left\" style =\"margin-left: 1000\" >";
				echo "Môn học: <select name=\"subject\" onchange=\"this.form.submit()\" style=\"width: 100px\"";
				echo ">";
				
				$allSubject =  $model->getSubjectName() ;
				$i = 0;
				if ($subject !="")
					echo "<option selected=\"selected\">".$subject."</option>";
				else
				{
					echo "<option></option>";
					while($allSubject[$i]!= ""){
						echo "<option >".$allSubject[$i]."</option>";
						$i++;
					}
				}	
				echo "		</select>";
				
				$subjectid = $model->getSubjectid($subject) ;
				echo "</br>Chương: &nbsp;<select name=\"chapterName\" onchange=\"this.form.submit()\" style=\"width: 300px\">";
				$allChapter =  $model->getChapterName($subjectid) ;
				$i = 0;
				if ($chapterName !="")
					echo "<option selected=\"selected\">".$chapterName."</option>";
				else
				{
					echo "<option></option>";
					while($allChapter[$i]!= ""){
						echo "<option>".$allChapter[$i]."</option>";
						$i++;
					}	
				}
				echo "		</select>";
					
		
			
				echo "</br>Bài: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<select name=\"theory\" onchange=\"this.form.submit()\" style=\"width: 300px\">";
				
				$allTheory =  $model->getTheoryName($chapterName) ;
				$i = 0;
				if ($theory !="")
					echo "<option selected=\"selected\">".$theory."</option>";
				else
				{
					echo "<option></option>";
					while($allTheory[$i]!= ""){
						if ($theory == $allTheory[$i]) 
						{
							echo "<option selected=\"selected\" >".$allTheory[$i]."</option>";
						} else{
							echo "<option>".$allTheory[$i]."</option>";
						}
						$i++;
					}	
				}
				echo "		</select>";		
				
				$num = array (1,5,10,15,20);
				$numDefault = 10;
				echo "</br>		</select>";
				echo "Số lượng câu hỏi:  <select name=\"num\" style=\"width: 50px\">";
				$i = 0;
				while($num[$i]!= ""){
					if ($num[$i] == $numDefault) 
					{
						echo "<option selected=\"selected\">".$num[$i]."</option>";
					} else{
						echo "<option>".$num[$i]."</option>";
					}
					$i++;
				}	
				
				echo "		</select>";
				?>
					<div class = "exerciseSuggest">các giá trị lựa chọn là 5, 10 ,15, 20</div>
				<?php
				$diff = array (1,2,3,4,5);
				$diffDefault = 3;
				echo "</select>";
				echo "Độ khó: &nbsp;&nbsp<select name=\"difficulty\" style=\"width: 50px\">";
				$i = 0;
				while($diff[$i]!= ""){
					if ($diff[$i] == $diffDefault) 
					{
						echo "<option selected=\"selected\">".$diff[$i]."</option>";
					} else{
						echo "<option>".$diff[$i]."</option>";
					}
					
					$i++;
				}
				echo "		</select>";
				?>
					<div class = "exerciseSuggest">có 5 mức từ 1 -> 5 tương ứng độ khó tăng dần</div>
				<?php
				echo "<input class = \"exerciseSearch\" name=\"go\" type=\"submit\" value=\"Tiếp tục\"/>";
			echo "</form>";
			if($subject != "")
				echo "<a href=\"".JPATH_URL.$this->baseurl."/index.php?option=com_excercisecontent&view=excerciseContent&Itemid=17\">Back</a>";			
					?>
				</div>
				</div>
				<?php 
				
		}
		 
		
		parent::display($tpl);	
		
		
	}
	
	
}
?>

  