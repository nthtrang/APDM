<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php	
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
        $partnumber = $this->row->ccs_code.'-'.$this->row->pns_code;
        if ($this->row->pns_revision) 
                $partnumber .= '-'.$this->row->pns_revision;	
	JToolBarHelper::title( $partnumber , 'cpanel.png' );
       
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
//		var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&]", "i");
//		if (form.pns_revision.value !="" && form.pns_revision.value.length != 2){
//			alert("PNs Revision must 2 characters");
//			form.pns_revision.focus();
//			return false;
//		}		
//		if (form.eco_id.value==0){
//			alert("Please select ECO");
//			form.eco.focus();
//			return false;
//		}
//		if (form.pns_status.value==""){
//			alert("Please select Part Number Status/");
//			from.pns_status.focus();
//			return false;
//		}
		
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
	
	function get_rev_roll(){
		var url = 'index.php?option=com_apdmpns&task=rev_roll';
		var ccs_code = $('ccs_code').value;
		var pns_code = $('pns_code').value;
		url = url + '&ccs_code=' + ccs_code + '&pns_code=' + pns_code;
		
		var MyAjax = new Ajax(url, {
			method:'get',
			onComplete:function(result){

				if ( result.toString() == '0A' ){
					alert('<?php echo JText::_('End of REV roll. Please contact with Administrator.');?>');					
				}else{
					$('pns_revision').value = result;
				}
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

</script>
<div class="submenu-box">
	<div class="submenu-pad">
		<ul id="submenu" class="configuration">
			<li><a id="detail"  href="index.php?option=com_apdmpns&task=detail&cid[0]=<?php echo $this->row->pns_id?>"><?php echo JText::_( 'Detail' ); ?></a></li>
			<li><a id="bom" href="index.php?option=com_apdmpns&task=bom&id=<?php echo $this->row->pns_id;?>"><?php echo JText::_( 'BOM' ); ?></a></li>
			<li><a id="whereused" href="index.php?option=com_apdmpns&task=whereused&id=<?php echo $this->row->pns_id;?>"><?php echo JText::_( 'Where Used' ); ?></a></li>
                        <li><a id="specification" class="active" ><?php echo JText::_( 'Specification' ); ?></a></li>
                        <li><a id="mep" href="index.php?option=com_apdmpns&task=mep&cid[]=<?php echo $this->row->pns_id;?>"><?php echo JText::_( 'MEP' ); ?></a></li>
                        <li><a id="server"><?php echo JText::_( 'REV' ); ?></a></li>
                        <li><a id="server"><?php echo JText::_( 'DASH ROLL' ); ?></a></li>
		</ul>
		<div class="clr"></div>
	</div>
</div>
<div class="clr"></div>
<p>&nbsp;</p>
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data" >
	<div class="col width-100">
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
						<input type="hidden" name="old_pns_image" value="<?php echo $this->row->pns_image;?>" />
					</td>
				</tr>
				<?php if ($this->row->pns_image !="") {?>
				<tr>
					<td colspan="2" align="center">
					<img src="../uploads/pns/images/<?php echo $this->row->pns_image?>" width="200" height="100"  />
					<br />
					<a href="index.php?option=com_apdmpns&task=download_img&id=<?php echo $this->row->pns_id?>" title="<?php echo JText::_('Click here to download image')?>" ><?php echo JText::_('Download Image')?></a>&nbsp;&nbsp;
					<a href="index.php?option=com_apdmpns&task=remove_img&id=<?php echo $this->row->pns_id?>&remove=00<?php echo time();?>"  title="<?php echo JText::_('Click here to remove image')?>" onclick="if ( confirm('Are you sure to delete it ? ') ) { return true;} else {return false;} " >Remove</a>
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
					<td colspan="2" align="center"><a href="index.php?option=com_apdmpns&task=download&id=<?php echo $this->row->pns_id?>" title="Click here to download file"><?php echo $this->row->pns_pdf;?>&nbsp;(<?php $filesizepdf = PNsController::Readfilesize('pdf', $this->row->pns_pdf); echo number_format($filesizepdf, 0, '.', ' ')?>&nbsp;KB)</a>&nbsp;&nbsp;					
					<a href="index.php?option=com_apdmpns&task=remove_pdf&id=<?php echo $this->row->pns_id?>&remove=010<?php echo time();?>" title="Click here to remove" onclick="if ( confirm('Are you sure to delete it ? ') ) { return true;} else {return false;} " >Remove</a>
					</td>
				</tr>
				<?php } ?>
				<?php if (count($this->lists['cads_files']) > 0) {
				?>				
				<tr>
					<td colspan="2" >
					<table width="100%"  class="adminlist" cellpadding="1">
						<hr />
						<thead>
							<th colspan="4"><?php echo JText::_('List file cads')?></th>
						</thead>
						<tr>
							<td width="5%"><strong><?php echo JText::_('No.')?></strong></td>
							<td width="45%"><strong><?php echo JText::_('Name')?> </strong></td>
							<td width="30%"><strong><?php echo JText::_('Size (KB)')?> </strong></td>
							<td width="20%"><strong><?php echo JText::_('Download')?>  <?php echo JText::_('Remove')?></strong></td>
						</tr>
				<?php
				
				$i = 1;
				 $folder_pns = $this->row->ccs_code.'-'.$this->row->pns_code.'-'.$this->row->pns_revision;
				foreach ($this->lists['cads_files'] as $cad) {
					$filesize = PNsController::Readfilesize('cads', $cad['cad_file'], $this->row->ccs_code, $folder_pns);
				?>
				<tr>
					<td><?php echo $i?></td>
					<td><?php echo $cad['cad_file']?></td>
					<td><?php echo number_format($filesize, 0, '.', ' '); ?></td>
					<td><a href="index.php?option=com_apdmpns&task=download_cad&id=<?php echo $cad['id']?>" title="Click here to download file"><img src="images/download_f2.png" width="20" height="20" /></a>&nbsp;&nbsp;
					<a href="index.php?option=com_apdmpns&task=remove_cad&id=<?php echo $cad['id']?>&remove=<?php echo $i.time();?>" title="Click to remove" onclick="if ( confirm('Are you sure to delete it ? ') ) { return true;} else {return false;} "><img src="images/cancel_f2.png" width="15" height="15" /></a></td>
				</tr>
				<?php $i++; } ?>
				
				<tr>
					
					<td colspan="4" align="center">
					<a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmpns&task=download_all_cads&tmpl=component&zdir=<?php echo $this->row->ccs_code.'-'.$this->row->pns_code.'-'.$this->row->pns_revision;?>" title="Image">
<input type="button" name="addVendor" value="<?php echo JText::_('Download All Files')?>"/>
</a>&nbsp;&nbsp;
				
					<input type="button" value="<?php echo JText::_('Remove All Files')?>" onclick="if ( confirm ('Are you sure to delete it ?')) { window.location.href='index.php?option=com_apdmpns&task=remove_all_cad&pns_id=<?php echo $this->row->pns_id?>' }else{ return false;}" /></td>					
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
						<a href="javascript:;"id="lnkfichier" title="<?php echo JText::_('Click here to add more CAD files');?>" ><?php echo JText::_('Click here to add more CAD files');?></a>
					</td>
				</tr>
							
			</table>
		</fieldset>		
	</div>
	<div class="clr"></div>

<div style="display:none"><?php
						// parameters : areaname, content, width, height, cols, rows
						echo $editor->display( 'text',  $row->text , '10%', '10', '10', '3' ) ;
						?></div>
	<input name="nvdid" value="<?php echo $this->lists['count_vd'];?>" type="hidden" />
	<input name="nspid" value="<?php echo $this->lists['count_sp'];?>" type="hidden" />
	<input name="nmfid" value="<?php echo $this->lists['count_mf'];?>" type="hidden" />
	<input type="hidden" name="pns_id" value="<?php echo $this->row->pns_id;?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->row->pns_id;?>" />	
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="task" value="" />
        <input type="hidden" name="redirect" value="specification" />
	<input type="hidden" name="return" value="<?php echo $this->cd;?>"  />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
