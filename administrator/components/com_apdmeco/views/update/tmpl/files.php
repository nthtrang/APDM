<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$role = JAdministrator::RoleOnComponent(5);	
	$tabsummary = '<button onclick="javascript:hideMainMenu(); submitbutton(\'summary\')" class="buttonfiles" style="vertical-align:middle"><span>Summary </span></button>';
        $tabaffected  = '<button onclick="javascript:hideMainMenu(); submitbutton(\'affected\')" class="buttonaffected" style="vertical-align:middle"><span>Affected Parts </span></button>';

	JToolBarHelper::title( JText::_( 'ECO_MANAGEMET' ) . ': <small><small>[ '. JText::_( 'Files' ).' ]</small></small>'.$tabsummary.$tabaffected , 'generic.png' );	
	//JToolBarHelper::customX('export_detail', 'excel', '', 'Export', false);
	if (in_array("E", $role)) {
		//JToolBarHelper::editListX();
	}
	if (in_array("W", $role)) {
	//	JToolBarHelper::addNewX();
	}
       // JToolBarHelper::customX("summary", 'summary', '', 'Summary', false);
       // JToolBarHelper::customX("affected", 'affected', '', 'Affected Parts', false);
                
	JToolBarHelper::cancel( 'cancel', 'Close' );

	$cparams = JComponentHelper::getParams ('com_media');
?>

<?php
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	
?>
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
		if (pressbutton == 'summary') {
				 window.location.assign("index.php?option=com_apdmeco&task=detail&cid[]=<?php echo $this->row->eco_id?>")
				return;
			}
		if (pressbutton == 'affected') {
			  window.location.assign("index.php?option=com_apdmeco&task=affected&cid[]=<?php echo $this->row->eco_id?>");
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
	<div class="col width-100">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Files' ); ?></legend>
			<table class="admintable" width="100%">
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

	</div>
	
	<div class="clr"></div>

	<input type="hidden" name="eco_id" value="<?php echo $this->row->eco_id?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->row->eco_id?>" />
	<input type="hidden" name="option" value="com_apdmeco" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="1" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
