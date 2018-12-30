<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php  JHTML::_('behavior.tooltip');  ?>
<script language="javascript">
function UpdateECO(){	
	if ($('boxchecked').value==0){
		alert('Please select one SO number.');
		return false;
	}else if($('boxchecked').value > 1){
		alert('Please choose only one SO. Thanks');
		return false;
	}else{
		var url = 'index.php?option=com_apdmpns&task=ajax_so_towo';		
		var MyAjax = new Ajax(url, {
			method:'post',
			data:  $('adminFormEco').toQueryString(),
			onComplete:function(result){	
				var eco_result = result;
				eco = eco_result.split('^');
				window.parent.document.getElementById('so_code').value = eco[1];
				window.parent.document.getElementById('so_id').value = eco[0];
                                window.parent.document.getElementById('so_request_date').value = eco[2];
				
                                
                                window.parent.document.getElementById('get_assy_pn').innerHTML = "Select Top ASSY P/N";      
                                window.parent.document.getElementById('get_assy_pn').setAttribute("href", "index.php?option=com_apdmpns&task=get_list_assy_wo&tmpl=component&so_id="+eco[0]);
                                window.parent.document.getElementById('sbox-window').close();       
				

			}
		}).request();

	}
	
}
</script>

<form action="index.php?option=com_apdmeco&task=get_eco&tmpl=component" method="post" name="adminForm" id="adminFormEco">
	<table  width="100%">
		<tr>
			<td width="35%" >
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" size="40" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				
			</td>
			
			
		</tr>
		<tr align="right">
			<td align="right"><input type="button" name="btinsert" value="Insert" onclick="UpdateECO();" /> </td>	
		</tr>
	</table>

	<table class="adminlist" cellpadding="1">
		<thead>
			<tr>
				<th width="2%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th width="3%" class="title">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
				</th>
				<th class="title" width="20%">
					<?php echo JHTML::_('grid.sort',   'Name', 'so.so_cuscode', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				
					
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="4">
					<?php  echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php
			$k = 0;
			for ($i=0, $n=count( $this->items ); $i < $n; $i++)
			{
				$row 	=& $this->items[$i];
                                $soNumber = $row->so_cuscode;
                                if($row->ccs_coordinator)
                                {
                                       $soNumber .= "-".$row->ccs_coordinator;
                                }
				
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td>
					<?php echo JHTML::_('grid.id', $i, $row->pns_so_id ); ?>
				</td>
				<td>					
						<?php echo $soNumber; ?>
				</td>				
				
				
			</tr>
			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>
	</table>

	<input type="hidden" name="option" value="com_apdmpns" />	
	<input type="hidden" name="tmpl" value="component" />
	<input type="hidden" name="boxchecked" value="0" id="boxchecked" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>