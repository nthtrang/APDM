<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php
	//$role = JAdministrator::RoleOnComponent(6);
	JToolBarHelper::title( JText::_( 'ADVANCE SEARCH' ) , 'search.png' );

	
        JToolBarHelper::customX("searchadvance","search",'',"Search",false);  
        JToolBarHelper::customX("cancelsearch","cancel",'',"Reset",false);  
	$cparams = JComponentHelper::getParams ('com_media');
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	
?>
<script language="javascript">
function submitbutton(pressbutton) {
        
			var form = document.adminForm;		
                       
			if (pressbutton == 'searchadvance') {                               
				var d = document.adminForm;                             
//				if (d.so_cuscode.value==""){
//					alert("Please input keyword");	
//					d.so_cuscode.focus();
//					return;				
//				}else{
					submitform( pressbutton );
				//}
				
			}
                        if (pressbutton == 'cancelsearch') {  
                                 window.location = "index.php?option=com_apdmpns&task=searchadvance&clean=all";
                                 return;
                        }
                        
			
		}
                function controlStatusSearch(type_search)
                {
                        if(type_search=="searchso")
                        {
                                for(var i = 1;i<=12;i++){                                        
                                        document.getElementById('wo_op_status'+i).setAttribute("onclick","javascript: return false;");                                        
                                        if(i<=5){
                                                document.getElementById('so_status'+i).setAttribute("onclick","");
                                        }
                                        if(i<=3){
                                                document.getElementById('wo_step_status'+i).setAttribute("onclick","javascript: return false;");
                                        }
                                        
                                        
                                }
                        }
                        if(type_search=="searchwo")
                        {
                                for(var i = 1;i<=5;i++){                                        
                                        document.getElementById('so_status'+i).setAttribute("onclick","javascript: return false;");
                                        if(i<=3){
                                                document.getElementById('wo_step_status'+i).setAttribute("onclick","javascript: return false;");
                                        }
                                        
                                }
                                 for(var i = 1;i<=12;i++){
                                         document.getElementById('wo_op_status'+i).setAttribute("onclick","");
                                 }
                        }
                         if(type_search=="searchstep")
                        {                               
                                 for(var i = 1;i<=12;i++){
                                         document.getElementById('wo_op_status'+i).setAttribute("onclick","javascript: return false;");
                                         if(i<=3){
                                                document.getElementById('wo_step_status'+i).setAttribute("onclick","");
                                        }
                                         if(i<=5){
                                                document.getElementById('so_status'+i).setAttribute("onclick","javascript: return false;");
                                        }
                                 }
                        }
                }

</script>
<form action="index.php?option=com_apdmpns&task=searchadvance" method="post" name="adminForm"  >
<!--<input type="hidden" name="query_export" value="<?php echo $this->lists['query'];?>" />
<input type="hidden" name="total_record" value="<?php echo $this->lists['total_record'];?>" />-->
<table class="admintable" cellspacing="1" width="100%" border="0">           
  <tr>
    <td colspan="2"><strong>OBJECT</strong></td>
    <td colspan="2"><strong>TIME</strong><br></td>
    <td><strong>SO OPTION</strong></td>
    <td><strong>WO OPTION</strong></td>
  </tr>
  <tr>
    <td><input type="radio" onclick="controlStatusSearch(this.value)" name="search_swo_type" value="searchso" <?php echo ($this->search_swo_type=='searchso')?"checked='checked'":"";?>>SO:</td>
    <td><input type="text" maxlength="20" name="so_cuscode"  id="so_cuscode" class="inputbox" size="30" value="<?php echo $this->search_so?>"/></td>
    <td>Time remain under</td>
    <td><input type="text" maxlength="20" name="time_remain"  onKeyPress="return numbersOnly(this, event);" id="time_remain" class="inputbox" size="30" value="<?php echo $this->time_remain?>"/> days</td>
    <td><input type="radio" name="so_status" id="so_status1" value="done" <?php echo ($this->so_status=='done')?"checked='checked'":"";?>>Done</td>
    <td><input type="radio" name="wo_op_status"  id="wo_op_status1" value="label_printed" <?php echo ($this->wo_op_status=='label_printed')?"checked='checked'":"";?>>Label Printed</td>
  </tr>
  <tr>
    <td><input type="radio" onclick="controlStatusSearch(this.value)"  name="search_swo_type" value="searchwo" <?php echo ($this->search_swo_type=='searchwo')?"checked='checked'":"";?>>WO:</td>
    <td><input type="text" maxlength="20" name="wo_cuscode"  id="wo_cuscode" class="inputbox" size="30" value="<?php echo $this->search_wo?>"/></td>
    <td>Time From</td>
  <td>
     <?php echo JHTML::_('calendar',$this->time_from,'time_from', 'time_from', '%m/%d/%Y', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	                                                       
      To 
      <?php echo JHTML::_('calendar',$this->time_to, 'time_to', 'time_to', '%m/%d/%Y', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	     
  </td>
     <td><input type="radio" name="so_status" id="so_status2" value="onhold"  <?php echo ($this->so_status=='onhold')?"checked='checked'":"";?>>On Hold</td>
     <td><input type="radio" name="wo_op_status"  id="wo_op_status2" value="wire_cut" <?php echo ($this->wo_op_status=='wire_cut')?"checked='checked'":"";?>>Wire Cut</td>
  </tr>
  <tr>
    <td><input type="radio" onclick="controlStatusSearch(this.value)"  name="search_swo_type" value="searchstep" <?php echo ($this->search_swo_type=='searchstep')?"checked='checked'":"";?>>Step:</td>
    <td>
    <?php echo $this->list_step;?>  
    </td>
    <td></td>
    <td></td>
    <td><input type="radio" name="so_status" id="so_status3" value="inprogress" <?php echo ($this->so_status=='inprogress')?"checked='checked'":"";?> >In Progress</td>
    <td><input type="radio" name="wo_op_status"  id="wo_op_status3" value="kitted" <?php echo ($this->wo_op_status=='kitted')?"checked='checked'":"";?>>Kitted</td>
  </tr>
  <tr>
          <td>Employee:</td>
    <td>
            <?php echo $this->list_assigners;?>            
    <td></td>
    <td></td>
    <td><input type="radio" name="so_status" id="so_status4" value="cancel" <?php echo ($this->so_status=='cancel')?"checked='checked'":"";?>>Cancel</td>
    <td><input type="radio" name="wo_op_status"  id="wo_op_status4" value="production" <?php echo ($this->wo_op_status=='production')?"checked='checked'":"";?>>Production</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>    
    <td><input type="radio" name="so_status" id="so_status5" value="rma" <?php echo ($this->so_status=='rma')?"checked='checked'":"";?>>RMA</td>
    <td><input type="radio" name="wo_op_status"  id="wo_op_status5" value="visual_inspection" <?php echo ($this->wo_op_status=='visual_inspection')?"checked='checked'":"";?>>Visual Inspection</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td><input type="radio" name="wo_op_status"  id="wo_op_status6" value="final_inspection" <?php echo ($this->wo_op_status=='final_inspection')?"checked='checked'":"";?>>Final Inspection</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
   <td><input type="radio" name="wo_op_status"  id="wo_op_status7" value="packaging" <?php echo ($this->wo_op_status=='packaging')?"checked='checked'":"";?>>Packing</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td><input type="radio" name="wo_op_status"  id="wo_op_status8" value="done" <?php echo ($this->wo_op_status=='done')?"checked='checked'":"";?>>Done</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td><strong>STEP & EMP.OPTION</strong></td>
    <td><input type="radio" name="wo_op_status"  id="wo_op_status9" value="onhold" <?php echo ($this->wo_op_status=='onhold')?"checked='checked'":"";?>>On hold</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td><input type="radio" name="wo_step_status" id="wo_step_status1" value="done" <?php echo ($this->wo_step_status=='done')?"checked='checked'":"";?>>Done</td>
    <td><input type="radio" name="wo_op_status"  id="wo_op_status10" value="cancel" <?php echo ($this->wo_op_status=='cancel')?"checked='checked'":"";?>>Cancel</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
   <td><input type="radio" name="wo_step_status" id="wo_step_status2"  value="delay" <?php echo ($this->wo_step_status=='delay')?"checked='checked'":"";?>>Delay</td>
    <td><input type="radio"name="wo_op_status"  id="wo_op_status11"value="rework" <?php echo ($this->wo_op_status=='rework')?"checked='checked'":"";?>>Rework</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
       <td><input type="radio" name="wo_step_status" id="wo_step_status3"  value="inprogress" <?php echo ($this->wo_step_status=='inprogress')?"checked='checked'":"";?>>In Progress</td>
        <td ><input type="radio" name="wo_op_status"  id="wo_op_status12" value="delay" <?php echo ($this->wo_op_status=='delay')?"checked='checked'":"";?>>Delay</td>
  </tr>
 
</table>


        <?php

if($this->search_swo_type== "searchso" && count($this->rs_so))
{      
        ?>
       
      <fieldset class="adminform">
		 <legend><?php echo JText::_("SO Result");?></legend>                                            
<?php 
if (count($this->rs_so) > 0) { ?>
                <table class="adminlist" cellspacing="1" width="400">
                        <thead>
                                <tr>
                                        <th width="2%"><?php echo JText::_('NUM'); ?></th>
                                        <th width="100"><?php echo JText::_('SO'); ?></th>
                                        <th width="100"><?php echo JText::_('Start date'); ?></th>
                                        <th width="100"><?php echo JText::_('Shipping request date'); ?></th>                                      
                                        <th width="100"><?php echo JText::_('Time Remain'); ?></th>                                        
                                        <th width="100"><?php echo JText::_('Status'); ?></th>
                                        <th width="100"><?php echo JText::_('RMA'); ?></th>                                                                         
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
                                        $remain_day = $so->so_remain_date+1;  
                                        $background= "style='background-color:#f00;color:#fff'";
                                }
                        }
                        elseif($remain_day<=3)
                        {        
                                if($so->so_state != 'done' && $so->so_state != 'cancel')
                                {
                                        $remain_day = $so->so_remain_date+1;  
                                        $background= "style='background-color:#ff0;color:#000'";
                                }
                        }				
                ?>
                                        <tr>
                                                <td align="center"><?php echo $i;?></td>
                                                <td align="center"><a href="index.php?option=com_apdmpns&task=so_detail&id=<?php echo $so->pns_so_id; ?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $soNumber; ?></a> </td>
                                                <td align="center">
                                                 <?php echo JHTML::_('date', $so->so_start_date, JText::_('DATE_FORMAT_LC5')); ?>
                                                </td>     
                                                 <td align="center">
                                                <?php echo JHTML::_('date', $so->so_shipping_date, JText::_('DATE_FORMAT_LC5')); ?>
                                                </td> 
                                                <td align="center" <?php echo $background?>><?php echo $remain_day;?></td>
                                                <td>
                                                       <?php 
                                                       echo PNsController::getSoStatus($so->so_state); ?>
                                                </td>
                                                <td align="center"><?php echo $so->rma; ?></td>
                                                </tr>
                                                <?php }
                                        } ?>
                </tbody>
        </table>
      </fieldset>

  <?php
}
if($this->search_swo_type== "searchwo" && count($this->rs_wo))
{      
        ?>
       
      <fieldset class="adminform">
		 <legend><?php echo JText::_("WO Result");?></legend>
               
<?php 
if (count($this->rs_wo) > 0) { ?>
                <table class="adminlist" cellspacing="1" width="400">
                        <thead>
                                <tr>
                                        <th width="2%"><?php echo JText::_('NUM'); ?></th>
                                        <th width="100"><?php echo JText::_('WO'); ?></th>                                       
                                        <th width="100"><?php echo JText::_('Start Date'); ?></th>
                                        <th width="100"><?php echo JText::_('Finish Date'); ?></th>
                                        <th width="100"><?php echo JText::_('Time Remain(days)'); ?></th>                                        
                                        <th width="100"><?php echo JText::_('Status'); ?></th>
                                        <th width="100"><?php echo JText::_('Rework'); ?></th>
                                        <th width="100"><?php echo JText::_('Delay'); ?></th>                                     
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
                                                    
                                                <td align="center">
                                                 <?php echo JHTML::_('date', $wo->wo_start_date, JText::_('DATE_FORMAT_LC5')); ?>
                                                </td>     
                                                 <td align="center">
                                                <?php echo JHTML::_('date', $wo->wo_completed_date, JText::_('DATE_FORMAT_LC5')); ?>
                                                </td> 
                                                <td  align="center"<?php echo $background?>><?php echo $remain_day;?></td>
                                                  <td><?php echo PNsController::getWoStatus($wo->wo_state); ?></td>
                                               <td align="center"><?php echo (PNsController::getReworkStep($wo->pns_wo_id))?PNsController::getReworkStep($wo->pns_wo_id):0;?></td>
                                                  <td align="center"><?php echo $wo->wo_delay;//PNsController::getDelayTimes($wo->pns_wo_id);?></td>
                                               
                                                </tr>
                                                <?php }
                                        } ?>
                </tbody>
        </table>
      </fieldset>

  <?php
}
if($this->search_swo_type== "searchstep" && count($this->rs_step))
{      
        ?>
       
      <fieldset class="adminform">
		 <legend><?php echo JText::_("Step Result");?></legend>
               
<?php 
if (count($this->rs_step) > 0) { ?>
                <table class="adminlist" cellspacing="1" width="400">
                        <thead>
                                <tr>
                                        <th width="2%"><?php echo JText::_('NUM'); ?></th>
                                         <th width="100"><?php echo JText::_('WO'); ?></th>
                                        <th width="100"><?php echo JText::_('Step'); ?></th>                                       
                                        <th width="100"><?php echo JText::_('Emp'); ?></th>
                                        <th width="100"><?php echo JText::_('Start Date'); ?></th>
                                        <th width="100"><?php echo JText::_('Target Date'); ?></th>
                                        <th width="100"><?php echo JText::_('Time Remain(days)'); ?></th>                                        
                                        <th width="100"><?php echo JText::_('Status'); ?></th>
<!--                                        <th width="100"><?php echo JText::_('Rework'); ?></th>-->
                                        <th width="100"><?php echo JText::_('Delay'); ?></th>                                     
                                </tr>
                        </thead>                  
                        <tbody>					
        <?php
        $i = 0;
        foreach ($this->rs_step as $wop) {
                $i++;
                 $remain_day = $wop->wop_remain_date+1;
                 $background = "";
                        if($remain_day<=0)
                        {
                                $remain_day = 0;
                                if($wop->op_status != 'done')
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
                                                <td align="center"><a href="index.php?option=com_apdmpns&task=wo_detail&id=<?php echo $wop->wo_id; ?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $wop->wo_code; ?></a> </td>
                                                <td align="center"><?php echo PNsController::getWoStep($wop->op_code); ?></td>
                                                <td align="center">
                                                        <?php echo GetValueUser($wop->op_assigner, "name"); ?>
                                                </td>
                                                <td align="center">
                                                 <?php echo JHTML::_('date', $wop->op_start_date, JText::_('DATE_FORMAT_LC5')); ?>
                                                </td>
                                                 <td align="center">
                                                <?php
                                                if($wop->op_target_date!="0000-00-00 00:00:00"){
                                                    echo JHTML::_('date', $wop->op_target_date, JText::_('DATE_FORMAT_LC5'));
                                                }
                                                else
                                                {
                                                    echo "NA";
                                                }

                                                ?>
                                                </td>
                                                <td align="center" <?php echo $background?>><?php echo $remain_day;?></td>
                                                  <td><?php
                                                  if($wop->op_status=="done")
                                                          echo "Done";
                                                  elseif($wop->op_status!="done")
                                                          echo "In Progress";
                                                  elseif($wop->op_delay)
                                                          echo "Delay";
                                                    ?></td>
                                                  <td align="center"><?php echo ($wop->op_delay)?$wop->op_delay:0;//PNsController::getDelayTimes($wo->pns_wo_id);?></td>
                                               
                                                </tr>
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
	<input type="hidden" name="task" value="searchadvance" />
	<input type="hidden" name="boxchecked" value="1" />	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
