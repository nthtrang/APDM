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


//elem.style.visibility = 'hidden';
//elem.style.display = 'none';
function isCheckedChild(isitchecked,id){
         var form = document.adminForm;
	if (isitchecked == true){
                for ( var j = 0; j <= 40; j++ ) {
                        alert(form.getElementById("389"+j)!='undefined')
                        {
                        form.getElementById("389"+j).style.display="";        
                        }
                        
                }
	}
	else {
		for ( var i = 0; i <= 40; i++ ) {
                        form.getElementById("389"+i).style.display="none";
                }
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
$list_pns = PNsController::DisplayPnsAllChildId($this->lists['pns_id']);
?>
<div> <input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $this->lists['pns_id'];?>" name="cid[]"  /> <a href="index.php?option=com_apdmpns&task=detail&cid[]=<?php echo $this->lists['pns_id']?>&cd=<?php echo $this->lists['pns_id']?>" title="<?php echo JText::_('Click to see detail PNs')?>"> <strong><?php echo $pns_code_full?> </strong></a>
<table width="100%" class="adminlist" cellpadding="1">
	<thead>
		<tr>
			<th width="25%" class="title">
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
        <?php 
        foreach ($list_pns as $rowp){
                ?>
        <tr>
		<td width="25%"><?php echo '<p style="height:25px"><a href="javascript:void(0)" title="Click display Pns child">+</a><input  type="checkbox" onclick="isChecked(this.checked);isCheckedChild(this.checked,'.$rowp->pns_id.')" value="'.$rowp->pns_id.'" name="cid[]"  /> <a href="index.php?option=com_apdmpns&task=detail&cid[]='.$rowp->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'.$rowp->text.'</a></p> '; ?></td>
		<td><?php echo $rowp->eco_name;?></td>
		<td><?php echo $rowp->pns_type;?></td>
		<td><?php echo $rowp->pns_status;?></td>
		<td><span class="editlinktip hasTip" title="<?php echo $rowp->pns_description; ?>" ><?php echo limit_text($rowp->pns_description, 15);?></span></td>
	</tr>
        <?php
               $list_pns_c = PNsController::DisplayPnsAllChildId($rowp->pns_id); 
               if(isset($list_pns_c)&& sizeof($list_pns_c)>0)
               {
                       $i=0;
                        foreach ($list_pns_c as $row){
                       ?>
                        <tr id="<?php echo $rowp->pns_id.$i;?>" style="display:none"> 
                             
                                <td width="25%"><?php echo '<p style="margin-left:40px"><input  type="checkbox" onclick="isChecked(this.checked);" value="'.$row->pns_id.'" name="cid[]"  /> <a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'.$row->text.'</a></p> '; ?></td>
                                <td><?php echo $row->eco_name;?></td>
                                <td><?php echo $row->pns_type;?></td>
                                <td><?php echo $row->pns_status;?></td>
                                <td><span class="editlinktip hasTip" title="<?php echo $row->pns_description; ?>" ><?php echo limit_text($row->pns_description, 15);?></span></td>
                        </tr>

                <?php
                        $i++;
                        }
               }
        }
        ?>
</table>
</div>
<input type="hidden" name="option" value="com_apdmpns" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="pns_id" value="<?php echo $this->lists['pns_id'];?>"  />
<input type="hidden" name="return" value="<?php echo $this->lists['pns_id'];?>"  />
<input type="hidden" name="cd" value="<?php echo $this->lists['pns_id'];?>"  />
</form>


