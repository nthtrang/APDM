<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php JHTML::_('behavior.modal'); ?>

<?php
$cid = JRequest::getVar( 'cid', array(0) );
$edit		= JRequest::getVar('edit',true);
$role = JAdministrator::RoleOnComponent(8);
$sto_id = JRequest::getVar('id');
$folder_sto = $this->sto_row->sto_code;
JToolBarHelper::title($this->sto_row->sto_code .': <small><small>[ view ]</small></small>' , 'generic.png' );

if (in_array("E", $role)&& ($this->sto_row->sto_state  != "Done")) {
    JToolBarHelper::customX("editeto",'edit',"Edit","Edit",false);
    //JToolBarHelper::customX("importpn",'upload',"Import Part","Import Part",false);
}

JToolBarHelper::cancel( 'cancel', 'Close' );
//for PPN part
//        if (in_array("E", $role) && ($this->sto_row->sto_state  != "Done")) {
//            $allow_edit = 1;
//            JToolBarHelper::customX('saveqtyStofk', 'save', '', 'Save Shipping Part');
//        }
//        if (in_array("W", $role)&& ($this->sto_row->sto_state  != "Done")) {
//                JToolBarHelper::addPnsSto("Add Part", $this->sto_row->pns_sto_id);        
//        }                     
//        if (in_array("D", $role) && ($this->sto_row->sto_state  != "Done")) {
//                JToolBarHelper::deletePns('Are you sure to delete it?',"removeAllpnsstos","Remove Part");
//                //JToolBarHelper::deletePns('Are you sure to delete it?',"deletesto","Delete ITO");
//                JToolBarHelper::customXDel( 'Are you sure to delete it?', 'deletesto', 'delete', 'Delete ITO');
//        }         
        //end PN part
if ($this->sto_row->sto_isdelivery_good) {
         JToolBarHelper::customX("printetoDelivery","print",'',"Print Delivery",false);
 }
JToolBarHelper::customX("printetopdf","print",'',"Print",false);
if (in_array("D", $role) && $this->sto_row->sto_state !="Done") {
    JToolBarHelper::customXDel( 'Are you sure to delete it?', 'deletesto', 'delete', 'Delete ETO');
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
        if (pressbutton == 'editeto') {
            submitform( pressbutton );
            return;
        }
        if (pressbutton == 'editmpn') {
            submitform( pressbutton );
            return;
        }
        
        if (pressbutton == 'printetopdf') {
            //window.location = "index.php?option=com_apdmpns&task=printwopdf&id="+form.wo_id.value + "&tmpl=component";
            var url = "index.php?option=com_apdmsto&task=printetopdf&id="+form.sto_id.value + "&tmpl=component";
            window.open(url, '_blank');
            return;
        }
        if (pressbutton == 'importpneto') {
            submitform( pressbutton );
            return window.location = "index.php?option=com_apdmsto&task=importpneto&id="+form.sto_id.value;

        }
         if (pressbutton == 'printetoDelivery') {
            //window.location = "index.php?option=com_apdmpns&task=printwopdf&id="+form.wo_id.value + "&tmpl=component";
            var url = "index.php?option=com_apdmsto&task=printetoDelivery&id="+form.sto_id.value + "&tmpl=component";
            window.open(url, '_blank');
            return;
        }
        
         if (pressbutton == 'saveqtyStofk') {
                       // submitform( pressbutton );
                       // return;
                       
                             
                                var cpn = document.getElementsByName('cid[]');
                                var len = cpn.length;                              
                                for (var i=0; i<len; i++)
                                {
                                        if(cpn[i].checked)
                                        {
                                            var arr_sto = cpn[i].value.split("_");
                                            var arr_qfk = arr_sto[1].split(",");
                                            var check_pass = 1;
                                            arr_qfk.forEach(function(sti)
                                            {
                                                /*var mfg_pn_value = document.getElementById('mfg_pn_' + arr_sto[0]+'_'+sti).value;
                                                if (mfg_pn_value == 0)
                                                {
                                                    alert("Please choose MFG PN");
                                                    check_pass = 0;
                                                    document.getElementById('mfg_pn_' + arr_sto[0]+'_'+ sti).focus();
                                                    return;
                                                }*/
                                                var location_value = document.getElementById('location_' + arr_sto[0]+'_'+sti).value;
                                                if (location_value == 0)
                                                {
                                                    alert("Please choose Location");
                                                    check_pass = 0;
                                                    document.getElementById('location_' + arr_sto[0]+'_'+ sti).focus();
                                                    return;
                                                }                                                
                                                var qty_value = document.getElementById('qty_' + arr_sto[0]+'_'+sti).value;
                                                if (qty_value == 0)
                                                {
                                                    alert("Please input QTY for PN selected");
                                                        check_pass = 0;
                                                    document.getElementById('qty_' + arr_sto[0]+'_'+ sti).focus();
                                                    return;
                                                }
                                            });
                                        }
                                }
                                if(check_pass==1){
                                        submitform( pressbutton );
                                        return;         
                                }
                             

                                      
                        
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
                     //  document.getElementById('ajax_location_'+pnsId+'_'+fkId).innerHTML = result.trim();
                }
        }).request();
        
}
function getMfgPnPartState(pnsId,fkId,currentMfgPn,partState)
{	
        var url = 'index.php?option=com_apdmsto&task=ajax_getmfgpn_partstate&partstate='+partState+'&pnsid='+pnsId+'&fkid='+fkId+'&currentmfgpn='+currentMfgPn;
        var MyAjax = new Ajax(url, {
                method:'get',
                onComplete:function(result){
                       document.getElementById('ajax_mfgpn_'+pnsId+'_'+fkId).innerHTML = result.trim();
                    document.getElementById('mfg_pn_'+pnsId+'_'+fkId).onchange();
                }
        }).request();

}
function getLocationFromMfgPn(pnsId,fkId,currentLocation,MfgPn,partstate)
{
    var partState = document.getElementById('partstate_' + pnsId+'_'+fkId).value;
    var url = 'index.php?option=com_apdmsto&task=ajax_getlocation_mfgpn&mfgpn='+MfgPn+'&pnsid='+pnsId+'&fkid='+fkId+'&currentloc='+currentLocation+'&partstate='+partState;
    var MyAjax = new Ajax(url, {
        method:'get',
        onComplete:function(result){
            document.getElementById('ajax_location_'+pnsId+'_'+fkId).innerHTML = result.trim();
        }
    }).request();
}
function checkAllEtoPn(n, fldName )
{
  if (!fldName) {
     fldName = 'etopn';
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
    function autoAddPartEto(pns,sto_id){
        window.location = "index.php?option=com_apdmsto&task=ajax_addpn_eto&sto_id="+sto_id+"&pns_code="+pns+"&time=<?php echo time();?>";
    }
function checkforscaneto(isitchecked)
{
        if (isitchecked == true){
                document.getElementById("pns_code").focus();
                document.getElementById('pns_code').setAttribute("onkeyup", "autoAddPartEto(this.value,'<?php echo $this->sto_row->pns_sto_id; ?>')");
            checkedforMarkScan(1);
        }
        else {
                document.getElementById('pns_code').setAttribute("onkeyup", "return false;");
            checkedforMarkScan(0);
        }
}

function checkedforMarkScan(ischecked)
{
    var url = 'index.php?option=com_apdmsto&task=ajax_markscan_checked&etoscan='+ischecked;
    var MyAjax = new Ajax(url, {
        method:'get',
        onComplete:function(result){
            var eco_result = result;

        }
    }).request();
}    
</script>
<!--<div class="submenu-box">
    <div class="t">
        <div class="t">
            <div class="t"></div>
        </div>
    </div>
    <div class="m">
        <ul id="submenu" class="configuration">
            <li><a id="detail" class="active"><?php echo JText::_( 'DETAIL' ); ?></a></li>
            <li><a id="bom" href="index.php?option=com_apdmsto&task=ito_detail_pns&id=<?php echo $this->sto_row->pns_sto_id;?>"><?php echo JText::_( 'AFFECTED PARTS' ); ?></a></li>
            <li><a id="bom" href="index.php?option=com_apdmsto&task=eto_detail_support_doc&id=<?php echo $this->sto_row->pns_sto_id;?>"><?php echo JText::_( 'SUPPORTING DOC' ); ?></a></li>
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
<p>&nbsp;</p>-->

<form action="index.php"  onsubmit="submitbutton('')"  method="post" name="adminForm" >
    <fieldset>
        <legend><?php echo JText::_( 'ETO Detail' ); ?></legend>
        <table class="admintable" cellspacing="1"  width="70%">
            <tr>
                <td class="key" width="28%"><?php echo JText::_('ETO'); ?></td>
                <td width="30%" class="title"><?php echo $this->sto_row->sto_code; ?></td>
                <td class="key" width="18%"><?php echo JText::_('WO'); ?></td>
                <td width="30%" class="title"><?php echo ($this->sto_row->wo_code)?$this->sto_row->wo_code:"NA";?></td>

            </tr>
            <tr>
                <td  class="key" width="28%"><?php echo JText::_('SO'); ?></td>
                <td width="30%" class="title"><?php
                if($this->sto_row->sto_isdelivery_good && $this->sto_row->sto_so_id){
                        echo SToController::getSoCodeFromId($this->sto_row->sto_so_id);
                       
                }
                else
                {
                    $soNumber = $this->sto_row->so_cuscode;
                    if($this->sto_row->ccs_code)
                    {
                        $soNumber = $this->sto_row->ccs_code."-".$soNumber;
                    }
                    echo ($soNumber)?$soNumber:"NA";
                }
                    ?></td>
                <td  class="key" width="28%"><?php echo JText::_('State'); ?></td>
                <td width="30%" class="title"><?php echo $this->sto_row->sto_state;?></td>
            </tr>
            <tr>
                <td  class="key" width="28%"><?php echo JText::_('External PO'); ?></td>
                <td width="30%" class="title"><?php
                  //  if($this->sto_row->sto_isdelivery_good && $this->sto_row->sto_so_id){
                        //echo SToController::getPoExCodeFromId($this->sto_row->sto_so_id);
                        echo $this->sto_row->so_cuscode;
                   // }
                    ?>
                </td>
                <td  class="key" width="28%"></td>
                <td width="30%" class="title">
                   </td>
            </tr>
            <tr>
                <td  class="key" width="28%"><?php echo JText::_('Customer'); ?></td>
                <td width="30%" class="title"><?php 
                if($this->sto_row->sto_isdelivery_good && $this->sto_row->sto_so_id){
                        echo SToController::getCustomerCodeFromSoId($this->sto_row->sto_so_id);
                }
                else
                {
                        echo ($this->sto_row->ccs_name)?$this->sto_row->ccs_name:"NA";     
                }
                 ?></td>
                <td  class="key" width="28%"><?php echo JText::_( 'Delivery Goods' ); ?></td>
                <td width="30%" class="title"><?php
                    if($this->sto_row->sto_isdelivery_good)
                        echo "Yes";
                    else {
                        echo "No";
                    }
                    ?></td>
            </tr>
            <tr>
                <td class="key"  width="28%"><?php echo JText::_('Created Date'); ?></td>
                <td width="30%" class="title"><?php echo JHTML::_('date', $this->sto_row->sto_created, JText::_('DATE_FORMAT_LC5')); ?></td>
                <td  class="key" width="28%"><?php echo JText::_('Stocker'); ?></td>
                <td width="30%" class="title"><?php echo GetValueUser($this->sto_row->sto_stocker, "name"); ?></td>

            </tr>
            <tr>
                <td class="key"  width="28%"><?php echo JText::_('Completed Date'); ?></td>
                <td width="30%" class="title">  <?php echo ($this->sto_row->sto_completed_date!='0000-00-00 00:00:00')?JHTML::_('date', $this->sto_row->sto_completed_date, JText::_('DATE_FORMAT_LC5')):""; ?></td>
                <td  class="key" width="28%"><?php echo JText::_('Stocker Confirm'); ?></td>
                <td width="30%" class="title">
                    <input checked="checked" type="checkbox" name="sto_stocker_confirm" value="1" onclick="return false;" onkeydown="return false;" />
                </td>

            </tr>
            <tr>
                <td  class="key" width="28%"><?php echo JText::_('Owner'); ?></td>
                <td width="30%" class="title">  <?php echo ($this->sto_row->sto_owner)?GetValueUser($this->sto_row->sto_owner, "name"):""; ?></td>
                <td  class="key" width="28%"><?php echo JText::_('Confirm'); ?></td>

                <td width="30%" class="title">
                    <?php
                    if($this->sto_row->sto_owner_confirm==0){

                        ?>


                        <a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmsto&task=get_owner_confirm_sto&sto_id=<?php echo $this->sto_row->pns_sto_id?>&tmpl=component" title="Image">
                            <input onclick="return false;" onkeydown="return false;" type="checkbox" name="sto_owner_confirm" value="1" /></a>
                    <?php }
                    else
                    {
                        ?>
                        <input checked="checked" onclick="return false;" onkeydown="return false;" type="checkbox" name="sto_owner_confirm" value="1" />
                        <?php
                    }
                    ?>
                </td>

            </tr>
            <tr>
                <td class="key"  width="28%"><?php echo JText::_('Description'); ?></td>
                <td colspan="3"><?php echo strtoupper($this->sto_row->sto_description); ?></td>

            </tr>
        </table>
    </fieldset>
        <?php
                            $style='style="display: none"';
                            if($this->sto_row->sto_isdelivery_good)
                            {
                                    $style='style="display: block"';
                            }
                            ?>
                            <div id="delivery_info" <?php echo $style?> >
                            <fieldset>               
                                    <legend><?php echo JText::_( 'Delivery Note' ); ?></legend>
                                   <table class="admintable" cellspacing="1" width="50%">
                                           <tr><td  class="key">Delivery Method</td>
                                           <td colspan="3"><?php  echo $this->sto_row->delivery_method; ?></td>
                                           </tr>
                                        <tr>
                                            <td colspan="2">
                                                <label for="name" style="color:#0B55C4;font-size: 12px;font-weight: bold">
                                                    <?php echo JText::_( 'Shipping Address' ); ?>
                                                </label>
                                            </td>
                                          <td colspan="2">
                                                <label for="name" style="color:#0B55C4;font-size: 12px;font-weight: bold">
                                                    <?php echo JText::_( 'Invoice Address' ); ?>
                                                </label>
                                            </td>
                                        </tr> 
                                        <tr>
                                            <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'Name' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <?php  echo $this->sto_row->delivery_shipping_name; ?>
                                            </td>
                                             <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'Name' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <?php  echo $this->sto_row->delivery_billing_name; ?>
                                            </td>
                                             </tr>
                                             <tr>
                                            <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'Company name' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <?php  echo $this->sto_row->delivery_shipping_company; ?>
                                            </td>
                                             <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'Company name' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <?php  echo $this->sto_row->delivery_billing_company; ?>
                                            </td>
                                             </tr>
                                             <tr>
                                            <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'Street address' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <?php  echo $this->sto_row->delivery_shipping_street; ?>
                                            </td>
                                             <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'Street address' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                               <?php  echo $this->sto_row->delivery_billing_street; ?>
                                            </td>
                                             </tr>
                                             <tr>
                                            <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'City,Zip code' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <?php  echo $this->sto_row->delivery_shipping_zipcode; ?>
                                            </td>
                                             <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'City,Zip code' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                               <?php  echo $this->sto_row->delivery_billing_zipcode; ?>
                                            </td>
                                             </tr>
                                             <tr>
                                            <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'Phone number' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <?php  echo $this->sto_row->delivery_shipping_phone; ?>
                                            </td>
                                             <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'Phone number' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <?php  echo $this->sto_row->delivery_billing_phone; ?>
                                            </td>
                                             </tr>
                                           </table>
                                    </fieldset>
                            </div>
        <fieldset>		 
		<legend><?php echo JText::_( 'Documents' ); ?> <font color="#FF0000"><em><?php //echo JText::_('(Please upload file less than 20Mb)')?></em></font></legend>
                <table class="adminlist">                        
              <?php if (isset($this->lists['image_files'])&& count($this->lists['image_files'])>0) {?>
				<tr>
                                        <td colspan="2" >
					<table width="100%"  class="adminlist" cellpadding="1">
						
						<thead>
							<th colspan="4"><?php echo JText::_('List Documents')?></th>
						</thead>
						<tr>
							<td width="5%"><strong><?php echo JText::_('No.')?></strong></td>
							<td width="45%"><strong><?php echo JText::_('Name')?> </strong></td>
							<td width="30%"><strong><?php echo JText::_('Size (KB)')?> </strong></td>
							<td width="20%"><strong><?php echo JText::_('Download')?>  <?php echo JText::_('Remove')?></strong></td>
						</tr>
				<?php
				
				$i = 1;
				foreach ($this->lists['image_files'] as $image) {
					$filesize = SToController::readfilesizeSto($folder_sto, $image['image_file'],'images');
				?>
				<tr>
					<td><?php echo $i?></td>
					<td><?php echo $image['image_file']?></td>
					<td><?php echo number_format($filesize, 0, '.', ' '); ?></td>
					<td><a href="index.php?option=com_apdmsto&task=download_doc_sto&type=images&sto_id=<?php echo $this->sto_row->pns_sto_id?>&id=<?php echo $image['id']?>" title="Click here to download file"><img src="images/download_f2.png" width="20" height="20" /></a>&nbsp;&nbsp;
                                                <?php
                                               if (in_array("D", $role) && $this->sto_row->sto_state  != "Done") {                       
                                                ?>
					<a href="index.php?option=com_apdmsto&task=remove_doc_sto&back=eto_detail&type=images&sto_id=<?php echo $this->sto_row->pns_sto_id?>&id=<?php echo $image['id']?>&remove=<?php echo $i.time();?>" title="Click to remove" onclick="if ( confirm('Are you sure to delete it ? ') ) { return true;} else {return false;} "><img src="images/cancel_f2.png" width="15" height="15" /></a>
                                         <?php
                                               }
                                                ?>
                                        </td>
				</tr>
				<?php $i++; } ?>
				
				<tr>
					
					<td colspan="4" align="center">
					<a href="index.php?option=com_apdmsto&task=download_all_doc_sto&type=images&tmpl=component&sto_id=<?php echo $this->sto_row->pns_sto_id;?>" title="Download All Files">
                                       <!-- <input type="button" name="addVendor" value="<?php /*echo JText::_('Download All Files')*/?>"/>-->
                                        </a>&nbsp;&nbsp;

<!--					<input type="button" value="<?php echo JText::_('Remove All Files')?>" onclick="if ( confirm ('Are you sure to delete it ?')) { window.location.href='index.php?option=com_apdmpns&task=remove_all_images&pns_id=<?php echo $this->row->pns_id?>' }else{ return false;}" /></td>					-->
				</tr>
								
					</table>
					</td>                                        
                                        
				</tr>
				<?php } ?>
                                
                                                    
                                <?php if (isset($this->lists['pdf_files'])&& count($this->lists['pdf_files'])>0) {?>
				<tr>
                                        <td colspan="2" >
					<table width="100%"  class="adminlist" cellpadding="1">
						<hr />
						<thead>
							<th colspan="4"><?php echo JText::_('List PDF')?></th>
						</thead>
						<tr>
							<td width="5%"><strong><?php echo JText::_('No.')?></strong></td>
							<td width="45%"><strong><?php echo JText::_('Name')?> </strong></td>
							<td width="30%"><strong><?php echo JText::_('Size (KB)')?> </strong></td>
							<td width="20%"><strong><?php echo JText::_('Download')?>  <?php echo JText::_('Remove')?></strong></td>
						</tr>
				<?php
				
				$i = 1;				                   
				foreach ($this->lists['pdf_files'] as $pdf) {
					$filesize = SToController::readfilesizeSto($folder_sto, $pdf['pdf_file'],'pdfs');
				?>
				<tr>
					<td><?php echo $i?></td>
					<td><?php echo $pdf['pdf_file']?></td>
					<td><?php echo number_format($filesize, 0, '.', ' '); ?></td>
					<td><a href="index.php?option=com_apdmsto&task=download_doc_sto&type=pdfs&sto_id=<?php echo $this->sto_row->pns_sto_id?>&id=<?php echo $pdf['id']?>" title="Click here to download file"><img src="images/download_f2.png" width="20" height="20" /></a>&nbsp;&nbsp;
                                                 <?php
                                               if ($this->sto_row->sto_state  != "Done") {                       
                                                ?>
					<a href="index.php?option=com_apdmsto&task=remove_doc_sto&back=eto_detail&type=pdfs&sto_id=<?php echo $this->sto_row->pns_sto_id?>&id=<?php echo $pdf['id']?>&remove=<?php echo $i.time();?>" title="Click to remove" onclick="if ( confirm('Are you sure to delete it ? ') ) { return true;} else {return false;} "><img src="images/cancel_f2.png" width="15" height="15" /></a>
                                         <?php
                                              }
                                                ?>
                                        </td>
				</tr>
				<?php $i++; } ?>
				
				<tr>
					
					<td colspan="4" align="center">
				<a href="index.php?option=com_apdmsto&task=download_all_doc_sto&type=pdfs&tmpl=component&sto_id=<?php echo $this->sto_row->pns_sto_id;?>" title="Download All Files">
                                        <input type="button" name="addVendor" value="<?php echo JText::_('Download All Files')?>"/>
                                        </a>&nbsp;&nbsp;

<!--					<input type="button" value="<?php echo JText::_('Remove All Files')?>" onclick="if ( confirm ('Are you sure to delete it ?')) { window.location.href='index.php?option=com_apdmpns&task=remove_all_pdfs&pns_id=<?php echo $this->row->pns_id?>' }else{ return false;}" /></td>					-->
				</tr>
								
					</table>
					</td>                                        
                                        
				</tr>
				<?php } ?>  
                                       
                        <?php if (count($this->lists['zips_files']) > 0) {
				?>				
				<tr>
					<td colspan="2" >
					<table width="100%"  class="adminlist" cellpadding="1">
						<hr />
						<thead>
							<th colspan="4"><?php echo JText::_('List ZIP')?></th>
						</thead>
						<tr>
							<td width="5%"><strong><?php echo JText::_('No.')?></strong></td>
							<td width="45%"><strong><?php echo JText::_('Name')?> </strong></td>
							<td width="30%"><strong><?php echo JText::_('Size (KB)')?> </strong></td>
							<td width="20%"><strong><?php echo JText::_('Download')?>  <?php echo JText::_('Remove')?></strong></td>
						</tr>
				<?php
				
				$i = 1;
				                        
				foreach ($this->lists['zips_files'] as $cad) {
					$filesize = SToController::readfilesizeSto($folder_sto, $cad['zip_file'],'zips');                                        				
				?>
				<tr>
					<td><?php echo $i?></td>
					<td><?php echo $cad['zip_file']?></td>
					<td><?php echo number_format($filesize, 0, '.', ' '); ?></td>
					<td><a href="index.php?option=com_apdmsto&task=download_zip_sto&type=zips&sto_id=<?php echo $this->sto_row->pns_sto_id?>&id=<?php echo $cad['id']?>" title="Click here to download file"><img src="images/download_f2.png" width="20" height="20" /></a>&nbsp;&nbsp;
                                                 <?php
                                             if ($this->sto_row->sto_state  != "Done") {                  
                                                ?>
					<a href="index.php?option=com_apdmsto&task=remove_doc_sto&back=eto_detail&type=zips&sto_id=<?php echo $this->sto_row->pns_sto_id?>&id=<?php echo $cad['id']?>&remove=<?php echo $i.time();?>" title="Click to remove" onclick="if ( confirm('Are you sure to delete it ? ') ) { return true;} else {return false;} "><img src="images/cancel_f2.png" width="15" height="15" /></a>
                                         <?php
                                               }
                                                ?>
                                        </td>
				</tr>
				<?php $i++; } ?>
				
				<tr>
					
					<td colspan="4" align="center">
                                                <a href="index.php?option=com_apdmsto&task=download_all_doc_sto&type=zips&tmpl=component&sto_id=<?php echo $this->sto_row->pns_sto_id;?>" title="Download All Files">
                                                <input type="button" name="addVendor" value="<?php echo JText::_('Download All Files')?>"/>
                                                </a>&nbsp;&nbsp;
				
<!--					<input type="button" value="<?php echo JText::_('Remove All Files')?>" onclick="if ( confirm ('Are you sure to delete it ?')) { window.location.href='index.php?option=com_apdmpns&task=remove_all_cad&pns_id=<?php echo $this->row->pns_id?>' }else{ return false;}" /></td>					-->
				</tr>
				
					</table>
					</td>
				</tr>
				<?php } ?>                                        
				</tr>		
          
                                          </table>
                </fieldset>   
        <fieldset>
                <legend>Shipping Part</legend>       
<div class="toolbar">
            <table class="toolbar"><tbody><tr>
<?php
if($this->sto_row->sto_owner_confirm==0 && !$this->sto_row->sto_owner) {
    if (in_array("W", $role) && ($this->sto_row->sto_state != "Done")) {
       $session = JFactory::getSession();
        if($session->get('is_scaneto')){
            $etoscanchecked = 'checked="checked"';
            $etoonkeyUp = "onkeyup=\"autoAddPartEto(this.value,'".$this->sto_row->pns_sto_id."')\" autofocus";
        }
        else
        {
            $etoscanchecked = "";
            $etoonkeyUp = "";
        }
        ?>
        <td class="button" id="toolbar-addpnsave">
            Scan PN Barcode <input <?php echo $etoonkeyUp?> onchange="autoAddPartEto(this.value,'<?php echo $this->sto_row->pns_sto_id; ?>')" onkeyup="autoAddPartEto(this.value,'<?php echo $this->sto_row->pns_sto_id; ?>')" type="text"  name="pns_code" id="pns_code" value="" >
            <input <?php echo $etoscanchecked?> type="checkbox" name="check_scan_barcode" value="1" onclick="checkforscaneto(this.checked)" />
        </td>
        <td class="button" id="toolbar-save">
            <a href="#"
               onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Please make a selection from the list to save shipping part');}else{ hideMainMenu(); submitbutton('saveqtyStofk')}"
               class="toolbar">
<span class="icon-32-save" title="Save Shipping Part">
</span>
                Save Shipping Part
            </a>
        </td>
        <td class="button" id="toolbar-popup-Popup">
            <a class="modal"
               href="index.php?option=com_apdmpns&amp;task=get_list_pns_eto&amp;tmpl=component&amp;sto_id=<?php echo $this->sto_row->pns_sto_id; ?>"
               rel="{handler: 'iframe', size: {x: 850, y: 500}}">
<span class="icon-32-new" title="Add Part">
</span>
                Add Part
            </a>
        </td>
        <td class="button" id="toolbar-upload">
<a href="#" onclick="javascript:hideMainMenu(); submitbutton('importpneto')" class="toolbar">
<span class="icon-32-upload" title="Import PNs from WO">
</span>
Import PNs from WO
</a>
</td>
        <?php
    }
    if (in_array("D", $role) && ($this->sto_row->sto_state != "Done")) {
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
                                        <th width="18"><?php echo JText::_('NUM'); ?></th>                                               
                                        <th width="3%" class="title"><input type="checkbox" name="toggle" value="" onclick="checkAllEtoPn(<?php echo count($this->sto_pn_list); ?>);" /></th>
                                        <th width="100"><?php echo JText::_('Part Number'); ?></th>
                                        <th width="100"><?php echo JText::_('Description'); ?></th>  
                                        <th width="100"><?php echo JText::_('UOM'); ?></th>  
                                        <th width="100"><?php echo JText::_('MFG PN'); ?></th>  
                                        <th width="100"><?php echo ($this->sto_row->sto_type==1)?JText::_('QTY In'):JText::_('QTY Out'); ?></th>
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
                                                <input type="checkbox" id = "etopn<?php echo $i?>" onclick="isCheckedPosPn(this.checked,'<?php echo $row->pns_id;?>','<?php echo implode(",",$stoList);?>');" value="<?php echo $row->pns_id;?>_<?php echo implode(",",$stoList);?>" name="cid[]"  />
                                                </td>                                                
                                                <td align="left"><span class="editlinktip hasTip" title="<?php echo $pns_image;?>" >
					<a href="<?php echo $link;?>" title="<?php echo JText::_('Click to see detail PNs');?>"><?php echo $pns_code;?></a>
				</span></td>
                                                <td align="left"><?php echo $row->pns_description; ?></td>
                                                <td align="center"><?php echo $row->pns_uom; ?></td>
<!--                                                <td align="center">
                                                    <table>
                                                        <?php
                                                       /* $mf = GetManufacture($row->pns_id,4);
                                                        if (count($mf) > 0) {
                                                            $imf1=1;
                                                            foreach ($mf as $m) {
                                                                $style="style='border-bottom:1px solid #eee;'";
                                                                if($imf1==count($mf))
                                                                    $style ="style='border-bottom:none'";
                                                                echo "<tr><td ".$style.">".$m['v_mf'] . '</tr></td>';
                                                                $imf1++;
                                                            }

                                                        }*/
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
                                                        <span  id="ajax_mfgpn_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>">
                                                                  <?php 
                                                        
                                                                 //pns_mfg_pn_id
                                                                $mfgPnLists = SToController::getMfgPnListFromPnEto($row->pns_id,$rw->partstate);                                                                
                                                                echo JHTML::_('select.genericlist',   $mfgPnLists, 'mfg_pn_'.$row->pns_id.'_'.$rw->id, 'class="inputbox"  style="display:none; width: 81px;" size="1" onchange="getLocationFromMfgPn(\''.$row->pns_id.'\',\''.$rw->id.'\',\''.$rw->location.'\',this.value)"', 'value', 'text', $rw->pns_mfg_pn_id );
                                                       
                                                        ?></span> 
                                                </td>	
                                                                        <td align="center" width="74px">
                                                        <span style="display:block" id="text_qty_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>"><?php echo $rw->qty;?></span>
                                                        <input style="display:none;width: 70px" onKeyPress="return numbersOnlyEspecialFloat(this, event);" type="text" value="<?php echo $rw->qty;?>" id="qty_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>"  name="qty_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>" />                                                        
                                                </td> 
                                                <td align="center" width="77px">					
                                                    <span style="display:block" id="text_location_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>"><a href="<?php echo $linkStoTab;?>"><?php echo $rw->location?SToController::GetCodeLocation($rw->location):"";?></a></span>
                                                       <?php 
                                                        
														 ?><span  id="ajax_location_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>">
															 <?php 
                                                                 $locationArr1 = SToController::getLocationPartStatePnEto($rw->partstate,$row->pns_id,$rw->pns_mfg_pn_id,$rw->id);
                                                                echo JHTML::_('select.genericlist',   $locationArr1, 'location_'.$row->pns_id.'_'.$rw->id, 'class="inputbox" style="display:none" size="1" ', 'value', 'text', $rw->location ); 
																?>
																</span> 																
                                                </td>	
                                                <td align="center" width="77px">					
                                                        <span style="display:block" id="text_partstate_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>"><?php echo $rw->partstate?strtoupper($rw->partstate):"";?></span>
                                                         <?php       
                                                                                                                     
                                                                 $partStateArr = SToController::getPartStatePnEto($rw->partstate,$row->pns_id);
                                                                 echo JHTML::_('select.genericlist',   $partStateArr, 'partstate_'.$row->pns_id.'_'.$rw->id, 'class="inputbox" style="display:none" size="1" onchange="getLocationPartState(\''.$row->pns_id.'\',\''.$rw->id.'\',\''.$rw->location.'\',this.value);getMfgPnPartState(\''.$row->pns_id.'\',\''.$rw->id.'\',\''.$rw->pns_mfg_pn_id.'\',this.value)"', 'value', 'text', $rw->partstate );
                                                        ?>
                                                </td>
                                                <td align="center" width="75px">	
                                                          <?php
                                                          //if($this->sto_row->sto_owner_confirm==0 && !$this->sto_row->sto_owner) {
                                             if ($this->sto_row->sto_owner_confirm==0 && !$this->sto_row->sto_owner) {
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
    <input type="hidden" name="sto_id" value="<?php echo $this->sto_row->pns_sto_id; ?>" />
    <input type="hidden" name="option" value="com_apdmsto" />
    <input type="hidden" name="id" value="<?php echo JRequest::getVar('id'); ?>" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />

    <?php echo JHTML::_('form.token'); ?>
</form>

