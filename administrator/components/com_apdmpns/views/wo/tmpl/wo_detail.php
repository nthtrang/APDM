<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php
//
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
$id = JRequest::getVar('id');
$edit = JRequest::getVar('edit', true);
$me = & JFactory::getUser();
$usertype	= $me->get('usertype');
$allow_edit = 0;
$allow_complete=1;
if ($usertype =='Administrator' || $usertype=="Super Administrator" || $this->wo_row->wo_created_by  == $me->get('id') ) {
        $allow_edit = 1;
       // $allow_complete=1;
}
JToolBarHelper::title("WO: ".$this->wo_row->wo_code, 'cpanel.png');
$role = JAdministrator::RoleOnComponent(12);
if (in_array("E", $role) && $this->wo_row->wo_state!="done" && $this->wo_row->wo_state !="onhold" && $this->wo_row->wo_state!="cancel" ) {
        JToolBarHelper::editListX("editwo","Edit WO");
        JToolBarHelper::customX("requestmaterialwo","help",'',"Request Material",false);
}
if (in_array("D", $role) && $this->wo_row->wo_state!="done" && $this->wo_row->wo_state !="onhold" && $this->wo_row->wo_state!="cancel" ) {
    JToolBarHelper::deletePns('Are you sure to delete it?',"deletewo","Delete WO");
}
JToolBarHelper::customX("printwopdf","print",'',"Print",false);


$op_arr  = $this->op_arr;
if ($this->wo_row->wo_state!="done" && $this->wo_row->wo_state !="onhold" && $this->wo_row->wo_state!="cancel" ) {
    if (($allow_complete || $op_arr['wo_step1']['op_assigner'] == $me->get('id')) && $op_arr['wo_step1']['op_status'] != 'done') {    // && $op_arr['wo_step1']['op_assigner'] == $me->get('id')
        if ($op_arr['wo_step1']['op_is_start'] == 1) { //after start
            if ($op_arr['wo_step1']['op_is_pause'] == 1) { //after start
                JToolBarHelper::popUpCompleteStepWo('Resume', 'save_resume_step', 'wo_step1', $this->wo_row->pns_wo_id, $this->wo_row->so_id);
            } else {
                JToolBarHelper::popUpCompleteStepWo('Pause', 'save_pause_step', 'wo_step1', $this->wo_row->pns_wo_id, $this->wo_row->so_id, 700, 500, 'restore');
                JToolBarHelper::popUpCompleteStepWo('Complete', 'save_complete_step', 'wo_step1', $this->wo_row->pns_wo_id, $this->wo_row->so_id);
                JToolBarHelper::popUpCompleteStepWo('FAILURE REPORT', 'save_failure_step', 'wo_step1', $this->wo_row->pns_wo_id, $this->wo_row->so_id, 700, 500, 'back');
            }


        } else {
            JToolBarHelper::popUpCompleteStepWo('Start', 'save_start_step', 'wo_step1', $this->wo_row->pns_wo_id, $this->wo_row->so_id);
        }
    }
//complete step2        
    $checkStep1 = PNsController::checkStepBeforeDone('step2', $this->wo_row->pns_wo_id);
    if (($allow_complete || $op_arr['wo_step2']['op_assigner'] == $me->get('id')) && ($checkStep1 == 1 && $op_arr['wo_step1']['op_status'] == "done" && $op_arr['wo_step2']['op_status'] != 'done')) {
        if ($op_arr['wo_step2']['op_is_start'] == 1) { //after start
            if ($op_arr['wo_step2']['op_is_pause'] == 1) { //after start
                JToolBarHelper::popUpCompleteStepWo('Resume', 'save_resume_step', 'wo_step2', $this->wo_row->pns_wo_id, $this->wo_row->so_id);
            } else {
                JToolBarHelper::popUpCompleteStepWo('Pause', 'save_pause_step', 'wo_step2', $this->wo_row->pns_wo_id, $this->wo_row->so_id, 700, 500, 'restore');
                JToolBarHelper::popUpCompleteStepWo('Complete', 'save_complete_step', 'wo_step2', $this->wo_row->pns_wo_id, $this->wo_row->so_id);
                JToolBarHelper::popUpCompleteStepWo('FAILURE REPORT', 'save_failure_step', 'wo_step2', $this->wo_row->pns_wo_id, $this->wo_row->so_id, 700, 500, 'back');
            }

        } else {
            JToolBarHelper::popUpCompleteStepWo('Start', 'save_start_step', 'wo_step2', $this->wo_row->pns_wo_id, $this->wo_row->so_id);
        }
    }
//complete step3        
    $checkStep2 = PNsController::checkStepBeforeDone('step3', $this->wo_row->pns_wo_id);
    if (($allow_complete || $op_arr['wo_step3']['op_assigner'] == $me->get('id')) && ($checkStep2 == 1 && $op_arr['wo_step2']['op_status'] == "done" && $op_arr['wo_step3']['op_status'] != 'done')) {// && $op_arr['wo_step3']['op_assigner'] == $me->get('id')
        if ($op_arr['wo_step3']['op_is_start'] == 1) { //after start
            if ($op_arr['wo_step3']['op_is_pause'] == 1) { //after start
                JToolBarHelper::popUpCompleteStepWo('Resume', 'save_resume_step', 'wo_step3', $this->wo_row->pns_wo_id, $this->wo_row->so_id);
            } else {
                JToolBarHelper::popUpCompleteStepWo('Pause', 'save_pause_step', 'wo_step3', $this->wo_row->pns_wo_id, $this->wo_row->so_id, 700, 500, 'restore');
                JToolBarHelper::popUpCompleteStepWo('Complete', 'save_complete_step', 'wo_step3', $this->wo_row->pns_wo_id, $this->wo_row->so_id);
                JToolBarHelper::popUpCompleteStepWo('FAILURE REPORT', 'save_failure_step', 'wo_step3', $this->wo_row->pns_wo_id, $this->wo_row->so_id, 700, 500, 'back');
            }

        } else {
            JToolBarHelper::popUpCompleteStepWo('Start', 'save_start_step', 'wo_step3', $this->wo_row->pns_wo_id, $this->wo_row->so_id);
        }
    }
//complete step4
    $checkStep3 = PNsController::checkStepBeforeDone('step4', $this->wo_row->pns_wo_id);
    if (($allow_complete || $op_arr['wo_step4']['op_assigner'] == $me->get('id')) && ($checkStep3 == 1 && $op_arr['wo_step3']['op_status'] == "done" && $op_arr['wo_step4']['op_status'] != 'done')) {// && $op_arr['wo_step3']['op_assigner'] == $me->get('id')
        if ($op_arr['wo_step4']['op_is_start'] == 1) { //after start
            if ($op_arr['wo_step4']['op_is_pause'] == 1) { //after start
                JToolBarHelper::popUpCompleteStepWo('Resume', 'save_resume_step', 'wo_step4', $this->wo_row->pns_wo_id, $this->wo_row->so_id);
            } else {
                JToolBarHelper::popUpCompleteStepWo('Pause', 'save_pause_step', 'wo_step4', $this->wo_row->pns_wo_id, $this->wo_row->so_id, 700, 500, 'restore');
                JToolBarHelper::popUpCompleteStepWo('Complete', 'save_complete_step', 'wo_step4', $this->wo_row->pns_wo_id, $this->wo_row->so_id);
                JToolBarHelper::popUpCompleteStepWo('FAILURE REPORT', 'save_failure_step', 'wo_step4', $this->wo_row->pns_wo_id, $this->wo_row->so_id, 700, 500, 'back');
            }


        } else {
            JToolBarHelper::popUpCompleteStepWo('Start', 'save_start_step', 'wo_step4', $this->wo_row->pns_wo_id, $this->wo_row->so_id);
        }
    }
//complete step5
    $checkStep4 = PNsController::checkStepBeforeDone('step5', $this->wo_row->pns_wo_id);
    if (($allow_complete || $op_arr['wo_step5']['op_assigner'] == $me->get('id')) && ($checkStep4 == 1 && $op_arr['wo_step4']['op_status'] == "done" && $op_arr['wo_step5']['op_status'] != 'done')) {// && $op_arr['wo_step4']['op_assigner'] == $me->get('id')
        if ($op_arr['wo_step5']['op_is_start'] == 1) { //after start
            if ($op_arr['wo_step5']['op_is_pause'] == 1) { //after start
                JToolBarHelper::popUpCompleteStepWo('Resume', 'save_resume_step', 'wo_step5', $this->wo_row->pns_wo_id, $this->wo_row->so_id);
            } else {
                JToolBarHelper::popUpCompleteStepWo('Pause', 'save_pause_step', 'wo_step5', $this->wo_row->pns_wo_id, $this->wo_row->so_id, 700, 500, 'restore');
                JToolBarHelper::popUpCompleteStepWo('Complete', 'save_complete_step5', 'wo_step5', $this->wo_row->pns_wo_id, $this->wo_row->so_id);
                JToolBarHelper::popUpCompleteStepWo('FAILURE REPORT', 'save_failure_step', 'wo_step5', $this->wo_row->pns_wo_id, $this->wo_row->so_id, 700, 500, 'back');
            }

        } else {
            JToolBarHelper::popUpCompleteStepWo('Start', 'save_start_step', 'wo_step5', $this->wo_row->pns_wo_id, $this->wo_row->so_id);
        }
    }
//complete step6
    $checkStep5 = PNsController::checkStepBeforeDone('step6', $this->wo_row->pns_wo_id);
    if (($allow_complete || $op_arr['wo_step6']['op_assigner'] == $me->get('id')) && ($checkStep5 == 1 && $op_arr['wo_step5']['op_status'] == "done" && $op_arr['wo_step6']['op_status'] != 'done')) {// && $op_arr['wo_step6']['op_assigner'] == $me->get('id')
        if ($op_arr['wo_step6']['op_is_start'] == 1) { //after start
            if ($op_arr['wo_step6']['op_is_pause'] == 1) { //after start
                JToolBarHelper::popUpCompleteStepWo('Resume', 'save_resume_step', 'wo_step6', $this->wo_row->pns_wo_id, $this->wo_row->so_id);
            } else {
                if ($this->wo_row->wo_rework_times < 2) {
                    JToolBarHelper::popUpCompleteStepWo('REWORK', 'save_rework_step', 'wo_step6', $this->wo_row->pns_wo_id, $this->wo_row->so_id, 780, 600, 'refresh');
                }
                JToolBarHelper::popUpCompleteStepWo('Pause', 'save_pause_step', 'wo_step6', $this->wo_row->pns_wo_id, $this->wo_row->so_id, 700, 500, 'restore');
                JToolBarHelper::popUpCompleteStepWo('Complete', 'save_complete_step6', 'wo_step6', $this->wo_row->pns_wo_id, $this->wo_row->so_id, 700, 500);
                JToolBarHelper::popUpCompleteStepWo('FAILURE REPORT', 'save_failure_step', 'wo_step6', $this->wo_row->pns_wo_id, $this->wo_row->so_id, 700, 500, 'back');
            }

        } else {
            JToolBarHelper::popUpCompleteStepWo('Start', 'save_start_step', 'wo_step6', $this->wo_row->pns_wo_id, $this->wo_row->so_id);
        }
    }
//complete step7
    $checkStep6 = PNsController::checkStepBeforeDone('step7', $this->wo_row->pns_wo_id);
    if (($allow_complete || $op_arr['wo_step7']['op_assigner'] == $me->get('id')) && ($checkStep6 == 1 && $op_arr['wo_step6']['op_status'] == "done" && $op_arr['wo_step7']['op_status'] != 'done')) {//
        if ($op_arr['wo_step7']['op_is_start'] == 1) { //after start
            if ($op_arr['wo_step4']['op_is_pause'] == 1) { //after start
                JToolBarHelper::popUpCompleteStepWo('Resume', 'save_resume_step', 'wo_step6', $this->wo_row->pns_wo_id, $this->wo_row->so_id);
            } else {
                JToolBarHelper::popUpCompleteStepWo('Pause', 'save_pause_step', 'wo_step6', $this->wo_row->pns_wo_id, $this->wo_row->so_id, 700, 500, 'restore');
                JToolBarHelper::popUpCompleteStepWo('Complete', 'save_complete_step', 'wo_step7', $this->wo_row->pns_wo_id, $this->wo_row->so_id);
            }

        } else {
            JToolBarHelper::popUpCompleteStepWo('Start', 'save_start_step', 'wo_step7', $this->wo_row->pns_wo_id, $this->wo_row->so_id);
        }
    }

}

$cparams = JComponentHelper::getParams('com_media');
$editor = &JFactory::getEditor();
//$generator = new BarcodeGeneratorHTML();       
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
        if (pressbutton == 'requestmaterialwo') {
                window.location = "index.php?option=com_apdmpns&task=requestmaterialwo&id="+form.wo_id.value;
           //submitform( pressbutton );
            return;
        }        
        if (pressbutton == 'printwopdf') {
            //window.location = "index.php?option=com_apdmpns&task=printwopdf&id="+form.wo_id.value + "&tmpl=component";
            var url = "index.php?option=com_apdmpns&task=printwopdf&id="+form.wo_id.value + "&tmpl=component";
            window.open(url, '_blank');
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

</script>
<style type="text/css">
    .tgdetail  {border-collapse:collapse;border-spacing:0;}
    .tgdetail td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
    .tgdetail th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
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
<div class="submenu-box">
    <div class="t">
        <div class="t">
            <div class="t"></div>
        </div>
    </div>
    <div class="m">
        <ul id="submenu" class="configuration">
            <li><a id="detail" class="active"><?php echo JText::_( 'DETAIL' ); ?></a></li>
            <li><a id="bom" href="index.php?option=com_apdmpns&task=wo_log&id=<?php echo $this->wo_row->pns_wo_id;?>&time=<?php echo time()?>"><?php echo JText::_( 'LOG' ); ?></a></li>
            <li><a id="diary" href="index.php?option=com_apdmpns&task=wo_diary&id=<?php echo $this->wo_row->pns_wo_id;?>&time=<?php echo time()?>"><?php echo JText::_( 'DIARY' ); ?></a></li>
            <li><a id="material" href="index.php?option=com_apdmpns&task=wo_material&id=<?php echo $this->wo_row->pns_wo_id;?>&time=<?php echo time()?>"><?php echo JText::_( 'MATERIAL REQUEST' ); ?></a></li>
            <li><a id="rework_log" href="index.php?option=com_apdmpns&task=wo_rework_log&id=<?php echo $this->wo_row->pns_wo_id;?>&time=<?php echo time()?>"><?php echo JText::_( 'REWORK' ); ?></a></li>
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

<form action="index.php"  onsubmit="submitbutton('')"  method="post" name="adminForm" >


    <table class="tgdetail">
        <tr>
            <th class="tg-0pky" colspan="3"><img src="./templates/khepri/images/h_green/header.jpg"></img></th>
            <th class="tg-7jts" colspan="3"><span style="font-weight:bold">Production Traveler</span></th>
            <th class="tg-c3ow" colspan="4">
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
            <td class="tg-0pky" colspan="3"><span style="font-weight:bold">WO NUMBER</span></td>
            <td class="tg-c3ow" colspan="3"><?php echo $this->wo_row->wo_code;?></td>
            <td class="tg-0pky"><span style="font-weight:bold">STATUS</span></td>
            <td class="tg-c3ow" colspan="3"><?php 
            echo PNsController::getWoStatus($this->wo_row->wo_state); 
             $wo_step = PNsController::getWoStepCode($this->wo_row->wo_state);                          
             if($op_arr[$wo_step]['op_failure_report']!=0)
            {
                    echo "(failure report)";
            }
            if($op_arr[$wo_step]['op_rework_times']==1)
            {
                    echo "(1st Rework)";
            }
            elseif($op_arr[$wo_step]['op_rework_times']==2)
            {
                    echo "(2nd Rework)";
            }
            ?></td>
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
            <td class="tg-0pky"><span style="font-weight:bold">UOM</span></td>
            <td class="tg-0pky"><?php echo $this->row_part->pns_uom;?></td>
        </tr>
        <tr>
            <td class="tg-0pky" colspan="3"><span style="font-weight:bold">DESCRIPTION</span></td>
            <td class="tg-c3ow" colspan="7"><?php echo $this->row_part->pns_description;?></td>
        </tr>
        <tr>
            <td class="tg-0pky" colspan="3"><span style="font-weight:bold">REQUIRED</span>
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
            <td class="tg-0pky" colspan="3"><span style="font-weight:bold">TOP LEVEL ASSY PN</span></td>
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
            <td class="tg-0pky" colspan="3"><span style="font-weight:bold">REQUEST DATE</span></td>
            <td class="tg-0pky" colspan="3"><?php echo JHTML::_('date', $this->wo_row->so_shipping_date, JText::_('DATE_FORMAT_LC5')); ?><?php //echo PNsController::getCcsName($this->wo_row->wo_customer_id); ?></td>
            <td class="tg-0pky"><span style="font-weight:bold"></span></td>
            <td class="tg-dvpl" colspan="3"></td>
        </tr>
        <tr>
            <td class="tg-0pky" colspan="3"><span style="font-weight:bold">SO NUMBER</span></td>
            <td class="tg-0pky" colspan="3"><?php
                $soNumber = $this->wo_row->so_cuscode;
                if($this->wo_row->ccs_code)
                {
                    $soNumber = $this->wo_row->ccs_code."-".$soNumber;
                }
                echo $soNumber;?></td>
            <td class="tg-0pky"><span style="font-weight:bold">WO STARTED</span></td>
            <td class="tg-dvpl" colspan="3"><?php echo JHTML::_('date', $this->wo_row->wo_start_date, JText::_('DATE_FORMAT_LC5')); ?></td>
        </tr>
        <tr>
            <td class="tg-0pky" colspan="3"><span style="font-weight:bold">CREATED BY</span></td>
            <td class="tg-0pky" colspan="3"><?php echo GetValueUser($this->wo_row->wo_created_by, "name"); ?></td>
            <td class="tg-0pky"><span style="font-weight:bold">WO FINISHED</span></td>
            <td class="tg-dvpl" colspan="3"><?php echo JHTML::_('date', $this->wo_row->wo_completed_date, JText::_('DATE_FORMAT_LC5')); ?></td>
        </tr>
        <tr>
            <td class="tg-0pky" colspan="3"><span style="font-weight:bold">CREATED DATE</span></td>
            <td class="tg-0pky" colspan="3"><?php echo JHTML::_('date', $this->wo_row->wo_created, JText::_('DATE_FORMAT_LC5')); ?></td>
            <td class="tg-0pky"><span style="font-weight:bold">ASSIGNER</span></td>
            <td class="tg-dvpl" colspan="3"><?php echo GetValueUser($this->wo_row->wo_assigner, "name"); ?></td>
        </tr>
        <tr>
            <td class="tg-7jts" colspan="10"><span style="font-weight:bold">OPERATIONS</span>
                
            </td>
        </tr>
        <tr>
            <td class="tg-w9sc">NO.</td>
            <td class="tg-b2ze" colspan="5">STEP</td>
            <td class="tg-v783">COMMENTS</td>
            <td class="tg-v783">COMPLETED DATE</td>
            <td class="tg-v783">ASSIGNEE</td>
            <td class="tg-v783">TARGET DATE</td>
        </tr>
        <tr>
            <td class="tg-uys7">1</td>
            <td class="tg-0pky" colspan="5">Doc. Preparation:</td>
            <td class="tg-xldj"><?php echo $op_arr['wo_step1']['op_comment'];?></td>
            <td class="tg-xldj"><?php echo ($op_arr['wo_step1']['op_completed_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step1']['op_completed_date'], JText::_('DATE_FORMAT_LC6')):""; ?></td>
            <td class="tg-xldj"><?php echo ($op_arr['wo_step1']['op_assigner']!=0)?GetValueUser($op_arr['wo_step1']['op_assigner'], "name"):"N/A"; ?></td>
            <td class="tg-xldj"><?php echo ($op_arr['wo_step1']['op_target_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step1']['op_target_date'], JText::_('DATE_FORMAT_LC6')):""; ?></td>
        </tr>
        <tr>
            <td class="tg-uys7">2</td>
            <td class="tg-0pky" colspan="5">Label Print By:</td>
            <td class="tg-xldj"><?php echo $op_arr['wo_step2']['op_comment'];?></td>
            <td class="tg-xldj"><?php echo ($op_arr['wo_step2']['op_completed_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step2']['op_completed_date'], JText::_('DATE_FORMAT_LC6')):""; ?></td>
            <td class="tg-xldj"><?php echo ($op_arr['wo_step2']['op_assigner']!=0)?GetValueUser($op_arr['wo_step2']['op_assigner'], "name"):"N/A"; ?></td>
            <td class="tg-xldj"><?php echo ($op_arr['wo_step2']['op_target_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step2']['op_target_date'], JText::_('DATE_FORMAT_LC6')):""; ?></td>
        </tr>
        <tr>
            <td class="tg-uys7">3</td>
            <td class="tg-0pky" colspan="5">Wire Cut By:</td>
            <td class="tg-xldj"><?php echo $op_arr['wo_step3']['op_comment'];?></td>
            <td class="tg-xldj"><?php echo ($op_arr['wo_step3']['op_completed_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step3']['op_completed_date'], JText::_('DATE_FORMAT_LC6')):""; ?></td>
            <td class="tg-xldj"><?php echo ($op_arr['wo_step3']['op_assigner']!=0)?GetValueUser($op_arr['wo_step3']['op_assigner'], "name"):"N/A"; ?></td>
            <td class="tg-xldj"><?php echo ($op_arr['wo_step3']['op_target_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step3']['op_target_date'], JText::_('DATE_FORMAT_LC6')):""; ?></td>
        </tr>
        <tr>
            <td class="tg-uys7">4</td>
            <td class="tg-0pky" colspan="5">Kitted By:</td>
            <td class="tg-xldj"><?php echo $op_arr['wo_step4']['op_comment'];?></td>
            <td class="tg-xldj"><?php echo ($op_arr['wo_step4']['op_completed_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step4']['op_completed_date'], JText::_('DATE_FORMAT_LC6')):""; ?></td>
            <td class="tg-xldj"><?php echo ($op_arr['wo_step4']['op_assigner']!=0)?GetValueUser($op_arr['wo_step4']['op_assigner'], "name"):"N/A"; ?></td>
            <td class="tg-xldj"><?php echo ($op_arr['wo_step4']['op_target_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step4']['op_target_date'], JText::_('DATE_FORMAT_LC6')):""; ?></td>
        </tr>
        <tr>
            <td class="tg-c3ow">5</td>
            <td class="tg-0pky" colspan="5">Assembly performed by:</td>
            <td class="tg-xldj"></td>
            <td class="tg-xldj"><?php echo ($op_arr['wo_step5']['op_completed_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step5']['op_completed_date'], JText::_('DATE_FORMAT_LC6')):""; ?></td>
            <td class="tg-xldj"><?php echo ($op_arr['wo_step5']['op_assigner']!=0)?GetValueUser($op_arr['wo_step5']['op_assigner'], "name"):"N/A"; ?></td>
            <td class="tg-xldj"><?php echo ($op_arr['wo_step5']['op_target_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step5']['op_target_date'], JText::_('DATE_FORMAT_LC6')):""; ?></td>
        </tr>
        <tr>
            <td class="tg-c3ow">Process</td>
            <td class="tg-0pky" colspan="2">Solder?</td>
            <td class="tg-0pky" colspan="2">Crimp?</td>
            <td class="tg-0pky">None</td>
            <td class="tg-0pky" colspan="4" rowspan="6"><?php echo $op_arr['wo_step5']['op_comment'];?></td>
            
        </tr>
        <tr>
            <td class="tg-c3ow" rowspan="5">Production</td>
            <td class="tg-0pky">CONT#</td>
            <td class="tg-0pky">Wire size#</td>
            <td class="tg-0pky" width="120px">TOOL ID# <?php
//            if($listTool){
//            foreach($listTool as $rowsto)
//            {
//                    echo "<a href='index.php?option=com_apdmtto&task=tto_detail&id=".$rowsto->pns_tto_id."'>".$rowsto->tto_code."</a><br>";
//            }
//            }
            ?></td>
            <td class="tg-0pky">Height</td>
            <td class="tg-0pky">Pull Force</td>
            
        </tr>
        <?php
        $iassem=1;
        foreach ($this->wo_assem_rows as $a_row)
        {
            ?>
            <tr>
                <td class="tg-0pky"><?php echo $a_row->op_assembly_value1; ?></td>
                <td class="tg-0pky"><?php echo $a_row->op_assembly_value2; ?></td>
                <td class="tg-0pky">
                <?php  $arrTool = PNsController::getTtofromWo($this->wo_row->pns_wo_id);
                echo $arrTool[$iassem];
               // echo $a_row->op_assembly_value3; ?></td>
                <td class="tg-0pky"><?php echo $a_row->op_assembly_value4; ?></td>
                <td class="tg-0pky"><?php echo $a_row->op_assembly_value5; ?></td>
               
            </tr>
            <?php
            $iassem++;
        }
        ?>

        <tr>
            <td class="tg-0pky" colspan="5"></td>
            <td class="tg-b2ze" colspan="2">Inspection(QC)</td>
            <!--<td class="tg-b2ze">2nd Fail Qty</td>-->
            <td class="tg-b2ze">COMPLETED DATE</td>
            <td class="tg-b2ze">ASSIGNEE</td>
            <td class="tg-b2ze">TARGET DATE</td>
        </tr>
       
        <tr>
            <td class="tg-7btt">6</td>
            <td class="tg-0pky" colspan="4">Inspection(QC) By:</td>
            <td class="tg-0pky" colspan="2"></td>
<!--            <td class="tg-0pky"></td>-->
            <td class="tg-0pky"><?php echo ($op_arr['wo_step6']['op_completed_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step6']['op_completed_date'], JText::_('DATE_FORMAT_LC6')):""; ?></td>
            <td class="tg-0pky"><?php echo ($op_arr['wo_step6']['op_assigner']!=0)?GetValueUser($op_arr['wo_step6']['op_assigner'], "name"):"N/A"; ?></td>
            <td class="tg-0pky"><?php echo ($op_arr['wo_step6']['op_target_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step6']['op_target_date'], JText::_('DATE_FORMAT_LC6')):""; ?></td>
        </tr>
        <?php
        $opfn_arr = $this->opfn_arr;
        ?>
        <tr>
            <td class="tg-0pky"></td>
            <td class="tg-0pky">&gt;</td>
            <td class="tg-0pky" colspan="3">Document(BOM,Drawing,Pro. Traveler)</td>
            <td class="tg-0pky" colspan="2">
                <?php
                if($opfn_arr[1]['op_final_value1']=='1')
                    echo "PASS";
                elseif($opfn_arr[1]['op_final_value1']=='0')
                    echo "FAIL";
                ?>
            </td>
<!--            <td class="tg-0pky"><?php echo $opfn_arr[2]['op_final_value1']?></td>-->
            
            <td class="tg-c3ow" colspan="3"><span style="font-weight:700">COMMENTS</span></td>
        </tr>
        <tr>
            <td class="tg-0pky"></td>
            <td class="tg-0pky">&gt;</td>
            <td class="tg-0pky" colspan="3">Visual Inspection</td>
            <td class="tg-0pky" colspan="2">
            <?php
                if($opfn_arr[1]['op_final_value2']=='1')
                echo "PASS";
                elseif($opfn_arr[1]['op_final_value2']=='0')
                echo "FAIL";
                ?>
            </td>
<!--            <td class="tg-0pky"><?php echo $opfn_arr[2]['op_final_value2']?></td>-->            
            <td class="tg-0pky" colspan="3" rowspan="7"><?php echo $op_arr['wo_step6']['op_comment'];?></td>
        </tr>
        <tr>
            <td class="tg-0pky"></td>
            <td class="tg-0pky">&gt;</td>
            <td class="tg-0pky" colspan="3">Dimention</td>
            <td class="tg-0pky" colspan="2">
                <?php
                if($opfn_arr[1]['op_final_value3']=='1')
                echo "PASS";
                elseif($opfn_arr[1]['op_final_value3']=='0')
                echo "FAIL";
                ?>
            </td>
<!--            <td class="tg-0pky"><?php echo $opfn_arr[2]['op_final_value3']?></td>-->
            
        </tr>
        <tr>
            <td class="tg-0pky"></td>
            <td class="tg-0pky">&gt;</td>
            <td class="tg-0pky" colspan="3">Label</td>
            <td class="tg-0pky" colspan="2">
                <?php
                if($opfn_arr[1]['op_final_value4']=='1')
                echo "PASS";
                elseif($opfn_arr[1]['op_final_value4']=='0')
                echo "FAIL";
                ?>
            </td>
<!--            <td class="tg-0pky"><?php echo $opfn_arr[2]['op_final_value4']?></td>-->
            
        </tr>
        <tr>
            <td class="tg-0pky"></td>
            <td class="tg-0pky">&gt;</td>
            <td class="tg-0pky" colspan="3">Wiring</td>
            <td class="tg-0pky" colspan="2">
                <?php
                if($opfn_arr[1]['op_final_value5']=='1')
                echo "PASS";
                elseif($opfn_arr[1]['op_final_value5']=='0')
                echo "FAIL";
                ?>
            </td>
<!--            <td class="tg-0pky"><?php echo $opfn_arr[2]['op_final_value5']?></td>-->
            
        </tr>
        <tr>
            <td class="tg-0pky"></td>
            <td class="tg-0pky">&gt;</td>
            <td class="tg-0pky" colspan="3">Connection</td>
            <td class="tg-0pky" colspan="2">
                <?php
                if($opfn_arr[1]['op_final_value6']=='1')
                echo "PASS";
                elseif($opfn_arr[1]['op_final_value6']=='0')
                echo "FAIL";
                ?>
            </td>
<!--            <td class="tg-0pky"><?php echo $opfn_arr[2]['op_final_value6']?></td>-->
            
        </tr>
        <tr>
            <td class="tg-0pky"></td>
            <td class="tg-0pky">&gt;</td>
            <td class="tg-0pky" colspan="3">Hipot Test</td>
            <td class="tg-0pky" colspan="2">
                <?php
                if($opfn_arr[1]['op_final_value7']=='1')
                echo "PASS";
                elseif($opfn_arr[1]['op_final_value7']=='0')
                echo "FAIL";
                ?>
            </td>
<!--            <td class="tg-0pky"><?php echo $opfn_arr[2]['op_final_value7']?></td>-->
            
        </tr>
        <tr>
            <td class="tg-0pky"></td>
            <td class="tg-0pky">&gt;</td>
            <td class="tg-0pky" colspan="3">Other</td>
            <td class="tg-0pky" colspan="2">
                <?php
                if($opfn_arr[1]['op_final_value8']=='1')
                echo "PASS";
                elseif($opfn_arr[1]['op_final_value8']=='0')
                echo "FAIL";
                ?>
            </td>
<!--            <td class="tg-0pky"><?php echo $opfn_arr[2]['op_final_value8']?></td>-->
           
        </tr>
        <tr>
            <td class="tg-0pky" colspan="6"></td>
            <td class="tg-b2ze">COMMENTS</td>
            <td class="tg-b2ze">COMPLETED DATE</td>
            <td class="tg-b2ze">ASSIGNEE</td>
            <td class="tg-b2ze">TARGET DATE</td>
        </tr>
        <tr>
            <td class="tg-7btt">7</td>
            <td class="tg-0pky" colspan="5">Packaging by</td>
            <td class="tg-0pky"><?php echo $op_arr['wo_step7']['op_comment'];?></td>
            <td class="tg-0pky"><?php echo ($op_arr['wo_step7']['op_completed_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step7']['op_completed_date'], JText::_('DATE_FORMAT_LC6')):""; ?></td>
            <td class="tg-0pky"><?php echo ($op_arr['wo_step7']['op_assigner']!=0)?GetValueUser($op_arr['wo_step7']['op_assigner'], "name"):"N/A"; ?></td>
            <td class="tg-0pky"><?php echo ($op_arr['wo_step7']['op_target_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr['wo_step7']['op_target_date'], JText::_('DATE_FORMAT_LC6')):""; ?></td>
        </tr>
    </table>
    <input type="hidden" name="wo_id" value="<?php echo $this->wo_row->pns_wo_id; ?>" />
    <input type="hidden" name="option" value="com_apdmpns" />
    <input type="hidden" name="id" value="<?php echo JRequest::getVar('id'); ?>" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="1" />
    <?php echo JHTML::_('form.token'); ?>
</form>
