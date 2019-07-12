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
?>

<?php
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
                        <li><a id="ecohistory" href="index.php?option=com_apdmpns&task=eco_history&cid[0]=<?php echo $this->row->pns_id;?>"><?php echo JText::_( 'ECO History' ); ?></a></li>
                        <li><a id="whereused" href="index.php?option=com_apdmpns&task=whereused&id=<?php echo $this->row->pns_id; ?>"><?php echo JText::_('Where Used'); ?></a></li>
                        <li><a id="specification" href="index.php?option=com_apdmpns&task=specification&cid[]=<?php echo $this->row->pns_id; ?>"><?php echo JText::_('Specification'); ?></a></li>
                        <li><a id="mep" href="index.php?option=com_apdmpns&task=mep&cid[]=<?php echo $this->row->pns_id; ?>"><?php echo JText::_('MEP'); ?></a></li>
                        <li><a id="rev" href="index.php?option=com_apdmpns&task=rev&cid[]=<?php echo $this->row->pns_id; ?>"><?php echo JText::_('REV'); ?></a></li>
                         <?php if($this->row->pns_cpn!=1){?>
                        <li><a id="dash" href="index.php?option=com_apdmpns&task=dash&cid[]=<?php echo $this->row->pns_id; ?>"><?php echo JText::_('DASH ROLL'); ?></a></li>                        
                        <?php }?>
                        <li><a id="po" class="active"><?php echo JText::_('PO'); ?></a></li>
                        <li><a id="rev" href="index.php?option=com_apdmpns&task=sto&cid[]=<?php echo $this->row->pns_id; ?>"><?php echo JText::_('STO'); ?></a></li>
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
<?php if (count($this->pos) > 0) { ?>
                <table class="adminlist" cellspacing="1" width="400">
                        <thead>
                                <tr>
                                        <th width="2%"><?php echo JText::_('NUM'); ?></th>
                                        <th width="100"><?php echo JText::_('P.O Number'); ?></th>
                                        <th width="50"><?php echo JText::_('Qty'); ?></th>
                                        <th width="200"><?php echo JText::_('Description'); ?></th>
                                        <th width="100"><?php echo JText::_('Attached'); ?></th>
                                        <th width="100"><?php echo JText::_('Created Date'); ?></th>
                                        <th width="100"><?php echo JText::_('Owner'); ?></th>
<!--                                        <th width="100"><?php echo JText::_('Action'); ?></th>-->
                                </tr>
                        </thead>
                        <tbody>					
        <?php
        $i = 0;
        foreach ($this->pos as $po) {
                $i++;
                ?>
                                        <tr>
                                                <td align="center"><?php echo $i; ?></td>
                                                <td align="center"><a href="index.php?option=com_apdmpns&task=po_detail&id=<?php echo $po->pns_po_id; ?>" title="<?php echo JText::_('Click here view detail') ?>" ><?php echo $po->po_code; ?></a> </td>
                                                <td align="center"><?php echo $po->stock; ?></td>
                                                <td align="left"><?php echo $po->po_description; ?></td>
                                                <td align="center">
                <?php if ($po->po_file) { ?>
                                                                <a href="index.php?option=com_apdmpns&task=download_po&id=<?php echo $po->pns_po_id; ?>" title="<?php echo JText::_('Click here to download') ?>" ><?php echo JText::_('Download') ?></a>&nbsp;&nbsp;
                                                        <?php } ?>
                                                </td>
                                                <td align="center">
                                                        <?php echo JHTML::_('date', $po->po_created, JText::_('DATE_FORMAT_LC5')); ?>
                                                </td>
                                                <td align="center">
                                                        <?php echo GetValueUser($po->po_create_by, "name"); ?>
                                                </td>                                                  
<!--                                                <td>
                                                        <?php if(in_array("D", $role)){?>
                                                        <a href="index.php?option=com_apdmpns&task=remove_po&id=<?php echo $po->pns_po_id; ?>&pns_id=<?php echo $this->row->pns_id ?>" title="Click to remove"><?php echo JText::_('Remove') ?></a>
                                                                <?php }
                                                                ?>
                                                </td>-->
                                        </tr>
                                                <?php }
                                        } ?>
                </tbody>
        </table>		

        <div style="display:none"><?php
                                        //echo $editor->display('text', $row->text, '10%', '10', '10', '3');
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
