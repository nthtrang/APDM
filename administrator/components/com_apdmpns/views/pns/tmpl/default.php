<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php
	$role = JAdministrator::RoleOnComponent(6);
	JToolBarHelper::title( JText::_( 'PNS_MAMANGEMENT' ) , 'cpanel.png' );
	if (in_array("E", $role)) {
		JToolBarHelper::customX('next_upload_step1', 'upload', '', 'Multi Uploads CADs', false);
		JToolBarHelper::customX('next_upload_step2', 'upload', '', 'Multi Uploads PDF', false);
		
	}
	if (in_array("V", $role)) { 	
      JToolBarHelper::customX('export', 'excel', '', 'Export', false);	
	}
	if (in_array("D", $role)) {
                //viet comment
		//JToolBarHelper::deleteList('Are you sure to delete it(s)?');
	}
	if (in_array("E", $role)) {
		JToolBarHelper::editListX();
		
	}
	if (in_array("W", $role)) {
		JToolBarHelper::addNew();
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
			if (pressbutton == 'next_upload_step2') {
				if (form.boxchecked.value==0){
					alert("Please select PNs to upload file!");
				}else if (form.boxchecked.value <=10) {
					submitform( pressbutton );
						return;
				}else{
					alert("Please chooes less than 10 PNs to upload file. Thanks");
					return false;
				}
				//
			
			}
			if (pressbutton == 'next_upload_step1') {
				if (form.boxchecked.value==0){
					alert("Please select PNs to upload file!");
				}else if (form.boxchecked.value <=5) {
					submitform( pressbutton );
						return;
				}else{
					alert("Please chooes less than 5 PNs to upload file. Thanks");
					return false;
				}
				//
			
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
			<button onclick="document.adminForm.text_search.value='';document.adminForm.type_filter.value=0;document.adminForm.filter_status.value='';document.adminForm.filter_type.value='';document.adminForm.filter_created_by.value=0;document.adminForm.filter_modified_by.value=0;document.adminForm.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			
		</tr>
		<tr>
			
			<td align="right">
			<?php echo $this->lists['status'];?>
			
			<?php echo $this->lists['pns_type'];?>
			<?php echo $this->lists['pns_create_by'];?>
			<?php echo $this->lists['pns_modified_by'];?></td>
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
				<th width="5%" class="title" >
					<?php echo JText::_( 'BOM' ); ?>
				</th>
                                <th width="5%" class="title" >
					<?php echo JText::_( 'PNS_PARENT' ); ?>
				</th>
				<th  class="title" width="10%">
					<?php echo JHTML::_('grid.sort',   JText::_('ECO'), 'p.eco_id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="5%" class="title" >
					<?php echo JText::_( 'DOWNLOAD_PDF' ); ?>
				</th>
				
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   JText::_('Status'), 'p.pns_status', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   JText::_('Type'), 'p.pns_type', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th class="title"  >
					<?php echo JText::_( 'PNS_DESCRIPTION' ); ?>
				</th>
				
				<th width="20%" class="title">
					<?php echo JText::_( 'PNS_MANUAFACTURE' ); ?>
				</th>
<!--				<th width="20%" class="title">
					<?php echo JText::_( 'Cost' ); ?>
				</th>   -->
				<th width="20%" class="title">
					<?php echo JText::_( 'Date In' ); ?>
				</th>       
				<th width="20%" class="title">
					<?php echo JText::_( 'Stock' ); ?>
				</th>    
				<th width="20%" class="title">
					<?php echo JText::_( 'Qty Used' ); ?>
				</th>  
				<th width="20%" class="title">
					<?php echo JText::_( 'Qty Remain' ); ?>
				</th>                                    
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="16">
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
				$pns_code = $row->ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision;
				if ($row->pns_image !=''){
					$pns_image = $path_image.$row->pns_image;
				}else{
					$pns_image = JText::_('NONE_IMAGE_PNS');
				}
				//echo $pns_image;
				$mf = PNsController::GetManufacture($row->pns_id);
				$bom = PNsController::GetChildParentNumber($row->pns_id);
                                $wheruse = PNsController::GetChildWhereNumber($row->pns_id);
                        
  
                                
                                
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
				<td>
				<?php if ($bom) {                                       
                                ?>
				<a href="index.php?option=com_apdmpns&task=bom&id=<?php echo $row->pns_id; ?>" title="<?php echo JText::_('LINK_PART_HIERARCHY')?>" >
					<img src="images/search_f2.png" width="16" height="16" border="0" title="<?php echo JText::_('LINK_PART_HIERARCHY')?>" alt="<?php echo JText::_('LINK_PART_HIERARCHY')?>" /></a>
				<?php } else {?>
					<img src="images/search.png" width="16" height="16" border="0" title="<?php echo JText::_('NO_PART_HIERARCHY')?>" alt="<?php echo JText::_('NO_PART_HIERARCHY')?>" />
				<?php } ?>
	
				</td>
                                <td>
				<?php if ($wheruse) { ?>
				<a href="index.php?option=com_apdmpns&task=whereused&id=<?php echo $row->pns_id; ?>" title="<?php echo JText::_('LINK_PART_HIERARCHY')?>" >
					<img src="images/search_f2.png" width="16" height="16" border="0" title="<?php echo JText::_('LINK_PART_HIERARCHY')?>" alt="<?php echo JText::_('LINK_PART_HIERARCHY')?>" /></a>
				<?php } else {?>
					<img src="images/search.png" width="16" height="16" border="0" title="<?php echo JText::_('NO_PART_HIERARCHY')?>" alt="<?php echo JText::_('NO_PART_HIERARCHY')?>" />
				<?php } ?>
	
				</td>
				<td align="center">
					<?php echo PNsController::GetECO($row->eco_id); ?>
				</td>
				<td>
					<?php if($row->pns_pdf !="") { ?>
					 <a href="index.php?option=com_apdmpns&task=download&id=<?php echo $row->pns_id?>" title="<?php echo JText::_('CLICK_HERE_TO_DOWNLOAD_FILE_PDF')?>"><img src="images/downloads_f2.png" width="16" height="16" border="0" alt="<?php echo JText::_('CLICK_HERE_TO_DOWNLOAD_FILE_PDF')?>" /></a>
					<?php }else{ ?>
					<img src="images/downloads.png" width="16" height="16" border="0" alt="<?php echo JText::_('NONE_PDF_FILE')?>" />
					<?php
				
					}?>
				</td>
				<td align="center">
					<?php echo $row->pns_status;?>
				</td>
				<td align="center">
					<?php echo $row->pns_type;?>
				</td>
				<td>
					<?php echo  $row->pns_description; ?>
				</td>
				<td>
					<?php 
					if (count($mf) > 0){
					foreach ($mf as $m){
						echo '<strong>-'.$m['mf'].': </strong>&nbsp;&nbsp;'.$m['v_mf'].'<br />';
					}
						
					}else{
						
					}
					 ?>
				</td>	
<!--                                <td align="center">
					<?php echo $row->pns_cost;?>
				</td>   -->
                                <td align="center">
					<?php echo  JHTML::_('date', $row->pns_datein, '%m-%d-%Y %H:%M:%S'); ?>
				</td>   
                                <td align="center">
					<?php echo $row->pns_stock;?>
				</td>   
                                <td align="center">
					<?php echo $row->pns_qty_used;?>
				</td>   
                                <td align="center">
					<?php echo round($row->pns_stock - $row->pns_qty_used);?>
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
