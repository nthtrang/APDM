<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	
	JToolBarHelper::title( JText::_( 'RECYLE_BIN_MAMANGEMENT' ) , 'trash.png' );
	JToolBarHelper::deleteList('Are you sure to delete it?', 'delete_ccs');
	JToolBarHelper::customX('restore_ccs', 'trash', '', 'Restore', true);
	//JToolBarHelper::cancel( 'cancel', 'Close' );
	$cparams = JComponentHelper::getParams ('com_media');
?>

<form action="index.php?option=com_apdmrecylebin&task=ccs" method="post" name="adminForm">
	<table>
		<tr>
			<td width="100%">
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_type').value='0';this.form.getElementById('filter_logged').value='0';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			<td nowrap="nowrap">
				<?php //echo $this->lists['active'];?>
				<?php echo $this->lists['create'];?>
			</td>
		</tr>
	</table>

	<table class="adminlist" cellpadding="1">
		<thead>
			<tr>
				<th width="2%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th width="3%" class="title">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
				</th>
				<th class="title">
					<?php echo JHTML::_('grid.sort',   'TEXT_CCS_CODE', 'c.ccs_code', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="10%" class="title" >
					<?php echo JText::_('NUMBER_OF_PNS'); ?>
				</th>
				<th class="title" >
					<?php echo JText::_('Description'); ?>
				</th>				
				<th width="15%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   'DATE_CREATE', 'c.ccs_create', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="15%" class="title">
					<?php echo JHTML::_('grid.sort',   'CREATED_BY', 'c.ccs_create_by', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="15%" class="title">
					<?php echo JHTML::_('grid.sort',   'DATE_DELETE', 'c.ccs_modified', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="15%" class="title">
					<?php echo JHTML::_('grid.sort',   'DELETED_BY', 'c.ccs_modified_by', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>				
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="10">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php
			$k = 0;
			for ($i=0, $n=count( $this->items ); $i < $n; $i++)
			{
				$row 	=& $this->items[$i];

				$img 	= $row->ccs_activate ? 'publish_x.png' : 'tick.png';
				$task 	= $row->ccs_activate ? 'unblock' : 'block';
				$alt 	= $row->ccs_activate ? JText::_( 'Enabled' ) : JText::_( 'Blocked' );
				$link 	= 'index.php?option=com_apdmccs&amp;task=vrestore&amp;cid[]='. $row->ccs_id. '';
			//	$npns = CCsController::GetNumberOfPNs($row->ccs_id);
				$link_pns = "#";
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td>
					<?php echo JHTML::_('grid.id', $i, $row->ccs_id ); ?>
				</td>
				<td>
					
						<?php echo $row->ccs_code; ?>
				</td>
				<td>
					<?php echo ($npns) ? '<a href="'.$link_pns.'">'.$npns.'</a>' : 0; ?>
				</td>	
				<td>					
						<?php echo $row->ccs_description; ?>
				</td>
				<td>
					<?php echo JHTML::_('date', $row->ccs_create, '%Y-%m-%d %H:%M:%S') ; ?>
				</td>
				<td>					
						<?php echo $row->username; ?>
				</td>
				<td nowrap="nowrap">
					<?php echo JHTML::_('date', $row->ccs_modified, '%Y-%m-%d %H:%M:%S') ; ?>
				</td>
				<td>
					<?php echo GetValueUser($row->ccs_modified_by, 'username');?>
				</td>
				
			</tr>
			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>
	</table>

	<input type="hidden" name="option" value="com_apdmrecylebin" />
	<input type="hidden" name="task" value="ccs" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
