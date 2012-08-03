<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php
	for($i = 0; $i<$this->numOfSubject; $i++)
	{  
?>	
		<div class="Layer">
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
					$j=0;
					foreach($chapter as $chapterName)
					{
						if($j==4)
						{
							break;
						}
?>
						<div class="chapterName">
							<div>
								<a href="<?php echo $this->baseurl; ?>/index.php?option=com_theorycontent&name=<?php echo $chapterName; ?>"><?php echo $chapterName; ?></a>
							</div>
						</div>
<?php
						$j++;
					}
				}
			}
?>
		</div>
<?php
	}
?>