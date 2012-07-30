<?php
/*------------------------------------------------------------------------

 # Yt News FrontPage  - Version 1.1

 # Copyright (C) 2009-2010 The YouTech Company. All Rights Reserved.

 # @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

 # Author: The YouTech Company

 # Websites: http://www.ytcvn.com

 -------------------------------------------------------------------------*/
?>
<?php

    defined('_JEXEC') or die('Restricted access');
    if(count($items)>0){
    if (!defined ('YTCJQUERY')){
		define('YTCJQUERY', 1);
		JHTML::script('ytc.jquery-1.5.min.js', JURI::base() . '/modules/'.$module->module.'/assets/js/');				
	}
	JHTML::script('jquery.hoveraccordion.js',JURI::base() . 'modules/'.$module->module.'/assets/js/');
?>
<style>
    #yt_accordion<?php echo $module->id;?> a{
        display: block;
    }
</style>
<script>
    $jYtc(document).ready(function($){
    	// Setup HoverAccordion for Example 2 with some custom options
    	$('#yt_accordion<?php echo $module->id;?>').hoverAccordion({
    		activateitem: '1',
    		speed: 'fast'
    	});
    	$('#yt_accordion<?php echo $module->id;?>').children('li:first').addClass('firstitem');
    	$('#yt_accordion<?php echo $module->id;?>').children('li:last').addClass('lastitem');
    });
</script>
   
<div class="yt_frontpage <?php echo $themes; ?>" style="width:<?php echo $width_module;?>px;">
    <?php
        $count_items = 0;     
        if($count_items == 0){
    ?>
    <div class="main_frontpage" style="float: left;">   
        <div class="main_images">
         <?php if($link_image == 1){?><a href="<?php echo $items[0]['link']; ?>" target = "<?php echo $target;?>"><?php } ?><img src="<?php echo $items[0]['thumb']?>" title="<?php echo $items[0]['title']?>"/></a>
        </div> 
        <div class="main_content" style="width: <?php echo $thumb_width;?>px;">
            <?php if($show_main_title == 1):?>
            <?php if($link_caption == 1){?>
                <a href="<?php echo $items[0]['link']; ?>" target = "<?php echo $target;?>">
            <?php } ?>   
                    <h3 style="color: <?php echo $title_color;?>;font-weight: bold;" title="<?php echo $items[0]['title']?>"><?php echo $items[0]['sub_title']?></h3>
            <?php if($link_caption == 1){?>   
                </a>
            <?php } ?>
            <?php endif;?>
            <?php if($show_date == 1){?>
                <p class="yt_date"><?php echo date("d F Y", strtotime($items[0]['publish'])); ?></p>
            <?php } ?>
            <?php if($show_description == 1){?>
                <?php echo $items[0]['sub_main_content']?>
            <?php } ?>
            <?php if($show_readmore == 1){?>
            <span><a href="<?php echo $items[0]['link']; ?>" title="<?php echo $items[0]['title']?>" target = "<?php echo $target;?>"><b>read more</b>&nbsp;&gt;&gt;</a></span>
            <?php } ?>
        </div> 
    </div>
    <?php 
        $count_items = 1;
        }
     ?>
    <div class="normal_frontpage_theme4" style="float: left;width:<?php echo $width_content+25;?>px;">
      <ul id="yt_accordion<?php echo $module->id;?>" class="normal_content_theme4" style="width:100%;float:left;">
        <?php 
            foreach($items as $key=>$item) { 
                if($key != 0){
        ?>
        <li class="normal_items_theme4">
                <?php if($link_caption == 1){?>
                <a href="<?php echo $item['link']; ?>" target = "<?php echo $target;?>">  
                    <strong style="color: <?php echo $title_color;?>;font-weight: bold;" title="<?php echo $item['title']?>"><?php echo $item['sub_title']?></strong>
                </a>
                <?php } ?>
                <?php if($link_caption == 0){?>
                <a target = "<?php echo $target;?>">  
                    <strong style="color: <?php echo $title_color;?>;font-weight: bold;" title="<?php echo $item['title']?>"><?php echo $item['sub_title']?></strong>
                </a>
                <?php } ?>                                
          <ul class="normal_content_accor">
            <li style="float: right;">
                <?php if($link_image == 1){?><a href="<?php echo $item['link']; ?>" target = "<?php echo $target;?>"><?php } ?><img src="<?php echo $item['small_thumb']?>" title="<?php echo $item['title']?>"/></a>
            </li>
            <li class="normal_desc_theme4" style="width:<?php echo $width_content - ($small_thumb_width + 42)?>px;float:left;">
            <?php if($show_date == 1){?>
                    <span><?php echo date("d F Y", strtotime($item['publish'])); ?></span>
            <?php } ?>
            <?php if($show_normal_description == 1){?>
                <p><?php echo $item['sub_normal_content']?></p>
            <?php } ?> 
			
            </li>
          </ul>
        </li>
        <?php }} ?>
      </ul>
  </div>
</div>
<?php }else{
    echo "Has not article";
}?>
<?php if($note): ?>
<br/>
<div style="text-align:left; width:<?php echo $width_module; ?>px">
	<p><?php  echo $note;?></p>
</div>
<?php endif;?>