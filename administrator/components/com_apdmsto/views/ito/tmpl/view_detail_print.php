<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php JHTML::_('behavior.modal'); ?>

<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);	
	$role = JAdministrator::RoleOnComponent(8);
    $cparams = JComponentHelper::getParams ('com_media');
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );
?>
<script language="javascript" type="text/javascript">
    window.print();
</script>
<style type="text/css">
    .tgi  {border-collapse:collapse;border-spacing:0;align-content: center}
    .tgi td{font-family:Arial, Helvetica, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:black;}
    .tgi th{font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:black;}
    .tgi .tg-88nc{font-weight:bold;border-color:inherit;text-align:center;font-size: 20px;color: #0B55C4}
    .tgi .tg-kiyi{font-weight:bold;font-size: 11px;border-color:inherit;text-align:left}
    .tgi .tg-c3ow{text-align:center;vertical-align:top}
    .tgi .tg-c3ow-des{border-color:inherit;border-style:solid;border-width:1px;text-align:center;vertical-align:top}
    .tgi .tg-xldj-pr{text-align:right}
    .tgi .tg-0pky-pr{text-align:left;vertical-align:top}
    .tgi .tg-0pky-border{border-width:1px;border-style:solid}
    .tgi .tg-0pky-pr-title{border-color:inherit;text-align:left;vertical-align:top;font-size: 16px;color: #0B55C4}
    .tgi .tg-0pky-ito-title{border-color:inherit;text-align:center;vertical-align:top;font-size: 16px;color: #0B55C4}
</style>
<table class="tgi" width="100%">
    <tr>
        <th class="tg-kiyi" colspan="2">
            ASCENX TECHNOLOGIES
            <br>Unit 5B, 5th Floor, Standard Factory Building
            <br>Road 14, Tan Thuan EPZ, Tan Thuan Dong Ward,
            <br>District 7, HCMC, Vietnam<br>ST ZIP Code: 0305.399.533<br>(O) : (8428) 3620.5581<br>(F):  (8428) 3620.5583</th>
        <th class="tg-xldj-pr" colspan="2">
            <img src="./templates/khepri/images/h_green/logo1.png" width="300px"></img>
            <br></th>
    </tr>
    <tr>
        <td class="tg-88nc" colspan="4">IMPORT TRANSACTION ORDER</td>
    </tr>
    <tr>
        <td class="tg-xldj-pr"></td>
        <td class="tg-xldj-pr"></td>
        <td class="tg-xldj-pr"></td>
        <td class="tg-xldj-pr"></td>
    </tr>
    <tr>
        <td class="tg-0pky-ito-title" colspan="4">ITO# <?php echo $this->sto_row->sto_code; ?></td>
    </tr>
    <tr>
        <td class="tg-0pky-pr"></td>
        <td class="tg-0pky-pr"></td>
        <td class="tg-0pky-pr"></td>
        <td class="tg-0pky-pr"></td>
    </tr>
    <tr>
        <td class="tg-0pky-pr tg-0pky-border" style="border-right:0px">Created date:</td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-left:0px"><?php echo JHTML::_('date', $this->sto_row->sto_created, JText::_('DATE_FORMAT_LC5')); ?></td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-right:0px">Supplier#:</td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-left:0px"><?php echo SToController::GetSupplierName($this->sto_row->sto_supplier_id);?></td>
    </tr>
    <tr>
        <td class="tg-0pky-pr tg-0pky-border" style="border-right:0px">Completed date:</td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-left:0px"><?php echo ($this->sto_row->sto_completed_date)?JHTML::_('date', $this->sto_row->sto_completed_date, JText::_('DATE_FORMAT_LC5')):""; ?></td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-right:0px">P.O INTERNAL:</td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-left:0px"><?php echo $this->sto_row->sto_po_internal;?></td>
    </tr>
    <tr>
        <td class="tg-0pky-pr tg-0pky-border" style="border-right:0px" rowspan="2">State:</td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-left:0px"  rowspan="2"><?php echo $this->sto_row->sto_state;?></td>
        <td class="tg-0pky-pr tg-0pky-border">Stocker: <?php echo ($this->sto_row->sto_owner)?GetValueUser($this->sto_row->sto_stocker, "name"):""; ?></td>
        <td class="tg-0pky-pr tg-0pky-border">Comfirm:<input checked="checked" type="checkbox" name="sto_stocker_confirm" value="1" onclick="return false;" onkeydown="return false;" /></td>
    </tr>
    <tr>
        <td class="tg-0pky-pr tg-0pky-border">Owner: <?php echo ($this->sto_row->sto_owner)?GetValueUser($this->sto_row->sto_owner, "name"):""; ?></td>
        <td class="tg-0pky-pr tg-0pky-border">Comfirm:
            <?php
            $checked ="";
            if($this->sto_row->sto_owner_confirm){
                $checked = 'checked="checked"';
            }
            ?>
            <input <?php echo $checked;?> onclick="return false;" onkeydown="return false;" type="checkbox" name="sto_owner_confirm" value="1" />
        </td>
    </tr>
    <tr>
        <td class="tg-0pky-pr"></td>
        <td class="tg-0pky-pr"></td>
        <td class="tg-0pky-pr"></td>
        <td class="tg-0pky-pr"></td>
    </tr>
    <tr>
        <td class="tg-c3ow-desc" colspan="4" style="border-width:1px;border-style:solid">
           Description:<?php echo $this->sto_row->sto_description?></td>
    </tr>
    <tr>
        <td class="tg-0pky-pr"></td>
        <td class="tg-0pky-pr"></td>
        <td class="tg-0pky-pr"></td>
        <td class="tg-0pky-pr"></td>
    </tr>
    <tr>
        <td class="tg-0pky-pr-title" colspan="4">Receiving Part</td>
    </tr>
    <tr>
        <td class="tg-0pky-pr" colspan="4">
            <?php if (count($this->sto_pn_list) > 0) { ?>
            <table class="tgi" width="100%">
                <thead>
                <tr>
                    <th width="18" style="border-left:1px;border-width:1px;border-style:solid"><?php echo JText::_('#'); ?></th>
                    <th width="100" style="border-left:1px;border-width:1px;border-style:solid"><?php echo JText::_('PN'); ?></th>
                    <th width="100" style="border-left:1px;border-width:1px;border-style:solid"><?php echo JText::_('Description'); ?></th>
                    <th width="100" style="border-left:1px;border-width:1px;border-style:solid"><?php echo JText::_('UOM'); ?></th>
                    <th width="100" style="border-left:1px;border-width:1px;border-style:solid"><?php echo JText::_('Qty'); ?></th>
                    <th width="100" style="border-left:1px;border-width:1px;border-style:solid"><?php echo JText::_('Location'); ?></th>
                    <th width="100" style="border-left:1px;border-width:1px;border-style:solid"><?php echo JText::_('Part State'); ?></th>
                    
                </tr>
                </thead>
                <tbody>
                <?php



                $i = 0;
                foreach ($this->sto_pn_list as $row) {
                    $i++;
                    $stoList = SToController::GetStoFrommPns($row->pns_id,$sto_id);
                    if($row->pns_revision)
                        $pns_code = $row->ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision;
                    else
                        $pns_code = $row->ccs_code.'-'.$row->pns_code;

                    ?>
                    <tr>
                        <td  style="border-left:1px;border-width:1px;border-style:solid"><?php echo $i; ?></td>
                        <td  style="border-left:1px;border-width:1px;border-style:solid"><?php echo $pns_code;?></td>
                        <td  style="border-left:1px;border-width:1px;border-style:solid"><?php echo $row->pns_description; ?></td>
                        <td  style="border-left:1px;border-width:1px;border-style:solid"><?php echo $row->pns_uom; ?></td>
                        <td  style="border-left:1px;border-width:1px;border-style:solid" colspan="4">
                            <table class="adminlist" cellspacing="0" width="200">
                                <?php
                                foreach ($this->sto_pn_list2 as $rw) {
                                    if($rw->pns_id==$row->pns_id)
                                    {
                                        ?>
                                        <tr><td align="center" width="74px">
                                                <span style="display:block" id="text_qty_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>"><?php echo $rw->qty;?></span>
                                                <input style="display:none;width: 70px" onKeyPress="return numbersOnlyEspecialFloat(this, event);" type="text" value="<?php echo $rw->qty;?>" id="qty_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>"  name="qty_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>" />
                                            </td>
                                             <td align="center" width="77px">
                                                        <span style="display:block" id="text_location_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>"><?php echo $rw->location?SToController::GetCodeLocation($rw->location):"";?></span>
                                                       <?php 
                                                        if($rw->sto_type==1)
                                                         {
                                                                echo JHTML::_('select.genericlist',   $locationArr, 'location_'.$row->pns_id.'_'.$rw->id, 'class="inputbox" style="display:none" size="1" ', 'value', 'text', $rw->location ); 
                                                         }
                                                         else{
															 ?><span  id="ajax_location_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>">
															 <?php 
                                                                 $locationArr = SToController::getLocationPartStatePn($rw->partstate,$row->pns_id);
                                                                echo JHTML::_('select.genericlist',   $locationArr, 'location_'.$row->pns_id.'_'.$rw->id, 'class="inputbox" style="display:none" size="1" ', 'value', 'text', $rw->location ); 
																?>
																</span> 
																<?php 
                                                         }
                                                        ?>
                                                </td>	
                                                <td align="center" width="77px">
                                                        <span style="display:block" id="text_partstate_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>"><?php echo $rw->partstate?strtoupper($rw->partstate):"";?></span>
                                                         <?php       
                                                         if($rw->sto_type==1)
                                                         {
                                                                echo JHTML::_('select.genericlist',   $partStateArr, 'partstate_'.$row->pns_id.'_'.$rw->id, 'class="inputbox" style="display:none" size="1" ', 'value', 'text', $rw->partstate ); 
                                                         }
                                                         else{                                                                 
                                                                 $partStateArr = SToController::getPartStatePn($rw->partstate,$row->pns_id);
                                                                 echo JHTML::_('select.genericlist',   $partStateArr, 'partstate_'.$row->pns_id.'_'.$rw->id, 'class="inputbox" style="display:none" size="1" onchange="getLocationPartState('.$row->pns_id.','.$rw->id.','.$rw->location.',this.value);"', 'value', 'text', $rw->partstate ); 
                                                                 
                                                         }
                                                        
                                                        ?>
                                                </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </table>
                        </td>
                    </tr>
                <?php }
                }
                else
                {
                    echo "Not found PNs";
                }
                ?>
                </tbody>
            </table>

        </td>
    </tr>
</table>