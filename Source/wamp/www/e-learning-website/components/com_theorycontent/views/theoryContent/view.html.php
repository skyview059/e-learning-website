


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

class theorycontentViewtheoryContent extends JView
{
	function display($tpl = null)
	{
		$model =& $this->getModel();
		$content = $model->getContent();
		$this->assignRef( 'content',$content );
		
		$theoryName = $model->getTheoryName();
		$this->assignRef( 'theoryName',$theoryName );
		
		parent::display($tpl);	
		$dat = $model->getDat();
		
		?>
		
		<link href="http://localhost/thu%20vien%20ly%20thuyet/video-js/video-js.css" rel="stylesheet">
		<script src="http://localhost/thu%20vien%20ly%20thuyet/video-js/video.js"></script>
		
		<video id="my_video_1" class="video-js vjs-default-skin" controls
	  	preload="auto" width="480" height="300" poster="my_video_poster.png"
	  	data-setup="{}">
		  <source src="<?php echo $content ?>" type='video/flv'>
		</video>
		<?php
	}
}
?>

  