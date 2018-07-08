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
function UpdateQuo(){	
        var form = document.adminFormQuonew;
        if (form.quo_code.value==""){
		alert('Please add QUO Number.');
		return false;
	}else{
		var url = 'index.php?option=com_apdmpns&task=save_pns_quonew';		
		var MyAjax = new Ajax(url, {
			method:'post',
			data:  $('adminFormQuonew').toQueryString(),
			onComplete:function(result){	
				var eco_result = result;      
				quos= eco_result.split('^');
				window.parent.document.getElementById('quo_code').value = quos[1];
				window.parent.document.getElementById('pns_quo_id').value = quos[0];				
				window.parent.document.getElementById('sbox-window').close();	
			}
		}).request();

	}
	
}        
</script>

<form action="index.php?option=com_apdmpns&task=save_pns_quonew&cid[]=<?php echo $cid[0]?>&time=<?php echo time();?>" method="post" name="adminFormQuonew" id="adminFormQuonew" enctype="multipart/form-data" >
         <table  width="100%">
		<tr>
			<td></td>
			<td align="right"><?php
                       // if($this->pns_status!='Release')
                      //  {
                                ?><input type="button" name="btinsersave" value="Save"  onclick="UpdateQuo();" />
                        <?php
                      //  }
                        ?>
                        </td>	
		</tr>	
</table>
			<table class="admintable" cellspacing="1">
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'QUO Number' ); ?>
						</label>
					</td>
					<td>
						<input type="text"  name="quo_code" id="quo_code"  size="10" value="<?php echo $rev[0]->quo_code;?>"/>						
					</td>
				</tr>
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Description' ); ?>
						</label>
					</td>
					<td>						
						<textarea name="quo_description" rows="10" cols="60"><?php echo $rev[0]->quo_description;?></textarea>
					</td>
				</tr>             
                               
                               		
			</table>
	


	<input type="hidden" name="pns_id" value="<?php echo  $cid[0];?>" />	
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="return" value="quo"  />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
