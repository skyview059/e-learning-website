


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
		
		if(!isset($_GET['theory'])){ 
		
		if(isset($_GET['Itemid']) ){
			$chapterNames = $model->getChapterName();
			if(isset($_GET['name'])){ 					
				$chapter = $_GET['name'];
				$index = array_search($chapter,$chapterNames);
			}else{
				$index = 0;
			}
?>
			<div class="chapterLayer">
<?php
			$i=0;
			foreach($chapterNames as $chapterName){
?>
				<table class="chapterTable">
				<tr>
<?php				
				if($i==$index){
?>
					<td width="20"><div align="center"><img src="<?php echo JPATH_URL.$this->baseurl;?>/images/red_globe.gif" width="16" height="16"></div></td>
<?php				
				}else{
?>
					<td width="20"><div align="center"><img src="<?php echo JPATH_URL.$this->baseurl;?>/images/blue_globe.gif" width="16" height="16"></div></td>
<?php					
				}
?>
					<td width="1"></td>
					<td width="259"><div class="chapterLink"><a href="<?php echo JPATH_URL.$this->baseurl;?>/index.php?option=com_theorycontent&Itemid=<?php echo $_GET['Itemid'];?>&name=<?php echo $chapterName; ?>"><?php echo $chapterName; ?></a></div></td>
				</tr>
				</table>
				<div class="endLine"><img src="<?php echo JPATH_URL.$this->baseurl;?>/images/line2.gif" width="295" height="4"></div>	
<?php
				$i++;
			}
?>
			</div>
<?php
		}
		if(isset($_GET['name'])){ 					
			$chapter = $_GET['name'];	
		}else{
			//$chapter = "Nhiệt học";
			$chapter = $chapterNames['0'];
		}
		$theoryNames = $model->getTheoryName($chapter);
?>
		<div class="theoryLayer">
<?php			
		foreach($theoryNames as $theoryName){
?>
			<table class="chapterTable">
			<tr>
				<td width="30"><div align="center"><img src="<?php echo JPATH_URL.$this->baseurl;?>/images/arrow.gif" width="16" height="16"></div></td>
				<td width="1"></td>
				<td width="310"><div class="chapterLink"><a href="<?php echo JPATH_URL.$this->baseurl;?>/index.php?option=com_theorycontent&theory=<?php echo $theoryName['0'];?>"><?php echo $theoryName['1']; ?></a></div></td>
			</tr>
			</table>
<?php		
		}
?>
		</div>
<?php			
		}else{
			$theoryid = $_GET['theory'];
			$theoryName = $model->getTheoryid($theoryid);
			echo "<div class=\"theoryContentLayer\">";
			echo "<div align=\"center\" class=\"theoryName\">".$theoryName."</div>";		
			$dat = $model->getDat();
			$video = $model->getVideo();
			
			if ($dat == "Fail")
			{	
				echo "Dữ liệu sẽ được cập nhật trong thời gian tới </br>";
			}
			
			if (isset($video) )
			{
				echo "<div> Video liên quan  </div>";
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
			echo "</div>";
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

  