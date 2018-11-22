<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php
$cid = JRequest::getVar('cid', array(0));
$edit = JRequest::getVar('edit', true);

JToolBarHelper::title($this->sto_row->sto_code, 'cpanel.png');
$role = JAdministrator::RoleOnComponent(8);      
if (in_array("W", $role)) {
        JToolBarHelper::addPnsSto("Add Part", $this->sto_row->pns_sto_id);        
        JToolBarHelper::customX('saveqtyStofk', 'save', '', 'Save', false);	
        
}
if (in_array("D", $role)) {
        JToolBarHelper::deletePns('Are you sure to delete it?',"removepnsstos","Remove Part");
}
$cparams = JComponentHelper::getParams('com_media');
$editor = &JFactory::getEditor();
?>

<?php
// clean item data
JFilterOutput::objectHTMLSafe($user, ENT_QUOTES, '');
?>
<script language="javascript" type="text/javascript">
        function submitbutton(pressbutton) {
                var form = document.adminFormPo;
                if (pressbutton == 'submit') {
                        var d = document.adminForm;
                        if (d.text_search.value==""){
                                alert("Please input keyword");	
                                d.text_search.focus();
                                return false;				
                        }else{
                                submitform( pressbutton );
                        }
                }
                if (pressbutton == 'saveqtyStofk') {
                        submitform( pressbutton );
                        return;
                }                      
                if(pressbutton == 'removepnsstos')
                {
                     submitform( pressbutton );
                     return;
                }                
			
        }

function isCheckedPosPn(isitchecked,id){
       
	if (isitchecked == true){
		document.adminForm.boxchecked.value++;
                document.getElementById('qty_'+id).style.visibility= 'visible';
                document.getElementById('qty_'+id).style.display= 'block';
                document.getElementById('text_qty_'+id).style.visibility= 'hidden';
                document.getElementById('text_qty_'+id).style.display= 'none';    
                
                document.getElementById('location_'+id).style.visibility= 'visible';
                document.getElementById('location_'+id).style.display= 'block';
                document.getElementById('text_location_'+id).style.visibility= 'hidden';
                document.getElementById('text_location_'+id).style.display= 'none';    
                
                document.getElementById('partstate_'+id).style.visibility= 'visible';
                document.getElementById('partstate_'+id).style.display= 'block';
                document.getElementById('text_partstate_'+id).style.visibility= 'hidden';
                document.getElementById('text_partstate_'+id).style.display= 'none';                    
	}
	else {
		document.adminForm.boxchecked.value--;
                document.getElementById('text_qty_'+id).style.visibility= 'visible';
                document.getElementById('text_qty_'+id).style.display= 'block';

                document.getElementById('text_location_'+id).style.visibility= 'visible';
                document.getElementById('text_location_'+id).style.display= 'block';

                document.getElementById('text_partstate_'+id).style.visibility= 'visible';
                document.getElementById('text_partstate_'+id).style.display= 'block';

                document.getElementById('qty_'+id).style.visibility= 'hidden';
                document.getElementById('qty_'+id).style.display= 'none';
                
                document.getElementById('location_'+id).style.visibility= 'hidden';
                document.getElementById('location_'+id).style.display= 'none';
                document.getElementById('partstate_'+id).style.visibility= 'hidden';
                document.getElementById('partstate_'+id).style.display= 'none';                
             
                
                
	}
}        

</script>
<div class="clr"></div>
<form action="index.php?option=com_apdmpns&task=stomanagement&t=<?php echo time();?>"  onsubmit="submitbutton('')"  method="post" name="adminForm" >	
<?php if (count($this->sto_pn_list) > 0) { ?>
                <table class="adminlist" cellspacing="1" width="400">
                        <thead>
                                <tr>
                                        <th width="18"><?php echo JText::_('No'); ?></th>                                               
                                        <th width="3%" class="title">
<!--					<input type="checkbox" name="CheckAll" value="0" onClick="checkboxBom(document.adminForm.pns_po)"/>-->
				</th>                                        
                                        <th width="100"><?php echo JText::_('Part Number'); ?></th>
                                        <th width="100"><?php echo JText::_('Description'); ?></th>                                                
                                        <th width="100"><?php echo ($this->sto_row->sto_type==1)?JText::_('Qty In'):JText::_('Qty Out'); ?></th>
                                        <th width="100"><?php echo JText::_('Location'); ?></th>                                                
                                        <th width="100"><?php echo JText::_('Part State'); ?></th>                                                
                                </tr>
                        </thead>
                        <tbody>					
        <?php
        
        $locationArr = array();
//        $Alpha=array("A010","A020","A030","A040","A010","B010","B020","B030","C010","C020","C030","C040","C050","C060","C070","C080","D010","D020","E010","E020","E030","E040","E050","E060","E070","E080");
//
//        foreach($Alpha as $val)
//        {
//                for($i =1;$i<=5;$i++)
//                {
//                        //$locationArr[$val.$i] = $val.$i;
//                        $locationArr[] = JHTML::_('select.option', $val.$i, $val.$i , 'value', 'text'); 
//                }
//        }
        $location = PNsController::GetLocationCodeList();
        foreach($location as $rowcode)
        {
              $locationArr[] = JHTML::_('select.option',$rowcode->pns_location_id ,$rowcode->location_code, 'value', 'text');   
        }
        $partStateArr   = array();
        $partStateArr[] = JHTML::_('select.option', 'OH-G', "OH-G" , 'value', 'text'); 
        $partStateArr[] = JHTML::_('select.option', 'OH-D', "OH-D" , 'value', 'text'); 
        $partStateArr[] = JHTML::_('select.option', 'IT-G', "IT-G" , 'value', 'text'); 
        $partStateArr[] = JHTML::_('select.option', 'IT-D', "IT-D" , 'value', 'text'); 
        $partStateArr[] = JHTML::_('select.option', 'OO', "OO" , 'value', 'text'); 
        $partStateArr[] = JHTML::_('select.option', 'Prototype', "Prototype" , 'value', 'text'); 
        

        $i = 0;       
        foreach ($this->sto_pn_list as $row) {
                $i++;
                                if($row->pns_cpn==1)
                                        $link 	= 'index.php?option=com_apdmpns&amp;task=detailmpn&cid[0]='.$row->pns_id;	
                                else
                                        $link 	= 'index.php?option=com_apdmpns&amp;task=detail&cid[0]='.$row->pns_id;					
                                $image = PNsController::GetImagePreview($row->pns_id);
				if ($image !=''){					
                                        $pns_image = "<img border=&quot;1&quot; src='".$path_image.$image."' name='imagelib' alt='".JText::_( 'No preview available' )."' width='100' height='100' />";
				}else{
					$pns_image = JText::_('None image for preview');
				}                
                                           
                                ?>
                                        <tr>
                                                <td><?php echo $i; ?></td>         
                                                <td>					
                                                <input type="checkbox" id = "pns_po" onclick="isCheckedPosPn(this.checked,'<?php echo $row->id;?>');" value="<?php echo $row->id;?>" name="cid[]"  />
                                                </td>                                                
                                                <td><span class="editlinktip hasTip" title="<?php echo $pns_image;?>" >
					<a href="<?php echo $link;?>" title="<?php echo JText::_('Click to see detail PNs');?>"><?php echo $row->parent_pns_code;?></a>
				</span></td>
                                                <td><?php echo $row->pns_description; ?></td>                                                
                                                <td>                                                    
                                                        <span style="display:block" id="text_qty_<?php echo $row->id;?>"><?php echo $row->qty;?></span>
                                                        <input style="display:none" onKeyPress="return numbersOnly(this, event);" type="text" value="<?php echo $row->qty;?>" id="qty_<?php echo $row->id;?>"  name="qty_<?php echo $row->id;?>" />                                                        
                                                </td> 
                                                <td align="center">					
                                                        <span style="display:block" id="text_location_<?php echo $row->id;?>"><?php echo $row->location?PNsController::GetCodeLocation($row->location):"";?></span>
                                                         <?php                                         
                                                         echo JHTML::_('select.genericlist',   $locationArr, 'location_'.$row->id, 'class="inputbox" style="display:none" size="1" ', 'value', 'text', $row->location ); 
                                                        ?>
                                                </td>	
                                                <td align="center">					
                                                        <span style="display:block" id="text_partstate_<?php echo $row->id;?>"><?php echo $row->partstate?$row->partstate:"";?></span>
                                                         <?php                                         
                                                         echo JHTML::_('select.genericlist',   $partStateArr, 'partstate_'.$row->id, 'class="inputbox" style="display:none" size="1" ', 'value', 'text', $row->partstate ); 
                                                        ?>
                                                </td> 
                                               </tr>
                                                <?php }
                                        } 
                                        else
                                        {
                                                echo "Not found PNs"; 
                                        }
                                        ?>
                </tbody>
        </table>		

        <input type="hidden" name="sto_id" value="<?php echo $this->sto_row->pns_sto_id; ?>" />
        <input type="hidden" name="option" value="com_apdmpns" />     
        <input type="hidden" name="id" value="<?php echo JRequest::getVar('id'); ?>" />     
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_('form.token'); ?>
</form>
