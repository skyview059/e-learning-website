<?php
class HTML_book
{
  function showBook($rows, $option)
  { 
?>
    <table>
<?php
    foreach($rows as $row)
    {
		$link = 'index.php?option='.$option.'&id='. $row->id . '&task=view';
		$picture = '';
		if($row->picture != ''){
			$linkPicture = 'administrator/components/com_book/books/fix/' .$row->picture;
			$picture = '<img src="' . $linkPicture . '" hspace="5"vspace="5" align="left" />';
		}
		echo '
			<tr>
			<td>
				<a href="'. $link .'" class="contentheading">'.$row->title .'</a>
				<br>
					' . $picture . '
					<strong>Author</strong>: ' . $row->author . '
				<br />
				<strong>Publish date</strong>: ' . $row->publish_date . '
				<br />
				<strong>Synopsis</strong>: ' . $row->synopsis . '
			</td>
			</tr>
			';
    }
?>
	</table>
<?php
  }
}
?>