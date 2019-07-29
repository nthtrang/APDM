<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.tooltip'); ?>
<?php JHTML::_('behavior.modal'); 
JHTML::_('behavior.calendar');
?>
<?php	
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
        
        JToolBarHelper::title( JText::_( 'QUOTATION FORM TEMPLATE' ) . ' <small><small></small></small>' , 'cpanel.png' );
        JToolBarHelper::apply('save_quo_template', 'Save');

	JToolBarHelper::cancel( 'cancel', 'Close' );
	
        // clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );
	$editor = &JFactory::getEditor();
?>

<script language="javascript" type="text/javascript">
        
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
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
	 else if ((("0123456789$").indexOf(keychar) > -1))
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
		<legend><?php echo JText::_( 'Form Template' ); ?></legend>    
<table class="admintable" cellspacing="1" width="100%">
                        <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Ascenx Information' ); ?>
						</label>
					</td><td>
<?php 
                                                $editor =& JFactory::getEditor();                                                
                                                     echo $editor->display('ascenx_info', $this->template_row->ascenx_info, '5%', '2', '5', '1',false);
                                        ?>
    </td>
   
  </tr>
  <tr>
					
  <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Content' ); ?>
						</label>
					</td><td><?php             
                                                $editor =& JFactory::getEditor();                                                
                                                     echo $editor->display('content', $this->template_row->content, '5%', '2', '5', '1',false);
                                        ?></td>
  </tr>
 <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Term and Conditions of Sale' ); ?>
						</label>
					</td><td><?php 
   
                                                $editor =& JFactory::getEditor();                                                
                                                     echo $editor->display('term_conditions', $this->template_row->term_conditions, '5%', '2', '5', '1',false);
                                        ?></td>
  </tr>
 <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Question' ); ?>
						</label>
					</td><td><?php 

                                                $editor =& JFactory::getEditor();                                                
                                                     echo $editor->display('question', $this->template_row->question, '5%', '2', '5', '1',false);
                                        ?></td>
  </tr>
  
</table>
                </fieldset>
         </div>
                
	<input type="hidden" name="pns_id" value="<?php echo  $cid[0];?>" />	
	<input type="hidden" name="option" value="com_apdmquo" />
	<input type="hidden" name="return" value="quo"  />
	<input type="hidden" name="task" value="save_quo_template" />        
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
