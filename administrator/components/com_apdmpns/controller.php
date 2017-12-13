<?php
/**
 * PNS Component Controller
 *
 * @package		APDM
 * @subpackage	PNS
 * @since 1.5
*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');
require_once('includes/class.upload.php');
require_once('includes/download.class.php');
require_once('includes/zip.class.php'); 
require_once('includes/system_defines.php'); 
ini_set('display_errors', 0);
 
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
        $this->registerTask( 'list_child', 'list_child' );   
        $this->registerTask( 'list_where_used', 'list_where_used' );   

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
	/**
		Asign layout and view to display list PNS
	*/
    function  list_pns(){
        JRequest::setVar('layout', 'default');
        JRequest::setVar('view', 'listpns');
        parent::display();
    }
	/*
		Asign template to display list download files cads
	*/
     function download_all_cads(){
        JRequest::setVar('layout', 'default');
        JRequest::setVar('view', 'download');
        parent::display();
    }
	/*
	 * Asign template to display multi upload files
	*/
    function multi_upload(){
        JRequest::setVar('layout', 'default');
        JRequest::setVar('view', 'multi_uploads');
        parent::display();
    }
	/*
		* Asign template to display next step for multi upload
	*/
    function next_upload(){
       
       JRequest::setVar('layout', 'list_pns');
       JRequest::setVar('view', 'multi_uploads');
        parent::display();
    }
	/*
		*Asign template for multi upload file pdf
	*/
    function next_upload_step2(){    
       JRequest::setVar('layout', 'from_upload_pdf');
       JRequest::setVar('view', 'multi_uploads_form');
        parent::display();
    }
	/*
		* Asign template for multi upload cads file
	*/
    function next_upload_step1(){
        JRequest::setVar('layout', 'from_upload_cad');
       JRequest::setVar('view', 'multi_uploads_form');
        parent::display();
    }
	/*
		* Asign template for get list child PNS  for PNS
	*/
    function get_list_child(){
        JRequest::setVar( 'layout', 'default'  );
        JRequest::setVar( 'view', 'getpnschild' );
        parent::display();
    }
	/*
		* Asign template for get list PNs to add more child for PNs
	*/
    function list_child(){
        JRequest::setVar( 'layout', 'default'  );
        JRequest::setVar( 'view', 'listchild' );
        parent::display();
    }
	/*
		* Asign template for displat list parent of Pns
	*/
    function list_where_used(){
        JRequest::setVar( 'layout', 'default'  );
        JRequest::setVar( 'view', 'listwhereused' );
        parent::display();
    }
    
    /** 
		funcntion get list PNs child for ajax request
	*/
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
 /*
 	* To save multi upload file cad (this function backup)
 */
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
    /*
		* To save multi upload file pdf
	*/
    function save_multi_upload_pdf(){
       global $mainframe;
       $db            = & JFactory::getDBO();
       $pns_id = JRequest::getVar('pns_id',  array(), '', 'array'); 
       $pns_code = JRequest::getVar('pns_code',  array(), '', 'array');  
                        
       $path_pns        = JPATH_SITE.DS.'uploads'.DS.'pns'.DS.'pdf'.DS;  
       $path_pns_img    = JPATH_SITE.DS.'uploads'.DS.'pns'.DS.'images'.DS;  
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
            //for image upload
            $file_img = 'file_img'.$pns_id[$i];
            if ($_FILES[$file_img]['size'] > 0 ){
                $upload_img = new Upload($_FILES[$file_img]);
                $upload_img->file_new_name_body = $pns_code[$i];
                if ($upload_img->uploaded){
                    $upload_img->process($path_pns_img);
                    if ($upload_img->processed){
                        $pns_img = $upload_img->file_dst_name;
                        //update databse
                        $query = "UPDATE apdm_pns SET pns_image='".$pns_img."' WHERE pns_id=".$pns_id[$i];
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
	/*
 	* To save multi upload file cad
 	*/
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
	/*
		* Get rev roll for Pns
	*/
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
	/*
		Get random revision
	*/
    function RandomRevision(){
         $arrChar   = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'K', 'M', 'N', 'P', 'R', 'T', 'V', 'Y', 'Z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'K', 'M', 'N', 'P', 'R', 'T', 'V', 'Y', 'Z'); 
         //new code random
        $arr_get = array_rand($arrChar, 2); 
        $arr_result = array();
        foreach ($arr_get as $key){
            $arr_result[] = $arrChar[$key];
        }
        $new_code = implode("", $arr_result);    
        return $new_code;
    }
    /*
		Get code defaut : Ajax request
	*/
	function code_default(){		
		$db         =& JFactory::getDBO();  
        $ccs_code   = JRequest::getVar('ccs_code'); 
        
		$query = "SELECT pns_code  FROM apdm_pns  WHERE ccs_code = '".$ccs_code."' ORDER BY pns_id DESC LIMIT 0, 1 ";
		$db->setQuery($query);
		$rows = $db->loadObject();		 
		 if ( $rows){ //267890-00
		 	$temp = explode("-", $rows->pns_code);
		 	$pns_latest = $temp[0];
			
		 }else{
		 	$pns_latest = 0;
		 }
		 
		$next_pns_code = (int) $pns_latest;
		$next_pns_code++;
		$number = strlen($next_pns_code);
		switch ($number){
			case '1':
				$new_pns_code = '00000'.$next_pns_code;
			break;
			case '2':
				$new_pns_code = '0000'.$next_pns_code;
			break;
			case '3':
				$new_pns_code = '000'.$next_pns_code;
			break;
			case '4':
				$new_pns_code = '00'.$next_pns_code;
			break;
			case '5':
				$new_pns_code = '0'.$next_pns_code;
			break;
			default:
				$new_pns_code = $next_pns_code;
			break;
		}
		//$arr_char = array('A', 'A', 'A','A', 'A', 'A','B', 'B', 'B', 'B', 'B', 'B', 'C','C','C','C','C','C', 'D','D','D', 'D','D','D', 'E','E','E', 'E','E','E', 'F','F', 'F', 'F','F', 'F', 'G','G','G', 'G','G','G', 'H','H','H', 'H','H','H', 'I', 'I', 'I', 'I', 'I', 'I', 'J','J','J', 'J','J','J', 'K','K', 'K', 'K','K', 'K', 'M','M','M', 'M','M','M', 'N', 'N', 'N', 'N', 'N', 'N', 'O','O','O', 'O','O','O', 'P','P','P', 'P','P','P', 'Q','Q','Q', 'Q','Q','Q', 'R','R', 'R', 'R','R', 'R', 'S','S','S', 'S','S','S', 'T','T','T', 'T','T','T', 'U','U','U', 'U','U','U', 'V','V', 'V', 'V','V', 'V','W','W','W', 'W','W','W', 'X','X','X', 'X','X','X', 'Y','Y','Y', 'Y','Y','Y', 'Z','Z','Z', 'Z','Z','Z', '1', '1', '1', '1', '1', '1', '2', '2', '2', '2', '2', '2', '3', '3', '3', '3', '3', '3','4', '4', '4', '4', '4', '4', '5', '5', '5', '5', '5', '5', '6', '6', '6', '6', '6', '6', '7', '7', '7', '7', '7', '7', '8', '8', '8', '8', '8', '8', '9', '9', '9', '9', '9', '9', '0', '0', '0', '0', '0', '0',);
        /*$arr_char = array('1', '1', '1', '1', '1', '1', '2', '2', '2', '2', '2', '2', '3', '3', '3', '3', '3', '3','4', '4', '4', '4', '4', '4', '5', '5', '5', '5', '5', '5', '6', '6', '6', '6', '6', '6', '7', '7', '7', '7', '7', '7', '8', '8', '8', '8', '8', '8', '9', '9', '9', '9', '9', '9', '0', '0', '0', '0', '0', '0');
		$arr_get = array_rand($arr_char, 6);
		$arr_result = array();
		foreach ($arr_get as $obj){
			$arr_result[] = $arr_char[$obj];
		}		
		$code = implode("", $arr_result);		*/
		echo $new_pns_code;
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
            $query_check = "SELECT pns_id FROM apdm_pns WHERE ccs_code='".$row->ccs_code."' AND pns_code = '".$pns_code_check."' AND pns_revision='".$pns_revision."'";
        }else{
            $query_check = "SELECT pns_id FROM apdm_pns WHERE ccs_code='".$row->ccs_code."' AND pns_code = '".$pns_code_check."'";    
        }
        
        $db->setQuery($query_check);
        $result_check = $db->loadResult();         
        if ($result_check > 0){
            $thisPns = $row->ccs_code.'-'.$pns_code_check.'-'.$pns_revision;              
            $msg = JText::_('This Part Number ('.$thisPns.') Have exist. Please check list again. (Please check with administrator if you dont found.)');            
            $this->setRedirect('index.php?option=com_apdmpns', $msg);
            return false;
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
		$row->pns_description = strtoupper($post['pns_description']);    
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
      
        if (! $row->bind($post)){
            JError::raiseError( 500, $db->stderr() );
            return false;
        } 
         $row->pns_life_cycle = JRequest::getVar('pns_life_cycle');
           $row->pns_uom = JRequest::getVar('pns_uom');
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
		   $row->pns_description = strtoupper($post['pns_description']); 
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
                  if (file_exists($path_pns_cads.$_FILES['pns_cad'.$i]['name'])){
                      @unlink($path_pns_cads.$_FILES['pns_cad'.$i]['name']);
                  }
				  if (!move_uploaded_file($_FILES['pns_cad'.$i]['tmp_name'], $path_pns_cads.$_FILES['pns_cad'.$i]['name'])){
				  		$arr_error_upload_cads[] = $_FILES['pns_cad'.$i]['name'];
				  }else{
				  		$arr_file_uplad[] = $_FILES['pns_cad'.$i]['name'];
				  }
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
             $this->setRedirect('index.php?option=com_apdmpns&task=detail&cid[]='.$row->pns_id, $msg);          
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
		   $row->pns_description = strtoupper($post['pns_description']); 
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
              $this->setRedirect('index.php?option=com_apdmpns&task=detail&cid[]='.$row->pns_id, $msg);  
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
	 /**
    * @desc Remove organization
    */
	
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
    * @desc Remove image PNs
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
   /*
   	Remove PNS child
   */
   function remove_parent(){
       $db =& JFactory::getDBO();
       //$id = JRequest::getVar('id');
       $cid             = JRequest::getVar( 'cid', array(), '', 'array' );      
       $pns_id = JRequest::getVar('id');   
      
       $db->setQuery('DELETE FROM apdm_pns_parents WHERE pns_id IN ('.implode(",", $cid).') AND pns_parent='.$pns_id );       
       $db->query();
       $msg = JText::_('PNS Parent have deleted.');
       JRequest::setVar( 'id', $pns_id );
       JRequest::setVar( 'tmpl','component' ); 
       JRequest::setVar( 'layout', 'ajax'  );
       JRequest::setVar( 'view', 'listchild' );
                                   
       parent::display();
      
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
	  if (file_exists($path_pns.$filename) ) {
            $filesize =  ceil( filesize($path_pns.$filename) / 1000 );
	  }else{
	  	$filesize = 0;
	  }
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
	/**
    * @desc Download cad file of PNs
    */
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
	/*
		Download all cad file
	*/
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
        for ($i=0; $i < count($zdir); $i++) {
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
    function DisplayPnsAllChildId($pns_id){  
        $db =& JFactory::getDBO();
        $rows = array();
        $db->setQuery('SELECT pr.pns_id,CONCAT_WS( "-", p.ccs_code, p.pns_code, p.pns_revision ) AS text, e.eco_name, p.    pns_description, p.pns_type, p.pns_status FROM apdm_pns AS p LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_id LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND pr.pns_parent='.$pns_id);
        return $result = $db->loadObjectList();
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
 /*
 	* Get list array id of origanization
 */
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
 	/*
		* Export BOM with format excel
	*/
 	function export_bom(){                          
        include_once(JPATH_BASE .DS.'includes'.DS.'PHPExcel.php');
        require_once (JPATH_BASE .DS.'includes'.DS.'PHPExcel'.DS.'RichText.php');        
        require_once(JPATH_BASE .DS.'includes'.DS.'PHPExcel'.DS.'IOFactory.php');   
        require_once('includes/download.class.php');     
         ini_set("memory_limit", "252M");   
        @set_time_limit(1000000);
        $objPHPExcel = new PHPExcel();                               
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load(JPATH_COMPONENT.DS.'apdm_pn_bom_report.xls'); 
		
        global $mainframe;
	 
		$me             =& JFactory::getUser();   		              
		$pns_id 		= JRequest::getVar('pns_id');
		$username 		= $me->get('username');
        $db             =& JFactory::getDBO();  
        $query = 'SELECT * FROM apdm_pns WHERE pns_id='.$pns_id;

        $db->setQuery( $query);
        $row = $db->loadObject(); 

        $listPNs = array();
        $listPNs[] = array(
            "pns_code"=>$row->ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision,
            "pns_level"=>1,
            "eco"=>GetEcoValue($row->eco_id),
            "pns_type"=>$row->pns_type,
            "pns_des"=>$row->pns_description,
            "pns_status"=>$row->pns_status,
            "pns_date"=>JHTML::_('date', $row->pns_create, '%m/%d/%Y')
        );
        //get list child
        $query = "SELECT pr.*, p.ccs_code FROM apdm_pns_parents as pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=".$pns_id." ORDER BY p.ccs_code ";        
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        
        //for level 2
       foreach ($rows as $obj1) {
            $query1 = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj1->pns_id;
            $db->setQuery($query1);
            $result1 = $db->loadObject();            
            $listPNs[] = array(
                "pns_code"=>$result1->full_pns_code,
                "pns_level"=>2,
                "eco"=>$result1->eco_name,
                "pns_type"=>$result1->pns_type,
                "pns_des"=>$result1->pns_description,
                "pns_status"=>$result1->pns_status,
                "pns_date"=>JHTML::_('date', $result1->pns_create, '%m/%d/%Y')
            );
            ///check for child of level 3
            $db->setQuery("SELECT pr.*,  p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=".$obj1->pns_id." ORDER BY p.ccs_code");                
            $rows2 = $db->LoadObjectList();
            if (count($rows2) > 0 ){
                foreach ($rows2 as $obj2){                  
                    $query2 = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj2->pns_id;        
                    $db->setQuery($query2);
                    $result2 = $db->loadObject();
                     $listPNs[] = array(
                         "pns_code"=>$result2->full_pns_code,
                        "pns_level"=>3,
                        "eco"=>$result2->eco_name,
                        "pns_type"=>$result2->pns_type,
                        "pns_des"=>$result2->pns_description,
                        "pns_status"=>$result2->pns_status,
                        "pns_date"=>JHTML::_('date', $result2->pns_create, '%m/%d/%Y')
                    );
                    //check for level 4
                    $db->setQuery("SELECT pr.*,  p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=".$obj2->pns_id." ORDER BY p.ccs_code");                
                    $rows3 = $db->LoadObjectList();
                     if (count($rows3) > 0){
                         foreach ($rows3 as $obj3){                            
                            $query3 = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj3->pns_id;
                            $db->setQuery($query3);
                            $result3 = $db->loadObject();
                            $listPNs[] = array(
                                "pns_code"=>$result3->full_pns_code,
                                "pns_level"=>4,
                                "eco"=>$result3->eco_name,
                                "pns_type"=>$result3->pns_type,
                                "pns_des"=>$result3->pns_description,
                                "pns_status"=>$result3->pns_status,
                                "pns_date"=>JHTML::_('date', $result3->pns_create, '%m/%d/%Y')
                            );
                            //check for level 5
                            $db->setQuery("SELECT pr.*,  p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=".$obj3->pns_id." ORDER BY p.ccs_code");                
                            $rows4 = $db->LoadObjectList();
                            if ( count ($rows4) >0 ){
                                foreach ($rows4 as $obj4){
                                    $query4 = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj4->pns_id;
                                    $db->setQuery($query4);
                                    $result4 = $db->loadObject();
                                     $listPNs[] = array(
                                        "pns_code"=>$result4->full_pns_code,
                                        "pns_level"=>5,
                                        "eco"=>$result4->eco_name,
                                        "pns_type"=>$result4->pns_type,
                                        "pns_des"=>$result4->pns_description,
                                        "pns_status"=>$result4->pns_status,
                                        "pns_date"=>JHTML::_('date', $result4->pns_create, '%m/%d/%Y')
                                    );
                                    //check for level 6
                                    $db->setQuery("SELECT pr.*,  p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=".$obj4->pns_id." ORDER BY p.ccs_code");                
                                    $rows5 = $db->LoadObjectList();
                                     if (count($rows5) > 0){
                                         foreach ($rows5 as $obj5){                                            
                                            $query5 = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj5->pns_id;            
                                            $db->setQuery($query5);
                                            $result5 = $db->loadObject();
                                            $listPNs[] = array(
                                                "pns_code"=>$result5->full_pns_code,
                                                "pns_level"=>6,
                                                "eco"=>$result5->eco_name,
                                                "pns_type"=>$result5->pns_type,
                                                "pns_des"=>$result5->pns_description,
                                                "pns_status"=>$result5->pns_status,
                                                "pns_date"=>JHTML::_('date', $result5->pns_create, '%m/%d/%Y')
                                            );
                                            //check for level 7
                                            $db->setQuery("SELECT pr.*,  p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=".$obj5->pns_id." ORDER BY p.ccs_code");                
                                            $rows6 = $db->LoadObjectList();
                                            if ( count ($rows6) > 0 ){
                                                foreach ($rows6 as $obj6) {                                                   
                                                    $query6 = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj6->pns_id;
                                                    $db->setQuery($query6);
                                                    $result6 = $db->loadObject();
                                                     $listPNs[] = array(
                                                        "pns_code"=>$result6->ccs_code.'-'.$result6->pns_code.'-'.$result6->pns_revision,
                                                        "pns_level"=>7,
                                                        "eco"=>GetEcoValue($result6->eco_id),
                                                        "pns_type"=>$result6->pns_type,
                                                        "pns_des"=>$result6->pns_description,
                                                        "pns_status"=>$result6->pns_status,
                                                        "pns_date"=>JHTML::_('date', $result6->pns_create, '%m/%d/%Y')
                                                    );          
                                                    // check for level 8
                                                    $db->setQuery("SELECT pr.*,  p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=".$obj6->pns_id." ORDER BY p.ccs_code");                
                                                    $rows7 = $db->LoadObjectList();                                                        
                                                    if ( count ($rows7) > 0 ){
                                                        foreach ($rows7 as $obj7){                                               
                                                            $query7 = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj7->pns_id;
                                                            $db->setQuery($query7);
                                                            $result7 = $db->loadObject();
                                                             $listPNs[] = array(
                                                                "pns_code"=>$result7->full_pns_code,
                                                                "pns_level"=>8,
                                                                "eco"=>$result7->eco_name,
                                                                "pns_type"=>$result7->pns_type,
                                                                "pns_des"=>$result7->pns_description,
                                                                "pns_status"=>$result7->pns_status,
                                                                "pns_date"=>JHTML::_('date', $result7->pns_create, '%m/%d/%Y')
                                                            );       
                                                            //check for level 9
                                                            $db->setQuery("SELECT pr.*,  p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=".$obj7->pns_id." ORDER BY p.ccs_code");                
                                                            $rows8 = $db->LoadObjectList();    
                                                            if ( count ($rows8) > 0 ){
                                                                foreach ($rows8 as $obj8){                                                                            
                                                                    $query8 = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj8->pns_id;
                                                                    $db->setQuery($query8);
                                                                    $result8 = $db->loadObject();
                                                                    $listPNs[] = array(
                                                                        "pns_code"=>$result8->full_pns_code,
                                                                        "pns_level"=>9,
                                                                        "eco"=>$result8->eco_name,
                                                                        "pns_type"=>$result8->pns_type,
                                                                        "pns_des"=>$result8->pns_description,
                                                                        "pns_status"=>$result8->pns_status,
                                                                        "pns_date"=>JHTML::_('date', $result8->pns_create, '%m/%d/%Y')
                                                                    );
                                                                    //check for level 10;
                                                                    $db->setQuery("SELECT pr.*,  p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=".$obj8->pns_id." ORDER BY p.ccs_code");                
                                                                    $rows9 = $db->LoadObjectList();    
                                                                    if ( count ($rows9) > 0){
                                                                        foreach ($rows9 as $obj9){
                                                                            $query9 = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p  lEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE p.pns_id=".$obj9->pns_id;
                                                                            $db->setQuery($query9);
                                                                            $result9 = $db->loadObject();
                                                                             $listPNs[] = array(
                                                                                "pns_code"=>$result9->full_pns_code,
                                                                                "pns_level"=>10,
                                                                                "eco"=>$result9>eco_name,
                                                                                "pns_type"=>$result9->pns_type,
                                                                                "pns_des"=>$result9->pns_description,
                                                                                "pns_status"=>$result9->pns_status,
                                                                                "pns_date"=>JHTML::_('date', $result9->pns_create, '%m/%d/%Y')
                                                                            );
                                                                            
                                                                        }
                                                                    }

                                                                    
                                                                }
                                                            }
   
                                                        }
                                                    }
                                                }
                                            }

                                         }
                                     }
                                   }
                            }
                              
                              
                         }
                     }
                }
            }
            
        }
         $user_name = $me->get('name');
            $date = JHTML::_('date', date("Y-m-d"), '%m/%d/%Y');
             //for Execl
            $styleThinBlackBorderOutline = array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => 'FF000000'),
                    ),
                ),
            );
            
            $objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);          
            $objPHPExcel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);  
           
            $objPHPExcel->getActiveSheet()->setCellValue('A5', 'Username: '.$me->get('username'));   
            $objPHPExcel->getActiveSheet()->setCellValue('F5', 'Date Created: '.$date); 
            $nRecord = count($listPNs);       
            $objPHPExcel->getActiveSheet()->getStyle('A7:F'.$nRecord)->getAlignment()->setWrapText(true);
            if ($nRecord > 0){
                    $j=0;
                    $i = 7;        
					$number = 1;
                    foreach ($listPNs as $pns){
                        $a = 'A'.$i;
                        $b='B'.$i;
                        $c='C'.$i;
                        $d = 'D'.$i;
                        $e = 'E'.$i;
                        $f = 'F'.$i;
                        $g = 'G'.$i;                        
						$h = 'H'.$i;
                        //set heigh or row 
                        $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(30);               
						$objPHPExcel->getActiveSheet()->setCellValue($a, $number);
                        $objPHPExcel->getActiveSheet()->setCellValue($b, $pns['pns_code']);
                        $objPHPExcel->getActiveSheet()->setCellValue($c, $pns['pns_level']);
                        $objPHPExcel->getActiveSheet()->setCellValue($d, $pns['eco']);
                        $objPHPExcel->getActiveSheet()->setCellValue($e, $pns['pns_type']);
                        $objPHPExcel->getActiveSheet()->setCellValue($f, $pns['pns_des']);  
                        $objPHPExcel->getActiveSheet()->setCellValue($g, $pns['pns_status']);                         
                        $objPHPExcel->getActiveSheet()->setCellValue($h, $pns['pns_date']);                         
                        
                        //set format
                        $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($c)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($d)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($e)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($f)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);
                        $objPHPExcel->getActiveSheet()->getStyle($g)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle($h)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                       
                        
                        $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($c)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($d)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($e)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
                        $objPHPExcel->getActiveSheet()->getStyle($g)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle($h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        
                        
                                                                                                                                    
                        $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        $objPHPExcel->getActiveSheet()->getStyle($c)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        $objPHPExcel->getActiveSheet()->getStyle($d)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        $objPHPExcel->getActiveSheet()->getStyle($e)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        $objPHPExcel->getActiveSheet()->getStyle($f)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        $objPHPExcel->getActiveSheet()->getStyle($g)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
						$objPHPExcel->getActiveSheet()->getStyle($h)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                      
                      
                        
                        $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                
                        if ($j%2==0) {
                            $objPHPExcel->getActiveSheet()->getStyle($a.':'.$h)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                            $objPHPExcel->getActiveSheet()->getStyle($a.':'.$h)->getFill()->getStartColor()->setRGB('EEEEEE');
                          
                        }
                       if ($j ==$nRecord-1){
                            $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $objPHPExcel->getActiveSheet()->getStyle($c)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $objPHPExcel->getActiveSheet()->getStyle($d)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $objPHPExcel->getActiveSheet()->getStyle($e)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $objPHPExcel->getActiveSheet()->getStyle($f)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $objPHPExcel->getActiveSheet()->getStyle($g)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
							$objPHPExcel->getActiveSheet()->getStyle($h)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                      
                        }                 
                        $i++;
                        $j++;  
						$number++;  
                    }
            }
            $path_export = JPATH_SITE.DS.'uploads'.DS.'export'.DS;           
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save($path_export.'APDM_BOM_REPORT.xls');             
            $dFile=new DownloadFile($path_export,'APDM_BOM_REPORT.xls');
            exit; 
            
		
	}
	/*
		* Export list PNs with format excel
	*/
    function export(){
        include_once(JPATH_BASE .DS.'includes'.DS.'PHPExcel.php');
        require_once (JPATH_BASE .DS.'includes'.DS.'PHPExcel'.DS.'RichText.php');        
        require_once(JPATH_BASE .DS.'includes'.DS.'PHPExcel'.DS.'IOFactory.php');   
        require_once('includes/download.class.php');  
        ini_set("memory_limit", "252M");   
        @set_time_limit(1000000);   
        $objPHPExcel = new PHPExcel();                               
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load(JPATH_COMPONENT.DS.'apdm_pn_report.xls'); 
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
			jimport('joomla.html.pagination');
            $pagination = new JPagination( $total, $limitstart, $limit );
            $db->setQuery( $query, $pagination->limitstart, $pagination->limit );
            $rows = $db->loadObjectList();                    
            $user_name = $me->get('name');
            $date = JHTML::_('date', date("Y-m-d"), '%m/%d/%Y');
             //for Execl
            $styleThinBlackBorderOutline = array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => 'FF000000'),
                    ),
                ),
            );
            
            $objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);          
            $objPHPExcel->getActiveSheet()->getStyle('E5')->getFont()->setBold(true);  
           
            $objPHPExcel->getActiveSheet()->setCellValue('A5', 'Username: '.$me->get('username'));   
            $objPHPExcel->getActiveSheet()->setCellValue('E5', 'Date Created: '.date('d/m/Y'));   
            $nRecord = count($rows);
            $objPHPExcel->getActiveSheet()->getStyle('A7:F'.$nRecord)->getAlignment()->setWrapText(true);
            if ($nRecord > 0){
                    $j=0;
                    $i = 7; 
					$number = 1;       
                    foreach ($rows as $row){
                        $a = 'A'.$i;
                        $b ='B'.$i;
                        $c = 'C'.$i;
                        $d = 'D'.$i;
                        $e = 'E'.$i;
                        $f = 'F'.$i;
						$g = 'G'.$i;
                        $pns_code = $row->ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision;
                        //set heigh or row 
                        $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(30);  
						$objPHPExcel->getActiveSheet()->setCellValue($a, $number);             
                        $objPHPExcel->getActiveSheet()->setCellValue($b, $pns_code);
                        $objPHPExcel->getActiveSheet()->setCellValue($c, GetECO($row->eco_id));
                        $objPHPExcel->getActiveSheet()->setCellValue($d, $row->pns_type);
                        $objPHPExcel->getActiveSheet()->setCellValue($e,  $row->pns_description);
                        $objPHPExcel->getActiveSheet()->setCellValue($f, $row->pns_status);  
                        $objPHPExcel->getActiveSheet()->setCellValue($g, JHTML::_('date', $row->pns_create, '%m/%d/%Y'));                         
                        
                        //set format
                        $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($c)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($d)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($e)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);
                        $objPHPExcel->getActiveSheet()->getStyle($f)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					   $objPHPExcel->getActiveSheet()->getStyle($g)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                       
                        
                        $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($c)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($d)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($e)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
                        $objPHPExcel->getActiveSheet()->getStyle($f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($g)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                        
                        
                                                                                                                                    
                        $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        $objPHPExcel->getActiveSheet()->getStyle($c)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        $objPHPExcel->getActiveSheet()->getStyle($d)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        $objPHPExcel->getActiveSheet()->getStyle($e)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        $objPHPExcel->getActiveSheet()->getStyle($f)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                       $objPHPExcel->getActiveSheet()->getStyle($g)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                      
                        
                        $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                
                        if ($j%2==0) {
                            $objPHPExcel->getActiveSheet()->getStyle($a.':'.$g)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                            $objPHPExcel->getActiveSheet()->getStyle($a.':'.$g)->getFill()->getStartColor()->setRGB('EEEEEE');
                          
                        }
                       if ($j ==$nRecord-1){
                            $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $objPHPExcel->getActiveSheet()->getStyle($c)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $objPHPExcel->getActiveSheet()->getStyle($d)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $objPHPExcel->getActiveSheet()->getStyle($e)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $objPHPExcel->getActiveSheet()->getStyle($f)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
							 $objPHPExcel->getActiveSheet()->getStyle($g)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                      
                        }                 
                        $i++;
                        $j++;    
						$number++;
                    }
            }
            $path_export = JPATH_SITE.DS.'uploads'.DS.'export'.DS;           
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save($path_export.'APDM_PN_REPORT.xls');             
            $dFile=new DownloadFile($path_export,'APDM_PN_REPORT.xls');
            exit; 
            
            
    }
	/*
		Export PNs detail
	*/
    function export_detail(){
        include_once(JPATH_BASE .DS.'includes'.DS.'PHPExcel.php');
        require_once (JPATH_BASE .DS.'includes'.DS.'PHPExcel'.DS.'RichText.php');        
        require_once(JPATH_BASE .DS.'includes'.DS.'PHPExcel'.DS.'IOFactory.php');   
        require_once('includes/download.class.php');  
        ini_set("memory_limit", "252M");   
        @set_time_limit(1000000);
        $objPHPExcel = new PHPExcel();                               
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load(JPATH_COMPONENT.DS.'apdm_pndesc_report.xls'); 
        global $mainframe;
            $me             =& JFactory::getUser();            
            $username       = $me->get('username');    
            $id = JRequest::getVar('pns_id');
            $db             =& JFactory::getDBO();  
            $query = 'SELECT * FROM apdm_pns WHERE pns_id='.$id;
            $db->setQuery( $query);
            $row = $db->loadObject();                                                                                            
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
             //for Execl
            $styleThinBlackBorderOutline = array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => 'FF000000'),
                    ),
                ),
            );  
            $objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);          
            $objPHPExcel->getActiveSheet()->getStyle('E5')->getFont()->setBold(true);                      
            $objPHPExcel->getActiveSheet()->setCellValue('A5', 'Username: '.$me->get('username'));   
            $objPHPExcel->getActiveSheet()->setCellValue('E5', 'Date Created: '.date('m/d/Y'));  
            //detail
            $pns_code           = $row->ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision;
			$pns_name			= $row->ccs_code.'_'.$row->pns_code.'_'.$row->pns_revision;
            $pns_modified       = ($row->pns_modified_by) ? JHTML::_('date', $row->pns_modified, '%m-%d-%Y %H:%M:%S') : 'None';
            $pns_modified_by    = ($row->pns_modified_by) ? GetValueUser($row->pns_modified_by, "username") : 'None';
            $pns_pdf            = ($row->pns_pdf !='') ? $row->pns_pdf : 'None';
           $objPHPExcel->getActiveSheet()->setCellValue('B7', $pns_code);  
           $objPHPExcel->getActiveSheet()->setCellValue('B8', GetEcoValue($row->eco_id));  
           $objPHPExcel->getActiveSheet()->setCellValue('B9', $row->pns_status);  
           $objPHPExcel->getActiveSheet()->setCellValue('B10', JHTML::_('date', $row->pns_create, '%m-%d-%Y %H:%M:%S'));  
           $objPHPExcel->getActiveSheet()->setCellValue('B11', $row->pns_type);             
           $objPHPExcel->getActiveSheet()->setCellValue('B12', GetValueUser($row->pns_create_by, "username"));  
           $objPHPExcel->getActiveSheet()->setCellValue('B13', $pns_modified);  
           $objPHPExcel->getActiveSheet()->setCellValue('B14', $pns_modified_by); 
           $objPHPExcel->getActiveSheet()->setCellValue('B15', $row->pns_description);  
           
           $objPHPExcel->getActiveSheet()->setCellValue('E19', $pns_pdf);  
           //For Vendor
           $nVendor = count($list_vendor);
           $i_vendor = 18;           
           if ($nVendor > 0 ){
               
               $objPHPExcel->getActiveSheet()->mergeCells('A'.$i_vendor.':'.'B'.$i_vendor);
               $objPHPExcel->getActiveSheet()->getStyle('A'.$i_vendor)->getFont()->setBold(true); 
               $objPHPExcel->getActiveSheet()->getStyle('A'.$i_vendor)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
               $objPHPExcel->getActiveSheet()->setCellValue('A'.$i_vendor, 'Vendor:');  
               $objPHPExcel->getActiveSheet()->getStyle('A'.$i_vendor)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);               
               //for header list Vendor
               $i_vendor++;
               $objPHPExcel->getActiveSheet()->getStyle('A'.$i_vendor)->getFont()->setBold(true); 
               $objPHPExcel->getActiveSheet()->getStyle('B'.$i_vendor)->getFont()->setBold(true); 
               $objPHPExcel->getActiveSheet()->setCellValue('A'.$i_vendor, 'Vendor Name'); 
               $objPHPExcel->getActiveSheet()->setCellValue('B'.$i_vendor, 'Vendor PNs'); 
               $objPHPExcel->getActiveSheet()->getStyle('A'.$i_vendor)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
               $objPHPExcel->getActiveSheet()->getStyle('B'.$i_vendor)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
               
               $objPHPExcel->getActiveSheet()->getStyle('A'.$i_vendor)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);               
               $objPHPExcel->getActiveSheet()->getStyle('B'.$i_vendor)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);               
               $objPHPExcel->getActiveSheet()->getStyle('A'.$i_vendor.':B'.$i_vendor)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
               $objPHPExcel->getActiveSheet()->getStyle('A'.$i_vendor.':B'.$i_vendor)->getFill()->getStartColor()->setARGB('FF808080');

               $j_vendor = 0;
                foreach ($list_vendor as $vendor){
                    $i_vendor++;
                    $a = 'A'.$i_vendor;
                    $b = 'B'.$i_vendor;
                    $objPHPExcel->getActiveSheet()->setCellValue($a, $vendor->info_name);
                    $objPHPExcel->getActiveSheet()->setCellValue($b, $vendor->supplier_info);
                    
                    $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);
                    $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);
                    
                    $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
                    $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);    
                    
                    $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    
                     $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                     
                      if ($j_vendor%2==0) {
                            $objPHPExcel->getActiveSheet()->getStyle($a.':'.$b)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                            $objPHPExcel->getActiveSheet()->getStyle($a.':'.$b)->getFill()->getStartColor()->setRGB('EEEEEE');
                          
                      }
                   if ($j_vendor ==$nVendor-1){ 
                       $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                       $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                       
                   }
                   $j_vendor++;
                    
                }
              $i_vendor++;                  
           }
            //For Supplier
           $i_super = $i_vendor;
           $nSuper = count($list_superlier); 
            if ($nSuper > 0 ){
               
               $objPHPExcel->getActiveSheet()->mergeCells('A'.$i_super.':'.'B'.$i_super);
               $objPHPExcel->getActiveSheet()->getStyle('A'.$i_super)->getFont()->setBold(true); 
               $objPHPExcel->getActiveSheet()->getStyle('A'.$i_super)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
               $objPHPExcel->getActiveSheet()->setCellValue('A'.$i_super, 'Supplier:');  
               $objPHPExcel->getActiveSheet()->getStyle('A'.$i_super)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);               
               //for header list Vendor
               $i_super++;
               $objPHPExcel->getActiveSheet()->getStyle('A'.$i_super)->getFont()->setBold(true); 
               $objPHPExcel->getActiveSheet()->getStyle('B'.$i_super)->getFont()->setBold(true); 
               $objPHPExcel->getActiveSheet()->setCellValue('A'.$i_super, 'Supplier Name'); 
               $objPHPExcel->getActiveSheet()->setCellValue('A'.$i_super, 'Supplier PNs'); 
               $objPHPExcel->getActiveSheet()->getStyle('A'.$i_super)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
               $objPHPExcel->getActiveSheet()->getStyle('B'.$i_super)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);               
               
               $objPHPExcel->getActiveSheet()->getStyle('A'.$i_super.':B'.$i_super)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
               $objPHPExcel->getActiveSheet()->getStyle('A'.$i_super.':B'.$i_super)->getFill()->getStartColor()->setARGB('FF808080');               
               
               $objPHPExcel->getActiveSheet()->getStyle('A'.$i_super)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);               
               $objPHPExcel->getActiveSheet()->getStyle('B'.$i_super)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);               
               $j_super = 0;
                foreach ($list_superlier as $super){
                    $i_super++;
                    $a = 'A'.$i_super;
                    $b = 'B'.$i_super;
                    $objPHPExcel->getActiveSheet()->setCellValue($a, $super->info_name);
                    $objPHPExcel->getActiveSheet()->setCellValue($b, $super->supplier_info);
                    
                    $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);
                    $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);
                    
                    $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
                    $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);    
                    
                    $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    
                     $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                     
                      if ($j_super%2==0) {
                            $objPHPExcel->getActiveSheet()->getStyle($a.':'.$b)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                            $objPHPExcel->getActiveSheet()->getStyle($a.':'.$b)->getFill()->getStartColor()->setRGB('EEEEEE');
                          
                      }
                   if ($j_super ==$nSuper-1){ 
                       $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                       $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                       
                   }
                   $j_super++;
                    
                }
              $i_super++;                  
           }
           // For manuafacture
            $i_m = $i_super;
           $nMan = count($list_manufacture); 
            if ($nMan > 0 ){
               
               $objPHPExcel->getActiveSheet()->mergeCells('A'.$i_m.':'.'B'.$i_m);
               $objPHPExcel->getActiveSheet()->getStyle('A'.$i_m)->getFont()->setBold(true); 
               $objPHPExcel->getActiveSheet()->getStyle('A'.$i_m)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
               $objPHPExcel->getActiveSheet()->setCellValue('A'.$i_m, 'Manufacture:');  
               $objPHPExcel->getActiveSheet()->getStyle('A'.$i_m)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);               
               //for header list Vendor
               $i_m++;
               $objPHPExcel->getActiveSheet()->getStyle('A'.$i_m)->getFont()->setBold(true); 
               $objPHPExcel->getActiveSheet()->getStyle('B'.$i_m)->getFont()->setBold(true); 
               $objPHPExcel->getActiveSheet()->setCellValue('A'.$i_m, 'Manufacture Name'); 
               $objPHPExcel->getActiveSheet()->setCellValue('A'.$i_m, 'Manufacture PNs'); 
               $objPHPExcel->getActiveSheet()->getStyle('A'.$i_m)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
               $objPHPExcel->getActiveSheet()->getStyle('B'.$i_m)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
               
               $objPHPExcel->getActiveSheet()->getStyle('A'.$i_m.':B'.$i_m)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
               $objPHPExcel->getActiveSheet()->getStyle('A'.$i_m.':B'.$i_m)->getFill()->getStartColor()->setARGB('FF808080');               
               
               $objPHPExcel->getActiveSheet()->getStyle('A'.$i_m)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);               
               $objPHPExcel->getActiveSheet()->getStyle('B'.$i_m)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);               
               $j_m = 0;
                foreach ($list_manufacture as $man){
                    $i_m++;
                    $a = 'A'.$i_m;
                    $b = 'B'.$i_m;
                    $objPHPExcel->getActiveSheet()->setCellValue($a, $super->info_name);
                    $objPHPExcel->getActiveSheet()->setCellValue($b, $super->supplier_info);
                    
                    $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);
                    $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);
                    
                    $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
                    $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);    
                    
                    $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    
                     $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                     
                      if ($j_m%2==0) {
                            $objPHPExcel->getActiveSheet()->getStyle($a.':'.$b)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                            $objPHPExcel->getActiveSheet()->getStyle($a.':'.$b)->getFill()->getStartColor()->setRGB('EEEEEE');
                          
                      }
                   if ($j_m ==$nMan-1){ 
                       $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                       $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                       
                   }
                   $j_m++;
                    
                }
              $i_m++;                  
           }
        // format fie image
        if ($row->pns_image !='') {
            $pns_imge = '../uploads/pns/images/'.$row->pns_image;              
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('PNs image');
            $objDrawing->setDescription('PNs imgae');
            $objDrawing->setPath($pns_imge);
            $objDrawing->setCoordinates('E7');
            $objDrawing->setHeight(60);
            $objDrawing->setWidth('200');
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        }
        $nCdas = count ($list_cads);
        if ($nCdas > 0 ){
          $i_file = 24;
          $folder_pns = $row->ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision;
          $j_file = 0;
          //Mercel
          $objPHPExcel->getActiveSheet()->mergeCells('D22:F22');    
          $objPHPExcel->getActiveSheet()->getStyle('D22')->getFont()->setBold(true);          
          $objPHPExcel->getActiveSheet()->setCellValue('D22', 'List File CADs');  
          $objPHPExcel->getActiveSheet()->getStyle('D22')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);               
          $objPHPExcel->getActiveSheet()->getStyle('D22')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM); 
          //for head file
          $objPHPExcel->getActiveSheet()->setCellValue('D23', 'No.');  
          $objPHPExcel->getActiveSheet()->setCellValue('E23', 'Name ');  
          $objPHPExcel->getActiveSheet()->setCellValue('F23', 'Size (KB) ');  
          $objPHPExcel->getActiveSheet()->getStyle('D23')->getFont()->setBold(true); 
          $objPHPExcel->getActiveSheet()->getStyle('E23')->getFont()->setBold(true); 
          $objPHPExcel->getActiveSheet()->getStyle('F23')->getFont()->setBold(true); 
          $objPHPExcel->getActiveSheet()->getStyle('D23:F23')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
          $objPHPExcel->getActiveSheet()->getStyle('D23:F23')->getFill()->getStartColor()->setARGB('FF808080');        
          $objPHPExcel->getActiveSheet()->getStyle('D23')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
          $objPHPExcel->getActiveSheet()->getStyle('E23')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
          $objPHPExcel->getActiveSheet()->getStyle('F23')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);  
          $path_pns = JPATH_SITE.DS.'uploads'.DS.'pns'.DS;   
//$fp = fopen ($path_pns."file.txt", "w"); 
          foreach ($list_cads as $cad){
              $d = 'D'.$i_file;
              $e = 'E'.$i_file;
              $f = 'F'.$i_file;
			  
              $filesize = PNsController::Readfilesize('cads', $cad->cad_file, $row->ccs_code, $folder_pns);    
			  
			
		//	fwrite($fp, $filesize.'  \r\n ');	
			
				
              $objPHPExcel->getActiveSheet()->setCellValue($d, $j_file+1);
              $objPHPExcel->getActiveSheet()->setCellValue($e, $cad->cad_file);
              $objPHPExcel->getActiveSheet()->setCellValue($f, $filesize);
              
              $objPHPExcel->getActiveSheet()->getStyle($d)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);
              $objPHPExcel->getActiveSheet()->getStyle($e)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);
              $objPHPExcel->getActiveSheet()->getStyle($f)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);
            
              $objPHPExcel->getActiveSheet()->getStyle($d)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
              $objPHPExcel->getActiveSheet()->getStyle($e)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);    
              $objPHPExcel->getActiveSheet()->getStyle($f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);    
            
              $objPHPExcel->getActiveSheet()->getStyle($d)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
              $objPHPExcel->getActiveSheet()->getStyle($e)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
              $objPHPExcel->getActiveSheet()->getStyle($f)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            
              $objPHPExcel->getActiveSheet()->getStyle($d)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             
              if ($j_file%2==0) {
                    $objPHPExcel->getActiveSheet()->getStyle($d.':'.$f)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                    $objPHPExcel->getActiveSheet()->getStyle($d.':'.$f)->getFill()->getStartColor()->setRGB('EEEEEE');
                  
              }
               if ($j_file ==$nCdas-1){ 
                   $objPHPExcel->getActiveSheet()->getStyle($d)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                   $objPHPExcel->getActiveSheet()->getStyle($e)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                   $objPHPExcel->getActiveSheet()->getStyle($f)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                   
               }                  
              $i_file++;
              $j_file++;
          }
          
        }
	//	fclose($fp);
        $path_export = JPATH_SITE.DS.'uploads'.DS.'export'.DS;           
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$name_file = 'APDM_PNdesc_REPORT_'.$pns_name.'_'.date('d_m_Y');
        $objWriter->save($path_export.$name_file.'.xls');             
        $dFile=new DownloadFile($path_export,$name_file.'.xls');
        exit; 
           
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
        /*
          alter table `apdm`.`apdm_pns` add column `pns_life_cycle` varchar (100) COLLATE utf8_general_ci   NULL  after `pns_deleted`, add column `pns_uom` varchar (100) COLLATE utf8_general_ci   NULL  after `pns_life_cycle`, add column `pns_cost` varchar (100) COLLATE utf8_general_ci   NULL  after `pns_uom`, add column `pns_stock` int (11) DEFAULT '0' NULL  after `pns_cost`;
         */
}// end func
}
