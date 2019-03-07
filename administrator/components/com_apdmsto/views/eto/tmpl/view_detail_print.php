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
    .tgi  {border-collapse:collapse;border-spacing:0;align-content: center;width:100%}
    .tgi td{font-family:Arial, Helvetica, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:black;}
    .tgi th{font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:black;}
    .tgi .tg-88nc{font-weight:bold;border-color:inherit;text-align:center;font-size: 20px;color: #0B55C4}
    .tgi .tg-kiyi{font-weight:bold;font-size: 11px;border-color:inherit;text-align:left}
    .tgi .tg-c3ow{text-align:center;vertical-align:top}
    .tgi .tg-c3ow-des{border-color:inherit;border-style:solid;border-width:1px;text-align:center;vertical-align:top}
    .tgi .tg-xldj-pr{text-align:right}
    .tgi .tg-0pky-pr{text-align:left;vertical-align:top}
    .tgi .tg-0pky-border{border-width:1px;border-style:solid}
    .tgi .tg-0pky-pr-title{border-color:inherit;text-align:left;vertical-align:top;font-size: 18px;color: #0B55C4}
    .tgi .tg-0pky-ito-title{border-color:inherit;text-align:center;vertical-align:top;font-size: 16px;color: #0B55C4}
    .adminlist1 th{border-width:1px;border-style:solid}
    .adminlist1 td{border-width:1px;border-style:solid}
</style>
<table class="tgi" width="100%">
    <tr>
        <th class="tg-kiyi" colspan="2">
            ASCENX TECHNOLOGIES
            <br>Unit 5B, 5th Floor, Standard Factory Building
            <br>Road 14, Tan Thuan EPZ, Tan Thuan Dong Ward,
            <br>District 7, HCMC, Vietnam<br>ST ZIP Code: 0305.399.533<br>(O) : (8428) 3620.5581<br>(F):  (8428) 3620.5583</th>
        <th class="tg-xldj-pr" colspan="2">
            <img src="./templates/khepri/images/h_green/logo1.png" width="200px"></img>
            <br></th>
    </tr>
    <tr>
        <td class="tg-88nc" colspan="4">EXPORT TRANSACTION ORDER</td>
    </tr>
    <tr>
        <td class="tg-xldj-pr"></td>
        <td class="tg-xldj-pr"></td>
        <td class="tg-xldj-pr"></td>
        <td class="tg-xldj-pr"></td>
    </tr>
    <tr>
        <td class="tg-0pky-ito-title" colspan="4">ETO# <?php echo $this->sto_row->sto_code; ?></td>
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
        <td class="tg-0pky-pr tg-0pky-border" style="border-right:0px">WO#</td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-left:0px"><?php echo $this->sto_row->wo_code;?></td>
    </tr>
    <tr>
        <td class="tg-0pky-pr tg-0pky-border" style="border-right:0px">Completed date:</td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-left:0px"><?php echo ($this->sto_row->sto_completed_date!='0000-00-00 00:00:00')?JHTML::_('date', $this->sto_row->sto_completed_date, JText::_('DATE_FORMAT_LC5')):""; ?></td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-right:0px">Customer:</td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-left:0px"><?php  echo $this->sto_row->ccs_name; ?></td>
    </tr>
    <tr>
        <td class="tg-0pky-pr tg-0pky-border" rowspan="3" style="border-right:0px">State:</td>
        <td class="tg-0pky-pr tg-0pky-border" rowspan="3" style="border-left:0px"><?php echo $this->sto_row->sto_state;?></td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-right:0px">PO#:</td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-left:0px"><?php
            $soNumber = $this->sto_row->so_cuscode;
            if($this->sto_row->ccs_code)
            {
                $soNumber = $this->sto_row->ccs_code."-".$soNumber;
            }
            echo $soNumber;
            ?></td>
    </tr>
    <tr>
        <td class="tg-0pky-pr tg-0pky-border">Stocker: <?php echo ($this->sto_row->sto_stocker)?GetValueUser($this->sto_row->sto_stocker, "name"):""; ?></td>
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
           Description:<?php echo strtoupper($this->sto_row->sto_description)?></td>
    </tr>
    <tr>
        <td class="tg-0pky-pr"></td>
        <td class="tg-0pky-pr"></td>
        <td class="tg-0pky-pr"></td>
        <td class="tg-0pky-pr"></td>
    </tr>
    <tr>
        <td class="tg-0pky-pr-title" colspan="4">Shipping Part</td>
    </tr>
    <tr>
        <td class="tg-0pky-pr" colspan="4">
            <?php if (count($this->sto_pn_list) > 0) { ?>
                <table class="tgi" width="100%">
                <thead>
                <tr>
                    <th width="18" class="tg-0pky-pr tg-0pky-border"><?php echo JText::_('#'); ?></th>
                    <th width="100" class="tg-0pky-pr tg-0pky-border"><?php echo JText::_('PN'); ?></th>
                    <th width="100" class="tg-0pky-pr tg-0pky-border"><?php echo JText::_('Description'); ?></th>
                    <th width="100" class="tg-0pky-pr tg-0pky-border"><?php echo JText::_('UOM'); ?></th>
                    <th width="100" class="tg-0pky-pr tg-0pky-border"><?php echo JText::_('Qty'); ?></th>
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
                        <td class="tg-0pky-pr tg-0pky-border"><?php echo $i; ?></td>
                        <td class="tg-0pky-pr tg-0pky-border"><?php echo $pns_code;?></td>
                        <td class="tg-0pky-pr tg-0pky-border"><?php echo $row->pns_description; ?></td>
                        <td class="tg-0pky-pr tg-0pky-border"><?php echo $row->pns_uom; ?></td>
                        <td  class="tg-0pky-pr tg-0pky-border" colspan="2">
                            <!--<table class="adminlist" style="color:#000" cellspacing="0" width="200">-->
                                <?php
                                $totalQty = 0;
                                foreach ($this->sto_pn_list2 as $rw) {
                                    if($rw->pns_id==$row->pns_id)
                                    {
                                        $totalQty += $rw->qty;
                                        ?>
                                       <!-- <tr><td align="center" width="74px">
                                                <?php /*echo $rw->qty;*/?>
                                            </td>
                                        </tr>-->
                                        <?php
                                    }
                                }
                                echo $totalQty;
                                ?>
                            <!--</table>-->
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