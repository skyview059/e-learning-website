


<?php
/**
 * @package    Joomla
 * @subpackage Components
*/

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the TheoryContent Component
 *
 * @package    TheoryContent
 */

class TheoryContentViewTheoryContent extends JView
{
	function display($tpl = null)
	{
		$model =& $this->getModel();
		
		
		if(isset($_GET['Itemid']) ){
			$chapterNames = $model->getChapterName();
			foreach($chapterNames as $chapterName){
			echo "<h3><a href=\"".JPATH_URL.$this->baseurl."/index.php?option=com_theorycontent&Itemid=".$_GET['Itemid']."&name=$chapterName\"\">" . $chapterName . "</a></h3>";		
			}
		}
		
		if(isset($_GET['name'])){ 	
				
			$theorynames = $model->getTheoryName();
			foreach($theorynames as $theoryname){
				echo "<h4><a href=\"".JPATH_URL.$this->baseurl."/index.php?option=com_theorycontent&theory=".$theoryname['0']."\"\">" . $theoryname['1'] . "</a></h4>";	
			}
		}
		
			
		if(isset($_GET['theory'])){ 
		
			$theoryid = $_GET['theory'];
			$theoryName = $model->getTheoryid($theoryid);
			
			echo "<h4><a href=\"".JPATH_URL.$this->baseurl."/index.php?option=com_theorycontent&theory=$theoryid\"\">" . $theoryName . "</a></h4>";		
			$dat = $model->getDat();
			$video = $model->getVideo();
			
			if ($dat == "Fail")
			{	
				echo "Dữ liệu sẽ được cập nhật trong thời gian tới </br>";
			}
			
			if (isset($video) )
			{
				echo "<h4> Video liên quan  </h4>";
			?>	
			<link href="<?php echo JPATH_URL.$this->baseurl; ?>/data//video-js/video-js.css" rel="stylesheet">
			<script src="<?php echo JPATH_URL.$this->baseurl; ?>/data/video-js/video.js"></script>
			
			<video id="my_video_1" class="video-js vjs-default-skin" controls
			preload="auto" width="480" height="300" poster="my_video_poster.png"
			data-setup="{}">
			  <source src="<?php echo $video ?>" type='video/flv'>
			</video>
			<?php	
			}
			
			$question = $model->getQuestion($theoryid,5);
			if (isset($question) )
			{	
				echo $question;
			}
			
			
			
				
		}
		parent::display($tpl);	
		
		
	}
}
?>

  