<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php JHTML::_('behavior.modal'); ?>

<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);	
	$role = JAdministrator::RoleOnComponent(11);
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
    .tgi  {border-collapse:collapse;border-spacing:0;align-content: center}
    .tgi td{font-family:Arial, Helvetica, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:black;}
    .tgi th{font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:black;}
    .tgi-pn  {border-collapse:collapse;border-spacing:0;align-content: center}
    .tgi-pn td{font-family:Arial, Helvetica, sans-serif;font-size:14px;padding:0px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:black;}
    .tgi-pn th{font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:normal;padding:0px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:black;}
    .tgi .tg-88nc{font-weight:bold;border-color:inherit;text-align:center;font-size: 20px;color: #0B55C4}
    .tgi .tg-kiyi{font-weight:bold;font-size: 11px;border-color:inherit;text-align:left}
    .tgi .tg-c3ow{text-align:center;vertical-align:top}
    .tgi .tg-c3ow-des{border-color:inherit;border-style:solid;border-width:1px;text-align:center;vertical-align:top}
    .tgi .tg-xldj-pr{text-align:right}
    .tgi .tg-0pky-pr{text-align:left;vertical-align:top}
    .tgi .tg-0pky-border{border-width:1px;border-style:solid}
    .tgi .tg-0pky-border-r{border-right:1px;border-top:1px;border-style:solid}
    .tgi .tg-0pky-pr-title{border-color:inherit;text-align:left;vertical-align:top;font-size: 18px;color: #0B55C4}
    .tgi .tg-0pky-ito-title{border-color:inherit;text-align:center;vertical-align:top;font-size: 13px;color: #000}
</style>
<table class="tgi" width="100%">
    <tr>
        <th class="tg-kiyi" colspan="3">
            ASCENX TECHNOLOGIES
            <br>Unit 5B, 5th Floor, Standard Factory Building
            <br>Road 14, Tan Thuan EPZ, Tan Thuan Dong Ward,
            <br>District 7, HCMC, Vietnam<br>Tax ID: 0305.399.533<br>(O) : (8428) 3620.5581<br>(F):  (8428) 3620.5583</th>
        <th class="tg-xldj-pr" colspan="3">
            <img src="./templates/khepri/images/h_green/logo1.png" width="200px"></img>
            <br></th>
    </tr>
    <tr>
        <td class="tg-88nc" colspan="6">TOOL TRANSACTION ORDER</td>
    </tr>
    <tr>
        <td class="tg-xldj-pr" colspan="6"></td>
    </tr>
    <tr>
        <td class="tg-0pky-ito-title" colspan="6">
         <?php
            $img			=	code128BarCode($this->tto_row->tto_code, 1);
            //Start output buffer to capture the image
            //Output PNG image
            ob_start();
            imagepng($img);
            //Get the image from the output buffer
            $output_img		=	ob_get_clean();
            echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '" /><br>'.$this->tto_row->tto_code;
             ?></td>
    </tr>
    <tr>
        <td class="tg-0pky-pr" colspan="6"></td>
    </tr>
    <tr>
        <td class="tg-0pky-pr tg-0pky-border" style="border-right:0px;border-right:0px;width:15%"><?php echo JText::_( 'Created Date' ); ?>:</td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-left:0px;border-right:0px;width:15%"><?php echo JHTML::_('date', $this->tto_row->tto_created, JText::_('DATE_FORMAT_LC5')); ?></td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-right:0px"><?php echo JText::_( 'WO' ); ?>:</td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-left:0px"><?php echo ($this->tto_row->wo_code)?$this->tto_row->wo_code:"NA";?></td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-right:0px"></td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-left:0px"></td>
    </tr>
    <tr>
        <td class="tg-0pky-pr tg-0pky-border" style="border-right:0px"><?php echo JText::_( 'Completed Date' ); ?>:</td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-left:0px"><?php echo ($this->tto_row->tto_completed_date!='0000-00-00 00:00:00')?JHTML::_('date', $this->tto_row->tto_completed_date, JText::_('DATE_FORMAT_LC5')):""; ?></td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-right:0px"><?php echo JText::_( 'Due Date' ); ?>:</td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-left:0px"><?php echo ($this->tto_row->tto_due_date!='0000-00-00 00:00:00')?JHTML::_('date', $this->tto_row->tto_due_date, JText::_('DATE_FORMAT_LC5')):""; ?></td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-right:0px"></td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-left:0px"></td>
    </tr>
    <tr>
        <td class="tg-0pky-pr tg-0pky-border" style="border-right:0px"><?php echo JText::_( 'Status' ); ?>:</td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-left:0px"><?php echo $this->tto_row->tto_state;?></td>
        <td class="tg-0pky-pr tg-0pky-border" width="250px"><?php echo JText::_( 'Tool Assigner' ); ?>: <?php echo ($this->tto_row->tto_create_by)?GetValueUser($this->tto_row->tto_create_by, "name"):""; ?></td>
        <td class="tg-0pky-pr tg-0pky-border"><?php echo JText::_( 'Comfirm' ); ?>:<input checked="checked" type="checkbox" name="sto_stocker_confirm" value="1" onclick="return false;" onkeydown="return false;" /></td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-right:0px"><?php echo JText::_( 'Date Out' ); ?>:</td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-left:0px"><?php echo ($this->tto_row->tto_owner_out_confirm_date!='0000-00-00 00:00:00')?JHTML::_('date', $this->tto_row->tto_owner_out_confirm_date, JText::_('DATE_FORMAT_LC5')):""; ?></td>    
    </tr>
    <tr>
        <td class="tg-0pky-pr tg-0pky-border" style="border-right:0px"><?php echo JText::_( 'Description' ); ?>:</td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-left:0px"><?php echo strtoupper($this->tto_row->tto_description)?></td>
        <td class="tg-0pky-pr tg-0pky-border" width="150px"><?php echo JText::_( 'Owner' ); ?>: <?php echo ($this->tto_row->tto_owner_in)?GetValueUser($this->tto_row->tto_owner_in, "name"):""; ?></td>
        <td class="tg-0pky-pr tg-0pky-border"><?php echo JText::_( 'Comfirm' ); ?>:
                <?php 
                $style="";
                if($this->tto_row->tto_owner_in_confirm)
                {
                         $style='checked="checked"';
                }
                ?>
                <input <?php echo $style;?> type="checkbox" name="sto_stocker_confirm" value="1" onclick="return false;" onkeydown="return false;" /></td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-right:0px"><?php echo JText::_( 'Date In' ); ?>:</td>
        <td class="tg-0pky-pr tg-0pky-border" style="border-left:0px"><?php echo ($this->tto_row->tto_owner_in_confirm_date!='0000-00-00 00:00:00')?JHTML::_('date', $this->tto_row->tto_owner_in_confirm_date, JText::_('DATE_FORMAT_LC5')):""; ?></td>    
    </tr>
    
    <tr>
        <td class="tg-0pky-pr" colspan="6"></td>
    </tr>

    <tr>
        <td class="tg-0pky-pr" colspan="6"></td>
    </tr>
    <tr>
        <td class="tg-0pky-pr-title" colspan="6">Tools</td>
    </tr>
    <tr>
        <td class="tg-0pky-pr" colspan="6">
            <?php if (count($this->tto_pn_list) > 0) { ?>
            <table class="tgi" width="100%">
                <thead>
                <tr>
                    <th  class="tg-0pky-pr tg-0pky-border" align="center" width="10" style="text-align:center;border-left:1px;border-width:1px;border-style:solid"><?php echo JText::_('NUM'); ?></th>
                    <th class="tg-0pky-pr tg-0pky-border" align="center" width="100" style="text-align:center;border-left:1px;border-width:1px;border-style:solid"><?php echo JText::_('PN'); ?></th>
                    <th  class="tg-0pky-pr tg-0pky-border" align="center" width="150" style="text-align:center;border-left:1px;border-width:1px;border-style:solid"><?php echo JText::_('Description'); ?></th>
                    <th  class="tg-0pky-pr tg-0pky-border" align="center" width="80" style="text-align:center;border-left:1px;border-width:1px;border-style:solid"><?php echo JText::_('UOM'); ?></th>
                    <th  class="tg-0pky-pr tg-0pky-border" align="center" width="60" style="text-align:center;border-left:1px;border-width:1px;border-style:solid"><?php echo JText::_('QTY'); ?></th>
                    <th  class="tg-0pky-pr tg-0pky-border" align="center" width="80" style="text-align:center;border-left:1px;border-width:1px;border-style:solid"><?php echo JText::_('Tool ID'); ?></th>
                    <th  class="tg-0pky-pr tg-0pky-border" align="center" width="80" style="text-align:center;border-left:1px;border-width:1px;border-style:solid"><?php echo JText::_('Part State'); ?></th>
                    
                </tr>
                </thead>
                <tbody>
                <?php



                $i = 0;
                foreach ($this->tto_pn_list as $row) {
                    $i++;
                    $ttoList = TToController::GetTtoFrommPns($row->pns_id,$tto_id);
                    if($row->pns_revision)
                        $pns_code = $row->ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision;
                    else
                        $pns_code = $row->ccs_code.'-'.$row->pns_code;

                    ?>
                    <tr>
                        <td class="tg-0pky-pr tg-0pky-border"  align="center" style="text-align:center;border-left:1px;border-width:1px;border-style:solid"><?php echo $i; ?></td>
                        <td  class="tg-0pky-pr tg-0pky-border" align="center" style="text-align:left;border-left:1px;border-width:1px;border-style:solid"><?php echo $pns_code;?></td>
                        <td class="tg-0pky-pr tg-0pky-border"  align="left" style="text-align:left;border-left:1px;border-width:1px;border-style:solid"><?php echo $row->pns_description; ?></td>
                        <td  class="tg-0pky-pr tg-0pky-border" align="center" style="text-align:center;border-left:1px;border-width:1px;border-style:solid"><?php echo $row->pns_uom; ?></td>
                        <td class="tg-0pky-pr tg-0pky-border"  align="center" style="text-align:center;padding:0px" colspan="3">
                            <table class="tgi" width="100%">
                                <?php
                                foreach ($this->tto_pn_list2 as $rw) {
                                    if($rw->pns_id==$row->pns_id)
                                    {
                                        ?>
                                        <tr><td width="60" class="tg-0pky-pr tg-0pky-border-r" style="text-align:center;" align="center" width="77.5px">
                                               <?php echo $rw->qty;?>                                                
                                            </td>
                                             <td width="80" class="tg-0pky-pr tg-0pky-border-r" style="text-align:center;" align="center" width="77px">
                                                      <?php echo $rw->location?TToController::GetCodeLocation($rw->location):"";?>                                                     
                                                </td>	
                                                <td width="80" class="tg-0pky-pr tg-0pky-border-r" style="text-align:center;"  align="center" width="77px">
                                                       <?php echo $rw->partstate?strtoupper($rw->partstate):"";?>                                                         
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
                    echo "Not Found Tool";
                }
                ?>
                </tbody>
            </table>

        </td>
    </tr>
</table>