<?php
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class ExercisesController extends JController
{
	function display()
	{
		parent::display();
	}
	
	function displayFull(){
		$subjectName = JRequest::getVar('subjectName');
		$chapterName = JRequest::getVar('chapterName');
		$theoryName = JRequest::getVar('theoryName');
		//echo "<br> In Controller<br>subjectName = ".$subjectName."<br> chapterName = ".$chapterName."<br> theoryName = ".$theoryName."<br>";
		
		$document =& JFactory::getDocument();

		$viewType	= $document->getType();
		$viewName	= JRequest::getCmd( 'view', $this->getName() );
		// sets the template to ExerciseView
		$viewLayout	= JRequest::getCmd( 'layout', 'exercise' );
		// sets the view to someview.html.php
		$view = & $this->getView($viewName,$viewType, '', array( 'base_path'=>$this->_basePath));
		// Get/Create the model
		if ($model = & $this->getModel($viewName)) {
			// Push the model into the view (as default)
			$view->setModel($model, true);		
		}
		// Set the layout
		$view->setLayout($viewLayout);

		// go off to the view and call the displaySomeView() method, also pass in $var variable
		$view->displayFull($subjectName,$chapterName,$theoryName);
	}
	
	function getChapter()
	{
		global $mainframe;
		$subjectName=JRequest::getVar('subjectName');
		$model = $this->getModel('exercises');
		
		$subjectID = $model->getSubjectId($subjectName);
		$chapterArray = $model->getChapterArray($subjectID);
		echo "<select name=\"chapterName\" onchange=\"getTheory(this.value)\" style=\"width: 310px\">";
		echo "<option value=\"\">Chọn một chương bất kì</option>";
		for($i=0;$i<count($chapterArray);$i++)
		{
			echo "<option value=\"".$chapterArray[$i]."\">".$chapterArray[$i]."</option>";
		}
		echo "</select>";
		$mainframe->close();
	}
	function getTheory()
	{
		global $mainframe;
		$chapterName=JRequest::getVar('chapterName');
		$model = $this->getModel('exercises');
		
		$theoryArray = $model->getTheoryArray($chapterName);
		/* onchange=\"this.form.submit()\"*/
		echo "<select name=\"theoryName\" style=\"width: 310px\">";
		echo "<option value=\"\">Chọn một bài học</option>";
		for($i=0;$i<count($theoryArray);$i++)
		{
			echo "<option value=\"".$theoryArray[$i]."\">".$theoryArray[$i]."</option>";
		}
		echo "</select>";
		$mainframe->close();
	}
}