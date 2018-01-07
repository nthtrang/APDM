<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php  JHTML::_('behavior.tooltip');  ?>

<?php
	JToolBarHelper::title( JText::_( 'HISTORY_MANAGEMENT' ), 'addedit.png' );	
	JToolBarHelper::deleteList('Are you sure to delete it?');
	JToolBarHelper::cancel();
?>
<form action="index.php?option=com_history" method="post" name="adminForm">
	<table>
		<tr>
			<td width="100%">
				
				
			</td>
			<td nowrap="nowrap">
				<?php echo $this->lists['com'];?>
				<?php echo $this->lists['users'];?>					
				<button onclick="this.form.getElementById('filter_com').value='0';this.form.getElementById('filter_user').value='0';"><?php echo JText::_( 'Reset' ); ?></button>
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
				<th class="title" width="15%">
					<?php echo JHTML::_('grid.sort',   'HISTORY_DATE', 'h.history_date', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="15%" class="title" >
					<?php echo JHTML::_('grid.sort',   'HISTORY_WHERE', 'c.component_name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th class="title" width="10%">
					<?php echo JHTML::_('grid.sort',   'HISTORY_USER', 'u.name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th class="title">
					<?php echo JText::_('HISTORY_TODO'); ?>
				</th>			
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="6">
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
				$what = HistoryController::getInformation($row->history_what, $row->history_where, $row->history_todo_id);


			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td>
					<?php echo JHTML::_('grid.id', $i, $row->history_id ); ?>
				</td>
				<td>
						<?php echo JHTML::_('date', $row->history_date, '%m-%d-%Y %H:%M:%S'); ?>
				</td>
				<td>
					<?php echo $row->component_name; ?>
					
				</td>
				<td>
					<?php echo $row->username;?>
				</td>
				<td>
					<?php echo $what;?>
				</td>
			</tr>
			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>
	</table>

	<input type="hidden" name="option" value="com_history" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>