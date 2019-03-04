<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php
//
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
$cid = JRequest::getVar('cid', array(0));
$edit = JRequest::getVar('edit', true);

JToolBarHelper::title($this->sto_row->sto_code, 'cpanel.png');
$role = JAdministrator::RoleOnComponent(10);      

if (in_array("W", $role) && $this->sto_row->sto_state !="Done") {
        JToolBarHelper::apply('save_doc_sto', 'Save');
}
if (in_array("D", $role) && $this->sto_row->sto_state !="Done") {
        JToolBarHelper::deletePns('Are you sure to delete it?',"deleteso","Delete SO#");
}
$cparams = JComponentHelper::getParams('com_media');
$editor = &JFactory::getEditor();
?>

<?php
// clean item data
JFilterOutput::objectHTMLSafe($user, ENT_QUOTES, '');
?>
<script language="javascript" type="text/javascript">
        function submitbutton(pressbutton) {  
                var form = document.adminForm;      
                if(pressbutton == 'deleteso')
                {                       
                     submitform( pressbutton );
                     return;
                }
                if (pressbutton == 'save_doc_sto') {
                        submitform( pressbutton );
                        return;
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
                        
                        //for image
                        //File Input Generate
			var mid=0;			
			var mclick=1;
			$$(".iptfichier_image span").each(function(itext,id) {
				if (mid!=0)
					itext.style.display = "none";
					mid++;
			});
			$('lnkfichier_image').addEvents ({				
				'click':function(){	
					if (mclick<mid) {
						$$(".iptfichier_image span")[mclick].style.display="block";
					//	alert($$(".iptfichier input")[mclick].style.display);
						mclick++;
					}
				}
			});	
                        //for pdf
                        //File Input Generate
			var mid=0;			
			var mclick=1;
			$$(".iptfichier_pdf span").each(function(itext,id) {
				if (mid!=0)
					itext.style.display = "none";
					mid++;
			});
			$('lnkfichier_pdf').addEvents ({				
				'click':function(){	
					if (mclick<mid) {
						$$(".iptfichier_pdf span")[mclick].style.display="block";
					//	alert($$(".iptfichier input")[mclick].style.display);
						mclick++;
					}
				}
			});	                        
		});        
                
</script>
<div class="submenu-box">
            <div class="t">
                <div class="t">
                        <div class="t"></div>
                </div>
        </div>
        <div class="m">
		<ul id="submenu" class="configuration">
			<li><a id="detail" href="index.php?option=com_apdmsto&task=ito_detail&id=<?php echo $this->sto_row->pns_sto_id;?>" ><?php echo JText::_( 'DETAIL' ); ?></a></li>
			<li><a id="bom" href="index.php?option=com_apdmsto&task=ito_detail_pns&id=<?php echo $this->sto_row->pns_sto_id;?>"><?php echo JText::_( 'AFFECTED PARTS' ); ?></a></li>
                        <li><a id="bom" class="active"><?php echo JText::_( 'SUPPORTING DOC' ); ?></a></li>                        
                </ul>
		<div class="clr"></div>
        </div>
        <div class="b">
                <div class="b">
                        <div class="b"></div>
                </div>
        </div>
</div>
<div class="clr"></div>
<p>&nbsp;</p>

<form action="index.php?option=com_apdmsto&task=save_doc_sto&time=<?php echo time();?>" method="post" name="adminForm" enctype="multipart/form-data" >      
        <fieldset class="adminform">		 
        	<div class="col width-100">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Image, Pdf, Zip files' ); ?> <font color="#FF0000"><em><?php echo JText::_('(Please upload file less than 20Mb)')?></em></font></legend>
                <table class="adminlist">                        
              <?php if (isset($this->lists['image_files'])&& count($this->lists['image_files'])>0) {?>
				<tr>
                                        <td colspan="2" >
					<table width="100%"  class="adminlist" cellpadding="1">
						
						<thead>
							<th colspan="4"><?php echo JText::_('List Images')?></th>
						</thead>
						<tr>
							<td width="5%"><strong><?php echo JText::_('No.')?></strong></td>
							<td width="45%"><strong><?php echo JText::_('Name')?> </strong></td>
							<td width="30%"><strong><?php echo JText::_('Size (KB)')?> </strong></td>
							<td width="20%"><strong><?php echo JText::_('Download')?>  <?php echo JText::_('Remove')?></strong></td>
						</tr>
				<?php
				
				$i = 1;
				$folder_sto = $this->sto_row->sto_code;
				foreach ($this->lists['image_files'] as $image) {
					$filesize = SToController::readfilesizeSto($folder_sto, $image['image_file'],'images');
				?>
				<tr>
					<td><?php echo $i?></td>
					<td><img src="../uploads/sto/<?php echo $folder_sto . DS?>/images/<?php echo $image['image_file']?>" width="200" height="100"  /></td>
					<td><?php echo number_format($filesize, 0, '.', ' '); ?></td>
					<td><a href="index.php?option=com_apdmpns&task=download_img_so&so_id=<?php echo $this->sto_row->pns_sto_id?>&id=<?php echo $image['id']?>" title="Click here to download file"><img src="images/download_f2.png" width="20" height="20" /></a>&nbsp;&nbsp;
                                                <?php
                                            //   if ($this->so_row->pns_life_cycle =='Create') {                       
                                                ?>
					<a href="index.php?option=com_apdmpns&task=remove_imgs_so&so_id=<?php echo $this->sto_row->pns_sto_id?>&id=<?php echo $image['id']?>&remove=<?php echo $i.time();?>" title="Click to remove" onclick="if ( confirm('Are you sure to delete it ? ') ) { return true;} else {return false;} "><img src="images/cancel_f2.png" width="15" height="15" /></a>
                                         <?php
                                               //}
                                                ?>
                                        </td>
				</tr>
				<?php $i++; } ?>
				
				<tr>
					
					<td colspan="4" align="center">
					<a href="index.php?option=com_apdmpns&task=download_all_images_so&tmpl=component&so_id=<?php echo $this->sto_row->pns_sto_id;?>" title="Download All Files">
                                        <input type="button" name="addVendor" value="<?php echo JText::_('Download All Files')?>"/>
                                        </a>&nbsp;&nbsp;

<!--					<input type="button" value="<?php echo JText::_('Remove All Files')?>" onclick="if ( confirm ('Are you sure to delete it ?')) { window.location.href='index.php?option=com_apdmpns&task=remove_all_images&pns_id=<?php echo $this->row->pns_id?>' }else{ return false;}" /></td>					-->
				</tr>
								
					</table>
					</td>                                        
                                        
				</tr>
				<?php } ?>
                <tr>
					<td class="key">
						<label for="ccs_create">
							Image
						</label>
					</td>
					<td>

						<input type="hidden" name="old_pns_image" value="<?php echo $this->row->pns_image;?>" />
                                                <div class="iptfichier_image">
                                                 <span id="1">
							<input type="file" name="pns_image1" /> 
						</span>
						<span id="2">
							<input type="file" name="pns_image2" /> 
						</span>
						<span id="3">
							<input type="file" name="pns_image3" /> 
						</span>
						<span id="4">
							<input type="file" name="pns_image4" /> 
						</span>
						<span id="5">
							<input type="file" name="pns_image5" /> 
						</span>
						<span id="6">
							<input type="file" name="pns_image6" /> 
						</span>
						<span id="7">
							<input type="file" name="pns_image7" /> 
						</span>
						<span id="8">
							<input type="file" name="pns_image8" /> 
						</span>
						<span id="9">
							<input type="file" name="pns_image9" /> 
						</span>   
						<span id="10">
							<input type="file" name="pns_image10" /> 
						</span>                                                           
                                                </div>
                                                <br />
                                                <a href="javascript:;"id="lnkfichier_image" title="<?php echo JText::_('Click here to add more Images');?>" ><?php echo JText::_('Click here to add more Images');?></a>
					</td>
                                        </tr> 
                                                    
                                <?php if (isset($this->lists['pdf_files'])&& count($this->lists['pdf_files'])>0) {?>
				<tr>
                                        <td colspan="2" >
					<table width="100%"  class="adminlist" cellpadding="1">
						<hr />
						<thead>
							<th colspan="4"><?php echo JText::_('List PDF')?></th>
						</thead>
						<tr>
							<td width="5%"><strong><?php echo JText::_('No.')?></strong></td>
							<td width="45%"><strong><?php echo JText::_('Name')?> </strong></td>
							<td width="30%"><strong><?php echo JText::_('Size (KB)')?> </strong></td>
							<td width="20%"><strong><?php echo JText::_('Download')?>  <?php echo JText::_('Remove')?></strong></td>
						</tr>
				<?php
				
				$i = 1;				                   
				foreach ($this->lists['pdf_files'] as $pdf) {
					$filesize = SToController::readfilesizeSto($folder_sto, $pdf['pdf_file'],'pdfs');
				?>
				<tr>
					<td><?php echo $i?></td>
					<td><?php echo $pdf['pdf_file']?></td>
					<td><?php echo number_format($filesize, 0, '.', ' '); ?></td>
					<td><a href="index.php?option=com_apdmpns&task=download_pdfs_so&so_id=<?php echo $this->sto_row->pns_sto_id?>&id=<?php echo $pdf['id']?>" title="Click here to download file"><img src="images/download_f2.png" width="20" height="20" /></a>&nbsp;&nbsp;
                                                 <?php
                                           //    if ($this->row->pns_life_cycle =='Create') {                       
                                                ?>
					<a href="index.php?option=com_apdmpns&task=remove_pdfs_so&so_id=<?php echo $this->sto_row->pns_sto_id?>&id=<?php echo $pdf['id']?>&remove=<?php echo $i.time();?>" title="Click to remove" onclick="if ( confirm('Are you sure to delete it ? ') ) { return true;} else {return false;} "><img src="images/cancel_f2.png" width="15" height="15" /></a>
                                         <?php
                                           //    }
                                                ?>
                                        </td>
				</tr>
				<?php $i++; } ?>
				
				<tr>
					
					<td colspan="4" align="center">
				<a href="index.php?option=com_apdmpns&task=download_all_pdfs_so&tmpl=component&so_id=<?php echo $this->sto_row->pns_sto_id;?>" title="Download All Files">
                                        <input type="button" name="addVendor" value="<?php echo JText::_('Download All Files')?>"/>
                                        </a>&nbsp;&nbsp;

<!--					<input type="button" value="<?php echo JText::_('Remove All Files')?>" onclick="if ( confirm ('Are you sure to delete it ?')) { window.location.href='index.php?option=com_apdmpns&task=remove_all_pdfs&pns_id=<?php echo $this->row->pns_id?>' }else{ return false;}" /></td>					-->
				</tr>
								
					</table>
					</td>                                        
                                        
				</tr>
				<?php } ?>  
                                        <tr><td class="key">
						<label for="ccs_create">
							PDF
						</label>
					</td>
					<td>
<!--						<input type="file" name="pns_pdf" />-->
						<input type="hidden" name="old_pns_pdf" value="<?php echo $this->row->pns_pdf;?>" />
                                                
					
                                                <div class="iptfichier_pdf">
                                                 <span id="1">
							<input type="file" name="pns_pdf1" /> 
						</span>
						<span id="2">
							<input type="file" name="pns_pdf2" /> 
						</span>
						<span id="3">
							<input type="file" name="pns_pdf3" /> 
						</span>
						<span id="4">
							<input type="file" name="pns_pdf4" /> 
						</span>
                                                 <span id="5">
							<input type="file" name="pns_pdf5" /> 
						</span>
						<span id="6">
							<input type="file" name="pns_pdf6" /> 
						</span>
						<span id="7">
							<input type="file" name="pns_pdf7" /> 
						</span>
						<span id="8">
							<input type="file" name="pns_pdf8" /> 
						</span>
						<span id="9">
							<input type="file" name="pns_pdf9" /> 
						</span>
						<span id="10">
							<input type="file" name="pns_pdf10" /> 
						</span>                                                        
                                                </div>
                                                <br />
                                                <a href="javascript:;"id="lnkfichier_pdf" title="<?php echo JText::_('Click here to add more pdf');?>" ><?php echo JText::_('Click here to add more pdf');?></a>
                                        </td>
                        <?php if (count($this->lists['zips_files']) > 0) {
				?>				
				<tr>
					<td colspan="2" >
					<table width="100%"  class="adminlist" cellpadding="1">
						<hr />
						<thead>
							<th colspan="4"><?php echo JText::_('List ZIP')?></th>
						</thead>
						<tr>
							<td width="5%"><strong><?php echo JText::_('No.')?></strong></td>
							<td width="45%"><strong><?php echo JText::_('Name')?> </strong></td>
							<td width="30%"><strong><?php echo JText::_('Size (KB)')?> </strong></td>
							<td width="20%"><strong><?php echo JText::_('Download')?>  <?php echo JText::_('Remove')?></strong></td>
						</tr>
				<?php
				
				$i = 1;
				                        
				foreach ($this->lists['zips_files'] as $cad) {
					$filesize = SToController::readfilesizeSto($folder_sto, $cad['zip_file'],'zips');                                        				
				?>
				<tr>
					<td><?php echo $i?></td>
					<td><?php echo $cad['zip_file']?></td>
					<td><?php echo number_format($filesize, 0, '.', ' '); ?></td>
					<td><a href="index.php?option=com_apdmpns&task=download_zip_so&id=<?php echo $cad['id']?>" title="Click here to download file"><img src="images/download_f2.png" width="20" height="20" /></a>&nbsp;&nbsp;
                                                 <?php
                                             //  if ($this->row->pns_life_cycle =='Create') {                       
                                                ?>
					<a href="index.php?option=com_apdmpns&task=remove_zip_so&so_id=<?php echo $this->sto_row->pns_sto_id?>&id=<?php echo $cad['id']?>&remove=<?php echo $i.time();?>" title="Click to remove" onclick="if ( confirm('Are you sure to delete it ? ') ) { return true;} else {return false;} "><img src="images/cancel_f2.png" width="15" height="15" /></a>
                                         <?php
                                          //     }
                                                ?>
                                        </td>
				</tr>
				<?php $i++; } ?>
				
				<tr>
					
					<td colspan="4" align="center">
                                                <a href="index.php?option=com_apdmpns&task=download_all_cads_so&tmpl=component&so_id=<?php echo $this->sto_row->pns_sto_id;?>" title="Download All Files">
                                                <input type="button" name="addVendor" value="<?php echo JText::_('Download All Files')?>"/>
                                                </a>&nbsp;&nbsp;
				
<!--					<input type="button" value="<?php echo JText::_('Remove All Files')?>" onclick="if ( confirm ('Are you sure to delete it ?')) { window.location.href='index.php?option=com_apdmpns&task=remove_all_cad&pns_id=<?php echo $this->row->pns_id?>' }else{ return false;}" /></td>					-->
				</tr>
				
					</table>
					</td>
				</tr>
				<?php } ?>                                        
				</tr>		
<tr>
					<td class="key" valign="top">
						<label for="ccs_create">
							<?php echo JText::_('ZIP')?>
						</label>
					</td>
					<td>
					<div class="iptfichier">
						<span id="1">
							<input type="file" name="pns_zip1" /> 
						</span>
						<span id="2">
							<input type="file" name="pns_zip2" /> 
						</span>
						<span id="3">
							<input type="file" name="pns_zip3" /> 
						</span>
						<span id="4">
							<input type="file" name="pns_zip4" /> 
						</span>
						<span id="5">
							<input type="file" name="pns_zip5" /> 
						</span>
						<span id="6">
							<input type="file" name="pns_zip6" /> 
						</span>
						<span id="7">
							<input type="file" name="pns_zip7" /> 
						</span>
						<span id="8">
							<input type="file" name="pns_zip8" /> 
						</span>
						<span id="9">
							<input type="file" name="pns_zip9" /> 
						</span>
						<span id="10">
							<input type="file" name="pns_zip10" /> 
						</span>
						<span id="11">
							<input type="file" name="pns_zip11" /> 
						</span>
						<span id="12">
							<input type="file" name="pns_zip12" /> 
						</span>
						<span id="13">
							<input type="file" name="pns_zip13" /> 
						</span>
						<span id="14">
							<input type="file" name="pns_zip14" /> 
						</span>
						<span id="15">
							<input type="file" name="pns_zip15" /> 
						</span>
						<span id="16">
							<input type="file" name="pns_zip16" /> 
						</span>
						<span id="17">
							<input type="file" name="pns_zip17" /> 
						</span>
						<span id="18">
							<input type="file" name="pns_zip18" /> 
						</span>
						<span id="19">
							<input type="file" name="pns_zip19" /> 
						</span>
						<span id="20">
							<input type="file" name="pns_zip20" /> 
						</span>
					</div>
						<br />
						<a href="javascript:;"id="lnkfichier" title="<?php echo JText::_('Click here to add more ZIP files');?>" ><?php echo JText::_('Click here to add more ZIP files');?></a>
					</td>
				</tr>                                
                                          </table>
                </fieldset>
</div>	
        </fieldset>
        <input type="hidden" name="sto_id" value="<?php echo $this->sto_row->pns_sto_id; ?>" />
        <input type="hidden" name="option" value="com_apdmsto" />     
        <input type="hidden" name="id" value="<?php echo JRequest::getVar('id'); ?>" />     
	<input type="hidden" name="task" value="save_doc_sto" />	
        <input type="hidden" name="return" value="ito_detail_support_doc"  />
        <input type="hidden" name="boxchecked" value="1" />
<?php echo JHTML::_('form.token'); ?>
</form>
