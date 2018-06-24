<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
sss
<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

	JToolBarHelper::title( JText::_( 'Customers Code Management' ) . ': <small><small>[ '. $text .' ]</small></small>' , 'generic.png' );
	if (!intval($edit)) {
		JToolBarHelper::save('save', 'Save & Add new');
	}	JToolBarHelper::apply('savecus', 'Save');
	
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
		//alert(form.ccs_code.length);
		var cc1 = form.ccs_code1.value;
                var cc2 = form.ccs_code2.value;
		//alert(cc.length);
		// do field validation
		if (trim(form.ccs_code1.value) == "" || trim(form.ccs_code2.value) == "") {
			alert( "<?php echo JText::_( 'ALERT_COMODITY_CODE', true ); ?>" );		
		} else if (cc1.length !=1 || cc2.length !=2){
			alert("<?php echo JText::_( 'ALERT_COMODITY_CODE_LENGHT', true ); ?>" );
		} else {
			submitform( pressbutton );
		}
	}
	function get_defautl_code(){
		
		var url = 'index.php?option=com_apdmccs&task=code_default';
		var MyAjax = new Ajax(url, {
			method:'get',
			onComplete:function(result){
				$('ccs_code').value = result;
			}
		}).request();
	}
      
        
        function capitaliseName()
        {
            var form = document.adminForm;
            var str = form.ccs_code1.value;
            form.ccs_code1.value = str.charAt(0).toUpperCase() + str.slice(1);

        }        
</script>

<form action="index.php" method="post" name="adminForm" >
	<div class="col width-60">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Comodity Code Detail' ); ?></legend>
			<table class="admintable" cellspacing="1">
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'COMMODITY_CODE' ); ?>
						</label>
					</td>
					<td>
                                                <input type="text" maxlength="1"  name="ccs_code1" onkeydown="capitaliseName()" onKeyPress="return CharatersOnlyEspecialUpCase(this, event);" id="ccs_code1" class="inputbox" size="5" value="<?php echo $this->row->ccs_code;?>" <?php echo ($this->row->ccs_id) ? 'readonly=""' : '';?>  />
						<input type="text" maxlength="2"  name="ccs_code2" onKeyPress="return numbersOnly(this, event);" id="ccs_code2" class="inputbox" size="5" value="<?php echo $this->row->ccs_code;?>" <?php echo ($this->row->ccs_id) ? 'readonly=""' : '';?>  /><?php if (!$this->row->ccs_id) {?>
						&nbsp;&nbsp;<!--<a href="javascript:void(0)" onclick="get_defautl_code();"><?php //echo JText::_('DEFAULT_CODE')?></a>-->
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'COMMODITY_CODE_DESCRIPTION' ); ?>
						</label>
					</td>
					<td>
						<textarea name="ccs_description" rows="10" cols="60"><?php echo $this->row->ccs_description?></textarea>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'COMMODITY_CODE_ACTIVATE' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->lists['activate']?>
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
						<label for="ccs_create">
							<?php echo JText::_('CCS_CREATE')?>
						</label>
					</td>
					<td>
						<?php echo ($this->row->ccs_id) ? JHTML::_('date', $this->row->ccs_create, '%Y-%m-%d %H:%M:%S') :'New document';?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="ccs_create_by">
							<?php echo JText::_('CCS_CREATE_BY')?>
						</label>
					</td>
					<td>
						<?php echo ($this->row->ccs_id) ? GetValueUser($this->row->ccs_create_by, 'username') : 'New Document';?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="ccs_create">
							<?php echo JText::_('CCS_MODIFIED')?>
						</label>
					</td>
					<td>
						<?php echo ($this->row->ccs_modified !='0000-00-00 00:00:00') ? JHTML::_('date', $this->row->ccs_modified, '%Y-%m-%d %H:%M:%S') : 'None';?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="ccs_create_by">
							<?php echo JText::_('CCS_MODIFIED_BY')?>
						</label>
					</td>
					<td>
						<?php echo ($this->row->ccs_modified_by) ? GetValueUser($this->row->ccs_modified_by, 'username') : 'None';?>
					</td>
				</tr>				
			</table>
		</fieldset>
		
	</div>
	<div class="clr"></div>

	<input type="hidden" name="ccs_id" value="<?php echo $this->row->ccs_id?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->row->ccs_id?>" />
	<input type="hidden" name="option" value="com_apdmccs" />
	<input type="hidden" name="task" value="savecus" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
