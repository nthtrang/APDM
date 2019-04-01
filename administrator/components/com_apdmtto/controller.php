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
require_once('includes/download.class.php');
require_once('includes/zip.class.php');
require_once('includes/system_defines.php');
ini_set('display_errors',0);

/**
 * Users Component Controller
 *
 * @package		Joomla
 * @subpackage	Users
 * @since 1.5
 */
class TToController extends JController
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
		$this->registerTask( 'addtto'  , 	'display'  );
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
			case 'addtto':
                        {
				JRequest::setVar( 'layout', 'form'  );
				JRequest::setVar( 'view', 'itto' );
				JRequest::setVar( 'edit', false );                                
                        } break;
			
			case 'edittto'    :
			{				
				JRequest::setVar( 'layout', 'formedit'  );
				JRequest::setVar( 'view', 'itto' );
				JRequest::setVar( 'edit', true );
			} break;
			
			case 'detailtto':{
				JRequest::setVar( 'layout', 'view'  );
				JRequest::setVar( 'view', 'itto' );
				JRequest::setVar( 'edit', true );
			}
			break;
			 
                default :
                                JRequest::setVar( 'layout', 'default'  );
				JRequest::setVar( 'view', 'tto' );
		}

		parent::display();
	}
        function get_tto_code_default() {
                $db = & JFactory::getDBO();
                $tto_type = JRequest::getVar('tto_type');

                $query = "SELECT count(*)  FROM apdm_pns_tto  WHERE tto_type = '" . $tto_type . "' and date(tto_created) = CURDATE()";
                $db->setQuery($query);
               $tto_latest = $db->loadResult();
               
                $next_tto_code = (int) $tto_latest;
                $next_tto_code++;
                $number = strlen($next_tto_code);
                switch ($number) {
                        case '1':
                                $new_tto_code = '0' . $next_tto_code;
                                break;
                        case '2':
                                $new_tto_code = $next_tto_code;
                                break;
                       
                        default:
                                $new_tto_code = $next_tto_code;
                                break;
                }
                if($tto_type==1)
                        $pre = "T";
                elseif($tto_type==2)
                        $pre = "TT";                
                echo $pre.date('ymd').'-'.$new_tto_code;
                exit;
        }
        /*
         * Save new stock TTO
         */
        function save_tto() {
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $datenow = & JFactory::getDate();
                $post = JRequest::get('post');   
                $tto_code = $post['tto_code'];
                $due_date = new DateTime($post['tto_due_date']);                
                $tto_due_date = $due_date->format('Y-m-d');                 				
                $tto_state = "Create"; //Create Using Done 				
               
                //check exist first
                $db->setQuery("select count(*) from apdm_pns_tto where tto_code = '" . $tto_code."'");
                $check_exist = $db->loadResult();
                if ($check_exist!=0) {    
                        $msg = "The Tool Number already exist!";
                        $this->setRedirect('index.php?option=com_apdmtto&task=addtto', $msg);
                        return;
                }                                        
                $return = JRequest::getVar('return');
                $db->setQuery("INSERT INTO apdm_pns_tto (tto_code,tto_wo_id,tto_due_date,tto_state,tto_description,tto_created,tto_create_by,tto_type) VALUES ('" . $tto_code . "','".$post['tto_wo_id']."','".$tto_due_date."','".$tto_state."', '" . strtoupper($post['tto_description']) . "','" . $datenow->toMySQL() . "', '" . $me->get('id') . "',1)");
                $db->query();
				
                //getLast ITO ID
                $tto_id = $db->insertid();
                if($tto_id)
                {					
                        $msg = "Successfully Saved Tool";
                        return $this->setRedirect('index.php?option=com_apdmtto&task=tto_detail&id='.$tto_id, $msg);                
                }
                else {
                        $msg = "Saved Tool Fail";
                        return $this->setRedirect('index.php?option=com_apdmtto&task=addtto', $msg);                
                }
        }        		
		/*
         * Detail STO 
         */        
        function tto_detail() {
                JRequest::setVar('layout', 'view');
                JRequest::setVar('view', 'itto');
                parent::display();
        }  
        function GetSupplierName($supplier_id) {
                $db = & JFactory::getDBO();
                $rows = array();
                $query = "SELECT s.info_name FROM  apdm_supplier_info AS s WHERE  s.info_deleted=0 AND  s.info_activate=1  AND  s.info_id =" . $supplier_id;
                $db->setQuery($query);                
                $info_name = $db->loadResult();
                echo $info_name;
        }
        function ito_detail_pns() {
                JRequest::setVar('layout', 'view_detail_pns');
                JRequest::setVar('view', 'ito');
                parent::display();
        }  
		 //for sto
        function get_list_pns_tto() {
                JRequest::setVar('layout', 'default');
                JRequest::setVar('view', 'getpnsfortto');
                parent::display();
        }
		 function GetLocationCodeList() {
                $db = & JFactory::getDBO();
                $rows = array();
                $query = "SELECT pns_location_id, location_code FROM apdm_pns_location WHERE  location_status =1";
                $db->setQuery($query);
                return $result = $db->loadObjectList();               
        }
		function GetCodeLocation($pns_location_id) {
                $db = & JFactory::getDBO();                
                $db->setQuery("SELECT location_code FROM apdm_pns_location WHERE pns_location_id=" . $pns_location_id);                
                return $db->loadResult();
        }		
		 function GetTtoFrommPns($pns_id,$tto_id) {
                $db = & JFactory::getDBO();
                $rows = array();
                //$query = "SELECT fk.id  FROM apdm_pns_sto AS sto inner JOIN apdm_pns_sto_fk fk on sto.pns_sto_id = fk.sto_id inner join apdm_pns AS p on p.pns_id = fk.pns_id where fk.pns_id=".$pns_id;
                $query = "SELECT pns_id,id FROM apdm_pns_tto_fk WHERE pns_id = ".$pns_id ." and tto_id = ".$tto_id;

                $db->setQuery($query);
                $result = $db->loadObjectList();
                if (count($result) > 0) {
                        foreach ($result as $obj) {
                                $rows[] = $obj->id;
                        }
                }
                return $rows;
        }        
		function GetImagePreview($pns_id)
        {
                $db = & JFactory::getDBO();
                $db->setQuery("select image_file from apdm_pns_image where pns_id ='".$pns_id."' limit 1");
                return $db->loadResult();                
        }
		function GetManufacture($pns_id,$type=4) {
                $db = & JFactory::getDBO();
                $rows = array();
                $query = "SELECT p.supplier_id, p.supplier_info, s.info_name FROM apdm_pns_supplier AS p LEFT JOIN apdm_supplier_info AS s ON s.info_id = p.supplier_id WHERE  s.info_deleted=0 AND  s.info_activate=1 AND p.type_id = ".$type." AND  p.pns_id =" . $pns_id;

                $db->setQuery($query);
                $result = $db->loadObjectList();
                if (count($result) > 0) {
                        foreach ($result as $obj) {
                                $rows[] = array('mf' => $obj->info_name, 'v_mf' => $obj->supplier_info);
                        }
                }
                return $rows;
        }
    function GetChildParentNumber($pns_id) {
        $db = & JFactory::getDBO();
        $result = 0;
        $query = " SELECT COUNT(pr.id) FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns AS p ON p.pns_id= pr.pns_id INNER JOIN apdm_ccs as c ON c.ccs_code = p.ccs_code WHERE p.pns_deleted = 0 AND c.ccs_deleted = 0 AND c.ccs_activate =1 AND pns_parent=" . $pns_id;
        $db->setQuery($query);
        $result = $db->loadResult();
        return $result;
    }
    function GetECO($eco_id) {
        $db = & JFactory::getDBO();
        $db->setQuery("SELECT eco_name FROM apdm_eco WHERE eco_id=" . $eco_id);
        return $db->loadResult();
    }

        function getLocationPartStatePn($partState,$pnsId)
        {
                $db = & JFactory::getDBO();
                $rows = array();
                $query = "select fk.pns_id,fk.sto_id ,sto.sto_type,fk.partstate,fk.location,loc.location_code ".
                        " from apdm_pns_sto_fk fk  ".
                        " inner join apdm_pns_location loc on loc.pns_location_id=location ".
                        " inner join apdm_pns_sto sto on fk.sto_id = sto.pns_sto_id ".
                        " where fk.pns_id = ".$pnsId." and sto.sto_type=1 and fk.partstate = '".$partState."' group by loc.location_code";
                $db->setQuery($query);
                $result = $db->loadObjectList();
                if (count($result) > 0) {
                        $locationArr=array();
                        foreach ($result as $obj) {
                                if($obj->sto_type==1 )
                                {
                                    //$array_partstate[$obj->partstate] = $obj->partstate;                                
                                    $locationArr[] = JHTML::_('select.option', $obj->location, $obj->location_code , 'value', 'text');                                                                          
                                }
                        }
                }
                return $locationArr;
        }		
        function ito_detail_support_doc()
        {
                JRequest::setVar('layout', 'view_detail_doc');
                JRequest::setVar('view', 'ito');
                parent::display();
        }
                /**
         * @desc Read file size
         */
        function readfilesizeSto($folder_sto, $filename,$type) {
                $path_so = JPATH_SITE . DS . 'uploads' . DS . 'sto' . DS;
                $filesize = '';               
                $path_so .= $folder_sto . DS . $type . DS;
                if (file_exists($path_so . $filename)) {
                        $filesize = ceil(filesize($path_so . $filename) / 1000);
                } else {
                        $filesize = 0;
                }
                return $filesize;
        }      
        
        function get_owner_confirm_tto()
        {
                JRequest::setVar('layout', 'inform');
                JRequest::setVar('view', 'userinform');
                parent::display();
        }
        function ajax_checkownertto()
        {
                $db = & JFactory::getDBO();
                $datenow = & JFactory::getDate();
                $tto_id = JRequest::getVar('tto_id');
                $tto_type_inout = JRequest::getVar('tto_type_inout');
                $password =  JRequest::getVar('passwd', '', 'post', 'string', JREQUEST_ALLOWRAW);
                $username = JRequest::getVar('username', '', 'method', 'username');
                $query = "select user_id from apdm_users where user_password = md5('".$password."') and username='".$username."'";
                $db->setQuery($query);
                $userId = $db->loadResult();
                $db->setQuery("SELECT * from apdm_pns_tto where pns_tto_id=".$tto_id);
                $sto_row =  $db->loadObject();    
                
                if($userId)
                {   
                        if($sto_row->tto_state=="Create" && $tto_type_inout = 2)
                        {
                                $db->setQuery("update apdm_pns_tto set tto_owner_out = '".$userId."',tto_state = 'Using',tto_owner_out_confirm_date='" . $datenow->toMySQL() . "' , tto_owner_out_confirm ='1' WHERE  pns_tto_id = ".$tto_id);                                                        
                                $db->query();     
                        }
                        if($sto_row->tto_state=="Using" && $tto_type_inout = 1)
                        {
                                $db->setQuery("update apdm_pns_tto set tto_owner_in = '".$userId."',tto_state = 'Done',tto_completed_date='" . $datenow->toMySQL() . "' ,tto_owner_in_confirm_date='" . $datenow->toMySQL() . "' , tto_owner_in_confirm ='1' WHERE  pns_tto_id = ".$tto_id);                        
                                $db->query();  
                        }                        
                        echo 1;
                }
                else
                {
                        echo 0;
                }
                exit;
        }
        
        function save_edittto() {
                global $mainframe;
                // Initialize some variables                                  
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $datenow = & JFactory::getDate();
                $post = JRequest::get('post');
                $due_date = new DateTime($post['tto_due_date']);
                $tto_due_date = $due_date->format('Y-m-d');

                $db->setQuery("update apdm_pns_tto set tto_description='" . strtoupper($post['tto_description']) . "',tto_due_date='".$tto_due_date."'  WHERE  pns_tto_id = '".$post['pns_tto_id']."'");
                $db->query();
                $msg = "Successfully Saved Update Tool";
                return $this->setRedirect('index.php?option=com_apdmtto&task=tto_detail&id='.$post['pns_tto_id'], $msg);
        }
        function save_editeto() {
                global $mainframe;
                // Initialize some variables                                  
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $datenow = & JFactory::getDate();
                $post = JRequest::get('post');   
                $sto_code = $post['sto_code'];
                $ito_id = $post['pns_sto_id'];                
                                            
                $return = JRequest::getVar('return');
                //get so info
                $db->setQuery("SELECT * from apdm_pns_sto where pns_sto_id=".$post['pns_sto_id']);
                $sto_row =  $db->loadObject();    
                
               
                if($sto_row->sto_isdelivery_good)
                {
                    $db->setQuery("update apdm_pns_sto_delivery set delivery_method='".$post['sto_delivery_method']."',delivery_shipping_name ='".$post['sto_delivery_shipping_name']."', delivery_shipping_company = '".$post['sto_delivery_shipping_company']."',delivery_shipping_street='" . $post['sto_delivery_shipping_street'] . "' ,delivery_shipping_zipcode='" . $post['sto_delivery_shipping_zipcode'] . "',delivery_shipping_phone='".$post['sto_delivery_shipping_phone']."',delivery_billing_name='".$post['sto_delivery_billing_name']."',delivery_billing_company='".$post['sto_delivery_billing_company']."',delivery_billing_street='".$post['sto_delivery_billing_street']."',delivery_billing_zipcode='".$post['sto_delivery_billing_zipcode']."',delivery_billing_phone='".$post['sto_delivery_billing_phone']."'  WHERE  sto_id = '".$post['pns_sto_id']."'");                    
                    $db->query();
                }        
                $db->setQuery("update apdm_pns_sto set sto_wo_id ='".$post['sto_wo_id']."', sto_description='" . strtoupper($post['sto_description']) . "'  WHERE  pns_sto_id = '".$post['pns_sto_id']."'");
                $db->query();
                //upload file
                            
                //Save upload new                
                $path_upload = JPATH_SITE . DS . 'uploads' . DS . 'sto' ;
                $stoNumber = $folder = $sto_row->sto_code;                                 
               //upload new images
                $path_so_images = $path_upload  .DS. $folder . DS .'images'. DS;
                $upload = new upload($_FILES['']);
                $upload->r_mkdir($path_so_images, 0777);
                $arr_error_upload_image = array();
                $arr_image_upload = array();
                
                for ($i = 1; $i <= 20; $i++) {                        
                        if ($_FILES['pns_image' . $i]['size'] > 0) {
                            if($_FILES['pns_image' . $i]['size']<20000000)
                            {
                                  if($sto_row->sto_isdelivery_good && $sto_row->sto_state=="InTransit" && !$sto_row->sto_owner_confirm)
                                  {
                                        $msg = JText::_('ETO must confirm before upload DELIVERY NOTE');
                                        return $this->setRedirect('index.php?option=com_apdmsto&task=eto_detail&id='.$ito_id, $msg);                                        
                                  }
                                $file_name = explode(".", $_FILES['pns_image' . $i]['name']);                                    
                                if($sto_row->sto_isdelivery_good==1 && $sto_row->sto_state=="InTransit" && $sto_row->sto_owner_confirm && $file_name[0]!= "DELIVERY NOTE")
                                {
                                        $msg = JText::_('Please upload file name is: DELIVERY NOTE');
                                        return $this->setRedirect('index.php?option=com_apdmsto&task=editeto&id='.$ito_id, $msg);                                        
                                }
                                if (file_exists($path_so_images . $_FILES['pns_image' . $i]['name'])) {

                                        @unlink($path_so_images .  $_FILES['pns_image' . $i]['name']);
                                }
                                if (!move_uploaded_file($_FILES['pns_image' . $i]['tmp_name'], $path_so_images . $_FILES['pns_image' . $i]['name'])) {
                                    $arr_error_upload_image[] = $_FILES['pns_image' . $i]['name'];
                                } else {
                                    $arr_image_upload[] = $_FILES['pns_image' . $i]['name'];
                                }
                            }
                            else
                            {
                                $msg = JText::_('Please upload file less than 20MB.');
                                return $this->setRedirect('index.php?option=com_apdmsto&task=editeto&id='.$ito_id, $msg);
                            }
                        }
                }
                                
                if (count($arr_image_upload) > 0) {
                        foreach ($arr_image_upload as $file) {
                                 $db->setQuery("DELETE FROM apdm_pns_sto_files where sto_id = " . $ito_id);
                                 $db->query();
                                 $db->setQuery("INSERT INTO apdm_pns_sto_files (sto_id, file_name,file_type, sto_file_created, sto_file_created_by) VALUES (" . $ito_id . ", '" . $file . "',2, '" . $datenow->toMySQL() . "', " . $me->get('id') . " ) ");                                                                         
                                 $db->query();
                                 if( $sto_row->sto_state=="InTransit" && $sto_row->sto_owner_confirm)
                                 {
                                        $db->setQuery("update apdm_pns_sto set sto_state = 'Done',sto_completed_date= '" . $datenow->toMySQL() . "' WHERE  pns_sto_id = ".$ito_id);
                                        $db->query();  
                                 }
                        }
                }                                     
                $msg = "Successfully Saved Update ETO";
                return $this->setRedirect('index.php?option=com_apdmsto&task=eto_detail&id='.$post['pns_sto_id'], $msg);                
        }        
        function save_doc_sto()
        {
                global $mainframe;
                // Initialize some variables
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();                
                $datenow = & JFactory::getDate();        
                $post = JRequest::get('post');   
                $sto_code = $post['sto_code'];
                $ito_id = $post['sto_id'];      
                 
                //get so info
                $db->setQuery("SELECT * from apdm_pns_sto where pns_sto_id=".$ito_id);
                $sto_row =  $db->loadObject();                
                //Save upload new                
                $path_upload = JPATH_SITE . DS . 'uploads' . DS . 'sto' ;
                $stoNumber = $folder = $sto_row->sto_code;
                  

                $path_so_zips = $path_upload  .DS. $folder . DS .'zips'. DS;
                $upload = new upload($_FILES['']);
                $upload->r_mkdir($path_so_zips, 0777);                        
                $arr_file_upload = array();
                $arr_error_upload_zips = array();
                for ($i = 1; $i <= 20; $i++) {					
                        if ($_FILES['pns_zip' . $i]['size'] > 0) {
								if($_FILES['pns_zip' . $i]['size']<20000000)
								{
									if (!move_uploaded_file($_FILES['pns_zip' . $i]['tmp_name'], $path_so_zips . $_FILES['pns_zip' . $i]['name'])) {
											$arr_error_upload_zips[] = $_FILES['pns_zip' . $i]['name'];
									} else {
											$arr_file_upload[] = $_FILES['pns_zip' . $i]['name'];
									}
								}
								else
								{        
									$msg = JText::_('Please upload file ZIP less than 20MB.');
								        return $this->setRedirect('index.php?option=com_apdmpns&task=so_detail_support_doc&id='.$ito_id, $msg);    
								}
                        }
                        
                }
                if (count($arr_file_upload) > 0) {                        
                        foreach ($arr_file_upload as $file) {
                                 $db->setQuery("INSERT INTO apdm_pns_sto_files (sto_id, file_name,file_type, sto_file_created, sto_file_created_by) VALUES (" . $ito_id . ", '" . $file . "',0, '" . $datenow->toMySQL() . "', " . $me->get('id') . " ) ");                                        
                                 $db->query();
                        }
                }
               //upload new images
                $path_so_images = $path_upload  .DS. $folder . DS .'images'. DS;
                $upload = new upload($_FILES['']);
                $upload->r_mkdir($path_so_images, 0777);
                $arr_error_upload_image = array();
                $arr_image_upload = array();
                for ($i = 1; $i <= 20; $i++) {
                        if ($_FILES['pns_image' . $i]['size'] > 0) {
                                $imge = new upload($_FILES['pns_image' . $i]);
                                $imge->file_new_name_body = $stoNumber . "_" . time()."_".$i;    
                                if (file_exists($path_so_images . $imge->file_new_name_body . "." . $imge->file_src_name_ext)) {

                                        @unlink($path_so_images .  $imge->file_new_name_body . "." . $imge->file_src_name_ext);
                                }
                                if ($imge->uploaded) {
                                        $imge->Process($path_so_images);
                                        if ($imge->processed) {
                                                $arr_image_upload[] = $imge->file_dst_name;
                                        } else {
                                                $arr_error_upload_image[] = $_FILES['pns_imge' . $i]['name'];
                                        }
                                }
                        }
                }
                if (count($arr_image_upload) > 0) {
                        foreach ($arr_image_upload as $file) {
                                 $db->setQuery("INSERT INTO apdm_pns_sto_files (sto_id, file_name,file_type, sto_file_created, sto_file_created_by) VALUES (" . $ito_id . ", '" . $file . "',2, '" . $datenow->toMySQL() . "', " . $me->get('id') . " ) ");                                        
                                 $db->query();
                        }
                }        

                //upload new pdf
                $path_so_pdfs = $path_upload  .DS. $folder . DS .'pdfs'. DS;
                $upload = new upload($_FILES['']);
                $upload->r_mkdir($path_so_pdfs, 0777);
                $arr_error_upload_pdf = array();
                $arr_pdf_upload = array();
                for ($i = 1; $i <= 20; $i++) {
                        if ($_FILES['pns_pdf' . $i]['size'] > 0) {
								if($_FILES['pns_pdf' . $i]['size']<20000000)
								{
									$imge = new upload($_FILES['pns_pdf' . $i]);
									$imge->file_new_name_body = $stoNumber . "_" . time()."_".$i;

									if (file_exists($path_so_pdfs . $imge->file_new_name_body . "." . $imge->file_src_name_ext)) {

											@unlink($path_so_pdfs . $imge->file_new_name_body . "." . $imge->file_src_name_ext);
									}
									if ($imge->uploaded) {
											$imge->Process($path_so_pdfs);
											if ($imge->processed) {
													$arr_pdf_upload[] = $imge->file_dst_name;
											} else {
													$arr_error_upload_pdf[] = $_FILES['pns_pdf' . $i]['name'];
											}
									}
								}
								else
								{
										$msg = JText::_('Please upload file PDF less than 20MB.');
										return $this->setRedirect('index.php?option=com_apdmpns&task=so_detail_support_doc&id='.$ito_id, $msg);
								}
                        }
                        
                }
                if (count($arr_pdf_upload) > 0) {
                        foreach ($arr_pdf_upload as $file) {
                                $db->setQuery("INSERT INTO apdm_pns_sto_files (sto_id, file_name,file_type, sto_file_created, sto_file_created_by) VALUES (" . $ito_id . ", '" . $file . "',1, '" . $datenow->toMySQL() . "', " . $me->get('id') . " ) ");                                        
                                $db->query();
                        }
                }     
                $msg = JText::_('Successfully Saved ITO Supporting Doc');
                $return = JRequest::getVar('return');
               
                if ($return) {
                       return $this->setRedirect('index.php?option=com_apdmsto&task=ito_detail_support_doc&id='.$ito_id, $msg);
                } else {
                       return $this->setRedirect('index.php?option=com_apdmsto&task=ito_detail&id=' . $ito_id, $msg);
                }                
                                        
        }
    function ajax_add_pns_tto_old() {
        $db = & JFactory::getDBO();
        $pns = JRequest::getVar('cid', array(), '', 'array');
        $tto_id = JRequest::getVar('tto_id');
        $tto_type_inout = JRequest::getVar('tto_type_inout'); //1 IN 2 OUT
        //innsert to FK table
        foreach($pns as $pn_id)
        {
            $location="";
            $partstate="";
            $db->setQuery("select tto_type from apdm_pns_sto where pns_sto_id ='".$tto_id."'");
            $sto_type = $db->loadResult();
            if($sto_type==3)//tempp
            {
                $db->setQuery("SELECT stofk.* from apdm_pns_tto_fk ttofk inner join apdm_pns_tto tto on ttofk.sto_id = tto.pns_tto_id WHERE ttofk.pns_id= '".$pn_id."' and tto.tto_type = 1  AND ttofk.tto_id != '".$tto_id."' order by stofk.id desc limit 1");
                $row = $db->loadObject();
                $location = $row->location;
                $partState = $row->partstate;
            }
            $db->setQuery("INSERT INTO apdm_pns_tto_fk (pns_id,tto_id,location,partstate,tto_type_inout) VALUES ( '" . $pn_id . "','" . $tto_id . "','" . $location . "','" . $partState . "','".$tto_type_inout."')");
            $db->query();
        }
        return $msg = JText::_('Have add Tool successfull.');
    }
    function ajax_add_pns_tto() {
        $db = & JFactory::getDBO();
        $fks= JRequest::getVar('cid', array(), '', 'array');
        $tto_id = JRequest::getVar('tto_id');
        $tto_type_inout = JRequest::getVar('tto_type_inout'); //1 IN 2 OUT
        //innsert to FK table
        foreach($fks as $id)
        {
                $location="";
                $partstate="";
                $db->setQuery("SELECT stofk.* from apdm_pns_sto_fk stofk  inner join apdm_pns_sto sto on stofk.sto_id = sto.pns_sto_id WHERE stofk.id= '".$id."' and sto.sto_type = 1   order by stofk.id desc");
                $rows = $db->loadObjectList();
                 if (count($rows) > 0) {                        
                        foreach ($rows as $obj) {
                                $location = $obj->location;
                                $partState = $obj->partstate;
                                $pn_id =  $obj->pns_id;
                                $db->setQuery("INSERT INTO apdm_pns_tto_fk (pns_id,tto_id,location,partstate,tto_type_inout) VALUES ( '" . $pn_id . "','" . $tto_id . "','" . $location . "','" . $partState . "','".$tto_type_inout."')");
                                $db->query(); 
                        }
                 }
        }
        return $msg = JText::_('Have add Tool successfull.');
    }
    function ajax_add_pns_stos_movelocation() {
        $db = & JFactory::getDBO();
        $pns = JRequest::getVar('cid', array(), '', 'array');
        $stoId = JRequest::getVar('sto_id');
        $partStateArr   = array('OH-G','OH-D','IT-G','IT-D','OO','Prototype');
        //innsert to FK table
        foreach($pns as $pn_id)
        {
            $get_status = "select count(id) from apdm_pns_sto_fk where pns_id = '".$pn_id."' and sto_id = '".$stoId."'";
            $db->setQuery($get_status);
            $status = $db->loadResult();
            if($status)
            {
                return $msg = JText::_('The PN already add into MTO');
                die;
            }
            $query = "select partstate from apdm_pns_sto_fk where  pns_id = '".$pn_id."'  and partstate!= '' group by partstate";
            $db->setQuery($query);
            $resultPartstate = $db->loadObjectList();
            if (count($resultPartstate) > 0) {
                $array_loacation= array();
                foreach ($resultPartstate as $partState) {

                    //get total qty
                    $query = "select fk.pns_id,loc.location_code,fk.qty,fk.sto_id,fk.location ,sto.sto_type ".
                        "from apdm_pns_sto_fk fk ".
                        "inner join apdm_pns_location loc on fk.location=loc.pns_location_id ".
                        "inner join apdm_pns_sto sto on fk.sto_id = sto.pns_sto_id ".
                        "where fk.pns_id = ".$pn_id." and fk.partstate = '".$partState->partstate."' and sto.sto_type in (1,2)";

                    $db->setQuery($query);
                    $result = $db->loadObjectList();
                    if (count($result) > 0) {
                        $array_loacation=array();
                        foreach ($result as $obj) {
                            if($obj->sto_type==1 )
                                $array_loacation[$obj->location] = $array_loacation[$obj->location] + $obj->qty;
                            else
                                $array_loacation[$obj->location] =$array_loacation[$obj->location] - $obj->qty;

                        }

                    }
                    //get calculate move location
                    $query = "select loc.location_code,fk.qty,fk.sto_id ,sto.sto_type,fk.location,fk.location_from ".
                        "from apdm_pns_sto_fk fk ".
                        "inner join apdm_pns_location loc on fk.location_from=loc.pns_location_id ".
                        "inner join apdm_pns_sto sto on fk.sto_id = sto.pns_sto_id ".
                        "where fk.pns_id = ".$pn_id." and fk.partstate = '".$partState->partstate."' and sto.sto_type in (3)";
                    $db->setQuery($query);
                    $result = $db->loadObjectList();
                    if (count($result) > 0) {
                        //$array_loacation=array();
                        foreach ($result as $obj) {
                            $array_loacation[$obj->location_from] =$array_loacation[$obj->location_from] - $obj->qty;
                        }
                    }
                    //get calculate move location
                    /* $query = "select loc.location_code,fk.qty,fk.sto_id ,sto.sto_type,fk.location,fk.location_from  ".
                             "from apdm_pns_sto_fk fk ".
                             "inner join apdm_pns_location loc on fk.location=loc.pns_location_id ".
                             "inner join apdm_pns_sto sto on fk.sto_id = sto.pns_sto_id ".
                             "where fk.pns_id = ".$pn_id." and fk.partstate = '".$partState->partstate."' and sto.sto_type in (3)";
                     $db->setQuery($query);
                     $result = $db->loadObjectList();
                     if (count($result) > 0) {
                             //$array_loacation=array();
                             foreach ($result as $obj) {
                                     $array_loacation[$obj->location] =$array_loacation[$obj->location] + $obj->qty;
                             }
                     }       */
                    if(isset($array_loacation) && sizeof($array_loacation)>0)
                    {
                        foreach($array_loacation as $location=>$qty)
                        {
                            if($qty)
                            {
                                $db->setQuery("INSERT INTO apdm_pns_sto_fk (pns_id,sto_id,qty_from,location_from,partstate) VALUES ( '" . $pn_id . "','" . $stoId . "','" . $qty . "','" . $location . "','" . $partState->partstate . "')");
                                $db->query();
                            }

                        }
                    }
                    ///end calculate movelocation
                }
            }
        }
        return $msg = JText::_('Have add pns successfull.');
    }
    /*
        * save stock for STO/PN
        */
    function saveqtyStofk_movelocation() {
        $db = & JFactory::getDBO();
        $cid = JRequest::getVar('cid', array(), '', 'array');

        $fkid = JRequest::getVar('id');
        foreach ($cid as $pnsid) {
            $obj = explode("_", $pnsid);
            $pns=$obj[0];
            $ids = explode(",",$obj[1]);
            foreach ($ids as $id) {
                $stock = JRequest::getVar('qty_'. $pns .'_' . $id);
                $location = JRequest::getVar('location_' . $pns .'_' . $id);
                //get sto_type
                $db->setQuery("select fk.qty_from,fk.location_from,fk.id as id_from from  apdm_pns_sto_fk fk where fk.id =  ".$id);
                $fkFrom= $db->loadObject();
                if($fkFrom->qty_from < $stock)//validate stock input
                {
                    $msg = "The Destination Qty must less than Source Qty";
                    return $this->setRedirect('index.php?option=com_apdmpns&task=sto_detail_movelocation&id=' . $fkid, $msg);
                }
                if($stock && $location==0)
                {
                    $msg = "Must choose Destination Location and input Qty together";
                    return $this->setRedirect('index.php?option=com_apdmpns&task=sto_detail_movelocation&id=' . $fkid, $msg);
                }

                $db->setQuery("update apdm_pns_sto_fk set qty=" . $stock . ", location='" . $location . "' WHERE  id = " . $id);
                $db->query();
                //updatestock from
                // $db->setQuery("update apdm_pns_sto_fk set qty=" . $stock . ", location='" . $fkFrom->location_from . "' WHERE  id = " . $fkFrom->id_from);
                // $db->query();
            }
        }
        $msg = "Successfully Saved Part Number";
        $this->setRedirect('index.php?option=com_apdmsto&task=sto_detail_movelocation&id=' . $fkid, $msg);
    }
    /*
        * Remove PNS out of STO in STO management
        */
    function removeAllpnsttos() {
        $db = & JFactory::getDBO();
        $pnsfk = JRequest::getVar('cid', array(), '', 'array');
        $tto_id = JRequest::getVar('tto_id');
        foreach($pnsfk as $fk_ids){
            $obj = explode("_", $fk_ids);
            $pns=$obj[0];
            $ids = explode(",",$obj[1]);
            foreach ($ids as $fk_id)
            {
                $db->setQuery("DELETE FROM apdm_pns_tto_fk WHERE id = '" . $fk_id . "' AND tto_id = " . $tto_id . "");
                $db->query();
            }
        }
        $msg = JText::_('Have removed Tool successfull.');
        return $this->setRedirect('index.php?option=com_apdmtto&task=tto_detail&id=' . $tto_id, $msg);
    }
    /*
     * Remove PNS out of STO in STO management
     */
    function removeAllpnsstoLocation() {
        $db = & JFactory::getDBO();
        $pnsfk = JRequest::getVar('cid', array(), '', 'array');
        $sto_id = JRequest::getVar('sto_id');
        foreach($pnsfk as $fk_ids){
            $obj = explode("_", $fk_ids);
            $pns=$obj[0];
            $ids = explode(",",$obj[1]);
            foreach ($ids as $fk_id)
            {
                $db->setQuery("DELETE FROM apdm_pns_sto_fk WHERE id = '" . $fk_id . "' AND sto_id = " . $sto_id . "");
                $db->query();
            }
        }
        $msg = JText::_('Have removed Part successfull.');
        return $this->setRedirect('index.php?option=com_apdmsto&task=sto_detail_movelocation&id=' . $sto_id, $msg);
    }
    /*
           * save stock for STO/PN
           */
    function saveqtyTtofk() {
        $db = & JFactory::getDBO();
        $cid = JRequest::getVar('cid', array(), '', 'array');

        $fkid = JRequest::getVar('id');
        foreach ($cid as $pnsid) {
                $obj = explode("_", $pnsid);
                $pns=$obj[0];
                $ids = explode(",",$obj[1]);
                $currentOutStock = 0;
                foreach ($ids as $id) {
                    $stock = JRequest::getVar('qty_' . $pns . '_' . $id);
                    $location = JRequest::getVar('location_' . $pns . '_' . $id);
                    $partState = JRequest::getVar('partstate_' . $pns . '_' . $id);
                    $qtyRemain = CalculateInventoryLocationPartValue($pns, $location, $partState);
                    $db->setQuery("select sum(fk.qty) as total_qty from apdm_pns_tto tto inner join apdm_pns_tto_fk fk on tto.pns_tto_id = fk.tto_id where tto.tto_state != 'Done' and fk.pns_id = '" . $pns . "' and fk.partstate = '" . $partState . "' and fk.location = '" . $location . "' and fk.id != " . $id);                    
                    $qtyOutCheck = $db->loadResult();
                    $currentOutStock += $stock + $qtyOutCheck;
                    if ($currentOutStock > $qtyRemain) {
                        $msg = "Total Qty just input must less than $qtyRemain";
                        return $this->setRedirect('index.php?option=com_apdmtto&task=tto_detail&id=' . $fkid, $msg);
                    }
                    $db->setQuery("update apdm_pns_tto_fk set qty=" . $stock . ", location='" . $location . "', partstate='" . $partState . "' WHERE  id = " . $id);
                    $db->query();
                }
        }
        $db->setQuery("select tto_type from apdm_pns_tto where pns_tto_id ='".$fkid."'");
        $sto_type = $db->loadResult();
        $return = "tto_detail";
        if($sto_type==2)
                $return = "tto_detail";
        $msg = "Successfully Saved Part Number";
        $this->setRedirect('index.php?option=com_apdmtto&task='.$return.'&id=' . $fkid, $msg);
    }
    /*
           * Remove PNS out of STO in STO management
           */
    function removepnstto() {
        $db = & JFactory::getDBO();
        $pnsfk = JRequest::getVar('cid', array(), '', 'array');
        $tto_id = JRequest::getVar('tto_id');
        foreach($pnsfk as $fk_id)
        {
            $db->setQuery("DELETE FROM apdm_pns_tto_fk WHERE id = '" . $fk_id . "' AND tto_id = " . $tto_id . "");
            $db->query();
        }
        $msg = JText::_('Have removed Tool successfull.');
        return $this->setRedirect('index.php?option=com_apdmtto&task=tto_detail&id=' . $tto_id, $msg);
    }
    function removepnsstos_movelocation() {
        $db = & JFactory::getDBO();
        $pnsfk = JRequest::getVar('cid', array(), '', 'array');
        $sto_id = JRequest::getVar('sto_id');
        foreach($pnsfk as $fk_id)
        {
            $db->setQuery("DELETE FROM apdm_pns_sto_fk WHERE id = '" . $fk_id . "' AND sto_id = " . $sto_id . "");
            $db->query();
        }
        $msg = JText::_('Have removed successfull.');
        return $this->setRedirect('index.php?option=com_apdmsto&task=sto_detail_movelocation&id=' . $sto_id, $msg);
    }
    function ajax_getlocpn_partstate($pnsId,$fkId,$currentLoc,$partState)
    {
        //&partstate='+partState+'&pnsid='+pnsId+'&fkid'+fkId+'&currentloc='+currentLoc;

        $db = & JFactory::getDBO();
        $rows = array();
        $pnsId = JRequest::getVar('pnsid');
        $fkId = JRequest::getVar('fkid');
        $currentLoc = JRequest::getVar('currentloc');
        $partState = JRequest::getVar('partstate');
        $query = "select fk.pns_id,fk.sto_id ,sto.sto_type,fk.partstate,fk.location,loc.location_code ".
            " from apdm_pns_sto_fk fk  ".
            " inner join apdm_pns_location loc on loc.pns_location_id=location ".
            " inner join apdm_pns_sto sto on fk.sto_id = sto.pns_sto_id ".
            " where fk.pns_id = ".$pnsId." and sto.sto_type=1 and fk.partstate = '".$partState."'";
        $db->setQuery($query);
        $result = $db->loadObjectList();
        if (count($result) > 0) {
            $locationArr=array();
            foreach ($result as $obj) {
                if($obj->sto_type==1 )
                {
                    //$array_partstate[$obj->partstate] = $obj->partstate;
                    $locationArr[] = JHTML::_('select.option', $obj->location, $obj->location_code , 'value', 'text');
                }
            }
        }

        echo JHTML::_('select.genericlist',   $locationArr, 'location_'.$pnsId.'_'.$fkId, 'class="inputbox" size="1" ', 'value', 'text', $currentLoc);
        exit;
        //return $locationArr;
    }
    function move_location()
    {
        JRequest::setVar('layout', 'add_stom');
        JRequest::setVar('view', 'stos');
        parent::display();
    }
    function sto_detail_movelocation() {
        JRequest::setVar('layout', 'sto_detail_pns_movelocation');
        JRequest::setVar('view', 'stos');
        parent::display();
    }
    function removestos()
    {
        $db = & JFactory::getDBO();
        $cid = JRequest::getVar('cid', array(), '', 'array');
        JArrayHelper::toInteger($cid);
        if (count($cid) < 1) {
            JError::raiseError(500, JText::_('Select a STO to delete', true));
        }
        foreach ($cid as $id) {
            $db->setQuery("DELETE FROM apdm_pns_sto_fk WHERE sto_id = '" . $id . "'");
            $db->query();
            $db->setQuery("DELETE FROM apdm_pns_sto WHERE pns_sto_id = '" . $id . "'");
            $db->query();
        }
        $msg = JText::_('Have removed successfull.');
        return $this->setRedirect('index.php?option=com_apdmsto&task=sto', $msg);
    }
    function printttopdf()
    {
        JRequest::setVar('layout', 'view_detail_print');
        JRequest::setVar('view', 'itto');
        parent::display();
    }
    function getPoCoordinator()
    {
        $db = & JFactory::getDBO();
        $wo_id  = JRequest::getVar( 'wo_id');
        $db->setQuery("SELECT so.*,so.customer_id as ccs_so_code,ccs.ccs_coordinator,ccs.ccs_name,ccs.ccs_code from apdm_pns_so so inner join apdm_pns_wo wo on so.pns_so_id=wo.so_id left join apdm_ccs ccs on so.customer_id = ccs.ccs_code where wo.pns_wo_id=".$wo_id);
        $row =  $db->loadObject();
        $soNumber = $row->so_cuscode;
        if($row->ccs_code)
        {
            $soNumber = $row->ccs_code."-".$soNumber;
        }
        $result = $row->customer_id.'^'.$row->ccs_name.'^'.$row->pns_so_id.'^'.$soNumber;
        echo $result;
        exit;
    }
    /*
            * Save new stock ITO
            */
    function save_eto() {
        $db = & JFactory::getDBO();
        $me = & JFactory::getUser();
        $datenow = & JFactory::getDate();
        $post = JRequest::get('post');
        $sto_code = $post['sto_code'];
        //check exist first
        $db->setQuery("select count(*) from apdm_pns_sto where sto_code = '" . $sto_code."'");
        $check_exist = $db->loadResult();
        if ($check_exist!=0) {
            $msg = "The ETO already exist!";
            $this->setRedirect('index.php?option=com_apdmsto&task=addeto', $msg);
            return;
        }
        $return = JRequest::getVar('return');
        $sto_state="Create";
        if($post['sto_isdelivery_good'])
            $sto_state = "InTransit";
        $db->setQuery("INSERT INTO apdm_pns_sto (sto_code,sto_description,sto_state,sto_created,sto_create_by,sto_type,sto_stocker,sto_wo_id,sto_isdelivery_good) VALUES ('" . $sto_code . "', '" . strtoupper($post['sto_description']) . "', '" . $sto_state . "', '" . $datenow->toMySQL() . "', '" . $me->get('id') . "',2,'".$me->get('id')."','".$post['sto_wo_id']."','".$post['sto_isdelivery_good']."')");
        $db->query();

        //getLast ETO ID
        $eto_id = $db->insertid();
        if($eto_id)
        {
             if($post['sto_isdelivery_good']==1)
             {
                      $db->setQuery("INSERT INTO apdm_pns_sto_delivery (sto_id,delivery_method,delivery_shipping_name,delivery_shipping_company,delivery_shipping_street,delivery_shipping_zipcode,delivery_shipping_phone,delivery_billing_name,delivery_billing_company,delivery_billing_street,delivery_billing_zipcode,delivery_billing_phone) VALUES ('" . $eto_id . "', '" . $post['sto_delivery_method'] . "', '" . $post['sto_delivery_shipping_name'] . "', '" . $post['sto_delivery_shipping_company'] . "', '" . $post['sto_delivery_shipping_street'] . "','".$post['sto_delivery_shipping_zipcode']."','".$post['sto_delivery_shipping_phone']."','".$post['sto_delivery_billing_name']."','".$post['sto_delivery_billing_company']."','".$post['sto_delivery_billing_street']."','".$post['sto_delivery_billing_zipcode']."','".$post['sto_delivery_billing_phone']."')");
                      $db->query();
             }

            $path_upload = JPATH_SITE . DS . 'uploads' . DS . 'sto' . DS . $post['sto_code'];            
            //for upload file image            
            $path_so_images = $path_upload  .DS.'images'. DS;
            $upload = new upload($_FILES['']);
            $upload->r_mkdir($path_so_images, 0777);
            $arr_error_upload_image = array();
            $arr_image_upload = array();
            for ($i = 1; $i <= 20; $i++) {
                 if ($_FILES['pns_image' . $i]['size'] > 0) {
                            if($_FILES['pns_image' . $i]['size']<20000000)
                            {                              
                                if (file_exists($path_so_images . $_FILES['pns_image' . $i]['name'])) {

                                        @unlink($path_so_images .  $_FILES['pns_image' . $i]['name']);
                                }
                                if (!move_uploaded_file($_FILES['pns_image' . $i]['tmp_name'], $path_so_images . $_FILES['pns_image' . $i]['name'])) {
                                    $arr_error_upload_image[] = $_FILES['pns_image' . $i]['name'];
                                } else {
                                    $arr_image_upload[] = $_FILES['pns_image' . $i]['name'];
                                }
                            }
                            else
                            {
                                $msg = JText::_('Please upload file less than 20MB.');
                                return $this->setRedirect('index.php?option=com_apdmsto&task=editito&id='.$ito_id, $msg);
                            }
                        }
            }
            if (count($arr_image_upload) > 0) {
                foreach ($arr_image_upload as $file) {
                    $db->setQuery("INSERT INTO apdm_pns_sto_files (sto_id, file_name,file_type, sto_file_created, sto_file_created_by) VALUES (" . $eto_id . ", '" . $file . "',2, '" . $datenow->toMySQL() . "', " . $me->get('id') . " ) ");
                    $db->query();
                }
            }
        }//for save database of pns

        $msg = "Successfully Saved ETO";
        return $this->setRedirect('index.php?option=com_apdmsto&task=eto_detail&id='.$eto_id, $msg);
    }
    /*
         * Detail ETO
         */
    function eto_detail() {
        JRequest::setVar('layout', 'view');
        JRequest::setVar('view', 'eto');
        parent::display();
    }
    function getPartStatePn($partState,$pns_id)
    {
        $db = & JFactory::getDBO();
        $rows = array();
        $query = "select fk.pns_id,fk.sto_id ,sto.sto_type,fk.partstate ".
            " from apdm_pns_sto_fk fk  ".
            "inner join apdm_pns_sto sto on fk.sto_id = sto.pns_sto_id ".
            " where fk.pns_id = ".$pns_id." and sto.sto_type=1 and fk.partstate != '' group by fk.partstate ";
        $db->setQuery($query);
        $result = $db->loadObjectList();
        if (count($result) > 0) {
            $partStateArr=array();
            foreach ($result as $obj) {
                if($obj->sto_type==1 )
                {
                    //$array_partstate[$obj->partstate] = $obj->partstate;
                    $partStateArr[] = JHTML::_('select.option', $obj->partstate, strtoupper($obj->partstate) , 'value', 'text');
                }
            }
        }

        return $partStateArr;
    }
    function printetopdf()
    {
        JRequest::setVar('layout', 'view_detail_print');
        JRequest::setVar('view', 'eto');
        parent::display();
    }
    
    function printetoDelivery()
    {
        JRequest::setVar('layout', 'view_delivery_print');
        JRequest::setVar('view', 'eto');
        parent::display();
    }
    /*
         * Remove STO
         */
        function deletetto() {
                $db = & JFactory::getDBO();                
                $tto_id = JRequest::getVar('tto_id');
                $db->setQuery("DELETE FROM apdm_pns_tto_fk WHERE tto_id = '" . $tto_id . "'");
                $db->query();
                $db->setQuery("DELETE FROM apdm_pns_tto WHERE pns_tto_id = '" . $tto_id . "'");
                $db->query();
                $msg = JText::_('Have removed successfull.');
                return $this->setRedirect('index.php?option=com_apdmtto&task=tto', $msg);
        }   
        
/**
         * @desc  Remove file cads
         */
        function remove_doc_sto() {
                $db = & JFactory::getDBO();
                $id = JRequest::getVar('id');
                $sto_id = JRequest::getVar('sto_id');
                $type_of_doc = JRequest::getVar('type');
                $task_back = JRequest::getVar('back');
                //unlink first
                //get name file cad
                $query = "SELECT img.sto_id,img.file_name,sto.pns_sto_id,sto.sto_code FROM apdm_pns_sto_files img inner join apdm_pns_sto sto on img.sto_id= sto.pns_sto_id WHERE img.id=" . $id;
                $db->setQuery($query);
                $row = $db->loadObject();                 
                $path_upload = JPATH_SITE . DS . 'uploads' . DS . 'sto' ;
                $folder = $row->sto_code;
                $path_so_images = $path_upload  .DS. $folder . DS . $type_of_doc . DS;                                 
                $file_name = $row->file_name;
                //get folder file cad          
                $handle = new upload($path_so_images . $file_name);
                $handle->file_dst_pathname = $path_so_images . $file_name;
                $handle->clean();                               
                
                $db->setQuery("DELETE FROM apdm_pns_sto_files WHERE id=" . $id);
                $db->query();
                $msg = JText::_('Have successfuly delete image file');
                $this->setRedirect('index.php?option=com_apdmsto&task='.$task_back.'&id=' . $sto_id, $msg);
        }              

        function download_all_doc_sto() {
                global $dirarray, $conf, $dirsize;

                //$conf['dir'] = "zipfiles";
                $conf['dir'] = "../uploads/pns/cads/PNsZip";
                $db = & JFactory::getDBO();
                $sto_id = JRequest::getVar('sto_id');
                $type_of_doc = JRequest::getVar('type');
                $doc_type = 0;
                if($type_of_doc=='images')
                        $doc_type =2;
                elseif($type_of_doc=='pdfs')
                        $doc_type = 1;
                $db->setQuery("SELECT * from apdm_pns_sto where pns_sto_id=".$sto_id);
                $so_row =  $db->loadObject();           
                //Save upload new                
                $path_upload = JPATH_SITE . DS . 'uploads' . DS . 'sto' ;
                $folder = $so_row->sto_code;
                $path_sto_images = $path_upload  .DS. $folder . DS .$type_of_doc. DS;                
              
                               
                //getall images belong PN                
                $query = "SELECT img.sto_id,img.file_name,sto.pns_sto_id,sto.sto_code FROM apdm_pns_sto_files img inner join apdm_pns_sto sto on img.sto_id= sto.pns_sto_id WHERE img.file_type = '".$doc_type."' and img.sto_id=" . $sto_id;                
                $db->setQuery($query);                
                $rows = $db->loadObjectList();
                $arrImgs = array();
                if (count($rows) > 0) {
                        foreach ($rows as $row) {
                                $arrImgs[] = $row->file_name;
                        }
                }    
                $zdir[] = $path_sto_images;                               
                $dirarray = array();
                $dirsize = 0;
                $zdirsize = 0;
                for ($i = 0; $i < count($zdir); $i++) {
                     
                        $ffile = $zdir[$i];
                        if (is_dir($ffile)) {
                                getdir($ffile);
                        } else {

                                if ($fsize = @filesize($ffile))
                                        $zdirsize+=$fsize;
                        }
                }

                $zdirsize+=$dirsize;

                for ($i = 0; $i < count($dirarray); $i++) {
                        echo  $dirarray[$i];        
                        $fName= substr(end(explode("\\", $dirarray[$i])),1);
                        if(in_array($fName, $arrImgs))                                
                        {
                                $zdir[] = $dirarray[$i];
                        }
                }

                if (!@is_dir($conf['dir'])) {
                        $res = @mkdir($conf['dir'], 0777);
                        if (!$res)
                                $txtout = "Cannot create dir !<br>";
                } else
                {
                        @chmod($conf['dir'], 0777);
                }

                if (!@is_dir($conf['dir'])) {
                        $res = @mkdir($conf['dir'], 0777);
                        if (!$res)
                                $txtout = "Cannot create dir !<br>";
                } else
                        @chmod($conf['dir'], 0777);

                $zipname = 'zipfile_' .  $so_row->sto_code;
                $zipname = str_replace("/", "", $zipname);
                //if (empty($zipname)) $zipname="NDKzip";
                $zipname.=".zip";

                $ziper = new zipfile();
                $ziper->addFiles($zdir);
                $ziper->output("{$conf['dir']}/{$zipname}");

                if ($fsize = @filesize("{$conf['dir']}/{$zipname}"))
                        $zipsize = $fsize;
                else
                        $zipsize = 0;


                $zdirsize = SToController::size_format($zdirsize);
                $zipsize = SToController::size_format($zipsize);
                $archive_file_name = $conf['dir'] . '/' . $zipname;

                header("Content-type: application/zip");
                header("Content-Disposition: attachment; filename=$archive_file_name");
                header("Pragma: no-cache");
                header("Expires: 0");
                readfile("$archive_file_name");
                $this->setRedirect('index.php?option=com_apdmsto&task=ito_detail&id=' . $sto_id);
                exit;
        }      
          function size_format($bytes="") {
                $retval = "";
                if ($bytes >= 1048576) {
                        $retval = round($bytes / 1048576 * 100) / 100 . " MB";
                } else if ($bytes >= 1024) {
                        $retval = round($bytes / 1024 * 100) / 100 . " KB";
                } else {
                        $retval = $bytes . " bytes";
                }
                return $retval;
        }
       
         /**
         * @desc Download imge of PNs
         */
        function download_doc_sto() {
                $db = & JFactory::getDBO();
                $sto_id = JRequest::getVar('sto_id');
                $image_id = JRequest::getVar('id');        
                $type_of_file = JRequest::getVar('type');        
                $query = "SELECT img.sto_id,img.file_name,sto.pns_sto_id,sto.sto_code FROM apdm_pns_sto_files img inner join apdm_pns_sto sto on img.sto_id= sto.pns_sto_id WHERE img.id=" . $image_id;
                $db->setQuery($query);
                $row = $db->loadObject();                
                ///for pns cads/image/pdf              
                $folder =  $row->sto_code;                
                $path_so = JPATH_SITE . DS . 'uploads' . DS . 'sto' . DS;
                $path_images = $path_so  . DS . $folder . DS . $type_of_file . DS;
                $file_name = $row->file_name;
                $dFile = new DownloadFile($path_images, $file_name);
                exit;
        }
        function download_zip_sto() {
                global $dirarray, $conf, $dirsize;

                //$conf['dir'] = "zipfiles";
                $conf['dir'] = "../uploads/pns/cads/PNsZip";
                $db = & JFactory::getDBO();
                $image_id = JRequest::getVar('id');      
                $sto_id = JRequest::getVar('sto_id');
                $type_of_doc = JRequest::getVar('type');
                $doc_type = 0;
                if($type_of_doc=='images')
                        $doc_type =2;
                elseif($type_of_doc=='pdfs')
                        $doc_type = 1;
                $db->setQuery("SELECT * from apdm_pns_sto where pns_sto_id=".$sto_id);
                $so_row =  $db->loadObject();           
                //Save upload new                
                $path_upload = JPATH_SITE . DS . 'uploads' . DS . 'sto' ;
                $folder = $so_row->sto_code;
                $path_sto_images = $path_upload  .DS. $folder . DS .$type_of_doc. DS;                
                //getall images belong PN                
                $query = "SELECT img.sto_id,img.file_name,sto.pns_sto_id,sto.sto_code FROM apdm_pns_sto_files img inner join apdm_pns_sto sto on img.sto_id= sto.pns_sto_id WHERE img.file_type = '".$doc_type."' and img.id=" . $image_id;                
                $db->setQuery($query);                
                $rows = $db->loadObjectList();
                $arrImgs = array();
                if (count($rows) > 0) {
                        foreach ($rows as $row) {
                                $arrImgs[] = $row->file_name;
                        }
                }    
                $zdir[] = $path_sto_images;                               
                $dirarray = array();
                $dirsize = 0;
                $zdirsize = 0;
                for ($i = 0; $i < count($zdir); $i++) {
                     
                        $ffile = $zdir[$i];
                        if (is_dir($ffile)) {
                                getdir($ffile);
                        } else {

                                if ($fsize = @filesize($ffile))
                                        $zdirsize+=$fsize;
                        }
                }

                $zdirsize+=$dirsize;

                for ($i = 0; $i < count($dirarray); $i++) {
                        echo  $dirarray[$i];        
                        $fName= substr(end(explode("\\", $dirarray[$i])),1);
                        if(in_array($fName, $arrImgs))                                
                        {
                                $zdir[] = $dirarray[$i];
                        }
                }

                if (!@is_dir($conf['dir'])) {
                        $res = @mkdir($conf['dir'], 0777);
                        if (!$res)
                                $txtout = "Cannot create dir !<br>";
                } else
                {
                        @chmod($conf['dir'], 0777);
                }

                if (!@is_dir($conf['dir'])) {
                        $res = @mkdir($conf['dir'], 0777);
                        if (!$res)
                                $txtout = "Cannot create dir !<br>";
                } else
                        @chmod($conf['dir'], 0777);

                $zipname = 'zipfile_' .  $so_row->sto_code;
                $zipname = str_replace("/", "", $zipname);
                //if (empty($zipname)) $zipname="NDKzip";
                $zipname.=".zip";

                $ziper = new zipfile();
                $ziper->addFiles($zdir);
                $ziper->output("{$conf['dir']}/{$zipname}");

                if ($fsize = @filesize("{$conf['dir']}/{$zipname}"))
                        $zipsize = $fsize;
                else
                        $zipsize = 0;


                $zdirsize = SToController::size_format($zdirsize);
                $zipsize = SToController::size_format($zipsize);
                $archive_file_name = $conf['dir'] . '/' . $zipname;

                header("Content-type: application/zip");
                header("Content-Disposition: attachment; filename=$archive_file_name");
                header("Pragma: no-cache");
                header("Expires: 0");
                readfile("$archive_file_name");
                $this->setRedirect('index.php?option=com_apdmsto&task=ito_detail&id=' . $sto_id);
                exit;
        }
    function getinfofomWoId($wo_id)
    {
        $db = & JFactory::getDBO();
        $db->setQuery("select wo.pns_wo_id,wo.wo_code, so.so_cuscode,so.customer_id as ccs_so_code,ccs.ccs_coordinator,ccs.ccs_name,ccs.ccs_code from apdm_pns_wo wo left join apdm_pns_so so on so.pns_so_id=wo.so_id left join apdm_ccs ccs on so.customer_id = ccs.ccs_code where wo.pns_wo_id = ".$wo_id);
        $row =  $db->loadObject();
        $soNumber = $row->so_cuscode;
        if($row->ccs_code)
        {
            $soNumber = $row->ccs_code."-".$soNumber;
        }
        $array = array();
        $array['sto_id'] = $wo_id;
        $array['so_code'] = $soNumber;
        $array['so_shipping_date'] = $row->so_shipping_date;
        $array['so_start_date'] = $row->so_start_date;
        return $array;
    }

    function ajax_wo_toitto()
    {
        $db = & JFactory::getDBO();
        $cid             = JRequest::getVar( 'cid', array(), '', 'array' );
        $id = $cid[0];
        if($id)
        {
                $db->setQuery("SELECT so.pns_so_id,wo.pns_wo_id,wo.wo_code, so.so_cuscode,so.customer_id as ccs_so_code,ccs.ccs_coordinator,ccs.ccs_name,ccs.ccs_code from apdm_pns_so so right join apdm_pns_wo wo on so.pns_so_id=wo.so_id left join apdm_ccs ccs on so.customer_id = ccs.ccs_code where wo.pns_wo_id=".$id);
                $row =  $db->loadObject();
                $soNumber = $row->so_cuscode;
                if($row->ccs_code)
                {
                    $soNumber = $row->ccs_code."-".$soNumber;
                }
                $result = $row->customer_id.'^'.$row->ccs_name.'^'.$row->pns_so_id.'^'.$soNumber.'^'.$row->pns_wo_id.'^'.$row->wo_code;
                
        }
        else {
               $result = '0^NA^0^NA^0^NA'; 
        }
        echo $result;      
        exit;
    }
    function get_wo_ajax()
    {
        JRequest::setVar( 'layout', 'list'  );
        JRequest::setVar( 'view', 'getwo' );
        parent::display();
    }
    function get_po_ajax()
    {
        JRequest::setVar( 'layout', 'list'  );
        JRequest::setVar( 'view', 'getpo' );
        parent::display();
    }
    function ajax_po_toito()
    {
        $db = & JFactory::getDBO();
        $cid             = JRequest::getVar( 'cid', array(), '', 'array' );
        $id = $cid[0];
        $db->setQuery("SELECT p.*  FROM apdm_pns_po AS p where p.pns_po_id=".$id);
        $row =  $db->loadObject();
        $result = $row->pns_po_id.'^'.$row->po_code;
        echo $result;
        exit;
    }
    function gettool_tracker_scan()
    {
            $db = & JFactory::getDBO();
            $tool_code = JRequest::getVar('tool_code');
            $db->setQuery("select tto.pns_tto_id from apdm_pns_tto tto inner join apdm_pns_tto_fk fk on tto.pns_tto_id = fk.tto_id inner join apdm_pns_location loc on fk.location = loc.pns_location_id where loc.location_code = '".$tool_code."' and tto.tto_state = 'Using' order by tto.pns_tto_id desc limit 1");
            $pns_tto_id =  $db->loadResult();             
            if ($pns_tto_id) {
                    return $this->setRedirect('index.php?option=com_apdmtto&task=tto_detail&id='.$pns_tto_id.'&test='.time());
            }
            return  $this->setRedirect('index.php?option=com_apdmtto');
    }
}
