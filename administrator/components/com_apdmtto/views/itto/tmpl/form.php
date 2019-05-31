<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.tooltip'); ?>
<?php JHTML::_('behavior.modal'); ?>
<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

	JToolBarHelper::title( JText::_( 'TTO' ) . ': <small><small>[ '. $text .' ]</small></small>' , 'generic.png' );
	if (!intval($edit)) {
	//	JToolBarHelper::save('save', 'Save & Add new');
	}	
	JToolBarHelper::apply('save_tto', 'Save');
	
	if ( $edit ) {
		// for existing items the button is renamed `close`
		JToolBarHelper::cancel( 'cancel', 'Close' );
	} else {
		JToolBarHelper::cancel();
	}
	
	$cparams = JComponentHelper::getParams ('com_media');
?>
<?php	
//poup add rev roll
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	
?>
<script language="javascript" type="text/javascript">
function get_default_tto_prefix(){		
		var url = 'index.php?option=com_apdmtto&task=get_tto_code_default&tto_type=1';				
		var MyAjax = new Ajax(url, {
			method:'get',
			onComplete:function(result){				
				$('tto_code').value = result.trim();
			}
		}).request();
	}
        get_default_tto_prefix();
		
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
 function upperCaseF(a){
    setTimeout(function(){
        a.value = a.value.toUpperCase();
    }, 1);
}
function submitbutton(pressbutton) {
        var form = document.adminForm;
        if (pressbutton == 'cancel') {
                submitform( pressbutton );
                return;
        }  
        if (form.tto_due_date.value==0){
                alert("Please select Due date");
                form.tto_due_date.focus();
                return false;
        }  
                
        var date = new Date();
        current_month = date.getMonth()+1;
        var current_date = date.getFullYear()+"-"+current_month+"-"+ (date.getDate() < 10 ? "0"+date.getDate() : date.getDate());                
        var current_date = new Date(current_date);
        var due_date = new Date(form.tto_due_date.value);
        if (due_date < current_date ) 
        {
            alert("Invalid Date Range!\nDue Date cannot be before Today!")
            return false;
        }

       submitform( pressbutton );
}

function autoAddWoTto(wo_code)
{
        var url = 'index.php?option=com_apdmtto&task=ajax_scanwo_toitto&wo_code='+wo_code;
        var MyAjax = new Ajax(url, {
                method:'get',
                onComplete:function(result){
                    var eco_result = result;
                    eco = eco_result.split('^');
                    window.document.getElementById('tto_wo_id').value = eco[4];
                    window.document.getElementById('wo_code').value = eco[5];
                    if(eco[5]!= "NA" && eco[5] != "EXIT") {
                        window.document.getElementById('notice').innerHTML = "Have add WO " + wo_code + " successfull.";
                        window.document.getElementById('notice_fail').innerHTML = "";
                        window.document.getElementById('wo_code').value =eco[5];
                    }
                    else
                    {
                            if(eco[5]== "EXIT"){
                                window.document.getElementById('notice').innerHTML = "";
                                window.document.getElementById('notice_fail').innerHTML = "WO " + wo_code+" exist in another TTO" ;
                                window.document.getElementById('wo_code').value = "";
                            }
                            else
                            {
                                window.document.getElementById('notice').innerHTML = "";
                                window.document.getElementById('notice_fail').innerHTML = "Not found WO " + wo_code ;
                            }
                        
                    }
                    window.document.getElementById('scan_wo_code').value ="";
                    window.document.getElementById('scan_wo_code').focus();
                }
        }).request();        
}

function checkforscanwotto(isitchecked)
{
        if (isitchecked == true){
                document.getElementById("wo_code").focus();
                document.getElementById('wo_code').setAttribute("onkeyup", "autoAddWoTto(this.value)");

            document.getElementById('wo_code').removeAttribute("readonly");
          
        }
        else {
                document.getElementById('wo_code').setAttribute("onkeyup", "return false;");
            document.getElementById('wo_code').setAttribute("readonly", "readonly");
            
        }
}


</script>
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">
	<div class="col width-60">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Tool Detail' ); ?></legend>
		
			<table class="admintable" cellspacing="1">
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'TTO Number' ); ?>
						</label>
					</td>
					<td>
						<input type="text" readonly="readonly" name="tto_code" id="tto_code"  size="10" value=""/>                                               
					</td>
				</tr>
                                <tr>
                    <td class="key">
                        <label for="name">
                            <?php echo JText::_( 'WO' ); ?>
                        </label>
                    </td>
                    <td>
                        <?php //echo $this->lists['wolist'];?>
                        <input type="text" value="" name="wo_code" id="wo_code" readonly="readonly" />
                        <input type="hidden" name="tto_wo_id" id="tto_wo_id" value="" />                        
                        <a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmtto&task=get_wo_ajax&tmpl=component" title="Image">
                            <input type="button" name="addSO" value="<?php echo JText::_('Select WO')?>"/>
                        </a><br>Scan Barcode <input type="checkbox" name="check_scan_barcode" value="1" onclick="checkforscanwotto(this.checked)" />
<!--                        Scan Barcode <input onchange="autoAddWoTto(this.value)" onkeyup="autoAddWoTto(this.value)" type="text"  name="scan_wo_code" id="scan_wo_code" value="" >-->
                         <div name="notice_fail" style="color:#D30000" id ="notice_fail"></div>
                        <div name="notice" style="color:#0B55C4" id ="notice"></div>
                    </td>
                </tr>
                 <tr>
                 <td class="key">
                                        <label for="name">
                                                <?php echo JText::_( 'Due Date' ); ?>
                                        </label>
                                </td>
                                <td>                                                 
                                       <?php echo JHTML::_('calendar',$this->tto_row->tto_due_date, 'tto_due_date', 'tto_due_date', '%m/%d/%Y', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	
                                </td>
				</tr> 
				 
                               
				<tr>
					<td class="key" valign="top">
						<label for="stocker">
							<?php echo JText::_( 'Confirm' ); ?>
						</label>
					</td>
					<td>
                            <input type="checkbox" id ="stocker_confirm" name="stocker_confirm" checked="checked" value="1" /> 
					</td>
				</tr>              				
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Description' ); ?>
						</label>
					</td>
					<td>						
						<textarea  onkeydown="upperCaseF(this)" name="tto_description" rows="10" cols="60" maxlength="40"><?php echo $this->tto_row->tto_code?></textarea>
					</td>
				</tr>  
			</table>                	
        </fieldset>
        </div>
        <input type="hidden" name="pns_id" value="<?php echo  $cid[0];?>" />	
	<input type="hidden" name="option" value="com_apdmtto" />
	<input type="hidden" name="return" value="tto"  />
	<input type="hidden" name="task" value="save_tto" />     
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
