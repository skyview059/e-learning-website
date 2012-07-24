<br clear="all">
<table class="adminlist" cellspacing="1">
	<thead>
            <th width="1px">
                <?php echo JText::_( 'ID' ); ?>
            </th>
            <th>
                <?php echo JText::_( 'Title' ); ?>
            </th>
            <th>
                <?php echo JText::_( 'Permisions' ); ?>
            </th>
        </thead>
	<tbody>
	<?php if( empty($this->menuTypesList) ): ?>
        <tr class="row0">
            <td align="center" colspan="100%"><?php echo JText::_('There are no Menu'); ?></td>
        </tr>
	<?php else: ?>
        <?php $k = 0; ?>
		<?php foreach($this->menuTypesList as $menuType): ?>
            <?php $k = $k % 2; ?>
    		<tr class="<?php echo "row$k"; ?>">
                <td align="center"><?php echo $menuType->id; ?></td>
                <td align="center">
                    <a href="javascript:void(0);" onclick="showAdapterTasks('<?php echo $this->adapterName; ?><?php echo $this->viewName; ?>MenuType<?php echo $menuType->id; ?>Tasks')">
                        <?php echo $menuType->title; ?>
                    </a>
                </td>
                <td align="center">
                    <?php
                    $groupName = JRequest::getVar( 'groupName' );
                    $extraParams = array(
                        '$menutype' => $menuType->menutype
                    );
                    $groupTasks = $this->adapterControl->loadGroupTasks( $groupName, $this->adapterName,$this->viewName,$extraParams);
                    ?>
                    <div id="<?php echo $this->adapterName; ?><?php echo $this->viewName; ?>MenuType<?php echo $menuType->id; ?>">
                        <?php
                        if( !empty($groupTasks) ){
                            echo trim(implode(',',$groupTasks));
                        }
                        else{
                            echo JText::_( 'none' );
                        }
                        ?>
                    </div>
                    <?php
                    /**
                     * Loading Category Params
                     */
                    $this->adapterControl->renderTasks($this->adapterName,$this->viewName,$this->tasks,"MenuType{$menuType->id}",$groupTasks,"[{$menuType->menutype}]");
                    ?>
                </td>
            </tr>
            <?php $k++; ?>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>