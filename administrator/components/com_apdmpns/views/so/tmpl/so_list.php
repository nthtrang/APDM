<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
$cid = JRequest::getVar('cid', array(0));
$edit = JRequest::getVar('edit', true);
$me = & JFactory::getUser();
JToolBarHelper::title("Sale Order", 'cpanel.png');
$role = JAdministrator::RoleOnComponent(10);
$rolewo = JAdministrator::RoleOnComponent(12);
if (in_array("W", $role)) {     
        JToolBarHelper::customX('add_so', 'new', '', 'New SO', false);
}
if (in_array("W", $rolewo)) {
    JToolBarHelper::addNew("add_wo","New WO");
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
                if (pressbutton == 'add_wo') {
                        submitform( pressbutton );
                        return;
                }
                if (pressbutton == 'add_so') {
                        submitform( pressbutton );
                        return;
                }                
			
        }

       function autoSearchWoF(a){
           var form = document.adminForm;
           setTimeout(function(){
               submitform('getWoScan');
           }, 1);
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

<form action="index.php?option=com_apdmpns&task=somanagement"   onsubmit="submitbutton('')"  method="post" name="adminForm" >
        <input type="hidden" name="query_exprot" value="<?php echo $this->lists['query'];?>" />
<input type="hidden" name="total_record" value="<?php echo $this->lists['total_record'];?>" />        

      <fieldset class="adminform">
		<legend><font style="size:14px"><?php echo JText::_( 'My Task' ); ?> </font></legend>
                <section class="">
                <div class="col width-100 scroll container">
<?php 
if (count($this->so_list) > 0) { ?>
                <table class="adminlist1" cellspacing="1" width="400">
                        <thead>
                               <tr class="header">
                                        <th  width="10"><?php echo JText::_('NUM'); ?><div style="width:10px;padding:10px 0px 0px 10px"><?php echo JText::_('NUM'); ?></div></th>
                                        <th width="120"><?php echo JText::_('SO'); ?><div style="width:120px;padding:10px 0px 0px 15px">SO</div></th>
                                        <th width="100"><?php echo JText::_('WO'); ?><div style="width:100px;padding:10px 0px 0px 10px">WO</div></th>
                                        <th width="100"><?php echo JText::_('Status'); ?><div style="width:100px;padding:10px 0px 0px 10px">Status</div></th>
                                        <th width="100"><?php echo JText::_('PN'); ?><div style="width:100px;padding:10px 0px 0px 10px">PN</div></th>
                                        <th width="120"><?php echo JText::_('Description'); ?><div style="width:120px;padding:10px 0px 0px 30px">Description</div></th>
                                        <th width="20"><?php echo JText::_('Qty'); ?><div style="width:20px;padding:10px 0px 0px 5px">Qty</div></th>
                                        <th width="60"><?php echo JText::_('UOM'); ?><div style="width:60px;padding:10px 0px 0px 8px">UOM</div></th>
                                        <th width="100"><?php echo JText::_('Task'); ?><div style="width:100px;padding:10px 0px 0px 10px">Task</div></th>
                                        <th width="100"><?php echo JText::_('Target Date'); ?><div style="width:100px;padding:10px 0px 0px 10px">Target Date</div></th>
                                        <th width="100"><?php echo JText::_('Remained Time'); ?><div style="width:100px;padding:10px 0px 0px 10px">Remained Time</div></th>
                                        <th width="100"><?php echo JText::_('Assigner'); ?><div style="width:100px;padding:10px 0px 0px 10px">Assigner</div></th>
                                </tr>
                        </thead>                  
                        <tbody>					
        <?php
        $i = 0;
        foreach ($this->so_list as $so) {
                $i++;
                if ($so->pns_cpn == 1)
                        $link = 'index.php?option=com_apdmpns&amp;task=detailmpn&cid[0]=' . $so->pns_id;
                else
                        $link = 'index.php?option=com_apdmpns&amp;task=detail&cid[0]=' . $so->pns_id;
                if ($so->pns_revision) {
                        $pnNumber = $so->ccs_code . '-' . $so->pns_code . '-' . $so->pns_revision;
                } else {
                        $pnNumber = $so->ccs_code . '-' . $so->pns_code;
                }
                $soNumber = $so->so_cuscode;
                if($so->ccs_so_code)
                {
                       $soNumber = $so->ccs_so_code."-".$soNumber;
                }
                $background="";
                $remain_day = $so->wo_remain_date+1;
                if($remain_day<=0)
                {       
                        //$remain_day = 0;
                        if($so->wo_state != 'done' && $so->wo_state != 'cancel')
                        {
                                $background= "style='background-color:#f00;color:#fff'";
                        }
                }
                elseif($remain_day<=3)
                {               
                        if($so->wo_state != 'done' && $so->wo_state != 'cancel')
                        {
                                $background= "style='background-color:#ff0;color:#000'";
                        }
                }                
                ?>
                                        <tr>
                                                <td align="center"><?php echo $i+$this->pagination->limitstart;?></td>                                            
                                                <td align="left"><a href="index.php?option=com_apdmpns&task=so_detail&id=<?php echo $so->pns_so_id; ?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $soNumber; ?></a> </td>
                                                <td align="center"><?php echo '<a href="index.php?option=com_apdmpns&task=wo_detail&id='.$so->pns_wo_id.'" title="'.JText::_('Click to see detail WO').'">'.$so->wo_code.'</a> '; ?></td>     
                                                <td align="left"><?php echo PNsController::getWoStatus($so->wo_state);?></td>
                                                <td align="left"><span class="editlinktip hasTip" title="<?php echo $pnNumber; ?>" >
                                                                                        <a href="<?php echo $link; ?>" title="<?php echo JText::_('Click to see detail PNs'); ?>"><?php echo $pnNumber; ?></a>
                                                </span></td>   
                                                <td align="left"><?php echo $so->pns_description; ?></td>                                                
                                                <td align="center">
                                                <?php echo $so->wo_qty; ?>
                                                </td>     
                                                 <td align="center">
                                                <?php echo $so->pns_uom; ?>
                                                </td> 
                                                <td align="left">
                                                        <?php echo PNsController::getWoStep($so->op_code); 
                                                        if($so->op_failure_report)
                                                 {
                                                         echo '(Failure Report)';
                                                 }
                                                 else
                                                 {
                                                         if($so->op_rework_times==1)
                                                         {
                                                                echo '(1st Rework)';
                                                         }
                                                         elseif($so->op_rework_times==2)
                                                         {
                                                                  echo '(2nd Rework)';
                                                         }
                                                 }
                                                        ?>
                                                </td>
                                                <td align="center"><?php echo JHTML::_('date', $so->op_target_date, JText::_('DATE_FORMAT_LC5')); ?></td>
                                                <td  align="center"<?php echo $background?>><?php echo $remain_day;?></td>
                                                <td align="center">
                                                     <?php echo GetValueUser($so->wo_assigner, "name"); ?>
                                                </td></tr>
                                                <?php }
                                        } ?>
                </tbody>
                </table></div></section>
      </fieldset>

      
<?php 
if (in_array("V", $rolewo) && count($this->report_list) > 0) { ?>
<fieldset class="adminform">
		<legend><font style="size:14px"><?php echo JText::_( 'Issue Report' ); ?> </font></legend>                          
                <section class="">
                <div class="col width-100 scroll container">
                <table class="adminlist1" cellspacing="1" width="400">
                        <thead>
                                 <tr class="header">
                                        <th width="10"><?php echo JText::_('NUM'); ?><div style="width:10px;padding:10px 0px 0px 10px"><?php echo JText::_('NUM'); ?></div></th>
                                        <th width="120"><?php echo JText::_('SO'); ?><div style="width:120px;padding:10px 0px 0px 20px"><?php echo JText::_('SO'); ?></div></th>
                                        <th width="100"><?php echo JText::_('WO'); ?><div style="width:100px;padding:10px 0px 0px 20px"><?php echo JText::_('WO'); ?></div></th>
                                        <th width="100"><?php echo JText::_('Status'); ?><div style="width:100px;padding:10px 0px 0px 20px"><?php echo JText::_('Status'); ?></div></th>
                                        <th width="100"><?php echo JText::_('Step'); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_('Step'); ?></div></th>
                                        <th width="100"><?php echo JText::_('Assignee'); ?><div style="width:100px;padding:10px 0px 0px 20px"><?php echo JText::_('Assignee'); ?></div></th>
                                        <th width="100"><?php echo JText::_('Issue'); ?><div style="width:100px;padding:10px 0px 0px 20px"><?php echo JText::_('Issue'); ?></div></th>
                                        <th width="100"><?php echo JText::_('Remained Times'); ?><div style="width:100px;padding:10px 0px 0px 20px"><?php echo JText::_('Remained Times'); ?></div></th>
                                </tr>
                        </thead>                  
                      <tbody style="height: 300px; overflow-y: auto"> 				
        <?php
        $i = 0;
        foreach ($this->report_list as $so) {
                $i++;              
                $soNumber = $so->so_cuscode;
                if($so->ccs_so_code)
                {
                       $soNumber = $so->ccs_so_code."-".$soNumber;
                }
                $background="";
                $remain_day = $so->wo_remain_date+1;
                if($remain_day<=0)
                {       
                        //$remain_day = 0;
                        if($so->wo_state != 'done' && $so->wo_state != 'cancel')
                        {
                                $background= "style='background-color:#f00;color:#fff'";
                        }
                }
                elseif($remain_day<=3)
                {               
                        if($so->wo_state != 'done' && $so->wo_state != 'cancel')
                        {
                                $background= "style='background-color:#ff0;color:#000'";
                        }
                }       
                ?>
                                        <tr>
                                                <td align="center"><?php echo $i?></td>
                                                <td align="left"><a href="index.php?option=com_apdmpns&task=so_detail&id=<?php echo $so->pns_so_id; ?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $soNumber; ?></a> </td>
                                                <td align="center"><?php echo '<a href="index.php?option=com_apdmpns&task=wo_detail&id='.$so->pns_wo_id.'" title="'.JText::_('Click to see detail WO').'">'.$so->wo_code.'</a> '; ?></td>
                                                <td align="left"><?php echo PNsController::getWoStatus($so->wo_state); ?></td>
                                                <td align="left"><?php echo PNsController::getWoStep($so->op_code); ?></td>
                                                <td align="center"><?php echo GetValueUser($so->op_assigner, "name"); ?></td>
                                                 <td align="center"><?php 
                                                 if($so->op_delay)
                                                         echo '<a href="index.php?option=com_apdmpns&task=wo_detail&id='.$so->pns_wo_id.'" title="'.JText::_('Click to see detail WO').'">Delayed WO</a><br>';
                                                 if($so->op_failure_report)
                                                 {
                                                         echo '<a href="index.php?option=com_apdmpns&task=wo_diary&id='.$so->pns_wo_id.'" title="'.JText::_('Click to see detail WO').'">Failure Report</a>';
                                                 }
                                                 else
                                                 {
                                                         if($so->op_rework_times==1)
                                                         {
                                                                echo '<a href="index.php?option=com_apdmpns&task=wo_detail&id='.$so->pns_wo_id.'" title="'.JText::_('Click to see detail WO').'">1st Rework</a>';
                                                         }
                                                         elseif($so->op_rework_times==2)
                                                         {
                                                                  echo '<a href="index.php?option=com_apdmpns&task=wo_detail&id='.$so->pns_wo_id.'" title="'.JText::_('Click to see detail WO').'">2nd Rework</a>';
                                                         }
                                                 }
                                                 ?></td>
                                                <td  align="center"<?php echo $background?>><?php echo $remain_day;?></td>
                                                </tr>
                                                <?php }
                                                ?>
                                                 </tbody>
                                        </table></div></section>
                                      </fieldset>
                                                <?php
                                        } ?>
               
                
<?php 
if (in_array("V", $rolewo) && count($this->so_progress) > 0) { ?>
<fieldset class="adminform">
		<legend><font style="size:14px"><?php echo JText::_( 'SO Progress' ); ?> </font></legend>                          
                <section class="">
                <div class="col width-100 scroll container">
                <table class="adminlist1" cellspacing="1" width="100%">
                        <thead>
                                 <tr class="header">
                                        <th width="10"><?php echo JText::_('NUM'); ?><div style="width:10px;padding:10px 0px 0px 10px"><?php echo JText::_('NUM'); ?></div></th>
                                        <th width="120"><?php echo JText::_('SO'); ?><div style="width:120px;padding:10px 0px 0px 20px"><?php echo JText::_('SO'); ?></div></th>
                                        <th width="100"><?php echo JText::_('Customer'); ?><div style="width:100px;padding:10px 0px 0px 20px"><?php echo JText::_('Customer'); ?></div></th>
                                        <th width="100"><?php echo JText::_('Status'); ?><div style="width:100px;padding:10px 0px 0px 20px"><?php echo JText::_('Status'); ?></div></th>
                                        <th width="100"><?php echo JText::_('TOP ASSY PN'); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_('TOP ASSY PN'); ?></div></th>
                                        <th width="100"><?php echo JText::_('Order Qty'); ?><div style="width:100px;padding:10px 0px 0px 20px"><?php echo JText::_('Order Qty'); ?></div></th>
                                        <th width="100"><?php echo JText::_('Production Qty'); ?><div style="width:100px;padding:10px 0px 0px 20px"><?php echo JText::_('Production Qty'); ?></div></th>
                                        <th width="100"><?php echo JText::_('Shipped Qty'); ?><div style="width:100px;padding:10px 0px 0px 20px"><?php echo JText::_('Shipped Qty'); ?></div></th>
                                        <th width="100"><?php echo JText::_('Remained Times'); ?><div style="width:100px;padding:10px 0px 0px 20px"><?php echo JText::_('Remained Times'); ?></div></th>                                                                                
                                </tr>
                        </thead>                  
                      <tbody style="height: 300px; overflow-y: auto"> 				
        <?php
        $i = 0;
        foreach ($this->so_progress as $so) {
                $i++;              
                $soNumber = $so->so_cuscode;
                if($so->ccs_so_code)
                {
                       $soNumber = $so->ccs_so_code."-".$soNumber;
                } 
                 $background="";
                $remain_day = $so->so_remain_date+1;
                if($remain_day<=0)
                {       
                        //$remain_day = 0;
                        if($so->so_state != 'done' && $so->so_state != 'cancel')
                        {
                                $background= "style='background-color:#f00;color:#fff'";
                        }
                }
                elseif($remain_day<=3)
                {               
                        if($so->so_state != 'done' && $so->so_state != 'cancel')
                        {
                                $background= "style='background-color:#ff0;color:#000'";
                        }
                } 
                ?>
                                        <tr>
                                                <td align="center"><?php echo $i?></td>
                                                <td align="left"><a href="index.php?option=com_apdmpns&task=so_detail&id=<?php echo $so->pns_so_id; ?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $soNumber; ?></a> </td>
                                                <td align="center"><?php echo $so->ccs_name; ?></td>
                                                <td align="left">
                                                <?php
                                          $arrStatus = $this->arr_status;
                                          echo strtoupper($arrStatus[$so->so_state]);
                                      ?>
                                                </td>
                                                <td align="left">
                                                        <table class="adminlist1" cellspacing="1" width="200">
                                                                <?php 
                                                                $pnTopInfo = PNsController::getTopAssysSo($so->pns_so_id);
                                                                $i=1;
                                                                if (count($pnTopInfo) > 0) {
                                                                        foreach($pnTopInfo as $top )
                                                                        {
                                                                                $style="style='border-bottom:1px solid #eee;'";
                                                                               if($i==count($pnTopInfo))
                                                                                      $style ="style='border-bottom:none'";
                                                                               
                                                                        if ($top->pns_cpn == 1)
                                                                                $link = 'index.php?option=com_apdmpns&amp;task=detailmpn&cid[0]=' . $top->pns_id;
                                                                        else
                                                                                $link = 'index.php?option=com_apdmpns&amp;task=detail&cid[0]=' . $top->pns_id;                                                                
                                                                        if ($top->pns_revision) {
                                                                                $pnNumber = $top->ccs_code . '-' . $top->pns_code . '-' . $top->pns_revision;
                                                                        } else {
                                                                                $pnNumber = $top->ccs_code . '-' . $top->pns_code;
                                                                        }
                                                                                ?>
                                                                        <tr>
                                                                                <td align="center" <?php echo $style;?>>
                                                                                                <a href="<?php echo $link; ?>" title="<?php echo JText::_('Click to see detail PNs'); ?>"><?php echo $pnNumber; ?></a>
                                                                                        </td>
                                                                        </tr>
                                                                        <?php 
                                                                        $i++;
                                                                        }
                                                                        
                                                                }
                                                                        ?>
                                                                <tr></tr>
                                                        </table>
                                                </td>
                                                <td align="center">
                                                         <table class="adminlist1" cellspacing="1" width="200">
                                                                <?php 
                                                                if (count($pnTopInfo) > 0) {
                                                                        $a=1;
                                                                        foreach($pnTopInfo as $top )
                                                                        {
                                                                               $style="style='border-bottom:1px solid #eee;'";
                                                                               if($a==count($pnTopInfo))
                                                                                      $style ="style='border-bottom:none'";


                                                                        if ($top->pns_cpn == 1)
                                                                                $link = 'index.php?option=com_apdmpns&amp;task=detailmpn&cid[0]=' . $top->pns_id;
                                                                        else
                                                                                $link = 'index.php?option=com_apdmpns&amp;task=detail&cid[0]=' . $top->pns_id;                                                                
                                                                        if ($top->pns_revision) {
                                                                                $pnNumber = $top->ccs_code . '-' . $top->pns_code . '-' . $top->pns_revision;
                                                                        } else {
                                                                                $pnNumber = $top->ccs_code . '-' . $top->pns_code;
                                                                        }
                                                                                ?>
                                                                        <tr>
                                                                                <td align="center" <?php echo $style;?>><?php echo $topSysQty=$top->qty;?></td>
                                                                        </tr>
                                                                        <?php 
                                                                        $a++;
                                                                        }
                                                                        
                                                                }
                                                                ?>
                                                                <tr></tr>
                                                        </table>
                                                </td>
                                                <td  align="center"> 
                                                        <table class="adminlist1" cellspacing="1" width="200">
                                                                <?php                                                                 
                                                                if (count($pnTopInfo) > 0) {
                                                                        $i=1;
                                                                        foreach($pnTopInfo as $top )
                                                                        {
                                                                                $style="style='border-bottom:1px solid #eee;'";
                                                                                if($i==count($pnTopInfo))
                                                                                    $style ="style='border-bottom:none'";
                                                                                     
                                                                                
                                                                                ?>
                                                                        <tr>
                                                                                <td align="center" <?php echo $style;?>><?php echo PNsController::getQtyTopAssysDone($top->pns_id,$so->pns_so_id)."/".$topSysQty;?></td>
                                                                        </tr>
                                                                        <?php 
                                                                        $i++;  
                                                                        }
                                                                }
                                                                ?>
                                                                <tr></tr>
                                                        </table></td>
                                                        <td  align="center">
                                                        <table class="adminlist1" cellspacing="1" width="200">
                                                                <?php 
                                                                if (count($pnTopInfo) > 0) {
                                                                        $j=1;
                                                                        foreach($pnTopInfo as $top )
                                                                        {
                                                                                $style="style='border-bottom:1px solid #eee;'";
                                                                                if($j==count($pnTopInfo))
                                                                                    $style ="style='border-bottom:none'";
                                                                                                                                                 
                                                                                ?>
                                                                        <tr>
                                                                                <td align="center" <?php echo $style;?>><?php echo PNsController::getQtyTopAssysShipped($top->pns_id,$so->pns_so_id)."/".$topSysQty;?></td>
                                                                        </tr>
                                                                        <?php 
                                                                        $j++;       
                                                                        }
                                                                }
                                                                        ?>
                                                                <tr></tr>
                                                        </table></td>
                                                 <td  align="center"<?php echo $background?>><?php echo $remain_day;?></td>
                                                </tr>
                                                <?php }
                                                ?>
                                                 </tbody>
                                        </table></div></section>
                                      </fieldset>
                                                <?php
                                        } ?>
        <input type="hidden" name="option" value="com_apdmpns" />
        <input type="hidden" name="task" value="somanagement" />
        <input type="hidden" name="redirect" value="mep" />
        <input type="hidden" name="return" value="<?php echo $this->cd; ?>"  />
        <input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
<?php echo JHTML::_('form.token'); ?>
</form>
