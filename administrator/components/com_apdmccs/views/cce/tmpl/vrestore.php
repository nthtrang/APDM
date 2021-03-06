<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	JToolBarHelper::title( JText::_( 'COMMODITY_CODE_MAMANGEMENT' ) . ': <small><small>[ view ]</small></small>' , 'generic.png' );
	JToolBarHelper::publishList('restore', 'Restore');
	JToolBarHelper::cancel( 'cancel_restore', 'Close' );
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

		// do field validation
		submitform( pressbutton );
	}

</script>
<form action="index.php" method="post" name="adminForm" >
	<div class="col width-60">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Comodity Code Detail' ); ?></legend>
			<table class="admintable" cellspacing="1">
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'COMMODITY_CODE' ); ?>
						</label>
					</td>
					<td>
					<?php echo $this->row->ccs_code;?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'COMMODITY_CODE_DESCRIPTION' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->ccs_description?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'COMMODITY_CODE_ACTIVATE' ); ?>
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
							<?php echo JText::_('CCS_CREATE')?>
						</label>
					</td>
					<td>
						<?php echo ($this->row->ccs_id) ? JHTML::_('date', $this->row->ccs_create, '%Y-%m-%d %H:%M:%S') :'New document';?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="ccs_create_by">
							<?php echo JText::_('CCS_CREATE_BY')?>
						</label>
					</td>
					<td>
						<?php echo ($this->row->ccs_id) ? GetValueUser($this->row->ccs_create_by, 'username') : 'New Document';?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="ccs_create">
							<?php echo JText::_('CCS_MODIFIED')?>
						</label>
					</td>
					<td>
						<?php echo ($this->row->ccs_modified !='0000-00-00 00:00:00') ? JHTML::_('date', $this->row->ccs_modified, '%Y-%m-%d %H:%M:%S') : 'None';?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="ccs_create_by">
							<?php echo JText::_('CCS_MODIFIED_BY')?>
						</label>
					</td>
					<td>
						<?php echo ($this->row->ccs_modified_by) ? GetValueUser($this->row->ccs_modified_by, 'username') : 'None';?>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center"><a href="#"><?php echo JText::_('LINK_PART_NUMBER_BELONG')?></a></td>
				</tr>
				
			</table>
		</fieldset>
		
	</div>
	<div class="clr"></div>

	<input type="hidden" name="ccs_id" value="<?php echo $this->row->ccs_id?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->row->ccs_id?>" />
	<input type="hidden" name="option" value="com_apdmccs" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="1" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
