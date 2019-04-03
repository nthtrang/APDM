<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php JHTML::_('behavior.modal');
        if($this->row->pns_cpn==1)
        {
                $app =& JFactory::getApplication();
                $app->redirect('index.php?option=com_apdmpns&task=detailmpn&cid[0]='.$this->row->pns_id);
        }
	$cid = JRequest::getVar( 'cid', array(0) );
	//$edit		= JRequest::getVar('edit',true);
	//$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
	$role = JAdministrator::RoleOnComponent(6);
//	if (in_array("S", $role)) {		
//                JToolBarHelper::customX('updatestock', 'edit', '', 'Update Stock', false);
//	}             
        $partnumber = $this->row->ccs_code.'-'.$this->row->pns_code;
        if ($this->row->pns_revision) 
        {
                $partnumber .= '-'.$this->row->pns_revision;
        }
	//JToolBarHelper::title( JText::_( 'PART NUMBER' ) . ': <small><small>[ '. JText::_('Detail') .' ]</small></small>' , 'cpanel.png' );
        JToolBarHelper::title( $partnumber, 'cpanel.png');
	JToolBarHelper::customX('export_detail', 'excel', '', 'Export', false);
	if (in_array("E", $role) && $this->row->pns_life_cycle =='Create') {
		JToolBarHelper::editListX();
	}
        else
        {
                JToolBarHelper::customX("Cannotedit", 'cannotedit', '', 'Cannotedit', false);
        }
	if (in_array("W", $role)) {
                //viet comment
		//JToolBarHelper::addNew();
	}	
	if (in_array("S", $role)) {		
                JToolBarHelper::customX('updatestock', 'edit', '', 'Update Cost', false);
	}       
	if (in_array("D", $role)) {		
                JToolBarHelper::deleteList('Are you sure to delete it?');
	}        
	JToolBarHelper::cancel( 'cancel', 'Close' );			
	$cparams = JComponentHelper::getParams ('com_media');
	$editor = &JFactory::getEditor();
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
                if (pressbutton == 'edit') {
                        submitform( pressbutton );
                        return;
                }
                if (pressbutton == 'updatestock') {
                        submitform( pressbutton );
                        return;
                }                        
                if (pressbutton == 'export_detail') {
                        submitform( pressbutton );
                        return;
                }
                if (pressbutton == 'remove') {
				submitform( pressbutton );
				return;
			}                    
			
	}	
	///for add more file
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
<div class="submenu-box">
            <div class="t">
                <div class="t">
                        <div class="t"></div>
                </div>
        </div>
        <div class="m">
		<ul id="submenu" class="configuration">
			<li><a id="detail" class="active"><?php echo JText::_( 'Detail' ); ?></a></li>
			<li><a id="bom" href="index.php?option=com_apdmpns&task=bom&id=<?php echo $this->row->pns_id;?>"><?php echo JText::_( 'BOM' ); ?></a></li>
			<li><a id="whereused" href="index.php?option=com_apdmpns&task=whereused&id=<?php echo $this->row->pns_id;?>"><?php echo JText::_( 'Where Used' ); ?></a></li>
                        <li><a id="specification" href="index.php?option=com_apdmpns&task=specification&cid[]=<?php echo $this->row->pns_id;?>"><?php echo JText::_( 'Specification' ); ?></a></li>
                        <li><a id="mep" href="index.php?option=com_apdmpns&task=mep&cid[]=<?php echo $this->row->pns_id;?>"><?php echo JText::_( 'MEP' ); ?></a></li>
                        <li><a id="rev" href="index.php?option=com_apdmpns&task=rev&cid[]=<?php echo $this->row->pns_id;?>"><?php echo JText::_( 'REV' ); ?></a></li>
                         <?php if($this->row->pns_cpn!=1){?>
                        <li><a id="dash" href="index.php?option=com_apdmpns&task=dash&cid[]=<?php echo $this->row->pns_id;?>"><?php echo JText::_( 'DASH ROLL' ); ?></a></li>                        
                        <?php } ?>
                        <li><a id="pos" href="index.php?option=com_apdmpns&task=po&cid[]=<?php echo $this->row->pns_id;?>"><?php echo JText::_( 'PO' ); ?></a></li>                        
                        <li><a id="stos" href="index.php?option=com_apdmpns&task=sto&cid[]=<?php echo $this->row->pns_id;?>"><?php echo JText::_( 'STO' ); ?></a></li>
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
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data" >
	<div class="col width-60">
		<fieldset class="adminform">
		<legend><?php //echo JText::_( 'PNs Detail' ); ?></legend>
			<table class="admintable" cellspacing="1">
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Ascenx Vietnam PN' ); ?>
						</label>
					</td>
					<td width="500"><?php 
                                        if($this->row->pns_revision)
                                                $pns_code = $this->row->ccs_code.'-'.$this->row->pns_code.'-'.$this->row->pns_revision;
                                        else
                                                $pns_code = $this->row->ccs_code.'-'.$this->row->pns_code;                                                                                        
                                        
                                        echo $pns_code;
                                        ?>
					</td>
				</tr>	
                                
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'PNS_REVISION' ); ?>
						</label>
					</td>
					<td><?php echo $this->row->pns_revision;?>
					</td>
				</tr>	
<!--				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_CHILD' ); ?>
						</label>
					</td>
					<td valign="top">
						<?php 
							if (count($this->lists['pns_parent_info']) > 0) {
								//foreach ($this->lists['pns_parent_info'] as $pns_parent) { 			
								 // $link_info = 'index.php?option=com_apdmpns&task=detail&cid[0]='.$pns_parent['id'];
								?>
								<a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmpns&task=list_child&tmpl=component&id=<?php echo $this->row->pns_id?>" title="Image">
<input type="button" name="listPnsChild" value="<?php echo JText::_('List PNs Child')?>"/>
</a>			
		

							<?php	//}
							}else{
							echo JText::_('NONE_PNS_CHILD');
							}
						?>
						
					</td>
				</tr>-->
<!--				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_PARENT' ); ?>
						</label>
					</td>
					<td valign="top">
						<?php 
							if (count($this->lists['where_use']) > 0) {								
								?>
								<a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmpns&task=list_where_used&tmpl=component&id=<?php echo $this->row->pns_id?>" title="Image">
<input type="button" name="where_used" value="<?php echo JText::_('List PNs')?>"/>
                                                <a href="index.php?option=com_apdmpns&task=list_where_used&tmpl=component&id=<?php echo $this->row->pns_id?>" title="Image">
<input type="button" name="where_used" value="<?php echo JText::_('List PNs')?>"/>
</a>
							<?php	
							}else{
								echo JText::_('NONE_PNS_USE');
							}
						?>
						
					</td>
				</tr>-->
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_ECO' ); ?>
						</label>
					</td>
					<td>
						<?php echo PNsController::GetEcoValue($this->row->eco_id);?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Make/Buy' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->pns_type; ?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_DESCRIPTION' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->pns_description?>
					</td>
				</tr>
<!--				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_STATUS' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->pns_status; ?>
					</td>
				</tr>-->
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'State' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->pns_life_cycle; ?>
					</td>
				</tr>	
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Cost' ); ?>
						</label>
					</td>
					<td>
                                                <?php echo $this->row->pns_cost;?>
					</td>
				</tr>	                                				
<!--				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Date In' ); ?>
						</label>
					</td>
					<td>						
                                                <?php echo  JHTML::_('date', $this->row->pns_datein,JText::_('DATE_FORMAT_LC5')); ?>
					</td>
				</tr>	
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Stock' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->pns_stock; ?>
					</td>
				</tr>	      -->
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Qty Used' ); ?>
						</label>
					</td>
					<td>
						<?php //echo $this->row->pns_qty_used; ?>                                                
                                                <?php echo PNsController::CalculateQtyUsedValue($this->row->pns_id);?>
					</td>
				</tr>	        
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Inventory' ); ?>
						</label>
					</td>
					<td>
						<?php echo PNsController::CalculateInventoryValue($this->row->pns_id);?>
					</td>
				</tr>	                                 
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'UOM' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->pns_uom; ?>
					</td>
                                        
				</tr>	
                                <?php 
                                     //   if($this->row->ccs_code=='206'){?>
                                <tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Tool PN' ); ?>
						</label>
					</td>
					<td><div id="tool_pnlists">
                                                <?php $pntool =  PNsController::getToolPnAddtoBom($this->row->pns_id);
                                                if($pntool){
                                                ?>

                                              <table class="adminlist" cellspacing="1" width="100%">
                                   
                                                        <tr>
                                                                <th width="2%"  align="center" class="key"><?php echo JText::_( 'NUM' ); ?></th>
                                                                <th  align="center" width="20%" class="key">Tool PN</th>                                                               
                                                                <th align="center"  width="15%" class="key"></th>
                                                        </tr> 
                                                <?php 
                                                        $i=0;
                                                        foreach($pntool as $pn)
                                                        {
                                                                $i++;
                                                                ?>
                                                        <tr><td><?php echo $i;?></td><td><?php 
                                                         if($pn->pns_revision){
                                                                $toolpns_code = $pn->ccs_code.'-'.$pn->pns_code.'-'.$pn->pns_revision;
                                                         }
                                                        else{
                                                                $toolpns_code = $pn->ccs_code.'-'.$pn->pns_code;
                                                        }
                                        
                                                        echo $toolpns_code;
                                                        ?></td><td><a href="index.php?option=com_apdmpns&task=removetoolbom&id=<?php echo $pn->id;?>&pns_id=<?php echo $this->row->pns_id;?>">Remove</a></td></tr>
                                                        <?php 
                                                        }
                                                ?>
                                                        </table>
                                                <?php }?></div>
                                                
					<a class="modal-button" rel="{handler: 'iframe', size: {x: 850, y: 400}}" href="index.php?option=com_apdmpns&task=get_pntoolboom&tmpl=component&cid[0]=<?php echo $this->row->pns_id;?>" title="Image">
                                                <input type="button" name="addECO" value="<?php echo JText::_('Select Tools')?>"/>
                                        
                                        </td>
                                        
				</tr>	
                                <?php
                                  //      }
                                        ?>
                                <tr>
                                        <td class="key" valign="top">
                                                <label for="username">
                                                        <?php echo JText::_('Created Date'); ?>
                                                </label>
                                        </td>
                                        <td>
                                                <?php echo JHTML::_('date',$this->row->pns_create, JText::_('DATE_FORMAT_LC6')); ?>
                                                        
                                        </td>
                                </tr>
				
				
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Created by' ); ?>
						</label>
					</td>
					<td>
 						<?php echo GetValueUser($this->row->pns_create_by, "name"); ?>

					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Modified Date' ); ?>
						</label>
					</td>
					<td>
 						<?php echo  ($this->row->pns_modified_by) ? JHTML::_('date', $this->row->pns_modified, JText::_('DATE_FORMAT_LC6')) : ''; ?>

					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Modified By' ); ?>
						</label>
					</td>
					<td> 						
						<?php echo  ($this->row->pns_modified_by) ? GetValueUser($this->row->pns_modified_by, "name") : ''; ?>

					</td>
				</tr>
				
				
			</table>
		</fieldset>
	</div>

	
<div style="display:none"><?php
						// parameters : areaname, content, width, height, cols, rows
						//echo $editor->display( 'text',  $row->text , '10%', '10', '10', '3' ) ;
						?></div>
	<input name="nvdid" value="<?php echo $this->lists['count_vd'];?>" type="hidden" />
	<input name="nspid" value="<?php echo $this->lists['count_sp'];?>" type="hidden" />
	<input name="nmfid" value="<?php echo $this->lists['count_mf'];?>" type="hidden" />
	<input type="hidden" name="pns_id" value="<?php echo $this->row->pns_id;?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->row->pns_id;?>" />	
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="return" value="<?php echo $this->cd;?>"  />
	<input type="hidden" name="boxchecked" value="1" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
