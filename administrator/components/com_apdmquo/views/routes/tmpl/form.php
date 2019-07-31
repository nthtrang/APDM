<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>


<?php
	$cid = JRequest::getVar('cid', array(0));
$edit = JRequest::getVar('edit', true);
$text = intval($edit) ? JText::_('Edit') : JText::_('New');
$demote = $promote = "";
$me = & JFactory::getUser();
$row = $this->row;

JToolBarHelper::title( JText::_($row[0]->name));
JToolBarHelper::apply('update_routes_quo', 'Save');

if ($edit) {
        // for existing items the button is renamed `close`
        JToolBarHelper::cancel('cancel', 'Close');
} else {
        JToolBarHelper::cancel();
}

$cparams = JComponentHelper::getParams('com_media');
$editor = &JFactory::getEditor();
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
		submitform( pressbutton );
	}


</script>

<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data" >
	<div class="col width-50">
		<table class="admintable" cellspacing="1">
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Name' ); ?>
						</label>
					</td>
					<td>
						<input type="text"  name="name" id="name"  size="10" value="<?php echo $row[0]->name;?>"/>						
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Description' ); ?>
						</label>
					</td>
					<td>
                                               <textarea name="description" rows="5" cols="30"><?php echo $row[0]->description?></textarea>
						
					</td>
				</tr>
				
				
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Due date' ); ?>
						</label>
					</td>
					<td>
                                        <?php //echo JHTML::_('calendar', $this->lists['pns_datein'], 'pns_datein', 'pns_datein', '%m-%d-%Y %H:%M:%S', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	
					<?php echo JHTML::_('calendar', $row[0]->due_date, 'due_date', 'due_date', '%Y-%m-%d %H:%M:%S', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	
					</td>
				</tr>
			</table>
	</div>
	
	<div class="clr"></div>
<div style="display:none"><?php
						// parameters : areaname, content, width, height, cols, rows
echo $editor->display( 'text',  $row->text , '10%', '10', '10', '3' ) ;
?></div>
        <input type="hidden" name="route_id" value="<?php echo  $row[0]->id?>" />
	<input type="hidden" name="quo_id" value="<?php echo  $row[0]->quotation_id?>" />
	<input type="hidden" name="cid[]" value="<?php echo  $row[0]->quotation_id?>" />
	<input type="hidden" name="option" value="com_apdmquo" />
	<input type="hidden" name="task" value="" />	
        <input type="hidden" name="id" value="" />	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
