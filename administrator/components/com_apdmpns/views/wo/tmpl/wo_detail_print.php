<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php
//
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
$id = JRequest::getVar('id');
$edit = JRequest::getVar('edit', true);

JToolBarHelper::title("WO#: ".$this->wo_row->wo_code, 'cpanel.png');
$role = JAdministrator::RoleOnComponent(10);      
if (in_array("W", $role) && $this->wo_row->wo_state!="done" && $this->wo_row->wo_state !="onhold" && $this->wo_row->wo_state!="cancel" ) {        
        JToolBarHelper::editListX("editwo","Edit WO");	        
}
if (in_array("D", $role) && $this->wo_row->wo_state!="done" && $this->wo_row->wo_state !="onhold" && $this->wo_row->wo_state!="cancel" ) {
        JToolBarHelper::deletePns('Are you sure to delete it?',"deletewo","Delete WO#");
}
 JToolBarHelper::editListX("editwo","Edit WO");
 JToolBarHelper::customX("printwopdf","print",'',"Print",false);        
//$generator = new BarcodeGeneratorHTML();      
$cparams = JComponentHelper::getParams('com_media');
$editor = &JFactory::getEditor();
?>

<?php
// clean item data
JFilterOutput::objectHTMLSafe($user, ENT_QUOTES, '');
?>
<script language="javascript" type="text/javascript">
        function submitbutton(pressbutton) {  
                var form = document.adminForm;      
                if(pressbutton == 'deletewo')
                {                       
                     submitform( pressbutton );
                     return;
                }
                if (pressbutton == 'editwo') {
                        submitform( pressbutton );
                        return;
                }      
                if (pressbutton == 'savermafk') {
                        submitform( pressbutton );
                        return;
                }     
                
                        
        }
 function isCheckedSoPn(isitchecked,id){
       
	if (isitchecked == true){
		document.adminForm.boxchecked.value++;
                document.getElementById('rma_'+id).style.visibility= 'visible';
                document.getElementById('rma_'+id).style.display= 'block';
                document.getElementById('text_rma_'+id).style.visibility= 'hidden';
                document.getElementById('text_rma_'+id).style.display= 'none';        
	}
	else {
		document.adminForm.boxchecked.value--;
                document.getElementById('text_rma_'+id).style.visibility= 'visible';
                document.getElementById('text_rma_'+id).style.display= 'block';

                document.getElementById('rma_'+id).style.visibility= 'hidden';
                document.getElementById('rma_'+id).style.display= 'none';
             
                
                
	}
}       
window.print();
</script>
<style type="text/css">
.tgdetail  {border-collapse:collapse;border-spacing:0;}
.tgdetail td{font-family:Arial, sans-serif;font-size:11px;padding:2.5px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tgdetail th{font-family:Arial, sans-serif;font-size:11px;font-weight:normal;padding:0px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tgdetail .tg-88nc{font-weight:bold;border-color:inherit;text-align:center}
.tgdetail .tg-w9sc{font-size:13px;border-color:inherit;text-align:center}
.tgdetail .tg-b2ze{font-weight:bold;font-size:13px;border-color:inherit;text-align:left;vertical-align:top}
.tgdetail .tg-c3ow{border-color:inherit;text-align:center;vertical-align:top}
.tgdetail .tg-uys7{border-color:inherit;text-align:center}
.tgdetail .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
.tgdetail .tg-fuxe{font-size:18px;border-color:inherit;text-align:left;vertical-align:top}
.tgdetail .tg-7jts{font-size:18px;border-color:inherit;text-align:center;vertical-align:top}
.tgdetail .tg-dvpl{border-color:inherit;text-align:right;vertical-align:top}
.tgdetail .tg-v783{font-weight:bold;font-size:13px;border-color:inherit;text-align:left}
.tgdetail .tg-xldj{border-color:inherit;text-align:left}
.tgdetail .tg-7btt{font-weight:bold;border-color:inherit;text-align:center;vertical-align:top}
</style>


<form action="index.php"  onsubmit="submitbutton('')"  method="post" name="adminForm" >	
     
	      
        <table class="tgdetail">
  <tr>
          <th class="tg-0pky" colspan="3"><img src="./templates/khepri/images/h_green/header1.jpg" width="150px"></img></th>
    <th class="tg-7jts" colspan="3"><span style="font-weight:bold">Production Traveler</span></th>
    <th class="tg-c3ow" colspan="4">  <br>
             <?php 
            // echo $generator->getBarcode($this->wo_row->wo_code,$generator::TYPE_CODE_128,3,50);            
             //TYPE_EAN_13
             //TYPE_CODE_128
            $img			=	code128BarCode($this->wo_row->wo_code, 1);
		
        //Start output buffer to capture the image
        //Output PNG image
        
		ob_start();
		imagepng($img);
		
        //Get the image from the output buffer
        
		$output_img		=	ob_get_clean();
                echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '" /><br>'.$this->wo_row->wo_code;
            ?>
    </th>
  </tr>
  <tr>
    <td class="tg-7jts" colspan="10"><span style="font-weight:bold">JOB INFORMATION</span></td>
  </tr>
  <tr>
    <td class="tg-0pky" colspan="3"><span style="font-weight:bold">WO NUMBER:</span></td>
    <td class="tg-c3ow" colspan="3"><?php echo $this->wo_row->wo_code;?></td>
    <td class="tg-0pky"><span style="font-weight:bold">STATUS:</span></td>
    <td class="tg-c3ow" colspan="3"><?php echo PNsController::getWoStatus($this->wo_row->wo_state); ?></td>    
  </tr>
  <tr>
    <td class="tg-0pky" colspan="3"><span style="font-weight:bold">PART NUMBER</span></td>
    <td class="tg-c3ow" colspan="3">    
        <?php 
        if ($this->row_part->pns_revision) {
               $pnNumber = $this->row_part->ccs_code . '-' . $this->row_part->pns_code . '-' . $this->row_part->pns_revision;
        } else {
                $pnNumber = $this->row_part->ccs_code . '-' . $this->row_part->pns_code;
        }
        echo $pnNumber;?>
    </td>
    <td class="tg-0pky"><span style="font-weight:bold">QUANTITY</span></td>
    <td class="tg-0pky"><?php echo $this->wo_row->wo_qty;?></td>
    <td class="tg-0pky"><span style="font-weight:bold">UOM</span>:</td>
    <td class="tg-0pky"><?php echo $this->row_part->pns_uom;?></td>
  </tr>
  <tr>
    <td class="tg-0pky" colspan="3"><span style="font-weight:bold">DESCRIPTION</span></td>
    <td class="tg-c3ow" colspan="7"><?php echo $this->row_part->pns_description;?></td>
  </tr>
  <tr>
    <td class="tg-0pky" colspan="3"><span style="font-weight:bold">REQUIRED:</span>
        <?php
                        $fachecked="";
                        if($this->row_top_assy->fa_required)
                                $fachecked = 'checked="checked"';
                        $esdchecked="";
                        if($this->row_top_assy->esd_required)
                                $esdchecked = 'checked="checked"';
                        $cocchecked="";
                        if($this->row_top_assy->coc_required)
                                $cocchecked = 'checked="checked"';
                        ?>
    </td>
    <td class="tg-dvpl" colspan="2"><span style="font-weight:bold"><input <?php echo $fachecked?> type="checkbox" name="fa_required" value="1" onclick="return false;" onkeydown="return false;" />FA</span></td>
    <td class="tg-dvpl" colspan="2"><span style="font-weight:bold"><input <?php echo $cocchecked?> type="checkbox" name="fa_required" value="1" onclick="return false;" onkeydown="return false;" />COC</span></td>
    <td class="tg-dvpl" colspan="3"><span style="font-weight:bold"><input <?php echo $esdchecked?> type="checkbox" name="fa_required" value="1" onclick="return false;" onkeydown="return false;" />ESD</span></td>
  </tr>
  <tr>
    <td class="tg-0pky" colspan="3"><span style="font-weight:bold">TOP LEVEL ASSY P/N:</span></td>
    <td class="tg-c3ow" colspan="4">
             <?php 
        if ($this->row_top_assy->pns_revision) {
               $toppnNumber = $this->row_top_assy->ccs_code . '-' . $this->row_top_assy->pns_code . '-' . $this->row_top_assy->pns_revision;
        } else {
                $toppnNumber = $this->row_top_assy->ccs_code . '-' . $this->row_top_assy->pns_code;
        }
        echo $toppnNumber;?>
    </td>
    <td class="tg-dvpl" colspan="3">
            <?php 
             if($this->wo_row->wo_rma_active)
                $wo_rma_active = 'checked="checked"';
            ?>
           <input <?php echo $wo_rma_active?> type="checkbox" name="wo_rma_active" value="<?php echo $this->wo_row->wo_rma_active;?>" onclick="return false;" onkeydown="return false;" /> RMA</td>
  </tr>
  <tr>
    <td class="tg-0pky" colspan="3"><span style="font-weight:bold">CUSTOMER:</span></td>
    <td class="tg-0pky" colspan="3"><?php echo PNsController::getCcsName($this->wo_row->wo_customer_id); ?></td>
    <td class="tg-0pky"><span style="font-weight:bold">REQUEST DATE:</span></td>
    <td class="tg-dvpl" colspan="3"><?php echo JHTML::_('date', $this->wo_row->so_shipping_date, JText::_('DATE_FORMAT_LC3')); ?></td>
  </tr>
  <tr>
    <td class="tg-0pky" colspan="3"><span style="font-weight:bold">SO NUMBER:</span></td>
    <td class="tg-0pky" colspan="3"><?php 
     $soNumber = $this->wo_row->so_cuscode;
                                if($this->wo_row->ccs_code)
                                {
                                       $soNumber = $this->wo_row->ccs_code."-".$soNumber;
                                }
    echo $soNumber;?></td>
    <td class="tg-0pky"><span style="font-weight:bold">WO# Started</span></td>
    <td class="tg-dvpl" colspan="3"><?php echo JHTML::_('date', $this->wo_row->wo_start_date, JText::_('DATE_FORMAT_LC3')); ?></td>
  </tr>
  <tr>
    <td class="tg-0pky" colspan="3"><span style="font-weight:bold">CREATED BY:</span></td>
    <td class="tg-0pky" colspan="3"><?php echo GetValueUser($this->wo_row->wo_created_by, "name"); ?></td>
    <td class="tg-0pky"><span style="font-weight:bold">WO# Finished</span></td>
    <td class="tg-dvpl" colspan="3"><?php echo JHTML::_('date', $this->wo_row->wo_completed_date, JText::_('DATE_FORMAT_LC3')); ?></td>
  </tr>
  <tr>
    <td class="tg-0pky" colspan="3"><span style="font-weight:bold">CREATED DATE:</span></td>
    <td class="tg-0pky" colspan="3"><?php echo JHTML::_('date', $this->wo_row->wo_created, JText::_('DATE_FORMAT_LC3')); ?></td>
    <td class="tg-0pky"><span style="font-weight:bold">ASSIGNER</span></td>
    <td class="tg-dvpl" colspan="3"><?php echo GetValueUser($this->wo_row->wo_assigner, "name"); ?></td>
  </tr>
  <tr>
    <td class="tg-7jts" colspan="10"><span style="font-weight:bold">OPERATIONS</span>
    <?php 
    $op_arr  = $this->op_arr;
    ?>
    </td>
  </tr>
  <tr>
    <td class="tg-w9sc">#</td>
    <td class="tg-b2ze" colspan="5">Steps</td>
    <td class="tg-v783">Comments</td>
    <td class="tg-v783">DATE</td>
    <td class="tg-v783">INITIAL/ID</td>
    <td class="tg-v783">TARGET DATE</td>
  </tr>
  <tr>
    <td class="tg-uys7">1</td>
    <td class="tg-0pky" colspan="5">Label Print By:</td>
    <td class="tg-xldj"><?php echo $op_arr['wo_step1']['op_comment'];?></td>
    <td class="tg-xldj"><?php echo ($op_arr['wo_step1']['op_completed_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step1']['op_completed_date'], JText::_('DATE_FORMAT_LC3')):""; ?></td>
    <td class="tg-xldj"><?php echo GetValueUser($op_arr['wo_step1']['op_assigner'], "name"); ?></td>
    <td class="tg-xldj"><?php echo ($op_arr['wo_step1']['op_target_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step1']['op_target_date'], JText::_('DATE_FORMAT_LC3')):""; ?></td>
  </tr>
  <tr>
    <td class="tg-uys7">2</td>
    <td class="tg-0pky" colspan="5">Wire Cut By:</td>
    <td class="tg-xldj"><?php echo $op_arr['wo_step2']['op_comment'];?></td>
    <td class="tg-xldj"><?php echo ($op_arr['wo_step2']['op_completed_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step2']['op_completed_date'], JText::_('DATE_FORMAT_LC3')):""; ?></td>
    <td class="tg-xldj"><?php echo GetValueUser($op_arr['wo_step2']['op_assigner'], "name"); ?></td>
    <td class="tg-xldj"><?php echo ($op_arr['wo_step2']['op_target_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step2']['op_target_date'], JText::_('DATE_FORMAT_LC3')):""; ?></td>
  </tr>
  <tr>
    <td class="tg-uys7">3</td>
    <td class="tg-0pky" colspan="5">Kitted By:</td>
    <td class="tg-xldj"><?php echo $op_arr['wo_step3']['op_comment'];?></td>
    <td class="tg-xldj"><?php echo ($op_arr['wo_step3']['op_completed_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step3']['op_completed_date'], JText::_('DATE_FORMAT_LC3')):""; ?></td>
    <td class="tg-xldj"><?php echo GetValueUser($op_arr['wo_step3']['op_assigner'], "name"); ?></td>
    <td class="tg-xldj"><?php echo ($op_arr['wo_step3']['op_target_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step3']['op_target_date'], JText::_('DATE_FORMAT_LC3')):""; ?></td>
  </tr>
  <tr>
    <td class="tg-c3ow">4</td>
    <td class="tg-0pky" colspan="5">Assembly performed by:</td>
    <td class="tg-xldj"><?php echo $op_arr['wo_step4']['op_comment'];?></td>
    <td class="tg-xldj"><?php echo ($op_arr['wo_step4']['op_completed_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step4']['op_completed_date'], JText::_('DATE_FORMAT_LC3')):""; ?></td>
    <td class="tg-xldj"><?php echo GetValueUser($op_arr['wo_step4']['op_assigner'], "name"); ?></td>
    <td class="tg-xldj"><?php echo ($op_arr['wo_step4']['op_target_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step4']['op_target_date'], JText::_('DATE_FORMAT_LC3')):""; ?></td>
  </tr>
  <tr>
    <td class="tg-c3ow">Process</td>
    <td class="tg-0pky" colspan="2">Solder?</td>
    <td class="tg-0pky" colspan="2">Crimp?</td>
    <td class="tg-0pky">None</td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-c3ow" rowspan="5">Production</td>
    <td class="tg-0pky">CONT#</td>
    <td class="tg-0pky">Wire size#</td>
    <td class="tg-0pky">TOOL ID#</td>
    <td class="tg-0pky">Height</td>
    <td class="tg-0pky">Pull Force</td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
  </tr>
  <?php 
  foreach ($this->wo_assem_rows as $a_row)
  {
  ?>
  <tr>
    <td class="tg-0pky"><?php echo $a_row->op_assembly_value1; ?></td>
    <td class="tg-0pky"><?php echo $a_row->op_assembly_value2; ?></td>
    <td class="tg-0pky"><?php echo $a_row->op_assembly_value3; ?></td>
    <td class="tg-0pky"><?php echo $a_row->op_assembly_value4; ?></td>
    <td class="tg-0pky"><?php echo $a_row->op_assembly_value5; ?></td>
    <td class="tg-0pky">&nbsp;</td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
  </tr>
  <?php 
  }
  ?>
   
  <tr>
    <td class="tg-0pky" colspan="5"></td>
    <td class="tg-b2ze">1st Fail Qty</td>
    <td class="tg-b2ze">2nd Fail Qty</td>
    <td class="tg-b2ze">DATE</td>
    <td class="tg-b2ze">INITIAL/ID</td>
    <td class="tg-b2ze">TARGET DATE</td>
  </tr>
  <tr>
    <td class="tg-88nc">5</td>
    <td class="tg-0pky" colspan="4">Visual Inspection(QC) By:</td>
    <td class="tg-xldj"></td>
    <td class="tg-xldj"></td>    
    <td class="tg-xldj"><?php echo ($op_arr['wo_step5']['op_completed_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step5']['op_completed_date'], JText::_('DATE_FORMAT_LC3')):""; ?></td>
    <td class="tg-xldj"><?php echo GetValueUser($op_arr['wo_step5']['op_assigner'], "name"); ?></td>
    <td class="tg-xldj"><?php echo ($op_arr['wo_step5']['op_target_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step5']['op_target_date'], JText::_('DATE_FORMAT_LC3')):""; ?></td>
  </tr>
<?php 
  $opvs_arr = $this->opvs_arr;
  ?>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3">Document not match</td>
    <td class="tg-0pky"><?php echo $opvs_arr[1]['op_visual_value1']?></td>
    <td class="tg-0pky"><?php echo $opvs_arr[2]['op_visual_value1']?></td>
    <td class="tg-0pky"></td>
    <td class="tg-c3ow" colspan="2"><span style="font-weight:bold">Comments</span></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3">Traveler incomplete</td>
    <td class="tg-0pky"><?php echo $opvs_arr[1]['op_visual_value2']?></td>
    <td class="tg-0pky"><?php echo $opvs_arr[2]['op_visual_value2']?></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky" colspan="2" rowspan="4"><?php echo $op_arr['wo_step5']['op_comment'];?></td>   
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3">Wrong Dimension</td>
    <td class="tg-0pky"><?php echo $opvs_arr[1]['op_visual_value3']?></td>
    <td class="tg-0pky"><?php echo $opvs_arr[2]['op_visual_value3']?></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3">Label print error</td>
    <td class="tg-0pky"><?php echo $opvs_arr[1]['op_visual_value4']?></td>
    <td class="tg-0pky"><?php echo $opvs_arr[2]['op_visual_value4']?></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3">Missing Label / Wrong Location</td>
    <td class="tg-0pky"><?php echo $opvs_arr[1]['op_visual_value5']?></td>
    <td class="tg-0pky"><?php echo $opvs_arr[2]['op_visual_value5']?></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-7btt">6</td>
    <td class="tg-0pky" colspan="4">Final&nbsp;&nbsp;Inspection(QC) By:</td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"><?php echo ($op_arr['wo_step6']['op_completed_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step6']['op_completed_date'], JText::_('DATE_FORMAT_LC3')):""; ?></td>
    <td class="tg-0pky"><?php echo GetValueUser($op_arr['wo_step6']['op_assigner'], "name"); ?></td>
    <td class="tg-0pky"><?php echo ($op_arr['wo_step6']['op_target_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step6']['op_target_date'], JText::_('DATE_FORMAT_LC3')):""; ?></td>
  </tr>
  <?php $opfn_arr = $this->opfn_arr;?>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3">Document not match</td>
    <td class="tg-0pky"><?php echo $opfn_arr[1]['op_final_value1']?></td>
    <td class="tg-0pky"><?php echo $opfn_arr[2]['op_final_value1']?></td>
    <td class="tg-0pky"></td>
    <td class="tg-c3ow" colspan="2"><span style="font-weight:700">Comments</span></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3">Traveler incomplete</td>
    <td class="tg-0pky"><?php echo $opfn_arr[1]['op_final_value2']?></td>
    <td class="tg-0pky"><?php echo $opfn_arr[2]['op_final_value2']?></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky" colspan="2" rowspan="6"><?php echo $op_arr['wo_step6']['op_comment'];?></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3">Wrong Dimension</td>
    <td class="tg-0pky"><?php echo $opfn_arr[1]['op_final_value3']?></td>
    <td class="tg-0pky"><?php echo $opfn_arr[2]['op_final_value3']?></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3">Label print error</td>
    <td class="tg-0pky"><?php echo $opfn_arr[1]['op_final_value4']?></td>
    <td class="tg-0pky"><?php echo $opfn_arr[2]['op_final_value4']?></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3">Missing Label / Wrong Location</td>
    <td class="tg-0pky"><?php echo $opfn_arr[1]['op_final_value5']?></td>
    <td class="tg-0pky"><?php echo $opfn_arr[2]['op_final_value5']?></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3">Miss Wire / Open Connection</td>
    <td class="tg-0pky"><?php echo $opfn_arr[1]['op_final_value6']?></td>
    <td class="tg-0pky"><?php echo $opfn_arr[2]['op_final_value6']?></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3">Fail Hipot Test</td>
    <td class="tg-0pky"><?php echo $opfn_arr[1]['op_final_value7']?></td>
    <td class="tg-0pky"><?php echo $opfn_arr[2]['op_final_value7']?></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky" colspan="6"></td>
    <td class="tg-b2ze">COMMENTS</td>
    <td class="tg-b2ze">DATE</td>
    <td class="tg-b2ze">INITIAL/ID</td>
    <td class="tg-b2ze">TARGET DATE</td>
  </tr>
  <tr>
    <td class="tg-7btt">7</td>
    <td class="tg-0pky" colspan="5">Packaging by</td>
    <td class="tg-0pky"><?php echo $op_arr['wo_step7']['op_comment'];?></td>
    <td class="tg-0pky"><?php echo ($op_arr['wo_step7']['op_completed_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step7']['op_completed_date'], JText::_('DATE_FORMAT_LC3')):""; ?></td>
    <td class="tg-0pky"><?php echo GetValueUser($op_arr['wo_step7']['op_assigner'], "name"); ?></td>
    <td class="tg-0pky"><?php echo ($op_arr['wo_step7']['op_target_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step7']['op_target_date'], JText::_('DATE_FORMAT_LC3')):""; ?></td>
  </tr>
</table>		       
        <input type="hidden" name="wo_id" value="<?php echo $this->wo_row->pns_wo_id; ?>" />
        <input type="hidden" name="option" value="com_apdmpns" />     
        <input type="hidden" name="id" value="<?php echo JRequest::getVar('id'); ?>" />     
	<input type="hidden" name="task" value="" />	
        <input type="hidden" name="boxchecked" value="1" />
<?php echo JHTML::_('form.token'); ?>
</form>
