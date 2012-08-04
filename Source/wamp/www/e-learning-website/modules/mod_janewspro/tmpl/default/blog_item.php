<?php
/*
# ------------------------------------------------------------------------
# Ja NewsPro
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: JoomlArt.com
# Websites: http://www.joomlart.com - http://www.joomlancers.com.
# ------------------------------------------------------------------------
*/
$cls_sufix = trim($params->get('blog_theme',''));		
if($cls_sufix) $cls_sufix = '-'.$cls_sufix;


$showcreator			= 	$helper->get( 'showcreator', 0 );
$showdate 				= 	$helper->get( 'showdate', 0 );
$maxchars 				= 	intval (trim( $helper->get( 'maxchars', 200 ) ));
$showreadmore 			= 	intval (trim( $helper->get( 'showreadmore', 1 ) ));
$showsubcattitle 		= 	trim( $helper->get( 'showsubcattitle' ));
$showtooltip			= 	intval (trim( $helper->get( 'showtooltip', 1 ) ));										
				
?>
<div class="ja-box column ja-zintheme<?php echo $cls_sufix;?><?php if (isset($y) && $y==0) echo ' ja-box-first' ?>">
	<div class="ja-box-inner clearfix">
		<?php if ($groupbysubcat && $showsubcattitle && count($rows)) : ?>					
			<div class="ja-zincat clearfix">
				<h3>
					<a href="<?php echo $cat->link?>" title="<?php echo trim(strip_tags($cat->description));?>">
						<span><?php echo $cat->title;?></span>
					</a>
				</h3>
			</div>
		<?php endif; ?>
		
		<?php
		foreach ($rows as $i=>$row){	
			if($i>=$introitems) break;												
			?>
			
			<div class="ja-zincontent clearfix">
				<h4 class="ja-zintitle">
					<a href="<?php echo $row->link;?>" title="<?php echo strip_tags($row->title);?>"><?php echo $row->title;?></a>
				</h4>
						
				<?php if ( $showcreator || $showdate ) : ?>
					<div class="ja-zinmeta clearfix">
						<?php if ($showdate) : ?>
							<span class="createdate">
								<?php echo $row->created?> 
								<?php if ($showcreator) : ?> &nbsp;|&nbsp; <?php endif; ?> 
							</span>
						<?php endif; ?>
						<?php if ($showcreator) : ?>
							<span class="createby"><?php echo $row->creator;?></span>						
						<?php endif; ?>
					</div>
				<?php endif; ?>
								
				<?php if($showimage)	echo $row->image; ?>
				
				<?php 
				     if($maxchars > strlen($row->introtext1)) {
				      echo $row->introtext;
				     } else {
				      echo $row->introtext1;
				     }
				?>
				<?php if ($showreadmore) : ?>
				<p class="readmore">
				<a href="<?php echo $row->link; ?>" title="<?php echo JText::sprintf('READ MORE...');?>">
					<span><?php echo JText::sprintf('READ MORE...');?></span>
				</a>
				</p>
				<?php endif; ?>
			</div>			
			<?php unset($rows[$i])?>
		<?php }?>
			
		<?php if($rows){?>
		<div class="ja-zinlinks clearfix">
			<strong><?php echo JTEXT::_('MORE:')?></strong>			
			<ul class="jazin-links">
				<?php foreach ($rows as $row){?>									
					<li>
						<span <?php if($showtooltip){?> class="editlinktip jahasTip" title="<?php echo trim(strip_tags($row->title), '"'); ?>::<?php echo htmlspecialchars($row->image.$row->introtext)?>"<?php }?>>
				  			<a href="<?php echo $row->link; ?>">
				  				<?php echo $row->title; ?>
				  			</a>
			  			</span>
		  			</li>
				<?php }?>
			</ul>
		</div>
		<?php }?>
		
	</div>
</div>