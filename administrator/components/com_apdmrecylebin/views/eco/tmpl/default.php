<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php  JHTML::_('behavior.tooltip');  ?>

<?php	
	JToolBarHelper::title( JText::_( 'RECYLE_BIN_MAMANGEMENT' ) , 'trash.png' );
	JToolBarHelper::deleteList('Are you sure to delete it?', 'delete_eco');
	JToolBarHelper::customX('restore_eco', 'trash', '', 'Restore', true);	

?>

<form action="index.php?option=com_apdmrecylebin&task=eco" method="post" name="adminForm">
	<table  width="100%">
		<tr>
			<td width="35%" >
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" size="40" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>				
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
					<?php echo JHTML::_('grid.sort',   'Name', 'e.eco_name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="15%" class="title" >
					<?php echo JText::_( 'Description' ); ?>
				</th>
				<th width="15%" class="title" >
					<?php echo JText::_( 'Activate' ); ?>
				</th>				
				
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   'Date Create', 'e.eco_create', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				
				<th width="15%" class="title">
					<?php echo JHTML::_('grid.sort',   'Create by', 'e.eco_create_by', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="15%" class="title">
					<?php echo JHTML::_('grid.sort',   'Date Modified', 'e.eco_modified', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="10%" class="title">
					<?php echo JHTML::_('grid.sort',   'Modified By', 'e.eco_modified_by', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
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

				$img 	= $row->eco_status ? 'tick.png' : 'publish_x.png';
				$task 	= $row->eco_status ? 'unblock' : 'block';
				
				$alt 	= $row->eco_status ? JText::_( 'Activate' ) : JText::_( 'Inactivate' );
				$link 	= 'index.php?option=com_apdmrecylebin&amp;task=ecodetail&amp;cid[]='. $row->eco_id. '';			
				
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td>
					<?php echo JHTML::_('grid.id', $i, $row->eco_id ); ?>
				</td>
				<td>
					<a href="<?php echo $link; ?>">
						<?php echo $row->eco_name; ?></a>
				</td>				
				<td align="center">
					<?php echo $row->eco_description; ?>
				</td>
				<td>
				
						<img src="images/<?php echo $img;?>" width="16" height="16" border="0" alt="<?php echo $alt; ?>" />
				</td>				
				<td>
					<?php echo  JHTML::_('date', $row->eco_create, '%m-%d-%Y'); ?>
				</td>
				<td>
					<?php echo GetValueUser($row->eco_create_by, 'username'); ?>
				</td>
				<td nowrap="nowrap">
						<?php echo ($row->eco_modified_by) ? JHTML::_('date', $row->eco_modified, '%m-%d-%Y') : ''; ?>
				</td>
				<td>
					<?php echo GetValueUser($row->eco_modified_by, 'username'); ?>
				</td>
			</tr>
			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>
	</table>

	<input type="hidden" name="option" value="com_apdmrecylebin" />
	<input type="hidden" name="task" value="eco" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>