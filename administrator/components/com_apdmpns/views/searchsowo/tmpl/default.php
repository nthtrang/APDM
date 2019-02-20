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
    <td><input type="radio" name="search_swo_type" value="searchso" <?php echo ($this->search_swo_type=='searchso')?"checked='checked'":"";?>>SO#:</td>
    <td><input type="text" maxlength="20" name="so_cuscode"  id="so_cuscode" class="inputbox" size="30" value="<?php echo $this->search_so?>"/></td>
    <td>Time remain under</td>
    <td><input type="text" maxlength="20" name="time_remain"  onKeyPress="return numbersOnly(this, event);" id="time_remain" class="inputbox" size="30" value="<?php echo $this->time_remain?>"/> days</td>
    <td><input type="radio" name="so_status" value="done" <?php echo ($this->so_status=='done')?"checked='checked'":"";?>>Done</td>
    <td><input type="radio" name="wo_op_status" value="label_printed" <?php echo ($this->wo_op_status=='label_printed')?"checked='checked'":"";?>>Label Printed</td>
  </tr>
  <tr>
    <td><input type="radio" name="search_swo_type" value="searchwo" <?php echo ($this->search_swo_type=='searchwo')?"checked='checked'":"";?>>WO#:</td>
    <td><input type="text" maxlength="20" name="wo_cuscode"  id="wo_cuscode" class="inputbox" size="30" value="<?php echo $this->search_wo?>"/></td>
    <td>Time From</td>
  <td>
     <?php echo JHTML::_('calendar',$this->time_from,'time_from', 'time_from', '%m/%d/%Y', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	                                                       
      To 
      <?php echo JHTML::_('calendar',$this->time_to, 'time_to', 'time_to', '%m/%d/%Y', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	     
  </td>
     <td><input type="radio" name="so_status" value="onhold"  <?php echo ($this->so_status=='onhold')?"checked='checked'":"";?>>On Hold</td>
     <td><input type="radio" name="wo_op_status" value="wire_cut" <?php echo ($this->wo_op_status=='wire_cut')?"checked='checked'":"";?>>Wire Cut</td>
  </tr>
  <tr>
    <td><input type="radio" name="search_swo_type" value="searchstep" <?php echo ($this->search_swo_type=='searchstep')?"checked='checked'":"";?>>Step:</td>
    <td><input type="text" maxlength="20" name="step"  id="step" class="inputbox" size="30" value=""/></td>
    <td></td>
    <td></td>
    <td><input type="radio" name="so_status" value="inprogress" <?php echo ($this->so_status=='inprogress')?"checked='checked'":"";?> >In Progress</td>
    <td><input type="radio" name="wo_op_status" value="kitted" <?php echo ($this->wo_op_status=='kitted')?"checked='checked'":"";?>>Kitted</td>
  </tr>
  <tr>
          <td>Employee ID#:</td>
    <td>
            <?php echo $this->list_assigners;?>            
    <td></td>
    <td></td>
    <td><input type="radio" name="so_status" value="cancel" <?php echo ($this->so_status=='cancel')?"checked='checked'":"";?>>Cancel</td>
    <td><input type="radio" name="wo_op_status" value="production" <?php echo ($this->wo_op_status=='production')?"checked='checked'":"";?>>Production</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>    
    <td><input type="radio" name="wo_status" value="rma" <?php echo ($this->wo_status=='rma')?"checked='checked'":"";?>>RMA</td>
    <td><input type="radio" name="wo_op_status" value="visual_inspection" <?php echo ($this->wo_op_status=='visual_inspection')?"checked='checked'":"";?>>Visual Inspection</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td><input type="radio" name="wo_op_status" value="final_inspection" <?php echo ($this->wo_op_status=='final_inspection')?"checked='checked'":"";?>>Final Inspection</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
   <td><input type="radio" name="wo_op_status" value="packaging" <?php echo ($this->wo_op_status=='packaging')?"checked='checked'":"";?>>Packing</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td><input type="radio" name="wo_op_status" value="done" <?php echo ($this->wo_op_status=='done')?"checked='checked'":"";?>>Done</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td><strong>STEP & EMP.OPTION</strong></td>
    <td><input type="radio" name="wo_op_status" value="onhold" <?php echo ($this->wo_op_status=='onhold')?"checked='checked'":"";?>>On hold</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td><input type="radio" name="wo_step_status" value="done" <?php //echo ($this->wo_op_status=='onhold')?"checked='checked'":"";?>>Done</td>
    <td><input type="radio" name="wo_op_status" value="cancel" <?php echo ($this->wo_op_status=='cancel')?"checked='checked'":"";?>>Cancel</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
   <td><input type="radio" name="wo_step_status" value="delay" <?php //echo ($this->wo_op_status=='onhold')?"checked='checked'":"";?>>Delay</td>
    <td><input type="radio" name="wo_status" value="rework" <?php echo ($this->wo_status=='rework')?"checked='checked'":"";?>>Rework</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
       <td><input type="radio" name="wo_step_status" value="inprogress" <?php //echo ($this->wo_op_status=='onhold')?"checked='checked'":"";?>>In Progress</td>
        <td ><input type="radio" name="wo_status" value="delay" <?php echo ($this->wo_status=='delay')?"checked='checked'":"";?>>Delay</td>
  </tr>
 
</table>


        <?php

if(count($this->rs_so))
{      
        ?>
       
      <fieldset class="adminform">
		 <legend><?php echo JText::_("SO Result");?></legend>                                            
<?php 
if (count($this->rs_so) > 0) { ?>
                <table class="adminlist" cellspacing="1" width="400">
                        <thead>
                                <tr>
                                        <th width="100"><?php echo JText::_('No'); ?></th>                                               
                                        <th width="100"><?php echo JText::_('SO#'); ?></th>
                                        <th width="100"><?php echo JText::_('Customer'); ?></th>                                                
                                        <th width="100"><?php echo JText::_('TOP ASSYS PN'); ?></th>                                        
                                        <th width="100"><?php echo JText::_('Description'); ?></th>
                                        <th width="100"><?php echo JText::_('Start date'); ?></th>
                                        <th width="100"><?php echo JText::_('Shipping request date'); ?></th>
                                        <th width="100"><?php echo JText::_('Required'); ?></th>
                                        <th width="100"><?php echo JText::_('Time Remain'); ?></th>                                        
                                        <th width="100"><?php echo JText::_('Status'); ?></th>
                                        <th width="100"><?php echo JText::_('RMA'); ?></th>
                                        <th width="100"><?php echo JText::_('LOG'); ?></th>                                        
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
                ?>
                                        <tr>
                                                <td><?php echo $i;?></td>                                            
                                                <td><a href="index.php?option=com_apdmpns&task=so_detail&id=<?php echo $so->pns_so_id; ?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $soNumber; ?></a> </td>
                                                <td><?php echo PNsController::getCcsName($so->customer_id); ?></td>                                                
                                                <td><span class="editlinktip hasTip" title="<?php echo $pnNumber; ?>" >
                                                       <a href="<?php echo $link; ?>" title="<?php echo JText::_('Click to see detail PNs'); ?>"><?php echo $pnNumber; ?></a>
                                                </span></td>   
                                                <td><?php echo $so->pns_description; ?></td>                                                
                                                <td>
                                                 <?php echo JHTML::_('date', $so->so_shipping_date, JText::_('DATE_FORMAT_LC5')); ?>
                                                </td>     
                                                 <td>
                                                <?php echo JHTML::_('date', $so->so_shipping_date, JText::_('DATE_FORMAT_LC5')); ?>
                                                </td> 
                                                <td>
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
                                                <td><?php echo ($so->so_remain_date>=0)?$so->so_remain_date:0;?></td>
                                                <td>
                                                       <?php 
                                                       echo PNsController::getSoStatus($so->so_state); ?>
                                                </td>
                                                <td><?php echo $so->rma; ?></td>                                                
                                                <td>
                                                     <?php echo $so->so_log; ?>
                                                </td></tr>
                                                <?php }
                                        } ?>
                </tbody>
        </table>
      </fieldset>

  <?php
}
if(count($this->rs_wo))
{      
        ?>
       
      <fieldset class="adminform">
		 <legend><?php echo JText::_("WO Result");?></legend>
               
<?php 
if (count($this->rs_wo) > 0) { ?>
                <table class="adminlist" cellspacing="1" width="400">
                        <thead>
                                <tr>
                                        <th width="100"><?php echo JText::_('No'); ?></th>                                               
                                        <th width="100"><?php echo JText::_('WO#'); ?></th>
                                        <th width="100"><?php echo JText::_('PN'); ?></th>                                                                                        
                                        <th width="100"><?php echo JText::_('Description'); ?></th>
                                        <th width="100"><?php echo JText::_('Qty'); ?></th>
                                        <th width="100"><?php echo JText::_('UOM'); ?></th>
                                        <th width="100"><?php echo JText::_('Start date'); ?></th>
                                        <th width="100"><?php echo JText::_('Deadline'); ?></th>
                                        <th width="100"><?php echo JText::_('Time Remain(days)'); ?></th>                                        
                                        <th width="100"><?php echo JText::_('Status'); ?></th>
                                        <th width="100"><?php echo JText::_('Delay'); ?></th>
                                        <th width="100"><?php echo JText::_('Rework'); ?></th>
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
                                                <td><?php echo $i;?></td>                                            
                                                <td><a href="index.php?option=com_apdmpns&task=wo_detail&id=<?php echo $wo->pns_wo_id; ?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $wo->wo_code; ?></a> </td>                                                                                                
                                                <td><span class="editlinktip hasTip" title="<?php echo $pnNumber; ?>" >
                                                       <a href="<?php echo $link; ?>" title="<?php echo JText::_('Click to see detail PNs'); ?>"><?php echo $pnNumber; ?></a>
                                                </span></td>   
                                                <td><?php echo $wo->pns_description; ?></td>                    
                                                <td><?php echo $wo->wo_qty; ?></td>         
                                                <td><?php echo $wo->pns_uom; ?></td>         
                                                <td>
                                                 <?php echo JHTML::_('date', $wo->wo_start_date, JText::_('DATE_FORMAT_LC5')); ?>
                                                </td>     
                                                 <td>
                                                <?php echo JHTML::_('date', $wo->wo_completed_date, JText::_('DATE_FORMAT_LC5')); ?>
                                                </td> 
                                                <td <?php echo $background?>><?php echo $remain_day;?></td>
                                                  <td><?php echo PNsController::getWoStatus($wo->wo_state); ?></td>
                                               <td><?php echo $wo->wo_delay;//PNsController::getDelayTimes($wo->pns_wo_id);?></td>
                                               <td><?php echo (PNsController::getReworkStep($wo->pns_wo_id))?PNsController::getReworkStep($wo->pns_wo_id):0;?></td>
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
	<input type="hidden" name="task" value="searchadvance" />
	<input type="hidden" name="boxchecked" value="1" />	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
