<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php JHTML::_('behavior.modal'); ?>
<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

	JToolBarHelper::title( $this->sto_row->sto_code. ': <small><small>[ '. $text .' ]</small></small>' , 'generic.png' );
	if (!intval($edit)) {
	//	JToolBarHelper::save('save', 'Save & Add new');
	}	
	JToolBarHelper::apply('save_editito', 'Save');
	
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
 window.addEvent('domready', function(){ var JTooltips = new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false}); });
		window.addEvent('domready', function() {

			SqueezeBox.initialize({});

			$$('a.modal-button').each(function(el) {
				el.addEvent('click', function(e) {
					new Event(e).stop();
					SqueezeBox.fromElement(el);
				});
			});
		});
                
                 window.addEvent('domready', function() {

                SqueezeBox.initialize({});

                $$('a.modal').each(function(el) {
                        el.addEvent('click', function(e) {
                                new Event(e).stop();
                                SqueezeBox.fromElement(el);
                        });
                });
        });
</script>
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">
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
						<input type="text" readonly="readonly" name="sto_code" id="sto_code"  size="10" value="<?php echo $this->sto_row->sto_code?>"/>                                               
					</td>
				</tr>
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'P.O Internal' ); ?>
						</label>
					</td>
					<td>
						<input type="text" name="po_inter_code" id="po_inter_code"  size="10" value="<?php echo $this->sto_row->sto_po_internal?>"/>                                               
					</td>
				</tr>                                
                                 <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Created Date' ); ?>
						</label>
					</td>
					<td>                                                 
                                               <?php echo JHTML::_('calendar',$this->sto_row->sto_created, 'sto_created', 'sto_created', '%m/%d/%Y', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	
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
					</td>
				</tr>	
				<tr>
					<td class="key" valign="top">
						<label for="stocker">
							<?php echo JText::_( 'Stoker confirm' ); ?>
						</label>
					</td>
					<td>
                            <input type="checkbox" id ="stocker_confirm" name="stocker_confirm" checked="checked" value="1" /> 
					</td>
				</tr>              				
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Description' ); ?>
						</label>
					</td>
					<td>						
						<textarea name="sto_description" rows="10" cols="60"><?php echo $this->sto_row->sto_description?></textarea>
					</td>
				</tr>  
                                <tr>
                                        <td  class="key" width="28%"><?php echo JText::_('Confirm'); ?></td>                                               
                                        <td width="30%" class="title"> 
										 <?php 
                                                     if(!$this->sto_row->sto_owner_confirm){

                                                    ?>
                                                  
                                                   
                                                   <a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmsto&task=get_owner_confirm_sto&sto_id=<?php echo $this->sto_row->pns_sto_id?>&tmpl=component" title="Image">
                                                         <input onclick="return false;" onkeydown="return false;" type="checkbox" name="sto_owner_confirm" value="1" /></a>
                                                        <?php }
                                                        else
                                                        {
                                                                       ?>
                                                <input checked="checked" onclick="return false;" onkeydown="return false;" type="checkbox" name="sto_owner_confirm" value="1" />
                                                                       <?php
                                                        }
                                                        ?>
                                        </td>  
                                </tr>
                                
                                 <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Owner' ); ?>
						</label>
					</td>
                                 <td  width="16%">
                                      <?php echo ($this->sto_row->sto_owner)?GetValueUser($this->sto_row->sto_owner, "name"):""; ?>
                                                        </td>
                                 </tr>                              
			</table>                	
        </fieldset>
        </div>
		
				<input type="hidden" name="pns_sto_id" value="<?php echo $this->sto_row->pns_sto_id?>" />
	<input type="hidden" name="option" value="com_apdmsto" />
	<input type="hidden" name="return" value="sto"  />
	<input type="hidden" name="task" value="ito_detail" />     
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
