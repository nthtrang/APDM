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
                
                 if (pressbutton == 'search_tool_out') {
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
        
function autoLoadTool(a){
        window.location = "index.php?option=com_apdmtto&task=gettool_tracker_scan&tool_code="+a+"&time=<?php echo time();?>";
}
</script>
<style>
section {
  position: relative;
  padding-top: 30px;
      text-align: center;
    background: #f0f0f0;
    color: #666;
    border-bottom: 1px solid #999;
    border-left: 1px solid #fff;
}
section.positioned {
  position: absolute;
  top:100px;
  left:100px;
  width:800px;
  box-shadow: 0 0 15px #333;
}
.container {
  overflow-y: auto;
  height: 160px;
}
table {
  border-spacing: 0;
  width:100%;
}
td + td {
  border-left:1px solid #eee;
}
td, th {
  border-bottom:1px solid #eee;
  padding: 10px 10px 7px 0px;
}
th {
  height: 0;
  line-height: 0;
  padding-top: 0;
  padding-bottom: 0;
  color: transparent;
  border: none;
  white-space: nowrap;
}
th div{
  position: absolute;
  background: transparent;
     color: #666;
  padding: 10px;
  top: 0;
  line-height: normal;
    border-left: 1px solid #fff;
}
th:first-child div{
  border: none;
}
</style>
<div class="clr"></div>
<form action="index.php"   onsubmit="submitbutton('')"  method="post" name="adminForm" >	
        <input type="hidden" name="query_exprot" value="<?php echo $this->lists['query'];?>" />
<input type="hidden" name="total_record" value="<?php echo $this->lists['total_record'];?>" />
<table class="adminlist1" cellspacing="1" width="400">
        <tr><td align="right">
Scan Tool ID Barcode <input onchange="autoLoadTool(this.value)"  onkeyup="autoLoadTool(this.value)" type="text"  name="tool_code" id="tool_code" value="" >
                </td></tr>
</table>
    <fieldset class="adminform">
        <legend><font style="size:14px"><?php echo JText::_( 'Tools Tracking' ); ?> </font></legend>
        <section class="">
                <div class="col width-100 scroll container">
        <?php if (count($this->ttos_list) > 0) { ?>
                 
               <table class="adminlist1" cellspacing="1" width="400">
                        <thead>
                               <tr class="header">                                   
                                        <th width="100"><?php echo JText::_('NUM'); ?><div style="width:50px;padding:10px 0px 0px 15px"><?php echo JText::_('NUM'); ?></div></th>
                                        <th width="100"><?php echo JText::_('TTO'); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_('TTO'); ?></th>                                        
                                        <th width="100"><?php echo JText::_('Description'); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_('Description'); ?></th>                                                
                                        <th width="100"><?php echo JText::_('State'); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_('State'); ?></div></th>                                        
                                        <th width="100"><?php echo JText::_('Created Date'); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_('Created Date'); ?></th>                                        
                                        <th width="100"><?php echo JText::_('Owner'); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_('Owner'); ?></div></th>
                                        <th width="100"><?php echo JText::_('Created By'); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_('Created By'); ?></th>
                                        <th width="100"><?php echo JText::_('Time Remain'); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_('Time Remain'); ?></th>
                                        <th  class="title" width="100">&nbsp;<div style="width:100px;padding:10px 0px 0px 25px">&nbsp;</div></th>
                                </tr>
                        </thead> 
                        
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
                        </div>
    </fieldset>
<fieldset class="adminform">
<legend><?php echo JText::_( 'Tools History' ); ?></legend>
<table width="80%" border="0">
                        <tr>
                                <td align="right">
                                        Date Out From&nbsp;&nbsp
                                        <?php echo JHTML::_('calendar',$this->date_out_from, 'tto_owner_out_confirm_date_from', 'tto_owner_out_confirm_date_from', '%m/%d/%Y', array('class'=>'inputbox', 'size'=>'10',  'maxlength'=>'10')); ?>	
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        To&nbsp;&nbsp;<?php echo JHTML::_('calendar',$this->date_out_to, 'tto_owner_out_confirm_date_to', 'tto_owner_out_confirm_date_to', '%m/%d/%Y', array('class'=>'inputbox', 'size'=>'10',  'maxlength'=>'10')); ?>	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                                        
                           
                                        <?php echo $this->lists['tto_create_by'];?>
			<?php echo $this->lists['tto_owner_out'];?>
                             <input type="submit"  onclick="submitbutton('search_tool_out')"  name="search_tool_out" value="Go">
                                        <a href="index.php?option=com_apdmtto&amp;task=tto&amp;clean=all"><input type="button" value="Reset"></a></td>
                        </tr>
                </table>
<section class="">
        <div class="col width-100 scroll container">

		
<?php if (count($this->tools) > 0) { ?>
       
                <table class="adminlist1" cellspacing="1" width="400">
                        <thead>
                               <tr class="header">
                                        <th width="100"><?php echo JText::_('NUM'); ?><div style="width:50px;padding:10px 0px 0px 15px"><?php echo JText::_('NUM'); ?></div></th>
                                        <th width="100"><?php echo JText::_('TTO'); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_('TTO'); ?></th>                                        
                                        <th width="100"><?php echo JText::_('Description'); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_('Description'); ?></th>                                                
                                        <th width="100"><?php echo JText::_('State'); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_('State'); ?></div></th>                                        
                                        <th width="100"><?php echo JText::_('Date-Out'); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_('Date-Out'); ?></th>
                                        <th width="100"><?php echo JText::_('Date-In'); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_('Date-In'); ?></th>
                                        <th width="100"><?php echo JText::_('Owner'); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_('Owner'); ?></div></th>
                                        <th width="100"><?php echo JText::_('Created By'); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_('Created By'); ?></th>
                                        <th width="100"><?php echo JText::_('Time Remain'); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_('Time Remain'); ?></th>
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
</div>
</section></fieldset>

        <input type="hidden" name="pns_id" value="<?php echo $this->row->pns_id; ?>" />
        <input type="hidden" name="cid[]" value="<?php echo $this->row->pns_id; ?>" />	
        <input type="hidden" name="option" value="com_apdmtto" />
        <input type="hidden" name="task" value="tto" />
        <input type="hidden" name="redirect" value="tto" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="return" value="<?php echo $this->cd; ?>"  />
<?php echo JHTML::_('form.token'); ?>
</form>