


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
<<<<<<< .mine
		
		
		if(isset($_GET['Itemid'])){
			$chapterName = $model->getChapterName();
		
		}
		
		if(isset($_GET['name'])){ 
		
			$theoryName = $model->getTheoryName();
		}
		
			
		if(isset($_GET['theory'])){ 
		
			$theory=$_GET['theory'];
			echo "<h4><a href=\"index.php?option=com_theorycontent&theory=$theory\"\">" . $theory . "</a></h4>";		
			$dat = $model->getDat();
			$video = $model->getVideo();
			
			?>	
			<link href="http://localhost/thu%20vien%20ly%20thuyet/video-js/video-js.css" rel="stylesheet">
			<script src="http://localhost/thu%20vien%20ly%20thuyet/video-js/video.js"></script>
			
			<video id="my_video_1" class="video-js vjs-default-skin" controls
			preload="auto" width="480" height="300" poster="my_video_poster.png"
			data-setup="{}">
			  <source src="<?php echo $video ?>" type='video/flv'>
			</video>
			<?php		
		}
		parent::display($tpl);	
=======
>>>>>>> .r223
		$file = fopen($dat, "r") or exit("Unable to open file!");
		//Output a line of the file until the end is reached
		while(!feof($file)){
			  $buf = fgets($file);
			  $output[] = $buf;
		}
		fclose($file);
		for($i=0; $i<sizeof($output); $i++)
		{
				echo  $output[$i] . "<br/>";
		}

		parent::display($tpl);
		
<<<<<<< .mine
=======
		<link href="http://localhost/thu%20vien%20ly%20thuyet/video-js/video-js.css" rel="stylesheet">
		<script src="http://localhost/thu%20vien%20ly%20thuyet/video-js/video.js"></script>
		 <video id="my_video_1" class="video-js vjs-default-skin" controls
		  preload="auto" width="480" height="300" poster="my_video_poster.png"
		  data-setup="{}">
			  <source src="<?php $content  ?>" type='video/flv'>
			</video>
			<?php
			
>>>>>>> .r223
	}
}


?>

  