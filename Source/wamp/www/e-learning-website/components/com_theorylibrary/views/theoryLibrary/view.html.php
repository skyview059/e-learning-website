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

class theoryLibraryViewtheoryLibrary extends JView
{
	function display($tpl = null)
	{
		$model =& $this->getModel();
		$subjectArray = $model->getSubject();
		$this->assignRef( 'subjects',	$subjectArray );
		
		$subjectImageArray = $model->getSubjectImage();
		$this->assignRef( 'subjectImage',  $subjectImageArray);
		
		$numOfSubject = $model->getNumOfSubject();
		$this->assignRef( 'numOfSubject',  $numOfSubject);
		
		$chapterNameArray = $model->getChapterNameArray();
		$this->assignRef( 'chapterNameArray',  $chapterNameArray);
		
		parent::display($tpl);
	}
}