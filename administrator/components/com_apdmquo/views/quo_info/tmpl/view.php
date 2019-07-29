<?php defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip'); 
JHTML::_('behavior.modal'); 

$cid = JRequest::getVar( 'cid', array(0) );
$edit		= JRequest::getVar('edit',true);	
$sto_id = JRequest::getVar('id');
$role = JAdministrator::RoleOnComponent(8);	
JToolBarHelper::title($this->quo_row->quo_code .' '. $this->quo_row->quo_revision .': <small><small>[ view ]</small></small>' , 'generic.png' );

if (in_array("E", $role)&& ($this->quo_row->sto_state  != "Done")) {
        JToolBarHelper::customX("editito",'edit',"Edit","Edit",false);
}
JToolBarHelper::cancel( 'cancel', 'Close' );
JToolBarHelper::customX("printitopdf","print",'',"Print",false);

if (in_array("D", $role) && $this->quo_row->sto_state !="Done") {
    JToolBarHelper::customXDel( 'Are you sure to delete it?', 'deletesto', 'delete', 'Delete ETO');
}
$cparams = JComponentHelper::getParams ('com_media');
// clean item data
JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

?>detail
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
                if (pressbutton == 'saveqtyStofk') {
                         if (document.adminForm.boxchecked.value==0){
                                alert("Please make a selection from the list to save receiving part");			
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
                if(pressbutton == 'removeAllpnsstos')
                {
                     submitform( pressbutton );
                     return;
                } 
                if(pressbutton == 'download_sto')
                {
                     submitform( pressbutton );
                     return;
                }     
                if (pressbutton == 'save_doc_sto') {
                        submitform( pressbutton );
                        return;
                }  
                 if (pressbutton == 'deletesto') {
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
        
function isCheckedPosPn(isitchecked,id,sto){
        
       var arr_sto = sto.split(",");
	if (isitchecked == true){
		document.adminForm.boxchecked.value++;
                arr_sto.forEach(function(sti) {
                document.getElementById('qty_'+id+'_'+sti).style.visibility= 'visible';
                document.getElementById('qty_'+id+'_'+sti).style.display= 'block';
                document.getElementById('text_qty_'+id+'_'+sti).style.visibility= 'hidden';
                document.getElementById('text_qty_'+id+'_'+sti).style.display= 'none';    
                
                document.getElementById('location_'+id+'_'+sti).style.visibility= 'visible';
                document.getElementById('location_'+id+'_'+sti).style.display= 'block';
                document.getElementById('text_location_'+id+'_'+sti).style.visibility= 'hidden';
                document.getElementById('text_location_'+id+'_'+sti).style.display= 'none';    
                
                document.getElementById('partstate_'+id+'_'+sti).style.visibility= 'visible';
                document.getElementById('partstate_'+id+'_'+sti).style.display= 'block';
                document.getElementById('text_partstate_'+id+'_'+sti).style.visibility= 'hidden';
                document.getElementById('text_partstate_'+id+'_'+sti).style.display= 'none';         
                
                document.getElementById('mfg_pn_'+id+'_'+sti).style.visibility= 'visible';
                document.getElementById('mfg_pn_'+id+'_'+sti).style.display= 'block';
                document.getElementById('text_mfg_pn_'+id+'_'+sti).style.visibility= 'hidden';
                document.getElementById('text_mfg_pn_'+id+'_'+sti).style.display= 'none';                                     
                });
	}
	else {
		document.adminForm.boxchecked.value--;
                 arr_sto.forEach(function(sti) {
                document.getElementById('text_qty_'+id+'_'+sti).style.visibility= 'visible';
                document.getElementById('text_qty_'+id+'_'+sti).style.display= 'block';

                document.getElementById('text_location_'+id+'_'+sti).style.visibility= 'visible';
                document.getElementById('text_location_'+id+'_'+sti).style.display= 'block';

                document.getElementById('text_partstate_'+id+'_'+sti).style.visibility= 'visible';
                document.getElementById('text_partstate_'+id+'_'+sti).style.display= 'block';

                document.getElementById('text_mfg_pn_'+id+'_'+sti).style.visibility= 'visible';
                document.getElementById('text_mfg_pn_'+id+'_'+sti).style.display= 'block';

                document.getElementById('qty_'+id+'_'+sti).style.visibility= 'hidden';
                document.getElementById('qty_'+id+'_'+sti).style.display= 'none';
                
                document.getElementById('location_'+id+'_'+sti).style.visibility= 'hidden';
                document.getElementById('location_'+id+'_'+sti).style.display= 'none';
                document.getElementById('partstate_'+id+'_'+sti).style.visibility= 'hidden';
                document.getElementById('partstate_'+id+'_'+sti).style.display= 'none';      
                
                document.getElementById('mfg_pn_'+id+'_'+sti).style.visibility= 'hidden';
                document.getElementById('mfg_pn_'+id+'_'+sti).style.display= 'none';      
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
function checkAllItoPn(n, fldName )
{
  if (!fldName) {
     fldName = 'itopn';
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
                document.getElementById('pns_code').setAttribute("onkeyup", "autoAddPartIto(this.value,'<?php echo $this->quo_row->pns_sto_id; ?>')");
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
			<li><a id="detail" class="active"><?php echo JText::_( 'DETAIL' ); ?></a></li>
			<li><a id="bom" href="index.php?option=com_apdmsto&task=ito_detail_pns&id=<?php echo $this->quo_row->pns_sto_id;?>"><?php echo JText::_( 'Rev' ); ?></a></li>
                        
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
                <legend>Receiving Part</legend>
            <div class="toolbar">
            <table class="toolbar"><tbody><tr>
<?php
if($this->quo_row->sto_owner_confirm==0 && !$this->quo_row->sto_owner) {
    if (in_array("W", $role) && ($this->quo_row->sto_state != "Done")) {
            $session = JFactory::getSession();
        if($session->get('is_scanito')){
            $itoscanchecked = 'checked="checked"';
            $itoonkeyUp = "onkeyup=\"autoAddPartIto(this.value,'".$this->quo_row->pns_sto_id."')\" autofocus";
        }
        else
        {
            $itoscanchecked = "";
            $itoonkeyUp = "";
        }
        ?>
                                    <td class="button" id="toolbar-addpnsave">           
                Scan PN Barcode <input <?php echo $itoonkeyUp?> onchange="autoAddPartIto(this.value,'<?php echo $this->quo_row->pns_sto_id; ?>')" onkeyup="autoAddPartIto(this.value,'<?php echo $this->quo_row->pns_sto_id; ?>')" type="text"  name="pns_code" id="pns_code" value="" >
                 <input <?php echo $itoscanchecked?> type="checkbox" name="check_scan_barcode" value="1" onclick="checkforscanito(this.checked)" />
        </td>
        <td class="button" id="toolbar-save">
            <a href="#"
               onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Please make a selection from the list to save receiving part');}else{ hideMainMenu(); submitbutton('saveqtyStofk')}"
               class="toolbar">
<span class="icon-32-save" title="Save Receiving Part">
</span>
                Save Receiving Part
            </a>
        </td>

        <td class="button" id="toolbar-popup-Popup">
            <a class="modal"
               href="index.php?option=com_apdmpns&amp;task=get_list_pns_sto&amp;tmpl=component&amp;sto_id=<?php echo $this->quo_row->pns_sto_id; ?>"
               rel="{handler: 'iframe', size: {x: 850, y: 500}}">
<span class="icon-32-new" title="Add Part">
</span>
                Add Part
            </a>
        </td>
        <td class="button" id="toolbar-upload">
<a href="#" onclick="javascript:hideMainMenu(); submitbutton('importpnito')" class="toolbar">
<span class="icon-32-upload" title="Import Part">
</span>
Import Part
</a>
</td>
        <?php
    }
    if (in_array("D", $role) && ($this->quo_row->sto_state != "Done")) {
        ?>
        <td class="button" id="toolbar-Are you sure to delete it?">
            <a href="#"
               onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Please make a selection from the list to delete');}else{if(confirm('Are you sure to delete it?')){submitbutton('removeAllpnsstos');}}"
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
                <?php if (count($this->sto_pn_list) > 0) { ?>
                <table class="adminlist" cellspacing="1" width="400">
                        <thead>
                                <tr>
                                        <th width="2%"><?php echo JText::_('NUM'); ?></th>
                                        <th width="3%" class="title"><input type="checkbox" name="toggle" value="" onclick="checkAllItoPn(<?php echo count($this->sto_pn_list); ?>);" /></th>
                                        <th width="100"><?php echo JText::_('Part Number'); ?></th>
                                        <th width="300"><?php echo JText::_('Description'); ?></th>
                                        <th width="100"><?php echo JText::_('UOM'); ?></th>  
                                        <th width="100"><?php echo JText::_('Manufacture PN'); ?></th>  
                                        <th width="100"><?php echo ($this->quo_row->sto_type==1)?JText::_('Qty In'):JText::_('Qty Out'); ?></th>
                                        <th width="100"><?php echo JText::_('Location'); ?></th>                                                
                                        <th width="100"><?php echo JText::_('Part State'); ?></th>  
                                        <th width="100"><?php //echo JText::_('Action'); ?></th>  
                                </tr>
                        </thead>
                        <tbody>					
        <?php
        
        $locationArr = array();
        $location = SToController::GetLocationCodeList();
        foreach($location as $rowcode)
        {
              $locationArr[] = JHTML::_('select.option',$rowcode->pns_location_id ,$rowcode->location_code, 'value', 'text');   
        }
        $partStateArr   = array();
        $partStateArr[] = JHTML::_('select.option', 'OH-G', "OH-G" , 'value', 'text'); 
        $partStateArr[] = JHTML::_('select.option', 'OH-D', "OH-D" , 'value', 'text'); 
        $partStateArr[] = JHTML::_('select.option', 'IT-G', "IT-G" , 'value', 'text'); 
        $partStateArr[] = JHTML::_('select.option', 'IT-D', "IT-D" , 'value', 'text'); 
        $partStateArr[] = JHTML::_('select.option', 'OO', "OO" , 'value', 'text'); 
        $partStateArr[] = JHTML::_('select.option', 'Prototype', "PROTOTYPE" , 'value', 'text'); 
        

        $i = 0;
        foreach ($this->sto_pn_list as $row) {
                
                                if($row->pns_cpn==1)
                                        $link 	= 'index.php?option=com_apdmpns&amp;task=detailmpn&cid[0]='.$row->pns_id;	
                                else
                                        $link 	= 'index.php?option=com_apdmpns&amp;task=detail&cid[0]='.$row->pns_id;
                                $linkStoTab 	= 'index.php?option=com_apdmpns&task=sto&cid[]='.$row->pns_id;
                                $image = SToController::GetImagePreview($row->pns_id);
				if ($image !=''){					
                                        $pns_image = "<img border=&quot;1&quot; src='".$path_image.$image."' name='imagelib' alt='".JText::_( 'No preview available' )."' width='100' height='100' />";
				}else{
					$pns_image = JText::_('None image for preview');
				}                
                                 $stoList = SToController::GetStoFrommPns($row->pns_id,$sto_id);
                                 if($row->pns_revision)
                                        $pns_code = $row->ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision;
                                else
                                        $pns_code = $row->ccs_code.'-'.$row->pns_code;
                                 
                               
                                ?>
                                        <tr>
                                                <td align="center"><?php echo $i+1; ?></td>
                                                <td align="center">
                                                <input type="checkbox" id = "itopn<?php echo $i?>"  onclick="isCheckedPosPn(this.checked,'<?php echo $row->pns_id;?>','<?php echo implode(",",$stoList);?>');" value="<?php echo $row->pns_id;?>_<?php echo implode(",",$stoList);?>" name="cid[]"  />
                                                </td>                                                
                                                <td align="left"><span class="editlinktip hasTip" title="<?php echo $pns_image;?>" >
					<a href="<?php echo $link;?>" title="<?php echo JText::_('Click to see detail PNs');?>"><?php echo $pns_code;?></a>
				</span></td>
                                                <td align="left"><?php echo $row->pns_description; ?></td>
                                                <td align="center"><?php echo $row->pns_uom; ?></td>
<!--                                                <td align="center">
                                                    <table>
                                                        <?php
//                                                        $mf = GetManufacture($row->pns_id,4);
//                                                        if (count($mf) > 0) {
//                                                            $imf1=1;
//                                                            foreach ($mf as $m) {
//                                                                $style="style='border-bottom:1px solid #eee;'";
//                                                                if($imf1==count($mf))
//                                                                    $style ="style='border-bottom:none'";
//                                                                echo "<tr><td ".$style.">".$m['v_mf'] . '</tr></td>';
//                                                                $imf1++;
//                                                            }
//
//                                                        }
                                                        ?> </table>
                                                </td> -->
                                                <td align="center" colspan="5">
                                                        
                                                        <table class="adminlist" cellspacing="0" width="200">
                                                                <?php 
                                                                foreach ($this->sto_pn_list2 as $rw) {
                                                                        if($rw->pns_id==$row->pns_id)
                                                                        {                                                                                
                                                                ?>
                                                                <tr>
                                                                        <td align="center" width="74px">					
                                                    <span style="display:block" id="text_mfg_pn_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>"><?php echo $rw->pns_mfg_pn_id?SToController::GetMfgPnCode($rw->pns_mfg_pn_id):"";?></span>
                                                       <?php 
                                                        
                                                                 //pns_mfg_pn_id
                                                                $mfgPnLists = SToController::getMfgPnListFromPn($row->pns_id);                                                                
                                                                echo JHTML::_('select.genericlist',   $mfgPnLists, 'mfg_pn_'.$row->pns_id.'_'.$rw->id, 'class="inputbox"  style="display:none; width: 81px;" size="1" ', 'value', 'text', $rw->pns_mfg_pn_id ); 
                                                       
                                                        ?>
                                                </td>	
                                                                        <td align="center" width="74px">
                                                        <span style="display:block" id="text_qty_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>"><?php echo $rw->qty;?></span>
                                                        <input style="display:none;width: 76px" onKeyPress="return numbersOnlyEspecialFloat(this, event);" type="text" value="<?php echo $rw->qty;?>" id="qty_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>"  name="qty_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>" />                                                        
                                                </td> 
                                                <td align="center" width="77px">					
                                                    <span style="display:block" id="text_location_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>"><a href="<?php echo $linkStoTab;?>"><?php echo $rw->location?SToController::GetCodeLocation($rw->location):"";?></a></span>
                                                       <?php 
                                                        if($rw->sto_type==1)
                                                         {
                                                                echo JHTML::_('select.genericlist',   $locationArr, 'location_'.$row->pns_id.'_'.$rw->id, 'class="inputbox"  style="display:none; width: 81px;" size="1" ', 'value', 'text', $rw->location ); 
                                                         }
                                                         else{
															 ?><span  id="ajax_location_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>">
															 <?php 
                                                                 $locationArr = SToController::getLocationPartStatePn($rw->partstate,$row->pns_id);
                                                                echo JHTML::_('select.genericlist',   $locationArr, 'location_'.$row->pns_id.'_'.$rw->id, 'class="inputbox"  style="display:none;width: 81px;" size="1" ', 'value', 'text', $rw->location ); 
																?>
																</span> 
																<?php 
                                                         }
                                                        ?>
                                                </td>	
                                                <td align="center" width="77px">					
                                                        <span style="display:block" id="text_partstate_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>"><?php echo $rw->partstate?strtoupper($rw->partstate):"";?></span>
                                                         <?php       
                                                         if($rw->sto_type==1)
                                                         {
                                                                echo JHTML::_('select.genericlist',   $partStateArr, 'partstate_'.$row->pns_id.'_'.$rw->id, 'class="inputbox" style="display:none;width: 81px;" size="1" ', 'value', 'text', $rw->partstate ); 
                                                         }
                                                         else{                                                                 
                                                                 $partStateArr = SToController::getPartStatePn($rw->partstate,$row->pns_id);
                                                                 echo JHTML::_('select.genericlist',   $partStateArr, 'partstate_'.$row->pns_id.'_'.$rw->id, 'class="inputbox" style="display:none;width: 81px;" size="1" onchange="getLocationPartState('.$row->pns_id.','.$rw->id.','.$rw->location.',this.value);"', 'value', 'text', $rw->partstate ); 
                                                                 
                                                         }
                                                        
                                                        ?>
                                                </td>
                                                <td align="center" width="75px">	
                                                          <?php
                                                 if (in_array("D", $role) && $this->quo_row->sto_owner_confirm==0 && !$this->quo_row->sto_owner) {
                                                ?>
                                                        <a href="index.php?option=com_apdmsto&task=removepnsstos&cid[]=<?php echo $rw->id;?>&sto_id=<?php echo $sto_id;?>" title="<?php echo JText::_('Click to see detail PNs');?>">Remove</a>
                                                        <?php }?>
                                                </td>
                                                                </tr>
                                                                
                                                                <?php 
                                                                }
                                                                }
                                                                ?>
                                                        </table>
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
        <input type="hidden" name="sto_id" value="<?php echo $this->quo_row->pns_sto_id; ?>" />
        <input type="hidden" name="option" value="com_apdmsto" />     
        <input type="hidden" name="id" value="<?php echo JRequest::getVar('id'); ?>" />     
	<input type="hidden" name="task" value="" />	
        <input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_('form.token'); ?>
</form>

