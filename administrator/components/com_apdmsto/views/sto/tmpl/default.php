<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
$cid = JRequest::getVar('cid', array(0));
$edit = JRequest::getVar('edit', true);

//JToolBarHelper::title("STOCK Management", 'cpanel.png');
$role = JAdministrator::RoleOnComponent(8);      
if (in_array("W", $role)) {
      //  JToolBarHelper::addNewito("New ITO", $this->row->pns_id);
        JToolBarHelper::customX('addito', 'new', '', 'New ITO', false);        
        JToolBarHelper::customX('addeto', 'new', '', 'New ETO', false);
        //JToolBarHelper::addNeweto("New ETO", $this->row->pns_id);
        
}
if (in_array("S", $role)) {
        JToolBarHelper::addMoveLocation("Move Location", $this->row->pns_id);
}
//if (in_array("D", $role)) {
//        //viet comment
//        JToolBarHelper::deletePns('Are you sure to delete it?',"removestos","Delete STO");
//}
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
                if (pressbutton == 'btnSubmit') {
                        var d = document.adminForm;
                        if ( document.adminForm.text_search.value==""){
                                alert("Please input keyword");	
                                d.text_search.focus();
                                return false;				
                        }else{                                
                                document.adminForm.submit();
                                submitform( pressbutton );
				
                        }
                }
                
                 if (pressbutton == 'search_qty') {
                        submitform( pressbutton );
                        return;
                }
                if (pressbutton == 'removestos') {
                        submitform( pressbutton );
                        return;
                }
                if (pressbutton == 'addito') {
                        submitform( pressbutton );
                        return;
                }
                if (pressbutton == 'addeto') {
                        submitform( pressbutton );
                        return;
                }
			
        }
</script>
<style>
section {
  position: relative;
  padding-top: 30px;
      text-align: center;
    background: #f0f0f0;
    color: #666;
    border-bottom: 1px solid #999;
    border-left: 1px solid #fff;
}
section.positioned {
  position: absolute;
  top:100px;
  left:100px;
  width:800px;
  box-shadow: 0 0 15px #333;
}
.container {
  overflow-y: auto;
  height: 160px;
}
table {
  border-spacing: 0;
  width:100%;
}
td + td {
  border-left:1px solid #eee;
}
td, th {
  border-bottom:1px solid #eee;
  padding: 10px 10px 7px 0px;
}
th {
  height: 0;
  line-height: 0;
  padding-top: 0;
  padding-bottom: 0;
  color: transparent;
  border: none;
  white-space: nowrap;
}
th div{
  position: absolute;
  background: transparent;
     color: #666;
  padding: 10px;
  top: 0;
  line-height: normal;
    border-left: 1px solid #fff;
}
th:first-child div{
  border: none;
}
</style>
<div class="clr"></div>
<form action="index.php"   onsubmit="submitbutton('')"  method="post" name="adminForm" >	
        <input type="hidden" name="query_exprot" value="<?php echo $this->lists['query'];?>" />
<input type="hidden" name="total_record" value="<?php echo $this->lists['total_record'];?>" />
 <fieldset class="adminform">
		<legend><font style="size:14px"><?php echo JText::_( 'Delivery' ); ?> </font></legend>                          
<section class="">
<div class="col width-100 scroll container">
<?php if (count($this->stos_list) > 0) { ?>
                <table class="adminlist1" cellspacing="1" width="400">
                         <thead>
                               <tr class="header">
                                        <th  class="title" width="50"><?php echo JText::_('NUM'); ?><div style="width:50px;padding:10px 0px 0px 15px"><?php echo JText::_('No.'); ?></div></th>
                                        <th  class="title" width="100"><?php echo JText::_('ITO/ETO'); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_('ITO/ETO'); ?></div></th>
                                        <th  class="title" width="100"><?php echo JText::_('Description'); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_('Description'); ?></div></th>
                                        <th  class="title" width="100"><?php echo JText::_('State'); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_('State'); ?></div></th>
                                        <th  class="title" width="100"><?php echo JText::_('Created Date'); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_('Created Date'); ?></div></th>
                                        <th  class="title" width="100"><?php echo JText::_('Owner'); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_('Owner'); ?></div></th>
                                        <th  class="title" width="100"><?php echo JText::_('Created By'); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_('Created By'); ?></div></th>
                                        <th  class="title" width="100"><?php echo JText::_('Time Remain'); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_('Time Remain'); ?></div></th>
                                        <th  class="title" width="100"></th>
                                </tr>
                        </thead>                  
                        <tbody>					
        <?php
        $i = 0;
        foreach ($this->stos_list as $sto) {
                $i++;
                ?>
                                        <tr>
                                                <td align="center"><?php echo $i+$this->pagination->limitstart;?></td>
                                                <td align="center">
                                                        <?php
                                                                $style="";
                                                                $link = "index.php?option=com_apdmsto&task=ito_detail&id=".$sto->pns_sto_id;
                                                                $linkedit = "index.php?option=com_apdmsto&task=editito&id=".$sto->pns_sto_id."&sto_type=".$sto->sto_type;
                                                                if($sto->sto_type==2){
                                                                        $style="color: #f00";
                                                                        $link = "index.php?option=com_apdmsto&task=eto_detail&id=".$sto->pns_sto_id;
                                                                        $linkedit = "index.php?option=com_apdmsto&task=editeto&id=".$sto->pns_sto_id."&sto_type=".$sto->sto_type;
                                                                }elseif($sto->sto_type==3){
                                                                        $link = "index.php?option=com_apdmpns&task=sto_detail_movelocation&id=".$sto->pns_sto_id;
                                                                }
                                                                ?>
                                                        <a style="<?php echo $style?>" href="<?php echo $link;?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $sto->sto_code; ?></a> </td>
                                                
                                                <td align="left" style="<?php //echo $style?>" ><?php echo $sto->sto_description; ?></td>
                                                <td align="center" style="<?php //echo $style?>" >
                                                    <?php echo $sto->sto_state; ?>
                                                </td>
                                                <td align="center"  style="<?php //echo $style?>" >
                                                        <?php echo JHTML::_('date', $sto->sto_created, JText::_('DATE_FORMAT_LC6')); ?>
                                                </td>
                                                <td align="center"  style="<?php //echo $style?>" >
                                                        <?php echo GetValueUser($sto->sto_owner, "name"); ?>
                                                </td> 
                                                <td align="center"  style="<?php //echo $style?>" >
                                                        <?php echo GetValueUser($sto->sto_create_by, "name"); ?>
                                                </td>
                                                <td align="center" ></td>
                                                <td align="center"  style="<?php //echo $style?>" ><?php if (in_array("E", $role)) {

                                                        ?>
                                                        <a style="<?php //echo $style?>"  href="<?php echo $linkedit; ?>" title="Click to edit"><?php echo JText::_('Edit') ?></a>
                                                        <?php
                                                }
                                                        ?>
                                                </td></tr>
                                                <?php }
                                        } ?>
                </tbody>
                </table></div></section>
      </fieldset>


<fieldset class="adminform">
		<legend><font style="size:14px"><?php echo JText::_( 'Warehouse Status' ); ?> </font></legend>                          
                <table width="100%" border="0">
                        <tr>
                                <td align="right">
                                        QTY From&nbsp;&nbsp;<input type="text" maxlength="20" name="qty_from"  onKeyPress="return numbersOnly(this, event);" id="qty_from" class="inputbox" size="30" value="<?php echo $this->qty_from?>"/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        To&nbsp;&nbsp;<input type="text" maxlength="20" name="qty_to"  onKeyPress="return numbersOnly(this, event);" id="qty_to" class="inputbox" size="30" value="<?php echo $this->qty_to?>"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="submit"  onclick="submitbutton('search_qty')"  name="search_qty" value="Go">
                                        <a href="index.php?option=com_apdmsto&amp;task=sto&amp;clean=all"><input type="button" value="Reset"></a>
                                </td>
                        </tr>
                </table>
                <section class="">
                <div class="col width-100 scroll container">
                        <?php if (count($this->warehouse_list) > 0) { ?>
                        <table class="adminlist1" cellspacing="1" width="400">
		<thead>
			<tr>
				<th  width="50" align="center" class="title">
					<?php echo JText::_( 'No.' ); ?><div style="width:50px;padding:10px 0px 0px 10px"><?php echo JText::_( 'NUM' ); ?></div>
				</th>
				<th class="title"  width="100">
					<?php  JText::_('PART_NUMBER_CODE'); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_( 'PART_NUMBER_CODE' ); ?></div>
				</th>          
				<th class="title"  width="100" >
					<?php echo JText::_( 'PNS_DESCRIPTION' ); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_( 'PNS_DESCRIPTION' ); ?></div>
				</th>
                                <th  width="100"class="title" >
					<?php echo JText::_( 'MFR Name' ); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_( 'MFR Name' ); ?></div>
				</th>
                                <th width="100" class="title" >
					<?php echo JText::_( 'MFR PN' ); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_( 'MFG PN' ); ?></div>
				</th>
                                <th  width="100" class="title" >
					<?php echo JText::_( 'Supplier' ); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_( 'Supplier' ); ?></div>
				</th>	
                                 <th  width="100" class="title" >
					<?php echo JText::_( 'Supplier PN' ); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_( 'Supplier PN' ); ?></div>
				</th>
                                <th  width="100" class="title" >
					<?php echo JText::_( 'Vendor' ); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_( 'Vendor' ); ?></div>
				</th>	
                                 <th  width="100" class="title" >
					<?php echo JText::_( 'Vendor PN' ); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_( 'Vendor PN' ); ?></div>
				</th>
                                 <th width="100" class="title" >
					<?php echo JText::_( 'Inventory' ); ?><div style="width:100px;padding:10px 0px 0px 25px"><?php echo JText::_( 'Inventory' ); ?></div>
				</th>
			</tr>
		</thead>		
		<tbody>
		<?php
			$path_image = '../uploads/pns/images/';
			$k = 0;
                                                                                                   
			for ($i=0, $n=count( $this->warehouse_list ); $i < $n; $i++) {
                $row =& $this->warehouse_list[$i];
               // if (($this->qty_from =="") && $row->inventory > 0) {
                    if ($row->pns_cpn == 1)
                        $link = 'index.php?option=com_apdmpns&amp;task=detailmpn&cid[0]=' . $row->pns_id;
                    else
                        $link = 'index.php?option=com_apdmpns&amp;task=detail&cid[0]=' . $row->pns_id;
                    if ($row->pns_revision)
                        $pns_code = $row->ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                    else
                        $pns_code = $row->ccs_code . '-' . $row->pns_code;

                    $mf = SToController::GetManufacture($row->pns_id, 4);//manufacture
                    $ms = SToController::GetManufacture($row->pns_id, 3);//Supplier
                    $mv = SToController::GetManufacture($row->pns_id, 2);//vendor

                    $stock = SToController::CalculateInventoryValue($row->pns_id);
                $background = "";
                if ($stock <= 3) {
                    $background = "style='background-color:#f00;color:#fff'";
                }
                $qty_from =  $this->qty_from;
                $qty_to =  $this->qty_to;
                if($qty_from && $qty_to)
                {
                    if($stock<$qty_from || $stock>$qty_to)
                        continue;
                }
                elseif($qty_to)
                {
                    if($stock>$qty_to)
                        continue;
                }
                elseif($qty_from)
                {
                    if($stock<$qty_from )
                        continue;
                }
                else{
                    if($stock<=0 || $stock>10)
                        continue;
                }

                    ?>
                    <tr class="<?php echo "row$k"; ?>">
                        <td align="center" width="50">
                            <?php echo $i + 1 + $this->pagination->limitstart; ?>
                        </td>
                        <td align="left" >
                            <a href="<?php echo $link; ?>"
                               title="<?php echo JText::_('Click to see detail PNs'); ?>"><?php echo $pns_code; ?></a>
                        </td>
                        <td align="left" >
                            <?php echo $row->pns_description; ?>
                        </td>
                        <td align="left" >
                            <?php
                            if (count($mf) > 0) {
                                foreach ($mf as $m) {
                                    echo $m['mf'].' &nbsp;&nbsp;<br />';
                                }
                            }
                            ?>
                        </td>
                        <td align="left" >
                            <?php
                            if (count($mf) > 0) {
                                foreach ($mf as $m) {
                                    echo $m['v_mf'].' &nbsp;&nbsp;<br />';
                                }

                            }
                            ?>
                        </td>
                        <td align="left" >
                            <?php
                            if (count($ms) > 0) {
                                foreach ($ms as $m) {
                                    echo $m['mf'].' &nbsp;&nbsp;<br />';
                                }
                            }
                            ?>
                        </td>
                        <td align="left" >
                            <?php
                            if (count($ms) > 0) {
                                foreach ($ms as $m) {
                                    echo $m['v_mf'].' &nbsp;&nbsp;<br />';
                                }

                            }
                            ?>
                        </td>
                        <td align="left" >
                            <?php
                            if (count($mv) > 0) {
                                foreach ($mv as $m) {
                                    echo $m['mf'].' &nbsp;&nbsp;<br />';
                                }
                            }
                            ?>
                        </td>
                        <td align="left" >
                            <?php
                            if (count($mv) > 0) {
                                foreach ($mv as $m) {
                                    echo $m['v_mf'].' &nbsp;&nbsp;<br />';
                                }

                            }
                            ?>
                        </td>
                        <td align="center" <?php echo $background; ?>>
                            <?php
                            echo $stock;
                            $inventory = round($row->inventory, 2);
                            if ($inventory <= 0)
                                $inventory = 0;
                            //echo $inventory;
                            ?>
                        </td>
                    </tr>
                    <?php
                    $k = 1 - $k;
                }
          //  }
			?>
		</tbody>
	</table>
                        <?php 
                        }?>
                </div>
                </section>
</fieldset>


        <input name="nvdid" value="<?php echo $this->lists['count_vd']; ?>" type="hidden" />
        <input name="nspid" value="<?php echo $this->lists['count_sp']; ?>" type="hidden" />
        <input name="nmfid" value="<?php echo $this->lists['count_mf']; ?>" type="hidden" />
        <input type="hidden" name="pns_id" value="<?php echo $this->row->pns_id; ?>" />
        <input type="hidden" name="cid[]" value="<?php echo $this->row->pns_id; ?>" />	
        <input type="hidden" name="option" value="com_apdmsto" />
        <input type="hidden" name="task" value="sto" />
        <input type="hidden" name="redirect" value="mep" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="return" value="<?php echo $this->cd; ?>"  />
<?php echo JHTML::_('form.token'); ?>
</form>
