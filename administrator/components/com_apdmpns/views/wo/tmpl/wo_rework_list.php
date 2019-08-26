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
                        <li><a id="detail" href="index.php?option=com_apdmpns&task=wo_detail&id=<?php echo $this->wo_row->pns_wo_id; ?>&time=<?php echo time()?>" ><?php echo JText::_('DETAIL'); ?></a></li>
                        <li><a id="bom" href="index.php?option=com_apdmpns&task=wo_log&id=<?php echo $this->wo_row->pns_wo_id;?>&time=<?php echo time()?>"><?php echo JText::_( 'LOG' ); ?></a></li>
                        <li><a id="diary" href="index.php?option=com_apdmpns&task=wo_diary&id=<?php echo $this->wo_row->pns_wo_id;?>&time=<?php echo time()?>"><?php echo JText::_( 'DIARY' ); ?></a></li>
                        <li><a id="material" href="index.php?option=com_apdmpns&task=wo_material&id=<?php echo $this->wo_row->pns_wo_id;?>&time=<?php echo time()?>"><?php echo JText::_( 'MATERIAL REQUEST' ); ?></a></li>
                        <li><a id="rework_log"  class="active"><?php echo JText::_( 'REWORK' ); ?></a></li>
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
                                                                                        <th><strong><?php echo JText::_('Rework')?> </strong></th>
                                                                                        <th><strong><?php echo JText::_('Created Time')?> </strong></th>
                                                                                        <th><strong><?php echo JText::_('QC By')?> </strong></th>
                                                                                        <th><strong><?php echo JText::_('Rework Qty')?> </strong></th>
                                                                                        <th><strong><?php echo JText::_('Rework From')?> </strong></th>
                                                                                        <th><strong><?php echo JText::_('Failure')?> </strong></th>
                                                                                        <th><strong><?php echo JText::_('Comments')?> </strong></th>
                                                                                        <th colspan =2><strong><?php echo JText::_('Attached')?> </strong></th>
                                                                                        
                                                                                </thead>
                                                                               
                                                                <?php

                                                                $i = 1;                                                                
                                                                foreach ($this->rework_log_list as $rowf) {                                                                        
                                                                ?>
                                                                <tr>
                                                                        <td><?php echo $i?></td>
                                                                        <td><?php if($rowf->rework_times=='1'){
                                                                                        echo "1st";
                                                                        }
                                                                        elseif($rowf->rework_times=='2')
                                                                        {
                                                                                echo "2nd";
                                                                        }
                                                                                ?></td>
                                                                        <td><?php echo JHTML::_('date', $rowf->rework_created, JText::_('DATE_FORMAT_LC6')); ?></td>
                                                                        <td><?php echo GetValueUser($rowf->rework_created_by, "name"); ?></td>
                                                                       <td><?php echo $rowf->rework_qty; ?></td>
                                                                       <td><?php echo PNsController::getWoStep($rowf->rework_from); ?></td>
                                                                       <td><?php echo $rowf->rework_failure; ?></td>
                                                                       <td><?php echo $rowf->rework_comments; ?></td>                                                                                                                                                                                                                                                                                                
                                                                       <td><a href="index.php?option=com_apdmpns&task=download_file_rework&id=<?php echo $rowf->wo_id?>&file=<?php echo $rowf->rework_attached_file?>" title="Click here to download file"><img src="images/download_f2.png" width="20" height="20" /></a>&nbsp;&nbsp;
                                                                       </td>
                                                                       <td><a target="_blank" href="index.php?option=com_apdmpns&task=print_rework&tmpl=component&id=<?php echo $rowf->wo_id?>&rework_id=<?php echo $rowf->rework_id?>" title="Click here to print">Print Detail</a>&nbsp;&nbsp;
                                                                       </td>
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
