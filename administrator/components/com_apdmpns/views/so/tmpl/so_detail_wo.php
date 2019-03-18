<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php
//
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
$cid = JRequest::getVar('cid', array(0));
$edit = JRequest::getVar('edit', true);
$soNumber = $this->so_row->so_cuscode;
if($this->so_row->ccs_so_code)
{
       $soNumber = $this->so_row->ccs_so_code."-".$soNumber;
}
JToolBarHelper::title("SO: ".$soNumber, 'cpanel.png');
$role = JAdministrator::RoleOnComponent(10);      
JToolBarHelper::cancelSo("",$this->so_row->pns_so_id);//tmpforload modal
if (in_array("W", $role)  && $this->so_row->so_state !="done") { 
        JToolBarHelper::customX("onholdwo","unpublish",'',"On Hold",true);      
        JToolBarHelper::customX("inprogresswo","restore",'',"In PROGRESS",true);    
        JToolBarHelper::customX("cancelwopop","cancel",'',"Cancel",true); 
        
        //JToolBarHelper::customX("inprogresswo","restore",'',"In PROGRESS",true); 
        //function customX($task = '', $icon = '', $iconOver = '', $alt = '', $listSelect = true)
      //   JToolBarHelper::addWoSo("ADD WO", $this->so_row->pns_so_id);       
         //JToolBarHelper::customX('add_wo', 'new', '', 'NEW WO', false);	
       
}
if (in_array("E", $role) && $this->so_row->so_state =="inprogress") {
       JToolBarHelper::customX('add_wo', 'new', '', 'NEW WO', false); 
        JToolBarHelper::deletePns('Are you sure to delete it?',"removewoso","REMOVE WO");
}
//if (in_array("W", $role) && $this->so_row->so_state =="onhold") {        
//        JToolBarHelper::customX("inprogressso","restore",'',"In PROGRESS",false);     
//        JToolBarHelper::cancelSo("Cancel",$this->so_row->pns_so_id);
//}


$cparams = JComponentHelper::getParams('com_media');
$editor = &JFactory::getEditor();
?>

<?php
// clean item data
JFilterOutput::objectHTMLSafe($user, ENT_QUOTES, '');
?>
<script language="javascript" type="text/javascript">
         
         document.getElementById('toolbar-popup-Popup').style.visibility= 'hidden';
          document.getElementById('toolbar-popup-Popup').style.display= 'none';  
	window.addEvent('domready', function(){ var JTooltips = new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false}); });
		window.addEvent('domready', function() {

			SqueezeBox.initialize({});

			$$('a.modal-button').each(function(el) {
				el.addEvent('click', function(e) {
					new Event(e).stop();
					SqueezeBox.fromElement(el);
				});
			});
		});
        
        function submitbutton(pressbutton) {  
                var form = document.adminForm;      
                if(pressbutton == 'removewoso')
                {                       
                     submitform( pressbutton );
                     return;
                }
                if(pressbutton == 'onholdwo')
                {                       
                    // submitform( pressbutton );
                    var cpn = document.getElementsByName('cid[]');
                        var len = cpn.length;
                        var wo_ids = new Array();
                        var wo = "";
                        for (var i=0; i<len; i++) {
                               // alert(cpn[i].value);
                               if(cpn[i].checked)
                               {
                                  wo_ids.push(cpn[i].value);
                                //  wo += wo + "_";
                               }                                
                        }
                        wo =  wo_ids.join();
                        window.parent.document.getElementById('onholdWO').setAttribute("href", "index.php?option=com_apdmpns&task=onholdwopop&tmpl=component&id="+form.so_id.value+"&wo_ids="+wo );
                        document.getElementById("onholdWO").click(); // Click on the checkbox                   
                        return;
                }
                if(pressbutton == 'inprogresswo')
                {                       
                     // submitform( pressbutton );
                    var cpn = document.getElementsByName('cid[]');
                        var len = cpn.length;
                        var wo_ids = new Array();
                        var wo = "";
                        for (var i=0; i<len; i++) {
                               // alert(cpn[i].value);
                               if(cpn[i].checked)
                               {
                                  wo_ids.push(cpn[i].value);
                                //  wo += wo + "_";
                               }                                
                        }
                        wo =  wo_ids.join();
                        window.parent.document.getElementById('inprogressWO').setAttribute("href", "index.php?option=com_apdmpns&task=inprogresswopop&tmpl=component&id="+form.so_id.value+"&wo_ids="+wo );
                        document.getElementById("inprogressWO").click(); // Click on the checkbox                   
                        return;
                }
                if(pressbutton == 'cancelwopop')
                {
                    var cpn = document.getElementsByName('cid[]');
                        var len = cpn.length;
                        var wo_ids = new Array();
                        var wo = "";
                        for (var i=0; i<len; i++) {
                               // alert(cpn[i].value);
                               if(cpn[i].checked)
                               {
                                  wo_ids.push(cpn[i].value);
                                //  wo += wo + "_";
                               }                                
                        }
                        wo =  wo_ids.join();
                        window.parent.document.getElementById('cancelWO').setAttribute("href", "index.php?option=com_apdmpns&task=informcancelwopop&tmpl=component&id="+form.so_id.value+"&wo_ids="+wo );
                        document.getElementById("cancelWO").click(); // Click on the checkbox                   
                        return;
                }
                if (pressbutton == 'add_wo') {
                        window.location = "index.php?option=com_apdmpns&task=add_wo&so_id="+form.so_id.value;
                        return;
                }                        
        }
        
        	
</script>
<div class="submenu-box">
            <div class="t">
                <div class="t">
                        <div class="t"></div>
                </div>
        </div>
        <div class="m">
		<ul id="submenu" class="configuration">
			<li><a id="detail" href="index.php?option=com_apdmpns&task=so_detail&id=<?php echo $this->so_row->pns_so_id;?>" ><?php echo JText::_( 'Detail' ); ?></a></li>
			<li><a id="bom" class="active"><?php echo JText::_( 'Affected WO' ); ?></a></li>
                        <li><a id="bom" href="index.php?option=com_apdmpns&task=so_detail_support_doc&id=<?php echo $this->so_row->pns_so_id;?>"><?php echo JText::_( 'Supporting Doc' ); ?></a></li>
                        <li><a id="bom" href="index.php?option=com_apdmpns&task=so_detail_wo_history&id=<?php echo $this->so_row->pns_so_id;?>"><?php echo JText::_( 'Status Changing History' ); ?></a></li>
                </ul>
		<div class="clr"></div>
        </div>
        <div class="b">
                <div class="b">
                        <div class="b"></div>
                </div>
        </div>
</div>
<div class="clr"></div>
<p>&nbsp;</p>
<a class="modal-button" id="onholdWO" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmpns&task=onholdwopop&tmpl=component" title="<?php echo JText::_('click here to add more PN')?>"></a>
<a class="modal-button" id="cancelWO" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmpns&task=cancelwopop&tmpl=component" title="<?php echo JText::_('click here to add more PN')?>"></a>
<a class="modal-button" id="inprogressWO" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmpns&task=inprogresswopop&tmpl=component" title="<?php echo JText::_('click here to add more PN')?>"></a>
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data" >      
        <fieldset class="adminform">
		 
        	<div class="col width-100">
		<fieldset class="adminform">		
                <table width="100%" class="adminlist" cellpadding="1">
	<thead>
		<tr>
                        
			<th width="2%" class="title">
					<?php echo JText::_('NUM')?>
			</th>
                        <th width="12%">
				<?php echo JText::_('TOP ASSYS')?>
			</th>
                        <th width="8%">
				<?php echo JText::_('WO')?>
			</th>
                         <th width="12%">
				<?php echo JText::_('PN')?>
			</th>
			<th width="15%">
				<?php echo JText::_('Description')?>
			</th>
			<th width="6%">
				<?php echo JText::_('Qty')?>
			</th>
                        <th width="6%">
				<?php echo JText::_('UOM')?>
			</th>
                        <th width="6%">
				<?php echo JText::_('Start Date')?>
			</th>
                        <th width="6%">
				<?php echo JText::_('Deadline')?>
			</th>
                         <th width="6%">
				<?php echo JText::_('Time Remain(days)')?>
			</th>                        
			<th width="6%">
				<?php echo JText::_('Status')?>
			</th>
			<th width="6%">
				<?php echo JText::_('Delay')?>				
			</th>
                        <th width="6%">
				<?php echo JText::_('Rework')?>				
			</th>
                        <th width="10%">
				<?php echo JText::_('Log')?>				
			</th>
			
			
		</tr>
	</thead>
        <?php 
        //level1
        $level=0;
        foreach ($this->wo_list as $row){
                $level++;
                if ($row->pns_cpn == 1)
                        $link = 'index.php?option=com_apdmpns&amp;task=detailmpn&cid[0]=' . $row->pns_id;
                else
                        $link = 'index.php?option=com_apdmpns&amp;task=detail&cid[0]=' . $row->pns_id;
                if ($row->pns_revision) {
                        $pnNumber = $row->ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                } else {
                        $pnNumber = $row->ccs_code . '-' . $row->pns_code;
                }  
                $background="";
                $remain_day = $row->wo_remain_date+1;
                if($remain_day<=0)
                {
                        $remain_day = 0;                        
						if($row->wo_state != 'done' && $row->wo_state != 'cancel')
                        {
                                $background= "style='background-color:#f00;color:#fff'";
                        }
                }
                elseif($row->wo_remain_date<=3)
                {
						if($row->wo_state != 'done' && $row->wo_state != 'cancel')
                        {
							$background= "style='background-color:#ff0;color:#000'";
						}
						
                }
                ?>
        <tr>		
                                              
                <td>
                        <?php echo JHTML::_('grid.id', $level, $row->pns_wo_id ); ?>
                </td>
<!--		<td>					
                <input type="checkbox" id = "pns_wo_id" value="<?php echo $row->pns_wo_id;?>" name="cid[]"  />
                </td>-->
                
                <td align="left"><?php echo PNsController::getTopAssysWo($row->pns_wo_id); ?></td>
                <td align="center"><?php echo '<a href="index.php?option=com_apdmpns&task=wo_detail&id='.$row->pns_wo_id.'" title="'.JText::_('Click to see detail WO').'">'.$row->wo_code.'</a> '; ?></td>
		<td align="left"><?php echo '<a href="'.$link.'" title="'.JText::_('Click to see detail PNs').'">'.$pnNumber.'</a> '; ?></td>
		<td align="left"><span class="editlinktip hasTip" title="<?php echo $row->pns_description; ?>" ><?php echo limit_text($row->pns_description, 15);?></span></td>
                <td align="center"><?php echo $row->wo_qty;?></td>
                <td align="center"><?php echo $row->pns_uom;?></td>
                <td align="center"><?php echo JHTML::_('date', $row->wo_start_date, JText::_('DATE_FORMAT_LC5')); ?></td>
                <td align="center"><?php echo JHTML::_('date', $row->wo_completed_date, JText::_('DATE_FORMAT_LC5')); ?></td>
                <td align="center" <?php echo $background?>><?php echo $remain_day;?></td>
                <td align="center"><?php echo PNsController::getWoStatus($row->wo_state); ?></td>
                <td align="center"><?php echo $row->wo_delay;//PNsController::getDelayTimes($row->pns_wo_id);?></td>
                <td align="center"><?php echo PNsController::getReworkStep($row->pns_wo_id,0);?></td>
                 <td align="center"><?php echo $row->wo_log;?></td>
	</tr>
<?php 
        }
?>
</table>
                </fieldset>
</div>	
        </fieldset>
        <input type="hidden" name="so_id" value="<?php echo $this->so_row->pns_so_id; ?>" />
        <input type="hidden" name="option" value="com_apdmpns" />     
        <input type="hidden" name="id" value="<?php echo JRequest::getVar('id'); ?>" />     
	<input type="hidden" name="task" value="" />	
        <input type="hidden" name="return" value="so_detail_support_doc"  />
        <input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_('form.token'); ?>
</form>
