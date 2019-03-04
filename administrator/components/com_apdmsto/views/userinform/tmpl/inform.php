<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
$me = & JFactory::getUser();
$me->get('username');
$sto_id		= JRequest::getVar( 'sto_id');
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	
?>
<script language="javascript">
function CheckForm() {

			if (document.adminForm.text_search.value==""){
				alert("Please input keyword to filter");
				return false;
			}
			if (document.adminForm.type_filter.value==0){
				alert("Please select type to filter");
				return false;			
			}
		
	
}
function UpdateOwnerSto(sto_id){
        var form = document.adminForm;
        var so_id = form.sto_id.value;
         if (form.username.value==""){
		alert('Please type your username.');
		return false;
	}
        else if (form.passwd.value==""){
		alert('Please type your password.');
		return false;
	}else{	
		var url = 'index.php?option=com_apdmsto&task=ajax_checkownersto&id='+so_id;                
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
                                       // window.parent.document.getElementById('sbox-window').close();	
                                        window.parent.location.reload();
                                }
				
				

			}
		}).request();
	}
	
}
</script>
<form action="index.php?option=com_apdmsto&task=checkownerso&tmpl=component&id=<?php echo $so_id?>" method="post" name="adminForm" id="adminForm"  >
<input type="hidden" name="id" value="<?=$this->id?>" />
<div name="notice" style="color:#D30000" id ="notice"></div>
<table class="adminlist" cellpadding="1">
        <tr>
                <td colspan="2"><strong><?php echo JText::_('Please confirm your Username / password')?></strong></td>
        </tr>
         <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'User Name' ); ?>
						</label>
					</td>
					<td>
						<input name="username" type="text" id="modlgn_username" value="<?php echo $me->get('username')?>" type="text" class="inputbox" size="15" />                                                
					</td>
				</tr>                           
		 <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Password' ); ?>
						</label>
					</td>
					<td>						
                                                <input name="passwd" id="modlgn_passwd" type="password" class="inputbox" size="15" />                                               
					</td>
				</tr>
                           <tr>
			<td></td>
			<td align="right"><input type="button" name="btinsersave" value="Save"  onclick="UpdateOwnerSto(<?php echo $sto_id?>);"/>
                        
                        </td>	
		</tr>	      
				
	</table>

	<div class="clr"></div>	
	<input type="hidden" name="option" value="com_apdmsto" />
        <input type="hidden" name="sto_id" id="so_id" value="<?php echo $sto_id; ?>" />
	<input type="hidden" name="boxchecked" id="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
