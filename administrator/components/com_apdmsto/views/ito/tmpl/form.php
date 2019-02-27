<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

	JToolBarHelper::title( JText::_( 'ITO' ) . ': <small><small>[ '. $text .' ]</small></small>' , 'generic.png' );
	if (!intval($edit)) {
		JToolBarHelper::save('save', 'Save & Add new');
	}	JToolBarHelper::apply('apply', 'Save');
	
	if ( $edit ) {
		// for existing items the button is renamed `close`
		JToolBarHelper::cancel( 'cancel', 'Close' );
	} else {
		JToolBarHelper::cancel();
	}
	
	$cparams = JComponentHelper::getParams ('com_media');
?>
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
		var url = 'index.php?option=com_apdmsto&task=get_sto_code_default&sto_type=1';				
		var MyAjax = new Ajax(url, {
			method:'get',
			onComplete:function(result){				
				$('sto_code').value = result.trim();
			}
		}).request();
	}
        get_default_ito_prefix();
</script>
<form action="index.php" method="post" name="adminForm">
	<div class="col width-60">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'ITO Detail' ); ?></legend>
		
			<table class="admintable" cellspacing="1">
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'ITO Number' ); ?>
						</label>
					</td>
					<td>
						<input type="text" readonly="readonly" name="sto_code" id="sto_code"  size="10" value=""/>                                               
					</td>
				</tr>
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'P.O Internal' ); ?>
						</label>
					</td>
					<td>
						<input type="text" name="po_inter_code" id="po_inter_code"  size="10" value=""/>                                               
					</td>
				</tr>                                
                                 <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Created Date' ); ?>
						</label>
					</td>
					<td>                                                 
                                               <?php echo JHTML::_('calendar',$this->so_row->so_shipping_date, 'so_shipping_date', 'so_shipping_date', '%m/%d/%Y', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	
					</td>
				</tr>      
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Supplier' ); ?>
						</label>                                                
					</td>
					<td>												 
                                                <?php echo $this->lists['ccsupplier'];?>  
                                                <input type="hidden" maxlength="20" name="so_state"  id="so_state" class="inputbox" size="30" value="inprogress"/>
                                                
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
							<?php echo JText::_( 'Owner' ); ?>
						</label>
					</td>
                                 <td  width="16%">
                                                                <select name="sto_owner" id="sto_owner" >
                                                                        <option value="">Select Owner</option>
                                        <?php foreach ($this->list_user as $list) { ?>
                                                                                <option value="<?php echo $list->id; ?>"><?php echo $list->name; ?></option>
                                                <?php } ?>
                                                                </select>
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
	<input type="hidden" name="option" value="com_apdmsto" />
	<input type="hidden" name="return" value="sto"  />
	<?php echo JHTML::_( 'form.token' ); ?>
        </fieldset>
        </div>
</form>
