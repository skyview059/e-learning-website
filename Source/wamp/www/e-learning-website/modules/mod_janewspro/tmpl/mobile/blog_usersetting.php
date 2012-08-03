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
$id = $module->id.'-'.$secid;
$selectedCats = array();
$categories = $helper->_categories_org[$secid];

if($params_new->get('cookie_catsid', '')!=''){
	$selectedCats = explode(',', $params_new->get('cookie_catsid', ''));
}
elseif(count($helper->_categories[$secid])!=count($categories)){
	foreach ($helper->_categories[$secid] as $subcat){
		$selectedCats[] = $subcat->id;
	}
}


$checkall = true;
if ($selectedCats && count($selectedCats) != count($categories)) $checkall = false;
?>
<div class="ja-usersetting-wrap">
<div class="ja-usersetting" id="ja-usersetting-item-<?php echo $id?>">

	<a class="ja-usersetting-loadform" href="javascript:void(0)" onclick="return janewspro.showForm( $('ja-usersetting-item-<?php echo $id?>'))" id="ja-usersetting-loadform-<?php echo $id?>">
		<span><?php echo JText::_('Setting')?></span>
	</a>
	
	<div class="ja-usersetting-options clearfix" style="overflow: hidden; height: 0; ">
		
		<form class="ja-usersetting-form" method="get" action="index.php" >
			<div class="ja-usersetting-form-inner clearfix">
			<input type="hidden" name="group" value="<?php echo $secid; ?>" />
			<input type="hidden" name="moduleid" value="<?php echo $module->id?>" />
			
			<?php if($categories){?>
			<div class="ja-usersetting-row options-cat clearfix">

			<ul class="checkall">
				<li><input type="checkbox" id="checkall-<?php echo $id;?>" name="checkall" <?php if ($checkall) echo "checked=\"checked\"";?> />
				<label for="checkall-<?php echo $id;?>"><?php echo JTEXT::_('CHECK ALL');?></label></li>
			</ul>
		
			<ul class="catselect">
				<?php foreach( $categories as $category ): ?>
				<li>
					<input type="checkbox" <?php echo ( !$selectedCats || in_array($category->id, $selectedCats)? 'checked="checked"':'' );?> class="checkbox" value="<?php echo $category->id; ?>" id="ja-category-<?php echo $category->id; ?>" name="categories[]" />
					<label for="ja-category-<?php echo $category->id; ?>"><?php echo $category->title; ?></label>
				</li>
				<?php endforeach; ?>
			</ul>
			</div>
			<?php }?>

			<div class="ja-usersetting-row options-content clearfix">			
				<ul>
					<li>
						<label for="introitems<?php echo $id?>" class="jahasTip" title="<?php echo JTEXT::_('INTRO ITEMS NUMBER OF INTRO ITEMS.');?>"><?php echo JTEXT::_('INTRO ITEMS')?></label>
						<input type="text" name="introitems" id="introitems<?php echo $id?>" value="<?php echo $introitems;?>" class="inputbox" />
					</li>
					<li>
						<label for="linkitems<?php echo $id?>" class="jahasTip" title="<?php echo JTEXT::_('LINK ITEMS NUMBER OF LINK ITEMS.');?>"><?php echo JTEXT::_('LINK ITEMS');?></label>
						<input type="text" name="linkitems" id="linkitems<?php echo $id?>" value="<?php echo $linkitems;?>" class="inputbox" />
					</li>
				</ul>
			</div>
			
			<div class="ja-usersetting-row options-img clearfix">
				<ul>
					<li>
						<label class="jahasTip" title="<?php echo JTEXT::_('DISPLAY IMAGE OF ARTICLE.');?>"><?php echo JTEXT::_('SHOW IMAGE');?></label>
					</li>
					<li>
						<input type="radio" name="showimage" id="showimage<?php echo $id?>1" value="1" <?php if ($showimage) echo "checked=\"checked\"";?> class="radio" />
						<label for="showimage<?php echo $id?>1"><?php echo JTEXT::_('SHOW')?></label>
					</li>
					<li>
						<input type="radio" name="showimage" id="showimage<?php echo $id?>0" value="0" <?php if (!$showimage) echo "checked=\"checked\"";?> class="radio" />
						<label for="showimage<?php echo $id?>0"><?php echo JTEXT::_('HIDE')?></label>
					</li>
				</ul>
			</div>
			
			<div class="ja-usersetting-actions clearfix">
				<input type="button" class="button ja-submit" name="ja-submit" value="<?php echo JTEXT::_('SAVE');?>" />
				<input type="button" class="button ja-cancel" name="ja-cancel" value="<?php echo JTEXT::_('CANCEL');?>" />
			</div>
		</div>
		</form>
	</div>
</div>
</div>