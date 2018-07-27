<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit', true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

	JToolBarHelper::title( JText::_( 'Role' ) . ': <small><small>[ '. $text .' ]</small></small>' , 'config.png' );
	JToolBarHelper::save('save', 'save & add new');
	JToolBarHelper::apply('apply', 'save');
	if ( $edit ) {
		// for existing items the button is renamed `close`
		JToolBarHelper::cancel( 'cancel', 'Close' );
	} else {
		JToolBarHelper::cancel();
	}
	//for Commodity code
	$cc1 = 0;
	$cc2 = 0;
	$cc3 = 0;
	$cc4 = 0;
	$cc5 = 0;
	$ccall =0;
	if(count($this->arrCC) > 0){
		foreach ($this->arrCC as $cc){
			if ($cc=='V') { $cc1=1; $ccall++;}
			if ($cc=='W') { $cc2=1; $ccall++;}
			if ($cc=='E') { $cc3=1; $ccall++;}
			if ($cc=='D') { $cc4=1; $ccall++;}
			if ($cc=='R') { $cc5=1; $ccall++;}

		}
	}

	//for Vendor
	$vd1 = 0;
	$vd2 = 0;
	$vd3 = 0;
	$vd4 = 0;
	$vd5 = 0;
	$vdall = 0;
	if(count($this->arrVendor) > 0){
		foreach ($this->arrVendor as $vd){
			if ($vd=='V') {$vd1=1; $vdall++;}
			if ($vd=='W') {$vd2=1; $vdall++;}
			if ($vd=='E') {$vd3=1; $vdall++;}
			if ($vd=='D') {$vd4=1; $vdall++;}
			if ($vd=='R') {$vd5=1; $vdall++;}

		}
	}
	//for SUpplier
	/*$sp1 = 0;
	$sp2 = 0;
	$sp3 = 0;
	$sp4 = 0;
	$sp5 = 0;
	if(count($this->arrSupplier) > 0){
		foreach ($this->arrSupplier as $sp){
			if ($sp=='V') $sp1=1;
			if ($sp=='W') $sp2=1;
			if ($sp=='E') $sp3=1;
			if ($sp=='D') $sp4=1;
			if ($sp=='R') $sp5=1;

		}
	}*/
	//for manufacture
	/*$mf1 = 0;
	$mf2 = 0;
	$mf3 = 0;
	$mf4 = 0;
	$mf5 = 0;
	if(count($this->arrManufacture) > 0){
		foreach ($this->arrManufacture as $mf){
			if ($mf=='V') $mf1=1;
			if ($mf=='W') $mf2=1;
			if ($mf=='E') $mf3=1;
			if ($mf=='D') $mf4=1;
			if ($mf=='R') $mf5=1;

		}
	}*/
	//for ECO
	$eco1 = 0;
	$eco2 = 0;
	$eco3 = 0;
	$eco4 = 0;
	$eco5 = 0;
	$ecoall=0;
	if(count($this->arrECO) > 0){
		foreach ($this->arrECO as $eco){
			if ($eco=='V') {$eco1=1; $ecoall++;}
			if ($eco=='W') {$eco2=1; $ecoall++;}
			if ($eco=='E') {$eco3=1; $ecoall++;}
			if ($eco=='D') {$eco4=1; $ecoall++;}
			if ($eco=='R') {$eco5=1; $ecoall++;}

		}
	}
	//for PO
	$po1 = 0;
	$po2 = 0;
	$po3 = 0;
	$po4 = 0;
	$po5 = 0;
	$poall=0;
	if(count($this->arrPO) > 0){
		foreach ($this->arrPO as $po){
			if ($po=='V') {$po1=1; $poall++;}
			if ($po=='W') {$po2=1; $poall++;}
			if ($po=='E') {$po3=1; $poall++;}
			if ($po=='D') {$po4=1; $poall++;}
			if ($po=='R') {$po5=1; $poall++;}

		}
	}        
	//for STO
	$sto1 = 0;
	$sto2 = 0;
	$sto3 = 0;
	$sto4 = 0;
	$sto5 = 0;
	$stoall=0;
	if(count($this->arrSTO) > 0){
		foreach ($this->arrSTO as $sto){
			if ($sto=='V') {$sto1=1; $stoall++;}
			if ($sto=='W') {$sto2=1; $stoall++;}
			if ($sto=='E') {$sto3=1; $stoall++;}
			if ($sto=='D') {$sto4=1; $stoall++;}
			if ($sto=='R') {$sto5=1; $stoall++;}

		}
	}    
	//for part number
	$pns1 = 0;
	$pns2 = 0;
	$pns3 = 0;
	$pns4 = 0;
	$pns5 = 0;
        $pns6 = 0;        
	$pnsall=0;
	if(count($this->arrPns) > 0){
		foreach ($this->arrPns as $pns){
			if ($pns=='V') {$pns1=1; $pnsall++;}
			if ($pns=='W') {$pns2=1; $pnsall++;}
			if ($pns=='E') {$pns3=1; $pnsall++;}
			if ($pns=='D') {$pns4=1; $pnsall++;}
			if ($pns=='R') {$pns5=1; $pnsall++;}
                        if ($pns=='S') {$pns6=1; $pnsall++;}
                        

		}
	}
	$checktotal = (int) count($this->arrCC) + count($this->arrVendor) + count($this->arrSupplier) + count($this->arrManufacture) + count($this->arrECO) + count($this->arrPO) + count($this->arrPns);
	//$cparams = JComponentHelper::getParams ('com_media');
?>

<?php	
//	$lvisit	= JHTML::_('date', $this->user->get('lastvisitDate'), '%Y-%m-%d %H:%M:%S');
?>
<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&]", "i");	
		// do field validation
		if (trim(form.role_name.value) == "") {
			alert( "<?php echo JText::_( 'ALERT_NAME_ROLE', true ); ?>" );
			form.role_name.focus();
		} else if ((form.boxchecked.value == 0) && (form.boxcheckedcc.value==0) && (form.boxcheckedv.value==0) && (form.boxcheckeds.value==0) && (form.boxcheckedm.value==0) && (form.boxcheckedeco.value==0) && (form.boxcheckedpns.value==0)) {
			alert( "<?php echo JText::_( 'ALERT_ROLE_VALUE', true ); ?>" );
		} else {
			submitform( pressbutton );
		}
	}

	function gotocontact( id ) {
		var form = document.adminForm;
		form.contact_id.value = id;
		submitform( 'contact' );
	}
</script>
<form action="index.php" method="post" name="adminForm" autocomplete="off">
	<div class="col width-60">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'ROLE_DETAIL' ); ?></legend>
			<table class="admintable" cellspacing="1">
				<tr>
					<td width="150" class="key">
						<label for="name">
							<?php echo JText::_( 'ROLE_NAME' ); ?>
						</label>
					</td>
					<td >
						<input type="text" name="role_name" id="role_name" class="inputbox" size="50" value="<?php echo $this->row->get('role_name'); ?>" />
					</td>
				</tr>
				<tr>
					<td width="150" class="key" valign="top">
						<label for="name">
							<?php echo JText::_( 'ROLE_DESCRIPTION' ); ?>
						</label>
					</td>
					<td >
						<textarea name="role_description" rows="5" cols="50"><?php echo $this->row->get('role_description'); ?></textarea>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label>
							<?php echo JText::_( 'ROLE_COMPONENT' ); ?>
						</label>
					</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;
						<label>
							<?php echo JText::_( 'ROLE_VIEW' ); ?>
						</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<label>
							<?php echo JText::_( 'ROLE_WRITE' ); ?>
						</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<label>
							<?php echo JText::_( 'ROLE_EDIT' ); ?>
						</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<label>
							<?php echo JText::_( 'ROLE_DELETE' ); ?>
						</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<label>
							<?php echo JText::_( 'ROLE_RESTORE' ); ?>
						</label>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <label>
							<?php echo JText::_( 'Stock Update' ); ?>
						</label>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<label>
							<?php echo JText::_( 'ROLE_CHECK_ALL' ); ?>
						</label>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="email">
							<?php echo JText::_( 'COMPONENT_COMMODITY_CODE' ); ?>
							
						</label>
					</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="cc[]" value="V" <?php echo ($cc1) ? 'checked="checked"' : ''?>  onclick="isChecked(this.checked);" id="cc0" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="cc[]" value="W" <?php echo ($cc2) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="cc1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="cc[]" value="E" <?php echo ($cc3) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="cc2" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="cc[]" value="D" <?php echo ($cc4) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="cc3" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="cc[]" value="R" <?php echo ($cc5) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="cc4" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" onclick="checkAllCC(5, 'cc');" value="" name="toggle1" <?php if ($ccall==5) { ?> checked="checked" <?php } ?>/>
					</td>
				</tr>				
				<tr>
					<td valign="top" class="key">
						<label for="gid">
							<?php echo JText::_( 'COMPONENT_ECO' ); ?>
							
						</label>
					</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="eco[]" value="V" <?php echo ($eco1) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="eco0" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="eco[]" value="W" <?php echo ($eco2) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="eco1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="eco[]" value="E" <?php echo ($eco3) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="eco2" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="eco[]" value="D" <?php echo ($eco4) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="eco3" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="eco[]" value="R" <?php echo ($eco5) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="eco4" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" onclick="checkAllECO(5, 'eco');" value="" name="toggle5" <?php if ($ecoall==5) { ?> checked="checked" <?php } ?>/>
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<label for="gid">
							<?php echo JText::_( 'COMPONENT_PNS' ); ?>							
						</label>
					</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p[]" value="V" <?php echo ($pns1) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="p0" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p[]" value="W" <?php echo ($pns2) ? 'checked="checked"' : ''?>  onclick="isChecked(this.checked);" id="p1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p[]" value="E" <?php echo ($pns3) ? 'checked="checked"' : ''?>  onclick="isChecked(this.checked);" id="p2"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p[]" value="D" <?php echo ($pns4) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="p3" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p[]" value="R" <?php echo ($pns5) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="p4" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="checkbox" name="p[]" value="S" <?php echo ($pns6) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="p4" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" onclick="checkAllPNS(6, 'p');" value="0" name="toggle6" <?php if ($pnsall==6) { ?> checked="checked" <?php } ?>/>
					</td>
				</tr>		
                                <tr>
					<td valign="top" class="key">
						<label for="gid">
							<?php echo JText::_( 'PO' ); ?>
							
						</label>
					</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="po[]" value="V" <?php echo ($po1) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="po0" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="po[]" value="W" <?php echo ($po2) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="po1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="po[]" value="E" <?php echo ($po3) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="po2" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="po[]" value="D" <?php echo ($po4) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="po3" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="po[]" value="R" <?php echo ($po5) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="po4" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" onclick="checkAllPO(5, 'po');" value="" name="toggle7" <?php if ($poall==5) { ?> checked="checked" <?php } ?>/>
					</td>
				</tr>	
                                <tr>
					<td valign="top" class="key">
						<label for="gid">
							<?php echo JText::_( 'STO' ); ?>
							
						</label>
					</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="sto[]" value="V" <?php echo ($sto1) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="sto0" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="sto[]" value="W" <?php echo ($sto2) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="sto1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="sto[]" value="E" <?php echo ($sto3) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="sto2" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="sto[]" value="D" <?php echo ($sto4) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="sto3" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="sto[]" value="R" <?php echo ($sto5) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="sto4" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" onclick="checkAllSTO(5, 'sto');" value="" name="toggle8" <?php if ($stoall==5) { ?> checked="checked" <?php } ?>/>
					</td>
				</tr>	                                
			<tr>
					<td class="key">
						<label for="email">
							<?php echo JText::_( 'COMPONENT_VENDOR_SP_MF' ); ?>
							
						</label>
					</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="v[]" value="V" <?php echo ($vd1) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="v0" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="v[]" value="W" <?php echo ($vd2) ? 'checked="checked"' : ''?>  onclick="isChecked(this.checked);" id="v1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="v[]" value="E" <?php echo ($vd3) ? 'checked="checked"' : ''?>  onclick="isChecked(this.checked);" id="v2" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="v[]" value="D" <?php echo ($vd4) ? 'checked="checked"' : ''?>  onclick="isChecked(this.checked);" id="v3" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="v[]" value="R" <?php echo ($vd5) ? 'checked="checked"' : ''?>  onclick="isChecked(this.checked);" id="v4" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" onclick="checkAllVendor(5, 'v');" value="" name="toggle2" <?php if ($vdall==5) { ?> checked="checked" <?php } ?>/>
					</td>
				</tr>
				
			</table>
		</fieldset>
	</div>
	<div class="col width-40">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Parameters' ); ?></legend>
			<table class="admintable">
				<tr>
					<td class="key">
						<?php
							echo JText::_('DATE_CREATE');
						?>
					</td>
					<td>
						<?php echo ($this->row->role_create !='0000-00-00 00:00:00') ? JHTML::_('date', $this->row->role_create, '%Y-%m-%d %H:%M:%S') : 'New Role' ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<?php
							echo JText::_('CREATED_BY');
						?>
					</td>
					<td>
						<?php echo ($this->row->role_create_by ) ? RolesController::GetNameUser($this->row->role_create_by) : 'New Role' ?>
					</td>
				</tr>
				
				<tr>
					<td class="key">
						<?php
							echo JText::_('DATE_MODIFIED');
						?>
					</td>
					<td>
						<?php echo ($this->row->role !=0) ? JHTML::_('date', $this->row->role_modified, '%Y-%m-%d %H:%M:%S') : 'None' ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<?php
							echo JText::_('MODIFIED_BY');
						?>
					</td>
					<td>
						<?php echo ($this->row->role_modified_by ) ? RolesController::GetNameUser($this->row->role_modified_by) : 'None' ?>
					</td>
				</tr>
					<tr>
					<td class="key">
						<?php
							echo JText::_('NUMBEROFUSER');
						?>
					</td>
					<td>
						<?php echo  RolesController::CountNumberUserOfRole($this->role_id); ?>
					</td>
				</tr>
				
			</table>
		</fieldset>			
		
	</div>
	<div class="clr"></div>
	<input type="hidden" name="role_id" value="<?php echo $this->role_id;?>" />
	<input type="hidden" name="option" value="com_roles" />
	<input type="hidden" name="task" value="" />	
	<input type="hidden" name="boxchecked" value="<?php echo $checktotal;?>" />
	<input type="hidden" name="boxcheckedcc" value="0" />
	<input type="hidden" name="boxcheckedv" value="0" />
	<input type="hidden" name="boxcheckedm" value="0" />
	<input type="hidden" name="boxcheckeds" value="0" />
	<input type="hidden" name="boxcheckedeco" value="0" />
        <input type="hidden" name="boxcheckedpo" value="0" />
        <input type="hidden" name="boxcheckedsto" value="0" />
	<input type="hidden" name="boxcheckedpns" value="0" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
