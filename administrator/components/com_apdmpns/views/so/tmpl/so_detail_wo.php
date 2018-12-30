<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php
//
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
$cid = JRequest::getVar('cid', array(0));
$edit = JRequest::getVar('edit', true);

JToolBarHelper::title("SO#: ".$this->so_row->so_cuscode, 'cpanel.png');
$role = JAdministrator::RoleOnComponent(10);      
if (in_array("W", $role)) {	
        //JToolBarHelper::addWoSo("ADD WO#", $this->so_row->pns_so_id);       
         JToolBarHelper::customX('add_wo', 'new', '', 'NEW WO#', false);	
        
}
if (in_array("D", $role)) {
        JToolBarHelper::deletePns('Are you sure to delete it?',"removewoso","REMOVE WO#");
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
                if(pressbutton == 'removewoso')
                {                       
                     submitform( pressbutton );
                     return;
                }
                if (pressbutton == 'add_wo') {
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
			<li><a id="detail" href="index.php?option=com_apdmpns&task=so_detail&id=<?php echo $this->so_row->pns_so_id;?>" ><?php echo JText::_( 'DETAIL' ); ?></a></li>
			<li><a id="bom" class="active"><?php echo JText::_( 'AFFECTED WO#' ); ?></a></li>
                        <li><a id="bom" href="index.php?option=com_apdmpns&task=so_detail_support_doc&id=<?php echo $this->so_row->pns_so_id;?>"><?php echo JText::_( 'SUPPORTING DOC' ); ?></a></li>
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

<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data" >      
        <fieldset class="adminform">
		 
        	<div class="col width-100">
		<fieldset class="adminform">		
                <table width="100%" class="adminlist" cellpadding="1">
	<thead>
		<tr>
			<th width="5%" class="title">
					<?php echo JText::_('No.')?>
			</th>
                        <th width="8%">
				<?php echo JText::_('WO#')?>
			</th>
                         <th width="8%">
				<?php echo JText::_('PN')?>
			</th>
			<th width="8%">
				<?php echo JText::_('Description')?>
			</th>
			<th width="6%">
				<?php echo JText::_('Qty')?>
			</th>
                        <th width="6%">
				<?php echo JText::_('UOM')?>
			</th>
                        <th width="6%">
				<?php echo JText::_('Start Date')?>
			</th>
                        <th width="6%">
				<?php echo JText::_('Deadline')?>
			</th>
                         <th width="6%">
				<?php echo JText::_('Time remain(day)')?>
			</th>                        
			<th width="6%">
				<?php echo JText::_('Status')?>
			</th>
			<th>
				<?php echo JText::_('Delay')?>				
			</th>
                        <th>
				<?php echo JText::_('Rework')?>				
			</th>
			
			
		</tr>
	</thead>
        <?php 
        //level1
        $level=0;
        foreach ($this->wo_list as $row){
                $level++;
                if ($row->pns_cpn == 1)
                        $link = 'index.php?option=com_apdmpns&amp;task=detailmpn&cid[0]=' . $row->pns_id;
                else
                        $link = 'index.php?option=com_apdmpns&amp;task=detail&cid[0]=' . $row->pns_id;
                if ($row->pns_revision) {
                        $pnNumber = $row->ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                } else {
                        $pnNumber = $row->ccs_code . '-' . $row->pns_code;
                }  
                $background="";
                $remain_day = $row->wo_remain_date;
                if($remain_day<=0)
                {
                        $remain_day = 0;
                        $background= "style='background-color:#f00;color:#fff'";
                }
                elseif($row->wo_remain_date<=3)
                {
                        $background= "style='background-color:#ff0;color:#fff'";
                }
                ?>
        <tr>		
		<td><?php echo $level;?></td>
                <td><?php echo '<a href="index.php?option=com_apdmpns&task=wo_detail&id='.$row->pns_wo_id.'" title="'.JText::_('Click to see detail WO').'">'.$row->wo_code.'</a> '; ?></td>                
		<td><?php echo '<a href="'.$link.'" title="'.JText::_('Click to see detail PNs').'">'.$pnNumber.'</a> '; ?></td>		
		<td><span class="editlinktip hasTip" title="<?php echo $row->pns_description; ?>" ><?php echo limit_text($row->pns_description, 15);?></span></td>
                <td><?php echo $row->wo_qty;?></td>
                <td><?php echo $row->pns_uom;?></td>
                <td><?php echo JHTML::_('date', $row->wo_start_date, JText::_('DATE_FORMAT_LC3')); ?></td>
                <td><?php echo JHTML::_('date', $row->wo_completed_date, JText::_('DATE_FORMAT_LC3')); ?></td>
                <td <?php echo $background?>><?php echo $remain_day;?></td>
                <td><?php echo $row->so_state;?></td>
                <td><?php echo round($row->wo_delay);?></td>
                <td><?php echo round($row->wo_rework);?></td>                
	</tr>
<?php 
        }
?>
</table>
                </fieldset>
</div>	
        </fieldset>
        <input type="text" name="so_id" value="<?php echo $this->so_row->pns_so_id; ?>" />
        <input type="hidden" name="option" value="com_apdmpns" />     
        <input type="text" name="id" value="<?php echo JRequest::getVar('id'); ?>" />     
	<input type="hidden" name="task" value="" />	
        <input type="hidden" name="return" value="so_detail_support_doc"  />
        <input type="hidden" name="boxchecked" value="1" />
<?php echo JHTML::_('form.token'); ?>
</form>
