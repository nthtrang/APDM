<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php JHTML::_('behavior.modal'); ?>
<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
    $folder_sto = $this->sto_row->sto_code;
	JToolBarHelper::title( $this->sto_row->sto_code. ': <small><small>[ '. $text .' ]</small></small>' , 'generic.png' );
	if (!intval($edit)) {
	//	JToolBarHelper::save('save', 'Save & Add new');
	}	
	JToolBarHelper::apply('save_editito', 'Save');
	
	if ( $edit ) {
		// for existing items the button is renamed `close`
		JToolBarHelper::cancel( 'cancel', 'Close' );
	} else {
		JToolBarHelper::cancel();
	}
	
	$cparams = JComponentHelper::getParams ('com_media');
?>
<?php	
//poup add rev roll
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	
?>
<script language="javascript" type="text/javascript">
 window.addEvent('domready', function(){ var JTooltips = new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false}); });
		window.addEvent('domready', function() {

			SqueezeBox.initialize({});

			$$('a.modal-button').each(function(el) {
				el.addEvent('click', function(e) {
					new Event(e).stop();
					SqueezeBox.fromElement(el);
				});
			});
		});
                
                 window.addEvent('domready', function() {

                SqueezeBox.initialize({});

                $$('a.modal').each(function(el) {
                        el.addEvent('click', function(e) {
                                new Event(e).stop();
                                SqueezeBox.fromElement(el);
                        });
                });
        });
        
///for add more file
	window.addEvent('domready', function(){
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
                                         
		});
 window.addEvent('domready', function(){ var JTooltips = new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false}); });
 window.addEvent('domready', function() {

     SqueezeBox.initialize({});

     $$('a.modal-button').each(function(el) {
         el.addEvent('click', function(e) {
             new Event(e).stop();
             SqueezeBox.fromElement(el);
         });
     });
 });
</script>
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">
	<div class="col width-40">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'ITO Detail' ); ?></legend>
			<table class="admintable" cellspacing="1">
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'ITO Number' ); ?>
						</label>
					</td>
					<td>
						<input type="text" readonly="readonly" name="sto_code" id="sto_code"  size="10" value="<?php echo $this->sto_row->sto_code?>"/>                                               
					</td>
				</tr>
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'P.O Internal' ); ?>
						</label>
					</td>
                    <td>
                        <?php //echo $this->lists['wolist'];?>
                        <input type="hidden" value="" name="po_id" id="po_id" readonly="readonly" />
                        <input type="text" name="po_inter_code" id="po_inter_code"  size="10" value="<?php echo $this->sto_row->sto_po_internal?>"/>
                        <a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmsto&task=get_po_ajax&tmpl=component" title="Image">
                            <input type="button" name="addPO" value="<?php echo JText::_('Insert P.O Internal')?>"/>
                        </a>
                    </td>
				</tr>
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Supplier' ); ?>
						</label>                                                
					</td>
					<td>												 
                                                <?php echo $this->lists['ccsupplier'];?>                                                                                                 
					</td>
				</tr>	
				<tr>
					<td class="key" valign="top">
						<label for="stocker">
							<?php echo JText::_( 'Stoker confirm' ); ?>
						</label>
					</td>
					<td>
                            <input type="checkbox" id ="stocker_confirm" name="stocker_confirm" checked="checked" value="1" /> 
					</td>
				</tr>              				
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Description' ); ?>
						</label>
					</td>
					<td>						
						<textarea name="sto_description" rows="10" cols="60"><?php echo $this->sto_row->sto_description?></textarea>
					</td>
				</tr>  
                                <tr>
                                        <td  class="key" width="28%"><?php echo JText::_('Confirm'); ?></td>                                               
                                        <td width="30%" class="title"> 
										 <?php 
                                                     if(!$this->sto_row->sto_owner_confirm){

                                                    ?>
                                                  
                                                   
                                                   <a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmsto&task=get_owner_confirm_sto&sto_id=<?php echo $this->sto_row->pns_sto_id?>&tmpl=component" title="Image">
                                                         <input onclick="return false;" onkeydown="return false;" type="checkbox" name="sto_owner_confirm" value="1" /></a>
                                                        <?php }
                                                        else
                                                        {
                                                                       ?>
                                                <input checked="checked" onclick="return false;" onkeydown="return false;" type="checkbox" name="sto_owner_confirm" value="1" />
                                                                       <?php
                                                        }
                                                        ?>
                                        </td>  
                                </tr>
                                
                                 <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Owner' ); ?>
						</label>
					</td>
                                 <td  width="16%">
                                      <?php echo ($this->sto_row->sto_owner)?GetValueUser($this->sto_row->sto_owner, "name"):""; ?>
                                                        </td>
                                 </tr>                              
			</table>                	
        </fieldset>
        </div>
                <div class="col width-60">
                <fieldset class="adminform">
		<legend><?php echo JText::_( 'Documents' ); ?> <font color="#FF0000"><em><?php echo JText::_('(Please upload file less than 20Mb)')?></em></font></legend>
                <table class="adminlist">                        
              <?php if (isset($this->lists['image_files'])&& count($this->lists['image_files'])>0) {?>
				<tr>
                                        <td colspan="2" >
					<table width="100%"  class="adminlist" cellpadding="1">
						
						<thead>
							<th colspan="4"><?php echo JText::_('List Documents')?></th>
						</thead>
						<tr>
							<td width="5%"><strong><?php echo JText::_('No.')?></strong></td>
							<td width="45%"><strong><?php echo JText::_('Name')?> </strong></td>
							<td width="30%"><strong><?php echo JText::_('Size (KB)')?> </strong></td>
							<td width="20%"><strong><?php echo JText::_('Download')?>  <?php echo JText::_('Remove')?></strong></td>
						</tr>
				<?php
				
				$i = 1;
				foreach ($this->lists['image_files'] as $image) {
					$filesize = SToController::readfilesizeSto($folder_sto, $image['image_file'],'images');
				?>
				<tr>
					<td><?php echo $i?></td>
					<td><?php echo $image['image_file']?></td>
					<td><?php echo number_format($filesize, 0, '.', ' '); ?></td>
					<td><a href="index.php?option=com_apdmsto&task=download_doc_sto&type=images&sto_id=<?php echo $this->sto_row->pns_sto_id?>&id=<?php echo $image['id']?>" title="Click here to download file"><img src="images/download_f2.png" width="20" height="20" /></a>&nbsp;&nbsp;
                                                <?php
                                               if ($this->sto_row->sto_state  != "Done") {                       
                                                ?>
					<a href="index.php?option=com_apdmsto&task=remove_doc_sto&back=ito_detail&type=images&sto_id=<?php echo $this->sto_row->pns_sto_id?>&id=<?php echo $image['id']?>&remove=<?php echo $i.time();?>" title="Click to remove" onclick="if ( confirm('Are you sure to delete it ? ') ) { return true;} else {return false;} "><img src="images/cancel_f2.png" width="15" height="15" /></a>
                                         <?php
                                               }
                                                ?>
                                        </td>
				</tr>
				<?php $i++; } ?>
				
				<tr>
					
					<td colspan="4" align="center">
					<a href="index.php?option=com_apdmsto&task=download_all_doc_sto&type=images&tmpl=component&sto_id=<?php echo $this->sto_row->pns_sto_id;?>" title="Download All Files">
                                        <input type="button" name="addVendor" value="<?php echo JText::_('Download All Files')?>"/>
                                        </a>&nbsp;&nbsp;

<!--					<input type="button" value="<?php echo JText::_('Remove All Files')?>" onclick="if ( confirm ('Are you sure to delete it ?')) { window.location.href='index.php?option=com_apdmpns&task=remove_all_images&pns_id=<?php echo $this->row->pns_id?>' }else{ return false;}" /></td>					-->
				</tr>
								
					</table>
					</td>                                        
                                        
				</tr>
				<?php } ?>
                <tr>
					
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
                                                <a href="javascript:;"id="lnkfichier_image" title="<?php echo JText::_('Click here to add more files');?>" ><?php echo JText::_('Click here to add more files');?></a>
					</td>
                                        </tr> 
                                          </table>
                </fieldset>
        </div>
		
				<input type="hidden" name="pns_sto_id" value="<?php echo $this->sto_row->pns_sto_id?>" />
	<input type="hidden" name="option" value="com_apdmsto" />
	<input type="hidden" name="return" value="sto"  />
	<input type="hidden" name="task" value="save_editito" />     
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
