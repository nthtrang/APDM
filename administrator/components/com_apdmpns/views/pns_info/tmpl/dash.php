<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.tooltip'); ?>
<?php JHTML::_('behavior.modal');

	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

	 $partnumber = $this->row->ccs_code.'-'.$this->row->pns_code;
        if ($this->row->pns_revision) 
        {
                $partnumber .= '-'.$this->row->pns_revision;
        }
	//JToolBarHelper::title( JText::_( 'PART NUMBER' ) . ': <small><small>[ '. JText::_('Detail') .' ]</small></small>' , 'cpanel.png' );
        JToolBarHelper::title( $partnumber, 'cpanel.png');	
        $role = JAdministrator::RoleOnComponent(6);      
	if (in_array("E", $role)) {
                if (!intval($edit)) {
                        JToolBarHelper::save('save', 'Save & Add new');
                }
                JToolBarHelper::apply('edit_pns_dash', 'Save');
        }
	
	
	$cparams = JComponentHelper::getParams ('com_media');
	$editor = &JFactory::getEditor();
?>

<?php
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	
?>
<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
			
		if (form.eco_id.value==0){
			alert("Please select ECO");
			form.eco.focus();
			return false;
		}
		
		
		submitform( pressbutton );
	}
	function get_default_code(){
		var url = 'index.php?option=com_apdmpns&task=get_dash_up&pns_id='+<?php echo $cid[0];?>;
                var ccs_code = $('ccs_code').value;
               // var pns_id = $('pns_id').value; 
		var pns_code = $('pns_code').value;
                url = url + '&ccs_code=' + ccs_code + '&pns_code=' + pns_code;
		var MyAjax = new Ajax(url, {
			method:'get',
			onComplete:function(result){
				$('pns_version').value = result;
                                document.getElementById("content_version").innerHTML =  result;
                               
			}
		}).request();
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
</script>
<div class="submenu-box">
        <div class="t">
                <div class="t">
                        <div class="t"></div>
                </div>
        </div>
        <div class="m">
		<ul id="submenu" class="configuration">
			<li><a id="detail"  href="index.php?option=com_apdmpns&task=detail&cid[0]=<?php echo $this->row->pns_id?>"><?php echo JText::_( 'Detail' ); ?></a></li>
			<li><a id="bom" href="index.php?option=com_apdmpns&task=bom&id=<?php echo $this->row->pns_id;?>"><?php echo JText::_( 'BOM' ); ?></a></li>
                        <li><a id="ecohistory" href="index.php?option=com_apdmpns&task=eco_history&cid[0]=<?php echo $this->row->pns_id;?>"><?php echo JText::_( 'ECO Released History' ); ?></a></li>
			<li><a id="whereused" href="index.php?option=com_apdmpns&task=whereused&id=<?php echo $this->row->pns_id;?>"><?php echo JText::_( 'Where Used' ); ?></a></li>
                        <li><a id="specification" href="index.php?option=com_apdmpns&task=specification&cid[]=<?php echo $this->row->pns_id;?>"><?php echo JText::_( 'Specification' ); ?></a></li>
                        <li><a id="mep" href="index.php?option=com_apdmpns&task=mep&cid[]=<?php echo $this->row->pns_id;?>"><?php echo JText::_( 'MEP' ); ?></a></li>
                        <li><a id="rev" href="index.php?option=com_apdmpns&task=rev&cid[]=<?php echo $this->row->pns_id;?>"><?php echo JText::_( 'REV' ); ?></a></li>
                        <li><a id="dash" class="active"><?php echo JText::_( 'DASH ROLL' ); ?></a></li>
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
<p>&nbsp;</p>
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data" >
	<div class="col width-60">
		<fieldset class="adminform">
			<table class="admintable" cellspacing="1">
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Ascenx Vietnam PN' ); ?>
						</label>
					</td>
					<td><?php 
                                         list($pns_code,$pns_version) = explode("-", $this->row->pns_code);
                                        echo $this->row->ccs_code.'-'.$pns_code.'-';?><a id ="content_version" name ="content_version" href="javascript:void(0);" onclick="get_default_code();"><?php echo $pns_version;?></a><?php if ($this->row->pns_revision) echo '-'.$this->row->pns_revision;?>
						
                                                <input type="hidden" name="ccs_code" id="ccs_code" value="<?php echo $this->row->ccs_code;?>" />
                                                <input type="hidden"  name="pns_code_old" id="pns_code"  size="10" value="<?php echo $this->row->pns_code;?>"/>
                                                <input type="hidden" maxlength="6" onKeyPress="return numbersOnly(this, event);" value="<?php echo $pns_code;?>"  name="pns_code" id="pns_code" class="inputbox" size="20" />
						<input type="hidden" maxlength="2" onKeyPress="return numbersOnly(this, event);" value="<?php echo $pns_version;?>" name="pns_version" id="pns_version" class="inputbox" size="5"  />
						
                                                
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
<input type="hidden" name="RevRoll" value="<?php echo JText::_('Rev Roll')?>"/>
						
					</td>
				</tr>
<!--				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_CHILD' ); ?>
						</label>
					</td>
					<td valign="top">
						<a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmpns&task=get_list_child&tmpl=component&id=<?php echo $this->row->pns_id?>" title="Image">
                                                <input type="button" name="addECO" value="<?php echo JText::_('Addition PNS Child')?>"/>
                                                </a>
                                                <div id='pns_child'>
						</div>
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
					<a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmeco&task=get_eco&tmpl=component" title="Image">
<input type="button" name="addECO" value="<?php echo JText::_('Select ECO')?>"/>                                        
</a>	
					</td>
				</tr>
<!--				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'PNS_TYPE' ); ?>
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
						<textarea name="pns_description" rows="10" cols="60"><?php echo $this->row->pns_description?></textarea>
					</td>
				</tr>
				
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
                                                 $classDisabled = 'disabled = "disabled"';  
                                        if($this->pns_status=='Released'){
                                                $classDisabled = "";
                                        }
                                        ?>                                
			
				
			</table>
		</fieldset>
	</div>

<div style="display:none"><?php
						// parameters : areaname, content, width, height, cols, rows
				//		echo $editor->display( 'text',  $row->text , '10%', '10', '10', '3' ) ;
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
