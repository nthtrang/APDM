<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php
	$role = JAdministrator::RoleOnComponent(6);
	JToolBarHelper::title( JText::_( 'PN Management' ) , 'cpanel.png' );
	if (in_array("W", $role)) {
		JToolBarHelper::addNew("add","New PN");
                JToolBarHelper::customX('addpncus', 'new', '', 'Mass Create PN', false);
	}  
     
//	if (in_array("E", $role)) {
//		JToolBarHelper::customX('next_upload_step1', 'upload', '', 'Multi Uploads CADs', false);
//		JToolBarHelper::customX('next_upload_step2', 'upload', '', 'Multi Uploads PDF', false);		
//	}     
	if (in_array("V", $role)) { 	
                JToolBarHelper::customX('export', 'excel', '', 'Export', false);	
	}
        
	if (in_array("D", $role)) {
                //viet comment
		//JToolBarHelper::deleteList('Are you sure to delete it(s)?');
	}
	if (in_array("E", $role)) {
		//JToolBarHelper::editListX();
		JToolBarHelper::customX('copy_filespec_pns', 'upload', '', 'Uploads Spec', false);	
	}	
	$cparams = JComponentHelper::getParams ('com_media');
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
			if (pressbutton == 'addpncus') {
				submitform( pressbutton );
				form.task.value = '';
				return;
			}                        
                        if (pressbutton == 'copy_filespec_pns') {
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
				<?php echo JText::_( 'Search' ); ?>:
				<input type="text" name="text_search" id="text_search" value="<?php echo $this->lists['search'];?>" class="text_area"  size="40" />&nbsp;&nbsp;<?php echo JText::_('Filter')?> 
				<?php echo $this->lists['type_filter'];?>
				&nbsp;&nbsp;
			<button onclick="javascript: return submitbutton('submit')"><?php echo JText::_( 'Go' ); ?></button>
			<button onclick="document.adminForm.text_search.value='';document.adminForm.type_filter.value=0;document.adminForm.filter_status.value='';document.adminForm.filter_type.value='';document.adminForm.filter_created_by.value=0;document.adminForm.filter_modified_by.value=0;document.adminForm.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			
		</tr>
		<tr>
			
			<td align="right">
			<?php echo $this->lists['state'];?>
			
			<?php echo $this->lists['pns_type'];?>
			<?php echo $this->lists['pns_create_by'];?>
<!--			<?php echo $this->lists['pns_modified_by'];?></td>-->
		</tr>
			
</table>
<table class="adminlist" cellpadding="1">
		<thead>
			<tr>
				<th  align="center" width="2%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th align="center" width="3%" class="title">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->rows); ?>);" />
				</th>
				<th  align="center" class="title" width="15%">
					<?php echo JHTML::_('grid.sort',   JText::_('PART_NUMBER_CODE'), 'p.pns_code', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
          
				<th align="center" width="5%" class="title" >
					<?php echo JText::_( 'BOM' ); ?>
				</th>
                                <th align="center" width="5%" class="title" >
					<?php echo JText::_( 'Where Used' ); ?>
				</th>
				<th  align="center" class="title" width="10%">
					<?php echo JHTML::_('grid.sort',   JText::_('ECO'), 'p.eco_id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th  align="center" width="5%" class="title" >
					<?php echo JText::_( 'Download' ); ?>
				</th>
				
<!--				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   JText::_('Status'), 'p.pns_status', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>-->
				<th  align="center" width="5%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   JText::_('State'), 'p.pns_life_cycle', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>                                
				<th  align="center" width="5%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   JText::_('Type'), 'p.pns_type', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th align="center" width="25%" class="title"  >
					<?php echo JText::_( 'PNS_DESCRIPTION' ); ?>
				</th>
				
				<th align="center" width="10%" class="title">
					<?php echo JText::_( 'MFR Name' ); ?>
				</th>
                <th  align="left" width="10%" class="title">
					<?php echo JText::_( 'MFG PN' ); ?>
				</th>
<!--				<th width="20%" class="title">
					<?php echo JText::_( 'Cost' ); ?>
				</th>   -->
<!--				<th width="20%" class="title">
					<?php echo JText::_( 'Date In' ); ?>
				</th>       -->
				<th  align="center" width="10%" class="title">
					<?php echo JText::_( 'Inventory' ); ?>
                                        <?php //echo JHTML::_('grid.sort',   JText::_('Stock'), 'p.pns_stock', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>    
<!--				<th width="20%" class="title">
					<?php echo JText::_( 'Qty Used' ); ?>
				</th>  
				<th width="20%" class="title">
					<?php echo JText::_( 'Qty Remain' ); ?>
				</th>                                    -->
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
                                if($row->pns_cpn==1)
                                        $link 	= 'index.php?option=com_apdmpns&amp;task=detailmpn&cid[0]='.$row->pns_id;	
                                else
                                        $link 	= 'index.php?option=com_apdmpns&amp;task=detail&cid[0]='.$row->pns_id;	
                                if($row->pns_revision)
                                        $pns_code = $row->ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision;
                                else
                                        $pns_code = $row->ccs_code.'-'.$row->pns_code;
                                $image = PNsController::GetImagePreview($row->pns_id);
				if ($image !=''){					
                                        $pns_image = "<img border=&quot;1&quot; src='".$path_image.$image."' name='imagelib' alt='".JText::_( 'No preview available' )."' width='100' height='100' />";
				}else{
					$pns_image = JText::_('None image for preview');
				}

                                
				//echo $pns_image;
				$mf = PNsController::GetManufacture($row->pns_id);
				$bom = PNsController::GetChildParentNumber($row->pns_id);
                                $wheruse = PNsController::GetChildWhereNumber($row->pns_id);
                        
  
                                
                                
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td style="text-align: center !important;">
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td style="text-align: center !important;">
					<?php echo JHTML::_('grid.id', $i, $row->pns_id ); ?>
				</td>
				<td align="left"><span class="editlinktip hasTip" title="<?php echo $pns_image;?>" >
					<a href="<?php echo $link;?>" title="<?php echo JText::_('Click to see detail PNs');?>"><?php echo $pns_code;?></a>
				</span>
				</td>	
                              
				<td align="center">
				<?php if ($bom) {                                       
                                ?>
				<a href="index.php?option=com_apdmpns&task=bom&id=<?php echo $row->pns_id; ?>" title="<?php echo JText::_('LINK_PART_HIERARCHY')?>" >
					<img src="images/search_f2.png" width="16" height="16" border="0" title="<?php echo JText::_('LINK_PART_HIERARCHY')?>" alt="<?php echo JText::_('LINK_PART_HIERARCHY')?>" /></a>
				<?php } else {?>
					<img src="images/search.png" width="16" height="16" border="0" title="<?php echo JText::_('NO_PART_HIERARCHY')?>" alt="<?php echo JText::_('NO_PART_HIERARCHY')?>" />
				<?php } ?>
	
				</td>
                <td align="center">
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
				<td style="text-align: center !important;">
					<?php 
                                        $exist_pdf =PNsController::checkexistSpec($row->pns_id);
                                        if($exist_pdf) { ?>
					 <a href="index.php?option=com_apdmpns&task=specification&cid[]=<?php echo $row->pns_id?>" title="<?php echo JText::_('CLICK_HERE_TO_DOWNLOAD_FILE_PDF')?>"><img src="images/downloads_f2.png" width="16" height="16" border="0" alt="<?php echo JText::_('CLICK_HERE_TO_DOWNLOAD_FILE_PDF')?>" /></a>
					<?php }else{ ?>
					<img src="images/downloads.png" width="16" height="16" border="0" alt="<?php echo JText::_('NONE_PDF_FILE')?>" />
					<?php
				
					}?>
				</td>
<!--				<td align="center">
					<?php echo $row->pns_status;?>
				</td>-->
				<td align="center">
					<?php echo $row->pns_life_cycle;?>
				</td>                                                                
				<td align="center">
					<?php echo $row->pns_type;?>
				</td>
				<td align="left">
					<?php echo  $row->pns_description; ?>
				</td>
				<td align="left">
					<?php 
					if (count($mf) > 0){
					foreach ($mf as $m){
						echo $m['mf'].' &nbsp;&nbsp;<br />';
					}
						
					}
					 ?>
				</td>	
                                <td align="left">
					<?php 
					if (count($mf) > 0){
					foreach ($mf as $m){
						echo $m['v_mf'].' &nbsp;&nbsp;<br />';
					}
						
					}
					 ?>
				</td>	
<!--                                <td align="center">
					<?php echo  number_format((float)$row->pns_cost, 2, '.', '');?>
				</td>   -->
<!--                                <td align="center">
					<?php echo  JHTML::_('date', $row->pns_datein, JText::_('DATE_FORMAT_LC6')); ?>
				</td>   -->
                                <td align="center">
					<?php //echo $row->pns_stock;?>
                                        <?php echo $stock = PNsController::CalculateInventoryValue($row->pns_id);?>
				</td>   
<!--                                <td align="center">
					<?php //echo $row->pns_qty_used;?>
                                        <?php echo $stockUsed = PNsController::CalculateQtyUsedValue($row->pns_id);?>
				</td>   
                                <td align="center">
					<?php echo round($stock - $stockUsed);?>
				</td>                                      -->
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
