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
jimport('joomla.filesystem.file');
require_once('includes/class.upload.php');
require_once('includes/download.class.php');

/**
 * Users Component Controller
 *
 * @package		Joomla
 * @subpackage	Users
 * @since 1.5
 */
class ECOController extends JController
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
        $this->registerTask( 'edit'  ,     'display'  );
		$this->registerTask( 'detail'  , 	'display'  );        
		$this->registerTask( 'apply', 	'save'  );
		$this->registerTask( 'flogout', 'logout');
		$this->registerTask( 'unblock', 'block' );
		$this->registerTask( 'download', 'download' );
        $this->registerTask( 'export', 'export' ); 
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
				JRequest::setVar( 'view', 'update' );
				JRequest::setVar( 'edit', false );
			} break;
			case 'edit'    :
			{
				
				JRequest::setVar( 'layout', 'form'  );
				JRequest::setVar( 'view', 'update' );
				JRequest::setVar( 'edit', true );
			} break;
            case 'detail'    :
            {
                
                JRequest::setVar( 'layout', 'detail'  );
                JRequest::setVar( 'view', 'update' );
                JRequest::setVar( 'edit', true );
            } break;
		}

		parent::display();
	}
    function remove_file(){
     
        $db = & JFactory::getDBO();
        $id = JRequest::getVar('id');
        $eco_id = JRequest::getVar('eco_id');
        $db->setQuery("SELECT * FROM apdm_eco_files WHERE id=".$id);
        $row = $db->loadObject();
        $file_name = $row->file_name;
        $eco_id = $row->eco_id;
        $path_eco = JPATH_SITE.DS.'uploads'.DS.'eco'.DS;    
        $remove = new Upload($path_eco.$file_name);
        $remove->file_dst_pathname = $path_eco.$file_name;
        $remove->clean();
        $db->setQuery("DELETE FROM apdm_eco_files WHERE id=".$id);
        $db->query();
       $msg = JText::_( 'Successfully Deleted file' );
       $this->setRedirect( 'index.php?option=com_apdmeco&task=edit&cid[]='.$eco_id, $msg );   
        
    }
	/**
	* Download file
	**/
	function download(){
        
        $db = & JFactory::getDBO();
		$id = JRequest::getVar('id');
        $db->setQuery("SELECT file_name FROM apdm_eco_files WHERE id=".$id);
        $row = $db->loadObject();        
        
		$file_name = $row->file_name;
		$path_eco = JPATH_SITE.DS.'uploads'.DS.'eco'.DS;	
		//echo $path_eco; exit;
		$dFile=new DownloadFile($path_eco,$file_name);
		exit;
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
		$check_senmail = JRequest::getVar('check_sendmail');
		
		$MailFrom	= $mainframe->getCfg('mailfrom');
		$FromName	= $mainframe->getCfg('fromname');
		$SiteName	= $mainframe->getCfg('sitename');

		
		
		//echo JPATH_SITE;
		//upload file pdf
        $row = & JTable::getInstance('apdmeco');
        if (!$row->bind( JRequest::get('post'))) {
            JError::raiseError( 500, $db->stderr() );
            return false;
        }
        if (! $row->check()){
            $msg = JText::_( 'This name eco have exist. Please input other name' );
            $this->setRedirect( 'index.php?option=com_apdmeco&task=add', $msg ); 
        }else{
            $arr_file = array();
		    for ($i=1; $i <= 10; $i++) {
                $file_name = 'file'.$i;
		        if($_FILES[$file_name]['size'] > 0){			
			        $handle = new Upload($_FILES[$file_name]);
			        //get root path
			        $path_eco = JPATH_SITE.DS.'uploads'.DS.'eco'.DS;					
			      //  $file_ext = $handle->file_src_name_ext; 			    
			       // $file_name = $handle->file_src_name;
			       // if (file_exists($path_eco.$file_name)){
				    //    $new_name = time();
				     //   $handle->file_new_name_body = $new_name.$handle->file_src_name_body;				
				      //  $handle->file_new_name_ext = $handle->file_src_name_ext;				        
			       // }
			        if ($handle->uploaded) {			
			          $handle->Process($path_eco);			 
			          if ($handle->processed) {
//				        $file_name_ok = $handle->file_dst_name;
						$arr_file[]   = $handle->file_dst_name;
				        //remove file old
				       /* if (JRequest::getVar("file_pdf_exist")!=""){
					        $remove_file = new Upload();
					        $remove_file->file_src_pathname = $path_eco.JRequest::getVar("file_pdf_exist");
					        $remove_file->clean();
				        } */
			         }
			        }
  //                  $arr_file[]  =  $file_name_ok;
		        }
            }
		    
		    $row->eco_id = (int) $row->eco_id;
		    $isNew = true;		
		    
		    if ($row->eco_id) {
			    $isNew = false;
			    $datenow =& JFactory::getDate();
			    $row->eco_modified 	= $datenow->toMySQL();
			    $row->eco_modified_by 	= $me->get('id');
		    }
		    $row->eco_create_by 	= $row->eco_create_by ? $row->eco_create_by : $me->get('id');

		    if ($row->eco_create && strlen(trim( $row->eco_create )) <= 10) {
			    $row->eco_create 	.= ' 00:00:00';
		    }
		    $config =& JFactory::getConfig();
		    $tzoffset = $config->getValue('config.offset');
		    $date =& JFactory::getDate($row->eco_create, $tzoffset);
		    $row->eco_create = $date->toMySQL();
		   
		    
		    // Store the content to the database
		    if (!$row->store()) {
			    JError::raiseError( 500, $db->stderr() );
			    return false;
		    }else{
			    if ($isNew){
				    $what = "W";
			    }else{
				    $what = "E";
			    }			
			    JAdministrator::HistoryUser(5, $what, $row->eco_id);
		    }
		    
            if (count($arr_file) > 0 ){
                foreach ($arr_file as $file){
                    $query = "INSERT INTO apdm_eco_files (eco_id, file_name) VALUES (".$row->eco_id.", '".$file."') ";
                    $db->setQuery($query);
                    $db->query();
                }
            }
		    if ($check_senmail){
			    $arr_user = JRequest::getVar('mail_user', array(0), '', 'array');			

			    $subject = "New ECO have update";
			    $message = "Hi, Please check site go get new information of ECO";
                $adminEmail = $me->get('email');
                $adminName    = $me->get('name');
                if ($MailFrom != '' && $FromName != '')
                    {
                        $adminName     = $FromName;
                        $adminEmail = $MailFrom;
                    }
                
			    foreach ($arr_user as $user){
                    JUtility::sendMail( $adminEmail, $adminName, $user, $subject, $message );    
				    //JUtility::sendMail( $adminEmail, $adminName, $user, $subject, $message );				
			    }
			    
		    }
		    
		    switch ( $this->getTask() )
		    {
			    case 'apply':
				    $msg = JText::sprintf( 'Successfully Saved changes to ECO', $row->eco_name );
				    $this->setRedirect( 'index.php?option=com_apdmeco&task=detail&cid[]='. $row->eco_id, $msg );
				    break;

			    case 'save':
			    default:
				    $msg = JText::sprintf( 'Successfully Saved ECO', $row->eco_name );
				    $this->setRedirect( 'index.php?option=com_apdmeco&task=add', $msg );
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
		$cid 			= JRequest::getVar( 'cid', array(), '', 'array' );
		$currentUser 	=& JFactory::getUser();
		$datenow =& JFactory::getDate();
		JArrayHelper::toInteger( $cid );

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select a record to delete', true ) );
		}
		
		
		
		foreach ($cid as $id)
		{
			$query = "UPDATE apdm_eco SET  eco_deleted=1, eco_modified='".$datenow->toMySQL()."', eco_modified_by = ".$currentUser->get('id')." WHERE eco_id=".$id;
			$db->setQuery($query);
			$db->query();			
			JAdministrator::HistoryUser(5, 'D', $id);
			//SET UPDATE FOR PmS
			
		}		
		$msg = JText::_('ALERT_DETELE_ECO');
		$this->setRedirect( 'index.php?option=com_apdmeco', $msg);
	}

	/**
	 * Cancels an edit operation
	 */
	function cancel( )
	{
		$this->setRedirect( 'index.php?option=com_apdmeco');
	}

	/**
	 * Disables the user account
	 */
	function block( )
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$db 			=& JFactory::getDBO();		
		$currentUser 	=& JFactory::getUser();
		$datenow =& JFactory::getDate();

		$cid 	= JRequest::getVar( 'cid', array(), '', 'array' );
		
		$block  = $this->getTask() == 'block' ? 0 : 1;

		JArrayHelper::toInteger( $cid );

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select a eco to '.$this->getTask(), true ) );
		}
		foreach ($cid as $id)
		{
			$query = "UPDATE apdm_eco SET  eco_status=".$block.", eco_modified='".$datenow->toMySQL()."', eco_modified_by = ".$currentUser->get('id')." WHERE eco_id=".$id;
			$db->setQuery($query);
			$db->query();			
			//set update PNs
			//set history			
			JAdministrator::HistoryUser(5, 'E', $id);
			
		}
		$msg = JText::_('UPDATE_ACTIVATE');
		$this->setRedirect( 'index.php?option=com_apdmeco', $msg);
	}
      function export(){
        global $mainframe;
            $me             =& JFactory::getUser();                
            $query_exprot   = JRequest::getVar("query_exprot");
            $total          = JRequest::getVar("total_record");
            $limit          = $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
            $limitstart     = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
            $db             =& JFactory::getDBO(); 
            //jimport('joomla.html.pagination');
            //$pagination = new JPagination( $total, $limitstart, $limit );
            $query = base64_decode($query_exprot);
            //$db->setQuery( $query, $pagination->limitstart, $pagination->limit );
            $db->setQuery( $query); 
            $rows = $db->loadObjectList();
            $content = '';           
             $user_name = $me->get('name');
             $date = JHTML::_('date', date("Y-m-d"), '%m/%d/%Y');
             $name = 'ECO_Report';
             require_once( JPATH_COMPONENT.DS.'eco.xls.php' );
            //  ob_end_clean();
             header("Content-type: application/vnd.ms-excel"); 
             header("Content-Disposition: attachment; filename=".$name.".xls"); 
             header("Pragma: no-cache"); 
             header("Expires: 0"); 
            exit;
        // CCsController::downContent('eee.xls',$content);
       //   exit;
         
    }
    function get_eco(){
        JRequest::setVar( 'layout', 'list'  );
        JRequest::setVar( 'view', 'geteco' );
        parent::display();
    }
	function code_default(){
		 $db             =& JFactory::getDBO(); 
		 $arrExist    = array();
		 
		 $db->setQuery(" SELECT eco_name FROM apdm_eco ");
		 $rows = $db->loadObjectList();
		 if ( count ( $rows ) > 0 ){
		 	foreach ( $rows as $row ){
				$arrExist[] = $row->eco_name;
			}
		 }
		
			$number = ECOController::random_number();
		if ( count ($arrExist) > 0  && in_array($number, $arrExist)) {
			$number = ECOController::random_number();
		}
		echo $number;
		exit;

		
	}
	function random_number(){				
        $arr_char = array('1', '1', '1', '1', '1', '2', '2', '2', '2', '2', '3', '3', '3', '3', '3','4', '4', '4', '4', '4', '5', '5', '5', '5', '5', '6', '6', '6', '6', '6',  '7', '7', '7', '7', '7', '8', '8', '8', '8', '8','9', '9', '9', '9', '9', '0', '0', '0', '0', '0');
		$arr_get = array_rand($arr_char, 5);
		$arr_result = array();
		foreach ($arr_get as $obj){
			$arr_result[] = $arr_char[$obj];
		}		
		$code = implode("", $arr_result);	
		return $code;	
	}


    function ajax_eco(){
        
        $cid             = JRequest::getVar( 'cid', array(), '', 'array' );       
        $id = $cid[0];
        $row =& JTable::getInstance('apdmeco');
        $row->load($id);
        $name_eco = $row->eco_name;
        $result = $id.'^'.$name_eco;
        echo $result;
        exit;
    }
	function Readfilesize($filename){
      $path = JPATH_SITE.DS.'uploads'.DS.'eco'.DS;   
      $filesize =  ceil ( filesize($path.$filename) / 1000 ) ;
      return $filesize;
   }
	
}
