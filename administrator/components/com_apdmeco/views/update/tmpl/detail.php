<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$role = JAdministrator::RoleOnComponent(5);	
	
	JToolBarHelper::title( JText::_( 'ECO_MANAGEMET' ) . ': <small><small>[ '. JText::_( 'Detail' ).' ]</small></small>' , 'generic.png' );	
	JToolBarHelper::customX('export_detail', 'excel', '', 'Export', false);
	if (in_array("E", $role)) {
		JToolBarHelper::editListX();
	}
	if (in_array("W", $role)) {
		JToolBarHelper::addNewX();
	}
	JToolBarHelper::cancel( 'cancel', 'Close' );

	$cparams = JComponentHelper::getParams ('com_media');
?>

<?php
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	
?>
<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'edit') {
				submitform( pressbutton );
				return;
			}
		if (pressbutton == 'add') {
				submitform( pressbutton );
				return;
			}
		if (pressbutton == 'export_detail') {
				submitform( pressbutton );
				return;
			}
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&]", "i");	
	}
</script>

<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data" >
	<div class="col width-60">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'INFORMATION_DETAIL' ); ?></legend>
			<table class="admintable" cellspacing="1">				
				<tr>
					<td class="key" valign="top">
						<label for="name">
							<?php echo JText::_('ECO_NAME');?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_name?>
					</td>
				</tr>
				<!--<tr>
					<td class="key" valign="top">
						<label for="name">
							<?php //echo JText::_('ECO_PDF');?>
						</label>
					</td>
					<td>
						<input type="file" name="file_pdf" />&nbsp;&nbsp;<?php //if($this->row->eco_id && ($this->row->eco_pdf !="")) { ?> 
						File PDF: <a href="index.php?option=com_apdmeco&task=download&id=<?php //echo $this->row->eco_id?>" title="Click to download file pdf"><?php //echo $this->row->eco_pdf;?></a>
						<?php //} ?>
						<input type="hidden" name="file_pdf_exist" value="<?php //echo $this->row->eco_pdf;?>" />
					</td>
				</tr>		-->		
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'DESCRIPTION' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_description?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_PROJECT' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_project; ?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_TYPE' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_type; ?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_FIELD_IMPACT' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_field_impact; ?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_REASON' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_reason?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_WHAT_IS_CHANGE' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_what?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_SPECIAL' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_special?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_BENEFIT' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_benefit?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_TECHNICAL_ACTIONS' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_technical?>
					</td>
				</tr>
<!--				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_TECHNICAL_DESIGN' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_tech_design; ?>
					</td>
				</tr>
-->
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_ESTIMATED' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_estimated; ?>
					</td>
				</tr>
<!--				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_TARGET' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_estimated_cogs; ?>
					</td>
				</tr>
	-->			
			
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ACTIVE' ); ?>
						</label>
					</td>
					<td>
						<?php echo ($this->row->eco_activate) ? 'Activated' : 'Inactivated';  ?>
					</td>
				</tr>	
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'STATUS' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_status; ?>
					</td>
				</tr>			
				
			</table>
		</fieldset>
	</div>
	<div class="col width-40">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Files' ); ?></legend>
			<table class="admintable">
				<?php if (count($this->arr_file) > 0 ) { ?>
					<tr>
						<td colspan="2">
						<table width="100%"  class="adminlist" cellpadding="1">						
						<thead>
							<th colspan="4"><?php echo JText::_('List file ')?></th>
						</thead>
						<tr>
							<td width="5%"><strong><?php echo JText::_('No.')?></strong></td>
							<td width="45%"><strong><?php echo JText::_('Name')?> </strong></td>
							<td width="30%"><strong><?php echo JText::_('Size (KB)')?> </strong></td>
							<td width="20%"><strong><?php echo JText::_('Download')?>  </strong></td>
						</tr>
						<?php $i = 1; 
					foreach ($this->arr_file as $file) { 
						$filesize = ECOController::Readfilesize($file->file_name);
					?>
							<tr>
							<td><?php echo $i?></td>
							<td><?php echo $file->file_name;?></td>
							<td><?php echo number_format($filesize, 0, '.', ' '); ?></td>
							<td><a href="index.php?option=com_apdmeco&task=download&id=<?php echo $file->id?>" title="Click here to download file"><img src="images/download_f2.png" width="20" height="20" /></a>&nbsp;&nbsp;
							</td>
						</tr>
						<?php $i++; } ?>
						</table>
						</td>
					</tr>
				<?php  
				} ?>
				
				
			</table>
		</fieldset>
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
						<?php echo ($this->row->eco_id) ? JHTML::_('date', $this->row->eco_create, '%Y-%m-%d %H:%M:%S') :'New document';?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="ccs_create_by">
							<?php echo JText::_('INFO_CREATE_BY')?>
						</label>
					</td>
					<td>
						<?php echo ($this->row->eco_id) ? GetValueUser($this->row->eco_create_by, 'name') : 'New Document';?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="ccs_create">
							<?php echo JText::_('INFO_MODIFIED')?>
						</label>
					</td>
					<td>
						<?php echo ($this->row->eco_modified_by) ? JHTML::_('date', $this->row->eco_modified, '%Y-%m-%d %H:%M:%S') : 'None';?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="ccs_create_by">
							<?php echo JText::_('INFO_MODIFIED_BY')?>
						</label>
					</td>
					<td>
						<?php echo ($this->row->eco_modified_by) ? GetValueUser($this->row->eco_modified_by, 'name') : 'None';?>
					</td>
				</tr>
				
				
			</table>
		</fieldset>
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Approvers' ); ?></legend>
                
                			<table class="admintable">
				<?php if (count($this->arr_status) > 0 ) { ?>
					<tr>
						<td colspan="2">
						<table width="100%"  class="adminlist" cellpadding="1">						
						<thead>
							<th colspan="3"><?php echo JText::_('List Approvers ')?></th>
						</thead>
						<tr>
							<td width="5%"><strong><?php echo JText::_('No.')?></strong></td>
							<td width="45%"><strong><?php echo JText::_('Email')?> </strong></td>
							<td width="30%"><strong><?php echo JText::_('Status')?> </strong></td>							
						</tr>
						<?php $i = 1; 
					foreach ($this->arr_status as $status) { 
						?>
							<tr>
							<td><?php echo $i?></td>
							<td><?php echo $status->email;?></td>
							<td><?php echo $status->eco_status;?></td>
						</tr>
						<?php $i++; } ?>
						</table>
						</td>
					</tr>
				<?php  
				} ?>
			</table>
                
                </fieldset>
	</div>
	
	<div class="clr"></div>

	<input type="hidden" name="eco_id" value="<?php echo $this->row->eco_id?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->row->eco_id?>" />
	<input type="hidden" name="option" value="com_apdmeco" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="1" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
