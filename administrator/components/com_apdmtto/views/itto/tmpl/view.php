<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php JHTML::_('behavior.modal');
$cid    = JRequest::getVar( 'cid', array(0) );
$edit   = JRequest::getVar('edit',true);
$tto_id = JRequest::getVar('id');
$role   = JAdministrator::RoleOnComponent(11);
JToolBarHelper::title($this->tto_row->tto_code .': <small><small>[ view ]</small></small>' , 'generic.png' );

if (in_array("E", $role)&& ($this->tto_row->tto_state  == "Create")) {
        $session = JFactory::getSession();
        if($session->get('is_scantto')){
            $ttoscanchecked = 'checked="checked"';
            $ttoonkeyUp = "onkeyup=\"autoAddPartTto(this.value,'".$this->tto_row->pns_tto_id."')\" autofocus";
        }
        else
        {
            $ttoscanchecked = "";
            $ttoonkeyUp = "";
        }
            JToolBarHelper::customX("edittto",'edit',"Edit","Edit",false);
}
    JToolBarHelper::cancel( 'cancel', 'Close' );
        //for PPN part
       /* if (in_array("E", $role) && ($this->tto_row->sto_state  != "Done")) {
            $allow_edit = 1;
            JToolBarHelper::customX('saveqtyStofk', 'save', '', 'Save Receiving Part');
        }
        if (in_array("W", $role)&& ($this->tto_row->sto_state  != "Done")) {
                JToolBarHelper::addPnsSto("Add Part", $this->tto_row->pns_sto_id);        
        }                     
        if (in_array("D", $role) && ($this->tto_row->sto_state  != "Done")) {
                JToolBarHelper::deletePns('Are you sure to delete it?',"removeAllpnsstos","Remove Part");
                //JToolBarHelper::deletePns('Are you sure to delete it?',"deletesto","Delete ITO");
                JToolBarHelper::customXDel( 'Are you sure to delete it?', 'deletesto', 'delete', 'Delete ITO');
        }     */
        //end PN part
        
        JToolBarHelper::customX("printttopdf","print",'',"Print",false);

if (in_array("D", $role) && $this->tto_row->tto_state =="Create") {
    JToolBarHelper::customXDel( 'Are you sure to delete it?', 'deletetto', 'delete', 'Delete TTO');
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
                if (pressbutton == 'edittto') {
                        submitform( pressbutton );
                        return;
                }
                if (pressbutton == 'printttopdf') {
                    //window.location = "index.php?option=com_apdmpns&task=printwopdf&id="+form.wo_id.value + "&tmpl=component";
                    var url = "index.php?option=com_apdmtto&task=printttopdf&id="+form.tto_id.value + "&tmpl=component";
                    window.open(url, '_blank');
                    return;
                }
                if (pressbutton == 'saveqtyTtofk') {
                        submitform( pressbutton );
                        return;
                }                      
                if(pressbutton == 'removeAllpnsttos')
                {
                     submitform( pressbutton );
                     return;
                } 
                if(pressbutton == 'download_tto')
                {
                     submitform( pressbutton );
                     return;
                }     
                if (pressbutton == 'save_doc_tto') {
                        submitform( pressbutton );
                        return;
                }  
                 if (pressbutton == 'deletetto') {
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
                
//                document.getElementById('location_'+id+'_'+sti).style.visibility= 'visible';
//                document.getElementById('location_'+id+'_'+sti).style.display= 'block';
//                document.getElementById('text_location_'+id+'_'+sti).style.visibility= 'hidden';
//                document.getElementById('text_location_'+id+'_'+sti).style.display= 'none';    
//                
//                document.getElementById('partstate_'+id+'_'+sti).style.visibility= 'visible';
//                document.getElementById('partstate_'+id+'_'+sti).style.display= 'block';
//                document.getElementById('text_partstate_'+id+'_'+sti).style.visibility= 'hidden';
//                document.getElementById('text_partstate_'+id+'_'+sti).style.display= 'none';
//                document.getElementById('tooltype_'+id+'_'+sti).style.visibility= 'visible';
//                document.getElementById('tooltype_'+id+'_'+sti).style.display= 'block';
//                document.getElementById('text_tooltype_'+id+'_'+sti).style.visibility= 'hidden';
//                document.getElementById('text_tooltype_'+id+'_'+sti).style.display= 'none';
                });
	}
	else {
		document.adminForm.boxchecked.value--;
                 arr_sto.forEach(function(sti) {
                document.getElementById('text_qty_'+id+'_'+sti).style.visibility= 'visible';
                document.getElementById('text_qty_'+id+'_'+sti).style.display= 'block';

//                document.getElementById('text_location_'+id+'_'+sti).style.visibility= 'visible';
//                document.getElementById('text_location_'+id+'_'+sti).style.display= 'block';
//
//                document.getElementById('text_partstate_'+id+'_'+sti).style.visibility= 'visible';
//                document.getElementById('text_partstate_'+id+'_'+sti).style.display= 'block';

//                 document.getElementById('text_tooltype_'+id+'_'+sti).style.visibility= 'visible';
//                 document.getElementById('text_tooltype_'+id+'_'+sti).style.display= 'block';

                document.getElementById('qty_'+id+'_'+sti).style.visibility= 'hidden';
                document.getElementById('qty_'+id+'_'+sti).style.display= 'none';
                
//                document.getElementById('location_'+id+'_'+sti).style.visibility= 'hidden';
//                document.getElementById('location_'+id+'_'+sti).style.display= 'none';
//                document.getElementById('partstate_'+id+'_'+sti).style.visibility= 'hidden';
//                document.getElementById('partstate_'+id+'_'+sti).style.display= 'none';
//                 document.getElementById('tooltype_'+id+'_'+sti).style.visibility= 'hidden';
//                 document.getElementById('tooltype_'+id+'_'+sti).style.display= 'none';
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
function checkAllToolPn(n, fldName )
{
  if (!fldName) {
     fldName = 'toolpn';
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
    function autoAddPartTto(pns,tto_id){

        setTimeout(function(){
        window.location = "index.php?option=com_apdmtto&task=ajax_addscanpn_tto&tto_id="+tto_id+"&pns_code="+pns+"&time=<?php echo time();?>";
    }, 1000);
    }
function checkforscantto(isitchecked)
{
        if (isitchecked == true){
                document.getElementById("pns_code").focus();
                document.getElementById('pns_code').setAttribute("onkeyup", "autoAddPartTto(this.value,'<?php echo $this->sto_row->pns_sto_id; ?>')");
            checkedforMarkScanTto(1);
        }
        else {
                document.getElementById('pns_code').setAttribute("onkeyup", "return false;");
            checkedforMarkScanTto(0);
        }
}

function checkedforMarkScanTto(ischecked)
{
    var url = 'index.php?option=com_apdmtto&task=ajax_markscan_checkedtto&ttoscan='+ischecked;
    var MyAjax = new Ajax(url, {
        method:'get',
        onComplete:function(result){
            var eco_result = result;

        }
    }).request();
}   
</script>
<form action="index.php"  onsubmit="submitbutton('')"  method="post" name="adminForm" >	
        <fieldset>
		<legend><?php echo JText::_( 'Tool Detail' ); ?></legend>        
        <table class="admintable" cellspacing="1"  width="80%">
                              <tr>
                                        <td class="key" width="11%"><?php echo JText::_('TTO Number'); ?></td>                                               
                                        <td width="12%" class="title"><?php echo $this->tto_row->tto_code; ?></td>                                          
                                        <td class="key" width="20%"><?php echo JText::_('Tool Assigner'); ?></td>                                               
                                        <td width="20%" class="title"><?php echo GetValueUser($this->tto_row->tto_create_by, "name");?></td>
                                       <td  class="key"><?php echo JText::_('Confirm'); ?></td>                                                                                       
                                         <td colspan="2"  class="title">
                                                 <input checked="checked" onclick="return false;" onkeydown="return false;" type="checkbox" name="tto_create_confirm" value="1" />
                                                                    
                                        </td>  
				                                                                              
                                </tr>
                                <tr>
                                        <td class="key" ><?php echo JText::_('Created Date'); ?></td>                                               
                                        <td  class="title"><?php echo JHTML::_('date', $this->tto_row->tto_created, JText::_('DATE_FORMAT_LC5')); ?></td>
					<td  class="key"><?php echo JText::_('Owner'); ?></td>
                                        <td class="title"><?php echo GetValueUser($this->tto_row->tto_owner_out, "name"); ?></td>                                       
                                        <td class="key"><?php echo JText::_('Confirm-Out'); ?></td>
                                        <td class="title"> 
										 <?php                                                                                  
                                                             if($this->tto_row->tto_owner_out_confirm==0 && $this->tto_row->tto_state=="Create"){
                                                    ?>                                                                                                     
                                                   <a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmtto&task=get_owner_confirm_tto&tto_id=<?php echo $this->tto_row->pns_tto_id?>&tmpl=component&tto_type_inout=2" title="Image">
                                                         <input onclick="return false;" onkeydown="return false;" type="checkbox" name="tto_owner_out_confirm" value="1" /></a>
                                                        <?php }
                                                        else
                                                        {
                                                                if($this->tto_row->tto_owner_out_confirm==1){
                                                                       ?>
                                                                <input checked="checked" onclick="return false;" onkeydown="return false;" type="checkbox" name="tto_owner_out_confirm" value="1" />
                                                                       <?php
                                                                }
                                                                else{
                                                                        ?>
                                                                        <input  onclick="return false;" onkeydown="return false;" type="checkbox" name="tto_owner_out_confirm" value="0" />
                                                                        <?php
                                                                }
                                                        }
                                                        ?>
                                        </td>  
                                        <td class="key"><?php echo JText::_('Date-Out'); ?></td>
                                        <td class="title"  ><?php echo ($this->tto_row->tto_owner_out_confirm_date!='0000-00-00 00:00:00')?JHTML::_('date', $this->tto_row->tto_owner_out_confirm_date, JText::_('DATE_FORMAT_LC5')):""; ?></td>  
				                                                                              
                                </tr>
                                <tr>
                                        <td class="key"><?php echo JText::_('Due Date'); ?></td>                                               
                                        <td class="title">  <?php echo ($this->tto_row->tto_due_date!='0000-00-00 00:00:00')?JHTML::_('date', $this->tto_row->tto_due_date, JText::_('DATE_FORMAT_LC5')):""; ?></td>  
                                        <td  class="key" ><?php echo JText::_(''); ?></td>
                                        <td class="title"><?php echo GetValueUser($this->tto_row->tto_owner_in, "name"); ?></td>                                       
                                        <td  class="key"><?php echo JText::_('Confirm-In'); ?></td>
                                        <td  class="title"> 
										 <?php                                                                                  
                                                             if($this->tto_row->tto_owner_in_confirm==0 && $this->tto_row->tto_state=="Using"){
                                                    ?>                                                                                                     
                                                   <a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmtto&task=get_owner_confirm_tto&tto_id=<?php echo $this->tto_row->pns_tto_id?>&tmpl=component&tto_type_inout=1" title="Image">
                                                         <input onclick="return false;" onkeydown="return false;" type="checkbox" name="tto_owner_in_confirm" value="1" /></a>
                                                        <?php }
                                                        else
                                                        {
                                                                 if($this->tto_row->tto_owner_in_confirm==1){
                                                                       ?>
                                                                <input checked="checked" onclick="return false;" onkeydown="return false;" type="checkbox" name="tto_owner_in_confirm" value="1" />
                                                                       <?php
                                                                 }
                                                                 else{
                                                                         ?>
                                                                         <input onclick="return false;" onkeydown="return false;" type="checkbox" name="tto_owner_in_confirm" value="0" />
                                                                         <?php 
                                                                 }
                                                        }
                                                        ?>
                                        </td>  
                                        <td  class="key"><?php echo JText::_('Date-In'); ?></td>
                                        <td  class="title"><?php echo ($this->tto_row->tto_owner_in_confirm_date!='0000-00-00 00:00:00')?JHTML::_('date', $this->tto_row->tto_owner_in_confirm_date, JText::_('DATE_FORMAT_LC5')):""; ?></td>                           
                                </tr>                                
                                <tr>
                                        <td class="key"><?php echo JText::_('WO'); ?></td>
                                        <td  class="title"><?php echo ($this->tto_row->wo_code)?$this->tto_row->wo_code:"NA";?></td>
                                        <td class="key"><?php echo JText::_('State'); ?></td>
                                        <td  class="title"><?php echo ($this->tto_row->tto_state)?$this->tto_row->tto_state:"NA";?></td>
                                </tr> 
                                <tr>
                                        <td class="key"><?php echo JText::_('Description'); ?></td>                                               
                                             <td colspan="5"><?php echo strtoupper($this->tto_row->tto_description); ?></td>
				                                                                              
                                </tr>  
        </table>                
        </fieldset>   
    <fieldset>
        <legend>Tools</legend>
        <div class="toolbar">
            <table class="toolbar"><tbody><tr>
                    <?php
                  //  if($this->tto_row->tto_owner_confirm==0 && !$this->tto_row->tto_owner) {
                        if (in_array("E", $role) && ($this->tto_row->tto_state == "Create")) {
                            ?>
                                     <td class="button" id="toolbar-addpnsave">
            Scan PN Barcode <input <?php echo $ttoonkeyUp?>  onkeyup="autoAddPartTto(this.value,'<?php echo $this->tto_row->pns_tto_id; ?>')" type="text"  name="pns_code" id="pns_code" value="" >
            <input <?php echo $ttoscanchecked?> type="checkbox" name="check_scan_barcode" value="1" onclick="checkforscantto(this.checked)" />
        </td>
                            <td class="button" id="toolbar-save">
                                <a href="#"
                                   onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Please make a selection from the list to save receiving part');}else{ hideMainMenu(); submitbutton('saveqtyTtofk')}"
                                   class="toolbar">
<span class="icon-32-save" title="Save">
</span>
                                    Save
                                </a>
                            </td>

<!--                            <td class="button" id="toolbar-popup-Popup">
                                <a class="modal"
                                   href="index.php?option=com_apdmtto&amp;task=get_list_pns_tto&amp;tmpl=component&amp;tto_id=<?php echo $this->tto_row->pns_tto_id; ?>&amp;tto_type_inout=1"
                                   rel="{handler: 'iframe', size: {x: 850, y: 500}}">
<span class="icon-32-new" title="Add Tool-In">
</span>
                                    Add Tool-In
                                </a>
                            </td>-->
                            <td class="button" id="toolbar-popup-Popup">
                                <a class="modal"
                                   href="index.php?option=com_apdmtto&amp;task=get_list_pns_tto&amp;tmpl=component&amp;tto_id=<?php echo $this->tto_row->pns_tto_id; ?>&amp;tto_type_inout=2"
                                   rel="{handler: 'iframe', size: {x: 850, y: 500}}">
<span class="icon-32-new" title="Add Tool-Out">
</span>
                                    Add Tool
                                </a>
                            </td>                            
                            <?php
                        }
                        if (in_array("D", $role) && ($this->tto_row->tto_state == "Create")) {
                            ?>
                            <td class="button" id="toolbar-Are you sure to delete it?">
                                <a href="#"
                                   onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Please make a selection from the list to delete');}else{if(confirm('Are you sure to delete it?')){submitbutton('removeAllpnsttos');}}"
                                   class="toolbar">
<span class="icon-32-delete" title="Tool">
</span>
                                    Remove Tools
                                </a>
                            </td>
                        <?php }
                    //}
                    ?>

                </tr></tbody></table></div>
        <?php if (count($this->tto_pn_list) > 0) { ?>
        <table class="adminlist" cellspacing="1" width="400">
            <thead>
            <tr>
                <th width="2%"><?php echo JText::_('NUM'); ?></th>
               <th width="3%" class="title">
					<input type="checkbox" name="toggle" value="" onclick="checkAllToolPn(<?php echo count($this->tto_pn_list); ?>);" />
		</th>
                <th width="100"><?php echo JText::_('Part Number'); ?></th>
                <th width="300"><?php echo JText::_('Description'); ?></th>
                <th width="100"><?php echo JText::_('UOM'); ?></th>
                <th width="100"><?php echo JText::_('MFG PN'); ?></th>
                <th width="100"><?php echo JText::_('QTY'); ?></th>
                <th width="100"><?php echo JText::_('Tool ID'); ?></th>
                <th width="100"><?php echo JText::_('Part State'); ?></th>
<!--                <th width="100"><?php //echo JText::_('Action'); ?></th>-->
                <th width="100"><?php //echo JText::_('Action'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php

            $locationArr = array();
            $location = TToController::GetLocationCodeList();
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

            $toolType   = array();
            $toolType[] = JHTML::_('select.option', '1', "IN" , 'value', 'text');
            $toolType[] = JHTML::_('select.option', '2', "OUT" , 'value', 'text');



            $i = 0;
            foreach ($this->tto_pn_list as $row) {                
                if($row->pns_cpn==1)
                    $link 	= 'index.php?option=com_apdmpns&amp;task=detailmpn&cid[0]='.$row->pns_id;
                else
                    $link 	= 'index.php?option=com_apdmpns&amp;task=detail&cid[0]='.$row->pns_id;
                $linkStoTab 	= 'index.php?option=com_apdmpns&task=sto&cid[]='.$row->pns_id;
                $image = TToController::GetImagePreview($row->pns_id);
                if ($image !=''){
                    $pns_image = "<img border=&quot;1&quot; src='".$path_image.$image."' name='imagelib' alt='".JText::_( 'No preview available' )."' width='100' height='100' />";
                }else{
                    $pns_image = JText::_('None image for preview');
                }
                $ttoList = TToController::GetTtoFrommPns($row->pns_id,$tto_id);
                if($row->pns_revision)
                    $pns_code = $row->ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision;
                else
                    $pns_code = $row->ccs_code.'-'.$row->pns_code;

                ?>
                <tr>
                    <td align="center"><?php echo $i+1; ?></td>
                    <td align="center">
                        <input type="checkbox" id = "toolpn<?php echo $i?>"  onclick="isCheckedPosPn(this.checked,'<?php echo $row->pns_id;?>','<?php echo implode(",",$ttoList);?>');" value="<?php echo $row->pns_id;?>_<?php echo implode(",",$ttoList);?>" name="cid[]"  />                                                
                    </td>
                    <td align="left"><span class="editlinktip hasTip" title="<?php echo $pns_image;?>" >
                                                    <a href="<?php echo $link;?>" title="<?php echo JText::_('Click to see detail PNs');?>"><?php echo $pns_code;?></a>
                                                </span></td>
                    <td align="left"><?php echo $row->pns_description; ?></td>
                    <td align="center"><?php echo $row->pns_uom; ?></td>
                    <td align="center">
                        <?php
                        $mf = TToController::GetManufacture($row->pns_id,4);
                        if (count($mf) > 0){
                            foreach ($mf as $m){
                                echo $m['v_mf'];
                            }
                        } ?>
                    </td>
                    <td align="center" colspan="5">

                        <table class="adminlist" cellspacing="0" width="200">
                            <?php
                            foreach ($this->tto_pn_list2 as $rw) {
                                if($rw->pns_id==$row->pns_id)
                                {
                                    ?>
                                    <tr><td align="center" width="74px">
                                            <span style="display:block" id="text_qty_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>"><?php echo $rw->qty;?></span>
                                            <input style="display:none;width: 70px" onKeyPress="return numbersOnlyEspecialFloat(this, event);" type="text" value="<?php echo ($rw->qty)?$rw->qty:1;?>" id="qty_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>"  name="qty_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>" />
                                        </td>
                                        <td align="center" width="77px">
                                            <span style="display:block" id="text_location_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>"><a href="<?php echo $linkStoTab;?>"><?php echo $rw->location?TToController::GetCodeLocation($rw->location):"";?></a></span>
                                            <?php
                                         //   if($rw->tto_type_inout==1)
                                        //    {
                                                echo JHTML::_('select.genericlist',   $locationArr, 'location_'.$row->pns_id.'_'.$rw->id, 'class="inputbox" style="display:none" size="1" ', 'value', 'text', $rw->location );
                                          //  }
                                           // else{
                                                ?><!--<span  id="ajax_location_<?php //echo $row->pns_id;?>_<?php echo $rw->id;?>">-->
                                                <?php
                                               // $locationArr = TToController::getLocationPartStatePn($rw->partstate,$row->pns_id);
                                             //   echo JHTML::_('select.genericlist',   $locationArr, 'location_'.$row->pns_id.'_'.$rw->id, 'class="inputbox" style="display:none" size="1" ', 'value', 'text', $rw->location );
                                                ?>
                                                <!-- </span>-->
                                                <?php
                                            //}
                                            ?>
                                        </td>
                                        <td align="center" width="77px">
                                            <span style="display:block" id="text_partstate_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>"><?php echo $rw->partstate?strtoupper($rw->partstate):"";?></span>
                                            <?php
                                            //if($rw->tto_type_inout==1)
                                          //  {
                                                echo JHTML::_('select.genericlist',   $partStateArr, 'partstate_'.$row->pns_id.'_'.$rw->id, 'class="inputbox" style="display:none" size="1" ', 'value', 'text', $rw->partstate );
                                         //   }
                                         //   else{
                                       //         $partStateArr = TToController::getPartStatePn($rw->partstate,$row->pns_id);
                                       //         echo JHTML::_('select.genericlist',   $partStateArr, 'partstate_'.$row->pns_id.'_'.$rw->id, 'class="inputbox" style="display:none" size="1" onchange="getLocationPartState('.$row->pns_id.','.$rw->id.','.$rw->location.',this.value);"', 'value', 'text', $rw->partstate );

                                       //     }

                                            ?>
                                        </td>
<!--                                        <td align="center" width="75px">
                                            <span style="display:block" id="text_tooltype_<?php //echo $row->pns_id;?>_<?php //echo $rw->id;?>"><?php //echo ($rw->tto_type_inout==1)?"IN":"OUT";?></span>                                               
                                        </td>-->
                                        <td align="center" width="75px">
                                            <?php
                                            if (in_array("D", $role) && ($this->tto_row->tto_state == "Create")) {
                                                ?>
                                                <a href="index.php?option=com_apdmtto&task=removepnstto&cid[]=<?php echo $rw->id;?>&tto_id=<?php echo $tto_id;?>" title="<?php echo JText::_('Click to see detail PNs');?>">Remove</a>
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
        <input type="hidden" name="tto_id" value="<?php echo $this->tto_row->pns_tto_id; ?>" />
        <input type="hidden" name="option" value="com_apdmtto" />
        <input type="hidden" name="id" value="<?php echo JRequest::getVar('id'); ?>" />     
	<input type="hidden" name="task" value="" />	
        <input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_('form.token'); ?>
</form>

