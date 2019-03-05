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


	$cparams = JComponentHelper::getParams ('com_media');
?>

<?php
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	
?>
<script language="javascript">
    window.print();
</script>
<table width="100%" cellpadding="1">
    <tr>
        <th class="tg-kiyi"  style="text-align:left">
            <img src="./templates/khepri/images/h_green/logo1.png" width="150px"></img></th>
    </tr>
    <tr><td style="text-align:center"><span style="font-weight:bold;border-color:inherit;text-align:center;font-size: 20px;color: #0B55C4;align-content: center">Bill of Materials</span></td></tr>
</table>
<form action="index.php?option=com_apdmpns" method="post" name="adminForm">
<?php 

$list_pns_id = PNsController::DisplayPnsChildId($this->lists['pns_id'], $this->lists['pns_id']);

$new_pns = explode(",", $list_pns_id);
$list_pns = PNsController::DisplayPnsAllChildId($this->lists['pns_id']);
?>
<div> Level 0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?option=com_apdmpns&task=detail&cid[]=<?php echo $this->lists['pns_id']?>&cd=<?php echo $this->lists['pns_id']?>" title="<?php echo JText::_('Click to see detail PNs')?>"> <strong><?php echo $pns_code_full?> </strong></a></a>
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
            <th>
                <?php echo JText::_('PN Barcode');?>
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
                <td><input  type="checkbox" id = "bom" onclick="isCheckedBom(this.checked,'<?php echo $row->pns_id."_".$step;?>');" value="<?php echo $row->pns_id."_".$step."_".$this->lists['pns_id'];?>" name="cid[]"  /></td>                
                 <td>1</td>
		<td width="45%"><?php echo '<p style="height:25px"><a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'.$row->text.'</a></p> '; ?></td>		
                <td><span class="editlinktip hasTip" title="<?php echo $row->pns_description; ?>" ><?php echo limit_text($row->pns_description, 15);?></span></td>
                <td>
                        <span style="display:block" id="text_find_number_<?php echo $row->pns_id."_".$step;?>"><?php echo $row->find_number;?></span>
                        <input style="display:none" type="text" value="<?php echo $row->find_number;?>" id="find_number_<?php echo $row->pns_id."_".$step;?>"  name="find_number_<?php echo $row->pns_id."_".$step;?>" />
                </td>
                <td>
                        <span style="display:block" id="text_ref_des_<?php echo $row->pns_id."_".$step;?>"><?php echo $row->ref_des;?></span>
                        <input style="display:none" type="text" value="<?php echo $row->ref_des;?>" id="ref_des_<?php echo $row->pns_id."_".$step;?>"  name="ref_des_<?php echo $row->pns_id."_".$step;?>" />
                        <span style="display:none" id="note_ref_des_<?php echo $row->pns_id."_".$step;?>">Each ref des split by ","</span>
                </td>
                <td>
                        <span style="display:block" id="text_stock_<?php echo $row->pns_id."_".$step;?>"><?php echo $row->stock;?></span>
                        <input style="display:none" type="text" value="<?php echo $row->stock;?>" id="stock_<?php echo $row->pns_id."_".$step;?>"  name="stock_<?php echo $row->pns_id."_".$step;?>" />
                </td>
                <td><?php echo $row->pns_uom;?></td>
                <td><?php echo $manufacture[0]['mf'];?></td>
                <td><?php echo $manufacture[0]['v_mf'];?></td>
            <td><?php
                $img			=	code128BarCode($row->text, 1);
                //Start output buffer to capture the image
                //Output PNG image
                ob_start();
                imagepng($img);
                //Get the image from the output buffer
                $output_img		=	ob_get_clean();
                echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '" /><br>'.$row->text;
                ?></td>
		<td><?php echo $row->pns_life_cycle;?></td>		
	</tr>
        <?php
                //level2
               $list_pns_c = PNsController::DisplayPnsAllChildId($row->pns_id); 
               if(isset($list_pns_c)&& sizeof($list_pns_c)>0)
               {
                        foreach ($list_pns_c as $row2){
                                $step++;
                        $manufacture = PNsController::GetManufacture($row2->pns_id);
                       ?>
                           <tr>
                                   <td><?php echo $step;;?></td>
                                   <td><input  type="checkbox" id = "bom" onclick="isCheckedBom(this.checked,'<?php echo $row2->pns_id."_".$step;?>');" value="<?php echo $row2->pns_id."_".$step."_".$row->pns_id;?>" name="cid[]"  /></td>                                 
                                   <td>2</td>
                                <td width="45%"><?php echo '<p style="margin-left:40px"><a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row2->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'.$row2->text.'</a></p> '; ?></td>                                
                                <td><span class="editlinktip hasTip" title="<?php echo $row2->pns_description; ?>" ><?php echo limit_text($row2->pns_description, 15);?></span></td>
                                <td>
                                        <span style="display:block" id="text_find_number_<?php echo $row2->pns_id."_".$step;?>"><?php echo $row2->find_number;?></span>
                                        <input style="display:none" type="text" value="<?php echo $row2->find_number;?>" id="find_number_<?php echo $row2->pns_id."_".$step;?>"  name="find_number_<?php echo $row2->pns_id."_".$step;?>" />
                                </td>
                                <td>
                                        <span style="display:block" id="text_ref_des_<?php echo $row2->pns_id."_".$step;?>"><?php echo $row2->ref_des;?></span>
                                        <input style="display:none" type="text" value="<?php echo $row2->ref_des;?>" id="ref_des_<?php echo $row2->pns_id."_".$step;?>"  name="ref_des_<?php echo $row2->pns_id."_".$step;?>" />
                                        <span style="display:none" id="note_ref_des_<?php echo $row2->pns_id."_".$step;?>">Each ref des split by ","</span>
                                </td>
                                <td>
                                        <span style="display:block" id="text_stock_<?php echo $row2->pns_id."_".$step;?>"><?php echo $row2->stock;?></span>
                                        <input style="display:none" type="text" value="<?php echo $row2->stock;?>" id="stock_<?php echo $row2->pns_id."_".$step;?>"  name="stock_<?php echo $row2->pns_id."_".$step;?>" />
                                </td>
                                <td><?php echo $row2->pns_uom;?></td>
                                <td><?php echo $manufacture[0]['mf'];?></td>
                                <td><?php echo $manufacture[0]['v_mf'];?></td>
                               <td><?php
                                   $img			=	code128BarCode($row2->text, 1);
                                   //Start output buffer to capture the image
                                   //Output PNG image
                                   ob_start();
                                   imagepng($img);
                                   //Get the image from the output buffer
                                   $output_img		=	ob_get_clean();
                                   echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '" /><br>'.$row2->text;
                                   ?></td>
                                <td><?php echo $row2->pns_life_cycle;?></td>
                                
                        </tr>
                             
                              <?php
                                //level3
                               $list_pns_3 = PNsController::DisplayPnsAllChildId($row2->pns_id); 
                               if(isset($list_pns_3)&& sizeof($list_pns_3)>0)
                               {
                                        foreach ($list_pns_3 as $row3){
                                                $step++;
                                        $manufacture = PNsController::GetManufacture($row3->pns_id);
                                       ?>
                                           <tr>
                                                   <td><?php echo $step;?></td>
                                                   <td><input  type="checkbox" id = "bom" onclick="isCheckedBom(this.checked,'<?php echo $row3->pns_id."_".$step;?>');" value="<?php echo $row3->pns_id."_".$step."_".$row2->pns_id;?>" name="cid[]"  /></td>
                                                    <td>3</td>
                                                <td width="45%"><?php echo '<p style="margin-left:80px"><a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row3->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'.$row3->text.'</a></p> '; ?></td>                                               
                                                <td><span class="editlinktip hasTip" title="<?php echo $row3->pns_description; ?>" ><?php echo limit_text($row3->pns_description, 15);?></span></td>
                                                <td>
                                                        <span style="display:block" id="text_find_number_<?php echo $row3->pns_id."_".$step;?>"><?php echo $row3->find_number;?></span>
                                                        <input style="display:none" type="text" value="<?php echo $row3->find_number;?>" id="find_number_<?php echo $row3->pns_id."_".$step;?>"  name="find_number_<?php echo $row3->pns_id."_".$step;?>" />
                                                </td>
                                                <td>
                                                        <span style="display:block" id="text_ref_des_<?php echo $row3->pns_id."_".$step;?>"><?php echo $row3->ref_des;?></span>
                                                        <input style="display:none" type="text" value="<?php echo $row3->ref_des;?>" id="ref_des_<?php echo $row3->pns_id."_".$step;?>"  name="ref_des_<?php echo $row3->pns_id."_".$step;?>" />
                                                        <span style="display:none" id="note_ref_des_<?php echo $row3->pns_id."_".$step;?>">Each ref des split by ","</span>
                                                </td>
                                                <td>
                                                        <span style="display:block" id="text_stock_<?php echo $row3->pns_id."_".$step;?>"><?php echo $row3->stock;?></span>
                                                        <input style="display:none" type="text" value="<?php echo $row3->stock;?>" id="stock_<?php echo $row3->pns_id."_".$step;?>"  name="stock_<?php echo $row3->pns_id."_".$step;?>" />
                                                </td>
                                                <td><?php echo $row3->pns_uom;?></td>
                                                <td><?php echo $manufacture[0]['mf'];?></td>
                                                 <td><?php echo $manufacture[0]['v_mf'];?></td>
                                               <td><?php
                                                   $img			=	code128BarCode($row3->text, 1);
                                                   //Start output buffer to capture the image
                                                   //Output PNG image
                                                   ob_start();
                                                   imagepng($img);
                                                   //Get the image from the output buffer
                                                   $output_img		=	ob_get_clean();
                                                   echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '" /><br>'.$row3->text;
                                                   ?></td>
                                                <td><?php echo $row3->pns_life_cycle;?></td>                                                
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
                                                                   <td><input  type="checkbox" id = "bom" onclick="isCheckedBom(this.checked,'<?php echo $row4->pns_id."_".$step;?>');" value="<?php echo $row4->pns_id."_".$step."_".$row3->pns_id;?>" name="cid[]"  /></td>
                                                                   <td>4</td>
                                                                <td width="45%"><?php echo '<p style="margin-left:120px"><a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row4->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'.$row4->text.'</a></p> '; ?></td>
                                                                <td><span class="editlinktip hasTip" title="<?php echo $row4->pns_description; ?>" ><?php echo limit_text($row4->pns_description, 15);?></span></td>
                                                                <td>
                                                                        <span style="display:block" id="text_find_number_<?php echo $row4->pns_id."_".$step;?>"><?php echo $row4->find_number;?></span>
                                                                        <input style="display:none" type="text" value="<?php echo $row4->find_number;?>" id="find_number_<?php echo $row4->pns_id."_".$step;?>"  name="find_number_<?php echo $row4->pns_id."_".$step;?>" />
                                                                </td>
                                                                <td>
                                                                        <span style="display:block" id="text_ref_des_<?php echo $row4->pns_id."_".$step;?>"><?php echo $row4->ref_des;?></span>
                                                                        <input style="display:none" type="text" value="<?php echo $row4->ref_des;?>" id="ref_des_<?php echo $row4->pns_id."_".$step;?>"  name="ref_des_<?php echo $row4->pns_id."_".$step;?>" />
                                                                        <span style="display:none" id="note_ref_des_<?php echo $row4->pns_id."_".$step;?>">Each ref des split by ","</span>
                                                                </td>
                                                                <td>
                                                                        <span style="display:block" id="text_stock_<?php echo $row4->pns_id."_".$step;?>"><?php echo $row4->stock;?></span>
                                                                        <input style="display:none" type="text" value="<?php echo $row4->stock;?>" id="stock_<?php echo $row4->pns_id."_".$step;?>"  name="stock_<?php echo $row4->pns_id."_".$step;?>" />
                                                                </td>
                                                                <td><?php echo $row4->pns_uom;?></td>
                                                                <td><?php echo $manufacture[0]['mf'];?></td>
                                                                <td><?php echo $manufacture[0]['v_mf'];?></td>
                                                               <td><?php
                                                                   $img			=	code128BarCode($row4->text, 1);
                                                                   //Start output buffer to capture the image
                                                                   //Output PNG image
                                                                   ob_start();
                                                                   imagepng($img);
                                                                   //Get the image from the output buffer
                                                                   $output_img		=	ob_get_clean();
                                                                   echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '" /><br>'.$row4->text;
                                                                   ?></td>
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
                                                                                           <td><input  type="checkbox" id = "bom" onclick="isCheckedBom(this.checked,'<?php echo $row5->pns_id."_".$step;?>');" value="<?php echo $row5->pns_id."_".$step."_".$row4->pns_id;?>" name="cid[]"  /></td>
                                                                                           <td>5</td>
                                                                                        <td width="45%"><?php echo '<p style="margin-left:140px"><a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row5->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'.$row5->text.'</a></p> '; ?></td>
                                                                                        <td><span class="editlinktip hasTip" title="<?php echo $row5->pns_description; ?>" ><?php echo limit_text($row5->pns_description, 15);?></span></td>
                                                                                        <td>
                                                                                                <span style="display:block" id="text_find_number_<?php echo $row5->pns_id."_".$step;?>"><?php echo $row5->find_number;?></span>
                                                                                                <input style="display:none" type="text" value="<?php echo $row5->find_number;?>" id="find_number_<?php echo $row5->pns_id."_".$step;?>"  name="find_number_<?php echo $row5->pns_id."_".$step;?>" />
                                                                                        </td>
                                                                                        <td>
                                                                                                <span style="display:block" id="text_ref_des_<?php echo $row5->pns_id."_".$step;?>"><?php echo $row5->ref_des;?></span>
                                                                                                <input style="display:none" type="text" value="<?php echo $row5->ref_des;?>" id="ref_des_<?php echo $row5->pns_id."_".$step;?>"  name="ref_des_<?php echo $row5->pns_id."_".$step;?>" />
                                                                                                <span style="display:none" id="note_ref_des_<?php echo $row5->pns_id."_".$step;?>">Each ref des split by ","</span>
                                                                                        </td>
                                                                                        <td>
                                                                                                <span style="display:block" id="text_stock_<?php echo $row5->pns_id."_".$step;?>"><?php echo $row5->stock;?></span>
                                                                                                <input style="display:none" type="text" value="<?php echo $row5->stock;?>" id="stock_<?php echo $row5->pns_id."_".$step;?>"  name="stock_<?php echo $row5->pns_id."_".$step;?>" />
                                                                                        </td>
                                                                                        <td><?php echo $row5->pns_uom;?></td>
                                                                                        <td><?php echo $manufacture[0]['mf'];?></td>
                                                                                        <td><?php echo $manufacture[0]['v_mf'];?></td>
                                                                                       <td><?php
                                                                                           $img			=	code128BarCode($row5->text, 1);
                                                                                           //Start output buffer to capture the image
                                                                                           //Output PNG image
                                                                                           ob_start();
                                                                                           imagepng($img);
                                                                                           //Get the image from the output buffer
                                                                                           $output_img		=	ob_get_clean();
                                                                                           echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '" /><br>'.$row5->text;
                                                                                           ?></td>
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
                                                                                                                   <td><input  type="checkbox" id = "bom" onclick="isCheckedBom(this.checked,'<?php echo $row6->pns_id."_".$step;?>');" value="<?php echo $row6->pns_id."_".$step."_".$row5->pns_id;?>" name="cid[]"  /></td>
                                                                                                                   <td>6</td>
                                                                                                                <td width="45%"><?php echo '<p style="margin-left:180px"><a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row6->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'.$row6->text.'</a></p> '; ?></td>
                                                                                                                <td><span class="editlinktip hasTip" title="<?php echo $row6->pns_description; ?>" ><?php echo limit_text($row6->pns_description, 15);?></span></td>
                                                                                                                <td>
                                                                                                                        <span style="display:block" id="text_find_number_<?php echo $row6->pns_id."_".$step;?>"><?php echo $row6->find_number;?></span>
                                                                                                                        <input style="display:none" type="text" value="<?php echo $row6->find_number;?>" id="find_number_<?php echo $row6->pns_id."_".$step;?>"  name="find_number_<?php echo $row6->pns_id."_".$step;?>" />
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                        <span style="display:block" id="text_ref_des_<?php echo $row6->pns_id."_".$step;?>"><?php echo $row6->ref_des;?></span>
                                                                                                                        <input style="display:none" type="text" value="<?php echo $row6->ref_des;?>" id="ref_des_<?php echo $row6->pns_id."_".$step;?>"  name="ref_des_<?php echo $row6->pns_id."_".$step;?>" />
                                                                                                                        <span style="display:none" id="note_ref_des_<?php echo $row6->pns_id."_".$step;?>">Each ref des split by ","</span>
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                        <span style="display:block" id="text_stock_<?php echo $row6->pns_id."_".$step;?>"><?php echo $row6->stock;?></span>
                                                                                                                        <input style="display:none" type="text" value="<?php echo $row6->stock;?>" id="stock_<?php echo $row6->pns_id."_".$step;?>"  name="stock_<?php echo $row6->pns_id."_".$step;?>" />
                                                                                                                </td>
                                                                                                                <td><?php echo $row6->pns_uom;?></td>
                                                                                                                <td><?php echo $manufacture[0]['mf'];?></td>
                                                                                                                <td><?php echo $manufacture[0]['v_mf'];?></td>
                                                                                                               <td><?php
                                                                                                                   $img			=	code128BarCode($row6->text, 1);
                                                                                                                   //Start output buffer to capture the image
                                                                                                                   //Output PNG image
                                                                                                                   ob_start();
                                                                                                                   imagepng($img);
                                                                                                                   //Get the image from the output buffer
                                                                                                                   $output_img		=	ob_get_clean();
                                                                                                                   echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '" /><br>'.$row6->text;
                                                                                                                   ?></td>
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
                                                                                                                                           <td><input  type="checkbox" id = "bom" onclick="isCheckedBom(this.checked,'<?php echo $row7->pns_id."_".$step;?>');" value="<?php echo $row7->pns_id."_".$step."_".$row6->pns_id;?>" name="cid[]"  /></td>
                                                                                                                                           <td>7</td>
                                                                                                                                        <td width="45%"><?php echo '<p style="margin-left:220px"><a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row7->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'.$row7->text.'</a></p> '; ?></td>
                                                                                                                                        <td><span class="editlinktip hasTip" title="<?php echo $row7->pns_description; ?>" ><?php echo limit_text($row7->pns_description, 15);?></span></td>
                                                                                                                                        <td>
                                                                                                                                                <span style="display:block" id="text_find_number_<?php echo $row7->pns_id."_".$step;?>"><?php echo $row7->find_number;?></span>
                                                                                                                                                <input style="display:none" type="text" value="<?php echo $row7->find_number;?>" id="find_number_<?php echo $row7->pns_id."_".$step;?>"  name="find_number_<?php echo $row7->pns_id."_".$step;?>" />
                                                                                                                                        </td>
                                                                                                                                        <td>
                                                                                                                                                <span style="display:block" id="text_ref_des_<?php echo $row7->pns_id."_".$step;?>"><?php echo $row7->ref_des;?></span>
                                                                                                                                                <input style="display:none" type="text" value="<?php echo $row7->ref_des;?>" id="ref_des_<?php echo $row7->pns_id."_".$step;?>"  name="ref_des_<?php echo $row7->pns_id."_".$step;?>" />
                                                                                                                                                <span style="display:none" id="note_ref_des_<?php echo $row7->pns_id."_".$step;?>">Each ref des split by ","</span>
                                                                                                                                        </td>
                                                                                                                                        <td>
                                                                                                                                                <span style="display:block" id="text_stock_<?php echo $row7->pns_id."_".$step;?>"><?php echo $row7->stock;?></span>
                                                                                                                                                <input style="display:none" type="text" value="<?php echo $row7->stock;?>" id="stock_<?php echo $row7->pns_id."_".$step;?>"  name="stock_<?php echo $row7->pns_id."_".$step;?>" />
                                                                                                                                        </td>
                                                                                                                                        <td><?php echo $row7->pns_uom;?></td>
                                                                                                                                         <td><?php echo $manufacture[0]['mf'];?></td>
                                                                                                                                       <td><?php echo $manufacture[0]['v_mf'];?></td>
                                                                                                                                       <td><?php
                                                                                                                                           $img			=	code128BarCode($row7->text, 1);
                                                                                                                                           //Start output buffer to capture the image
                                                                                                                                           //Output PNG image
                                                                                                                                           ob_start();
                                                                                                                                           imagepng($img);
                                                                                                                                           //Get the image from the output buffer
                                                                                                                                           $output_img		=	ob_get_clean();
                                                                                                                                           echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '" /><br>'.$row7->text;
                                                                                                                                           ?></td>
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
                                                                                                                                                                   <td><input  type="checkbox" id = "bom" onclick="isCheckedBom(this.checked,'<?php echo $row8->pns_id."_".$step;?>');" value="<?php echo $row8->pns_id."_".$step."_".$row7->pns_id;?>" name="cid[]"  /></td>
                                                                                                                                                                   <td>8</td>
                                                                                                                                                                <td width="45%"><?php echo '<p style="margin-left:240px"> <a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row8->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'.$row8->text.'</a></p> '; ?></td>
                                                                                                                                                                <td><span class="editlinktip hasTip" title="<?php echo $row8->pns_description; ?>" ><?php echo limit_text($row8->pns_description, 15);?></span></td>
                                                                                                                                                                <td>
                                                                                                                                                                        <span style="display:block" id="text_find_number_<?php echo $row8->pns_id."_".$step;?>"><?php echo $row8->find_number;?></span>
                                                                                                                                                                        <input style="display:none" type="text" value="<?php echo $row8->find_number;?>" id="find_number_<?php echo $row8->pns_id;?>"  name="find_number_<?php echo $row8->pns_id."_".$step;?>" />
                                                                                                                                                                </td>
                                                                                                                                                                <td>
                                                                                                                                                                        <span style="display:block" id="text_ref_des_<?php echo $row8->pns_id."_".$step;?>"><?php echo $row8->ref_des;?></span>
                                                                                                                                                                        <input style="display:none" type="text" value="<?php echo $row8->ref_des;?>" id="ref_des_<?php echo $row8->pns_id;?>"  name="ref_des_<?php echo $row8->pns_id."_".$step;?>" />
                                                                                                                                                                        <span style="display:none" id="note_ref_des_<?php echo $row8->pns_id."_".$step;?>">Each ref des split by ","</span>
                                                                                                                                                                </td>
                                                                                                                                                                <td>
                                                                                                                                                                        <span style="display:block" id="text_stock_<?php echo $row8->pns_id."_".$step;?>"><?php echo $row8->stock;?></span>
                                                                                                                                                                        <input style="display:none" type="text" value="<?php echo $row8->stock;?>" id="stock_<?php echo $row8->pns_id."_".$step;?>"  name="stock_<?php echo $row8->pns_id."_".$step;?>" />
                                                                                                                                                                </td>
                                                                                                                                                                <td><?php echo $row8->pns_uom;?></td>
                                                                                                                                                                <td><?php echo $manufacture[0]['mf'];?></td>
                                                                                                                                                                        <td><?php echo $manufacture[0]['v_mf'];?></td>
                                                                                                                                                               <td><?php
                                                                                                                                                               $img			=	code128BarCode($row8->text, 1);
                                                                                                                                                               //Start output buffer to capture the image
                                                                                                                                                               //Output PNG image
                                                                                                                                                               ob_start();
                                                                                                                                                               imagepng($img);
                                                                                                                                                               //Get the image from the output buffer
                                                                                                                                                               $output_img		=	ob_get_clean();
                                                                                                                                                               echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '" /><br>'.$row8->text;
                                                                                                                                                               ?></td>
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


