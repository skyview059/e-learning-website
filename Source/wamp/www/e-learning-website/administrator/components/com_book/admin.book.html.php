<?php
class HTML_book{
function addBook($lists){
  $editor =& JFactory::getEditor();
  JHTML::_('behavior.calendar');
?>
   <script type="text/javascript"src="includes/js/calendar/calendar.js"></script>
   <script type="text/javascript" src="includes/js/calendar/lang/calendar-en.js"></script>
   <form action="index.php" method="post" enctype="multipart/form-data"name="adminForm">
	<table class="admintable">
		<tr>
			<td class="key">
				<label for="message">
				<?php echo JText::_( 'Title' ); ?>: </label>
			</td>
			<td >
				<input class="text_area" type="text"name="title" id="title" size="100" maxlength="255">    
			</td>
		</tr>
		<tr>
			<td class="key">
				<label for="message">
				<?php echo JText::_( 'Picture' ); ?>: </label>
			</td>
			<td >
				<input class="text_area" type="file"name="picture" id="title" size="80" maxlength="255">    </td>
			</tr>
			<tr>
				<td class="key"><label for="message">
				<?php echo JText::_( 'Author' ); ?>: </label></td>
				<td ><input class="text_area" type="text"name="author" id="author" size="50" maxlength="255"></td>
			</tr>
			<tr>
				<td class="key">
					<label for="message"><?php echo JText::_( 'Date publish' ); ?>: </label>
				</td>
				<td >
					<input class="text_area" type="text" name="publish_date"id="publish_date" size="25" maxlength="255">
					<a href="#" onclick="return showCalendar('publish_date', '%Y-%m-%d');">
					<img class="calendar"src="templates/system/images/calendar.png" alt="calendar" />
					</a>
				</td>
			</tr>
			<tr>
				<td class="key">
					<label for="message"><?php echo JText::_( 'Synopsis' ); ?>: </label>
				</td>
				<td >
					<?php echo $editor->display('synopsis','','100%','200','40','4'); ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<label for="message"><?php echo JText::_( 'Book Content' ); ?>: </label>
				</td>
				<td >
					<?php echo $editor->display('content','','100%','300','40','6'); ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<label for="message"><?php echo JText::_( 'Published' ); ?>:</label>
				</td>
				<td >
					<?php echo $lists['published']; ?>
				</td>
			</tr>
	</table>
	<input type="hidden" name="option" value="com_book" />
	<input type="hidden" name="task" value="" />
	</form>
<?php
}
?>

<?php
function showBook($rows){ 
?>
	<form action="index.php" method="post" name="adminForm">
	<table class="adminlist" cellspacing="1" width="100%">
	<thead>
	<tr>
        <th width="5">#</th>
        <th width="5"><input type="checkbox" name="toggle" value=""onclick="checkAll(<?php echo count($rows)?>)"></th>
        <th class="title">Title</th>
        <th width="1%" nowrap="nowrap" class="title">Published</th>
        <th width="1%" nowrap="nowrap" class="title">Publish Date</th>
        <th width="8%" nowrap="nowrap" class="title">Author</th>
        <th width="8%" nowrap="nowrap" class="title">Created Date</th>
        <th width="8%" nowrap="nowrap" class="title">Created by</th>
        <th width="8%" nowrap="nowrap" class="title">Modified Date</th>
        <th width="8%" nowrap="nowrap" class="title">Modified by</th>
        <th width="1%" nowrap="nowrap" class="title">ID</th>
    </tr>
    </thead>
<?php
	for($i=0, $n=count($rows); $i < $n ; $i++)
	{
		$row = &$rows[$i];
		$checked = JHTML::_('grid.id', $i, $row->id);
		$published = JHTML::_('grid.published', $row, $i);
?>
        <tr>
            <td align="center"><?php echo $i+1; ?></td>
            <td align="center"><?php echo $checked?></td>
            <td><?php echo $row->title?></td>
            <td align="center"><?php echo $row->publish_date?></td>
			<td align="center"><?php echo $row->author?></td>
            <td align="center"><?php echo $row->created ?></td>
            <td align="center"><?php echo $row->created ?></td>
            <td align="center"><?php echo $row->postname?></td>
            <td align="center"><?php echo $row->modified?></td>
            <td align="center"><?php echo $row->modifyname?></td>
            <td align="center"><?php echo $row->id?></td>
        </tr>
<?php
	}
?>
        </table>
        <input type="hidden" name="option" value="com_book">
        <input type="hidden" name="task" value="">
        <input type="hidden" name="boxchecked" value="0">
    </form>
<?php
}
}
?>

