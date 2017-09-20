<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

	JToolBarHelper::title( JText::_( 'SUPPLIER_INFO_MANAGEMET' ) . ': <small><small>[ '. $text .' ]</small></small>' , 'generic.png' );
	if (!intval($edit)) {
		JToolBarHelper::save('save', 'Save & Add new');
	}
	JToolBarHelper::apply('apply', 'Save');
	
	if ( $edit ) {
		// for existing items the button is renamed `close`
		JToolBarHelper::cancel( 'cancel', 'Close' );
	} else {
		JToolBarHelper::cancel();
	}
	
	$cparams = JComponentHelper::getParams ('com_media');
?>

<?php
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
		var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&]", "i");
			submitform( pressbutton );
		if (trim(form.info_type.value) == 0) {
			alert( "<?php echo JText::_( 'ALERT_TYPE_INFO', true ); ?>" );		
		}else if (trim(form.info_name.value )== ""){
			alert("<?php echo JText::_( 'ALERT_NAME', true ); ?>" );
		} else {
			submitform( pressbutton );
		}
	}

</script>

<form action="index.php" method="post" name="adminForm" >
	<div class="col width-60">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'INFORMATION_DETAIL' ); ?></legend>
			<table class="admintable" cellspacing="1">
				<tr>
					<td class="key">
						<label for="type_info">
							<?php echo JText::_( 'TYPE_INFO' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->lists['type_info'];?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="name">
							<?php echo JText::_('NAME');?>
						</label>
					</td>
					<td>
						<input type="text" maxlength="200" class="inputbox" size="30" name="info_name" value="<?php echo $this->row->info_name?>" />
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="name">
							<?php echo JText::_('ADDRESS');?>
						</label>
					</td>
					<td>
						<input type="text" maxlength="200" class="inputbox" size="30" name="info_address" value="<?php echo $this->row->info_address?>" />
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="name">
							<?php echo JText::_('TEL_FAX');?>
						</label>
					</td>
					<td>
						<input type="text" maxlength="200" class="inputbox" size="30" name="info_telfax" value="<?php echo $this->row->info_telfax?>" />
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="name">
							<?php echo JText::_('WEBSITE');?>
						</label>
					</td>
					<td>
						<input type="text" maxlength="200" class="inputbox" size="30" name="info_website" value="<?php echo $this->row->info_website?>" />
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="name">
							<?php echo JText::_('CONTACT_PERSON');?>
						</label>
					</td>
					<td>
						<input type="text" maxlength="200" class="inputbox" size="30" name="info_contactperson" value="<?php echo $this->row->info_contactperson?>" />
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="name">
							<?php echo JText::_('EMAIL');?>
						</label>
					</td>
					<td>
						<input type="text" maxlength="200" class="inputbox" size="30" name="info_email" value="<?php echo $this->row->info_email?>" />
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'DESCRIPTION' ); ?>
						</label>
					</td>
					<td>
						<textarea name="info_description" rows="10" cols="60"><?php echo $this->row->info_description?></textarea>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ACTIVATE' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->lists['activate']?>
					</td>
				</tr>
			</table>
		</fieldset>
	</div>
	<div class="col width-40">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Parameters' ); ?></legend>
			<table class="admintable">
				<tr>
					<td class="key">
						<label for="ccs_create">
							<?php echo JText::_('INFO_CREATE')?>
						</label>
					</td>
					<td>
						<?php echo ($this->row->info_id) ? JHTML::_('date', $this->row->info_create, '%Y-%m-%d %H:%M:%S') :'New document';?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="ccs_create_by">
							<?php echo JText::_('INFO_CREATE_BY')?>
						</label>
					</td>
					<td>
						<?php echo ($this->row->info_id) ? GetValueUser($this->row->info_created_by, 'name') : 'New Document';?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="ccs_create">
							<?php echo JText::_('INFO_MODIFIED')?>
						</label>
					</td>
					<td>
						<?php echo ($this->row->info_modified_by) ? JHTML::_('date', $this->row->info_modified, '%Y-%m-%d %H:%M:%S') : 'None';?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="ccs_create_by">
							<?php echo JText::_('INFO_MODIFIED_BY')?>
						</label>
					</td>
					<td>
						<?php echo ($this->row->info_modified_by) ? GetValueUser($this->row->info_modified_by, 'name') : 'None';?>
					</td>
				</tr>
				
				
			</table>
		</fieldset>
		
	</div>
	<div class="clr"></div>

	<input type="hidden" name="info_id" value="<?php echo $this->row->info_id?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->row->info_id?>" />
	<input type="hidden" name="option" value="com_apdmsuppliers" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
