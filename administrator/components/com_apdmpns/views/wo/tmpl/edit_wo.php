<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.tooltip'); ?>
<?php JHTML::_('behavior.modal'); ?>
<?php	
        $me = & JFactory::getUser();
        $edit = JRequest::getVar('edit',true);
        $text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
        JToolBarHelper::title("Edit WO#: ".$this->wo_row->wo_code, 'cpanel.png');
        JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );
        $usertype	= $me->get('usertype');
        $allow_edit = 0;
        if ($usertype =='Administrator' || $usertype=="Super Administrator" || $this->wo_row->wo_created_by  == $me->get('id') ) {
                $allow_edit = 1;
        }
        $role = JAdministrator::RoleOnComponent(10);     
        
        JToolBarHelper::apply('save_editwo', 'Save');
        if ( $edit ) {
        // for existing items the button is renamed `close`
                JToolBarHelper::cancel( 'cancelWo', 'Close' );
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
                if (pressbutton == 'cancelWo') {
                        submitform( pressbutton );
                        return;
                }
                var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&]", "i");
		if (form.wo_code.value==0){
			alert("Please select WO Number");
			form.wo_code.focus();
			return false;
		}
                if (form.so_code.value==0){
			alert("Please select SO Number");
			form.so_code.focus();
			return false;
		}  
                if (form.top_pns_id.value==0){
			alert("Please select Top ASSY PN");
			form.top_pns_id.focus();
			return false;
		}                  
                if (form.wo_start_date.value==0){
			alert("Please select Start date");
			form.wo_start_date.focus();
			return false;
		}                    
                if (form.wo_completed_date.value==0){
			alert("Please select Completed date");
			form.wo_completed_date.focus();
			return false;
		}                    
                var date = new Date();
                current_month = date.getMonth()+1;
                current_day = date.getDate();
                var current_date = date.getFullYear()+"-"+current_month+"-"+ (current_day < 10 ? "0"+current_day : current_day);                
                var current_date = new Date(current_date);
                var start_date = new Date(form.wo_start_date.value);
                var complete_date = new Date(form.wo_completed_date.value);   
                start_date = start_date.setHours(0,0,0,0);
                complete_date = complete_date.setHours(0,0,0,0);

                var so_start_date = new Date(form.so_start_date.value);   
                so_start_date = so_start_date.setHours(0,0,0,0);
                var so_shipping_date = new Date(form.so_request_date.value);   
                so_shipping_date = so_shipping_date.setHours(0,0,0,0);

                var is_edit_finish_date = form.is_edit_finish_date.value;
                if (so_start_date > start_date ) 
                {
                    alert("Invalid Date Range!\nStart Date cannot be before WO start!"+form.so_start_date.value)
                    return false;
                }
                if (start_date > so_shipping_date ) 
                {
                    alert("Invalid Date Range!\nStart Date cannot be after SO Finish!"+form.so_request_date.value)
                    return false;
                }
                if (complete_date < start_date ) 
                {
                    alert("Invalid Date Range!\nFinished Date cannot be before WO start!"+form.so_start_date.value)
                    return false;
                }
                if (complete_date > so_shipping_date ) 
                {
                    alert("Invalid Date Range!\nFinished Date cannot be after SO Finish!"+form.so_request_date.value)
                    return false;
                }
                
                if (start_date > complete_date ) 
                {
                    alert("Invalid Date Range!\nStart Date cannot be after Complete Date!!")
                    return false;
                }        
                if(is_edit_finish_date<=0)
                {
                        var wo_completed_date_old	= new Date(form.wo_completed_date_old.value);               
                        wo_completed_date_old = wo_completed_date_old.setHours(0,0,0,0); 		
                        if(wo_completed_date_old!= complete_date)
                        {
                                if (current_date > complete_date ) 
                                {
                                    alert("Invalid Date Range!\nFinished Date cannot be before ToDay!!")
                                    return false;
                                }  
                         }
                }
                //vaidate date step1 
                var op_target_date1 = new Date(form.op_target_date1.value);   
                op_target_date1 = op_target_date1.setHours(0,0,0,0);
                if (op_target_date1 < start_date || op_target_date1 > complete_date) 
                {
                    alert("Invalid Date Range!\nStep 1: Target Date cannot be before Start Date or after Complete Date!!")
                    return false;
                }
                //date complete step1
                var op_completed_date1 = new Date(form.op_completed_date1.value); 
                op_completed_date1 = op_completed_date1.setHours(0,0,0,0);
                var op_status1_check = form.op_status1_check.value;                                 
                if ((op_status1_check != 'done') && (current_date < op_completed_date1 || current_date > op_completed_date1 )) 
                {
                    alert("Invalid Date Range!\nStep 1: Complete Date cannot be less or greater than Today!")
                    return false;
                }
//                //date complete step1
//                var op_completed_date1 = new Date(form.op_completed_date1.value); 
//                if(op_completed_date1 > op_target_date1)
//                {
//                    alert("Invalid Date Range!\nStep 1: Completed Date cannot be after Target Date!!")
//                    return false;
//                }                                
                 //date step2 
                var op_target_date2 = new Date(form.op_target_date2.value);                
                op_target_date2 = op_target_date2.setHours(0,0,0,0);
                if (op_target_date2 < start_date || op_target_date2 > complete_date) 
                {
                    alert("Invalid Date Range!\nStep 2: Target Date cannot be before Start Date or after Complete Date!!")
                    return false;
                }
                //date complete step2
                var op_completed_date2 = new Date(form.op_completed_date2.value); 
                op_completed_date2 = op_completed_date2.setHours(0,0,0,0);
                var op_status2_check = form.op_status2_check.value;  
                if ((op_status2_check != 'done') && (current_date < op_completed_date2 || current_date > op_completed_date2 )) 
                {
                    alert("Invalid Date Range!\nStep 2: Complete Date cannot be less or greater than Today!")
                    return false;
                }
//                //date complete step2
//                var op_completed_date2 = new Date(form.op_completed_date2.value); 
//                if(op_completed_date2 > op_target_date2)
//                {
//                    alert("Invalid Date Range!\nStep 2: Completed Date cannot be after Target Date!!")
//                    return false;
//                }                                
                 //date step3 
                var op_target_date3 = new Date(form.op_target_date3.value);                
                 op_target_date3 = op_target_date3.setHours(0,0,0,0);
                if (op_target_date3 < start_date || op_target_date3 > complete_date) 
                {
                    alert("Invalid Date Range!\nStep 3: Target Date cannot be before Start Date or after Complete Date!!")
                    return false;
                }
                //date complete step3
                var op_completed_date3 = new Date(form.op_completed_date3.value); 
                op_completed_date3 = op_completed_date3.setHours(0,0,0,0);
                var op_status3_check = form.op_status3_check.value;  
                if ((op_status3_check != 'done') && (current_date < op_completed_date3 || current_date > op_completed_date3 )) 
                {
                    alert("Invalid Date Range!\nStep 3: Complete Date cannot be less or greater than Today!")
                    return false;
                }
//                //date complete step3
//                var op_completed_date3 = new Date(form.op_completed_date3.value); 
//                if(op_completed_date3 > op_target_date3)
//                {
//                    alert("Invalid Date Range!\nStep 3: Completed Date cannot be after Target Date!!")
//                    return false;
//                }                     
                 //date step4 
                var op_target_date4 = new Date(form.op_target_date4.value);       
                 op_target_date4 = op_target_date4.setHours(0,0,0,0);
                if (op_target_date4 < start_date || op_target_date4 > complete_date) 
                {
                    alert("Invalid Date Range!\nStep 4: Target Date cannot be before Start Date or after Complete Date!!")
                    return false;
                }
                //date complete step4
                var op_completed_date4 = new Date(form.op_completed_date4.value); 
                op_completed_date4 = op_completed_date4.setHours(0,0,0,0);
                var op_status4_check = form.op_status4_check.value;  
                if ((op_status4_check != 'done') && (current_date < op_completed_date4 || current_date > op_completed_date4 )) 
                {
                    alert("Invalid Date Range!\nStep 4: Complete Date cannot be less or greater than Today!")
                    return false;
                }                 
//                //date complete step4
//                var op_completed_date4 = new Date(form.op_completed_date4.value); 
//                if(op_completed_date4 > op_target_date4)
//                {
//                    alert("Invalid Date Range!\nStep 4: Completed Date cannot be after Target Date!!")
//                    return false;
//                }                  
                 //date step5 
                var op_target_date5 = new Date(form.op_target_date5.value);                
                 op_target_date5 = op_target_date5.setHours(0,0,0,0);
                if (op_target_date5 < start_date || op_target_date5 > complete_date) 
                {
                    alert("Invalid Date Range!\nStep 5: Target Date cannot be before Start Date or after Complete Date!!")
                    return false;
                }
                //date complete step5
                var op_completed_date5 = new Date(form.op_completed_date5.value); 
                op_completed_date5 = op_completed_date5.setHours(0,0,0,0);
                var op_status5_check = form.op_status5_check.value;  
                if ((op_status5_check != 'done') && (current_date < op_completed_date5 || current_date > op_completed_date5 )) 
                {
                    alert("Invalid Date Range!\nStep 5: Complete Date cannot be less or greater than Today!")
                    return false;
                }                  
//                //date complete step5
//                var op_completed_date5 = new Date(form.op_completed_date5.value); 
//                if(op_completed_date5 > op_target_date5)
//                {
//                    alert("Invalid Date Range!\nStep 5: Completed Date cannot be after Target Date!!")
//                    return false;
//                }  
                //date step6
                var op_target_date6 = new Date(form.op_target_date6.value);                
                 op_target_date6 = op_target_date6.setHours(0,0,0,0);
                if (op_target_date6 < start_date || op_target_date6 > complete_date) 
                {
                    alert("Invalid Date Range!\nStep 6: Target Date cannot be before Start Date or after Complete Date!!")
                    return false;
                }   
                //date complete step6
                var op_completed_date6 = new Date(form.op_completed_date6.value); 
                op_completed_date6 = op_completed_date6.setHours(0,0,0,0);
                var op_status6_check = form.op_status6_check.value;                  
                if ((op_status6_check != 'done') && (current_date < op_completed_date6 || current_date > op_completed_date6 )) 
                {
                    alert("Invalid Date Range!\nStep 6: Complete Date cannot be less or greater than Today!")
                    return false;
                }                
//                //date complete step6
//                var op_completed_date6 = new Date(form.op_completed_date6.value); 
//                if(op_completed_date6 > op_target_date6)
//                {
//                    alert("Invalid Date Range!\nStep 6: Completed Date cannot be after Target  Date!!")
//                    return false;
//                } 
                //date step7
                var op_target_date7 = new Date(form.op_target_date7.value);        
                 op_target_date7 = op_target_date7.setHours(0,0,0,0);
                if (op_target_date7 < start_date || op_target_date7 > complete_date) 
                {
                    alert("Invalid Date Range!\nStep 7: Target Date cannot be before Start Date or after Complete Date!!")
                    return false;
                } 
                //date complete step7
                var op_completed_date7 = new Date(form.op_completed_date7.value); 
                op_completed_date7 = op_completed_date7.setHours(0,0,0,0);
                var op_status7_check = form.op_status7_check.value;  
                if ((op_status7_check != 'done') && (current_date < op_completed_date7 || current_date > op_completed_date7 )) 
                {
                    alert("Invalid Date Range!\nStep 7: Complete Date cannot be less or greater than Today!")
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
	 else if ((("0123456789").indexOf(keychar) > -1))
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
		<legend><?php echo JText::_( 'Edit WO' ); ?></legend>
        <table class="tg" cellspacing="1" width="100%">                               
                                 <tr>
					<td class="tg-0pky">
						<label for="name">
							<?php echo JText::_( 'WO NUMBER' ); ?>
						</label>
					</td>
					<td>                                                 
                                                <input type="text" maxlength="20" name="wo_code"  id="wo_code" class="inputbox" size="30" value="<?php echo $this->wo_row->wo_code;?>" readonly="readonly"/>
					</td>
				</tr>     
                                <tr>
					<td class="tg-0pky" valign="top">
						<?php echo JText::_( 'PART NUMBER' ); ?>
					</td>
					<td valign="top">						
                                                <?php 
                                                $readonly = $style = "";
                                                if($this->wo_row->allow_edit_qty > 0 )
                                                {
                                                        $readonly = 'readonly="readonly"';
                                                        $style= 'style="display:none"';
                                                }
                                                ?>
							<a  <?php echo $style ?> class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmpns&task=get_list_pns_wo&tmpl=component&so_id=<?php echo $this->wo_row->so_id;?>" title="<?php echo JText::_('click here to add more PN')?>"><?php echo JText::_('Select Part Number')?></a>
						
					</td>
				</tr>  
                                  <tr>
					<td class="tg-0pky" colspan="2" id='pns_child_so' >
                                                <table class="admintable" cellspacing="1" width="60%">
                                                <tr>
                                                         <td class="key">#</td>
                                                        <td class="key">PART NUMBER</td>
                                                         <td class="key">Description</td>                                                         
                                                           <td class="key">UOM</td>                                                          
                                                </tr>
                                                <?php 
                                                         if ($row->pns_revision) {
                                                                $pnNumber = $this->row_part->ccs_code . '-' . $this->row_part->pns_code . '-' . $this->row_part->pns_revision;
                                                        } else {
                                                                $pnNumber = $this->row_part->ccs_code . '-' . $this->row_part->pns_code;
                                                        }                        
                                                        $str = '<tr>'.
                                                                ' <td><input checked="checked" type="checkbox" name="pns_child[]" value="' . $this->row_part->pns_id . '" /> </td>'.
                                                                ' <td class="key">'.$pnNumber.'</td>'.
                                                                ' <td class="key">'.$this->row_part->pns_description.'</td>'.                               
                                                                ' <td class="key">'.$this->row_part->pns_uom.'</td>';
                                                        echo $str;
                                                ?>
                                               
                                                </table>                                                                                                                                               
					</td>
					
				</tr>   
                                <tr>
					<td class="tg-0pky" valign="top">
						<label for="username">
							<?php echo JText::_( 'QTY' ); ?>
						</label>
					</td>
					<td>
                                                
                                                <input type="text" <?php echo $readonly;?>  onKeyPress="return numbersOnlyEspecialFloat(this, event);" value="<?php echo $this->wo_row->wo_qty;?>" name="wo_qty" id="wo_qty" <?php echo $classDisabled;?> />
					</td>
				</tr>   
                                <tr>
					<td class="tg-0pky" valign="top">
						<label for="username">
							<?php echo JText::_( 'SO NUMBER' ); ?>
						</label>
					</td>
					<td>
					<input type="text" value="<?php echo $this->wo_row->so_cuscode;?>" name="so_code" id="so_code" readonly="readonly" />
					<input type="hidden" name="so_id" id="so_id" value="<?php echo $this->wo_row->so_id;?>" />
						<a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmpns&task=get_so_ajax&tmpl=component" title="Image">
<!--                                        <input type="button" name="addSO" value="<?php echo JText::_('Select SO')?>"/>-->
                                        </a>
										
					</td>
				</tr>                                
                                        <tr>
					<td class="tg-0pky" valign="top">
						<?php echo JText::_( 'TOP LEVEL ASSY P/N:' ); ?>
                                                <?php 
                                                 if ($this->row_top_assy->pns_revision) {
                                                        $pnNumber = $this->row_top_assy->ccs_code . '-' . $this->row_top_assy->pns_code . '-' . $this->row_top_assy->pns_revision;
                                                } else {
                                                        $pnNumber = $this->row_top_assy->ccs_code . '-' . $this->row_top_assy->pns_code;
                                                } 
                                                ?>
					</td>
                                        <td valign="top"><input type="text" value="<?php echo $pnNumber;?>" name="top_pns_code" id="top_pns_code" readonly="readonly" />
                                                <input type="text" value="<?php echo $this->row_top_assy->pns_id;?>" name="top_pns_id" id="top_pns_id" readonly="readonly" />
                                                <?php    
                                               if(strtotime(date("Y-m-d")) >= strtotime($this->wo_row->wo_start_date))
                                               {
                                                ?>
                                                <a class="modal-button" id="get_assy_pn" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmpns&task=get_list_assy_wo&so_id=<?php echo $this->wo_row->so_id;?>&tmpl=component" title="<?php echo JText::_('click here to add more PN')?>"></a>
                                                <?php 
                                               }
                                               else
                                               {
                                                       ?>
                                                <a class="modal-button" id="get_assy_pn" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmpns&task=get_list_assy_wo&so_id=<?php echo $this->wo_row->so_id;?>&tmpl=component" title="<?php echo JText::_('click here to add more PN')?>">Select Top ASSY P/N</a>
                                                <?php                                                
                                               }                                                                                              
                                               ?>
                                                
						
					</td>
                                        </tr>  
                                        <tr>
                                                <td class="tg-0pky" colspan="2" id='pns_assy_so' >
                                                <?php 
                                                $str = '<table class="admintable" cellspacing="1" width="60%">';                                                  
                                                
                                                                   
                                                        $fachecked="";
                                                        if($this->row_top_assy->fa_required)
                                                                $fachecked = 'checked="checked"';
                                                        $esdchecked="";
                                                        if($this->row_top_assy->esd_required)
                                                                $esdchecked = 'checked="checked"';
                                                        $cocchecked="";
                                                        if($this->row_top_assy->coc_required)
                                                                $cocchecked = 'checked="checked"';
                                                        $str .=  '<tr> <td class="key">FA<input '.$fachecked.' type="checkbox" name="fa_required['.$row->pns_id.']" value="1" /> </td>'.
                                                                ' <td class="key">ESD<input '.$esdchecked.'  type="checkbox" name="esd_required['.$row->pns_id.']" value="1" /> </td>'.
                                                                ' <td class="key">COC<input '.$cocchecked.'  type="checkbox" name="coc_required['.$row->pns_id.']" value="1" /> </td></tr>';
                                               
                                                $str .='</table>';
                                                echo $str;
                                               // $result = $row->pns_id.'^'.$row->customer_code.'^'.$pnNumber.'^'.$str;                
                                                ?>
                                                </td>

                                        </tr>    
                                <tr>
					<td class="tg-0pky" valign="top">
						<label for="username">
							<?php echo JText::_( 'RMA' ); ?>
						</label>
					</td>
					<td>                                                
                                                  <?php 
                                                     if($this->wo_row->wo_rma_active)
                                                        $wo_rma_active = 'checked="checked"';
                                                    ?>
                                                   <input <?php echo $wo_rma_active?> type="checkbox" name="wo_rma_active" value="<?php echo $this->wo_row->wo_rma_active;?> onclick="return false;" onkeydown="return false;" /> RMA</td>
					</td>
				</tr>                                              
                                       <tr>
					<td class="tg-0pky" valign="top">
						<label for="username">
							<?php echo JText::_( 'CUSTOMER' ); ?>
						</label>
					</td>
					<td>
                                                <input type="text" value="<?php echo PNsController::getCcsName($this->wo_row->wo_customer_id); ?>" name="wo_customer_name" id="wo_customer_name" />
                                                <input type="hidden" value="<?php echo $this->wo_row->wo_customer_id;?>" name="wo_customer_id" id="wo_customer_id" />
					</td>
				</tr>                                                                                 
                                       <tr>
					<td class="tg-0pky" valign="top">
						<label for="username">
							<?php echo JText::_( 'REQUEST DATE' ); ?>
						</label>
					</td>
					<td>
                                                <input type="text" value="<?php echo $this->wo_row->so_shipping_date?>" name="so_request_date" id="so_request_date" readonly="readonly" />
                                                <input type="hidden" value="<?php echo $this->wo_row->so_start_date?>" name="so_start_date" id="so_start_date" readonly="readonly" />
					</td>
				</tr>
                                 <tr>
					<td class="tg-0pky">
						<label for="name">
							<?php echo JText::_( 'WO# Start Date' ); ?>
						</label>
					</td>
					<td>         
                                                <input type="hidden" value="<?php echo $this->wo_row->allow_edit_qty?>" name="is_edit_finish_date" id="is_edit_finish_date" readonly="readonly" />
                                               <?php 
         
                                               if($this->wo_row->allow_edit_qty<=0)
                                               {
                                                ?>
                                                <input type="text" value="<?php echo $this->wo_row->wo_start_date?>" name="wo_start_date" id="wo_start_date" readonly="readonly" />
                                                <?php 
                                               }
                                               else
                                               {
                                                       echo JHTML::_('calendar',$this->wo_row->wo_start_date, 'wo_start_date', 'wo_start_date', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); 
                                               }                                                                                              
                                               ?>	
					</td>
				</tr>      
                                 <tr>
					<td class="tg-0pky">
						<label for="name">
							<?php echo JText::_( 'WO# Finished Date' ); ?>
						</label>
					</td>
					<td>  
                                                 <input type="hidden" value="<?php echo $this->wo_row->wo_completed_date?>" name="wo_completed_date_old" id="wo_completed_date_old" readonly="readonly" />
                                                <?php      
                                                
                                               if($this->wo_row->allow_edit_qty<=0)
                                               {
                                                       echo JHTML::_('calendar',$this->wo_row->wo_completed_date, 'wo_completed_date', 'wo_completed_date', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10'));
                                                ?>                                                
                                                <?php 
                                               }
                                               else
                                               {
                                                      echo JHTML::_('calendar',$this->wo_row->wo_completed_date, 'wo_completed_date', 'wo_completed_date', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10'));
                                               }                                                                                              
                                               ?>	                                                
                                               
					</td>
				</tr>    
                                
                                 <tr>
					<td class="tg-0pky">
						<label for="name">
							<?php echo JText::_( 'ASSIGNER' ); ?>
						</label>
					</td>
                                 <td>
                                                                <?php echo $this->lists['assigners'];?> 
                                  </td>
                                 </tr>                                                                                                                      		
			</table>
                </fieldset>
         </div>
                <div class="col width-100">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'OPERATIONS' ); ?> </legend>
                <table class="adminlist">
                        
<table class="tg">
  <tr>
    <th class="tg-0pky"></th>
    <th class="tg-0pky" colspan="5"><label for="name">Steps</label></th>
    <th class="tg-0pky"><label for="name">Comments</label></th>
    <th class="tg-0pky"><label for="name">DATE</label></th>
    <th class="tg-0pky"><label for="name">INITIAL/ID</label></th>
    <th class="tg-0pky"><label for="name">TARGET DATE</label></th>
  </tr>
  <tr>
    <?php 
    $op_arr  = $this->op_arr;
    ?>
    <td class="tg-0pky"><label for="name">1</label></td>
    <td class="tg-0pky" colspan="5"><label for="name">Label Print By:</label></td>
    <td>
    <?php
    if($op_arr['wo_step1']['op_assigner'] == $me->get('id')){    // && $op_arr['wo_step1']['op_assigner'] == $me->get('id')
            ?>
            <textarea maxlength='200' name="op_comment1" rows="3" cols="30"><?php echo $op_arr['wo_step1']['op_comment'];?></textarea>
            <?php
    }else
    {            
    ?>
        <textarea readonly="readonly" maxlength='200' name="op_comment1" rows="3" cols="30"><?php echo $op_arr['wo_step1']['op_comment'];?></textarea>
    <?php 
    }          
    ?>
    </td>
    <td>
    <!-- for checking completed date changed-->
    <input readonly="readonly" type="hidden" value="<?php echo $op_arr['wo_step1']['op_completed_date'];?>" name="op_completed_date1_old" id="op_completed_date1_old" />
    <input readonly="readonly" type="hidden" value="<?php echo $op_arr['wo_step1']['op_status'];?>" name="op_status1_check" id="op_status1_check" />
    <?php              
    if($op_arr['wo_step1']['op_assigner'] == $me->get('id') && $op_arr['wo_step1']['op_status'] != 'done'){    // && $op_arr['wo_step1']['op_assigner'] == $me->get('id')
        echo JHTML::_('calendar',$op_arr['wo_step1']['op_completed_date'], 'op_completed_date1', 'op_completed_date1', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10'));
    }else
    {?>
            <input readonly="readonly" type="text" value="<?php echo $op_arr['wo_step1']['op_completed_date'];?>" name="op_completed_date1" id="op_completed_date1" />
    <?php }?>
    </td>
    <td>
             <?php
    if($allow_edit || $this->wo_row->wo_created_by == $me->get('id') || $this->wo_row->wo_assigner == $me->get('id')){    // && $op_arr['wo_step1']['op_assigner'] == $me->get('id')
            ?>
             <select  name="op_assigner1" id="op_assigner1" >
                <option value="">Select Assignee</option>
                <?php 
                $opNa= "";
                if($op_arr['wo_step1']['op_assigner']==0)
                        $opNa= 'selected="selected"';
                ?>
                <option value="0"  <?php echo $opNa?>>N/A</option>
                 <?php foreach ($this->list_user as $list) { 
                         $selected = "";
                         if($list->id == $op_arr['wo_step1']['op_assigner'])
                         {
                                 $selected = 'selected="selected"';
                         }
                         ?>
                        <option value="<?php echo $list->id; ?>" <?php echo $selected?>><?php echo $list->name; ?></option>
                <?php } ?>
                </select>
            <?php
    }else{
            
    ?>
          <input readonly="readonly" type="hidden" value="<?php echo $op_arr['wo_step1']['op_assigner'];?>" name="op_assigner1" id="op_assigner1" />
          <select  name="op_assigner1_dis" id="op_assigner1_dis" disabled="disabled">
                <option value="">Select Assignee</option>
                 <?php 
                $opNa= "";
                if($op_arr['wo_step1']['op_assigner']==0)
                        $opNa= 'selected="selected"';
                ?>
                <option value="0"  <?php echo $opNa?>>N/A</option>
                 <?php foreach ($this->list_user as $list) { 
                         $selected = "";
                         if($list->id == $op_arr['wo_step1']['op_assigner'])
                         {
                                 $selected = 'selected="selected"';
                         }
                         ?>
                        <option value="<?php echo $list->id; ?>" <?php echo $selected?>><?php echo $list->name; ?></option>
                <?php } ?>
        </select>
    <?php 
    }          
    ?>
          
    </td>
    <td>
            <input readonly="readonly" type="hidden" value="<?php echo $op_arr['wo_step1']['op_target_date'];?>" name="op_target_date1_old" id="op_target_date1_old" />
            <?php 
            if($allow_edit || $this->wo_row->wo_assigner == $me->get('id') || $this->wo_row->allow_edit_qty > 0)//$this->wo_row->allow_edit_qty is  chỉ có thể sửa trước ngày start date
            {
                    echo JHTML::_('calendar',$op_arr['wo_step1']['op_target_date'], 'op_target_date1', 'op_target_date1', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10'));
            }else{
            ?>            
            <input readonly="readonly" type="text" value="<?php echo $op_arr['wo_step1']['op_target_date'];?>" name="op_target_date1" id="op_target_date1" />
                <?php } ?>
    </td>
  </tr>
  <tr>
    <td class="tg-0pky"><label for="name">2</label></td>
    <td class="tg-0pky" colspan="5"><label for="name">Wire Cut By:</label></td>
    <td>
    <?php
    if($op_arr['wo_step2']['op_assigner'] == $me->get('id')){    // && $op_arr['wo_step1']['op_assigner'] == $me->get('id')
            ?>
            <textarea maxlength='200' name="op_comment2" rows="3" cols="30"><?php echo $op_arr['wo_step2']['op_comment'];?></textarea>
            <?php
    }else
    {
            
    ?>
        <textarea readonly="readonly" maxlength='200' name="op_comment2" rows="3" cols="30"><?php echo $op_arr['wo_step2']['op_comment'];?></textarea>
    <?php 
    }          
    ?>
    </td>
    <td>
    <!-- for checking completed date changed-->
    <input type="hidden"  readonly="readonly"  value="<?php echo $op_arr['wo_step2']['op_completed_date'];?>" name="op_completed_date2_old" id="op_completed_date2_old" />
    <input readonly="readonly" type="hidden" value="<?php echo $op_arr['wo_step2']['op_status'];?>" name="op_status2_check" id="op_status2_check" />
    <?php     
    if($op_arr['wo_step1']['op_status']=="done" && $op_arr['wo_step2']['op_assigner'] == $me->get('id')  && $op_arr['wo_step2']['op_status'] != 'done'){    // && $op_arr['wo_step2']['op_assigner'] == $me->get('id')
        echo JHTML::_('calendar',$op_arr['wo_step2']['op_completed_date'], 'op_completed_date2', 'op_completed_date2', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10'));             
    }
    else
    {?>
            <input type="text"  readonly="readonly"  value="<?php echo $op_arr['wo_step2']['op_completed_date'];?>" name="op_completed_date2" id="op_completed_date2" />
    <?php }?>
        
    
    </td>
    <td>
    <?php
    if($this->wo_row->wo_created_by == $me->get('id')|| $this->wo_row->wo_assigner== $me->get('id')){    // && $op_arr['wo_step1']['op_assigner'] == $me->get('id')
            ?>
            <select  name="op_assigner2" id="op_assigner2" >
                <option value="">Select Assignee</option>
                <?php 
                $opNa= "";
                if($op_arr['wo_step2']['op_assigner']==0)
                        $opNa= 'selected="selected"';
                ?>
                <option value="0"  <?php echo $opNa?>>N/A</option>
                 <?php foreach ($this->list_user as $list) { 
                         $selected = "";
                         if($list->id == $op_arr['wo_step2']['op_assigner'])
                         {
                                 $selected = 'selected="selected"';
                         }
                         ?>
                        <option value="<?php echo $list->id; ?>" <?php echo $selected?>><?php echo $list->name; ?></option>
                <?php } ?>
        </select>
            <?php
    }else
    {
            
    ?>
          <input readonly="readonly" type="hidden" value="<?php echo $op_arr['wo_step2']['op_assigner'];?>" name="op_assigner2" id="op_assigner2" />
          <select  name="op_assigner2_dis" id="op_assigner2_dis" disabled="disabled">
                <option value="">Select Assignee</option>
                 <?php 
                $opNa= "";
                if($op_arr['wo_step2']['op_assigner']==0)
                        $opNa= 'selected="selected"';
                ?>
                <option value="0"  <?php echo $opNa?>>N/A</option>
                 <?php foreach ($this->list_user as $list) { 
                         $selected = "";
                         if($list->id == $op_arr['wo_step2']['op_assigner'])
                         {
                                 $selected = 'selected="selected"';
                         }
                         ?>
                        <option value="<?php echo $list->id; ?>" <?php echo $selected?>><?php echo $list->name; ?></option>
                <?php } ?>
        </select>
    <?php 
    }          
    ?>
    </td>
    <td>  
            <input readonly="readonly" type="hidden" value="<?php echo $op_arr['wo_step2']['op_target_date'];?>" name="op_target_date2_old" id="op_target_date2_old" />
    <?php 
            if($allow_edit  || $this->wo_row->wo_assigner == $me->get('id') || $this->wo_row->allow_edit_qty > 0)
            {                    
                    echo JHTML::_('calendar',$op_arr['wo_step2']['op_target_date'], 'op_target_date2', 'op_target_date2', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10'));
            }else{
            ?>            
            <input readonly="readonly" type="text" value="<?php echo $op_arr['wo_step2']['op_target_date'];?>" name="op_target_date2" id="op_target_date2" />
                <?php } ?>
    </td>
  </tr>
  <tr>
    <td class="tg-0pky"><label for="name">3</label></td>
    <td class="tg-0pky" colspan="5"><label for="name">Kitted By:</label></td>
    <td>            
    <?php
    if($op_arr['wo_step3']['op_assigner'] == $me->get('id')){    // && $op_arr['wo_step1']['op_assigner'] == $me->get('id')
            ?>
            <textarea maxlength='200' name="op_comment3" rows="3" cols="30"><?php echo $op_arr['wo_step3']['op_comment'];?></textarea>
            <?php
    }else
    {            
    ?>
        <textarea readonly="readonly" maxlength='200' name="op_comment3" rows="3" cols="30"><?php echo $op_arr['wo_step3']['op_comment'];?></textarea>
    <?php 
    }          
    ?>
    </td>
    <td>
        <!-- for checking completed date changed-->
        <input type="hidden"  readonly="readonly"  value="<?php echo $op_arr['wo_step3']['op_completed_date'];?>" name="op_completed_date3_old" id="op_completed_date3_old" />
    <input readonly="readonly" type="hidden" value="<?php echo $op_arr['wo_step3']['op_status'];?>" name="op_status3_check" id="op_status3_check" />
    <?php 
     if($op_arr['wo_step2']['op_status']=="done" && $op_arr['wo_step3']['op_assigner'] == $me->get('id')  && $op_arr['wo_step3']['op_status'] != 'done'){// && $op_arr['wo_step3']['op_assigner'] == $me->get('id')
        echo JHTML::_('calendar',$op_arr['wo_step3']['op_completed_date'], 'op_completed_date3', 'op_completed_date3', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); 
     }else
    {?>
            <input type="text"  readonly="readonly"  value="<?php echo $op_arr['wo_step3']['op_completed_date'];?>" name="op_completed_date3" id="op_completed_date3" />
    <?php }?></td>
    <td>            
    <?php
    if($this->wo_row->wo_created_by == $me->get('id') || $this->wo_row->wo_assigner== $me->get('id')){    // && $op_arr['wo_step1']['op_assigner'] == $me->get('id')
            ?>
            <select  name="op_assigner3" id="op_assigner3" >
                <option value="">Select Assignee</option>
                 <?php 
                $opNa= "";
                if($op_arr['wo_step3']['op_assigner']==0)
                        $opNa= 'selected="selected"';
                ?>
                <option value="0"  <?php echo $opNa?>>N/A</option>
                <?php foreach ($this->list_user as $list) { 
                         $selected = "";
                         if($list->id == $op_arr['wo_step3']['op_assigner'])
                         {
                                 $selected = 'selected="selected"';
                         }
                         ?>
                        <option value="<?php echo $list->id; ?>" <?php echo $selected?>><?php echo $list->name; ?></option>
                <?php } ?>
        </select>
            <?php
    }else
    {
            
    ?>
          <input readonly="readonly" type="hidden" value="<?php echo $op_arr['wo_step3']['op_assigner'];?>" name="op_assigner3" id="op_assigner3" />
          <select  name="op_assigner3_dis" id="op_assigner3_dis"  disabled="disabled">
                <option value="">Select Assignee</option>
                 <?php 
                $opNa= "";
                if($op_arr['wo_step3']['op_assigner']==0)
                        $opNa= 'selected="selected"';
                ?>
                <option value="0"  <?php echo $opNa?>>N/A</option>
                <?php foreach ($this->list_user as $list) { 
                         $selected = "";
                         if($list->id == $op_arr['wo_step3']['op_assigner'])
                         {
                                 $selected = 'selected="selected"';
                         }
                         ?>
                        <option value="<?php echo $list->id; ?>" <?php echo $selected?>><?php echo $list->name; ?></option>
                <?php } ?>
        </select>
    <?php 
    }          
    ?>
    </td>
    <td>
            <input readonly="readonly" type="hidden" value="<?php echo $op_arr['wo_step3']['op_target_date'];?>" name="op_target_date3_old" id="op_target_date3_old" />
    <?php 
            if($allow_edit || $this->wo_row->wo_assigner == $me->get('id') || $this->wo_row->allow_edit_qty > 0)
            {
                    echo JHTML::_('calendar',$op_arr['wo_step3']['op_target_date'], 'op_target_date3', 'op_target_date3', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10'));
            }else{
            ?>            
            <input readonly="readonly" type="text" value="<?php echo $op_arr['wo_step3']['op_target_date'];?>" name="op_target_date3" id="op_target_date3" />
                <?php } ?>
            <?php  ?>    
    </td>
  </tr>
  <tr>
    <td class="tg-0pky"><label for="name">4</label></td>
    <td class="tg-0pky" colspan="5"><label for="name">Assembly performed by:</label></td>
    <td>            
     <?php
    if($op_arr['wo_step4']['op_assigner'] == $me->get('id')){    // && $op_arr['wo_step1']['op_assigner'] == $me->get('id')
            ?>
            <textarea maxlength='200' name="op_comment4" rows="3" cols="30"><?php echo $op_arr['wo_step4']['op_comment'];?></textarea>
            <?php
    }else
    {            
    ?>
        <textarea readonly="readonly" maxlength='200' name="op_comment4" rows="3" cols="30"><?php echo $op_arr['wo_step4']['op_comment'];?></textarea>
    <?php 
    }          
    ?>
    </td>
    <td>
        <!-- for checking completed date changed-->
        <input type="hidden"  readonly="readonly"  value="<?php echo $op_arr['wo_step4']['op_completed_date'];?>" name="op_completed_date4_old" id="op_completed_date4_old" />
    <input readonly="readonly" type="hidden" value="<?php echo $op_arr['wo_step4']['op_status'];?>" name="op_status4_check" id="op_status4_check" />    
    <?php 
    if($op_arr['wo_step3']['op_status']=="done" && $op_arr['wo_step4']['op_assigner'] == $me->get('id') && $op_arr['wo_step4']['op_status'] != 'done'){// && $op_arr['wo_step4']['op_assigner'] == $me->get('id')
        echo JHTML::_('calendar',$op_arr['wo_step4']['op_completed_date'], 'op_completed_date4', 'op_completed_date4', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10'));
    }else
    {?>
            <input type="text"  readonly="readonly"  value="<?php echo $op_arr['wo_step4']['op_completed_date'];?>" name="op_completed_date4" id="op_completed_date4" />
    <?php }?></td>
    <td>
    <?php
    if( $this->wo_row->wo_created_by == $me->get('id')|| $this->wo_row->wo_assigner== $me->get('id')){    // && $op_arr['wo_step1']['op_assigner'] == $me->get('id')
            ?>
           <select  name="op_assigner4" id="op_assigner4" >
                <option value="">Select Assignee</option>
                 <?php 
                $opNa= "";
                if($op_arr['wo_step4']['op_assigner']==0)
                        $opNa= 'selected="selected"';
                ?>
                <option value="0"  <?php echo $opNa?>>N/A</option>
                 <?php foreach ($this->list_user as $list) { 
                         $selected = "";
                         if($list->id == $op_arr['wo_step4']['op_assigner'])
                         {
                                 $selected = 'selected="selected"';
                         }
                         ?>
                        <option value="<?php echo $list->id; ?>" <?php echo $selected?>><?php echo $list->name; ?></option>
                <?php } ?>
        </select>
            <?php
    }else
    {
            
    ?>
          <input readonly="readonly" type="hidden" value="<?php echo $op_arr['wo_step4']['op_assigner'];?>" name="op_assigner4" id="op_assigner4" />
         <select  name="op_assigner4_dis" id="op_assigner4_dis"  disabled="disabled">
                <option value="">Select Assignee</option>
                 <?php 
                $opNa= "";
                if($op_arr['wo_step4']['op_assigner']==0)
                        $opNa= 'selected="selected"';
                ?>
                <option value="0"  <?php echo $opNa?>>N/A</option>
                 <?php foreach ($this->list_user as $list) { 
                         $selected = "";
                         if($list->id == $op_arr['wo_step4']['op_assigner'])
                         {
                                 $selected = 'selected="selected"';
                         }
                         ?>
                        <option value="<?php echo $list->id; ?>" <?php echo $selected?>><?php echo $list->name; ?></option>
                <?php } ?>
        </select>
    <?php 
    }          
    ?>
    </td>
    <td>
            <input readonly="readonly" type="hidden" value="<?php echo $op_arr['wo_step4']['op_target_date'];?>" name="op_target_date4_old" id="op_target_date4_old" />
        <?php 
            if($allow_edit || $this->wo_row->wo_assigner == $me->get('id')|| $this->wo_row->allow_edit_qty > 0)
            {
                     echo JHTML::_('calendar',$op_arr['wo_step4']['op_target_date'], 'op_target_date4', 'op_target_date4', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10'));
            }else{
            ?>            
            <input readonly="readonly" type="text" value="<?php echo $op_arr['wo_step4']['op_target_date'];?>" name="op_target_date4" id="op_target_date4" />
                <?php } ?>
            <?php  ?>            
    </td>
  </tr>
  <tr>
    <td class="tg-0pky"><label for="name">Process</label></td>
    <td class="tg-0pky" colspan="2"><label for="name">Solder?</label></td>
    <td class="tg-0pky" colspan="2"><label for="name">Crimp?</label></td>
    <td class="tg-0pky"><label for="name">None</label></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky" rowspan="5"><label for="name">Production</label></td>
    <td class="tg-0pky"><label for="name">CONT#</label></td>
    <td class="tg-0pky"><label for="name">Wire size#</label></td>
    <td class="tg-0pky"><label for="name">TOOL ID#</label></td>
    <td class="tg-0pky"><label for="name">Height</label></td>
    <td class="tg-0pky"><label for="name">Pull Force</label></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
  </tr>
  <?php 
  $allow_step_edit ='readonly="readonly"';
  //$allow_edit || for admin can edit
  if($op_arr['wo_step4']['op_assigner'] == $me->get('id')){
           $allow_step_edit = '';
  }
  foreach ($this->wo_assem_rows as $a_row)
  {
  ?>
  <tr>
    <td><input type="text" size="6"  <?php echo $allow_step_edit;?> value="<?php echo $a_row->op_assembly_value1;?>" name="op_assembly_value1[<?php echo $a_row->id;?>]" id="op_assembly_value1" /></td>
    <td><input type="text" size="6" <?php echo $allow_step_edit;?> onKeyPress="return numbersOnlyEspecialFloat(this, event);" value="<?php echo $a_row->op_assembly_value2;?>" name="op_assembly_value2[<?php echo $a_row->id;?>]" id="op_assembly_value2" /></td>
    <td><input type="text" size="6"  <?php echo $allow_step_edit;?> value="<?php echo $a_row->op_assembly_value3;?>" name="op_assembly_value3[<?php echo $a_row->id;?>]" id="op_assembly_value3" /></td>
    <td><input type="text" size="6"  <?php echo $allow_step_edit;?> onKeyPress="return numbersOnlyEspecialFloat(this, event);" value="<?php echo $a_row->op_assembly_value4;?>" name="op_assembly_value4[<?php echo $a_row->id;?>]" id="op_assembly_value4" /></td>
    <td><input type="text" size="6"  <?php echo $allow_step_edit;?> onKeyPress="return numbersOnlyEspecialFloat(this, event);" value="<?php echo $a_row->op_assembly_value5;?>" name="op_assembly_value5[<?php echo $a_row->id;?>]" id="op_assembly_value5" /></td>
    <td class="tg-0pky">
            <input type="hidden" name="op_assemble_id[]" value="<?php echo $a_row->id ?>" />
    </td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
  </tr>
  <?php 
  }
  ?>    
  <tr>
    <td class="tg-0pky" colspan="5"></td>
    <td class="tg-0pky"><label for="name">1st Fail Qty</label></td>
    <td class="tg-0pky"><label for="name">2nd Fail Qty</label></td>
    <td class="tg-0pky"><label for="name">DATE</label></td>
    <td class="tg-0pky"><label for="name">INITIAL/ID</label></td>
    <td class="tg-0pky"><label for="name">TARGET DATE</label></td>
  </tr>
  <tr>
    <td class="tg-0pky"><label for="name">5</label></td>
    <td class="tg-0pky" colspan="4"><label for="name">Visual Inspection(QC) By:</label></td>
    <td></td>
    <td></td>
    <td>
          <!-- for checking completed date changed-->
          <input type="hidden"  readonly="readonly"  value="<?php echo $op_arr['wo_step5']['op_completed_date'];?>" name="op_completed_date5_old" id="op_completed_date5_old" />
    <input readonly="readonly" type="hidden" value="<?php echo $op_arr['wo_step5']['op_status'];?>" name="op_status5_check" id="op_status5_check" />    
  <?php 
    if($op_arr['wo_step4']['op_status']=="done" && $op_arr['wo_step5']['op_assigner'] == $me->get('id') && $op_arr['wo_step5']['op_status'] != 'done'){// && $op_arr['wo_step5']['op_assigner'] == $me->get('id')
        echo JHTML::_('calendar',$op_arr['wo_step5']['op_completed_date'], 'op_completed_date5', 'op_completed_date5', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); 
    }else
    {?>
            <input type="text"  readonly="readonly"  value="<?php echo $op_arr['wo_step5']['op_completed_date'];?>" name="op_completed_date5" id="op_completed_date5" />
    <?php }?></td>
    <td>           
           
<?php
    if($this->wo_row->wo_created_by == $me->get('id') || $this->wo_row->wo_assigner== $me->get('id')){    // && $op_arr['wo_step1']['op_assigner'] == $me->get('id')
            ?>
           <select  name="op_assigner5" id="op_assigne5" >
                <option value="">Select Assignee</option>
                 <?php 
                $opNa= "";
                if($op_arr['wo_step5']['op_assigner']==0)
                        $opNa= 'selected="selected"';
                ?>
                <option value="0"  <?php echo $opNa?>>N/A</option>
                <?php foreach ($this->list_user as $list) { 
                         $selected = "";
                         if($list->id == $op_arr['wo_step5']['op_assigner'])
                         {
                                 $selected = 'selected="selected"';
                         }
                         ?>
                        <option value="<?php echo $list->id; ?>" <?php echo $selected?>><?php echo $list->name; ?></option>
                <?php } ?>
        </select>
            <?php
    }else
    {
            
    ?>
          <input readonly="readonly" type="hidden" value="<?php echo $op_arr['wo_step5']['op_assigner'];?>" name="op_assigner5" id="op_assigner5" />
          <select  name="op_assigner5_dis" id="op_assigner5_dis"  disabled="disabled">
                <option value="">Select Assignee</option>
                 <?php 
                $opNa= "";
                if($op_arr['wo_step5']['op_assigner']==0)
                        $opNa= 'selected="selected"';
                ?>
                <option value="0"  <?php echo $opNa?>>N/A</option>
                <?php foreach ($this->list_user as $list) { 
                         $selected = "";
                         if($list->id == $op_arr['wo_step5']['op_assigner'])
                         {
                                 $selected = 'selected="selected"';
                         }
                         ?>
                        <option value="<?php echo $list->id; ?>" <?php echo $selected?>><?php echo $list->name; ?></option>
                <?php } ?>
        </select>
    <?php 
    }          
    ?>            
    </td>
    <td>
            <input readonly="readonly" type="hidden" value="<?php echo $op_arr['wo_step5']['op_target_date'];?>" name="op_target_date5_old" id="op_target_date5_old" />
        <?php 
            if($allow_edit || $this->wo_row->wo_assigner == $me->get('id')|| $this->wo_row->allow_edit_qty > 0)
            {
                    echo JHTML::_('calendar',$op_arr['wo_step5']['op_target_date'], 'op_target_date5', 'op_target_date5', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); 
            }else{
            ?>            
            <input readonly="readonly" type="text" value="<?php echo $op_arr['wo_step5']['op_target_date'];?>" name="op_target_date5" id="op_target_date5" />
                <?php } ?>
            <?php  ?>    
    </td>
  </tr>
  <?php $opvs_arr = $this->opvs_arr;
   $allow_step5_edit ='readonly="readonly"';
  //$allow_edit || for admin can edit
  if($op_arr['wo_step5']['op_assigner'] == $me->get('id')){
           $allow_step5_edit = '';
  }
  ?>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky"  colspan="3"><label for="name">Document not match</label></td>
    <td><input type="text" size="6" <?php echo $allow_step5_edit;?> value="<?php echo $opvs_arr[1]['op_visual_value1']?>" name="op_visual_value1[1]" id="op_visual_value1" /></td>
    <td><input type="text" size="6" <?php echo $allow_step5_edit;?> value="<?php echo $opvs_arr[2]['op_visual_value1']?>" name="op_visual_value1[2]" id="op_visual_value1" /></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky" colspan="2"><label for="name">Comment</label></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Traveler incomplete</label></td>
    <td><input type="text" size="6" <?php echo $allow_step5_edit;?> value="<?php echo $opvs_arr[1]['op_visual_value2']?>" name="op_visual_value2[1]" id="op_visual_value2" /></td>
    <td><input type="text" size="6" <?php echo $allow_step5_edit;?> value="<?php echo $opvs_arr[2]['op_visual_value2']?>" name="op_visual_value2[2]" id="op_visual_value2" /></td>
   <td class="tg-0pky"></td>
    <td colspan="2" rowspan="4">            
     <?php
    if($op_arr['wo_step5']['op_assigner'] == $me->get('id')){    // && $op_arr['wo_step1']['op_assigner'] == $me->get('id')
            ?>
            <textarea maxlength='200' name="op_comment5" rows="12" cols="30"><?php echo $op_arr['wo_step5']['op_comment'];?></textarea>
            <?php
    }else
    {            
    ?>
        <textarea readonly="readonly" maxlength='200' name="op_comment5" rows="12" cols="30"><?php echo $op_arr['wo_step5']['op_comment'];?></textarea>
    <?php 
    }          
    ?>    
    </td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Wrong Dimension</label></td>
    <td><input type="text" size="6" <?php echo $allow_step5_edit;?> value="<?php echo $opvs_arr[1]['op_visual_value3']?>" name="op_visual_value3[1]" id="op_visual_value3" /></td>
    <td><input type="text" size="6" <?php echo $allow_step5_edit;?> value="<?php echo $opvs_arr[2]['op_visual_value3']?>" name="op_visual_value3[2]" id="op_visual_value3" /></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Label print error</label></td>
    <td><input type="text" size="6" <?php echo $allow_step5_edit;?> value="<?php echo $opvs_arr[1]['op_visual_value4']?>" name="op_visual_value4[1]" id="op_visual_value4" /></td>
    <td><input type="text" size="6" <?php echo $allow_step5_edit;?> value="<?php echo $opvs_arr[2]['op_visual_value4']?>" name="op_visual_value4[2]" id="op_visual_value4" /></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Missing Label / Wrong Location</label></td>
    <td><input type="text" size="6" <?php echo $allow_step5_edit;?> value="<?php echo $opvs_arr[1]['op_visual_value5']?>" name="op_visual_value5[1]" id="op_visual_value5" /></td>
    <td><input type="text" size="6" <?php echo $allow_step5_edit;?> value="<?php echo $opvs_arr[2]['op_visual_value5']?>" name="op_visual_value5[2]" id="op_visual_value5" /></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"><label for="name">6</label></td>
    <td class="tg-0pky" colspan="4"><label for="name">Final&nbsp;&nbsp;Inspection(QC) By:</label></td>
    <td></td>
    <td></td>
    <td>
          <!-- for checking completed date changed-->
          <input type="hidden"  readonly="readonly"  value="<?php echo $op_arr['wo_step6']['op_completed_date'];?>" name="op_completed_date6_old" id="op_completed_date6_old" />
    <input readonly="readonly" type="hidden" value="<?php echo $op_arr['wo_step6']['op_status'];?>" name="op_status6_check" id="op_status6_check" />        
    <?php 
    if($op_arr['wo_step5']['op_status']=="done" && $op_arr['wo_step6']['op_assigner'] == $me->get('id') && $op_arr['wo_step6']['op_status'] != 'done'){// && $op_arr['wo_step6']['op_assigner'] == $me->get('id')
        echo JHTML::_('calendar',$op_arr['wo_step6']['op_completed_date'], 'op_completed_date6', 'op_completed_date6', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10'));
    }else
    {?>
            <input type="text"  readonly="readonly"  value="<?php echo $op_arr['wo_step6']['op_completed_date'];?>" name="op_completed_date6" id="op_completed_date6" />
    <?php }?></td>
    <td>    
     <?php
    if($this->wo_row->wo_created_by == $me->get('id') || $this->wo_row->wo_assigner === $me->get('id')){    // && $op_arr['wo_step1']['op_assigner'] == $me->get('id')
            ?>
           <select  name="op_assigner6" id="op_assigner6" >
                <option value="">Select Assignee</option>
                 <?php 
                $opNa= "";
                if($op_arr['wo_step6']['op_assigner']==0)
                        $opNa= 'selected="selected"';
                ?>
                <option value="0"  <?php echo $opNa?>>N/A</option>
                <?php foreach ($this->list_user as $list) { 
                         $selected = "";
                         if($list->id == $op_arr['wo_step6']['op_assigner'])
                         {
                                 $selected = 'selected="selected"';
                         }
                         ?>
                        <option value="<?php echo $list->id; ?>" <?php echo $selected?>><?php echo $list->name; ?></option>
                <?php } ?>
        </select>
            <?php
    }else
    {
            
    ?>
          <input readonly="readonly" type="hidden" value="<?php echo $op_arr['wo_step6']['op_assigner'];?>" name="op_assigner6" id="op_assigner6" />
         <select  name="op_assigner6" id="op_assigner6" disabled="disabled" >
                <option value="">Select Assignee</option>
                 <?php 
                $opNa= "";
                if($op_arr['wo_step6']['op_assigner']==0)
                        $opNa= 'selected="selected"';
                ?>
                <option value="0"  <?php echo $opNa?>>N/A</option>
                <?php foreach ($this->list_user as $list) { 
                         $selected = "";
                         if($list->id == $op_arr['wo_step6']['op_assigner'])
                         {
                                 $selected = 'selected="selected"';
                         }
                         ?>
                        <option value="<?php echo $list->id; ?>" <?php echo $selected?>><?php echo $list->name; ?></option>
                <?php } ?>
        </select>
    <?php 
    }          
    ?>              
    </td>
    <td>
              <input readonly="readonly" type="hidden" value="<?php echo $op_arr['wo_step6']['op_target_date'];?>" name="op_target_date6_old" id="op_target_date6_old" />
      <?php 
            if($allow_edit || $this->wo_row->wo_assigner == $me->get('id') || $this->wo_row->allow_edit_qty>0)
            {
                    echo JHTML::_('calendar',$op_arr['wo_step6']['op_target_date'], 'op_target_date6', 'op_target_date6', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); 
            }else{
            ?>            
            <input readonly="readonly" type="text" value="<?php echo $op_arr['wo_step6']['op_target_date'];?>" name="op_target_date6" id="op_target_date6" />
                <?php } ?>
            <?php  ?>
    </td>
  </tr>
  <?php $opfn_arr = $this->opfn_arr;
   $allow_step6_edit ='readonly="readonly"';
  //$allow_edit || for admin can edit
  if($op_arr['wo_step6']['op_assigner'] == $me->get('id')){
           $allow_step6_edit = '';
  }
  ?>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Document not match</label></td>
    <td><input type="text" size="6" <?php echo $allow_step6_edit;?> value="<?php echo $opfn_arr[1]['op_final_value1']?>" name="op_final_value1[1]" id="op_final_value1" /></td>
    <td><input type="text" size="6" <?php echo $allow_step6_edit;?> value="<?php echo $opfn_arr[2]['op_final_value1']?>" name="op_final_value1[2]" id="op_final_value1" /></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky" colspan="2"><label for="name">COMMENTS</label></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Traveler incomplete</label></td>
    <td><input type="text" size="6" <?php echo $allow_step6_edit;?> value="<?php echo $opfn_arr[1]['op_final_value2']?>" name="op_final_value2[1]" id="op_final_value2" /></td>
    <td><input type="text" size="6" <?php echo $allow_step6_edit;?> value="<?php echo $opfn_arr[2]['op_final_value2']?>" name="op_final_value2[2]" id="op_final_value2" /></td>
    <td class="tg-0pky"></td>
    <td colspan="2" rowspan="6">            
     <?php
    if($op_arr['wo_step6']['op_assigner'] == $me->get('id')){    // && $op_arr['wo_step1']['op_assigner'] == $me->get('id')
            ?>
            <textarea maxlength='200' name="op_comment6" rows="16" cols="30"><?php echo $op_arr['wo_step6']['op_comment'];?></textarea>
            <?php
    }else
    {            
    ?>
        <textarea readonly="readonly" maxlength='200' name="op_comment6" rows="16" cols="30"><?php echo $op_arr['wo_step6']['op_comment'];?></textarea>
    <?php 
    }          
    ?>
    </td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Wrong Dimension</label></td>
    <td><input type="text" size="6" <?php echo $allow_step6_edit;?> value="<?php echo $opfn_arr[1]['op_final_value3']?>" name="op_final_value3[1]" id="op_final_value3" /></td>
    <td><input type="text" size="6" <?php echo $allow_step6_edit;?> value="<?php echo $opfn_arr[2]['op_final_value3']?>" name="op_final_value3[2]" id="op_final_value3" /></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Label print error</label></td>
    <td><input type="text" size="6" <?php echo $allow_step6_edit;?> value="<?php echo $opfn_arr[1]['op_final_value4']?>" name="op_final_value4[1]" id="op_final_value4" /></td>
    <td><input type="text" size="6" <?php echo $allow_step6_edit;?> value="<?php echo $opfn_arr[2]['op_final_value4']?>" name="op_final_value4[2]" id="op_final_value4" /></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Missing Label / Wrong Location</label></td>
    <td><input type="text" size="6" <?php echo $allow_step6_edit;?> value="<?php echo $opfn_arr[1]['op_final_value5']?>" name="op_final_value5[1]" id="op_final_value5" /></td>
    <td><input type="text" size="6" <?php echo $allow_step6_edit;?> value="<?php echo $opfn_arr[2]['op_final_value5']?>" name="op_final_value5[2]" id="op_final_value5" /></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Miss Wire / Open Connection</label></td>
    <td><input type="text" size="6" <?php echo $allow_step6_edit;?> value="<?php echo $opfn_arr[1]['op_final_value6']?>" name="op_final_value6[1]" id="op_final_value6" /></td>
    <td><input type="text" size="6" <?php echo $allow_step6_edit;?> value="<?php echo $opfn_arr[2]['op_final_value6']?>" name="op_final_value6[2]" id="op_final_value6" /></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Fail Hipot Test</label></td>
    <td><input type="text" size="6" <?php echo $allow_step6_edit;?> value="<?php echo $opfn_arr[1]['op_final_value7']?>" name="op_final_value7[1]" id="op_final_value7" /></td>
    <td><input type="text" size="6" <?php echo $allow_step6_edit;?> value="<?php echo $opfn_arr[2]['op_final_value7']?>" name="op_final_value7[2]" id="op_final_value7" /></td>
  <tr>
    <td class="tg-0pky" colspan="6"></td>
    <td class="tg-0pky"><label for="name">COMMENTS</label></td>
    <td class="tg-0pky"><label for="name">DATE</label></td>
    <td class="tg-0pky"><label for="name">INITIAL/ID</label></td>
    <td class="tg-0pky"><label for="name">TARGET DATE</label></td>
  </tr>
  <tr>
    <td class="tg-0pky"><label for="name">7</label></td>
    <td class="tg-0pky" colspan="5"><label for="name">Packaging by</label></td>
    <td>            
     <?php
    if($op_arr['wo_step7']['op_assigner'] == $me->get('id')){    // && $op_arr['wo_step1']['op_assigner'] == $me->get('id')
            ?>
            <textarea maxlength='200' name="op_comment7" rows="3" cols="30"><?php echo $op_arr['wo_step7']['op_comment'];?></textarea>
            <?php
    }else
    {            
    ?>
        <textarea readonly="readonly" maxlength='200' name="op_comment7" rows="3" cols="30"><?php echo $op_arr['wo_step7']['op_comment'];?></textarea>
    <?php 
    }          
    ?>
    </td>
    <td>
          <!-- for checking completed date changed-->
          <input type="hidden" readonly="readonly"  value="<?php echo $op_arr['wo_step7']['op_completed_date'];?>" name="op_completed_date7_old" id="op_completed_date7_old" />
    <input readonly="readonly" type="hidden" value="<?php echo $op_arr['wo_step7']['op_status'];?>" name="op_status7_check" id="op_status7_check" />            
    <?php                     
    if($op_arr['wo_step6']['op_status']=="done" && $op_arr['wo_step7']['op_assigner'] == $me->get('id') && $op_arr['wo_step7']['op_status'] != 'done'){//
        echo JHTML::_('calendar',$op_arr['wo_step7']['op_completed_date'], 'op_completed_date7', 'op_completed_date7', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10'));
    }else
    {?>
            <input type="text" readonly="readonly"  value="<?php echo $op_arr['wo_step7']['op_completed_date'];?>" name="op_completed_date7" id="op_completed_date7" />
    <?php }?></td>
    <td>
        <?php
    if($this->wo_row->wo_created_by == $me->get('id') || $this->wo_row->wo_assigner== $me->get('id')){    // && $op_arr['wo_step1']['op_assigner'] == $me->get('id')
            ?>
           <select  name="op_assigner7" id="op_assigner7" >
                <option value="">Select Assignee</option>
                 <?php 
                $opNa= "";
                if($op_arr['wo_step7']['op_assigner']==0)
                        $opNa= 'selected="selected"';
                ?>
                <option value="0"  <?php echo $opNa?>>N/A</option>
                 <?php foreach ($this->list_user as $list) { 
                         $selected = "";
                         if($list->id == $op_arr['wo_step7']['op_assigner'])
                         {
                                 $selected = 'selected="selected"';
                         }
                         ?>
                        <option value="<?php echo $list->id; ?>" <?php echo $selected?>><?php echo $list->name; ?></option>
                <?php } ?>
        </select>
            <?php
    }else
    {
            
    ?>
          <input readonly="readonly" type="hidden" value="<?php echo $op_arr['wo_step7']['op_assigner'];?>" name="op_assigner7" id="op_assigner7" />
          <select  name="op_assigner7_dis" id="op_assigner7_dis"  disabled="disabled">
                <option value="">Select Assignee</option>
                 <?php 
                $opNa= "";
                if($op_arr['wo_step7']['op_assigner']==0)
                        $opNa= 'selected="selected"';
                ?>
                <option value="0"  <?php echo $opNa?>>N/A</option>
                 <?php foreach ($this->list_user as $list) { 
                         $selected = "";
                         if($list->id == $op_arr['wo_step7']['op_assigner'])
                         {
                                 $selected = 'selected="selected"';
                         }
                         ?>
                        <option value="<?php echo $list->id; ?>" <?php echo $selected?>><?php echo $list->name; ?></option>
                <?php } ?>
        </select>
    <?php 
    }          
    ?>                     
    </td>
    <td>
            <input readonly="readonly" type="hidden" value="<?php echo $op_arr['wo_step7']['op_target_date'];?>" name="op_target_date7_old" id="op_target_date7_old" />
    <?php 
            if($allow_edit || $this->wo_row->wo_assigner == $me->get('id') || $this->wo_row->allow_edit_qty > 0)
            {
                   echo JHTML::_('calendar',$op_arr['wo_step7']['op_target_date'], 'op_target_date7', 'op_target_date7', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10'));
            }else{
            ?>            
            <input readonly="readonly" type="text" value="<?php echo $op_arr['wo_step7']['op_target_date'];?>" name="op_target_date7" id="op_target_date7" />
                <?php } ?>
            <?php  ?>
    </td>
  </tr>
			
                                          </table>
                </fieldset>
         </div>
                
	<input type="hidden" name="wo_id" value="<?php echo $this->wo_row->pns_wo_id?>"  />	
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="return" value="so"  />
	<input type="hidden" name="task" value="save_sales_order" />        
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
