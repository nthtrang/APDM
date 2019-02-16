<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
$me = & JFactory::getUser();
$me->get('username');
$woids =   JRequest::getVar('woids');
$so_id = JRequest::getVar('id');
	// clean item data
JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );


?>
<script language="javascript">
function UpdateDeleteSo(){
        var form = document.adminForm;
        var so_id = form.so_id.value;
       var wo_ids = form.wo_ids.value;
        if (form.passwd.value==""){
		alert('Please type your password.');
		return false;
	}else{	
		var url = 'index.php?option=com_apdmpns&task=ajax_cancelwo&id='+so_id;                
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
                                       
                                        window.location = "index.php?option=com_apdmpns&task=cancelwopop&tmpl=component&id="+so_id+"&wo_ids="+wo_ids;
                                }
				
				

			}
		}).request();
	}
	
}
</script>
<form action="index.php?option=com_apdmpns&task=informDelSo&tmpl=component&id=<?php echo $so_id?>" method="post" name="adminForm" id="adminForm"  >
<input type="hidden" name="id" value="<?=$this->id?>" />
<div name="notice" style="color:#D30000" id ="notice"></div>
<table class="adminlist" cellpadding="1">
        <tr>
                <td colspan="2"><strong><?php echo JText::_('Please confirm your password')?></strong></td>
        </tr>
		 <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Password' ); ?>
						</label>
					</td>
					<td>
						<input name="username" type="hidden" id="modlgn_username" value="<?php echo $me->get('username')?>" type="text" class="inputbox" size="15" />
                                                <input name="passwd" id="modlgn_passwd" type="password" class="inputbox" size="15" />                                               
					</td>
				</tr>
                           <tr>
			<td></td>
			<td align="right"><input type="button" name="btinsersave" value="Ok"  onclick="UpdateDeleteSo();"/>
                        
                        </td>	
		</tr>	      
				
	</table>

	<div class="clr"></div>	
	<input type="hidden" name="option" value="com_apdmpns" />
        <input type="hidden" name="so_id" id="so_id" value="<?php echo $so_id; ?>" />
	<input type="hidden" name="boxchecked" id="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
        <input type="hidden" name="wo_ids" value="<?php echo $woids; ?>" />
        <input type="hidden" name="option" value="com_apdmpns" />     
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
