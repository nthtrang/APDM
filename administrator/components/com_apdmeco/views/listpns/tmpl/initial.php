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
		JToolBarHelper::addPns("New",$cid[0]);
	} 
        
//	if (in_array("E", $role)) {
//		JToolBarHelper::editListX();
//	}
	if (in_array("D", $role)&& $this->rowEco->eco_status !="Released" && $this->rowEco->eco_status !="Inreview") {
		JToolBarHelper::deletePns('Are you sure to delete it?');
	}
	if (in_array("V", $role)) { 	
                // JToolBarHelper::customX("affected", 'affected', '', 'Affected Parts', false);
                JToolBarHelper::customX('saveinitial', 'save', '', 'Save', false);	
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
			if (pressbutton == 'saveinitial') {
				submitform( pressbutton );
				return;
			}    
                        if (pressbutton == 'approvers') {
                                window.location.assign("index.php?option=com_apdmeco&task=approvers&cid[]=<?php echo $cid[0]?>");
                                return;
                        }      
			if (pressbutton == 'cancel_listpns') {				
				submitform( pressbutton );
				return;
			}
                        if (pressbutton == 'cancel_listpns') {				
				submitform( pressbutton );
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
function checkForm(){
alert(43)
	if ($('boxchecked').value==0){
		alert('Please select file.');
		return false;
	}
	return true;
}
function isCheckedInitial(isitchecked,id){
	if (isitchecked == true){
		document.adminForm.boxchecked.value++;
                document.getElementById('init_plant_status_'+id).style.visibility= 'visible';
                document.getElementById('init_plant_status_'+id).style.display= 'block';
                document.getElementById('init_make_buy_'+id).style.visibility= 'visible';
                document.getElementById('init_make_buy_'+id).style.display= 'block';  
                document.getElementById('sp_init_leadtime_'+id).style.visibility= 'visible';
                document.getElementById('sp_init_leadtime_'+id).style.display= 'block';      
                document.getElementById('init_buyer_'+id).style.visibility= 'visible';
                document.getElementById('init_buyer_'+id).style.display= 'block';    
                document.getElementById('init_cost_'+id).style.visibility= 'visible';
                document.getElementById('init_cost_'+id).style.display= 'block';    
                document.getElementById('init_supplier_'+id).style.visibility= 'visible';
                document.getElementById('init_supplier_'+id).style.display= 'block';                    
                
                
                document.getElementById('text_init_plant_status_'+id).style.visibility= 'hidden';
                document.getElementById('text_init_plant_status_'+id).style.display= 'none';
                document.getElementById('text_init_make_buy_'+id).style.visibility= 'hidden';
                document.getElementById('text_init_make_buy_'+id).style.display= 'none';        
                document.getElementById('text_init_leadtime_'+id).style.visibility= 'hidden';
                document.getElementById('text_init_leadtime_'+id).style.display= 'none';              
                document.getElementById('text_init_buyer_'+id).style.visibility= 'hidden';
                document.getElementById('text_init_buyer_'+id).style.display= 'none';    
                document.getElementById('text_init_cost_'+id).style.visibility= 'hidden';
                document.getElementById('text_init_cost_'+id).style.display= 'none';    
                document.getElementById('text_init_supplier_'+id).style.visibility= 'hidden';
                document.getElementById('text_init_supplier_'+id).style.display= 'none';                    
	}
	else {
		document.adminForm.boxchecked.value--;
                document.getElementById('text_init_plant_status_'+id).style.visibility= 'visible';
                document.getElementById('text_init_plant_status_'+id).style.display= 'block';
                document.getElementById('text_init_make_buy_'+id).style.visibility= 'visible';
                document.getElementById('text_init_make_buy_'+id).style.display= 'block'; 
                document.getElementById('text_init_leadtime_'+id).style.visibility= 'visible';
                document.getElementById('text_init_leadtime_'+id).style.display= 'block';              
                document.getElementById('text_init_buyer_'+id).style.visibility= 'visible';
                document.getElementById('text_init_buyer_'+id).style.display= 'block';     
                document.getElementById('text_init_cost_'+id).style.visibility= 'visible';
                document.getElementById('text_init_cost_'+id).style.display= 'block';     
                document.getElementById('text_init_supplier_'+id).style.visibility= 'visible';
                document.getElementById('text_init_supplier_'+id).style.display= 'block';                     
                

                document.getElementById('init_plant_status_'+id).style.visibility= 'hidden';
                document.getElementById('init_plant_status_'+id).style.display= 'none';
                document.getElementById('init_make_buy_'+id).style.visibility= 'hidden';
                document.getElementById('init_make_buy_'+id).style.display= 'none';                    
                document.getElementById('sp_init_leadtime_'+id).style.visibility= 'hidden';
                document.getElementById('sp_init_leadtime_'+id).style.display= 'none';                     
                document.getElementById('init_buyer_'+id).style.visibility= 'hidden';
                document.getElementById('init_buyer_'+id).style.display= 'none';      
                document.getElementById('init_cost_'+id).style.visibility= 'hidden';
                document.getElementById('init_cost_'+id).style.display= 'none';      
                document.getElementById('init_supplier_'+id).style.visibility= 'hidden';
                document.getElementById('init_supplier_'+id).style.display= 'none';                      

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
			<li><a id="affected" href="index.php?option=com_apdmeco&task=affected&cid[]=<?php echo $this->rowEco->eco_id;?>"><?php echo JText::_( 'Affected Parts' ); ?></a></li>
			<li><a id="initial" class="active"><?php echo JText::_( 'Initial Data' ); ?></a></li>
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
<form action="index.php?option=com_apdmeco" method="post" name="adminForm" onsubmit="submitbutton('')" >
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
					<?php echo JText::_('Plant Status'); ?>
				</th>				

				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Make/Buy'); ?>
				</th>
                                <th class="title"  >
					<?php echo JText::_( 'Lead time' ); ?>
				</th>
                                <th class="title"  >
					<?php echo JText::_( 'Buyer' ); ?>
				</th>                                
				<th class="title"  >
					<?php echo JText::_( 'Cost' ); ?>
				</th>
				<th class="title"  >
					<?php echo JText::_( 'Supplier' ); ?>
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
                        $plant_status_arr = array();
                        $plant_status_arr[] = JHTML::_('select.option', 'Unreleased', JText::_('Unreleased') , 'value', 'text'); 
                        $plant_status_arr[] = JHTML::_('select.option', 'Prerelease', JText::_('Prerelease') , 'value', 'text'); 
                        $plant_status_arr[] = JHTML::_('select.option', 'BetaTest', JText::_('Beta Test') , 'value', 'text');
                        $plant_status_arr[] = JHTML::_('select.option', 'RFQ', JText::_('RFQ') , 'value', 'text');
                        $plant_status_arr[] = JHTML::_('select.option', 'Active', JText::_('Active') , 'value', 'text');
                        $plant_status_arr[] = JHTML::_('select.option', 'MFG', JText::_('MFG') , 'value', 'text');
                        $plant_status_arr[] = JHTML::_('select.option', 'Obsolete', JText::_('Obsolete') , 'value', 'text');                        
                                          
                        $make_buy_arr = array();
                        $make_buy_arr[] = JHTML::_('select.option', 'Make', JText::_('Make') , 'value', 'text'); 
                        $make_buy_arr[] = JHTML::_('select.option', 'Buy', JText::_('Buy') , 'value', 'text'); 
                        //select list manufacture

			for ($i=0, $n=count( $this->rowint ); $i < $n; $i++)
			{
       
				$row 	=& $this->rowint[$i];
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
                                        <input type="checkbox" id = "initial" onclick="isCheckedInitial(this.checked,<?php echo $row->pns_id;?>);" value="<?php echo $row->pns_id;?>" name="cid[]"  />
				</td>
				<td><span class="editlinktip hasTip" title="<img border=&quot;1&quot; src=&quot;<?php echo $pns_image; ?>&quot; name=&quot;imagelib&quot; alt=&quot;<?php echo JText::_( 'No preview available' ); ?>&quot; width=&quot;100&quot; height=&quot;100&quot; />" >
					<a href="<?php echo $link;?>" title="<?php echo JText::_('Click to see detail PNs');?>"><?php echo $pns_code;?></a>
				</span>
				</td>	
				
				<td align="center">
					<?php echo $row->pns_description; ?>
				</td>	
				<td align="center">					
                                        <span style="display:block" id="text_init_plant_status_<?php echo $row->pns_id;?>"><?php echo $row->init_plant_status;?></span>
                                         <?php                                         
                                         echo JHTML::_('select.genericlist',   $plant_status_arr, 'init_plant_status_'.$row->pns_id, 'class="inputbox" style="display:none" size="1" ', 'value', 'text', $row->init_plant_status ); 
                                        ?>
				</td>		                                
				<td align="center">
					<span style="display:block" id="text_init_make_buy_<?php echo $row->pns_id;?>"><?php echo $row->init_make_buy;?></span>
                                         <?php                                         
                                         echo JHTML::_('select.genericlist',   $make_buy_arr, 'init_make_buy_'.$row->pns_id, 'class="inputbox" style="display:none" size="1" ', 'value', 'text', $row->init_make_buy ); 
                                        ?>
				</td>
				<td align="center">
                                        <span style="display:block" id="text_init_leadtime_<?php echo $row->pns_id;?>"><?php echo JHTML::_('date', $row->init_leadtime, '%m-%d-%Y %H:%M:%S'); ?> </span>
                                        <span style="display:none" id="sp_init_leadtime_<?php echo $row->pns_id;?>">
                                        <?php echo JHTML::_('calendar', $row->init_leadtime, 'init_leadtime_'.$row->pns_id, 'due_date_'.$row->pns_id.'[]', '%Y-%m-%d %H:%M:%S', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	
					</span>
				</td>
                                <td align="center">
					 <span style="display:block" id="text_init_buyer_<?php echo $row->pns_id;?>"><?php echo $row->init_buyer;?></span>
                                         <input style="display:none" type="text" value="<?php echo $row->init_buyer;?>" id="init_buyer_<?php echo $row->pns_id;?>"  name="init_buyer_<?php echo $row->pns_id;?>" />
				</td>      
                                <td align="center">
					 <span style="display:block" id="text_init_cost_<?php echo $row->pns_id;?>"><?php echo $row->init_cost;?></span>
                                         <input style="display:none" type="text" value="<?php echo $row->init_cost;?>" id="init_cost_<?php echo $row->pns_id;?>"  name="init_cost_<?php echo $row->pns_id;?>" />
				</td>                                    
				<td align="center">
                                        <?php 
                                        $rowmf =& JTable::getInstance('apdmsupplierinfo');
                                        $rowmf->load($row->init_supplier);
                                       // $rowmf->load(18);
                                        $name_mf = $rowmf->info_name;                                        
                                        ?>
                                        <span style="display:block" id="text_init_supplier_<?php echo $row->pns_id;?>"><?php echo $name_mf;?></span>                                        
                                        <select style="display:none"  name="init_supplier_<?php echo $row->pns_id;?>"  id="init_supplier_<?php echo $row->pns_id;?>" >
                                                <option value="">Select Supplier</option>
                                                <?php 
                                                
                                                echo $row->init_supplier;
                                                foreach ($this->manufacture as $mf) { 
                                                        $selected = "";
                                                        if($mf->info_id===$row->init_supplier)
                                                                $selected ="selected";
                                                        ?>
                                                        <option value="<?php echo $mf->info_id; ?>" <?php echo $selected;?>><?php echo $mf->info_name; ?></option>
                                                <?php } ?>
                                        </select>                                               
				</td>
			                             
				<td>
					<?php 
     
if ($row->pns_life_cycle =='Create' || ($this->rowEco->eco_status !="Released" && $this->rowEco->eco_status !="Inreview")) {
		?>
                  <a href="<?php echo $edit_link;?>" class="toolbar">
<span class="icon-32-edit" title="Edit">
</span>
Edit
</a>
                                        <?php 
		
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
	<input type="hidden" name="option" value="com_apdmeco" />
	<input type="hidden" name="task" value="" />
        <input type="hidden" name="eco" value="<?php echo $cid[0]?>" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>



