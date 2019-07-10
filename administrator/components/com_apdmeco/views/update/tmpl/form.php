<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>


<?php
	$cid = JRequest::getVar('cid', array(0));
$edit = JRequest::getVar('edit', true);
$text = intval($edit) ? JText::_('Edit') : JText::_('New');
$demote = $promote = "";
$me = & JFactory::getUser();
if (intval($edit) && $this->row->eco_create_by == $me->get('id')) {
        $demote = '<button onclick="javascript:hideMainMenu(); submitbutton(\'demote\')" class="buttonfiles" style="vertical-align:middle"><span>Demote </span></button>';
        $promote = '<button onclick="javascript:hideMainMenu(); submitbutton(\'promote\')" class="buttonaffected" style="vertical-align:middle"><span>Promote</span></button>';
}
JToolBarHelper::title(JText::_('ECO_MANAGEMET') . ': <small><small>[ ' . $text . ' ]</small></small>' , 'generic.png');
if (!intval($edit)) {
        JToolBarHelper::save('save', 'Save & Add new');
}
JToolBarHelper::apply('apply', 'Save');

if ($edit) {
        // for existing items the button is renamed `close`
        JToolBarHelper::cancel('cancel', 'Close');
} else {
        JToolBarHelper::cancel();
}

$cparams = JComponentHelper::getParams('com_media');
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
get_number_eco();
</script>

<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data" >
	<div class="col width-100">
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
						<textarea maxlength='40' name="eco_description" rows="5" cols="30"><?php echo $this->row->eco_description?></textarea>
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
						<!--<textarea name="eco_reason" rows="10" cols="50"><?php echo $this->row->eco_reason?></textarea>-->
                                                <?php                                     
                                                $editor =& JFactory::getEditor();                                                
                                                     echo $editor->display('eco_reason', $this->row->eco_reason, '5%', '2', '5', '1',false);
                                        ?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_WHAT_IS_CHANGE' ); ?>
						</label>
					</td>
					<td>
<!--						<textarea name="eco_what" rows="10" cols="50"><?php echo $this->row->eco_what?></textarea>-->
                                                <?php                                     
                                                $editor =& JFactory::getEditor();                                                
                                                     echo $editor->display('eco_what', $this->row->eco_what, '5%', '2', '5', '1',false);
                                        ?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="eco_record_number">
							<?php echo JText::_( 'Record Number' ); ?>
						</label>
					</td>
					<td>
<!--						<textarea name="eco_record_number" rows="10" cols="50"><?php echo $this->row->eco_record_number?></textarea>-->
                                                <?php                                     
                                                $editor =& JFactory::getEditor();                                                
                                                     echo $editor->display('eco_record_number', $this->row->eco_record_number, '5%', '2', '5', '1',false);
                                        ?>
					</td>
				</tr>                                
                                
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_SPECIAL' ); ?>
						</label>
					</td>
					<td>
<!--						<textarea name="eco_special" rows="10" cols="50"><?php echo $this->row->eco_special?></textarea>-->
                                                 <?php                                     
                                                $editor =& JFactory::getEditor();                                                
                                                     echo $editor->display('eco_special', $this->row->eco_special, '5%', '2', '5', '1',false);
                                        ?>
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

				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ACTIVE' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->lists['activate']?>
					</td>
				</tr>-->
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'State' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->lists['status']?>
					</td>
				</tr>
                                

				
				
			</table>
		</fieldset>
	</div>

	<div class="clr"></div>
<div style="display:none"><?php
						// parameters : areaname, content, width, height, cols, rows
//echo $editor->display( 'text',  $row->text , '10%', '10', '10', '3' ) ;
?></div>
	<input type="hidden" name="eco_id" value="<?php echo $this->row->eco_id?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->row->eco_id?>" />
	<input type="hidden" name="option" value="com_apdmeco" />
	<input type="hidden" name="task" value="" />	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
