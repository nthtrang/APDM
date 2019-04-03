<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php  JHTML::_('behavior.tooltip');  ?>

<?php
//get role of this compoment
	$role = JAdministrator::RoleOnComponent(1);	
	JToolBarHelper::title( JText::_( 'COMMODITY_CODE_MAMANGEMENT' ), 'generic.png' );	
	if (in_array("V", $role)) {
		JToolBarHelper::customX('export', 'excel', '', 'Export', false);
	}
	if (in_array("D", $role)) {
		JToolBarHelper::deleteList('Are you sure to delete it?');
	}
	if (in_array("E", $role)) {
		JToolBarHelper::editListX();
	}
	
	if (in_array("W", $role)) {
		JToolBarHelper::addNew();
                JToolBarHelper::customX('addcustomer', 'new', '', 'New Customer', false);
	}
	
	/*if (in_array("R", $role)) {
		JToolBarHelper::customX('trash', 'trash', '', 'Recycle Bin', false);
	}*/

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
			if (pressbutton == 'addcustomer') {
				submitform( pressbutton );				
				return;
			}                        
		
}

</script>
<form action="index.php?option=com_apdmccs" method="post" name="adminForm">
<input type="hidden" name="query_exprot" value="<?php echo $this->lists['query'];?>" />
<input type="hidden" name="total_record" value="<?php echo $this->lists['total_record'];?>" />

	<table  width="100%">
		<tr>
			<td >
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" size="40" />&nbsp;&nbsp;
				<?php echo  JText::_('FILTER_DATE_CREATE').' '.JHTML::_('calendar', $this->lists['filter_date_created'], 'filter_date_created', 'filter_date_created', '%m-%d-%Y', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>		
				&nbsp;&nbsp;<?php echo  JText::_('FILTER_DATE_MODIFIED').' '.JHTML::_('calendar', $this->lists['filter_date_modified'], 'filter_date_modified', 'filter_date_modified', '%m-%d-%Y', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>		
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="this.form.search.value='';this.form.filter_type.value='';this.form.filter_date_created.value='';this.form.filter_date_modified.value='';this.form.filter_created_by.value='0';this.form.filter_modified_by.value='0';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>						
			</td>
		
		</tr>
		<tr>
			<td align="right">
			<?php echo $this->lists['active'];?>
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
				<th class="title">
					<?php echo JHTML::_('grid.sort',   'TEXT_CCS_CODE', 'c.ccs_code', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="35%" class="title" >
					<?php echo JText::_('COMMODITY_CODE_DESCRIPTION'); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					
					<?php echo JHTML::_('grid.sort',   'TEXT_ACTIVATE', 'c.ccs_activate', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="10%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   'DATE_CREATE', 'c.ccs_create', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="10%" class="title">
					<?php echo JHTML::_('grid.sort',   'CREATED_BY', 'c.ccs_create_by', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="10%" class="title">
					<?php echo JHTML::_('grid.sort',   'DATE_MODIFIED', 'c.ccs_modified', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="10%" class="title">
					<?php echo JHTML::_('grid.sort',   'MODIFIED_BY', 'c.ccs_modified_by', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
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

				$img 	= $row->ccs_activate ? 'tick.png' : 'publish_x.png';
				$task 	= $row->ccs_activate ? 'block' : 'unblock';
				$alt 	= $row->ccs_activate ? JText::_( 'Enabled' ) : JText::_( 'Blocked' );
                                $link 	= 'index.php?option=com_apdmccs&amp;view=detail&amp;task=detail&amp;cid[]='. $row->ccs_id. '';
                                if($row->ccs_cpn==1)
                                        $link 	= 'index.php?option=com_apdmccs&amp;view=detail&amp;task=detailmpn&amp;cid[]='. $row->ccs_id. '';			
				$npns = CCsController::GetNumberOfPNs($row->ccs_id);
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
					<a href="<?php echo $link; ?>" title="<?php echo JText::_('Click to see detail of Commodity Code')?>">
						<?php echo $row->ccs_code; ?></a>
				</td>
				<td>
					<?php echo $row->ccs_description; //echo ($npns) ? '<a href="'.$link_pns.'">'.$npns.'</a>' : 0; ?>
				</td>				
				<td align="center">
					<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
						<img src="images/<?php echo $img;?>" width="16" height="16" border="0" alt="<?php echo $alt; ?>" /></a>
				</td>
				<td>
					<?php echo JHTML::_('date', $row->ccs_create, JText::_('DATE_FORMAT_LC6')) ; ?>
				</td>
				<td>					
						<?php echo $row->username; ?>
				</td>
				<td nowrap="nowrap">
					<?php echo ($row->ccs_modified_by) ? JHTML::_('date', $row->ccs_modified, JText::_('DATE_FORMAT_LC6')) : '' ; ?>
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

	<input type="hidden" name="option" value="com_apdmccs" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>