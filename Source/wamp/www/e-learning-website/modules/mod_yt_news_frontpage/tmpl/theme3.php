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
<div class="yt_frontpage yt_frontpage_theme3" style="width:<?php echo $width_module; ?>px;">
    <?php
        $count_items = 0;
        foreach($items as $key=>$item) {      
        if($count_items == 0){
    ?>
    <div class="ytc main_frontpage_theme3" style="width:<?php echo $width_module; ?>px; height:<?php echo $thumb_height;?>px;">
        <div class="main_img_theme3" style="float: left; position: relative;">
             <?php if($link_image == 1){?><a href="<?php echo $items[0]['link']; ?>" target = "<?php echo $target;?>"><?php } ?><img src="<?php echo $items[0]['thumb']?>" title="<?php echo $items[0]['title']?>"/></a>
        </div>
        <div class="main_content_theme3" style="position: relative; overflow: hidden;padding-left: 10px;">
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
                <span class="yt_date"><?php echo date("d F Y", strtotime($items[0]['publish'])); ?></span>
             <?php } ?>
            <?php if($show_description == 1){?>
                <p><?php echo $items[0]['sub_main_content']?></p>
            <?php } ?>
            <?php if($show_readmore == 1){?>
            <span><a href="<?php echo $items[0]['link']; ?>" title="<?php echo $items[0]['title']?>" target = "<?php echo $target;?>"><b>read more</b>&nbsp;&gt;&gt;</a></span>
            <?php } ?>
        </div>
    </div>
    
    <div  style="position: relative;float: left !important;">
    <?php 
        $count_items = 1;
        }elseif($count_items == 1){
     ?>
        <div class="nomal_frontpage_theme3"  style="float: left;width:<?php echo $widthpage_theme3; ?>px;">
            <div class="nomal_content_theme3">
               <div style="float: left;">
                    <?php if($link_image == 1){?><a href="<?php echo $item['link']; ?>" target = "<?php echo $target;?>"><?php } ?><img src="<?php echo $item['small_thumb']?>" title="<?php echo $item['title']?>"/> </a>
                </div>
               <div class="normal_des" >
                <?php if($show_normal_title == 1):?>
                    <?php if($link_caption == 1){?>
                        <a href="<?php echo $item['link']; ?>" target = "<?php echo $target;?>">
                    <?php } ?>    
                            <span style="color: <?php echo $title_color;?>;font-weight: bold;" title="<?php echo $item['title']?>"><?php echo $item['sub_title']?></span>
                    <?php if($link_caption == 1){?>    
                        </a>
                    <?php } ?>
                <?php endif;?>
                </div>
                <?php if($show_date == 1){?>
                    <div class="yt_date">
                        <span style="padding-left: 10px;" ><?php echo date("d F Y", strtotime($item['publish'])); ?></span>
                    </div>
                <?php } ?>
                <?php if($show_normal_description == 1){?>
                    <div class="normal_des_theme3" style="position: relative; overflow: hidden; padding: 0px 5px 0px 9px;"><?php echo $item['sub_normal_content']?></div>
                <?php } ?>
            </div>
            
        </div>
    <?php }} ?>
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