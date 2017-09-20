<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php  JHTML::_('behavior.tooltip');  ?>

<?php
	JToolBarHelper::title( JText::_( 'ROLE_MANAGEMENT' ), 'config.png' );
	JToolBarHelper::deleteList('Are you sure to delete ?');
	JToolBarHelper::editListX();
	JToolBarHelper::addNewX();
?>

<form action="index.php?option=com_roles" method="post" name="adminForm">
	<table width="100%" s>
		<tr>
			<td width="100%" >
				<?php echo JText::_( 'TEXT_FILTER' ); ?>:
				<input type="text" name="search" id="search" size="20" maxlength="200" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<?php echo  JText::_('FILTER_DATE_CREATE').' '.JHTML::_('calendar', $this->lists['filter_date_created'], 'filter_date_created', 'filter_date_created', '%m-%d-%Y', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>				
				&nbsp;
				<?php echo JText::_('FILTER_DATE_MODIFIED').' '.JHTML::_('calendar', $this->lists['filter_date_modified'], 'filter_date_modified', 'filter_date_modified', '%m-%d-%Y', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>		
				<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_date_created').value='';this.form.getElementById('filter_date_modified').value='';this.form.getElementById('filter_user').value='0';this.form.getElementById('filter_modified_by').value='0';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>	
			</td>	
		</tr>
		<tr>	
			<td align="right"  width="100%" >  	
				<?php echo $this->lists['groups'];?>
				<?php echo $this->lists['modified_by'];?>	
						
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
				<th class="title" width="10%">
					<?php echo JHTML::_('grid.sort',   'Role Name', 'r.role_name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th class="title" >
					<?php echo JText::_( 'ROLE_DESCRIPTION' ); ?>
					
				</th>				
				<th width="15%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   'DATE_CREATE', 'r.role_create', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="10%" class="title">
				<?php echo JHTML::_('grid.sort',   'CREATED_BY', 'r.role_create_by', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="15%" class="title">
				<?php echo JHTML::_('grid.sort',   'DATE_MODIFIED', 'r.role_modified', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="10%" class="title">
					<?php echo JHTML::_('grid.sort',   'MODIFIED_BY', 'r.role_modified_by', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<!--<th width="1%" class="title" nowrap="nowrap">
					<?php //echo JHTML::_('grid.sort',   'ID', 'r.role_id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>-->
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="9">
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
				$numberUser = RolesController::CountNumberUserOfRole($row->role_id);
				if ($numberUser) {
					//$link 	= 'index.php?option=com_roles&amp;view=role&amp;task=edit&amp;cid[]='. $row->role_id. '';
					$link 	= 'index.php?option=com_apdmusers&amp;filter_role='.$row->role_id;
					$title_link = JText::_('TITLE_LINK_LIST_1');
				}else{
					$link = 'index.php?option=com_roles&task=edit&cid[]='.$row->role_id;
					$title_link = JText::_('TITLE_LINK_LIST_2');
				}
				
				$modified_by = RolesController::GetNameUser($row->role_modified_by);
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td>
					<?php echo JHTML::_('grid.id', $i, $row->role_id ); ?>
				</td>
				<td><?php echo $row->role_name; ?>
				<!--	<a href="<?php //echo $link; ?>" title="<?php //echo $title_link;?>">
						<?php //echo $row->role_name; ?></a>-->
				</td>
				<td>
					<?php echo $row->role_description; ?>
				</td>
				<td align="center">
					<?php echo JHTML::_('date', $row->role_create, '%m-%d-%Y %H:%M:%S');?>
				</td>
				<td align="center">
					<?php echo $row->username;?>
				</td>
				<td>
					<?php echo ($row->role_modified !='0000-00-00 00:00:00') ? JHTML::_('date', $row->role_modified, '%m-%d-%Y %H:%M:%S') : '';?>
				</td>
				<td>
					<?php echo $modified_by;?>
				</td>			
				<!--<td>
					<?php //echo $row->role_id; ?>
				</td>-->
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