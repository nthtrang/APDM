<?php
/**
* @version		$Id: index.php 10381 2008-06-01 03:35:53Z pasamio $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
// Set flag that this is a parent file
define( '_JEXEC', 1 );

define('JPATH_BASE', dirname(__FILE__) );

define('DS', DIRECTORY_SEPARATOR);
require_once( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once( JPATH_BASE .DS.'includes'.DS.'framework.php' );
$mainframe =& JFactory::getApplication('administrator');   
$username  = $_REQUEST['u'];
$id = $_REQUEST['id'];
$db             =& JFactory::getDBO();  
$query = 'SELECT * FROM  apdm_eco WHERE eco_id='.$id;
$db->setQuery( $query);
$row = $db->loadObject();        
//get list file
$db->setQuery("SELECT * FROM apdm_eco_files WHERE eco_id=".$id);
$list_file  = $db->loadObjectList();                                                                                   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Export ECO detail</title>
</head>
<body>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td colspan="3" align="center">&nbsp;</td>
		</tr>	
		<tr>
			<td width="33%" align="left" valign="top">ASCENX TECHNOLOGIES</td>
			<td width="33%" align="center">INTERNAL USE ONLY <p><font color="#FF0000">ASCENX TECHNOLOGIES CONFIDENTIAL</font></p></td>
			<td width="33%" align="right" valign="top">Part Number: 600-235690-00 <br /> REV: AA</td>
		</tr>		
		<tr>
			<td colspan="3" align="center"><hr /></td>
		</tr>		
		<tr>
			<th colspan="3" align="center"><h1>ECO Detail</h1></th>
		</tr>		
	</table>
	<table width="100%">
		<tr>
			<td width="50%">Username: <?php echo $username;?></td>
			<td align="right" width="50%">Date Created: <?php echo date('d/m/Y');?></td>
		</tr>
	</table>
	<table width="100%" cellpadding="1">
		<tr>
			<td width="60%" valign="top">
		<fieldset>
		<legend><strong><font color="#0000CC"><?php echo JText::_( 'Information Detail' ); ?></font></strong></legend>
			<table class="admintable" cellspacing="4" cellpadding="2">				
				<tr>
					<td valign="top" width="30%">
						<label for="name">
						<strong>	<?php echo JText::_('ECO number');?></strong>
						</label>
					</td>
					<td width="70%">
					<font color="#666666">	<?php echo $row->eco_name?></font>
					</td>
				</tr>					
				<tr>
					<td valign="top">
						<label for="username">
						<strong>	<?php echo JText::_( 'Description' ); ?></strong>
						</label>
					</td>
					<td>
						<font color="#666666"><?php echo $row->eco_description?></font>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<label for="username">
						<strong>	<?php echo JText::_( 'Project' ); ?></strong>
						</label>
					</td>
					<td>
						<font color="#666666"><?php echo $row->eco_project; ?></font>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<label for="username">
						<strong>	<?php echo JText::_( 'Type' ); ?></strong>
						</label>
					</td>
					<td>
						<font color="#666666"><?php echo $row->eco_type; ?></font>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<label for="username">
						<strong>	<?php echo JText::_( 'Field Impact' ); ?></strong>
						</label>
					</td>
					<td>
						<font color="#666666"><?php echo $row->eco_field_impact; ?></font>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<label for="username">
						<strong>	<?php echo JText::_( 'Reason for Change' ); ?></strong>
						</label>
					</td>
					<td>
						<font color="#666666"><?php echo $row->eco_reason?></font>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<label for="username">
						<strong>	<?php echo JText::_( 'What is Changing' ); ?></strong>
						</label>
					</td>
					<td>
						<font color="#666666"><?php echo $row->eco_what?></font>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<label for="username">
						<strong>	<?php echo JText::_( 'Special Instructions ' ); ?></strong>
						</label>
					</td>
					<td>
					<font color="#666666">	<?php echo $row->eco_special?></font>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<label for="username">
						<strong>	<?php echo JText::_( 'Benifit to Customer' ); ?></strong>
						</label>
					</td>
					<td>
						<font color="#666666"><?php echo $row->eco_benefit?></font>
					</td>
				</tr>
				<tr>
					<td  valign="top">
						<label for="username">
						<strong>	<?php echo JText::_( 'Technical Actions' ); ?></strong>
						</label>
					</td>
					<td>
						<font color="#666666"><?php echo $row->eco_technical?></font>
					</td>
				</tr>
				<tr>
					<td  valign="top">
						<label for="username">
						<strong>	<?php echo JText::_( 'Technical Design Pre-Requisite ECO' ); ?></strong>
						</label>
					</td>
					<td>
						<font color="#666666"><?php echo $row->eco_tech_design; ?></font>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<label for="username">
						<strong>	<?php echo JText::_( 'Estimated One-Time Cost' ); ?></strong>
						</label>
					</td>
					<td>
						<font color="#666666"><?php echo $row->eco_estimated; ?></font>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<label for="username">
						<strong>	<?php echo JText::_( 'Target Serial Numbers' ); ?></strong>
						</label>
					</td>
					<td>
						<font color="#666666"><?php echo $row->eco_estimated_cogs; ?></font>
					</td>
				</tr>
				
				
				<tr>
					<td valign="top">
						<label for="username">
						<strong>	<?php echo JText::_( 'Activate ' ); ?></strong>
						</label>
					</td>
					<td>
						<font color="#666666"><?php echo ($row->eco_status) ? 'Activated' : 'Inactivated';  ?></font>
					</td>
				</tr>	
				<tr>
					<td valign="top">
						<label for="username">
						<strong>	<?php echo JText::_( 'Status' ); ?></strong>
						</label>
					</td>
					<td>
					<font color="#666666">	<?php echo $row->eco_activate; ?></font>
					</td>
				</tr>			
				
			</table>
		</fieldset>
	</td>
			<td width="40%" valign="top">
		<fieldset >
		<legend><strong><font color="#0000CC"><?php echo JText::_( 'Files' ); ?></font></strong></legend>
			<table width="100%" cellspacing="1" cellspacing="1" >
				<?php if (count($list_file) > 0 ) { ?>
					<tr>
						<td colspan="2" width="100%">
						<table width="100%" cellpadding="4" cellspacing="4"  >						
						<thead>
							<th colspan="4" ><?php echo JText::_('List file ')?></th>
						</thead>
						<tr>
							<td width="5%" ><strong><?php echo JText::_('No.')?></strong></td>
							<td width="45%"><strong><?php echo JText::_('Name')?> </strong></td>
							<td width="30%"><strong><?php echo JText::_('Size (KB)')?> </strong></td>							
						</tr>
						<?php $i = 1; 
					foreach ($list_file as $file) { 
						$filesize = ReadfilesizeECO($file->file_name);
					?>
							<tr>
							<td><font color="#666666"><?php echo $i?></font></td>
							<td><font color="#666666"><?php echo $file->file_name;?></font></td>
							<td><font color="#666666"><?php echo number_format($filesize, 0, '.', ' '); ?></font></td>							
						</tr>
						<?php $i++; } ?>
						</table>
						</td>
					</tr>
				<?php  
				} ?>
				
				
			</table>
		</fieldset>
		<fieldset>
		<legend><strong><font color="#0000CC"><?php echo JText::_( 'Parameters' ); ?></font></strong></legend>
			<table width="100%" cellpadding="2" cellspacing="1" >
				<tr>
					<td >
						<label for="ccs_create">
							<strong><?php echo JText::_('Date create')?></strong>
						</label>
					</td>
					<td>
						<font color="#666666"><?php echo JHTML::_('date', $row->eco_create, '%Y-%m-%d %H:%M:%S');?></font>
					</td>
				</tr>
				<tr>
					<td >
						<label for="ccs_create_by">
							<strong><?php echo JText::_('Created by')?></strong>
						</label>
					</td>
					<td>
						<font color="#666666"><?php echo GetValueUser($row->eco_create_by, 'username');?></font>
					</td>
				</tr>
				<tr>
					<td >
						<label for="ccs_create">
							<strong><?php echo JText::_('Date modify')?></strong>
						</label>
					</td>
					<td>
					<font color="#666666">	<?php echo ($row->eco_modified_by) ? JHTML::_('date', $row->eco_modified, '%Y-%m-%d %H:%M:%S') : 'None';?></font>
					</td>
				</tr>
				<tr>
					<td >
						<label for="ccs_create_by">
						<strong>	<?php echo JText::_('Modified by')?></strong>
						</label>
					</td>
					<td>
						<font color="#666666"><?php echo ($row->eco_modified_by) ? GetValueUser($row->eco_modified_by, 'username') : 'None';?></font>
					</td>
				</tr>
				
				
			</table>
		</fieldset>
		
	</div></td>
		</tr>
	</table>
	
</body>
</html>
