<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
ddd
<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$role = JAdministrator::RoleOnComponent(5);	
	$tabfiles = '<button onclick="javascript:hideMainMenu(); submitbutton(\'files\')" class="buttonfiles" style="vertical-align:middle"><span>Files </span></button>';
        $tabsummary = '<button onclick="javascript:hideMainMenu(); submitbutton(\'summary\')" class="buttonfiles" style="vertical-align:middle"><span>Summary </span></button>';

	JToolBarHelper::title( JText::_( 'ECO_MANAGEMET' ) . ': <small><small>[ '. JText::_( 'Affected' ).' ]</small></small>'.$tabsummary.$tabfiles , 'generic.png' );	
	//JToolBarHelper::customX('export_detail', 'excel', '', 'Export', false);

     //   JToolBarHelper::customX("summary", 'summary', '', 'Summary', false);
    //    JToolBarHelper::customX("files", 'files', '', 'Files', false);
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
		if (pressbutton == 'summary') {
				 window.location.assign("index.php?option=com_apdmeco&task=detail&cid[]=<?php echo $this->row->eco_id?>")
				return;
			}
		if (pressbutton == 'files') {
			  window.location.assign("index.php?option=com_apdmeco&task=files&cid[]=<?php echo $this->row->eco_id?>");
			return;
		}                         
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&]", "i");	
	}
</script>
<style>
        .buttonfiles {
  display: inline-block;
  border-radius: 4px;
  background-color: #f49542;
  border: none;
  color: white;
  text-align: center;
  font-size: 16px;
  padding: 10px 32px;
  width: 120px;
  transition: all 0.5s;
  cursor: pointer;
  margin-left: 30px;
}

.buttonaffected {
  display: inline-block;
  border-radius: 4px;
  background-color: #f49542;
  border: none;
  color: white;
  text-align: center;
  font-size: 16px;
  padding: 10px 32px;
  width: 180px;
  transition: all 0.5s;
  cursor: pointer;
  margin-left: 30px;
}
</style>
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data" >
	<div class="col">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Affected' ); ?></legend>
			<table class="admintable" width="100%">
				<?php if (count($this->arr_affected) > 0 ) { ?>
					<tr>
						<td colspan="2">
						<table width="100%"  class="adminlist" cellpadding="1">						
						<thead>
							<th colspan="15"><?php echo JText::_('Affected Parts ')?></th>
						</thead>
						<tr>
							<td width="5%"><strong><?php echo JText::_('No.')?></strong></td>
							<td width="45%"><strong><?php echo JText::_('Description')?> </strong></td>
							<td width="30%"><strong><?php echo JText::_('Project')?> </strong></td>
							<td width="20%"><strong><?php echo JText::_('Status')?>  </strong></td>
                                                        <td width="20%"><strong><?php echo JText::_('ECO type')?>  </strong></td>
                                                        <td width="20%"><strong><?php echo JText::_('Field Impact')?>  </strong></td>
                                                        <td width="20%"><strong><?php echo JText::_('Reason for Change')?>  </strong></td>
                                                        <td width="20%"><strong><?php echo JText::_('What is Changing')?>  </strong></td>
                                                        <td width="20%"><strong><?php echo JText::_('Special Instructions')?>  </strong></td>
                                                        <td width="20%"><strong><?php echo JText::_('Benifit to Customer')?>  </strong></td>
                                                        <td width="20%"><strong><?php echo JText::_('Technical Actions	')?>  </strong></td>
                                                        <td width="20%"><strong><?php echo JText::_('Estimated One-Time Cost')?>  </strong></td>
                                                        <td width="20%"><strong><?php echo JText::_('Activate')?>  </strong></td>
                                                        <td width="20%"><strong><?php echo JText::_('Date Modified')?>  </strong></td>
                                                        <td width="20%"><strong><?php echo JText::_('Modified By')?>  </strong></td>
                                                        
                                                        
						</tr>
						<?php $i = 1; 
					foreach ($this->arr_affected as $aff) { 
											?>
							<tr>
							<td><?php echo $i?></td>
							<td><?php echo $aff->eco_description;?></td>
							<td><?php echo $aff->eco_project;?></td>
                                                        <td><?php echo $aff->eco_status;?></td>
                                                        <td><?php echo $aff->eco_type;?></td>
                                                        <td><?php echo $aff->eco_field_impact;?></td>
							<td><?php echo $aff->eco_reason;?></td>
							<td><?php echo $aff->eco_what;?></td>
                                                        <td><?php echo $aff->eco_special;?></td>
                                                        <td><?php echo $aff->eco_benefit;?></td>
                                                        <td><?php echo $aff->eco_technical;?></td>
							<td><?php echo $aff->eco_estimated;?></td>
							<td><?php echo $aff->eco_activate;?></td>
                                                        <td><?php echo JHTML::_('date', $aff->eco_modified, '%Y-%m-%d %H:%M:%S');?></td>
                                                        <td><?php echo GetValueUser($aff->eco_modified_by, 'name');?></td>                                                     
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

	</div>
	
	<div class="clr"></div>

	<input type="hidden" name="eco_id" value="<?php echo $this->row->eco_id?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->row->eco_id?>" />
	<input type="hidden" name="option" value="com_apdmeco" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="1" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
