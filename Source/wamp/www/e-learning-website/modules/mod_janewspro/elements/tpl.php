<script type="text/javascript">
	var profiles = <?php echo json_encode($jsonData)?>;
	var Tempprofiles = <?php echo json_encode($jsonTempData)?>;
	var japarams2 = null;
	var lg_confirm_to_cancel = '<?php echo JText::_('Are you sure to cancel')?>';
	var lg_enter_profile_name = '<?php echo JText::_('Enter an Animation Profile name')?>';
	var lg_please_enter_profile_name = '<?php echo JText::_('Animation Profile name can not be empty')?>';
	var lg_confirm_delete_profile = '<?php echo JText::_('Are you sure to delete this profile')?>';
	var mod_url = '../modules/mod_janewspro/admin/helper.php';
	var templateactive = '<?php echo $template?>';	
	window.addEvent('load', function(){
		japarams2 = new JAPARAM2('<?php echo $control_name.$name?>');
		japarams2.changeProfile($('<?php echo $control_name.$name?>').value);
	});
</script>

<span class="clone">
	<a href="javascript:void(0)" onclick="japarams2.cloneProfile()" title="<?php echo JText::_('CLONE DESC')?>"><?php echo JText::_('Clone')?></a>
</span>
<span class="delete">	
	| <a href="javascript:void(0)" onclick="japarams2.deleteProfile()" title="<?php echo JText::_('DELETE DESC')?>"><?php echo JText::_('Delete')?></a>
</span>	

<div id="ja-layout-container">
	
	<div class="layout-name">
		<?php echo $paramsForm->render('japarams')?>
	</div>
</div>
<script type="text/javascript">	
	function submitbutton(pressbutton) {
		document.adminForm.task.value = pressbutton;
		if(pressbutton == 'apply' || pressbutton == 'save'){
			japarams2.saveProfile();
		}
		else{			
			document.adminForm.submit();
		}
	}
</script>