<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );
$cid[0];
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	
?>test
<script language="javascript">
function CheckForm() {

			if (document.adminForm.text_search.value==""){
				alert("Please input keyword to filter");
				return false;
			}
//			if (document.adminForm.type_filter.value==0){
//				alert("Please select type to filter");
//				return false;			
//			}
		
	
}
function UpdateWoSo(){
	if ($('boxchecked').value==0){
		alert('Please select WO.');
		return false;
	}else{
	
		var url = 'index.php?option=com_apdmpns&task=ajax_add_wo_so';			
		var MyAjax = new Ajax(url, {
			method:'post',
			data:  $('adminFormPns').toQueryString(),
			onComplete:function(result){			
			//	window.parent.document.getElementById('pns_child').innerHTML = result;				
				window.parent.document.getElementById('sbox-window').close();	
				

			}
		}).request();

	}
	
}
</script>
<form action="index.php?option=com_apdmpns&task=get_list_wo_so&tmpl=component" method="post" name="adminForm" id="adminFormPns"  >
<input type="text" name="id" value="<?php echo $this->id?>" />
<table  width="100%">
		<tr>
			<td colspan="4"  >
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="text_search" id="text_search" value="<?php echo $this->lists['search'];?>" class="text_area"  size="40" />&nbsp;&nbsp;<?php echo JText::_('Filter With')?> 
				<?php //echo $this->lists['type_filter'];?>
				&nbsp;&nbsp;
			<button onclick="javascript: return CheckForm()"><?php echo JText::_( 'Go' ); ?></button>
			<button onclick="document.adminForm.text_search.value='';document.adminForm.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			<tr align="right">
			<td align="right"><input type="button" name="btinsert" value="Save" onclick="UpdateWoSo();" /> 
                       
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
					<?php echo  JText::_('WO#'); ?>
				</th>												
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('QUANTITY'); ?>
				</th>
                                <th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Status'); ?>
				</th>
                                <th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('CUSTOMER'); ?>
				</th>
                                <th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Started Date'); ?>
				</th>
                                <th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Finished Date'); ?>
				</th>
                                <th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('ASSIGNER'); ?>
				</th>
				
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="9">
					<?php  echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php
			
			$k = 0;
			for ($i=0, $n=count( $this->rows ); $i < $n; $i++)
			{
				$row 	=& $this->rows[$i];
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td>
					<?php echo JHTML::_('grid.id', $i, $row->pns_wo_id ); ?>
				</td>
				<td>
					<?php echo $row->wo_code;?>				
				</td>	
				<td>
					<?php echo $row->wo_qty;?>				
				</td>
                                <td>
                                        <?php echo PNsController::getWoStatus($row->wo_state); ?>
                                </td>
				<td align="center">
					<?php echo PNsController::getCcsDescription($row->wo_customer_id); ?>
				</td>				
				<td align="center">
					<?php echo JHTML::_('date', $row->wo_start_date, JText::_('DATE_FORMAT_LC3')); ?>
				</td>
				<td align="center">
					<?php echo JHTML::_('date', $row->wo_start_date, JText::_('DATE_FORMAT_LC3')); ?>
				</td>
				<td>
					<?php echo GetValueUser($row->wo_assigner, "name"); ?>
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
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
