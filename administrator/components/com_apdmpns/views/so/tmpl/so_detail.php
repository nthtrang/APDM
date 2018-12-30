<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php
//
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
$cid = JRequest::getVar('cid', array(0));
$edit = JRequest::getVar('edit', true);

JToolBarHelper::title("SO#: ".$this->so_row->so_cuscode, 'cpanel.png');
$role = JAdministrator::RoleOnComponent(10);      
if (in_array("W", $role)) {        
        JToolBarHelper::customX('savermafk', 'save', '', 'RMA', false);
        JToolBarHelper::editListX("editso","Edit");	
        
}
if (in_array("D", $role)) {
        JToolBarHelper::deletePns('Are you sure to delete it?',"deleteso","Delete SO#");
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
                                        <td width="30%" class="title"><?php echo PNsController::getCcsDescription($this->so_row->customer_id); ?></td>                                          
                                        <td class="key" width="18%"><?php echo JText::_('Coordinator'); ?></td>                                               
                                        <td width="30%" class="title"><?php echo $this->so_row->ccs_coordinator; ?></td>
				                                                                              
                                </tr>
                                <tr>
                                        <td  class="key" width="28%"><?php echo JText::_('PO# of Customer'); ?></td>                                               
                                        <td width="30%" class="title" colspan="3"><?php echo $this->so_row->so_cuscode; ?></td>                                        
				                                                                              
                                </tr>  
                                <tr>
                                        <td class="key"  width="28%"><?php echo JText::_('Shipping Requested Date'); ?></td>                                               
                                        <td width="30%" class="title" colspan="3">  <?php echo JHTML::_('date', $this->so_row->so_shipping_date, JText::_('DATE_FORMAT_LC3')); ?></td>                                        
				                                                                              
                                </tr>  
                                <tr>
                                        <td  class="key" width="28%"><?php echo JText::_('Start Date'); ?></td>                                               
                                        <td width="30%" class="title" colspan="3">  <?php echo JHTML::_('date', $this->so_row->so_shipping_date, JText::_('DATE_FORMAT_LC3')); ?></td>                                        
				                                                                              
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
                                                                                <span id="text_qty_<?php echo $row->id; ?>"><?php echo $row->qty; ?></span>                                                        
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
                                                                <td class="key">Status</td>                                                                                                                       
                                                        </tr>
                                                         <tr>
                                                                <td width="30%">...</td>
                                                                <td>...</td>
                                                                <td>...</td>
                                                                <td>...</td>                                                                                                                       
                                                        </tr>
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
        <input type="text" name="so_id" value="<?php echo $this->so_row->pns_so_id; ?>" />
        <input type="hidden" name="option" value="com_apdmpns" />     
        <input type="text" name="id" value="<?php echo JRequest::getVar('id'); ?>" />     
	<input type="hidden" name="task" value="" />	
        <input type="hidden" name="boxchecked" value="1" />
<?php echo JHTML::_('form.token'); ?>
</form>
