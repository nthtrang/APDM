<?php defined('_JEXEC') or die('Restricted access'); ?>
wo_material
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
                        <li><a id="diary" href="index.php?option=com_apdmpns&task=wo_diary&id=<?php echo $this->wo_row->pns_wo_id;?>"><?php echo JText::_( 'DIARY' ); ?></a></li>
                        <li><a id="diary" class="active" href="#"><?php echo JText::_( 'MATERIAL REQUEST' ); ?></a></li>
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
                                
                                                                         <?php if (count($this->material_list) > 0) {
                                                                ?>				
                                                              
                                                                        <table width="100%"  class="adminlist" cellpadding="1">						
                                                                                <thead>
                                                                                        <th><strong><?php echo JText::_('No.')?> </strong></th>
                                                                                        <th><strong><?php echo JText::_('Time')?> </strong></th>
                                                                                        <th><strong><?php echo JText::_('Request By')?> </strong></th>
                                                                                        <th><strong><?php echo JText::_('Request To')?> </strong></th>
                                                                                        <th><strong><?php echo JText::_('Reason')?> </strong></th>
                                                                                        <th><strong><?php echo JText::_('Status')?> </strong></th>
                                                                                        
                                                                                </thead>
                                                                               
                                                                <?php

                                                                $i = 1;                                                                
                                                                foreach ($this->material_list as $rowf) {                                                                        
                                                                ?>
                                                                <tr>
                                                                        <td><?php echo $i?></td>
                                                                        <td><?php echo JHTML::_('date', $rowf->material_submited, JText::_('DATE_FORMAT_LC5')); ?></td>
                                                                        <td><?php echo GetValueUser($rowf->material_submited_by, "name"); ?></td>
                                                                       <td><?php echo GetValueUser($rowf->material_request_to, "name"); ?></td>
                                                                       <td><?php echo $rowf->material_reason; ?></td>
                                                                       <td><a href="index.php?option=com_apdmpns&task=detail_material&material_id=<?php echo $rowf->material_id;?>&id=<?php echo $rowf->wo_id;?>" title="<?php echo JText::_('Click to see detail Material Request'); ?>" /><?php echo $rowf->material_state; ?></a></td>
                                                                </tr>
                                                                <?php $i++; } ?>

                                                               
                                                                        
                                                                <?php } ?>    
                                                                        </table>
                                                              
                                  </fieldset>
                
        <input type="hidden" name="wo_id" value="<?php echo $this->wo_row->pns_wo_id; ?>" />
        <input type="hidden" name="option" value="com_apdmpns" />     
        <input type="hidden" name="id" value="<?php echo JRequest::getVar('id'); ?>" />     
        <input type="hidden" name="task" value="" />	
        <input type="hidden" name="return" value="so_detail_support_doc"  />
        <input type="hidden" name="boxchecked" value="1" />
                                        <?php echo JHTML::_('form.token'); ?>
</form>
