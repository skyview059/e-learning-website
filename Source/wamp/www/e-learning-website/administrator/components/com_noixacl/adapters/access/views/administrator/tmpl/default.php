<fieldset>
	<legend><?php echo JText::_("Extensions"); ?></legend>
	<table class="admintable" cellspacing="1">
	<?php if( empty($this->extensions) ): ?>
		<tr>
			<td colspan="100%">No extensions results</td>
		</tr>
	<?php else: ?>
		<?php foreach($this->extensions as $extension): ?>
		<tr>
			<td width="150" class="key">
				<label for="name">
					<?php echo JText::_( $extension->option ); ?>
				</label>
			</td>
			<td>
				<?php
				$groupName = JRequest::getVar( 'groupName' );
				$haveAccess = $this->checkAccess($extension->option,'administrator.block','users',$groupName);
				?>
				<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[<?php echo $extension->option; ?>][]" value="administrator.block" /> Block
			</td>
		</tr>
		<?php endforeach; ?>
	<?php endif; ?>
	</table>
</fieldset>