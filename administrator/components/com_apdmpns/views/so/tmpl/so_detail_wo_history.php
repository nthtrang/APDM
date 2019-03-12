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



$cparams = JComponentHelper::getParams('com_media');
$editor = &JFactory::getEditor();

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
			<li><a id="bom"  href="index.php?option=com_apdmpns&task=so_detail_wo&id=<?php echo $this->so_row->pns_so_id;?>"><?php echo JText::_( 'Affected WO' ); ?></a></li>
                        <li><a id="bom" href="index.php?option=com_apdmpns&task=so_detail_support_doc&id=<?php echo $this->so_row->pns_so_id;?>"><?php echo JText::_( 'Supporting Doc' ); ?></a></li>
                        <li><a id="bom" class="active"><?php echo JText::_( 'Status Changing History' ); ?></a></li>
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
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data" >      
        <fieldset class="adminform">
		 
        	<div class="col width-100">
		<fieldset class="adminform">		
                <table width="100%" class="adminlist" cellpadding="1">
	<thead>
		<tr>                        			
                        <th width="8%">
				<?php echo JText::_('WO')?>
			</th>
                         <th width="8%">
				<?php echo JText::_('PN')?>
			</th>
			<th width="25%">
				<?php echo JText::_('Description')?>
			</th>
			
                         <th width="6%">
				<?php echo JText::_('Previous Status')?>
			</th>                        
			<th width="6%">
				<?php echo JText::_('Current Status')?>
			</th>
			<th width="8%">
				<?php echo JText::_('Changed By')?>				
			</th>
                        <th width="8%">
				<?php echo JText::_('Changed Date')?>				
			</th>
                        <th width="10%">
				<?php echo JText::_('Reason')?>				
			</th>                      						
		</tr>
	</thead>
        <?php 
        //level1
        $level=0;
        foreach ($this->wo_list_history as $row){
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
                ?>
        <tr>		
                                              
                <td align="center"><?php echo '<a href="index.php?option=com_apdmpns&task=wo_detail&id='.$row->pns_wo_id.'" title="'.JText::_('Click to see detail WO').'">'.$row->wo_code.'</a> '; ?></td>
		        <td align="left"><?php echo '<a href="'.$link.'" title="'.JText::_('Click to see detail PNs').'">'.$pnNumber.'</a> '; ?></td>
		        <td align="left"><span class="editlinktip hasTip" title="<?php echo $row->pns_description; ?>" ><?php echo limit_text($row->pns_description, 15);?></span></td>
                <td align="center"><?php echo PNsController::getWoStatus($row->pre_status); ?></td>
                <td align="center"><?php echo PNsController::getWoStatus($row->cur_status); ?></td>
                <td align="center"><?php echo GetValueUser($row->wo_log_created_by, "name"); ?></td>
                <td align="center"><?php echo JHTML::_('date', $row->wo_log_created, '%m-%d-%Y %H:%M:%S %p'); ?></td>
                <td align="center"><?php echo $row->wo_log_content;?></td>
                
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
