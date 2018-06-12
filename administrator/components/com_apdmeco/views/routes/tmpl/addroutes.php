<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
addroutes
<?php	
//poup add routes
$me = & JFactory::getUser();
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
        $row = $this->rows;
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	//ToolBarHelper::apply('apply', 'Save');  
?>
<script language="javascript" type="text/javascript">
function UpdateRoutesWindow(){   
        window.parent.document.getElementById('sbox-window').close();	
        window.parent.location.reload();
}

</script>

<form action="index.php?option=com_apdmeco&task=save_routes&cid[]=<?php echo $cid[0]?>" method="post" name="adminFormSaveRoutes" enctype="multipart/form-data" >
         <table  width="100%">
		<tr>
			<td></td>
			<tr align="right">
			<td align="right">
                                <input type="submit" name="btinsersave" value="Save Route"  onclick="UpdateRoutesWindow();"/>
                        </td>	
		</tr>
		</tr>			
</table>
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
	


	<input type="text" name="eco_id" value="<?php echo $cid[0];?>" />	
	<input type="hidden" name="option" value="com_apdmeco" />
	<input type="hidden" name="return" value="routes"  />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
