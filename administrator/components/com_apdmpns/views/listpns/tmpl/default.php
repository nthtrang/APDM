<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
//bom
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
$list_pns = PNsController::DisplayPnsAllChildId($this->lists['pns_id']);
?>
<div> <input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $this->lists['pns_id'];?>" name="cid[]"  /> <a href="index.php?option=com_apdmpns&task=detail&cid[]=<?php echo $this->lists['pns_id']?>&cd=<?php echo $this->lists['pns_id']?>" title="<?php echo JText::_('Click to see detail PNs')?>"> <strong><?php echo $pns_code_full?> </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Level 0</a></a>
        <table width="100%" class="adminlist" cellpadding="1">
	<thead>
		<tr>
			<th width="25%" class="title">
					<?php echo JText::_('PNs BOM')?>
			</th>
                        <th width="8%">
				<?php echo JText::_('Level')?>
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
        //level1
        $level=0;
        foreach ($list_pns as $row){
                $level++;
                ?>
        <tr>
		<td width="25%"><?php echo '<p style="height:25px"><input  type="checkbox" onclick="isChecked(this.checked);" value="'.$row->pns_id.'" name="cid[]"  /> <a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'.$row->text.'</a></p> '; ?></td>
		<td>1</td>
                <td><?php echo $row->eco_name;?></td>                
		<td><?php echo $row->pns_type;?></td>
		<td><?php echo $row->pns_status;?></td>
		<td><span class="editlinktip hasTip" title="<?php echo $row->pns_description; ?>" ><?php echo limit_text($row->pns_description, 15);?></span></td>
	</tr>
        <?php
                //level2
               $list_pns_c = PNsController::DisplayPnsAllChildId($row->pns_id); 
               if(isset($list_pns_c)&& sizeof($list_pns_c)>0)
               {
                        foreach ($list_pns_c as $row){
                       ?>
                           <tr>
                                <td width="50%"><?php echo '<p style="margin-left:40px"><input  type="checkbox" onclick="isChecked(this.checked);" value="'.$row->pns_id.'" name="cid[]"  /> <a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'.$row->text.'</a></p> '; ?></td>
                                <td>2</td>
                                <td><?php echo $row->eco_name;?></td>                                
                                <td><?php echo $row->pns_type;?></td>
                                <td><?php echo $row->pns_status;?></td>
                                <td><span class="editlinktip hasTip" title="<?php echo $row->pns_description; ?>" ><?php echo limit_text($row->pns_description, 15);?></span></td>
                        </tr>
                             
                              <?php
                                //level3
                               $list_pns_3 = PNsController::DisplayPnsAllChildId($row->pns_id); 
                               if(isset($list_pns_3)&& sizeof($list_pns_3)>0)
                               {
                                        foreach ($list_pns_3 as $row3){
                                       ?>
                                           <tr>
                                                <td width="50%"><?php echo '<p style="margin-left:80px"><input  type="checkbox" onclick="isChecked(this.checked);" value="'.$row3->pns_id.'" name="cid[]"  /> <a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row3->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'.$row3->text.'</a></p> '; ?></td>
                                                <td>3</td>
                                                <td><?php echo $row3->eco_name;?></td>
                                                <td><?php echo $row3->pns_type;?></td>
                                                <td><?php echo $row3->pns_status;?></td>
                                                <td><span class="editlinktip hasTip" title="<?php echo $row3->pns_description; ?>" ><?php echo limit_text($row3->pns_description, 15);?></span></td>
                                        </tr>
                                               <?php
                                                //level4
                                               $list_pns_4 = PNsController::DisplayPnsAllChildId($row3->pns_id); 
                                               if(isset($list_pns_4)&& sizeof($list_pns_4)>0)
                                               {
                                                        foreach ($list_pns_4 as $row4){
                                                       ?>
                                                           <tr>
                                                                <td width="50%"><?php echo '<p style="margin-left:120px"><input  type="checkbox" onclick="isChecked(this.checked);" value="'.$row4->pns_id.'" name="cid[]"  /> <a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row4->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'.$row4->text.'</a></p> '; ?></td>
                                                                <td>4</td>
                                                                <td><?php echo $row4->eco_name;?></td>
                                                                <td><?php echo $row4->pns_type;?></td>
                                                                <td><?php echo $row4->pns_status;?></td>
                                                                <td><span class="editlinktip hasTip" title="<?php echo $row4->pns_description; ?>" ><?php echo limit_text($row4->pns_description, 15);?></span></td>
                                                        </tr>
                                                                        <?php
                                                                        //level5
                                                                       $list_pns_5 = PNsController::DisplayPnsAllChildId($row4->pns_id); 
                                                                       if(isset($list_pns_5)&& sizeof($list_pns_5)>0)
                                                                       {
                                                                                foreach ($list_pns_5 as $row5){
                                                                               ?>
                                                                                   <tr>
                                                                                        <td width="50%"><?php echo '<p style="margin-left:140px"><input  type="checkbox" onclick="isChecked(this.checked);" value="'.$row5->pns_id.'" name="cid[]"  /> <a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row5->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'.$row5->text.'</a></p> '; ?></td>
                                                                                        <td>5</td>
                                                                                        <td><?php echo $row5->eco_name;?></td>
                                                                                        <td><?php echo $row5->pns_type;?></td>
                                                                                        <td><?php echo $row5->pns_status;?></td>
                                                                                        <td><span class="editlinktip hasTip" title="<?php echo $row5->pns_description; ?>" ><?php echo limit_text($row5->pns_description, 15);?></span></td>
                                                                                </tr>
                                                                                                <?php
                                                                                                //level6
                                                                                               $list_pns_6 = PNsController::DisplayPnsAllChildId($row5->pns_id); 
                                                                                               if(isset($list_pns_6)&& sizeof($list_pns_6)>0)
                                                                                               {
                                                                                                        foreach ($list_pns_6 as $row6){
                                                                                                       ?>
                                                                                                           <tr>
                                                                                                                <td width="50%"><?php echo '<p style="margin-left:180px"><input  type="checkbox" onclick="isChecked(this.checked);" value="'.$row6->pns_id.'" name="cid[]"  /> <a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row6->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'.$row6->text.'</a></p> '; ?></td>
                                                                                                                <td>6</td>
                                                                                                                <td><?php echo $row6->eco_name;?></td>
                                                                                                                <td><?php echo $row6->pns_type;?></td>
                                                                                                                <td><?php echo $row6->pns_status;?></td>
                                                                                                                <td><span class="editlinktip hasTip" title="<?php echo $row6->pns_description; ?>" ><?php echo limit_text($row6->pns_description, 15);?></span></td>
                                                                                                        </tr>
                                                                                                                 <?php
                                                                                                                        //level7
                                                                                                                       $list_pns_7 = PNsController::DisplayPnsAllChildId($row6->pns_id); 
                                                                                                                       if(isset($list_pns_7)&& sizeof($list_pns_7)>0)
                                                                                                                       {
                                                                                                                                foreach ($list_pns_7 as $row7){
                                                                                                                               ?>
                                                                                                                                   <tr>
                                                                                                                                        <td width="50%"><?php echo '<p style="margin-left:220px"><input  type="checkbox" onclick="isChecked(this.checked);" value="'.$row7->pns_id.'" name="cid[]"  /> <a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row7->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'.$row7->text.'</a></p> '; ?></td>
                                                                                                                                        <td>7</td>
                                                                                                                                        <td><?php echo $row7->eco_name;?></td>
                                                                                                                                        <td><?php echo $row7->pns_type;?></td>
                                                                                                                                        <td><?php echo $row7->pns_status;?></td>
                                                                                                                                        <td><span class="editlinktip hasTip" title="<?php echo $row7->pns_description; ?>" ><?php echo limit_text($row7->pns_description, 15);?></span></td>
                                                                                                                                </tr>
                                                                                                                                                  <?php
                                                                                                                                                //level8
                                                                                                                                               $list_pns_8 = PNsController::DisplayPnsAllChildId($row7->pns_id); 
                                                                                                                                               if(isset($list_pns_8)&& sizeof($list_pns_8)>0)
                                                                                                                                               {
                                                                                                                                                        foreach ($list_pns_8 as $row8){
                                                                                                                                                       ?>
                                                                                                                                                           <tr>
                                                                                                                                                                <td width="50%"><?php echo '<p style="margin-left:240px"><input  type="checkbox" onclick="isChecked(this.checked);" value="'.$row8->pns_id.'" name="cid[]"  /> <a href="index.php?option=com_apdmpns&task=detail&cid[]='.$row8->pns_id.'&cd='.$this->lists['pns_id'].'" title="'.JText::_('Click to see detail PNs').'">'.$row8->text.'</a></p> '; ?></td>
                                                                                                                                                                <td>8</td>
                                                                                                                                                                <td><?php echo $row8->eco_name;?></td>
                                                                                                                                                                <td><?php echo $row8->pns_type;?></td>
                                                                                                                                                                <td><?php echo $row8->pns_status;?></td>
                                                                                                                                                                <td><span class="editlinktip hasTip" title="<?php echo $row8->pns_description; ?>" ><?php echo limit_text($row8->pns_description, 15);?></span></td>
                                                                                                                                                        </tr>

                                                                                                                                                <?php
                                                                                                                                                        }
                                                                                                                                               }
                                                                                                                                               ?>
                                                                                                                        <?php
                                                                                                                                }
                                                                                                                       }
                                                                                                                       ?>
                                                                                                <?php
                                                                                                        }
                                                                                               }
                                                                                               ?>
                                                                        <?php
                                                                                }
                                                                       }
                                                                       ?>
                                                <?php
                                                        }
                                               }
                                               ?>
                                <?php
                                        }
                               }
                               ?>
                <?php
                        }
               }
               ?>
     <?php
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


