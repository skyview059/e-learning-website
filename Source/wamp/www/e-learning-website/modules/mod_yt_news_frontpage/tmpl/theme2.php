<?php
/*------------------------------------------------------------------------

 # Yt News FrontPage  - Version 1.0

 # ------------------------------------------------------------------------

 # Copyright (C) 2009-2010 The YouTech Company. All Rights Reserved.

 # @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

 # Author: The YouTech Company

 # Websites: http://joomla.ytcvn.com

 -------------------------------------------------------------------------*/
?>
<?php

    defined('_JEXEC') or die('Restricted access');
    if(count($items)>0){
    
?>    
<div class="yt_frontpage <?php echo $themes; ?>" style="width:<?php echo $width_module; ?>px;">
    <div class="normal_yt">
        <?php
            $count_items = 0;   
            if($count_items == 0){
        ?>
        <div class="main_frontpage" style="height: <?php echo $thumb_height ?>px;">   
            <div class="main_images">
             <?php if($link_image == 1){?><a href="<?php echo $items[0]['link']; ?>" target = "<?php echo $target;?>"><?php } ?><img src="<?php echo $items[0]['thumb']?>" title="<?php echo $items[0]['title']?>"/></a>
            </div> 
        </div>
        <?php 
            $count_items = 1;
            }
         ?>
        <div class="normal_frontpage_theme2" style="width:<?php echo $width_content;?>px; float: left;">
            <ul class="normal_items_theme2">
            <?php 
				
				
                foreach($items as $key=>$item) { 
                    if($key != 0){
            ?>
                <li>
                    <div class="normal_title_theme2" style="color: <?php echo $title_color;?>;font-weight: bold;">
                    <?php if($show_normal_title == 1):?>
                        <?php if($link_caption == 1){?>
                            <a style="color: <?php echo $title_color;?>;" href="<?php echo $item['link']; ?>" title="<?php echo $item['title']?>" target = "<?php echo $target;?>">
                         <?php } ?>   
                                <?php echo $item['sub_title']?>
                         <?php if($link_caption == 1){?>
                            </a>
                         <?php } ?>
                     <?php endif;?>
                    </div>
                    <?php if($show_date == 1){?>
                        <div class="yt_date">
                            <span><?php echo date("d F Y", strtotime($item['publish'])); ?></span>
                        </div>
                    <?php } ?>
                    <?php if($show_normal_description == 1){?>
                    <div class="normal_desc_theme2"><?php  echo $item['sub_normal_content']?></div>
                    <?php } ?>
                </li>
             <?php }} ?>   
            </ul>
        </div>
    </div>

    <div class="main_content_theme2">
        <?php if($show_main_title == 1):?>
            <?php if($link_caption == 1){?>
                <a href="<?php echo $items[0]['link']; ?>" target = "<?php echo $target;?>" style="text-align: left;">
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
                <span><?php echo $items[0]['sub_main_content']?></span><br />
            <?php } ?>                
            <?php if($show_readmore == 1){?>
            <p><a href="<?php echo $items[0]['link']; ?>" title="<?php echo $items[0]['title']?>" target = "<?php echo $target;?>"><b>read more</b>&nbsp;&gt;&gt;</a></p>
            <?php } ?>
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