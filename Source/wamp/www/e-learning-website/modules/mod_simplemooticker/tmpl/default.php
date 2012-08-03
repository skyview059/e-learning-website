<?php
// Modulename: "SIMPLE MOOTICKER" for Joomla! 1.5.x
// Version: 1.5.4
// File: default.php
// Copyright 2008 - 2009: medien.stroeme - agentur für multimediale werbung
// Online: www.medienstroeme.de
// License:	GNU/GPL, see LICENSE.php
// Last update: 05.03.2009

// no direct access

defined('_JEXEC') or die('Restricted access'); ?>

<!-- medienstroeme - Simple Mooticker v.1.5.4 - starts here -->

<?php if($tccm == 1) : ?>
<div class="mooquee layer_one" id="mooquee-<?php echo $params->get( 'tdir' ); ?>"><?php echo $params->get( 'tcc' ); ?></div>
<?php else : ?>
<div class="mooquee layer_one" id="mooquee-<?php echo $params->get( 'tdir' ); ?>"><?php echo $params->get( 'separator' ); ?> <?php foreach ($list as $item) :  ?><a href="<?php echo $item->link; ?>" title="<?php echo $item->text; ?>"><?php echo $item->text; ?></a> <?php echo $params->get( 'separator' ); ?> <?php endforeach; ?></div>
<?php endif ?>
<noscript><div class="mooquee layer_two"><?php echo $params->get( 'tns' ); ?></div></noscript>
<div class="smtclr"></div>
<script type="text/javascript">
//<![CDATA[
var obj_<?php echo $params->get( 'tdir' ); ?> = new mooquee($('mooquee-<?php echo $params->get( 'tdir' ); ?>'), {
marHeight: '<?php echo $params->get( 'th' ); ?><?php echo $params->get( 'unityh' ); ?>',
marWidth: '<?php echo $params->get( 'tw' ); ?><?php echo $params->get( 'unityw' ); ?>',
steps: <?php
 $browser = $_SERVER['HTTP_USER_AGENT'];  
 if(stristr($browser, "MSIE")){ 
echo $params->get( 'tstpIE' );
} else { 
echo $params->get( 'tstp' );
} 
?>,
direction: '<?php echo $params->get( 'tdir' ); ?>'
});
//]]>       
</script>

<!-- medienstroeme - Simple Mooticker v.1.5.4 - ends here -->

 



 
