<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php JHTML::_('behavior.modal'); ?>
<?php
$cid = JRequest::getVar('cid', array(0));
$edit = JRequest::getVar('edit', true);
$partnumber = $this->row->ccs_code . '-' . $this->row->pns_code;
if ($this->row->pns_revision)
        $partnumber .= '-' . $this->row->pns_revision;
JToolBarHelper::title($partnumber, 'cpanel.png');
if (!intval($edit)) {
        JToolBarHelper::save('save', 'Save & Add new');
}
$role = JAdministrator::RoleOnComponent(6);
if (in_array("E", $role) && $this->row->pns_life_cycle == 'Create') {
        JToolBarHelper::apply('edit_pns', 'Save');
}
if ($edit) {
        // for existing items the button is renamed `close`
        JToolBarHelper::cancel('cancel', 'Close');
} else {
        JToolBarHelper::cancel();
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
                var mf = document.getElementById(id).remove();
                //parent.removeChild(mf);
        }
	    window.addEvent('domready', function(){ var JTooltips = new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false}); });
    window.addEvent('domready', function() {

        SqueezeBox.initialize({});

        $$('a.modal-button').each(function(el) {
            el.addEvent('click', function(e) {
                new Event(e).stop();
                SqueezeBox.fromElement(el);
            });
        });
    });
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
                        <li><a id="mep" class="active"><?php echo JText::_('MEP'); ?></a></li>
                        <li><a id="rev" href="index.php?option=com_apdmpns&task=rev&cid[]=<?php echo $this->row->pns_id; ?>"><?php echo JText::_('REV'); ?></a></li>
                        <?php if ($this->row->pns_cpn != 1) { ?>
                                <li><a id="dash" href="index.php?option=com_apdmpns&task=dash&cid[]=<?php echo $this->row->pns_id; ?>"><?php echo JText::_('DASH ROLL'); ?></a></li>                        
                        <?php } ?>
                        <li><a id="pos" href="index.php?option=com_apdmpns&task=po&cid[]=<?php echo $this->row->pns_id; ?>"><?php echo JText::_('PO'); ?></a></li>                                                
                        <li><a id="stos" href="index.php?option=com_apdmpns&task=sto&cid[]=<?php echo $this->row->pns_id;?>"><?php echo JText::_( 'STO' ); ?></a></li>
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
        <div class="col width-60">
                <fieldset class="adminform">
                        <legend><?php echo JText::_('Vendor'); ?></legend>
                                <?php if (count($this->lists['arr_v']) > 0) { ?>
                                <table class="adminlist" cellspacing="1" width="400">
                                        <thead>
                                                <tr>
                                                        <th width="200"><?php echo JText::_('Vendor Name'); ?></th>
                                                        <th width="180"><?php echo JText::_('Vendor PN'); ?></th>
                                                        <th width="20">&nbsp;</th>
                                                </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($this->lists['arr_v'] as $v) {
                                                ?>		
                                                        <tr>
                                                                <td>
                                                                        <input type="hidden" name="v_exist[]" value="<?php echo $v['id'] ?>" >
                                                                        <input type="hidden" name="v_exist_id[]" value="<?php echo $v['v_id'] ?>" >
                                                                <?php echo $v['v_name'] ?> 
                                                                </td>
                                                                <td>
                                                                        <input size="40" type="text" value="<?php echo $v['v_value']; ?>" name="v_exist_value[]" />
                                                                </td>
                                                                <td>
                                                                        <a href="index.php?option=com_apdmpns&task=remove_info&id=<?php echo $v['id'] ?>&pns_id=<?php echo $this->row->pns_id ?>" title="Click to remove"><?php echo JText::_('Remove') ?></a>
                                                                </td>
                                                        </tr>
                                        <?php } ?>	
                                        </tbody>
                                </table>
                                        <?php }
                                        ?>	
                        <table class="admintable" cellspacing="1" width="400">
                                <thead>
                                        <tr>
                                                <th width="50%"><?php echo JText::_('Vendor Name'); ?></th>
                                                <th><?php echo JText::_('Vendor PN'); ?></th>
                                        </tr>
                                </thead>
                                <tbody id="vendor_get">
                                        <tr>
                                                <td colspan="2"><?php echo JText::_('Please select Vendor to add more information.') ?></td>
                                        </tr>
                                </tbody>
                        </table>
                        <p>	
                                <a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmsuppliers&task=get_supplier&tmpl=component&type=2&pns_id=<?php echo $this->row->pns_id ?>" title="Image">
                                        <input type="button" name="addVendor" value="<?php echo JText::_('Select Vendor') ?>"/>
                                </a>
                        </p>
                </fieldset>
        </div>
        <div class="clr"></div>
        <div class="col width-60">
                <fieldset class="adminform">
                        <legend><?php echo JText::_('Supplier'); ?></legend>
                                <?php if (count($this->lists['arr_s']) > 0) { ?>
                                <table class="adminlist" cellspacing="1" width="400">
                                        <thead>
                                                <tr>						
                                                        <th width="200"><?php echo JText::_('Supplier Name'); ?></th>
                                                        <th width="180"><?php echo JText::_('Supplier PN'); ?></th>
                                                        <th width="20"></th>
                                                </tr>
                                        </thead>
                                        <tbody>		
                                        <?php
                                        foreach ($this->lists['arr_s'] as $s) {?>	
                                                <tr>
                                                                <td>
                                                                        <input type="hidden" name="s_exist[]" value="<?php echo $s['id'] ?>" />
                                                                        <input type="hidden" name="s_exist_id[]" value="<?php echo $s['s_id'] ?>" />
                                                                        <?php echo $s['s_name'] ?> 
                                                                </td>
                                                                <td>
                                                                        <input type="text" size="40" value="<?php echo $s['s_value']; ?>" name="s_exist_value[]" />
                                                                </td>
                                                                <td>
                                                                        <a href="index.php?option=com_apdmpns&task=remove_info&id=<?php echo $s['id'] ?>&pns_id=<?php echo $this->row->pns_id ?>" title="Click to remove"><?php echo JText::_('Remove') ?></a>
                                                                </td>
                                                        </tr>
                                        <?php } ?>				
                                        </tbody>
                                </table>
                                        <?php } ?>
                        <table class="admintable" cellspacing="1" width="400">
                                <thead>
                                        <tr>						
                                                <th width="50%"><?php echo JText::_('Supplier Name'); ?></th>
                                                <th><?php echo JText::_('Supplier PN'); ?></th>
                                        </tr>
                                </thead>
                                <tbody id="supplier_get">					
                                        <tr>
                                                <td colspan="2"><?php echo JText::_('Please select Supplier to add more information.') ?></td>
                                        </tr>
                                </tbody>
                        </table>
                        <p>	
                                <a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmsuppliers&task=get_supplier&tmpl=component&type=3&pns_id=<?php echo $this->row->pns_id ?>" title="Image">
                                        <input type="button" name="addSupplier" value="<?php echo JText::_('Select Supplier') ?>"/>
                                </a>
                        </p>
                </fieldset>
        </div>
        <div class="clr"></div>
        <div class="col width-60">
                <fieldset class="adminform">
                        <legend><?php echo JText::_('Manufacturer'); ?></legend>
                                <?php if (count($this->lists['arr_m']) > 0) { ?>
                                <table class="adminlist" cellspacing="1" width="400">
                                        <thead>
                                                <tr>
                                                        <th width="200"><?php echo JText::_('Manufacturer Name'); ?></th>
                                                        <th width="180"><?php echo JText::_('Manufacturing PN'); ?></th>
                                                        <th width="20">&nbsp;</th>
                                                </tr>
                                        </thead>
                                        <tbody>					
                                        <?php foreach ($this->lists['arr_m'] as $m) { ?>
                                                        <tr>
                                                                <td>
                                                                        <input type="hidden" name="m_exist[]" value="<?php echo $m['id'] ?>" />
                                                                        <input type="hidden" name="m_exist_id[]" value="<?php echo $m['m_id'] ?>" />
                                                                        <?php echo $m['m_name'] ?> 
                                                                </td>
                                                                <td>
                                                                        <input type="text" size="40" value="<?php echo $m['m_value']; ?>" name="m_exist_value[]" /> 
                                                                </td>
                                                                <td>
                                                                        <a href="index.php?option=com_apdmpns&task=remove_infomf&id=<?php echo $m['id'] ?>&pns_id=<?php echo $this->row->pns_id ?>" title="Click to remove">
                                                                                <?php echo JText::_('Remove') ?>
                                                                        </a>
                                                                </td>
                                                        </tr>
                                                <?php }
                                        } ?>
                                </tbody>
                        </table>		
                        <table class="admintable" cellspacing="1" width="400">
                                <thead>
                                        <tr>
                                                <th width="50%"><?php echo JText::_('Manufacturer Name'); ?></th>
                                                <th><?php echo JText::_('Manufacturing PN'); ?></th>
                                        </tr>
                                </thead>
                                <tbody id="manufacture_get">					
                                        <tr>
                                                <td colspan="2"><?php echo JText::_('Please select Manufacturer to add more information.') ?></td>
                                        </tr>
                                </tbody>
                        </table
                        <p>	<a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmsuppliers&task=get_supplier&tmpl=component&type=4&pns_id=<?php echo $this->row->pns_id ?>" title="Manufacturer">
                                        <input type="button" name="addManufacture" value="<?php echo JText::_('Select Manufacturing') ?>"/>
                                </a></p>
                </fieldset>
        </div>
        <div style="display:none"><?php
// parameters : areaname, content, width, height, cols, rows
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
        <input type="hidden" value="<?php echo $this->row->pns_revision; ?>" name="pns_revision" id="pns_revision" class="inputbox" size="6" maxlength="2" />
        <input type="hidden" value="<?php echo $this->row->pns_revision; ?>" name="pns_revision_old" />
        <input type="hidden" value="<?php echo $this->row->pns_description ?>" name="pns_description" />
        <input type="hidden"  name="pns_code" id="pns_code"  size="10" value="<?php echo $this->row->pns_code; ?>"/>
        <input type="hidden" name="ccs_code" id="ccs_code" value="<?php echo $this->row->ccs_code; ?>" />        
<?php echo JHTML::_('form.token'); ?>
</form>
