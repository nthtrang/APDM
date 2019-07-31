<?php defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip'); 
JHTML::_('behavior.modal'); 

$edit		= JRequest::getVar('edit',true);	
$quo_id = JRequest::getVar('id');
$role = JAdministrator::RoleOnComponent(8);	
JToolBarHelper::title($this->quo_row->quo_code .' '. $this->quo_row->quo_revision .': <small><small>[ view ]</small></small>' , 'generic.png' );

if (in_array("E", $role) && $this->quo_row->quo_state !="Released" && $this->quo_row->quo_state !="Inreview") {
        JToolBarHelper::customX("editquo",'edit',"Edit","Edit",false);
}
JToolBarHelper::cancel( 'cancel', 'Close' );
JToolBarHelper::customX("printitopdf","print",'',"Print",false);

if (in_array("D", $role) && $this->quo_row->quo_state !="Released" && $this->quo_row->quo_state !="Inreview") {
    JToolBarHelper::customXDel( 'Are you sure to delete it?', 'deletequo', 'delete', 'Delete QUO');
}
$cparams = JComponentHelper::getParams ('com_media');
// clean item data
JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

?>
<script language="javascript" type="text/javascript">
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
                if (pressbutton == 'editquo') {
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
                if (pressbutton == 'saveqtyQuofk') {
                         if (document.adminForm.boxchecked.value==0){
                                alert("Please make a selection from the list to save part");
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
                                                    return false;
                                                }
                                            });
                                        }
                                }
                                 submitform( pressbutton );
                             }

                        return;
                }                      
                if(pressbutton == 'removeAllpnsquos')
                {
                     submitform( pressbutton );
                     return;
                } 
                if(pressbutton == 'download_sto')
                {
                     submitform( pressbutton );
                     return;
                }     
                
                 if (pressbutton == 'deletequo') {
                        submitform( pressbutton );
                        return;
                }  

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
        
function isCheckedQuoPn(isitchecked,id,quo){
        
       var arr_sto = quo.split(",");
	if (isitchecked == true){
		document.adminForm.boxchecked.value++;
                arr_sto.forEach(function(sti) {
                document.getElementById('qty_'+id+'_'+sti).style.visibility= 'visible';
                document.getElementById('qty_'+id+'_'+sti).style.display= 'block';
                document.getElementById('text_qty_'+id+'_'+sti).style.visibility= 'hidden';
                document.getElementById('text_qty_'+id+'_'+sti).style.display= 'none';    
                
                document.getElementById('price_'+id+'_'+sti).style.visibility= 'visible';
                document.getElementById('price_'+id+'_'+sti).style.display= 'block';
                document.getElementById('text_price_'+id+'_'+sti).style.visibility= 'hidden';
                document.getElementById('text_price_'+id+'_'+sti).style.display= 'none';
                
                document.getElementById('extend_'+id+'_'+sti).style.visibility= 'visible';
                document.getElementById('extend_'+id+'_'+sti).style.display= 'block';
                document.getElementById('text_extend_'+id+'_'+sti).style.visibility= 'hidden';
                document.getElementById('text_extend_'+id+'_'+sti).style.display= 'none';
                
                document.getElementById('span_duedate_'+id+'_'+sti).style.visibility= 'visible';
                document.getElementById('span_duedate_'+id+'_'+sti).style.display= 'block';
                document.getElementById('text_duedate_'+id+'_'+sti).style.visibility= 'hidden';
                document.getElementById('text_duedate_'+id+'_'+sti).style.display= 'none';
                });
	}
	else {
		document.adminForm.boxchecked.value--;
                 arr_sto.forEach(function(sti) {
                document.getElementById('text_qty_'+id+'_'+sti).style.visibility= 'visible';
                document.getElementById('text_qty_'+id+'_'+sti).style.display= 'block';

                document.getElementById('text_price_'+id+'_'+sti).style.visibility= 'visible';
                document.getElementById('text_price_'+id+'_'+sti).style.display= 'block';

                document.getElementById('text_extend_'+id+'_'+sti).style.visibility= 'visible';
                document.getElementById('text_extend_'+id+'_'+sti).style.display= 'block';

                document.getElementById('text_duedate_'+id+'_'+sti).style.visibility= 'visible';
                document.getElementById('text_duedate_'+id+'_'+sti).style.display= 'block';

                document.getElementById('qty_'+id+'_'+sti).style.visibility= 'hidden';
                document.getElementById('qty_'+id+'_'+sti).style.display= 'none';
                
                document.getElementById('price_'+id+'_'+sti).style.visibility= 'hidden';
                document.getElementById('price_'+id+'_'+sti).style.display= 'none';
                document.getElementById('extend_'+id+'_'+sti).style.visibility= 'hidden';
                document.getElementById('extend_'+id+'_'+sti).style.display= 'none';
                
                document.getElementById('span_duedate_'+id+'_'+sti).style.visibility= 'hidden';
                document.getElementById('span_duedate_'+id+'_'+sti).style.display= 'none';
             });
                
                
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
function getLocationPartState(pnsId,fkId,currentLoc,partState)
{	
        var url = 'index.php?option=com_apdmsto&task=ajax_getlocpn_partstate&partstate='+partState+'&pnsid='+pnsId+'&fkid='+fkId+'&currentloc='+currentLoc;
        var MyAjax = new Ajax(url, {
                method:'get',
                onComplete:function(result){
//                       /alert(result.trim());
                       document.getElementById('ajax_location_'+pnsId+'_'+fkId).innerHTML = result.trim();        
                        //$('#ajax_location_'+pnsId+'_'+fkId).value = result.trim();                                
                }
        }).request();
        
}
function checkAllQuoPn(n, fldName )
{
  if (!fldName) {
     fldName = 'quopn';
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
function autoAddPartItobk(pns,sto_id)
{
        var url = 'index.php?option=com_apdmsto&task=ajax_addpn_ito&sto_id='+sto_id+'&pns_code='+pns;
        var MyAjax = new Ajax(url, {
                method:'get',
                onComplete:function(result){
                      window.location.reload();                                    
                }
        }).request();        
}
function autoAddPartIto(pns,sto_id){
        window.location = "index.php?option=com_apdmsto&task=ajax_addpn_ito&sto_id="+sto_id+"&pns_code="+pns+"&time=<?php echo time();?>";
}
function checkforscanito(isitchecked)
{
        if (isitchecked == true){
                document.getElementById("pns_code").focus();
                document.getElementById('pns_code').setAttribute("onkeyup", "autoAddPartIto(this.value,'<?php echo $this->quo_row->quotation_id; ?>')");
            checkedforMarkScan(1);
        }
        else {
                document.getElementById('pns_code').setAttribute("onkeyup", "return false;");
            checkedforMarkScan(0);
        }
}

function checkedforMarkScan(ischecked)
{
    var url = 'index.php?option=com_apdmsto&task=ajax_markscan_itochecked&itoscan='+ischecked;
    var MyAjax = new Ajax(url, {
        method:'get',
        onComplete:function(result){
            var eco_result = result;

        }
    }).request();
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
			<li><a id="detail" class="active"><?php echo JText::_( 'Detail' ); ?></a></li>
			<li><a id="bom" href="index.php?option=com_apdmquo&task=quo_rev&id=<?php echo $this->quo_row->quotation_id;?>"><?php echo JText::_( 'Rev' ); ?></a></li>
                        <li><a id="bom" href="index.php?option=com_apdmquo&task=routes_quo&cid[]=<?php echo $this->quo_row->quotation_id;?>&time=<?php echo time();?>"><?php echo JText::_( 'Routes' ); ?></a></li>
                        
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

<form action="index.php"  onsubmit="submitbutton('')"  method="post" name="adminForm" >	
        <fieldset>
		<legend><?php echo JText::_( 'Quotation Detail' ); ?></legend>        
        <table class="admintable" cellspacing="1"  width="70%">
                              <tr>
                                        <td class="key" width="28%"><?php echo JText::_('Created Date'); ?></td>                                               
                                        <td width="30%" class="title"><?php echo JHTML::_('date', $this->quo_row->quo_created, JText::_('DATE_FORMAT_LC5')); ?></td>                                        
                                        <td class="key" width="18%"><?php echo JText::_('Quotation State'); ?></td>                                               
                                        <td width="30%" class="title"><?php echo $this->quo_row->quo_state;?></td>
				                                                                              
                                </tr>
                                <tr>
                                        <td  class="key" width="28%"><?php echo JText::_('Created By'); ?></td>
                                        <td width="30%" class="title">  <?php echo ($this->quo_row->quo_created_by)?GetValueUser($this->quo_row->quo_created_by, "name"):""; ?></td>                             
									   <td  class="key" width="28%"><?php echo JText::_('Released Date'); ?></td>
									   <td width="30%" class="title"><?php echo $this->quo_row->quo_expire_date?JHTML::_('date', $this->quo_row->quo_expire_date, JText::_('DATE_FORMAT_LC5')):""; ?></td>
                                </tr>  
                               
                                <tr>
                                        <td class="key"  width="28%"><?php echo JText::_('Modified Date'); ?></td>                                               
                                        <td width="30%" class="title">  <?php echo ($this->quo_row->quo_updated)?JHTML::_('date', $this->quo_row->quo_updated, JText::_('DATE_FORMAT_LC5')):""; ?></td>  
										<td  class="key" width="28%"><?php echo JText::_('SO Linked'); ?></td>
									   <td width="30%" class="title">                                                   
                                                                           </td>
				                                                                              
                                </tr>                                
                                <tr>
                                        <td  class="key" width="28%"><?php echo JText::_('Modified By'); ?></td>                                               
                                        <td width="30%" class="title">  <?php echo ($this->quo_row->quo_updated_by)?GetValueUser($this->quo_row->quo_updated_by, "name"):""; ?></td>
					<td  class="key" width="28%"></td>                                                                                       
                                         <td width="30%" class="title"> 
                                        </td>  
				                                                                              
                                </tr> 
                             
        </table>                
        </fieldset>

        <fieldset>
                <legend>Part List </legend>
            <div class="toolbar">
            <table class="toolbar"><tbody><tr>
<?php
if($this->quo_row->sto_owner_confirm==0 && !$this->quo_row->sto_owner) {
    if (in_array("W", $role) && (($this->quo_row->quo_state !="Released" && $this->quo_row->quo_state !="Inreview"))) {
        ?>
                                    <td class="button" id="toolbar-addpnsave">           
                
        </td>
        <td class="button" id="toolbar-save">
            <a href="#"
               onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Please make a selection from the list to save receiving part');}else{ hideMainMenu(); submitbutton('saveqtyQuofk')}"
               class="toolbar">
<span class="icon-32-save" title="Save Part">
</span>
                Save Part
            </a>
        </td>
        <td class="button" id="toolbar-popup-Popup">
            <a class="modal"
               href="index.php?option=com_apdmquo&amp;task=get_list_pns_quo_detail&amp;tmpl=component&amp;quo_id=<?php echo $this->quo_row->quotation_id; ?>"
               rel="{handler: 'iframe', size: {x: 850, y: 500}}">
<span class="icon-32-new" title="Add Part">
</span>
                Add Part
            </a>
        </td>
        <?php
    }
    if (in_array("D", $role) && ($this->quo_row->quo_state !="Released" && $this->quo_row->quo_state !="Inreview")) {

        ?>
        <td class="button" id="toolbar-Are you sure to delete it?">
            <a href="#"
               onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Please make a selection from the list to delete');}else{if(confirm('Are you sure to delete it?')){submitbutton('removeAllpnsquos');}}"
               class="toolbar">
<span class="icon-32-delete" title="Remove Part">
</span>
                Remove Part
            </a>
        </td>
    <?php }
}
                    ?>

                </tr></tbody></table></div>
                <?php if (count($this->quo_pn_list) > 0) { ?>
                <table class="adminlist" cellspacing="1" width="400">
                        <thead>
                                <tr>
                                        <th width="2%"><?php echo JText::_('NUM'); ?></th>
                                        <th width="3%" class="title"><input type="checkbox" name="toggle" value="" onclick="checkAllQuoPn(<?php echo count($this->quo_pn_list); ?>);" /></th>
                                        <th width="100"><?php echo JText::_('Part Number'); ?></th>
                                        <th width="100"><?php echo JText::_('Rev'); ?></th>
                                        <th width="300"><?php echo JText::_('Description'); ?></th>
                                        <th width="100"><?php echo JText::_('Qty'); ?></th>
                                        <th width="100"><?php echo JText::_('UOM'); ?></th>  
                                        <th width="100"><?php echo JText::_('Unit Price'); ?></th>
                                        <th width="100"><?php echo JText::_('Extended'); ?></th>
                                        <th width="100"><?php echo JText::_('Due Date'); ?></th>
                                        <th width="100"><?php //echo JText::_('Action'); ?></th>  
                                </tr>
                        </thead>
                        <tbody>					
        <?php


        $i = 0;
        foreach ($this->quo_pn_list as $row) {
                                if($row->pns_cpn==1) {
                                    $link = 'index.php?option=com_apdmpns&amp;task=detailmpn&cid[0]=' . $row->pns_id;
                                }else{
                                        $link 	= 'index.php?option=com_apdmpns&amp;task=detail&cid[0]='.$row->pns_id;
                                }
                                $quoList = QUOController::GetQuoFrommPns($row->pns_id,$quo_id);
                                ?>
                                        <tr>
                                                <td align="center"><?php echo $i+1; ?></td>
                                                <td align="center">
                                                <input type="checkbox" id = "quopn<?php echo $i?>"  onclick="isCheckedQuoPn(this.checked,'<?php echo $row->pns_id;?>','<?php echo implode(",",$quoList);?>');" value="<?php echo $row->pns_id;?>_<?php echo implode(",",$quoList);?>" name="cid[]"  />
                                                </td>                                                
                                                <td align="left"><?php echo $row->pns_code;?></td>
                                                <td align="left"><?php echo $row->pns_revision;?></td>
                                                <td align="left"><?php echo $row->pns_description; ?></td>
                                                <td align="center" width="74px">
                                                    <span style="display:block" id="text_qty_<?php echo $row->pns_id;?>_<?php echo $row->id;?>"><?php echo $row->qty;?></span>
                                                    <input style="display:none;width: 76px" onKeyPress="return numbersOnlyEspecialFloat(this, event);" type="text" value="<?php echo $row->qty;?>" id="qty_<?php echo $row->pns_id;?>_<?php echo $row->id;?>"  name="qty_<?php echo $row->pns_id;?>_<?php echo $row->id;?>" />
                                                </td>
                                            <td align="center"><?php echo $row->pns_uom; ?></td>
                                            <td align="center" width="74px">
                                                <span style="display:block" id="text_price_<?php echo $row->pns_id;?>_<?php echo $row->id;?>"><?php echo $row->unit_price;?></span>
                                                <input style="display:none;width: 76px" onKeyPress="return numbersOnlyEspecialFloat(this, event);" type="text" value="<?php echo $row->qty;?>" id="price_<?php echo $row->pns_id;?>_<?php echo $row->id;?>"  name="price_<?php echo $row->pns_id;?>_<?php echo $row->id;?>" />
                                            </td>
                                            <td align="center" width="74px">
                                                <span style="display:block" id="text_extend_<?php echo $row->pns_id;?>_<?php echo $row->id;?>"><?php echo $row->extend_price;?></span>
                                                <input style="display:none;width: 76px" onKeyPress="return numbersOnlyEspecialFloat(this, event);" type="text" value="<?php echo $row->qty;?>" id="extend_<?php echo $row->pns_id;?>_<?php echo $row->id;?>"  name="extend_<?php echo $row->pns_id;?>_<?php echo $row->id;?>" />
                                            </td>
                                            <td align="center" width="74px">
                                                <span style="display:block" id="text_duedate_<?php echo $row->pns_id;?>_<?php echo $row->id;?>"><?php echo $row->quo_pn_due_date?JHTML::_('date', $row->quo_pn_due_date, JText::_('DATE_FORMAT_LC5')):""; ?></span>
                                                <span style="display:none;width: 76px" id="span_duedate_<?php echo $row->pns_id;?>_<?php echo $row->id;?>">
                                                <?php echo JHTML::_('calendar',$row->quo_pn_due_date, 'duedate_'.$row->pns_id.'_'. $row->id, 'duedate_'.$row->pns_id.'_'. $row->id, '%m/%d/%Y', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>
                                                    </span>
                                            </td>
                                                <td align="center" width="75px">
                                                        <a href="index.php?option=com_apdmquo&task=removepnsquos&cid[]=<?php echo $row->id;?>&quo_id=<?php echo $quo_id;?>" title="<?php echo JText::_('Click to see detail PNs');?>">Remove</a>
                                                        <?php
                                                        ?>
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
        <input type="hidden" name="quo_id" value="<?php echo $this->quo_row->quotation_id; ?>" />
        <input type="hidden" name="option" value="com_apdmquo" />
        <input type="hidden" name="id" value="<?php echo JRequest::getVar('id'); ?>" />     
	<input type="hidden" name="task" value="" />
    <input type="hidden" name="return" value="quo_detail" />
        <input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_('form.token'); ?>
</form>

