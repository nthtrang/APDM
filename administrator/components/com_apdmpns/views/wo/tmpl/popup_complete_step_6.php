<?php defined('_JEXEC') or die('Restricted access'); ?>
complete step6
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
$editor = &JFactory::getEditor();
?>
<script language="javascript">
        function submitbutton(pressbutton) {
                var form = window.document.adminForm;
		var wo_id = form.wo_id.value;
       if (form.passwd.value==""){
		alert('Please type your password.');
                form.passwd.focus();
		return false;
	}
        else {
			submitform( pressbutton);
                        closereload(wo_id);
		}
	}
        function closereload(wo_id)
        {
                
                window.parent.document.getElementById('sbox-window').close();	
                window.parent.location = "index.php?option=com_apdmpns&task=wo_detail&id="+wo_id;
        }
function onCompleteWo(){
        var form = window.document.adminForm;
        var wo_id = form.wo_id.value;
       if (form.passwd.value==""){
		alert('Please type your password.');
                form.passwd.focus();
		return false;
	}       
        else{	
		var url = 'index.php?option=com_apdmpns&task=checkloginSuccess&id='+wo_id;                
		var MyAjax = new Ajax(url, {
			method:'post',
			data:  $('adminForm').toQueryString(),
			onComplete:function(result){                                
                                if(result==0)
                                {
                                        document.getElementById('notice').innerHTML = "Incorrect Password";				                
                                }
				else
                                {   
                                        submitform("saveCompeteStepWo");
                                       // window.parent.document.getElementById('sbox-window').close();	
                                       // window.parent.location = "index.php?option=com_apdmpns&task=wo_detail&id="+wo_id;
                                }
				
				

			}
		}).request();
	}
	
}
function cancelUpdate()
{
        window.parent.document.getElementById('sbox-window').close();	
}

</script>
<form action="index.php?option=com_apdmpns&task=saveCompeteStepWo&tmpl=component&id=<?php echo $wo_id?>" method="post" id="adminForm" name="adminForm" enctype="multipart/form-data" >      
        <fieldset class="adminform">

                <div class="col width-100">
                        <fieldset class="adminform">	
                                <div name="notice" style="color:#D30000" id ="notice"></div>
                                <table class="admintable" cellspacing="1" width="100%">
                                        
                                         <tr>
                                                <td><strong>Step:</strong><?php echo PNsController::getWoStep($step);?></td>
                                                 <td><strong>Assignee:</strong>
                                                 <?php echo ($assignee!=0)?GetValueUser($assignee, "name"):"N/A"; ?>
                                                 </td>
                                                 <td><strong>Target Date:</strong>
                                                <?php echo ($op_arr[$step]['op_target_date']!='0000-00-00 00:00:00')?JHTML::_('date', $op_arr[$step]['op_target_date'], JText::_('DATE_FORMAT_LC5')):""; ?>
                                                 </td>
                                                
                                        </tr>
                                        <tr>
                                                <td>CHECKLIST</td>
                                                <td colspan="2">PASS&nbsp;&nbsp;&nbsp;FAIL</td>
                                        </tr>
                                       <tr>
                                                <td>Document(BOM,Drawing,Pro. Traveler)</td>
                                                <td colspan="2"><input type="radio"  name="op_final_value1" value="1">
                                                  &nbsp;&nbsp;&nbsp;<input type="radio"  name="op_final_value1" value="0"></td>
                                        </tr>
                                        <tr>
                                                <td>Visual Inspection</td>
                                                <td colspan="2"><input type="radio"  name="op_final_value2" value="1">
                                                        &nbsp;&nbsp;&nbsp;<input type="radio"  name="op_final_value2" value="0"></td>
                                        </tr>
                                         <tr>
                                                <td>Dimention</td>
                                                <td colspan="2"><input type="radio"  name="op_final_value3" value="1">
                                                        &nbsp;&nbsp;&nbsp;<input type="radio"  name="op_final_value3" value="0"></td>
                                        </tr>
                                         <tr>
                                                <td>Label</td>
                                                <td colspan="2"><input type="radio"  name="op_final_value4" value="1">
                                                        &nbsp;&nbsp;&nbsp;<input type="radio"  name="op_final_value4" value="0"></td>
                                        </tr>
                                         <tr>
                                                <td>Wiring</td>
                                                <td colspan="2"><input type="radio"  name="op_final_value5" value="1">
                                                        &nbsp;&nbsp;&nbsp;<input type="radio"  name="op_final_value5" value="0"></td>
                                        </tr>
                                         <tr>
                                                <td>Connection</td>
                                                <td colspan="2"><input type="radio"  name="op_final_value6" value="1">
                                                        &nbsp;&nbsp;&nbsp;<input type="radio"  name="op_final_value6" value="0"></td>
                                        </tr>
                                         <tr>
                                                <td>Hipot Test</td>
                                                <td colspan="2"><input type="radio"  name="op_final_value7" value="1">
                                                &nbsp;&nbsp;&nbsp;<input type="radio"  name="op_final_value7" value="0"></td>
                                        </tr>
                                         <tr>
                                                <td>Other</td>
                                                <td colspan="2"><input type="radio"  name="op_final_value8" value="1">
                                                        &nbsp;&nbsp;&nbsp;<input type="radio"  name="op_final_value8" value="0"></td>
                                        </tr>
                                        <tr>
                                                <td colspan="3"><strong>Reason:</strong></td>
                                                
                                        </tr>
                                        <tr>
                                                <td colspan="3">                                                        
                                                        <?php                                     
                                                //$editor =& JFactory::getEditor();                                                
                                                     echo $editor->display('op_comment', "", '5%', '2', '5', '1',false);
                                        ?>
                                                </td>
                                               
                                        </tr>
                                        
			   
                 <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'User Name' ); ?>
						</label>
					</td>
					<td colspan="2">
						<input name="username" type="text" readonly="readonly" id="modlgn_username" value="<?php echo ($assignee!=0)?GetValueUser($assignee, "username"):$me->get('username')?>" type="text" class="inputbox" size="15" />
					</td>
				</tr>
                 <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Password' ); ?>
						</label>
					</td>
					<td colspan="2">					
                                                <input name="passwd" id="modlgn_passwd" type="password" class="inputbox" size="15" />                                               
					</td>
				</tr>          
                                    <tr>
			
			<td <td colspan="3" align="center">
                                <input type="button" name="btinsersave" value="Save"  onclick="onCompleteWo();"/>
                                <input type="button" name="btinsercancel" value="Cancel"  onclick="cancelUpdate();"/>                        
                        </td>	
		</tr>	
                                </table>

                                
                        </fieldset>
                </div>	
        </fieldset>
        <input type="hidden" name="wo_id" value="<?php echo $wo_id; ?>" />
        <input type="hidden" name="so_id" value="<?php echo $so_id; ?>" />
        <input type="hidden" name="wo_step" value="<?php echo $step; ?>" />
        <input type="hidden" name="wo_assigner" value="<?php echo $assignee; ?>" />
        <input type="hidden" name="option" value="com_apdmpns" />             
        <input type="hidden" name="task" value="saveCompeteStepWo" />	
        <input type="hidden" name="return" value="wo_detail"  />
        <input type="hidden" name="boxchecked" value="1" />
    <?php echo JHTML::_( 'form.token' ); ?>
</form>
