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
<style type="text/css" media="print">
    @page
    {
        size: auto;   /* auto is the current printer page size */
        margin: 0mm;  /* this affects the margin in the printer settings */
    }


</style>
<style type="text/css">
    .tgi  {border-collapse:collapse;border-spacing:0;}
    .tgi td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:black;}
    .tgi th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:black;}
    .tgi .tg-88nc{font-weight:bold;border-color:inherit;text-align:center;font-size: 20px;color: #0B55C4}
    .tgi .tg-kiyi{font-weight:bold;font-size: 11px;border-color:inherit;text-align:left}
    .tgi .tg-c3ow{text-align:center;vertical-align:top}
    .tgi .tg-c3ow-des{border-color:inherit;border-style:solid;border-width:1px;text-align:center;vertical-align:top}
    .tgi .tg-xldj-pr{border-color:inherit;text-align:left}
    .tgi .tg-0pky-border{border-width:1px;border-style:solid}
    .tgi .tg-0pky-pr{border-color:inherit;text-align:left;vertical-align:top}
    .tgi .tg-0pky-shipping{background-color: #0000cc}
    .tgi .tg-0pky-pr-title{border-color:inherit;text-align:left;vertical-align:top;font-size: 16px;color: #0B55C4}
    .tgi .tg-xldj-pr-title{border-color:inherit;text-align:left;vertical-align:top;font-size: 18px;color: #0B55C4;font-weight: bold}
    .tgi .tg-xldj-pr-title-ship{border-color:inherit;text-align:center;vertical-align:top;font-size: 18px;color: #0B55C4;font-weight: bold}
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
            <br>District 7, HCMC, Vietnam<br>Tax ID: 0305.399.533<br>(O) : (8428) 3620.5581<br>(F):  (8428) 3620.5583</th>
        <th class="tg-xldj-pr">PO:<?php
           // $soNumber = $this->sto_row->so_cuscode;
            if($this->sto_row->sto_isdelivery_good && $this->sto_row->sto_so_id){
                echo SToController::getPoExCodeFromId($this->sto_row->sto_so_id);

            }
          //  echo $soNumber;
            ?></th>            
    </tr>
    <tr>
        <td class="tg-xldj-pr">Customer:
            <?php
            if($this->sto_row->sto_isdelivery_good && $this->sto_row->sto_so_id){
                echo SToController::getCustomerCodeFromSoId($this->sto_row->sto_so_id);
            }
            else
            {
                echo ($this->sto_row->ccs_name)?$this->sto_row->ccs_name:"NA";
            }
            ?></td>
    </tr>
    <tr>
        <td class="tg-xldj-pr">Delivery Method:<?php  echo $this->sto_row->delivery_method; ?></td>      
    </tr>
    <tr>
        <td class="tg-xldj-pr"></td>      
    </tr>
</table>
<table class="tgi" width="100%">
                                        <tr>
                                            <td class="tg-xldj-pr-title-ship" align="center">

                                                    <?php echo JText::_( 'Shipping Address' ); ?>

                                            </td>
                                          <td class="tg-xldj-pr-title-ship" align="center">

                                                    <?php echo JText::_( 'Invoice Address' ); ?>

                                            </td>
                                        </tr> 
                                        <tr>
                                            <td class="tg-0pky-pr tg-0pky-border"  width="500px">
                                                <table class="tgi" cellspacing="1" width="100%">
                                                    <tr>
                                                        <td class="key" width="30%">
                                                            <label for="name">
                                                                <?php echo JText::_( 'Name' ); ?>:
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <?php  echo $this->sto_row->delivery_shipping_name; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
                                                            <label for="name">
                                                                <?php echo JText::_( 'Company Name' ); ?>:
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <?php  echo $this->sto_row->delivery_shipping_company; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
                                                            <label for="name">
                                                                <?php echo JText::_( 'Street Address' ); ?>:
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <?php  echo $this->sto_row->delivery_shipping_street; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
                                                            <label for="name">
                                                                <?php echo JText::_( 'City,Zip Code' ); ?>:
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <?php  echo $this->sto_row->delivery_shipping_zipcode; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
                                                            <label for="name">
                                                                <?php echo JText::_( 'Phone Number' ); ?>:
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <?php  echo $this->sto_row->delivery_shipping_phone; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                             
                                            <td class="tg-0pky-pr tg-0pky-border" width="500px" >
                                                <table class="tgi" cellspacing="1" width="100%">
                                                    <tr>
                                                        <td class="key"  width="30%">
                                                            <label for="name">
                                                                <?php echo JText::_( 'Name' ); ?>:
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <?php  echo $this->sto_row->delivery_billing_name; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
                                                            <label for="name">
                                                                <?php echo JText::_( 'Company Name' ); ?>:
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <?php  echo $this->sto_row->delivery_billing_company; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
                                                            <label for="name">
                                                                <?php echo JText::_( 'Street Address' ); ?>:
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <?php  echo $this->sto_row->delivery_billing_street; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
                                                            <label for="name">
                                                                <?php echo JText::_( 'City,Zip Code' ); ?>:
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <?php  echo $this->sto_row->delivery_billing_zipcode; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key">
                                                            <label for="name">
                                                                <?php echo JText::_( 'Phone Number' ); ?>:
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <?php  echo $this->sto_row->delivery_billing_phone; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                             </tr>
                                           </table>

<table class="tgi" width="100%">
<!--    <tr>
        <td class="tg-0pky-pr-title" colspan="4">Shipping Part</td>
    </tr>-->
    <tr>
        <td class="tg-0pky-pr" colspan="4" style="padding:10px 0px">
            <?php if (count($this->sto_pn_list) > 0) { ?>
            <table class="tgi" width="100%">
                <thead>
                <tr>
                    <th width="18"  style="text-align:center;border-left:1px;border-width:1px;border-style:solid" class="tg-0pky-pr tg-0pky-border"><?php echo JText::_('NUM'); ?></th>
                    <th width="100" style="text-align:center;border-left:1px;border-width:1px;border-style:solid" class="tg-0pky-pr tg-0pky-border"><?php echo JText::_('PN'); ?></th>
                    <th width="100" style="text-align:center;border-left:1px;border-width:1px;border-style:solid" class="tg-0pky-pr tg-0pky-border"><?php echo JText::_('Description'); ?></th>
                    <th width="100" style="text-align:center;border-left:1px;border-width:1px;border-style:solid" class="tg-0pky-pr tg-0pky-border"><?php echo JText::_('UOM'); ?></th>
                    <th width="100" style="text-align:center;border-left:1px;border-width:1px;border-style:solid" class="tg-0pky-pr tg-0pky-border"><?php echo JText::_('Qty'); ?></th>
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
                        <td style="text-align:center;border-left:1px;border-width:1px;border-style:solid" class="tg-0pky-pr tg-0pky-border"><?php echo $i; ?></td>
                        <td style="text-align:left;border-left:1px;border-width:1px;border-style:solid" class="tg-0pky-pr tg-0pky-border"><?php echo $pns_code;?></td>
                        <td style="text-align:left;border-left:1px;border-width:1px;border-style:solid" class="tg-0pky-pr tg-0pky-border"><?php echo $row->pns_description; ?></td>
                        <td style="text-align:center;border-left:1px;border-width:1px;border-style:solid" class="tg-0pky-pr tg-0pky-border"><?php echo $row->pns_uom; ?></td>
                        <td style="text-align:center;border-left:1px;border-width:1px;border-style:solid" class="tg-0pky-pr tg-0pky-border" colspan="2">
                                <?php
                                $totalQty = 0;
                                foreach ($this->sto_pn_list2 as $rw) {
                                    if($rw->pns_id==$row->pns_id)
                                    {
                                        $totalQty += $rw->qty;
                                    }
                                }
                                echo $totalQty;
                                ?>
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
        <td class="tg-0pky-pr" style="text-align:right" colspan="4">Receive date: <?php echo JHTML::_('date', date("Y-m-d H:i:s"), JText::_('DATE_FORMAT_LC5')); ?></td>
    </tr>
</table>