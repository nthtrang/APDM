<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	
	JToolBarHelper::title( JText::_( 'RECYLE_BIN_MAMANGEMENT' ) , 'trash.png' );
	JToolBarHelper::deleteList('Are you sure to delete it?', 'delete_pns');
	JToolBarHelper::customX('restore_pns', 'trash', '', 'Restore', true);
	$cparams = JComponentHelper::getParams ('com_media');
?>

<?php
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	
?>
<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		if (pressbutton == 'delete_pns') {
			submitform( pressbutton );
			return;
		}
		if (pressbutton == 'restore_pns') {
			submitform( pressbutton );
			return;
		}
				
	}

</script>
<form action="index.php?option=com_apdmrecylebin&task=pns" method="post" name="adminForm" >
	<table  width="100%">
		<tr>
			<td width="35%" >
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" size="40" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>				
			</td>			
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
					<?php echo JHTML::_('grid.sort',   JText::_('PART_NUMBER_CODE'), 'p.pns_code', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th  class="title" width="15%">
					<?php echo JHTML::_('grid.sort',   JText::_('ECO'), 'p.eco_id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="15%" class="title" >
					<?php echo JText::_( 'DOWNLOAD_PDF' ); ?>
				</th>
				
<!--				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   JText::_('Status'), 'p.pns_status', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>-->
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   JText::_('Make/Buy'), 'p.pns_type', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th w class="title" >
					<?php echo JHTML::_('grid.sort',   JText::_('Date Create'), 'p.pns_create', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				
				<th w class="title">
					<?php echo JHTML::_('grid.sort',   JText::_('Create by'), 'p.pns_create_by', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th w class="title">
					<?php echo JHTML::_('grid.sort',   JText::_('Date Modified'), 'p.pns_modified', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th  class="title">
					<?php echo JHTML::_('grid.sort',   JText::_('Modified By'), 'p.pns_modified_by', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>				
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="11">
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
				$link 	= 'index.php?option=com_apdmrecylebin&amp;task=pnsdetail&cid[0]='.$row->pns_id;					
				$pns_code = $row->pns_full_code;
				if (substr($pns_code, -1)=="-"){
                    $pns_code = substr($pns_code, 0, strlen($pns_code)-1);  
                }
				
				
				if ($row->pns_image !=''){
					$pns_image = $path_image.$row->pns_image;
				}else{
					$pns_image = JText::_('NONE_IMAGE_PNS');
				}
				//echo $pns_image;
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td>
					<?php echo JHTML::_('grid.id', $i, $row->pns_id ); ?>
				</td>
				<td><span class="editlinktip hasTip" title="<img border=&quot;1&quot; src=&quot;<?php echo $pns_image; ?>&quot; name=&quot;imagelib&quot; alt=&quot;<?php echo JText::_( 'No preview available' ); ?>&quot; width=&quot;300&quot; height=&quot;245&quot; />" >
					<a href="<?php echo $link;?>" title="<?php echo JText::_('Click to see detail PNs');?>"><?php echo $pns_code;?></a>
				</span>
				</td>				
				<td align="center">
					<?php echo $row->eco_name;//echo PNsController::GetECO($row->eco_id); ?>
				</td>
				<td>
					<?php if($row->pns_pdf !="") { ?>
					 <a href="index.php?option=com_apdmpns&task=download&id=<?php echo $row->pns_id?>" title="Click to download file pdf"><?php echo $row->pns_pdf;?></a>
					<?php }else{ echo JText::_('NONE_PDF_FILE');}?>
				</td>
<!--				<td align="center">
					<?php echo $row->pns_status;?>
				</td>-->
				<td align="center">
					<?php echo $row->pns_type;?>
				</td>
				<td>
					<?php echo  JHTML::_('date', $row->pns_create, JText::_('DATE_FORMAT_LC5')); ?>
				</td>
				<td>
					<?php echo GetValueUser($row->pns_create_by, 'username'); ?>
				</td>
				<td nowrap="nowrap">
						<?php echo ($row->pns_modified !='0000-00-00 00:00:00') ? JHTML::_('date', $row->eco_modified, JText::_('DATE_FORMAT_LC5')) : ''; ?>
				</td>
				<td>
					<?php echo GetValueUser($row->pns_modified_by, 'username'); ?>
				</td>
			</tr>
			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>
	</table>

	<div class="clr"></div>	
	<input type="hidden" name="option" value="com_apdmrecylebin" />
	<input type="hidden" name="task" value="pns" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	
</form>
