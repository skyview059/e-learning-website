<?php
defined('_JEXEC') or die('Restricted Access');
class TableBook extends JTable
{
	var $id = null;
	var $title = null;
	var $picture = null;
	var $publish_date = null;
	var $author = null;
	var $synopsis = null;
	var $content = null;
	var $created = null;
	var $created_by = null;
	var $modified = null;
	var $modified_by = null;
	var $published = 0;
	function __construct(&$db)
	{
		parent::__construct( '#__books', 'id', $db );
	}
}
?>