<script type="text/javascript">
function showMenuSite()
{
    var showMenuTypeID = "<?php echo $this->adapterName; ?><?php echo $this->viewName; ?>TableMenuType"+$("<?php echo $this->adapterName; ?><?php echo $this->viewName; ?>TableMenuType").value;
    var totalOptions = $("<?php echo $this->adapterName; ?><?php echo $this->viewName; ?>TableMenuType").options.length;
    for( var numOption = 0 ; numOption < totalOptions ; numOption++ ){
        var myMenuTypeElem = "<?php echo $this->adapterName; ?><?php echo $this->viewName; ?>TableMenuType"+ $("<?php echo $this->adapterName; ?><?php echo $this->viewName; ?>TableMenuType").options[numOption].value;
        $(myMenuTypeElem).style.display = 'none';
    }
    $(showMenuTypeID).style.display = 'block';
}
</script>
<table>
	<tr>
		<td width="100%">
			<?php echo JText::_( 'Type' ); ?>:
			<?php echo $this->lists["menuType"]; ?>
		</td>
	</tr>
</table>
<?php $styleTable = "display:block;"; ?>
<?php foreach($this->menuTypesList as $menuType): ?>
<table class="adminlist" cellspacing="1" id="<?php echo $this->adapterName; ?><?php echo $this->viewName; ?>TableMenuType<?php echo $menuType->id; ?>" style="<?php echo $styleTable; ?>">
	<thead>
        <th width="1%">
            <?php echo JText::_( 'ID' ); ?>
        </th>
        <th width="20%" class="title">
            <?php echo JText::_( 'Menu Item' ); ?>
        </th>
        <th width="9%" nowrap="nowrap">
            <?php echo JText::_( 'Access Level' ); ?>
        </th>
        <th width="70%" nowrap="nowrap">
            <?php echo JText::_( 'Permisions' ); ?>
        </th>
    </thead>
	<tbody>
	<?php if( empty($menuType->menuItensList) ): ?>
	<tr class="row0">
		<td align="center" colspan="100%"><?php echo JText::_('There are no Menu Itens'); ?></td>
	</tr>
	<?php else: ?>
        <?php $k = 0; ?>
		<?php foreach($menuType->menuItensList as $menuItem): ?>
            <?php $access = JHTML::_('grid.access', $menuItem, $k ); ?>
            <?php $k = $k % 2; ?>
    		<tr class="<?php echo "row$k"; ?>">
                <td align="center"><?php echo $menuItem->id; ?></td>
                <td>
                    <?php if($menuItem->access): ?>
                        <a href="javascript:void(0);" onclick="showAdapterTasks('<?php echo $this->adapterName; ?><?php echo $this->viewName; ?>MenuType<?php echo $menuItem->id; ?>Tasks')">
                    <?php endif; ?>
                        <?php echo $menuItem->treename; ?>
                    <?php if($menuItem->access): ?>
                        </a>
                    <?php endif; ?>
                </td>
                <td align="center"><?php echo $access; ?></td>
                <td align="center">
                <?php
                $groupName = JRequest::getVar( 'groupName' );
                $extraParams = array(
                    '$menutype' => $menuItem->menutype,
                    '$menu_id' => $menuItem->id
                );
                
                $groupTasks = $this->adapterControl->loadGroupTasks( $groupName, $this->adapterName,$this->viewName,$extraParams);
                ?>
                <div id="<?php echo $this->adapterName; ?><?php echo $this->viewName; ?>MenuType<?php echo $menuItem->id; ?>">
                    <?php
                        if($menuItem->access){
                            if( !empty($groupTasks) ){
                                echo trim(implode(',',$groupTasks));
                            }
                            else{
                                echo JText::_( 'none' );
                            }
                        }
                        else{
                           echo JText::_( 'You can not set permissions in' ); ?> <?php echo $menuItem->groupname; ?> <?php echo JText::_( 'access level' );
                        }
                    ?>
                </div>
                <?php
                /**
                 * Loading Category Params
                 */
                $this->adapterControl->renderTasks($this->adapterName,$this->viewName,$this->tasks,"MenuType{$menuItem->id}",$groupTasks,"[{$menuItem->menutype}][{$menuItem->id}]");
                ?>
                </td>
            </tr>
        <?php $k++; ?>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
<?php $styleTable = "display:none;"; ?>
<?php endforeach; ?>