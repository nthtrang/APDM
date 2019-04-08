<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

$pns_id =$cid[0];	
?>
<script language="javascript">
function CheckForm() {

			if (document.adminForm.text_search.value==""){
				alert("Please input keyword to filter");
				return false;
			}
			if (document.adminForm.type_filter.value==0){
				alert("Please select type to filter");
				return false;			
			}
		
	
}
function UpdatePnsTool(){        
        var pns_id = $('pns_id').value;     
	if ($('boxchecked').value==0){
		alert('Please select PNs.');
		return false;
	}else{
		var url = 'index.php?option=com_apdmpns&task=ajax_add_pnstool_bom&pns_id='+pns_id;
		var MyAjax = new Ajax(url, {
			method:'post',
			data:  $('adminFormPns').toQueryString(),
			onComplete:function(result){			
				window.parent.document.getElementById('sbox-window').close();	
                                window.parent.location.reload();
			}
		}).request();
	}
	
}
function autoAddPartTool(pns,parent_id)
{
        var url = 'index.php?option=com_apdmpns&task=ajax_scanadd_pnstool_bom&pns_id='+parent_id+'&pns_code='+pns;
        var MyAjax = new Ajax(url, {
                method:'get',
                onComplete:function(result){
                   document.getElementById('notice').innerHTML = "Have add PN successfull.";	       
                   document.getElementById('pns_code').value ="";
                    window.parent.document.getElementById('tool_pnlists').innerHTML =result;
                   document.getElementById('pns_code').focus();
                }
        }).request();        
}
</script>
<form action="index.php?option=com_apdmpns&task=get_pntoolboom&tmpl=component&cid[]=<?php echo $pns_id?>" method="post" name="adminForm" id="adminFormPns"  >
<input type="hidden" name="id" value="<?=$this->id?>" />
<div name="notice" style="color:#D30000" id ="notice"></div>
<table  width="100%">
		<tr>
			<td colspan="4"  >
				<?php echo JText::_( 'Search' ); ?>:
				<input type="text" name="text_search" id="text_search" value="<?php echo $this->lists['search'];?>" class="text_area"  size="40" />&nbsp;&nbsp;<?php echo JText::_('Filter')?> 
                                
				<?php echo $this->lists['type_filter'];?>
				&nbsp;&nbsp;
			<button><?php echo JText::_( 'Go' ); ?></button>
			<button onclick="document.adminForm.text_search.value='';document.adminForm.type_filter.value=0;document.adminForm.filter_status.value=='';document.adminForm.filter_type.value='';document.adminForm.filter_created_by.value=0;document.adminForm.filter_modified_by.value=0;document.adminForm.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			<tr align="right">
			<td align="right"><input type="button" name="btinsert" value="Save" onclick="UpdatePnsTool();" /> 
                        </td>	
		</tr>
                <tr>
                        <td>
                                Scan PN Barcode <input onchange="autoAddPartTool(this.value,'<?php echo $pns_id; ?>')"  onkeyup="autoAddPartTool(this.value,'<?php echo $pns_id; ?>')" type="text"  name="pns_code" id="pns_code" value="" >
                        </td>
		</tr>
</table>
    <table class="adminlist" cellpadding="1">
        <thead>
        <tr>
            <th width="2%" class="title">
                <?php echo JText::_( 'NUM' ); ?>
            </th>
            <th width="2%" class="title">
                <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->rows); ?>);" />
            </th>
            <th class="title" width="12%">
                <?php echo  JText::_('PART_NUMBER_CODE'); ?>
            </th>
            <th width="5%" class="title" nowrap="nowrap">
                <?php echo JText::_('State'); ?>
            </th>

            <th width="17%" class="title"  >
                <?php echo JText::_( 'PNS_DESCRIPTION' ); ?>
            </th>
            <th width="5%" class="title"  >
                <?php echo JText::_( 'MFG PN' ); ?>
            </th>
            <th width="4%" class="title"  >
                <?php echo JText::_( 'Tool ID' ); ?>
            </th>
            <th width="3%" class="title"  >
                <?php echo JText::_( 'Part State' ); ?>
            </th>
            <th width="5%" class="title"  >
                <?php echo JText::_( 'QTY' ); ?>
            </th>

        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="10">
                <?php  echo $this->pagination->getListFooter(); ?>
            </td>
        </tr>
        </tfoot>
        <tbody>
        <?php
        $path_image = '../uploads/pns/images/';
        $k = 0;
        for ($i=0, $n=count( $this->rows ); $i < $n; $i++)
        {

            $row 	=& $this->rows[$i];
            if($row->pns_revision)
                $pns_code = $row->ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision;
            else
                $pns_code = $row->ccs_code.'-'.$row->pns_code;

            if ($row->pns_image !=''){
                $pns_image = $path_image.$row->pns_image;
            }else{
                $pns_image = JText::_('NONE_IMAGE_PNS');
            }
            //echo $pns_image;
            $partStateArr   = array('OH-G','OH-D','IT-G','IT-D','OO','Prototype');
            $qtyRemain = CalculateInventoryLocationPartValue($row->pns_id,$row->location,$row->partstate);
            if($qtyRemain<=0)
                continue;
            ?>
            <tr class="<?php echo "row$k"; ?>">
                <td align="center">
                    <?php echo $i+1+$this->pagination->limitstart;?>
                </td>
                <td align="center">
                    <?php echo JHTML::_('grid.id', $i, $row->pns_id ); ?>
                </td>
                <td align="left"><span class="editlinktip hasTip" title="<img border=&quot;1&quot; src=&quot;<?php echo $pns_image; ?>&quot; name=&quot;imagelib&quot; alt=&quot;<?php echo JText::_( 'No preview available' ); ?>&quot; width=&quot;100&quot; height=&quot;100&quot; />" >
					<?php echo $pns_code;?>
				</span>
                </td>
                <td align="center">
                    <?php echo $row->pns_life_cycle;?>
                </td>

                <td align="left">
                    <?php echo  $row->pns_description; ?>
                </td>
                <td align="center">
                    <?php
                    $mf = PNsController::GetManufacture($row->pns_id,4);
                    if (count($mf) > 0){
                        foreach ($mf as $m){
                            echo $m['v_mf'];
                        }
                    } ?>
                </td>
                
                <td align="center" width="77px">
                    <span style="display:block" id="text_location_<?php echo $row->pns_id;?>_<?php echo $row->id;?>"><?php echo $row->location?PNsController::GetCodeLocation($row->location):"";?></span>

                </td>
                <td align="center" width="77px">
                    <span style="display:block" id="text_partstate_<?php echo $row->pns_id;?>_<?php echo $row->id;?>"><?php echo $row->partstate?strtoupper($row->partstate):"";?></span>

                </td>
                <td>
                    <?php echo $qtyRemain;?>
                </td>
            </tr>
            <?php
            $k = 1 - $k;
        }
        ?>
        </tbody>
    </table>

	<div class="clr"></div>	
	<input type="hidden" name="option" value="com_apdmpns" />
        <input type="hidden" name="pns_id" id="pns_id" value="<?php echo $pns_id; ?>" />        
	<input type="hidden" name="boxchecked" id="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
