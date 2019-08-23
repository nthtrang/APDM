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
function saveReworkWoStep(){
        var form = document.adminForm;
        var wo_id = form.wo_id.value;
       if (form.passwd.value==""){
		alert('Please type your password.');
                form.passwd.focus();
		return false;
	}else{	                
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
                                        submitform("saveReworkStepWo");
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
function print_rework()
{
                    //window.location = "index.php?option=com_apdmpns&task=printwopdf&id="+form.wo_id.value + "&tmpl=component";
//                    var url = "index.php?option=com_apdmpns&task=print_rework&rework_id="+form.material_id.value + "&id="+form.wo_id.value+"&tmpl=component";
//                    window.open(url, '_blank');
//                    return;

 var form = document.adminForm;
        var wo_id = form.wo_id.value;
        
       if (form.passwd.value==""){
		alert('Please type your password.');
                form.passwd.focus();
		return false;
	}else{	                
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
                                        submitform("saveReworkStepWo");
                                        window.parent.document.getElementById('sbox-window').close();	
                                        window.parent.location = "index.php?option=com_apdmpns&task=wo_detail&id="+wo_id;
                                }
			}
		}).request();
	}
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
<form action="index.php?option=com_apdmpns&task=saveReworkStepWo&tmpl=component&id=<?php echo $wo_id?>" method="post" id="adminForm" name="adminForm" enctype="multipart/form-data" >      
        <fieldset class="adminform">

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
                                                        <?php echo $this->list_status_rework;?>
                                                </td>                                                
                                                <td class="key"><strong>QC By:</strong></td><td>   
                                                <?php echo ($assignee!=0)?GetValueUser($assignee, "name"):"N/A"; ?>
                                               <input type="hidden" value="<?php echo $assignee;?>" name="qc_by" id="qc_by"/>
                                                </td>
                                        </tr>
                                         <tr>
                                                <td class="key"><strong>Failure:</strong>  </td><td>                                                 
                                                        <?php $opfn_arr = $this->opfn_arr;                                                        
                                                        ?>
                                                        <?php
                                                        $arrFail = array();
                                                        if($opfn_arr[1]['op_final_value1']==0)
                                                            $arrFail[] ="Document(BOM,Drawing,Pro. Traveler)";
                                                        if($opfn_arr[1]['op_final_value2']==0)
                                                            $arrFail[] ="Visual Inspection";
                                                        if($opfn_arr[1]['op_final_value3']==0)
                                                            $arrFail[] ="Dimention";
                                                        if($opfn_arr[1]['op_final_value4']==0)
                                                            $arrFail[] ="Label";
                                                        if($opfn_arr[1]['op_final_value5']==0)
                                                            $arrFail[] ="Wiring";
                                                        if($opfn_arr[1]['op_final_value6']==0)
                                                            $arrFail[] ="Connection";
                                                        if($opfn_arr[1]['op_final_value7']==0)
                                                            $arrFail[] ="Hipot Test";
                                                        if($opfn_arr[1]['op_final_value8']==0)
                                                            $arrFail[] ="Other";
                                                        echo implode(",",$arrFail);                                                        
                                                        ?>
                                                        <input type="hidden" value="<?php echo implode(",",$arrFail);?>" name="rework_failure" id="rework_failure"/>
                                                </td>
                                               
                                                <td class="key"><strong>Rework Times:</strong></td><td>   
                                                <?php echo $this->wo_row->wo_rework_times + 1;?>
                                                         <input type="hidden"  value="<?php echo $this->wo_row->wo_rework_times + 1;?>" name="rework_times" id="rework_times"/>
                                                </td>
                                        </tr>
                                         <tr>
                                                <td></td>
                                                <td></td>
                                                <td class="key"><strong>Rework Qty:</strong></td><td>   
                                                
                                                 <input type="text" onKeyPress="return numbersOnlyEspecialFloat(this, event);" value="<?php echo $this->wo_row->wo_qty;?>" name="rework_qty" id="rework_qty"/>
                                                </td>
                                        </tr>
                                         
                                       
                                        <tr>
                                                <td colspan="4"><strong>Comments:</strong></td>
                                                
                                        </tr>
                                        <tr>
                                                <td colspan="4">
<!--                                                        <textarea name="op_comment" rows="10" cols="70"><?php echo $op_arr[$step]['op_comment']?></textarea>-->
                                                            <?php                                     
                                                $editor =& JFactory::getEditor();                                                
                                                     echo $editor->display('op_comment', "", '2%', '2', '2', '1',false);
                                        ?>
                                                </td>
                                               
                                        </tr>
                                        
                                        <tr>
                                                <td class="key">
                                                        <strong>Reference attachment:</strong></td><td colspan="3">
                                                        <input type="file" name="wo_files_zip" />
                                                </td>
                                               
                                        </tr>
                                        <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'User Name' ); ?>
						</label>
					</td>
					<td colspan="4">
						<input name="username" type="text" readonly="readonly" id="modlgn_username" value="<?php echo ($assignee!=0)?GetValueUser($assignee, "username"):$me->get('username')?>" type="text" class="inputbox" size="15" />
					</td>
				</tr>
                 <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Password' ); ?>
						</label>
					</td>
					<td colspan="4">					
                                                <input name="passwd" id="modlgn_passwd" type="password" class="inputbox" size="15" />                                               
					</td>
				</tr>          
                                    <tr>
			
			<td <td colspan="4" align="center">                                
                                <input type="button" name="btinsersavecomment" value="Save"  onclick="saveReworkWoStep();"/>                        
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
        <input type="hidden" name="pns_op_id" value="<?php echo $pns_op_id; ?>" />        
        <input type="hidden" name="option" value="com_apdmpns" />             
        <input type="hidden" name="task" value="" />	
        <input type="hidden" name="return" value="wo_detail"  />
        <input type="hidden" name="boxchecked" value="1" />
                                        <?php echo JHTML::_('form.token'); ?>
</form>
