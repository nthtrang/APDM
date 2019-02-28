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
ini_set('display_errors',1);

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
                $sto_type = JRequest::getVar('sto_type');

                $query = "SELECT count(*)  FROM apdm_pns_sto  WHERE sto_type = '" . $sto_type . "' and date(sto_created) = CURDATE()";
                $db->setQuery($query);
               $pns_latest = $db->loadResult();
               
                $next_pns_code = (int) $pns_latest;
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
                echo $pre.date('ymd').'-'.$new_pns_code;
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
                $db->setQuery("INSERT INTO apdm_pns_sto (sto_code,sto_description,sto_state,sto_created,sto_create_by,sto_type,sto_stocker,sto_supplier_id,sto_po_internal) VALUES ('" . $sto_code . "', '" . $post['sto_description'] . "', '" . $sto_state . "', '" . $datenow->toMySQL() . "', '" . $me->get('id') . "',1,'".$me->get('id')."','".$post['supplier_id']."','".$post['po_inter_code']."')");
                $db->query();
				
                //getLast ITO ID
                $ito_id = $db->insertid();
                if($ito_id)
                {

                        $path_upload = JPATH_SITE . DS . 'uploads' . DS . 'sto' . DS . $post['sto_code'];
                       

                        $path_so_zips = $path_upload  .DS .'zips'. DS;
                        $upload = new upload($_FILES['']);
                        $upload->r_mkdir($path_so_zips, 0777);                        
                        $arr_file_upload = array();
                        $arr_error_upload_zips = array();
                        for ($i = 1; $i <= 20; $i++) {        
               
                                if ($_FILES['pns_zip' . $i]['size'] > 0) {
                                        if (!move_uploaded_file($_FILES['pns_zip' . $i]['tmp_name'], $path_so_zips . $_FILES['pns_zip' . $i]['name'])) {
                                                $arr_error_upload_zips[] = $_FILES['pns_zip' . $i]['name'];
                                        } else {
                                                $arr_file_upload[] = $_FILES['pns_zip' . $i]['name'];
                                        }
                                }
                        }

                        if (count($arr_file_upload) > 0) {
                                foreach ($arr_file_upload as $file) {									
                                        $db->setQuery("INSERT INTO apdm_pns_sto_files (sto_id, file_name,file_type, sto_file_created, sto_file_created_by) VALUES (" . $ito_id . ", '" . $file . "',0, '" . $datenow->toMySQL() . "', " . $me->get('id') . " ) ");
										 echo $db->getQuery();die;
                                        $db->query();
                                }
                        }
                        //for upload file image
                        ///for pns cads/image/pdf
                       //upload new images
                        $path_so_images = $path_upload  .DS.'images'. DS;
                        $upload = new upload($_FILES['']);
                        $upload->r_mkdir($path_so_images, 0777);
                        $arr_error_upload_image = array();
                        $arr_image_upload = array();
                        for ($i = 1; $i <= 20; $i++) {
                                if ($_FILES['pns_image' . $i]['size'] > 0) {
                                        $imge = new upload($_FILES['pns_image' . $i]);
                                        $imge->file_new_name_body = $soNumber . "_" . time()."_".$i;    
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
                        $path_so_pdfs = $path_upload  .DS . 'pdfs'. DS;
                        $upload = new upload($_FILES['']);
                        $upload->r_mkdir($path_so_pdfs, 0777);
                        $arr_error_upload_pdf = array();
                        $arr_pdf_upload = array();
                        for ($i = 1; $i <= 20; $i++) {
                                if ($_FILES['pns_pdf' . $i]['size'] > 0) {
                                        $imge = new upload($_FILES['pns_pdf' . $i]);
                                        $imge->file_new_name_body = $soNumber . "_" . time()."_".$i;                                       

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
                        }
                        if (count($arr_pdf_upload) > 0) {
                                foreach ($arr_pdf_upload as $file) {
                                        $db->setQuery("INSERT INTO apdm_pns_sto_files (sto_id, file_name,file_type, sto_file_created, sto_file_created_by) VALUES (" . $ito_id . ", '" . $file . "',1, '" . $datenow->toMySQL() . "', " . $me->get('id') . " ) ");
                                        $db->query();
                                }
                        }                        
                        
                     
                }//for save database of pns 				
				
                $msg = "Successfully Saved ITO";
                $this->setRedirect('index.php?option=com_apdmsto&task=ito_detail', $msg);
                exit;
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
}
