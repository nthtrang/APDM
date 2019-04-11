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
                                                <td><strong><?php echo JText::_('LOG'); ?>:</strong></td>
                                                <td><strong><?php echo JText::_('Upload'); ?>:</strong></td>
                                        </tr>
                                        <tr>
                                                <td width="60%">
<!--                                                        <textarea name="wo_log" rows="10" cols="70"><?php echo $this->wo_row->wo_log; ?></textarea>-->
                                                        <?php                                     
                                                                $editor =& JFactory::getEditor();                                                
                                                     echo $editor->display('wo_log', $this->wo_row->wo_log, '5%', '5', '10', '1',false);
                                                        ?>
                                                </td>
                                                <td>
                                                        <table>
                                                                <tr>
                                                                        <td>Zip:</td>
                                                                        <td><input type="file" name="wo_log_zip" /> </td>
                                                                </tr>
                                                                 <tr>
                                                                        <td>PDF:</td>
                                                                        <td><input type="file" name="wo_log_pdf" />  </td>
                                                                </tr>
                                                                 <tr>
                                                                        <td>Image:</td>
                                                                        <td><input type="file" name="wo_log_zip" /> </td>
                                                                </tr>
                                                        </table>
                                                      
                                                        <table>
                                                                         <?php if (count($this->list_file_log) > 0) {
                                                                ?>				
                                                                <tr>
                                                                        <td colspan="2" >
                                                                        <table width="100%"  class="adminlist" cellpadding="1">						
                                                                                <thead>
                                                                                        <th colspan="4"><?php echo JText::_('List File')?></th>
                                                                                </thead>
                                                                                <tr>
                                                                                        <td width="5%"><strong><?php echo JText::_('No.')?></strong></td>
                                                                                        <td width="45%"><strong><?php echo JText::_('Name')?> </strong></td>
                                                                                        <td width="30%"><strong><?php echo JText::_('Size (KB)')?> </strong></td>
                                                                                        <td width="20%"><strong><?php echo JText::_('Download')?>  <?php echo JText::_('Remove')?></strong></td>
                                                                                </tr>
                                                                <?php

                                                                $i = 1;
                                                                $folder_wo = $this->wo_row->pns_wo_id;                           
                                                                foreach ($this->list_file_log as $rowf) {
                                                                        $filesize = PNsController::readfilesizeWoLog($this->wo_row->pns_wo_id,$rowf->file_name);                                        				
                                                                ?>
                                                                <tr>
                                                                        <td><?php echo $i?></td>
                                                                        <td><?php echo $rowf->file_name?></td>
                                                                        <td><?php echo number_format($filesize, 0, '.', ' '); ?></td>
                                                                        <td><a href="index.php?option=com_apdmpns&task=download_file_wo_log&id=<?php echo $rowf->id?>" title="Click here to download file"><img src="images/download_f2.png" width="20" height="20" /></a>&nbsp;&nbsp;
                                                                                 <?php                                                                               
																			   if ($this->wo_row->wo_state!="done" && $this->wo_row->wo_state !="onhold" && $this->wo_row->wo_state!="cancel" ){
                                                                                ?>
                                                                        qq<a href="index.php?option=com_apdmpns&task=remove_file_wo_log&woid=<?php echo $this->wo_row->pns_wo_id;?>&id=<?php echo $rowf->id?>&remove=<?php echo $i.time();?>" title="Click to remove" onclick="if ( confirm('Are you sure to delete it ? ') ) { return true;} else {return false;} "><img src="images/cancel_f2.png" width="15" height="15" /></a>
                                                                         <?php
                                                                               }
                                                                                ?>
                                                                        </td>
                                                                </tr>
                                                                <?php $i++; } ?>

                                                                <tr>

                                                                        <td colspan="4" align="center">
                                                                                <a href="index.php?option=com_apdmpns&task=download_all_cads_so&tmpl=component&so_id=<?php echo $this->so_row->pns_so_id;?>" title="Download All Files">
                                                                                <input type="button" name="addVendor" value="<?php echo JText::_('Download All Files')?>"/>
                                                                                </a>&nbsp;&nbsp;

                                <!--					<input type="button" value="<?php echo JText::_('Remove All Files')?>" onclick="if ( confirm ('Are you sure to delete it ?')) { window.location.href='index.php?option=com_apdmpns&task=remove_all_cad&pns_id=<?php echo $this->row->pns_id?>' }else{ return false;}" /></td>					-->
                                                                </tr>

                                                                        </table>
                                                                        </td>
                                                                </tr>
                                                                <?php } ?>                      
                                                                </table>        
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
                                                        <td><?php echo $rowde->op_assigner . "-". GetValueUser($rowde->op_assigner, "name"); ?></td>
                                                        <td><?php echo $rowde->op_delay; ?></td>
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
