<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php	
//poup add rev roll
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	
?>
<script language="javascript" type="text/javascript">
function UpdatePnsRevWindow(){        				
        window.parent.document.getElementById('sbox-window').close();	       
     // window.parent.document.location.reload(true);
        window.parent.document.location.href = "index.php?option=com_apdmpns&task=stomanagement&time=<?php echo time();?>";
     //   setTimeout("window.parent.document.getElementById('sbox-window').close();",1000);
       //setTimeout( "window.document.getElementById('sbox-window').close();window.parent.document.location.reload();", 2000 );
}
function get_default_ito_prefix(){		
		var url = 'index.php?option=com_apdmpns&task=iesto_prefix_default&sto_type=2';				
		var MyAjax = new Ajax(url, {
			method:'get',
			onComplete:function(result){				
				$('sto_code_prefix').value = result.trim();
			}
		}).request();
	}
</script>

<form action="index.php?option=com_apdmpns&task=save_stoe&time=<?php echo time();?>" method="post" name="adminFormPnsrev" enctype="multipart/form-data" >
         <table  width="100%">
		<tr>
			<td></td>
			<td align="right"><input type="submit" name="btinsersave" value="Save"  onclick="UpdatePnsRevWindow();"/>
                        
                        </td>	
		</tr>	
</table>
			<table class="admintable" cellspacing="1">
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'ETO Number' ); ?>
						</label>
					</td>
					<td>
						<input type="text"  name="sto_code" id="sto_code"  size="10" value="E<?php echo $this->sto_row->sto_code?$this->sto_row->sto_code:date('dmy');?>"/>						
                                                <input type="text"  name="sto_code_prefix" id="sto_code_prefix"  size="10" value=""/>
                                                <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="get_default_ito_prefix();"><?php echo JText::_('Get Default ITO')?></a>
					</td>
				</tr>
                                 
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Description' ); ?>
						</label>
					</td>
					<td>						
						<textarea name="sto_description" rows="10" cols="60"><?php echo $this->sto_row->sto_code?></textarea>
					</td>
				</tr>             
                               
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Attached' ); ?>
						</label>                                                
					</td>
					<td>						
						 <input type="file" name="sto_file" /><br/>
                                                 <font color="#FF0000"><em><?php echo JText::_('(Please upload file less than 20Mb)')?></em></font>
					</td>
				</tr>				
			</table>
	


	<input type="hidden" name="pns_id" value="<?php echo  $cid[0];?>" />	
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="return" value="po"  />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
