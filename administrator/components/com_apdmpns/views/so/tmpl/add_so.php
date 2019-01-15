<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.tooltip'); ?>
<?php JHTML::_('behavior.modal'); ?>
<?php	
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
        
        JToolBarHelper::title( JText::_( 'SO GENERATION' ) . ': <small><small>[ New ]</small></small>' , 'cpanel.png' );
        JToolBarHelper::apply('save_sales_order', 'Save');
	if ( $edit ) {
		// for existing items the button is renamed `close`
		JToolBarHelper::cancel('somanagement', 'Close' );
	} else {
		JToolBarHelper::cancel();
	}
        // clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );
	
?>

<script language="javascript" type="text/javascript">
function getccsCoordinator(ccs_code)
{
        var url = 'index.php?option=com_apdmccs&task=getcoordinator&ccs_code='+ccs_code;				
        var MyAjax = new Ajax(url, {
                method:'get',
                onComplete:function(result){				
                        $('so_coordinator').value = result.trim();
                }
        }).request();
}
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'somanagement') {
			submitform( pressbutton );
			return false;
		}
		var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&]", "i");
		if (form.customer_id.value==0){
			alert("Please select Commodity Code");
			form.customer_id.focus();
			return false;
		}                
                if (form.so_cuscode.value==0){
			alert("Please input PO# of Customer");
			form.so_cuscode.focus();
			return false;
		}  
                if (form.boxcheckedpn.value==0){
			alert("Please select a TOP ASSY PN");			
			return false;
		}
                else
                {
                        var cpn = document.getElementsByName('pns_child[]');
                        var len = cpn.length;
                        for (var i=0; i<len; i++) {
                               // alert(i + (cpn[i].checked?' checked ':' unchecked ') + cpn[i].value);
                                var qty_value = document.getElementById('qty[' +cpn[i].value+']').value;
                                var price_value = document.getElementById('price[' +cpn[i].value+']').value;
                                if(qty_value==0)
                                {
                                        alert("Please input QTY for PN");    
                                        document.getElementById('qty[' +cpn[i].value+']').focus();
                                        return false;
                                }
                                if(price_value==0)
                                {
                                        alert("Please input Price for PN");      
                                        document.getElementById('price[' +cpn[i].value+']').focus();
                                        return false;
                                }
                        }
                       // submitform( pressbutton );
                }
                
                
                var date = new Date();
                current_month = date.getMonth()+1;
                var current_date = date.getFullYear()+"-"+current_month+"-"+ (date.getDate() < 10 ? "0"+date.getDate() : date.getDate());                
                var current_date = new Date(current_date);
                var so_shipping_date = new Date(form.so_shipping_date.value);
                var so_start_date = new Date(form.so_start_date.value);  
                if (form.so_shipping_date.value==0){
			alert("Please input Shipping Request Date");
			form.so_shipping_date.focus();
			return false;
		}  
                if (current_date > so_shipping_date ) 
                {
                    alert("Invalid Date Range!\nShipping Request Date cannot be before Today!")
                    return false;
                }
                if (so_shipping_date < so_start_date ) 
                {
                    alert("Invalid Date Range!\nShipping Date cannot be before StartDate!")
                    return false;
                }
		submitform( pressbutton );
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
function jInsertEditorText( text, editor ) {
			tinyMCE.execInstanceCommand(editor, 'mceInsertContent',false,text);
		}
		window.addEvent('domready', function() {

			SqueezeBox.initialize({});

			$$('a.modal').each(function(el) {
				el.addEvent('click', function(e) {
					new Event(e).stop();
					SqueezeBox.fromElement(el);
				});
			});
		});
			function insertReadmore(editor) {
				var content = tinyMCE.getContent();
				if (content.match(/<hr\s+id=("|')system-readmore("|')\s*\/*>/i)) {
					alert('There is already a Read more... link that has been inserted. Only one such link is permitted. Use {pagebreak} to split the page up further.');
					return false;
				} else {
					jInsertEditorText('<hr id="system-readmore" />', editor);
				}
			}
function numbersOnlyEspecialFloat(myfield, e, dec){
       
	 var key;
	 var keychar;
	 if (window.event)
		key = window.event.keyCode;
	 else if (e)
		key = e.which;
	 else
		return true;
	 keychar = String.fromCharCode(key);
	 // control keys

	 if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27)|| (key==46) ) return true;
	 // numbers
	 else if ((("0123456789$").indexOf(keychar) > -1))
		return true;
	 // decimal point jump
	 else if (dec && (keychar == "."))
		{
		myfield.form.elements[dec].focus();
		return false;
		}
	 else
		return false;
}
</script>

<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data" >
	 <div class="col width-100">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'SO Detail' ); ?></legend>
        <table class="admintable" cellspacing="1" width="100%">
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Customer' ); ?>
						</label>
					</td>
					<td>
                                                   <?php echo $this->lists['ccscpn'];?>       
                                                <a href="index.php?option=com_apdmccs&task=addcustomer&back=so"><?php echo JText::_('Generate Customer')?></a>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="text"  name="so_coordinator" id="so_coordinator" class="inputbox" size="30" value="<?php echo $this->so_row->so_coordinator;?>"/>						
					</td>
				</tr>
                                 <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'PO# of Customer' ); ?>
						</label>
					</td>
					<td>                                                 
                                                <input type="text" maxlength="20" name="so_cuscode"  id="so_cuscode" class="inputbox" size="30" value="<?php echo $this->so_row->so_cuscode;?>"/>
					</td>
				</tr>                                
                                 <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Shipping Request Date' ); ?>
						</label>
					</td>
					<td>                                                 
                                               <?php echo JHTML::_('calendar',$this->so_row->so_shipping_date, 'so_shipping_date', 'so_shipping_date', '%m/%d/%Y', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	
					</td>
				</tr>      
                                 <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Start Date' ); ?>
						</label>
					</td>
					<td>                                                 
                                               <?php echo JHTML::_('calendar',$this->so_row->so_start_date, 'so_start_date', 'so_start_date', '%m/%d/%Y', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	
					</td>
				</tr>    
                                
                                <tr>
					<td class="key" colspan="2" id='pns_child_so' >
						<table class="admintable" cellspacing="1" width="60%">
                                                <tr>
                                                        <td class="key">TOP ASSY PN</td>
                                                         <td class="key">Description</td>
                                                          <td class="key">Qty</td>
                                                           <td class="key">UOM</td>
                                                            <td class="key">Unit Price</td>
                                                             <td class="key">F.A Required</td>
                                                             <td class="key">ESD Required</td>
                                                             <td class="key">COC Required</td>
                                                          
                                                </tr>
                                                <tr><td><input type="hidden" name="boxcheckedpn" value="0" />
                                                                
                                                        </td></tr>
                                                </table>                                                                                                                                               
					</td>
					
				</tr>             
                               <tr>
					<td class="key" valign="top">
						
					</td>
					<td valign="top">						
							<a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmpns&task=get_list_pns_so&tmpl=component" title="<?php echo JText::_('click here to add more PN')?>"><?php echo JText::_('click here to add more PN')?></a>			
						
					</td>
				</tr>
                                 <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Status' ); ?>
						</label>                                                
					</td>
					<td>												 
                                                <?php echo $this->lists['soStatus'];?>  
                                                <input type="hidden" maxlength="20" name="so_state"  id="so_state" class="inputbox" size="30" value="inprogress"/>
                                                
					</td>
				</tr>	
                                <tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Log' ); ?>
						</label>
					</td>
					<td>
						<textarea maxlength='40' name="pns_description" rows="10" cols="40"><?php echo $this->row->pns_description?></textarea>
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
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="return" value="so"  />
	<input type="hidden" name="task" value="save_sales_order" />        
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
