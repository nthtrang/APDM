<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

	JToolBarHelper::title( JText::_( 'Profile' ) );
//	JToolBarHelper::save();
	JToolBarHelper::apply('changeprofile');
	if ( $edit ) {
		// for existing items the button is renamed `close`
		JToolBarHelper::cancel( 'cancel_profile', 'Close' );
	} else {
		JToolBarHelper::cancel();
	}
	//JToolBarHelper::help( 'screen.users.edit' );
	$cparams = JComponentHelper::getParams ('com_media');
	$me 		= JFactory::getUser();   

?>

<?php
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	if ($this->user[0]->lastvisitDate == "0000-00-00 00:00:00") {
		$lvisit = JText::_( 'Never' );
	} else {
		$lvisit	= JHTML::_('date', $this->user[0]->lastvisitDate, '%Y-%m-%d %H:%M:%S');
	}
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
		if (trim(form.first_name.value) == "") {
			alert( "<?php echo JText::_( 'ALERT_FIRST_NAME', true ); ?>" );
		} else if (form.last_name.value == "") {
			alert( "<?php echo JText::_( 'ALERT_LAST_NAME', true ); ?>" );
		} else if (form.username.value == "") {
			alert( "<?php echo JText::_( 'ALERT_USERNAME_EMAIL', true ); ?>" );
		} else if (r.exec(form.username.value) || form.username.value.length < 6) {
			alert( "<?php echo JText::_( 'ALERT_ERROR_USERNAME', true ); ?>" );
		} else if (!isEmail( form.username.value )) {
			alert( "<?php echo JText::_( 'ALERT_ERROR_USERNAME', true ); ?>" );
		} else if (form.gid.value == "") {
			alert( "<?php echo JText::_( 'You must assign user to a group.', true ); ?>" );
		} else if (((trim(form.password.value) != "") || (trim(form.password2.value) != "")) && (form.password.value != form.password2.value)){
			alert( "<?php echo JText::_( 'Password do not match.', true ); ?>" );		
		} else {
			submitform( pressbutton );
		}
	}

	/*function gotocontact( id ) {
		var form = document.adminForm;
		form.contact_id.value = id;
		submitform( 'contact' );
	}*/
	
	/*function DisplayGroupRole(field, fieldvalue){
			if (fieldvalue.value == 23) {
			$('listrole').setStyle('display', 'table-row');
              var selectBox = $(field);
              var url = 'index.php?option=com_apdmusers&task=list_role';
              var MyAjax = new Ajax(url, {
					method: "post",
					onComplete: function(result){      
						var aData = result.split(";");
						selectBox.length = 0;
						for (var i = 0; i<aData.length-1; i+=2) {
						  addOption(selectBox, aData[i], aData[i+1]);
						}
					}			
				}).request();            
			}else{
				$('listrole').setStyle('display', 'none');
			}

          }*/

</script>
<form action="index.php" method="post" name="adminForm" autocomplete="off">
	<div class="col width-45">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'User Details' ); ?></legend>
			<table class="admintable" cellspacing="1">
				<tr>
					<td width="150" class="key">
						<label for="name">
							<?php echo JText::_( 'Fist Name' ); ?>
						</label>
					</td>
					<td>
						<input type="text" name="first_name" id="first_name" class="inputbox" size="40" value="<?php echo $this->user[0]->user_firstname; ?>" />
					</td>
				</tr>
				<tr>
					<td width="150" class="key">
						<label for="name">
							<?php echo JText::_( 'Last Name' ); ?>
						</label>
					</td>
					<td>
						<input type="text" name="last_name" id="last_name" class="inputbox" size="40" value="<?php echo $this->user[0]->user_lastname; ?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="username">
							<?php echo JText::_( 'Username' ); ?>
						</label>
					</td>
					<td>
						<input type="text" name="username" id="username" class="inputbox" size="40" value="<?php echo $this->user[0]->username; ?>" autocomplete="off" readonly="readonly" />
					</td>
				</tr>
				
				<tr>
					<td class="key">
						<label for="password">
							<?php echo JText::_( 'New Password' ); ?>
						</label>
					</td>
					<td>
						
							<input class="inputbox" type="password" name="password" id="password" size="40" value=""/>
						
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="password2">
							<?php echo JText::_( 'Verify Password' ); ?>
						</label>
					</td>
					<td>
						
							<input class="inputbox" type="password" name="password2" id="password2" size="40" value=""/>
						
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="email">
							<?php echo JText::_( 'Title' ); ?>
						</label>
					</td>
					<td>
						<input class="inputbox" type="text" name="user_title" id="user_title" size="40" value="<?php echo $this->user[0]->user_title; ?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="email">
							<?php echo JText::_( 'Mobile' ); ?>
						</label>
					</td>
					<td>
						<input class="inputbox" type="text" name="user_mobile" id="user_mobile" size="40" value="<?php echo $this->user[0]->user_mobile; ?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="email">
							<?php echo JText::_( 'Telephone' ); ?>
						</label>
					</td>
					<td>
						<input class="inputbox" type="text" name="user_telephone" id="user_telephone" size="40" value="<?php echo $this->user[0]->user_telephone; ?>" />
					</td>
				</tr>
				<!--<tr>
					<td class="key">
						<?php //echo JText::_( 'Block User' ); ?>
					</td>
					<td>
						<?php //echo $this->lists['block']; ?>
					</td>
				</tr>-->
				
				<?php //if( $this->user[0]->id ) { ?>
				<!--<tr>
					<td class="key">
						<?php //echo JText::_( 'Register Date' ); ?>
					</td>
					<td>
						<?php //echo JHTML::_('date', $this->user[0]->registerDate, '%Y-%m-%d %H:%M:%S');?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<?php //echo JText::_( 'Last Visit Date' ); ?>
					</td>
					<td>
						<?php //echo $lvisit; ?>
					</td>
				</tr>-->
				<?php // } ?>
			</table>
		</fieldset>
	</div>
	<!--<div class="col width-55">
		<fieldset class="adminform">
		<legend><?php //echo JText::_( 'Parameters' ); ?></legend>
			<table class="admintable">	
			<tr>
					<td valign="top" class="key" width="10%">
						<label for="gid">
							<?php //echo JText::_( 'Group' ); ?>
						</label>
					</td>
					<td>
						<?php //echo $this->lists['gid']; ?>
					</td>
				</tr>
				
				<tr id="listrole">
					<td valign="top" class="key" width="10%">
						<label for"gid">
							<?php //echo JText::_('Role');?>
						</label>
					
					</td>
					<td width="80%">
					<?php //echo $this->lists['role'];?>
						<select name="role_user[]" id="role_user" size="10" multiple="multiple">
							<option value="">--Select Role---</option>							
						</select>-->
					
					<!--</td>
				</tr>
		
			</table>
		</fieldset>		
	</div>-->
	<div class="clr"></div>

	<input type="hidden" name="id" value="<?php echo $this->user[0]->id; ?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->user[0]->id; ?>" />
	<input type="hidden" name="option" value="com_apdmusers" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="gid" value="<?php echo $this->user[0]->gid;?>" />
	<?php foreach ($this->userrole as $rr) { ?>
	<input type="hidden" name="role_user[]" value="<?php echo $rr;?>" />
	<?php } ?>
	<input type="hidden" name="block" value="<?php echo $this->user[0]->user_enable;?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
