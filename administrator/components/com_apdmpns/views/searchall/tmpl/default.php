<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php
	$role = JAdministrator::RoleOnComponent(6);
	JToolBarHelper::title( JText::_( 'SEARCH' ) , 'search.png' );

	
	$cparams = JComponentHelper::getParams ('com_media');
?>

<?php
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	
?>
<script language="javascript">
function submitbutton(pressbutton) {
			var form = document.adminForm;			
			if (pressbutton == 'submit') {
				var d = document.adminForm;
				if (d.text_search.value==""){
					alert("Please input keyword");	
					d.text_search.focus();
					return false;				
				}else{
					submitform( pressbutton );
				}
			}
			
		}

</script>
<form action="index.php?option=com_apdmpns&task=searchall" method="post" name="adminForm" onsubmit="submitbutton('')" >
<input type="hidden" name="query_exprot" value="<?php echo $this->lists['query'];?>" />
<input type="hidden" name="total_record" value="<?php echo $this->lists['total_record'];?>" />
<table  width="100%">
		<tr>
			<td colspan="4"  >
				<?php echo JText::_( 'Search what' ); ?>:
				<input type="text" name="text_search" id="text_search" value="<?php echo $this->lists['search'];?>" class="text_area"  size="40" />&nbsp;&nbsp;<?php echo JText::_('Filter With')?> 
				<?php echo $this->lists['type_filter'];?>
				&nbsp;&nbsp;
			<input type="submit" name="btinsersave" value="<?php echo JText::_( 'Go' ); ?>" /> 
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
<fieldset class="adminform">
<legend><?php echo JText::_( 'Eco Result' ); ?></legend>
<table class="adminlist" cellpadding="1">
<thead>
			<tr>
				<th width="2%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th class="title" width="10%">
					<?php echo JText::_( 'Name'); ?>
				</th>
				<th  class="title" >
					<?php echo JText::_( 'Description' ); ?>
				</th>

				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Activate'); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Life Cycle'); ?>
				</th>
				<th width="7%" class="title" nowrap="nowrap">
					<?php echo JText::_('Date Create'); ?>
				</th>
				
				<th width="10%" class="title">
					<?php echo JText::_('Create by'); ?>
				</th>
				<th width="7%" class="title">
					<?php echo JText::_('Date Modified'); ?>
				</th>
				<th width="10%" class="title">
					<?php echo JText::_('Modified By'); ?>
				</th>				
			</tr>
		</thead>
<tbody>
		<?php
			$k = 0;
			for ($i=0, $n=count( $this->rs_eco ); $i < $n; $i++)
			{
				$row 	=& $this->rs_eco[$i];

				$img 	= $row->eco_activate ? 'tick.png' : 'publish_x.png';
				$task 	= $row->eco_activate ? 'block' : 'unblock';
				
				$alt 	= $row->eco_activate ? JText::_( 'Activate' ) : JText::_( 'Inactivate' );
				$link 	= 'index.php?option=com_apdmeco&amp;task=detail&amp;cid[]='. $row->eco_id. '';			
				
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td align="center">
					<?php echo $i+1+$this->pagination->limitstart;?>
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
</fieldset>
<fieldset class="adminform">
<legend><?php echo JText::_( 'PNs Result' ); ?></legend>
<table class="adminlist" cellpadding="1">
		<thead>
			<tr>
				<th width="2%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th class="title" width="15%">
					<?php echo JText::_('PART_NUMBER_CODE'); ?>
				</th>
				<th width="5%" class="title" >
					<?php echo JText::_( 'BOM' ); ?>
				</th>
                                <th width="5%" class="title" >
					<?php echo JText::_( 'PNS_PARENT' ); ?>
				</th>
				<th  class="title" width="10%">
					<?php echo JText::_('ECO'); ?>
				</th>                             
				<th width="5%" class="title" >
					<?php echo JText::_( 'DOWNLOAD_PDF' ); ?>
				</th>
				
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Status'); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Type'); ?>
				</th>
				<th class="title"  >
					<?php echo JText::_( 'PNS_DESCRIPTION' ); ?>
				</th>
				
				<th width="20%" class="title">
					<?php echo JText::_( 'PNS_MANUAFACTURE' ); ?>
				</th>
				<th width="20%" class="title">
					<?php echo JText::_( 'Cost' ); ?>
				</th>   
<!--				<th width="20%" class="title">
					<?php echo JText::_( 'Date In' ); ?>
				</th>       -->
				<th width="20%" class="title">
					<?php echo JText::_( 'Inventory' ); ?>
				</th>    
<!--				<th width="20%" class="title">
					<?php echo JText::_( 'Qty Used' ); ?>
				</th>  
				<th width="20%" class="title">
					<?php echo JText::_( 'Qty Remain' ); ?>
				</th>                                    -->
			</tr>
		</thead>
		
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
				<td><span class="editlinktip hasTip" title="<img border=&quot;1&quot; src=&quot;<?php echo $pns_image; ?>&quot; name=&quot;imagelib&quot; alt=&quot;<?php echo JText::_( 'No preview available' ); ?>&quot; width=&quot;100&quot; height=&quot;100&quot; />" >
					<a href="<?php echo $link;?>" title="<?php echo JText::_('Click to see detail PNs');?>"><?php echo $pns_code;?></a>
				</span>
				</td>	
				<td>
				<?php if ($bom) { ?>
				<a href="index.php?option=com_apdmpns&task=listpns&id=<?php echo $row->pns_id; ?>" title="<?php echo JText::_('LINK_PART_HIERARCHY')?>" >
					<img src="images/search_f2.png" width="16" height="16" border="0" title="<?php echo JText::_('LINK_PART_HIERARCHY')?>" alt="<?php echo JText::_('LINK_PART_HIERARCHY')?>" /></a>
				<?php } else {?>
					<img src="images/search.png" width="16" height="16" border="0" title="<?php echo JText::_('NO_PART_HIERARCHY')?>" alt="<?php echo JText::_('NO_PART_HIERARCHY')?>" />
				<?php } ?>
	
				</td>
                                <td>
				<?php if ($wheruse) { ?>
				<a href="index.php?option=com_apdmpns&task=list_where_used&id=<?php echo $row->pns_id; ?>" title="<?php echo JText::_('LINK_PART_HIERARCHY')?>" >
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
                                <td align="center">
					<?php echo $row->pns_cost;?>
				</td>   
<!--                                <td align="center">
					<?php echo  JHTML::_('date', $row->pns_datein, '%m-%d-%Y %H:%M:%S'); ?>
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
				</td>                                   -->
			</tr>
			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>
	</table>
</fieldset>
<fieldset class="adminform">
        <legend><?php echo JText::_("PO Result");?></legend>
            
                <table class="adminlist" cellpadding="1">
                        <thead>
                                <tr>
                                        <th width="100"><?php echo JText::_('No'); ?></th>                                               
                                        <th width="100"><?php echo JText::_('P.O Number'); ?></th>
                                        <th width="100"><?php echo JText::_('Description'); ?></th>                                                
                                        <th width="100"><?php echo JText::_('Attached'); ?></th>                                        
                                        <th width="100"><?php echo JText::_('Created Date'); ?></th>
                                        <th width="100"><?php echo JText::_('Owner'); ?></th>
                                        <th width="100"><?php echo JText::_('Action'); ?></th>
                                </tr>
                        </thead>
                 
                        <tbody>					
        <?php
                        $k = 0;
			for ($i=0, $n=count( $this->rs_po ); $i < $n; $i++)
			{
				$po 	=& $this->rs_po[$i];

                ?>
                                      <tr class="<?php echo "row$k"; ?>">
                                                <td><?php echo $i+$this->pagination->limitstart;?></td>                                            
                                                <td><a href="index.php?option=com_apdmpns&task=po_detail&id=<?php echo $po->pns_po_id; ?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $po->po_code; ?></a> </td>
                                                <td><?php echo $po->po_description; ?></td>                                                
                                                <td>
                <?php if ($po->po_file) { ?>
                                                                <a href="index.php?option=com_apdmpns&task=download_po&id=<?php echo $po->pns_po_id; ?>" title="<?php echo JText::_('Click here to download') ?>" ><?php echo JText::_('Download') ?></a>&nbsp;&nbsp;
                                                        <?php } ?>
                                                </td>                                                
                                                <td>
                                                        <?php echo JHTML::_('date', $po->po_created, '%m-%d-%Y %H:%M:%S'); ?>
                                                </td>
                                                <td>
                                                        <?php echo GetValueUser($po->po_create_by, "username"); ?>
                                                </td>                                                  
                                                <td><?php if (in_array("E", $role)) {
                                                        ?>
                                                        <a href="index.php?option=com_apdmpns&task=edit_po&id=<?php echo $po->pns_po_id; ?>" title="Click to edit"><?php echo JText::_('Edit') ?></a>
                                                        <?php
                                                }
                                                        ?>                                                        
                                                </td></tr>
                                                <?php }
                                         ?>
                </tbody>
        </table>		
</fieldset>
<fieldset class="adminform">
        <legend><?php echo JText::_( 'Supplier Result' ); ?></legend>
        <table class="adminlist" cellpadding="1">
		<thead>
			<tr>
				<th width="2%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th class="title">
					<?php echo JText::_('Name' ); ?>
				</th>
				<th class="title">
					<?php echo JText::_('Type' ); ?>
				</th>
				<th width="15%" class="title" >
					<?php echo JText::_( 'Description' ); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Activate' ); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Date Create'); ?>
				</th>
				
				<th width="15%" class="title">
					<?php echo JText::_('Create by' ); ?>
				</th>
				<th width="15%" class="title">
					<?php echo JText::_('Date Modified'); ?>
				</th>
				<th width="10%" class="title">
					<?php echo JText::_('Modified By' ); ?>
				</th>				
			</tr>
		</thead>
		<tbody>
		<?php
			$k = 0;
			for ($i=0, $n=count( $this->rs_supplier ); $i < $n; $i++)
			{
				$row 	=& $this->rs_supplier[$i];

				$img 	= $row->info_activate ? 'tick.png' : 'publish_x.png';
				$task 	= $row->info_activate ? 'block' : 'unblock';
				$alt 	= $row->info_activate ? JText::_( 'Activate' ) : JText::_( 'Inactivate' );
				$link 	= 'index.php?option=com_apdmsuppliers&amp;task=detail&amp;cid[]='. $row->info_id. '';
				$type = '';
				if ($row->info_type ==2) $type = 'Vendor';
				if ($row->info_type ==3) $type = 'Supplier';
				if ($row->info_type ==4) $type = 'Manufacture';
				
				/*if ($row->lastvisitDate == "0000-00-00 00:00:00") {
					$lvisit = JText::_( 'Never' );
				} else {
					$lvisit	= JHTML::_('date', $row->lastvisitDate, '%Y-%m-%d %H:%M:%S');
				}*/
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td>
					<a href="<?php echo $link; ?>" title="<?php echo JText::_('Click to see detail.')?>">
						<?php echo $row->info_name; ?></a>
				</td>
				<td>
					<?php echo $type; ?>
				</td>
				<td align="center">
					<?php echo $row->info_description; ?>
				</td>
				<td align="center">
					<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
						<img src="images/<?php echo $img;?>" width="16" height="16" border="0" alt="<?php echo $alt; ?>" /></a>
				</td>
				<td>
					<?php echo  JHTML::_('date', $row->info_create, '%m-%d-%Y'); ?>
				</td>
				<td>
					<?php echo GetValueUser($row->info_created_by, 'username'); ?>
				</td>
				<td nowrap="nowrap">
						<?php echo ($row->info_modified_by) ? JHTML::_('date', $row->info_modified, '%m-%d-%Y') : ''; ?>
				</td>
				<td>
					<?php echo GetValueUser($row->info_modified_by, 'username'); ?>
				</td>
			</tr>
			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>
	</table>
</fieldset>
<fieldset class="adminform">
        <legend><?php echo JText::_( 'Manufacture Result' ); ?></legend>
        <table class="adminlist" cellpadding="1">
		<thead>
			<tr>
				<th width="2%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th class="title">
					<?php echo JText::_('Name' ); ?>
				</th>
				<th class="title">
					<?php echo JText::_('Type' ); ?>
				</th>
				<th width="15%" class="title" >
					<?php echo JText::_( 'Description' ); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Activate' ); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Date Create'); ?>
				</th>
				
				<th width="15%" class="title">
					<?php echo JText::_('Create by' ); ?>
				</th>
				<th width="15%" class="title">
					<?php echo JText::_('Date Modified'); ?>
				</th>
				<th width="10%" class="title">
					<?php echo JText::_('Modified By' ); ?>
				</th>				
			</tr>
		</thead>
		<tbody>
		<?php
			$k = 0;
			for ($i=0, $n=count( $this->rs_mf ); $i < $n; $i++)
			{
				$row 	=& $this->rs_mf[$i];

				$img 	= $row->info_activate ? 'tick.png' : 'publish_x.png';
				$task 	= $row->info_activate ? 'block' : 'unblock';
				$alt 	= $row->info_activate ? JText::_( 'Activate' ) : JText::_( 'Inactivate' );
				$link 	= 'index.php?option=com_apdmsuppliers&amp;task=detail&amp;cid[]='. $row->info_id. '';
				$type = '';
				if ($row->info_type ==2) $type = 'Vendor';
				if ($row->info_type ==3) $type = 'Supplier';
				if ($row->info_type ==4) $type = 'Manufacture';
				
				/*if ($row->lastvisitDate == "0000-00-00 00:00:00") {
					$lvisit = JText::_( 'Never' );
				} else {
					$lvisit	= JHTML::_('date', $row->lastvisitDate, '%Y-%m-%d %H:%M:%S');
				}*/
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td>
					<a href="<?php echo $link; ?>" title="<?php echo JText::_('Click to see detail.')?>">
						<?php echo $row->info_name; ?></a>
				</td>
				<td>
					<?php echo $type; ?>
				</td>
				<td align="center">
					<?php echo $row->info_description; ?>
				</td>
				<td align="center">
					<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
						<img src="images/<?php echo $img;?>" width="16" height="16" border="0" alt="<?php echo $alt; ?>" /></a>
				</td>
				<td>
					<?php echo  JHTML::_('date', $row->info_create, '%m-%d-%Y'); ?>
				</td>
				<td>
					<?php echo GetValueUser($row->info_created_by, 'username'); ?>
				</td>
				<td nowrap="nowrap">
						<?php echo ($row->info_modified_by) ? JHTML::_('date', $row->info_modified, '%m-%d-%Y') : ''; ?>
				</td>
				<td>
					<?php echo GetValueUser($row->info_modified_by, 'username'); ?>
				</td>
			</tr>
			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>
	</table>
</fieldset>
<fieldset class="adminform">
        <legend><?php echo JText::_( 'Vendor Result' ); ?></legend>
        <table class="adminlist" cellpadding="1">
		<thead>
			<tr>
				<th width="2%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th class="title">
					<?php echo JText::_('Name' ); ?>
				</th>
				<th class="title">
					<?php echo JText::_('Type' ); ?>
				</th>
				<th width="15%" class="title" >
					<?php echo JText::_( 'Description' ); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Activate' ); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Date Create'); ?>
				</th>
				
				<th width="15%" class="title">
					<?php echo JText::_('Create by' ); ?>
				</th>
				<th width="15%" class="title">
					<?php echo JText::_('Date Modified'); ?>
				</th>
				<th width="10%" class="title">
					<?php echo JText::_('Modified By' ); ?>
				</th>				
			</tr>
		</thead>
		<tbody>
		<?php
			$k = 0;
			for ($i=0, $n=count( $this->rs_vendor ); $i < $n; $i++)
			{
				$row 	=& $this->rs_vendor[$i];

				$img 	= $row->info_activate ? 'tick.png' : 'publish_x.png';
				$task 	= $row->info_activate ? 'block' : 'unblock';
				$alt 	= $row->info_activate ? JText::_( 'Activate' ) : JText::_( 'Inactivate' );
				$link 	= 'index.php?option=com_apdmsuppliers&amp;task=detail&amp;cid[]='. $row->info_id. '';
				$type = '';
				if ($row->info_type ==2) $type = 'Vendor';
				if ($row->info_type ==3) $type = 'Supplier';
				if ($row->info_type ==4) $type = 'Manufacture';
				
				/*if ($row->lastvisitDate == "0000-00-00 00:00:00") {
					$lvisit = JText::_( 'Never' );
				} else {
					$lvisit	= JHTML::_('date', $row->lastvisitDate, '%Y-%m-%d %H:%M:%S');
				}*/
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td>
					<a href="<?php echo $link; ?>" title="<?php echo JText::_('Click to see detail.')?>">
						<?php echo $row->info_name; ?></a>
				</td>
				<td>
					<?php echo $type; ?>
				</td>
				<td align="center">
					<?php echo $row->info_description; ?>
				</td>
				<td align="center">
					<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
						<img src="images/<?php echo $img;?>" width="16" height="16" border="0" alt="<?php echo $alt; ?>" /></a>
				</td>
				<td>
					<?php echo  JHTML::_('date', $row->info_create, '%m-%d-%Y'); ?>
				</td>
				<td>
					<?php echo GetValueUser($row->info_created_by, 'username'); ?>
				</td>
				<td nowrap="nowrap">
						<?php echo ($row->info_modified_by) ? JHTML::_('date', $row->info_modified, '%m-%d-%Y') : ''; ?>
				</td>
				<td>
					<?php echo GetValueUser($row->info_modified_by, 'username'); ?>
				</td>
			</tr>
			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>
	</table>
</fieldset>
	<div class="clr"></div>	
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="task" value="searchall" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
