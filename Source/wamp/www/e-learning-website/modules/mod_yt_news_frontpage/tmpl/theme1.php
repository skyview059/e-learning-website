<?php
/*------------------------------------------------------------------------

 # Yt News Front Page  - Version 1.0

 # ------------------------------------------------------------------------

 # Copyright (C) 2010 - 2011 The YouTech Company. All Rights Reserved.

 # @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

 # Author: The YouTech Company

 # Websites: http://joomla.ytcvn.com

 -------------------------------------------------------------------------*/
 
?>
<?php

    defined('_JEXEC') or die('Restricted access');
?>
<?php if(count($items)>0){?>   
<div class="yt_frontpage <?php echo $themes; ?>" style="width:<?php echo $width_module; ?>px;">
    <?php
        $count_items = 0;
        if($count_items == 0){
    ?>
        <div class="main_frontpage" style="width:<?php echo $thumb_width?>px;">   
            <div class="main_images">
                <?php if($link_image == 1){?><a href="<?php echo $items[0]['link']; ?>" target = "<?php echo $target;?>"><?php } ?><img src="<?php echo $items[0]['thumb']?>" title="<?php echo $items[0]['title']?>"/></a>
            </div> 
            <div class="main_content" style="width: <?php echo $thumb_width; ?>px;">
                <?php if($show_main_title == 1):?>
                    <?php if($link_caption == 1){?>
                        <a href="<?php echo $items[0]['link']; ?>" title="<?php echo $items[0]['title']?>" target = "<?php echo $target;?>">
                    <?php } ?>
                            <h3 style="color: <?php echo $title_color;?>;font-weight:bold;"> <?php echo $items[0]['sub_title']?></h3>
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
                <p><a href="<?php echo $items[0]['link']; ?>" title="<?php echo $items[0]['title']?>" target = "<?php echo $target;?>"><b>read more</b>&nbsp;&gt;&gt;</a></p>
                <?php } ?>
            </div> 
        </div>
    <?php 
        $count_items = 1;
        }
     ?>
    <div class="nomal_frontpage" style="width:<?php echo $width_content; ?>px;">
        <div class="nomal_items">
            <?php 
                foreach($items as $key=>$item) { 
                    if($key != 0){
            ?>
            <div style="padding-bottom: 10px; float: left;width: 100%;">
            <div class="nomal_images" style="float: right;">
             <?php if($link_image == 1){?><a href="<?php echo $item['link']; ?>" target = "<?php echo $target;?>"><?php } ?><img src="<?php echo $item['small_thumb']?>" title="<?php echo $item['title']?>"/></a>
            </div>
            <div class="nomal_content" style="width:<?php echo $width_content - ($small_thumb_width + 10)?>px;">
                <?php if($show_normal_title == 1):?>
                    <?php if($link_caption == 1){?>
                        <a href="<?php echo $item['link']; ?>" title="<?php echo $item['title']?>" target = "<?php echo $target;?>">
                    <?php } ?>
                            <strong style="color: <?php echo $title_color;?>;"><?php echo $item['sub_title']?></strong><br />
                    <?php if($link_caption == 1){?>
                        </a>
                    <?php } ?>
                <?php endif;?>
                <?php if($show_date == 1){?>
                    <span><?php echo date("d F Y", strtotime($item['publish'])); ?></span>
                <?php } ?>
                <?php if($show_normal_description == 1){?>
                <p><?php echo $item['sub_normal_content']?></p>
                <?php } ?>
            </div>
            </div>
            <?php }} ?>
        </div>
        
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