<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php  JHTML::_('behavior.tooltip');  ?>

<?php
	
	JToolBarHelper::title( JText::_( 'RECYLE_BIN_MAMANGEMENT' ) , 'trash.png' );
	JToolBarHelper::deleteList('Are you sure to delete it?', 'delete_info');
	JToolBarHelper::customX('restore_info', 'trash', '', 'Restore', true);
	

?>

<form action="index.php?option=com_apdmrecylebin&task=info" method="post" name="adminForm">
<input type="hidden" name="query_exprot" value="<?php echo $this->lists['query'];?>" />
<input type="hidden" name="total_record" value="<?php echo $this->lists['total_record'];?>" />
	<table  width="100%">
		<tr>
			<td width="35%" >
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" size="40" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button><button onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
				
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
					<?php echo JHTML::_('grid.sort',   'Name', 's.info_name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th class="title">
					<?php echo JHTML::_('grid.sort',   'Type', 's.info_type', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="15%" class="title" >
					<?php echo JText::_( 'Description' ); ?>
				</th>				
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   'Date Create', 's.info_create', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				
				<th width="15%" class="title">
					<?php echo JHTML::_('grid.sort',   'Create by', 's.info_created_by', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="15%" class="title">
					<?php echo JHTML::_('grid.sort',   'DATE_DELETE', 's.info_modified', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="10%" class="title">
					<?php echo JHTML::_('grid.sort',   'DELETED_BY', 's.info_modified_by', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>				
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="10">
					<?php  echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php
			$k = 0;
			for ($i=0, $n=count( $this->items ); $i < $n; $i++)
			{
				$row 	=& $this->items[$i];
				
				$link 	= 'index.php?option=com_apdmrecylebin&amp;task=infodetail&amp;cid[]='. $row->info_id. '';
				$type = '';
				if ($row->info_type ==2) $type = 'Vendor';
				if ($row->info_type ==3) $type = 'Supplier';
				if ($row->info_type ==4) $type = 'Manufacture';				
				
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td>
					<?php echo JHTML::_('grid.id', $i, $row->info_id ); ?>
				</td>
				<td>
					<a href="<?php echo $link; ?>">
						<?php echo $row->info_name; ?></a>
				</td>
				<td>
					<?php echo $type; ?>
				</td>
				<td align="center">
					<?php echo $row->info_description; ?>
				</td>
				
				<td>
					<?php echo  JHTML::_('date', $row->info_create, '%m-%d-%Y'); ?>
				</td>
				<td>
					<?php echo GetValueUser($row->info_created_by, 'name'); ?>
				</td>
				<td nowrap="nowrap">
						<?php echo ($row->info_modified_by) ? JHTML::_('date', $row->info_modified, '%m-%d-%Y') : ''; ?>
				</td>
				<td>
					<?php echo GetValueUser($row->info_modified_by, 'name'); ?>
				</td>
			</tr>
			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>
	</table>

	<input type="hidden" name="option" value="com_apdmrecylebin" />
	<input type="hidden" name="task" value="info" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
</form>