<?php
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class ExercisesViewExercises extends JView
{
	function display($tpl = null)
	{
		$model =& $this->getModel();
		
		$subjectArray = $model->getSubjectArray();
		$this->assignRef( 'subjectArray', $subjectArray );
		
		$exerciseArray = $model->getExerciseArray("","","","");
		$this->assignRef( 'exerciseArray', $exerciseArray );
		
		parent::display($tpl);
	}
	function displayFull($subjectName,$chapterName,$theoryName,$tpl = null)  {
		//fetch the model assigned to this view by the controller
		$model = $this->getModel();
		//echo "<br>In View<br>subjectName = ".$subjectName." chapterName = ".$chapterName." theoryName = ".$theoryName."<br>";
		
		$subjectID = $model->getSubjectId($subjectName);
		$theoryID = $model->getTheoryID($theoryName);
		
		$exerciseArray = $model->getExerciseArray($subjectID,$chapterName,$theoryID,"");
		$this->assignRef( 'exerciseArray', $exerciseArray );
		$subjectArray = $model->getSubjectArray();
		$this->assignRef( 'subjectArray', $subjectArray );
		
		$empty = "";
		
		if($subjectName==""){										//Chưa chọn môn => Chưa chọn gì
			$this->assignRef( 'subject', $empty );
			$this->assignRef( 'chapter', $empty);
			$this->assignRef( 'chapterArray', $empty);
			$this->assignRef( 'theory', $empty);
			$this->assignRef( 'theoryArray', $empty);
		}else{														//Đã chọn môn => Có môn học và chapterArray
			$this->assignRef( 'subject', $subjectName );
			$chapterArray = $model->getChapterArray($subjectID);
			$this->assignRef( 'chapterArray', $chapterArray );
			if($chapterName==""){									//Chưa chọn chapter => chưa có chapter, theory và theoryArray
				$this->assignRef( 'chapter', $empty);
				$this->assignRef( 'theory', $empty);
				$this->assignRef( 'theoryArray', $empty);
			}else{													//Đã chọn chapter => Có chapterName và theoryArray
				$this->assignRef( 'chapter', $chapterName);
				$theoryArray = $model->getTheoryArray($chapterName);
				$this->assignRef( 'theoryArray', $theoryArray );
				if($theoryName==""){								//Chưa chọn theory	
					$this->assignRef( 'theory', $empty);
				}else{												//Đã chọn theory => Có theoryName
					$this->assignRef( 'theory', $theoryName);
				}
			}
		}
		
		// call the parent class constructor in order to display the tmpl
		parent::display($tpl);
	}
	
	function search($search,$tpl = null)  {
		//fetch the model assigned to this view by the controller
		$model = $this->getModel();
		
		$subjectArray = $model->getSubjectArray();
		$this->assignRef( 'subjectArray', $subjectArray );
		
		$searchExercise = $model->getExerciseSearch($search);
		$this->assignRef( 'searchExercise', $searchExercise );
		// call the parent class constructor in order to display the tmpl
		parent::display($tpl);
	}
}