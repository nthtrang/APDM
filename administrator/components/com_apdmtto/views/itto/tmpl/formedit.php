<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php JHTML::_('behavior.modal'); ?>
<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

	JToolBarHelper::title( $this->tto_row->tto_code. ': <small><small>[ '. $text .' ]</small></small>' , 'generic.png' );
	if (!intval($edit)) {
	//	JToolBarHelper::save('save', 'Save & Add new');
	}	
	JToolBarHelper::apply('save_edittto', 'Save');
	
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
						<input type="text" readonly="readonly" name="sto_code" id="sto_code"  size="10" value="<?php echo $this->tto_row->tto_code?>"/>
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
                        <input type="text" value="<?php echo $this->tto_row->wo_code?>" name="wo_code" id="wo_code" readonly="readonly" />
                        <input type="hidden" name="tto_wo_id" id="tto_wo_id" value="<?php echo $this->tto_row->tto_wo_id?>" />
                        <?php if($allow_edit){?>
                            <a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmtto&task=get_wo_ajax&tmpl=component" title="Image">
                                <input type="button" name="addSO" value="<?php echo JText::_('Select WO')?>"/>
                            </a>
                        <?php }?>
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
				</tr>              				
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Description' ); ?>
						</label>
					</td>
					<td>						
                                                <textarea onkeydown="upperCaseF(this)" name="tto_description" rows="10" cols="60" maxlength="40"><?php echo strtoupper($this->tto_row->tto_description);?></textarea>
					</td>
				</tr>
			</table>                	
        </fieldset>
        </div>
				<input type="hidden" name="pns_tto_id" value="<?php echo $this->tto_row->pns_tto_id?>" />
	<input type="hidden" name="option" value="com_apdmtto" />
	<input type="hidden" name="return" value="tto"  />
	<input type="hidden" name="task" value="save_edittto" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
