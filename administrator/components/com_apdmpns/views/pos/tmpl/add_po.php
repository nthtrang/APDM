<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php	
//poup add rev roll
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );
JToolBarHelper::title( JText::_( 'PO' ) . ': <small><small>[ New ]</small></small>' , 'cpanel.png' );
	
?>
<script language="javascript" type="text/javascript">
function UpdatePnsRevWindow(){        				
        window.parent.document.getElementById('sbox-window').close();	            
        window.parent.document.location.href = "index.php?option=com_apdmpns&task=pomanagement&time=<?php echo time();?>";
}
function get_default_po_prefix(){		
		var url = 'index.php?option=com_apdmpns&task=po_prefix_default';				
		var MyAjax = new Ajax(url, {
			method:'get',
			onComplete:function(result){				
				$('po_code_prefix').value = result.trim();
			}
		}).request();
	}
</script>
<fieldset class="adminform">
		<legend><?php echo JText::_( 'Add PO' ); ?></legend>
<form action="index.php?option=com_apdmpns&task=save_po&time=<?php echo time();?>" method="post" name="adminFormPnsrev" enctype="multipart/form-data" >
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
							<?php echo JText::_( 'P.O Number' ); ?>
						</label>
					</td>
					<td>
						<input type="text"  name="po_code" id="po_code"  size="10" value="P<?php echo $this->po_row->po_code?$this->po_row->po_code:date('ymd');?>"/>						
                                                <input type="text"  name="po_code_prefix" id="po_code_prefix"  size="10" value=""/>
                                                <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="get_default_po_prefix();"><?php echo JText::_('Get Default PO')?></a>
					</td>
				</tr>
                                 
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Description' ); ?>
						</label>
					</td>
					<td>						
						<textarea name="po_description" rows="10" cols="60"><?php echo $this->po_row->po_code?></textarea>
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
