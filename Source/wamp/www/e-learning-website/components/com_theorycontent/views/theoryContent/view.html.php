


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
		
		
		if(isset($_GET['Itemid'])){
			$chapterNames = $model->getChapterName();
			foreach($chapterNames as $chapterName){
			echo "<h4><a href=\"/e-learning-website/index.php?option=com_theorycontent&name=$chapterName\"\">" . $chapterName . "</a></h4>";		
			}
		}
		
		if(isset($_GET['name'])){ 		
			$theorynames = $model->getTheoryName();
			foreach($theorynames as $theoryname){
				echo "<h4><a href=\"/e-learning-website/index.php?option=com_theorycontent&theory=".$theoryname['0']."\"\">" . $theoryname['1'] . "</a></h4>";	
			}
		}
		
			
		if(isset($_GET['theory'])){ 
		
			$theoryid = $_GET['theory'];
			$theory_name = $model->getTheoryid($theoryid);
			
			echo "<h4><a href=\"/e-learning-website/index.php?option=com_theorycontent&theory=$theoryid\"\">" . $theory_name . "</a></h4>";		
			$dat = $model->getDat();
			$video = $model->getVideo();
			
			if (isset($video) )
			{
				echo "<h4> Video liên quan  </h4>";
			?>	
			<link href="/e-learning-website/data//video-js/video-js.css" rel="stylesheet">
			<script src="/e-learning-website/data/video-js/video.js"></script>
			
			<video id="my_video_1" class="video-js vjs-default-skin" controls
			preload="auto" width="480" height="300" poster="my_video_poster.png"
			data-setup="{}">
			  <source src="<?php echo $video ?>" type='video/flv'>
			</video>
			<?php	
			}
			$question = $model->getQuestion($theoryid,5);	
		}
		parent::display($tpl);	
		
		
	}
}
?>

  