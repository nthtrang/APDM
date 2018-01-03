<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
        $demote = '<button onclick="javascript:hideMainMenu(); submitbutton(\'demote\')" class="buttonfiles" style="vertical-align:middle"><span>Demote </span></button>';
        $promote  = '<button onclick="javascript:hideMainMenu(); submitbutton(\'promote\')" class="buttonaffected" style="vertical-align:middle"><span>Promote</span></button>';

	JToolBarHelper::title( JText::_( 'ECO_MANAGEMET' ) . ': <small><small>[ '. $text .' ]</small></small>'.$demote.$promote , 'generic.png' );
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
                if (pressbutton == 'demote') {
			  window.location.assign("index.php?option=com_apdmeco&task=demote&cid[]=<?php echo $this->row->eco_id?>&time=<?php echo time();?>");
			return;
		}  
		if (pressbutton == 'promote') {
			  window.location.assign("index.php?option=com_apdmeco&task=promote&cid[]=<?php echo $this->row->eco_id?>&time=<?php echo time();?>");
			return;
		}    
		var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&]", "i");
	
		if (trim(form.eco_name.value) == 0) {
			alert( "<?php echo JText::_( 'ALERT_TYPE_INFO', true ); ?>" );		
		} else {
			submitform( pressbutton );
		}
	}
	function display_block(){
		var input_field = document.adminForm.getElementById('check_sendmail');		
		if(input_field.checked){
			document.adminForm.getElementById('list_user').style.display='table-row';
		}else{
		 document.adminForm.getElementById('list_user').style.display='none';
		}
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
function get_number_eco(){
	var url = 'index.php?option=com_apdmeco&task=code_default';		
		var MyAjax = new Ajax(url, {
			method:'get',
			onComplete:function(result){				
				$('eco_name').value = result;
			}
		}).request();
}
</script>
<style>
        .buttonfiles {
  display: inline-block;
  border-radius: 4px;
  background-color: #4CAF50;
  border: none;
  color: white;
  text-align: center;
  font-size: 16px;
  padding: 10px 32px;
  width: 120px;
  transition: all 0.5s;
  cursor: pointer;
  margin-left: 30px;
}

.buttonaffected {
  display: inline-block;
  border-radius: 4px;
  background-color: #4CAF50;
  border: none;
  color: white;
  text-align: center;
  font-size: 16px;
  padding: 10px 32px;
  width: 180px;
  transition: all 0.5s;
  cursor: pointer;
  margin-left: 30px;
}
</style>
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data" >
	<div class="col width-60">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'INFORMATION_DETAIL' ); ?></legend>
			<table class="admintable" cellspacing="1">				
				<tr>
					<td class="key" valign="top">
						<label for="name">
							<?php echo JText::_('ECO_NAME');?>
						</label>
					</td>
					<td>
					<?php if ($this->row->eco_id) { ?>
						<input type="text" name="eco_name" value="<?php echo $this->row->eco_name?>" readonly="readonly"  />
					<?php }else { ?>
						<input type="text" maxlength="5" onKeyPress="return numbersOnly(this, event);" class="inputbox" size="10" name="eco_name" id="eco_name" value="<?php echo $this->row->eco_name?>" /><em><?php echo JText::_('ECO_NAME_NOTE')?></em> <br /> <a href="javascript:void(0);" onclick="get_number_eco();"><?php echo JText::_('Get random number ECO')?></a>
					<?php } ?>	
					</td>
				</tr>
				<!--<tr>
					<td class="key" valign="top">
						<label for="name">
							<?php //echo JText::_('ECO_PDF');?>
						</label>
					</td>
					<td>
						<input type="file" name="file_pdf" />&nbsp;&nbsp;<?php //if($this->row->eco_id && ($this->row->eco_pdf !="")) { ?> 
						File PDF: <a href="index.php?option=com_apdmeco&task=download&id=<?php //echo $this->row->eco_id?>" title="Click to download file pdf"><?php //echo $this->row->eco_pdf;?></a>
						<?php //} ?>
						<input type="hidden" name="file_pdf_exist" value="<?php //echo $this->row->eco_pdf;?>" />
					</td>
				</tr>		-->		
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'DESCRIPTION' ); ?>
						</label>
					</td>
					<td>
						<textarea name="eco_description" rows="5" cols="30"><?php echo $this->row->eco_description?></textarea>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_PROJECT' ); ?>
						</label>
					</td>
					<td>
						<input type="text" name="eco_project"  id="eco_project" value="<?php echo $this->row->eco_project; ?>" />
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_TYPE' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->lists['type']?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_FIELD_IMPACT' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->lists['field_impact']?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_REASON' ); ?>
						</label>
					</td>
					<td>
						<textarea name="eco_reason" rows="10" cols="50"><?php echo $this->row->eco_reason?></textarea>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_WHAT_IS_CHANGE' ); ?>
						</label>
					</td>
					<td>
						<textarea name="eco_what" rows="10" cols="50"><?php echo $this->row->eco_what?></textarea>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_SPECIAL' ); ?>
						</label>
					</td>
					<td>
						<textarea name="eco_special" rows="10" cols="50"><?php echo $this->row->eco_special?></textarea>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_BENEFIT' ); ?>
						</label>
					</td>
					<td>
						<textarea name="eco_benefit" rows="5" cols="30"><?php echo $this->row->eco_benefit?></textarea>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_TECHNICAL_ACTIONS' ); ?>
						</label>
					</td>
					<td>
						<textarea name="eco_technical" rows="5" cols="30"><?php echo $this->row->eco_technical?></textarea>
					</td>
				</tr>
	<!--			<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_TECHNICAL_DESIGN' ); ?>
						</label>
					</td>
					<td>
						<input type="text" name="eco_tech_design"  id="eco_tech_design" value="<?php echo $this->row->eco_tech_design; ?>" />
					</td>
				</tr>
-->
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_ESTIMATED' ); ?>
						</label>
					</td>
					<td>
						<input type="text" name="eco_estimated"  id="eco_estimated" value="<?php echo $this->row->eco_estimated; ?>" />
					</td>
				</tr>
<!--				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_TARGET' ); ?>
						</label>
					</td>
					<td>
						<input type="text" name="eco_estimated_cogs"  id="eco_estimated_cogs" value="<?php echo $this->row->eco_estimated_cogs; ?>" />
					</td>
				</tr>
-->
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ACTIVE' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->lists['activate']?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Life Cicle' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->lists['status']?>
					</td>
				</tr>
                                

				<tr>
					<td><?php echo JText::_('SEND_MAIL');?></td>
					<td><input type="checkbox" name="check_sendmail" id="check_sendmail" value="1" onclick="display_block();" /></td>
				</tr>
				<tr id="list_user" style="display:none">
					<td valign="top"><?php echo JText::_('LIST_EMAIL_USER');?></td>
					<td>
					<p>	<a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmusers&task=get_list&tmpl=component" title="<?php echo JText::_('Select User')?>">
<input type="button" name="listUser" value="<?php echo JText::_('Select User')?>"/>
</a></p>
					<!--<select name="mail_user[]" multiple="multiple" size="10">
					<?php //foreach ($this->list_user as $list) {?>
						<option value="<?php //echo $list->username;?>"><?php //echo $list->username;?></option>
					<?php //} ?>
					</select>-->
					<p id="listAjaxUser">
					
					</p>
					</td>
				</tr>
				
			</table>
		</fieldset>
	</div>
	<div class="col width-40">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Files' ); ?> <font color="#FF0000"><em><?php echo JText::_('(Please upload file less than 20Mb)')?></em></font></legend>
			<table class="admintable" width="100%"  >
				<?php if (count($this->arr_file) > 0 ) { ?>
					<tr>
						<td colspan="2">
						<table width="100%"  class="adminlist" cellpadding="1">						
						<thead>
							<th colspan="4"><?php echo JText::_('List file ')?></th>
						</thead>
						<tr>
							<td width="5%"><strong><?php echo JText::_('No.')?></strong></td>
							<td width="45%"><strong><?php echo JText::_('Name')?> </strong></td>
							<td width="30%"><strong><?php echo JText::_('Size (bytes)')?> </strong></td>
							<td width="20%"><strong><?php echo JText::_('Download')?>  <?php echo JText::_('Remove')?></strong></td>
						</tr>
						<?php $i = 1; 
					foreach ($this->arr_file as $file) { 
						$filesize = ECOController::Readfilesize($file->file_name);
					?>
							<tr>
							<td><?php echo $i?></td>
							<td><?php echo $file->file_name;?></td>
							<td><?php echo number_format($filesize, 0, '.', ' '); ?></td>
							<td><a href="index.php?option=com_apdmeco&task=download&id=<?php echo $file->id?>" title="Click here to download file"><img src="images/download_f2.png" width="20" height="20" /></a>&nbsp;&nbsp;
							<a href="index.php?option=com_apdmeco&task=remove_file&id=<?php echo $file->id?>&id_eco=<?php echo $file->eco_id; ?>" title="Click to remove" onclick="if(confirm('Are you sure to delete it?')){ return true;}else{return false;}"><img src="images/cancel_f2.png" width="15" height="15" /></a></td>
						</tr>
						<?php $i++; } ?>
						</table>
						</td>
					</tr>
				<?php  
				} ?>
				<tr>
					<td class="key" valign="top">
						<label for="ccs_create">
							<?php echo JText::_('Files')?>
						</label>
					</td>
					<td>
					<div class="iptfichier">
						<span id="1">
							<input type="file" name="file1" /> 
						</span>
						<span id="2">
							<input type="file" name="file2" /> 
						</span>
						<span id="3">
							<input type="file" name="file3" /> 
						</span>
						<span id="4">
							<input type="file" name="file4" /> 
						</span>
						<span id="5">
							<input type="file" name="file5" />
						</span>
						<span id="6">
							<input type="file" name="file6" /> 
						</span>
						<span id="7">
							<input type="file" name="file7" /> 
						</span>
						<span id="8">
							<input type="file" name="file8" /> 
						</span>
						<span id="9">
							<input type="file" name="file9" />
						</span>
						<span id="10">
							<input type="file" name="file10" />
						</span>						
					</div>
						<br />
						<a href="javascript:;"id="lnkfichier" title="Add more file " ><?php echo JText::_('Click here to add more  files');?></a>
					</td>
				</tr>
				
			</table>
		</fieldset>
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Parameters' ); ?></legend>
			<table class="admintable">
				<tr>
					<td class="key">
						<label for="ccs_create">
							<?php echo JText::_('INFO_CREATE')?>
						</label>
					</td>
					<td>
						<?php echo ($this->row->eco_id) ? JHTML::_('date', $this->row->eco_create, '%Y-%m-%d %H:%M:%S') :'New document';?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="ccs_create_by">
							<?php echo JText::_('INFO_CREATE_BY')?>
						</label>
					</td>
					<td>
						<?php echo ($this->row->eco_id) ? GetValueUser($this->row->eco_create_by, 'name') : 'New Document';?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="ccs_create">
							<?php echo JText::_('INFO_MODIFIED')?>
						</label>
					</td>
					<td>
						<?php echo ($this->row->eco_modified_by) ? JHTML::_('date', $this->row->eco_modified, '%Y-%m-%d %H:%M:%S') : 'None';?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="ccs_create_by">
							<?php echo JText::_('INFO_MODIFIED_BY')?>
						</label>
					</td>
					<td>
						<?php echo ($this->row->eco_modified_by) ? GetValueUser($this->row->eco_modified_by, 'name') : 'None';?>
					</td>
				</tr>
				
				
			</table>
		</fieldset>
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Approvers' ); ?></legend>
                
                			<table class="admintable" width="100%"  >
				<?php if (count($this->arr_status) > 0 ) { ?>
					<tr>
						<td colspan="2">
						<table width="100%"  class="adminlist" cellpadding="1">						
						<thead>
							<th colspan="3"><?php echo JText::_('List Approvers ')?></th>
						</thead>
						<tr>
							<td width="5%"><strong><?php echo JText::_('No.')?></strong></td>
							<td width="45%"><strong><?php echo JText::_('Email')?> </strong></td>
							<td width="30%"><strong><?php echo JText::_('Status')?> </strong></td>							
						</tr>
						<?php $i = 1; 
					foreach ($this->arr_status as $status) { 
						?>
							<tr>
							<td><?php echo $i?></td>
							<td><?php echo $status->email;?></td>
							<td><?php echo $status->eco_status;?></td>
						</tr>
						<?php $i++; } ?>
						</table>
						</td>
					</tr>
				<?php  
				} ?>
			</table>
                
                </fieldset>
	</div>
	<div class="clr"></div>
<div style="display:none"><?php
						// parameters : areaname, content, width, height, cols, rows
echo $editor->display( 'text',  $row->text , '10%', '10', '10', '3' ) ;
?></div>
	<input type="hidden" name="eco_id" value="<?php echo $this->row->eco_id?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->row->eco_id?>" />
	<input type="hidden" name="option" value="com_apdmeco" />
	<input type="hidden" name="task" value="" />	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
