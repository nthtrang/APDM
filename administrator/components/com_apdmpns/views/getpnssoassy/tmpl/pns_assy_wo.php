<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );
$so_id               = JRequest::getVar('so_id');
	
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
function UpdatePnsChild(){
	if ($('boxchecked').value==0){
		alert('Please select PNs.');
		return false;
	}else if($('boxchecked').value > 1){
		alert('Please choose only one PN. Thanks');
		return false;
	}else{
	
		var url = 'index.php?option=com_apdmpns&task=ajax_list_pns_assy_wo';			
		var MyAjax = new Ajax(url, {
			method:'post',
			data:  $('adminFormPns').toQueryString(),
			onComplete:function(result){	
                                var eco_result = result;
				eco = eco_result.split('^');
				window.parent.document.getElementById('pns_assy_so').innerHTML = eco[4];   
                                window.parent.document.getElementById('top_pns_code').value = eco[3];
                                window.parent.document.getElementById('top_pns_id').value = eco[0];                                
                                window.parent.document.getElementById('wo_customer_id').value = eco[1];
                                window.parent.document.getElementById('wo_customer_name').value = eco[2];
				window.parent.document.getElementById('sbox-window').close();	
                                window.parent.document.getElementById('get_part_pn').innerHTML = "Select Part Number11";      
                                window.parent.document.getElementById('get_part_pn').setAttribute("href", "index.php?option=com_apdmpns&task=get_list_pns_wo&tmpl=component&so_id="+eco[5]+"&pns_id="+eco[0]);

				

			}
		}).request();

	}
	
}
</script>
<form action="index.php?option=com_apdmpns&task=get_list_assy_wo&tmpl=component&so_id=" method="post" name="adminForm" id="adminFormPns"  >
<input type="hidden" name="id" value="<?=$this->id?>" />
<table  width="100%">
		<tr>
			<td colspan="4"  >
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="text_search" id="text_search" value="<?php echo $this->lists['search'];?>" class="text_area"  size="40" />&nbsp;&nbsp;<?php echo JText::_('Filter With')?> 
				<?php echo $this->lists['type_filter'];?>
				&nbsp;&nbsp;
			<button onclick="javascript: return CheckForm()"><?php echo JText::_( 'Go' ); ?></button>
			<button onclick="document.adminForm.text_search.value='';document.adminForm.type_filter.value=0;document.adminForm.filter_status.value=='';document.adminForm.filter_type.value='';document.adminForm.filter_created_by.value=0;document.adminForm.filter_modified_by.value=0;document.adminForm.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			<tr align="right">
			<td align="right"><?php
                        if($this->pns_status!='Release')
                        {
                                ?><input type="button" name="btinsert" value="Insert" onclick="UpdatePnsChild();" /> 
                        <?php
                        }
                        ?>
                        </td>	
		</tr>
		</tr>			
</table>
<table class="adminlist" cellpadding="1">
		<thead>
			<tr>
				<th width="2%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th width="3%" class="title">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->rows); ?>);" />
				</th>
				<th class="title" width="15%">
					<?php echo  JText::_('PART_NUMBER_CODE'); ?>
				</th>
				
				<th  class="title" width="10%">
					<?php echo JText::_('ECO'); ?>
				</th>
				
<!--				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Status'); ?>
				</th>-->
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Type'); ?>
				</th>
				<th class="title"  >
					<?php echo JText::_( 'PNS_DESCRIPTION' ); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="7">
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
				$mf = PNsController::GetManufacture($row->pns_id);
				$bom = PNsController::GetChildParentNumber($row->pns_id);
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td>
					<?php echo JHTML::_('grid.id', $i, $row->pns_id ); ?>
				</td>
				<td><span class="editlinktip hasTip" title="<img border=&quot;1&quot; src=&quot;<?php echo $pns_image; ?>&quot; name=&quot;imagelib&quot; alt=&quot;<?php echo JText::_( 'No preview available' ); ?>&quot; width=&quot;100&quot; height=&quot;100&quot; />" >
					<?php echo $pns_code;?>
				</span>
				</td>	
				
				<td align="center">
					<?php echo PNsController::GetECO($row->eco_id); ?>
				</td>				
<!--				<td align="center">
					<?php echo $row->pns_status;?>
				</td>-->
				<td align="center">
					<?php echo $row->pns_type;?>
				</td>
				<td>
					<?php echo  $row->pns_description; ?>
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
	<input type="hidden" name="boxchecked" id="boxchecked" value="0" />
        <input type="hidden" name="so_id" id="so_id" value="<?php echo $so_id?>" />
                       
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
