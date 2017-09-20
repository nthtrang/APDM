<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php  JHTML::_('behavior.tooltip');  ?>
<script language="javascript">
function UpdateSupplier(){	
	if ($('boxchecked').value==0){
		alert('Please select value.');
		return false;	
	}else{
		var type = $('type').value;
		if (type==2){
			var idUpdate = 'vendor_get';
		}
		if (type==3){
			var idUpdate = 'supplier_get';
		}
		if (type==4){
			var idUpdate = 'manufacture_get';
		}
		
		var url = 'index.php?option=com_apdmsuppliers&task=ajax_supplier';		
		var MyAjax = new Ajax(url, {
			method:'post',
			data:  $('adminFromSupplier').toQueryString(),
			onComplete:function(result){					
				window.parent.document.getElementById(idUpdate).innerHTML = result;
				window.parent.document.getElementById('sbox-window').close();	
				

			}
		}).request();

	}
	
}
</script>
<form action="index.php?option=com_apdmsuppliers&task=get_supplier&tmpl=component" method="post" name="adminForm" id="adminFromSupplier">

	<table  width="100%">
		<tr>
			<td width="35%" >
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" size="40" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				
			</td>			
			
		</tr>
		<tr align="right">
			<td align="right"><input type="button" name="btinsert" value="Insert" onclick="UpdateSupplier();" /> </td>	
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
					<?php echo JHTML::_('grid.sort',   'Name', 's.info_name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>				
				<th  class="title" >
					<?php echo JText::_( 'Description' ); ?>
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
		if (count( $this->items ) > 0) {
			$k = 0;
			for ($i=0, $n=count( $this->items ); $i < $n; $i++)
			{
				$row 	=& $this->items[$i];
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td>
					<?php echo JHTML::_('grid.id', $i, $row->info_id ); ?>
				</td>
				<td>
					<?php echo $row->info_name; ?>
				</td>
				
				<td>
					<?php echo $row->info_description; ?>
				</td>
			
			</tr>
			<?php
				$k = 1 - $k;
				}
			}else { ?>
			<tr >
				<td colspan="4">
					<?php echo JText::_('There is no data.');?>
					
				</td>
				
			
			</tr>
			<?php
				
			}
			?>
		</tbody>
	</table>

	<input type="hidden" name="option" value="com_apdmsuppliers" />	
	<input type="hidden" name="tmpl" value="component" />
	<input type="hidden" name="type" id="type" value="<?php echo $this->lists['type']; ?>" />
	<input type="hidden" name="pns_id" id="pns_id" value="<?php echo $this->lists['pns_id']; ?>" />
	<input type="hidden" id="boxchecked" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php //echo JHTML::_( 'form.token' ); ?>
</form>