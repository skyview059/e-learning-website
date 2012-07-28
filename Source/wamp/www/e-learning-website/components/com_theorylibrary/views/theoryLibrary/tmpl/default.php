<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php
	for($i = 0; $i<$this->numOfSubject; $i++)
	{  
		if($i%2==1)
		{
			$strLayer = "Layer2";
		}else{
			$strLayer = "Layer1";
		}
?>	
		<div class="<?php echo $strLayer; ?>">
			<div class="subjectImage">
				<img src="<?php echo JPATH_URL.$this->baseurl.$this->subjectImage[$i]; ?>" alt="<?php echo $this->subjects[$i]; ?>">
			</div>
			<div class="subjectName">
				<a href="<?php echo JPATH_URL.$this->baseurl; ?>/index.php?option=com_theorycontent&view=theoryContent&Itemid=<?php echo $i+19; ?>">
					<?php echo $this->subjects[$i]; ?>
				</a>
			</div>	
<?php
			foreach ($this->chapterNameArray as $subject=>$chapter)
			{
				if($subject==$this->subjects[$i])
				{
					foreach($chapter as $chapterName)
					{
?>
						<div class="chapterName"><a href="<?php echo $this->baseurl; ?>/index.php?option=com_theorycontent&name=<?php echo $chapterName; ?>"><?php echo $chapterName; ?></a></div>
<?php
					}
				}
			}
?>
		</div>
<?php
	}
?>