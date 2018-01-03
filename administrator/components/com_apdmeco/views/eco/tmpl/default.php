<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php  JHTML::_('behavior.tooltip');  ?>

<?php
	$role = JAdministrator::RoleOnComponent(5);	
	JToolBarHelper::title( JText::_( 'ECO_MANAGEMET' ), 'addedit.png' );
	
	if (in_array("V", $role)) {
		JToolBarHelper::customX('export', 'excel', '', 'Export', false);
	}	
	if (in_array("D", $role)) {
		//JToolBarHelper::deleteList('Are you sure to delete it(s)?');
	}
	if (in_array("E", $role)) {
		//JToolBarHelper::editListX();
	}
	if (in_array("W", $role)) {
		JToolBarHelper::addNewX();
	}
	

?>
<script language="javascript">
function submitbutton(pressbutton) {
			var form = document.adminForm;			
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}
			if (pressbutton == 'add') {
				submitform( pressbutton );
				return;
			}
			if (pressbutton == 'edit') {
				submitform( pressbutton );
				return;
			}			
			if (pressbutton == 'remove') {
				submitform( pressbutton );
				return;
			}
			if (pressbutton == 'block') {
				submitform( pressbutton );
				return;
			}
			if (pressbutton == 'unblock') {
				submitform( pressbutton );
				return;
			}
			if (pressbutton == 'export') {
				submitform( pressbutton );
				form.task.value = '';
				return;
			}
		
}

</script>


<form action="index.php?option=com_apdmeco" method="post" name="adminForm">
<input type="hidden" name="query_exprot" value="<?php echo $this->lists['query'];?>" />
<input type="hidden" name="total_record" value="<?php echo $this->lists['total_record'];?>" />
	<table  width="100%">
		<tr>
			<td >
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" size="40" />
				&nbsp;&nbsp;<?php echo  JText::_('FILTER_DATE_CREATE').' '.JHTML::_('calendar', $this->lists['filter_date_created'], 'filter_date_created', 'filter_date_created', '%m-%d-%Y', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	
				&nbsp;&nbsp;
				<?php echo  JText::_('FILTER_DATE_MODIFIED').' '.JHTML::_('calendar', $this->lists['filter_date_modified'], 'filter_date_modified', 'filter_date_modified', '%m-%d-%Y', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="this.form.getElementById('search').value='';this.form.getElementById('filter_activate').value='-1';this.form.getElementById('filter_status').value='';this.form.getElementById('filter_date_created').value='';this.form.getElementById('filter_date_modified').value='';this.form.getElementById('filter_created_by').value='0';this.form.getElementById('filter_modified_by').value='0';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
				
			</td>			
			
		</tr>
		<tr>
			<td align="right"> 
			<?php echo $this->lists['active'];?>
			<?php echo $this->lists['status'];?>
			<?php echo $this->lists['create'];?>
			<?php echo $this->lists['modified'];?>
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
					<?php echo JHTML::_('grid.sort',   'Name', 'e.eco_name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th  class="title" >
					<?php echo JText::_( 'Description' ); ?>
				</th>
				
				
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   'Activate', 'e.eco_activate', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   'Life Cycle', 'e.eco_status', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="7%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   'Date Create', 'e.eco_create', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				
				<th width="10%" class="title">
					<?php echo JHTML::_('grid.sort',   'Create by', 'e.eco_create_by', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="7%" class="title">
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

				$img 	= $row->eco_activate ? 'tick.png' : 'publish_x.png';
				$task 	= $row->eco_activate ? 'block' : 'unblock';
				
				$alt 	= $row->eco_activate ? JText::_( 'Activate' ) : JText::_( 'Inactivate' );
				$link 	= 'index.php?option=com_apdmeco&amp;task=detail&amp;cid[]='. $row->eco_id. '';			
				
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td align="center">
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td align="center">
					<?php echo JHTML::_('grid.id', $i, $row->eco_id ); ?>
				</td>
				<td>
					<a href="<?php echo $link; ?>" title="<?php echo JText::_('Click to see detail ECO')?>">
						<?php echo $row->eco_name; ?></a>
				</td>				
				<td align="left">
					<?php echo $row->eco_description; ?>
				</td>
				<!--<td>
				<?php //if($row->eco_pdf !="") { ?>
					 <a href="index.php?option=com_apdmeco&task=download&id=<?php //echo $row->eco_id?>" title="<?php //echo JText::_('CLICK_HERE_TO_DOWNLOAD_FILE_PDF')?>"><img src="images/downloads_f2.png" width="16" height="16" border="0" alt="<?php //echo JText::_('CLICK_HERE_TO_DOWNLOAD_FILE_PDF')?>" /></a>
					<?php // }else{ ?>
					<img src="images/downloads.png" width="16" height="16" border="0" alt="<?php //echo JText::_('NONE_PDF_FILE')?>" />
					<?php //} ?>
					
				</td>-->
				<td align="center">
					<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
						<img src="images/<?php echo $img;?>" width="16" height="16" border="0" alt="<?php echo $alt; ?>" /></a>
				</td>
				<td>
					<?php echo $row->eco_status ; ?>
				</td>
				<td align="center">
					<?php echo  JHTML::_('date', $row->eco_create, '%m-%d-%Y'); ?>
				</td>
				<td>
					<?php echo GetValueUser($row->eco_create_by, 'username'); ?>
				</td>
				<td align="center">
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

	<input type="hidden" name="option" value="com_apdmeco" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>