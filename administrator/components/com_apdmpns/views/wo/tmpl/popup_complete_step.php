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
function onCompleteWo(){
        var form = document.adminForm;
        var wo_id = form.wo_id.value;
        document.getElementById('task').value = "saveCompeteStepWo";
       if (form.passwd.value==""){
		alert('Please type your password.');
                form.passwd.focus();
		return false;
	}
        else if (form.op_comment.value==""){
		alert('Please type your comment.');
                form.op_comment.focus();
		return false;
	}
        else{	
		var url = 'index.php?option=com_apdmpns&task=saveCompeteStepWo&id='+wo_id;                
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
                                        window.parent.document.getElementById('sbox-window').close();	
                                        window.parent.location = "index.php?option=com_apdmpns&task=wo_detail&id="+wo_id;
                                }
				
				

			}
		}).request();
	}
	
}
function cancelUpdate()
{
        window.parent.document.getElementById('sbox-window').close();	
}
function saveCommentWoStep(){         
         var form = document.adminForm;
        var wo_id = form.wo_id.value;
        var so_id = form.so_id.value;
        var wo_step = form.wo_step.value;
        var op_comment = form.op_comment.value;
       /* var url = 'index.php?option=com_apdmpns&task=saveCommentStepWo&time=<?php echo time();?>&wo_id='+wo_id;                
        url = url + '&wo_step='+wo_step+'&op_comment='+op_comment;
        var MyAjax = new Ajax(url, {
                        method:'get',
                        onComplete:function(result){
                                if(result==0)
                                {
                                 document.getElementById('notice').innerHTML = "Incorrect Password";				                
                                }
                                else{
                                 document.getElementById('notice').innerHTML = "Update Comment Successfullwwww";                                      
                                }
                        }
                }).request();*/
                document.getElementById('task').value = "checkloginSuccess";
                var url = 'index.php?option=com_apdmpns&task=checkloginSuccess&id='+wo_id;                
		var MyAjax = new Ajax(url, {
			method:'post',
			data:  $('adminForm').toQueryString(),
			onComplete:function(result){                                
                                if(result==0)
                                {
                                         document.getElementById('user_id').value = result;
                                        document.getElementById('notice').innerHTML = "Incorrect Password";				                
                                }
				else
                                {
                                            document.getElementById('user_id').value = result;
                                            document.getElementById('task').value = "saveCommentStepWo";
                                        submitform("saveCommentStepWo");                                        
                                       // window.parent.document.getElementById('sbox-window').close();	
                                     //......   window.location = "index.php?option=com_apdmpns&task=save_complete_step&step="+wo_step+"&tmpl=component&id="+wo_id+"&so_id="+so_id;
                                        //document.getElementById('notice').innerHTML =  "Update Comment Successfull";   			                
                                }
			}
		}).request();
                
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
                                                <td colspan="3"><strong>Reason:</strong></td>
                                                
                                        </tr>
                                        <tr>
                                                <td colspan="3">
                                                        <textarea maxlength="100" name="op_comment" rows="10" cols="70"><?php echo $op_arr[$step]['op_comment']?></textarea>
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
                                <input type="button" name="btinsersavecomment" value="Comment"  onclick="saveCommentWoStep();"/>                        
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
        <input type="hidden" name="pns_op_id" value="<?php echo $pns_op_id; ?>" />        
        <input type="hidden" name="user_id" id="user_id" value="<?php echo $me->get('id'); ?>" />        
        <input type="hidden" name="wo_assigner" value="<?php echo $assignee; ?>" />
        <input type="hidden" name="option" value="com_apdmpns" />             
        <input type="text" name="task" id="task" value="" />
        <input type="hidden" name="return" value="wo_detail"  />
        <input type="hidden" name="boxchecked" value="1" />
                                        <?php echo JHTML::_('form.token'); ?>
</form>
