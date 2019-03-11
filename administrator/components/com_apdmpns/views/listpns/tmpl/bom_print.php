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
<style type="text/css" media="print">
    @page
    {
        size: auto;   /* auto is the current printer page size */
        margin: 0mm;  /* this affects the margin in the printer settings */
    }


</style>
<style type="text/css">
    .tgi  {border-collapse:collapse;border-spacing:0;align-content: center}
    .tgi td{border-width:1px !important;font-family:Arial, Helvetica, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:black;text-align:center}
    .tgi th{border-width:1px !important;font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:black;text-align:center}
    .tgi .tg-88nc{font-weight:bold;border-color:inherit;text-align:center;font-size: 20px;color: #0B55C4}
    .tgi .tg-kiyi{font-weight:bold;font-size: 11px;border-color:inherit;text-align:left}
    .tgi .tg-c3ow{text-align:center;vertical-align:top}
    .tgi .tg-c3ow-des{border-color:inherit;border-style:solid;border-width:1px;text-align:center;vertical-align:top}
    .tgi .tg-xldj-pr{text-align:right}
    .tgi .tg-0pky-pr{text-align:left;vertical-align:top}
    .tgi .tg-0pky-border{border-width:1px;border-style:solid}
    .tgi .tg-0pky-pr-title{border-color:inherit;text-align:left;vertical-align:top;font-size: 16px;color: #0B55C4}
    .tgi .tg-0pky-ito-title{border-color:inherit;text-align:center;vertical-align:top;font-size: 16px;color: #0B55C4}
</style>
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
<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong style="font-size:14px"><?php echo $pns_code_full?> </strong>
        <table class="tgi" width="100%">
	<thead>
		<tr>
                         <th width="5%">
                             No
                        </th>                                             
                        <th width="5%">
				<?php echo JText::_('Level')?>
			</th>                        
			<th width="15%" >
					<?php echo JText::_('Part Number')?>
			</th>
			<th width="15%">
				<?php echo JText::_('Desctiption')?>				
			</th>
			<th width="10%">
				<?php echo JText::_('Find Number')?>
			</th>
			<th width="5%">
				<?php echo JText::_('Qty')?>
			</th>                     
			<th width="5%">
				<?php echo JText::_('UOM')?>
			</th>
			<th width="10%">
				<?php echo JText::_('MFG Name')?>
			</th>
            <th width="5%">
				<?php echo JText::_('MFG PN')?>
			</th>
            <th width="25%">
                <?php echo JText::_('PN Barcode');?>
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
                 <td>1</td>
		<td style="text-align: left !important;" width="15%"><?php echo $row->text; ?></td>
                <td style="text-align: left !important;"><?php echo limit_text($row->pns_description, 15);?></td>
                <td>
                        <?php echo $row->find_number;?>                        
                </td>

                <td>
                       <?php echo $row->stock;?>                        
                </td>
                <td><?php echo $row->pns_uom;?></td>
                <td><?php echo $manufacture[0]['mf'];?></td>
                <td><?php echo $manufacture[0]['v_mf'];?></td>
            <td  width="25%"><?php
                $img			=	code128BarCode($row->text, 1);
                //Start output buffer to capture the image
                //Output PNG image
                ob_start();
                imagepng($img);
                //Get the image from the output buffer
                $output_img		=	ob_get_clean();
                echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '" /><br>'.$row->text;
                ?></td>
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
                                   <td><?php echo $step;?></td>                                   
                                   <td>2</td>
                                <td style="text-align: left !important;" width="15%"><?php echo $row2->text; ?></td>
                                <td style="text-align: left !important;"><?php echo limit_text($row2->pns_description, 15);?></td>
                                <td>
                                        <?php echo $row2->find_number;?>                        
                                </td>
                                <td>
                                       <?php echo $row2->stock;?>                        
                                </td>
                                <td><?php echo $row2->pns_uom;?></td>
                                <td><?php echo $manufacture[0]['mf'];?></td>
                                <td><?php echo $manufacture[0]['v_mf'];?></td>
                               <td width="25%"><?php
                                   $img			=	code128BarCode($row2->text, 1);
                                   //Start output buffer to capture the image
                                   //Output PNG image
                                   ob_start();
                                   imagepng($img);
                                   //Get the image from the output buffer
                                   $output_img		=	ob_get_clean();
                                   echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '" /><br>'.$row2->text;
                                   ?></td>

                                
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
                                                    <td>3</td>
                                                <td style="text-align: left !important;" width="15%"><?php echo $row3->text; ?></td>
                                                <td style="text-align: left !important;" width="15%"><?php echo limit_text($row3->pns_description, 15);?></td>
                                                <td>
                                                        <?php echo $row3->find_number;?>                        
                                                </td>

                                                <td>
                                                       <?php echo $row3->stock;?>                        
                                                </td>
                                                <td><?php echo $row3->pns_uom;?></td>
                                                <td><?php echo $manufacture[0]['mf'];?></td>
                                                 <td><?php echo $manufacture[0]['v_mf'];?></td>
                                               <td width="25%"><?php
                                                   $img			=	code128BarCode($row3->text, 1);
                                                   //Start output buffer to capture the image
                                                   //Output PNG image
                                                   ob_start();
                                                   imagepng($img);
                                                   //Get the image from the output buffer
                                                   $output_img		=	ob_get_clean();
                                                   echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '" /><br>'.$row3->text;
                                                   ?></td>
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
                                                                   <td>4</td>
                                                                        <td style="text-align: left !important;" width="15%"><?php echo $row4->text; ?></td>
                                                                        <td style="text-align: left !important;" width="15%"><?php echo limit_text($row4->pns_description, 15);?></td>
                                                                        <td>
                                                                                <?php echo $row4->find_number;?>                        
                                                                        </td>

                                                                        <td>
                                                                               <?php echo $row4->stock;?>                        
                                                                        </td>
                                                                <td><?php echo $row4->pns_uom;?></td>
                                                                <td><?php echo $manufacture[0]['mf'];?></td>
                                                                <td><?php echo $manufacture[0]['v_mf'];?></td>
                                                               <td width="25%"><?php
                                                                   $img			=	code128BarCode($row4->text, 1);
                                                                   //Start output buffer to capture the image
                                                                   //Output PNG image
                                                                   ob_start();
                                                                   imagepng($img);
                                                                   //Get the image from the output buffer
                                                                   $output_img		=	ob_get_clean();
                                                                   echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '" /><br>'.$row4->text;
                                                                   ?></td>

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
                                                                                           <td>5</td>
                                                                                        <td style="text-align: left !important;" width="15%"><?php echo $row5->text; ?></td>
                                                                                        <td style="text-align: left !important;" width="15%"><?php echo limit_text($row5->pns_description, 15);?></td>
                                                                                        <td>
                                                                                                <?php echo $row5->find_number;?>                        
                                                                                        </td>

                                                                                        <td>
                                                                                               <?php echo $row5->stock;?>                        
                                                                                        </td>
                                                                                        <td><?php echo $row5->pns_uom;?></td>
                                                                                        <td><?php echo $manufacture[0]['mf'];?></td>
                                                                                        <td><?php echo $manufacture[0]['v_mf'];?></td>
                                                                                       <td width="25%"><?php
                                                                                           $img			=	code128BarCode($row5->text, 1);
                                                                                           //Start output buffer to capture the image
                                                                                           //Output PNG image
                                                                                           ob_start();
                                                                                           imagepng($img);
                                                                                           //Get the image from the output buffer
                                                                                           $output_img		=	ob_get_clean();
                                                                                           echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '" /><br>'.$row5->text;
                                                                                           ?></td>

                                                                                        
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
                                                                                                                   <td>6</td>
                                                                                                                <td style="text-align: left !important;" width="15%"><?php echo $row6->text; ?></td>
                                                                                                                <td style="text-align: left !important;" width="15%"><?php echo limit_text($row6->pns_description, 15);?></td>
                                                                                                                <td>
                                                                                                                        <?php echo $row6->find_number;?>                        
                                                                                                                </td>

                                                                                                                <td>
                                                                                                                       <?php echo $row6->stock;?>                        
                                                                                                                </td>
                                                                                                                <td><?php echo $row6->pns_uom;?></td>
                                                                                                                <td><?php echo $manufacture[0]['mf'];?></td>
                                                                                                                <td><?php echo $manufacture[0]['v_mf'];?></td>
                                                                                                               <td width="25%"><?php
                                                                                                                   $img			=	code128BarCode($row6->text, 1);
                                                                                                                   //Start output buffer to capture the image
                                                                                                                   //Output PNG image
                                                                                                                   ob_start();
                                                                                                                   imagepng($img);
                                                                                                                   //Get the image from the output buffer
                                                                                                                   $output_img		=	ob_get_clean();
                                                                                                                   echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '" /><br>'.$row6->text;
                                                                                                                   ?></td>

                                                                                                                
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
                                                                                                                                           <td>7</td>
                                                                                                                                        <td style="text-align: left !important;" width="15%"><?php echo $row7->text; ?></td>
                                                                                                                                        <td style="text-align: left !important;" width="15%"><?php echo limit_text($row7->pns_description, 15);?></td>
                                                                                                                                        <td>
                                                                                                                                                <?php echo $row7->find_number;?>                        
                                                                                                                                        </td>
                                                                                                                                        <td>
                                                                                                                                               <?php echo $row7->stock;?>                        
                                                                                                                                        </td>
                                                                                                                                        <td><?php echo $row7->pns_uom;?></td>
                                                                                                                                         <td><?php echo $manufacture[0]['mf'];?></td>
                                                                                                                                       <td><?php echo $manufacture[0]['v_mf'];?></td>
                                                                                                                                       <td width="25%"><?php
                                                                                                                                           $img			=	code128BarCode($row7->text, 1);
                                                                                                                                           //Start output buffer to capture the image
                                                                                                                                           //Output PNG image
                                                                                                                                           ob_start();
                                                                                                                                           imagepng($img);
                                                                                                                                           //Get the image from the output buffer
                                                                                                                                           $output_img		=	ob_get_clean();
                                                                                                                                           echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '" /><br>'.$row7->text;
                                                                                                                                           ?></td>
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
                                                                                                                                                                   <td>8</td>
                                                                                                                                                                 <td style="text-align: left !important;" width="15%"><?php echo $row8->text; ?></td>
                                                                                                                                                                <td style="text-align: left !important;" width="15%"><?php echo limit_text($row8->pns_description, 15);?></td>
                                                                                                                                                                <td>
                                                                                                                                                                        <?php echo $row8->find_number;?>                        
                                                                                                                                                                </td>
                                                                                                                                                                <td>
                                                                                                                                                                       <?php echo $row8->stock;?>                        
                                                                                                                                                                </td>
                                                                                                                                                                <td><?php echo $row8->pns_uom;?></td>
                                                                                                                                                                <td><?php echo $manufacture[0]['mf'];?></td>
                                                                                                                                                                        <td><?php echo $manufacture[0]['v_mf'];?></td>
                                                                                                                                                               <td width="25%"><?php
                                                                                                                                                               $img			=	code128BarCode($row8->text, 1);
                                                                                                                                                               //Start output buffer to capture the image
                                                                                                                                                               //Output PNG image
                                                                                                                                                               ob_start();
                                                                                                                                                               imagepng($img);
                                                                                                                                                               //Get the image from the output buffer
                                                                                                                                                               $output_img		=	ob_get_clean();
                                                                                                                                                               echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '" /><br>'.$row8->text;
                                                                                                                                                               ?></td>
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


