<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php	
//poup add rev roll
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
        $rev = $this->revision;
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	
?>
<script language="javascript" type="text/javascript">
function UpdatePnsRevWindow(){        				
        window.parent.document.getElementById('sbox-window').close();	
        window.parent.location.reload();
}

</script>

<form action="index.php?option=com_apdmpns&task=save_rev_roll&cid[]=<?php echo $cid[0]?>" method="post" name="adminFormPnsrev" enctype="multipart/form-data" >
         <table  width="100%">
		<tr>
			<td></td>
			<tr align="right">
			<td align="right"><?php
                       // if($this->pns_status!='Release')
                      //  {
                                ?><input type="submit" name="btinsersave" value="Save"  onclick="UpdatePnsRevWindow();"/>
                        <?php
                      //  }
                        ?>
                        </td>	
		</tr>
		</tr>			
</table>
			<table class="admintable" cellspacing="1">
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'ASCENX_PNS' ); ?>
						</label>
					</td>
					<td><?php echo $rev[0]->ccs_code.'-'.$rev[0]->pns_code;?>
						<input type="hidden"  name="pns_code" id="pns_code"  size="10" value="<?php echo $rev[0]->pns_code;?>"/>
						<input type="hidden" name="ccs_code" id="ccs_code" value="<?php echo $rev[0]->ccs_code;?>" />
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_REVISION' ); ?>
						</label>
					</td>
					<td>
                                                <?php echo $this->nextRev;?>
						<input type="hidden" onkeypress="return CharatersOnlyEspecial(this, event)" value="<?php echo $rev[0]->pns_revision;?>" name="pns_revision_old" id="pns_revision" class="inputbox" size="6" maxlength="2" />						                                                
                                                <input type="hidden" name="pns_revision" value="<?php echo $this->nextRev;?>"/>
						
					</td>
				</tr>
				
				
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_ECO' ); ?>
						</label>
					</td>
					<td>
					<?php echo PNsController::GetECO($rev[0]->eco_id); ?>
					<input type="hidden" name="eco_id" id="eco_id" value="<?php echo $rev[0]->eco_id;?>" />
					</td>
				</tr>
				
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'State' ); ?>
						</label>
					</td>
					<td>
                                                <?php echo $rev[0]->pns_life_cycle;?>
                                                <input type="hidden" name="pns_life_cycle" id="pns_life_cycle" value="<?php echo $rev[0]->pns_life_cycle;?>" />
					</td>
				</tr>
                            
				
			</table>
	


	<input type="hidden" name="pns_id" value="<?php echo $rev[0]->pns_id;?>" />	
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="return" value="rev"  />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
