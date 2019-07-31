<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php

$role = JAdministrator::RoleOnComponent(5);
$cid = JRequest::getVar( 'cid', array(0) );
JToolBarHelper::title($this->quo_row->quo_code .' '. $this->quo_row->quo_revision .': <small><small>[ view ]</small></small>' , 'generic.png' );
if (in_array("E", $role) && ($this->quo_row->quo_state !="Released" && $this->quo_row->quo_state !="Inreview")) {
    JToolBarHelper::addQuoRoutes("New",$cid[0]);
}

	if (in_array("D", $role) && ($this->quo_row->quo_state !="Released" && $this->quo_row->quo_state !="Inreview")) {
		JToolBarHelper::deleteEcoRoutes('Are you sure to delete it(s)?','remove_routes_quo');
	}        
//	if (in_array("E", $role)) {
//		JToolBarHelper::editListX();
//	}
//	if (in_array("D", $role)&& $this->quo_row->eco_status !="Released" && $this->quo_row->eco_status !="Inreview") {
//		JToolBarHelper::deleteEcoRoutes('Are you sure to delete it?');
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
//                        if (pressbutton == 'summary') {
//                                window.location.assign("index.php?option=com_apdmeco&task=detail&cid[]=<?php echo $cid[0]?>")
//                                return;
//                        }
//                        if (pressbutton == 'files') {
//                                window.location.assign("index.php?option=com_apdmeco&task=files&cid[]=<?php echo $cid[0]?>");
//                                return;
//                        }      
//                        if (pressbutton == 'approvers') {
//                                window.location.assign("index.php?option=com_apdmeco&task=approvers&cid[]=<?php echo $cid[0]?>");
//                                return;
//                        }      
                        if(pressbutton == 'remove_routes')
                        {
                             submitform( pressbutton );
                             return;
                        }
}

</script>
<div class="submenu-box">
	<div class="t">
                <div class="t">
                        <div class="t"></div>
                </div>
        </div>
        <div class="m">
		<ul id="submenu" class="configuration">
			<li><a id="detail" href="index.php?option=com_apdmquo&task=quo_detail&id=<?php echo $this->quo_row->quotation_id;?>"><?php echo JText::_( 'Detail' ); ?></a></li>
			<li><a id="affected" href="index.php?option=com_apdmeco&task=quo_rev&id=<?php echo $this->quo_row->quotation_id;?>"><?php echo JText::_( 'Rev' ); ?></a></li>
            <li><a id="routes"  class="active"><?php echo JText::_( 'Routes' ); ?></a></li>
		</ul>
		<div class="clr"></div>
        </div>
        <div class="b">
                <div class="b">
                        <div class="b"></div>
                </div>
        </div>
</div>
<div class="clr"></div>
<p>&nbsp;</p>
<form action="index.php?option=com_apdmquo" method="post" name="adminForm" >
<table class="adminlist" cellpadding="1">
		<thead>
			<tr>
				<th width="2%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th width="3%" class="title">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->rows); ?>);" />
				</th>
				<th class="title" width="10%">
					<?php echo  JText::_('Name'); ?>
                                </th>
				<th  class="title" width="20%">
					<?php echo  JText::_('Description'); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('State'); ?>
				</th>
				<th width="10%" class="title" nowrap="nowrap">
					<?php echo JText::_('Due Date'); ?>
				</th>
                                <th  width="5%" class="title"  >
					<?php echo JText::_( 'Owner' ); ?>
				</th>
				<th  width="5%"  class="title">
					<?php echo JText::_( 'Action' ); ?>
				</th>                                
			</tr>
		</thead>
		
		<tbody>
		<?php			
			$k = 0;
                        
			for ($i=0, $n=count( $this->rows ); $i < $n; $i++)
			{
       
				$row 	=& $this->rows[$i];
				$link 	= 'index.php?option=com_apdmpns&amp;task=detail&cid[0]='.$row->id;	
                $set_route = 'index.php?option=com_apdmquo&amp;task=set_route_quo&time='.time().'&cid[0]='.$cid[0].'&id='.$row->id;
				$edit_link = 'index.php?option=com_apdmquo&amp;task=edit_routes_quo&time='.time().'&cid[0]='.$cid[0].'&id='.$row->id;
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td align="center">
					<?php echo $i+1;?>
				</td>
				<td align="center"><input  type="checkbox" id = "route_id" onclick="isChecked(this.checked);" value="<?php echo $row->id;?>" name="route_id[]"  />					
				</td>
				<td align="center">
                                        <a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmquo&task=add_approvers_quo&cid[]=<?php echo $cid[0]?>&routes=<?php echo $row->id?>" title="Click here for add Approvers">
                                                <?php echo $row->name; ?>
                                        </a>
					<p id="listAjaxUser">
					
					</p>
				</td>
				<td align="left">
					<?php echo $row->description; ?>
				</td>		
				<td align="center">
					<?php echo $row->status; ?>
				</td>		                                
				<td align="center">
					<?php echo JHTML::_('date', $row->due_date, JText::_('DATE_FORMAT_LC5')) ;?>
				</td>
				<td align="center">
                                        <?php echo ($row->owner) ? GetValueUser($row->owner, 'name') : '';?>
				</td>
				<td align="center">
                                        <?php                                         
                                        if($row->id == $this->quo_row->quo_routes_id)
                                                echo '<strong>Current Route</strong>';
                                        else{
                                                if($row->status=="Create" || $row->status=="Started"){
                                        ?>
					<a href="<?php echo $set_route;?>">Set Route</a>&nbsp;| &nbsp;
                                        <a href="<?php echo $edit_link;?>">Edit</a>
                                        <?php
                                        }
                                        else{
                                                 ?>
					Can not do this action
                                        <a href="<?php //echo $edit_link;?>"></a>
                                        <?php
                                        }
                                        }
                                        ?>
				</td>                                
				                            
			</tr>
			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>
	</table>

	<div class="clr"></div>	

	<input type="hidden" name="option" value="com_apdmquo" />
	<input type="hidden" name="task" value="" />
        <input type="hidden" name="quo" value="<?php echo $cid[0]?>" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>



