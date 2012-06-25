<?php
/**
 * @version	$Id: admin.rokbridge.html.php 2047 2007-10-02 00:42:56Z rhuk $ 
 * @package RokBridge - phpBB3 edition
 * @copyright Copyright (C) 2009 RocketTheme. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @author RocketTheme, LLC
 */
/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<h1><?php echo JText::_('ROKBRIDGE_CONFIGURATION'); ?></h1>

<table>
    <tr valign="top">
        <td width="50%">
<form action="index.php" method="post" name="adminForm" autocomplete="off">
    <?php echo $this->params->render('params'); ?>
    <input type="hidden" name="option" value="com_rokbridge" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="current_bridge_path" value="<?php echo $this->current_bridge_path; ?>" />
</form>
        </td>
        <td width="50%">
            <div class="note">
				<div class="corner">
                	<?php echo JText::_('INSTRUCTIONS'); ?>
				</div>
            </div>
        </td>
    </tr>
</table>

<br />

<h1><?php echo JText::_('ROKBRIDGE_STATUS'); ?></h1>

<table class="adminlist">
	<thead>
		<tr>
			<th class="title" width="20%"><?php echo JText::_('ELEMENT'); ?></th>
			<th width="15%"><?php echo JText::_('STATUS'); ?></th>
			<th width="15%"><?php echo JText::_('ACTION'); ?></th>
			<th width="50%"><?php echo JText::_('NOTE'); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
	</tfoot>
	<tbody>
	   <tr class="<?php echo $this->userplg_class; ?>"> 
	        <td><?php echo JText::_('JOOMLA_USERPLG'); ?></td>
	        <td class="status"><span><?php echo $this->userplg_status ?></span></td>
	        <td>&nbsp;</td>
	        <td><?php echo $this->userplg_note; ?></td>
	   </tr>
	   <tr class="<?php echo $this->authplg_class; ?>"> 
   	        <td><?php echo JText::_('JOOMLA_AUTHPLG'); ?></td>
   	        <td class="status"><span><?php echo $this->authplg_status; ?></span></td>
   	        <td>&nbsp;</td>
   	        <td><?php echo $this->authplg_note; ?></td>
   	   </tr>
   	   <tr class="<?php echo $this->bridge_class; ?>"> 
  	        <td><?php echo JText::_('PHPBB3_BRIDGE'); ?></td>
  	        <td class="status"><span><?php echo $this->bridge_status; ?></span></td>
  	        <td class="centeralign">
  	            <?php if ($this->bridge_install_enable) :?>
  	                <?php if (!$this->bridge_installed) : ?>
  	                <a href="index.php?option=com_rokbridge&amp;task=movebridge"><?php echo JText::_('INSTALL'); ?></a>
  	                <?php else: ?>
  	                <a href="index.php?option=com_rokbridge&amp;task=removebridge"><?php echo JText::_('REMOVE'); ?></a>    
  	                <?php endif; ?>
  	            <?php endif; ?>
  	        </td>
  	        <td><?php echo $this->bridge_note; ?></td>
  	   </tr>   	   
   	   <tr class="<?php echo $this->phpbb3_class; ?>"> 
 	        <td><?php echo JText::_('PHPBB3_FORUM');?></td>
 	        <td class="status"><span><?php echo $this->phpbb3_status; ?></span></td>
 	        <td></td>
 	        <td><?php echo $this->phpbb3_note; ?></td>
 	   </tr>
   	   <tr class="<?php echo $this->phpbb3plg_class; ?>"> 
  	        <td><?php echo JText::_('PHPBB3_AUTHPLG');?></td>
  	        <td class="status"><span><?php echo $this->phpbb3plg_status; ?></span></td>
  	        <td class="centeralign">
      	        <?php if ($this->phpbb3_installed and $this->bridge_installed) : ?>
          	        <?php if (!$this->phpbb3plg_installed) : ?>
          	        <a href="index.php?option=com_rokbridge&amp;task=installplugin"><?php echo JText::_('INSTALL'); ?></a>
          	        <?php else: ?>
          	        <a href="index.php?option=com_rokbridge&amp;task=removeplugin"><?php echo JText::_('REMOVE'); ?></a>    
          	        <?php endif; ?>
          	    <?php else: 
          	        $this->phpbb3plg_note = JText::_('BRIDGE_INSTALLED_FIRST');
          	     endif; ?>
  	        </td>
  	        <td><?php echo $this->phpbb3plg_note; ?></td>
  	   </tr>
  	   <tr class="<?php echo $this->indexes_class; ?>"> 
  	        <td><?php echo JText::_('PHPBB3_INDEXES');?></td>
  	        <td class="status"><span><?php echo $this->indexes_status; ?></span></td>
  	        <td class="centeralign">
      	        <?php if ($this->phpbb3_installed and $this->bridge_installed) : ?>
          	        <?php if (!$this->indexes_installed) : ?>
          	        <a href="index.php?option=com_rokbridge&amp;task=addIndexes"><?php echo JText::_('INSTALL'); ?></a>
          	        <?php else: ?>
          	        <a href="index.php?option=com_rokbridge&amp;task=dropIndexes"><?php echo JText::_('REMOVE'); ?></a>    
          	        <?php endif; ?>
          	    <?php else: 
          	        $this->indexes_note = JText::_('BRIDGE_PHPBB3_INSTALLED_FIRST');
          	     endif; ?>
  	        </td>
  	        <td><?php echo $this->indexes_note; ?></td>
  	   </tr>
  	   <tr class="<?php echo $this->patch_class; ?>"> 
     	        <td><?php echo JText::_('PHPBB3_PATCH');?></td>
     	        <td class="status"><span><?php echo $this->patch_status; ?></span></td>
     	        <td class="centeralign">
         	        <?php if ($this->phpbb3_installed) : ?>
             	        <?php if (!$this->patch_installed) : ?>
             	        <a href="index.php?option=com_rokbridge&amp;task=applypatch&amp;patchfull=<?php echo (int) $this->patch_full; ?>"><?php echo JText::_('INSTALL'); ?></a>
             	        <?php else: ?>
             	        <a href="index.php?option=com_rokbridge&amp;task=removepatch&amp;patchfull=<?php echo (int) $this->patch_full; ?>"><?php echo JText::_('REMOVE'); ?></a>    
             	        <?php endif; ?>
         	        <?php endif; ?>
     	        </td>
     	        <td><?php echo $this->patch_note; ?></td>
     	   </tr>
	   
    </tbody>
</table>

<?php
if ($this->joomla_userplg_installed and $this->joomla_authplg_installed and $this->patch_installed and $this->phpbb3_installed and $this->phpbb3plg_installed and $this->bridge_installed) {
        echo '<p class="testurl">';
        echo sprintf(JText::_('FULLY_INSTALLED'),$this->bridge_url,$this->bridge_url);
        echo '</p>';
    }
?>