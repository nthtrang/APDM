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
    .tgi  {border-collapse:collapse;border-spacing:0;}
    .tgi td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:black;}
    .tgi th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:black;}
    .tgi .tg-88nc{font-weight:bold;border-color:inherit;text-align:center;font-size: 20px;color: #0B55C4}
    .tgi .tg-kiyi{font-weight:bold;font-size: 11px;border-color:inherit;text-align:left}
    .tgi .tg-c3ow{text-align:center;vertical-align:top}
    .tgi .tg-c3ow-des{border-color:inherit;border-style:solid;border-width:1px;text-align:center;vertical-align:top}
    .tgi .tg-xldj-pr{border-color:inherit;text-align:left}
    .tgi .tg-0pky-pr{border-color:inherit;text-align:left;vertical-align:top}
    .tgi .tg-0pky-pr-title{border-color:inherit;text-align:left;vertical-align:top;font-size: 16px;color: #0B55C4}
    .tgi .tg-xldj-pr-title{border-color:inherit;text-align:left;vertical-align:top;font-size: 18px;color: #0B55C4;font-weight: bold}
</style>
<table class="tgi" width="100%">
         <tr>
    <th class="tg-xldj-pr-title">ASCENX TECHNOLOGIES</th>
    <th class="tg-xldj-pr-title">DELIVERY NOTE</th>
  </tr>
    <tr>
        <th class="tg-kiyi" rowspan="3">            
            <br>Unit 5B, 5th Floor, Standard Factory Building
            <br>Road 14, Tan Thuan EPZ, Tan Thuan Dong Ward,
            <br>District 7, HCMC, Vietnam<br>ST ZIP Code: 0305.399.533<br>(O) : (8428) 3620.5581<br>(F):  (8428) 3620.5583</th>
        <th class="tg-xldj-pr">PO#:<?php
            $soNumber = $this->sto_row->so_cuscode;
            if($this->sto_row->ccs_code)
            {
                $soNumber = $this->sto_row->ccs_code."-".$soNumber;
            }
            echo $soNumber;
            ?></th>            
    </tr>
    <tr>
        <td class="tg-xldj-pr">Customer#:<?php  echo $this->sto_row->ccs_name; ?></td>      
    </tr>
    <tr>
        <td class="tg-xldj-pr">Delivery Method:<?php  echo $this->sto_row->delivery_method; ?></td>      
    </tr>
    <tr>
        <td class="tg-xldj-pr"></td>      
    </tr>
</table>
<table class="admintable" cellspacing="1" width="100%">                                           
                                        <tr>
                                            <td>
                                                <label for="name" style="padding: 5px 100px 5px 100px;color:#0B55C4;font-size: 16px;font-weight: bold;background-color:#3166ff;color:#ffffff;">
                                                    <?php echo JText::_( 'Shipping Address' ); ?>
                                                </label>
                                            </td>
                                          <td>
                                                <label for="name" style="padding: 5px 100px 5px 100px;color:#0B55C4;font-size: 16px;font-weight: bold;background-color:#3166ff;color:#ffffff;">
                                                    <?php echo JText::_( 'Invoice Address' ); ?>
                                                </label>
                                            </td>
                                        </tr> 
                                        <tr>
                                            <td>
                                                <?php  echo $this->sto_row->delivery_shipping_name; ?>
                                            </td>
                                             
                                            <td>
                                                <?php  echo $this->sto_row->delivery_billing_name; ?>
                                            </td>
                                             </tr>
                                             <tr>
                                          
                                            <td>
                                                <?php  echo $this->sto_row->delivery_shipping_company; ?>
                                            </td>
                                             
                                            <td>
                                                <?php  echo $this->sto_row->delivery_billing_company; ?>
                                            </td>
                                             </tr>
                                             <tr>
                                            
                                            <td>
                                                <?php  echo $this->sto_row->delivery_shipping_street; ?>
                                            </td>
                                             
                                            <td>
                                               <?php  echo $this->sto_row->delivery_billing_street; ?>
                                            </td>
                                             </tr>
                                             <tr>
                                           
                                            <td>
                                                <?php  echo $this->sto_row->delivery_shipping_zipcode; ?>
                                            </td>
                                            
                                            <td>
                                               <?php  echo $this->sto_row->delivery_billing_zipcode; ?>
                                            </td>
                                             </tr>
                                             <tr>
                                          
                                            <td>
                                                <?php  echo $this->sto_row->delivery_shipping_phone; ?>
                                            </td>
                                            
                                            <td>
                                                <?php  echo $this->sto_row->delivery_billing_phone; ?>
                                            </td>
                                             </tr>
                                           </table>
<table class="tgi" width="100%">
<!--    <tr>
        <td class="tg-0pky-pr-title" colspan="4">Shipping Part</td>
    </tr>-->
    <tr>
        <td class="tg-0pky-pr" colspan="4">
            <?php if (count($this->sto_pn_list) > 0) { ?>
            <table class="adminlist" cellspacing="1" width="400">
                <thead>
                <tr>
                    <th width="18"><?php echo JText::_('#'); ?></th>
                    <th width="100"><?php echo JText::_('PN'); ?></th>
                    <th width="100"><?php echo JText::_('Description'); ?></th>
                    <th width="100"><?php echo JText::_('UOM'); ?></th>
                    <th width="100"><?php echo JText::_('Qty'); ?></th>
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
                        <td><?php echo $i; ?></td>
                        <td><?php echo $pns_code;?></td>
                        <td><?php echo $row->pns_description; ?></td>
                        <td><?php echo $row->pns_uom; ?></td>
                        <td colspan="2">
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
       <tr>
        <td class="tg-0pky-pr" style="text-align:right" colspan="4">Received date: <?php echo JHTML::_('date', date("Y-m-d H:i:s"), JText::_('DATE_FORMAT_LC5')); ?></td>
    </tr>
</table>