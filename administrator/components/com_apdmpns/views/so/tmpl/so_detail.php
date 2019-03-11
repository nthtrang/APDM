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

JToolBarHelper::title("SO#: ".$soNumber, 'cpanel.png');
$role = JAdministrator::RoleOnComponent(10);   
$me = JFactory::getUser();
$usertype	= $me->get('usertype');
if (in_array("W", $role) && ($this->so_row->so_state =="inprogress")) { 
        JToolBarHelper::customX("onholdso","unpublish",'',"On Hold",false);        
        
        JToolBarHelper::cancelSo("Cancel",$this->so_row->pns_so_id);
        if ($usertype =='Administrator' || $usertype=="Super Administrator" || $this->so_row->so_created_by  == $me->get('id') ) {
                JToolBarHelper::customX("editso","edit",'',"Edit",false);                
        }
        
}
if (in_array("W", $role) && ($this->so_row->so_state =="inprogress" || $this->so_row->so_state =="done")) { 
  if ($usertype =='Administrator' || $usertype=="Super Administrator" || $this->so_row->so_created_by  == $me->get('id') ) {                
                JToolBarHelper::customX('savermafk', 'assign', '', 'Save RMA', false);
        }      
}
if (in_array("W", $role) && $this->so_row->so_state =="onhold") {        
        JToolBarHelper::customX("inprogressso","restore",'',"In PROGRESS",false);     
        JToolBarHelper::cancelSo("Cancel",$this->so_row->pns_so_id);
}
//$arrSoStatus['inprogress']= JText::_('In Progress');
//$arrSoStatus['onhold'] = JText::_('On Hold');
//$arrSoStatus['cancel'] = JText::_('Cancel');
//$arrSoStatus['done']= JText::_('Done');             

if (in_array("D", $role) && $this->so_row->so_state =="inprogress") {
       // JToolBarHelper::deletePns('Are you sure to delete it?',"deleteso","Delete SO#");                
        JToolBarHelper::deleteSo("Delete SO#",$this->so_row->pns_so_id);
        JToolBarHelper::customX('rmTopAssysSo', 'delete', '', 'Remove Top ASSYS', false);
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
                if(pressbutton == 'deleteso')
                {                       
                     submitform( pressbutton );
                     return;
                }
                if (pressbutton == 'editso') {
                        submitform( pressbutton );
                        return;
                }      
                if (pressbutton == 'savermafk') {                        
                        if (form.boxchecked.value==1){
                                alert("Please check PN for edit RMA first");                               
                                return false;
                        }       
                        var cpn = document.getElementsByName('cid[]');
                        var len = cpn.length;
                        for (var i=0; i<len; i++) {
                               // alert(i + (cpn[i].checked?' checked ':' unchecked ') + cpn[i].value);
                                var rma_value = document.getElementById('rma_' +cpn[i].value).value;
                                var qty_value = document.getElementById('qty_' +cpn[i].value).value;
								rma_value = parseInt(rma_value);
								qty_value = parseInt(qty_value);
								console.log(rma_value);
								console.log(qty_value)
								//alert(qty_value);
                                if(qty_value < rma_value)
                                {
                                        alert("Qty RMA must equal or less than PN Qty");                               
                                        return false;
                                }
                        }
                        submitform( pressbutton );
                        return;
                }
                if(pressbutton=='rmTopAssysSo')
                {
                        if (form.boxchecked.value==1){
                                alert("Please check PN for remove out first");                               
                                return false;
                        }  
                        submitform( pressbutton );
                        return;
                }
                if (pressbutton == 'onholdso') {
                        submitform( pressbutton );
                        return;
                }
                if (pressbutton == 'inprogressso') {
                        submitform( pressbutton );
                        return;
                }                
			
                        
                        
        }
 function isCheckedSoPn(isitchecked,id){
       
	if (isitchecked == true){
		document.adminForm.boxchecked.value++;
                document.getElementById('rma_'+id).style.visibility= 'visible';
                document.getElementById('rma_'+id).style.display= 'block';
                document.getElementById('text_rma_'+id).style.visibility= 'hidden';
                document.getElementById('text_rma_'+id).style.display= 'none';        
	}
	else {
		document.adminForm.boxchecked.value--;
                document.getElementById('text_rma_'+id).style.visibility= 'visible';
                document.getElementById('text_rma_'+id).style.display= 'block';

                document.getElementById('rma_'+id).style.visibility= 'hidden';
                document.getElementById('rma_'+id).style.display= 'none';    
	}
}       

</script>
<style type="text/css" media="print">
    @page 
    {
        size: auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
    }
</style>
<div class="submenu-box">
            <div class="t">
                <div class="t">
                        <div class="t"></div>
                </div>
        </div>
        <div class="m">
		<ul id="submenu" class="configuration">
			<li><a id="detail" class="active"><?php echo JText::_( 'DETAIL' ); ?></a></li>
			<li><a id="bom" href="index.php?option=com_apdmpns&task=so_detail_wo&id=<?php echo $this->so_row->pns_so_id;?>"><?php echo JText::_( 'AFFECTED WO#' ); ?></a></li>
                        <li><a id="bom" href="index.php?option=com_apdmpns&task=so_detail_support_doc&id=<?php echo $this->so_row->pns_so_id;?>"><?php echo JText::_( 'SUPPORTING DOC' ); ?></a></li>
                        <li><a id="bom" href="index.php?option=com_apdmpns&task=so_detail_wo_history&id=<?php echo $this->so_row->pns_so_id;?>"><?php echo JText::_( 'STATUS CHANGING HISTORY' ); ?></a></li>
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

<form action="index.php"  onsubmit="submitbutton('')"  method="post" name="adminForm" >	
        <fieldset class="adminform">
		<legend><?php echo JText::_( 'SO Detail' ); ?></legend>        
        <table class="admintable" cellspacing="1"  width="70%">
                              <tr>
                                        <td class="key" width="28%"><?php echo JText::_('Customer'); ?></td>                                               
                                        <td width="30%" class="title"><?php echo PNsController::getCcsName($this->so_row->customer_id); ?></td>                                          
                                        <td class="key" width="18%"><?php echo JText::_('Coordinator'); ?></td>                                               
                                        <td width="30%" class="title"><?php echo PNsController::getcoordinatorso($this->so_row->ccs_so_code);?></td>
				                                                                              
                                </tr>
                                <tr>
                                        <td  class="key" width="28%"><?php echo JText::_('PO# of Customer'); ?></td>                                               
                                        <td width="30%" class="title" colspan="3">
                                        <?php 
                                         $soNumber = $this->so_row->so_cuscode;
                                        if($this->so_row->ccs_code)
                                        {
                                               $soNumber = $this->so_row->ccs_code."-".$soNumber;
                                        }
                                        echo $soNumber; ?></td>                                        
				                                                                              
                                </tr>  
                                <tr>
                                        <td class="key"  width="28%"><?php echo JText::_('Shipping Requested Date'); ?></td>                                               
                                        <td width="30%" class="title" colspan="3">  <?php echo JHTML::_('date', $this->so_row->so_shipping_date, JText::_('DATE_FORMAT_LC5')); ?></td>                                        
				                                                                              
                                </tr>  
                                <tr>
                                        <td  class="key" width="28%"><?php echo JText::_('Start Date'); ?></td>                                               
                                        <td width="30%" class="title" colspan="3">  <?php echo JHTML::_('date', $this->so_row->so_start_date, JText::_('DATE_FORMAT_LC5')); ?></td>                                        
				                                                                              
                                </tr>                                                                                 
                                <tr>
                                        <td colspan="4" >
						<table class="adminlist" cellspacing="1" width="100%">
                                                        <tr>
                                                                <td class="key">#</td>
                                                                <td width="30%" class="key">TOP ASSY PN</td>
                                                                <td class="key">Description</td>
                                                                <td class="key">Qty</td>
                                                                <td class="key">RMA</td>
                                                                <td class="key">UOM</td>
                                                                <td class="key">Required</td>
                                                                <td class="key">Unit Price</td>
                                                                <td class="key">Delivery Times</td>                                                          
                                                        </tr>
                                                        <?php
                                                        $i = 0;
                                                        foreach ($this->so_pn_list as $row) {
                                                                $i++;
                                                                if ($row->pns_cpn == 1)
                                                                        $link = 'index.php?option=com_apdmpns&amp;task=detailmpn&cid[0]=' . $row->pns_id;
                                                                else
                                                                        $link = 'index.php?option=com_apdmpns&amp;task=detail&cid[0]=' . $row->pns_id;
                                                                $image = PNsController::GetImagePreview($row->pns_id);
                                                                if ($row->pns_revision) {
                                                                        $pnNumber = $row->ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                                                                } else {
                                                                        $pnNumber = $row->ccs_code . '-' . $row->pns_code;
                                                                }
                                                                ?>
                                                                <tr>        
                                                                        <td>
                                                                                <input type="checkbox" id = "pns_so" onclick="isCheckedSoPn(this.checked,'<?php echo $row->id;?>');" value="<?php echo $row->id;?>" name="cid[]"  />
                                                                        </td>
                                                                        <td><span class="editlinktip hasTip" title="<?php echo $pnNumber; ?>" >
                                                                                        <a href="<?php echo $link; ?>" title="<?php echo JText::_('Click to see detail PNs'); ?>"><?php echo $pnNumber; ?></a>
                                                                                </span></td>
                                                                        <td><?php echo $row->pns_description; ?></td>                                                
                                                                        <td>                                                    
                                                                                <span id="text_qty_<?php echo $row->id; ?>"><?php echo $row->qty; ?>
                                                                                </span>
                                                                                 <input type="hidden" value="<?php echo $row->qty;?>" id="qty_<?php echo $row->id;?>"  name="qty_<?php echo $row->id;?>" />
                                                                        </td> 
                                                                        <td>
                                                                                <span style="display:block" id="text_rma_<?php echo $row->id;?>"><?php echo $row->rma;?></span>
                                                                                <input style="display:none" onKeyPress="return numbersOnly(this, event);" type="text" value="<?php echo $row->rma;?>" id="rma_<?php echo $row->id;?>"  name="rma_<?php echo $row->id;?>" />
                                                                        </td>
                                                                        <td>                                                    
                                                                                <span id="text_qty_<?php echo $row->id; ?>"><?php echo $row->pns_uom; ?></span>                                                        
                                                                        </td>
                                                                        <td>                                                    
                                                                                <span id="text_qty_<?php echo $row->id; ?>">
                                                                                        <?php
                                                                                        $required = array();
                                                                                        if ($row->fa_required) {
                                                                                                $required[] = "F.A";
                                                                                        }
                                                                                        if ($row->esd_required) {
                                                                                                $required[] = "ESD";
                                                                                        }
                                                                                        if ($row->coc_required) {
                                                                                                $required[] = "COC";
                                                                                        }
                                                                                        echo implode(",", $required);
                                                                                        ?>
                                                                                
                                                                                </span>                                                        
                                                                        </td>
                                                                        <td>                                                    
                                                                                <span style="display:block" id="text_qty_<?php echo $row->id; ?>"><?php echo $row->price; ?></span>                                                        
                                                                        </td>
                                                                        <td>                                                    
                                                                                <span style="display:block" id="text_qty_<?php echo $row->id; ?>"></span>                                                        
                                                                        </td>
                                                                </tr>
        <?php
}
?>
                                                
                                                </table>
                                        </td>
                                </tr>
                        <tr>
                                <td  valign="top"><strong>DELIVERY</strong></td>
                                        <td valign="top"></td>
                                        <td ><strong>LOG</strong></td>
                                        <td valign="top"></td>
                                        
                                        
                                </tr>                                
                              
                         <tr>
                                 <tr>
                                        <td  colspan="2" valign="top">
                                            <table class="adminlist" cellspacing="1" width="100%">
                                                        <tr>
                                                                <td width="30%" class="key">PN</td>
                                                                <td class="key">Times</td>
                                                                <td class="key">Qty</td>
                                                                <td class="key">State</td>
                                                        </tr>
                                                        
                                                                 <?php 
                                                                 foreach ($this->so_pn_list as $row) {                                                                         
                                                                 $rowEto = PNsController::GetEtoPns($row->pns_id);
                                                                 
                                                                 $totalEto= count($rowEto);
                                                                 if($totalEto){
                                                                 if ($row->pns_cpn == 1)
                                                                        $link = 'index.php?option=com_apdmpns&amp;task=detailmpn&cid[0]=' . $row->pns_id;
                                                                 else
                                                                        $link = 'index.php?option=com_apdmpns&amp;task=detail&cid[0]=' . $row->pns_id;
                                                                $image = PNsController::GetImagePreview($row->pns_id);
                                                                if ($row->pns_revision) {
                                                                        $pnNumber = $row->ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                                                                } else {
                                                                        $pnNumber = $row->ccs_code . '-' . $row->pns_code;
                                                                }
                                                                 ?>
                                                        
                                                                 
                                                                <td width="30%" > <?php echo $pnNumber;?></td>
                                                                <td> <?php echo $totalEto;?></td>
                                                                <td colspan="2"><table class="adminlist" cellspacing="0" width="200">                                                                
                                                                <?php                                                             
                                                                foreach ($rowEto as $r1) { 
                                                                ?>
                                                                <tr>
                                                                <td width="100"><?php echo $r1->qty;?></td>
                                                                <td><a href="index.php?option=com_apdmsto&task=eto_detail&id=<?php echo $r1->sto_id?>"><?php echo $r1->sto_state;?></a></td>
                                                                 </tr>
                                                                <?php 
                                                                }?></table>
                                                               </td> </tr>  
                                                                <?php 
                                                                 }}?>
                                                              
                                             
                                            </table>
                                        </td>
                                        <td colspan="2" >
                                             <?php echo $this->so_row->so_log;?>
                                                        
                                        </td>
                                        
                                </tr>                                
                              
                         <tr>                                 
                        <td  class="key" width="28%"><?php echo JText::_('Status'); ?></td>                                               
                        <td width="30%" class="title">  
                        <?php 
                        $arrStatus = $this->arr_status;
                        echo strtoupper($arrStatus[$this->so_row->so_state]);
                        ?></td> 
                       <td></td>
                       

                </tr>         
        
               
                        <tr>
                                        <td class="key" valign="top">
                                                <label for="username">
                                                        <?php echo JText::_('Date Create'); ?>
                                                </label>
                                        </td>
                                        <td>
                                                <?php echo JHTML::_('date', $this->so_row->so_created, '%m-%d-%Y %H:%M:%S %p'); ?>
                                                        
                                        </td>
                                        <td  colspan="2" rowspan="4"></td> 
                                </tr>
				
				
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Create by' ); ?>
						</label>
					</td>
					<td>
 						<?php echo GetValueUser($this->so_row->so_created_by, "name"); ?>

					</td>
                                        
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Date Modified' ); ?>
						</label>
					</td>
					<td>
 						<?php echo  ($this->so_row->so_updated) ? JHTML::_('date', $this->so_row->so_updated, '%m-%d-%Y %H:%M:%S %p') : ''; ?>

					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Modified By' ); ?>
						</label>
					</td>
					<td> 						
						<?php echo  ($this->so_row->so_updated_by) ? GetValueUser($this->so_row->so_updated_by, "name") : ''; ?>

					</td>
				</tr>                
        </table>		
        </fieldset>
        <input type="hidden" name="so_id" value="<?php echo $this->so_row->pns_so_id; ?>" />
        <input type="hidden" name="option" value="com_apdmpns" />     
        <input type="hidden" name="id" value="<?php echo JRequest::getVar('id'); ?>" />     
	<input type="hidden" name="task" value="" />	
        <input type="hidden" name="boxchecked" value="1" />
<?php echo JHTML::_('form.token'); ?>
</form>
