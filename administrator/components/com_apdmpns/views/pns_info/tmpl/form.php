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
	$editor = &JFactory::getEditor();
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
		if (form.ccs_code.value==0){
			alert("Please select Commodity Code");
			form.ccs_code.focus();
			return false;
		}
		if (form.pns_code.value=="" || !checkpnscode(form.pns_code.value)){
			alert("Please input Part Number Code Correctly (exp: xxxxxx no special character)");
			form.pns_code.focus();
			return false;
		}
		if (form.pns_revision.value =="" ){
			alert("Please input PNs Revision ");
			form.pns_revision.focus();
			return false;
		}
		
		if (form.pns_revision.value !="" && form.pns_revision.value.length != 2){
			alert("PNs Revision must 2 characters");
			form.pns_revision.focus();
			return false;
		}
		
		if (form.pns_version.value ==""){
			alert("Please input PNs Version ");
			form.pns_version.focus();
			return false;
		}
		
		if (form.pns_version.value !="" && form.pns_version.value.length != 2){
			alert("PNs Version must 2 characters");
			form.pns_version.focus();
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
		
		submitform( pressbutton );
	}
	function get_default_code(){		
		var ccs = document.getElementById('ccs_code').value;
		if (ccs == 0){
			alert("Please select Commodity Code");
			return false;
		}
		var url = 'index.php?option=com_apdmpns&task=code_default&ccs_code='+ccs;		
		
		var MyAjax = new Ajax(url, {
			method:'get',
			onComplete:function(result){				
				$('pns_code').value = result.trim();
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
		
		//for PNs _arent
	



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
						<input type="text" maxlength="6" onKeyPress="return numbersOnly(this, event);"  name="pns_code" id="pns_code" class="inputbox" size="20" value=""/>
						<input type="text" maxlength="2" onKeyPress="return numbersOnly(this, event);" name="pns_version" id="pns_version" class="inputbox" size="5" value="00" />
						<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="get_default_code();"><?php echo JText::_('DEFAULT_CODE')?></a>

					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_REVISION' ); ?>
						</label>
					</td>
					<td>
						<input type="text" name="pns_revision" id="pns_revision" onkeypress="return CharatersOnlyEspecial(this, event)" class="inputbox" size="6" maxlength="2" value="AA" />
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_CHILD' ); ?>
						</label>
					</td>
					<td valign="top">						
							<a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmpns&task=get_list_child&tmpl=component" title="Image">
<input type="button" name="addECO" value="<?php echo JText::_('Select PNS Child')?>"/>
</a>			
						<div id='pns_child'>
						</div>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_ECO' ); ?>
						</label>
					</td>
					<td>
					<input type="text" value="" name="eco_name" id="eco_name" readonly="readonly" />
					<input type="hidden" name="eco_id" id="eco_id" value="0" />
						<a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmeco&task=get_eco&tmpl=component" title="Image">
<input type="button" name="addECO" value="<?php echo JText::_('Select ECO')?>"/>
</a>
										
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
						<textarea name="pns_description" rows="10" cols="40"><?php echo $this->row->pns_description?></textarea>
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
		<legend><?php echo JText::_( 'Image, Pdf, CAD files' ); ?> <font color="#FF0000"><em><?php echo JText::_('(Please upload file less than 20Mb)')?></em></font></legend>
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
	<div class="col width-60">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Vendor' ); ?></legend>
		<p>	<a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmsuppliers&task=get_supplier&tmpl=component&type=2&pns_id=0" title="Image">
<input type="button" name="addVendor" value="<?php echo JText::_('Select Vendor')?>"/>
</a></p>
		
			<table class="admintable" cellspacing="1" width="400">
			<thead>
				<tr>
					<th width="50%"><?php echo JText::_( 'Vendor Name' ); ?></th>
					<th><?php echo JText::_( 'Vendor Pns' ); ?></th>
				</tr>
			</thead>
			<tbody id="vendor_get">
				
			</tbody>
			</table>
		
		</fieldset>
	</div>
	<div class="clr"></div>
	<div class="col width-60">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Supplier' ); ?></legend>
			<p>	<a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmsuppliers&task=get_supplier&tmpl=component&type=3&pns_id=0" title="Image">
<input type="button" name="addSupplier" value="<?php echo JText::_('Select Supplier')?>"/>
</a></p>
		<table class="admintable" cellspacing="1" width="400">
				<thead>
					<tr>						
						<th width="50%"><?php echo JText::_( 'Supplier Name' ); ?></th>
						<th><?php echo JText::_( 'Supplier PNs' ); ?></th>
					</tr>
				</thead>
				<tbody id="supplier_get">					
				</tbody>
				</table>
						
		</fieldset>
	</div>
	<div class="clr"></div>
	<div class="col width-60">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Manufacture' ); ?></legend>
			<p>	<a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmsuppliers&task=get_supplier&tmpl=component&type=4&pns_id=0" title="Image">
<input type="button" name="addManufacture" value="<?php echo JText::_('Select Manufacture')?>"/>
</a></p>
		<table class="admintable" cellspacing="1" width="400">
				<thead>
					<tr>
					<th width="50%"><?php echo JText::_( 'Manufacture Name' ); ?></th>
						<th><?php echo JText::_( 'Manufacture PNs' ); ?></th>
					</tr>
				</thead>
				<tbody id="manufacture_get">					
				</tbody>
				</table>
					
		</fieldset>
	</div>
	<div style="display:none"><?php
						// parameters : areaname, content, width, height, cols, rows
						echo $editor->display( 'text',  $row->text , '10%', '10', '10', '3' ) ;
						?></div>
	<input name="nvdid" value="<?php echo $this->lists['count_vd'];?>" type="hidden" />
	<input name="nspid" value="<?php echo $this->lists['count_sp'];?>" type="hidden" />
	<input name="nmfid" value="<?php echo $this->lists['count_mf'];?>" type="hidden" />
	<input type="hidden" name="pns_id" value="0" />
	<input type="hidden" name="cid[]" value="0" />
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
