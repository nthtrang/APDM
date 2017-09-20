<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	$role = JAdministrator::RoleOnComponent(6);
	JToolBarHelper::title( JText::_( 'PNS_MAMANGEMENT' ) , 'cpanel.png' );
	
	if (in_array("V", $role)) {
		JToolBarHelper::customX('export_bom', 'excel', '', 'Export', false);
	}	
	JToolBarHelper::cancel( 'cancel_listpns', 'Close' );
//	if (in_array("E", $role)) {
//		JToolBarHelper::editListX();
//	}
//	if (in_array("D", $role)) {
//		JToolBarHelper::deleteList('Are you sure to delete it(s)?');
//	}
	
	$cparams = JComponentHelper::getParams ('com_media');
?>

<?php
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	
?>
<script language="javascript">
function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel_listpns') {				
				submitform( pressbutton );
				return;
			}
			if (pressbutton == 'export_bom') {				
				submitform( pressbutton );
				return;
			}
}
</script>
<form action="index.php?option=com_apdmpns" method="post" name="adminForm" >
<?php 
$row = $this->rows[0];
$pns_code_full = $row->pns_code_full;
 if (substr($pns_code_full, -1)=="-"){
   $pns_code_full = substr($pns_code_full, 0, strlen($pns_code_full)-1);  
 }
$list_pns_id = PNsController::DisplayPnsChildId($this->lists['pns_id'], $this->lists['pns_id']);

$new_pns = explode(",", $list_pns_id);
?>
<div> <input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $this->lists['pns_id'];?>" name="cid[]"  /> <a href="index.php?option=com_apdmpns&task=detail&cid[]=<?php echo $this->lists['pns_id']?>&cd=<?php echo $this->lists['pns_id']?>" title="<?php echo JText::_('Click to see detail PNs')?>"> <strong><?php echo $pns_code_full?> </strong></a>
<table width="100%" class="adminlist" cellpadding="1">
	<thead>
		<tr>
			<th width="40%" class="title">
					<?php echo JText::_('PNs BOM')?>
			</th>
			<th width="8%">
				<?php echo JText::_('ECO Number')?>
			</th>
			<th width="6%">
				<?php echo JText::_('Type')?>
			</th>
			<th width="6%">
				<?php echo JText::_('Status')?>
			</th>
			<th>
				<?php echo JText::_('Desctiption')?>
				
			</th>
			
			
		</tr>
	</thead>
	<tr>
		<td rowspan="<?php echo count($new_pns)?>" width="40%"><?php echo PNsController::DisplayPnsChild($this->lists['pns_id'], $this->lists['pns_id']); ?></td>
		<td><?php echo PNsController::GetEcoNumber($new_pns[0]);?></td>
		<td><?php echo PNsController::GetValuePns('pns_type', $new_pns[0]);?></td>
		<td><?php echo PNsController::GetValuePns('pns_status', $new_pns[0]);?></td>
		<td><span class="editlinktip hasTip" title="<?php echo PNsController::GetValuePns('pns_description', $new_pns[0]); ?>" ><?php echo limit_text(PNsController::GetValuePns('pns_description', $new_pns[0]), 15);?></span></td>
	</tr>
	<?php for ($i=1; $i < count($new_pns)-1; $i++) { ?>
	<tr>
	   <td><?php echo PNsController::GetEcoNumber($new_pns[$i]);?></td>
		<td><?php echo PNsController::GetValuePns('pns_type', $new_pns[$i]);?></td>
		<td><?php echo PNsController::GetValuePns('pns_status', $new_pns[$i]);?></td>
		<td><span class="editlinktip hasTip" title="<?php echo PNsController::GetValuePns('pns_description', $new_pns[$i]); ?>" ><?php echo limit_text(PNsController::GetValuePns('pns_description', $new_pns[$i]), 15);?></span></td>
	</tr>
   <?php } ?>
</table>
</div>
<input type="hidden" name="option" value="com_apdmpns" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="pns_id" value="<?php echo $this->lists['pns_id'];?>"  />
<input type="hidden" name="return" value="<?php echo $this->lists['pns_id'];?>"  />
<input type="hidden" name="cd" value="<?php echo $this->lists['pns_id'];?>"  />
</form>


