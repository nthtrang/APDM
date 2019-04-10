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
    $cc0 = 0;
    $cc1 = 0;
	$cc2 = 0;
	$cc3 = 0;
	$cc4 = 0;
	$cc5 = 0;
	$ccall =0;
	if(count($this->arrCC) > 0){
		foreach ($this->arrCC as $cc){
            if ($cc=='H') { $cc0=1; $ccall++;}
			if ($cc=='V') { $cc1=1; $ccall++;}
			if ($cc=='W') { $cc2=1; $ccall++;}
			if ($cc=='E') { $cc3=1; $ccall++;}
			if ($cc=='D') { $cc4=1; $ccall++;}
			if ($cc=='R') { $cc5=1; $ccall++;}

		}
	}

	//for Vendor
    $vd0 = 0;
	$vd1 = 0;
	$vd2 = 0;
	$vd3 = 0;
	$vd4 = 0;
	$vd5 = 0;
	$vdall = 0;
	if(count($this->arrVendor) > 0){
		foreach ($this->arrVendor as $vd){
            if ($vd=='H') {$vd0=1; $vdall++;}
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
    $eco0 = 0;
	$eco1 = 0;
	$eco2 = 0;
	$eco3 = 0;
	$eco4 = 0;
	$eco5 = 0;
	$ecoall=0;
	if(count($this->arrECO) > 0){
		foreach ($this->arrECO as $eco){
            if ($eco=='H') {$eco0=1; $ecoall++;}
			if ($eco=='V') {$eco1=1; $ecoall++;}
			if ($eco=='W') {$eco2=1; $ecoall++;}
			if ($eco=='E') {$eco3=1; $ecoall++;}
			if ($eco=='D') {$eco4=1; $ecoall++;}
			if ($eco=='R') {$eco5=1; $ecoall++;}

		}
	}
	//for PO
    $po0 = 0;
	$po1 = 0;
	$po2 = 0;
	$po3 = 0;
	$po4 = 0;
	$po5 = 0;
	$poall=0;
	if(count($this->arrPO) > 0){
		foreach ($this->arrPO as $po){
            if ($po=='H') {$po0=1; $poall++;}
			if ($po=='V') {$po1=1; $poall++;}
			if ($po=='W') {$po2=1; $poall++;}
			if ($po=='E') {$po3=1; $poall++;}
			if ($po=='D') {$po4=1; $poall++;}
			if ($po=='R') {$po5=1; $poall++;}

		}
	}        
	//for STO
    $sto0 = 0;
	$sto1 = 0;
	$sto2 = 0;
	$sto3 = 0;
	$sto4 = 0;
	$sto5 = 0;
	$sto6 = 0;
	$stoall=0;
	if(count($this->arrSTO) > 0){
		foreach ($this->arrSTO as $sto){
            if ($sto=='H') {$sto0=1; $stoall++;}
			if ($sto=='V') {$sto1=1; $stoall++;}
			if ($sto=='W') {$sto2=1; $stoall++;}
			if ($sto=='E') {$sto3=1; $stoall++;}
			if ($sto=='D') {$sto4=1; $stoall++;}
			if ($sto=='R') {$sto5=1; $stoall++;}
			if ($sto=='S') {$sto6=1; $stoall++;}
		}
	}
//for  TTO
$tto0 = 0;
$tto1 = 0;
$tto2 = 0;
$tto3 = 0;
$tto4 = 0;
$tto5 = 0;
$ttoall=0;
if(count($this->arrTTO) > 0){
    foreach ($this->arrTTO as $tto){
        if ($tto=='H') {$tto0=1; $ttoall++;}
        if ($tto=='V') {$tto1=1; $ttoall++;}
        if ($tto=='W') {$tto2=1; $ttoall++;}
        if ($tto=='E') {$tto3=1; $ttoall++;}
        if ($tto=='D') {$tto4=1; $ttoall++;}
        if ($tto=='R') {$tto5=1; $ttoall++;}

    }
}
//for Location
    $loc0 = 0;
	$loc1 = 0;
	$loc2 = 0;
	$loc3 = 0;
	$loc4 = 0;
	$loc5 = 0;
	$locall=0;
	if(count($this->arrLOC) > 0){
		foreach ($this->arrLOC as $loc){
            if ($loc=='H') {$loc0=1; $locall++;}
			if ($loc=='V') {$loc1=1; $locall++;}
			if ($loc=='W') {$loc2=1; $locall++;}
			if ($loc=='E') {$loc3=1; $locall++;}
			if ($loc=='D') {$loc4=1; $locall++;}
			if ($loc=='R') {$loc5=1; $locall++;}

		}
	}            
	//for part number
    $pns0 = 0;
	$pns1 = 0;
	$pns2 = 0;
	$pns3 = 0;
	$pns4 = 0;
	$pns5 = 0;
        $pns6 = 0;        
	$pnsall=0;
	if(count($this->arrPns) > 0){
		foreach ($this->arrPns as $pns){
            if ($pns=='H') {$pns0=1; $pnsall++;}
			if ($pns=='V') {$pns1=1; $pnsall++;}
			if ($pns=='W') {$pns2=1; $pnsall++;}
			if ($pns=='E') {$pns3=1; $pnsall++;}
			if ($pns=='D') {$pns4=1; $pnsall++;}
			if ($pns=='R') {$pns5=1; $pnsall++;}
                        if ($pns=='S') {$pns6=1; $pnsall++;}
                        

		}
	}
        //for SO
    $swo0 = 0;
    $swo1 = 0;
	$swo2 = 0;
	$swo3 = 0;
	$swo4 = 0;
	$swo5 = 0;
	$swo6 = 0;
	$swoall=0;
	if(count($this->arrSWO) > 0){
		foreach ($this->arrSWO as $swo){
            if ($swo=='H') {$swo0=1; $swoall++;}
			if ($swo=='V') {$swo1=1; $swoall++;}
			if ($swo=='W') {$swo2=1; $swoall++;}
			if ($swo=='E') {$swo3=1; $swoall++;}
			if ($swo=='D') {$swo4=1; $swoall++;}
			if ($swo=='R') {$swo5=1; $swoall++;}
			if ($swo=='S') {$swo6=1; $swoall++;}
                        

		}
	}
    //for WO
    $wo0 = 0;
    $wo1 = 0;
    $wo2 = 0;
    $wo3 = 0;
    $wo4 = 0;
    $wo5 = 0;
    $wo6 = 0;
    $woall=0;
    if(count($this->arrWO) > 0){
        foreach ($this->arrWO as $wo){
            if ($wo=='H') {$wo0=1; $woall++;}
            if ($wo=='V') {$wo1=1; $woall++;}
            if ($wo=='W') {$wo2=1; $woall++;}
            if ($wo=='E') {$wo3=1; $woall++;}
            if ($wo=='D') {$wo4=1; $woall++;}
            if ($wo=='R') {$wo5=1; $woall++;}
            if ($wo=='S') {$wo6=1; $woall++;}


        }
    }
	$checktotal = (int) count($this->arrCC) + count($this->arrVendor) + count($this->arrSupplier) + count($this->arrManufacture) + count($this->arrECO) + count($this->arrPO) + count($this->arrPns) + count($this->arrSTO)+ count($this->arrLOC)+ count($this->arrSWO)+ count($this->arrWO);
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
		} else if ((form.boxchecked.value == 0) && (form.boxcheckedcc.value==0) && (form.boxcheckedv.value==0) && (form.boxcheckeds.value==0) && (form.boxcheckedm.value==0) && (form.boxcheckedeco.value==0) && (form.boxcheckedpns.value==0) && (form.boxcheckedpo.value==0)&& (form.boxcheckedsto.value==0)&& (form.boxcheckedloc.value==0)&& (form.boxcheckedswo.value==0)) {
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
					<td colspan="8">
						<input type="text" name="role_name" id="role_name" class="inputbox" size="50" value="<?php echo $this->row->get('role_name'); ?>" />
					</td>
				</tr>
				<tr>
					<td width="150" class="key" valign="top">
						<label for="name">
							<?php echo JText::_( 'ROLE_DESCRIPTION' ); ?>
						</label>
					</td>
                    <td colspan="8">
						<textarea name="role_description" rows="5" cols="50"><?php echo $this->row->get('role_description'); ?></textarea>
					</td>
				</tr>
				<tr>
					<td>
						<label>
							<?php echo JText::_( 'ROLE_COMPONENT' ); ?>
						</label>
					</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;
                        <label>
                            <?php echo JText::_( 'ROLE_HIDE' ); ?>
                        </label>&nbsp;&nbsp;
                    </td>
                    <td>
						<label>
							<?php echo JText::_( 'ROLE_VIEW' ); ?>
						</label>&nbsp;&nbsp;&nbsp;
                    </td>
                    <td>
						<label>
							<?php echo JText::_( 'ROLE_WRITE' ); ?>
						</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                    <td>
						<label>
							<?php echo JText::_( 'ROLE_EDIT' ); ?>
                        </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                    <td>
						<label>
							<?php echo JText::_( 'ROLE_DELETE' ); ?>
						</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                    <td>
						<label>
							<?php echo JText::_( 'ROLE_RESTORE' ); ?>
						</label>
                    </td>
                    <td>
                    <label>
							<?php echo JText::_( 'Cost Update' ); ?>
						</label>
                    </td>
                    <td>
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
					<td><input type="checkbox" name="cc[]" value="H" <?php echo ($cc0) ? 'checked="checked"' : ''?>  onclick="isChecked(this.checked);" id="cc5" />
                    </td>
                    <td><input type="checkbox" name="cc[]" value="V" <?php echo ($cc1) ? 'checked="checked"' : ''?>  onclick="isChecked(this.checked);" id="cc0" />
                    </td>
                    <td><input type="checkbox" name="cc[]" value="W" <?php echo ($cc2) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="cc1" />
                    </td>
                    <td><input type="checkbox" name="cc[]" value="E" <?php echo ($cc3) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="cc2" />
                    </td>
                    <td><input type="checkbox" name="cc[]" value="D" <?php echo ($cc4) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="cc3" />
                    </td>
                    <td><input type="checkbox" name="cc[]" value="R" <?php echo ($cc5) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="cc4" />
                    </td>
                    <td>&nbsp;</td>
                    <td><input type="checkbox" onclick="checkAllCC(6, 'cc');" value="" name="toggle1" <?php if ($ccall==6) { ?> checked="checked" <?php } ?>/>
					</td>
				</tr>				
				<tr>
					<td valign="top" class="key">
						<label for="gid">
							<?php echo JText::_( 'COMPONENT_ECO' ); ?>
							
						</label>
					</td>
					<td><input type="checkbox" name="eco[]" value="H" <?php echo ($eco0) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="eco5" />
                    </td>
                    <td><input type="checkbox" name="eco[]" value="V" <?php echo ($eco1) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="eco0" />
                    </td>
                    <td><input type="checkbox" name="eco[]" value="W" <?php echo ($eco2) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="eco1" />
                    </td>
                    <td><input type="checkbox" name="eco[]" value="E" <?php echo ($eco3) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="eco2" />
                    </td>
                    <td><input type="checkbox" name="eco[]" value="D" <?php echo ($eco4) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="eco3" />
                    </td>
                    <td><input type="checkbox" name="eco[]" value="R" <?php echo ($eco5) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="eco4" />
                    </td>
                    <td>&nbsp;</td>
                    <td><input type="checkbox" onclick="checkAllECO(6, 'eco');" value="" name="toggle5" <?php if ($ecoall==6) { ?> checked="checked" <?php } ?>/>
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<label for="gid">
							<?php echo JText::_( 'COMPONENT_PNS' ); ?>							
						</label>
					</td>
					<td><input type="checkbox" name="p[]" value="H" <?php echo ($pns0) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="p6" />
                    </td>
                    <td><input type="checkbox" name="p[]" value="V" <?php echo ($pns1) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="p0" />
                    </td>
                    <td><input type="checkbox" name="p[]" value="W" <?php echo ($pns2) ? 'checked="checked"' : ''?>  onclick="isChecked(this.checked);" id="p1"/>
                    </td>
                    <td><input type="checkbox" name="p[]" value="E" <?php echo ($pns3) ? 'checked="checked"' : ''?>  onclick="isChecked(this.checked);" id="p2"/>
                    </td>
                    <td><input type="checkbox" name="p[]" value="D" <?php echo ($pns4) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="p3" />
                    </td>
                    <td><input type="checkbox" name="p[]" value="R" <?php echo ($pns5) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="p4" />
                    </td>
                    <td><input type="checkbox" name="p[]" value="S" <?php echo ($pns6) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="p5" />
                    </td>
                    <td><input type="checkbox" onclick="checkAllPNS(7, 'p');" value="0" name="toggle6" <?php if ($pnsall==7) { ?> checked="checked" <?php } ?>/>
					</td>
				</tr>
                <tr>
					<td valign="top" class="key">
						<label for="gid">
							<?php echo JText::_( 'PO' ); ?>
						</label>
					</td>
					<td><input type="checkbox" name="po[]" value="H" <?php echo ($po0) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="po5" />
                    </td>
                    <td><input type="checkbox" name="po[]" value="V" <?php echo ($po1) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="po0" />
                    </td>
                    <td><input type="checkbox" name="po[]" value="W" <?php echo ($po2) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="po1" />
                    </td>
                    <td><input type="checkbox" name="po[]" value="E" <?php echo ($po3) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="po2" />
                    </td>
                    <td><input type="checkbox" name="po[]" value="D" <?php echo ($po4) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="po3" />
                    </td>
                    <td><input type="checkbox" name="po[]" value="R" <?php echo ($po5) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="po4" />
                    </td>
                    <td>&nbsp;</td>
                    <td><input type="checkbox" onclick="checkAllPO(6, 'po');" value="" name="toggle7" <?php if ($poall==6) { ?> checked="checked" <?php } ?>/>
					</td>
				</tr>
                <tr>
					<td valign="top" class="key">
						<label for="gid">
							<?php echo JText::_( 'STO' ); ?>
						</label>
					</td>
					<td><input type="checkbox" name="sto[]" value="H" <?php echo ($sto0) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="sto6" />
                    </td>
                    <td><input type="checkbox" name="sto[]" value="V" <?php echo ($sto1) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="sto0" />
                    </td>
                    <td><input type="checkbox" name="sto[]" value="W" <?php echo ($sto2) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="sto1" />
                    </td>
                    <td><input type="checkbox" name="sto[]" value="E" <?php echo ($sto3) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="sto2" />
                    </td>
                    <td><input type="checkbox" name="sto[]" value="D" <?php echo ($sto4) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="sto3" />
                    </td>
                    <td><input type="checkbox" name="sto[]" value="R" <?php echo ($sto5) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="sto4" />
                    </td>
                    <td><input type="checkbox" name="sto[]" value="S" <?php echo ($sto6) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="sto5" />(MTO Button)
                    </td>
                    <td><input type="checkbox" onclick="checkAllSTO(7, 'sto');" value="" name="toggle8" <?php if ($stoall==7) { ?> checked="checked" <?php } ?>/>
					</td>
				</tr>
                <tr>
                    <td valign="top" class="key">
                        <label for="gid">
                            <?php echo JText::_( 'Special Tool' ); ?>

                        </label>
                    </td>
                    <td><input type="checkbox" name="tto[]" value="H" <?php echo ($tto0) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="tto5" />
                    </td>
                    <td><input type="checkbox" name="tto[]" value="V" <?php echo ($tto1) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="tto0" />
                    </td>
                    <td><input type="checkbox" name="tto[]" value="W" <?php echo ($tto2) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="tto1" />
                    </td>
                    <td><input type="checkbox" name="tto[]" value="E" <?php echo ($tto3) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="tto2" />
                    </td>
                    <td><input type="checkbox" name="tto[]" value="D" <?php echo ($tto4) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="tto3" />
                    </td>
                    <td><input type="checkbox" name="tto[]" value="R" <?php echo ($tto5) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="tto4" />
                    </td>
                    <td>&nbsp;</td>
                    <td><input type="checkbox" onclick="checkAllTTO(6, 'tto');" value="" name="toggle11" <?php if ($ttoall==6) { ?> checked="checked" <?php } ?>/>
                    </td>
                </tr>
			    <tr>
					<td valign="top" class="key">
						<label for="gid">
							<?php echo JText::_( 'Code Location' ); ?>
						</label>
					</td>
					<td><input type="checkbox" name="loc[]" value="H" <?php echo ($loc0) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="loc5" />
                    </td>
                    <td><input type="checkbox" name="loc[]" value="V" <?php echo ($loc1) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="loc0" />
                    </td>
                    <td><input type="checkbox" name="loc[]" value="W" <?php echo ($loc2) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="loc1" />
                    </td>
                    <td><input type="checkbox" name="loc[]" value="E" <?php echo ($loc3) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="loc2" />
                    </td>
                    <td><input type="checkbox" name="loc[]" value="D" <?php echo ($loc4) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="loc3" />
                    </td>
                    <td><input type="checkbox" name="loc[]" value="R" <?php echo ($loc5) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="loc4" />
                    </td>
                    <td>&nbsp;</td>
                    <td><input type="checkbox" onclick="checkAllLOC(6, 'loc');" value="" name="toggle9" <?php if ($locall==6) { ?> checked="checked" <?php } ?>/>
					</td>
				</tr>	                                
			<tr>
					<td class="key">
						<label for="email">
							<?php echo JText::_( 'COMPONENT_VENDOR_SP_MF' ); ?>
						</label>
					</td>
				<td><input type="checkbox" name="v[]" value="H" <?php echo ($vd0) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="v5" />
                    </td>
                <td><input type="checkbox" name="v[]" value="V" <?php echo ($vd1) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="v0" />
                </td>
                <td><input type="checkbox" name="v[]" value="W" <?php echo ($vd2) ? 'checked="checked"' : ''?>  onclick="isChecked(this.checked);" id="v1" />
                </td>
                <td><input type="checkbox" name="v[]" value="E" <?php echo ($vd3) ? 'checked="checked"' : ''?>  onclick="isChecked(this.checked);" id="v2" />
                </td>
                <td><input type="checkbox" name="v[]" value="D" <?php echo ($vd4) ? 'checked="checked"' : ''?>  onclick="isChecked(this.checked);" id="v3" />
                </td>
                <td><input type="checkbox" name="v[]" value="R" <?php echo ($vd5) ? 'checked="checked"' : ''?>  onclick="isChecked(this.checked);" id="v4" />
                </td>
                <td>&nbsp;</td>
                <td><input type="checkbox" onclick="checkAllVendor(6, 'v');" value="" name="toggle2" <?php if ($vdall==6) { ?> checked="checked" <?php } ?>/>
					</td>
				</tr>
                <tr>
					<td class="key">
						<label for="email">
							<?php echo JText::_( 'SO' ); ?>
						</label>
					</td>
					<td><input type="checkbox" name="swo[]" value="H" <?php echo ($swo0) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="swo5" />
                    </td>
                    <td><input type="checkbox" name="swo[]" value="V" <?php echo ($swo1) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="swo0" />
                    </td>
                    <td><input type="checkbox" name="swo[]" value="W" <?php echo ($swo2) ? 'checked="checked"' : ''?>  onclick="isChecked(this.checked);" id="swo1" />
                    </td>
                    <td><input type="checkbox" name="swo[]" value="E" <?php echo ($swo3) ? 'checked="checked"' : ''?>  onclick="isChecked(this.checked);" id="swo2" />
                    </td>
                    <td><input type="checkbox" name="swo[]" value="D" <?php echo ($swo4) ? 'checked="checked"' : ''?>  onclick="isChecked(this.checked);" id="swo3" />
                    </td>
                    <td><input type="checkbox" name="swo[]" value="R" <?php echo ($swo5) ? 'checked="checked"' : ''?>  onclick="isChecked(this.checked);" id="swo4" />
                    </td>
                    <td>&nbsp;</td>
                    <td><input type="checkbox" onclick="checkAllSwo(6, 'swo');" value="" name="toggle10" <?php if ($swoall==6) { ?> checked="checked" <?php } ?>/>
					</td>
				</tr>
                <tr>
                    <td class="key">
                        <label for="email">
                            <?php echo JText::_( 'WO' ); ?>

                        </label>
                    </td>
                    <td><input type="checkbox" name="wo[]" value="H" <?php echo ($wo0) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="wo5" />
                    </td>
                    <td><input type="checkbox" name="wo[]" value="V" <?php echo ($wo1) ? 'checked="checked"' : ''?> onclick="isChecked(this.checked);" id="wo0" />
                    </td>
                    <td><input type="checkbox" name="wo[]" value="W" <?php echo ($wo2) ? 'checked="checked"' : ''?>  onclick="isChecked(this.checked);" id="wo1" />
                    </td>
                    <td><input type="checkbox" name="wo[]" value="E" <?php echo ($wo3) ? 'checked="checked"' : ''?>  onclick="isChecked(this.checked);" id="wo2" />
                    </td>
                    <td><input type="checkbox" name="wo[]" value="D" <?php echo ($wo4) ? 'checked="checked"' : ''?>  onclick="isChecked(this.checked);" id="wo3" />
                    </td>
                    <td><input type="checkbox" name="wo[]" value="R" <?php echo ($wo5) ? 'checked="checked"' : ''?>  onclick="isChecked(this.checked);" id="wo4" />
                    </td>
                    <td>&nbsp;</td>
                    <td><input type="checkbox" onclick="checkAllWo(6, 'wo');" value="" name="toggle12" <?php if ($woall==6) { ?> checked="checked" <?php } ?>/>
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
						<?php echo ($this->row->role_create !='0000-00-00 00:00:00') ? JHTML::_('date', $this->row->role_create, JText::_('DATE_FORMAT_LC6')) : 'New Role' ?>
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
						<?php echo ($this->row->role !=0) ? JHTML::_('date', $this->row->role_modified, JText::_('DATE_FORMAT_LC6')) : 'None' ?>
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
    <input type="hidden" name="boxcheckedtto" value="0" />
    <input type="hidden" name="boxcheckedloc" value="0" />
    <input type="hidden" name="boxcheckedpns" value="0" />
    <input type="hidden" name="boxcheckedswo" value="0" />
    <input type="hidden" name="boxcheckedwo" value="0" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
