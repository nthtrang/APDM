<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$role = JAdministrator::RoleOnComponent(5);	
	
        JToolBarHelper::title( JText::_($this->row->eco_name));
      //  JToolBarHelper::title( JText::_( $this->row->eco_name));
	JToolBarHelper::customX('export_detail', 'excel', '', 'Export', false);
	if (in_array("E", $role) && $this->row->eco_status !="Released" && $this->row->eco_status !="Inreview") {
		JToolBarHelper::editListX();
	}
	if (in_array("W", $role)) {
	//	JToolBarHelper::addNewX();
	}
	JToolBarHelper::cancel( 'cancel', 'Close' );
	$cparams = JComponentHelper::getParams ('com_media');
?>

<?php
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	
?>
<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'edit') {
				submitform( pressbutton );
				return;
			}
		if (pressbutton == 'add') {
				submitform( pressbutton );
				return;
			}
		if (pressbutton == 'export_detail') {
				submitform( pressbutton );
				return;
			}
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
//		if (pressbutton == 'files') {
//			  window.location.assign("index.php?option=com_apdmeco&task=files&cid[]=<?php echo $this->row->eco_id?>");
//			return;
//		}  
		if (pressbutton == 'approvers') {
			  window.location.assign("index.php?option=com_apdmeco&task=approvers&cid[]=<?php echo $this->row->eco_id?>");
			return;
		}  
		if (pressbutton == 'affected') {
			  window.location.assign("index.php?option=com_apdmeco&task=affected&cid[]=<?php echo $this->row->eco_id?>");
			return;
		}                  
		var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&]", "i");	
	}
</script>
<?php 
$me = & JFactory::getUser();
$me->get('email');
$owner = $this->row->eco_create_by;
$link ="index.php?option=com_apdmeco&amp;task=add_approvers&amp;cid[]=".$this->row->eco_id."&amp;routes=".$this->row->eco_routes_id."&amp;time=".time();
if($owner == $me->get('id'))
{        
        $link ="index.php?option=com_apdmeco&amp;task=routes&amp;cid[]=".$this->row->eco_id."&amp;time=".time();
}
?>
<div class="submenu-box">
	<div class="t">
                <div class="t">
                        <div class="t"></div>
                </div>
        </div>
        <div class="m">
		<ul id="submenu" class="configuration">
			<li><a id="detail" class="active"><?php echo JText::_( 'Detail' ); ?></a></li>
			<li><a id="affected" href="index.php?option=com_apdmeco&task=affected&cid[]=<?php echo $this->row->eco_id;?>"><?php echo JText::_( 'Affected Parts' ); ?></a></li>
			<li><a id="initial" href="index.php?option=com_apdmeco&task=initial&cid[]=<?php echo $this->row->eco_id;?>"><?php echo JText::_( 'Initial Data' ); ?></a></li>
                        <li><a id="supporting" href="index.php?option=com_apdmeco&task=files&cid[]=<?php echo $this->row->eco_id;?>"><?php echo JText::_( 'Supporting Document' ); ?></a></li>
                        <li><a id="routes" href="<?php echo $link;?>"><?php echo JText::_( 'Routes' ); ?></a></li>                     
		</ul>
		<div class="clr"></div>
        </div>
        <div class="b">
                <div class="b">
                        <div class="b"></div>
                </div>
        </div>
</div>
<div class="clr"></div>
<p>&nbsp;</p>
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data" >
	<div class="col width-100">
		<fieldset class="adminform">
			<table class="admintable" cellspacing="1">				
				<tr>
					<td class="key" valign="top">
						<label for="name">
							<?php echo JText::_('ECO_NAME');?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_name?>
					</td>
				</tr>
				<!--<tr>
					<td class="key" valign="top">
						<label for="name">
							<?php //echo JText::_('ECO_PDF');?>
						</label>
					</td>
					<td>
						<input type="file" name="file_pdf" />&nbsp;&nbsp;<?php //if($this->row->eco_id && ($this->row->eco_pdf !="")) { ?> 
						File PDF: <a href="index.php?option=com_apdmeco&task=download&id=<?php //echo $this->row->eco_id?>" title="Click to download file pdf"><?php //echo $this->row->eco_pdf;?></a>
						<?php //} ?>
						<input type="hidden" name="file_pdf_exist" value="<?php //echo $this->row->eco_pdf;?>" />
					</td>
				</tr>		-->		
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'DESCRIPTION' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_description?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_PROJECT' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_project; ?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_TYPE' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_type; ?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_FIELD_IMPACT' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_field_impact; ?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_REASON' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_reason?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_WHAT_IS_CHANGE' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_what?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_SPECIAL' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_special?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_BENEFIT' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_benefit?>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_TECHNICAL_ACTIONS' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_technical?>
					</td>
				</tr>
<!--				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_TECHNICAL_DESIGN' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_tech_design; ?>
					</td>
				</tr>
-->
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_ESTIMATED' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_estimated; ?>
					</td>
				</tr>
<!--				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ECO_TARGET' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_estimated_cogs; ?>
					</td>
				</tr>
	-->			
			
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'ACTIVE' ); ?>
						</label>
					</td>
					<td>
						<?php echo ($this->row->eco_activate) ? 'Activated' : 'Inactivated';  ?>
					</td>
				</tr>	
				<tr>
					<td class="key" valign="top">
						<label for="username">
							<?php echo JText::_( 'State' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_status; ?>
					</td>
				</tr>	
				<tr>
					<td class="key" valign="top">
						<label for="eco_record_number">
							<?php echo JText::_( 'Record Number' ); ?>
						</label>
					</td>
					<td>
						<?php echo $this->row->eco_record_number; ?>
					</td>
				</tr>	                                
				<tr>
					<td class="key">
						<label for="ccs_create">
							<?php echo JText::_('INFO_CREATE')?>
						</label>
					</td>
					<td>
						<?php echo ($this->row->eco_id) ? JHTML::_('date', $this->row->eco_create, '%Y-%m-%d %H:%M:%S') :'New document';?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="ccs_create_by">
							<?php echo JText::_('INFO_CREATE_BY')?>
						</label>
					</td>
					<td>
						<?php echo ($this->row->eco_id) ? GetValueUser($this->row->eco_create_by, 'name') : 'New Document';?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="ccs_create">
							<?php echo JText::_('INFO_MODIFIED')?>
						</label>
					</td>
					<td>
						<?php echo ($this->row->eco_modified_by) ? JHTML::_('date', $this->row->eco_modified, '%Y-%m-%d %H:%M:%S') : 'None';?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="ccs_create_by">
							<?php echo JText::_('INFO_MODIFIED_BY')?>
						</label>
					</td>
					<td>
						<?php echo ($this->row->eco_modified_by) ? GetValueUser($this->row->eco_modified_by, 'name') : 'None';?>
					</td>
				</tr>
			</table>
		</fieldset>
	</div>
		<!--<fieldset class="adminform">
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
							<td width="45%"><strong><?php echo JText::_('Email')?> </strong></td>
							<td width="30%"><strong><?php echo JText::_('Status')?> </strong></td>							
						</tr>
						<?php $i = 1; 
					foreach ($this->arr_status as $status) { 
						?>
							<tr>
							<td><?php echo $i?></td>
							<td><?php echo $status->email;?></td>
							<td><?php echo $status->eco_status;?></td>
						</tr>
						<?php $i++; } ?>
						</table>
						</td>
					</tr>
				<?php  
				} ?>
			</table>
                
                </fieldset>
	</div>
	-->
	<div class="clr"></div>

	<input type="hidden" name="eco_id" value="<?php echo $this->row->eco_id?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->row->eco_id?>" />
	<input type="hidden" name="option" value="com_apdmeco" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="1" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
