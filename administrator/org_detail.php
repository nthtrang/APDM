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
$query = 'SELECT * FROM  apdm_supplier_info WHERE info_id ='.$id;
$db->setQuery( $query);
$row = $db->loadObject();        

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Export Organization detail</title>
</head>
<body>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td colspan="3" align="center">&nbsp;</td>
		</tr>	
		<tr>
			<td width="33%" align="left" valign="top">ASCENX TECHNOLOGIES</td>
			<td width="33%" align="center">INTERNAL USE ONLY <p><font color="#FF0000" >ASCENX TECHNOLOGIES CONFIDENTIAL</font></p></td>
			<td width="33%" align="right" valign="top">Part Number: 600-134668-00 <br /> REV: AA</td>
		</tr>		
		<tr>
			<td colspan="3" align="center"><hr /></td>
		</tr>		
		<tr>
			<th colspan="3" align="center"><h1>Organization Detail</h1></th>
		</tr>		
	</table>
	<table width="100%">
		<tr>
			<td width="50%">Username: <?php echo $username;?></td>
			<td align="right" width="50%">Date Created: <?php echo date('d/m/Y');?></td>
		</tr>
	</table>	
	<table width="100%">
		<tr>
			<td width="60%" valign="top">
		<fieldset>
		<legend><strong><font color="#0000CC"><?php echo JText::_( 'Organization Detail' ); ?></font></strong></legend>
			<table class="admintable" cellspacing="1" width="100%">
				<tr>
					<td >
						<label for="type_info">
							<strong><?php echo JText::_( 'Organization Type' ); ?></strong>
						</label>
					</td>
					<td>
						<font color="#666666"><?php  if ($row->info_type ==2) $type_info = 'Vendor';
		if ($row->info_type ==3) $type_info = 'Supplier';
		if ($row->info_type ==4) $type_info = 'Manufacture';	 echo $type_info;?></font>
					</td>
				</tr>
				<tr>
					<td>
						<label for="name">
						<strong>	<?php echo JText::_(' Name ');?></strong>
						</label>
					</td>
					<td>
						<font color="#666666"><?php echo $row->info_name?></font>
					</td>
				</tr>
				<tr>
					<td >
						<label for="name">
						<strong>	<?php echo JText::_(' Address ');?></strong>
						</label>
					</td>
					<td>
						<font color="#666666"><?php echo $row->info_address?></font>
					</td>
				</tr>
				<tr>
					<td >
						<label for="name">
						<strong>	<?php echo JText::_('Tel / Fax');?></strong>
						</label>
					</td>
					<td>
						<font color="#666666"><?php echo $row->info_telfax?></font>
					</td>
				</tr>
				<tr>
					<td >
						<label for="name">
						<strong>	<?php echo JText::_('Website');?></strong>
						</label>
					</td>
					<td>
					<font color="#666666">	<?php echo $row->info_website?></font>
					</td>
				</tr>
				<tr>
					<td >
						<label for="name">
						<strong>	<?php echo JText::_('Contact person');?></strong>
						</label>
					</td>
					<td>
						<font color="#666666"><?php echo $row->info_contactperson?></font>
					</td>
				</tr>
				<tr>
					<td >
						<label for="name">
						<strong>	<?php echo JText::_('Email');?></strong>
						</label>
					</td>
					<td>
					<font color="#666666">	<?php echo $row->info_email?></font>
					</td>
				</tr>
				<tr>
					<td >
						<label for="username">
						<strong>	<?php echo JText::_( 'Description' ); ?></strong>
						</label>
					</td>
					<td>
						<font color="#666666"><?php echo $row->info_description?></font>
					</td>
				</tr>				
			</table>
		</fieldset>
	</td>
			<td width="40%" valign="top">
		<fieldset class="adminform">
		<legend><strong><font color="#0000CC"><?php echo JText::_( 'Parameters' ); ?></font></strong></legend>
			<table class="admintable" cellspacing="1" width="100%">
				<tr>
					<td >
						<label for="ccs_create">
						<strong>	<?php echo JText::_('Date create ')?></strong>
						</label>
					</td>
					<td>
						<font color="#666666"><?php echo JHTML::_('date', $row->info_create, '%Y-%m-%d %H:%M:%S');?></font>
					</td>
				</tr>
				<tr>
					<td>
						<label for="ccs_create_by">
						<strong>	<?php echo JText::_('Created by')?></strong>
						</label>
					</td>
					<td>
						<font color="#666666"><?php echo GetValueUser($row->info_created_by, 'username');?></font>
					</td>
				</tr>
				<tr>
					<td>
						<label for="ccs_create">
						<strong>	<?php echo JText::_('  Date modified  ')?></strong>
						</label>
					</td>
					<td>
						<font color="#666666"><?php echo ($row->info_modified_by) ? JHTML::_('date', $row->info_modified, '%Y-%m-%d %H:%M:%S') : 'None';?></font>
					</td>
				</tr>
				<tr>
					<td>
						<label for="ccs_create_by">
						<strong>	<?php echo JText::_(' Modified By')?></strong>
						</label>
					</td>
					<td>
						<font color="#666666"><?php echo ($row->info_modified_by) ? GetValueUser($row->info_modified_by, 'username') : 'None';?></font>
					</td>
				</tr>
				
				
			</table>
		</fieldset>
		
</td>
			
		</tr>
		
	</table>	
</body>
</html>
