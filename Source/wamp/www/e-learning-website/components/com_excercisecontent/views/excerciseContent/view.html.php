


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
		if(isset($_POST["subject"]) and isset($_POST["num"]))
		{
			$subject = $_POST["subject"];
			$num = $_POST["num"];
		}
		 
		if($subject != "" && $num != ""){
			echo "<b>Bạn đang làm bài tập môn ".$subject."</b><br />";
			$subject_id = $model->get_subject_ID($subject) ;
			if (isset($subject_id))
			{
				$question = $model->getQuestion($subject_id,$num);
				if (isset($question))
				{
					echo( $question );
				} 
			}
			
			
		}else{
			echo "<form action=\"\" method=\"post\">";
			echo "Mã môn học :<select name=\"subject\">";
			echo "<option></option>";
			$all_subject =  $model->get_subject_name() ;
			$i = 0;
			while($all_subject[$i]!= ""){
				echo "<option>".$all_subject[$i]."</option>";
				$i++;
			}	
			echo "		</select>";
			echo "Số lượng câu hỏi :<select name=\"num\">";
			echo "<option></option>";
			echo "<option>1</option>";
			echo "<option>5</option>";
			echo "<option>10</option>";
			echo "<option>15</option>";
			echo "		</select>";
			echo "<input type=\"submit\" value=\"Làm  bài\"/>";
			echo "</form>";
 		}
		
		parent::display($tpl);	
		
		
	}
}
?>

  