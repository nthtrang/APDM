<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$role = JAdministrator::RoleOnComponent(5);	
	//$tabfiles = '<button onclick="javascript:hideMainMenu(); submitbutton(\'files\')" class="buttonfiles" style="vertical-align:middle"><span>Files </span></button>';
        $tabSummary = '<button onclick="javascript:hideMainMenu(); submitbutton(\'summary\')" class="buttonfiles" style="vertical-align:middle"><span>Summary </span></button>';
        $tabAffected  = '<button onclick="javascript:hideMainMenu(); submitbutton(\'affected\')" class="buttonaffected" style="vertical-align:middle"><span>Affected Parts </span></button>';
        $demote = $promote = "";
        $me = & JFactory::getUser();
        
        if ($this->row->eco_create_by == $me->get('id') && $this->row->eco_status !="Released") {
                $demote = '<button onclick="javascript:hideMainMenu(); submitbutton(\'demote\')" class="button_demote" style="vertical-align:middle"><span>Demote </span></button>';
                $promote = '<button onclick="javascript:hideMainMenu(); submitbutton(\'promote\')" class="button_promote" style="vertical-align:middle"><span>Promote</span></button>';
        }
        
        JToolBarHelper::title( JText::_( 'ECO_MANAGEMET' ) . ': <small><small>[ '. JText::_( 'Approvers' ).' ]</small></small>'.$tabSummary.$tabAffected . $demote . $promote , 'generic.png' );	
        JToolBarHelper::customX("approvers", 'apply', '', 'Save', true);
//JToolBarHelper::customX('export_detail', 'excel', '', 'Export', false);

     //   JToolBarHelper::customX("summary", 'summary', '', 'Summary', false);
    //    JToolBarHelper::customX("files", 'files', '', 'Files', false);
	$cparams = JComponentHelper::getParams ('com_media');
?>

<?php
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	
?>
<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'summary') {
				 window.location.assign("index.php?option=com_apdmeco&task=detail&cid[]=<?php echo $this->row->eco_id?>")
				return;
			}
//		if (pressbutton == 'files') {
//			  window.location.assign("index.php?option=com_apdmeco&task=files&cid[]=<?php echo $this->row->eco_id?>");
//			return;
//		}   
                if (pressbutton == 'demote') {
			  window.location.assign("index.php?option=com_apdmeco&task=demote&cid[]=<?php echo $this->row->eco_id?>&time=<?php echo time();?>");
			return;
		}  
		if (pressbutton == 'promote') {
			  window.location.assign("index.php?option=com_apdmeco&task=promote&cid[]=<?php echo $this->row->eco_id?>&time=<?php echo time();?>");
			return;
		}   
		if (pressbutton == 'affected') {
			  window.location.assign("index.php?option=com_apdmeco&task=affected&cid[]=<?php echo $this->row->eco_id?>");
			return;
		}       
		if (pressbutton == 'approvers') {
                        document.adminForm.submit();
			//submitform( pressbutton );
			//return;
		}
		var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&]", "i");	
	}
</script>
<style>
        .buttonfiles {
  display: inline-block;
  border-radius: 4px;
  background-color: #f49542;
  border: none;
  color: white;
  text-align: center;
  font-size: 16px;
  padding: 10px 32px;
  width: 120px;
  transition: all 0.5s;
  cursor: pointer;
  margin-left: 30px;
}

.buttonaffected {
  display: inline-block;
  border-radius: 4px;
  background-color: #f49542;
  border: none;
  color: white;
  text-align: center;
  font-size: 16px;
  padding: 10px 32px;
  width: 180px;
  transition: all 0.5s;
  cursor: pointer;
  margin-left: 30px;
}

        .button_demote {
  display: inline-block;
  border-radius: 4px;
  background-color: #4CAF50;
  border: none;
  color: white;
  text-align: center;
  font-size: 16px;
  padding: 10px 32px;
  width: 120px;
  transition: all 0.5s;
  cursor: pointer;
  margin-left: 30px;
}

.button_promote {
  display: inline-block;
  border-radius: 4px;
  background-color: #4CAF50;
  border: none;
  color: white;
  text-align: center;
  font-size: 16px;
  padding: 10px 32px;
  width: 180px;
  transition: all 0.5s;
  cursor: pointer;
  margin-left: 30px;
}
</style>
<form action="index.php?option=com_apdmeco&amp;task=saveapprove&amp;cid[]=18&amp;time=<?php echo time();?>" method="post" name="adminForm" >
	<div class="col">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Approvers' ); ?></legend>
                
                			<table class="admintable" width="100%"  >
				<?php if (count($this->arr_status) > 0 ) { ?>
					<tr>
						<td colspan="2">
						<table width="100%"  class="adminlist" cellpadding="1">						
						<thead>
							<th colspan="3"><?php echo JText::_('List Approvers ')?></th>
						</thead>
						<tr>
							<td width="5%"><strong><?php echo JText::_('No.')?></strong></td>
							<td width="15%"><strong><?php echo JText::_('Email')?> </strong></td>
							<td width="80%"><strong><?php echo JText::_('Approve Status')?> </strong></td>							
						</tr>
						<?php $i = 1; 
                                                $me = & JFactory::getUser();
                                                $me->get('email');
                                                foreach ($this->arr_status as $status) { 
                                                if($me->get('email')==$status->email)
                                                {
						?>
							<tr>
							<td><?php echo $i?></td>
							<td><?php echo $status->email;?></td>
							
                                                        <td width="60%"><?php  
                                                        if($status->eco_status != 'Released'){                                                          
                                                       ?>
                                                                <a href='index.php?option=com_apdmeco&task=approve&cid[]=<?php echo $this->row->eco_id;?>&time=<?php echo time();?>'></a>
                                                               <input type="radio" name="approve_status" id="approve_status1" value="Released"  class="inputbox" size="1"/>
                                                                <label for="approve_status1">Approve</label>
                                                                <input type="radio" name="approve_status" id="approve_status0" value="Inreview" checked="checked" class="inputbox" size="1"/>
                                                                <label for="approve_status0">Reject</label>	
                                                                <textarea cols="70" rows="6" id ="approve_note" name ='approve_note'><?php echo $status->note;?></textarea>
                                                        <?php                                                         
                                                        }
                                                        elseif($status->eco_status == 'Released'){
                                                                echo "Approved";
                                                        }
                                                       ?>
                                                        </td>
						</tr>
						<?php $i++; 
                                                }
                                                else
                                                {
                                                        ?>
							<tr>
							<td><?php echo $i?></td>
							<td><?php echo $status->email;?></td>
							
                                                        <td width="60%"><?php  
                                                        if($status->eco_status != 'Released'){                                                          
                                                       ?>
                                                                Status: <?php echo $status->eco_status?></br>
                                                                <textarea disabled="disabled" cols="70" rows="6" id ="approve_note" name ='approve_note'><?php echo $status->note;?></textarea>
                                                        <?php                                                         
                                                        }
                                                        else{
                                                                echo "Approved";
                                                                echo "</br>";
                                                                echo $status->note;
                                                        }
                                                       ?>
                                                        </td>
						</tr>
                                                <?php
                                                    $i++;           
                                                }
                                                } ?>
						</table>
						</td>
					</tr>
				<?php  
				} ?>
			</table>
		</fieldset>

	</div>
	
	<div class="clr"></div>

	<input type="hidden" name="eco_id" value="<?php echo $this->row->eco_id?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->row->eco_id?>" />
	<input type="hidden" name="option" value="com_apdmeco" />
	<input type="hidden" name="task" value="saveapprove" />
	<input type="hidden" name="boxchecked" value="1" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
