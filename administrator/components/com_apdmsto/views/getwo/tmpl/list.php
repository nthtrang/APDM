<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php  JHTML::_('behavior.tooltip');  ?>
<script language="javascript">
function UpdateECO(){	
	if ($('boxchecked').value==0){
		alert('Please select one WO number.');
		return false;
	}else if($('boxchecked').value > 1){
		alert('Please choose only one WO. Thanks');
		return false;
	}else{
		var url = 'index.php?option=com_apdmsto&task=ajax_wo_toeto';
		var MyAjax = new Ajax(url, { 
			method:'post',
			data:  $('adminFormEco').toQueryString(),
			onComplete:function(result){	
				var eco_result = result;
				eco = eco_result.split('^');
                                window.parent.document.getElementById('po_customer').innerHTML =  eco[3];
                                window.parent.document.getElementById('ccs_name').innerHTML = eco[1];
                                window.parent.document.getElementById('so_cuscode').value = eco[2];
                                window.parent.document.getElementById('customer_id').value = eco[0];
                                window.parent.document.getElementById('sto_wo_id').value = eco[4];
                                window.parent.document.getElementById('wo_code').value = eco[5];


                window.parent.document.getElementById('sbox-window').close();
				

			}
		}).request();

	}
	
}
</script>

<form action="index.php?option=com_apdmsto&task=get_wo_ajax&tmpl=component" method="post" name="adminForm" id="adminFormEco">
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
				<th class="title" width="10%">
					<?php echo JHTML::_('grid.sort',   'WO', 'wo.wo_code', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
                <th width="20%" class="title">
                    <?php echo JText::_( 'SO' ); ?>
                </th>
                <th width="10%" class="title">
                    <?php echo JText::_( 'Customer' ); ?>
                </th>			
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="5">
					<?php  echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
                        <tr class="<?php echo "row-"; ?>">
				<td align="center">
					<?php echo 0;?>
				</td>
				<td align="center">
					<?php echo JHTML::_('grid.id', -1, 0 ); ?>
				</td>
                                <td align="center">
                                    NA
                                </td>
                                <td align="center">
                                    NA
                                </td>
                                <td align="center"> NA
				</td>				
				
				
			</tr>
		<?php
			$k = 0;
			for ($i=0, $n=count( $this->items ); $i < $n; $i++)
			{
				$row 	=& $this->items[$i];
                                $soNumber = $row->so_cuscode;
                                if($row->ccs_code)
                                {
                                       $soNumber = $row->ccs_code."-".$soNumber;
                                }
				
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td align="center">
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td align="center">
					<?php echo JHTML::_('grid.id', $i, $row->pns_wo_id ); ?>
				</td>
                <td align="center">
                    <?php echo $row->wo_code; ?>
                </td>
                <td align="center">
                    <?php echo $soNumber; ?>
                </td>
                <td align="center">
						<?php echo $row->ccs_name; ?>
				</td>				
				
				
			</tr>
			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>
	</table>

	<input type="hidden" name="option" value="com_apdmsto" />
	<input type="hidden" name="tmpl" value="component" />
	<input type="hidden" name="boxchecked" value="0" id="boxchecked" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>