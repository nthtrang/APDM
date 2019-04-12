<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php
//bom
$row = $this->rows[0];
$pns_code_full = $row->pns_code_full;
if (substr($pns_code_full, -1)=="-"){
    $pns_code_full = substr($pns_code_full, 0, strlen($pns_code_full)-1);
}
$role = JAdministrator::RoleOnComponent(6);


$cparams = JComponentHelper::getParams ('com_media');
?>

<?php
// clean item data
JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );


?>
<script language="javascript">
    window.print();
</script>
<style type="text/css" media="print">
    @page
    {
        size: auto;   /* auto is the current printer page size */
        margin: 4mm;  /* this affects the margin in the printer settings */
    }


</style>
<style type="text/css">
    .tgi  {border-collapse:collapse;border-spacing:0;align-content: center}
    .tgi td{border-width:1px !important;font-family:Arial, Helvetica, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:black;text-align:center}
    .tgi td .barcode{border-width:0px !important;border-left:0px;}
    .tgi th{border-width:1px !important;font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:black;text-align:center}
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
<table width="100%" cellpadding="1">
    <tr>
        <th class="tg-kiyi"  style="text-align:left">
            <img src="./templates/khepri/images/h_green/logo1.png" width="150px"></img></th>
    </tr>
    <tr><td  colspan="10" style="text-align:center"><span style="font-weight:bold;border-color:inherit;text-align:center;font-size: 20px;color: #0B55C4;align-content: center">Bill of Materials</span></td></tr>
</table>
<form action="index.php?option=com_apdmpns" method="post" name="adminForm">
    <?php

    $list_pns_id = PNsController::DisplayPnsChildId($this->lists['pns_id'], $this->lists['pns_id']);

    $new_pns = explode(",", $list_pns_id);
    $list_pns = PNsController::DisplayPnsAllChildId($this->lists['pns_id']);
    ?>
    <div>&nbsp
        <table class="tgi" width="100%">
            <thead>
            <tr>
                <th width="1%" style="border-left:0px;border-right:0px">
                    <?php echo JText::_('NUM')?>
                </th>
                <th width="1%" style="border-left:0px;border-right:0px">
                    <?php echo JText::_('Level')?>
                </th>
                <th width="20%" style="border-left:0px;border-right:0px">
                    <?php echo JText::_('Part Number')?>
                </th>
                <th width="12%" style="border-left:0px;border-right:0px">
                    <?php echo JText::_('Description')?>
                </th>
                <th width="5%" style="border-left:0px;border-right:0px">
                    <?php echo JText::_('F.N')?>
                </th>
                <th width="4%" style="border-left:0px;border-right:0px">
                    <?php echo JText::_('Qty')?>
                </th>
                <th width="5%" style="border-left:0px;border-right:0px">
                    <?php echo JText::_('UOM')?>
                </th>
                <th width="10%" style="border-left:0px;border-right:0px">
                    <?php echo JText::_('MFR Name')?>
                </th>
                <th width="10%" style="border-left:0px;border-right:0px">
                    <?php echo JText::_('MFG PN')?>
                </th>
                <th width="10%" style="border-left:0px;border-right:0px">
                    <?php echo JText::_('Tool PN')?>
                </th>
            </tr>
            </thead>
            <tr>
                <td align="center"  style="border-left:0px;border-right:0px">0</td>
                <td style="border-left:0px;border-right:0px">0</td>
                <td  align="center" width="15%" class="barcode" style="border-left:0px;border-right:0px">
                    <?php
                    $img			=	code128BarCode($pns_code_full, 1);
                    //Start output buffer to capture the image
                    //Output PNG image
                    ob_start();
                    imagepng($img);
                    //Get the image from the output buffer
                    $output_img		=	ob_get_clean();
                    echo '<img   src="data:image/png;base64,' . base64_encode($output_img) . '" /><br>'.$pns_code_full;

                    $manufacture = PNsController::GetManufacture($row->pns_id);

                    ?>
                </td>
                <td style="text-align: left !important;border-left:0px;border-right:0px"><?php echo limit_text($row->pns_description, 15);?></td>
                <td align="center"style="border-left:0px;border-right:0px"><?php echo $row->find_number;?> </td>
                <td align="center" style="border-left:0px;border-right:0px"><?php echo $row->stock;?></td>
                <td align="center" style="border-left:0px;border-right:0px"><?php echo $row->pns_uom;?></td>
                <td align="left"  style="border-left:0px;border-right:0px"><?php echo $manufacture[0]['mf'];?></td>
                <td align="left"  style="border-left:0px;border-right:0px"><?php echo $manufacture[0]['v_mf'];?></td>
                <td align="left" style="border-left:0px;border-right:0px" ><?php
                    // $ToolPN = GetToolPnValue($row->pns_id);
                    $pntool =  PNsController::getToolPnAddtoBom($row->pns_id);

                    foreach($pntool as $pn)
                    {
                        if($pn->pns_revision){
                            $toolpns_code = $pn->ccs_code.'-'.$pn->pns_code.'-'.$pn->pns_revision;
                        }
                        else{
                            $toolpns_code = $pn->ccs_code.'-'.$pn->pns_code;
                        }

                        $img			=	code128BarCode($toolpns_code, 1);
                        //Start output buffer to capture the image
                        //Output PNG image
                        ob_start();
                        imagepng($img);
                        //Get the image from the output buffer
                        $output_img		=	ob_get_clean();
                        echo '<img     src="data:image/png;base64,' . base64_encode($output_img) . '" /><br>'.$toolpns_code."<br>";
                    }
                    ?>
                </td>
            </tr>
            <?php
            //level1
            $level=0;
            $step=0;
            foreach ($list_pns as $row){
                $level++;
                $step++;
                $manufacture = PNsController::GetManufacture($row->pns_id);
                ?>
                <tr>
                    <td align="center" style="border-left:0px;border-right:0px"><?php echo $step;?></td>
                    <td align="center" style="border-left:0px;border-right:0px">1</td>
                    <td  align="center" width="25%" class="barcode" style="border-left:0px;border-right:0px" >
                        <?php
                        $img			=	code128BarCode($row->text, 1);
                        //Start output buffer to capture the image
                        //Output PNG image
                        ob_start();
                        imagepng($img);
                        //Get the image from the output buffer
                        $output_img		=	ob_get_clean();
                        echo '<img     src="data:image/png;base64,' . base64_encode($output_img) . '" /><br>'.$row->text;
                        ?>
                    </td>
                    <td align="left"  style="text-align: left !important;border-left:0px;border-right: 0px"><?php echo limit_text($row->pns_description, 15);?></td>
                    <td align="center" style="border-left:0px;border-right:0px">
                        <?php echo $row->find_number;?>
                    </td>

                    <td align="center" style="border-left:0px;border-right:0px">
                        <?php echo $row->stock;?>
                    </td>
                    <td align="center" style="border-left:0px;border-right:0px"><?php echo $row->pns_uom;?></td>
                    <td align="left" style="border-left:0px;border-right:0px"><?php echo $manufacture[0]['mf'];?></td>
                    <td align="left" style="border-left:0px;border-right:0px"><?php echo $manufacture[0]['v_mf'];?></td>
                    <td align="left" style="border-left:0px;border-right:0px"><?php
                        // $ToolPN = GetToolPnValue($row->pns_id);
                        $pntool =  PNsController::getToolPnAddtoBom($row->pns_id);

                        foreach($pntool as $pn)
                        {
                            if($pn->pns_revision){
                                $toolpns_code = $pn->ccs_code.'-'.$pn->pns_code.'-'.$pn->pns_revision;
                            }
                            else{
                                $toolpns_code = $pn->ccs_code.'-'.$pn->pns_code;
                            }

                            $img			=	code128BarCode($toolpns_code, 1);
                            //Start output buffer to capture the image
                            //Output PNG image
                            ob_start();
                            imagepng($img);
                            //Get the image from the output buffer
                            $output_img		=	ob_get_clean();
                            echo '<img     src="data:image/png;base64,' . base64_encode($output_img) . '" /><br>'.$toolpns_code."<br>";
                        }
                        ?>
                    </td>
                </tr>

                <?php
            }
            ?>
        </table>
    </div>
    <input type="hidden" name="option" value="com_apdmpns" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="pns_id" value="<?php echo $this->lists['pns_id'];?>"  />
    <input type="hidden" name="return" value="<?php echo $this->lists['pns_id'];?>"  />
    <input type="hidden" name="cd" value="<?php echo $this->lists['pns_id'];?>"  />
</form>


