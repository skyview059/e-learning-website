<?php 
/**
* @name			Latest News Pro
* @version		1.5.0
* @package		Joomla
* @copyright	Copyright (C) 2008 - 2010 Joomla.StefySoft.com. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
*/

// no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<hr>
<ul class="latestnews<?php echo $params->get('moduleclass_sfx'); ?>">
<?php foreach ($list as $item) :  ?>
	<li class="latestnews<?php echo $params->get('moduleclass_sfx'); ?>">
		<a href="<?php echo $item->link; ?>" class="latestnews<?php echo $params->get('moduleclass_sfx'); ?>" title="<?php echo $item->alt_txt; ?>">
			<?php echo $item->text; ?></a>
	</li>
<?php endforeach; ?>
</ul>