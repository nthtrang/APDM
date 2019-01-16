<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php
//
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
$cid = JRequest::getVar('cid', array(0));
$edit = JRequest::getVar('edit', true);
$me = & JFactory::getUser();
JToolBarHelper::title("WO#: " . $this->wo_row->wo_code, 'cpanel.png');
$role = JAdministrator::RoleOnComponent(10);
if (in_array("W", $role) && $this->wo_row->wo_state!="done" && $this->wo_row->wo_state !="onhold" && $this->wo_row->wo_state!="cancel" ) {        
        JToolBarHelper::apply('save_log_wo', 'Save');
}
$cparams = JComponentHelper::getParams('com_media');
$editor = &JFactory::getEditor();
// clean item data
JFilterOutput::objectHTMLSafe($user, ENT_QUOTES, '');
?>
<script language="javascript" type="text/javascript">
        function submitbutton(pressbutton) {  
                var form = document.adminForm;      
                
                if (pressbutton == 'save_log_wo') {
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
                        <li><a id="detail" href="index.php?option=com_apdmpns&task=wo_detail&id=<?php echo $this->wo_row->pns_wo_id; ?>" ><?php echo JText::_('DETAIL'); ?></a></li>
                        <li><a id="bom" class="active"><?php echo JText::_('LOG'); ?></a></li>                        
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

<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data" >      
        <fieldset class="adminform">

                <div class="col width-100">
                        <fieldset class="adminform">		
                                <table class="admintable" cellspacing="1" width="100%">
                                        <tr>
                                                <td><strong>LOG:</strong></td>
                                        </tr>
                                        <tr>
                                                <td>
                                                        <textarea maxlength='40' name="wo_log" rows="10" cols="100"><?php echo $this->wo_row->wo_log; ?></textarea>
                                                </td>
                                        </tr>
                                </table>
                                <pre></pre>
                                <strong>Delay of Steps</strong>
                                <table class="adminlist" cellspacing="1" width="100%">
                                        <tr>
                                                <th>Step</th>
                                                <th>Employee ID</th>
                                                <th>Times</th>
                                                <th>Reason</th>
                                        </tr>
                                        <?php
                                        foreach ($this->wo_delay as $rowde) {
                                                ?>
                                                <tr>				
                                                        <td><?php echo PNsController::getWoStep($rowde->op_code); ?></td>				
                                                        <td><?php echo $rowde->op_assigner; ?></td>
                                                        <td><?php echo $rowde->step_delay_date; ?></td>
                                                        <td><?php
                                        //if($me->get('id');                
                                        $op_arr = $this->op_arr;
                                        if ($op_arr[$rowde->op_code]['op_assigner'] == $me->get('id')) {
                                                        ?>
                                                                        <input type="text" size="30" value="" name="op_log_comment[<?php echo $rowde->pns_op_id; ?>]" id="op_log_comment" />
                                                                        </br>
                                                                        <?php
                                                                }
                                                                $comment = PNsController::getWoStepLog($rowde->pns_op_id, 0);
                                                                if ($comment) {
                                                                        $str = "";
                                                                        foreach ($comment as $r) {
                                                                                $str .= "- " . $r->op_log_comment . " (" . JHTML::_('date', $r->op_log_updated, JText::_('DATE_FORMAT_LC3')) . ")<br>";
                                                                        }
                                                                        echo $str;
                                                                }
                                                                ?></td>                
                                                </tr>
                                                                <?php
                                                        }
                                                        ?>
                                </table>
                                <pre></pre>

                                <strong>Rework</strong>
                                <table class="adminlist" cellspacing="1" width="100%">
                                        <tr>
                                                <th>Step</th>
                                                <th>Time</th>
                                                <th>QC by</th>                                       
                                                <th>Reason</th>
                                        </tr>
                                        <?php
                                        $i = 0;
                                        foreach ($this->wo_rework as $rowre) {
                                                $i++;
                                                ?>
                                                <tr>				
                                                        <td><?php echo PNsController::getWoStep($rowre->op_code); ?></td>
                                                        <td><?php echo $i;//$rowre->fail_time; ?></td>				
                                                        <td>
                                                        <?php echo  ($rowre->op_assigner) ? GetValueUser($rowre->op_assigner, "name") : ''; ?>
                                                        </td>               
                                                        <td><?php                                                    
                                                $op_arr = $this->op_arr;
                                                if ($op_arr[$rowre->op_code]['op_assigner'] == $me->get('id')) {
                                                ?>
                                                        <input type="hidden" name="fail_time[<?php echo $rowre->pns_op_id; ?>]" value="<?php echo $rowre->fail_time;?>" />
                                                        <input type="text" size="30" value="" name="op_logrework_comment[<?php echo $rowre->pns_op_id; ?>]" id="op_logrework_comment" />
                                                        </br>
                                                        <?php
                                                }
                                                $comment = PNsController::getWoStepLog($rowre->pns_op_id, $rowre->fail_time);
                                                if ($comment) {
                                                        $str = "";
                                                        foreach ($comment as $r) {
                                                                $str .= "- " . $r->op_log_comment . " (" . JHTML::_('date', $r->op_log_updated, JText::_('DATE_FORMAT_LC3')) . ")<br>";
                                                        }
                                                        echo $str;
                                                }
                                                                ?></td>                
                                                </tr>
                                                                <?php
                                                        }
                                                        ?>
                                </table>
                        </fieldset>
                </div>	
        </fieldset>
        <input type="hidden" name="wo_id" value="<?php echo $this->wo_row->pns_wo_id; ?>" />
        <input type="hidden" name="option" value="com_apdmpns" />     
        <input type="hidden" name="id" value="<?php echo JRequest::getVar('id'); ?>" />     
        <input type="hidden" name="task" value="" />	
        <input type="hidden" name="return" value="so_detail_support_doc"  />
        <input type="hidden" name="boxchecked" value="1" />
                                        <?php echo JHTML::_('form.token'); ?>
</form>
