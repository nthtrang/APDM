<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php
	$role = JAdministrator::RoleOnComponent(6);
	JToolBarHelper::title( JText::_( 'SHOP FLOOR OVERVIEW' ) , 'cpanel.png' );	
	$cparams = JComponentHelper::getParams ('com_media');
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );
?>
<script language="javascript">
function submitbutton(pressbutton) {
			var form = document.adminForm;			
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}						
		}

</script>
<form action="index.php?option=com_apdmpns" method="post" name="adminForm" onsubmit="submitbutton('')" >
<input type="hidden" name="query_exprot" value="<?php echo $this->lists['query'];?>" />
<input type="hidden" name="total_record" value="<?php echo $this->lists['total_record'];?>" />

<table class="adminlist" cellpadding="1">
		<thead>
			<tr>
				<th rowspan="2" align="center" width="2%" class="title">					
                                        <?php echo JHTML::_('grid.sort',   JText::_('Work Order'), 'wo.wo_code', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th rowspan="2"  align="center" width="2%" class="title">					
                                        <?php echo JHTML::_('grid.sort',   JText::_('Status'), 'wo.wo_state', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th rowspan="2" align="center" class="title" width="15%">
					<?php echo JHTML::_('grid.sort',   JText::_('PART_NUMBER_CODE'), 'p.pns_code', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
                                <th rowspan="2"  align="center" class="title" width="15%">
					<?php echo JHTML::_('grid.sort',   JText::_('TOP LEVEL ASSY P/N'), 'p2.pns_code', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
                                <th rowspan="2" align="center" class="title" width="15%">
					<?php echo JHTML::_('grid.sort',   JText::_('REV.'), 'p.pns_revision', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
                                <th rowspan="2" align="center" class="title" width="15%">
					<?php echo JHTML::_('grid.sort',   JText::_('External PO'), 'so.so_cuscode', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
                                 <th rowspan="2" align="center" class="title" width="15%">
					<?php echo JHTML::_('grid.sort',   JText::_('SO Number'), 'so.so_cuscode', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
                                <th rowspan="2" align="center" class="title" width="15%">
					<?php echo JText::_('CUSTOMER'); ?>
				</th>
                                <th rowspan="2" align="center" class="title" width="15%">
					<?php echo JText::_('Qty'); ?>
				</th>
                                <th rowspan="2" align="center" class="title" width="15%">
					<?php echo JText::_('Shipping Request date'); ?>
				</th>
                                 <th rowspan="2" align="center" class="title" width="15%">
					<?php echo JText::_('WO Finish'); ?>
				</th>
                                <th colspan="2" align="center" class="title" width="15%">
					<?php echo JText::_('Doc. Pre'); ?>
				</th>                                
                                 <th colspan="2" align="center" class="title" width="15%">
					<?php echo JText::_('Label Printed'); ?>
				</th>
                                 <th colspan="2" align="center" class="title" width="15%">
					<?php echo JText::_('Wire Cut'); ?>
				</th>
                                 <th colspan="2" align="center" class="title" width="15%">
					<?php echo JText::_('Kitted'); ?>
				</th>
                                 <th colspan="2" align="center" class="title" width="15%">
					<?php echo JText::_('Production'); ?>
				</th>
                                 <th colspan="2" align="center" class="title" width="15%">
					<?php echo JText::_('QC'); ?>
				</th>
                                 <th colspan="2" align="center" class="title" width="15%">
					<?php echo JText::_('Packaging'); ?>
				</th>
                                </tr>
                                <tr>
                                <th align="center" class="title" width="15%">
					<?php echo JText::_('Completed Time'); ?>
				</th>
                                 <th  align="center" class="title" width="15%">
					<?php echo JText::_('Assignee'); ?>
				</th>
                                 <th align="center" class="title" width="15%">
					<?php echo JText::_('Completed Time'); ?>
				</th>
                                 <th  align="center" class="title" width="15%">
					<?php echo JText::_('Assignee'); ?>
				</th>
                                 <th align="center" class="title" width="15%">
					<?php echo JText::_('Completed Time'); ?>
				</th>
                                 <th  align="center" class="title" width="15%">
					<?php echo JText::_('Assignee'); ?>
				</th>
                                 <th align="center" class="title" width="15%">
					<?php echo JText::_('Completed Time'); ?>
				</th>
                                 <th  align="center" class="title" width="15%">
					<?php echo JText::_('Assignee'); ?>
				</th>
                                 <th align="center" class="title" width="15%">
					<?php echo JText::_('Completed Time'); ?>
				</th>
                                 <th  align="center" class="title" width="15%">
					<?php echo JText::_('Assignee'); ?>
				</th>
                                 <th align="center" class="title" width="15%">
					<?php echo JText::_('Completed Time'); ?>
				</th>
                                 <th  align="center" class="title" width="15%">
					<?php echo JText::_('Assignee'); ?>
				</th>
                                 <th align="center" class="title" width="15%">
					<?php echo JText::_('Completed Time'); ?>
				</th>
                                 <th  align="center" class="title" width="15%">
					<?php echo JText::_('Assignee'); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="24">
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
//                                if($row->pns_cpn==1)
//                                        $link 	= 'index.php?option=com_apdmpns&amp;task=detailmpn&cid[0]='.$row->pns_id;	
//                                else
//                                        $link 	= 'index.php?option=com_apdmpns&amp;task=detail&cid[0]='.$row->pns_id;	
//                                if($row->pns_revision)
//                                        $pns_code = $row->ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision;
//                                else
//                                        $pns_code = $row->ccs_code.'-'.$row->pns_code;
//                               
                                
			?>
			<tr class="<?php echo "row$k"; ?>">				
				
				<td align="left">					
                                        <?php echo $row->wo_code;?>			
				</td>	                              
				<td align="left">					                                        
                                        <?php echo PNsController::getWoStatus($row->wo_state); ?>
				</td>	
                                <td align="left">					
                                        <?php echo $row->part_number;?>			
				</td>	
				<td align="center">
					<?php echo $row->top_pn;?>
				</td>
				<td align="center">
					<?php echo $row->pns_revision;?>
				</td>                                                                
				<td align="center">
					<?php echo $row->so_cuscode;?>
				</td>
				<td align="left">
					<?php echo  $row->so_number; ?>
				</td>
				<td align="left">
					<?php echo  $row->ccs_name; ?>
				</td>
                                <td align="left">
					<?php echo  $row->wo_qty; ?>
				</td>
                                <td align="left">
					<?php echo JHTML::_('date', $row->so_shipping_date, JText::_('DATE_FORMAT_LC5')); ?>
				</td>
                                
                                <td align="left">					
                                        <?php echo ($row->wo_completed_date!="")?JHTML::_('date', $row->wo_completed_date, JText::_('DATE_FORMAT_LC5')):""; ?>
				</td>
                                
                                <td align="left">					
                                        <?php echo ($row->step1_complete_date!="0000-00-00 00:00:00")?JHTML::_('date', $row->step1_complete_date, JText::_('DATE_FORMAT_LC5')):""; ?>
				</td>
                                <td align="left">					
                                        <?php echo GetValueUser($row->step1_assigner, "name"); ?>
				</td>
                                
                                 <td align="left">					
                                         <?php echo ($row->step2_complete_date!="0000-00-00 00:00:00")?JHTML::_('date', $row->step2_complete_date, JText::_('DATE_FORMAT_LC5')):""; ?>
				</td>
                                <td align="left">
					<?php echo GetValueUser($row->step2_assigner, "name"); ?>
				</td>
                                
                                 <td align="left">					
                                         <?php echo ($row->step3_complete_date!="0000-00-00 00:00:00")?JHTML::_('date', $row->step3_complete_date, JText::_('DATE_FORMAT_LC5')):""; ?>
				</td>
                                <td align="left">
					<?php echo GetValueUser($row->step3_assigner, "name"); ?>
				</td>
                                
                                 <td align="left">					
                                         <?php echo ($row->step4_complete_date!="0000-00-00 00:00:00")?JHTML::_('date', $row->step4_complete_date, JText::_('DATE_FORMAT_LC5')):""; ?>
				</td>
                                <td align="left">
					<?php echo GetValueUser($row->step4_assigner, "name"); ?>
				</td>
                                
                                 <td align="left">					
                                         <?php echo ($row->step5_complete_date!="0000-00-00 00:00:00")?JHTML::_('date', $row->step5_complete_date, JText::_('DATE_FORMAT_LC5')):""; ?>
				</td>
                                <td align="left">
					<?php echo GetValueUser($row->step5_assigner, "name"); ?>
				</td>
                                
                                 <td align="left">					
                                         <?php echo ($row->step6_complete_date!="0000-00-00 00:00:00")?JHTML::_('date', $row->step6_complete_date, JText::_('DATE_FORMAT_LC5')):""; ?>
				</td>
                                <td align="left">
					<?php echo GetValueUser($row->step6_assigner, "name"); ?>
				</td>
                                
                                 <td align="left">					
                                         <?php echo ($row->step7_complete_date!="0000-00-00 00:00:00")?JHTML::_('date', $row->step7_complete_date, JText::_('DATE_FORMAT_LC5')):""; ?>
				</td>
                                <td align="left">
					<?php echo GetValueUser($row->step7_assigner, "name"); ?>
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
	<input type="hidden" name="task" value="shopfloor" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="text" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="text" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
