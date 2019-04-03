<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip');
$cid = JRequest::getVar( 'cid', array(0) );
$edit		= JRequest::getVar('edit',true);
$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

JToolBarHelper::title( JText::_( 'PNS_MAMANGEMENT' ) . ': <small><small>[ '. $text .' ]</small></small>' , 'cpanel.png' );

JToolBarHelper::apply('edit_pns_stock', 'Save');
if ( $edit ) {
        // for existing items the button is renamed `close`
        JToolBarHelper::cancel( 'cancel', 'Close' );
} else {
        JToolBarHelper::cancel();
}

$cparams = JComponentHelper::getParams ('com_media');
$editor = &JFactory::getEditor();
// clean item data
JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );	
?>
<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}	
//		if (form.pns_stock.value < form.pns_qty_used.value){
//			alert("Please input Stock greater than Qty Used	");
//			form.pns_stock.focus();
//			return false;
//		}                
		submitform( pressbutton );
	}
	
</script>

<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data" >
	<div class="col width-100">
		<fieldset class="adminform">
<!--		<legend><?php echo JText::_( 'PNs Detail' ); ?></legend>-->
			<table class="admintable" cellspacing="1">
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'ASCENX_PNS' ); ?>
						</label>
					</td>
					<td><?php echo $this->row->ccs_code.'-'.$this->row->pns_code;?>
						<input type="hidden"  name="pns_code" id="pns_code"  size="10" value="<?php echo $this->row->pns_code;?>"/>
						<input type="hidden" name="ccs_code" id="ccs_code" value="<?php echo $this->row->ccs_code;?>" />
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_REVISION' ); ?>
						</label>
					</td>
					<td>
                                                <?php echo $this->row->pns_revision;?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_CHILD' ); ?>
						</label>
					</td>
					<td valign="top">
						<?php 
							if (count($this->lists['pns_parent_info']) > 0) {
							?>
								<a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmpns&task=list_child&tmpl=component&id=<?php echo $this->row->pns_id?>" title="Image">
<input type="button" name="listPnsChild" value="<?php echo JText::_('List PNs Child')?>"/>
</a>			
		
						<?php	}
						?>
					</td>
				</tr>

				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_ECO' ); ?>
						</label>
					</td>
					<td>
					<?php echo PNsController::GetECO($this->row->eco_id); ?>
					<input type="hidden" name="eco_id" id="eco_id" value="<?php echo $this->row->eco_id;?>" />
                                      
</a>	
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Make/Buy' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->pns_type;?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_DESCRIPTION' ); ?>
						</label>
					</td>
					<td>
						<textarea maxlength='40' readonly name="pns_description" rows="6" cols="30"><?php echo $this->row->pns_description?></textarea>
					</td>
				</tr>
<!--				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_STATUS' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->status;?>
					</td>
				</tr>-->
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'State' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->pns_life_cycle;?>
					</td>
				</tr>
                                                                   
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Cost' ); ?>
						</label>
					</td>
					<td>
                                                <input type="text" value="<?php echo $this->lists['pns_cost']?>" name="pns_cost" id="pns_cost" <?php echo $classDisabled;?> />
					</td>
				</tr>
<!--				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Date In' ); ?>
						</label>
					</td>
					<td>
						<?php //echo JHTML::_('calendar', $this->lists['pns_datein'], 'pns_datein', 'pns_datein', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Stock' ); ?>
						</label>
					</td>
					<td>

                                                <input type="text" value="<?php echo $this->lists['pns_stock']?>" name="pns_stock" id="pns_stock" <?php echo $classDisabled;?> />

					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Qty Used' ); ?>
						</label>
					</td>
					<td>
                                                <input type="text" value="<?php echo $this->lists['pns_qty_used']?>" name="pns_qty_used" id="pns_qty_used" />
					</td>
				</tr>                                -->
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'UOM' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->pns_uom;?>
					</td>
				</tr>	                                
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Date Create' ); ?>
						</label>
					</td>
					<td>
 						<?php echo  JHTML::_('date', $this->row->pns_create, JText::_('DATE_FORMAT_LC6')); ?>

					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Create by' ); ?>
						</label>
					</td>
					<td>
 						<?php echo GetValueUser($this->row->pns_create_by, "username"); ?>

					</td>
				</tr>
				
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Date Modified' ); ?>
						</label>
					</td>
					<td>
 						<?php echo  ($this->row->pns_modified_by) ? JHTML::_('date', $this->row->pns_modified, JText::_('DATE_FORMAT_LC6')) : ''; ?>

					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Modified By' ); ?>
						</label>
					</td>
					<td> 						
						<?php echo  ($this->row->pns_modified_by) ? GetValueUser($this->row->pns_modified_by, "username") : ''; ?>

					</td>
				</tr>
				
			</table>
		</fieldset>
	</div>
<div style="display:none"><?php
						// parameters : areaname, content, width, height, cols, rows
						echo $editor->display( 'text',  $row->text , '10%', '10', '10', '3' ) ;
						?></div>
	<input name="nvdid" value="<?php echo $this->lists['count_vd'];?>" type="hidden" />
	<input name="nspid" value="<?php echo $this->lists['count_sp'];?>" type="hidden" />
	<input name="nmfid" value="<?php echo $this->lists['count_mf'];?>" type="hidden" />
	<input type="hidden" name="pns_id" value="<?php echo $this->row->pns_id;?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->row->pns_id;?>" />	
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="return" value="<?php echo $this->cd;?>"  />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
