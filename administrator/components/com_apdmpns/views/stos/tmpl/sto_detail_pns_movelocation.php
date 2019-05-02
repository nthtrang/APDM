<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php
$cid = JRequest::getVar('cid', array(0));
$edit = JRequest::getVar('edit', true);
$sto_id = JRequest::getVar('id');

JToolBarHelper::title($this->sto_row->sto_code, 'cpanel.png');
$role = JAdministrator::RoleOnComponent(8);      
if (in_array("W", $role)) {
        JToolBarHelper::addPnsStoLocation("Add Part", $this->sto_row->pns_sto_id);        
        JToolBarHelper::customX('saveqtyStofk_movelocation', 'save', '', 'Save', false);	
        
}
 
if($this->sto_row->sto_file){        
        JToolBarHelper::customX('download_sto', 'download', '', 'Download', false);
}
else
{
        JToolBarHelper::customX("Download", 'cannotdownload', '', 'Download', false);
}

 
                        
if (in_array("D", $role)) {
        JToolBarHelper::deletePns('Are you sure to delete it?',"removeAllpnsstoLocation","Remove Part");
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
                if (pressbutton == 'saveqtyStofk_movelocation') {
                        
                        submitform( pressbutton );
                        return;
                }                      
                if(pressbutton == 'removeAllpnsstoLocation')
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
                
//                document.getElementById('partstate_'+id+'_'+sti).style.visibility= 'visible';
//                document.getElementById('partstate_'+id+'_'+sti).style.display= 'block';
//                document.getElementById('text_partstate_'+id+'_'+sti).style.visibility= 'hidden';
//                document.getElementById('text_partstate_'+id+'_'+sti).style.display= 'none';         
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

                document.getElementById('qty_'+id+'_'+sti).style.visibility= 'hidden';
                document.getElementById('qty_'+id+'_'+sti).style.display= 'none';
                
                document.getElementById('location_'+id+'_'+sti).style.visibility= 'hidden';
                document.getElementById('location_'+id+'_'+sti).style.display= 'none';
//                document.getElementById('partstate_'+id+'_'+sti).style.visibility= 'hidden';
//                document.getElementById('partstate_'+id+'_'+sti).style.display= 'none';                
             });
                
                
	}
}        
function numbersOnlyEspecialy(myfield, e, dec){
       
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
        var url = 'index.php?option=com_apdmpns&task=ajax_getlocpn_partstate&partstate='+partState+'&pnsid='+pnsId+'&fkid='+fkId+'&currentloc='+currentLoc;
        var MyAjax = new Ajax(url, {
                method:'get',
                onComplete:function(result){
//                       /alert(result.trim());
                       document.getElementById('ajax_location_'+pnsId+'_'+fkId).innerHTML = result.trim();        
                        //$('#ajax_location_'+pnsId+'_'+fkId).value = result.trim();                                
                }
        }).request();
        
}

</script>
<div class="clr"></div>
<form action="index.php?option=com_apdmpns&task=stomanagement&t=<?php echo time();?>"  onsubmit="submitbutton('')"  method="post" name="adminForm" >	
<?php if (count($this->sto_pn_list) > 0) { ?>
                <table class="adminlist" cellspacing="1" width="400">
                        <thead>
                                <tr>
                                        <th width="2%"><?php echo JText::_('NUM'); ?></th>
                                        <th width="3%" class="title">
<!--					<input type="checkbox" name="CheckAll" value="0" onClick="checkboxBom(document.adminForm.pns_po)"/>-->
				</th>                                        
                                        <th width="100"><?php echo JText::_('Part Number'); ?></th>
                                        <th width="200"><?php echo JText::_('Description'); ?></th>
                                        <th width="100"><?php echo JText::_('UOM'); ?></th>  
                                        <th width="100"><?php echo JText::_('MFG PN'); ?></th>
                                        <th width="50"><?php echo JText::_('Source Qty'); ?></th>
                                        <th width="50"><?php echo JText::_('Destination Qty'); ?></th>
                                        <th width="100"><?php echo JText::_('Source Location'); ?></th>
                                        <th width="100"><?php echo JText::_('Destination Location'); ?></th>
                                        <th width="100"><?php echo JText::_('Part State'); ?></th>  
                                        <th width="100"><?php echo JText::_(''); ?></th>
                                </tr>
                        </thead>
                        <tbody>					
        <?php
        
        $locationArr = array();
        $location = PNsController::GetLocationCodeList();
        $locationArr[] = JHTML::_('select.option',0,"Select", 'value', 'text');   
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
        $partStateArr[] = JHTML::_('select.option', 'Prototype', "Prototype" , 'value', 'text'); 
        

        $i = 0;       
        foreach ($this->sto_pn_list as $row) {
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
                                 $stoList = PNsController::GetStoFrommPns($row->pns_id,$sto_id);
                                 if($row->pns_revision)
                                        $pns_code = $row->ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision;
                                else
                                        $pns_code = $row->ccs_code.'-'.$row->pns_code;
                                 
                                ?>
                                        <tr>
                                                <td align="center"><?php echo $i; ?></td>
                                                <td align="center">
                                                <input type="checkbox" id = "pns_po" onclick="isCheckedPosPn(this.checked,'<?php echo $row->pns_id;?>','<?php echo implode(",",$stoList);?>');" value="<?php echo $row->pns_id;?>_<?php echo implode(",",$stoList);?>" name="cid[]"  />
                                                </td>                                                
                                                <td align="left"><span class="editlinktip hasTip" title="<?php echo $pns_image;?>" >
					<a href="<?php echo $link;?>" title="<?php echo JText::_('Click to see detail PNs');?>"><?php echo $pns_code;?></a>
				</span></td>
                                                <td align="left"><?php echo $row->pns_description; ?></td>
                                                <td align="center"><?php echo $row->pns_uom; ?></td>
                                                <td align="center">
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
                                                <td align="center" colspan="6">

                                                                        <table class="adminlist" cellspacing="0" width="200">
                                                                                <?php
                                                                                foreach ($this->sto_pn_list2 as $rw) {
                                                                                        if ($rw->pns_id == $row->pns_id) {
                                                                                                ?>
                                                                                                <tr>
                                                                                                        <td align="center" width="74px">
                                                                                                                <span  id="source_qty_<?php echo $row->pns_id; ?>_<?php echo $rw->id; ?>"><?php echo $rw->qty_from;?> </span>
                                                                                                                <input onKeyPress="return numbersOnlyEspecialy(this, event);" type="hidden" value="<?php echo round($rw->qty_from - $rw->qty,2) ; ?>" id="source_qty_<?php echo $row->pns_id; ?>_<?php echo $rw->id; ?>"  name="source_qty_<?php echo $row->pns_id; ?>_<?php echo $rw->id; ?>" />                                                        
                                                                                                        </td>
                                                                                                         <td align="center" width="74px">
                                                                                                                <span style="display:block" id="text_qty_<?php echo $row->pns_id; ?>_<?php echo $rw->id; ?>"><?php echo $rw->qty; ?></span>
                                                                                                                <input style="display:none;width: 70px" onKeyPress="return numbersOnlyEspecialy(this, event);" type="text" value="<?php echo $rw->qty; ?>" id="qty_<?php echo $row->pns_id; ?>_<?php echo $rw->id; ?>"  name="qty_<?php echo $row->pns_id; ?>_<?php echo $rw->id; ?>" />                                                        
                                                                                                        </td>
                                                                                                          <td align="center" width="77px">					
                                                                                                                <span id="source_location_<?php echo $row->pns_id; ?>_<?php echo $rw->id; ?>"><?php echo $rw->location_from ? PNsController::GetCodeLocation($rw->location_from) : ""; ?></span>                                                                                                                                                                                                               
                                                                                                        </td>	
                                                                                                        <td align="center" width="77px">					
                                                                                                                <span style="display:block" id="text_location_<?php echo $row->pns_id; ?>_<?php echo $rw->id; ?>"><?php echo $rw->location ? PNsController::GetCodeLocation($rw->location) : ""; ?></span>
                                                                                                                <span  id="ajax_location_<?php echo $row->pns_id; ?>_<?php echo $rw->id; ?>">
                                                                                                                        <?php
                                                                                                                       // $locationArr = PNsController::getLocationPartStatePn($rw->partstate, $row->pns_id);
                                                                                                                        echo JHTML::_('select.genericlist', $locationArr, 'location_' . $row->pns_id . '_' . $rw->id, 'class="inputbox" style="display:none" size="1" ', 'value', 'text', $rw->location);
                                                                                                                        ?>
                                                                                                                </span> 
                                                                                               
                                                                                                        </td>	
                                                                                                        <td align="center" width="77px">					
                                                                                                                <span style="display:block" id="text_partstate_<?php echo $row->pns_id; ?>_<?php echo $rw->id; ?>"><?php echo $rw->partstate ? strtoupper($rw->partstate) : ""; ?></span>
                                                                                                                <?php
                                                                                                                $partStateArr = PNsController::getPartStatePn($rw->partstate, $row->pns_id);
                                                                                                                echo JHTML::_('select.genericlist', $partStateArr, 'partstate_' . $row->pns_id . '_' . $rw->id, 'class="inputbox" style="display:none" size="1" onchange="getLocationPartState(' . $row->pns_id . ',' . $rw->id . ',' . $rw->location . ',this.value);"', 'value', 'text', $rw->partstate);
                                                                                                                ?>
                                                                                                        </td>
                                                                                                        <td align="center" width="75px">					
                                                                                                                <a href="index.php?option=com_apdmpns&task=removepnsstos_movelocation&cid[]=<?php echo $rw->id; ?>&sto_id=<?php echo $sto_id; ?>" title="<?php echo JText::_('Click to see detail PNs'); ?>">Remove</a>
                                                                                                        </td>
                                                                                                </tr>
                                                                                                        
                                                                                                        <?php
                                                                                                }
                                                                                        }
                                                                                        ?>
                                                                        </table>
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

        <input type="hidden" name="sto_id" value="<?php echo $this->sto_row->pns_sto_id; ?>" />
        <input type="hidden" name="option" value="com_apdmpns" />     
        <input type="hidden" name="id" value="<?php echo JRequest::getVar('id'); ?>" />     
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_('form.token'); ?>
</form>
