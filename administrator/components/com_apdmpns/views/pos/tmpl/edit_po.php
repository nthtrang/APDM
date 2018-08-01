<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php	
//poup add rev roll
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
	JToolBarHelper::title("Edit PO ".$this->po_row->po_code, 'cpanel.png');
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

$role = JAdministrator::RoleOnComponent(7);      
?>

<form action="index.php?option=com_apdmpns&task=save_editpo&time=<?php echo time();?>" method="post" name="adminForm" enctype="multipart/form-data" >
         <table  width="100%">
		<tr>
			<td></td>
                        <?php if (in_array("E", $role)) {
                                                        ?>
			<td align="right"><input type="submit" name="btinsersave" value="Save" />
 <?php 
                        }
 ?>
                        </td>	
		</tr>	
</table>
			<table class="admintable" cellspacing="1">
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'P.O Number' ); ?>
						</label>
					</td>
					<td>
						<input type="text"  name="po_code" id="po_code"  size="60" value="<?php echo $this->po_row->po_code;?>"/>						
					</td>
				</tr>                       
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Description' ); ?>
						</label>
					</td>
					<td>						
						<textarea name="po_description" rows="10" cols="60"><?php echo $this->po_row->po_description?></textarea>
					</td>
				</tr>             
                               
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Attached' ); ?>
						</label>                                                
					</td>
					<td>						
						 <input type="file" name="po_file" /><br/>
                                                 <font color="#FF0000"><em><?php echo JText::_('(Please upload file less than 20Mb)')?></em></font>
					</td>
				</tr>				
			</table>
	


	<input type="hidden" name="po_id" value="<?php echo $this->po_row->pns_po_id;?>" />	
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="return" value="pomanagement"  />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
