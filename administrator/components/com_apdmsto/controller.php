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
class SToController extends JController
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
		$this->registerTask( 'addito'  , 	'display'  );
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
			case 'addito':
                        {
				JRequest::setVar( 'layout', 'form'  );
				JRequest::setVar( 'view', 'ito' );
				JRequest::setVar( 'edit', false );                                
                        } break;
			case 'addeto'     :
			{	
				JRequest::setVar( 'layout', 'form'  );
				JRequest::setVar( 'view', 'eto' );
				JRequest::setVar( 'edit', false );
			} break;
			case 'editito'    :
			{				
				JRequest::setVar( 'layout', 'formedit'  );
				JRequest::setVar( 'view', 'ito' );
				JRequest::setVar( 'edit', true );
			} break;
			case 'editeto'    :
			{				
				JRequest::setVar( 'layout', 'formedit'  );
				JRequest::setVar( 'view', 'eto' );
				JRequest::setVar( 'edit', true );
			} break;                
                
			case 'detailito':{
				JRequest::setVar( 'layout', 'view'  );
				JRequest::setVar( 'view', 'ito' );
				JRequest::setVar( 'edit', true );
			}
			break;
			case 'detaileto':{
				JRequest::setVar( 'layout', 'view'  );
				JRequest::setVar( 'view', 'eto' );
				JRequest::setVar( 'edit', true );
			}
			break;                                
			
		}

		parent::display();
	}
        function get_sto_code_default() {
                $db = & JFactory::getDBO();
            $datenow = & JFactory::getDate();
                $sto_type = JRequest::getVar('sto_type');
            $query = "SELECT sto_code  FROM apdm_pns_sto  WHERE sto_type = '" . $sto_type . "' and date(sto_created) = '".$datenow->toFormat('%Y-%m-%d')."' order by pns_sto_id desc limit 1";
            $db->setQuery($query);
               $pns_latest = $db->loadResult();
                $arr = explode("-",$pns_latest);
               
                $next_pns_code = (int) $arr[1];
                $next_pns_code++;
                $number = strlen($next_pns_code);
                switch ($number) {
                        case '1':
                                $new_pns_code = '0' . $next_pns_code;
                                break;
                        case '2':
                                $new_pns_code = $next_pns_code;
                                break;
                       
                        default:
                                $new_pns_code = $next_pns_code;
                                break;
                }
                if($sto_type==1)
                        $pre = "I";
                elseif($sto_type==2)
                        $pre = "E";
                elseif($sto_type==3)
                        $pre = "M";
                echo $pre.$datenow->toFormat('%y%m%d').'-'.$new_pns_code;
                 
                exit;
        }
        /*
         * Save new stock ITO
         */
        function save_ito() {
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $datenow = & JFactory::getDate();
                $post = JRequest::get('post');   
                $sto_code = $post['sto_code'];
				
                $sto_state = "Create"; //JRequest::getVar('sto_state');   				
               
                //check exist first
                $db->setQuery("select count(*) from apdm_pns_sto where sto_code = '" . $sto_code."'");
                $check_exist = $db->loadResult();
                if ($check_exist!=0) {    
                        $msg = "The ITO already exist!";
                        $this->setRedirect('index.php?option=com_apdmsto&task=addito', $msg);
                        return;
                }                                        
                $return = JRequest::getVar('return');
                $db->setQuery("INSERT INTO apdm_pns_sto (sto_code,sto_description,sto_state,sto_created,sto_create_by,sto_type,sto_stocker,sto_supplier_id,sto_po_internal) VALUES ('" . $sto_code . "', '" . strtoupper($post['sto_description']) . "', '" . $sto_state . "', '" . $datenow->toMySQL() . "', '" . $me->get('id') . "',1,'".$me->get('id')."','".$post['sto_supplier_id']."','".$post['po_inter_code']."')");
                $db->query();
				
                //getLast ITO ID
                $ito_id = $db->insertid();
                if($ito_id)
                {

                        $path_upload = JPATH_SITE . DS . 'uploads' . DS . 'sto' . DS . $post['sto_code'];
                        //for upload file image
                       //upload new images
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
                                        $db->setQuery("INSERT INTO apdm_pns_sto_files (sto_id, file_name,file_type, sto_file_created, sto_file_created_by) VALUES (" . $ito_id . ", '" . $file . "',2, '" . $datenow->toMySQL() . "', " . $me->get('id') . " ) ");                                        
                                        $db->query();
                                }
                        }                            
                }//for save database of pns 				
				
                $msg = "Successfully Saved ITO";
                return $this->setRedirect('index.php?option=com_apdmsto&task=ito_detail&id='.$ito_id, $msg);                
        }        		
		/*
         * Detail STO 
         */        
        function ito_detail() {
                JRequest::setVar('layout', 'view');
                JRequest::setVar('view', 'ito');
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
        function get_list_pns_sto() {
                JRequest::setVar('layout', 'default');
                JRequest::setVar('view', 'getpnsforstos');
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
		 function GetStoFrommPns($pns_id,$sto_id) {
                $db = & JFactory::getDBO();
                $rows = array();
                //$query = "SELECT fk.id  FROM apdm_pns_sto AS sto inner JOIN apdm_pns_sto_fk fk on sto.pns_sto_id = fk.sto_id inner join apdm_pns AS p on p.pns_id = fk.pns_id where fk.pns_id=".$pns_id;
                $query = "SELECT pns_id,id FROM apdm_pns_sto_fk WHERE pns_id = ".$pns_id ." and sto_id = ".$sto_id;

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
        
        function get_owner_confirm_sto()
        {
                JRequest::setVar('layout', 'inform');
                JRequest::setVar('view', 'userinform');
                parent::display();
        }
        function ajax_checkownersto()
        {
                $db = & JFactory::getDBO();
                $datenow = & JFactory::getDate();
                $sto_id = JRequest::getVar('sto_id');
                $password =  JRequest::getVar('passwd', '', 'post', 'string', JREQUEST_ALLOWRAW);
                $username = JRequest::getVar('username', '', 'method', 'username');
                $query = "select user_id from apdm_users where user_password = md5('".$password."') and username='".$username."'";
                $db->setQuery($query);
                $userId = $db->loadResult();
                $db->setQuery("SELECT * from apdm_pns_sto where pns_sto_id=".$sto_id);
                $sto_row =  $db->loadObject();    
                
                if($userId)
                {   
                        if($sto_row->sto_state!="InTransit")
                        {
                                $db->setQuery("update apdm_pns_sto set sto_owner = '".$userId."',sto_state = 'Done',sto_completed_date='" . $datenow->toMySQL() . "' , sto_owner_confirm ='1' WHERE  pns_sto_id = ".$sto_id);                        
                                $db->query();     
                        }
                        else {
                                $db->setQuery("update apdm_pns_sto set sto_owner = '".$userId."', sto_owner_confirm ='1' WHERE  pns_sto_id = ".$sto_id);                        
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
        
        function save_editito() {
                global $mainframe;
                // Initialize some variables                                  
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $datenow = & JFactory::getDate();
                $post = JRequest::get('post');   
                $sto_code = $post['sto_code'];
                $ito_id = $post['pns_sto_id'];
                                            
                $return = JRequest::getVar('return');
                $db->setQuery("update apdm_pns_sto set sto_po_internal = '".$post['po_inter_code']."',sto_supplier_id = '".$post['sto_supplier_id']."',sto_description='" . strtoupper($post['sto_description']) . "'  WHERE  pns_sto_id = '".$post['pns_sto_id']."'");
                $db->query();
                //upload file
                //get so info
                $db->setQuery("SELECT * from apdm_pns_sto where pns_sto_id=".$post['pns_sto_id']);
                $sto_row =  $db->loadObject();                
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
                                $db->setQuery("DELETE FROM apdm_pns_sto_files where sto_id = " . $ito_id);
                                $db->query();
                                $db->setQuery("INSERT INTO apdm_pns_sto_files (sto_id, file_name,file_type, sto_file_created, sto_file_created_by) VALUES (" . $ito_id . ", '" . $file . "',2, '" . $datenow->toMySQL() . "', " . $me->get('id') . " ) ");                                                                         
                                $db->query();                                 
                        }
                }                        
                $msg = "Successfully Saved Update ITO";
                return $this->setRedirect('index.php?option=com_apdmsto&task=ito_detail&id='.$post['pns_sto_id'], $msg);                
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
                $db->setQuery("update apdm_pns_sto set sto_so_id = '".$post['sto_so_id']."', sto_wo_id ='".$post['sto_wo_id']."', sto_description='" . strtoupper($post['sto_description']) . "'  WHERE  pns_sto_id = '".$post['pns_sto_id']."'");
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
    function ajax_add_pns_stos() {
        $db = & JFactory::getDBO();
        $pns = JRequest::getVar('cid', array(), '', 'array');
        $sto_id = JRequest::getVar('sto_id');
        //innsert to FK table
        foreach($pns as $pn_id)
        {
            $location="";
            $partstate="";
            $db->setQuery("select sto_type from apdm_pns_sto where pns_sto_id ='".$sto_id."'");
            $sto_type = $db->loadResult();
            if($sto_type==2)
            {
                $db->setQuery("SELECT stofk.* from apdm_pns_sto_fk stofk inner join apdm_pns_sto sto on stofk.sto_id = sto.pns_sto_id WHERE stofk.pns_id= '".$pn_id."' and sto.sto_type = 1  AND stofk.sto_id != '".$sto_id."' order by stofk.id desc limit 1");
                $row = $db->loadObject();
                $location = $row->location;
                $partState = $row->partstate;
            }
            $db->setQuery("INSERT INTO apdm_pns_sto_fk (pns_id,sto_id,location,partstate) VALUES ( '" . $pn_id . "','" . $sto_id . "','" . $location . "','" . $partState . "')");
            $db->query();
        }
        return $msg = JText::_('Have add pns successfull.');
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
    function removeAllpnsstos() {
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
        return $this->setRedirect('index.php?option=com_apdmsto&task=ito_detail&id=' . $sto_id, $msg);
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
    function saveqtyStofk() {
        $db = & JFactory::getDBO();
        $cid = JRequest::getVar('cid', array(), '', 'array');

        $fkid = JRequest::getVar('id');
        foreach ($cid as $pnsid) {
            $obj = explode("_", $pnsid);
            $pns=$obj[0];
            $ids = explode(",",$obj[1]);
            $msg = "";
            foreach ($ids as $id) {
                $stock = JRequest::getVar('qty_'. $pns .'_' . $id);
                $location = JRequest::getVar('location_' . $pns .'_' . $id);
                $partState = JRequest::getVar('partstate_' . $pns .'_' . $id);
                $mfgPnId = JRequest::getVar('mfg_pn_' . $pns .'_' . $id);
                
                //get sto_type
                $db->setQuery("select fk.qty,sto.sto_type,fk.pns_id,fk.sto_id,fk.partstate,fk.location,loc.location_code from apdm_pns_sto sto inner join apdm_pns_sto_fk fk on sto.pns_sto_id = fk.sto_id inner join apdm_pns_location loc on fk.location = loc.pns_location_id where fk.id =  ".$id);
               
                $stoChecker= $db->loadObject();
                if($stoChecker->sto_type==2)//if is out(ship) stock
                {
                    $db->setQuery("select sum(fk.qty) as total_qty from apdm_pns_sto sto inner join apdm_pns_sto_fk fk on sto.pns_sto_id = fk.sto_id where fk.pns_id = '".$pns."' and fk.partstate = '".$partState."' and fk.location = '".$location."' and fk.pns_mfg_pn_id = '".$mfgPnId."'  and sto.sto_type = 1 and sto.sto_owner_confirm = 1");

                    $qtyInCheck = round($db->loadResult(),2);
                    //get QTY from TTO
                    $db->setQuery("select sum(fk.qty) as total_qty_tool from apdm_pns_tto tto inner join apdm_pns_tto_fk fk on tto.pns_tto_id = fk.tto_id where  tto.tto_state != 'Done' and  fk.pns_id = '".$pns."' and fk.partstate = '".$partState."' and fk.location = '".$location."'  and tto.tto_type = 1 and sto.sto_owner_confirm = 1");
                    $qtyTtoCheck = round($db->loadResult(),2);
                    $totalQtyCheck = $qtyInCheck - $qtyTtoCheck;

                    $db->setQuery("select sum(fk.qty) as total_qty from apdm_pns_sto sto inner join apdm_pns_sto_fk fk on sto.pns_sto_id = fk.sto_id where fk.pns_id = '".$pns."' and fk.partstate = '".$partState."' and fk.location = '".$location."' and fk.pns_mfg_pn_id = '".$mfgPnId."'  and sto.sto_type = 2  and fk.id != ".$id);
                    $qtyOutCheck = $db->loadResult();
                    if(!$qtyOutCheck)
                    {
                          $qtyOutCheck = 0;
                    }
                    $currentOutStock = $stock+$qtyOutCheck;
                    if($currentOutStock > $totalQtyCheck)
                    {
                        $msg .= "Qty just input at row have Part State:".$stoChecker->partstate.",Location:".$stoChecker->location_code.",MFG PN:".SToController::GetMfgPnCode($mfgPnId)." must less than $totalQtyCheck . $currentOutStock";
                        return $this->setRedirect('index.php?option=com_apdmsto&task=eto_detail&id=' . $fkid, $msg);
                    }
                }
                $db->setQuery("update apdm_pns_sto_fk set qty=" . $stock . ", location='" . $location . "', partstate='" . $partState . "',pns_mfg_pn_id = '".$mfgPnId."' WHERE  id = " . $id);
                $db->query();
            }
        }
        $db->setQuery("select sto_type from apdm_pns_sto where pns_sto_id ='".$fkid."'");       
        $sto_type = $db->loadResult();
        $return = "ito_detail";
        if($sto_type==2)
                $return = "eto_detail";
        $msg .= "Successfully Saved Part Number";
        $this->setRedirect('index.php?option=com_apdmsto&task='.$return.'&id=' . $fkid, $msg);
    }
    /*
           * Remove PNS out of STO in STO management
           */
    function removepnsstos() {
        $db = & JFactory::getDBO();
        $pnsfk = JRequest::getVar('cid', array(), '', 'array');
        $sto_id = JRequest::getVar('sto_id');
//                $db->setQuery("update apdm_pns set po_id = 0 WHERE  pns_id IN (" . implode(",", $pns) . ")");
//                $db->query();
        foreach($pnsfk as $fk_id)
        {
            $db->setQuery("DELETE FROM apdm_pns_sto_fk WHERE id = '" . $fk_id . "' AND sto_id = " . $sto_id . "");
            $db->query();
        }
        $msg = JText::_('Have removed successfull.');
        $db->setQuery("select sto_type from apdm_pns_sto where pns_sto_id ='".$sto_id."'");
        $sto_type = $db->loadResult();
        if($sto_type==2)
        {
            return $this->setRedirect('index.php?option=com_apdmsto&task=eto_detail&id=' . $sto_id, $msg);
        }
        return $this->setRedirect('index.php?option=com_apdmsto&task=ito_detail&id=' . $sto_id, $msg);
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
    function getLocationPartStatePnEto($partState,$pnsId,$pns_mfg_pn_id,$id=0)
    {
        $db = & JFactory::getDBO();
        $rows = array();
        $query = "select fk.pns_id,fk.sto_id ,sto.sto_type,fk.partstate,fk.location,loc.location_code ".
            " from apdm_pns_sto_fk fk  ".
            " inner join apdm_pns_location loc on loc.pns_location_id=location ".
            " inner join apdm_pns_sto sto on fk.sto_id = sto.pns_sto_id ".
            " where fk.pns_id = ".$pnsId." and sto.sto_type=1 and fk.partstate = '".$partState."' and fk.pns_mfg_pn_id = '".$pns_mfg_pn_id."' or fk.id= '".$id."' group by loc.location_code";
        $db->setQuery($query);
        $result = $db->loadObjectList();
        if (count($result) > 0) {
            $locationArr=array();
            foreach ($result as $obj) {
                //$qty_remain = CalculateInventoryLocationPartValueForTool($obj->pns_id,$obj->location,$obj->partstate);
                //if($qty_remain>0)
                //{
                //$array_partstate[$obj->partstate] = $obj->partstate;
                $locationArr[] = JHTML::_('select.option', $obj->location, $obj->location_code , 'value', 'text');
                //}
            }
        }
        return $locationArr;
    }
    function ajax_getlocation_mfgpn($pnsId,$fkId,$currentLoc,$MfgPn,$partstate="")
    {
        //&partstate='+partState+'&pnsid='+pnsId+'&fkid'+fkId+'&currentloc='+currentLoc;

        $db = & JFactory::getDBO();
        $rows = array();
        $pnsId = JRequest::getVar('pnsid');
        $fkId = JRequest::getVar('fkid');
        $currentLoc = JRequest::getVar('currentloc');
        $MfgPn = JRequest::getVar('mfgpn');
        $partstate = JRequest::getVar('partstate');
        $query = "select fk.pns_id,fk.sto_id ,sto.sto_type,fk.partstate,fk.location,loc.location_code ".
            " from apdm_pns_sto_fk fk  ".
            " inner join apdm_pns_location loc on loc.pns_location_id=location ".
            " inner join apdm_pns_sto sto on fk.sto_id = sto.pns_sto_id ".
            " where fk.pns_id = ".$pnsId." and sto.sto_type=1 ";
        if($MfgPn)
        {
            $query .= " and fk.pns_mfg_pn_id = '".$MfgPn."'";
        }
        $query .= " and fk.partstate = '".$partstate."' or fk.id= '".$fkId."' group by fk.location";
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
    function printitopdf()
    {
        JRequest::setVar('layout', 'view_detail_print');
        JRequest::setVar('view', 'ito');
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
        if($post['sto_isdelivery_good'])//save moew SO
        {
                $sto_state = "InTransit";
                $db->setQuery("INSERT INTO apdm_pns_sto (sto_code,sto_description,sto_state,sto_created,sto_create_by,sto_type,sto_stocker,sto_so_id,sto_isdelivery_good) VALUES ('" . $sto_code . "', '" . strtoupper($post['sto_description']) . "', '" . $sto_state . "', '" . $datenow->toMySQL() . "', '" . $me->get('id') . "',2,'".$me->get('id')."','".$post['sto_so_id']."','".$post['sto_isdelivery_good']."')");
                $db->query();
        }
        else {
                $sto_state="Create";
                $db->setQuery("INSERT INTO apdm_pns_sto (sto_code,sto_description,sto_state,sto_created,sto_create_by,sto_type,sto_stocker,sto_wo_id,sto_so_id,sto_isdelivery_good) VALUES ('" . $sto_code . "', '" . strtoupper($post['sto_description']) . "', '" . $sto_state . "', '" . $datenow->toMySQL() . "', '" . $me->get('id') . "',2,'".$me->get('id')."','".$post['sto_wo_id']."','".$post['sto_so_id']."','".$post['sto_isdelivery_good']."')");
                $db->query();
        }
       

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
        function deletesto() {
                $db = & JFactory::getDBO();                
                $sto_id = JRequest::getVar('sto_id');
                $db->setQuery("DELETE FROM apdm_pns_sto WHERE pns_sto_id = '" . $sto_id . "'");
                $db->query();                    
                $db->setQuery("DELETE FROM apdm_pns_sto_files WHERE sto_id = '" . $sto_id . "'");
                $db->query();     
                $db->setQuery("DELETE FROM apdm_pns_sto_fk WHERE sto_id = '" . $sto_id . "'");
                $db->query();
                $db->setQuery("DELETE FROM apdm_pns_sto_delivery WHERE sto_id = '" . $sto_id . "'");
                $db->query();
                $msg = JText::_('Have removed successfull.');
                return $this->setRedirect('index.php?option=com_apdmsto&task=sto', $msg);
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

    function ajax_wo_toeto()
    {
        $db = & JFactory::getDBO();
        $cid             = JRequest::getVar( 'cid', array(), '', 'array' );
        $id = $cid[0];
        if($id)
        {
                $db->setQuery("SELECT so.pns_so_id,wo.pns_wo_id,wo.wo_code, so.so_cuscode,so.customer_id as ccs_so_code,ccs.ccs_coordinator,ccs.ccs_name,ccs.ccs_code from apdm_pns_so so inner join apdm_pns_wo wo on so.pns_so_id=wo.so_id left join apdm_ccs ccs on so.customer_id = ccs.ccs_code where wo.pns_wo_id=".$id);
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
 function ajax_so_toeto()
    {
        $db = & JFactory::getDBO();
        $cid             = JRequest::getVar( 'cid', array(), '', 'array' );
        $id = $cid[0];
        if($id)
        {
                $db->setQuery("SELECT so.pns_so_id, so.so_cuscode,so.customer_id as ccs_so_code,ccs.ccs_coordinator,ccs.ccs_name,ccs.ccs_code from apdm_pns_so so left join apdm_ccs ccs on so.customer_id = ccs.ccs_code where so.pns_so_id=".$id);
                $row =  $db->loadObject();
                $soNumber = $row->so_cuscode;
                if($row->ccs_code)
                {
                    $soNumber = $row->ccs_code."-".$soNumber;
                }
                $result = $row->customer_id.'^'.$row->ccs_name.'^'.$row->pns_so_id.'^'.$soNumber;
                
        }
        else {
               $result = '0^NA^0^NA'; 
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
        function get_so_ajax()
    {
        JRequest::setVar( 'layout', 'list'  );
        JRequest::setVar( 'view', 'getso' );
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
        if($id) {
            $db->setQuery("SELECT p.*  FROM apdm_pns_po AS p where p.pns_po_id=" . $id);
            $row = $db->loadObject();
            $result = $row->pns_po_id . '^' . $row->po_code;
        }else {
            $result = '0^NA';
        }
        echo $result;
        exit;
    }
    function CalculateInventoryValue($pns_id)
    {
        $db = & JFactory::getDBO();
        $db->setQuery("select pns_stock from apdm_pns where pns_id='".$pns_id."'");
        $db->query();
        $rows = $db->loadObjectList();
        $CurrentStock = $rows[0]->pns_stock;
        //get Stock IN
        $db->setQuery("select  sum(qty) from apdm_pns_sto_fk fk inner join apdm_pns pn on fk.pns_id = pn.pns_id  inner join apdm_pns_sto sto on sto.pns_sto_id = fk.sto_id and sto_type = 1 where fk.pns_id='".$pns_id."'");
        $db->query();
        $StockIn = $db->loadResult();
        //$StockIn = $rows->qty_in;
        //get Stock OUT
        $db->setQuery("select  sum(qty)  from apdm_pns_sto_fk fk inner join apdm_pns pn on fk.pns_id = pn.pns_id  inner join apdm_pns_sto sto on sto.pns_sto_id = fk.sto_id and sto_type = 2 where fk.pns_id='".$pns_id."'");
        $db->query();
        $StockOut = $db->loadResult();
        //$StockOut = $rows->qty_out;
        $inventory =  round($CurrentStock + ($StockIn-$StockOut),2);
        if($inventory<0)
            $inventory = 0;
        return $inventory;
        exit;
    }
    function getSoCodeFromId($soId)
    {
        $db = & JFactory::getDBO();
        $result  = "NA";
        $query = 'SELECT  so.pns_so_id,so.so_cuscode,so.customer_id as ccs_so_code,ccs.ccs_coordinator,ccs.ccs_name,ccs.ccs_code '
                . ' from apdm_pns_so so'
                . ' left join apdm_ccs ccs on so.customer_id = ccs.ccs_code where so.pns_so_id='.$soId;
        $db->setQuery($query);
        $row =  $db->loadObject();
        $soNumber = $row->so_cuscode;
        if($row->ccs_code)
        {
            $soNumber = $row->ccs_code."-".$soNumber;
        }
        $result = $soNumber;
        return  $result;      
    } 
    function getCustomerCodeFromSoId($soId)
    {
        $db = & JFactory::getDBO();
        $result            = "NA";
        $query = 'SELECT  so.pns_so_id,so.so_cuscode,so.customer_id as ccs_so_code,ccs.ccs_coordinator,ccs.ccs_name,ccs.ccs_code '
                . ' from apdm_pns_so so'
                . ' left join apdm_ccs ccs on so.customer_id = ccs.ccs_code where so.pns_so_id='.$soId;
        $db->setQuery($query);
        $row =  $db->loadObject();        
        if($row->ccs_name)
        {
            return $row->ccs_name;
        }
        return "NA";
    }    
    function ajax_addpn_ito()
    {
                $db = & JFactory::getDBO();
                $sto_id = JRequest::getVar('sto_id');   
                $pns_code = JRequest::getVar('pns_code');   
                $arrPn = explode("-", $pns_code);
        //A02-200263-0A
                $ccs_code = $arrPn[0];
                $pns_code = $arrPn[1];
                $pns_revision = $arrPn[2];
        //K01-0262499-000

                if($arrPn[4])
                {
                    $pns_code = $arrPn[1]."-".$arrPn[2]."-".$arrPn[3];
                    $pns_revision = $arrPn[4];
                }
                elseif($arrPn[3] &&!$arrPn[4])
                {
                    $pns_code = $arrPn[1]."-".$arrPn[2];
                    $pns_revision = $arrPn[3];

                }
                if($arrPn[3] || $arrPn[4])
                {
                       // $pns_revision = $arrPn[3];
                        $query = "select pns_id from apdm_pns where ccs_code = '".$ccs_code."' and pns_code = '".$pns_code."' and pns_revision = '".$pns_revision."'";

                }
                else {
                        if(preg_match("/^[0-9]+$/i", $arrPn[2]))
                        {
                            $pns_code = $arrPn[1]."-".$arrPn[2];
                            $query = "select pns_id from apdm_pns where ccs_code = '".$ccs_code."' and pns_code = '".$pns_code."'";
                        }
                        else
                        {
                            $pns_code = $arrPn[1];
                            $pns_revision = $arrPn[2];
                            $query = "select pns_id from apdm_pns where ccs_code = '".$ccs_code."' and pns_code = '".$pns_code."' and pns_revision = '".$pns_revision."'";
                        }
                }
                $db->setQuery($query);
                $pns_id = $db->loadResult();
                //innsert to FK table
                $location="";
                $partstate="";
                $db->setQuery("select sto_type from apdm_pns_sto where pns_sto_id ='".$sto_id."'");
                $sto_type = $db->loadResult();
                $return = 'index.php?option=com_apdmsto&task=ito_detail&id=' . $sto_id;                
                $db->setQuery("INSERT INTO apdm_pns_sto_fk (pns_id,sto_id,location,partstate) VALUES ( '" . $pns_id . "','" . $sto_id . "','" . $location . "','" . $partState . "')");
                $db->query();
                return $this->setRedirect($return);
        }   
        function ajax_addpn_eto()
        {
                $db = & JFactory::getDBO();
                $sto_id = JRequest::getVar('sto_id');   
                $pns_code = JRequest::getVar('pns_code');   
                $arrPn = explode("-", $pns_code);
        //A02-200263-0A
                $ccs_code = $arrPn[0];
                $pns_code = $arrPn[1];
                $pns_revision = $arrPn[2];
        //K01-0262499-000

                if($arrPn[4])
                {
                    $pns_code = $arrPn[1]."-".$arrPn[2]."-".$arrPn[3];
                    $pns_revision = $arrPn[4];
                }
                elseif($arrPn[3] &&!$arrPn[4])
                {
                    $pns_code = $arrPn[1]."-".$arrPn[2];
                    $pns_revision = $arrPn[3];

                }
                if($arrPn[3] || $arrPn[4])
                {
                       // $pns_revision = $arrPn[3];
                        $query = "select pns_id from apdm_pns where ccs_code = '".$ccs_code."' and pns_code = '".$pns_code."' and pns_revision = '".$pns_revision."'";

                }
                else {
                        if(preg_match("/^[0-9]+$/i", $arrPn[2]))
                        {
                            $pns_code = $arrPn[1]."-".$arrPn[2];
                            $query = "select pns_id from apdm_pns where ccs_code = '".$ccs_code."' and pns_code = '".$pns_code."'";
                        }
                        else
                        {
                            $pns_code = $arrPn[1];
                            $pns_revision = $arrPn[2];
                            $query = "select pns_id from apdm_pns where ccs_code = '".$ccs_code."' and pns_code = '".$pns_code."' and pns_revision = '".$pns_revision."'";
                        }
                }
                $db->setQuery($query);
                $pns_id = $db->loadResult();
                //innsert to FK table
                $location="";
                $partstate="";                                           
                $db->setQuery("select sto_type from apdm_pns_sto where pns_sto_id ='".$sto_id."'");
                $sto_type = $db->loadResult();
                if($sto_type==2)
                {
                        $db->setQuery("SELECT stofk.* from apdm_pns_sto_fk stofk inner join apdm_pns_sto sto on stofk.sto_id = sto.pns_sto_id WHERE stofk.pns_id= '".$pns_id."' and sto.sto_type = 1  AND stofk.sto_id != '".$sto_id."' order by stofk.id desc limit 1");
                        $row = $db->loadObject();
                        $location = $row->location;
                        $partState = $row->partstate;
                        $return = 'index.php?option=com_apdmsto&task=eto_detail&id=' . $sto_id;
                }
                $db->setQuery("INSERT INTO apdm_pns_sto_fk (pns_id,sto_id,location,partstate) VALUES ( '" . $pns_id . "','" . $sto_id . "','" . $location . "','" . $partState . "')");
                $db->query();
                return $this->setRedirect($return);
        }        
        function get_list_pns_eto()
        {
                JRequest::setVar('layout', 'default');
                JRequest::setVar('view', 'getpnsforeto');
                parent::display();
        }
        function viewallsto()
        {
                JRequest::setVar('layout', 'viewall');
                JRequest::setVar('view', 'sto');
                parent::display();
        }
        function ajax_markscan_checked()
        {
                global $is_etoscan;
                $is_etoscan= JRequest::getVar('etoscan');
                $session = JFactory::getSession();
                $session->set('is_scaneto',$is_etoscan);
        }
        function ajax_markscan_itochecked()
        {
                global $is_itoscan;
                $is_itoscan= JRequest::getVar('itoscan');
                $session = JFactory::getSession();
                $session->set('is_scanito',$is_itoscan);
    }
 
    function GetMfgPnCode($mfgId) {
                $db = & JFactory::getDBO();                
                $db->setQuery("SELECT p.supplier_info FROM apdm_pns_supplier AS p LEFT JOIN apdm_supplier_info AS s ON s.info_id = p.supplier_id left join apdm_pns_sto_fk fk on fk.pns_mfg_pn_id = p.id WHERE  s.info_deleted=0 AND  s.info_activate=1 AND p.type_id = 4 AND  p.id =" . $mfgId);                
               
                return $db->loadResult();
    }
     function getMfgPnListFromPn($pnsId)
        {
                $db = & JFactory::getDBO();
                $rows = array();
                $query = "SELECT p.id,p.supplier_id, p.supplier_info, s.info_name FROM apdm_pns_supplier AS p LEFT JOIN apdm_supplier_info AS s ON s.info_id = p.supplier_id WHERE  s.info_deleted=0 AND  s.info_activate=1 AND p.type_id = 4 AND  p.pns_id =" . $pnsId;
                $db->setQuery($query);
                $result = $db->loadObjectList();
                if (count($result) > 0) {
                        $locationArr=array();                        
                        foreach ($result as $obj) {                                  
                                    $locationArr[] = JHTML::_('select.option', $obj->id, $obj->supplier_info , 'value', 'text');                                
                        }
                }                       
                return $locationArr;
        }	
        function getMfgPnListFromPnEto($pnsId,$partState)
        {
                $db = & JFactory::getDBO();
                $rows = array();               
                 $query = "SELECT p.id,p.supplier_id, p.supplier_info, s.info_name ".
                                " FROM apdm_pns_supplier AS p ".
                                " LEFT JOIN apdm_supplier_info AS s ON s.info_id = p.supplier_id ".
                                " LEFT JOIN apdm_pns_sto_fk AS fk ON p.id = fk.pns_mfg_pn_id ".
                                " inner join apdm_pns_sto sto on fk.sto_id = sto.pns_sto_id ".
                                " WHERE s.info_deleted=0 AND s.info_activate=1 AND p.type_id = 4 ".
                                " and fk.pns_id = '".$pnsId."' and sto.sto_type=1 ";
                     if($partState)
                     {
                           $query .=   " and fk.partstate = '".$partState."' ";
                     }
            $query .=   " group by  p.id";
            $db->setQuery($query);
                $result = $db->loadObjectList();
                if (count($result) > 0) {
                        $mfgPnArr=array();
                        $mfgPnArr[] = JHTML::_('select.option', 0, "Select MFG PN" , 'value', 'text');
                        foreach ($result as $obj) {                                  
                                    $mfgPnArr[] = JHTML::_('select.option', $obj->id, $obj->supplier_info , 'value', 'text');                                
                        }
                }                       
                return $mfgPnArr;
                
                
        }	
 function ajax_getmfgpn_partstate($pnsId,$fkId,$currentLoc,$partState)
    {
        //&partstate='+partState+'&pnsid='+pnsId+'&fkid'+fkId+'&currentloc='+currentLoc;

        $db = & JFactory::getDBO();
        $rows = array();
        $pnsId = JRequest::getVar('pnsid');
        $fkId = JRequest::getVar('fkid');
        $currentmfgpn = JRequest::getVar('currentmfgpn');
        $partState = JRequest::getVar('partstate');
        $query = "SELECT p.id,p.supplier_id, p.supplier_info, s.info_name ".
                                " FROM apdm_pns_supplier AS p ".
                                " LEFT JOIN apdm_supplier_info AS s ON s.info_id = p.supplier_id ".
                                " LEFT JOIN apdm_pns_sto_fk AS fk ON p.id = fk.pns_mfg_pn_id ".
                                " inner join apdm_pns_sto sto on fk.sto_id = sto.pns_sto_id ".
                                " WHERE s.info_deleted=0 AND s.info_activate=1 AND p.type_id = 4 ".
                                " and fk.pns_id = '".$pnsId."'  and sto.sto_type=1 ";
                     if($partState)
                     {
                           $query .=   " and fk.partstate = '".$partState."' ";
                     }
        $query .=   " group by  p.id";
        $db->setQuery($query);
        $result = $db->loadObjectList();
        if (count($result) > 0) {
            $mfgPnArr=array();
            $mfgPnArr[] = JHTML::_('select.option', 0, "Select MFG PN" , 'value', 'text');
            foreach ($result as $obj) {                                
                    $mfgPnArr[] = JHTML::_('select.option', $obj->id, $obj->supplier_info , 'value', 'text');            
            }
        }

        echo JHTML::_('select.genericlist',   $mfgPnArr, 'mfg_pn_'.$pnsId.'_'.$fkId, 'class="inputbox"  size="1" onchange="getLocationFromMfgPn(\''.$pnsId.'\',\''.$fkId.'\',\''.$currentLoc.'\',this.value)"" ', 'value', 'text', $currentmfgpn);
        exit;
        //return $locationArr;
    }            
    
}
