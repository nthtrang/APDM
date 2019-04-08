<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
$cid = JRequest::getVar('cid', array(0));
$edit = JRequest::getVar('edit', true);
$partnumber = $this->row->ccs_code . '-' . $this->row->pns_code;
if ($this->row->pns_revision)
        $partnumber .= '-' . $this->row->pns_revision;
JToolBarHelper::title($partnumber, 'cpanel.png');
$role = JAdministrator::RoleOnComponent(6);   

if (in_array("E", $role)&& $this->row->pns_life_cycle =='Create') {
      //  JToolBarHelper::addPnsPos("Add PO", $this->row->pns_id);
}
$cparams = JComponentHelper::getParams('com_media');
$editor = &JFactory::getEditor();

// clean item data
JFilterOutput::objectHTMLSafe($user, ENT_QUOTES, '');
?>
<script language="javascript" type="text/javascript">
        function submitbutton(pressbutton) {
                var form = document.adminForm;
                if (pressbutton == 'cancel') {
                        submitform( pressbutton );
                        return;
                }
                var mf_info= document.getElementsByName("mf_info[]");
                for(var i=0;i<mf_info.length;i++)
                {
                        if(mf_info[i].value =='')
                        {
                                alert("Must input PNS");
                                return;
                        }
                }
                submitform( pressbutton );
        }
        function removeMf(id)
        {
                var parent = document.getElementById("manufacture_get");
                var mf = document.getElementById(id);
                parent.removeChild(mf);
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
                        <li><a id="detail"  href="index.php?option=com_apdmpns&task=detail&cid[0]=<?php echo $this->row->pns_id ?>"><?php echo JText::_('Detail'); ?></a></li>
                        <li><a id="bom" href="index.php?option=com_apdmpns&task=bom&id=<?php echo $this->row->pns_id; ?>"><?php echo JText::_('BOM'); ?></a></li>
                        <li><a id="whereused" href="index.php?option=com_apdmpns&task=whereused&id=<?php echo $this->row->pns_id; ?>"><?php echo JText::_('Where Used'); ?></a></li>
                        <li><a id="specification" href="index.php?option=com_apdmpns&task=specification&cid[]=<?php echo $this->row->pns_id; ?>"><?php echo JText::_('Specification'); ?></a></li>
                        <li><a id="mep" href="index.php?option=com_apdmpns&task=mep&cid[]=<?php echo $this->row->pns_id; ?>"><?php echo JText::_('MEP'); ?></a></li>
                        <li><a id="rev" href="index.php?option=com_apdmpns&task=rev&cid[]=<?php echo $this->row->pns_id; ?>"><?php echo JText::_('REV'); ?></a></li>
                         <?php if($this->row->pns_cpn!=1){?>
                        <li><a id="dash" href="index.php?option=com_apdmpns&task=dash&cid[]=<?php echo $this->row->pns_id; ?>"><?php echo JText::_('DASH ROLL'); ?></a></li>                        
                        <?php }?>
                        <li><a id="po" href="index.php?option=com_apdmpns&task=po&cid[]=<?php echo $this->row->pns_id; ?>"><?php echo JText::_('PO'); ?></a></li>
                        <li><a id="stos" class="active"><?php echo JText::_('STO'); ?></a></li>
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
<fieldset class="adminform">
		<legend><?php echo JText::_( 'Location and Quantity' ); ?></legend>
                <?php              
                $arrayPartState =array("OH-G","OH-D","IT-G","IT-D","OO","PROTOTYPE");
                ?><div class="col width-100 scroll">
                <table class="adminlist" cellspacing="1" width="400">
                        <thead>
                                <tr>
                                        <th width="100"><?php echo JText::_('Part State'); ?></th>                                               
                                        <th width="100"><?php echo JText::_('Qty'); ?></th>
                                        <th width="100"><?php echo JText::_('Location'); ?></th>                                        
                                </tr>
                                </thead>
                                <tbody>
                                <?php 
                                foreach($arrayPartState as $partState)
                                {
                                        $location = PNsController::GetLocationFromPartStatePns($partState,$this->row->pns_id);
                                        
                                        if(count($location)>0)
                                        {
                               ?>
                                        <tr rowspan="<?php echo count($location); ?>">
                                                                <td  align="center"><?php echo $partState ?></td>
                                                                <td align="center">
                                                                        <table class="adminlist" cellspacing="1" width="400">
                                                                                <?php
                                                                                foreach ($location as $keyloc => $valoc) {
                                                                                        if ($valoc)
                                                                                        {
                                                                                                ?><tr><td align="center"> <?php echo $valoc;?></td></tr>
                                                                                <?php
                                                                                        }
                                                                                }
                                                                                ?>
                                                                        </table>
                                                                </td>  
                                                                <td>
                                                                        <table class="adminlist" cellspacing="1" width="400">
                                                                                <?php
                                                                                foreach ($location as $keyloc => $valoc) {
                                                                                        if ($valoc) 
                                                                                        {
                                                                                                ?><tr><td align="center"><?php echo $keyloc;?></td></tr>
                                                                                        <?php                                                                                                 
                                                                                        }
                                                                                } ?>
                                                                        </table>
                                                                </td>                                         
                                                        </tr>
                                <?php 
                                }
                                }
                                ?>        
                                </tbody>
                        
                </table>
                </div>
</fieldset>
<fieldset class="adminform">
		<legend><?php echo JText::_( 'Tool-Out' ); ?></legend>
                <table class="adminlist" cellspacing="1" width="400">
                <?php if (count($this->tto_pn_list) > 0) { ?>                
                        <thead>
                                <tr>
                                        <th width="100" colspan="6"><?php echo JText::_('Tool Out'); ?></th>
                                </tr>
                                <tr>
                                        <th width="100"><?php echo JText::_('Date Out'); ?></th>                                           
                                        <th width="100"><?php echo JText::_('QTY Out'); ?></th>      
                                        <th width="100"><?php echo JText::_('State'); ?></th>      
                                        <th width="100"><?php echo JText::_('Tool ID'); ?></th>
                                        <th width="100"><?php echo JText::_('Part State'); ?></th>                                                                                
                                        <th width="100"><?php echo JText::_('Owner'); ?></th>
                                </tr>
                        </thead>
                        <tbody>					
        <?php
        $i = 0;
        foreach ($this->tto_pn_list as $tto) {
                $i++;
            $link = "index.php?option=com_apdmtto&task=tto_detail&id=".$tto->pns_tto_id;
            if($sto->tto_type_inout==2){
                $link = "index.php?option=com_apdmsto&task=tto_detail&id=".$tto->pns_tto_id;
            }
                ?>
                                        <tr>
                                                
                                               <td align="center">
                                                        <?php echo JHTML::_('date', $tto->tto_owner_out_confirm_date, JText::_('DATE_FORMAT_LC5')); ?>
                                                </td>
                                                <td align="center"><?php echo $tto->qty; ?></td>
                                                <td align="center"><?php echo $tto->tto_state; ?></td>
                                                
                                                <td align="center"><a href="<?php echo $link; ?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $tto->location?PNsController::GetCodeLocation($tto->location):"";?></a></td>
                                                <td align="center"><a href="<?php echo $link; ?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $tto->partstate; ?></a></td>
                                                
                                                <td align="center">
                                                        <?php echo GetValueUser($tto->tto_owner_out, "name"); ?>
                                                </td> 
                                                
                                        </tr>
                                                <?php }
                                         ?>
                </tbody>
                <tr>
                                        <td width="100" align="center" colspan="6">
                                        <?php 
                                        echo JText::_('Tool Remain:'); 
                                        echo CalculateToolRemainValue($this->row->pns_id);
                                        ?></td>
                                </tr>
                 <?php 
                 }
                 ?>
                 
                                   </table>
</fieldset>
<fieldset class="adminform">
		<legend><?php echo JText::_( 'Transaction History' ); ?></legend>
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data" >
    <table width="80%" border="0">
        <tr>
            <td align="right">
                Created From From&nbsp;&nbsp
                <?php echo JHTML::_('calendar',$this->sto_created_from, 'sto_created_from', 'sto_created_from', '%m/%d/%Y', array('class'=>'inputbox', 'size'=>'10',  'maxlength'=>'10')); ?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                To&nbsp;&nbsp;<?php echo JHTML::_('calendar',$this->sto_created_to, 'sto_created_to', 'sto_created_to', '%m/%d/%Y', array('class'=>'inputbox', 'size'=>'10',  'maxlength'=>'10')); ?>	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <?php echo $this->lists['sto_create_by'];?>
                <?php echo $this->lists['sto_owner_out'];?>
                <input type="submit"  onclick="submitbutton('search_tool_out')"  name="search_tool_out" value="Go">
                <a href="index.php?option=com_apdmtto&amp;task=tto&amp;clean=all"><input type="button" value="Reset"></a></td>
        </tr>
    </table>
<?php if (count($this->stos) > 0) { ?>
         <div class="col width-100 scroll">
                <table class="adminlist" cellspacing="1" width="400">
                        <thead>
                                <tr>
                                        <th width="100"><?php echo JText::_('NUM'); ?></th>
                                        <th width="100"><?php echo JText::_('Transaction Number'); ?></th>                                        
                                        <th width="100"><?php echo JText::_('Description'); ?></th>                                                
                                        <th width="100"><?php echo JText::_('QTY In/QTY Out'); ?></th>
                                        <!--<th width="100"><?php /*echo JText::_('Attached'); */?></th>-->
                                        <th width="100"><?php echo JText::_('Location'); ?></th>
                                        <th width="100"><?php echo JText::_('Part State'); ?></th>
                                        <th width="100"><?php echo JText::_('Created Date'); ?></th>
                                        <th width="100"><?php echo JText::_('Owner'); ?></th>
                                        <th width="100"><?php echo JText::_('Created By'); ?></th>
<!--                                        <th width="100"><?php echo JText::_('Action'); ?></th>-->
                                </tr>
                        </thead>
                        <tbody>					
        <?php
        $i = 0;
        foreach ($this->stos as $sto) {
                $i++;
            $link = "index.php?option=com_apdmsto&task=ito_detail&id=".$sto->pns_sto_id;
            if($sto->sto_type==2){
                $link = "index.php?option=com_apdmsto&task=eto_detail&id=".$sto->pns_sto_id;
            }elseif($sto->sto_type==3){
                $link = "index.php?option=com_apdmpns&task=sto_detail_movelocation&id=".$sto->pns_sto_id;
            }elseif($sto->sto_type==4){//for TTO
                $link = "index.php?option=com_apdmtto&task=tto_detail&id=".$sto->pns_sto_id;
            }
                ?>
                                        <tr>
                                                <td align="center"><?php echo $i; ?></td>
                                                <td align="center"><a href="<?php echo $link; ?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $sto->sto_code; ?></a> </td>
                                                <td align="left"><?php echo $sto->sto_description; ?></td>
                                                <td align="center"><?php echo $sto->stock; ?></td>
                                                <!--<td align="center">
                                                <?php /*if ($sto->sto_file) { */?>
                                                                <a href="index.php?option=com_apdmpns&task=download_sto&id=<?php /*echo $sto->pns_sto_id; */?>" title="<?php /*echo JText::_('Click here to download') */?>" ><?php /*echo JText::_('Download') */?></a>&nbsp;&nbsp;
                                                        <?php /*} */?>
                                                </td>-->
                                                <td align="center"><a href="<?php echo $link; ?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $sto->location?PNsController::GetCodeLocation($sto->location):"";?></a></td>
                                                <td align="center"><a href="<?php echo $link; ?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $sto->partstate; ?></a></td>
                                                <td align="center">
                                                        <?php echo JHTML::_('date', $sto->sto_created, JText::_('DATE_FORMAT_LC5')); ?>
                                                </td>
                                                <td align="center">
                                                        <?php echo GetValueUser($sto->sto_owner, "name"); ?>
                                                </td> 
                                                <td align="center">
                                                        <?php echo GetValueUser($sto->sto_create_by, "name"); ?>
                                                </td>                                                                                                                                                      
<!--                                                <td>
                                                        <?php if(in_array("D", $role)){?>
                                                        <a href="index.php?option=com_apdmpns&task=remove_po&id=<?php echo $sto->pns_sto_id; ?>&pns_id=<?php echo $this->row->pns_id ?>" title="Click to remove"><?php echo JText::_('Remove') ?></a>
                                                                <?php }
                                                                ?>
                                                </td>-->
                                        </tr>
                                                <?php }
                                         ?>
                </tbody>
        </table>
         </div>
                 <?php 
                 }
                 ?>

        <div style="display:none"><?php
                             //           echo $editor->display('text', $row->text, '10%', '10', '10', '3');
                                        ?></div>
        <input name="nvdid" value="<?php echo $this->lists['count_vd']; ?>" type="hidden" />
        <input name="nspid" value="<?php echo $this->lists['count_sp']; ?>" type="hidden" />
        <input name="nmfid" value="<?php echo $this->lists['count_mf']; ?>" type="hidden" />
        <input type="hidden" name="pns_id" value="<?php echo $this->row->pns_id; ?>" />
        <input type="hidden" name="cid[]" value="<?php echo $this->row->pns_id; ?>" />	
        <input type="hidden" name="option" value="com_apdmpns" />
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="redirect" value="mep" />
        <input type="hidden" name="return" value="<?php echo $this->cd; ?>"  />
<?php echo JHTML::_('form.token'); ?>
</form>
</fieldset>
