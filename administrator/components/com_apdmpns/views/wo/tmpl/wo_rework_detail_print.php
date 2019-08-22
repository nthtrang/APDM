<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php
$cid = JRequest::getVar('cid', array(0));
$edit = JRequest::getVar('edit', true);
$me = & JFactory::getUser();
// clean item data
JFilterOutput::objectHTMLSafe($user, ENT_QUOTES, '');
$step = JRequest::getVar('step');
$wo_id = JRequest::getVar('id');
$so_id = JRequest::getVar('so_id');
$op_arr  = $this->op_arr;
$assignee = $op_arr[$step]['op_assigner'];
$pns_op_id = $op_arr[$step]['pns_op_id'];
?>
<script language="javascript">
 window.print();
</script>
<form action="index.php?option=com_apdmpns&task=saveReworkStepWo&tmpl=component&id=<?php echo $wo_id?>" method="post" id="adminForm" name="adminForm" enctype="multipart/form-data" >      
        

                <div class="col width-100">
                        <fieldset class="adminform">	
                                <div name="notice" style="color:#D30000" id ="notice"></div>
                                <table class="admintable" cellspacing="1" width="100%">
                                        <tr>
                                                <td colspan="4" align="center"><strong style="font-size:18px;border-color:inherit;" >REWORK</strong></td>
                                                
                                        </tr>
                                          <tr>
                                                <td colspan="4" align="center"><strong><?php
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
                                        ?></strong></td>
                                                
                                        </tr>
                                        <tr>
                                                <td class="key"><strong>Rework from:</strong></td><td>                                                
                                                        <?php echo PNsController::getWoStep($this->rework_detail->rework_from);?>
                                                </td>                                                
                                                <td class="key"><strong>QC By:</strong></td><td>   
                                                <?php echo ($this->rework_detail->rework_created!=0)?GetValueUser($this->rework_detail->rework_created, "name"):"N/A"; ?>                                               
                                                </td>
                                        </tr>
                                         <tr>
                                                <td class="key"><strong>Failure:</strong>  </td><td>                                                 
                                                        <?php 
                                                        echo $this->rework_detail->rework_failure;
                                                        ?>
                                                        
                                                </td>
                                               
                                                <td class="key"><strong>Rework Times:</strong></td><td>   
                                                <?php if($this->rework_detail->rework_times=='1'){
                                                                                        echo "1st";
                                                                        }
                                                                        elseif($this->rework_detail->rework_times=='2')
                                                                        {
                                                                                echo "2nd";
                                                                        }
                                                                                ?>                                                         
                                                </td>
                                        </tr>
                                         <tr>
                                                <td></td>
                                                <td></td>
                                                <td class="key"><strong>Rework Qty:</strong></td><td>   
                                                <?php 
                                                echo $this->rework_detail->rework_qty;
                                                ?>
                                                </td>
                                        </tr>
                                         
                                       
                                        <tr>
                                                <td colspan="4"><strong>Comments:</strong></td>
                                                
                                        </tr>
                                        <tr>
                                                <td colspan="4">
<!--                                                        <textarea name="op_comment" rows="10" cols="70"><?php echo $op_arr[$step]['op_comment']?></textarea>-->
                                                            <?php   
                                                            echo $this->rework_detail->rework_comments;                                               
                                        ?>
                                                </td>
                                         
		</tr>	
                                </table>

                                
                        </fieldset>
                </div>	
        
        <input type="hidden" name="wo_id" value="<?php echo $wo_id; ?>" />
        <input type="hidden" name="so_id" value="<?php echo $so_id; ?>" />
        <input type="hidden" name="wo_step" value="<?php echo $step; ?>" />
        <input type="hidden" name="wo_assigner" value="<?php echo $assignee; ?>" />
        <input type="hidden" name="pns_op_id" value="<?php echo $pns_op_id; ?>" />        
        <input type="hidden" name="option" value="com_apdmpns" />             
        <input type="hidden" name="task" value="" />	
        <input type="hidden" name="return" value="wo_detail"  />
        <input type="hidden" name="boxchecked" value="1" />
                                        <?php echo JHTML::_('form.token'); ?>
</form>
