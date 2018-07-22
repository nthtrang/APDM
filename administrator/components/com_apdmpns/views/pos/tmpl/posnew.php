<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php	
//poup add rev roll
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
        $rev = $this->pos;
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	
?>
<script language="javascript" type="text/javascript">
function UpdatePos(){	
        var form = document.adminFormPosnew;
        if (form.po_code.value==""){
		alert('Please add P.O Number.');
		return false;
	}else{
		var url = 'index.php?option=com_apdmpns&task=save_pns_posnew';		
		var MyAjax = new Ajax(url, {
			method:'post',
			data:  $('adminFormPosnew').toQueryString(),
			onComplete:function(result){	
				var eco_result = result;
				pos= eco_result.split('^');
				window.parent.document.getElementById('po_code').value = pos[1];
				window.parent.document.getElementById('pns_po_id').value = pos[0];				
				window.parent.document.getElementById('sbox-window').close();	
				

			}
		}).request();

	}
	
}        
</script>
<form action="index.php?option=com_apdmpns&task=save_pns_posnew&cid[]=<?php echo $cid[0]?>&time=<?php echo time();?>" method="post" name="adminFormPosnew" id="adminFormPosnew" enctype="multipart/form-data" >
         <table  width="100%">
		<tr>
			<td></td>
			<td align="right">
                                <input type="button" name="btinsersave" value="Save"  onclick="UpdatePos();" />
                        </td>	
		</tr>	
</table>
			<table class="admintable" cellspacing="1">
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'P.O Number' ); ?>
						</label>
					</td>
					<td>
						<input type="text"  name="po_code" id="po_code"  size="10" value="<?php echo $rev[0]->po_code;?>"/>						
					</td>
				</tr>
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Description' ); ?>
						</label>
					</td>
					<td>						
						<textarea name="po_description" rows="10" cols="60"><?php echo $rev[0]->po_description;?></textarea>
					</td>
				</tr>             
                               
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Attached' ); ?>
						</label>                                                
					</td>
					<td>						
						 <input type="file" name="po_file" /><br/>
                                                 <font color="#FF0000"><em><?php echo JText::_('(Please upload file less than 20Mb)')?></em></font>
					</td>
				</tr>				
			</table>
	


	<input type="hidden" name="pns_id" value="<?php echo  $cid[0];?>" />	
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="return" value="po"  />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
