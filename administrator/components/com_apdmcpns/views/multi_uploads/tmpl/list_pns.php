<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	$role = JAdministrator::RoleOnComponent(6);
	JToolBarHelper::title( JText::_( 'MULTI_UPLOADS' ) , 'multi_upload.png' );
	if (count( $this->rows ) > 0) {
		if ($this->type_upload==1) $task_next = 'next_upload_step1'; //for cads
		if ($this->type_upload==2) $task_next = 'next_upload_step2'; //for pdf
		JToolBarHelper::customX($task_next, 'forward', '', 'Next', true);
	}
	JToolBarHelper::custom( 'multi_upload', 'back','','Back', false );
	JToolBarHelper::cancel( 'cancel', 'Cancel' );
	

	$cparams = JComponentHelper::getParams ('com_media');
?>

<?php
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );


?>
<script language="javascript">
	function submitbutton(pressbutton) {
			var form = document.adminForm;			
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}
			if (pressbutton == 'multi_upload') {
				submitform( pressbutton );
				return;
			}
			if (pressbutton=='next_upload_step2'){				
				if (form.boxchecked.value >10){
					alert('Please choose less than 10 Pns to upload');
					return false;
				}else{
					submitform( pressbutton );
					return;
				}
			}
			if (pressbutton=='next_upload_step1'){				
				if (form.boxchecked.value >3){
					alert('Please choose less than 3 Pns to upload');
					return false;
				}else{
					submitform( pressbutton );
					return;
				}
			}
		}
</script>
<form action="index.php?option=com_apdmpns" method="post" name="adminForm" enctype="multipart/form-data" >
<input type="hidden" name="form_submit" value="1" />
<div class="col width-50 center">
		<fieldset class="adminform">
			<p><strong><?php echo JText::_('Please choose file to upload')?>:</strong> <input type="file" name="upload_file" /></p>
			
			<table class="adminlist" cellpadding="1">
		<thead>
			<tr>
				<th width="2%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>				
				<th class="title" >
					<?php echo  JText::_('PART_NUMBER_CODE'); ?>
				</th>
							
			</tr>
		</thead>		
		<tbody>
		<?php
			$path_image = '../uploads/pns/images/';
			$k = 0;
			if (count( $this->rows ) > 0)  {
			for ($i=0, $n=count( $this->rows ); $i < $n; $i++)
			{
				$row 	=& $this->rows[$i];
				$link 	= 'index.php?option=com_apdmpns&amp;task=detail&cid[0]='.$row->pns_id;	
				if ($row->pns_revision !='')	{
					$pns_code = CPNsController::GetNameCCs($row->ccs_id).'-'.$row->pns_code.'-'.$row->pns_revision;
				}else{
					$pns_code = CPNsController::GetNameCCs($row->ccs_id).'-'.$row->pns_code;
				}
				if ($row->pns_image !=''){
					$pns_image = $path_image.$row->pns_image;
				}else{
					$pns_image = JText::_('NONE_IMAGE_PNS');
				}
				//echo $pns_image;
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>				
				<td><span class="editlinktip hasTip" title="<img border=&quot;1&quot; src=&quot;<?php echo $pns_image; ?>&quot; name=&quot;imagelib&quot; alt=&quot;<?php echo JText::_( 'No preview available' ); ?>&quot; width=&quot;300&quot; height=&quot;245&quot; />" >
					<?php echo $pns_code;?>
				</span>
				</td>			
				
			</tr>
			<?php
				$k = 1 - $k;
				}
			}
			?>			
		</tbody>
	</table>
		</fieldset>
</div>
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="bt_next" value="next_upload" />
<input type="hidden" name="type_upload" value="<?php echo $this->type_upload?>" />
</form>
