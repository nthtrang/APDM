<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	$role = JAdministrator::RoleOnComponent(6);
	JToolBarHelper::title( JText::_( 'PNS_MAMANGEMENT' ) , 'cpanel.png' );
	if (in_array("V", $role)) { ?>
	
	<?php	JToolBarHelper::customX('export', 'excel', '', 'Export', false);
	//	JToolBarHelper::editListX('detail', 'View Detail');
	}
	
	if (in_array("E", $role)) {
		JToolBarHelper::customX('multi_upload', 'upload', '', 'Multi Uploads', false);
		
	}
		
	if (in_array("W", $role)) {
		JToolBarHelper::addNew();
	}
	if (in_array("E", $role)) {
		JToolBarHelper::editListX();
		
	}
	
	if (in_array("D", $role)) {
		JToolBarHelper::deleteList('Are you sure to delete it(s)?');
	}
	$cparams = JComponentHelper::getParams ('com_media');
?>

<?php
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	
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
			if (pressbutton == 'detail') {
				submitform( pressbutton );
				return;
			}
			if (pressbutton == 'remove') {
				submitform( pressbutton );
				return;
			}
			if (pressbutton == 'export') {
				submitform( pressbutton );
				form.task.value = '';
				return;
			}
			if (pressbutton == 'multi_upload') {
				submitform( pressbutton );
				return;
			}
			
			if (pressbutton == 'submit') {
				var d = document.adminForm;
				if (d.text_search.value==""){
					alert("Please input keyword");	
					d.text_search.focus();
					return false;				
				}else if(d.type_filter.value==0){
					alert("Please select type to filter");
					d.type_filter.focus();
					return false;
				}else{
					submitform( pressbutton );
				}
			}
			
		}

</script>
<form action="index.php?option=com_apdmpns" method="post" name="adminForm" onsubmit="submitbutton('')" >
<input type="hidden" name="query_exprot" value="<?php echo $this->lists['query'];?>" />
<input type="hidden" name="total_record" value="<?php echo $this->lists['total_record'];?>" />
<table  width="100%">
		<tr>
			<td colspan="4"  >
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="text_search" id="text_search" value="<?php echo $this->lists['search'];?>" class="text_area"  size="40" />&nbsp;&nbsp;<?php echo JText::_('Filter With')?> 
				<?php echo $this->lists['type_filter'];?>
				&nbsp;&nbsp;
			<button onclick="javascript: return submitbutton('submit')"><?php echo JText::_( 'Go' ); ?></button>
			<button onclick="document.getElementById('text_search').value='';this.form.getElementById('type_filter').value='0';this.form.getElementById('filter_status').value='';this.form.getElementById('filter_type').value='';this.form.getElementById('filter_created_by').value='0';this.form.getElementById('filter_modified_by').value='0';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			
		</tr>
		<tr>
			
			<td>
			<?php echo $this->lists['status'];?>
			</td>
			<td><?php echo $this->lists['pns_type'];?></td>
			<td><?php echo $this->lists['pns_create_by'];?></td>
			<td><?php echo $this->lists['pns_modified_by'];?></td>
		</tr>
			
</table>
<table class="adminlist" cellpadding="1">
		<thead>
			<tr>
				<th width="2%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th width="3%" class="title">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->rows); ?>);" />
				</th>
				<th class="title" width="15%">
					<?php echo JHTML::_('grid.sort',   JText::_('PART_NUMBER_CODE'), 'p.pns_code', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th  class="title" width="15%">
					<?php echo JHTML::_('grid.sort',   JText::_('ECO'), 'p.eco_id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="15%" class="title" >
					<?php echo JText::_( 'DOWNLOAD_PDF' ); ?>
				</th>
				
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   JText::_('Status'), 'p.pns_status', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   JText::_('Type'), 'p.pns_type', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th w class="title" >
					<?php echo JHTML::_('grid.sort',   JText::_('Date Create'), 'p.pns_create', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				
				<th w class="title">
					<?php echo JHTML::_('grid.sort',   JText::_('Create by'), 'p.pns_create_by', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th w class="title">
					<?php echo JHTML::_('grid.sort',   JText::_('Date Modified'), 'p.pns_modified', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th  class="title">
					<?php echo JHTML::_('grid.sort',   JText::_('Modified By'), 'p.pns_modified_by', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>				
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="11">
					<?php  echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php
			$path_image = '../uploads/pns/images/';
			$k = 0;
			for ($i=0, $n=count( $this->rows ); $i < $n; $i++)
			{
				$row 	=& $this->rows[$i];
				$link 	= 'index.php?option=com_apdmpns&amp;task=detail&cid[0]='.$row->pns_id;	
				if ($row->pns_revision !='')	{
					$pns_code = PNsController::GetNameCCs($row->ccs_id).'-'.$row->pns_code.'-'.$row->pns_revision;
				}else{
					$pns_code = PNsController::GetNameCCs($row->ccs_id).'-'.$row->pns_code;
				}
				if ($row->pns_image !=''){
					$pns_image = $path_image.$row->pns_image;
				}else{
					$pns_image = JText::_('NONE_IMAGE_PNS');
				}
				//echo $pns_image;
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td>
					<?php echo JHTML::_('grid.id', $i, $row->pns_id ); ?>
				</td>
				<td><span class="editlinktip hasTip" title="<img border=&quot;1&quot; src=&quot;<?php echo $pns_image; ?>&quot; name=&quot;imagelib&quot; alt=&quot;<?php echo JText::_( 'No preview available' ); ?>&quot; width=&quot;100&quot; height=&quot;100&quot; />" >
					<a href="<?php echo $link;?>" title="<?php echo JText::_('Click to see detail PNs');?>"><?php echo $pns_code;?></a>
				</span>
				</td>				
				<td align="center">
					<?php echo PNsController::GetECO($row->eco_id); ?>
				</td>
				<td>
					<?php if($row->pns_pdf !="") { ?>
					 <a href="index.php?option=com_apdmpns&task=download&id=<?php echo $row->pns_id?>" title="Click to download file pdf"><?php echo $row->pns_pdf;?></a>
					<?php }else{ echo JText::_('NONE_PDF_FILE');}?>
				</td>
				<td align="center">
					<?php echo $row->pns_status;?>
				</td>
				<td align="center">
					<?php echo $row->pns_type;?>
				</td>
				<td>
					<?php echo  JHTML::_('date', $row->pns_create, '%m-%d-%Y'); ?>
				</td>
				<td>
					<?php echo GetValueUser($row->pns_create_by, 'name'); ?>
				</td>
				<td nowrap="nowrap">
						<?php echo ($row->pns_modified !='0000-00-00 00:00:00') ? JHTML::_('date', $row->eco_modified, '%m-%d-%Y') : ''; ?>
				</td>
				<td>
					<?php echo GetValueUser($row->pns_modified_by, 'name'); ?>
				</td>
			</tr>
			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>
	</table>

	<div class="clr"></div>	
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
