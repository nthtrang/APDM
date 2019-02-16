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


// clean item data
JFilterOutput::objectHTMLSafe($user, ENT_QUOTES, '');
$woids =   JRequest::getVar('woids');
$so_id = JRequest::getVar('id');
?>
<script language="javascript">
function inprogresswoWo(){
        var form = document.adminForm;
        if (form.wo_history_reason.value==""){
		alert('Please input reason.');
		return false;
	}else{	
		form.submit();
	}
	
}
function UpdatePnsRevWindow(){        				
        window.parent.document.getElementById('sbox-window').close();	       
       window.parent.document.location.href = "index.php?option=com_apdmpns&task=so_detail_wo&time=<?php echo time();?>&id=<?php echo $so_id?>";
}
</script>
<form action="index.php?option=com_apdmpns&task=saveinprogresswo&tmpl=component&id=<?php echo $so_id?>" method="post" name="adminForm" enctype="multipart/form-data" >      
        <fieldset class="adminform">

                <div class="col width-100">
                        <fieldset class="adminform">		
                                <table class="admintable" cellspacing="1" width="100%">
                                        <tr>
			<td></td>
			<td align="right"><input type="button" name="btinsersave" value="Save"  onclick="inprogresswoWo();UpdatePnsRevWindow();"/>
                        
                        </td>	
		</tr>	
                                        <tr>
                                                <td><strong>Reason:</strong></td>
                                                
                                        </tr>
                                        <tr>
                                                <td>
                                                        <textarea name="wo_history_reason" rows="10" cols="70"></textarea>
                                                </td>
                                               
                                        </tr>
                                        
			      
                                </table>

                                
                        </fieldset>
                </div>	
        </fieldset>
        <input type="hidden" name="wo_ids" value="<?php echo $woids; ?>" />
        <input type="hidden" name="option" value="com_apdmpns" />     
        <input type="hidden" name="so_id" value="<?php echo JRequest::getVar('id'); ?>" />     
        <input type="hidden" name="task" value="saveinprogresswo" />	
        <input type="hidden" name="return" value="so_detail_wo"  />
        <input type="hidden" name="boxchecked" value="1" />
                                        <?php echo JHTML::_('form.token'); ?>
</form>
