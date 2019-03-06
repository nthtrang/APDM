<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.tooltip'); ?>
<?php JHTML::_('behavior.modal'); ?>
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
                            <?php //echo $this->lists['wolist'];?>
                            <input type="hidden" value="" name="po_id" id="po_id" readonly="readonly" />
                            <input type="text" name="po_inter_code" id="po_inter_code"  size="10" value=""/>
                            <a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmsto&task=get_po_ajax&tmpl=component" title="Image">
                                <input type="button" name="addPO" value="<?php echo JText::_('Insert P.O Internal')?>"/>
                            </a>
                        </td>
				</tr>
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
                                 
                                <!--
                                 <tr>
					<td class="key">
						<label for="name">
							<?php /*echo JText::_( 'Owner' ); */?>
						</label>
					</td>
                                 <td  width="16%">
                                                                <select name="sto_owner" id="sto_owner" >
                                                                        <option value="">Select Owner</option>
                                        <?php /*foreach ($this->list_user as $list) { */?>
                                                                                <option value="<?php /*echo $list->id; */?>"><?php /*echo $list->name; */?></option>
                                                <?php /*} */?>
                                                                </select>
                                                        </td>
                                 </tr>         -->
			</table>                	
        </fieldset>
        </div>
		<div class="col width-100">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Documents' ); ?> <font color="#FF0000"><em><?php echo JText::_('(Please upload file less than 20Mb)')?></em></font></legend>
                <table class="adminlist">             
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
                                               <!-- <a href="javascript:;"id="lnkfichier_image" title="<?php /*echo JText::_('Click here to add more files');*/?>" ><?php /*echo JText::_('Click here to add more files');*/?></a>-->
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
