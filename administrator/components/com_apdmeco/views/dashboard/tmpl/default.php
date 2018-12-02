<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	$role = JAdministrator::RoleOnComponent(5);
     	
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
function saveApproveTask(id){
                var approve_status = $('approve_status_'+id).value;
                var approve_note = $('approve_note_'+id).value; 
		var routes_id = $('routes_id_'+id).value;
                var eco_id = $('eco_id_'+id).value;
                if(approve_note=="")
                {
                        alert("Please input comment before save");
                        return false;
                }
                var url = 'index.php?option=com_apdmeco&task=saveapproveAjax&cid='+eco_id;
                url = url + '&approve_status=' + approve_status + '&approve_note=' + approve_note+ '&routes_id=' + routes_id;
		var MyAjax = new Ajax(url, {
			method:'get',
			onComplete:function(result){
				window.location.assign("index.php?option=com_apdmeco&task=dashboard");
                               
			}
		}).request();
	}

</script>

<style>
.scroll {
   width: 200px;
   height: 300px;
   overflow: scroll;
}
/* width */
.scroll::-webkit-scrollbar {
    width: 10px;
}

/* Track */
.scroll::-webkit-scrollbar-track {
    background: #f1f1f1; 
}
 
/* Handle */
.scroll::-webkit-scrollbar-thumb {
    background: #888; 
}

/* Handle on hover */
.scroll::-webkit-scrollbar-thumb:hover {
    background: #555; 
}
</style>

                        <fieldset class="adminform">
                        <legend><?php echo JText::_( 'My task' ); ?></legend>
<!--<form action="index.php?option=com_apdmeco" method="post" name="adminForm1" >-->
<form action="index.php?option=option=com_apdmeco&task=dashboard&tmpl=component" method="post" name="adminForm1" id="adminFormPns"  >
        <div class="col width-100 scroll">
        <table class="adminlist" cellpadding="0">
<thead>
			<tr>
				<th width="5%" class="title">
					<?php echo JText::_( '#' ); ?>
				</th>
				
				<th class="title" width="7%">
					<?php echo  JText::_('Name'); ?>
                                </th>
                                <th class="title" width="6%">
					<?php echo  JText::_('Eco'); ?>
                                </th>
				<th  class="title" width="20%">
					<?php echo  JText::_('Description'); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('State'); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Title'); ?>
				</th>                             
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Owner'); ?>
				</th>        
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Approve/Reject'); ?>
				</th>                                
				<th width="15%" class="title" nowrap="nowrap">
					<?php echo JText::_('Comment'); ?>
				</th>                                
                                <th width="5%" lass="title"  >
					<?php echo JText::_( 'Due date' ); ?>
				</th>
				<th width="5%" class="title">
					<?php echo JText::_( 'Action' ); ?>
				</th>                                
			</tr>
		</thead>                
		<tbody>
		<?php		
//                rt.status as route_status,st.*,eco.eco_id,eco.eco_create_by,rt.name as route_name,eco.eco_name,eco.description,eco.eco_status
			$i = 0;
			foreach ($this->arr_inreview as $row)
			{
                                $i++;
				$linkEco 	= 'index.php?option=com_apdmeco&task=detail&cid[]='.$row->eco_id;	
                                $linkRoute = 'index.php?option=com_apdmeco&task=add_approvers&cid[]='.$row->eco_id.'&routes='.$row->routes_id;				
			?>
			<tr class="">
				<td width="6%" >
					<?php echo $i;?>
				</td>
				<td width="16%"><a href='<?php echo $linkRoute;?>'><?php echo $row->route_name; ?></a></td>
				<td width="17%"><a href='<?php echo $linkEco;?>'><?php echo $row->eco_name; ?></a></td>
                                <td width="35%"width="15%"><?php echo $row->eco_description; ?></td>
                                <td width="5%"><?php echo $row->eco_status; ?></td>
                                <td width="5%"><?php echo $row->title; ?></td>
                                <td  width="5%" align="center">
                                        <?php echo ($row->owner) ? GetValueUser($row->owner, 'name') : '';?>
				</td>
                                <td width="5%"> 
                                                                                
                                                        <?php  
                                                        if($row->eco_status != 'Released'){                                                          
                                                                $status_arr = array();
                                                                $status_arr[] = JHTML::_('select.option', 'Inreview', JText::_('Inreview'), 'value', 'text');
                                                                $status_arr[] = JHTML::_('select.option', 'Released', JText::_('Approve'), 'value', 'text');
                                                                $status_arr[] = JHTML::_('select.option', 'Reject', JText::_('Reject'), 'value', 'text');                                                        
                                                         echo JHTML::_('select.genericlist', $status_arr, 'approve_status_'. $i, 'class="inputbox" size="1" ', 'value', 'text',"Inreview" );
                                                        ?>
                                                        <input type="hidden" name="routes_id" id ="routes_id_<?php echo $i;?>" value="<?php echo $row->routes_id;?>" />
                                                        <input type="hidden" name="eco_id" id ="eco_id_<?php echo $i;?>" value="<?php echo $row->eco_id;?>" />
                                                        <?php                                                         
                                                        }
                                                        elseif($row->eco_status == 'Released'){
                                                                echo "Approved";
                                                        }
                                                       ?>                                        
                                       </td>				
				<td  width="5%" align="center">
                                          <?php  
                                                        if($row->eco_status != 'Released'){                                                          
                                                       ?>
                                         <textarea cols="20" rows="3" id ="approve_note_<?php echo $i;?>" name ='approve_note'><?php echo $row->note;?></textarea>
					<?php } ?>
				</td>		
					                                
				<td   width="5%" align="center">
					<?php echo JHTML::_('date', $row->due_date, '%m-%d-%Y') ;?>
				</td>
				
				<td  width="5%" align="center">
                                       <a id ="save_approve_task" name ="save_approve_task" href="javascript:void(0);" onclick="saveApproveTask(<?php echo $i?>);">Done</a>
                                       
				</td>                                
				                            
			</tr>
			<?php
				
				}
			?>
		</tbody>
                 <tfoot>
			<tr>
				<td colspan="11">
					<?php // echo $this->pagination_inreview->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
	</table>
</div>
	<div class="clr"></div>	

	<input type="hidden" name="option" value="com_apdmeco" />
	<input type="hidden" name="task" value="" />
       
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
                </fieldset>

                
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'My pending task' ); ?></legend>
                <form action="index.php?option=option=com_apdmeco&task=dashboard&tmpl=component" method="post" name="adminForm" id="adminFormPns"  >
             		<div class="col width-100 scroll">
              <table class="adminlist" cellpadding="1">
		<thead>
			<tr>
				<th width="2%" class="title">
					<?php echo JText::_( '#' ); ?>
				</th>
				
				<th class="title" width="15%">
					<?php echo  JText::_('Name'); ?>
                                </th>
                                <th class="title" width="15%">
					<?php echo  JText::_('Eco'); ?>
                                </th>
				<th  class="title" width="10%">
					<?php echo  JText::_('Description'); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('State'); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Title'); ?>
				</th>                             
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Approver'); ?>
				</th>        				              
                                <th class="title"  >
					<?php echo JText::_( 'Due date' ); ?>
				</th>
				<th class="title">
					<?php echo JText::_( 'Remind' ); ?>
				</th>                                
			</tr>
		</thead>
  

		<tbody>
		<?php		
//                rt.status as route_status,st.*,eco.eco_id,eco.eco_create_by,rt.name as route_name,eco.eco_name,eco.description,eco.eco_status
			$i = 0;
			foreach ($this->arr_pending as $row)
			{
                                $i++;                               
				$linkEco 	= 'index.php?option=com_apdmeco&task=detail&cid[]='.$row->ecoid;	
                                $linkRoute = 'index.php?option=com_apdmeco&task=add_approvers&cid[]='.$row->ecoid.'&routes='.$row->id;				
			?>
			<tr class="">
				<td>
					<?php echo $i;?>
				</td>
				<td><a href='<?php echo $linkRoute;?>'><?php echo $row->route_name; ?></a></td>
				<td><a href='<?php echo $linkEco;?>'><?php echo $row->eco_name; ?></a></td>
                                <td><?php echo $row->description; ?></td>
                                <td><?php echo $row->eco_status; ?></td>
                                <td>
                                <?php                                 
                                $arrAppver= ECOController::GetListApprover($row->id);                                                                 
                                ?>
                                      <table class="adminlist" cellpadding="0" style="background-color:#fff;border-bottom: 1px">
                                              <?php 
                                              foreach($arrAppver as $rs)
                                              {
                                              ?>
                                              <tr>
                                                      <td><?php echo $rs['title']; ?></td>
                                                     
                                              </tr>
                                              <?php }?>
                                                </table>					
				</td><td>
                                 <table class="adminlist" cellpadding="0" style="background-color:#fff;border-bottom: 1px">
                                              <?php 
                                              foreach($arrAppver as $rs)
                                              {
                                              ?>
                                              <tr>
                                                      
                                                      <td><?php echo $rs['approver']; ?></td>
                                                     
                                              </tr>
                                              <?php }?>
                                                </table>
                                </td><td>
                                <table class="adminlist" cellpadding="0" style="background-color:#fff;border-bottom: 1px">
                                              <?php 
                                              foreach($arrAppver as $rs)
                                              {
                                              ?>
                                              <tr>
                                                    
                                                        <td><?php echo JHTML::_('date', $row->due_date, '%m-%d-%Y'); ?></td>                                                  
                                              </tr>
                                              <?php }?>
                                                </table>	
				</td>
				<td align="center">
                                       <a id ="save_approve_task" name ="save_approve_task" href="index.php?option=com_apdmeco&amp;task=sendRemindApprove&cid=<?php echo $row->ecoid;?>&routes=<?php echo $row->id;?>&time=<?php echo time();?>">Remind</a>
                                       
				</td>                                
				                            
			</tr>
			<?php
				
				}
			?>
		</tbody>                
                <tfoot>
			<tr>
				<td colspan="11">
					<?php  //echo $this->pagination_pending->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
	</table>
                </div>
                        <input type="hidden" name="option" value="com_apdmeco" />
	<input type="hidden" name="boxchecked" id="boxchecked" value="0" />
	<?php echo JHTML::_( 'form.token' ); ?>
                </form>

                </fieldset>
                        </div>



