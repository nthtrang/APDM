<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php
	$role = JAdministrator::RoleOnComponent(6);
	JToolBarHelper::title( JText::_( 'Import Bom' ) , 'cpanel.png' );
	if (in_array("E", $role)) {
		JToolBarHelper::apply('importBom', 'Save');
	}  

	//JToolBarHelper::cancel();
        JToolBarHelper::cancel( 'cancel', 'Close' );
	$cparams = JComponentHelper::getParams ('com_media');
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );
?>
<script language="javascript">
function submitbutton(pressbutton) {
        var form = document.adminForm;
        if (pressbutton == 'cancel') {
                submitform( pressbutton );
                return;
        }  
        if (form.bom_file.value==0){
                alert("Please select an excel file first.");
                form.tto_due_date.focus();
                return false;
        }  
                
     submitform( pressbutton );
}


</script>
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">
<fieldset class="adminform">
            <legend><?php echo JText::_( 'Import BOM(.xls)' ); ?> <font color="#FF0000"><em><?php echo JText::_('(Please upload file less than 20Mb)')?></em></font></legend>
            <table class="adminlist">
                <tr>
                    <td>
                            <input type="file" id="bom_file" name="bom_file" />		
                    </td>                    
                </tr>
                <tr>
                        <td>
                                 <a href="index.php?option=com_apdmpns&task=downloadBomTemplate">Download</a> file import template.
                        </td>
                </tr>
                
                
            </table>
        </fieldset>

	<div class="clr"></div>	
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="task" value="importBom" />     
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
