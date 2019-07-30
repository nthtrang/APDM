<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.tooltip'); ?>
<?php JHTML::_('behavior.modal'); ?>
<?php	  
        $edit = JRequest::getVar('edit',true);
        $text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
        JToolBarHelper::title("Edit Quotation: ".$this->quo_row->quo_code .' '. $this->quo_row->quo_revision, 'cpanel.png');
        JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

        $role = JAdministrator::RoleOnComponent(10);     
        JToolBarHelper::apply('save_edit_quo', 'Save');     
        if ( $edit ) {
        // for existing items the button is renamed `close`
                JToolBarHelper::cancel( 'quo_detail', 'Close' );
        } else {
                JToolBarHelper::cancel();
        }      
?>
<script language="javascript" type="text/javascript">
      
        function submitbutton(pressbutton) {
                var form = document.adminForm;
                if (pressbutton == 'quo_detail') {
                        window.location = "index.php?option=com_apdmquo&task=quo_detail&id="+form.quo_id.value;
                        return;
                }           
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return false;
		}
               
	//	var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&]", "i");
		if (form.customer_id.value==0){
			alert("Please select Commodity Code");
			form.customer_id.focus();
			return false;
		}                
                
              
                
              
                
                        var cpn = document.getElementsByName('cid[]');
                        var len = cpn.length;
                        for (var i=0; i<len; i++) {
                                alert('qty_' +cpn[i].value);
                                //alert(i + (cpn[i].checked?' checked ':' unchecked ') + cpn[i].value);
                                var qty_value = document.getElementById('qty_' +cpn[i].value).value;
                                var price_value = document.getElementById('price_' +cpn[i].value).value;
                                var price_extended = document.getElementById('extend_' +cpn[i].value).value;
                                var duedate = document.getElementById('duedate_' +cpn[i].value).value;
                                if(qty_value==0)
                                {
                                        alert("Please input QTY for PN");    
                                        document.getElementById('qty_' +cpn[i].value).focus();
                                        return false;
                                }
                                if(price_value==0)
                                {
                                        alert("Please input Price for PN");      
                                        document.getElementById('price_' +cpn[i].value).focus();
                                        return false;
                                }
                                if(price_extended==0)
                                {
                                        alert("Please input Extened Price for PN");      
                                        document.getElementById('extend_' +cpn[i].value).focus();
                                        return false;
                                }
                                if(duedate==0)
                                {
                                        alert("Please input Due Date for PN");      
                                        document.getElementById('duedate_' +cpn[i].value).focus();
                                        return false;
                                }
                                 var date = new Date();
                current_month = date.getMonth()+1;
                var current_date = date.getFullYear()+"-"+current_month+"-"+ (date.getDate() < 10 ? "0"+date.getDate() : date.getDate());                
                var current_date = new Date(current_date);
                
                                var quo_duedate = new Date(duedate);
                                if (current_date > quo_duedate ) 
                                {
                                    alert("Invalid Date Range!\nDue Date cannot be before Today!")
                                    return false;
                                }
                        }
                        submitform( pressbutton );
                
                
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
               // submitform( pressbutton );     
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
		<legend><?php echo JText::_( 'Edit Quotation' ); ?></legend>
        <table class="admintable" cellspacing="1" width="100%">
                                 <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Customer' ); ?>
						</label>
					</td>
					<td>
                                                   <?php echo $this->lists['ccscpn'];?>       
                                                <a href="index.php?option=com_apdmccs&task=addcustomer&back=quo"><?php //echo JText::_('Generate Customer')?></a>                                                
					</td>
				</tr>
                                <tr>
					
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Quotation Number' ); ?>
						</label>
					</td>
					<td>                                                 
                                                <input type="text"  readonly="readonly" maxlength="20" name="quo_code"  id="quo_code" class="inputbox" size="30" value="<?php echo $this->quo_row->quo_code .' '. $this->quo_row->quo_revision?>"/>
					</td>
				</tr>                                
                                 <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Request Date' ); ?>
						</label>
					</td>
					<td>                                                 
                                               <?php echo JHTML::_('calendar',$this->quo_row->quo_start_date, 'quo_start_date', 'quo_start_date', '%m/%d/%Y', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	
					</td>
				</tr>      
                                 <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Expire Date' ); ?>
						</label>
					</td>
					<td>                                                 
                                               <?php echo JHTML::_('calendar',$this->quo_row->quo_expire_date, 'quo_expire_date', 'quo_expire_date', '%m/%d/%Y', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	
					</td>
				</tr>    
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'State' ); ?>
						</label>                                                
					</td>
					<td>												 
                                                <?php echo $this->quo_row->quo_state;?>  
                                                <input type="hidden" maxlength="20" name="quo_state"  id="quo_state" class="inputbox" size="30" value="<?php echo $this->quo_row->quo_state;?>"/>
                                                
					</td>
				</tr>	    
                                <tr>
					<td class="key" colspan="2" id='pns_child_so' >
                                                <?php if (count($this->quo_pn_list) > 0) { ?>
                <table class="adminlist" cellspacing="1" width="400">
                        <thead>
                                <tr>
                                        <th width="2%"><?php echo JText::_('NUM'); ?></th>
                                        <th width="3%" class="title"></th>
                                        <th width="100"><?php echo JText::_('Part Number'); ?></th>
                                        <th width="100"><?php echo JText::_('Rev'); ?></th>
                                        <th width="300"><?php echo JText::_('Description'); ?></th>
                                        <th width="100"><?php echo JText::_('Qty'); ?></th>
                                        <th width="100"><?php echo JText::_('UOM'); ?></th>  
                                        <th width="100"><?php echo JText::_('Unit Price'); ?></th>
                                        <th width="100"><?php echo JText::_('Extended'); ?></th>
                                        <th width="100"><?php echo JText::_('Due Date'); ?></th>
                                        <th width="100"><?php //echo JText::_('Action'); ?></th>  
                                </tr>
                        </thead>
                        <tbody>					
        <?php


        $i = 0;
        foreach ($this->quo_pn_list as $row) {
                                if($row->pns_cpn==1) {
                                    $link = 'index.php?option=com_apdmpns&amp;task=detailmpn&cid[0]=' . $row->pns_id;
                                }else{
                                        $link 	= 'index.php?option=com_apdmpns&amp;task=detail&cid[0]='.$row->pns_id;
                                }
                                $quoList = QUOController::GetQuoFrommPns($row->pns_id,$this->quo_row->quotation_id);
                                ?>
                                        <tr>
                                                <td align="center"><?php echo $i+1; ?></td>
                                                <td align="center">
                                                <input checked="checked" type="checkbox" type="checkbox" id = "quopn<?php echo $i?>"  value="<?php echo $row->pns_id;?>_<?php echo $row->id;?>" name="cid[]"  />
                                                </td>                                                
                                                <td align="left"><?php echo $row->pns_code;?></td>
                                                <td align="left"><?php echo $row->pns_revision;?></td>
                                                <td align="left"><?php echo $row->pns_description; ?></td>
                                                <td align="center" width="74px">                                                    
                                                    <input onKeyPress="return numbersOnlyEspecialFloat(this, event);" type="text" value="<?php echo $row->qty;?>" id="qty_<?php echo $row->pns_id;?>_<?php echo $row->id;?>"  name="qty_<?php echo $row->pns_id;?>_<?php echo $row->id;?>" />
                                                </td>
                                            <td align="center"><?php echo $row->pns_uom; ?></td>
                                            <td align="center" width="74px">                                                
                                                <input onKeyPress="return numbersOnlyEspecialFloat(this, event);" type="text" value="<?php echo $row->qty;?>" id="price_<?php echo $row->pns_id;?>_<?php echo $row->id;?>"  name="price_<?php echo $row->pns_id;?>_<?php echo $row->id;?>" />
                                            </td>
                                            <td align="center" width="74px">                                                
                                                <input onKeyPress="return numbersOnlyEspecialFloat(this, event);" type="text" value="<?php echo $row->qty;?>" id="extend_<?php echo $row->pns_id;?>_<?php echo $row->id;?>"  name="extend_<?php echo $row->pns_id;?>_<?php echo $row->id;?>" />
                                            </td>
                                            <td align="center" width="74px">                                                                                                
                                                <?php echo JHTML::_('calendar',$row->quo_pn_due_date, 'duedate_'.$row->pns_id.'_'. $row->id, 'duedate_'.$row->pns_id.'_'. $row->id, '%m/%d/%Y', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>                                                    
                                            </td>
                                                <td align="center" width="75px">
                                                        <a href="index.php?option=com_apdmquo&task=removepnsquos&return=editquo&cid[]=<?php echo $row->id;?>&quo_id=<?php echo $this->quo_row->quotation_id;?>" title="<?php echo JText::_('Click to see detail PNs');?>">Remove</a>
                                                        <?php
                                                        ?>
                                                </td>
                                               </tr>
                                                <?php 
                                                $i++;
                                                }
                                        } 
                                        else
                                        {
                                                echo "Not found PNs"; 
                                        }
                                        ?>
                </tbody>
        </table>		                                                                                                                                      
					</td>
					
				</tr>                                  
                               <tr>				
					<td valign="top">						
							<a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmquo&task=get_list_pns_quo_detail&tmpl=component&quo_id=<?php echo $this->quo_row->quotation_id?>" title="<?php echo JText::_('click here to add more PN')?>"><?php echo JText::_('Click here to add more PN')?></a>			
						
					</td>
				</tr>
                                                                                                                		
			</table>
                </fieldset>
         </div>
                
	<input type="hidden" name="quo_id" value="<?php echo $this->quo_row->quotation_id;?>"  />	
	<input type="hidden" name="option" value="com_apdmquo" />
	<input type="hidden" name="return" value="quo"  />
	<input type="hidden" name="task" value="save_edit_quo" />        
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
