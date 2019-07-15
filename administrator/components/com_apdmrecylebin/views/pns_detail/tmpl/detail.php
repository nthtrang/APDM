<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	JToolBarHelper::title( JText::_( 'PNS_MAMANGEMENT' ) . ': <small><small>[ '. JText::_('Detail') .' ]</small></small>' , 'cpanel.png' );
	JToolBarHelper::cancel( 'cancel_pns', 'Close' );	
	$cparams = JComponentHelper::getParams ('com_media');
	$editor = &JFactory::getEditor();
?>

<?php
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	
?>
<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel_pns') {
			submitform( pressbutton );
			return;
		}
	}	

</script>

<form action="index.php?option=com_apdmrecylebin&task=pns" method="post" name="adminForm" enctype="multipart/form-data" >
	<div class="col width-60">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'PNs Detail' ); ?></legend>
			<table class="admintable" cellspacing="1">
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'ASCENX_PNS' ); ?>
						</label>
					</td>
					<td><?php echo $this->row->ccs_code.'-'.$this->row->pns_code;?>					
						<?php if ($this->row->pns_revision) echo '-'.$this->row->pns_revision;?>
					</td>
				</tr>				
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_CHILD' ); ?>
						</label>
					</td>
					<td>
						<?php
						if (count($this->arr_parent_code_detail) > 0){
							echo implode("; ", $this->arr_parent_code_detail);
						}else{
						 	echo JText::_('None Child PNs');
						}
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
						<?php echo GetEcoValue($this->row->eco_id);?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Make/Buy' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->lists['pns_type']?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_DESCRIPTION' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->pns_description?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_STATUS' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->pns_type?>
					</td>
				</tr>
				
				
			</table>
		</fieldset>
	</div>
	<div class="col width-40">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Image, Pdf, CAD files' ); ?></legend>
			<table class="admintable">
				<tr>
					<td colspan="2">
						<label for="ccs_create">
							<strong><?php echo JText::_('IMAGE')?></strong>
						</label>
					</td>					
				</tr>
				<?php if ($this->row->pns_image !="") {?>
				<tr>
					<td  align="center" colspan="2">
					<img src="../uploads/pns/images/<?php echo $this->row->pns_image?>" width="200" height="100"  />		
					<br />
					<a href="index.php?option=com_apdmpns&task=download_img&id=<?php echo $this->row->pns_id?>" title="<?php echo JText::_('Click here to download image')?>"><?php echo JText::_('Download Image')?></a>				
					</td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="2">
						<label for="ccs_create">
							<strong><?php echo JText::_('PDF')?></strong>
						</label>
					</td>
				
				</tr>
				<?php if ($this->row->pns_pdf !="") {?>
				<tr>
					<td  align="center" colspan="2"><a href="index.php?option=com_apdmpns&task=download&id=<?php echo $this->row->pns_id?>" title="Click here to download file"><?php echo $this->row->pns_pdf;?>  &nbsp;(<?php  $filesizepdf = RecyleBinController::Readfilesize('pdf', $this->row->pns_pdf); echo number_format($filesizepdf, 0, '.', ' '); ?>&nbsp;KB) </a>					
				
					</td>
				</tr>
				<?php } ?>
				<?php if (count($this->lists['cads_files']) > 0) {
				?>
				<tr>
					<td colspan="2" >
					<table width="100%"  class="adminlist" cellpadding="1">
						<hr />
						<thead>
							<th colspan="4"><?php echo JText::_('List file cads')?></th>
						</thead>
						<tr>
							<td width="5%"><strong><?php echo JText::_('No.')?></strong></td>
							<td width="45%"><strong><?php echo JText::_('Name')?> </strong></td>
							<td width="30%"><strong><?php echo JText::_('Size (KB)')?> </strong></td>
							<td width="20%"><strong><?php echo JText::_('Download')?></strong></td>
						</tr>
				<?php
				
				$i = 1;
				$folder_pns = $this->row->ccs_code.'-'.$this->row->pns_code.'-'.$this->row->pns_revision;
				foreach ($this->lists['cads_files'] as $cad) {
					$filesize = RecyleBinController::Readfilesize('cads', $cad['cad_file'], $this->row->ccs_code, $folder_pns);
				?>
				<tr>
					<td><?php echo $i?></td>
					<td><?php echo $cad['cad_file']?></td>
					<td><?php echo number_format($filesize, 0, '.', ' '); ?></td>
					<td><a href="index.php?option=com_apdmpns&task=download_cad&id=<?php echo $cad['id']?>" title="Click here to download file"><img src="images/download_f2.png" width="20" height="20" /></a></td>
					
				</tr>
				<?php $i++; } ?>
				
				<tr>
					
					<td align="center" colspan="4">
					<a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmpns&task=download_all_cads&tmpl=component&zdir=<?php echo $this->row->ccs_code.'-'.$this->row->pns_code.'-'.$this->row->pns_revision;?>" title="Image">
<input type="button" name="addVendor" value="<?php echo JText::_('Download All Files')?>"/>
</a>
					</td>
										
				</tr>
				
					</table>
					</td>
				</tr>
				<?php } ?>
				
							
			</table>
		</fieldset>		
	</div>
	<div class="clr"></div>
	
	<div class="col width-60">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Vendor' ); ?></legend>
		
		<table class="admintable" cellspacing="1" width="400">
				<thead>
					<tr>
						<th width="50%"><?php echo JText::_( 'Vendor Name' ); ?></th>
						<th><?php echo JText::_( 'Vendor PNs' ); ?></th>
					</tr>
				</thead>
				<tbody >	
					<?php if (count($this->lists['arr_v']) > 0) {
					foreach($this->lists['arr_v'] as $v) {
					 ?>			<tr><td><?php echo $v['v_name']?></td> <td><?php echo $v['v_value'];?></td></tr>
					<?php }
					 } ?>					
				</tbody>
				</table>
		
		
		<?php //if (count($this->lists['arr_v']) > 0) {
				//foreach($this->lists['arr_v'] as $v) {
		 ?>			<!--<p><strong><?php //echo $v['v_name']?> :</strong> <?php //echo $v['v_value'];?></p>-->
		<?php //}
		// } ?>	
		</fieldset>
	</div>
	<div class="clr"></div>
	<div class="col width-60">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Supplier' ); ?></legend>
		<table class="admintable" cellspacing="1" width="400">
				<thead>
					<tr>
						<th width="50%"><?php echo JText::_( 'Supplier Name' ); ?></th>
						<th><?php echo JText::_( 'Supplier PNs' ); ?></th>
					</tr>
				</thead>
				<tbody >	
					<?php if (count($this->lists['arr_s']) > 0) {
								foreach($this->lists['arr_s'] as $s) {
						 ?>			<tr><td><?php echo $s['s_name']?></td><td> <?php echo $s['s_value'];?></td></tr>
						<?php }
						 } ?>				
				</tbody>
				</table>
		
		
		
		<?php //if (count($this->lists['arr_s']) > 0) {
				//foreach($this->lists['arr_s'] as $s) {
		 ?>			<!--<p><strong><?php //echo $s['s_name']?>:</strong> <?php //echo $s['s_value'];?></p>-->
		<?php // }
		// } ?>
		</fieldset>
	</div>
	<div class="clr"></div>
	<div class="col width-60">
	
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Manufacture' ); ?></legend>
		
			<table class="admintable" cellspacing="1" width="400">
				<thead>
					<tr>
						<th width="50%"><?php echo JText::_( 'Manufacture Name' ); ?></th>
						<th><?php echo JText::_( 'Manufacture PNs' ); ?></th>
					</tr>
				</thead>
				<tbody >	
					<?php if (count($this->lists['arr_m']) > 0) {
							foreach($this->lists['arr_m'] as $m) {
					 ?>			<tr><td><?php echo $m['m_name']?></td><td> <?php echo $m['m_value'];?></td></tr>
					<?php }
					 } ?>					
				</tbody>
				</table>
		
		
		<?php //if (count($this->lists['arr_m']) > 0) {
				//foreach($this->lists['arr_m'] as $m) {
		 ?>			<!--<p><strong><?php //echo $m['m_name']?></strong>: <?php //echo $m['m_value'];?></p>-->
		<?php //}
		// } ?>	
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
	<input type="hidden" name="option" value="com_apdmrecylebin" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="return" value="<?php echo $this->cd;?>"  />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
