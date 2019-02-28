<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php JHTML::_('behavior.modal'); ?>

<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);	
	$role = JAdministrator::RoleOnComponent(8);	
	JToolBarHelper::title($this->sto_row->sto_code .': <small><small>[ view ]</small></small>' , 'generic.png' );
	//if (in_array("E", $role)) {
                        JToolBarHelper::customX("editito",'edit',"Edit","Edit");
	//}
	
	
	JToolBarHelper::cancel( 'cancel', 'Close' );
	
	$cparams = JComponentHelper::getParams ('com_media');
?>

<?php
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	
?>
<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		if (pressbutton == 'add') {
				submitform( pressbutton );
				return;
			}
                if (pressbutton == 'editito') {
                        submitform( pressbutton );
                        return;
                }
                if (pressbutton == 'editmpn') {
                        submitform( pressbutton );
                        return;
                }                
                
		
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
<div class="submenu-box">
            <div class="t">
                <div class="t">
                        <div class="t"></div>
                </div>
        </div>
        <div class="m">
		<ul id="submenu" class="configuration">
			<li><a id="detail" class="active"><?php echo JText::_( 'DETAIL' ); ?></a></li>
			<li><a id="bom" href="index.php?option=com_apdmsto&task=ito_detail_pns&id=<?php echo $this->sto_row->pns_sto_id;?>"><?php echo JText::_( 'AFFECTED PARTS' ); ?></a></li>
                        <li><a id="bom" href="index.php?option=com_apdmsto&task=ito_detail_support_doc&id=<?php echo $this->sto_row->pns_sto_id;?>"><?php echo JText::_( 'SUPPORTING DOC' ); ?></a></li>                      
                </ul>
		<div class="clr"></div>
        </div>
        <div class="b">
                <div class="b">
                        <div class="b"></div>
                </div>
        </div>
</div>
<div class="clr"></div>
<p>&nbsp;</p>

<form action="index.php"  onsubmit="submitbutton('')"  method="post" name="adminForm" >	
        <fieldset class="adminform">
		<legend><?php echo JText::_( 'ITO Detail' ); ?></legend>        
        <table class="admintable" cellspacing="1"  width="70%">
                              <tr>
                                        <td class="key" width="28%"><?php echo JText::_('ITO'); ?></td>                                               
                                        <td width="30%" class="title"><?php echo $this->sto_row->sto_code; ?></td>                                          
                                        <td class="key" width="18%"><?php echo JText::_('Supplier'); ?></td>                                               
                                        <td width="30%" class="title"><?php echo SToController::GetSupplierName($this->sto_row->sto_supplier_id);?></td>
				                                                                              
                                </tr>
                                <tr>
                                        <td  class="key" width="28%"><?php echo JText::_('P.O Internal'); ?></td>                                               
                                        <td width="30%" class="title"><?php echo $this->sto_row->sto_po_internal;?></td>                                        
									   <td  class="key" width="28%"><?php echo JText::_('State'); ?></td>
									   <td width="30%" class="title"><?php echo $this->sto_row->sto_state;?></td>
                                </tr>  
                                <tr>
                                        <td class="key"  width="28%"><?php echo JText::_('Created Date'); ?></td>                                               
                                        <td width="30%" class="title">  <?php echo JHTML::_('date', $this->sto_row->sto_created, JText::_('DATE_FORMAT_LC5')); ?></td>  
										<td  class="key" width="28%"><?php echo JText::_('Stocker'); ?></td>
									   <td width="30%" class="title"><?php echo GetValueUser($this->sto_row->sto_stocker, "name"); ?></td>                                       
				                                                                              
                                </tr>
                                <tr>
                                        <td class="key"  width="28%"><?php echo JText::_('Completed Date'); ?></td>                                               
                                        <td width="30%" class="title">  <?php echo ($this->sto_row->sto_completed_date)?JHTML::_('date', $this->sto_row->sto_completed_date, JText::_('DATE_FORMAT_LC5')):""; ?></td>  
										<td  class="key" width="28%"><?php echo JText::_('Stocker Confirm'); ?></td>
									   <td width="30%" class="title">
                                                   <input checked="checked" type="checkbox" name="sto_stocker_confirm" value="1" onclick="return false;" onkeydown="return false;" />
                                                                           </td>
				                                                                              
                                </tr>                                
                                <tr>
                                        <td  class="key" width="28%"><?php echo JText::_('Owner'); ?></td>                                               
                                        <td width="30%" class="title">  <?php echo ($this->sto_row->sto_owner)?GetValueUser($this->sto_row->sto_owner, "name"):""; ?></td>
					<td  class="key" width="28%"><?php echo JText::_('Confirm'); ?></td>                                               
                                        
                                         <td width="30%" class="title"> 
										 <?php                                                                                  
                                                             if($this->sto_row->sto_owner_confirm==0){
                                                        $sto_owner_confirm = 'checked="checked"';
                                                    ?>
                                                  
                                                   
                                                   <a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmsto&task=get_owner_confirm_sto&sto_id=<?php echo $this->sto_row->pns_sto_id?>&tmpl=component" title="Image">
                                                         <input <?php echo $sto_owner_confirm?> onclick="return false;" onkeydown="return false;" type="checkbox" name="sto_owner_confirm" value="1" /></a>
                                                        <?php }
                                                        else
                                                        {
                                                                       ?>
                                                <input checked="checked" onclick="return false;" onkeydown="return false;" type="checkbox" name="sto_owner_confirm" value="1" />
                                                                       <?php
                                                        }
                                                        ?>
                                        </td>  
				                                                                              
                                </tr> 
                                <tr>
                                        <td class="key"  width="28%"><?php echo JText::_('Description'); ?></td>                                               
                                             <td colspan="3"><?php echo $this->sto_row->sto_description; ?></td>                                 
				                                                                              
                                </tr>  
        </table>		
        </fieldset>
        <input type="hidden" name="so_id" value="<?php echo $this->sto_row->pns_sto_id; ?>" />
        <input type="hidden" name="option" value="com_apdmsto" />     
        <input type="hidden" name="id" value="<?php echo JRequest::getVar('id'); ?>" />     
	<input type="hidden" name="task" value="" />	
        <input type="hidden" name="boxchecked" value="1" />
<?php echo JHTML::_('form.token'); ?>
</form>

