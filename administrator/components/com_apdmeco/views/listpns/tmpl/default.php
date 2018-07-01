<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	$role = JAdministrator::RoleOnComponent(5);
        $cid = JRequest::getVar( 'cid', array(0) );
	//$tabfiles = '<button onclick="javascript:hideMainMenu(); submitbutton(\'files\')" class="buttonfiles" style="vertical-align:middle"><span>Files </span></button>';
    //    $tabApprovers = '<button onclick="javascript:hideMainMenu(); submitbutton(\'approvers\')" class="buttonfiles" style="vertical-align:middle"><span>Approvers </span></button>';
     //   $tabSummary = '<button onclick="javascript:hideMainMenu(); submitbutton(\'summary\')" class="buttonfiles" style="vertical-align:middle"><span>Summary </span></button>';        
	//JToolBarHelper::title( JText::_( 'ADP ECO MAMANGEMENT' )  . ': <small><small>[ '. JText::_( 'Affected Parts Edit' ).' ]</small></small>'.$tabApprovers.$tabSummary, 'cpanel.png' );
	
	
        JToolBarHelper::title( JText::_($this->rowEco->eco_name));
	JToolBarHelper::cancel( 'cancel_listpns', 'Close' );
	if (in_array("E", $role) && $this->rowEco->eco_status !="Released" && $this->rowEco->eco_status !="Inreview") {
		JToolBarHelper::addPns("Add Part",$cid[0]);
                JToolBarHelper::addNew("new_part","New Part");        
	} 
        
//	if (in_array("E", $role)) {
//		JToolBarHelper::editListX();
//	}
	if (in_array("D", $role)&& $this->rowEco->eco_status !="Released" && $this->rowEco->eco_status !="Inreview") {
		JToolBarHelper::deletePns('Are you sure to delete it?');
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
                        if (pressbutton == 'summary') {
                                window.location.assign("index.php?option=com_apdmeco&task=detail&cid[]=<?php echo $cid[0]?>")
                                return;
                        }
//                        if (pressbutton == 'files') {
//                                window.location.assign("index.php?option=com_apdmeco&task=files&cid[]=<?php echo $cid[0]?>");
//                                return;
//                        }      
                        if (pressbutton == 'approvers') {
                                window.location.assign("index.php?option=com_apdmeco&task=approvers&cid[]=<?php echo $cid[0]?>");
                                return;
                        }      
			if (pressbutton == 'cancel_listpns') {				
				submitform( pressbutton );
				return;
			}
                        if (pressbutton == 'new_part') {				
				  window.location.assign("index.php?option=com_apdmpns&task=add&eco_id=<?php echo $cid[0]?>&eco_name=<?php echo $this->rowEco->eco_name?>");
				return;
			}
			if (pressbutton == 'export_bom') {				
				submitform( pressbutton );
				return;
			}
                        if(pressbutton == 'removepns')
                        {
                             submitform( pressbutton );
                             return;
                        }
}

</script>
<div class="submenu-box">
	<div class="t">
                <div class="t">
                        <div class="t"></div>
                </div>
        </div>
        <div class="m">
		<ul id="submenu" class="configuration">
			<li><a id="detail" href="index.php?option=com_apdmeco&task=detail&cid[]=<?php echo $this->rowEco->eco_id;?>"><?php echo JText::_( 'Detail' ); ?></a></li>
			<li><a id="affected" class="active"><?php echo JText::_( 'Affected Parts' ); ?></a></li>
			<li><a id="initial" href="index.php?option=com_apdmeco&task=initial&cid[]=<?php echo $this->rowEco->eco_id;?>"><?php echo JText::_( 'Initial Data' ); ?></a></li>
                        <li><a id="supporting" href="index.php?option=com_apdmeco&task=files&cid[]=<?php echo $this->rowEco->eco_id;?>"><?php echo JText::_( 'Supporting Document' ); ?></a></li>
                        <li><a id="routes" href="index.php?option=com_apdmeco&task=routes&cid[]=<?php echo $this->rowEco->eco_id;?>"><?php echo JText::_( 'Routes' ); ?></a></li>                     
		</ul>
		<div class="clr"></div>
        </div>
        <div class="b">
                <div class="b">
                        <div class="b"></div>
                </div>
        </div>
</div>
<div class="clr"></div>
<p>&nbsp;</p>
<form action="index.php?option=com_apdmpns" method="post" name="adminForm" onsubmit="submitbutton('')" >
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
					<?php echo  JText::_('PART_NUMBER_CODE'); ?>
                                </th>
				<th  class="title" width="10%">
					<?php echo  JText::_('PNS_DESCRIPTION'); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('State'); ?>
				</th>				
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Status'); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Type'); ?>
				</th>
                                <th class="title"  >
					<?php echo JText::_( 'Vendor' ); ?>
				</th>
                                <th class="title"  >
					<?php echo JText::_( 'Vendor_PN' ); ?>
				</th>                                
				<th class="title"  >
					<?php echo JText::_( 'Supplier' ); ?>
				</th>
				<th class="title"  >
					<?php echo JText::_( 'Supplier_PN' ); ?>
				</th>				
				<th width="20%" class="title">
					<?php echo JText::_( 'PNS_MANUAFACTURE' ); ?>
				</th>
				<th class="title">
					<?php echo JText::_( 'Action' ); ?>
				</th>                                
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
                                $edit_link = 'index.php?option=com_apdmpns&amp;task=edit&cid[0]='.$row->pns_id;	
				$pns_code = $row->ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision;
				if ($row->pns_image !=''){
					$pns_image = $path_image.$row->pns_image;
				}else{
					$pns_image = JText::_('NONE_IMAGE_PNS');
				}
				//echo $pns_image;
				$mf = EcoController::GetPnManufacture($row->pns_id);
				$mv = EcoController::GetPnVendor($row->pns_id);
                                $ms = EcoController::GetPnSupplier($row->pns_id);
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1;?>
				</td>
				<td>
					<?php echo JHTML::_('grid.id', $i, $row->pns_id ); ?>
				</td>
				<td><span class="editlinktip hasTip" title="<img border=&quot;1&quot; src=&quot;<?php echo $pns_image; ?>&quot; name=&quot;imagelib&quot; alt=&quot;<?php echo JText::_( 'No preview available' ); ?>&quot; width=&quot;100&quot; height=&quot;100&quot; />" >
					<a href="<?php echo $link;?>" title="<?php echo JText::_('Click to see detail PNs');?>"><?php echo $pns_code;?></a>
				</span>
				</td>	
				
				<td align="center">
					<?php echo $row->pns_description; ?>
				</td>
				<td align="center">
					<?php echo $row->pns_life_cycle; ?>
				</td>		
				<td align="center">
					<?php echo $row->pns_status; ?>
				</td>		                                
				<td align="center">
					<?php echo $row->pns_type;?>
				</td>
				<td align="center">
					<?php 
					if (count($mv) > 0){
                                                foreach ($mv as $m){
                                                        echo $m['vendor_name'];
                                                }
					}
					 ?>
				</td>
				<td align="center">
					<?php 
					if (count($mv) > 0){
                                                foreach ($mv as $m){
                                                        echo $m['vendor_info'];
                                                }
					}
					 ?>
				</td>   
				<td align="center">
					<?php 
					if (count($ms) > 0){
                                                foreach ($ms as $m){
                                                        echo $m['supplier_name'];
                                                }
					}
					 ?>
				</td>
				<td align="center">
					<?php 
					if (count($ms) > 0){
                                                foreach ($ms as $m){
                                                        echo $m['supplier_info'];
                                                }
					}
					 ?>
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
				<td>
					<?php 
     
if ($row->pns_life_cycle =='Create') {
		?>
                  <a href="<?php echo $edit_link;?>" class="toolbar">
<span class="icon-32-edit" title="Edit">
</span>
Edit
</a>
                                        <?php 
		
	}
        else
        {
                echo "Can not edit";
        }
        
					 ?>
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
        <input type="hidden" name="eco" value="<?php echo $cid[0]?>" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>



