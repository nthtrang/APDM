<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php	
//poup add rev roll
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
        $rev = $this->pos;
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	
?>
<script language="javascript" type="text/javascript">
function UpdatePnsRevWindow(){        				
        window.parent.document.getElementById('sbox-window').close();	       
     // window.parent.document.location.reload(true);
        window.parent.document.location.href = "index.php?option=com_apdmpns&task=po&cid[]=<?php echo $cid[0]?>&time=<?php echo time();?>";
     //   setTimeout("window.parent.document.getElementById('sbox-window').close();",1000);
       //setTimeout( "window.document.getElementById('sbox-window').close();window.parent.document.location.reload();", 2000 );
}

</script>

<form action="index.php?option=com_apdmpns&task=save_pns_po&cid[]=<?php echo $cid[0]?>&time=<?php echo time();?>" method="post" name="adminFormPnsrev" enctype="multipart/form-data" >
         <table  width="100%">
		<tr>
			<td></td>
			<td align="right"><?php
                       // if($this->pns_status!='Release')
                      //  {
                                ?><input type="submit" name="btinsersave" value="Save"  onclick="UpdatePnsRevWindow();"/>
                        <?php
                      //  }
                        ?>
                        </td>	
		</tr>	
</table>
			<table class="admintable" cellspacing="1">
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'P.O Number' ); ?>
						</label>
					</td>
					<td>
						<input type="text"  name="po_code" id="po_code"  size="10" value="<?php echo $rev[0]->po_code;?>"/>						
					</td>
				</tr>
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Description' ); ?>
						</label>
					</td>
					<td>						
						<textarea name="po_description" rows="10" cols="60"><?php echo $rev[0]->po_description;?></textarea>
					</td>
				</tr>             
                               
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Attached' ); ?>
						</label>                                                
					</td>
					<td>						
						 <input type="file" name="po_file" /><br/>
                                                 <font color="#FF0000"><em><?php echo JText::_('(Please upload file less than 20Mb)')?></em></font>
					</td>
				</tr>				
			</table>
	


	<input type="hidden" name="pns_id" value="<?php echo  $cid[0];?>" />	
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="return" value="po"  />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
