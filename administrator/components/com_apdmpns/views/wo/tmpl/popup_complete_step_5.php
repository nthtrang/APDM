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
?>
<script language="javascript">
function onCompleteWo(){
        var form = document.adminForm;
        var wo_id = form.wo_id.value;
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

function numbersOnlyEspecialFloat(myfield, e, dec){

    var key;
    var keychar;
    if (window.event)
        key = window.event.keyCode;
    else if (e)
        key = e.which;
    else
        return true;
    keychar = String.fromCharCode(key);
    // control keys

    if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27)|| (key==46) ) return true;
    // numbers
    else if ((("0123456789").indexOf(keychar) > -1))
        return true;
    // decimal point jump
    else if (dec && (keychar == "."))
    {
        myfield.form.elements[dec].focus();
        return false;
    }
    else
        return false;
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
                                    <?php
                                    $a_row = $this->wo_assem_rows[0];
                                    ?>
                                    <tr>
                                        <td><strong>CONT#:</strong></td><td colspan="2">
                                            <input type="text" size="20" maxlength='20'  value="<?php echo $a_row->op_assembly_value1;?>" name="op_assembly_value1[<?php echo $a_row->id;?>]" id="op_assembly_value1" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Wire size:</strong></td><td colspan="2">
                                    <input type="text" size="20" maxlength='10' onKeyPress="return numbersOnlyEspecialFloat(this, event);" value="<?php echo $a_row->op_assembly_value2;?>" name="op_assembly_value2[<?php echo $a_row->id;?>]" id="op_assembly_value2" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tool ID:</strong></td><td colspan="2">
                                            <?php

                                            $arrTool = PNsController::getTtofromWo($this->wo_row->pns_wo_id);
                                            if(sizeof($arrTool)) {
                                                for ($iassem = 1; $iassem < 4; $iassem++) {
                                                    echo $arrTool[$iassem];
                                                }
                                            }
                                            else
                                            {
                                                ?>
                                        <input type="text" size="20" maxlength='10' value="<?php echo $a_row->op_assembly_value3;?>" name="op_assembly_value3[<?php echo $a_row->id;?>]" id="op_assembly_value3" />
                                            <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Height:</strong></td><td colspan="2">
                                            <input type="text" size="20" maxlength='10' onKeyPress="return numbersOnlyEspecialFloat(this, event);" value="<?php echo $a_row->op_assembly_value4;?>" name="op_assembly_value4[<?php echo $a_row->id;?>]" id="op_assembly_value4" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Pull Force:</strong></td><td colspan="2">
                                   <input type="text" size="20" maxlength='10' value="<?php echo $a_row->op_assembly_value5;?>" name="op_assembly_value5[<?php echo $a_row->id;?>]" id="op_assembly_value5" /></td>
                                    </tr>
                                        <tr>
                                                <td colspan="3"><strong>Comments:</strong></td>
                                                
                                        </tr>
                                        <tr>
                                                <td colspan="3">
                                                        <textarea name="op_comment" rows="10" cols="70"><?php echo $op_arr[$step]['op_comment']?></textarea>
                                                </td>
                                            <input type="hidden" name="op_assemble_id[]" value="<?php echo $a_row->id ?>" />
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
                                        <?php echo JHTML::_('form.token'); ?>
</form>
