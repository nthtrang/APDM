<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	$role = JAdministrator::RoleOnComponent(6);
	JToolBarHelper::title( JText::_( 'MULTI_UPLOADS' ) , 'multi_upload.png' );
	//JToolBarHelper::customX('multi_upload', 'upload', '', 'Continue', false);
	JToolBarHelper::cancel( 'cancel', 'Cancel' );

	$cparams = JComponentHelper::getParams ('com_media');
?>

<?php
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );


?>

<form action="index.php?option=com_apdmpns" method="post" name="adminForm">
<div class="col width-50 center">
		<fieldset class="adminform">
			<p class="textupload"><strong><?php echo JText::_('You have upload successfull.')?></strong></p>
			
		</fieldset>
</div>
<input type="hidden" name="task" value="" />
</form>