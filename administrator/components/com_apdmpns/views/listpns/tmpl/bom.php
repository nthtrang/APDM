<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php
//bom
$row = $this->rows[0];
$pns_code_full = $row->pns_code_full;
 if (substr($pns_code_full, -1)=="-"){
   $pns_code_full = substr($pns_code_full, 0, strlen($pns_code_full)-1);  
 }
	$role = JAdministrator::RoleOnComponent(6);      
	JToolBarHelper::title( $pns_code_full , 'cpanel.png' );
	
	if (in_array("V", $role)) {
		JToolBarHelper::customX('export_bom', 'excel', '', 'Export', false);
	}
	if (in_array("V", $role)) { 	
                // JToolBarHelper::customX("affected", 'affected', '', 'Affected Parts', false);
                JToolBarHelper::customX('download', 'download', '', 'Download', false);	
	}
       
	if (in_array("D", $role)&& $row->pns_life_cycle =='Create') {           
		JToolBarHelper::deleteList('Are you sure to delete it(s)?','removepnbom');
	}
        if (in_array("E", $role)&& $row->pns_life_cycle =='Create') {
		JToolBarHelper::addPnsChild("Add Part Child",$this->lists['pns_id']);
        }   
	if (in_array("V", $role)&& $row->pns_life_cycle =='Create') { 	
                // JToolBarHelper::customX("affected", 'affected', '', 'Affected Parts', false);
                JToolBarHelper::customX('saveref', 'save', '', 'Save', false);	
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
			if (pressbutton == 'cancel_listpns') {				
				submitform( pressbutton );
				return;
			}
			if (pressbutton == 'export_bom') {				
				submitform( pressbutton );
				return;
			}
			if (pressbutton == 'removepnbom') {
				submitform( pressbutton );
				return;
			}
			if (pressbutton == 'addbomchild') {
				submitform( pressbutton );
				return;
			}             
			if (pressbutton == 'saveref') {
				submitform( pressbutton );
				return;
			}                              
			if (pressbutton == 'download') {
                                 window.location.assign("index.php?option=com_apdmpns&task=download_cad_all_pns&pns_id=<?php echo $this->lists['pns_id']?>")
                                 //window.location.assign("../uploads/pns/cads/<?php echo $row->ccs_code?>/<?php echo $row->pns_code_full?>/zip.php?step=2")
				//submitform( pressbutton );
				//form.task.value = '';
				return;
			}    
                        
}

function checkForm(){

	if ($('boxchecked').value==0){
		alert('Please select file.');
		return false;
	}
	return true;
}
function isCheckedBom(isitchecked,id){
       
	if (isitchecked == true){
		document.adminForm.boxchecked.value++;
                document.getElementById('find_number_'+id).style.visibility= 'visible';
                document.getElementById('find_number_'+id).style.display= 'block';
                document.getElementById('ref_des_'+id).style.visibility= 'visible';
                document.getElementById('ref_des_'+id).style.display= 'block';  
                document.getElementById('stock_'+id).style.visibility= 'visible';
                document.getElementById('stock_'+id).style.display= 'block';                  
                
                document.getElementById('text_find_number_'+id).style.visibility= 'hidden';
                document.getElementById('text_find_number_'+id).style.display= 'none';
                document.getElementById('text_ref_des_'+id).style.visibility= 'hidden';
                document.getElementById('text_ref_des_'+id).style.display= 'none';        
                document.getElementById('text_stock_'+id).style.visibility= 'hidden';
                document.getElementById('text_stock_'+id).style.display= 'none';                  
	}
	else {
		document.adminForm.boxchecked.value--;
                document.getElementById('text_find_number_'+id).style.visibility= 'visible';
                document.getElementById('text_find_number_'+id).style.display= 'block';
                document.getElementById('text_ref_des_'+id).style.visibility= 'visible';
                document.getElementById('text_ref_des_'+id).style.display= 'block'; 
                document.getElementById('text_stock_'+id).style.visibility= 'visible';
                document.getElementById('text_stock_'+id).style.display= 'block';   

                document.getElementById('find_number_'+id).style.visibility= 'hidden';
                document.getElementById('find_number_'+id).style.display= 'none';
                document.getElementById('ref_des_'+id).style.visibility= 'hidden';
                document.getElementById('ref_des_'+id).style.display= 'none';                    
                document.getElementById('stock_'+id).style.visibility= 'hidden';
                document.getElementById('stock_'+id).style.display= 'none';                     
	}
}

		elem.style.visibility = 'hidden';
		elem.style.display = 'none';
</script>
<div class="submenu-box">
	<div class="t">
                <div class="t">
                        <div class="t"></div>
                </div>
        </div>
        <div class="m">
		<ul id="submenu" class="configuration">
			<li><a id="detail" href="index.php?option=com_apdmpns&task=detail&cid[0]=<?php echo $this->lists['pns_id']?>"><?php echo JText::_( 'Detail' ); ?></a></li>
			<li><a id="bom"  class="active"><?php echo JText::_( 'BOM' ); ?></a></li>
			<li><a id="whereused" href="index.php?option=com_apdmpns&task=whereused&id=<?php echo $this->lists['pns_id']?>"><?php echo JText::_( 'Where Used' ); ?></a></li>
                        <li><a id="specification" href="index.php?option=com_apdmpns&task=specification&cid[]=<?php echo $this->lists['pns_id']?>"><?php echo JText::_( 'Specification' ); ?></a></li>
                        <li><a id="mep" href="index.php?option=com_apdmpns&task=mep&cid[]=<?php echo $this->lists['pns_id'];?>"><?php echo JText::_( 'MEP' ); ?></a></li>
                        <li><a id="rev" href="index.php?option=com_apdmpns&task=rev&cid[]=<?php echo $this->lists['pns_id'];?>"><?php echo JText::_( 'REV' ); ?></a></li>
                         <?php if($this->row->pns_cpn!=1){?>
                        <li><a id="dash" href="index.php?option=com_apdmpns&task=dash&cid[]=<?php echo $this->lists['pns_id'];?>"><?php echo JText::_( 'DASH ROLL' ); ?></a></li>
                        <li><a id="pos" href="index.php?option=com_apdmpns&task=po&cid[]=<?php echo $this->lists['pns_id'];?>"><?php echo JText::_( 'POs' ); ?></a></li>
                        <?php } ?>
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
<form action="index.php?option=com_apdmpns" method="post" name="adminForm">
<?php 

$list_pns_id = PNsController::DisplayPnsChildId($this->lists['pns_id'], $this->lists['pns_id']);

$new_pns = explode(",", $list_pns_id);
$list_pns = PNsController::DisplayPnsAllChildId($this->lists['pns_id']);
?>
<div> <input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $this->lists['pns_id'];?>" name="cid[]"  /> Level 0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?option=com_apdmpns&task=detail&cid[]=<?php echo $this->lists['pns_id']?>&cd=<?php echo $this->lists['pns_id']?>" title="<?php echo JText::_('Click to see detail PNs')?>"> <strong><?php echo $pns_code_full?> </strong></a></a>
        <table width="100%" class="adminlist" cellpadding="1">
	<thead>
		<tr>
                         <th width="8%">				
                             #
                        </th>                        
                        <th width="8%">
				
                                <input type="checkbox" name="CheckAll" value="0" onClick="checkboxBom(document.adminForm.bom)"/>
                        </th>
                        <th width="8%">
				<?php echo JText::_('Level')?>
			</th>                        
			<th width="45%" >
					<?php echo JText::_('Part Number')?>
			</th>
			<th width="15%">
				<?php echo JText::_('Desctiption')?>				
			</th>
			<th width="8%">
				<?php echo JText::_('Find Number')?>
			</th>
			<th width="6%">
				<?php echo JText::_('Ref des')?>
			</th>
			<th width="6%">
				<?php echo JText::_('Qty')?>
			</th>                     
			<th width="6%">
				<?php echo JText::_('UOM')?>
			</th>
			<th width="6%">
				<?php echo JText::_('MFG Name')?>
			</th>                        
                        <th width="6%">
				<?php echo JText::_('MFG PN')?>
			</th>                        
			<th width="6%">
				<?php echo JText::_('State')?>
			</th>

			
			
		</tr>
	</thead>
        <?php 
        //level1
        $level=0;
        $step=0;
        foreach ($list_pns as $row){
                $level++;
                $step++;
                $manufacture = PNsController::GetManufacture($row->pns_id);
                ?>
        <tr>
                <td><?php echo $step;?></td>
                <td><input  type="checkbox" id = "bom" onclick="isCheckedBom(this.checked,<?php echo $row->pns_id;?>);" value="<?php echo $row->pns_id;?>" name="cid[]"  /></td>                
                 <td>1</td>
		<td width="45%"><?php echo '<p style="height:25px"><a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'.$row->text.'</a></p> '; ?></td>		
                <td><span class="editlinktip hasTip" title="<?php echo $row->pns_description; ?>" ><?php echo limit_text($row->pns_description, 15);?></span></td>
                <td>
                        <span style="display:block" id="text_find_number_<?php echo $row->pns_id;?>"><?php echo $row->pns_find_number;?></span>
                        <input style="display:none" type="text" value="<?php echo $row->pns_find_number;?>" id="find_number_<?php echo $row->pns_id;?>"  name="find_number_<?php echo $row->pns_id;?>" />
                </td>
                <td>
                        <span style="display:block" id="text_ref_des_<?php echo $row->pns_id;?>"><?php echo $row->pns_ref_des;?></span>
                        <input style="display:none" type="text" value="<?php echo $row->pns_ref_des;?>" id="ref_des_<?php echo $row->pns_id;?>"  name="ref_des_<?php echo $row->pns_id;?>" />
                </td>
                <td>
                        <span style="display:block" id="text_stock_<?php echo $row->pns_id;?>"><?php echo $row->pns_stock;?></span>
                        <input style="display:none" type="text" value="<?php echo $row->pns_stock;?>" id="stock_<?php echo $row->pns_id;?>"  name="stock_<?php echo $row->pns_id;?>" />
                </td>
                <td><?php echo $row->pns_uom;?></td>
                <td><?php echo $manufacture[0]['mf'];?></td>
                <td><?php echo $manufacture[0]['v_mf'];?></td>
		<td><?php echo $row->pns_life_cycle;?></td>		
	</tr>
        <?php
                //level2
               $list_pns_c = PNsController::DisplayPnsAllChildId($row->pns_id); 
               if(isset($list_pns_c)&& sizeof($list_pns_c)>0)
               {
                        foreach ($list_pns_c as $row){
                                $step++;
                        $manufacture = PNsController::GetManufacture($row->pns_id);
                       ?>
                           <tr>
                                   <td><?php echo $step++;;?></td>
                                   <td><input  type="checkbox" id = "bom" onclick="isCheckedBom(this.checked,<?php echo $row->pns_id;?>);" value="<?php echo $row->pns_id;?>" name="cid[]"  /></td>                                 
                                   <td>2</td>
                                <td width="45%"><?php echo '<p style="margin-left:40px"><a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'.$row->text.'</a></p> '; ?></td>                                
                                <td><span class="editlinktip hasTip" title="<?php echo $row->pns_description; ?>" ><?php echo limit_text($row->pns_description, 15);?></span></td>
                                <td>
                                        <span style="display:block" id="text_find_number_<?php echo $row->pns_id;?>"><?php echo $row->pns_find_number;?></span>
                                        <input style="display:none" type="text" value="<?php echo $row->pns_find_number;?>" id="find_number_<?php echo $row->pns_id;?>"  name="find_number_<?php echo $row->pns_id;?>" />
                                </td>
                                <td>
                                        <span style="display:block" id="text_ref_des_<?php echo $row->pns_id;?>"><?php echo $row->pns_ref_des;?></span>
                                        <input style="display:none" type="text" value="<?php echo $row->pns_ref_des;?>" id="ref_des_<?php echo $row->pns_id;?>"  name="ref_des_<?php echo $row->pns_id;?>" />
                                </td>
                                <td>
                                        <span style="display:block" id="text_stock_<?php echo $row->pns_id;?>"><?php echo $row->pns_stock;?></span>
                                        <input style="display:none" type="text" value="<?php echo $row->pns_stock;?>" id="stock_<?php echo $row->pns_id;?>"  name="stock_<?php echo $row->pns_id;?>" />
                                </td>
                                <td><?php echo $row->pns_uom;?></td>
                                <td><?php echo $manufacture[0]['mf'];?></td>
                                <td><?php echo $manufacture[0]['v_mf'];?></td>
                                <td><?php echo $row->pns_life_cycle;?></td>
                                
                        </tr>
                             
                              <?php
                                //level3
                               $list_pns_3 = PNsController::DisplayPnsAllChildId($row->pns_id); 
                               if(isset($list_pns_3)&& sizeof($list_pns_3)>0)
                               {
                                        foreach ($list_pns_3 as $row3){
                                                $step++;
                                        $manufacture = PNsController::GetManufacture($row3->pns_id);
                                       ?>
                                           <tr>
                                                   <td><?php echo $step;?></td>
                                                   <td><input  type="checkbox" id = "bom" onclick="isCheckedBom(this.checked,<?php echo $row3->pns_id;?>);" value="<?php echo $row3->pns_id;?>" name="cid[]"  /></td>
                                                    <td>3</td>
                                                <td width="45%"><?php echo '<p style="margin-left:80px"><a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row3->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'.$row3->text.'</a></p> '; ?></td>                                               
                                                <td>
                                                        <span style="display:block" id="text_find_number_<?php echo $row3->pns_id;?>"><?php echo $row3->pns_find_number;?></span>
                                                        <input style="display:none" type="text" value="<?php echo $row3->pns_find_number;?>" id="find_number_<?php echo $row3->pns_id;?>"  name="find_number_<?php echo $row3->pns_id;?>" />
                                                </td>
                                                <td>
                                                        <span style="display:block" id="text_ref_des_<?php echo $row3->pns_id;?>"><?php echo $row3->pns_ref_des;?></span>
                                                        <input style="display:none" type="text" value="<?php echo $row3->pns_ref_des;?>" id="ref_des_<?php echo $row3->pns_id;?>"  name="ref_des_<?php echo $row3->pns_id;?>" />
                                                </td>
                                                <td>
                                                        <span style="display:block" id="text_stock_<?php echo $row3->pns_id;?>"><?php echo $row3->pns_stock;?></span>
                                                        <input style="display:none" type="text" value="<?php echo $row3->pns_stock;?>" id="stock_<?php echo $row3->pns_id;?>"  name="stock_<?php echo $row3->pns_id;?>" />
                                                </td>
                                                <td><?php echo $row3->pns_uom;?></td>
                                                <td><?php echo $manufacture[0]['mf'];?></td>
                                                 <td><?php echo $manufacture[0]['v_mf'];?></td>
                                                <td><?php echo $row3->pns_life_cycle;?></td>
                                                <td><span class="editlinktip hasTip" title="<?php echo $row3->pns_description; ?>" ><?php echo limit_text($row3->pns_description, 15);?></span></td>
                                        </tr>
                                               <?php
                                                //level4
                                               $list_pns_4 = PNsController::DisplayPnsAllChildId($row3->pns_id); 
                                               if(isset($list_pns_4)&& sizeof($list_pns_4)>0)
                                               {
                                                        foreach ($list_pns_4 as $row4){
                                                                $step++;
                                                                $manufacture = PNsController::GetManufacture($row4->pns_id);
                                                       ?>
                                                           <tr>
                                                                   <td><?php echo $step;?></td>
                                                                   <td><input  type="checkbox" id = "bom" onclick="isCheckedBom(this.checked,<?php echo $row4->pns_id;?>);" value="<?php echo $row4->pns_id;?>" name="cid[]"  /></td>
                                                                   <td>4</td>
                                                                <td width="45%"><?php echo '<p style="margin-left:120px"><a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row4->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'.$row4->text.'</a></p> '; ?></td>
                                                                <td><span class="editlinktip hasTip" title="<?php echo $row4->pns_description; ?>" ><?php echo limit_text($row4->pns_description, 15);?></span></td>
                                                                <td>
                                                                        <span style="display:block" id="text_find_number_<?php echo $row4->pns_id;?>"><?php echo $row4->pns_find_number;?></span>
                                                                        <input style="display:none" type="text" value="<?php echo $row4->pns_find_number;?>" id="find_number_<?php echo $row4->pns_id;?>"  name="find_number_<?php echo $row4->pns_id;?>" />
                                                                </td>
                                                                <td>
                                                                        <span style="display:block" id="text_ref_des_<?php echo $row4->pns_id;?>"><?php echo $row4->pns_ref_des;?></span>
                                                                        <input style="display:none" type="text" value="<?php echo $row4->pns_ref_des;?>" id="ref_des_<?php echo $row4->pns_id;?>"  name="ref_des_<?php echo $row4->pns_id;?>" />
                                                                </td>
                                                                <td>
                                                                        <span style="display:block" id="text_stock_<?php echo $row4->pns_id;?>"><?php echo $row4->pns_stock;?></span>
                                                                        <input style="display:none" type="text" value="<?php echo $row4->pns_stock;?>" id="stock_<?php echo $row4->pns_id;?>"  name="stock_<?php echo $row4->pns_id;?>" />
                                                                </td>
                                                                <td><?php echo $row4->pns_uom;?></td>
                                                                <td><?php echo $manufacture[0]['mf'];?></td>
                                                                <td><?php echo $manufacture[0]['v_mf'];?></td>
                                                                <td><?php echo $row4->pns_life_cycle;?></td>                                                                
                                                        </tr>
                                                                        <?php
                                                                        //level5
                                                                       $list_pns_5 = PNsController::DisplayPnsAllChildId($row4->pns_id); 
                                                                       if(isset($list_pns_5)&& sizeof($list_pns_5)>0)
                                                                       {
                                                                                foreach ($list_pns_5 as $row5){
                                                                                        $step++;
                                                                                        $manufacture = PNsController::GetManufacture($row5->pns_id);
                                                                               ?>
                                                                                   <tr>
                                                                                           <td><?php echo $step;?></td>
                                                                                           <td><input  type="checkbox" id = "bom" onclick="isCheckedBom(this.checked,<?php echo $row5->pns_id;?>);" value="<?php echo $row5->pns_id;?>" name="cid[]"  /></td>
                                                                                           <td>5</td>
                                                                                        <td width="45%"><?php echo '<p style="margin-left:140px"><a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row5->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'.$row5->text.'</a></p> '; ?></td>
                                                                                        <td><span class="editlinktip hasTip" title="<?php echo $row5->pns_description; ?>" ><?php echo limit_text($row5->pns_description, 15);?></span></td>
                                                                                        <td>
                                                                                                <span style="display:block" id="text_find_number_<?php echo $row5->pns_id;?>"><?php echo $row5->pns_find_number;?></span>
                                                                                                <input style="display:none" type="text" value="<?php echo $row5->pns_find_number;?>" id="find_number_<?php echo $row5->pns_id;?>"  name="find_number_<?php echo $row5->pns_id;?>" />
                                                                                        </td>
                                                                                        <td>
                                                                                                <span style="display:block" id="text_ref_des_<?php echo $row5->pns_id;?>"><?php echo $row5->pns_ref_des;?></span>
                                                                                                <input style="display:none" type="text" value="<?php echo $row5->pns_ref_des;?>" id="ref_des_<?php echo $row5->pns_id;?>"  name="ref_des_<?php echo $row5->pns_id;?>" />
                                                                                        </td>
                                                                                        <td>
                                                                                                <span style="display:block" id="text_stock_<?php echo $row5->pns_id;?>"><?php echo $row5->pns_stock;?></span>
                                                                                                <input style="display:none" type="text" value="<?php echo $row5->pns_stock;?>" id="stock_<?php echo $row5->pns_id;?>"  name="stock_<?php echo $row5->pns_id;?>" />
                                                                                        </td>
                                                                                        <td><?php echo $row5->pns_uom;?></td>
                                                                                        <td><?php echo $manufacture[0]['mf'];?></td>
                                                                                        <td><?php echo $manufacture[0]['v_mf'];?></td>
                                                                                        <td><?php echo $row5->pns_life_cycle;?></td>
                                                                                        
                                                                                </tr>
                                                                                                <?php
                                                                                                //level6
                                                                                               $list_pns_6 = PNsController::DisplayPnsAllChildId($row5->pns_id); 
                                                                                               if(isset($list_pns_6)&& sizeof($list_pns_6)>0)
                                                                                               {
                                                                                                        foreach ($list_pns_6 as $row6){
                                                                                                                $step++;
                                                                                                                $manufacture = PNsController::GetManufacture($row6->pns_id);
                                                                                                       ?>
                                                                                                           <tr>
                                                                                                                   <td><?php echo $step;?></td>
                                                                                                                   <td><input  type="checkbox" id = "bom" onclick="isCheckedBom(this.checked,<?php echo $row6->pns_id;?>);" value="<?php echo $row6->pns_id;?>" name="cid[]"  /></td>
                                                                                                                   <td>6</td>
                                                                                                                <td width="45%"><?php echo '<p style="margin-left:180px"><a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row6->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'.$row6->text.'</a></p> '; ?></td>
                                                                                                                <td><span class="editlinktip hasTip" title="<?php echo $row6->pns_description; ?>" ><?php echo limit_text($row6->pns_description, 15);?></span></td>
                                                                                                                <td>
                                                                                                                        <span style="display:block" id="text_find_number_<?php echo $row6->pns_id;?>"><?php echo $row6->pns_find_number;?></span>
                                                                                                                        <input style="display:none" type="text" value="<?php echo $row6->pns_find_number;?>" id="find_number_<?php echo $row6->pns_id;?>"  name="find_number_<?php echo $row6->pns_id;?>" />
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                        <span style="display:block" id="text_ref_des_<?php echo $row6->pns_id;?>"><?php echo $row6->pns_ref_des;?></span>
                                                                                                                        <input style="display:none" type="text" value="<?php echo $row6->pns_ref_des;?>" id="ref_des_<?php echo $row6->pns_id;?>"  name="ref_des_<?php echo $row6->pns_id;?>" />
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                        <span style="display:block" id="text_stock_<?php echo $row6->pns_id;?>"><?php echo $row6->pns_stock;?></span>
                                                                                                                        <input style="display:none" type="text" value="<?php echo $row6->pns_stock;?>" id="stock_<?php echo $row6->pns_id;?>"  name="stock_<?php echo $row6->pns_id;?>" />
                                                                                                                </td>
                                                                                                                <td><?php echo $row6->pns_uom;?></td>
                                                                                                                <td><?php echo $manufacture[0]['mf'];?></td>
                                                                                                                <td><?php echo $manufacture[0]['v_mf'];?></td>
                                                                                                                <td><?php echo $row6->pns_life_cycle;?></td>
                                                                                                                
                                                                                                        </tr>
                                                                                                                 <?php
                                                                                                                        //level7
                                                                                                                       $list_pns_7 = PNsController::DisplayPnsAllChildId($row6->pns_id); 
                                                                                                                       if(isset($list_pns_7)&& sizeof($list_pns_7)>0)
                                                                                                                       {
                                                                                                                                foreach ($list_pns_7 as $row7){
                                                                                                                                        $step++;
                                                                                                                                        $manufacture = PNsController::GetManufacture($row7->pns_id);
                                                                                                                               ?>
                                                                                                                                   <tr>
                                                                                                                                           <td><?php echo $step;?></td>
                                                                                                                                           <td><input  type="checkbox" id = "bom" onclick="isCheckedBom(this.checked,<?php echo $row7->pns_id;?>);" value="<?php echo $row7->pns_id;?>" name="cid[]"  /></td>
                                                                                                                                           <td>7</td>
                                                                                                                                        <td width="45%"><?php echo '<p style="margin-left:220px"><a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row7->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'.$row7->text.'</a></p> '; ?></td>
                                                                                                                                        <td><span class="editlinktip hasTip" title="<?php echo $row7->pns_description; ?>" ><?php echo limit_text($row7->pns_description, 15);?></span></td>
                                                                                                                                        <td>
                                                                                                                                                <span style="display:block" id="text_find_number_<?php echo $row7->pns_id;?>"><?php echo $row7->pns_find_number;?></span>
                                                                                                                                                <input style="display:none" type="text" value="<?php echo $row7->pns_find_number;?>" id="find_number_<?php echo $row7->pns_id;?>"  name="find_number_<?php echo $row7->pns_id;?>" />
                                                                                                                                        </td>
                                                                                                                                        <td>
                                                                                                                                                <span style="display:block" id="text_ref_des_<?php echo $row7->pns_id;?>"><?php echo $row7->pns_ref_des;?></span>
                                                                                                                                                <input style="display:none" type="text" value="<?php echo $row7->pns_ref_des;?>" id="ref_des_<?php echo $row7->pns_id;?>"  name="ref_des_<?php echo $row7->pns_id;?>" />
                                                                                                                                        </td>
                                                                                                                                        <td>
                                                                                                                                                <span style="display:block" id="text_stock_<?php echo $row7->pns_id;?>"><?php echo $row7->pns_stock;?></span>
                                                                                                                                                <input style="display:none" type="text" value="<?php echo $row7->pns_stock;?>" id="stock_<?php echo $row7->pns_id;?>"  name="stock_<?php echo $row7->pns_id;?>" />
                                                                                                                                        </td>
                                                                                                                                        <td><?php echo $row7->pns_uom;?></td>
                                                                                                                                         <td><?php echo $manufacture[0]['mf'];?></td>
                                                                                                                                       <td><?php echo $manufacture[0]['v_mf'];?></td>
                                                                                                                                        <td><?php echo $row7->pns_life_cycle;?></td>
                                                                                                                                        
                                                                                                                                </tr>
                                                                                                                                                  <?php
                                                                                                                                                //level8
                                                                                                                                               $list_pns_8 = PNsController::DisplayPnsAllChildId($row7->pns_id); 
                                                                                                                                               if(isset($list_pns_8)&& sizeof($list_pns_8)>0)
                                                                                                                                               {
                                                                                                                                                        foreach ($list_pns_8 as $row8){
                                                                                                                                                                $step++;
                                                                                                                                                                $manufacture = PNsController::GetManufacture($row8->pns_id);
                                                                                                                                                       ?>
                                                                                                                                                           <tr>
                                                                                                                                                                   <td><?php echo $step;?></td>
                                                                                                                                                                   <td><input  type="checkbox" id = "bom" onclick="isCheckedBom(this.checked,<?php echo $row8->pns_id;?>);" value="<?php echo $row8->pns_id;?>" name="cid[]"  /></td>
                                                                                                                                                                   <td>8</td>
                                                                                                                                                                <td width="45%"><?php echo '<p style="margin-left:240px"> <a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row8->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'.$row8->text.'</a></p> '; ?></td>
                                                                                                                                                                <td><span class="editlinktip hasTip" title="<?php echo $row8->pns_description; ?>" ><?php echo limit_text($row8->pns_description, 15);?></span></td>
                                                                                                                                                                <td>
                                                                                                                                                                        <span style="display:block" id="text_find_number_<?php echo $row8->pns_id;?>"><?php echo $row8->pns_find_number;?></span>
                                                                                                                                                                        <input style="display:none" type="text" value="<?php echo $row8->pns_find_number;?>" id="find_number_<?php echo $row8->pns_id;?>"  name="find_number_<?php echo $row8->pns_id;?>" />
                                                                                                                                                                </td>
                                                                                                                                                                <td>
                                                                                                                                                                        <span style="display:block" id="text_ref_des_<?php echo $row8->pns_id;?>"><?php echo $row8->pns_ref_des;?></span>
                                                                                                                                                                        <input style="display:none" type="text" value="<?php echo $row8->pns_ref_des;?>" id="ref_des_<?php echo $row8->pns_id;?>"  name="ref_des_<?php echo $row8->pns_id;?>" />
                                                                                                                                                                </td>
                                                                                                                                                                <td>
                                                                                                                                                                        <span style="display:block" id="text_stock_<?php echo $row8->pns_id;?>"><?php echo $row8->pns_stock;?></span>
                                                                                                                                                                        <input style="display:none" type="text" value="<?php echo $row8->pns_stock;?>" id="stock_<?php echo $row8->pns_id;?>"  name="stock_<?php echo $row8->pns_id;?>" />
                                                                                                                                                                </td>
                                                                                                                                                                <td><?php echo $row8->pns_uom;?></td>
                                                                                                                                                                <td><?php echo $manufacture[0]['mf'];?></td>
                                                                                                                                                                        <td><?php echo $manufacture[0]['v_mf'];?></td>
                                                                                                                                                                <td><?php echo $row8->pns_life_cycle;?></td>
                                                                                                                                                                
                                                                                                                                                        </tr>

                                                                                                                                                <?php
                                                                                                                                                        }
                                                                                                                                               }
                                                                                                                                               ?>
                                                                                                                        <?php
                                                                                                                                }
                                                                                                                       }
                                                                                                                       ?>
                                                                                                <?php
                                                                                                        }
                                                                                               }
                                                                                               ?>
                                                                        <?php
                                                                                }
                                                                       }
                                                                       ?>
                                                <?php
                                                        }
                                               }
                                               ?>
                                <?php
                                        }
                               }
                               ?>
                <?php
                        }
               }
               ?>
     <?php
        }
        ?>
</table>
</div>
<input type="hidden" name="option" value="com_apdmpns" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="pns_id" value="<?php echo $this->lists['pns_id'];?>"  />
<input type="hidden" name="return" value="<?php echo $this->lists['pns_id'];?>"  />
<input type="hidden" name="cd" value="<?php echo $this->lists['pns_id'];?>"  />
</form>


