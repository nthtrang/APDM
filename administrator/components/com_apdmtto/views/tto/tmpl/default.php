<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
$cid = JRequest::getVar('cid', array(0));
$edit = JRequest::getVar('edit', true);

//JToolBarHelper::title("STOCK Management", 'cpanel.png');
$role = JAdministrator::RoleOnComponent(8);      
if (in_array("W", $role)) {
      //  JToolBarHelper::addNewito("New ITO", $this->row->pns_id);
        JToolBarHelper::customX('addtto', 'new', '', 'Tool', false);        
        //JToolBarHelper::customX('addeto', 'new', '', 'New ETO', false);
        //JToolBarHelper::addNeweto("New ETO", $this->row->pns_id);
        
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
                
                 if (pressbutton == 'search_qty') {
                        submitform( pressbutton );
                        return;
                }
                if (pressbutton == 'removestos') {
                        submitform( pressbutton );
                        return;
                }
                if (pressbutton == 'addtto') {
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
<?php if (count($this->ttos_list) > 0) { ?>
                <table class="adminlist" cellspacing="1" width="400">
                         <thead>
                               <tr class="header">
                                        <th  class="title" width="50"><?php echo JText::_('NUM'); ?></th>
                                        <th  class="title" width="100"><?php echo JText::_('ITO/ETO'); ?></th>
                                        <th  class="title" width="100"><?php echo JText::_('Description'); ?></th>
                                        <th  class="title" width="100"><?php echo JText::_('State'); ?></th>
                                        <th  class="title" width="100"><?php echo JText::_('Created Date'); ?></th>
                                        <th  class="title" width="100"><?php echo JText::_('Owner'); ?></th>
                                        <th  class="title" width="100"><?php echo JText::_('Created By'); ?></th>
                                        <th  class="title" width="100"><?php echo JText::_('Time Remain'); ?></th>
                                        <th  class="title" width="100"></th>
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
        foreach ($this->ttos_list as $tto) {
                $i++;
                ?>
                                        <tr>
                                                <td align="center"><?php echo $i+$this->pagination->limitstart;?></td>
                                                <td align="center">
                                                        <?php
                                                                $style="";
                                                                $link = "index.php?option=com_apdmtto&task=tto_detail&id=".$tto->pns_tto_id;
                                                                $linkdelete = "index.php?option=com_apdmtto&task=deletetto&id=".$tto->pns_tto_id."&tto_type=".$tto->tto_type;                                                         
                                                                $background="";
                                                                $remain_day = $tto->tto_remain;
                                                                if($remain_day<=0)
                                                                {       
                                                                        //$remain_day = 0;
                                                                        $background= "style='background-color:#f00;color:#fff'";                                                                        
                                                                }
                                                                elseif($remain_day<=3)
                                                                {
                                                                        $background= "style='background-color:#ff0;color:#000'";   
                                                                }                                                              
                                                                
                                                                ?>
                                                        <a style="<?php echo $style?>" href="<?php echo $link;?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $tto->tto_code; ?></a> </td>
                                                
                                                <td align="left" style="<?php echo $style?>" ><?php echo $tto->tto_description; ?></td>
                                                <td align="center" style="<?php echo $style?>" >
                                                    <?php echo $tto->tto_state; ?>
                                                </td>
                                                <td align="center"  style="<?php echo $style?>" >
                                                        <?php echo JHTML::_('date', $tto->tto_created, '%m-%d-%Y %H:%M:%S'); ?>
                                                </td>
                                                <td align="center"  style="<?php echo $style?>" >
                                                        <?php echo GetValueUser($tto->tto_owner_in, "name"); ?>
                                                </td> 
                                                <td align="center"  style="<?php echo $style?>" >
                                                        <?php echo GetValueUser($tto->tto_create_by, "name"); ?>
                                                </td>
                                                <td align="center"  <?php echo $background;?>> <?php echo $tto->tto_remain; ?></td>
                                                <td align="center"  style="<?php echo $style?>" ><?php if (in_array("E", $role)) {

                                                        ?>
                                                        <a style="<?php echo $style?>"  href="<?php echo $link; ?>" title="Click to edit"><?php echo JText::_('Edit') ?></a>
                                                        <?php
                                                }
                                                        ?>
                                                </td></tr>
                                                <?php }
                                        } ?>
                </tbody>
                </table>
        <input type="hidden" name="pns_id" value="<?php echo $this->row->pns_id; ?>" />
        <input type="hidden" name="cid[]" value="<?php echo $this->row->pns_id; ?>" />	
        <input type="hidden" name="option" value="com_apdmtto" />
        <input type="hidden" name="task" value="tto" />
        <input type="hidden" name="redirect" value="tto" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="return" value="<?php echo $this->cd; ?>"  />
<?php echo JHTML::_('form.token'); ?>
</form>
