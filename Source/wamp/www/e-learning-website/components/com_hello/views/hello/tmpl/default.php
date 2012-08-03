<?php defined('_JEXEC') or die('Restricted access');?>
<form style="margin:30px 50px;" name="quesstionForm" method="post" action="<?php echo JRoute::_('index.php?option=com_hello'); ?>">
<table width="587" height="39" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
		<span> Subject: </span>
	</td>
    <td>
		<select name="subject" id="subjectID">
			<option value="0">-Select a subject-</option>
			<?php 
				$i = 0;
				foreach($this->subjectArray as $subjects)
				{
					echo "<option value=$i>".$subjects."</option>";
					$i++;
				}
			?>
		</select>
	</td>
    <td>
		<span> Chapter: </span>
	</td>
    <td>
		<select>
			<option>-Select a chapter-</option>
		</select>
	</td>
  </tr>
</table>

</form>