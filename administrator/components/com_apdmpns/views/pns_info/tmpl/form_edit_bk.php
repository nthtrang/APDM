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
	JToolBarHelper::apply('edit_pns', 'Save');
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
		if (form.pns_revision.value !="" && form.pns_revision.value.length < 3){
			alert("PNs Revision must 3 characters");
			form.pns_revision.focus();
			return false;
		}		
		if (form.eco_id.value==0){
			alert("Please select ECO");
			form.eco.focus();
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
		
		//for PNs _arent
		window.addEvent('domready', function(){
			//File Input Generate
			var pns_parent=0;			
			var mclick_pns=1;
			$$(".pns_parent span").each(function(itext,id) {
				if (pns_parent!=0)
					itext.style.display = "none";
					pns_parent++;
			});
			$('lnkpnsparent').addEvents ({				
				'click':function(){	
					if (mclick_pns<pns_parent) {
						$$(".pns_parent span")[mclick_pns].style.display="block";					
						mclick_pns++;
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
					<td><?php echo PNsController::GetNameCCs($this->row->ccs_id).'-'.$this->row->pns_code;?>
						<input type="hidden"  name="pns_code" id="pns_code"  size="10" value="<?php echo $this->row->pns_code;?>"/>
						<input type="hidden" name="ccs_id" value="<?php echo $this->row->ccs_id;?>" />
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_REVISION' ); ?>
						</label>
					</td>
					<td>
						<input type="text" value="<?php echo $this->row->pns_revision;?>" name="pns_revision" id="pns_revidion" class="inputbox" size="6" maxlength="3" />
						<input type="hidden" value="<?php echo $this->row->pns_revision;?>" name="pns_revision_old" />
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_PARENT' ); ?>
						</label>
					</td>
					<td valign="top">
						<?php 
							if (count($this->lists['pns_parent_info']) > 0) {
								foreach ($this->lists['pns_parent_info'] as $pns_parent) { 
								  $link_ = 'index.php?option=com_apdmpns&task=remove_parent&id='.$pns_parent['id'].'&idpns='.$this->row->pns_id;
								?>
								<p> <?php echo $pns_parent['pns_code'];?>&nbsp;&nbsp;<a href="<?php echo $link_;?>" title="<?php echo JText::_('Click here to remove this parent of PNS')?>"> Remove </a></p>

							<?php	}
							}
						?>
						<?php //echo $this->lists['pns_parent'];?>
						<div class="pns_parent">
						<span id="1">
						<input type="text" value="" onKeyPress="return numbersOnlyEspecial(this, event);" name="pns_parent[]" />
						</span>
						<span id="2">
						<input type="text" value="" onKeyPress="return numbersOnlyEspecial(this, event);" name="pns_parent[]" />
						</span>
						<span id="3">
						<input type="text" value="" onKeyPress="return numbersOnlyEspecial(this, event);" name="pns_parent[]" />
						</span>
						<span id="4">
						 <input type="text" value="" onKeyPress="return numbersOnlyEspecial(this, event);" name="pns_parent[]" />	
						</span>
						<span id="5">
						<input type="text" value="" onKeyPress="return numbersOnlyEspecial(this, event);" name="pns_parent[]" />
						</span>
						<span id="6">
						<input type="text" value="" onKeyPress="return numbersOnlyEspecial(this, event);" name="pns_parent[]" />
						</span>
						<span id="7">
						<input type="text" value="" onKeyPress="return numbersOnlyEspecial(this, event);" name="pns_parent[]" />						
						</span>
						<span id="8">
						<input type="text" value="" onKeyPress="return numbersOnlyEspecial(this, event);" name="pns_parent[]" />
						</span>
						<span id="9">
						<input type="text" value="" onKeyPress="return numbersOnlyEspecial(this, event);" name="pns_parent[]" />
						</span>
						<span id="10">
						<input type="text" value="" onKeyPress="return numbersOnlyEspecial(this, event);" name="pns_parent[]" />
						</span>						
					</div>
						<br />
						<a href="javascript:;"id="lnkpnsparent" title="Add more pns parent" ><?php echo JText::_('Add more pns parent');?></a>
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
						<textarea name="pns_description" rows="10" cols="60"><?php echo $this->row->pns_description?></textarea>
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
						<input type="hidden" name="old_pns_image" value="<?php echo $this->row->pns_image;?>" />
					</td>
				</tr>
				<?php if ($this->row->pns_image !="") {?>
				<tr>
					<td colspan="2" align="center">
					<img src="../uploads/pns/images/<?php echo $this->row->pns_image?>" width="200" height="100"  />
					<a href="index.php?option=com_apdmpns&task=remove_img&id=<?php echo $this->row->pns_id?>"  title="Click here to remove" >Remove</a>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<td class="key">
						<label for="ccs_create">
							<?php echo JText::_('PDF')?>
						</label>
					</td>
					<td>
						<input type="file" name="pns_pdf" />
						<input type="hidden" name="old_pns_pdf" value="<?php echo $this->row->pns_pdf;?>" />
					</td>
				</tr>
				<?php if ($this->row->pns_pdf !="") {?>
				<tr>
					<td colspan="2" align="center"><a href="index.php?option=com_apdmpns&task=download&id=<?php echo $this->row->pns_id?>" title="Click here to download file"><?php echo $this->row->pns_pdf;?></a>&nbsp;&nbsp;					
					<a href="index.php?option=com_apdmpns&task=remove_pdf&id=<?php echo $this->row->pns_id?>" title="Click here to remove" >Remove</a>
					</td>
				</tr>
				<?php } ?>
				<?php if (count($this->lists['cads_files']) > 0) {
				?>
				<tr>
					<td colspan="2" align="center">
					<table>
						<tr>
							<td><strong><?php echo JText::_('No.')?></strong></td>
							<td><strong><?php echo JText::_('Name File CAD')?> </strong></td>
							<td><strong><?php echo JText::_('Download CAD')?></strong></td>
							<td><strong><?php echo JText::_('Remove')?></strong></td>
						</tr>
				<?php
				
				$i = 1;
				foreach ($this->lists['cads_files'] as $cad) {
				?>
				<tr>
					<td><?php echo $i?></td>
					<td><?php echo $cad['cad_file']?></td>
					<td><a href="index.php?option=com_apdmpns&task=download_cad&id=<?php echo $cad['id']?>" title="Click here to download file">Download</a></td>
					<td><a href="index.php?option=com_apdmpns&task=remove_cad&id=<?php echo $cad['id']?>" title="Click to remove">Remove</a></td>
				</tr>
				<?php $i++; } ?>
				
				<tr>
					<td></td>
					<td></td>
					<td>
					<input type="button" value="Download All Files" onclick="window.location.href='../uploads/pns/cads/zip.php?step=1&zdir=124-000qqq-00-XX0'" />
					<!--<input type="button" value="<?php //echo JText::_('Download All Files')?>" onclick="window.location.href='index.php?option=com_apdmpns&task=download_cad_all_pns&pns_id=<?php //echo $this->row->pns_id?>'" />--></td>
					<td><input type="button" value="<?php echo JText::_('Remove All Files')?>" onclick="window.location.href='index.php?option=com_apdmpns&task=remove_all_cad&pns_id=<?php echo $this->row->pns_id?>'" /></td>					
				</tr>
				
					</table>
					</td>
				</tr>
				<?php } ?>
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
		<?php if (count($this->lists['arr_v']) > 0) {
				foreach($this->lists['arr_v'] as $v) {
		 ?>			<p><input type="hidden" name="v_exist[]" value="<?php echo $v['id']?>" ><input type="hidden" name="v_exist_id[]" value="<?php echo $v['v_id']?>" ><?php echo $v['v_name']?> <input type="text" value="<?php echo $v['v_value'];?>" name="v_exist_value[]" /> &nbsp;<a href="index.php?option=com_apdmpns&task=remove_info&id=<?php echo $v['id']?>&pns_id=<?php echo $this->row->pns_id?>" title="Click to remove"><?php echo JText::_('Remove_Vendor')?></a></p>
		<?php }
		 } ?>
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
		<?php if (count($this->lists['arr_s']) > 0) {
				foreach($this->lists['arr_s'] as $s) {
		 ?>			<p><input type="hidden" name="s_exist[]" value="<?php echo $s['id']?>" ><input type="hidden" name="s_exist_id[]" value="<?php echo $s['s_id']?>" ><?php echo $s['s_name']?> <input type="text" value="<?php echo $s['s_value'];?>" name="s_exist_value[]" />&nbsp;<a href="index.php?option=com_apdmpns&task=remove_info&id=<?php echo $s['id']?>&pns_id=<?php echo $this->row->pns_id?>" title="Click to remove"><?php echo JText::_('Remove_Supplier')?></a></p>
		<?php }
		 } ?>
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
					<?php }else{ echo JText::_('THERE_IS_NO_SUPPLIER_TO_ADD'); 
						echo '<input type="hidden" name="" id="lnksupplier" />';

					} ?>
		</fieldset>
	</div>
	<div class="col width-30">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Manufacture' ); ?></legend>
		<?php if (count($this->lists['arr_m']) > 0) {
				foreach($this->lists['arr_m'] as $m) {
		 ?>			<p><input type="hidden" name="m_exist[]" value="<?php echo $m['id']?>" ><input type="hidden" name="m_exist_id[]" value="<?php echo $m['m_id']?>" ><?php echo $m['m_name']?> <input type="text" value="<?php echo $m['m_value'];?>" name="m_exist_value[]" /> &nbsp;<a href="index.php?option=com_apdmpns&task=remove_info&id=<?php echo $m['id']?>&pns_id=<?php echo $this->row->pns_id?>" title="Click to remove"><?php echo JText::_('Remove_Manufacture')?></a></p>
		<?php }
		 } ?>
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
	<input type="hidden" name="pns_id" value="<?php echo $this->row->pns_id;?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->row->pns_id;?>" />	
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="return" value="<?php echo $this->cd;?>"  />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
