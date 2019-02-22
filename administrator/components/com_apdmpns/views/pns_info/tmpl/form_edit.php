<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip');
$cid = JRequest::getVar( 'cid', array(0) );
$edit		= JRequest::getVar('edit',true);
$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

JToolBarHelper::title( JText::_( 'PNS_MAMANGEMENT' ) . ': <small><small>[ '. $text .' ]</small></small>' , 'cpanel.png' );
if (!intval($edit)) {
        JToolBarHelper::save('save', 'Save & Add new');
}

JToolBarHelper::apply('edit_pns', 'Save');
if ( $edit ) {
        // for existing items the button is renamed `close`
        JToolBarHelper::cancel( 'cancel', 'Close' );
} else {
        JToolBarHelper::cancel();
}

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
		var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&]", "i");
		if (form.pns_revision.value !="" && form.pns_revision.value.length != 2){
			alert("PNs Revision must 2 characters");
			form.pns_revision.focus();
			return false;
		}		
		if (form.eco_id.value==0){
			alert("Please select ECO");
			form.eco.focus();
			return false;
		}
//		if (form.pns_stock.value < form.pns_qty_used.value){
//			alert("Please input Stock greater than Qty Used	");
//			form.pns_stock.focus();
//			return false;
//		}                
//		if (form.pns_status.value==""){
//			alert("Please select Part Number Status/");
//			from.pns_status.focus();
//			return false;
//		}
		
		submitform( pressbutton );
	}
	function get_defautl_code(){
		var url = 'index.php?option=com_apdmpns&task=code_default';
		var MyAjax = new Ajax(url, {
			method:'get',
			onComplete:function(result){
				$('pns_code').value = result;
			}
		}).request();
	}
	
	function get_rev_roll(){
		var url = 'index.php?option=com_apdmpns&task=rev_roll';
		var ccs_code = $('ccs_code').value;
		var pns_code = $('pns_code').value;
		url = url + '&ccs_code=' + ccs_code + '&pns_code=' + pns_code;
		
		var MyAjax = new Ajax(url, {
			method:'get',
			onComplete:function(result){

				if ( result.toString() == '0A' ){
					alert('<?php echo JText::_('End of REV roll. Please contact with Administrator.');?>');					
				}else{
					$('pns_revision').value = result;
				}
			}
		}).request();
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
		});

</script>

<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data" >
	<div class="col width-100">
		<fieldset class="adminform">
<!--		<legend><?php echo JText::_( 'PNs Detail' ); ?></legend>-->
			<table class="admintable" cellspacing="1">
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Ascenx Viet Nam P/N' ); ?>
						</label>
					</td>
					<td><?php echo $this->row->ccs_code.'-'.$this->row->pns_code;?>
						<input type="hidden"  name="pns_code" id="pns_code"  size="10" value="<?php echo $this->row->pns_code;?>"/>
						<input type="hidden" name="ccs_code" id="ccs_code" value="<?php echo $this->row->ccs_code;?>" />
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_REVISION' ); ?>
						</label>
					</td>
					<td>
                                                <?php echo $this->row->pns_revision;?>
						<input type="hidden" onkeypress="return CharatersOnlyEspecial(this, event)" value="<?php echo $this->row->pns_revision;?>" name="pns_revision" id="pns_revision" class="inputbox" size="6" maxlength="2" />
						<input type="hidden" value="<?php echo $this->row->pns_revision;?>" name="pns_revision_old" />
<input type="hidden" name="RevRoll" value="<?php echo JText::_('Rev Roll')?>" onclick="get_rev_roll();"/>
						
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_CHILD' ); ?>
						</label>
					</td>
					<td valign="top">
						<?php 
							if (count($this->lists['pns_parent_info']) > 0) {
							?>
								<a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmpns&task=list_child&tmpl=component&id=<?php echo $this->row->pns_id?>" title="Image">
<input type="button" name="listPnsChild" value="<?php echo JText::_('List PNs Child')?>"/>
</a>			
		
						<?php	}
						?>
					
						
						<p>
						<a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmpns&task=get_list_child&tmpl=component&id=<?php echo $this->row->pns_id?>" title="Image">
<input type="button" name="addECO" value="<?php echo JText::_('Addition PNS Child')?>"/>
</a>			</p>
						<div id='pns_child'>
						</div>
					</td>
				</tr>
				<!--<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php //echo JText::_( 'PNS_PARENT' ); ?>
						</label>
					</td>
					<td valign="top">
						<?php 
							/*if (count($this->lists['where_use']) > 0) { ?>
								<a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmpns&task=list_where_used&tmpl=component&id=<?php echo $this->row->pns_id?>" title="Image">
<input type="button" name="where_used" value="<?php echo JText::_('List PNs')?>"/>
							<?php	
							}else {
								echo JText::_('NONE_PNS_USE');
							}*/
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
					<input type="text" value="<?php echo PNsController::GetECO($this->row->eco_id); ?>" name="eco_name" id="eco_name" readonly="readonly" />
					<input type="hidden" name="eco_id" id="eco_id" value="<?php echo $this->row->eco_id;?>" />
                                        <?php 
                                        if($this->pns_status!='Release'){?>
					<a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmeco&task=get_eco&tmpl=component" title="Image">
<input type="button" name="addECO" value="<?php echo JText::_('Select ECO')?>"/>
                                        <?php
                                        }
                                        ?>
</a>	
					</td>
				</tr>
<!--				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Make/Buy' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->lists['pns_type']?>
					</td>
				</tr>-->
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_DESCRIPTION' ); ?>
						</label>
					</td>
					<td>
						<textarea maxlength='40' name="pns_description" rows="6" cols="30"><?php echo $this->row->pns_description?></textarea>
					</td>
				</tr>
<!--				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_STATUS' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->lists['status']?>
					</td>
				</tr>-->
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'State' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->lists['life_cycle']?>
					</td>
				</tr>
                                                 <?php 
                                                 $classDisabled="";
//                                                 $classDisabled = 'disabled = "disabled"';  
//                                        if($this->pns_status=='Released'){
//                                                $classDisabled = "";
//                                        }
                                        ?>                                
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Cost' ); ?>
						</label>
					</td>
					<td>
                                                <input type="text" value="<?php echo $this->lists['pns_cost']?>" name="pns_cost" id="pns_cost" <?php echo $classDisabled;?> />
					</td>
				</tr>
<!--				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Date In' ); ?>
						</label>
					</td>
					<td>
						<?php echo JHTML::_('calendar', $this->lists['pns_datein'], 'pns_datein', 'pns_datein', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Stock' ); ?>
						</label>
					</td>
					<td>

                                                <input type="text" value="<?php echo $this->lists['pns_stock']?>" name="pns_stock" id="pns_stock" <?php echo $classDisabled;?> />

					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Qty Used' ); ?>
						</label>
					</td>
					<td>
                                                <input type="text" value="<?php echo $this->lists['pns_qty_used']?>" name="pns_qty_used" id="pns_qty_used" />
					</td>
				</tr>    -->                            
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'UOM' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->lists['uom']?>
					</td>
				</tr>	                                
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Date Create' ); ?>
						</label>
					</td>
					<td>
 						<?php echo  JHTML::_('date', $this->row->pns_create, '%m-%d-%Y %H:%M:%S %p'); ?>

					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Create by' ); ?>
						</label>
					</td>
					<td>
 						<?php echo GetValueUser($this->row->pns_create_by, "username"); ?>

					</td>
				</tr>
				
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Date Modified' ); ?>
						</label>
					</td>
					<td>
 						<?php echo  ($this->row->pns_modified_by) ? JHTML::_('date', $this->row->pns_modified, '%m-%d-%Y %H:%M:%S %p') : ''; ?>

					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Modified By' ); ?>
						</label>
					</td>
					<td> 						
						<?php echo  ($this->row->pns_modified_by) ? GetValueUser($this->row->pns_modified_by, "username") : ''; ?>

					</td>
				</tr>
				
			</table>
		</fieldset>
	</div>
<div style="display:none"><?php
						// parameters : areaname, content, width, height, cols, rows
					//	echo $editor->display( 'text',  $row->text , '10%', '10', '10', '3' ) ;
						?></div>
	<input name="nvdid" value="<?php echo $this->lists['count_vd'];?>" type="hidden" />
	<input name="nspid" value="<?php echo $this->lists['count_sp'];?>" type="hidden" />
	<input name="nmfid" value="<?php echo $this->lists['count_mf'];?>" type="hidden" />
	<input type="hidden" name="pns_id" value="<?php echo $this->row->pns_id;?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->row->pns_id;?>" />	
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="return" value="<?php echo $this->cd;?>"  />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
