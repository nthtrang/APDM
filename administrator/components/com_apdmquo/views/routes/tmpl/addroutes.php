<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php	
//poup add routes
$me = & JFactory::getUser();
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
        $row = $this->rows;
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	//ToolBarHelper::apply('apply', 'Save');  
?>
<script language="javascript" type="text/javascript">
function get_default_routequo_name(){		
		var url = 'index.php?option=com_apdmquo&task=get_routename_quo_default&quo_id=<?php echo $cid[0];?>';				
		var MyAjax = new Ajax(url, {
			method:'get',
			onComplete:function(result){				
				$('name').value = result.trim();
			}
		}).request();
	}
        get_default_routequo_name();        
function UpdateRoutesWindow(){
    if (document.adminFormSaveRoutes.name.value==""){
        alert("Please input name");
        return false;
    }
    if (document.adminFormSaveRoutes.due_date.value=="0000-00-00 00:00:00" || document.adminFormSaveRoutes.due_date.value==""){
        alert("Please select Due date");
        return false;
    }

    var date = new Date();
    current_month = date.getMonth()+1;
    var current_date = date.getFullYear()+"-"+current_month+"-"+ (date.getDate() < 10 ? "0"+date.getDate() : date.getDate());
    var current_date = new Date(current_date);
    var due_date = new Date(document.adminFormSaveRoutes.due_date.value);
    if (due_date < current_date )
    {
        alert("Invalid Date Range!\nDue Date cannot be before Today!")
        return false;
    }
    //submitform();
    /*var url = 'index.php?option=com_apdmeco&task=save_routes&eco[]=php //echo $cid[0]?>;
    var MyAjax = new Ajax(url, {
        method:'post',
        data:  $('adminFormSaveRoutes').toQueryString(),
        onComplete:function(result){
            //	window.parent.document.getElementById('pns_child').innerHTML = result;
            window.parent.document.getElementById('sbox-window').close();
            window.parent.location.reload();


        }
    }).request();*/

        window.parent.document.getElementById('sbox-window').close();
        //window.top.location.
        //window.parent.location.reload(1);
        window.parent.location.href = "index.php?option=com_apdmquo&task=routestmp&quo_id=<?php echo $cid[0]?>&time=<?php echo time();?>";
}

</script>
<?php 
$exist_route_promoted = QUOController::check_routequo_promote($cid[0]);
if($exist_route_promoted)
{
?>
<div name="notice" style="color:#D30000" id ="notice"><strong>Please demote route before create new route</strong></div>
<?php 
}else{
?>dd
<form action="index.php?option=com_apdmquo&task=save_routes_quo&cid[]=<?php echo $cid[0]?>" method="post" name="adminFormSaveRoutes" enctype="multipart/form-data" >
         <table  width="100%">
		<tr>
			<td></td>
			<tr align="right">
			<td align="right">
                                <input type="submit" name="btinsersave" value="Save Route"  onclick="return UpdateRoutesWindow();"/>
                        </td>	
		</tr>
		</tr>			
</table>
			<table class="admintable" cellspacing="1">
                                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Name' ); ?>
						</label>
					</td>
					<td>
						<input type="text"  name="name" id="name"  size="10" value="<?php echo $row[0]->name;?>"/>						
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Description' ); ?>
						</label>
					</td>
					<td>
                                               <textarea name="description" rows="5" cols="30"><?php echo $row[0]->description?></textarea>
						
					</td>
				</tr>
				
				
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'Due date' ); ?>
						</label>
					</td>
					<td>
                                        <?php //echo JHTML::_('calendar', $this->lists['pns_datein'], 'pns_datein', 'pns_datein', '%m-%d-%Y %H:%M:%S', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	
					<?php echo JHTML::_('calendar', $row[0]->due_date, 'due_date', 'due_date', '%Y-%m-%d %H:%M:%S', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>	
					</td>
				</tr>
			</table>
	


	<input type="hidden" name="quo_id" value="<?php echo $cid[0];?>" />
	<input type="hidden" name="option" value="com_apdmquo" />
	<input type="hidden" name="return" value="routes_quo"  />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
<?php }?>