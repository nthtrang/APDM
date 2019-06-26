<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.tooltip'); ?>
<?php JHTML::_('behavior.modal'); ?>
<?php	
        $edit = JRequest::getVar('edit',true);
        $text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
        JToolBarHelper::title("Edit SO: ".$this->so_row->so_cuscode, 'cpanel.png');
        JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

        $role = JAdministrator::RoleOnComponent(10);     
        JToolBarHelper::apply('save_editso', 'Save');
        if ( $edit ) {
        // for existing items the button is renamed `close`
                JToolBarHelper::cancel( 'somanagement', 'Close' );
        } else {
                JToolBarHelper::cancel();
        }
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
                        window.location = "index.php?option=com_apdmpns&task=so_detail&id="+form.so_id.value;
                        return;
                }
                var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&]", "i");
                if (form.customer_id.value==0){
                        alert("Please select Commodity Code");
                        form.customer_id.focus();
                        return false;
                }
                if (form.so_cuscode.value==0){
			alert("Please input External PO");
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
                so_shipping_date = so_shipping_date.setHours(0,0,0,0);
                var so_start_date = new Date(form.so_start_date.value);  
                so_start_date = so_start_date.setHours(0,0,0,0);
                if (form.so_shipping_date.value==0){
					alert("Please input Shipping Request Date");
					form.so_shipping_date.focus();
					return false;
				}  
//                if (current_date > so_shipping_date ) 
//                {
//                    alert("Invalid Date Range!\nShipping Request Date cannot be before Today!")
//                    return false;
//                }
                if (so_shipping_date < so_start_date ) 
                {
                    alert("Invalid Date Range!\nShipping Date cannot be before StartDate!")
                    return false;
                }
                //check max WO finish date
                var max_wo_completed  = new Date(form.max_wo_completed.value);
                max_wo_completed = max_wo_completed.setHours(0,0,0,0);   
				var so_start_date_old	= new Date(form.so_start_date_old.value);
                so_start_date_old = so_start_date_old.setHours(0,0,0,0); 		
				if(so_start_date_old!= so_shipping_date)
				{
					if(max_wo_completed)
					{						
							if (so_shipping_date < max_wo_completed ) 
							{
								alert("Invalid Date Range!\nShipping Date cannot be before WO Complete belong this SO!")
								return false;
							}  
					}
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
		<legend><?php echo JText::_( 'Edit SO' ); ?></legend>
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
                                                <input type="text"  name="so_coordinator" id="so_coordinator" class="inputbox" size="30" value="<?php echo PNsController::getcoordinatorso($this->so_row->ccs_so_code);?>"/>						
					</td>
				</tr>
                                 <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'External PO' ); ?>
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
                                               <?php echo JHTML::_('calendar',$this->so_row->so_shipping_date, 'so_shipping_date', 'so_shipping_date', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	
					</td>
				</tr>      
                                 <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Start Date' ); ?>
						</label>
					</td>
					<td>   
                                                 <input type="hidden" maxlength="20" name="max_wo_completed"  id="max_wo_completed" class="inputbox" size="30" value="<?php echo $this->so_row->max_wo_completed;?>"/>
												 <input type="hidden" maxlength="20" name="so_start_date_old"  id="so_start_date_old" class="inputbox" size="30" value="<?php echo $this->so_row->so_start_date;?>"/>
                                               <?php echo JHTML::_('calendar',$this->so_row->so_start_date, 'so_start_date', 'so_start_date', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	
					</td>
				</tr>    
                                
                                <tr>
					<td class="key" colspan="2" id='pns_child_so' >
						<?php 
                                                $str = '<table class="admintable" cellspacing="1" width="100%"><tr>'.
                        '<td class="key">#</td>'.
                        '<td class="key">TOP ASSY PN</td>'.
                        '<td class="key">Description</td>'.
                        '<td class="key">Qty</td>'.
                        '<td class="key">UOM</td>'.
                        '<td class="key">Unit Price</td>'.
                        '<td class="key">F.A Required</td>'.
                        '<td class="key">ESD Required</td>'.
                        '<td class="key">COC Required</td></tr>'.
                        '<tr><td><input type="hidden" name="boxcheckedpn" value="'.count($this->so_pn_list).'" /></td></tr>';
                                                
                foreach ($this->so_pn_list as $row) {
                         if ($row->pns_revision) {
                                $pnNumber = $row->ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                        } else {
                                $pnNumber = $row->ccs_code . '-' . $row->pns_code;
                        }  
                        $fachecked="";
                        if($row->fa_required)
                                $fachecked = 'checked="checked"';
                        $esdchecked="";
                        if($row->esd_required)
                                $esdchecked = 'checked="checked"';
                        $cocchecked="";
                        if($row->coc_required)
                                $cocchecked = 'checked="checked"';
                                
                        $str .= '<tr>'.
                                ' <td><input checked="checked" type="checkbox" name="pns_child[]" value="' . $row->pns_id . '" /> </td>'.
                                ' <td class="key">'.$pnNumber.'</td>'.
                                ' <td class="key">'.$row->pns_description.'</td>'.
                                ' <td class="key"><input style="width: 70px" onKeyPress="return numbersOnlyEspecialFloat(this, event);" type="text" value="'.$row->qty.'" id="qty['.$row->pns_id.']"  name="qty['.$row->pns_id.']" /></td>'.
                                ' <td class="key">'.$row->pns_uom.'</td>'.
                                ' <td class="key"><input style="width: 70px" onKeyPress="return numbersOnlyEspecialFloat(this, event);" type="text" value="'.$row->price.'" id="price['.$row->pns_id.']"  name="price['.$row->pns_id.']" /></td>'.
                                ' <td class="key"><input '.$fachecked.' type="checkbox" name="fa_required['.$row->pns_id.']" value="1" /> </td>'.
                                ' <td class="key"><input '.$esdchecked.'  type="checkbox" name="esd_required['.$row->pns_id.']" value="1" /> </td>'.
                                ' <td class="key"><input '.$cocchecked.'  type="checkbox" name="coc_required['.$row->pns_id.']" value="1" /> </td>';
                }
                $str .='</table>';
                echo $str;
                                                ?>                                                                                                                                          
					</td>
					
				</tr>                                  
                               <tr>
					<td class="key" valign="top">
						
					</td>
					<td valign="top">						
							<a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmpns&task=get_list_pns_so_edit&tmpl=component&so_id=<?php echo $this->so_row->pns_so_id?>" title="<?php echo JText::_('click here to add more PN')?>"><?php echo JText::_('click here to add more PN')?></a>			
						
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
<!--						<textarea name="so_log1" rows="10" cols="40"><?php echo $this->so_row->so_log?></textarea>-->                                                
                                                <?php                                     
                                                $editor =& JFactory::getEditor();                                                
                                                     echo $editor->display('so_log', $this->so_row->so_log, '5%', '5', '10', '1',false);
                                        ?>
					</td>
				</tr>                                                               		
			</table>
                </fieldset>
         </div>
                
	<input type="hidden" name="so_id" value="<?php echo $this->so_row->pns_so_id?>"  />	
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="return" value="so"  />
	<input type="hidden" name="task" value="save_sales_order" />        
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
