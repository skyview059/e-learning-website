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

class HelloViewHello extends JView
{
	var $greeting;
	var $subjectArray;
	
	function display($tpl = null)
	{
		$sub = JRequest::getVar('subject');
		$model =& $this->getModel();
		$this->greeting = $model->getGreeting();
		$this->subjectArray = $model->getSubjectName();
		echo $sub."shit";
		
		parent::display($tpl);
	}
}