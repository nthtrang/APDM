<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
$cid = JRequest::getVar('cid', array(0));
$edit = JRequest::getVar('edit', true);

JToolBarHelper::title("Location Code Management", 'cpanel.png');
$role = JAdministrator::RoleOnComponent(9);      
if (in_array("W", $role) || in_array("V", $role)) {
        JToolBarHelper::addLocation("New", $this->row->pns_location_id);
}
if (in_array("D", $role)) {           
		JToolBarHelper::deleteList('Are you sure to remove it(s)?','removepnlocation',"Remove");
}
$cparams = JComponentHelper::getParams('com_media');
$editor = &JFactory::getEditor();
?>
<?php
// clean item data
JFilterOutput::objectHTMLSafe($user, ENT_QUOTES, '');
?>
<script language="javascript" type="text/javascript">
       function submitbutton(pressbutton) {
                var form = document.adminForm;
                if (pressbutton == 'removepnlocation') {
				submitform( pressbutton );
				return;
			}
                if (pressbutton == 'btnSubmit') {
                        var d = document.adminForm;
                        if ( document.adminForm.text_search.value==""){
                                alert("Please input keyword");	
                                d.text_search.focus();
                                return false;				
                        }else{
                                document.adminForm.submit();
                                submitform( pressbutton );
				
                        }
                }
			
        }

function isCheckedBom(isitchecked,id){
       
	if (isitchecked == true){
		document.adminForm.boxchecked.value++;
        }
	else {
		document.adminForm.boxchecked.value--;
   	}
}
</script>
<div class="clr"></div>
<form action="index.php?option=com_apdmpns&task=pomanagement&time=<?php echo time();?>"   onsubmit="submitbutton('')"  method="post" name="adminForm" >	
        <input type="hidden" name="query_exprot" value="<?php echo $this->lists['query'];?>" />
<input type="hidden" name="total_record" value="<?php echo $this->lists['total_record'];?>" />        
<table  width="100%">
		<tr>
			<td colspan="4"  >
				<?php echo JText::_( 'Filter' ); ?>:
                                <?php echo $this->lists['search'];?>
				<input type="text" name="text_search" id="text_search" value="<?php echo $this->lists['search'];?>" class="text_area"  size="40" />&nbsp;&nbsp;<?php echo JText::_('Filter With')?> 				
				&nbsp;&nbsp;
			<button onclick="javascript: return submitbutton(this.form)" name="btnSubmit" id="btnSubmit"><?php echo JText::_( 'Go' ); ?></button>
			<button onclick="document.adminForm.text_search.value='';document.adminForm.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			
		</tr>
					
</table>        
<?php if (count($this->location_list) > 0) { ?>
                <table class="adminlist" cellspacing="1" width="400">
                        <thead>
                                <tr>
                                         <th width="8%">#</th>   
                                        <th width="100"><?php echo JText::_('No'); ?></th>                                               
                                        <th width="100"><?php echo JText::_('Location Code'); ?></th>
                                        <th width="100"><?php echo JText::_('Description'); ?></th>                                                
                                        <th width="100"><?php echo JText::_('Active'); ?></th>                                        
                                        <th width="100"><?php echo JText::_('Created Date'); ?></th>
                                        <th width="100"><?php echo JText::_('Created By'); ?></th>
                                        <th width="100"><?php echo JText::_('Modified Date'); ?></th>
                                        <th width="100"><?php echo JText::_('Modified By'); ?></th>
                                        <th width="100"><?php echo JText::_('Action'); ?></th>
                                </tr>
                        </thead>
<tfoot>
			<tr>
				<td colspan="16">
					<?php  echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>                        
                        <tbody>					
        <?php
        $i = 0;
        foreach ($this->location_list as $loc) {
                $i++;
                ?>
                                        <tr>
                                                <td><input  type="checkbox" id = "location"  onclick="isCheckedBom(this.checked,'<?php echo $loc->pns_location_id;?>');" value="<?php echo $loc->pns_location_id?>" name="cid[]"  /></td>
                                                <td><?php echo $i+$this->pagination->limitstart;?></td>                                            
                                                <td><a href="index.php?option=com_apdmpns&task=edit_location&id=<?php echo $loc->pns_location_id; ?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $loc->location_code; ?></a> </td>
                                                <td><?php echo $loc->location_description; ?></td>                                                
                                               
                                                <td>
                                                        <?php echo $loc->location_status ? '<img src="images/tick.png" width="16" height="16" border="0" alt="" />': '<img src="images/disabled.png" width="16" height="16" border="0" alt="" />'; ?>    
                                                </td>
                                                <td>
                                                        <?php echo JHTML::_('date', $loc->location_created, '%m-%d-%Y %H:%M:%S %p'); ?>
                                                </td>
                                                <td>
                                                        <?php echo GetValueUser($loc->location_created_by, "username"); ?>
                                                </td>      
                                                <td>
                                                        <?php echo JHTML::_('date', $loc->location_updated, '%m-%d-%Y %H:%M:%S %p'); ?>
                                                </td>
                                                <td>
                                                        <?php echo GetValueUser($loc->location_updated_by, "username"); ?>
                                                </td>      
                                                <td><?php if (in_array("E", $role)) {
                                                        ?>
                                                        <a href="index.php?option=com_apdmpns&task=edit_location&id=<?php echo $loc->pns_location_id; ?>" title="Click to edit"><?php echo JText::_('Edit') ?></a>
                                                        <?php
                                                }
                                                        ?>                                                        
                                                </td></tr>
                                                <?php }
                                        } ?>
                </tbody>
        </table>		

        <div style="display:none"><?php
                                 //      echo $editor->display('text', $row->text, '10%', '10', '10', '3');
                                        ?></div>
        <input name="nvdid" value="<?php echo $this->lists['count_vd']; ?>" type="hidden" />
        <input name="nspid" value="<?php echo $this->lists['count_sp']; ?>" type="hidden" />
        <input name="nmfid" value="<?php echo $this->lists['count_mf']; ?>" type="hidden" />
        <input type="hidden" name="pns_id" value="<?php echo $this->row->pns_location_id; ?>" />
        <input type="hidden" name="cid[]" value="<?php echo $this->row->pns_location_id; ?>" />	
        <input type="hidden" name="option" value="com_apdmpns" />
        <input type="hidden" name="task" value="locatecode" />
        <input type="hidden" name="redirect" value="locatecode" />
        <input type="hidden" name="return" value="<?php echo $this->cd; ?>"  />
        <input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_('form.token'); ?>
</form>
