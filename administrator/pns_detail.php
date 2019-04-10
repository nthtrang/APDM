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
$query = 'SELECT * FROM apdm_pns WHERE pns_id='.$id;
$db->setQuery( $query);
$row = $db->loadObject();                                                                                            
// get Pns child
 $db->setQuery("SELECT pr.id, pr.pns_id, CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns AS p on pr.pns_id = p.pns_id LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code  WHERE c.ccs_activate=1 AND c.ccs_deleted = 0 AND p.pns_deleted =0 AND pr.pns_parent=".$row->pns_id);
$list_parent = $db->loadObjectList();
$arr_parent_info = array();
if (count($list_parent) > 0){
	foreach($list_parent as $p){
		$arr_parent[] = $p->pns_id;
		$arr_parent_info[] = array("pns_id"=>$p->pns_id, "pns_code"=>$p->parent_pns_code, 'id'=>$p->id);
	}
}else{
	$arr_parent[] =0;
}
 $lists_pns_child = $arr_parent_info;
 //end child
 //get Where use (parent)
 $db->setQuery("SELECT pr.id, pr.pns_parent, CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns AS p on pr.pns_parent = p.pns_id LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code  WHERE c.ccs_activate=1 AND c.ccs_deleted = 0 AND p.pns_deleted =0 AND pr.pns_id=".$row->pns_id);
$list_where_use = $db->loadObjectList();
$arr_where_use = array();
if (count($list_where_use) > 0){
	foreach ($list_where_use as $w){
		$arr_where_use[] = array("id"=>$w->pns_parent, "pns_code"=>$w->parent_pns_code);
	}
}
$lists_where_use= $arr_where_use;
 //end parent (where user)
 //Select list vendor
$db->setQuery("SELECT p.*, v.info_name FROM apdm_pns_supplier as P LEFT JOIN apdm_supplier_info as v on v.info_id = p.supplier_id WHERE p.pns_id=".$row->pns_id." AND p.type_id=2 ");
$list_vendor = $db->loadObjectList();
//select list supperlier
$db->setQuery("SELECT p.*, s.info_name FROM apdm_pns_supplier as P LEFT JOIN apdm_supplier_info as s on s.info_id = p.supplier_id WHERE p.pns_id=".$row->pns_id." AND p.type_id=3 " );
$list_superlier = $db->loadObjectList();

//select list manufacture
$db->setQuery("SELECT p.*, m.info_name FROM apdm_pns_supplier as P LEFT JOIN apdm_supplier_info as m on m.info_id = p.supplier_id WHERE p.pns_id=".$row->pns_id." AND p.type_id=4 ");
$list_manufacture = $db->loadObjectList();

//select cads file
$db->setQuery("SELECT * FROM apdm_pn_cad WHERE pns_id=".$row->pns_id);
$list_cads = $db->loadObjectList();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Export PNs detail</title>
</head>
<body>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td colspan="3" align="center">&nbsp;</td>
		</tr>	
		<tr>
			<td width="33%" align="left" valign="top">ASCENX TECHNOLOGIES</td>
			<td width="33%" align="center">INTERNAL USE ONLY <p><font color="#FF0000">ASCENX TECHNOLOGIES CONFIDENTIAL</font></p></td>
			<td width="33%" align="right"  valign="top">Part number: 600-233350-00<br /> REV: AA	</td>
		</tr>		
		<tr>
			<td colspan="3" align="center"><hr /></td>
		</tr>		
		<tr>
			<th colspan="3" align="center"><h1>Part Detail</h1></th>
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
			<td width="60%" valign="top"><fieldset>
		<legend><font color="#0000CC"><?php echo JText::_( 'PNs Detail' ); ?></font></legend>
			<table cellspacing="1" width="100%">
				<tr>
					<td width="30%">
						<label for="name">
							<?php echo JText::_( 'Ascenx PNs' ); ?>
						</label>
					</td>
					<td width="70%">
					<font color="#666666"><?php echo $row->ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision;?>	</font>				
					</td>
				</tr>				
				<tr>
					<td valign="top" width="30%">
						<label for="username">
							<?php echo JText::_( 'PNs Child' ); ?>
						</label>
					</td>
					<td valign="top" width="70%">
						<?php 
							if (count($lists_pns_child) > 0) {
								foreach ($lists_pns_child as $pns_parent) { 											 
								?>
								<p><font color="#666666"><?php echo $pns_parent['pns_code'];?></font></p>

							<?php	}
							}
						?>
						
					</td>
				</tr>
				<tr>
					<td valign="top" width="30%">
						<label for="username">
							<?php echo JText::_( 'Where used' ); ?>
						</label>
					</td>
					<td valign="top" width="70%">
						<?php 
							if (count($lists_where_use) > 0) {
								foreach ($lists_where_use as $where_use) { 															
								?>
								<p><font color="#666666"><?php echo $where_use['pns_code'];?></font></p>

							<?php	}
							}else{
								echo '<font color="#666666">'.JText::_('NONE_PNS_USE').'</font>';
							}
						?>
						
					</td>
				</tr>
				<tr>
					<td valign="top" width="30%">
						<label for="username">
							<?php echo JText::_( 'ECO number' ); ?>
						</label>
					</td>
					<td width="70%">
						<font color="#666666"><?php echo GetEcoValue($row->eco_id);?></font>
					</td>
				</tr>
				<tr>
					<td  valign="top" width="30%">
						<label for="username">
							<font color="#666666"><?php echo JText::_( 'Type' ); ?></font>
						</label>
					</td>
					<td width="70%">
						<font color="#666666"><?php echo $row->pns_type; ?></font>
					</td>
				</tr>
				<tr>
					<td valign="top" width="30%">
						<label for="username">
							<?php echo JText::_( 'Description' ); ?>
						</label>
					</td>
					<td width="70%">
						<font color="#666666"><?php echo $row->pns_description?></font>
					</td>
				</tr>
				<tr>
					<td valign="top" width="30%">
						<label for="username">
							<?php echo JText::_( 'Status' ); ?>
						</label>
					</td>
					<td width="70%">
						<font color="#666666"><?php echo $row->pns_status; ?></font>
					</td>
				</tr>
						<tr>
					<td  valign="top" width="30%">
						<label for="username">
							<?php echo JText::_( 'Date Create' ); ?>
						</label>
					</td>
					<td width="70%">
 						<font color="#666666"><?php echo  JHTML::_('date', $row->pns_create, JText::_('DATE_FORMAT_LC6')); ?></font>

					</td>
				</tr>
				<tr>
					<td  valign="top" width="30%">
						<label for="username">
							<?php echo JText::_( 'Create by' ); ?>
						</label>
					</td>
					<td width="70%">
 						<font color="#666666"><?php echo GetValueUser($row->pns_create_by, "username"); ?></font>

					</td>
				</tr>
				
				<tr>
					<td valign="top" width="30%">
						<label for="username">
							<?php echo JText::_( 'Date Modified' ); ?>
						</label>
					</td>
					<td width="70%">
 						<font color="#666666"><?php echo  ($row->pns_modified_by) ? JHTML::_('date', $row->pns_modified, JText::_('DATE_FORMAT_LC6')) : ''; ?></font>

					</td>
				</tr>
				<tr>
					<td valign="top" width="30%">
						<label for="username">
							<?php echo JText::_( 'Modified By' ); ?>
						</label>
					</td>
					<td width="70%"> 						
						<font color="#666666"><?php echo  ($row->pns_modified_by) ? GetValueUser($row->pns_modified_by, "username") : ''; ?></font>

					</td>
				</tr>
				
			</table>
		</fieldset></td>
			<td width="40%" valign="top"><fieldset >
		<legend><font color="#0000CC"><?php echo JText::_( 'Image, Pdf, CAD files' ); ?></font></legend>
			<table width="100%" cellpadding="1" cellspacing="1"  >
				<tr>
					<td colspan="2">
						<label for="ccs_create">
							<strong><?php echo JText::_('IMAGE')?></strong>
						</label>
					</td>	
							
				</tr>
				<?php if ($row->pns_image !="") {?>
				<tr>
					<td  align="center" colspan="2">
					<img src="../uploads/pns/images/<?php echo $row->pns_image?>" width="200" height="100"  />								
					</td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="2">
						<label for="ccs_create">
							<strong><?php echo JText::_('PDF')?></strong>
						</label>
					</td>
				
				</tr>
				<?php if ($row->pns_pdf !="") {?>
				<tr>
					<td  align="center" colspan="2"><font color="#666666"><?php echo $row->pns_pdf;?> &nbsp;(<?php $filesizepdf = Readfilesize('pdf', $row->pns_pdf); echo number_format($filesizepdf, 0, '.', ' ')?>&nbsp;KB) 	<font color="#666666">		
				
					</td>
				</tr>
				<?php } ?>
				<?php if (count($list_cads) > 0) {
				?>
				<tr>
					<td colspan="2">
					<table width="100%"  cellpadding="2" cellspacing="2">
						<hr />
						<thead>
							<th colspan="3"><?php echo JText::_('List file cads')?></th>
						</thead>
						<tr>
							<td width="5%"><strong><?php echo JText::_('No.')?></strong></td>
							<td width="65%"><strong><?php echo JText::_('Name')?> </strong></td>
							<td width="30%"><strong><?php echo JText::_('Size (KB)')?> </strong></td>

						</tr>
				<?php
				
				$i = 1;
				$folder_pns = $row->ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision;
				foreach ($list_cads as $cad) {		
				$filesize = Readfilesize('cads', $cad->cad_file, $row->ccs_code, $folder_pns);			
				?>
				<tr>
					<td width="5%"><font color="#666666"><?php echo $i?></font></td>
					<td width="65%"><font color="#666666"><?php echo $cad->cad_file;?></font></td>
					<td width="30%"><font color="#666666"><?php echo number_format($filesize, 0, '.', ' '); ?></font></td>				
					
				</tr>
				<?php $i++; } ?>
				
					</table>
					</td>
				</tr>
				<?php } ?>
				
							
			</table>
		</fieldset></td>
		</tr>
	</table>	
	<div style="width:590px">
		<fieldset>
		<legend><font color="#0000CC"><?php echo JText::_( 'Vendor' ); ?></font></legend>
		<table cellspacing="1" cellpadding="2" width="400" border="1">
				<thead>
					<tr bgcolor="#CCCCCC">
						<th width="50%"><?php echo JText::_( 'Vendor Name' ); ?></th>
						<th><?php echo JText::_( 'Vendor PNs' ); ?></th>
					</tr>
				</thead>
					<?php if (count($list_vendor) > 0) { ?>
				<tbody >	
				 <?php
					$i = 0;
					foreach($list_vendor as $v) {
						
					 ?>			<tr <?php echo ($i%2 !=0 ) ? 'bgcolor="#EAEAEA"' : '';?> ><td><font color="#666666"><?php echo $v->info_name?></font></td> <td><font color="#666666"><?php echo $v->supplier_info;?></font></td></tr>
					<?php $i++; }
						?>			
				</tbody>
				 <?php } ?>	
				</table>
		
		
		</fieldset>
	</div>
	<div style="width:590px">
	<fieldset>
		<legend><font color="#0000CC"><?php echo JText::_( 'Supplier' ); ?></font></legend>
		<table cellspacing="1" cellpadding="2"  width="400" border="1">
				<thead>
					<tr bgcolor="#CCCCCC">
						<th width="50%"><?php echo JText::_( 'Supplier Name' ); ?></th>
						<th width="50%"><?php echo JText::_( 'Supplier PNs' ); ?></th>
					</tr>
				</thead>
				<?php if (count($list_superlier) > 0) { ?>
				<tbody >	
					<?php
					$i=0;
								foreach($list_superlier as $s) {
						 ?>			<tr <?php echo ($i%2 !=0 ) ? 'bgcolor="#EAEAEA"' : '';?>><td><font color="#666666"><?php echo $s->info_name; ?></font></td><td> <font color="#666666"><?php echo $s->supplier_info;?></font></td></tr>
						<?php $i++; } ?>
						 				
				</tbody>
			<?php	} ?>
				</table>
		
		</fieldset>
	</div>
	<div style="width:590px">
	<fieldset >
		<legend><font color="#0000CC"><?php echo JText::_( 'Manufacture' ); ?></font></legend>
		<table cellspacing="1" cellpadding="2" width="400" border="1">
				<thead>
					<tr bgcolor="#CCCCCC">
						<th width="50%"><?php echo JText::_( 'Manufacture Name' ); ?></th>
						<th><?php echo JText::_( 'Manufacture PNs' ); ?></th>
					</tr>
				</thead>
			<?php if (count($list_manufacture) > 0) { ?>
				<tbody >	
			<?php	
					$i=0;
							foreach($list_manufacture as $m) {
					 ?>			<tr <?php echo ($i%2 !=0 ) ? 'bgcolor="#EAEAEA"' : '';?>><td><font color="#666666"><?php echo $m->info_name; ?></font></td><td> <font color="#666666"><?php echo $m->supplier_info;?></font></td></tr>
					<?php $i++; }
					 ?>					
				</tbody>
				<?php } ?>
				</table>
		
		
		
		</fieldset>
	</div>
	
</body>
</html>
