<?php defined('_JEXEC') or die('Restricted access'); ?>
request_material_wo
<?php JHTML::_('behavior.tooltip'); ?>
<?php
$cid = JRequest::getVar('cid', array(0));
$edit = JRequest::getVar('edit', true);
$me = & JFactory::getUser();
// clean item data
JFilterOutput::objectHTMLSafe($user, ENT_QUOTES, '');
$step = JRequest::getVar('step');
$wo_id = JRequest::getVar('id');
$so_id = JRequest::getVar('so_id');
$op_arr  = $this->op_arr;
$assignee = $op_arr[$step]['op_assigner'];
$allow_edit = 0;
$allow_complete=0;
if ($usertype =='Administrator' || $usertype=="Super Administrator" || $this->wo_row->wo_created_by  == $me->get('id') ) {
        $allow_edit = 1;
        $allow_complete=1;
}
JToolBarHelper::title("WO: ".$this->wo_row->wo_code, 'cpanel.png');
$role = JAdministrator::RoleOnComponent(12);
if (in_array("E", $role) && $this->wo_row->wo_state!="done" && $this->wo_row->wo_state !="onhold" && $this->wo_row->wo_state!="cancel" ) {
        JToolBarHelper::editListX("editwo","Edit WO");
        JToolBarHelper::customX("requestmaterialwo","help",'',"Request Material",false);
}
if (in_array("D", $role) && $this->wo_row->wo_state!="done" && $this->wo_row->wo_state !="onhold" && $this->wo_row->wo_state!="cancel" ) {
    JToolBarHelper::deletePns('Are you sure to delete it?',"deletewo","Delete WO");
}
JToolBarHelper::customX("printwopdf","print",'',"Print",false);


?>
<script language="javascript">
        function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		if (pressbutton == 'add') {
				submitform( pressbutton );
				return;
			}
                if (pressbutton == 'editito') {
                        submitform( pressbutton );
                        return;
                }
                if (pressbutton == 'editmpn') {
                        submitform( pressbutton );
                        return;
                }
                if (pressbutton == 'importpnito') {
                    window.location = "index.php?option=com_apdmsto&task=importpnito&id="+form.sto_id.value;           
                    return;
                }
                if (pressbutton == 'printitopdf') {
                    //window.location = "index.php?option=com_apdmpns&task=printwopdf&id="+form.wo_id.value + "&tmpl=component";
                    var url = "index.php?option=com_apdmsto&task=printitopdf&id="+form.sto_id.value + "&tmpl=component";
                    window.open(url, '_blank');
                    return;
                }
                if (pressbutton == 'saveqtyWoMaterialfk') {
                         if (document.adminForm.boxchecked.value==0){
                                alert("Please make a selection from the list to save");			
                                return false;
                         }
                         else
                             {
                                var cpn = document.getElementsByName('cid[]');
                                var len = cpn.length;         
                                
                                for (var i=0; i<len; i++)
                                {
                                        if(cpn[i].checked)
                                        {
                                            var arr_sto = cpn[i].value.split("_");
                                            var arr_qfk = arr_sto[1].split(",");
                                            arr_qfk.forEach(function(sti)
                                            {

                                                var qty_value = document.getElementById('qty_' + arr_sto[0]+'_'+sti).value;
                                    
                                                if (qty_value == 0)
                                                {
                                                //    alert("Please input QTY for PN selected");
                                                    document.getElementById('qty_' + arr_sto[0]+'_'+ sti).focus();
                                                    return;
                                                }
                                            });
                                        }
                                }
                                 submitform( pressbutton );
                             }

                        return;
                }                      
                if(pressbutton == 'removeAllPnsMaterial')
                {
                     submitform( pressbutton );
                     return;
                } 
                if(pressbutton == 'download_sto')
                {
                     submitform( pressbutton );
                     return;
                }     


    }
function numbersOnlyEspecialFloat(myfield, e, dec){
       
	 var key;
	 var keychar;
	 if (window.event)
		key = window.event.keyCode;
	 else if (e)
		key = e.which;
	 else
		return true;
	 keychar = String.fromCharCode(key);
	 // control keys

	 if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27)|| (key==46) ) return true;
	 // numbers
	 else if ((("0123456789-").indexOf(keychar) > -1))
		return true;
	 // decimal point jump
	 else if (dec && (keychar == "."))
		{
		myfield.form.elements[dec].focus();
		return false;
		}
	 else
		return false;
}
function cancelUpdate()
{
        window.parent.document.getElementById('sbox-window').close();	
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
                
                 window.addEvent('domready', function() {

                SqueezeBox.initialize({});

                $$('a.modal').each(function(el) {
                        el.addEvent('click', function(e) {
                                new Event(e).stop();
                                SqueezeBox.fromElement(el);
                        });
                });
        });
 function checkAllWoMaterialPn(n, fldName )
{
  if (!fldName) {
     fldName = 'womatepn';
  }
	var f = document.adminForm;
	var c = f.toggle.checked;
	var n2 = 0;        
	for (i=0; i < n; i++) {
		cb = eval( 'f.' + fldName + '' + i );
		if (cb) {
                        cb.click();                           
			cb.checked = c;                       
			n2++;
		}
	}
	if (c) {
		document.adminForm.boxchecked.value = n2;
	} else {
		document.adminForm.boxchecked.value = 0;
	}
}
        function isCheckedWoMaterialPn(isitchecked,id,sto){
        
       var arr_wopn = sto.split(",");
	if (isitchecked == true){
		document.adminForm.boxchecked.value++;
                arr_wopn.forEach(function(sti) {
                document.getElementById('qty_'+id+'_'+sti).style.visibility= 'visible';
                document.getElementById('qty_'+id+'_'+sti).style.display= 'block';
                document.getElementById('text_qty_'+id+'_'+sti).style.visibility= 'hidden';
                document.getElementById('text_qty_'+id+'_'+sti).style.display= 'none';    
                
                   
                });
	}
	else {
		document.adminForm.boxchecked.value--;
                 arr_wopn.forEach(function(sti) {
                document.getElementById('text_qty_'+id+'_'+sti).style.visibility= 'visible';
                document.getElementById('text_qty_'+id+'_'+sti).style.display= 'block';

               
                

                document.getElementById('qty_'+id+'_'+sti).style.visibility= 'hidden';
                document.getElementById('qty_'+id+'_'+sti).style.display= 'none';
                
               
                
             });
                
                
	}
}        
</script>
<form action="index.php"  onsubmit="submitbutton('')"  method="post" name="adminForm" >	
        <fieldset class="adminform">

                <div class="col width-100">
                        <fieldset class="adminform">	
                                <div name="notice" style="color:#D30000" id ="notice"></div>
                                <table class="admintable" cellspacing="1" width="100%">
                                        <tr>
                                                <td colspan="4" align="center"><strong style="font-size:18px;border-color:inherit;" >MATERIAL REQUEST</strong></td>
                                                
                                        </tr>
                                          <tr>
                                                <td colspan="4" align="center"><strong><?php
                                        // echo $generator->getBarcode($this->wo_row->wo_code,$generator::TYPE_CODE_128,3,50);
                                        //TYPE_EAN_13
                                        //TYPE_CODE_128
                                        $img			=	code128BarCode($this->wo_row->wo_code, 1);

                                        //Start output buffer to capture the image
                                        //Output PNG image

                                        ob_start();
                                        imagepng($img);

                                        //Get the image from the output buffer

                                        $output_img		=	ob_get_clean();
                                        echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '" /><br>'.$this->wo_row->wo_code;
                                        ?></strong></td>
                                                
                                        </tr>
                                        <tr>                                                                                         
                                                <td class="key"><strong>Created By:</strong></td><td colspan="4">   
                                                <?php echo ($assignee!=0)?GetValueUser($assignee, "name"):"N/A"; ?>
                                                </td>
                                        </tr>
                                         
                                       
                                        <tr>
                                                <td colspan="4"><strong>Reason:</strong></td>
                                                
                                        </tr>
                                        <tr>
                                                <td colspan="4">
<!--                                                        <textarea name="op_comment" rows="10" cols="70"><?php echo $op_arr[$step]['op_comment']?></textarea>-->
                                                            <?php                                     
                                                $editor =& JFactory::getEditor();                                                
                                                     echo $editor->display('op_comment', "", '2%', '2', '2', '1',false);
                                        ?>
                                                </td>
                                               
                                        </tr>                                                                                                                 
                                </table>                                
                        </fieldset>
                        <fieldset>
                 <table class="admintable" cellspacing="1" width="100%">
                                        <tr>
                                                <td align="left"><strong style="font-size:18px;border-color:inherit;" >Requested Parts</strong></td>
                                                
                                        </tr></table>
            <div class="toolbar">
            <table class="toolbar"><tbody><tr>
<?php  
    if (in_array("W", $role) && $this->wo_row->wo_state!="done" && $this->wo_row->wo_state !="onhold" && $this->wo_row->wo_state!="cancel" ) {
        ?>  
    <td class="button" id="toolbar-save">
            <a href="#"
               onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Please make a selection from the list to save part');}else{ hideMainMenu(); submitbutton('saveqtyWoMaterialfk')}"
               class="toolbar">
<span class="icon-32-save" title="Save">
</span>
                Save
            </a>
        </td>
        <td class="button" id="toolbar-popup-Popup">
            <a class="modal"
               href="index.php?option=com_apdmpns&amp;task=get_list_pns_material&amp;tmpl=component&amp;wo_id=<?php echo $this->wo_row->pns_wo_id; ?>"
               rel="{handler: 'iframe', size: {x: 850, y: 500}}">
<span class="icon-32-new" title="Add Part">
</span>
                Add Part
            </a>
        </td>        
        <?php
    }    
    if (in_array("D", $role) && $this->wo_row->wo_state!="done" && $this->wo_row->wo_state !="onhold" && $this->wo_row->wo_state!="cancel" ) {
        ?>
        <td class="button" id="toolbar-Are you sure to delete it\?">
            <a href="#"
               onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Please make a selection from the list to delete');}else{if(confirm('Are you sure to delete it?')){submitbutton('removeAllPnsMaterial');}}"
               class="toolbar">
<span class="icon-32-delete" title="Remove Part">
</span>
                Remove
            </a>
        </td>
    <?php }
                    ?>
                </tr></tbody></table></div>
                <?php if (count($this->material_pn_list) > 0) { ?>
                <table class="adminlist" cellspacing="1" width="400">
                        <thead>
                                <tr>
                                        <th width="2%"><?php echo JText::_('NUM'); ?></th>
                                        <th width="3%" class="title"><input type="checkbox" name="toggle" value="" onclick="checkAllWoMaterialPn(<?php echo count($this->material_pn_list); ?>);" /></th>
                                        <th width="100"><?php echo JText::_('Level'); ?></th>
                                        <th width="100"><?php echo JText::_('Part Number'); ?></th>
                                        <th width="300"><?php echo JText::_('Description'); ?></th>
                                        <th width="100"><?php echo JText::_('Find Number'); ?></th>  
                                        <th width="100"><?php echo JText::_('Ref des'); ?></th>  
                                        <th width="100"><?php echo JText::_('Qty'); ?></th>  
                                        <th width="100"><?php echo JText::_('UOM'); ?></th>  
                                        <th width="100"><?php echo JText::_('MFR Name'); ?></th>  
                                        <th width="100"><?php echo JText::_('MFR PN'); ?></th>                                                                                  
                                </tr>
                        </thead>
                        <tbody>					
        <?php                
        $i = 0;
        foreach ($this->material_pn_list as $row) {
                
                                if($row->pns_cpn==1)
                                        $link 	= 'index.php?option=com_apdmpns&amp;task=detailmpn&cid[0]='.$row->pns_id;	
                                else
                                        $link 	= 'index.php?option=com_apdmpns&amp;task=detail&cid[0]='.$row->pns_id;
                                $linkStoTab 	= 'index.php?option=com_apdmpns&task=sto&cid[]='.$row->pns_id;
                                $image = PNsController::GetImagePreview($row->pns_id);
				if ($image !=''){					
                                        $pns_image = "<img border=&quot;1&quot; src='".$path_image.$image."' name='imagelib' alt='".JText::_( 'No preview available' )."' width='100' height='100' />";
				}else{
					$pns_image = JText::_('None image for preview');
				}                
                                 $stoList = PNsController::GetWoFkFrommPns($row->pns_id,$wo_id);
                                 if($row->pns_revision)
                                        $pns_code = $row->ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision;
                                else
                                        $pns_code = $row->ccs_code.'-'.$row->pns_code;
                                 
                               
                                ?>
                                        <tr>
                                                <td align="center"><?php echo $i+1; ?></td>
                                                <td align="center">
                                                <input type="checkbox" id = "womatepn<?php echo $i?>"  onclick="isCheckedWoMaterialPn(this.checked,'<?php echo $row->pns_id;?>','<?php echo implode(",",$stoList);?>');" value="<?php echo $row->pns_id;?>_<?php echo implode(",",$stoList);?>" name="cid[]"  />
                                                </td>       
                                                  <td align="center">1</td>
                                                <td align="left"><span class="editlinktip hasTip" title="<?php echo $pns_image;?>" >
					<a href="<?php echo $link;?>" title="<?php echo JText::_('Click to see detail PNs');?>"><?php echo $pns_code;?></a>
				</span></td>
                                                <td align="left"><?php echo $row->pns_description; ?></td>
                                                <td align="center"><?php echo $row->pns_find_number; ?></td>
                                                <td align="center"><?php echo $row->pns_ref_des; ?></td>
                                                
                                                <td align="center" width="74px">
                                                        <span style="display:block" id="text_qty_<?php echo $row->pns_id;?>_<?php echo $row->id;?>"><?php echo $row->qty;?></span>
                                                        <input style="display:none;width: 70px" onKeyPress="return numbersOnlyEspecialFloat(this, event);" type="text" value="<?php echo $row->qty;?>" id="qty_<?php echo $row->pns_id;?>_<?php echo $row->id;?>"  name="qty_<?php echo $row->pns_id;?>_<?php echo $row->id;?>" />                                                        
                                                </td> 
                                                 <td align="center"><?php echo $row->pns_uom; ?></td>
                                                <td align="left">
                                                    <table>
                                                        <?php
                                                        $mf = GetManufacture($row->pns_id,4);
                                                        if (count($mf) > 0) {
                                                            $imf=1;
                                                            foreach ($mf as $m) {
                                                                $style="style='border-bottom:1px solid #eee;'";
                                                                if($imf==count($mf))
                                                                    $style ="style='border-bottom:none'";
                                                                echo "<tr><td ".$style.">".$m['mf'] . '</tr></td>';
                                                                $imf++;
                                                            }
                                                        }
                                                        ?> </table>
                                                                </td>	
                                                                <td align="left">
                                                                    <table>
                                                                        <?php
                                                                        $mf = GetManufacture($row->pns_id,4);
                                                                        if (count($mf) > 0) {
                                                                            $imf1=1;
                                                                            foreach ($mf as $m) {
                                                                                $style="style='border-bottom:1px solid #eee;'";
                                                                                if($imf1==count($mf))
                                                                                    $style ="style='border-bottom:none'";
                                                                                echo "<tr><td ".$style.">".$m['v_mf'] . '</tr></td>';
                                                                                $imf1++;
                                                                            }
                                                                        }
                                                                        ?> </table>
                                                                </td>         
                                        </tr>
                                                <?php 
                                                $i++;
                                                }
                                        } 
                                        else
                                        {
                                                echo "Not found PNs"; 
                                        }
                                        ?>
                </tbody>
        </table>		

        </fieldset>
                </div>	
        </fieldset>
        <input type="hidden" name="wo_id" value="<?php echo $wo_id; ?>" />
        <input type="hidden" name="so_id" value="<?php echo $so_id; ?>" />
        <input type="hidden" name="wo_step" value="<?php echo $step; ?>" />
        <input type="hidden" name="wo_assigner" value="<?php echo $assignee; ?>" />
        <input type="hidden" name="option" value="com_apdmpns" />             
        <input type="hidden" name="task" value="" />	
        <input type="hidden" name="return" value="wo_detail"  />
        <input type="hidden" name="boxchecked" value="0" />
                                        <?php echo JHTML::_('form.token'); ?>
</form>
