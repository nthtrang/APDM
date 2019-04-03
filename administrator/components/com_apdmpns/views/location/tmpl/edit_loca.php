<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php	
//poup add rev roll
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
	JToolBarHelper::title("Edit Location Code ".$this->location_row->location_code, 'cpanel.png');
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

$role = JAdministrator::RoleOnComponent(7);      
?>

<form action="index.php?option=com_apdmpns&task=save_editloca&time=<?php echo time();?>" method="post" name="adminForm" enctype="multipart/form-data" >
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
        <div class="col width-60">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Code Location Detail' ); ?></legend>
			<table class="admintable" cellspacing="1">
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Location Code' ); ?>
						</label>
					</td>
					<td>
						<input type="text"  name="location_code" id="location_code"  size="60" value="<?php echo $this->location_row->location_code;?>"/>						
					</td>
				</tr>                       
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Description' ); ?>
						</label>
					</td>
					<td>						
						<textarea name="location_description" rows="10" cols="60"><?php echo $this->location_row->location_description?></textarea>
					</td>
				</tr>  
                                 <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Status' ); ?>
						</label>
					</td><td>
                               <?php 
                               
                               $status_arr = array();
                                                        $status_arr[] = JHTML::_('select.option', '1', JText::_('Yes'), 'value', 'text');
                                                        $status_arr[] = JHTML::_('select.option', '0', JText::_('No'), 'value', 'text');                                                        
                                 echo JHTML::_('select.genericlist', $status_arr, 'location_status', 'class="inputbox" size="1" ', 'value', 'text',$this->location_row->location_status );
                                ?>
                               </td>
                                </tr>  	
			</table>
                </fieldset>
        </div>
        <div class="col width-40">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Parameters' ); ?></legend>
                <table class="admintable" cellspacing="1">
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Created Date' ); ?>
						</label>
					</td>
					<td>
                                                <?php echo JHTML::_('date', $this->location_row->location_created, JText::_('DATE_FORMAT_LC6')); ?>
					</td>
				</tr>   
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Created By' ); ?>
						</label>
					</td>
					<td>
                                                <?php echo GetValueUser($this->location_row->location_created_by, "username"); ?>
					</td>
				</tr>   
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Modified Date' ); ?>
						</label>
					</td>
					<td>
                                                <?php echo JHTML::_('date', $this->location_row->location_updated, JText::_('DATE_FORMAT_LC6')); ?>
					</td>
				</tr>   
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Modified By' ); ?>
						</label>
					</td>
					<td>
                                                <?php echo GetValueUser($this->location_row->location_updated_by, "username"); ?>
					</td>
				</tr>                                   
                                </table>
                </fieldset>
        </div>

	<input type="hidden" name="pns_location_id" value="<?php echo $this->location_row->pns_location_id;?>" />	
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="return" value="locatecode"  />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
