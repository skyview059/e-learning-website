<fieldset>
	<legend><?php echo JText::_("Manage Users"); ?></legend>
	<table class="admintable" cellspacing="1">
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Edit user' ); ?>
			</label>
		</td>
		<td>
			<?php
			$groupName = JRequest::getVar( 'groupName' );
			$haveAccess = $this->checkAccess('com_user','edit','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_user][]" value="edit" />
		</td>
	</tr>
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Manage Users' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_users','manage','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_users][]" value="manage" />
		</td>
	</tr>
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'block user' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_users','block user','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_users][]" value="block user" />
		</td>
	</tr>
	</table>
</fieldset>

<fieldset>
	<legend><?php echo JText::_("Manage Login"); ?></legend>
	<table class="admintable" cellspacing="1">
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Backend Access' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('login','administrator','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[login][]" value="administrator" />
		</td>
	</tr>
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Frontend Access' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('login','site','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[login][]" value="site" />
		</td>
	</tr>
	</table>
</fieldset>

<fieldset>
	<legend><?php echo JText::_("Core Components"); ?></legend>
	<table class="admintable" cellspacing="1">
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Manage Components' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_components','manage','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_components][]" value="manage" />
		</td>
	</tr>
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Manage Banners' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_banners','manage','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_banners][]" value="manage" />
		</td>
	</tr>
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Manage Weblinks' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_weblinks','manage','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_weblinks][]" value="manage" />
		</td>
	</tr>
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Manage Media' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_media','manage','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_media][]" value="manage" />
		</td>
	</tr>
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Manage Menus' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_menus','manage','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_menus][]" value="manage" />
		</td>
	</tr>
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Manage Modules' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_modules','manage','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_modules][]" value="manage" />
		</td>
	</tr>
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Manage Templates' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_templates','manage','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_templates][]" value="manage" />
		</td>
	</tr>
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Manage Poll' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_poll','manage','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_poll][]" value="manage" />
		</td>
	</tr>
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Manage Frontpage' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_frontpage','manage','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_frontpage][]" value="manage" />
		</td>
	</tr>
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Manage Contact' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_contact','manage','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_contact][]" value="manage" />
		</td>
	</tr>
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Manage Languages' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_languages','manage','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_languages][]" value="manage" />
		</td>
	</tr>
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Manage Plugins' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_plugins','manage','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_plugins][]" value="manage" />
		</td>
	</tr>
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Manage Configuration' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_config','manage','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_config][]" value="manage" />
		</td>
	</tr>	
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Manage checkin' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_checkin','manage','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_checkin][]" value="manage" />
		</td>
	</tr>	
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Manage cache' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_cache','manage','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_cache][]" value="manage" />
		</td>
	</tr>	
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Manage massmail' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_massmail','manage','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_massmail][]" value="manage" />
		</td>
	</tr>	
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Manage newsfeeds' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_newsfeeds','manage','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_newsfeeds][]" value="manage" />
		</td>
	</tr>	
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Manage trash' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_trash','manage','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_trash][]" value="manage" />
		</td>
	</tr>	
	</table>
</fieldset>

<fieldset>
	<legend><?php echo JText::_("Manage Content"); ?></legend>
	<table class="admintable" cellspacing="1">
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Frontpage Add' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_content','add','users',$groupName,'content','all');
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_content][]" value="add;" />
		</td>
	</tr>
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Frontpage Edit All' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_content','edit','users',$groupName,'content','all');
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_content][]" value="edit;content;all" />
		</td>
	</tr>
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Frontpage Edit Own' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_content','edit','users',$groupName,'content','own');
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_content][]" value="edit;content;own" />
		</td>
	</tr>
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Frontpage Publish' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_content','publish','users',$groupName,'content','all');
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_content][]" value="publish;content;all" />
		</td>
	</tr>
	</table>
</fieldset>

<fieldset>
	<legend><?php echo JText::_("Manage Instalation"); ?></legend>
	<table class="admintable" cellspacing="1">
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Manage Installation' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_installer','installer','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_installer][]" value="installer" />
		</td>
	</tr>
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Install Component' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_installer','component','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_installer][]" value="component" />
		</td>
	</tr>
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Install Languages' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_installer','language','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_installer][]" value="language" />
		</td>
	</tr>
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Install Modules' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_installer','module','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_installer][]" value="module" />
		</td>
	</tr>
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Install Plugins' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_installer','plugin','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_installer][]" value="plugin" />
		</td>
	</tr>
	<tr>
		<td width="150" class="key">
			<label for="name">
				<?php echo JText::_( 'Install Templates' ); ?>
			</label>
		</td>
		<td>
			<?php 
			$haveAccess = $this->checkAccess('com_installer','template','users',$groupName);
			?>
			<input type="checkbox" <?php if( $haveAccess ): ?> checked="checked" <?php endif; ?> name="ada_access[com_installer][]" value="template" />
		</td>
	</tr>
	</table>
</fieldset>