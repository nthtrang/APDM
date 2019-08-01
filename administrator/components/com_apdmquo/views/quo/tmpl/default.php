<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
$cparams = JComponentHelper::getParams ('com_media');
JToolBarHelper::title("Quotation", 'cpanel.png');
$role = JAdministrator::RoleOnComponent(8);      
if (in_array("W", $role)) {
      //  JToolBarHelper::addNewito("New ITO", $this->row->pns_id);
        JToolBarHelper::customX('addquo', 'new', '', 'New Quotation', false);        
        JToolBarHelper::customX('addform', 'new', '', 'Form Template', false);
        //JToolBarHelper::addNeweto("New ETO", $this->row->pns_id);
}
$cparams = JComponentHelper::getParams('com_media');
$editor = &JFactory::getEditor();
?>
<?php
// clean item data
JFilterOutput::objectHTMLSafe($user, ENT_QUOTES, '');
?>
<script language="javascript" type="text/javascript">
    function submitbutton(pressbutton) {
        var form = document.adminForm;
        if (pressbutton == 'btnSubmit') {
            var d = document.adminForm;
            if ( document.adminForm.text_search.value==""){
                alert("Please input keyword");
                d.text_search.focus();
                return false;
            }else{
                document.adminForm.submit();
                submitform( pressbutton );

            }
        }

        if (pressbutton == 'search_qty') {
            submitform( pressbutton );
            return;
        }

        if (pressbutton == 'addquo') {
            submitform( pressbutton );
            return;
        }
        if (pressbutton == 'addform') {
            submitform( pressbutton );
            return;
        }

    }
</script>


                        <fieldset class="adminform">
                        <legend><?php echo JText::_( 'My Task' ); ?></legend>
<!--<form action="index.php?option=com_apdmeco" method="post" name="adminForm1" >-->
        <form action="index.php"  onsubmit="submitbutton('')"  method="post" name="adminForm" >
        <div class="col width-100 scroll">
        <table class="adminlist" cellpadding="0">
<thead>
			<tr>
				<th width="5%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				
				<th class="title" width="7%">
					<?php echo  JText::_('Quotation'); ?>
                                </th>
				<th  class="title" width="20%">
					<?php echo  JText::_('Description'); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Target Date'); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Time Remain'); ?>
				</th>                             
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Owner'); ?>
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
				$linkQuo 	= 'index.php?option=com_apdmquo&task=quo_detail&id='.$row->quotation_id;	
                                $linkRoute = 'index.php?option=com_apdmeco&task=add_approvers&id='.$row->quotation_id.'&routes='.$row->routes_id;				
                                
                                $background="";
                            $remain_day = $row->route_remain_date;                            
                            $arr = array('Started','Create');
                            if(in_array($row->route_status,$arr)){
                                if($remain_day<=0)
                                {
                                    $background= "style='background-color:#f00;color:#fff'";

                                }
                                elseif($remain_day<=3)
                                {

                                    $background= "style='background-color:#ff0;color:#000'";

                                }
                            }
			?>
			<tr class="">
				<td align="center" width="3%" >
					<?php echo $i;?>
				</td>				
				<td align="center" width="8%"><a href='<?php echo $linkQuo;?>'><?php echo $row->quo_code.' '. $row->quo_revision; ?></a></td>
                                <td align="center" width="25%" width="15%"><?php echo $row->description; ?></td>
                                <td align="center" width="5%"><?php echo JHTML::_('date', $row->route_due_date, JText::_('DATE_FORMAT_LC5')) ;?></td>
                                <td   width="8%" align="center" <?php echo $background?>>
					<?php echo $remain_day?>
				</td>                                
                                <td align="center" width="5%">
                                        <?php echo ($row->owner) ? GetValueUser($row->owner, 'name') : '';?>
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

	<input type="hidden" name="option" value="com_apdmquo" />
	<input type="hidden" name="task" value="quo" />
       
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
                </fieldset>

                
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'My Pending Task' ); ?></legend>
                <form action="index.php?option=option=com_apdmeco&task=dashboard&tmpl=component" method="post" name="adminFormPns" id="adminFormPns"  >
             		<div class="col width-100 scroll">
              <table class="adminlist" cellpadding="1">
		<thead>
			<tr>
				<th width="5%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				
				<th class="title" width="10%">
					<?php echo  JText::_('Quotation'); ?>
                                </th>                               
				<th  class="title" width="25%">
					<?php echo  JText::_('Description'); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('State'); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Target Date'); ?>
				</th>            
                                <th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Time Remain'); ?>
				</th>  
				<th width="7%" class="title" nowrap="nowrap">
					<?php echo JText::_('Approver'); ?>
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
				$linkQuo 	= 'index.php?option=com_apdmquo&task=quo_detail&id='.$row->quotation_id;	
                                $linkRoute = 'index.php?option=com_apdmquo&task=add_approvers_quo&id='.$row->quotation_id.'&routes='.$row->id;				
			?>
			<tr class="">
				<td align="center">
					<?php echo $i;?>
				</td>				
				<td align="center"><a href='<?php echo $linkQuo;?>'><?php echo $row->quo_code.' '. $row->quo_revision; ?></a></td>
                                <td align="left"><?php echo $row->description; ?></td>
                                <td align="center"><?php echo $row->quo_state; ?></td>                               
                                <td align="center" width="5%"><?php echo JHTML::_('date', $row->route_due_date, JText::_('DATE_FORMAT_LC5')) ;?></td>
                               <td   width="8%" align="center" <?php echo $background?>>
					<?php echo $remain_day?>
				</td>  
                                <td align="center" width="5%">
                                        <?php echo ($row->user_id) ? GetValueUser($row->user_id, 'name') : '';?>
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

                    <input name="nvdid" value="<?php echo $this->lists['count_vd']; ?>" type="hidden" />
                    <input name="nspid" value="<?php echo $this->lists['count_sp']; ?>" type="hidden" />
                    <input name="nmfid" value="<?php echo $this->lists['count_mf']; ?>" type="hidden" />
                    <input type="hidden" name="pns_id" value="<?php echo $this->row->pns_id; ?>" />
                    <input type="hidden" name="cid[]" value="<?php echo $this->row->pns_id; ?>" />
                    <input type="hidden" name="option" value="com_apdmquo" />
                    <input type="hidden" name="task" value="quo" />
                    <input type="hidden" name="redirect" value="mep" />
                    <input type="hidden" name="boxchecked" value="0" />
                    <input type="hidden" name="return" value="<?php echo $this->cd; ?>"  />
                    <?php echo JHTML::_('form.token'); ?>
                </form>

                </fieldset>




