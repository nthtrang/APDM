<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php JHTML::_('behavior.modal'); ?>

<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);	
        $sto_id = JRequest::getVar('id');
	$role = JAdministrator::RoleOnComponent(8);	
	JToolBarHelper::title($this->sto_row->sto_code .': <small><small>[ view ]</small></small>' , 'generic.png' );
    $folder_sto = $this->sto_row->sto_code;
	if (in_array("E", $role)&& ($this->sto_row->sto_state  != "Done")) {
                JToolBarHelper::customX("editito",'edit',"Edit","Edit",false);
	}
        //for PPN part
       /* if (in_array("E", $role) && ($this->sto_row->sto_state  != "Done")) {
            $allow_edit = 1;
            JToolBarHelper::customX('saveqtyStofk', 'save', '', 'Save Receiving Part');
        }
        if (in_array("W", $role)&& ($this->sto_row->sto_state  != "Done")) {
                JToolBarHelper::addPnsSto("Add Part", $this->sto_row->pns_sto_id);        
        }                     
        if (in_array("D", $role) && ($this->sto_row->sto_state  != "Done")) {
                JToolBarHelper::deletePns('Are you sure to delete it?',"removeAllpnsstos","Remove Part");
                //JToolBarHelper::deletePns('Are you sure to delete it?',"deletesto","Delete ITO");
                JToolBarHelper::customXDel( 'Are you sure to delete it?', 'deletesto', 'delete', 'Delete ITO');
        }     */
        //end PN part
        
        JToolBarHelper::customX("printitopdf","print",'',"Print",false);
        JToolBarHelper::cancel( 'cancel', 'Close' );
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
                if (pressbutton == 'editito') {
                        submitform( pressbutton );
                        return;
                }
                if (pressbutton == 'editmpn') {
                        submitform( pressbutton );
                        return;
                }
                if (pressbutton == 'printitopdf') {
                    //window.location = "index.php?option=com_apdmpns&task=printwopdf&id="+form.wo_id.value + "&tmpl=component";
                    var url = "index.php?option=com_apdmsto&task=printitopdf&id="+form.sto_id.value + "&tmpl=component";
                    window.open(url, '_blank');
                    return;
                }
                if (pressbutton == 'saveqtyStofk') {
                        submitform( pressbutton );
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
                document.getElementById('partstate_'+id+'_'+sti).style.visibility= 'hidden';
                document.getElementById('partstate_'+id+'_'+sti).style.display= 'none';                
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
 ///for add more file
	window.addEvent('domready', function(){
			//File Input Generate
			var mid=0;			
			var mclick=1;
			$$(".iptfichier span").each(function(itext,id) {
				if (mid!=0)
					itext.style.display = "none";
					mid++;
			});
			$('lnkfichier').addEvents ({				
				'click':function(){	
					if (mclick<mid) {
						$$(".iptfichier span")[mclick].style.display="block";
					//	alert($$(".iptfichier input")[mclick].style.display);
						mclick++;
					}
				}
			});	
                        
                        //for image
                        //File Input Generate
			var mid=0;			
			var mclick=1;
			$$(".iptfichier_image span").each(function(itext,id) {
				if (mid!=0)
					itext.style.display = "none";
					mid++;
			});
			$('lnkfichier_image').addEvents ({				
				'click':function(){	
					if (mclick<mid) {
						$$(".iptfichier_image span")[mclick].style.display="block";
					//	alert($$(".iptfichier input")[mclick].style.display);
						mclick++;
					}
				}
			});	
                        //for pdf
                        //File Input Generate
			var mid=0;			
			var mclick=1;
			$$(".iptfichier_pdf span").each(function(itext,id) {
				if (mid!=0)
					itext.style.display = "none";
					mid++;
			});
			$('lnkfichier_pdf').addEvents ({				
				'click':function(){	
					if (mclick<mid) {
						$$(".iptfichier_pdf span")[mclick].style.display="block";
					//	alert($$(".iptfichier input")[mclick].style.display);
						mclick++;
					}
				}
			});	                        
		});               
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
                        <li><a id="bom" href="index.php?option=com_apdmsto&task=ito_detail_support_doc&id=<?php echo $this->sto_row->pns_sto_id;?>"><?php echo JText::_( 'SUPPORTING DOC' ); ?></a></li>                      
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
        <fieldset class="adminform">
		<legend><?php echo JText::_( 'ITO Detail' ); ?></legend>        
        <table class="admintable" cellspacing="1"  width="70%">
                              <tr>
                                        <td class="key" width="28%"><?php echo JText::_('ITO'); ?></td>                                               
                                        <td width="30%" class="title"><?php echo $this->sto_row->sto_code; ?></td>                                          
                                        <td class="key" width="18%"><?php echo JText::_('Supplier'); ?></td>                                               
                                        <td width="30%" class="title"><?php echo SToController::GetSupplierName($this->sto_row->sto_supplier_id);?></td>
				                                                                              
                                </tr>
                                <tr>
                                        <td  class="key" width="28%"><?php echo JText::_('P.O Internal'); ?></td>                                               
                                        <td width="30%" class="title"><?php echo $this->sto_row->sto_po_internal;?></td>                                        
									   <td  class="key" width="28%"><?php echo JText::_('State'); ?></td>
									   <td width="30%" class="title"><?php echo $this->sto_row->sto_state;?></td>
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
                                             <td colspan="3"><?php echo $this->sto_row->sto_description; ?></td>                                 
				                                                                              
                                </tr>  
        </table>                
        </fieldset>
<fieldset class="adminform">		 
		<legend><?php echo JText::_( 'Document' ); ?> <font color="#FF0000"><em><?php //echo JText::_('(Please upload file less than 20Mb)')?></em></font></legend>
                <table class="adminlist">                        
              <?php if (isset($this->lists['image_files'])&& count($this->lists['image_files'])>0) {?>
				<tr>
                                        <td colspan="2" >
					<table width="100%"  class="adminlist" cellpadding="1">
						
						<thead>
							<th colspan="4"><?php echo JText::_('List Images')?></th>
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
					<td><img src="../uploads/sto/<?php echo $folder_sto . DS?>/images/<?php echo $image['image_file']?>" width="200" height="100"  /></td>
					<td><?php echo number_format($filesize, 0, '.', ' '); ?></td>
					<td><a href="index.php?option=com_apdmsto&task=download_doc_sto&type=images&sto_id=<?php echo $this->sto_row->pns_sto_id?>&id=<?php echo $image['id']?>" title="Click here to download file"><img src="images/download_f2.png" width="20" height="20" /></a>&nbsp;&nbsp;
                                                <?php
                                               if ($this->sto_row->sto_state  != "Done") {                       
                                                ?>
					<a href="index.php?option=com_apdmsto&task=remove_doc_sto&back=ito_detail&type=images&sto_id=<?php echo $this->sto_row->pns_sto_id?>&id=<?php echo $image['id']?>&remove=<?php echo $i.time();?>" title="Click to remove" onclick="if ( confirm('Are you sure to delete it ? ') ) { return true;} else {return false;} "><img src="images/cancel_f2.png" width="15" height="15" /></a>
                                         <?php
                                               }
                                                ?>
                                        </td>
				</tr>
				<?php $i++; } ?>
				
				<tr>
					
					<td colspan="4" align="center">
					<a href="index.php?option=com_apdmsto&task=download_all_doc_sto&type=images&tmpl=component&sto_id=<?php echo $this->sto_row->pns_sto_id;?>" title="Download All Files">
                                        <input type="button" name="addVendor" value="<?php echo JText::_('Download All Files')?>"/>
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
					<a href="index.php?option=com_apdmsto&task=remove_doc_sto&back=ito_detail&type=pdfs&sto_id=<?php echo $this->sto_row->pns_sto_id?>&id=<?php echo $pdf['id']?>&remove=<?php echo $i.time();?>" title="Click to remove" onclick="if ( confirm('Are you sure to delete it ? ') ) { return true;} else {return false;} "><img src="images/cancel_f2.png" width="15" height="15" /></a>
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
					<a href="index.php?option=com_apdmsto&task=remove_doc_sto&back=ito_detail&type=zips&sto_id=<?php echo $this->sto_row->pns_sto_id?>&id=<?php echo $cad['id']?>&remove=<?php echo $i.time();?>" title="Click to remove" onclick="if ( confirm('Are you sure to delete it ? ') ) { return true;} else {return false;} "><img src="images/cancel_f2.png" width="15" height="15" /></a>
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
                <legend>Receiving Part</legend>
            <div class="toolbar">
            <table class="toolbar"><tbody><tr>
<?php
if (in_array("W", $role)&& ($this->sto_row->sto_state  != "Done")) {
    ?>
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
           href="index.php?option=com_apdmpns&amp;task=get_list_pns_sto&amp;tmpl=component&amp;sto_id=<?php echo $this->sto_row->pns_sto_id; ?>"
           rel="{handler: 'iframe', size: {x: 850, y: 500}}">
<span class="icon-32-new" title="Add Part">
</span>
            Add Part
        </a>
    </td>
    <?php
}
if (in_array("D", $role)&& ($this->sto_row->sto_state  != "Done")) {
    ?>
                    <td class="button" id="toolbar-Are you sure to delete it?">
                        <a href="#" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Please make a selection from the list to delete');}else{if(confirm('Are you sure to delete it?')){submitbutton('removeAllpnsstos');}}" class="toolbar">
<span class="icon-32-delete" title="Remove Part">
</span>
                            Remove Part
                        </a>
                    </td>
                    <?php }?>

                </tr></tbody></table></div>
                <?php if (count($this->sto_pn_list) > 0) { ?>
                <table class="adminlist" cellspacing="1" width="400">
                        <thead>
                                <tr>
                                        <th width="18"><?php echo JText::_('No'); ?></th>                                               
                                        <th width="3%" class="title"></th>
                                        <th width="100"><?php echo JText::_('Part Number'); ?></th>
                                        <th width="100"><?php echo JText::_('Description'); ?></th>  
                                        <th width="100"><?php echo JText::_('UOM'); ?></th>  
                                        <th width="100"><?php echo JText::_('Manufacture PN'); ?></th>  
                                        <th width="100"><?php echo ($this->sto_row->sto_type==1)?JText::_('Qty In'):JText::_('Qty Out'); ?></th>
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
                $i++;
                                if($row->pns_cpn==1)
                                        $link 	= 'index.php?option=com_apdmpns&amp;task=detailmpn&cid[0]='.$row->pns_id;	
                                else
                                        $link 	= 'index.php?option=com_apdmpns&amp;task=detail&cid[0]='.$row->pns_id;					
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
                                                <td><?php echo $i; ?></td>         
                                                <td>					
                                                <input type="checkbox" id = "pns_po" onclick="isCheckedPosPn(this.checked,'<?php echo $row->pns_id;?>','<?php echo implode(",",$stoList);?>');" value="<?php echo $row->pns_id;?>_<?php echo implode(",",$stoList);?>" name="cid[]"  />
                                                </td>                                                
                                                <td><span class="editlinktip hasTip" title="<?php echo $pns_image;?>" >
					<a href="<?php echo $link;?>" title="<?php echo JText::_('Click to see detail PNs');?>"><?php echo $pns_code;?></a>
				</span></td>
                                                <td><?php echo $row->pns_description; ?></td>
                                                <td><?php echo $row->pns_uom; ?></td>
                                                <td>
                                                <?php
                                                 $mf = SToController::GetManufacture($row->pns_id,4);
                                                if (count($mf) > 0){
                                                        foreach ($mf as $m){
                                                                echo $m['v_mf'];
                                                        }					
                                                } ?>
                                                </td> 
                                                <td colspan="4">  
                                                        
                                                        <table class="adminlist" cellspacing="0" width="200">
                                                                <?php 
                                                                foreach ($this->sto_pn_list2 as $rw) {
                                                                        if($rw->pns_id==$row->pns_id)
                                                                        {                                                                                
                                                                ?>
                                                                <tr><td align="center" width="74px">
                                                        <span style="display:block" id="text_qty_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>"><?php echo $rw->qty;?></span>
                                                        <input style="display:none;width: 70px" onKeyPress="return numbersOnlyEspecialFloat(this, event);" type="text" value="<?php echo $rw->qty;?>" id="qty_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>"  name="qty_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>" />                                                        
                                                </td> 
                                                <td align="center" width="77px">					
                                                        <span style="display:block" id="text_location_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>"><?php echo $rw->location?SToController::GetCodeLocation($rw->location):"";?></span>
                                                       <?php 
                                                        if($rw->sto_type==1)
                                                         {
                                                                echo JHTML::_('select.genericlist',   $locationArr, 'location_'.$row->pns_id.'_'.$rw->id, 'class="inputbox" style="display:none" size="1" ', 'value', 'text', $rw->location ); 
                                                         }
                                                         else{
															 ?><span  id="ajax_location_<?php echo $row->pns_id;?>_<?php echo $rw->id;?>">
															 <?php 
                                                                 $locationArr = SToController::getLocationPartStatePn($rw->partstate,$row->pns_id);
                                                                echo JHTML::_('select.genericlist',   $locationArr, 'location_'.$row->pns_id.'_'.$rw->id, 'class="inputbox" style="display:none" size="1" ', 'value', 'text', $rw->location ); 
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
                                                                echo JHTML::_('select.genericlist',   $partStateArr, 'partstate_'.$row->pns_id.'_'.$rw->id, 'class="inputbox" style="display:none" size="1" ', 'value', 'text', $rw->partstate ); 
                                                         }
                                                         else{                                                                 
                                                                 $partStateArr = SToController::getPartStatePn($rw->partstate,$row->pns_id);
                                                                 echo JHTML::_('select.genericlist',   $partStateArr, 'partstate_'.$row->pns_id.'_'.$rw->id, 'class="inputbox" style="display:none" size="1" onchange="getLocationPartState('.$row->pns_id.','.$rw->id.','.$rw->location.',this.value);"', 'value', 'text', $rw->partstate ); 
                                                                 
                                                         }
                                                        
                                                        ?>
                                                </td>
                                                <td align="center" width="75px">	
                                                          <?php
                                             if ($this->sto_row->sto_state  != "Done") {                  
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
                                                <?php }
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

