<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	$role = JAdministrator::RoleOnComponent(6);
	JToolBarHelper::title( JText::_( 'MULTI_UPLOADS' ) , 'multi_upload.png' );
	JToolBarHelper::customX('next_upload', 'forward', '', 'Next', true);
	JToolBarHelper::cancel( 'cancel', 'Cancel' );

	$cparams = JComponentHelper::getParams ('com_media');
?>

<?php
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	
?>
<script language="javascript">
function submitbutton(pressbutton) {
//alert(pressbutton);
			var form = document.adminForm;
			if (pressbutton == 'next_upload') {
				submitform( pressbutton );
				return;
			}
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}
			
			
		}

</script>
<form action="index.php?option=com_apdmpns" method="post" name="adminForm" >
<div class="col width-50 center">
		<fieldset class="adminform">
			<p class="textupload"><strong><?php echo JText::_('Please choose file to upload')?></strong></p>
			<p class="textupload">
				<input type="radio" value="1" name="type_upload" onclick="isChecked(this.checked);" /><label> CAD Files</label>
				<input type="radio" value="2" name="type_upload" onclick="isChecked(this.checked);" /><label> PDF Files</label>
				
			</p>
		</fieldset>
</div>
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="task" value="next_upload" />
<input type="hidden" name="bt_next" value="next_upload" />
<input type="hidden" name="pns_id" value="<?php echo $this->list_pns_get;?>"
</form>
