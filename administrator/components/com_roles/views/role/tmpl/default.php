<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php  JHTML::_('behavior.tooltip');  ?>

<?php
	JToolBarHelper::title( JText::_( 'ROLE_MANAGEMENT' ), 'config.png' );
	JToolBarHelper::deleteList();
	JToolBarHelper::editListX();
	JToolBarHelper::addNewX();
?>

<form action="index.php?option=com_roles" method="post" name="adminForm">
	<table>
		<tr>
			<td width="100%">
				<?php echo JText::_( 'TEXT_FILTER' ); ?>:
				<input type="text" name="search" id="search" size="30" maxlength="200" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_type').value='0';this.form.getElementById('filter_logged').value='0';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			<td nowrap="nowrap">
				<?php echo $this->lists['groups'];?>			
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
					<?php echo JHTML::_('grid.sort',   'Role Name', 'r.role_name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="15%" class="title" >
					<?php echo JHTML::_('grid.sort',   'NUMBEROFUSER', 'ru.n_user', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>				
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   'DATE_CREATE', 'r.role_create', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="15%" class="title">
				<?php echo JHTML::_('grid.sort',   'CREATED_BY', 'r.role_create_by', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="15%" class="title">
				<?php echo JHTML::_('grid.sort',   'DATE_MODIFIED', 'r.role_modified', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="10%" class="title">
					<?php echo JHTML::_('grid.sort',   'MODIFIED_BY', 'r.role_modified_by', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="1%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   'ID', 'r.role_id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
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

				//$img 	= $row->block ? 'publish_x.png' : 'tick.png';
				//$task 	= $row->block ? 'unblock' : 'block';
				//$alt 	= $row->block ? JText::_( 'Enabled' ) : JText::_( 'Blocked' );
				//

			/*	if ($row->lastvisitDate == "0000-00-00 00:00:00") {
					$lvisit = JText::_( 'Never' );
				} else {
					$lvisit	= JHTML::_('date', $row->lastvisitDate, '%Y-%m-%d %H:%M:%S');
				}*/
				$link 	= 'index.php?option=com_roles&amp;view=role&amp;task=edit&amp;cid[]='. $row->role_id. '';
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td>
					<?php echo JHTML::_('grid.id', $i, $row->role_id ); ?>
				</td>
				<td>
					<a href="<?php echo $link; ?>">
						<?php echo $row->role_name; ?></a>
				</td>
				<td>
					<?php echo $row->n_user; ?>
				</td>
				<td align="center">
					<?php echo JHTML::_('date', $row->role_create, '%Y-%m-%d %H:%M:%S');?>
				</td>
				<td align="center">
					<?php echo $row->username;?>
				</td>
				<td>
					<?php echo JHTML::_('date', $row->role_modified, '%Y-%m-%d %H:%M:%S');?>
				</td>
				<td>
					<?php echo $row->username;?>
				</td>			
				<td>
					<?php echo $row->role_id; ?>
				</td>
			</tr>
			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>
	</table>

	<input type="hidden" name="option" value="com_roles" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>