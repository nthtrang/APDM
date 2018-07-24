<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php
$cid = JRequest::getVar('cid', array(0));
$edit = JRequest::getVar('edit', true);

JToolBarHelper::title("#".$this->po_row->po_code, 'cpanel.png');
$role = JAdministrator::RoleOnComponent(7);      
if (in_array("W", $role)) {
        JToolBarHelper::addPnsPo("Add Part", $this->po_row->pns_po_id);        
        JToolBarHelper::customX('saveqtyfk', 'save', '', 'Save', false);	
        
}
if (in_array("D", $role)) {
        JToolBarHelper::deletePns('Are you sure to delete it?',"removepnspos","Remove Part");
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
                var form = document.adminFormPo;
                if (pressbutton == 'submit') {
                        var d = document.adminForm;
                        if (d.text_search.value==""){
                                alert("Please input keyword");	
                                d.text_search.focus();
                                return false;				
                        }else{
                                submitform( pressbutton );
                        }
                }
                if (pressbutton == 'saveqtyfk') {
                        submitform( pressbutton );
                        return;
                }                      
                if(pressbutton == 'removepnspos')
                {
                     submitform( pressbutton );
                     return;
                }                
			
        }

function isCheckedPosPn(isitchecked,id){
       
	if (isitchecked == true){
		document.adminForm.boxchecked.value++;
                document.getElementById('qty_'+id).style.visibility= 'visible';
                document.getElementById('qty_'+id).style.display= 'block';
                document.getElementById('text_qty_'+id).style.visibility= 'hidden';
                document.getElementById('text_qty_'+id).style.display= 'none';        
	}
	else {
		document.adminForm.boxchecked.value--;
                document.getElementById('text_qty_'+id).style.visibility= 'visible';
                document.getElementById('text_qty_'+id).style.display= 'block';

                document.getElementById('qty_'+id).style.visibility= 'hidden';
                document.getElementById('qty_'+id).style.display= 'none';
             
                
                
	}
}        

</script>
<div class="clr"></div>
<form action="index.php?option=com_apdmpns&task=pomanagement&t=<?php echo time();?>"  onsubmit="submitbutton('')"  method="post" name="adminForm" >	
<?php if (count($this->po_pn_list) > 0) { ?>
                <table class="adminlist" cellspacing="1" width="400">
                        <thead>
                                <tr>
                                        <th width="18"><?php echo JText::_('No'); ?></th>                                               
                                        <th width="3%" class="title">
					<input type="checkbox" name="CheckAll" value="0" onClick="checkboxBom(document.adminForm.pns_po)"/>
				</th>                                        
                                        <th width="100"><?php echo JText::_('Part Number'); ?></th>
                                        <th width="100"><?php echo JText::_('Description'); ?></th>                                                
                                        <th width="100"><?php echo JText::_('Qty'); ?></th>                                                                               
                                </tr>
                        </thead>
                        <tbody>					
        <?php
        $i = 0;
        foreach ($this->po_pn_list as $row) {
                $i++;
                                if($row->pns_cpn==1)
                                        $link 	= 'index.php?option=com_apdmpns&amp;task=detailmpn&cid[0]='.$row->pns_id;	
                                else
                                        $link 	= 'index.php?option=com_apdmpns&amp;task=detail&cid[0]='.$row->pns_id;					
                                $image = PNsController::GetImagePreview($row->pns_id);
				if ($image !=''){					
                                        $pns_image = "<img border=&quot;1&quot; src='".$path_image.$image."' name='imagelib' alt='".JText::_( 'No preview available' )."' width='100' height='100' />";
				}else{
					$pns_image = JText::_('None image for preview');
				}                
                ?>
                                        <tr>
                                                <td><?php echo $i; ?></td>         
                                                <td>					
                                                <input type="checkbox" id = "pns_po" onclick="isCheckedPosPn(this.checked,'<?php echo $row->id;?>');" value="<?php echo $row->id;?>" name="cid[]"  />
                                                </td>                                                
                                                <td><span class="editlinktip hasTip" title="<?php echo $pns_image;?>" >
					<a href="<?php echo $link;?>" title="<?php echo JText::_('Click to see detail PNs');?>"><?php echo $row->parent_pns_code;?></a>
				</span></td>
                                                <td><?php echo $row->pns_description; ?></td>                                                
                                                <td>                                                    
                                                        <span style="display:block" id="text_qty_<?php echo $row->id;?>"><?php echo $row->qty;?></span>
                                                        <input style="display:none" onKeyPress="return numbersOnly(this, event);" type="text" value="<?php echo $row->qty;?>" id="qty_<?php echo $row->id;?>"  name="qty_<?php echo $row->id;?>" />                                                        
                                                </td>                                                 
                                               </tr>
                                                <?php }
                                        } 
                                        else
                                        {
                                                echo "Not found PNs"; 
                                        }
                                        ?>
                </tbody>
        </table>		

        <input type="hidden" name="po_id" value="<?php echo $this->po_row->pns_po_id; ?>" />
        <input type="hidden" name="option" value="com_apdmpns" />     
        <input type="hidden" name="id" value="<?php echo JRequest::getVar('id'); ?>" />     
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_('form.token'); ?>
</form>
