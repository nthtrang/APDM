<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
$cid = JRequest::getVar('cid', array(0));
$edit = JRequest::getVar('edit', true);

JToolBarHelper::title("SO Management", 'cpanel.png');
$role = JAdministrator::RoleOnComponent(7);      
if (in_array("W", $role)) {
        //JToolBarHelper::addNew("add_so","New SO");
        JToolBarHelper::customX('add_so', 'new', '', 'New SO', false);
        JToolBarHelper::addNew("add_wo","New WO");
        
}
$cparams = JComponentHelper::getParams('com_media');
$editor = &JFactory::getEditor();
?>
<?php
// clean item data
JFilterOutput::objectHTMLSafe($user, ENT_QUOTES, '');
?>sss
<script language="javascript" type="text/javascript">
       function submitbutton(pressbutton) {
                var form = document.adminForm;
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
                if (pressbutton == 'add_wo') {
                        submitform( pressbutton );
                        return;
                }
                if (pressbutton == 'add_so') {
                        submitform( pressbutton );
                        return;
                }                
			
        }


</script>
<div class="clr"></div>
<form action="index.php?option=com_apdmpns&task=somanagement"   onsubmit="submitbutton('')"  method="post" name="adminForm" >	
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
<?php if (count($this->pos_list) > 0) { ?>
                <table class="adminlist" cellspacing="1" width="400">
                        <thead>
                                <tr>
                                        <th width="100"><?php echo JText::_('No'); ?></th>                                               
                                        <th width="100"><?php echo JText::_('P.O Number'); ?></th>
                                        <th width="100"><?php echo JText::_('Description'); ?></th>                                                
                                        <th width="100"><?php echo JText::_('Attached'); ?></th>                                        
                                        <th width="100"><?php echo JText::_('Created Date'); ?></th>
                                        <th width="100"><?php echo JText::_('Owner'); ?></th>
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
        foreach ($this->pos_list as $po) {
                $i++;
                ?>
                                        <tr>
                                                <td><?php echo $i+$this->pagination->limitstart;?></td>                                            
                                                <td><a href="index.php?option=com_apdmpns&task=po_detail&id=<?php echo $po->pns_po_id; ?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $po->po_code; ?></a> </td>
                                                <td><?php echo $po->po_description; ?></td>                                                
                                                <td>
                <?php if ($po->po_file) { ?>
                                                                <a href="index.php?option=com_apdmpns&task=download_po&id=<?php echo $po->pns_po_id; ?>" title="<?php echo JText::_('Click here to download') ?>" ><?php echo JText::_('Download') ?></a>&nbsp;&nbsp;
                                                        <?php } ?>
                                                </td>                                                
                                                <td>
                                                        <?php echo JHTML::_('date', $po->po_created, '%m-%d-%Y %H:%M:%S'); ?>
                                                </td>
                                                <td>
                                                        <?php echo GetValueUser($po->po_create_by, "username"); ?>
                                                </td>                                                  
                                                <td><?php if (in_array("E", $role)) {
                                                        ?>
                                                        <a href="index.php?option=com_apdmpns&task=edit_po&id=<?php echo $po->pns_po_id; ?>" title="Click to edit"><?php echo JText::_('Edit') ?></a>
                                                        <?php
                                                }
                                                        ?>                                                        
                                                </td></tr>
                                                <?php }
                                        } ?>
                </tbody>
        </table>		

        <div style="display:none"><?php
                                        echo $editor->display('text', $row->text, '10%', '10', '10', '3');
                                        ?></div>
        <input name="nvdid" value="<?php echo $this->lists['count_vd']; ?>" type="hidden" />
        <input name="nspid" value="<?php echo $this->lists['count_sp']; ?>" type="hidden" />
        <input name="nmfid" value="<?php echo $this->lists['count_mf']; ?>" type="hidden" />
        <input type="hidden" name="pns_id" value="<?php echo $this->row->pns_id; ?>" />
        <input type="hidden" name="cid[]" value="<?php echo $this->row->pns_id; ?>" />	
        <input type="hidden" name="option" value="com_apdmpns" />
        <input type="hidden" name="task" value="pomanagement" />
        <input type="hidden" name="redirect" value="mep" />
        <input type="hidden" name="return" value="<?php echo $this->cd; ?>"  />
<?php echo JHTML::_('form.token'); ?>
</form>
