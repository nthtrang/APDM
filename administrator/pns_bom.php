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
//get list child
$query = "SELECT pr.*, p.ccs_code FROM apdm_pns_parents as pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=".$id." ORDER BY p.ccs_code ";		
$db->setQuery($query);
$rows = $db->loadObjectList();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Export PNs BOM</title>
</head>
<body>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td colspan="3" align="center">&nbsp;</td>
		</tr>	
		<tr>
			<td width="33%" align="left" valign="top">ASCENX TECHNOLOGIES</td>
			<td width="33%" align="center">INTERNAL USE ONLY <p><font color="#FF0000" >ASCENX TECHNOLOGIES CONFIDENTIAL</font></p></td>
			<td width="33%" align="right" valign="top">Part Number: 600-063133-00 <br /> REV: AA</td>
		</tr>
		<tr>
			<td colspan="3" align="center"><hr /></td>
		</tr>		
		<tr>
			<th colspan="3" align="center"><h1>Bill of Materials</h1></th>
		</tr>		
	</table>
	<table width="100%">
		<tr>
			<td width="50%">Username: <?php echo $username;?></td>
			<td align="right" width="50%">Date Created: <?php echo date('d/m/Y');?></td>
		</tr>
	</table>
	<table width="100%" border="1" cellpadding="6" cellspacing="0" >
		<tr bgcolor="#003366">
			<th width="18%" ><font color="#FFFFFF"> Pns number </font></th>
			<th width="5%" ><font color="#FFFFFF"> Level </font></th>
			<th width="8%" ><font color="#FFFFFF"> ECO </font></th>
			<th width="9%" align="left" ><font color="#FFFFFF">Type</font></th>
			<th width="40%" align="left" ><font color="#FFFFFF">Description</font></th>
			<th width="10%" align="left" ><font color="#FFFFFF">Status</font></th>
			<th width="10%"><font color="#FFFFFF">Date Create</font></th>
		</tr>
		<tr>
				<td  align="center"><font color="#666666"><?php echo $row->ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision; ?></font></td>
				<td   align="center"><font color="#666666">0</font></td>
				<td   align="center"><font color="#666666"><?php echo GetEcoValue($row->eco_id); ?></font></td>
				<td  ><font color="#666666"><?php echo $row->pns_type; ?></font></td>
				<td  ><font color="#666666"><?php echo ($row->pns_description) ? $row->pns_description : ''; ?></font> </td>
				<td  ><font color="#666666"><?php echo $row->pns_status; ?></font></td>
				<td><font color="#666666"><?php echo JHTML::_('date', $row->pns_create, '%m/%d/%Y') ; ?></font></td>
		   </tr>
		<?php if (count($rows) > 0) {
			$i = 0;
			foreach ($rows as $obj1) {
				$level = 1;
				$query1 = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj1->pns_id;
				
				$db->setQuery($query1);
				$result1 = $db->loadObject();	
		?>
			<tr>
				<td  align="center"><font color="#666666"><?php echo $result1->full_pns_code; ?></font></td>
				<td   align="center"><font color="#666666"><?php echo $level; ?></font></td>
				<td   align="center"><font color="#666666"><?php echo $result1->eco_name; ?></font></td>
				<td  ><font color="#666666"><?php echo $result1->pns_type; ?></font></td>
				<td  ><font color="#666666"><?php echo ($result1->pns_description) ? $result1->pns_description : ''; ?></font> </td>
				<td  ><font color="#666666"><?php echo $result1->pns_status; ?></font></td>
				<td><font color="#666666"><?php echo JHTML::_('date', $result1->pns_create, '%m/%d/%Y') ; ?></font></td>
		   </tr>
		   <?php 
		   		///check for child of level 2
				$db->setQuery("SELECT pr.*,  p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=".$obj1->pns_id." ORDER BY p.ccs_code");                
				 $rows2 = $db->LoadObjectList();
				 if (count($rows2) > 0 ){
				 	//display level 2
						foreach ($rows2 as $obj2){
							$level2 = 2;
							$query2 = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj2->pns_id;
				
							$db->setQuery($query2);
							$result2 = $db->loadObject();
							?>
								<tr>
									<td   align="center"><font color="#666666"><?php echo $result2->full_pns_code; ?></font></td>
									<td   align="center"><font color="#666666"><?php echo $level2; ?></font></td>
									<td   align="center"><font color="#666666"><?php echo $result2->eco_name; ?></font></td>
									<td  ><font color="#666666"><?php echo $result2->pns_type; ?></font></td>
									<td  ><font color="#666666"><?php echo $result2->pns_description; ?></font></td>
									<td  ><font color="#666666"><?php echo $result2->pns_status; ?></font></td>
									<td><font color="#666666"><?php echo JHTML::_('date', $result2->pns_create, '%m/%d/%Y') ; ?></font></td>
							   </tr>
							<?php
							//check for level 3
							$db->setQuery("SELECT pr.*,  p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=".$obj2->pns_id." ORDER BY p.ccs_code");                
						   $rows3 = $db->LoadObjectList();
						   if (count($rows3) > 0){
						   		foreach ($rows3 as $obj3){
									$level3 = 3;
									$query3 = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj3->pns_id;
				
									$db->setQuery($query3);
									$result3 = $db->loadObject();
									?>
									<tr>
										<td   align="center"><font color="#666666"><?php echo $result3->full_pns_code; ?></font></td>
										<td   align="center"><font color="#666666"><?php echo $level3; ?></font></td>
										<td   align="center"><font color="#666666"><?php echo $result3->eco_name; ?></font></td>
										<td  ><font color="#666666"><?php echo $result3->pns_type; ?></font></td>
										<td  ><font color="#666666"><?php echo $result3->pns_description; ?></font></td>
										<td  ><font color="#666666"><?php echo $result3->pns_status; ?></font></td>
										<td><font color="#666666"><?php echo JHTML::_('date', $result3->pns_create, '%m/%d/%Y') ; ?></font></td>
							  		 </tr>
									<?php
									//check for level 4
									$db->setQuery("SELECT pr.*,  p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=".$obj3->pns_id." ORDER BY p.ccs_code");                
						   			$rows4 = $db->LoadObjectList();
									if ( count ($rows4) >0 ){
										foreach ($rows4 as $obj4){
											$level4 = 4;
											$query4 = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj4->pns_id;
				
											$db->setQuery($query4);
											$result4 = $db->loadObject();
											?>
											<tr>
												<td   align="center"><font color="#666666"><?php echo $result4->full_pns_code; ?></font></td>
												<td   align="center"><font color="#666666"><?php echo $level4; ?></font></td>
												<td   align="center"><font color="#666666"><?php echo $result4->eco_name; ?></font></td>
												<td  ><font color="#666666"><?php echo $result4->pns_type; ?></font></td>
												<td  ><font color="#666666"><?php echo $result4->pns_description; ?></font></td>
												<td  ><font color="#666666"><?php echo $result4->pns_status; ?></font></td>
												<td><font color="#666666"><?php echo JHTML::_('date', $result4->pns_create, '%m/%d/%Y') ; ?></font></td>
											 </tr>
											<?php
											//check for level 5
											$db->setQuery("SELECT pr.*,  p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=".$obj4->pns_id." ORDER BY p.ccs_code");                
						   					 $rows5 = $db->LoadObjectList();
											 if (count($rows5) > 0){
											 	foreach ($rows5 as $obj5){
													$level5 = 5;
													$query5 = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj5->pns_id;
					
													$db->setQuery($query5);
													$result5 = $db->loadObject();
													?>
													<tr>
														<td   align="center"><font color="#666666"><?php echo $result5->full_pns_code; ?></font></td>
														<td   align="center"><font color="#666666"><?php echo $level5; ?></font></td>
														<td   align="center"><font color="#666666"><?php echo $result5->eco_name; ?></font></td>
														<td  ><font color="#666666"><?php echo $result5->pns_type; ?></font></td>
														<td  ><font color="#666666"><?php echo $result5->pns_description; ?></font></td>
														<td  ><font color="#666666"><?php echo $result5->pns_status; ?></font></td>
														<td><font color="#666666"><?php echo JHTML::_('date', $result5->pns_create, '%m/%d/%Y') ; ?></font></td>
													 </tr>
													<?php
													//check for level 6
													$db->setQuery("SELECT pr.*,  p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=".$obj5->pns_id." ORDER BY p.ccs_code");                
						   					 		$rows6 = $db->LoadObjectList();
													if ( count ($rows6) > 0 ){
														foreach ($rows6 as $obj6) {
															$level6 = 6;
															$query6 = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj6->pns_id;
					
															$db->setQuery($query6);
															$result6 = $db->loadObject();
															?>
															<tr>
																<td   align="center"><font color="#666666"><?php echo $result6->full_pns_code; ?></font></td>
																<td   align="center"><font color="#666666">	<?php echo $level6; ?></font></td>
																<td   align="center">	<font color="#666666"><?php echo $result6->eco_name; ?></font></td>
																<td  ><font color="#666666"><?php echo $result6->pns_type; ?></font></td>
																<td><font color="#666666"><?php echo $result6->pns_description; ?></font></td>
																<td  ><font color="#666666"><?php echo $result6->pns_status; ?></font></td>
																<td><?php echo JHTML::_('date', $result6->pns_create, '%m/%d/%Y') ; ?></td>
															 </tr>
															<?php	
															//check for level 7
															$db->setQuery("SELECT pr.*,  p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=".$obj6->pns_id." ORDER BY p.ccs_code");                
						   					 				$rows7 = $db->LoadObjectList();														
															if ( count ($rows7) > 0 ){
																foreach ($rows7 as $obj7){
																	$level7 = 7;
																	$query7 = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj7->pns_id;
					
																$db->setQuery($query7);
																$result7 = $db->loadObject();
																?>
																<tr>
																	<td   align="center"><font color="#666666"><?php echo $result7->full_pns_code; ?></font></td>
																	<td   align="center"><font color="#666666"><?php echo $level7; ?></font></td>
																	<td   align="center"><font color="#666666"><?php echo $result7->eco_name; ?></font></td>
																	<td  ><font color="#666666"><?php echo $result7->pns_type; ?></font></td>
																	<td  ><font color="#666666"><?php echo $result7->pns_description; ?></font></td>
																	<td  ><font color="#666666"><?php echo $result7->pns_status; ?></font></td>
																	<td><font color="#666666"><?php echo JHTML::_('date', $result7->pns_create, '%m/%d/%Y') ; ?></font></td>
																 </tr>
																<?php
																	//check level 8
																	$db->setQuery("SELECT pr.*,  p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=".$obj7->pns_id." ORDER BY p.ccs_code");                
								   					 				$rows8 = $db->LoadObjectList();	
																	if ( count ($rows8) > 0 ){
																		foreach ($rows8 as $obj8){
																			$level8 = 8;
																			$query8 = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj8->pns_id;
						
																		$db->setQuery($query8);
																		$result8 = $db->loadObject();
																		?>
																		<tr>
																			<td   align="center"><font color="#666666"><?php echo $result8->full_pns_code; ?></font></td>
																			<td   align="center"><font color="#666666"><?php echo $level8; ?></font></td>
																			<td   align="center"><font color="#666666"><?php echo $result8->eco_name; ?></font></td>
																			<td  ><font color="#666666"><?php echo $result8->pns_type; ?></font></td>
																			<td  ><font color="#666666"><?php echo $result8->pns_description; ?></font></td>
																			<td  ><font color="#666666"><?php echo $result8->pns_status; ?></font></td>
																			<td><font color="#666666"><?php echo JHTML::_('date', $result8->pns_create, '%m/%d/%Y') ; ?></font></td>
																		 </tr>
																		<?php
																			//chekc for level 9
																		$db->setQuery("SELECT pr.*,  p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=".$obj8->pns_id." ORDER BY p.ccs_code");                
								   					 					$rows9 = $db->LoadObjectList();	
																		if ( count ($rows9) > 0){
																			foreach ($rows9 as $obj9){
																				$level9 = 9;
																			    $query9 = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj9->pns_id;
						
																			$db->setQuery($query9);
																			$result9 = $db->loadObject();
																			?>
																				<tr>
																				<td   align="center"><font color="#666666"><?php echo $result9->full_pns_code; ?></font></td>
																				<td   align="center"><font color="#666666"><?php echo $level9; ?></font></td>
																				<td   align="center"><font color="#666666">	<?php echo $result9->eco_name; ?></font></td>
																				<td  ><font color="#666666"><?php echo $result9->pns_type; ?></font></td>
																				<td  ><font color="#666666"><?php echo $result9->pns_description; ?></font></td>
																				<td  ><font color="#666666"><?php echo $result9->pns_status; ?></font></td>
																				<td><font color="#666666"><?php echo JHTML::_('date', $result9->pns_create, '%m/%d/%Y') ; ?></font></td>
																			 </tr>
																			<?php
																			//check for level 10
																				$db->setQuery("SELECT pr.*,  p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=".$obj9->pns_id." ORDER BY p.ccs_code");                
										   					 					$rows10 = $db->LoadObjectList();	
																				if ( count ($rows10) > 0){
																					foreach ($rows10 as $obj10 ){
																						$level10 = 10;
																			   			 $query10 = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj10->pns_id;
						
																					$db->setQuery($query9);
																					$result10 = $db->loadObject();
																					?>
																					<tr>
																						<td   align="center"><font color="#666666"><?php echo $result10->full_pns_code; ?></font></td>
																						<td   align="center"><font color="#666666">	<?php echo $level10; ?></font></td>
																						<td   align="center"><font color="#666666">	<?php echo $result10->eco_name; ?></font></td>
																						<td  ><font color="#666666"><?php echo $result10->pns_type; ?></font></td>
																						<td  ><font color="#666666"><?php echo $result10->pns_description; ?></font></td>
																						<td  ><font color="#666666"><?php echo $result10->pns_status; ?></font></td>
																						<td><font color="#666666"><?php echo JHTML::_('date', $result10->pns_create, '%m/%d/%Y') ; ?></font></td>
																					 </tr>
																					<?php
																					}
																				} //end count rows10
																		    } //end foreach level 9
																		  } //end count rows 9
																		} // end foreach level 8
																	} //end for count rows8
																} //end foreach level 7
															} //end for count rows7
														} //end foreach level 7
													} //end count rows6
												} //end foreach level 5
											 } //end count rows 5
										} //end foreach level 4
									} //end count rows4 
								} //end foreach level 3
						   } //end for count $rows3
						} //end foreach level 2
				 } //end for count rows2
		   ?>
		<?php 			
		$i++;
			} //end foreach level 1
		}  //end for count level1
		?>
	</table>
</body>
</html>
