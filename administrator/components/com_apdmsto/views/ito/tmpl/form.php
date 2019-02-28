<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

	JToolBarHelper::title( JText::_( 'ITO' ) . ': <small><small>[ '. $text .' ]</small></small>' , 'generic.png' );
	if (!intval($edit)) {
	//	JToolBarHelper::save('save', 'Save & Add new');
	}	
	JToolBarHelper::apply('save_ito', 'Save');
	
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
function UpdatePnsRevWindow(){        				
        window.parent.document.getElementById('sbox-window').close();	       
     // window.parent.document.location.reload(true);
        window.parent.document.location.href = "index.php?option=com_apdmpns&task=stomanagement&time=<?php echo time();?>";
     //   setTimeout("window.parent.document.getElementById('sbox-window').close();",1000);
       //setTimeout( "window.document.getElementById('sbox-window').close();window.parent.document.location.reload();", 2000 );
}
function get_default_ito_prefix(){		
		var url = 'index.php?option=com_apdmsto&task=get_sto_code_default&sto_type=1';				
		var MyAjax = new Ajax(url, {
			method:'get',
			onComplete:function(result){				
				$('sto_code').value = result.trim();
			}
		}).request();
	}
        get_default_ito_prefix();
		
      
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
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">
	<div class="col width-60">
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
						<input type="text" readonly="readonly" name="sto_code" id="sto_code"  size="10" value=""/>                                               
					</td>
				</tr>
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'P.O Internal' ); ?>
						</label>
					</td>
					<td>
						<input type="text" name="po_inter_code" id="po_inter_code"  size="10" value=""/>                                               
					</td>
				</tr>                                
                                 <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Created Date' ); ?>
						</label>
					</td>
					<td>                                                 
                                               <?php echo JHTML::_('calendar',$this->sto_row->sto_created, 'sto_created', 'sto_created', '%m/%d/%Y', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	
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
						<textarea name="sto_description" rows="10" cols="60"><?php echo $this->sto_row->sto_code?></textarea>
					</td>
				</tr>  
                                 
                                
                                 <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Owner' ); ?>
						</label>
					</td>
                                 <td  width="16%">
                                                                <select name="sto_owner" id="sto_owner" >
                                                                        <option value="">Select Owner</option>
                                        <?php foreach ($this->list_user as $list) { ?>
                                                                                <option value="<?php echo $list->id; ?>"><?php echo $list->name; ?></option>
                                                <?php } ?>
                                                                </select>
                                                        </td>
                                 </tr>                              
			</table>                	
        </fieldset>
        </div>
		<div class="col width-100">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Image, Pdf, Zip files' ); ?> <font color="#FF0000"><em><?php echo JText::_('(Please upload file less than 20Mb)')?></em></font></legend>
                <table class="adminlist">
                        
              
                <tr>
					<td class="key">
						<label for="ccs_create">
							<?php echo JText::_('IMAGE')?>
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
                                        <tr><td class="key">
						<label for="ccs_create">
							<?php echo JText::_('P/N PDF')?>
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
				</tr>		
<tr>
					<td class="key" valign="top">
						<label for="ccs_create">
							<?php echo JText::_('P/N Zip')?>
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
						<a href="javascript:;"id="lnkfichier" title="<?php echo JText::_('Click here to add more CAD files');?>" ><?php echo JText::_('Click here to add more ZIP files');?></a>
					</td>
				</tr>                                
                                          </table>
                </fieldset>
				</div>
				<input type="hidden" name="pns_id" value="<?php echo  $cid[0];?>" />	
	<input type="hidden" name="option" value="com_apdmsto" />
	<input type="hidden" name="return" value="sto"  />
	<input type="hidden" name="task" value="save_ito" />     
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
