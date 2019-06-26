<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php
	$role = JAdministrator::RoleOnComponent(8);
        
        $sto_id = JRequest::getVar('id');
	JToolBarHelper::title( JText::_( 'Import Part for ' ).SToController::getStoCodefromId($sto_id), 'cpanel.png' );
	if (in_array("E", $role)) {
		JToolBarHelper::apply('uploadimportPart', 'Save');
	}  

	//JToolBarHelper::cancel();
        //JToolBarHelper::cancel( 'cancel', 'Close' );
    JToolBarHelper::customX("eto_detail",'cancel',"Back","Back",false);
	$cparams = JComponentHelper::getParams ('com_media');
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );
?>
<script language="javascript">
function submitbutton(pressbutton) {
        var form = document.adminForm;
        if (pressbutton == 'cancel') {
               window.location = "index.php?option=com_apdmsto&task=eto_detail&id="+form.sto_id.value;           
                return;
        }
    if (pressbutton == 'eto_detail') {
        window.location = "index.php?option=com_apdmsto&task=eto_detail&id="+form.sto_id.value;
        return;
    }
    if (form.bom_file.value==0){
                alert("Please select an excel file first.");
                return false;
        }


     submitform( pressbutton );
}


</script>
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">
        <?php 
         $importresult = JRequest::getVar('importresult'); 
         if($importresult)
         {
                 $path_pns = JPATH_SITE . DS . 'uploads'. DS;
                $dFile = new DownloadFile($path_pns, $importresult);
                 ?>
<!--                  <a href="index.php?option=com_apdmpns&task=downloadBomImportResult&importresult=<?php echo $importresult?>">Click here to download</a> file import result.-->
                 <?php 
         }
        ?>
<fieldset class="adminform">
            <legend><?php echo JText::_( 'Import Part(.xls)' ); ?> <font color="#FF0000"><em><?php echo JText::_('(Please upload file less than 20Mb)')?></em></font></legend>            
            <table class="adminlist">
                <tr>
                    <td>
                            <input type="file" id="bom_file" name="bom_file" />		
                    </td>                    
                </tr>
                <tr>
                        <td>
                                 <a href="index.php?option=com_apdmsto&task=downloadImportPartTemplate">Download</a> file import template.
                        </td>
                </tr>
                
                
            </table>
        </fieldset>

	<div class="clr"></div>	
	<input type="hidden" name="option" value="com_apdmsto" />
	<input type="hidden" name="task" value="uploadimportPart" />     
        <input type="hidden" name="sto_id" value="<?php echo $sto_id;?>" />     
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
