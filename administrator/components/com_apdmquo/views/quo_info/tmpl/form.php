<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.tooltip'); ?>
<?php JHTML::_('behavior.modal'); 
JHTML::_('behavior.calendar');
?>
<?php	
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
        
        JToolBarHelper::title( JText::_( 'QUOTATION GENERATION' ) . ': <small><small>[ New ]</small></small>' , 'cpanel.png' );
        JToolBarHelper::apply('save_quotation', 'Save');

	JToolBarHelper::cancel( 'cancel', 'Close' );
	
        // clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );
	
?>

<script language="javascript" type="text/javascript">
        function dateEspecialmdy(due)
        {
                alert(due.value)
        }
        function get_default_quo_code(){		
		var url = 'index.php?option=com_apdmquo&task=get_default_quo_code';				
		var MyAjax = new Ajax(url, {
			method:'get',
			onComplete:function(result){				
				$('quo_code').value = result.trim();
			}
		}).request();
	}
        get_default_quo_code();    

	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return false;
		}
		var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&]", "i");
		if (form.customer_id.value==0){
			alert("Please select Commodity Code");
			form.customer_id.focus();
			return false;
		}                
                
                if (form.boxcheckedpn.value==0){
			alert("Please select a PN");			
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
                                var price_extended = document.getElementById('extended[' +cpn[i].value+']').value;
                                
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
                                if(price_extended==0)
                                {
                                        alert("Please input Extened Price for PN");      
                                        document.getElementById('extended[' +cpn[i].value+']').focus();
                                        return false;
                                }
                        }
                       // submitform( pressbutton );
                }
                
                
                var date = new Date();
                current_month = date.getMonth()+1;
                var current_date = date.getFullYear()+"-"+current_month+"-"+ (date.getDate() < 10 ? "0"+date.getDate() : date.getDate());                
                var current_date = new Date(current_date);
                var quo_expire_date = new Date(form.quo_expire_date.value);
                var quo_start_date = new Date(form.quo_start_date.value);  
                if (form.quo_expire_date.value==0){
			alert("Please input Expire Date");
			form.quo_expire_date.focus();
			return false;
		}  
                if (current_date > quo_expire_date ) 
                {
                    alert("Invalid Date Range!\nExpire Date cannot be before Today!")
                    return false;
                }
                if (quo_expire_date < quo_start_date ) 
                {
                    alert("Invalid Date Range!\nExpire Date cannot be before StartDate!")
                    return false;
                }
                submitform( pressbutton );                      		 
	}

                
                
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
		<legend><?php echo JText::_( 'Quotation Detail' ); ?></legend>
        <table class="admintable" cellspacing="1" width="100%">
                        <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Customer' ); ?>
						</label>
					</td>
					<td>
                                                   <?php echo $this->lists['ccscpn'];?>       
                                                <a href="index.php?option=com_apdmccs&task=addcustomer&back=quo"><?php echo JText::_('Generate Customer')?></a>                                                
					</td>
				</tr>
                                <tr>
					
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Quotation Number' ); ?>
						</label>
					</td>
					<td>                                                 
                                                <input type="text"  readonly="readonly" maxlength="20" name="quo_code"  id="quo_code" class="inputbox" size="30" value=""/>
					</td>
				</tr>                                
                                 <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Request Date' ); ?>
						</label>
					</td>
					<td>                                                 
                                               <?php echo JHTML::_('calendar',$this->row->quo_start_date, 'quo_start_date', 'quo_start_date', '%m/%d/%Y', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	
					</td>
				</tr>      
                                 <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Expire Date' ); ?>
						</label>
					</td>
					<td>                                                 
                                               <?php echo JHTML::_('calendar',$this->row->quo_expire_date, 'quo_expire_date', 'quo_expire_date', '%m/%d/%Y', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	
					</td>
				</tr>    
                                
                                <tr>
					<td class="key" colspan="2" id='pns_child_quo' >
						<table class="admintable" cellspacing="1" width="60%">
                                                <tr>
                                                        <td class="key"><?php echo JText::_( 'NUM' ); ?></td>
                                                         <td class="key"><?php echo JText::_( 'PN' ); ?></td>
                                                          <td class="key"><?php echo JText::_( 'Rev' ); ?></td>
                                                           <td class="key"><?php echo JText::_( 'Description' ); ?></td>
                                                            <td class="key"><?php echo JText::_( 'Qty' ); ?></td>
                                                             <td class="key"><?php echo JText::_( 'UOM' ); ?></td>
                                                             <td class="key"><?php echo JText::_( 'Unit Price' ); ?></td>
                                                             <td class="key"><?php echo JText::_( 'Extended' ); ?></td>
                                                             <td class="key"><?php echo JText::_( 'Due Date' ); ?></td>
                                                          <td class="key"></td>
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
							<a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmquo&task=get_list_pns_quo&tmpl=component" title="<?php echo JText::_('click here to add more PN')?>"><?php echo JText::_('click here to add more PN')?></a>			
						
					</td>
				</tr>
                                 <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'State' ); ?>
						</label>                                                
					</td>
					<td>												 
                                                <?php echo "Create";?>  
                                                <input type="hidden" maxlength="20" name="quo_state"  id="quo_state" class="inputbox" size="30" value="Create"/>
                                                
					</td>
				</tr>	                                                                              		
			</table>
                </fieldset>
         </div>
                
	<input type="hidden" name="pns_id" value="<?php echo  $cid[0];?>" />	
	<input type="hidden" name="option" value="com_apdmquo" />
	<input type="hidden" name="return" value="quo"  />
	<input type="hidden" name="task" value="save_quotation" />        
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
