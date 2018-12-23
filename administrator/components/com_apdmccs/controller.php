<?php
/**
 * @version		$Id: controller.php 10381 2008-06-01 03:35:53Z pasamio $
 * @package		Joomla
 * @subpackage	Users
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');
require_once('includes/class.upload.php');  



/**
 * Users Component Controller
 *
 * @package		Joomla
 * @subpackage	Users
 * @since 1.5
 */
class CCsController extends JController
{
	/**
	 * Constructor
	 *
	 * @params	array	Controller configuration array
	 */
	function __construct($config = array())
	{
		parent::__construct($config);

		// Register Extra tasks
		$this->registerTask( 'add'  , 	'display'  );
                $this->registerTask( 'addcustomer'  , 	'display'  );
		$this->registerTask( 'edit'  , 	'display'  );
		$this->registerTask( 'detail'  , 'display'  );
		$this->registerTask( 'trash'  , 'display'  );
		$this->registerTask( 'apply', 	'save'  );
		$this->registerTask( 'flogout', 'logout');
		$this->registerTask( 'unblock', 'block' );
		$this->registerTask( 'code_default', 'GetDefaultCode' );
		$this->registerTask( 'export', 'export' );
	}

	/**
	 * Displays a view
	 */
	function display( )
	{
		
		switch($this->getTask())
		{
			case 'addcustomer':
                        {
				JRequest::setVar( 'layout', 'formcus'  );
				JRequest::setVar( 'view', 'cce' );
				JRequest::setVar( 'edit', false );                                
                        } break;
			case 'add'     :
			{	
				JRequest::setVar( 'layout', 'form'  );
				JRequest::setVar( 'view', 'cce' );
				JRequest::setVar( 'edit', false );
			} break;
			case 'edit'    :
			{				
				JRequest::setVar( 'layout', 'form'  );
				JRequest::setVar( 'view', 'cce' );
				JRequest::setVar( 'edit', true );
			} break;
			case 'editmpn'    :
			{				
				JRequest::setVar( 'layout', 'formcus'  );
				JRequest::setVar( 'view', 'cce' );
				JRequest::setVar( 'edit', true );
			} break;                
                
			case 'detail':{
				JRequest::setVar( 'layout', 'view'  );
				JRequest::setVar( 'view', 'cce' );
				JRequest::setVar( 'edit', true );
			}
			break;
			case 'detailmpn':{
				JRequest::setVar( 'layout', 'viewmpn'  );
				JRequest::setVar( 'view', 'cce' );
				JRequest::setVar( 'edit', true );
			}
			break;                                
			case 'trash':{
				JRequest::setVar( 'layout', 'default'  );
				JRequest::setVar( 'view', 'ccr' );				
			}
			break;
			case 'vrestore':{
				JRequest::setVar( 'layout', 'vrestore'  );
				JRequest::setVar( 'view', 'cce' );	
				JRequest::setVar( 'edit', true );			
			}
			break;
		}

		parent::display();
	}

	/**
	 * Saves the record
	 */
	function save()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$option = JRequest::getCmd( 'option');
		// Initialize some variables
		$db			= & JFactory::getDBO();
		$me			= & JFactory::getUser();
		$row = & JTable::getInstance('apdmccs');	
                $ccs_description = strtoupper(JRequest::getVar('ccs_description'));	
		if (!$row->bind(JRequest::get('post'))) {
			JError::raiseError( 500, $db->stderr() );
			return false;
		}
		$row->ccs_description = $ccs_description;
		$row->ccs_id = (int) $row->ccs_id;
		$isNew = true;		
		// Are we saving from an item edit?
		if ($row->ccs_id) {
			$isNew = false;
			$datenow =& JFactory::getDate();
			$row->ccs_modified 		= $datenow->toMySQL();
			$row->ccs_modified_by 	= $me->get('id');
		}
		$row->ccs_create_by 	= $row->ccs_create_by ? $row->ccs_create_by : $me->get('id');

		if ($row->ccs_create && strlen(trim( $row->ccs_create )) <= 10) {
			$row->ccs_create 	.= ' 00:00:00';
		}
		$config =& JFactory::getConfig();
		$tzoffset = $config->getValue('config.offset');
		$date =& JFactory::getDate($row->ccs_create, $tzoffset);
		$row->ccs_create = $date->toMySQL();
		if (!$row->check()){          
            
             $msg = JText::_('This commodity code have exist. Please input an other.');
             $this->setRedirect( 'index.php?option=com_apdmccs&task=add', $msg ); 
           
        } else if (!$row->check_des()){
              $msg = JText::_('This description of commodity code have exist. Please input an other.');
             $this->setRedirect( 'index.php?option=com_apdmccs&task=add', $msg ); 
        }else{
		// Store the content to the database
		    if (!$row->store()) {
			    JError::raiseError( 500, $db->stderr() );
			    return false;
		    }else{
                
			    if ($isNew){
                      //create folder
                    $path_pns_ccs =  JPATH_SITE.DS.'uploads'.DS.'pns'.DS.'cads'.DS.$row->ccs_code.DS;   
                    $upload = new upload($_FILES['']);
                    $upload->r_mkdir($path_pns_ccs, 0777);
				    $what = "W";
                   
			    }else{
				    $what = "E";
			    }
			    JAdministrator::HistoryUser(1, $what, $row->ccs_id);
		    }
		    
		    switch ( $this->getTask() )
		    {
			    case 'apply':
				    $msg = JText::sprintf( 'ALERT_SAVE_1', $row->ccs_code );                                    
                                    if($row->ccs_cpn==0)
                                        $this->setRedirect( 'index.php?option=com_apdmccs&view=cce&task=detail&cid[]='. $row->ccs_id, $msg );
                                    else
                                        $this->setRedirect( 'index.php?option=com_apdmccs&view=cce&task=detailmpn&cid[]='. $row->ccs_id, $msg );
				    //$this->setRedirect( 'index.php?option=com_apdmccs', $msg );
				    break;

			    case 'save':
			    default:
				    $msg = JText::sprintf( 'ALERT_SAVE_1', $row->ccs_code );
				    $this->setRedirect( 'index.php?option=com_apdmccs&task=add', $msg );
				    break;
		    }
        }
	}
/**
	 * Saves the record
	 */
	function savecus()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$option = JRequest::getCmd( 'option');
		// Initialize some variables
		$db			= & JFactory::getDBO();
		$me			= & JFactory::getUser();
		$row = & JTable::getInstance('apdmccs');	
                $ccs_description = strtoupper(JRequest::getVar('ccs_description'));	
                $ccs_code1 = strtoupper(JRequest::getVar('ccs_code1'));	
                $ccs_code2 = strtoupper(JRequest::getVar('ccs_code2'));
                $ccs_coordinator = JRequest::getVar('ccs_coordinator');
                $ccs_code = $ccs_code1.$ccs_code2;
		if (!$row->bind(JRequest::get('post'))) {
			JError::raiseError( 500, $db->stderr() );
			return false;
		}
                $row->ccs_cpn = 1;
                $row->ccs_coordinator = $ccs_coordinator;
                $row->ccs_description = $ccs_description;
		$row->ccs_code = $ccs_code;
                $row->ccs_id = (int) $row->ccs_id;
	 	$isNew = true;		
		// Are we saving from an item edit?
		if ($row->ccs_id) {
			$isNew = false;
			$datenow =& JFactory::getDate();
			$row->ccs_modified 		= $datenow->toMySQL();
			$row->ccs_modified_by 	= $me->get('id');
		}
		$row->ccs_create_by 	= $row->ccs_create_by ? $row->ccs_create_by : $me->get('id');

		if ($row->ccs_create && strlen(trim( $row->ccs_create )) <= 10) {
			$row->ccs_create 	.= ' 00:00:00';
		}
		$config =& JFactory::getConfig();
		$tzoffset = $config->getValue('config.offset');
		$date =& JFactory::getDate($row->ccs_create, $tzoffset);
		$row->ccs_create = $date->toMySQL();
		if (!$row->check()){          
            
             $msg = JText::_('This commodity code have exist. Please input an other.');
             $this->setRedirect( 'index.php?option=com_apdmccs&task=addcustomer', $msg ); 
           
        } else if (!$row->check_des()){
              $msg = JText::_('This description of commodity code have exist. Please input an other.');
             $this->setRedirect( 'index.php?option=com_apdmccs&task=addcustomer', $msg ); 
        }else{
		// Store the content to the database
		    if (!$row->store()) {
			    JError::raiseError( 500, $db->stderr() );
			    return false;
		    }else{
                
			    if ($isNew){
                      //create folder
                    $path_pns_ccs =  JPATH_SITE.DS.'uploads'.DS.'pns'.DS.'cads'.DS.$row->ccs_code.DS;   
                    $upload = new upload($_FILES['']);
                    $upload->r_mkdir($path_pns_ccs, 0777);
				    $what = "W";
                   
			    }else{
				    $what = "E";
			    }
			    JAdministrator::HistoryUser(1, $what, $row->ccs_id);
		    }
		    
		    switch ( $this->getTask() )
		    {
			    case 'savecus':                                    
				    $msg = JText::sprintf( 'ALERT_SAVE_1', $row->ccs_code );
                                    if(JRequest::getVar('back')=="mpn")
                                        $this->setRedirect( 'index.php?option=com_apdmpns&task=addpncus', $msg );                                            
                                    elseif(JRequest::getVar('back')=="so")
                                        $this->setRedirect( 'index.php?option=com_apdmpns&task=add_so', $msg );                                            
                                    else
                                        $this->setRedirect( 'index.php?option=com_apdmccs&view=cce&task=detailmpn&cid[]='. $row->ccs_id, $msg );                                        
				    //$this->setRedirect( 'index.php?option=com_apdmccs', $msg );
				    break;

			    case 'save':
			    default:
				    $msg = JText::sprintf( 'ALERT_SAVE_1', $row->ccs_code );
				    $this->setRedirect( 'index.php?option=com_apdmccs&task=addcustomer', $msg );
				    break;
		    }
        }
	}

	/**
	 * Removes the record(s) from the database
	 */
	function remove()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$db 			=& JFactory::getDBO();
		$me			 	=& JFactory::getUser();	
		$cid 			= JRequest::getVar( 'cid', array(), '', 'array' );
		$datenow =& JFactory::getDate();
		$ccs_modified 		= $datenow->toMySQL();
		$ccs_modified_by 	= $me->get('id');

		JArrayHelper::toInteger( $cid );

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select a Commodity Code to delete', true ) );
		}

		foreach ($cid as $id)
		{
			//for CCS
			$query = "UPDATE apdm_ccs SET ccs_deleted=1, ccs_modified='".$ccs_modified."', ccs_modified_by=".$ccs_modified_by." WHERE ccs_id=".$id;
			$db->setQuery($query);
			$db->query();
			//For PNs
			$query_pns = "UPDATE apdm_pns SET pns_deleted=1 WHERE ccs_id=".$id;
			$db->setQuery($query_pns);
			$db->query();
			// for history
			JAdministrator::HistoryUser(1, 'D', $id);
			
		}
		$msg = JText::_('DELETE_COMMODITY_CODE_SUCCESSFUL');
		$this->setRedirect( 'index.php?option=com_apdmccs', $msg);
	}
	function restore()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$db 			=& JFactory::getDBO();
		$me			 	=& JFactory::getUser();	
		$cid 			= JRequest::getVar( 'cid', array(), '', 'array' );
		$datenow =& JFactory::getDate();
		$ccs_modified 		= $datenow->toMySQL();
		$ccs_modified_by 	= $me->get('id');

		JArrayHelper::toInteger( $cid );

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select a Commodity Code to restore', true ) );
		}

		foreach ($cid as $id)
		{
			//for CCS
			$query = "UPDATE apdm_ccs SET ccs_deleted=0, ccs_modified='".$ccs_modified."', ccs_modified_by=".$ccs_modified_by." WHERE ccs_id=".$id;
			$db->setQuery($query);
			$db->query();
			//For PNs
		//	$query_pns = "UPDATE apdm_pns SET pns_deleted=1 WHERE ccd_id=".$id;
		//	$db->setQuery($query_pns);
		//	$db->query();
			// for history
			JAdministrator::HistoryUser(1, 'R', $id);
			
		}
		$msg = JText::_('RESTORE_COMMODITY_CODE_SUCCESSFUL');
		$this->setRedirect( 'index.php?option=com_apdmccs&task=trash', $msg);
	}
	function delete()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$db 			=& JFactory::getDBO();
	
		$cid 			= JRequest::getVar( 'cid', array(), '', 'array' );

		JArrayHelper::toInteger( $cid );

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select a Commodity Code to delete', true ) );
		}

		foreach ($cid as $id)
		{
			//for CCS
			$query = "DELETE FROM apdm_ccs WHERE ccs_id=".$id;
			$db->setQuery($query);
			$db->query();
			//For PNs
			$query_pns = "DELETE apdm_pns WHERE ccd_id=".$id;
			$db->setQuery($query_pns);
			$db->query();
			
		}
		$msg = JText::_('DELETE_COMMODITY_CODE_SUCCESSFUL');
		$this->setRedirect( 'index.php?option=com_apdmccs&task=trash', $msg);
	}

	/**
	 * Cancels an edit operation
	 */
	function cancel( )
	{
		$this->setRedirect( 'index.php?option=com_apdmccs' );
	}
	function cancel_restore( )
	{
		$this->setRedirect( 'index.php?option=com_apdmccs&task=trash' );
	}
	function cancel_trash( )
	{
		$this->setRedirect( 'index.php?option=com_apdmccs' );
	}


	/**
	 * Disables the user account
	 */
	function block( )
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$db 			=& JFactory::getDBO();
		//$acl			=& JFactory::getACL();
		//$currentUser 	=& JFactory::getUser();

		$cid 	= JRequest::getVar( 'cid', array(), '', 'array' );
		$block  = $this->getTask() == 'block' ? 0 : 1;

		JArrayHelper::toInteger( $cid );

		
		foreach ($cid as $id)
		{
			$query = "UPDATE apdm_ccs SET ccs_activate=".$block." WHERE ccs_id=".$id;
			$db->setQuery($query);
			if ($db->query()){
				JAdministrator::HistoryUser(1, 'E', $id);
			}
			
		}	
		$msg = JText::_('UPDATE_ACTIVATION_OK');
		$this->setRedirect( 'index.php?option=com_apdmccs', $msg);
	}
	function export(){     
        include_once(JPATH_BASE .DS.'includes'.DS.'PHPExcel.php');
        require_once (JPATH_BASE .DS.'includes'.DS.'PHPExcel'.DS.'RichText.php');        
        require_once(JPATH_BASE .DS.'includes'.DS.'PHPExcel'.DS.'IOFactory.php');   
        require_once('includes/download.class.php');     
        $objPHPExcel = new PHPExcel();                               
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load(JPATH_COMPONENT.DS.'ccs_excel.xls');   
        global $mainframe;
             $query_exprot   = JRequest::getVar("query_exprot"); 
             $total          = JRequest::getVar("total_record");
             $limit          = $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
             $limitstart     = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
   		 	 $me			 	=& JFactory::getUser();
             $db             =& JFactory::getDBO();    
             $query = base64_decode($query_exprot);    
             jimport('joomla.html.pagination');
             $pagination = new JPagination( $total, $limitstart, $limit );
             $db->setQuery( $query, $pagination->limitstart, $pagination->limit );
             $rows = $db->loadObjectList();                   

             //for Execl
            $styleThinBlackBorderOutline = array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => 'FF000000'),
                    ),
                ),
            );
            $objPHPExcel->getActiveSheet()->setCellValue('A5', 'Username: '.$me->get('username'));   
            $objPHPExcel->getActiveSheet()->setCellValue('D5', 'Date Created: '.date('m/d/Y'));   
            $nRecord = count($rows);
            $objPHPExcel->getActiveSheet()->getStyle('A7:D'.$nRecord)->getAlignment()->setWrapText(true);
            if ($nRecord > 0){
                    $j=0;
                    $i = 7;     
					$number =1;   
                    foreach ($rows as $row){
                        $a = 'A'.$i;
                        $b='B'.$i;
                        $c='C'.$i;
                        $d = 'D'.$i;
						$e = 'E'.$i;
                        $activate = ($row->ccs_activate) ? 'Activate' : 'Non-Active';
                        $date_created = JHTML::_('date', $row->ccs_create, '%m/%d/%Y');
                        //set heigh or row 
                        $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(30);               
                        $objPHPExcel->getActiveSheet()->setCellValue($a, $number);
						$objPHPExcel->getActiveSheet()->setCellValue($b, $row->ccs_code);
                        $objPHPExcel->getActiveSheet()->setCellValue($c, $row->ccs_description);
                        $objPHPExcel->getActiveSheet()->setCellValue($d, $activate);
                        $objPHPExcel->getActiveSheet()->setCellValue($e, $date_created);
                        //set format
                        $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($c)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($d)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						 $objPHPExcel->getActiveSheet()->getStyle($e)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        
                        $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($c)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
                        $objPHPExcel->getActiveSheet()->getStyle($d)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					    $objPHPExcel->getActiveSheet()->getStyle($e)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                                                                                                                    
                        $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        $objPHPExcel->getActiveSheet()->getStyle($c)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        $objPHPExcel->getActiveSheet()->getStyle($d)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
						$objPHPExcel->getActiveSheet()->getStyle($e)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        
                        $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
						
                
                        if ($j%2==0) {
                            $objPHPExcel->getActiveSheet()->getStyle($a.':'.$e)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                            $objPHPExcel->getActiveSheet()->getStyle($a.':'.$e)->getFill()->getStartColor()->setRGB('EEEEEE');
                          
                        }
                       if ($j ==$nRecord-1){
                            $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $objPHPExcel->getActiveSheet()->getStyle($c)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $objPHPExcel->getActiveSheet()->getStyle($d)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
							$objPHPExcel->getActiveSheet()->getStyle($e)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    
                        }                 
                        $i++;
                        $j++;
						$number++;    
                    }
            }
            $path_export = JPATH_SITE.DS.'uploads'.DS.'export'.DS;           
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save($path_export.'APDM_CC_REPORT.xls');             
            $dFile=new DownloadFile($path_export,'APDM_CC_REPORT.xls');
            exit;     
	}

	/**
	 * Force log out a user
	 */
	
	function GetNumberOfPNs($ccs_id)
	{
		$db =& JFactory::getDBO();
		$query = " SELECT COUNT(pns_id) FROM apdm_pns WHERE ccs_id=".$ccs_id;
		$db->setQuery($query);
		$result = $db->loadResult();
		return $result;
	}
	function GetDefaultCode(){
		$db 	=& JFactory::getDBO();
		//get array code in table 
		$db->setQuery("SELECT ccs_code FROM apdm_ccs GROUP BY ccs_code");
		$arr_codes = array();
		$rows = $db->loadObjectList();
		if (count($rows) > 0){
			foreach ($rows as $row){
				$arr_codes[] = $row->ccs_code;
			}

		}
		
		$arr_char = array('A', 'A', 'A','B', 'B', 'B', 'C','C','C', 'D','D','D', 'E','E','E', 'F','F', 'F','G','G','G', 'H','H','H', 'I', 'I',  'I','J','J','J', 'K','K', 'K','M','M','M', 'N', 'N', 'N', 'O','O','O', 'P','P','P', 'Q','Q','Q', 'R','R', 'R','S','S','S', 'T','T','T', 'U','U','U', 'V','V', 'V','W','W','W', 'X','X','X', 'Y','Y','Y', 'Z','Z','Z');
		$arr_get = array_rand($arr_char, 3);
		$arr_result = array();
		foreach ($arr_get as $obj){
			$arr_result[] = $arr_char[$obj];
		}		
		$cc_code = implode("", $arr_result);
		//$cc_code = 'AAA';
		if (in_array($cc_code, $arr_codes)){
			$cc_code = CCsController::GetDefaultCode();
		}
		echo $cc_code;
		exit;
		
	}
    function downContent($file_name, $content){
            header('HTTP/1.1 200 OK');
            header('Status: 200 OK');
            header('Accept-Ranges: bytes');
            header('Content-Transfer-Encoding: Binary');
            header('Content-Type: application/force-download; charset=utf-8');

            header("Content-Type: application/ms-excel; charset=utf-8");    
            $header = "Content-Disposition: attachment; filename=\"";
            $header .= $file_name;
            $header .= "\"";        
            header($header);

            header("Content-Length: " . strlen($content));
            header("Content-Transfer-Encoding: binary");
            header('Pragma: private');
            header('Cache-control: private, must-revalidate');
            print($content);
        }
        function getcoordinator()
	{
		$db =& JFactory::getDBO();
                $ccs_code = JRequest::getVar('ccs_code');
                $ccs_coordinator = 0;
                $query = " SELECT ccs_coordinator FROM apdm_ccs WHERE ccs_code='".$ccs_code."'";
		$db->setQuery($query);
                $ccs_coordinator = $db->loadResult();
		echo $ccs_coordinator;
                exit;
	}        
                    
}
