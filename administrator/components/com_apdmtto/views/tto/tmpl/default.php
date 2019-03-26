<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
$cid = JRequest::getVar('cid', array(0));
$edit = JRequest::getVar('edit', true);

JToolBarHelper::title("Tools Management", 'cpanel.png');
$role = JAdministrator::RoleOnComponent(11);

if (in_array("W", $role)) {
      //  JToolBarHelper::addNewito("New ITO", $this->row->pns_id);
        JToolBarHelper::customX('addtto', 'new', '', 'Tool', false);
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
    <fieldset class="adminform">
        <legend><font style="size:14px"><?php echo JText::_( 'Tools Tracking' ); ?> </font></legend>
        <?php if (count($this->ttos_list) > 0) { ?>
                <table class="adminlist" cellspacing="1" width="400">
                         <thead>
                               <tr class="header">
                                        <th  class="title" width="50"><?php echo JText::_('NUM'); ?></th>
                                        <th  class="title" width="100"><?php echo JText::_('TTO'); ?></th>
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
                                                        <?php echo GetValueUser($tto->tto_owner_out, "name"); ?>
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
    </fieldset>
        <input type="hidden" name="pns_id" value="<?php echo $this->row->pns_id; ?>" />
        <input type="hidden" name="cid[]" value="<?php echo $this->row->pns_id; ?>" />	
        <input type="hidden" name="option" value="com_apdmtto" />
        <input type="hidden" name="task" value="tto" />
        <input type="hidden" name="redirect" value="tto" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="return" value="<?php echo $this->cd; ?>"  />
<?php echo JHTML::_('form.token'); ?>
</form>
<fieldset class="adminform">
		<legend><?php echo JText::_( 'Tools History' ); ?></legend>
<?php if (count($this->tools) > 0) { ?>
         <div class="col width-100 scroll">
                <table class="adminlist" cellspacing="1" width="400">
                        <thead>
                                <tr>
                                        <th width="100"><?php echo JText::_('NUM'); ?></th>
                                        <th width="100"><?php echo JText::_('TTO'); ?></th>                                        
                                        <th width="100"><?php echo JText::_('Description'); ?></th>                                                
                                        <th width="100"><?php echo JText::_('State'); ?></th>                                        
                                        <th width="100"><?php echo JText::_('Date-Out'); ?></th>
                                        <th width="100"><?php echo JText::_('Date-In'); ?></th>
                                        <th width="100"><?php echo JText::_('Owner'); ?></th>
                                        <th width="100"><?php echo JText::_('Created By'); ?></th>
                                        <th width="100"><?php echo JText::_('Time Remain'); ?></th>
                                </tr>
                        </thead>
                        <tbody>					
        <?php
        $i = 0;
        foreach ($this->tools as $sto) {
                $i++;
            $link = "index.php?option=com_apdmtto&task=tto_detail&id=".$sto->pns_tto_id;
            $background="";
                                                                $remain_day = $sto->tto_remain;
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
                                        <tr>
                                                <td align="center"><?php echo $i; ?></td>
                                                <td align="center"><a href="<?php echo $link; ?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $sto->tto_code; ?></a> </td>
                                                <td align="left"><?php echo $sto->tto_description; ?></td>
                                                <td align="center"><?php echo $sto->tto_state; ?></td>                                                
                                                <td align="center">
                                                        <?php echo ($sto->tto_owner_out_confirm_date!="0000-00-00 00:00:00")?JHTML::_('date', $sto->tto_owner_out_confirm_date, '%m-%d-%Y %H:%M:%S'):""; ?>
                                                </td>
                                                <td align="center">
                                                        <?php echo ($sto->tto_owner_in_confirm_date!="0000-00-00 00:00:00")?JHTML::_('date', $sto->tto_owner_in_confirm_date, '%m-%d-%Y %H:%M:%S'):""; ?>
                                                </td>
                                                
                                                <td align="center">
                                                        <?php echo GetValueUser($sto->tto_owner_out, "name"); ?>
                                                </td> 
                                                <td align="center">
                                                        <?php echo GetValueUser($sto->tto_create_by, "name"); ?>
                                                </td>                                                                                                                                                      
                                              <td align="center"  <?php echo $background;?>> <?php echo $sto->tto_remain; ?></td>
                                        </tr>
                                                <?php }
                                         ?>
                </tbody>
        </table>
         </div>
                 <?php 
                 }
                 ?>

 
</fieldset>
