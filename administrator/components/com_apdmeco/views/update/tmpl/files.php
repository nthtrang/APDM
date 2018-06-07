<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>


<?php
	$cid = JRequest::getVar('cid', array(0));
        $edit = JRequest::getVar('edit', true);
$text = intval($edit) ? JText::_('Edit') : JText::_('New');
$demote = $promote = "";
$me = & JFactory::getUser();
 JToolBarHelper::title( JText::_( $this->row->eco_name));
if (!intval($edit)) {
        JToolBarHelper::save('save', 'Save & Add new');
}
JToolBarHelper::apply('savefiles', 'Save');

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
                submitform( pressbutton );
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
<div class="submenu-box">
	<div class="submenu-pad">
		<ul id="submenu" class="configuration">
			<li><a id="detail" href="index.php?option=com_apdmeco&task=detail&cid[]=<?php echo $this->row->eco_id;?>"><?php echo JText::_( 'Detail' ); ?></a></li>
			<li><a id="affected" href="index.php?option=com_apdmeco&task=affected&cid[]=<?php echo $this->row->eco_id;?>"><?php echo JText::_( 'Affected Parts' ); ?></a></li>
			<li><a id="initial" href="index.php?option=com_apdmeco&task=files&cid[]=<?php echo $this->row->eco_id;?>"><?php echo JText::_( 'Initial Data' ); ?></a></li>
                        <li><a id="supporting" class="active"><?php echo JText::_( 'Supporting Document' ); ?></a></li>
                        <li><a id="routes" href="index.php?option=com_apdmpns&task=mep&cid[]=<?php echo $this->row->eco_id;?>"><?php echo JText::_( 'Routes' ); ?></a></li>                     
		</ul>
		<div class="clr"></div>
	</div>
</div>
<div class="clr"></div>
<p>&nbsp;</p>
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data" >
					<table class="admintable" width="100%"  >
				<?php if (count($this->arr_file) > 0 ) { ?>
					<tr>
						<td colspan="2">
						<table width="100%"  class="adminlist" cellpadding="1">						
						<thead>
							<th colspan="4"><?php echo JText::_('List files ')?></th>
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
		
<div style="display:none"><?php
						// parameters : areaname, content, width, height, cols, rows
echo $editor->display( 'text',  $row->text , '10%', '10', '10', '3' ) ;
?></div>
	<input type="hidden" name="eco_id" value="<?php echo $this->row->eco_id?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->row->eco_id?>" />
	<input type="hidden" name="option" value="com_apdmeco" />
	<input type="hidden" name="task" value="" />	
        <input type="hidden" name="redirect" value="files" />	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
