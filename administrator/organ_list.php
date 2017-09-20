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
$query = $_REQUEST['q'];
$limit = $_REQUEST['l'];
$limitstart = $_REQUEST['ls'];
$username  = $_REQUEST['u'];
$total    = $_REQUEST['t'];
$db             =& JFactory::getDBO();  
$query = base64_decode($query);    
jimport('joomla.html.pagination');
$pagination = new JPagination( $total, $limitstart, $limit );
$db->setQuery( $query, $pagination->limitstart, $pagination->limit );
$rows = $db->loadObjectList();                                                                                            
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Export Organization</title>
</head>
<body>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td colspan="3" align="center">&nbsp;</td>
		</tr>	
		<tr>
			<td width="33%" align="left" valign="top">ASCENX TECHNOLOGIES</td>
			<td width="33%" align="center">INTERNAL USE ONLY <p><font color="#FF0000">ASCENX TECHNOLOGIES CONFIDENTIAL</font></p></td>
			<td width="33%" valign="top" align="right">Part Number: 600-124470-00 <br /> REV: AA</td>
		</tr>		
		<tr>
			<td colspan="3" align="center"><hr /></td>
		</tr>		
		<tr>
			<th colspan="3" align="center"><h1>Organization Management</h1></th>
		</tr>		
	</table>
	<table width="100%">
		<tr>
			<td width="50%">Username: <?php echo $username;?></td>
			<td align="right" width="50%">Date Created: <?php echo date('d/m/Y');?></td>
		</tr>
	</table>
	<table width="100%" border="0" cellpadding="8" cellspacing="0" style="border:1px solid #000;">
		<tr bgcolor="#003366">
			<th width="15%" align="center" style="border-right:1px solid #fff;"><font color="#FFFFFF"> Name </font></th>
			<th width="10%" align="center" style="border-right:1px solid #fff;"><font color="#FFFFFF"> Type </font></th>
			<th width="40%" align="center" style="border-right:1px solid #fff;"><font color="#FFFFFF">Description</font></th>
			<th width="15%" align="center" style="border-right:1px solid #fff;"><font color="#FFFFFF">Website</font></th>
			<th width="10%" align="center" style="border-right:1px solid #fff;"><font color="#FFFFFF">Status</font></th>
			<th width="10%" align="center"><font color="#FFFFFF">Date Create</font></th>
		</tr>
		<?php if (count($rows) > 0) {
			$i = 0;
			foreach ($rows as $row) {
				if ($row->info_type ==2) $type = 'Vendor';
				if ($row->info_type ==3) $type = 'Supplier';
				if ($row->info_type ==4) $type = 'Manufacture';
		?>
		<tr <?php echo ($i%2) ? 'bgcolor="#E1E1E1"' : ''; ?> >
			<td  ><font color="#666666"><?php echo $row->info_name; ?></font></td>
			<td align="center"><font color="#666666"><?php echo $type; ?></font></td>
			<td ><font color="#666666"><?php echo $row->info_description; ?></font></td>
			<td ><font color="#666666"><?php echo $row->info_website; ?></font></td>
			<td align="center"><font color="#666666"><?php echo ($row->info_activate) ? 'Activate' : 'InActivate'; ?></font></td>
			<td><font color="#666666"><?php echo JHTML::_('date', $row->info_create, '%m/%d/%Y') ; ?></font></td>
		</tr>
		<?php 
			$i++;
			 } //foreach
		 }
		?>

	</table>

</body>
</html>
