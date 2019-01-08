<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
$cid = JRequest::getVar('cid', array(0));
$edit = JRequest::getVar('edit', true);
$me = & JFactory::getUser();
//JToolBarHelper::title("SO Management", 'cpanel.png');
$role = JAdministrator::RoleOnComponent(10);      
if (in_array("W", $role)) {
        //JToolBarHelper::addNew("add_so","New SO");
        JToolBarHelper::customX('add_so', 'new', '', 'New SO', false);
        JToolBarHelper::addNew("add_wo","New WO");
        
}
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
                if (pressbutton == 'btnSubmit') {
                        var d = document.adminForm;
                        if ( document.adminForm.text_search.value==""){
                                alert("Please input keyword");	
                                d.text_search.focus();
                                return false;				
                        }else{
                                document.adminForm.submit();
                                submitform( pressbutton );
				
                        }
                }		
                if (pressbutton == 'add_wo') {
                        submitform( pressbutton );
                        return;
                }
                if (pressbutton == 'add_so') {
                        submitform( pressbutton );
                        return;
                }                
			
        }


</script>
<div class="clr"></div>
<form action="index.php?option=com_apdmpns&task=somanagement"   onsubmit="submitbutton('')"  method="post" name="adminForm" >	
        <input type="hidden" name="query_exprot" value="<?php echo $this->lists['query'];?>" />
<input type="hidden" name="total_record" value="<?php echo $this->lists['total_record'];?>" />        

      <fieldset class="adminform">
		<legend><font style="size:14px"><?php echo JText::_( 'Employee ID#:' ). $me->get('id'); ?> </font></legend>                          
                <div class="col width-100 scroll">
<?php 
if (count($this->so_list) > 0) { ?>
                <table class="adminlist" cellspacing="1" width="400">
                        <thead>
                                <tr>
                                        <th width="100"><?php echo JText::_('No'); ?></th>                                               
                                        <th width="100"><?php echo JText::_('SO#'); ?></th>
                                        <th width="100"><?php echo JText::_('WO#'); ?></th>                                                
                                        <th width="100"><?php echo JText::_('PN'); ?></th>                                        
                                        <th width="100"><?php echo JText::_('Description'); ?></th>
                                        <th width="100"><?php echo JText::_('Qty'); ?></th>
                                        <th width="100"><?php echo JText::_('UOM'); ?></th>
                                        <th width="100"><?php echo JText::_('Task'); ?></th>
                                        <th width="100"><?php echo JText::_('Time Remain'); ?></th>
                                        <th width="100"><?php echo JText::_('Assigner'); ?></th>
                                </tr>
                        </thead>                  
                        <tbody>					
        <?php
        $i = 0;
        foreach ($this->so_list as $so) {
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
                if($so->ccs_coordinator)
                {
                       $soNumber = $so->ccs_coordinator."-".$soNumber;
                }
                $background="";
                $remain_day = $so->wo_remain_date;
                if($remain_day<=0)
                {       
                        $remain_day = 0;
                        $background= "style='background-color:#f00;color:#fff'";
                }
                elseif($so->wo_remain_date<=3)
                {                         
                        $background= "style='background-color:#ff0;color:#000'";
                }
                ?>
                                        <tr>
                                                <td><?php echo $i+$this->pagination->limitstart;?></td>                                            
                                                <td><a href="index.php?option=com_apdmpns&task=so_detail&id=<?php echo $so->pns_so_id; ?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $soNumber; ?></a> </td>
                                                <td><?php echo '<a href="index.php?option=com_apdmpns&task=wo_detail&id='.$so->pns_wo_id.'" title="'.JText::_('Click to see detail WO').'">'.$so->wo_code.'</a> '; ?></td>     
                                                <td><span class="editlinktip hasTip" title="<?php echo $pnNumber; ?>" >
                                                                                        <a href="<?php echo $link; ?>" title="<?php echo JText::_('Click to see detail PNs'); ?>"><?php echo $pnNumber; ?></a>
                                                </span></td>   
                                                <td><?php echo $so->pns_description; ?></td>                                                
                                                <td>
                                                <?php echo $so->wo_qty; ?>
                                                </td>     
                                                 <td>
                                                <?php echo $so->pns_uom; ?>
                                                </td> 
                                                <td>
                                                        <?php echo PNsController::getWoStatus($so->wo_state); ?>
                                                </td>
                                                <td <?php echo $background?>><?php echo $remain_day;?></td>
                                                <td>
                                                     <?php echo GetValueUser($so->wo_assigner, "name"); ?>
                                                </td></tr>
                                                <?php }
                                        } ?>
                </tbody>
        </table></div>
      </fieldset>

      
<?php 
if (count($this->report_list) > 0) { ?>
<fieldset class="adminform">
		<legend><font style="size:14px"><?php echo JText::_( 'Issue Report' ); ?> </font></legend>                          
                <div class="col width-100 scroll">
                <table class="adminlist" cellspacing="1" width="400">
                        <thead>
                                <tr>
                                        <th width="100"><?php echo JText::_('No'); ?></th>                                               
                                        <th width="100"><?php echo JText::_('SO#'); ?></th>
                                        <th width="100"><?php echo JText::_('WO#'); ?></th>                                                
                                        <th width="100"><?php echo JText::_('Step'); ?></th>                                        
                                        <th width="100"><?php echo JText::_('Employee ID'); ?></th>
                                        <th width="100"><?php echo JText::_('Delay times of Step'); ?></th>
                                        <th width="100"><?php echo JText::_('Delay time of WO'); ?></th>
                                        <th width="100"><?php echo JText::_('Rework Times'); ?></th>
                                        <th width="100"><?php echo JText::_('Reason of Delay Step'); ?></th>                                        
                                </tr>
                        </thead>                  
                        <tbody>					
        <?php
        $i = 0;
        foreach ($this->report_list as $so) {
                $i++;              
                $soNumber = $so->so_cuscode;
                if($so->ccs_coordinator)
                {
                       $soNumber = $so->ccs_coordinator."-".$soNumber;
                }
                ?>
                                        <tr>
                                                <td><?php echo $i?></td>                                            
                                                <td><a href="index.php?option=com_apdmpns&task=so_detail&id=<?php echo $so->pns_so_id; ?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $soNumber; ?></a> </td>
                                                <td><?php echo '<a href="index.php?option=com_apdmpns&task=wo_detail&id='.$so->pns_wo_id.'" title="'.JText::_('Click to see detail WO').'">'.$so->wo_code.'</a> '; ?></td>     
                                                <td><?php echo PNsController::getWoStep($so->op_code); ?></td>   
                                                <td><?php echo $so->op_assigner; ?></td>                                                                                                
                                                 <td><?php echo $so->step_delay_date; ?></td> 
                                                <td><?php echo $so->step_delay_date; ?></td>
                                                <td><?php echo PNsController::getReworkStep($so->pns_wo_id,$so->op_code);  ?></td>                                                
                                                <td>
                                                     <?php 
                                                      $comment = PNsController::getWoStepLog($so->pns_op_id, 0);
                                                      if ($comment) {
                                                                        $str = "";
                                                                        foreach ($comment as $r) {
                                                                                $str .= "- " . $r->op_log_comment . " (" . JHTML::_('date', $r->op_log_updated, JText::_('DATE_FORMAT_LC5')) . ")<br>";
                                                                        }
                                                                        echo $str;
                                                                }
                                                     ?>
                                                </td></tr>
                                                <?php }
                                                ?>
                                                 </tbody>
                                        </table></div>
                                      </fieldset>
                                                <?php
                                        } ?>
               
                <div style="display:none"><?php
                                        echo $editor->display('text', $row->text, '10%', '10', '10', '3');
                                        ?></div>
        <input name="nvdid" value="<?php echo $this->lists['count_vd']; ?>" type="hidden" />
        <input name="nspid" value="<?php echo $this->lists['count_sp']; ?>" type="hidden" />
        <input name="nmfid" value="<?php echo $this->lists['count_mf']; ?>" type="hidden" />
        <input type="hidden" name="pns_id" value="<?php echo $this->row->pns_id; ?>" />
        <input type="hidden" name="cid[]" value="<?php echo $this->row->pns_id; ?>" />	
        <input type="hidden" name="option" value="com_apdmpns" />
        <input type="hidden" name="task" value="somanagement" />
        <input type="hidden" name="redirect" value="mep" />
        <input type="hidden" name="return" value="<?php echo $this->cd; ?>"  />
<?php echo JHTML::_('form.token'); ?>
</form>
