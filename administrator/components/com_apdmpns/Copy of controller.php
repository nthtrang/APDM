<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');
require_once('includes/class.upload.php');
require_once('includes/download.class.php');
require_once('includes/zip.class.php'); 
require_once('includes/system_defines.php'); 
ini_set('display_errors', 1);
/**
 * PNS Component Controller
 *
 * @package		APDM
 * @subpackage	PNS
 * @since 1.5
 */
 
class PNsController extends JController
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
		$this->registerTask( 'edit'  , 	'display'  );
        $this->registerTask( 'detail'  ,     'display'  ); 
		$this->registerTask( 'apply', 	'save'  );
		$this->registerTask( 'remove_info', 'remove_info');
		$this->registerTask( 'unblock', 'block' );
        $this->registerTask( 'listpns', 'list_pns' );
        $this->registerTask( 'export', 'export' ); 
        $this->registerTask( 'multi_upload', 'multi_upload' );
        $this->registerTask( 'next_upload', 'next_upload' );
        $this->registerTask( 'next_upload_step2', 'next_upload_step2' );  
        $this->registerTask( 'ajax_list_pns', 'ajax_list_pns' );  
        
                                
        //$this->registerTask('edit_pns', 'edit_pns');
	}

	/**
	 * Displays a view
	 */
	function display( )
	{
		switch($this->getTask())
		{
			case 'add'     :
			{	
			
				JRequest::setVar( 'layout', 'form'  );
				JRequest::setVar( 'view', 'pns_info' );
				JRequest::setVar( 'edit', false );
				
			} break;
			case 'edit'    :
			{
				
				JRequest::setVar( 'layout', 'form_edit'  );
				JRequest::setVar( 'view', 'pns_info' );
				JRequest::setVar( 'edit', true );
			} break;
            case 'detail':
            {
                
                JRequest::setVar( 'layout', 'detail'  );
                JRequest::setVar( 'view', 'pns_info' );
                JRequest::setVar( 'edit', true );
            }
            break;
		}

		parent::display();
	}
    function  list_pns(){
        JRequest::setVar('layout', 'default');
        JRequest::setVar('view', 'listpns');
        parent::display();
    }
     function download_all_cads(){
        JRequest::setVar('layout', 'default');
        JRequest::setVar('view', 'download');
        parent::display();
    }
    function multi_upload(){
        JRequest::setVar('layout', 'default');
        JRequest::setVar('view', 'multi_uploads');
        parent::display();
    }
    function next_upload(){
       //$type_upload = JRequest::getVar('type_upload');
       JRequest::setVar('layout', 'list_pns');
       JRequest::setVar('view', 'multi_uploads');
        parent::display();
    }
    function next_upload_step2(){
       //$type_upload = JRequest::getVar('type_upload');
       JRequest::setVar('layout', 'from_upload_pdf');
       JRequest::setVar('view', 'multi_uploads_form');
        parent::display();
    }
    function next_upload_step1(){
        JRequest::setVar('layout', 'from_upload_cad');
       JRequest::setVar('view', 'multi_uploads_form');
        parent::display();
    }
     //for display view list child
    function get_list_child(){
        JRequest::setVar( 'layout', 'default'  );
        JRequest::setVar( 'view', 'getpnschild' );
        parent::display();
    }
    //funcntion get list PNs child
    function ajax_list_pns(){
       
        $db       =& JFactory::getDBO();
        $cid      = JRequest::getVar( 'cid', array(), '', 'array' );        
        $query    = "select pns_id, CONCAT_WS( '-', ccs_code, pns_code, pns_revision) AS pns_full_code FROM apdm_pns WHERE pns_id IN (".implode(",", $cid).")";               
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        $str  = '';
        foreach ($rows as $row){
            $str .= '<p><input checked="checked" type="checkbox" name="pns_child[]" value="'.$row->pns_id.'" /> '.$row->pns_full_code.'</p>';
        }
        echo $str;
        exit;
        
    }
    function save_multi_upload_cad_1 (){
        global $mainframe;
       $db            = & JFactory::getDBO();
       $pns_id = JRequest::getVar('pns_id',  array(), '', 'array'); 
       $pns_code = JRequest::getVar('pns_code',  array(), '', 'array'); 
       $ccs_code = JRequest::getVar('ccs_code',  array(), '', 'array');            
       $path_pns = JPATH_SITE.DS.'uploads'.DS.'pns'.DS.'cads'.DS;  
       $me            = & JFactory::getUser(); 
       $datenow    =& JFactory::getDate(); 
       $pns_cads = array();
       for ($i=0; $i <count($pns_id); $i++){
               $cadfile = 'pns_cad';
               $path_cad = $path_pns.DS.$ccs_code[$i].DS.$pns_code[$i].DS;
               
               if ($_FILES[$cadfile]['size'] > 0){
                   $handle = new Upload($_FILES[$cadfile]);
                   if ($handle->uploaded){
                       $handle->process($path_cad);
                       if ($handle->processed){
                           $file_cad_name = $handle->file_dst_name;
                           $pns_cads[]  = array('pns_id'=>$pns_id[$i], 'cad_file'=>$file_cad_name, 'date_create'=>$datenow->toMySQL(), 'created_by'=>$me->get('id'));
                       }
                       
                   }
               }
          
       }
       //save information in the table apdm_pns_cad
       foreach($pns_cads as $obj){
           $query = "INSERT INTO apdm_pn_cad (pns_id, cad_file, date_create, created_by) VALUES (".$obj['pns_id'].", '".$obj['cad_file']."', '".$obj['date_create']."', ".$obj['created_by'].")";
           $db->setQuery($query);
           $db->query();
       }
       JRequest::setVar('layout', 'default');
       JRequest::setVar('view', 'multi_uploads_form');
        parent::display();
        
    }
    function save_multi_upload_pdf(){
       global $mainframe;
       $db            = & JFactory::getDBO();
       $pns_id = JRequest::getVar('pns_id',  array(), '', 'array'); 
       $pns_code = JRequest::getVar('pns_code',  array(), '', 'array');  
                        
       $path_pns = JPATH_SITE.DS.'uploads'.DS.'pns'.DS.'pdf'.DS;  
       for ($i = 0; $i <count($pns_id); $i++){
           $db->setQuery("SELECT pns_pdf FROM apdm_pns WHERE pns_id=".$pns_id[$i]);
           $pns_pdf = $db->loadResult();
           if ($pns_pdf) {
                if (file_exists($path_pns.$pns_pdf)) {
                      @unlink($path_pns.$pns_pdf);
                }  
           }
           $file_name = 'file'.$pns_id[$i];
           if ($_FILES[$file_name]['size'] > 0){                  
               //upload file
               $upload_pdf = new Upload($_FILES[$file_name]);
              
               $upload_pdf->file_new_name_body = $pns_code[$i];     
                           
               if($upload_pdf->uploaded){
                   $upload_pdf->process($path_pns);
                  // print_r($upload_pdf); exit;
                   if ($upload_pdf->processed){
                       $pns_pdf = $upload_pdf->file_dst_name;
                       //update database 
                       $query = "UPDATE apdm_pns SET pns_pdf='".$pns_pdf."' WHERE pns_id=".$pns_id[$i];
                       $db->setQuery($query);
                       $db->query();
                     
                   }
                }  
           }
       }
       JRequest::setVar('layout', 'default');
       JRequest::setVar('view', 'multi_uploads_form');
        parent::display();
       
    }
    function save_multi_upload_cad(){
       global $mainframe;
       $db            = & JFactory::getDBO();
       $pns_id = JRequest::getVar('pns_id',  array(), '', 'array'); 
       $pns_code = JRequest::getVar('pns_code',  array(), '', 'array');    
       $ccs_code = JRequest::getVar('ccs_code',  array(), '', 'array');      
       $path_pns = JPATH_SITE.DS.'uploads'.DS.'pns'.DS.'cads'.DS;  
       $me            = & JFactory::getUser(); 
       $datenow    =& JFactory::getDate(); 
       $pns_cads = array();
       for ($i=0; $i <count($pns_id); $i++){
           for ($j = 1; $j <= 20; $j++){
               $cadfile = 'pns_cad'.$j.$pns_id[$i];
               $path_cad = $path_pns.DS.$ccs_code[$i].DS.$pns_code[$i].DS;
               if ($_FILES[$cadfile]['size'] > 0){
			   		if (!move_uploaded_file($_FILES[$cadfile]['tmp_name'], $path_cad.$_FILES[$cadfile]['name'])){
				  		$arr_error_upload_cads[] = $_FILES[$cadfile]['name'];
				  }else{
				  		$file_cad_name = $_FILES[$cadfile]['name'];
						$pns_cads[]  = array('pns_id'=>$pns_id[$i], 'cad_file'=>$file_cad_name, 'date_create'=>$datenow->toMySQL(), 'created_by'=>$me->get('id'));
				  }
			   
			   
                  /* $handle = new Upload($_FILES[$cadfile]);
                   if ($handle->uploaded){
                       $handle->process($path_cad);
                       if ($handle->processed){
                           $file_cad_name = $handle->file_dst_name;
                           $pns_cads[]  = array('pns_id'=>$pns_id[$i], 'cad_file'=>$file_cad_name, 'date_create'=>$datenow->toMySQL(), 'created_by'=>$me->get('id'));
                       }
                       
                   }*/
               }
           }
       }
       //save information in the table apdm_pns_cad
       foreach($pns_cads as $obj){
           $query = "INSERT INTO apdm_pn_cad (pns_id, cad_file, date_create, created_by) VALUES (".$obj['pns_id'].", '".$obj['cad_file']."', '".$obj['date_create']."', ".$obj['created_by'].")";
           $db->setQuery($query);
           $db->query();
       }
       JRequest::setVar('layout', 'default');
       JRequest::setVar('view', 'multi_uploads_form');
        parent::display();
       
    }
    function rev_roll(){
        global $arrCharacter;
        $db         =& JFactory::getDBO();              
       // $arrLast    = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'K', 'L', 'M', 'N', 'P', 'R', 'T', 'V', 'Y', 'Z');
        $pns_code   = JRequest::getVar('pns_code');
        $ccs_code   = JRequest::getVar('ccs_code');
        $query      = "SELECT pns_revision FROM apdm_pns WHERE ccs_code='".$ccs_code."' AND pns_code='".$pns_code."' AND pns_deleted=0 order by pns_revision DESC LIMIT 0, 1";
        $db->setQuery($query);
        $rows       = $db->loadObjectList();
        $last_revision = trim($rows[0]->pns_revision);
        $firstChar     = $last_revision{0};
        $lastChar      = $last_revision{1};
        $newfirstChar  = '';
        $newLastChar   = '';
        //check for last char
        $i = 0;
        $itemp = 0;
        foreach ($arrCharacter as $char){
            if ($char == $lastChar){
                $itemp = $i;
            }
            $i++;
        }
             
        if ($itemp == count($arrCharacter)-1){ //last char of array
                $newLastChar = 'A';
                
                //get new first Char
                $j = 0;
                $jTemp = 0;
                foreach ($arrCharacter as $char_first){
                        if ($char_first == $firstChar){
                            $jTemp = $j;
                        }
                       $j++;
                }
             
                if ($jTemp == count($arrCharacter) -1 ){
                    $newfirstChar = '0';
                }else{
                    $newfirstChar = $arrCharacter[$jTemp+1];
                }
        }else{
            $newfirstChar = $firstChar;
            $newLastChar  = $arrCharacter[$itemp+1];
        }
         $new_code = $newfirstChar.$newLastChar;
        
        
        
        //for change by request Khang
        /*
        $arrExist   = array();
        if (count($rows) > 0){
            foreach ($rows as $row){
                $arrExist[] = $row->pns_revision;
            }
        }
        $new_code  = PNsController::RandomRevision();             
        if (count($arrExist) > 0 && in_array($new_code, $arrExist)){
            $new_code  = PNsController::RandomRevision();
        } */                                           
        echo   $new_code;
        exit;
		
        
        
    }
    function RandomRevision(){
         $arrChar   = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'K', 'L', 'M', 'N', 'P', 'R', 'T', 'V', 'Y', 'Z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'K', 'L', 'M', 'N', 'P', 'R', 'T', 'V', 'Y', 'Z'); 
         //new code random
        $arr_get = array_rand($arrChar, 2); 
        $arr_result = array();
        foreach ($arr_get as $key){
            $arr_result[] = $arrChar[$key];
        }
        $new_code = implode("", $arr_result);    
        return $new_code;
    }
    
	function code_default(){		
		//$arr_char = array('A', 'A', 'A','A', 'A', 'A','B', 'B', 'B', 'B', 'B', 'B', 'C','C','C','C','C','C', 'D','D','D', 'D','D','D', 'E','E','E', 'E','E','E', 'F','F', 'F', 'F','F', 'F', 'G','G','G', 'G','G','G', 'H','H','H', 'H','H','H', 'I', 'I', 'I', 'I', 'I', 'I', 'J','J','J', 'J','J','J', 'K','K', 'K', 'K','K', 'K', 'M','M','M', 'M','M','M', 'N', 'N', 'N', 'N', 'N', 'N', 'O','O','O', 'O','O','O', 'P','P','P', 'P','P','P', 'Q','Q','Q', 'Q','Q','Q', 'R','R', 'R', 'R','R', 'R', 'S','S','S', 'S','S','S', 'T','T','T', 'T','T','T', 'U','U','U', 'U','U','U', 'V','V', 'V', 'V','V', 'V','W','W','W', 'W','W','W', 'X','X','X', 'X','X','X', 'Y','Y','Y', 'Y','Y','Y', 'Z','Z','Z', 'Z','Z','Z', '1', '1', '1', '1', '1', '1', '2', '2', '2', '2', '2', '2', '3', '3', '3', '3', '3', '3','4', '4', '4', '4', '4', '4', '5', '5', '5', '5', '5', '5', '6', '6', '6', '6', '6', '6', '7', '7', '7', '7', '7', '7', '8', '8', '8', '8', '8', '8', '9', '9', '9', '9', '9', '9', '0', '0', '0', '0', '0', '0',);
        $arr_char = array('1', '1', '1', '1', '1', '1', '2', '2', '2', '2', '2', '2', '3', '3', '3', '3', '3', '3','4', '4', '4', '4', '4', '4', '5', '5', '5', '5', '5', '5', '6', '6', '6', '6', '6', '6', '7', '7', '7', '7', '7', '7', '8', '8', '8', '8', '8', '8', '9', '9', '9', '9', '9', '9', '0', '0', '0', '0', '0', '0');
		$arr_get = array_rand($arr_char, 6);
		$arr_result = array();
		foreach ($arr_get as $obj){
			$arr_result[] = $arr_char[$obj];
		}		
		$code = implode("", $arr_result);		
		echo $code;
		exit;
	}

	/**
	 * Saves the record
	 */
	function save()
	{
		global $mainframe;
        $pns_parent = JRequest::getVar('pns_parent',  array(), '', 'array');
        $pns_child  = JRequest::getVar('pns_child',  array(), '', 'array');
        // Initialize some variables
		$db			= & JFactory::getDBO();
		$me			= & JFactory::getUser();
		$row        = & JTable::getInstance('apdmpns');
        $datenow    =& JFactory::getDate(); 
        $post       =  JRequest::get('post');
        if (! $row->bind($post)){
            JError::raiseError( 500, $db->stderr() );
            return false;
        }
        $row->pns_id = (int) $row->pns_id;
        $isNew = true;
        $pns_code = trim($post['pns_code']);
        //check pns_code
        if (strlen($pns_code) < 6){
            $new = '';
            for($i =0; $i < 6-strlen($pns_code); $i++){
                $new .='0'; 
            }
        }
        $pns_code = $new.$pns_code;        
        $pns_version = $post['pns_version'];
        $pns_revision = ($post['pns_revision'] !='') ? strtoupper ($post['pns_revision']) : 'AA';        
       
        $pns_code_check = $pns_code."-".$pns_version;
    
        //check for pns code in database
        if($pns_revision != "") {
            $query_check = "SELECT pns_id FROM apdm_pns WHERE ccs_code=".$row->ccs_code." AND pns_code = ".$pns_code." AND pns_revision=".$pns_revision;
        }else{
            $query_check = "SELECT pns_id FROM apdm_pns WHERE ccs_code=".$row->ccs_code." AND pns_code = ".$pns_code;    
        }
        $db->setQuery($query_check);
        $result = $db->loadResult();
        if ($result){
            $msg = JText::_('This Part Number Have exist. Please check list again. (Please check witd administrator if you dont found.)');
            $this->setRedirect('index.php?option=com_apdmpns');
        }
        $row->pns_code = $pns_code_check;
        //get ccs 
       // $db->setQuery("SELECT ccs_code FROM apdm_ccs WHERE ccs_id=".$row->ccs_id);
        $ccs_code = $row->ccs_code;
        //for upload file image
        $path_pns = JPATH_SITE.DS.'uploads'.DS.'pns'.DS;    
        if($_FILES['pns_imge']['size'] > 0){
            $imge = new upload($_FILES['pns_imge']);
            if ($pns_revision !="") {
                $imge->file_new_name_body = $ccs_code."-".$pns_code_check."-".$pns_revision;
            }else{
                $imge->file_new_name_body = $ccs_code."-".$pns_code_check;
            }
            if ($imge->uploaded){
                $imge->Process($path_pns.'images'.DS);
                if ($imge->processed){
                    $pns_imge = $imge->file_dst_name;
                }
            }
            
        }else{
            $pns_imge = '';
        }
        //upload file pdf
        if ($_FILES['pns_pdf']['size'] > 0){
            $pdf = new upload($_FILES['pns_pdf']);
            if ($pns_revision !=""){
                $pdf->file_new_name_body = $ccs_code."-".$pns_code_check."-".$pns_revision;
            }else{
                $pdf->file_new_name_body = $ccs_code."-".$pns_code_check;
            }
            if ($pdf->uploaded){
                $pdf->process($path_pns.'pdf'.DS);
                if ($pdf->processed){
                    $pns_pdf = $pdf->file_dst_name;
                }
            }
            
        }else{
            $pns_pdf = '';
        }
        $row->pns_create = $datenow->toMySQL();
        $row->pns_image  = $pns_imge;
        $row->pns_pdf    = $pns_pdf;
        $row->pns_create_by = $me->get('id');      
        $row->pns_revision  = $pns_revision;              
        //save information of Pns in datbase
        if (!$row->store()) {
            JError::raiseError( 500, $db->stderr() );
            return false;
        }else{
        ///for cad file   
        //create folder for this pns
        if ($pns_revision) {
            $folder =   $ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision;     
        }else{
            $folder =   $ccs_code.'-'.$row->pns_code;
        }
        $path_pns_cads = $path_pns.'cads'.DS.$ccs_code.DS.$folder.DS;
        $upload = new upload($_FILES['']);
        $upload->r_mkdir($path_pns_cads, 0777);
        //copy file zip to folder pns_cad
        $file_zip =  $path_pns.'cads'.DS.'zip.php';
        copy($file_zip, $path_pns_cads.'zip.php');
        $arr_file_uplad = array();
		$arr_error_upload_cads = array();
           for($i=1; $i <= 20; $i++){   
              if ($_FILES['pns_cad'.$i]['size'] > 0){
			  	  if (!move_uploaded_file($_FILES['pns_cad'.$i]['tmp_name'], $path_pns_cads.$_FILES['pns_cad'.$i]['name'])){
				  		$arr_error_upload_cads[] = $_FILES['pns_cad'.$i]['name'];
				  }else{
				  		$arr_file_uplad[] = $_FILES['pns_cad'.$i]['name'];
				  }
                  /*$cad = new upload($_FILES['pns_cad'.$i]);
                  if($cad->uploaded){
                      $cad->process($path_pns_cads);
                      if($cad->processed){
                          $arr_file_uplad[] = $cad->file_dst_name;
                      }
                  }
                  */
              }
           }
          
            if (count($arr_file_uplad) > 0){
                foreach ($arr_file_uplad as $file){
                    $db->setQuery("INSERT INTO apdm_pn_cad (pns_id, cad_file, date_create, created_by) VALUES (".$row->pns_id.", '".$file."', '".$datenow->toMySQL()."', ".$me->get('id')." ) ");
                    $db->query();
                }
            }
            //for vendor    vendor_info
            $vendors  = JRequest::getVar( 'vendor_id', array(), '', 'array' ); 
            $vendors_infos  = JRequest::getVar( 'vendor_info', array(), '', 'array' );   
            if (count($vendors) > 0){
                for($i = 0; $i < count($vendors); $i++){
                    if ($vendors[$i] > 0){
                        $query = 'INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES ('.$row->pns_id.', '.$vendors[$i].', "'.$vendors_infos[$i].'", 2)';
                        $db->setQuery($query);
                        $db->query();
                    }
                }
            }
            //for supplier
            $supplier  = JRequest::getVar( 'supplier_id', array(), '', 'array' ); 
            $supplier_info  = JRequest::getVar( 'spp_info', array(), '', 'array' );   
            if (count($supplier) > 0){
                for($i = 0; $i < count($supplier); $i++){
                    if ($supplier[$i] > 0){
                        $query = 'INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES ('.$row->pns_id.', '.$supplier[$i].', "'.$supplier_info[$i].'", 3)';
                        $db->setQuery($query);
                        $db->query();
                    }
                }
            }
            //for manufacture
            $manufacture  = JRequest::getVar( 'manufacture_id', array(), '', 'array' ); 
            $mf_info  = JRequest::getVar( 'mf_info', array(), '', 'array' );   
            if (count($manufacture) > 0){
                for($i = 0; $i < count($manufacture); $i++){
                    if ($manufacture[$i] > 0){
                        $query = 'INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES ('.$row->pns_id.', '.$manufacture[$i].', "'.$mf_info[$i].'", 4)';
                        $db->setQuery($query);
                        $db->query();
                    }
                }
            }
          //for parent of pns
          $arr_pns_waring = array();
          $arr_parent_id = array();
          if (count($pns_child) > 0){
              foreach ($pns_child as $pn) {
                  $db->setQuery("INSERT INTO apdm_pns_parents (pns_id, pns_parent) VALUES (".$pn.", ".$row->pns_id.")");
                  $db->query();
              }
          }
        /*  if(count($pns_parent) > 0) {  
             for($i=0; $i <count($pns_parent); $i++){
                 if ($pns_parent[$i] !="") {
                     $pns_parent_get = explode("-",$pns_parent[$i]);
                     $ccs_code_parent = $pns_parent_get[0];
                     $pns_code_get   = $pns_parent_get[1].'-'.$pns_parent_get[2];
                     $pns_revision_get = $pns_parent_get[3];
                     $db->setQuery("SELECT ccs_id FROM apdm_ccs WHERE ccs_deleted=0 AND ccs_activate = 1 AND ccs_code ='".$ccs_code_parent."'");
                     $ccs_id_get = $db->loadResult();
                     if ($ccs_id_get){
                         $db->setQuery("SELECT pns_id FROM apdm_pns WHERE ccs_code=".$ccs_code_parent." AND pns_code='".$pns_code_get."' AND pns_revision ='".$pns_revision_get."' AND pns_deleted = 0 AND pns_id !=".$row->pns_id );
                         $pns_parent_id_get = $db->loadResult();
                         if ($pns_parent_id_get){
                           //  $arr_parent_id[] = $pns_parent_id_get;
                           $db->setQuery("INSERT INTO apdm_pns_parents (pns_id, pns_parent) VALUES (".$row->pns_id.", ".$pns_parent_id_get.")");
                           $db->query();
                         }else{
                             $arr_pns_waring[] = array("pns"=>$pns_parent[$i], 'mess'=>'This PNs do not exist.'); 
                         }
                         
                     }else{
                        $arr_pns_waring[] = array("pns"=>$pns_parent[$i], 'mess'=>'This PNs do not exist.'); 
                     }
               }
             }
             
          }      */
        }//for save database of pns 
         $text_mess = '';
        if (count($arr_pns_waring) > 0){
            $text_mess = JText::_(' You have missing with some add PNs Parent below: ');
            foreach ($arr_pns_waring as $aaa){
                $text_mess .= '"'.$aaa['pns'].'" => '.$aaa['mess'].'; ';
            }
        }
		if (count($arr_error_upload_cads) >0){
			$text_mess .= JText::_(' Some file CADs can not upload.');
			$text_mess .= '( '.implode(";", $arr_error_upload_cads).')';
		}
		 ///update history
         JAdministrator::HistoryUser(6, 'W', $row->pns_id);
		switch ( $this->getTask() )
		{
			case 'apply':
				$msg = JText::_( 'Successfully Saved Part Number' ).$text_mess;
				$this->setRedirect( 'index.php?option=com_apdmpns&task=detail&cid[0]='.$row->pns_id, $msg );
				break;

			case 'save':
			default:
				$msg = JText::_( 'Successfully Saved Part Number' ).': '.$row->ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision.' '.$text_mess;

				$this->setRedirect( 'index.php?option=com_apdmpns&task=add', $msg );
				break;
		}
	}
    /**
    * @desc save edit pns
    */
    function edit_pns(){
        
        global $mainframe;
         // Initialize some variables
        $db            = & JFactory::getDBO();
        $me            = & JFactory::getUser();
        $row        = & JTable::getInstance('apdmpns');
        $datenow    =& JFactory::getDate(); 
        $post       =  JRequest::get('post');
        
        $pns_parent = JRequest::getVar('pns_parent',  array(), '', 'array');
        $pns_child = JRequest::getVar('pns_child',  array(), '', 'array');
        $pns_revision_old  = JRequest::getVar('pns_revision_old');
        $pns_revision  = JRequest::getVar('pns_revision');
        $pns_code = JRequest::getVar('pns_code');
        $ccs_code  = JRequest::getVar('ccs_code');
       // $db->setQuery("SELECT ccs_code FROM apdm_ccs WHERE ccs_id=".$ccs_id);
     //   $ccs_code = $db->loadResult();
       
        
        if (! $row->bind($post)){
            JError::raiseError( 500, $db->stderr() );
            return false;
        } 
        
        $path_pns = JPATH_SITE.DS.'uploads'.DS.'pns'.DS;    
        
        if ($pns_revision ==$pns_revision_old ){
        //no change pns revision
           if($_FILES['pns_imge']['size'] > 0){
            $imge = new upload($_FILES['pns_imge']);
            if ($pns_revision !="") {                
                $imge->file_new_name_body = $ccs_code."_".str_replace("-", "_", $pns_code)."_".$pns_revision;
            }else{
                $imge->file_new_name_body = $ccs_code."_".str_replace("-", "_", $pns_code);
            }
          
            if (file_exists($path_pns.'images'.DS.$imge->file_new_name_body.".".$imge->file_src_name_ext)) {
                
                @unlink($path_pns.'images'.DS.$imge->file_new_name_body.".".$imge->file_src_name_ext);
            }
            if ($imge->uploaded){
                $imge->Process($path_pns.'images'.DS);
                if ($imge->processed){
                    $pns_imge = $imge->file_dst_name;
                }
            }
            
        }else{
            $pns_imge = JRequest::getVar('old_pns_image');
        }
        //upload file pdf
        if ($_FILES['pns_pdf']['size'] > 0){
            $pdf = new upload($_FILES['pns_pdf']);
            if ($pns_revision !=""){              
                $pdf->file_new_name_body = $ccs_code."_".str_replace("-", "_",$pns_code)."_".$pns_revision;
                
            }else{
                $pdf->file_new_name_body = $ccs_code."_".str_replace("-", "_",$pns_code);
              
            }   
             if (file_exists($path_pns.'pdf'.DS.$pdf->file_new_name_body.'.'.$pdf->file_src_name_ext)) { 
           
                unlink($path_pns.'pdf'.DS.$pdf->file_new_name_body.'.'.$pdf->file_src_name_ext);
           
            }
            if ($pdf->uploaded){
                $pdf->process($path_pns.'pdf'.DS);
                if ($pdf->processed){
                    $pns_pdf = $pdf->file_dst_name;
                }
            }
            
        }else{
            $pns_pdf = JRequest::getVar('old_pns_pdf');   
        } 
           $row->pns_modified = $datenow->toMySQL();
           $row->pns_modified_by = $me->get('id'); 
           $row->pns_image = $pns_imge;
           $row->pns_pdf = $pns_pdf;
           if (!$row->store()){
              $msg = JText::_( 'Successfully Saved Part Number' );
              $this->setRedirect('index.php?option=com_apdmpns&task=edit&cid[]='.$row->pns_id, $msg);  
           }
           //for pans parent
           //for parent of pns
          $arr_pns_waring = array();
          $arr_parent_id = array();
          if (count($pns_child) > 0){
              foreach ($pns_child as $child){
                  $db->setQuery("INSERT INTO apdm_pns_parents (pns_id, pns_parent) VALUES (".$child.", ".$row->pns_id.")" );
                  $db->query();
              }
          }
       
           ///for vendor and supplier and manufacture
           $v_exist         = JRequest::getVar('v_exist',  array(), '', 'array'); 
           $v_exist_value   = JRequest::getVar('v_exist_value',  array(), '', 'array');
           $vendor_id       = JRequest::getVar('vendor_id',  array(), '', 'array');  
           $vendor_info     = JRequest::getVar('vendor_info',  array(), '', 'array'); 
           
           $s_exist         = JRequest::getVar('s_exist',  array(), '', 'array'); 
           $s_exist_value   = JRequest::getVar('s_exist_value',  array(), '', 'array');            
           $supplier_id     = JRequest::getVar('supplier_id',  array(), '', 'array');  
           $spp_info        = JRequest::getVar('spp_info',  array(), '', 'array'); 
           
           $m_exist         = JRequest::getVar('m_exist',  array(), '', 'array'); 
           $m_exist_value   = JRequest::getVar('m_exist_value',  array(), '', 'array');            
           $manufacture_id  = JRequest::getVar('manufacture_id',  array(), '', 'array');  
           $mf_info         = JRequest::getVar('mf_info',  array(), '', 'array');
           
           //update vendor
           if (count($v_exist) > 0){           
              
               for($i=0; $i<count($v_exist); $i++){
                   $db->setQuery("UPDATE apdm_pns_supplier SET supplier_info='".$v_exist_value[$i]."' WHERE id=".$v_exist[$i]);
                   $db->query();
               }
           }
           //ad new vendor
           if(count($vendor_id) > 0){
               for($i=0; $i<count($vendor_id); $i++){
                   if ($vendor_id[$i] > 0) {   
                    $db->setQuery("INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (".$row->pns_id.", ".$vendor_id[$i].", '".$vendor_info[$i]."', 2) ");
                    $db->query();
                   }
               }
           }
           //update supplier
            if (count($s_exist) > 0){                          
               for($i=0; $i<count($s_exist); $i++){                  
                   $db->setQuery("UPDATE apdm_pns_supplier SET supplier_info='".$s_exist_value[$i]."' WHERE id=".$s_exist[$i]);
                   $db->query();
                
               }
           }
           //add new supplier
           if(count($supplier_id) > 0){
               for($i=0; $i<count($supplier_id); $i++){
                   if ($supplier_id[$i] > 0) {     
                    $db->setQuery("INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (".$row->pns_id.", ".$supplier_id[$i].", '".$spp_info[$i]."', 3) ");
                    $db->query();
                   }
               }
           }
            //update manufacture
            if (count($m_exist) > 0){                          
               for($i=0; $i<count($m_exist); $i++){
                   $db->setQuery("UPDATE apdm_pns_supplier SET supplier_info='".$m_exist_value[$i]."' WHERE id=".$m_exist[$i]);
                   $db->query();
               }
           }
           //add new manufacture
           if(count($manufacture_id) > 0){
               for($i=0; $i<count($manufacture_id); $i++){
                   if ($manufacture_id[$i] > 0) {
                    $db->setQuery("INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (".$row->pns_id.", ".$manufacture_id[$i].", '".$mf_info[$i]."', 4) ");
                    $db->query();
                   }
               }
           }
         ///for pns cads
          if ($pns_revision) {
            $folder =   $ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision;     
          }else{
            $folder =   $ccs_code.'-'.$row->pns_code;
         }
        $path_pns_cads = $path_pns.'cads'.DS.$ccs_code.DS.$folder.DS;
		$arr_error_upload_cads = array();
         $arr_file_uplad = array();
           for($i=1; $i <= 20; $i++){   
              if ($_FILES['pns_cad'.$i]['size'] > 0){
                  $cad = new upload($_FILES['pns_cad'.$i]);
                //  $cad->f = basename($_FILES['pns_cad'.$i]['name']);
                 // print_r($cad); exit;
                  if (file_exists($path_pns_cads.$_FILES['pns_cad'.$i]['name'])){
                      @unlink($path_pns_cads.$_FILES['pns_cad'.$i]['name']);
                  }
				  if (!move_uploaded_file($_FILES['pns_cad'.$i]['tmp_name'], $path_pns_cads.$_FILES['pns_cad'.$i]['name'])){
				  		$arr_error_upload_cads[] = $_FILES['pns_cad'.$i]['name'];
				  }else{
				  		$arr_file_uplad[] = $_FILES['pns_cad'.$i]['name'];
				  }
                 // PNsController::upload_cad($_FILES['pns_cad'.$i]['name'], $path_pns_cads)  ;
                  //$arr_file_uplad[] = $_FILES['pns_cad'.$i]['name'];
               /*   if($cad->uploaded){
                      $cad->process($path_pns_cads);
                      if($cad->processed){
                          $arr_file_uplad[] = $cad->file_dst_name;
                      }
                  } */
                  
              }
           }
          
            if (count($arr_file_uplad) > 0){
                foreach ($arr_file_uplad as $file){
                    $db->setQuery("INSERT INTO apdm_pn_cad (pns_id, cad_file, date_create, created_by) VALUES (".$row->pns_id.", '".$file."', '".$datenow->toMySQL()."', ".$me->get('id')." ) ");
                    $db->query();
                }
            }
             ///update history
             JAdministrator::HistoryUser(6, 'E', $row->pns_id);
               $text_mess = '';
            if (count($arr_pns_waring) > 0){
                $text_mess = JText::_(' You have missing with some add PNs Parent below: ');
                foreach ($arr_pns_waring as $aaa){
                    $text_mess .= '"'.$aaa['pns'].'" => '.$aaa['mess'].'; ';
                }
            }
             $msg = JText::_( 'Successfully Saved Part Number' ).$text_mess;
             $this->setRedirect('index.php?option=com_apdmpns&task=edit&cid[]='.$row->pns_id, $msg);          
        }else{ //to change pns revision
           //ad new pns with 
           $pns_id_exist = $row->pns_id;         
                         
           $row->pns_id = 0;
           $row->pns_create = $datenow->toMySQL();
           $row->pns_create_by = $me->get('id');           
           $row->ccs_code = $ccs_code;
           $row->pns_code =  $pns_code;
           $row->pns_revision = strtoupper($pns_revision);     
           $row->pns_deleted = 0;
           if($_FILES['pns_imge']['size'] > 0){
            $imge = new upload($_FILES['pns_imge']);
            $imge->file_new_name_body = $ccs_code."_".str_replace("-", "_", $pns_code)."_".$pns_revision;           
            if (file_exists($path_pns.'images'.DS.$imge->file_new_name_body.".".$imge->file_src_name_ext)) {                
                @unlink($path_pns.'images'.DS.$imge->file_new_name_body.".".$imge->file_src_name_ext);
            }
            if ($imge->uploaded){
                $imge->Process($path_pns.'images'.DS);
                if ($imge->processed){
                    $pns_imge = $imge->file_dst_name;
                }
            }
            
        }else{
            ///copy new file image
            $pns_imge_old = JRequest::getVar('old_pns_image');
            $copy_img = new upload($path_pns.'images'.DS.$pns_imge_old);
            $copy_img->file_new_name_body = $ccs_code."_".str_replace("-", "_", $pns_code)."_".$pns_revision;              
            if (file_exists($path_pns.'images'.DS.$copy_img->file_new_name_body.".".$copy_img->file_src_name_ext)) {                
                @unlink($path_pns.'images'.DS.$copy_img->file_new_name_body.".".$copy_img->file_src_name_ext);
            }
            if($copy_img->uploaded){
                $copy_img->process($path_pns.'images'.DS);
                   
                if($copy_img->processed){
                    $pns_imge = $copy_img->file_dst_name;    
                }
            }
            
        }
        //upload file pdf
        if ($_FILES['pns_pdf']['size'] > 0){
            $pdf = new upload($_FILES['pns_pdf']);
            $pdf->file_new_name_body = $ccs_code."_".str_replace("-", "_",$pns_code)."_".$pns_revision;               
             if (file_exists($path_pns.'pdf'.DS.$pdf->file_new_name_body.'.'.$pdf->file_src_name_ext)) {            
                @unlink($path_pns.'pdf'.DS.$pdf->file_new_name_body.'.'.$pdf->file_src_name_ext);                   
            }
            if ($pdf->uploaded){
                $pdf->process($path_pns.'pdf'.DS);
                if ($pdf->processed){
                    $pns_pdf = $pdf->file_dst_name;
                }
            }
            
        }else{
            //copy new file pdf
            $pns_pdf_old = JRequest::getVar('old_pns_pdf');  
            $copy_pdf = new upload($path_pns.'pdf'.DS.$pns_pdf_old);               
            $copy_pdf->file_new_name_body = $ccs_code."_".str_replace("-", "_", $pns_code)."_".$pns_revision;             
            
            if (file_exists($path_pns.'pdf'.DS.$copy_pdf->file_new_name_body.".".$copy_pdf->file_src_name_ext)) {                
                @unlink($path_pns.'pdf'.DS.$copy_pdf->file_new_name_body.".".$copy_pdf->file_src_name_ext);
            }
            $copy_pdf->file_new_name_body = $ccs_code."_".str_replace("-", "_", $pns_code)."_".$pns_revision; 
            
            if($copy_pdf->uploaded){
                $copy_pdf->process($path_pns.'pdf'.DS); 
             
                if($copy_pdf->processed){
                    $pns_pdf = $copy_pdf->file_dst_name;    
                }
            } 
            
        } 
           $row->pns_image = $pns_imge;
           $row->pns_pdf = $pns_pdf;
            if (!$row->store()){
              $msg = JText::_( 'Have a problem with Saved Part Number' );
              $this->setRedirect('index.php?option=com_apdmpns&task=edit&cid[]='.$row->pns_id, $msg);  
           }
           //add new pns_paretn
          $arr_pns_waring = array();
          $arr_parent_id = array();
          if (count($pns_child) > 0){
              foreach ($pns_child as $child){
                  $db->setQuery("INSERT INTO apdm_pns_parents (pns_id, pns_parent) VALUES (".$child.", ".$row->pns_id.")" );
                  $db->query();
              }
          }
            ///update history
             JAdministrator::HistoryUser(6, 'W', $row->pns_id);
         
           ///for vendor and supplier and manufacture
           $v_exist_id      = JRequest::getVar('v_exist_id',  array(), '', 'array'); 
           $v_exist_value   = JRequest::getVar('v_exist_value',  array(), '', 'array');
           $vendor_id       = JRequest::getVar('vendor_id',  array(), '', 'array');  
           $vendor_info     = JRequest::getVar('vendor_info',  array(), '', 'array'); 
           
           $s_exist_id      = JRequest::getVar('s_exist_id',  array(), '', 'array'); 
           $s_exist_value   = JRequest::getVar('s_exist_value',  array(), '', 'array');            
           $supplier_id     = JRequest::getVar('supplier_id',  array(), '', 'array');  
           $spp_info        = JRequest::getVar('spp_info',  array(), '', 'array'); 
           
           $m_exist_id      = JRequest::getVar('m_exist_id',  array(), '', 'array'); 
           $m_exist_value   = JRequest::getVar('m_exist_value',  array(), '', 'array');            
           $manufacture_id  = JRequest::getVar('manufacture_id',  array(), '', 'array');  
           $mf_info         = JRequest::getVar('mf_info',  array(), '', 'array');
             //update vendor
           if (count($v_exist_id) > 0){           
              
               for($i=0; $i<count($v_exist_id); $i++){
                   $db->setQuery("INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (".$row->pns_id.", ".$v_exist_id[$i].", '".$v_exist_value[$i]."', 2) ");
                   $db->query();
               }
           }
           //ad new vendor
           if(count($vendor_id) > 0){
               for($i=0; $i<count($vendor_id); $i++){
                   if ($vendor_id[$i] > 0) {   
                    $db->setQuery("INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (".$row->pns_id.", ".$vendor_id[$i].", '".$vendor_info[$i]."', 2) ");
                    $db->query();
                   }
               }
           }
           //update supplier
            if (count($s_exist_id) > 0){                          
               for($i=0; $i<count($s_exist_id); $i++){                  
                    $db->setQuery("INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (".$row->pns_id.", ".$s_exist_id[$i].", '".$s_exist_value[$i]."', 3) ");
                   $db->query();
                
               }
           }
           //add new supplier
           if(count($supplier_id) > 0){
               for($i=0; $i<count($supplier_id); $i++){
                   if ($supplier_id[$i] > 0) {     
                    $db->setQuery("INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (".$row->pns_id.", ".$supplier_id[$i].", '".$spp_info[$i]."', 3) ");
                    $db->query();
                   }
               }
           }
            //update manufacture
            if (count($m_exist_id) > 0){                          
               for($i=0; $i<count($m_exist_id); $i++){
                   $db->setQuery("INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (".$row->pns_id.", ".$m_exist_id[$i].", '".$m_exist_value[$i]."', 4) ");
                   $db->query();
               }
           }
           //add new manufacture
           if(count($manufacture_id) > 0){
               for($i=0; $i<count($manufacture_id); $i++){
                   if ($manufacture_id[$i] > 0) {
                    $db->setQuery("INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (".$row->pns_id.", ".$manufacture_id[$i].", '".$mf_info[$i]."', 4) ");
                    $db->query();
                   }
               }
           }
           //file cad
           //create folder for this pns
        $folder =   $ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision;               
        $path_pns_cads = $path_pns.'cads'.DS.$ccs_code.DS.$folder.DS;
        $upload = new upload($_FILES['']);
        $upload->r_mkdir($path_pns_cads, 0777);
        //copy file zip ne
        $file_zip =   $path_pns.'cads'.DS.'zip.php';
        copy ($file_zip, $path_pns_cads.'zip.php');
        $arr_file_uplad = array();
		$arr_error_upload_cads =array();
           for($i=1; $i <= 20; $i++){   
              if ($_FILES['pns_cad'.$i]['size'] > 0){
			  	 if (!move_uploaded_file($_FILES['pns_cad'.$i]['tmp_name'], $path_pns_cads.$_FILES['pns_cad'.$i]['name'])){
				  		$arr_error_upload_cads[] = $_FILES['pns_cad'.$i]['name'];
				  }else{
				  		$arr_file_uplad[] = $_FILES['pns_cad'.$i]['name'];
				  }
                
              }
           }
           ///move file exist in odl foder to new folder
           $db->setQuery("SELECT * FROM apdm_pn_cad WHERE pns_id=".$pns_id_exist);
           $files = $db->loadObjectList();
          
           if (count($files)>0){
                //$arr_file_exist = array(); 
               //get folder old file 
               $querypn = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS text FROM apdm_pns AS p  LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code WHERE p.pns_deleted =0  AND p.pns_id =".$pns_id_exist;               
               $db->setQuery($querypn);
               $rs = $db->loadObject();
               $pns_folder_exist = trim($rs->text);                
               $path_pns_exist =  $path_pns.'cads'.DS.$ccs_code.DS.$pns_folder_exist.DS;              
               foreach ($files as $file){   
                   
                 if ( copy($path_pns_exist.$file->cad_file, $path_pns_cads.$file->cad_file ) ){
                        $arr_file_uplad[] =   $file->cad_file;
                    }
                  
               }
           }
          
            if (count($arr_file_uplad) > 0){
                foreach ($arr_file_uplad as $file){
                    $db->setQuery("INSERT INTO apdm_pn_cad (pns_id, cad_file, date_create, created_by) VALUES (".$row->pns_id.", '".$file."', '".$datenow->toMySQL()."', ".$me->get('id')." ) ");
                    $db->query();
                }
            }
            
             $text_mess = '';
            if (count($arr_pns_waring) > 0){
                $text_mess = JText::_(' You have missing with some add PNs Parent below: ');
                foreach ($arr_pns_waring as $aaa){
                    $text_mess .= '"'.$aaa['pns'].'" => '.$aaa['mess'].'; ';
                }
            }
			if (count($arr_error_upload_cads) > 0){
				$text_mess .=  JText::_('Have error with some file CADs upload: ');
				$text_mess .= "( ".implode(";", $arr_error_upload_cads)." )";
			}
             $msg = JText::_( 'Successfully Saved Part Number. Please change ECO for this Part Number' ).$text_mess;
             $this->setRedirect('index.php?option=com_apdmpns&task=detail&cid[0]='.$row->pns_id, $msg);          
           
        } //end else
        
    }

	/**
	 * Removes the record(s) from the database
	 */
	function remove()
	{
		// Check for request forgeries     		

		$db 			=& JFactory::getDBO();
		$currentUser 	=& JFactory::getUser();		
		$cid 			= JRequest::getVar( 'cid', array(), '', 'array' );

		JArrayHelper::toInteger( $cid );

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select a User to delete', true ) );
		}

		foreach ($cid as $id)
		{
			// check for a super admin ... can't delete them
            $query = "UPDATE apdm_pns SET pns_deleted=1 WHERE pns_id=".$id;
            $db->setQuery($query);
            $db->query();
            ///update history
            JAdministrator::HistoryUser(6, 'D', $id);
		}
        $msg = "Have successfuly delete pns";	
        $return = JRequest::getVar('return'); 
         if ($return){
              $this->setRedirect( 'index.php?option=com_apdmpns&task=listpns&id='.$return, $msg );
        }else{
            $this->setRedirect( 'index.php?option=com_apdmpns', $msg );
        }         
		
	}

	/**
	 * Cancels an edit operation
	 */
	function cancel( )
	{
        $return = JRequest::getVar('return');
        if ($return){
              $this->setRedirect( 'index.php?option=com_apdmpns&task=listpns&id='.$return );
        }else{
		    $this->setRedirect( 'index.php?option=com_apdmpns' );
        }
	}
    /**
    * @desc Cancel list pns
    */
    function cancel_listpns(){
         global $mainframe, $option;    
         $option = 'com_apdmpns';
         $mainframe->getUserStateFromRequest( "$option.text_search", 'text_search', '','string' );         
         $mainframe->setUserState("$option.type_filter", 0);
         $mainframe->setUserState("$option.text_search", '' );         
         $this->setRedirect( 'index.php?option=com_apdmpns' );
        
    }

	
    function remove_info(){
        $db =& JFactory::getDBO();
        $id = JRequest::getVar('id');
        $pns_id = JRequest::getVar('pns_id');
        $db->setQuery("DELETE FROM apdm_pns_supplier WHERE id=".$id);
        $db->query();
        $msg = JText::_('Have delete information successfully.');
        $this->setRedirect('index.php?option=com_apdmpns&task=edit&cid[]='.$pns_id, $msg);
    }
    /**
    * @desc Remove image ns
    **/
     function remove_img(){
         $db = & JFactory::getDBO();
         $id= JRequest::getVar('id');
         $path_pns = JPATH_SITE.DS.'uploads'.DS.'pns'.DS.'images'.DS;  
         $row = & JTable::getInstance('apdmpns');
         $row->load($id);
         $pns_image = $row->pns_image;
         $handle = new upload($path_pns.$pns_image);
         $handle->file_dst_pathname = $path_pns.$pns_image;
         $handle->clean();
         $row->pns_image = "";
         if ($row->store()){
            $msg = JText::_('Have delete image successfully.');               
         }else{
            $msg = JText::_('Have a problem with remove image.');               
         }
          $this->setRedirect('index.php?option=com_apdmpns&task=edit&cid[]='.$id, $msg);  
     }
     /**
     * @desc  remove pns pdf file     
     */
     function remove_pdf(){
         $db = & JFactory::getDBO();
         $id= JRequest::getVar('id');
         $path_pns = JPATH_SITE.DS.'uploads'.DS.'pns'.DS.'pdf'.DS;  
         $row = & JTable::getInstance('apdmpns');
         $row->load($id);
         $pns_pdf = $row->pns_pdf;         
         $handle = new upload($path_pns.$pns_pdf);
         $handle->file_dst_pathname = $path_pns.$pns_pdf;
         $handle->clean();
         $row->pns_pdf = "";
         if ($row->store()){
            $msg = JText::_('Have delete pdf successfully.');               
         }else{
            $msg = JText::_('Have a problem with remove pdf.');               
         }
          $this->setRedirect('index.php?option=com_apdmpns&task=edit&cid[]='.$id, $msg); 
     }
     /**
     * @desc  Remove file cads
     */
     function remove_cad(){
         $db = & JFactory::getDBO();
         $id= JRequest::getVar('id');
         //get name file cad
         $query = "SELECT * FROM apdm_pn_cad WHERE pns_cad_id=".$id;           
         $db->setQuery($query);
         $row = $db->loadObject();         
         $pns_id = $row->pns_id;                      
         $file_name = $row->cad_file;         
         //get folder file cad
         $querypn = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS pns_code, p.ccs_code FROM apdm_pns AS p  WHERE  p.pns_id =".$pns_id;
         $db->setQuery($querypn);
         $pns = $db->loadObject();
         $pns_code = $pns->pns_code;
         $ccs_code = $pns->ccs_code;             
         $path_pns = JPATH_SITE.DS.'uploads'.DS.'pns'.DS.'cads'.DS.$ccs_code.DS.$pns_code.DS;
         
         $handle = new upload($path_pns.$file_name);
         $handle->file_dst_pathname = $path_pns.$file_name;
         $handle->clean();
         
         $db->setQuery("DELETE FROM apdm_pn_cad WHERE pns_cad_id=".$id);
         $db->query(); 
         $msg = JText::_('Have successfuly delete cad file');
         $this->setRedirect('index.php?option=com_apdmpns&task=edit&cid[]='.$pns_id, $msg); 
         
     }
   /**
   * @desc remove all file cads of PNs  
   */
   function remove_all_cad(){
       $db = & JFactory::getDBO();
       $pns_id = JRequest::getVar('pns_id');
        //get folder file cad
        $querypn = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS pns_code, p.ccs_code FROM apdm_pns AS p  WHERE  p.pns_id =".$pns_id;
        $db->setQuery($querypn);
        $pns = $db->loadObject();
        $pns_code = $pns->pns_code;
        $ccs_code = $pns->ccs_code;
        
        $path_pns = JPATH_SITE.DS.'uploads'.DS.'pns'.DS.'cads'.DS.$ccs_code.DS.$pns_code.DS;
        
       $query = "SELECT * FROM apdm_pn_cad WHERE pns_id=".$pns_id;           
       $db->setQuery($query);
       $rows = $db->loadObjectList();    
       if (count($rows) >0)     {
           foreach ($rows as $row){
               $file_cad = $row->cad_file;
               $handle = new upload($path_pns.$file_cad);
               $handle->file_dst_pathname = $path_pns.$file_cad;               
               $handle->clean();
           }
       }
       $db->setQuery("DELETE FROM apdm_pn_cad WHERE pns_id=".$pns_id);
       $db->query();  
       $msg = JText::_('All file cad have deleted');       
       $this->setRedirect('index.php?option=com_apdmpns&task=edit&cid[]='.$pns_id, $msg); 
      
   }
   function remove_parent(){
       $db =& JFactory::getDBO();
       $id = JRequest::getVar('id');
       $pns_id = JRequest::getVar('idpns');
       $db->setQuery('DELETE FROM apdm_pns_parents WHERE id='.$id);
       $db->query();
       $msg = JText::_('PNS Parent have deleted.');
       $this->setRedirect('index.php?option=com_apdmpns&task=edit&cid[]='.$pns_id, $msg); 
   }
   /**
   * @desc Read file size
   */
   function Readfilesize($folder, $filename, $ccs=null, $pns=null){
      $path_pns = JPATH_SITE.DS.'uploads'.DS.'pns'.DS;   
      $filesize = '';
      switch ($folder){
          case "cads":
                $path_pns .= $folder.DS.$ccs.DS.$pns.DS;    
          break;                
          default: //images; pdf
            $path_pns .= $folder.DS;       
          break;
      }
            $filesize =  ceil( filesize($path_pns.$filename) / 1000 );
      return $filesize;
   }
    
    /**
    * Download file
    **/
    function download(){
        $pns_id = JRequest::getVar('id');
        $row = & JTable::getInstance('apdmpns');    
        $row->load($pns_id);
        $file_name = $row->pns_pdf;
        $path_pns = JPATH_SITE.DS.'uploads'.DS.'pns'.DS.'pdf'.DS;           
        $dFile=new DownloadFile($path_pns,$file_name);
        exit;
    }
    /**
    * @desc Download imge of PNs
    */
    function download_img(){
        $pns_id = JRequest::getVar('id');
        $row = & JTable::getInstance('apdmpns');    
        $row->load($pns_id);
        $file_name = $row->pns_image;
        $path_pns = JPATH_SITE.DS.'uploads'.DS.'pns'.DS.'images'.DS;           
        $dFile=new DownloadFile($path_pns,$file_name);
        exit;
    }
    function download_cad(){
         $db = & JFactory::getDBO(); 
         $pns_cad_id = JRequest::getVar('id');
         $query = "SELECT * FROM apdm_pn_cad WHERE pns_cad_id=".$pns_cad_id;           
         $db->setQuery($query);
         $row = $db->loadObject();         
         $pns_id = $row->pns_id;                      
         $file_name = $row->cad_file;
         
         $querypn = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS pns_code, p.ccs_code FROM apdm_pns AS p  WHERE  p.pns_id =".$pns_id;
         $db->setQuery($querypn);
         $pns = $db->loadObject();         
         $pns_code = $pns->pns_code;
         $ccs_code  = $pns->ccs_code;
         if (substr($pns_code, -1)=="-"){
             $pns_code = substr($pns_code, 0, strlen($pns_code)-1); 
         }   
         $path_pns = JPATH_SITE.DS.'uploads'.DS.'pns'.DS.'cads'.DS.$ccs_code.DS.$pns_code.DS;
         
        $dFile=new DownloadFile($path_pns,$file_name);
         exit;
    }
    function download_cad_all_pns(){
        
        global $dirarray, $conf, $dirsize;    
        
        $conf['dir'] = "zipfiles";
        
        $db = & JFactory::getDBO();
        $pns_id = JRequest::getVar('pns_id');
        $querypn = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS pns_code FROM apdm_pns AS p  WHERE  p.pns_id =".$pns_id;
        $db->setQuery($querypn);
        $pns = $db->loadObject();
        $pns_code = $pns->pns_code;
        if (substr($pns_code, -1)=="-"){
            $pns_code = substr($pns_code, 0, strlen($pns_code)-1); 
        }  
       
        $path_pns = JPATH_SITE.DS.'uploads'.DS.'pns'.DS.'cads'.DS.$pns_code.DS;
        
        $dirarray=array();
        $dirsize=0;
        $zdirsize=0;
        $zdir[] =  $path_pns;        
       
        $dirarray=array();
        $dirsize=0;
        $zdirsize=0;
        for ($i=0;$i<count($zdir);$i++) {
            $ffile = $zdir[$i];
            if (is_dir($ffile)) {
                getdir($ffile);
            } else {
                
                if ($fsize=@filesize($ffile)) $zdirsize+=$fsize;
            }
        }
       
        $zdirsize+=$dirsize;
        
        for ($i=0;$i<count($dirarray);$i++) {
            $zdir[] = $dirarray[$i];
        }
        
        if (!@is_dir($conf['dir'])) {
            $res = @mkdir($conf['dir'],0777);
            if (!$res) $txtout = "Cannot create dir !<br>";
        } else @chmod($conf['dir'],0777);
    
        
       
         
        $zdirsize+=$dirsize;             
        for ($i=0;$i<count($dirarray);$i++) {
            $zdir[] = $dirarray[$i];
        }
       
        if (!@is_dir($conf['dir'])) {
            $res = @mkdir($conf['dir'],0777);
            if (!$res) $txtout = "Cannot create dir !<br>";
        } else @chmod($conf['dir'],0777);
        
        $zipname = 'zipfile';
        $zipname=str_replace("/","",$zipname);
        //if (empty($zipname)) $zipname="NDKzip";
        $zipname.=".zip";
       
        $ziper = new zipfile();
        $ziper->addFiles($zdir);
        $ziper->output("{$conf['dir']}/{$zipname}");
       
        if ($fsize=@filesize("{$conf['dir']}/{$zipname}")) $zipsize=$fsize;
        else $zipsize=0;
        
        $zdirsize =PNsController::size_format($zdirsize);
        $zipsize = PNsController::size_format($zipsize);
        $archive_file_name = $conf['dir'].'/'.$zipname;
       
        PNsController::zipFilesAndDownload($archive_file_name); 
        exit;
       /* $query = "SELECT * FROM apdm_pn_cad WHERE pns_id=".$pns_id; 
        $db->setQuery($query);
        $rows = $db->loadObjectList();        
        //$file_names=array('test.php','test1.txt');
        $file_names=array();
        foreach ($rows as $obj){
            $file_name = $obj->cad_file;
             $file_names[] = $file_name;
        }
      
        $archive_file_name='zipped.zip';          
        PNsController::zipFilesAndDownload($file_names,$archive_file_name,$path_pns); */
        exit;
        
    
        
    }
  function GetNameCCs($ccs_id){
        $db = & JFactory::getDBO();
        $db->setQuery("SELECT ccs_code FROM apdm_ccs WHERE ccs_id=".$ccs_id);
        return $db->loadResult();
    }
 function GetECO($eco_id){
        $db = & JFactory::getDBO();
        $db->setQuery("SELECT eco_name FROM apdm_eco WHERE eco_id=".$eco_id);
        return $db->loadResult();
    }
 
  
    /**
    * @desc Display list child pns 
    */
    function DisplayPnsChild($pns_id, $cd){
        $vcd = $cd;       
        $db =& JFactory::getDBO();
        $sql = 'SELECT pr.pns_id, p.ccs_code FROM apdm_pns_parents as pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE p.pns_deleted = 0 AND pr.pns_parent='.$pns_id.' ORDER BY p.ccs_code';
        $db->setQuery($sql);
        $rs = $db->loadObjectList();
        if (count($rs) > 0){
            $resutl = '<ul>';
                foreach ($rs as $obj){
                    //get information of PNs
                    $querypn = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS text, e.eco_name, p.    pns_description, p.pns_type, p.pns_status FROM apdm_pns AS p  LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND p.pns_id=".$obj->pns_id;
                 //   echo  $querypn;
                    $db->setQuery($querypn);
                    $row = $db->loadObject();
                    $pns_code = $row->text;
                    $type = substr($row->pns_type, 0, 1);
                   // echo $type;
                    $status =$row->pns_status;
                    if (substr($pns_code, -1)=="-"){
                       $pns_code = substr($pns_code, 0, strlen($pns_code)-1);  
                     }
                    $resutl .= '<li>';
                    $resutl .= '<p><input  type="checkbox" onclick="isChecked(this.checked);" value="'.$obj->pns_id.'" name="cid[]"  /> <a href="index.php?option=com_apdmpns&task=detail&cid[]='.$obj->pns_id.'&cd='.$vcd.'" title="'.JText::_('Click to see detail PNs').'">'.$pns_code.'</a></p> ';
                    $resutl .= PNsController::DisplayPnsChild($obj->pns_id, $vcd);
        
                    $resutl .= '</li>';
                    
                }
            $resutl .= '</ul>';
        } 
              
        return $resutl;
    }
    
      function DisplayPnsChildId($pns_id, $cd){
        $vcd = $cd;       
        $db =& JFactory::getDBO();
        $sql = 'SELECT pr.pns_id, p.ccs_code FROM apdm_pns_parents as pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE p.pns_deleted = 0 AND pr.pns_parent='.$pns_id.' ORDER BY p.ccs_code ';
        $db->setQuery($sql);
        $rs = $db->loadObjectList();
        if (count($rs) > 0){
            $result = '';
                foreach ($rs as $obj){
                    //get information of PNs
                    $querypn = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS text, e.eco_name, p.    pns_description, p.pns_type, p.pns_status FROM apdm_pns AS p  LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND p.pns_id=".$obj->pns_id;
                 //   echo  $querypn;
                    $db->setQuery($querypn);
                    $row = $db->loadObject();
                    $pns_code = $row->text;
                    $type = substr($row->pns_type, 0, 1);
                   // echo $type;
                    $status =$row->pns_status;
                    if (substr($pns_code, -1)=="-"){
                       $pns_code = substr($pns_code, 0, strlen($pns_code)-1);  
                     }   
                    $result .= $obj->pns_id.',';
                    $result .= PNsController::DisplayPnsChildId($obj->pns_id, $vcd);            
                }
           
        } 
              
        return $result;
    }
    function GetEcoValue($eco_id){
        $db = & JFactory::getDBO();
        $db->setQuery('SELECT eco_name FROM apdm_eco WHERE eco_id ='.$eco_id);
        return $db->loadResult();
    }
    function GetArrPartNumberParent($pns_id){
        $db =& JFactory::getDBO();
        $sql = 'SELECT pr.pns_parent FROM apdm_pns_parents as pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE p.pns_deleted = 0 AND pr.pns_id='.$pns_id.' ORDER BY ccs_code';
        $db->setQuery($sql);
        $rs = $db->loadObjectList();
        $arr_parent_code = array();
        if (count($rs) >0){
            foreach ($rs as $obj){
                $querypn = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS text FROM apdm_pns AS p  LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code WHERE c.ccs_activate= 1 AND c.ccs_deleted=0 AND   p.pns_deleted =0 AND p.pns_id=".$obj->pns_id;
                $db->setQuery($querypn);
                $row = $db->loadObject();
                $pns_code = $row->text;
                if (substr($pns_code, -1)=="-"){
                   $pns_code = substr($pns_code, 0, strlen($pns_code)-1);  
                 }
                $arr_parent_code[] = $pns_code;
            }
        }
       return $arr_parent_code;
 }
 function GetArrInfo($pns_id, $type_id){
     $db = & JFactory::getDBO();
     $arr_pns_info = array();
     $db->setQuery("SELECT CONCAT_WS('=>', i.info_name, p.supplier_info) as information FROM apdm_pns_supplier as p LEFT JOIN apdm_supplier_info as i ON i.info_id = p.supplier_id WHERE p.type_id=".$type_id." AND p.pns_id=".$pns_id);
     $rs = $db->loadObjectList();
     if (count($rs) > 0){
        foreach ($rs as $obj){
            $arr_pns_info[] = $obj->information;
        }
     }
     return $arr_pns_info;
 }
 	function export_bom(){
        
		global $mainframe;
		$db             =& JFactory::getDBO();   
		$me             =& JFactory::getUser();  
		              
		$pns_id 		= JRequest::getVar('pns_id');
		$username 		= $me->get('username');
		$date			= JHTML::_('date',  time(), JText::_('DATE_FORMAT_LC2') );
		
		$str            = '';
		///get pns_full_code
		$db->setQuery(" SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS pns_full FROM apdm_pns AS p WHERE p.pns_id=".$pns_id);
		$row = $db->loadObject();
	
		$pns_full_code = $row->pns_full;

		//get child of PNs
		$query = "SELECT pr.*, p.ccs_code FROM apdm_pns_parents as pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=".$pns_id." ORDER BY p.ccs_code ";		
		$db->setQuery($query);
		$rows = $db->loadObjectLIst();
        $p = 0;
		if (count($rows) > 0){
		//	for ($i= 0; $i < count($rows); $i++ ){
            $p = 1;
            foreach ($rows as $row) {
				$query = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description  FROM apdm_pns AS p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$row->pns_id;
				
				$db->setQuery($query);
				$result = $db->loadObject();				
				$str .= '<tr height=34 style=\'height:25.5pt\'>
						  <td height=34 style=\'height:25.5pt\'></td>
						  <td class=xl33 width=546 style=\'width:69pt\'>'.$p.'</td>
                           <td class=xl33 width=546 style=\'width:69pt\'>1</td>  
						  <td class=xl33 width=546 style=\'width:176pt\'>'.$result->full_pns_code.'</td>
						  <td class=xl34 width=546 style=\'width:70pt\' x:str="'.$result->eco_name.'">'.$result->eco_name.'</td>
						  <td class=xl34 width=546 style=\'width:100pt\' x:str="'.$result->pns_type.'">'.$result->pns_type.'</td>
						  <td class=xl34 width=546 style=\'width:200pt\' x:str="'.$result->pns_status.'">'.$result->pns_status.'</td>
						  <td class=xl35 width=546 style=\'width:300pt\' x:str="'.$result->pns_description.'">'.$result->pns_description.'</td>
						 </tr>
						 <![if supportMisalignedColumns]>
						 <tr height=0 style=\'display:none\'>
						  <td width=546 style=\'width:56pt\'></td>
						  <td width=546 style=\'width:69pt\'></td>
                          <td width=546 style=\'width:69pt\'></td>       
						  <td width=546 style=\'width:70pt\'></td>
						  <td width=546 style=\'width:100pt\'></td>
						  <td width=546 style=\'width:200pt\'></td>
						  <td class=xl35 width=546 style=\'width:300pt\'></td>
						  
						 </tr>
						 <![endif]>';
				///check for child of it 1
				$db->setQuery("SELECT pr.*,  p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=".$row->pns_id." ORDER BY p.ccs_code");                
				$c = $db->LoadObjectList();
				if (count($c) > 0 ){
				
					$j = 1;
                    $itemj = 0;
					foreach ($c as $obj) {
						$query = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description  FROM apdm_pns as p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj->pns_id;
						$db->setQuery($query);
						$result = $db->loadObject();
                        $itemj = $p+$j;
						$str .= '<tr height=34 style=\'height:25.5pt\'>
						  <td height=34 style=\'height:25.5pt\'></td>
						  <td class=xl33 width=546 style=\'width:69pt\'>'.$itemj.'</td>
                           <td class=xl33 width=546 style=\'width:69pt\'>2</td>    
						  <td class=xl33 width=546 style=\'width:176pt\'>'.$result->full_pns_code.'</td>
						  <td class=xl34 width=546 style=\'width:70pt\' x:str="'.$result->eco_name.'">'.$result->eco_name.'</td>
						  <td class=xl34 width=546 style=\'width:100pt\' x:str="'.$result->pns_type.'">'.$result->pns_type.'</td>
						  <td class=xl34 width=546 style=\'width:200pt\' x:str="'.$result->pns_status.'">'.$result->pns_status.'</td>
						  <td class=xl35 width=546 style=\'width:300pt\' x:str="'.$result->pns_description.'">'.$result->pns_description.'</td>
						 </tr>
						 <![if supportMisalignedColumns]>
						 <tr height=0 style=\'display:none\'>
						  <td width=546 style=\'width:56pt\'></td>
						  <td width=546 style=\'width:69pt\'></td>
                           <td width=546 style=\'width:69pt\'></td>  
						  <td width=546 style=\'width:70pt\'></td>
						  <td width=546 style=\'width:100pt\'></td>
						  <td width=546 style=\'width:200pt\'></td>
						  <td class=xl35 width=546 style=\'width:300pt\'></td>
						  
						 </tr>
						 <![endif]>';
						 ///get level 2						
						$db->setQuery("SELECT pr.*, p.ccs_code  FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns AS p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=".$obj->pns_id." ORDER BY p.ccs_code ");
						$c2 = $db->LoadObjectList();
						if (count ($c2) > 0){
							$j2 = 1;                             
							foreach ($c2 as $obj2){
								$query = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description  FROM apdm_pns as p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj2->pns_id;
								$db->setQuery($query);
								$result = $db->loadObject();
                                //$temj2 = $p+$j+$j2;
                                $temj2  = $itemj +$j2;
								$str .= '<tr height=34 style=\'height:25.5pt\'>
								  <td height=34 style=\'height:25.5pt\'></td>
								  <td class=xl33 width=546 style=\'width:69pt\'>'.$temj2.'</td>
                                  <td class=xl33 width=546 style=\'width:69pt\'>3</td>
								  <td class=xl33 width=546 style=\'width:176pt\'>'.$result->full_pns_code.'</td>
								  <td class=xl34 width=546 style=\'width:70pt\' x:str="'.$result->eco_name.'">'.$result->eco_name.'</td>
								  <td class=xl34 width=546 style=\'width:100pt\' x:str="'.$result->pns_type.'">'.$result->pns_type.'</td>
								  <td class=xl34 width=546 style=\'width:200pt\' x:str="'.$result->pns_status.'">'.$result->pns_status.'</td>
								  <td class=xl35 width=546 style=\'width:300pt\' x:str="'.$result->pns_description.'">'.$result->pns_description.'</td>
								 </tr>
								 <![if supportMisalignedColumns]>
								 <tr height=0 style=\'display:none\'>
								  <td width=546 style=\'width:56pt\'></td>
								  <td width=546 style=\'width:69pt\'></td>
                                  <td width=546 style=\'width:69pt\'></td>
								  <td width=546 style=\'width:70pt\'></td>
								  <td width=546 style=\'width:100pt\'></td>
								  <td width=546 style=\'width:200pt\'></td>
								  <td class=xl35 width=546 style=\'width:300pt\'></td>
								  
								 </tr>
								 <![endif]>';
								 //get level 3
								 $db->setQuery("SELECT pr.*, p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns AS p ON p.pns_id = pr.pns_id WHERE pr.pns_parent=".$obj2->pns_id." ORDER BY p.ccs_code ");
								 $c3 = $db->LoadObjectList();
								 if ( count($c3) > 0){
								 		$j3 = 1;
                                      //  $temj3  = 0;
								 	foreach ($c3 as $obj3){
										$query = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description  FROM apdm_pns as p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj3->pns_id;
										$db->setQuery($query);
										$result = $db->loadObject();
                                        $temj3  = $itemj2 +$j3;  
										$str .= '<tr height=34 style=\'height:25.5pt\'>
										  <td height=34 style=\'height:25.5pt\'></td>
										  <td class=xl33 width=546 style=\'width:69pt\'>'.$temj3.'</td>
                                          <td class=xl33 width=546 style=\'width:69pt\'>4</td>
										  <td class=xl33 width=546 style=\'width:176pt\'>'.$result->full_pns_code.'</td>
										  <td class=xl34 width=546 style=\'width:70pt\' x:str="'.$result->eco_name.'">'.$result->eco_name.'</td>
										  <td class=xl34 width=546 style=\'width:100pt\' x:str="'.$result->pns_type.'">'.$result->pns_type.'</td>
										  <td class=xl34 width=546 style=\'width:200pt\' x:str="'.$result->pns_status.'">'.$result->pns_status.'</td>
										  <td class=xl35 width=546 style=\'width:300pt\' x:str="'.$result->pns_description.'">'.$result->pns_description.'</td>
										 </tr>
										 <![if supportMisalignedColumns]>
										 <tr height=0 style=\'display:none\'>
										  <td width=546 style=\'width:56pt\'></td>
                                          <td width=546 style=\'width:56pt\'></td>
										  <td width=546 style=\'width:69pt\'></td>
										  <td width=546 style=\'width:70pt\'></td>
										  <td width=546 style=\'width:100pt\'></td>
										  <td width=546 style=\'width:200pt\'></td>
										  <td class=xl35 width=546 style=\'width:300pt\'></td>
										  
										 </tr>
										 <![endif]>';
										 //get level 4
										 $db->setQuery("SELECT pr.*, p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns AS p ON p.pns_id = pr.pns_id WHERE pr.pns_parent=".$obj3->pns_id." ORDER BY p.ccs_code ");
										 $c4 = $db->LoadObjectList();
										 if (count ($c4) > 0){
										 	$j4 = 1;
                                            $temj4 = 0;
										 	foreach ($c4 as $obj4){
												$query = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description  FROM apdm_pns as p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj4->pns_id;
												$db->setQuery($query);
												$result = $db->loadObject();
                                                //$temj4 = $p+$j+$j2+$j3+$j4;     
                                                 $temj4  = $itemj3 +$j4;  
												$str .= '<tr height=34 style=\'height:25.5pt\'>
												  <td height=34 style=\'height:25.5pt\'></td>
												  <td class=xl33 width=546 style=\'width:69pt\'>'.$temj4.'</td>
                                                  <td class=xl33 width=546 style=\'width:69pt\'>5</td>
												  <td class=xl33 width=546 style=\'width:176pt\'>'.$result->full_pns_code.'</td>
												  <td class=xl34 width=546 style=\'width:70pt\' x:str="'.$result->eco_name.'">'.$result->eco_name.'</td>
												  <td class=xl34 width=546 style=\'width:100pt\' x:str="'.$result->pns_type.'">'.$result->pns_type.'</td>
												  <td class=xl34 width=546 style=\'width:200pt\' x:str="'.$result->pns_status.'">'.$result->pns_status.'</td>
												  <td class=xl35 width=546 style=\'width:300pt\' x:str="'.$result->pns_description.'">'.$result->pns_description.'</td>
												 </tr>
												 <![if supportMisalignedColumns]>
												 <tr height=0 style=\'display:none\'>
												  <td width=546 style=\'width:56pt\'></td>
												  <td width=546 style=\'width:69pt\'></td>
                                                  <td width=546 style=\'width:69pt\'></td>
												  <td width=546 style=\'width:70pt\'></td>
												  <td width=546 style=\'width:100pt\'></td>
												  <td width=546 style=\'width:200pt\'></td>
												  <td class=xl35 width=546 style=\'width:300pt\'></td>
												  
												 </tr>
												 <![endif]>';
												  //get level 5
												 $db->setQuery("SELECT pr.*, p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns AS p ON p.pns_id = pr.pns_id WHERE pr.pns_parent=".$obj4->pns_id." ORDER BY p.ccs_code ");
												 $c5 = $db->LoadObjectList();
												 if (count($c5) > 0){
												 	$j5=1;
                                                    $temj5  = 0;
													foreach ($c5 as $obj5){
														$query = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description  FROM apdm_pns as p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj5->pns_id;
														$db->setQuery($query);
														$result = $db->loadObject();
                                                        //$temj5 = $p+$j+$j2+$j3+$j5; 
                                                        $temj5  = $itemj4 +$j5;
														$str .= '<tr height=34 style=\'height:25.5pt\'>
														  <td height=34 style=\'height:25.5pt\'></td>
														  <td class=xl33 width=546 style=\'width:69pt\'>'.$temj5.'</td>
                                                          <td class=xl33 width=546 style=\'width:69pt\'>6</td>
														  <td class=xl33 width=546 style=\'width:176pt\'>'.$result->full_pns_code.'</td>
														  <td class=xl34 width=546 style=\'width:70pt\' x:str="'.$result->eco_name.'">'.$result->eco_name.'</td>
														  <td class=xl34 width=546 style=\'width:100pt\' x:str="'.$result->pns_type.'">'.$result->pns_type.'</td>
														  <td class=xl34 width=546 style=\'width:200pt\' x:str="'.$result->pns_status.'">'.$result->pns_status.'</td>
														  <td class=xl35 width=546 style=\'width:300pt\' x:str="'.$result->pns_description.'">'.$result->pns_description.'</td>
														 </tr>
														 <![if supportMisalignedColumns]>
														 <tr height=0 style=\'display:none\'>
														  <td width=546 style=\'width:56pt\'></td>
														  <td width=546 style=\'width:69pt\'></td>
                                                          <td width=546 style=\'width:69pt\'></td>
														  <td width=546 style=\'width:70pt\'></td>
														  <td width=546 style=\'width:100pt\'></td>
														  <td width=546 style=\'width:200pt\'></td>
														  <td class=xl35 width=546 style=\'width:300pt\'></td>
														  
														 </tr>
														 <![endif]>';
														 //get level 6
														  $db->setQuery("SELECT pr.*, p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns AS p ON p.pns_id = pr.pns_id WHERE pr.pns_parent=".$obj5->pns_id." ORDER BY p.ccs_code ");
												 		  $c6 = $db->LoadObjectList();
														  if (count($c6) > 0){
														  		$j6 = 1;
                                                                $temj6  = 0;
																foreach ($c6 as $obj6){
																	$query = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description  FROM apdm_pns as p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj6->pns_id;
																	$db->setQuery($query);
																	$result = $db->loadObject();
                                                                    //$temj6 = $p+$j+$j2+$j3+$j5+$j6; 
                                                                     $temj6  = $itemj5 +$j6;  
																	$str .= '<tr height=34 style=\'height:25.5pt\'>
																	  <td height=34 style=\'height:25.5pt\'></td>
																	  <td class=xl33 width=546 style=\'width:69pt\'>'.$temj6.'</td>
                                                                      <td class=xl33 width=546 style=\'width:69pt\'>7</td>
																	  <td class=xl33 width=546 style=\'width:176pt\'>'.$result->full_pns_code.'</td>
																	  <td class=xl34 width=546 style=\'width:70pt\' x:str="'.$result->eco_name.'">'.$result->eco_name.'</td>
																	  <td class=xl34 width=546 style=\'width:100pt\' x:str="'.$result->pns_type.'">'.$result->pns_type.'</td>
																	  <td class=xl34 width=546 style=\'width:200pt\' x:str="'.$result->pns_status.'">'.$result->pns_status.'</td>
																	  <td class=xl35 width=546 style=\'width:300pt\' x:str="'.$result->pns_description.'">'.$result->pns_description.'</td>
																	 </tr>
																	 <![if supportMisalignedColumns]>
																	 <tr height=0 style=\'display:none\'>
																	  <td width=546 style=\'width:56pt\'></td>
																	  <td width=546 style=\'width:69pt\'></td>
                                                                      <td width=546 style=\'width:69pt\'></td>
																	  <td width=546 style=\'width:70pt\'></td>
																	  <td width=546 style=\'width:100pt\'></td>
																	  <td width=546 style=\'width:200pt\'></td>
																	  <td class=xl35 width=546 style=\'width:300pt\'></td>
																	  
																	 </tr>
																	 <![endif]>';
																	 //get for lebel 7
																	  $db->setQuery("SELECT pr.*, p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns AS p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=".$obj6->pns_id." ORDER BY p.ccs_code ");
																	 $c7 = $db->LoadObjectList();
																	 if (count ($c7) > 0){
																	 		$j7 = 1;
                                                                            $temj7  = 0;
																			foreach ($c7 as $obj7){
																					$query = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description  FROM apdm_pns as p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj7->pns_id;
																			$db->setQuery($query);
																			$result = $db->loadObject();
                                                                            //$temj7 = $p+$j+$j2+$j3+$j5+$j6+$j7;  
                                                                             $temj7  = $itemj6 +$j7;    
																			$str .= '<tr height=34 style=\'height:25.5pt\'>
																			  <td height=34 style=\'height:25.5pt\'></td>
																			  <td class=xl33 width=546 style=\'width:69pt\'>'.$temj7.'</td>
                                                                              <td class=xl33 width=546 style=\'width:69pt\'>8</td>
																			  <td class=xl33 width=546 style=\'width:176pt\'>'.$result->full_pns_code.'</td>
																			  <td class=xl34 width=546 style=\'width:70pt\' x:str="'.$result->eco_name.'">'.$result->eco_name.'</td>
																			  <td class=xl34 width=546 style=\'width:100pt\' x:str="'.$result->pns_type.'">'.$result->pns_type.'</td>
																			  <td class=xl34 width=546 style=\'width:200pt\' x:str="'.$result->pns_status.'">'.$result->pns_status.'</td>
																			  <td class=xl35 width=546 style=\'width:300pt\' x:str="'.$result->pns_description.'">'.$result->pns_description.'</td>
																			 </tr>
																			 <![if supportMisalignedColumns]>
																			 <tr height=0 style=\'display:none\'>
																			  <td width=546 style=\'width:56pt\'></td>
																			  <td width=546 style=\'width:69pt\'></td>
                                                                              <td width=546 style=\'width:69pt\'></td>
																			  <td width=546 style=\'width:70pt\'></td>
																			  <td width=546 style=\'width:100pt\'></td>
																			  <td width=546 style=\'width:200pt\'></td>
																			  <td class=xl35 width=546 style=\'width:300pt\'></td>
																			  
																			 </tr>
																			 <![endif]>';
																			 //gel level 8
																			 $db->setQuery("SELECT pr.*, p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns AS p ON p.pns_id = pr.pns_id WHERE pr.pns_parent=".$obj7->pns_id." ORDER BY p.ccs_code ");
																			 $c8 = $db->LoadObjectList();
																			 if (count ($c8) > 0){
																			 	$j8 = 1;
                                                                                $temj8  = 0;
																				foreach ($c8 as $obj8){
																						$query = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description  FROM apdm_pns as p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj8->pns_id;
																					$db->setQuery($query);
																					$result = $db->loadObject();
                                                                                    //$temj8 = $p+$j+$j2+$j3+$j5+$j6+$j7+$j8;  
                                                                                     $temj8  = $itemj7 +$j8;         
																					$str .= '<tr height=34 style=\'height:25.5pt\'>
																					  <td height=34 style=\'height:25.5pt\'></td>
																					  <td class=xl33 width=546 style=\'width:69pt\'>'.$temj8.'</td>
                                                                                      <td class=xl33 width=546 style=\'width:69pt\'>9</td>
																					  <td class=xl33 width=546 style=\'width:176pt\'>'.$result->full_pns_code.'</td>
																					  <td class=xl34 width=546 style=\'width:70pt\' x:str="'.$result->eco_name.'">'.$result->eco_name.'</td>
																					  <td class=xl34 width=546 style=\'width:100pt\' x:str="'.$result->pns_type.'">'.$result->pns_type.'</td>
																					  <td class=xl34 width=546 style=\'width:200pt\' x:str="'.$result->pns_status.'">'.$result->pns_status.'</td>
																					  <td class=xl35 width=546 style=\'width:300pt\' x:str="'.$result->pns_description.'">'.$result->pns_description.'</td>
																					 </tr>
																					 <![if supportMisalignedColumns]>
																					 <tr height=0 style=\'display:none\'>
																					  <td width=546 style=\'width:56pt\'></td>
																					  <td width=546 style=\'width:69pt\'></td> 
                                                                                      <td width=546 style=\'width:69pt\'></td> 
																					  <td width=546 style=\'width:70pt\'></td>
																					  <td width=546 style=\'width:100pt\'></td>
																					  <td width=546 style=\'width:200pt\'></td>
																					  <td class=xl35 width=546 style=\'width:300pt\'></td>
																					  
																					 </tr>
																					 <![endif]>';
																					 //gel for leb\vel 9
																					  $db->setQuery("SELECT pr.*, p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns AS p ON p.pns_id = pr.pns_id WHERE pr.pns_parent=".$obj8->pns_id." ORDER BY p.ccs_code ");
																					  $c9 = $db->LoadObjectList();
																					  if (count ($c9) > 0 ){
																					  	$j9 = 1;
                                                                                        $temj9  = 0;
																						foreach($c9 as $obj9){
																							$query = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description  FROM apdm_pns as p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj9->pns_id;
																					$db->setQuery($query);
																					$result = $db->loadObject();
                                                                                    //$temj9 = $p+$j+$j2+$j3+$j5+$j6+$j7+$j8+$j9; 
                                                                                     $temj9  = $itemj8 +$j9;  
																					$str .= '<tr height=34 style=\'height:25.5pt\'>
																					  <td height=34 style=\'height:25.5pt\'></td>
																					  <td class=xl33 width=546 style=\'width:69pt\'>'.$temj9.'</td>
                                                                                      <td class=xl33 width=546 style=\'width:69pt\'>10</td>
																					  <td class=xl33 width=546 style=\'width:176pt\'>'.$result->full_pns_code.'</td>
																					  <td class=xl34 width=546 style=\'width:70pt\' x:str="'.$result->eco_name.'">'.$result->eco_name.'</td>
																					  <td class=xl34 width=546 style=\'width:100pt\' x:str="'.$result->pns_type.'">'.$result->pns_type.'</td>
																					  <td class=xl34 width=546 style=\'width:200pt\' x:str="'.$result->pns_status.'">'.$result->pns_status.'</td>
																					  <td class=xl35 width=546 style=\'width:300pt\' x:str="'.$result->pns_description.'">'.$result->pns_description.'</td>
																					 </tr>
																					 <![if supportMisalignedColumns]>
																					 <tr height=0 style=\'display:none\'>
																					  <td width=546 style=\'width:56pt\'></td>
																					  <td width=546 style=\'width:69pt\'></td>
                                                                                      <td width=546 style=\'width:69pt\'></td>
																					  <td width=546 style=\'width:70pt\'></td>
																					  <td width=546 style=\'width:100pt\'></td>
																					  <td width=546 style=\'width:200pt\'></td>
																					  <td class=xl35 width=546 style=\'width:300pt\'></td>
																					  
																					 </tr>
																					 <![endif]>';
																					 	//get level 10
																						  $db->setQuery("SELECT pr.*, p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns AS p ON p.pns_id = pr.pns_id WHERE pr.pns_parent=".$obj9->pns_id." ORDER BY p.ccs_code ");
																					 	  $c10 = $db->LoadObjectList();
																						  if (count($c10) > 0){
																						  	$j10 = 1;
                                                                                            $temj10  = 0;
																							foreach ($c10 as $obj10){
																								$query = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description  FROM apdm_pns as p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj10->pns_id;
																					$db->setQuery($query);
																					$result = $db->loadObject();
                                                                                    //$temj10 = $p+$j+$j2+$j3+$j5+$j6+$j7+$j8+$j9+$j10; 
                                                                                     $temj10  = $itemj9 +$j10;  
																					$str .= '<tr height=34 style=\'height:25.5pt\'>
																					  <td height=34 style=\'height:25.5pt\'></td>
																					  <td class=xl33 width=546 style=\'width:69pt\'>'.$temj10.'</td>
                                                                                       <td width=546 style=\'width:69pt\'>11</td>     
																					  <td class=xl33 width=546 style=\'width:176pt\'>'.$result->full_pns_code.'</td>
																					  <td class=xl34 width=546 style=\'width:70pt\' x:str="'.$result->eco_name.'">'.$result->eco_name.'</td>
																					  <td class=xl34 width=546 style=\'width:100pt\' x:str="'.$result->pns_type.'">'.$result->pns_type.'</td>
																					  <td class=xl34 width=546 style=\'width:200pt\' x:str="'.$result->pns_status.'">'.$result->pns_status.'</td>
																					  <td class=xl35 width=546 style=\'width:300pt\' x:str="'.$result->pns_description.'">'.$result->pns_description.'</td>
																					 </tr>
																					 <![if supportMisalignedColumns]>
																					 <tr height=0 style=\'display:none\'>
																					  <td width=546 style=\'width:56pt\'></td>
																					  <td width=546 style=\'width:69pt\'></td>
                                                                                       <td width=546 style=\'width:69pt\'></td>     
																					  <td width=546 style=\'width:70pt\'></td>
																					  <td width=546 style=\'width:100pt\'></td>
																					  <td width=546 style=\'width:200pt\'></td>
																					  <td class=xl35 width=546 style=\'width:300pt\'></td>
																					  
																					 </tr>
																					 <![endif]>';
																								$j10++;
																							}
																						  }
																							$j9++;
																						}
																					  }
																					  
																					$j8++;
																				} //end for lebvel 8
																			 }
																			 
																			 $j7++;
																			} //dne for j7
																	 }
 																	 
																	$j6++;
																}// end for j6
														  } //end count c6
														$j5++;
													} //end j5
												 } //end count 
												 $j4++;
											} //end foreach j4
										 } //end count 
										 
										 
										$j3++;
									} //end for j3
								 } //end count
								  $j2 = $itemj2;
								 $j2++;
							} //end for j2
							
						} //end count
                        $j = $itemj;
						$j++;
					} //end for j 1
                    $p = $itemj + $temj2 + $temj3 + $temj4 + $temj5 + $temj6 + $temj7 + $temj9 + $temj8 + $temj10;
                  // $p = $j+$j2+$j3+$j4+$j5+$j6+$j7+$j8+$j9+$j10;
				} //end coint
				
				$p++;
				
			}
		}
		
	
		require_once( JPATH_COMPONENT.DS.'pns.bom.xls.php' );
		$name = 'PNS_Report_BOM';
            //  ob_end_clean();
		 header("Content-type: application/vnd.ms-excel"); 
		 header("Content-Disposition: attachment; filename=".$name.".xls"); 
		 header("Pragma: no-cache"); 
		 header("Expires: 0"); 
		
		exit;

		
	}
    function export(){
        global $mainframe;
            $me             =& JFactory::getUser();            
			$username       = $me->get('username');    
			$date			= JHTML::_('date',  time(), JText::_('DATE_FORMAT_LC2') );
            $query_exprot   = JRequest::getVar("query_exprot");
            $total          = JRequest::getVar("total_record");
            $limit          = $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
            $limitstart     = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
            $db             =& JFactory::getDBO();           
            $query = base64_decode($query_exprot);            
            $db->setQuery( $query); 
            $rows = $db->loadObjectList();
            $content = '';           
             $user_name = $me->get('name');
             $date = JHTML::_('date', date("Y-m-d"), '%m/%d/%Y');
             $name = 'PNS_Report';
             require_once( JPATH_COMPONENT.DS.'pns.xls.php' );
            //  ob_end_clean();
             header("Content-type: application/vnd.ms-excel"); 
             header("Content-Disposition: attachment; filename=".$name.".xls"); 
             header("Pragma: no-cache"); 
             header("Expires: 0"); 
            
            exit;
        // CCsController::downContent('eee.xls',$content);
       //   exit;
         
    }
	function GetArrayPNsChild($pns){
		 $db 		= & JFactory::getDBO();   		 
		// $query 	= "SELECT * FROM apdm_pns_parents WHERE pns_parent=".$pns.' ORDER BY ccs_code ';	
         $query = "SELECT pr.*, p.ccs_code FROM apdm_pns_parents as pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id  WHERE p.pns_deleted=0 AND pr.pns_parent = ".$pns.' ORDER BY p.ccs_code';    	
         
		 $db->setQuery($query);
		 $rows = $db->loadObjectList();
		 if ( count ($rows) > 0 ){
		 	foreach ($rows as $row){
				$arrChild[] = $row->pns_id;
				$arrChild[]= PNsController::GetArrayPNsChild($row->pns_id);
			}
		 }
		 return $arrChild;
	}
    function GetListPnsParent($pns){
        $db = & JFactory::getDBO();      
        $query = "SELECT pr.pns_id, p.ccs_code FROM apdm_pns_parents as pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id  WHERE p.pns_deleted=0 AND pr.pns_parent = ".$pns.' ORDER BY p.ccs_code';    
        
        $result = '';
        $db->setQuery($query);
        $rs = $db->loadObjectList();
        if (count($rs) > 0){
            foreach ($rs as $obj){
                $result .= $obj->pns_id.', ';        
                $result .= PNsController::GetListPnsParent($obj->pns_id);             
                
            }            
        
        }        
        return $result;    
       
      
    }
 function  GetManufacture($pns_id){
     $db = & JFactory::getDBO();
     $rows  = array();
     $query = "SELECT p.supplier_id, p.supplier_info, s.info_name FROM apdm_pns_supplier AS p LEFT JOIN apdm_supplier_info AS s ON s.info_id = p.supplier_id WHERE  s.info_deleted=0 AND  s.info_activate=1 AND p.type_id = 4 AND  p.pns_id =".$pns_id;
     
     $db->setQuery($query);
     $result = $db->loadObjectList();
     if (count($result) > 0){
         foreach ($result as $obj){
             $rows[] = array('mf'=>$obj->info_name, 'v_mf'=>$obj->supplier_info);
         }
     }
     return $rows;
 }
 function GetChildParentNumber($pns_id){
    $db = & JFactory::getDBO();
    $result = 0;
    $query = " SELECT COUNT(pr.id) FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns AS p ON p.pns_id= pr.pns_id INNER JOIN apdm_ccs as c ON c.ccs_code = p.ccs_code WHERE p.pns_deleted = 0 AND c.ccs_deleted = 0 AND c.ccs_activate =1 AND pns_parent=".$pns_id;
    $db->setQuery($query);
    $result = $db->loadResult();
    return $result;
 }
 function size_format($bytes="") {
      $retval = "";
      if ($bytes >= 1048576) {
        $retval = round($bytes / 1048576 * 100 ) / 100 . " MB";
      } else if ($bytes  >= 1024) {
            $retval = round($bytes / 1024 * 100 ) / 100 . " KB";
        } else {
            $retval = $bytes . " bytes";
          }
      return $retval;
}
function GetInForValue($field, $table, $key, $keyvalue){
    
    $db =& JFactory::getDBO();  
    $query = "SELECT {$field} FROM {$table} WHERE {$key}=".$keyvalue;
    $db->setQuery($query);
    $result = $db->loadResult();
    return $result;    
}
function GetValuePns($field, $pns_id){
    
    $db =& JFactory::getDBO();  
    $query = "SELECT $field FROM apdm_pns WHERE pns_id=".$pns_id;
    $db->setQuery($query);
    $result = $db->loadResult();
    return $result;    
}
function GetEcoNumber($pns_id){
    $db =& JFactory::getDBO();  
    $db->setQuery("SELECT e.eco_name FROM apdm_eco AS e LEFT JOIN apdm_pns AS p ON p.eco_id = e.eco_id WHERE pns_id=".$pns_id);
    $result = $db->loadResult();
    return $result;
}
function getcurrentdir($path=".") {
    global $conf;    
        $dirarr = array();
        if ($dir = opendir($path)) {
          while (false !== ($entry = @readdir($dir))) {
             if (($entry!=".")&&($entry!="..")) {
                  $lastdot = strrpos($entry,".");
                $ext = chop(strtolower(substr($entry,$lastdot+1)));
                $fname = substr($entry,0,$lastdot);
                if ($path!=".") $newpath = $path."/".$entry;
                else $newpath = $entry;
                $newpath = str_replace("//","/",$newpath);

                if (($entry!="NDKziper.php")&&($entry!="ndkziper.txt")&&($entry!=$conf['dir'])) {
                    $dirarr[] = $newpath;
                } 
               }
          }                                                      
        }
        
        return $dirarr;
}// end func
}