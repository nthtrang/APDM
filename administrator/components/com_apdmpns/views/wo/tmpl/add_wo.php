<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.tooltip'); ?>
<?php JHTML::_('behavior.modal'); ?>
<?php	
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
        $so_code = "";
        $so_id=0;
        if(JRequest::getVar( 'so_id')){
              $so_id =  JRequest::getVar('so_id');
              $so_info = PNsController::getSofomId($so_id);                                
        }              
        JToolBarHelper::title( JText::_( 'WO GENERATION' ) . ': <small><small>[ New ]</small></small>' , 'cpanel.png' );
        JToolBarHelper::apply('save_works_order', 'Save');

	JToolBarHelper::cancel( 'cancelWo', 'Close' );
	
         
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
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}            
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
                var current_date = date.getFullYear()+"-"+current_month+"-"+ (date.getDate() < 10 ? "0"+date.getDate() : date.getDate());                
                var current_date = new Date(current_date);
                var start_date = new Date(form.wo_start_date.value);
                var complete_date = new Date(form.wo_completed_date.value);              
                
                var so_start_date = new Date(form.so_start_date.value);   
                so_start_date = so_start_date.setHours(0,0,0,0);
                var so_shipping_date = new Date(form.so_request_date.value);   
                so_shipping_date = so_shipping_date.setHours(0,0,0,0);
                 
                if (so_start_date > start_date ) 
                {
                    alert("Invalid Date Range!\nStart Date cannot be before SO start!" + form.so_start_date.value)
                    return false;
                }
                if (start_date > so_shipping_date ) 
                {
                    alert("Invalid Date Range!\nStart Date cannot be after SO Finish!"+ form.so_request_date.value)
                    return false;
                }
                if (complete_date < start_date ) 
                {
                    alert("Invalid Date Range!\nFinished Date cannot be before SO start!"+form.so_start_date.value)
                    return false;
                }
                if (complete_date > so_shipping_date ) 
                {
                    alert("Invalid Date Range!\nFinished Date cannot be after SO Finish!"+form.so_request_date.value)
                    return false;
                }                
                if (current_date > start_date ) 
                {
                    alert("Invalid Date Range!\nStart Date cannot be before Today!")
                    return false;
                }
                if (start_date > complete_date ) 
                {
                    alert("Invalid Date Range!\nStart Date cannot be after Complete Date!!")
                    return false;
                }          
                //date step1 
                var op_target_date1 = new Date(form.op_target_date1.value);                
                if (op_target_date1 < start_date || op_target_date1 > complete_date) 
                {
                    alert("Invalid Date Range!\nStep 1: Target Date cannot be before Start Date or after Complete Date!!")
                    return false;
                }
                //date step1 
                var op_target_date1 = new Date(form.op_target_date1.value);                
                if (op_target_date1 < start_date || op_target_date1 > complete_date) 
                {
                    alert("Invalid Date Range!\nStep 1: Target Date cannot be before Start Date or after Complete Date!!")
                    return false;
                }    
                 //date step2 
                var op_target_date2 = new Date(form.op_target_date2.value);                
                if (op_target_date2 < start_date || op_target_date2 > complete_date) 
                {
                    alert("Invalid Date Range!\nStep 2: Target Date cannot be before Start Date or after Complete Date!!")
                    return false;
                }
                
                 //date step3 
                var op_target_date3 = new Date(form.op_target_date3.value);                
                if (op_target_date3 < start_date || op_target_date3 > complete_date) 
                {
                    alert("Invalid Date Range!\nStep 3: Target Date cannot be before Start Date or after Complete Date!!")
                    return false;
                }
                 //date step4 
                var op_target_date4 = new Date(form.op_target_date4.value);                
                if (op_target_date4 < start_date || op_target_date4 > complete_date) 
                {
                    alert("Invalid Date Range!\nStep 4: Target Date cannot be before Start Date or after Complete Date!!")
                    return false;
                }
                 //date step5 
                var op_target_date5 = new Date(form.op_target_date5.value);                
                if (op_target_date5 < start_date || op_target_date5 > complete_date) 
                {
                    alert("Invalid Date Range!\nStep 5: Target Date cannot be before Start Date or after Complete Date!!")
                    return false;
                }
                //date step6
                var op_target_date6 = new Date(form.op_target_date6.value);                
                if (op_target_date6 < start_date || op_target_date6 > complete_date) 
                {
                    alert("Invalid Date Range!\nStep 6: Target Date cannot be before Start Date or after Complete Date!!")
                    return false;
                }           
                //date step7
                var op_target_date7 = new Date(form.op_target_date7.value);                
                if (op_target_date7 < start_date || op_target_date7 > complete_date) 
                {
                    alert("Invalid Date Range!\nStep 7: Target Date cannot be before Start Date or after Complete Date!!")
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
	 else if ((("0123456789-").indexOf(keychar) > -1))
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
function check_so_first()
{
        if($('so_id').value==0)
        {
               alert("Please select SO Number first");
               window.parent.document.getElementById('sbox-window').close();
               return false;
        }
        return true;
}
</script>
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data" >
	 <div class="col width-100">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'WO Detail' ); ?></legend>
        <table class="tg" cellspacing="1" width="100%">                               
                                 <tr>
					<td class="tg-0pky">
						<label for="name">
							<?php echo JText::_( 'WO NUMBER' ); ?>
						</label>
					</td>
					<td>                                                 
                                                <input type="text" maxlength="20" name="wo_code"  id="wo_code" class="inputbox" size="30" value="<?php echo PNsController::wo_autoincrement_default();?>" readonly="readonly"/>
					</td>
				</tr>     
                                <tr>
					<td class="tg-0pky" valign="top">
						<?php echo JText::_( 'PART NUMBER' ); ?>
					</td>
					<td valign="top">
                                                
                                                 <?php 
                                                if($so_info['so_code'])
                                                {
                                                ?>                                                        
                                                        <a class="modal-button" id="get_part_pn" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmpns&task=get_list_pns_wo&tmpl=component&so_id=<?php echo $so_info['so_id']?>" title="<?php echo JText::_('click here to add more PN')?>"><?php echo JText::_('Select Part Number')?></a>
                                                <?php
                                                }
                                                else
                                                {
                                                ?>                                                
                                                        <a class="modal-button" id="get_part_pn" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmpns&task=get_list_pns_wo&tmpl=component" title="<?php echo JText::_('click here to add more PN')?>"></a>
                                                <?php 
                                                }
                                                ?>	
							
						
					</td>
				</tr>  
                                  <tr>
					<td class="tg-0pky" colspan="2" id='pns_child_so' >
						<table class="admintable" cellspacing="1" width="60%">
                                                <tr>
                                                        <td class="key">PART NUMBER</td>
                                                         <td class="key">Description</td>                                                          
                                                           <td class="key">UOM</td>                                                          
                                                </tr>
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
                                                <input type="text" onKeyPress="return numbersOnly(this, event);" value="<?php echo $this->wo_row->wo_qty;?>" name="wo_qty" id="wo_qty" <?php echo $classDisabled;?> />
					</td>
				</tr>   
                                <tr>
					<td class="tg-0pky" valign="top">
						<label for="username">
							<?php echo JText::_( 'SO NUMBER' ); ?>
						</label>
					</td>
					<td>                                          
                                          <input type="hidden" value="<?php echo  $so_info['so_start_date'];?>" name="so_start_date" id="so_start_date" readonly="readonly" />                                                
					<input type="text" value="<?php echo $so_info['so_code'];?>" name="so_code" id="so_code" readonly="readonly" />
					<input type="hidden" name="so_id" id="so_id" value="<?php echo $so_info['so_id'];?>" />
						<a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmpns&task=get_so_ajax&tmpl=component" title="Image">
                                        <input type="button" name="addSO" value="<?php echo JText::_('Select SO')?>"/>
                                        </a>
										
					</td>
				</tr>                                
                                        <tr>
					<td class="tg-0pky" valign="top">
						<?php echo JText::_( 'TOP LEVEL ASSY P/N:' ); ?>
					</td>
                                        <td valign="top"><input type="text" value="" name="top_pns_code" id="top_pns_code" readonly="readonly" />
                                                <input type="hidden" value="" name="top_pns_id" id="top_pns_id" readonly="readonly" />
                                                <?php 
                                                if($so_info['so_code'])
                                                {
                                                ?>
                                                        <a class="modal-button" id="get_assy_pn" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmpns&task=get_list_assy_wo&tmpl=component&so_id=<?php echo $so_info['so_id']?>" title="<?php echo JText::_('Select Top ASSY P/N')?>"><?php echo JText::_('Select Top ASSY P/N')?></a>
                                                <?php
                                                }
                                                else
                                                {
                                                ?>
                                                <a class="modal-button" id="get_assy_pn" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmpns&task=get_list_assy_wo&tmpl=component" title="<?php echo JText::_('Select Top ASSY P/N')?>"></a>
                                                <?php 
                                                }
                                                ?>							
						
					</td>
                                        </tr>  
                                        <tr>
                                                <td class="tg-0pky" colspan="2" id='pns_assy_so' >

                                                </td>

                                        </tr>    
                                <tr>
					<td class="tg-0pky" valign="top">
						<label for="username">
							<?php echo JText::_( 'RMA' ); ?>
						</label>
					</td>
					<td>
                                                <input type="checkbox" id ="wo_rma_active" name="wo_rma_active" value="1" /> 
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
                                                <input type="text" value="<?php echo $so_info['so_shipping_date']?>" name="so_request_date" id="so_request_date" readonly="readonly" />
					</td>
				</tr>
                                 <tr>
					<td class="tg-0pky">
						<label for="name">
							<?php echo JText::_( 'WO Start Date' ); ?>
						</label>
					</td>
					<td>                                                 
                                               <?php echo JHTML::_('calendar',$this->so_row->wo_start_date, 'wo_start_date', 'wo_start_date', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	
					</td>
				</tr>      
                                 <tr>
					<td class="tg-0pky">
						<label for="name">
							<?php echo JText::_( 'WO Finished Date' ); ?>
						</label>
					</td>
					<td>                                                 
                                               <?php echo JHTML::_('calendar',$this->so_row->wo_completed_date, 'wo_completed_date', 'wo_completed_date', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	
					</td>
				</tr>    
                                
                                 <tr>
					<td class="tg-0pky">
						<label for="name">
							<?php echo JText::_( 'ASSIGNER' ); ?>
						</label>
					</td>
                                 <td>
                                                                <select  name="wo_assigner" id="wo_assigner" >
                                                                                <option value="">Select Assigner</option>
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
    <td class="tg-0pky"><label for="name">1</label></td>
    <td class="tg-0pky" colspan="5"><label for="name">Label Print By:</label></td>
    <td><textarea maxlength='40' name="op_comment1" rows="3" cols="30"></textarea></td>
    <td><?php echo JHTML::_('calendar',$this->so_row->op_completed_date, 'op_completed_date1', 'op_completed_date1', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
    <td> <select  name="op_assigner1" id="op_assigner1" >
                <option value="">Select Assignee</option>
                 <?php foreach ($this->list_user as $list) { ?>
                        <option value="<?php echo $list->id; ?>"><?php echo $list->name; ?></option>
                <?php } ?>
        </select>
    </td>
    <td><?php echo JHTML::_('calendar',$this->so_row->op_target_date, 'op_target_date1', 'op_target_date1', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
  </tr>
  <tr>
    <td class="tg-0pky"><label for="name">2</label></td>
    <td class="tg-0pky" colspan="5"><label for="name">Wire Cut By:</label></td>
    <td><textarea maxlength='40' name="op_comment2" rows="3" cols="30"></textarea></td>
    <td><?php echo JHTML::_('calendar',$this->so_row->op_completed_date, 'op_completed_date2', 'op_completed_date2', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
    <td>
            <select  name="op_assigner2" id="op_assigner2" >
                <option value="">Select Assignee</option>
                 <?php foreach ($this->list_user as $list) { ?>
                        <option value="<?php echo $list->id; ?>"><?php echo $list->name; ?></option>
                <?php } ?>
        </select>
    </td>
    <td><?php echo JHTML::_('calendar',$this->so_row->op_target_date, 'op_target_date2', 'op_target_date2', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
  </tr>
  <tr>
    <td class="tg-0pky"><label for="name">3</label></td>
    <td class="tg-0pky" colspan="5"><label for="name">Kitted By:</label></td>
    <td><textarea maxlength='40' name="op_comment3" rows="3" cols="30"></textarea></td>
    <td><?php echo JHTML::_('calendar',$this->so_row->op_completed_date, 'op_completed_date3', 'op_completed_date3', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
    <td><select  name="op_assigner3" id="op_assigner3" >
                <option value="">Select Assignee</option>
                 <?php foreach ($this->list_user as $list) { ?>
                        <option value="<?php echo $list->id; ?>"><?php echo $list->name; ?></option>
                <?php } ?>
        </select></td>
    <td><?php echo JHTML::_('calendar',$this->so_row->op_target_date, 'op_target_date3', 'op_target_date3', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
  </tr>
  <tr>
    <td class="tg-0pky"><label for="name">4</label></td>
    <td class="tg-0pky" colspan="5"><label for="name">Assembly performed by:</label></td>
    <td><textarea maxlength='40' name="op_comment4" rows="3" cols="30"></textarea></td>
    <td><?php echo JHTML::_('calendar',$this->so_row->op_completed_date, 'op_completed_date4', 'op_completed_date4', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
    <td>
            <select  name="op_assigner4" id="op_assigner4" >
                <option value="">Select Assignee</option>
                 <?php foreach ($this->list_user as $list) { ?>
                        <option value="<?php echo $list->id; ?>"><?php echo $list->name; ?></option>
                <?php } ?>
        </select>
    </td>
    <td><?php echo JHTML::_('calendar',$this->so_row->op_target_date, 'op_target_date4', 'op_target_date4', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
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
  <tr>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_assembly_value1;?>" name="op_assembly_value1[1]" id="op_assembly_value1" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_assembly_value2;?>" name="op_assembly_value2[1]" id="op_assembly_value2" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_assembly_value3;?>" name="op_assembly_value3[1]" id="op_assembly_value3" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_assembly_value4;?>" name="op_assembly_value4[1]" id="op_assembly_value4" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_assembly_value5;?>" name="op_assembly_value5[1]" id="op_assembly_value5" /></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_assembly_value1;?>" name="op_assembly_value1[2]" id="op_assembly_value1" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_assembly_value2;?>" name="op_assembly_value2[2]" id="op_assembly_value2" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_assembly_value3;?>" name="op_assembly_value3[2]" id="op_assembly_value3" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_assembly_value4;?>" name="op_assembly_value4[2]" id="op_assembly_value4" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_assembly_value5;?>" name="op_assembly_value5[2]" id="op_assembly_value5" /></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_assembly_value1;?>" name="op_assembly_value1[3]" id="op_assembly_value1" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_assembly_value2;?>" name="op_assembly_value2[3]" id="op_assembly_value2" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_assembly_value3;?>" name="op_assembly_value3[3]" id="op_assembly_value3" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_assembly_value4;?>" name="op_assembly_value4[3]" id="op_assembly_value4" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_assembly_value5;?>" name="op_assembly_value5[3]" id="op_assembly_value5" /></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_assembly_value1;?>" name="op_assembly_value1[4]" id="op_assembly_value1" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_assembly_value2;?>" name="op_assembly_value2[4]" id="op_assembly_value2" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_assembly_value3;?>" name="op_assembly_value3[4]" id="op_assembly_value3" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_assembly_value4;?>" name="op_assembly_value4[4]" id="op_assembly_value4" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_assembly_value5;?>" name="op_assembly_value5[4]" id="op_assembly_value5" /></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
  </tr>
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
    <td><?php echo JHTML::_('calendar',$this->so_row->op_completed_date, 'op_completed_date5', 'op_completed_date6', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
    <td>
            <select  name="op_assigner5" id="op_assigne5" >
                <option value="">Select Assignee</option>
                 <?php foreach ($this->list_user as $list) { ?>
                        <option value="<?php echo $list->id; ?>"><?php echo $list->name; ?></option>
                <?php } ?>
        </select>
    </td>
    <td><?php echo JHTML::_('calendar',$this->so_row->op_target_date, 'op_target_date5', 'op_target_date5', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky"  colspan="3"><label for="name">Document not match</label></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_visual_value1;?>" name="op_visual_value1[1]" id="op_visual_value1" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_visual_value1;?>" name="op_visual_value1[2]" id="op_visual_value1" /></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky" colspan="2"><label for="name">Comment</label></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Traveler incomplete</label></td>
       <td><input type="text" size="6" value="<?php echo $this->wo_row->op_visual_value2;?>" name="op_visual_value2[1]" id="op_visual_value2" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_visual_value2;?>" name="op_visual_value2[2]" id="op_visual_value2" /></td>
   <td class="tg-0pky"></td>
    <td colspan="2" rowspan="4"><textarea maxlength='40' name="op_comment5" rows="12" cols="30"></textarea></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Wrong Dimension</label></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_visual_value3;?>" name="op_visual_value3[1]" id="op_visual_value3" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_visual_value3;?>" name="op_visual_value3[2]" id="op_visual_value3" /></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Label print error</label></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_visual_value4;?>" name="op_visual_value4[1]" id="op_visual_value4" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_visual_value4;?>" name="op_visual_value4[2]" id="op_visual_value4" /></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Missing Label / Wrong Location</label></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_visual_value5;?>" name="op_visual_value5[1]" id="op_visual_value5" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_visual_value5;?>" name="op_visual_value5[2]" id="op_visual_value5" /></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"><label for="name">6</label></td>
    <td class="tg-0pky" colspan="4"><label for="name">Final&nbsp;&nbsp;Inspection(QC) By:</label></td>
    <td></td>
    <td></td>
    <td><?php echo JHTML::_('calendar',$this->so_row->op_completed_date, 'op_completed_date6', 'op_completed_date6', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
    <td><select  name="op_assigner6" id="op_assigner6" >
                <option value="">Select Assignee</option>
                 <?php foreach ($this->list_user as $list) { ?>
                        <option value="<?php echo $list->id; ?>"><?php echo $list->name; ?></option>
                <?php } ?>
        </select></td>
    <td ><?php echo JHTML::_('calendar',$this->so_row->op_target_date, 'op_target_date6', 'op_target_date6', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Document not match</label></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_final_value1;?>" name="op_final_value1[1]" id="op_final_value1" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_final_value1;?>" name="op_final_value1[2]" id="op_final_value1" /></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky" colspan="2"><label for="name">COMMENTS</label></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Traveler incomplete</label></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_final_value2;?>" name="op_final_value2[1]" id="op_final_value2" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_final_value2;?>" name="op_final_value2[2]" id="op_final_value2" /></td>
    <td class="tg-0pky"></td>
    <td colspan="2" rowspan="6"><textarea maxlength='40' name="op_comment6" rows="16" cols="30"></textarea></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Wrong Dimension</label></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_final_value3;?>" name="op_final_value3[1]" id="op_final_value3" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_final_value3;?>" name="op_final_value3[2]" id="op_final_value3" /></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Label print error</label></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_final_value4;?>" name="op_final_value4[1]" id="op_final_value4" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_final_value4;?>" name="op_final_value4[2]" id="op_final_value4" /></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Missing Label / Wrong Location</label></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_final_value5;?>" name="op_final_value3[5]" id="op_final_value5" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_final_value5;?>" name="op_final_value3[5]" id="op_final_value5" /></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Miss Wire / Open Connection</label></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_final_value6;?>" name="op_final_value4[6]" id="op_final_value4" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_final_value6;?>" name="op_final_value4[6]" id="op_final_value4" /></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Fail Hipot Test</label></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_final_value5;?>" name="op_final_value5[1]" id="op_final_value5" /></td>
    <td><input type="text" size="6" value="<?php echo $this->wo_row->op_final_value4;?>" name="op_final_value4[2]" id="op_final_value5" /></td>
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
    <td><textarea maxlength='40' name="op_comment7" rows="3" cols="30"></textarea></td>
    <td><?php echo JHTML::_('calendar',$this->so_row->op_completed_date, 'op_completed_date7', 'op_completed_date7', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
    <td>
            <select  name="op_assigner7" id="op_assigner7" >
                <option value="">Select Assignee</option>
                 <?php foreach ($this->list_user as $list) { ?>
                        <option value="<?php echo $list->id; ?>"><?php echo $list->name; ?></option>
                <?php } ?>
        </select>
    </td>
    <td><?php echo JHTML::_('calendar',$this->so_row->op_target_date, 'op_target_date7', 'op_target_date7', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
  </tr>
			
                                          </table>
                </fieldset>
</div>
	<input type="hidden" name="pns_id" value="<?php echo  $cid[0];?>" />	
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="return" value="<?php echo $so_id;?>"  />
	<input type="hidden" name="task" value="save_works_order" />        
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
