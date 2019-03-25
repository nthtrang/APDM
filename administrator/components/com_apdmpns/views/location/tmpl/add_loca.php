<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php	
//poup add rev roll
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	
?>
<script language="javascript" type="text/javascript">
function UpdateLocationWindow(){
        //window.parent.document.getElementById('sbox-window').close();
     // window.parent.document.location.reload(true);
     window.parent.location.reload();
        window.parent.document.location.href = "index.php?option=com_apdmpns&task=locatecodetemp&time=<?php echo time();?>";
     //   setTimeout("window.parent.document.getElementById('sbox-window').close();",1000);
       //setTimeout( "window.document.getElementById('sbox-window').close();window.parent.document.location.reload();", 2000 );
}
function upperCaseF(a){
    setTimeout(function(){
        a.value = a.value.toUpperCase();
    }, 1);
}
</script>

<form action="index.php?option=com_apdmpns&task=save_location&time=<?php echo time();?>" method="post" name="adminFormPnsrev" enctype="multipart/form-data" >
         <table  width="100%">
		<tr>
			<td></td>
			<td align="right"><input type="submit" name="btinsersave" value="Save"  onclick="UpdateLocationWindow();"/>
                        
                        </td>	
		</tr>	
</table>
			<table class="admintable" cellspacing="1">
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Location Code' ); ?>
						</label>
					</td>
					<td>
						<input type="text"  name="location_code" id="location_code"  size="10" value="<?php echo $this->location_row->location_code;?>"/>						
					</td>
				</tr>
                                 
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Description' ); ?>
						</label>
					</td>
					<td>						
						<textarea  onkeydown="upperCaseF(this)" name="location_description" rows="10" cols="60"><?php echo $this->location_row->location_description?></textarea>
					</td>
				</tr>         <!--
                               <tr>
					<td class="key">
						<label for="name">
							<?php /*echo JText::_( 'Status' ); */?>
						</label>
					</td><td>
                               <?php
                               
                            /*   $status_arr = array();
                                                        $status_arr[] = JHTML::_('select.option', '1', JText::_('Yes'), 'value', 'text');
                                                        $status_arr[] = JHTML::_('select.option', '0', JText::_('No'), 'value', 'text');                                                        
                                 echo JHTML::_('select.genericlist', $status_arr, 'location_status', 'class="inputbox" size="1" ', 'value', 'text',$this->location_row->location_status );*/
                                ?>
                               </td>
                                </tr>  		-->
			</table>
	


	<input type="hidden" name="pns_id" value="<?php echo  $cid[0];?>" />	
	<input type="hidden" name="option" value="com_apdmpns" />
    <input type="hidden" name="task" value="save_location" />
	<input type="hidden" name="return" value="save_location"  />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
