<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
$tto_id		= JRequest::getVar( 'tto_id');
$tto_type_inout		= JRequest::getVar( 'tto_type_inout');
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );
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
function UpdatePnsEco(){        
        var tto_id = $('tto_id').value;
        var tto_type_inout = $('tto_type_inout').value;
	if ($('boxchecked').value==0){
		alert('Please select PNs.');
		return false;
	}else{
	
		var url = 'index.php?option=com_apdmtto&task=ajax_add_pns_tto&tto_id='+tto_id+'&tto_type_inout='+tto_type_inout;
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
</script>
<form action="index.php?option=com_apdmtto&task=get_list_pns_tto&tmpl=component&tto_id=<?php echo $tto_id?>" method="post" name="adminForm" id="adminFormPns"  >
<input type="hidden" name="id" value="<?=$this->id?>" />
<table  width="100%">
		<tr>
			<td colspan="4"  >
				<?php echo JText::_( 'Search' ); ?>:
				<input type="text" name="text_search" id="text_search" value="<?php echo $this->lists['search'];?>" class="text_area"  size="40" />&nbsp;&nbsp;<?php echo JText::_('Filter')?> 
				<?php echo $this->lists['type_filter'];?>
				&nbsp;&nbsp;
			<button onclick="javascript: return CheckForm()"><?php echo JText::_( 'Go' ); ?></button>
			<button onclick="document.adminForm.text_search.value='';document.adminForm.type_filter.value=0;document.adminForm.filter_status.value=='';document.adminForm.filter_type.value='';document.adminForm.filter_created_by.value=0;document.adminForm.filter_modified_by.value=0;document.adminForm.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			<tr align="right">
			<td align="right"><?php
                      //  if($this->pns_status!='Release')
                       /// {
                                ?><input type="button" name="btinsert" value="Save" onclick="UpdatePnsEco();" /> 
                        <?php
                     //   }
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
                                $qtyRemain = CalculateInventoryLocationPartValueForTool($row->pns_id,$row->location,$row->partstate);
                                if($qtyRemain<=0)
                                        continue;
                                        
                                
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td align="center">
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td align="center">
					<?php echo JHTML::_('grid.id', $i, $row->id ); ?>                                        
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
                                        $mf = TToController::GetManufacture($row->pns_id,4);
                                        if (count($mf) > 0){
                                                foreach ($mf as $m){
                                                        echo $m['v_mf'];
                                                }					
					} ?>
				</td>	
                                 <td align="center" width="77px">					
                                       <?php echo $row->location?TToController::GetCodeLocation($row->location):"";?>                                        

                                </td>	
                                <td align="center" width="77px">					
                                       <?php echo $row->partstate?strtoupper($row->partstate):"";?>

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
	<input type="hidden" name="option" value="com_apdmtto" />
        <input type="hidden" name="tto_id" id="tto_id" value="<?php echo $tto_id; ?>" />
        <input type="hidden" name="tto_type_inout" id="tto_type_inout" value="<?php echo $tto_type_inout; ?>" />
	<input type="hidden" name="boxchecked" id="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
