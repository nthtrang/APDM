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
JToolBarHelper::title("WO: " . $this->wo_row->wo_code, 'cpanel.png');
$role = JAdministrator::RoleOnComponent(12);
if (in_array("E", $role) && $this->wo_row->wo_state!="done" && $this->wo_row->wo_state !="onhold" && $this->wo_row->wo_state!="cancel" ) {        
        //JToolBarHelper::apply('save_log_wo', 'Save');
}
$cparams = JComponentHelper::getParams('com_media');
$editor = &JFactory::getEditor();
$op_arr  = $this->op_arr;  
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
                        <li><a id="bom" href="index.php?option=com_apdmpns&task=wo_log&id=<?php echo $this->wo_row->pns_wo_id;?>"><?php echo JText::_( 'LOG' ); ?></a></li>
                        <li><a id="diary" class="active" href="#"><?php echo JText::_( 'DIARY' ); ?></a></li>
                        <li><a id="material" href="index.php?option=com_apdmpns&task=wo_material&id=<?php echo $this->wo_row->pns_wo_id;?>"><?php echo JText::_( 'MATERIAL REQUEST' ); ?></a></li>
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
        

                <div class="col width-100">
                        <fieldset class="adminform">		
                                <table class="admintable" cellspacing="1" width="100%">
                                        <tr>
                                                <td colspan="3"><strong><?php echo JText::_('TOTAL TIME'); ?>:
                                                        <?php 
                                                        $total_op =  $op_arr['wo_step1']['op_total_time'] + $op_arr['wo_step2']['op_total_time'] + $op_arr['wo_step3']['op_total_time'] + $op_arr['wo_step4']['op_total_time']+ $op_arr['wo_step5']['op_total_time']+$op_arr['wo_step6']['op_total_time']+$op_arr['wo_step7']['op_total_time'];
                                                        $total_f_rework =  $op_arr['wo_step1']['op_rework_f_total_time'] + $op_arr['wo_step2']['op_rework_f_total_time'] + $op_arr['wo_step3']['op_rework_f_total_time'] + $op_arr['wo_step4']['op_rework_f_total_time']+ $op_arr['wo_step5']['op_rework_f_total_time']+$op_arr['wo_step6']['op_rework_f_total_time']+$op_arr['wo_step7']['op_rework_f_total_time'];
                                                        $total_s_rework =  $op_arr['wo_step1']['op_rework_s_total_time'] + $op_arr['wo_step2']['op_rework_s_total_time'] + $op_arr['wo_step3']['op_rework_s_total_time'] + $op_arr['wo_step4']['op_rework_s_total_time']+ $op_arr['wo_step5']['op_rework_s_total_time']+$op_arr['wo_step6']['op_rework_s_total_time']+$op_arr['wo_step7']['op_rework_s_total_time'];
                                                        echo $total_op + $total_f_rework+$total_s_rework;
                                                        ?> min
                                                        </strong></td>                                                
                                        </tr>    
                                        <tr>
                                                <td align="center"><strong>FIRST TIME</strong></td>
                                                <td align="center"><strong>1st REWORK</strong></td>
                                                <td align="center"><strong>2nd REWORK</strong></td>
                                        </tr>
                                         <tr>
                                                <td style="border-right: 1px;border-right-style:solid;border-right-width:1px;border-right-color:black;">
                                                        <table class="admintable" cellspacing="1" width="100%">
                                                                
                                                                <tr>
                                                                        <td>1.</td>
                                                                        <td><strong>DOC. Pre</strong></td>
                                                                        <td><?php echo ($op_arr['wo_step1']['op_assigner']!=0)?GetValueUser($op_arr['wo_step1']['op_assigner'], "name"):"N/A"; ?></td>
                                                                        <td><?php echo $op_arr['wo_step1']['op_total_time']; ?> min</td>
                                                                </tr>
                                                                <tr>
                                                                        <td>2.</td>
                                                                        <td><strong>Label Printed</strong></td>
                                                                        <td><?php echo ($op_arr['wo_step2']['op_assigner']!=0)?GetValueUser($op_arr['wo_step2']['op_assigner'], "name"):"N/A"; ?></td>
                                                                        <td><?php echo $op_arr['wo_step2']['op_total_time']; ?> min</td>
                                                                </tr>
                                                                <tr>
                                                                        <td>3.</td>
                                                                        <td><strong>Wire Cut</strong></td>
                                                                        <td><?php echo ($op_arr['wo_step3']['op_assigner']!=0)?GetValueUser($op_arr['wo_step3']['op_assigner'], "name"):"N/A"; ?></td>
                                                                        <td><?php echo $op_arr['wo_step3']['op_total_time']; ?> min</td>
                                                                </tr>
                                                                <tr>
                                                                        <td>4.</td>
                                                                        <td><strong>Kitted</strong></td>
                                                                        <td><?php echo ($op_arr['wo_step4']['op_assigner']!=0)?GetValueUser($op_arr['wo_step4']['op_assigner'], "name"):"N/A"; ?></td>
                                                                        <td><?php echo $op_arr['wo_step4']['op_total_time']; ?> min</td>
                                                                </tr>
                                                                <tr>
                                                                        <td>5.</td>
                                                                        <td><strong>Production</strong></td>
                                                                        <td><?php echo ($op_arr['wo_step5']['op_assigner']!=0)?GetValueUser($op_arr['wo_step5']['op_assigner'], "name"):"N/A"; ?></td>
                                                                        <td><?php echo $op_arr['wo_step5']['op_total_time']; ?> min</td>
                                                                </tr>
                                                                <tr>
                                                                        <td>6.</td>
                                                                        <td><strong>QC</strong></td>
                                                                        <td><?php echo ($op_arr['wo_step6']['op_assigner']!=0)?GetValueUser($op_arr['wo_step6']['op_assigner'], "name"):"N/A"; ?></td>
                                                                        <td><?php echo $op_arr['wo_step6']['op_total_time']; ?> min</td>
                                                                </tr>
                                                                <tr>
                                                                        <td>7.</td>
                                                                        <td><strong>Packaging</strong></td>
                                                                        <td><?php echo ($op_arr['wo_step7']['op_assigner']!=0)?GetValueUser($op_arr['wo_step7']['op_assigner'], "name"):"N/A"; ?></td>
                                                                        <td><?php echo $op_arr['wo_step7']['op_total_time']; ?> min</td>
                                                                </tr>
                                                                <tr><td colspan="3" align="right"><strong>Total:</strong> <?php echo $total_op?></td></tr>
                                                        </table>
                                                </td>
                                             <td style="border-right: 1px;border-right-style:solid;border-right-width:1px;border-right-color:black;"><table class="admintable" cellspacing="1" width="100%">
                                                                
                                                                <tr>
                                                                        <td>1.</td>
                                                                        <td><strong>DOC. Pre</strong></td>
                                                                        <td><?php echo ($op_arr['wo_step1']['op_assigner']!=0)?GetValueUser($op_arr['wo_step1']['op_assigner'], "name"):"N/A"; ?></td>
                                                                        <td><?php echo $op_arr['wo_step1']['op_rework_f_total_time']; ?> min</td>
                                                                </tr>
                                                                <tr>
                                                                        <td>2.</td>
                                                                        <td><strong>Label Printed</strong></td>
                                                                        <td><?php echo ($op_arr['wo_step2']['op_assigner']!=0)?GetValueUser($op_arr['wo_step2']['op_assigner'], "name"):"N/A"; ?></td>
                                                                        <td><?php echo $op_arr['wo_step2']['op_rework_f_total_time']; ?> min</td>
                                                                </tr>
                                                                <tr>
                                                                        <td>3.</td>
                                                                        <td><strong>Wire Cut</strong></td>
                                                                        <td><?php echo ($op_arr['wo_step3']['op_assigner']!=0)?GetValueUser($op_arr['wo_step3']['op_assigner'], "name"):"N/A"; ?></td>
                                                                        <td><?php echo $op_arr['wo_step3']['op_rework_f_total_time']; ?> min</td>
                                                                </tr>
                                                                <tr>
                                                                        <td>4.</td>
                                                                        <td><strong>Kitted</strong></td>
                                                                        <td><?php echo ($op_arr['wo_step4']['op_assigner']!=0)?GetValueUser($op_arr['wo_step4']['op_assigner'], "name"):"N/A"; ?></td>
                                                                        <td><?php echo $op_arr['wo_step4']['op_rework_f_total_time']; ?> min</td>
                                                                </tr>
                                                                <tr>
                                                                        <td>5.</td>
                                                                        <td><strong>Production</strong></td>
                                                                        <td><?php echo ($op_arr['wo_step5']['op_assigner']!=0)?GetValueUser($op_arr['wo_step5']['op_assigner'], "name"):"N/A"; ?></td>
                                                                        <td><?php echo $op_arr['wo_step5']['op_rework_f_total_time']; ?> min</td>
                                                                </tr>
                                                                <tr>
                                                                        <td>6.</td>
                                                                        <td><strong>QC</strong></td>
                                                                        <td><?php echo ($op_arr['wo_step6']['op_assigner']!=0)?GetValueUser($op_arr['wo_step6']['op_assigner'], "name"):"N/A"; ?></td>
                                                                        <td><?php echo $op_arr['wo_step6']['op_rework_f_total_time']; ?> min</td>
                                                                </tr>
                                                                <tr>
                                                                        <td>7.</td>
                                                                        <td><strong>Packaging</strong></td>
                                                                        <td><?php echo ($op_arr['wo_step7']['op_assigner']!=0)?GetValueUser($op_arr['wo_step7']['op_assigner'], "name"):"N/A"; ?></td>
                                                                        <td><?php echo $op_arr['wo_step7']['op_rework_f_total_time']; ?> min</td>
                                                                </tr>
                                                                <tr><td colspan="3" align="right">Total: <?php echo $total_f_rework?></td></tr>
                                                        </table></td>
                                                <td> <table class="admintable" cellspacing="1" width="100%">
                                                                
                                                                <tr>
                                                                        <td>1.</td>
                                                                        <td><strong>DOC. Pre</strong></td>
                                                                        <td><?php echo ($op_arr['wo_step1']['op_assigner']!=0)?GetValueUser($op_arr['wo_step1']['op_assigner'], "name"):"N/A"; ?></td>
                                                                        <td><?php echo $op_arr['wo_step1']['op_rework_s_total_time']; ?> min</td>
                                                                </tr>
                                                                <tr>
                                                                        <td>2.</td>
                                                                        <td><strong>Label Printed</strong></td>
                                                                        <td><?php echo ($op_arr['wo_step2']['op_assigner']!=0)?GetValueUser($op_arr['wo_step2']['op_assigner'], "name"):"N/A"; ?></td>
                                                                        <td><?php echo $op_arr['wo_step2']['op_rework_s_total_time']; ?> min</td>
                                                                </tr>
                                                                <tr>
                                                                        <td>3.</td>
                                                                        <td><strong>Wire Cut</strong></td>
                                                                        <td><?php echo ($op_arr['wo_step3']['op_assigner']!=0)?GetValueUser($op_arr['wo_step3']['op_assigner'], "name"):"N/A"; ?></td>
                                                                        <td><?php echo $op_arr['wo_step3']['op_rework_s_total_time']; ?> min</td>
                                                                </tr>
                                                                <tr>
                                                                        <td>4.</td>
                                                                        <td><strong>Kitted</strong></td>
                                                                        <td><?php echo ($op_arr['wo_step4']['op_assigner']!=0)?GetValueUser($op_arr['wo_step4']['op_assigner'], "name"):"N/A"; ?></td>
                                                                        <td><?php echo $op_arr['wo_step4']['op_rework_s_total_time']; ?> min</td>
                                                                </tr>
                                                                <tr>
                                                                        <td>5.</td>
                                                                        <td><strong>Production</strong></td>
                                                                        <td><?php echo ($op_arr['wo_step5']['op_assigner']!=0)?GetValueUser($op_arr['wo_step5']['op_assigner'], "name"):"N/A"; ?></td>
                                                                        <td><?php echo $op_arr['wo_step5']['op_rework_s_total_time']; ?> min</td>
                                                                </tr>
                                                                <tr>
                                                                        <td>6.</td>
                                                                        <td><strong>QC</strong></td>
                                                                        <td><?php echo ($op_arr['wo_step6']['op_assigner']!=0)?GetValueUser($op_arr['wo_step6']['op_assigner'], "name"):"N/A"; ?></td>
                                                                        <td><?php echo $op_arr['wo_step6']['op_rework_s_total_time']; ?> min</td>
                                                                </tr>
                                                                <tr>
                                                                        <td>7.</td>
                                                                        <td><strong>Packaging</strong></td>
                                                                        <td><?php echo ($op_arr['wo_step7']['op_assigner']!=0)?GetValueUser($op_arr['wo_step7']['op_assigner'], "name"):"N/A"; ?></td>
                                                                        <td><?php echo $op_arr['wo_step7']['op_rework_s_total_time']; ?> min</td>
                                                                </tr>
                                                                <tr><td colspan="3" align="right"><strong>Total</strong>: <?php echo $total_s_rework?></td></tr>
                                                        </table></td>
                                        </tr>
                                </table>                                                                
                        </fieldset>
                </div>	
     
                        <fieldset class="adminform">
                                <legend>DAIRY</legend>     
                                <?php 
                                if($this->dairy_list){
                                ?>
                                <table class="adminlist" cellpadding="1">                                                                                        
                                        <thead>
                                                <th  align="left"class="title"><?php echo JText::_('Date'); ?></th>
                                                <th  align="left"class="title"><?php echo JText::_('Status'); ?></th>
                                                <th  align="left"class="title"><?php echo JText::_('Action'); ?></th>
                                                <th  align="left"class="title"><?php echo JText::_('By'); ?></th>
                                                <th  align="left" class="title"><?php echo JText::_('Comments'); ?></th>
                                                </tr>
                                                </thead>
                                                <?php 
                                                foreach($this->dairy_list as $row)
                                                {
                                                        ?>
                                                  <tr>
                                                <td><?php echo JHTML::_('date', $row->wo_log_created, JText::_('DATE_FORMAT_LC6')); ?></td>                                                
                                                <td><?php echo PNsController::getWoStep($row->op_code);?></td>
                                                <td><?php echo $row->op_action; ?></td>
                                                <td><?php echo ($row->wo_log_created_by!=0)?GetValueUser($row->wo_log_created_by, "name"):"N/A"; ?></td>
                                                <td><?php echo $row->wo_log_content; ?></td>   
                                                </tr>
                                                <?php 
                                                }
                                                ?>
                                                
                                </table>
                                <?php
                                }
                                ?>
                                  </fieldset>
                
        <input type="hidden" name="wo_id" value="<?php echo $this->wo_row->pns_wo_id; ?>" />
        <input type="hidden" name="option" value="com_apdmpns" />     
        <input type="hidden" name="id" value="<?php echo JRequest::getVar('id'); ?>" />     
        <input type="hidden" name="task" value="" />	
        <input type="hidden" name="return" value="so_detail_support_doc"  />
        <input type="hidden" name="boxchecked" value="1" />
                                        <?php echo JHTML::_('form.token'); ?>
</form>
