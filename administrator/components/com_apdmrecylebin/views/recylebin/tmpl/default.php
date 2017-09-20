<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	
	JToolBarHelper::title( JText::_( 'RECYLE_BIN_MAMANGEMENT' ) , 'trash.png' );
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
	}

</script>
<form action="index.php" method="post" name="adminForm" >
	<div class="col width-60">
		<?php echo JText::_( 'Recyle Bin: Please select component to see list delete.' ); ?>
	</div>
	
	<div class="clr"></div>	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
