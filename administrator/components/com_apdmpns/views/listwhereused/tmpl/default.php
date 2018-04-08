<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
$role = JAdministrator::RoleOnComponent(6);
	JToolBarHelper::title( JText::_( 'List PNs Where Used' ) , 'cpanel.png' );
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );
	if (in_array("V", $role)) {
		//JToolBarHelper::customX('export_whereused', 'excel', '', 'Export', false);
	}	
	JToolBarHelper::cancel( 'cancel_listpns', 'Close' );
	
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

</script>
<h1><?php //echo JText::_('List PNs Where Used')?></h1>
<form action="index.php?option=com_apdmpns&task=list_child&tmpl=component" method="post" name="adminForm" id="adminFormPns"  >
<input type="hidden" name="id" value="<?=$this->id?>" />
<!--<table  width="100%">
		<tr>
			<td colspan="4"  >
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="text_search" id="text_search" value="<?php echo $this->lists['search'];?>" class="text_area"  size="40" />&nbsp;&nbsp;<?php echo JText::_('Filter With')?> 
				<?php echo $this->lists['type_filter'];?>
				&nbsp;&nbsp;
			<button onclick="javascript: return CheckForm()"><?php echo JText::_( 'Go' ); ?></button>
			<button onclick="document.adminForm.text_search.value='';document.adminForm.type_filter.value=0;document.adminForm.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			
		</tr>			
</table>-->
<table class="adminlist" cellpadding="1">
		<thead>
			<tr>
				<th width="2%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				
				<th class="title" width="15%">
					<?php echo  JText::_('PART_NUMBER_CODE'); ?>
				</th>
				
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Status'); ?>
				</th>
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
				<td colspan="5">
					<?php  echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody id="list_pns_child" >
		<?php
			$path_image = '../uploads/pns/images/';
			$k = 0;
			for ($i=0, $n=count( $this->rows ); $i < $n; $i++)
			{
				$row 	=& $this->rows[$i];				
				$pns_code = $row->ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision;
				if ($row->pns_image !=''){
					$pns_image = $path_image.$row->pns_image;
				}else{
					$pns_image = JText::_('NONE_IMAGE_PNS');
				}
				
				
				
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				
				<td><span class="editlinktip hasTip" title="<img border=&quot;1&quot; src=&quot;<?php echo $pns_image; ?>&quot; name=&quot;imagelib&quot; alt=&quot;<?php echo JText::_( 'No preview available' ); ?>&quot; width=&quot;100&quot; height=&quot;100&quot; />" >
					<?php echo $pns_code;?>
				</span>
				</td>	
				<td align="center">
					<?php echo $row->pns_status;?>
				</td>
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
	<input type="hidden" name="boxchecked" id="boxchecked" value="0" />
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="task" id="task" value="list_where_used" />
	<input type="hidden" name="tmpl" value="component" />	
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
</form>

