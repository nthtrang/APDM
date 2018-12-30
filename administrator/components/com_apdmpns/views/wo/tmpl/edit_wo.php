<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.tooltip'); ?>
<?php JHTML::_('behavior.modal'); ?>
<?php	
        $edit = JRequest::getVar('edit',true);
        $text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
        JToolBarHelper::title("Edit WO#: ".$this->wo_row->wo_code, 'cpanel.png');
        JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

        $role = JAdministrator::RoleOnComponent(10);     
        JToolBarHelper::apply('save_editwo', 'Save');
        if ( $edit ) {
        // for existing items the button is renamed `close`
                JToolBarHelper::cancel( 'cancel', 'Close' );
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
                if (pressbutton == 'cancel') {
                        submitform( pressbutton );
                        return;
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
							<a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmpns&task=get_list_pns_wo&tmpl=component" title="<?php echo JText::_('click here to add more PN')?>"><?php echo JText::_('Select Part Number')?></a>			
						
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
                                                <input type="text" value="<?php echo $this->wo_row->wo_qty;?>" name="wo_qty" id="wo_qty" <?php echo $classDisabled;?> />
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
							<a class="modal-button" id="get_assy_pn" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmpns&task=get_list_assy_wo&so_id=<?php echo $this->wo_row->so_id;?>&tmpl=component" title="<?php echo JText::_('click here to add more PN')?>">Select Top ASSY P/N</a>
						
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
                                                <input checked="checked" type="checkbox" id ="wo_rma_active" name="wo_rma_active" value="1" /> 
					</td>
				</tr>                                              
                                       <tr>
					<td class="tg-0pky" valign="top">
						<label for="username">
							<?php echo JText::_( 'CUSTOMER' ); ?>
						</label>
					</td>
					<td>
                                                <input type="text" value="<?php echo $this->wo_row->wo_customer_id;?>" name="wo_customer_id" id="wo_customer_id" />
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
					</td>
				</tr>
                                 <tr>
					<td class="tg-0pky">
						<label for="name">
							<?php echo JText::_( 'WO# Start Date' ); ?>
						</label>
					</td>
					<td>                                                                                               
                                               <?php echo JHTML::_('calendar',$this->wo_row->wo_start_date, 'wo_start_date', 'wo_start_date', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	
					</td>
				</tr>      
                                 <tr>
					<td class="tg-0pky">
						<label for="name">
							<?php echo JText::_( 'WO# Finished Date' ); ?>
						</label>
					</td>
					<td>                                                 
                                               <?php echo JHTML::_('calendar',$this->wo_row->wo_completed_date, 'wo_completed_date', 'wo_completed_date', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	                                               
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
    <td><textarea maxlength='40' name="op_comment1" rows="3" cols="30"><?php echo $op_arr['wo_step1']['op_comment'];?></textarea></td>
    <td><?php echo JHTML::_('calendar',$op_arr['wo_step1']['op_completed_date'], 'op_completed_date1', 'op_completed_date1', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
    <td> <select  name="op_assigner1" id="op_assigner1" >
                <option value="">Select Assigner</option>
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
    </td>
    <td><?php echo JHTML::_('calendar',$op_arr['wo_step1']['op_target_date'], 'op_target_date1', 'op_target_date1', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
  </tr>
  <tr>
    <td class="tg-0pky"><label for="name">2</label></td>
    <td class="tg-0pky" colspan="5"><label for="name">Wire Cut By:</label></td>
    <td><textarea maxlength='40' name="op_comment2" rows="3" cols="30"><?php echo $op_arr['wo_step2']['op_comment'];?></textarea></td>
    <td><?php echo JHTML::_('calendar',$op_arr['wo_step2']['op_completed_date'], 'op_completed_date2', 'op_completed_date2', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
    <td>
            <select  name="op_assigner2" id="op_assigner2" >
                <option value="">Select Assigner</option>
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
    </td>
    <td><?php echo JHTML::_('calendar',$op_arr['wo_step2']['op_target_date'], 'op_target_date2', 'op_target_date2', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
  </tr>
  <tr>
    <td class="tg-0pky"><label for="name">3</label></td>
    <td class="tg-0pky" colspan="5"><label for="name">Kitted By:</label></td>
    <td><textarea maxlength='40' name="op_comment3" rows="3" cols="30"><?php echo $op_arr['wo_step3']['op_comment'];?></textarea></td>
    <td><?php echo JHTML::_('calendar',$op_arr['wo_step3']['op_completed_date'], 'op_completed_date3', 'op_completed_date3', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
    <td><select  name="op_assigner3" id="op_assigner3" >
                <option value="">Select Assigner</option>
                <?php foreach ($this->list_user as $list) { 
                         $selected = "";
                         if($list->id == $op_arr['wo_step3']['op_assigner'])
                         {
                                 $selected = 'selected="selected"';
                         }
                         ?>
                        <option value="<?php echo $list->id; ?>" <?php echo $selected?>><?php echo $list->name; ?></option>
                <?php } ?>
        </select></td>
    <td><?php echo JHTML::_('calendar',$op_arr['wo_step3']['op_target_date'], 'op_target_date3', 'op_target_date3', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
  </tr>
  <tr>
    <td class="tg-0pky"><label for="name">4</label></td>
    <td class="tg-0pky" colspan="5"><label for="name">Assembly performed by:</label></td>
    <td><textarea maxlength='40' name="op_comment4" rows="3" cols="30"><?php echo $op_arr['wo_step4']['op_comment'];?></textarea></td>
    <td><?php echo JHTML::_('calendar',$op_arr['wo_step4']['op_completed_date'], 'op_completed_date4', 'op_completed_date4', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
    <td>
            <select  name="op_assigner4" id="op_assigner4" >
                <option value="">Select Assigner</option>
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
    </td>
    <td><?php echo JHTML::_('calendar',$op_arr['wo_step4']['op_target_date'], 'op_target_date4', 'op_target_date4', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
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
  foreach ($this->wo_assem_rows as $a_row)
  {
  ?>
  <tr>
    <td><input type="text" size="6" value="<?php echo $a_row->op_assembly_value1;?>" name="op_assembly_value1[<?php echo $a_row->id;?>]" id="op_assembly_value1" /></td>
    <td><input type="text" size="6" value="<?php echo $a_row->op_assembly_value2;?>" name="op_assembly_value2[<?php echo $a_row->id;?>]" id="op_assembly_value2" /></td>
    <td><input type="text" size="6" value="<?php echo $a_row->op_assembly_value3;?>" name="op_assembly_value3[<?php echo $a_row->id;?>]" id="op_assembly_value3" /></td>
    <td><input type="text" size="6" value="<?php echo $a_row->op_assembly_value4;?>" name="op_assembly_value4[<?php echo $a_row->id;?>]" id="op_assembly_value4" /></td>
    <td><input type="text" size="6" value="<?php echo $a_row->op_assembly_value5;?>" name="op_assembly_value5[<?php echo $a_row->id;?>]" id="op_assembly_value5" /></td>
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
    <td><?php echo JHTML::_('calendar',$op_arr['wo_step5']['op_completed_date'], 'op_completed_date5', 'op_completed_date6', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
    <td>
            <select  name="op_assigner5" id="op_assigne5" >
                <option value="">Select Assigner</option>
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
    </td>
    <td><?php echo JHTML::_('calendar',$op_arr['wo_step5']['op_target_date'], 'op_target_date5', 'op_target_date5', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
  </tr>
  <?php $opvs_arr = $this->opvs_arr;?>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky"  colspan="3"><label for="name">Document not match</label></td>
    <td><input type="text" size="6" value="<?php echo $opvs_arr[1]['op_visual_value1']?>" name="op_visual_value1[1]" id="op_visual_value1" /></td>
    <td><input type="text" size="6" value="<?php echo $opvs_arr[2]['op_visual_value1']?>" name="op_visual_value1[2]" id="op_visual_value1" /></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky" colspan="2"><label for="name">Comment</label></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Traveler incomplete</label></td>
    <td><input type="text" size="6" value="<?php echo $opvs_arr[1]['op_visual_value2']?>" name="op_visual_value2[1]" id="op_visual_value2" /></td>
    <td><input type="text" size="6" value="<?php echo $opvs_arr[2]['op_visual_value2']?>" name="op_visual_value2[2]" id="op_visual_value2" /></td>
   <td class="tg-0pky"></td>
    <td colspan="2" rowspan="4"><textarea maxlength='40' name="op_comment5" rows="12" cols="30"><?php echo $op_arr['wo_step5']['op_comment'];?></textarea></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Wrong Dimension</label></td>
    <td><input type="text" size="6" value="<?php echo $opvs_arr[1]['op_visual_value3']?>" name="op_visual_value3[1]" id="op_visual_value3" /></td>
    <td><input type="text" size="6" value="<?php echo $opvs_arr[2]['op_visual_value3']?>" name="op_visual_value3[2]" id="op_visual_value3" /></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Label print error</label></td>
    <td><input type="text" size="6" value="<?php echo $opvs_arr[1]['op_visual_value4']?>" name="op_visual_value4[1]" id="op_visual_value4" /></td>
    <td><input type="text" size="6" value="<?php echo $opvs_arr[2]['op_visual_value4']?>" name="op_visual_value4[2]" id="op_visual_value4" /></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Missing Label / Wrong Location</label></td>
    <td><input type="text" size="6" value="<?php echo $opvs_arr[1]['op_visual_value5']?>" name="op_visual_value5[1]" id="op_visual_value5" /></td>
    <td><input type="text" size="6" value="<?php echo $opvs_arr[2]['op_visual_value5']?>" name="op_visual_value5[2]" id="op_visual_value5" /></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"><label for="name">6</label></td>
    <td class="tg-0pky" colspan="4"><label for="name">Final&nbsp;&nbsp;Inspection(QC) By:</label></td>
    <td></td>
    <td></td>
    <td><?php echo JHTML::_('calendar',$op_arr['wo_step6']['op_completed_date'], 'op_completed_date6', 'op_completed_date6', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
    <td><select  name="op_assigner6" id="op_assigner6" >
                <option value="">Select Assigner</option>
                <?php foreach ($this->list_user as $list) { 
                         $selected = "";
                         if($list->id == $op_arr['wo_step6']['op_assigner'])
                         {
                                 $selected = 'selected="selected"';
                         }
                         ?>
                        <option value="<?php echo $list->id; ?>" <?php echo $selected?>><?php echo $list->name; ?></option>
                <?php } ?>
        </select></td>
    <td ><?php echo JHTML::_('calendar',$op_arr['wo_step6']['op_target_date'], 'op_target_date6', 'op_target_date6', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
  </tr>
  <?php $opfn_arr = $this->opfn_arr;?>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Document not match</label></td>
    <td><input type="text" size="6" value="<?php echo $opfn_arr[1]['op_final_value1']?>" name="op_final_value1[1]" id="op_final_value1" /></td>
    <td><input type="text" size="6" value="<?php echo $opfn_arr[2]['op_final_value1']?>" name="op_final_value1[2]" id="op_final_value1" /></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky" colspan="2"><label for="name">COMMENTS</label></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Traveler incomplete</label></td>
    <td><input type="text" size="6" value="<?php echo $opfn_arr[1]['op_final_value2']?>" name="op_final_value2[1]" id="op_final_value2" /></td>
    <td><input type="text" size="6" value="<?php echo $opfn_arr[2]['op_final_value2']?>" name="op_final_value2[2]" id="op_final_value2" /></td>
    <td class="tg-0pky"></td>
    <td colspan="2" rowspan="6"><textarea maxlength='40' name="op_comment6" rows="16" cols="30"><?php echo $op_arr['wo_step6']['op_comment'];?></textarea></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Wrong Dimension</label></td>
    <td><input type="text" size="6" value="<?php echo $opfn_arr[1]['op_final_value3']?>" name="op_final_value3[1]" id="op_final_value3" /></td>
    <td><input type="text" size="6" value="<?php echo $opfn_arr[2]['op_final_value3']?>" name="op_final_value3[2]" id="op_final_value3" /></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Label print error</label></td>
    <td><input type="text" size="6" value="<?php echo $opfn_arr[1]['op_final_value4']?>" name="op_final_value4[1]" id="op_final_value4" /></td>
    <td><input type="text" size="6" value="<?php echo $opfn_arr[2]['op_final_value4']?>" name="op_final_value4[2]" id="op_final_value4" /></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Missing Label / Wrong Location</label></td>
    <td><input type="text" size="6" value="<?php echo $opfn_arr[1]['op_final_value5']?>" name="op_final_value5[1]" id="op_final_value5" /></td>
    <td><input type="text" size="6" value="<?php echo $opfn_arr[2]['op_final_value5']?>" name="op_final_value5[2]" id="op_final_value5" /></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Miss Wire / Open Connection</label></td>
    <td><input type="text" size="6" value="<?php echo $opfn_arr[1]['op_final_value6']?>" name="op_final_value6[1]" id="op_final_value6" /></td>
    <td><input type="text" size="6" value="<?php echo $opfn_arr[2]['op_final_value6']?>" name="op_final_value6[2]" id="op_final_value6" /></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky">&gt;</td>
    <td class="tg-0pky" colspan="3"><label for="name">Fail Hipot Test</label></td>
    <td><input type="text" size="6" value="<?php echo $opfn_arr[1]['op_final_value7']?>" name="op_final_value7[1]" id="op_final_value7" /></td>
    <td><input type="text" size="6" value="<?php echo $opfn_arr[2]['op_final_value7']?>" name="op_final_value7[2]" id="op_final_value7" /></td>
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
    <td><textarea maxlength='40' name="op_comment7" rows="3" cols="30"><?php echo $op_arr['wo_step7']['op_comment'];?></textarea></td>
    <td><?php echo JHTML::_('calendar',$op_arr['wo_step7']['op_completed_date'], 'op_completed_date7', 'op_completed_date7', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
    <td>
            <select  name="op_assigner7" id="op_assigner7" >
                <option value="">Select Assigner</option>
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
    </td>
    <td><?php echo JHTML::_('calendar',$op_arr['wo_step7']['op_target_date'], 'op_target_date7', 'op_target_date7', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?></td>
  </tr>
			
                                          </table>
                </fieldset>
         </div>
                
	<input type="text" name="wo_id" value="<?php echo $this->wo_row->pns_wo_id?>"  />	
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="return" value="so"  />
	<input type="hidden" name="task" value="save_sales_order" />        
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
