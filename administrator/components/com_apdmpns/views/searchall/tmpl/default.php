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
	<!--	<tr>
			<td colspan="4"  >
				<?php echo JText::_( 'Search what' ); ?>:
				<input type="text" name="text_search" id="text_search" value="<?php echo $this->lists['search'];?>" class="text_area"  size="40" />&nbsp;&nbsp;<?php echo JText::_('Filter With')?> 
				<?php echo $this->lists['type_filter'];?>
				&nbsp;&nbsp;
			<input type="submit" name="btinsersave" value="<?php echo JText::_( 'Go' ); ?>" /> 
			<button onclick="document.adminForm.text_search.value='';document.adminForm.type_filter.value=0;document.adminForm.filter_status.value='';document.adminForm.filter_type.value='';document.adminForm.filter_created_by.value=0;document.adminForm.filter_modified_by.value=0;document.adminForm.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			
		</tr>-->
		<tr>
			
			<td align="right">
			<?php echo $this->lists['status'];?>
			
			<?php echo $this->lists['pns_type'];?>
			<?php echo $this->lists['pns_create_by'];?>
			<?php echo $this->lists['pns_modified_by'];?></td>
		</tr>
			
</table>
<?php 
if(($this->type_filter==0 || $this->type_filter==1) && count( $this->rs_eco ))
{
?>
<fieldset class="adminform">
<legend><?php echo JText::_( 'Eco Result' ); ?></legend>
<table class="adminlist" cellpadding="1">
<thead>
			<tr>
				<th width="2%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th class="title" width="10%">
                    <?php echo JHTML::_('grid.sort', 'ECO Number', 'eco_name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th  class="title" >
					<?php echo JText::_( 'Description' ); ?>
				</th>

<!--				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Activate'); ?>
				</th>-->
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('State'); ?>
				</th>
				<th width="7%" class="title" nowrap="nowrap">
                    <?php echo JHTML::_('grid.sort', 'Created Date', 'eco_create', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				
				<th width="10%" class="title">
					<?php echo JText::_('Created By'); ?>
				</th>
				<th width="7%" class="title">
					<?php echo JText::_('Modified Date'); ?>
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
				
				<td align="center">
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
<!--				<td align="center">
					<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
						<img src="images/<?php echo $img;?>" width="16" height="16" border="0" alt="<?php echo $alt; ?>" /></a>
				</td>-->
				<td align="center">
					<?php echo $row->eco_status ; ?>
				</td>
				<td align="center">
					<?php echo  JHTML::_('date', $row->eco_create, '%m-%d-%Y'); ?>
				</td>
				<td align="center">
					<?php echo GetValueUser($row->eco_create_by, 'name'); ?>
				</td>
				<td align="center">
						<?php echo ($row->eco_modified_by) ? JHTML::_('date', $row->eco_modified, '%m-%d-%Y') : ''; ?>
				</td>
				<td align="center">
					<?php echo GetValueUser($row->eco_modified_by, 'name'); ?>
				</td>
			</tr>
			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>                
               </table> 
</fieldset>
<?php 
}
if(($this->type_filter==0 || $this->type_filter==5  || $this->type_filter==6 || $this->type_filter==10 || $this->type_filter==8 || $this->type_filter==9) && count($this->rows) )
{
?>
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
					<?php echo JText::_( 'Where Used' ); ?>
				</th>
				<th  class="title" width="10%">
					<?php echo JText::_('ECO'); ?>
				</th>                             
				<th width="5%" class="title" >
					<?php echo JText::_( 'DOWNLOAD_PDF' ); ?>
				</th>
				
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('State'); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Type'); ?>
				</th>
				<th class="title"  >
					<?php echo JText::_( 'PNS_DESCRIPTION' ); ?>
				</th>
				<?php if($this->type_filter==8)
                                {
                                ?>
                                        <th width="20%" class="title">
                                                <?php echo JText::_( 'MFR Name' ); ?>
                                        </th>
                                        <th width="20%" class="title">
                                                <?php echo JText::_( 'MFG PN' ); ?>
                                        </th>                                     
                                <?php
                                }elseif($this->type_filter==9){
                                ?>
				<th width="20%" class="title">
					<?php echo JText::_( 'Vendor' ); ?>
				</th>
                                <th width="20%" class="title">
					<?php echo JText::_( 'Vendor PN' ); ?>
				</th>   
                                <?php 
                                }elseif($this->type_filter==10){
                                ?>
				<th width="20%" class="title">
					<?php echo JText::_( 'Supplier' ); ?>
				</th>
                                <th width="20%" class="title">
					<?php echo JText::_( 'Supplier PN' ); ?>
				</th>   
                                <?php 
                                }
                                else
                                {
                                ?><th width="20%" class="title">
                                                <?php echo JText::_( 'MFR Name' ); ?>
                                        </th>
                                        <th width="20%" class="title">
                                                <?php echo JText::_( 'MFG PN' ); ?>
                                        </th> 
                                      <?php 
                                }?>   
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
                                if($row->pns_cpn==1)
                                        $link 	= 'index.php?option=com_apdmpns&amp;task=detailmpn&cid[0]='.$row->pns_id;	
                                else
                                        $link 	= 'index.php?option=com_apdmpns&amp;task=detail&cid[0]='.$row->pns_id;					
                                if($row->pns_revision)
                                        $pns_code = $row->ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision;
                                else
                                        $pns_code = $row->ccs_code.'-'.$row->pns_code;
				if ($row->pns_image !=''){
					$pns_image = $path_image.$row->pns_image;
				}else{
					$pns_image = JText::_('NONE_IMAGE_PNS');
				}
				//echo $pns_image;
                if($this->type_filter==8){//manufacture
                        $mf = PNsController::GetManufacture($row->pns_id,4);
                }
                elseif($this->type_filter==9){//vendor
                        $mf = PNsController::GetManufacture($row->pns_id,2);
                }
                elseif($this->type_filter==10){//Supplier
                        $mf = PNsController::GetManufacture($row->pns_id,3);
                }
                else
                    $mf = PNsController::GetManufacture($row->pns_id,4);
				$bom = PNsController::GetChildParentNumber($row->pns_id);
                                $wheruse = PNsController::GetChildWhereNumber($row->pns_id);
                        
  
                                
                                
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td align="center">
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td align="left"><span class="editlinktip hasTip" title="<img border=&quot;1&quot; src=&quot;<?php echo $pns_image; ?>&quot; name=&quot;imagelib&quot; alt=&quot;<?php echo JText::_( 'No preview available' ); ?>&quot; width=&quot;100&quot; height=&quot;100&quot; />" >
					<a href="<?php echo $link;?>" title="<?php echo JText::_('Click to see detail PNs');?>"><?php echo $pns_code;?></a>
				</span>
				</td>	
				<td align="center">
				<?php if ($bom) { ?>
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
				<td align="center">
                                        <?php 
                                        $exist_pdf =PNsController::checkexistSpec($row->pns_id);
                                        if($exist_pdf) { ?>
					 <a href="index.php?option=com_apdmpns&task=specification&cid[]=<?php echo $row->pns_id?>" title="<?php echo JText::_('CLICK_HERE_TO_DOWNLOAD_FILE_PDF')?>"><img src="images/downloads_f2.png" width="16" height="16" border="0" alt="<?php echo JText::_('CLICK_HERE_TO_DOWNLOAD_FILE_PDF')?>" /></a>
					<?php }else{ ?>
					<img src="images/downloads.png" width="16" height="16" border="0" alt="<?php echo JText::_('NONE_PDF_FILE')?>" />
					<?php
				
					}?>                                        
					
				</td>
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
<?php 
}
if(($this->type_filter==0 || $this->type_filter==7 ) && count($this->rs_po))
{
?>
<fieldset class="adminform">
        <legend><?php echo JText::_("PO Result");?></legend>
            
                <table class="adminlist" cellpadding="1">
                        <thead>
                                <tr>
                                        <th width="10"><?php echo JText::_('NUM'); ?></th>
                                        <th width="100">
                                            <?php echo JHTML::_('grid.sort', 'P.O Number', 'po_code', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
                                        </th>
                                        <th width="100"><?php echo JText::_('Description'); ?></th>                                                
                                        <th width="100"><?php echo JText::_('Attached'); ?></th>
                                        <th width="100"><?php echo JHTML::_('grid.sort', JText::_('Created Date'),'po_created', @$this->lists['order_Dir'], @$this->lists['order'] ); ?></th>
                                        <th width="100"><?php echo JText::_('Owner'); ?></th>
                                        <th width="100"><?php echo JText::_(''); ?></th>
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
                                                <td align="center"><?php echo $i+$this->pagination->limitstart;?></td>                                            
                                                <td align="center"><a href="index.php?option=com_apdmpns&task=po_detail&id=<?php echo $po->pns_po_id; ?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $po->po_code; ?></a> </td>
                                                <td align="left"><?php echo $po->po_description; ?></td>                                                
                                                <td align="center">
                <?php if ($po->po_file) { ?>
                                                                <a href="index.php?option=com_apdmpns&task=download_po&id=<?php echo $po->pns_po_id; ?>" title="<?php echo JText::_('Click here to download') ?>" ><?php echo JText::_('Download') ?></a>&nbsp;&nbsp;
                                                        <?php } ?>
                                                </td>                                                
                                                <td align="center">
                                                        <?php echo JHTML::_('date', $po->po_created, '%m-%d-%Y %H:%M:%S'); ?>
                                                </td>
                                                <td align="center">
                                                        <?php echo GetValueUser($po->po_create_by, "name"); ?>
                                                </td>                                                  
                                                <td align="center"><?php if (in_array("E", $role)) {
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
<?php 
}
if(($this->type_filter==0 || $this->type_filter==3 || $this->type_filter==100 )&&count( $this->rs_supplier ))
{
?>
<fieldset class="adminform">
        <legend><?php echo JText::_( 'Supplier Result' ); ?></legend>
        <table class="adminlist" cellpadding="1">
		<thead>
			<tr>
				<th width="2%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th width="15%" class="title">
					<?php echo JText::_('Name' ); ?>
				</th>
				<th width="10%" class="title">
					<?php echo JText::_('Type' ); ?>
				</th>
				<th width="25%" class="title" >
					<?php echo JText::_( 'Description' ); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Activate' ); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Created Date'); ?>
				</th>
				
				<th width="15%" class="title">
					<?php echo JText::_('Created By' ); ?>
				</th>
				<th width="15%" class="title">
					<?php echo JText::_('Modified Date'); ?>
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
				<td align="center">
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td align="left">
					<a href="<?php echo $link; ?>" title="<?php echo JText::_('Click to see detail.')?>">
						<?php echo $row->info_name; ?></a>
				</td>
				<td align="center">
					<?php echo $type; ?>
				</td>
				<td  align="left" align="center">
					<?php echo $row->info_description; ?>
				</td>
				<td  align="center" align="center">
					<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
						<img src="images/<?php echo $img;?>" width="16" height="16" border="0" alt="<?php echo $alt; ?>" /></a>
				</td>
				<td align="center">
					<?php echo  JHTML::_('date', $row->info_create, '%m-%d-%Y'); ?>
				</td>
				<td align="center">
					<?php echo GetValueUser($row->info_created_by, 'name'); ?>
				</td>
				<td  align="center" nowrap="nowrap">
						<?php echo ($row->info_modified_by) ? JHTML::_('date', $row->info_modified, '%m-%d-%Y') : ''; ?>
				</td>
				<td align="center">
					<?php echo GetValueUser($row->info_modified_by, 'name'); ?>
				</td>
			</tr>
			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>
	</table>
</fieldset>
<?php 
}
if(($this->type_filter==0 || $this->type_filter==4 || $this->type_filter==88 )&&count( $this->rs_mf ))
{
?>
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
					<?php echo JText::_('Created Date'); ?>
				</th>
				
				<th width="15%" class="title">
					<?php echo JText::_('Create By' ); ?>
				</th>
				<th width="15%" class="title">
					<?php echo JText::_('Modified Date'); ?>
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
<?php 
}
if(($this->type_filter==0 || $this->type_filter==2 || $this->type_filter==99 )&& count( $this->rs_vendor ))
{
?>
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
					<?php echo JText::_('Created Date'); ?>
				</th>
				
				<th width="15%" class="title">
					<?php echo JText::_('Created By' ); ?>
				</th>
				<th width="15%" class="title">
					<?php echo JText::_('Modified Date'); ?>
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
				<td align="center">
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td align="left">
					<a href="<?php echo $link; ?>" title="<?php echo JText::_('Click to see detail.')?>">
						<?php echo $row->info_name; ?></a>
				</td>
				<td align="center">
					<?php echo $type; ?>
				</td>
				<td align="left">
					<?php echo $row->info_description; ?>
				</td>
				<td align="center">
					<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
						<img src="images/<?php echo $img;?>" width="16" height="16" border="0" alt="<?php echo $alt; ?>" /></a>
				</td>
				<td align="center">
					<?php echo  JHTML::_('date', $row->info_create, '%m-%d-%Y'); ?>
				</td>
				<td align="center">
					<?php echo GetValueUser($row->info_created_by, 'name'); ?>
				</td>
				<td align="center" nowrap="nowrap">
						<?php echo ($row->info_modified_by) ? JHTML::_('date', $row->info_modified, '%m-%d-%Y') : ''; ?>
				</td>
				<td align="center">
					<?php echo GetValueUser($row->info_modified_by, 'name'); ?>
				</td>
			</tr>
			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>
	</table>
</fieldset>
<?php 
}
if(($this->type_filter==0 || $this->type_filter==11) && count($this->rs_sto))
{
?>
<fieldset class="adminform">
        <legend><?php echo JText::_("Inventory Result");?></legend>
   <table class="adminlist" cellspacing="1" width="400">
                        <thead>
                                <tr>
                                        <th align="center" width="10"><?php echo JText::_('NUM'); ?></th>
                                        <th align="center" class="title" width="15%">
                                            <?php echo JHTML::_('grid.sort', 'ITO/ETO', 'sto_code', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
                                        </th>
                                        <th align="center" width="100"><?php echo JText::_('Description'); ?></th>                                                                                        
                                        <th align="center" width="100"><?php echo JHTML::_('grid.sort', JText::_('Created Date'),'sto_created', @$this->lists['order_Dir'], @$this->lists['order'] ); ?></th>
                                        <th align="center" width="100"><?php echo JText::_('Owner'); ?></th>
                                        <th align="center" width="100"><?php echo JText::_('Stocker'); ?></th>                                       
                                </tr>
                        </thead>
                        <tbody>					
        <?php
        $i = 0;
        foreach ($this->rs_sto as $sto) {
                $i++;
                $style="";
                if($sto->sto_type==2){
                        $style="color: #f00";
                }
                ?>
                                        <tr>
                                                <td align="center" style="<?php //echo $style?>" ><?php echo $i; ?></td>
                                                <td align="center" style="<?php echo $style?>" >
                                                    <?php
                                                    $link = "index.php?option=com_apdmsto&task=ito_detail&id=".$sto->pns_sto_id;
                                                    if($sto->sto_type==2){
                                                        $link = "index.php?option=com_apdmsto&task=eto_detail&id=".$sto->pns_sto_id;
                                                    }
                                                    ?>
                                                    <a style="<?php echo $style?>"  href="<?php echo $link; ?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $sto->sto_code; ?></a> </td>
                                                <td align="left" style="<?php //echo $style?>" ><?php echo $sto->sto_description; ?></td>
<!--                                                <td style="<?php echo $style?>" >
                                                <?php if ($sto->sto_file) { ?>
                                                                <a href="index.php?option=com_apdmpns&task=download_sto&id=<?php echo $sto->pns_sto_id; ?>" title="<?php echo JText::_('Click here to download') ?>" ><?php echo JText::_('Download') ?></a>&nbsp;&nbsp;
                                                        <?php } ?>
                                                </td>                                                -->
                                                <td align="center" style="<?php //echo $style?>" >
                                                        <?php echo JHTML::_('date', $sto->sto_created, '%m-%d-%Y %H:%M:%S'); ?>
                                                </td>
                                                <td align="center" style="<?php //echo $style?>" >
                                                        <?php echo GetValueUser($sto->sto_owner, "name"); ?>
                                                </td>     
                                                <td align="center" style="<?php //echo $style?>" >
                                                        <?php echo GetValueUser($sto->sto_stocker, "name"); ?>
                                                </td>
                                                
                                        </tr>
                                                <?php 
                                        } ?>
                </tbody>
        </table>		        
         </fieldset>
        <?php
}
if(($this->type_filter==0 || $this->type_filter==14) && count($this->rs_tto))
{
    ?>
    <fieldset class="adminform">
        <legend><?php echo JText::_("Tool Result");?></legend>
        <table class="adminlist" cellspacing="1" width="400">
            <thead>
            <tr class="header">
                <th  class="title" width="50"><?php echo JText::_('NUM'); ?></th>
                <th  class="title" width="100"><?php echo JText::_('TTO'); ?></th>
                <th  class="title" width="100"><?php echo JText::_('Description'); ?></th>
                <th  class="title" width="100"><?php echo JText::_('State'); ?></th>
                <th  class="title" width="100"><?php echo JText::_('Created Date'); ?></th>
                <th  class="title" width="100"><?php echo JText::_('Owner'); ?></th>
                <th  class="title" width="100"><?php echo JText::_('Created By'); ?></th>
                <th  class="title" width="100"><?php echo JText::_('Time Remain'); ?></th>
                <th  class="title" width="100"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 0;
            foreach ($this->rs_tto as $tto) {
                $i++;
                ?>
                <tr>
                    <td align="center"><?php echo $i+$this->pagination->limitstart;?></td>
                    <td align="center">
                        <?php
                        $style="";
                        $link = "index.php?option=com_apdmtto&task=tto_detail&id=".$tto->pns_tto_id;
                        $background="";
                        $remain_day = $tto->tto_remain;
                        if($remain_day<=0)
                        {
                            //$remain_day = 0;
                            $background= "style='background-color:#f00;color:#fff'";
                        }
                        elseif($remain_day<=3)
                        {
                            $background= "style='background-color:#ff0;color:#000'";
                        }

                        ?>
                        <a style="<?php echo $style?>" href="<?php echo $link;?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $tto->tto_code; ?></a> </td>

                    <td align="left" style="<?php echo $style?>" ><?php echo $tto->tto_description; ?></td>
                    <td align="center" style="<?php echo $style?>" >
                        <?php echo $tto->tto_state; ?>
                    </td>
                    <td align="center"  style="<?php echo $style?>" >
                        <?php echo JHTML::_('date', $tto->tto_created, '%m-%d-%Y %H:%M:%S'); ?>
                    </td>
                    <td align="center"  style="<?php echo $style?>" >
                        <?php echo GetValueUser($tto->tto_owner_out, "name"); ?>
                    </td>
                    <td align="center"  style="<?php echo $style?>" >
                        <?php echo GetValueUser($tto->tto_create_by, "name"); ?>
                    </td>
                    <td align="center"  <?php echo $background;?>> <?php echo $tto->tto_remain; ?></td>
                    <td align="center"  style="<?php echo $style?>" ><?php if (in_array("E", $role)) {

                            ?>
                            <a style="<?php echo $style?>"  href="<?php echo $link; ?>" title="Click to edit"><?php echo JText::_('Edit') ?></a>
                            <?php
                        }
                        ?>
                    </td></tr>
            <?php }
            ?>
            </tbody>
        </table>
    </fieldset>
    <?php
}
if(($this->type_filter==0 || $this->type_filter==12) && count($this->rs_so))
{      
        ?>
       
      <fieldset class="adminform">
		 <legend><?php echo JText::_("SO Result");?></legend>                                            
<?php 
if (count($this->rs_so) > 0) { ?>
                <table class="adminlist" cellspacing="1" width="400">
                        <thead>
                                <tr>
                                        <th width="20"><?php echo JText::_('NUM'); ?></th>
                                        <th width="100"><?php echo JHTML::_('grid.sort', 'SO', 'so_cuscode', @$this->lists['order_Dir'], @$this->lists['order'] ); ?></th>
                                        <th width="100"><?php echo JText::_('Customer'); ?></th>
                                        <th width="100"><?php echo JText::_('TOP ASSYS PN'); ?></th>                                        
                                        <th width="200"><?php echo JText::_('Description'); ?></th>
                                        <th width="100"><?php echo JHTML::_('grid.sort', JText::_('Start Date'), 'so_start_date', @$this->lists['order_Dir'], @$this->lists['order'] ); ?></th>
                                        <th width="100"><?php echo JHTML::_('grid.sort', JText::_('Shipping Request Date'), 'so_shipping_date', @$this->lists['order_Dir'], @$this->lists['order'] ); ?></th>
					                    <th width="50"><?php echo JText::_('Time Remain'); ?></th>
                                        <th width="50"><?php echo JText::_('Required'); ?></th>
                                        <th width="100"><?php echo JText::_('Status'); ?></th>
                                        <th width="50"><?php echo JText::_('RMA'); ?></th>
                                        <th width="200"><?php echo JText::_('LOG'); ?></th>
                                </tr>
                        </thead>                  
                        <tbody>					
        <?php
        $i = 0;
        foreach ($this->rs_so as $so) {
                $i++;
                if ($so->pns_cpn == 1)
                        $link = 'index.php?option=com_apdmpns&amp;task=detailmpn&cid[0]=' . $so->pns_id;
                else
                        $link = 'index.php?option=com_apdmpns&amp;task=detail&cid[0]=' . $so->pns_id;
                if ($so->pns_revision) {
                        $pnNumber = $so->ccs_code . '-' . $so->pns_code . '-' . $so->pns_revision;
                } else {
                        $pnNumber = $so->ccs_code . '-' . $so->pns_code;
                }
                $soNumber = $so->so_cuscode;
                if($so->ccs_so_code)
                {
                       $soNumber = $so->ccs_so_code."-".$soNumber;
                }       
				$background="";
                 $remain_day = $so->so_remain_date+1;                
                        if($remain_day<=0)
                        {       
                                $remain_day = 0;
                                if($so->so_state != 'done' && $so->so_state != 'cancel')
                                {
                                        $background= "style='background-color:#f00;color:#fff'";
                                }
                        }
                        elseif($remain_day<=3)
                        {        
                                if($so->so_state != 'done' && $so->so_state != 'cancel')
                                {
                                        $background= "style='background-color:#ff0;color:#000'";
                                }
                        }						
                ?>
                                        <tr>
                                                <td align="center"><?php echo $i;?></td>
                                                <td align="center"><a href="index.php?option=com_apdmpns&task=so_detail&id=<?php echo $so->pns_so_id; ?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $soNumber; ?></a> </td>
                                                <td align="center"><?php echo PNsController::getCcsName($so->customer_id); ?></td>
                                                <td align="left"><span class="editlinktip hasTip" title="<?php echo $pnNumber; ?>" >
                                                       <a href="<?php echo $link; ?>" title="<?php echo JText::_('Click to see detail PNs'); ?>"><?php echo $pnNumber; ?></a>
                                                </span></td>   
                                                <td align="left"><?php echo $so->pns_description; ?></td>
                                                <td align="center">
                                                 <?php echo JHTML::_('date', $so->so_start_date, JText::_('DATE_FORMAT_LC5')); ?>
                                                </td>     
                                                 <td align="center">
                                                <?php echo JHTML::_('date', $so->so_shipping_date, JText::_('DATE_FORMAT_LC5')); ?>
                                                </td> 
												 <td  align="center" <?php echo $background?>><?php echo $remain_day;?></td>
                                                <td align="center">
                                                        <?php
                                                                                        $required = array();
                                                                                        if ($so->fa_required) {
                                                                                                $required[] = "F.A";
                                                                                        }
                                                                                        if ($so->esd_required) {
                                                                                                $required[] = "ESD";
                                                                                        }
                                                                                        if ($so->coc_required) {
                                                                                                $required[] = "COC";
                                                                                        }
                                                                                        echo implode(",", $required);
                                                                                        ?>
                                                </td>
                                                <td align="center">
                                                        <?php echo PNsController::getSoStatus($so->so_state); ?>
                                                </td>
                                                <td align="center"><?php echo $so->rma; ?></td>
                                                <td align="center">
                                                     <?php echo $so->so_log; ?>
                                                </td></tr>
                                                <?php }
                                        } ?>
                </tbody>
        </table>
      </fieldset>

  <?php
}
if(($this->type_filter==0 || $this->type_filter==13) && count($this->rs_wo))
{      
        ?>
       
      <fieldset class="adminform">
		 <legend><?php echo JText::_("WO Result");?></legend>
               
<?php 
if (count($this->rs_wo) > 0) { ?>
                <table class="adminlist" cellspacing="1" width="400">
                        <thead>
                                <tr>
                                        <th width="50"><?php echo JText::_('NUM'); ?></th>
                                        <th width="100"><?php echo JText::_('WO'); ?></th>
                                        <th width="150"><?php echo JText::_('PN'); ?></th>
                                        <th width="250"><?php echo JText::_('Description'); ?></th>
                                        <th width="50"><?php echo JText::_('Qty'); ?></th>
                                        <th width="50"><?php echo JText::_('UOM'); ?></th>
                                        <th width="130"><?php echo JText::_('Start Date'); ?></th>
                                        <th width="130"><?php echo JText::_('Deadline'); ?></th>
                                        <th width="100"><?php echo JText::_('Time Remain(days)'); ?></th>                                        
                                        <th width="100"><?php echo JText::_('Status'); ?></th>
                                        <th width="50"><?php echo JText::_('Delay'); ?></th>
                                        <th width="50"><?php echo JText::_('Rework'); ?></th>
                                        <th width="100"><?php echo JText::_('LOG'); ?></th>                                        
                                </tr>
                        </thead>                  
                        <tbody>					
        <?php
        $i = 0;
        foreach ($this->rs_wo as $wo) {
                $i++;
                if ($so->pns_cpn == 1)
                        $link = 'index.php?option=com_apdmpns&amp;task=detailmpn&cid[0]=' . $wo->pns_id;
                else
                        $link = 'index.php?option=com_apdmpns&amp;task=detail&cid[0]=' . $wo->pns_id;
                if ($so->pns_revision) {
                        $pnNumber = $wo->ccs_code . '-' . $wo->pns_code . '-' . $wo->pns_revision;
                } else {
                        $pnNumber = $wo->ccs_code . '-' . $wo->pns_code;
                }
               
                $background="";
                $remain_day = $wo->wo_remain_date+1;
                
                        if($remain_day<=0)
                        {       
                                $remain_day = 0;
                                if($wo->wo_state != 'done' && $wo->wo_state != 'cancel')
                                {
                                        $background= "style='background-color:#f00;color:#fff'";
                                }
                        }
                        elseif($remain_day<=3)
                        {        
                                if($wo->wo_state != 'done' && $wo->wo_state != 'cancel')
                                {
                                        $background= "style='background-color:#ff0;color:#000'";
                                }
                        }
               
                ?>
                                        <tr>
                                                <td align="center"><?php echo $i;?></td>
                                                <td align="center"><a href="index.php?option=com_apdmpns&task=wo_detail&id=<?php echo $wo->pns_wo_id; ?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $wo->wo_code; ?></a> </td>
                                                <td align="left"><span class="editlinktip hasTip" title="<?php echo $pnNumber; ?>" >
                                                       <a href="<?php echo $link; ?>" title="<?php echo JText::_('Click to see detail PNs'); ?>"><?php echo $pnNumber; ?></a>
                                                </span></td>   
                                                <td align="left"><?php echo $wo->pns_description; ?></td>
                                                <td align="center"><?php echo $wo->wo_qty; ?></td>
                                                <td align="center"><?php echo $wo->pns_uom; ?></td>
                                                <td align="center">
                                                 <?php echo JHTML::_('date', $wo->wo_start_date, JText::_('DATE_FORMAT_LC5')); ?>
                                                </td>     
                                                 <td align="center">
                                                <?php echo JHTML::_('date', $wo->wo_completed_date, JText::_('DATE_FORMAT_LC5')); ?>
                                                </td> 
                                                <td align="center" <?php echo $background?>><?php echo $remain_day;?></td>
                                                  <td align="center"><?php echo PNsController::getWoStatus($wo->wo_state); ?></td>
                                                 <td align="center"><?php echo $wo->wo_delay;//PNsController::getDelayTimes($wo->pns_wo_id);?></td>
                                                  <td align="center"><?php echo (PNsController::getReworkStep($wo->pns_wo_id))?PNsController::getReworkStep($wo->pns_wo_id):0;?></td>
                                                <td>
                                                     <?php echo $wo->wo_log; ?>
                                                </td></tr>
                                                <?php }
                                        } ?>
                </tbody>
        </table>
      </fieldset>

  <?php
}
?>

	<div class="clr"></div>	
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="task" value="searchall" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
