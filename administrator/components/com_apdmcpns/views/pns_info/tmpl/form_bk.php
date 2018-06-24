<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

	JToolBarHelper::title( JText::_( 'PNS_MAMANGEMENT' ) . ': <small><small>[ '. $text .' ]</small></small>' , 'cpanel.png' );
	if (!intval($edit)) {
		JToolBarHelper::save('save', 'Save & Add new');
	}
	JToolBarHelper::apply('apply', 'Save');
	if ( $edit ) {
		// for existing items the button is renamed `close`
		JToolBarHelper::cancel( 'cancel', 'Close' );
	} else {
		JToolBarHelper::cancel();
	}
	$cparams = JComponentHelper::getParams ('com_media');
?>

<?php
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
		var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&]", "i");
		if (form.ccs_id.value==0){
			alert("Please select Commodity Code");
			form.css_id.focus();
			return false;
		}
		if (form.pns_code.value=="" || !checkpnscode(form.pns_code.value)){
			alert("Please input Part Number Code Correctly (exp: xxxxxx no special character)");
			form.pns_code.focus();
			return false;
		}
		if (form.eco_id.value==0){
			alert("Please select ECO");
			form.eco.focus();
			return false;
		}
		if (form.pns_revision.value !="" && form.pns_revision.value.length < 3){
			alert("PNs Revision must 3 characters");
			form.pns_revision.focus();
			return false;
		}
		if (form.pns_status.value==""){
			alert("Please select Part Number Status");
			from.pns_status.focus();
			return false;
		}
		

		///for check vendor
		var nvendor = form.nvdid.value;
		var check_vendor = 0;
		if(nvendor > 0){
			for(var i=0; i<nvendor; i++){
				var tamp = form.vendor_id[i].value;
				if (tamp !=0) {
					for(var j=i+1; j < nvendor; j++){
						if (form.vendor_id[j].value !=0) {
							if(tamp==form.vendor_id[j].value){
								check_vendor++;							
							}
						}
					}
				}
			}
		}
		if (check_vendor>0){
			alert("Please choose unique vendor. No more than Vendor the same");
			return false;
		}
		///forcheck supplier
		var nsupplier = form.nspid.value;
	
		var check_supplier = 0;
		if (nsupplier>0){
			for(var isp=0; isp < nsupplier; isp++){
				var tampsp = form.supplier_id[isp].value;
				if(tampsp !=0){
					for(var jsp=isp+1; jsp<nsupplier; jsp++){
						if(form.supplier_id[jsp].value !=0){
							if(tampsp == form.supplier_id[jsp].value){
								check_supplier++;
							}
						}
					}
				}
			}
		}
		if(check_supplier>0){
			alert("Please choose unique Supplier. No more than Supplier the same");
			return false;
		}
		///for check manufacture
		var nmf = form.nmfid.value;
		var check_mf = 0;
		if(nmf>0){
			for(imf=0; imf<nmf; imf++){
				var tampmf = form.manufacture_id[imf].value;
				if(tampmf !=0){
					for(jmf = imf+1; jmf<nmf; jmf++){
						if(form.manufacture_id[jmf].value !=0 ){
							if(tampmf == form.manufacture_id[jmf].value){
								check_mf++;
							}
						}
					}
				}
			}
		}
		if(check_mf>0){
			alert("Please choose unique Manufacture. No more than Manufacture the same");
			return false;
		}
		submitform( pressbutton );
	}
	function get_defautl_code(){
		var url = 'index.php?option=com_apdmpns&task=code_default';
		var MyAjax = new Ajax(url, {
			method:'get',
			onComplete:function(result){
				$('pns_code').value = result;
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
		});
		
			///for add more vendor
	window.addEvent('domready', function(){
			//File Input Generate
			var mid_v=0;			
			var mclick_v=1;
			$$(".listvendor span").each(function(itext,id) {
				if (mid_v!=0)
					itext.style.display = "none";
					mid_v++;
			});
			$('lnkvendor').addEvents ({				
				'click':function(){	
					if (mclick_v<mid_v) {
						$$(".listvendor span")[mclick_v].style.display="block";					
						mclick_v++;
					}
				}
			});	
		});
		
					///for add more supplier
	window.addEvent('domready', function(){
			//File Input Generate
			var mid_s=0;			
			var mclick_s=1;
			$$(".listsupplier span").each(function(itext,id) {
				if (mid_s!=0)
					itext.style.display = "none";
					mid_s++;
			});
			$('lnksupplier').addEvents ({				
				'click':function(){	
					if (mclick_s<mid_s) {
						$$(".listsupplier span")[mclick_s].style.display="block";					
						mclick_s++;
					}
				}
			});	
		});
					///for add more mf
	window.addEvent('domready', function(){
			//File Input Generate
			var mid_f=0;			
			var mclick_f=1;
			$$(".listmf span").each(function(itext,id) {
				if (mid_f!=0)
					itext.style.display = "none";
					mid_f++;
			});
			$('lnkmf').addEvents ({				
				'click':function(){	
					if (mclick_f<mid_f) {
						$$(".listmf span")[mclick_f].style.display="block";					
						mclick_f++;
					}
				}
			});	
		});

</script>

<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data" >
	<div class="col width-60">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'PNs Detail' ); ?></legend>
			<table class="admintable" cellspacing="1">
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'ASCENX_PNS' ); ?>
						</label>
					</td>
					<td><?php echo $this->lists['ccs'];?>
						<input type="text" maxlength="6"  name="pns_code" id="pns_code" class="inputbox" size="10" value=""/>
						<input type="text" maxlength="2" name="pns_version" id="pns_version" class="inputbox" size="5" value="00" />
						<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="get_defautl_code();"><?php echo JText::_('DEFAULT_CODE')?></a>

					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_REVISION' ); ?>
						</label>
					</td>
					<td>
						<input type="text" name="pns_revision" id="pns_revidion" class="inputbox" size="6" maxlength="3" />
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_PARENT' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->lists['pns_parent'];?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_ECO' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->lists['eco'];?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_TYPE' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->lists['pns_type']?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_DESCRIPTION' ); ?>
						</label>
					</td>
					<td>
						<textarea name="ccs_description" rows="10" cols="60"><?php echo $this->row->ccs_description?></textarea>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_STATUS' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->lists['status']?>
					</td>
				</tr>
				
				
			</table>
		</fieldset>
	</div>
	<div class="col width-40">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Image, Pdf, CAD files' ); ?></legend>
			<table class="admintable">
				<tr>
					<td class="key">
						<label for="ccs_create">
							<?php echo JText::_('IMAGE')?>
						</label>
					</td>
					<td>
						<input type="file" name="pns_imge" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="ccs_create">
							<?php echo JText::_('PDF')?>
						</label>
					</td>
					<td>
						<input type="file" name="pns_pdf" />
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="ccs_create">
							<?php echo JText::_('CAD')?>
						</label>
					</td>
					<td>
					<div class="iptfichier">
						<span id="1">
							<input type="file" name="pns_cad1" /> 
						</span>
						<span id="2">
							<input type="file" name="pns_cad2" /> 
						</span>
						<span id="3">
							<input type="file" name="pns_cad3" /> 
						</span>
						<span id="4">
							<input type="file" name="pns_cad4" /> 
						</span>
						<span id="5">
							<input type="file" name="pns_cad5" />
						</span>
						<span id="6">
							<input type="file" name="pns_cad6" /> 
						</span>
						<span id="7">
							<input type="file" name="pns_cad7" /> 
						</span>
						<span id="8">
							<input type="file" name="pns_cad8" /> 
						</span>
						<span id="9">
							<input type="file" name="pns_cad9" />
						</span>
						<span id="10">
							<input type="file" name="pns_cad10" />
						</span>
						<span id="11">
							<input type="file" name="pns_cad11" /> 
						</span>
						<span id="12">
							<input type="file" name="pns_cad12" /> 
						</span>
						<span id="13">
							<input type="file" name="pns_cad13" /> 
						</span>
						<span id="14">
							<input type="file" name="pns_cad14" /> 
						</span>
						<span id="15">
							<input type="file" name="pns_cad15" /> 
						</span>
						<span id="16">
							<input type="file" name="pns_cad16" /> 
						</span>
						<span id="17">
							<input type="file" name="pns_cad17" /> 
						</span>
						<span id="18">
							<input type="file" name="pns_cad18" /> 
						</span>
						<span id="19">
							<input type="file" name="pns_cad19" /> 
						</span>
						<span id="20">
							<input type="file" name="pns_cad20" /> 
						</span>
					</div>
						<br />
						<a href="javascript:;"id="lnkfichier" title="Add more file CAD" ><?php echo JText::_('Click here to add more CAD files');?></a>
					</td>
				</tr>
							
			</table>
		</fieldset>		
	</div>
	<div class="clr"></div>
	
	<div class="col width-30">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Vendor' ); ?></legend>
		<div class="listvendor">
					<?php
						for($i=1; $i<=$this->lists['count_vd']; $i++){
							?>
							<span id="<?php echo $i?>">
							<?php echo $this->lists['vd'];?> <input type="text" value="" name="vendor_info[]" />
							</span>
							<?php							
						}

					?>						
					</div>
					<br />
					<?php if($this->lists['count_vd'] > 0) {?>
						<a href="javascript:;"id="lnkvendor" title="Add moreVendor" ><?php echo JText::_('Click here to add more Vendor');?></a>
					<?php }else { echo JText::_('THERE_IS_NO_VENDOR_TO_ADD');?>
					<input type="hidden" name="" id="lnkvendor" />
					<?PHP } ?>
		</fieldset>
	</div>
	<div class="col width-30">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Supplier' ); ?></legend>
			<div class="listsupplier">
						<?php
						for($i=1; $i<=$this->lists['count_sp']; $i++){
							?>
							<span id="<?php echo $i?>">
							<?php echo $this->lists['spp'];?> <input type="text" value="" name="spp_info[]" />
							</span>
							<?php							
						}

					?>		
					</div>
					<br />
					<?php if($this->lists['count_sp'] > 0) {?>
						<a href="javascript:;"id="lnksupplier" title="Add more Supplier" ><?php echo JText::_('Click here to add more Supplier');?></a>
					<?php } else { echo JText::_('THERE_IS_NO_SUPPLIER_TO_ADD');?>
					<input type="hidden" name="" id="lnksupplier" />
					<?	
					} ?>
		</fieldset>
	</div>
	<div class="col width-30">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Manufacture' ); ?></legend>
		<div class="listmf">
					<?php
						for($i=1; $i<=$this->lists['count_mf']; $i++){
							?>
							<span id="<?php echo $i?>">
							<?php echo $this->lists['mf'];?> <input type="text" value="" name="mf_info[]" />
							</span>
							<?php							
						}

					?>	
					</div>
					<br />
					<?php if($this->lists['count_mf'] > 0) {?>
						<a href="javascript:;"id="lnkmf" title="Add more Manufacture" ><?php echo JText::_('Click here to add more Manufacture');?></a><?php }else { echo JText::_('THERE_IS_NO_MANUFACTURE_TO_ADD');?>
						<input type="hidden" name="" id="lnkmf" />
						<?php } ?>
		</fieldset>
	</div>

	<input name="nvdid" value="<?php echo $this->lists['count_vd'];?>" type="hidden" />
	<input name="nspid" value="<?php echo $this->lists['count_sp'];?>" type="hidden" />
	<input name="nmfid" value="<?php echo $this->lists['count_mf'];?>" type="hidden" />
	<input type="hidden" name="pns_id" value="0" />
	<input type="hidden" name="cid[]" value="0" />
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
