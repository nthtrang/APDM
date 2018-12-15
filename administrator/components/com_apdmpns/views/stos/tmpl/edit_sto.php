<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php	
//poup add rev roll
	$edit		= JRequest::getVar('edit',true);
        $sto_type		= JRequest::getVar('sto_type');
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
        if($this->sto_row->sto_type==1)
                JToolBarHelper::title("Edit ITO ".$this->sto_row->sto_code, 'cpanel.png');
        else
                JToolBarHelper::title("Edit ETO ".$this->sto_row->sto_code, 'cpanel.png');
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

        $role = JAdministrator::RoleOnComponent(7);      
?>

<form action="index.php?option=com_apdmpns&task=save_editsto&time=<?php echo time();?>" method="post" name="adminForm" enctype="multipart/form-data" >
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
							<?php echo $this->sto_row->sto_type==1?JText::_( 'ITO Number' ):JText::_( 'ETO Number' ); ?>
						</label>
					</td>
					<td>
						<input type="text"  name="sto_code" id="sto_code" readonly size="60" value="<?php echo $this->sto_row->sto_code;?>"/>						
					</td>
				</tr>                       
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Description' ); ?>
						</label>
					</td>
					<td>						
						<textarea name="sto_description" rows="10" cols="60"><?php echo $this->sto_row->sto_description?></textarea>
					</td>
				</tr>             
                               <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Owner' ); ?>
						</label>
					</td>
                                 <td>
                                                                <select name="sto_owner" id="sto_owner" >
                                                                        <option value="">Select Owner</option>
                                        <?php 
                                                
                                                foreach ($this->list_user as $list) { 
                                                $selected="";
                                                if($list->id==$this->sto_row->sto_owner)
                                                        $selected ="selected";
                                                ?>
                                                  <option value="<?php echo $list->id; ?>" <?php echo $selected;?>><?php echo $list->name; ?></option>
                                                <?php } ?>
                                                                </select>
                                                        </td>
                                 </tr>
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Attached' ); ?>
						</label>                                                
					</td>
					<td>						
						 <input type="file" name="sto_file" /><br/>
                                                 <font color="#FF0000"><em><?php echo JText::_('(Please upload file less than 20Mb)')?></em></font>
					</td>
				</tr>				
			</table>
	


	<input type="hidden" name="sto_id" value="<?php echo $this->sto_row->pns_sto_id;?>" />	
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="return" value="pomanagement"  />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
