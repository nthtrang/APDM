<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
$cid = JRequest::getVar('cid', array(0));
$edit = JRequest::getVar('edit', true);

JToolBarHelper::title("STOCK Management", 'cpanel.png');
$role = JAdministrator::RoleOnComponent(8);      
if (in_array("W", $role)) {
      //  JToolBarHelper::addNewito("New ITO", $this->row->pns_id);
        JToolBarHelper::customX('addito', 'new', '', 'New ITO', false);        
        JToolBarHelper::customX('addeto', 'new', '', 'New ETO', false);
        //JToolBarHelper::addNeweto("New ETO", $this->row->pns_id);
        
}
if (in_array("S", $role)) {
        JToolBarHelper::addMoveLocation("Move Location", $this->row->pns_id);
}
//if (in_array("D", $role)) {
//        //viet comment
//        JToolBarHelper::deletePns('Are you sure to delete it?',"removestos","Delete STO");
//}
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
                if (pressbutton == 'removestos') {
                        submitform( pressbutton );
                        return;
                }
                if (pressbutton == 'addito') {
                        submitform( pressbutton );
                        return;
                }
                if (pressbutton == 'addeto') {
                        submitform( pressbutton );
                        return;
                }
			
        }
</script>
<div class="clr"></div>
<form action="index.php"   onsubmit="submitbutton('')"  method="post" name="adminForm" >	
        <input type="hidden" name="query_exprot" value="<?php echo $this->lists['query'];?>" />
<input type="hidden" name="total_record" value="<?php echo $this->lists['total_record'];?>" />        
<table  width="100%">
		<tr>
			<td colspan="4"  >
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="text_search" id="text_search" value="<?php echo $this->lists['search'];?>" class="text_area"  size="40" />&nbsp;&nbsp;<?php echo JText::_('Filter With')?> 				
				&nbsp;&nbsp;
			<button onclick="javascript: return submitbutton(this.form)" name="btnSubmit" id="btnSubmit"><?php echo JText::_( 'Go' ); ?></button>
			<button onclick="document.adminForm.text_search.value='';document.adminForm.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			
		</tr>
					
</table>        
<?php if (count($this->stos_list) > 0) { ?>
                <table class="adminlist" cellspacing="1" width="400">
                        <thead>
                                <tr>
                                        <th width="100"><?php echo JText::_('No'); ?></th>         
                                        <th width="3%" class="title">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->stos_list); ?>);" />
                                        </th>                                        
                                        <th width="100"><?php echo JText::_('ITO/ETO'); ?></th>
                                        <th width="100"><?php echo JText::_('Description'); ?></th>
                                        <th width="100"><?php echo JText::_('State'); ?></th>
                                        <th width="100"><?php echo JText::_('Created Date'); ?></th>
                                        <th width="100"><?php echo JText::_('Owner'); ?></th>
                                        <th width="100"><?php echo JText::_('Created By'); ?></th>
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
        foreach ($this->stos_list as $sto) {
                $i++;
                ?>
                                        <tr>
                                                <td><?php echo $i+$this->pagination->limitstart;?></td>                                            
                                                <td>
                                                        <?php echo JHTML::_('grid.id', $i, $sto->pns_sto_id ); ?>
                                                </td>
                                                <td>
                                                        <?php
                                                                $style="";
                                                                $link = "index.php?option=com_apdmsto&task=ito_detail&id=".$sto->pns_sto_id;
                                                                $linkedit = "index.php?option=com_apdmsto&task=editito&id=".$sto->pns_sto_id."&sto_type=".$sto->sto_type;
                                                                if($sto->sto_type==2){
                                                                        $style="color: #f00";
                                                                        $link = "index.php?option=com_apdmsto&task=eto_detail&id=".$sto->pns_sto_id;
                                                                        $linkedit = "index.php?option=com_apdmsto&task=editeto&id=".$sto->pns_sto_id."&sto_type=".$sto->sto_type;
                                                                }elseif($sto->sto_type==3){
                                                                        $link = "index.php?option=com_apdmpns&task=sto_detail_movelocation&id=".$sto->pns_sto_id;
                                                                }
                                                                ?>
                                                        <a style="<?php echo $style?>" href="<?php echo $link;?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $sto->sto_code; ?></a> </td>
                                                
                                                <td style="<?php echo $style?>" ><?php echo $sto->sto_description; ?></td>                                                                                             
                                                <td style="<?php echo $style?>" >
                                                    <?php echo $sto->sto_state; ?>
                                                </td>
                                                <td style="<?php echo $style?>" >
                                                        <?php echo JHTML::_('date', $sto->sto_created, '%m-%d-%Y %H:%M:%S'); ?>
                                                </td>
                                                <td style="<?php echo $style?>" >
                                                        <?php echo GetValueUser($sto->sto_owner, "name"); ?>
                                                </td> 
                                                <td style="<?php echo $style?>" >
                                                        <?php echo GetValueUser($sto->sto_create_by, "name"); ?>
                                                </td>                                                  
                                                <td style="<?php echo $style?>" ><?php if (in_array("E", $role)) {
                                                        
                                                        ?>
                                                        <a style="<?php echo $style?>"  href="<?php echo $linkedit; ?>" title="Click to edit"><?php echo JText::_('Edit') ?></a>
                                                        <?php
                                                }
                                                        ?>                                                        
                                                </td></tr>
                                                <?php }
                                        } ?>
                </tbody>
        </table>		


        <input name="nvdid" value="<?php echo $this->lists['count_vd']; ?>" type="hidden" />
        <input name="nspid" value="<?php echo $this->lists['count_sp']; ?>" type="hidden" />
        <input name="nmfid" value="<?php echo $this->lists['count_mf']; ?>" type="hidden" />
        <input type="hidden" name="pns_id" value="<?php echo $this->row->pns_id; ?>" />
        <input type="hidden" name="cid[]" value="<?php echo $this->row->pns_id; ?>" />	
        <input type="hidden" name="option" value="com_apdmsto" />
        <input type="hidden" name="task" value="sto" />
        <input type="hidden" name="redirect" value="mep" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="return" value="<?php echo $this->cd; ?>"  />
<?php echo JHTML::_('form.token'); ?>
</form>
