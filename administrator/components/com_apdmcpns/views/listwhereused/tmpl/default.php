<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
$db                =& JFactory::getDBO();
$role = JAdministrator::RoleOnComponent(6);
	JToolBarHelper::title( JText::_( 'List PNs Where Used' ) , 'cpanel.png' );
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );
	if (in_array("V", $role)) {
		JToolBarHelper::customX('export_whereused', 'excel', '', 'Export', false);
	}	
	JToolBarHelper::cancel( 'cancel_listpns', 'Close' );
	$title = $this->title[0];
        $pns_code_full = $title->pns_code_full;
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
function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel_listpns') {				
				submitform( pressbutton );
				return;
			}
			if (pressbutton == 'export_whereused') {		
				submitform( pressbutton );
				return;
			}
}
</script>
<h1><?php //echo JText::_('List PNs Where Used')?></h1>

<form action="index.php?option=com_apdmpns" method="post" name="adminForm" id="adminFormPns"  >
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
                                <div> <input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $this->id;?>" name="cid[]"  /> <a href="index.php?option=com_apdmpns&task=detail&cid[]=<?php echo $this->id?>&cd=<?php echo $this->id?>" title="<?php echo JText::_('Click to see detail PNs')?>"> <strong><?php echo $pns_code_full?> </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Level 0</a>
<table class="adminlist" cellpadding="1">
		<thead>
			<tr>
				
				<th class="title" width="15%">
					<?php echo  JText::_('PART_NUMBER_CODE'); ?>
				</th>
                                <th width="8%">
                                        <?php echo JText::_('Level')?>
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
					<?php // echo $this->pagination->getListFooter(); ?>
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
				
				<td width="50%"><span class="editlinktip hasTip" title="<img border=&quot;1&quot; src=&quot;<?php echo $pns_image; ?>&quot; name=&quot;imagelib&quot; alt=&quot;<?php echo JText::_( 'No preview available' ); ?>&quot; width=&quot;100&quot; height=&quot;100&quot; />" >					
                                <?php    echo '<p style="margin-left:0px"><input  type="checkbox" onclick="isChecked(this.checked);" value="'.$row->pns_id.'" name="cid[]"  /> <a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'. $pns_code.'</a></p> '; ?>                                                
				</span>
				</td>	<td>-1</td>
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
                                //level2      
                               $list_pns_c2 = CPNsController::DisplayPnsAllParentId($row->pns_id); 
                               if(isset($list_pns_c2)&& sizeof($list_pns_c2)>0)
                               {
                                        foreach ($list_pns_c2 as $row2){
                                                if ($row2->pns_image !=''){
                                                        $pns_image1 = $path_image.$row2->pns_image;
                                                }else{
                                                        $pns_image1 = JText::_('NONE_IMAGE_PNS');
                                                }                                                
                                       ?>
                                                <tr>
 

                                                        <td width="50%"><span class="editlinktip hasTip" title="<img border=&quot;1&quot; src=&quot;<?php echo $pns_image1; ?>&quot; name=&quot;imagelib&quot; alt=&quot;<?php echo JText::_( 'No preview available' ); ?>&quot; width=&quot;100&quot; height=&quot;100&quot; />" >
                                                               <?php    echo '<p style="margin-left:40px"><input  type="checkbox" onclick="isChecked(this.checked);" value="'.$row2->pns_id.'" name="cid[]"  /> <a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row2->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'. $row2->text.'</a></p> '; ?>
                                                        </span>
                                                        </td><td>-2</td>	
                                                        <td align="center">
                                                                <?php echo $row2->pns_status;?>
                                                        </td>
                                                        <td align="center">
                                                                <?php echo $row2->pns_type;?>
                                                        </td>
                                                        <td>
                                                                <?php echo  $row2->pns_description; ?>
                                                        </td>							
                                                </tr>
                                               <?php		
                                                //level3      
                                               $list_pns_c3 = CPNsController::DisplayPnsAllParentId($row2->pns_id); 
                                               if(isset($list_pns_c3)&& sizeof($list_pns_c3)>0)
                                               {
                                                        foreach ($list_pns_c3 as $row3){
                                                                if ($row3->pns_image !=''){
                                                                        $pns_image1 = $path_image.$row3->pns_image;
                                                                }else{
                                                                        $pns_image1 = JText::_('NONE_IMAGE_PNS');
                                                                }                                                
                                                       ?>
                                                                <tr>


                                                                        <td width="50%"><span class="editlinktip hasTip" title="<img border=&quot;1&quot; src=&quot;<?php echo $pns_image1; ?>&quot; name=&quot;imagelib&quot; alt=&quot;<?php echo JText::_( 'No preview available' ); ?>&quot; width=&quot;100&quot; height=&quot;100&quot; />" >
                                                                               <?php    echo '<p style="margin-left:80px"><input  type="checkbox" onclick="isChecked(this.checked);" value="'.$row3->pns_id.'" name="cid[]"  /> <a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row3->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'. $row3->text.'</a></p> '; ?>
                                                                        </span>
                                                                        </td>	<td>-3</td>
                                                                        <td align="center">
                                                                                <?php echo $row3->pns_status;?>
                                                                        </td>
                                                                        <td align="center">
                                                                                <?php echo $row3->pns_type;?>
                                                                        </td>
                                                                        <td>
                                                                                <?php echo  $row3->pns_description; ?>
                                                                        </td>							
                                                                </tr>
                                                               <?php		
                                                                //level4     
                                                               $list_pns_c4 = CPNsController::DisplayPnsAllParentId($row3->pns_id); 
                                                               if(isset($list_pns_c4)&& sizeof($list_pns_c4)>0)
                                                               {
                                                                        foreach ($list_pns_c4 as $row4){
                                                                                if ($row4->pns_image !=''){
                                                                                        $pns_image1 = $path_image.$row4->pns_image;
                                                                                }else{
                                                                                        $pns_image1 = JText::_('NONE_IMAGE_PNS');
                                                                                }                                                
                                                                       ?>
                                                                                <tr>


                                                                                        <td width="50%"><span class="editlinktip hasTip" title="<img border=&quot;1&quot; src=&quot;<?php echo $pns_image1; ?>&quot; name=&quot;imagelib&quot; alt=&quot;<?php echo JText::_( 'No preview available' ); ?>&quot; width=&quot;100&quot; height=&quot;100&quot; />" >
                                                                                               <?php    echo '<p style="margin-left:120px"><input  type="checkbox" onclick="isChecked(this.checked);" value="'.$row4->pns_id.'" name="cid[]"  /> <a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row4->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'. $row4->text.'</a></p> '; ?>
                                                                                        </span>
                                                                                        </td>	<td>-4</td>
                                                                                        <td align="center">
                                                                                                <?php echo $row4->pns_status;?>
                                                                                        </td>
                                                                                        <td align="center">
                                                                                                <?php echo $row4->pns_type;?>
                                                                                        </td>
                                                                                        <td>
                                                                                                <?php echo  $row4->pns_description; ?>
                                                                                        </td>							
                                                                                </tr>
                                                                                       <?php		
                                                                                        //level5     
                                                                                       $list_pns_c5 = CPNsController::DisplayPnsAllParentId($row4->pns_id); 
                                                                                       if(isset($list_pns_c5)&& sizeof($list_pns_c5)>0)
                                                                                       {
                                                                                                foreach ($list_pns_c5 as $row5){
                                                                                                        if ($row5->pns_image !=''){
                                                                                                                $pns_image1 = $path_image.$row5->pns_image;
                                                                                                        }else{
                                                                                                                $pns_image1 = JText::_('NONE_IMAGE_PNS');
                                                                                                        }                                                
                                                                                               ?>
                                                                                                        <tr>
                                                                                                                <td width="50%"><span class="editlinktip hasTip" title="<img border=&quot;1&quot; src=&quot;<?php echo $pns_image1; ?>&quot; name=&quot;imagelib&quot; alt=&quot;<?php echo JText::_( 'No preview available' ); ?>&quot; width=&quot;100&quot; height=&quot;100&quot; />" >
                                                                                                                       <?php    echo '<p style="margin-left:160px"><input  type="checkbox" onclick="isChecked(this.checked);" value="'.$row5->pns_id.'" name="cid[]"  /> <a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row5->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'. $row5->text.'</a></p> '; ?>
                                                                                                                </span>
                                                                                                                </td><td>-5</td>	
                                                                                                                <td align="center">
                                                                                                                        <?php echo $row5->pns_status;?>
                                                                                                                </td>
                                                                                                                <td align="center">
                                                                                                                        <?php echo $row5->pns_type;?>
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                        <?php echo  $row5->pns_description; ?>
                                                                                                                </td>							
                                                                                                        </tr>
                                                                                                               <?php		
                                                                                                                //level6     
                                                                                                               $list_pns_c6 = CPNsController::DisplayPnsAllParentId($row5->pns_id); 
                                                                                                               if(isset($list_pns_c6)&& sizeof($list_pns_c6)>0)
                                                                                                               {
                                                                                                                        foreach ($list_pns_c6 as $row6){
                                                                                                                                if ($row6->pns_image !=''){
                                                                                                                                        $pns_image1 = $path_image.$row6->pns_image;
                                                                                                                                }else{
                                                                                                                                        $pns_image1 = JText::_('NONE_IMAGE_PNS');
                                                                                                                                }                                                
                                                                                                                       ?>
                                                                                                                                <tr>
                                                                                                                                        <td width="50%"><span class="editlinktip hasTip" title="<img border=&quot;1&quot; src=&quot;<?php echo $pns_image1; ?>&quot; name=&quot;imagelib&quot; alt=&quot;<?php echo JText::_( 'No preview available' ); ?>&quot; width=&quot;100&quot; height=&quot;100&quot; />" >
                                                                                                                                               <?php    echo '<p style="margin-left:200px"><input  type="checkbox" onclick="isChecked(this.checked);" value="'.$row6->pns_id.'" name="cid[]"  /> <a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row6->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'. $row6->text.'</a></p> '; ?>
                                                                                                                                        </span>
                                                                                                                                        </td>	<td>-6</td>
                                                                                                                                        <td align="center">
                                                                                                                                                <?php echo $row6->pns_status;?>
                                                                                                                                        </td>
                                                                                                                                        <td align="center">
                                                                                                                                                <?php echo $row6->pns_type;?>
                                                                                                                                        </td>
                                                                                                                                        <td>
                                                                                                                                                <?php echo  $row6->pns_description; ?>
                                                                                                                                        </td>							
                                                                                                                                </tr>
                                                                                                                                <?php
                                                                                                                        }
                                                                                                               }//end level6
                                                                                                               ?>                                                                                                           
                                                                                                        <?php
                                                                                                }
                                                                                       }//end level5
                                                                                       ?>   
                                                                                <?php
                                                                        }
                                                               }//end level4
                                                               ?>                                                                
                                                                <?php
                                                        }
                                               }//end level3
                                               ?>
                                                <?php
                                        }
                               }
                               ?>

			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>
	</table>
</div>
	<div class="clr"></div>		
	<input type="hidden" name="boxchecked" id="boxchecked" value="0" />
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="task" id="task" value="list_where_used" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="pns_id" value="<?php echo $this->lists['pns_id'];?>"  />
	<input type="hidden" name="tmpl" value="component" />	
        <input type="hidden" name="return" value="<?php echo $this->lists['pns_id'];?>"  />
        <input type="hidden" name="cd" value="<?php echo $this->lists['pns_id'];?>"  />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />



</form>

