<?php
/**
 * @package		APDM
 * @subpackage	UECO
 **/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');
jimport('joomla.filesystem.file');
require_once('includes/class.upload.php');
require_once('includes/download.class.php');

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
                $this->registerTask( 'files'  , 	'files'  );        
                $this->registerTask( 'saveapprove'  , 	'saveapprove'  );    
                $this->registerTask( 'savefiles', 	'savefiles'  );
                $this->registerTask( 'save_routes', 	'save_routes'  );
                $this->registerTask( 'add_routes', 	'add_routes'  );
                $this->registerTask( 'remove_routes', 	'remove_routes'  );
                $this->registerTask( 'edit_routes', 	'edit_routes'  );
                $this->registerTask( 'add_approvers', 	'add_approvers'  );
                $this->registerTask( 'set_route_eco', 	'set_route_eco'  );
                $this->registerTask( 'initial', 	'initial'  );
                $this->registerTask( 'affected', 	'affected'  );
                
        
        
        
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
	/**
		* Delete file upload 
	*/
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
        function savefiles()
        {
                global $mainframe;

                // Check for request forgeries
                JRequest::checkToken() or jexit('Invalid Token');

                $option = JRequest::getCmd('option');

                // Initialize some variables
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $row = & JTable::getInstance('apdmeco');
                if (!$row->bind(JRequest::get('post'))) {
                        JError::raiseError(500, $db->stderr());
                        return false;
                }                           
                $arr_file = array();
                for ($i = 1; $i <= 10; $i++) {
                        $file_name = 'file' . $i;
                        if ($_FILES[$file_name]['size'] > 0) {
                                $handle = new Upload($_FILES[$file_name]);
                                //get root path
                                $path_eco = JPATH_SITE . DS . 'uploads' . DS . 'eco' . DS;
                                if ($handle->uploaded) {
                                        $handle->Process($path_eco);
                                        if ($handle->processed) {
                                                $arr_file[] = $handle->file_dst_name;
                                        }
                                }
                        }
                }
                if (count($arr_file) > 0) {
                        foreach ($arr_file as $file) {
                                $query = "INSERT INTO apdm_eco_files (eco_id, file_name) VALUES (" . $row->eco_id . ", '" . $file . "') ";
                                $db->setQuery($query);
                                $db->query();
                        }
                }
                $msg = JText::sprintf('Successfully Saved changes to Files', $row->eco_name);
                $this->setRedirect('index.php?option=com_apdmeco&task=files&cid[]=' . $row->eco_id, $msg);                
                
        }
	/**
	 * Saves the record
	 */
	function save() {
                global $mainframe;

                // Check for request forgeries
                JRequest::checkToken() or jexit('Invalid Token');

                $option = JRequest::getCmd('option');

                // Initialize some variables
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $check_senmail = JRequest::getVar('check_sendmail');

                $MailFrom = $mainframe->getCfg('mailfrom');
                $FromName = $mainframe->getCfg('fromname');
                $SiteName = $mainframe->getCfg('sitename');

//                $approve_status = JRequest::getVar('approve_status');
//                $approve_note = JRequest::getVar('approve_note');
//                

                //echo JPATH_SITE;
                //upload file pdf
                $row = & JTable::getInstance('apdmeco');
                if (!$row->bind(JRequest::get('post'))) {
                        JError::raiseError(500, $db->stderr());
                        return false;
                }
                if (!$row->check()) {
                        $msg = JText::_('This name eco have exist. Please input other name');
                        $this->setRedirect('index.php?option=com_apdmeco&task=add', $msg);
                } else {
                        $arr_file = array();
                        for ($i = 1; $i <= 10; $i++) {
                                $file_name = 'file' . $i;
                                if ($_FILES[$file_name]['size'] > 0) {
                                        $handle = new Upload($_FILES[$file_name]);
                                        //get root path
                                        $path_eco = JPATH_SITE . DS . 'uploads' . DS . 'eco' . DS;
                                        if ($handle->uploaded) {
                                                $handle->Process($path_eco);
                                                if ($handle->processed) {
                                                        $arr_file[] = $handle->file_dst_name;
                                                }
                                        }
                                }
                        }

                        $row->eco_id = (int) $row->eco_id;
                        $isNew = true;
                        $IsCreater = 'create';
                        if ($row->eco_id) {
                                $isNew = false;
                                $IsCreater = 'update';
                                $datenow = & JFactory::getDate();
                                $row->eco_modified = $datenow->toMySQL();
                                $row->eco_modified_by = $me->get('id');
                        }
                        

                        if ($row->eco_create && strlen(trim($row->eco_create)) <= 10) {
                                $row->eco_create .= ' 00:00:00';
                        }
                        $config = & JFactory::getConfig();
                        $tzoffset = $config->getValue('config.offset');
                        $date = & JFactory::getDate($row->eco_create, $tzoffset);
                        $row->eco_create = $date->toMySQL();


                        // Store the content to the database
                        if (!$row->store()) {
                                JError::raiseError(500, $db->stderr());
                                return false;
                        } else {

//                           if(JRequest::getVar('eco_status_tmp')=='Released')
//                           {
//                           Temp not use
                                //viet add historyapprove 
                                                
//                                $query = 'update apdm_eco_status set eco_status= "' . $approve_status . '", note = "'.$approve_note.'" where eco_id = ' . $row->eco_id . ' and email= "' . $me->get('email') . '"';
//                                $db->setQuery($query);
//                                $db->query();
//                                //   }
//                                $db->setQuery('select count(*) from apdm_eco_status where eco_id = ' . $row->eco_id . '');
//                                $totalApprovers = $db->loadResult();
//                                //check all release
//                                $db->setQuery('select count(*) from apdm_eco_status where eco_status = "Create" and eco_id = ' . $row->eco_id . '');
//                                $totalPending = $db->loadResult();
//                                if ($totalPending > 0) {
//                                        $row->eco_status = 'Create'; //JRequest::getVar('eco_status_tmp');  
//                                        $row->store();
//                                }
//                                //check all release
//                                $db->setQuery('select count(*) from apdm_eco_status where eco_status = "Released" and eco_id = ' . $row->eco_id . '');
//                                $totalReleased = $db->loadResult();
//                                if ($totalApprovers == $totalReleased) {
//                                        $row->eco_status = 'Released'; //JRequest::getVar('eco_status_tmp');  
//                                        $row->store();
//                                }
//                                //check all reject
//                                $db->setQuery('select count(*) from apdm_eco_status where eco_status = "Inreview" and eco_id = ' . $row->eco_id . '');
//                                $totalReject = $db->loadResult();
//                                if ($totalApprovers == $totalReject) {
//                                        $row->eco_status = 'Inreview'; //JRequest::getVar('eco_status_tmp');  
//                                        $row->store();
//                                }

                                if ($row->eco_status == 'Released') {
                                        $query = 'update apdm_pns set pns_life_cycle= "Released" where eco_id = ' . $row->eco_id . '';
                                        $db->setQuery($query);
                                        $db->query();
                                }
                                if ($isNew) {
                                        $row->eco_create_by = $row->eco_create_by ? $row->eco_create_by : $me->get('id');
                                        //if create new set eco_status(lyfe_cycle) default is Create
                                        $row->eco_status = 'Create';
                                        $row->store();
                                        $what = "W";
                                } else {
                                        $what = "E";
                                }
                                JAdministrator::HistoryUser(5, $what, $row->eco_id);
                        }

                        if (count($arr_file) > 0) {
                                foreach ($arr_file as $file) {
                                        $query = "INSERT INTO apdm_eco_files (eco_id, file_name) VALUES (" . $row->eco_id . ", '" . $file . "') ";
                                        $db->setQuery($query);
                                        $db->query();
                                }
                        }
                        
                        $mail_remove = JRequest::getVar('mail_remove', array(0), '', 'array');
                        foreach ($mail_remove as $e_rm) {                                
                                if($e_rm!= $me->get('email'))
                                {                                        
                                        $query = "delete from apdm_eco_status where eco_id = ". $row->eco_id . " and email =  '" . $e_rm."'";
                                        $db->setQuery($query);
                                        $db->query();
                                }
                        }
                        if ($check_senmail) {

                                $arr_user = JRequest::getVar('mail_user', array(0), '', 'array');
                                
                                //$subject = "ECO#".$row->eco_name." ".$IsCreater." by ".$me->get('username')." on ".date('m-d-Y');
                                $subject = "[ADP] ECO " . $row->eco_status . " notice - " . $row->eco_name;
                                $message1 = "Please be noticed that this ECO has been " . $row->eco_status;

                                if ($row->eco_status != 'Released') {
                                        $subject = "[ADP] ECO Approval request - " . $row->eco_name;
                                        $message1 = "Please go to <a href='http://10.10.1.245/ADP/administrator/index.php?option=com_apdmeco&task=detail&cid[]=" . $row->eco_id . "'>ADP</a> to approve/reject for this ECO";

                                        foreach ($arr_user as $user) {
                                                if($user!= $me->get('email'))
                                                {
                                                        $query = "INSERT INTO apdm_eco_status (eco_id,email,eco_status) VALUES (" . $row->eco_id . ", '" . $user . "','Create') ON DUPLICATE KEY UPDATE eco_status = '" . $row->eco_status . "'";
                                                        $db->setQuery($query);
                                                        $db->query();
                                                }
                                        }
                                }


                                $message2 = "<br>+ ECO #: " . $row->eco_name .
                                        "<br>+ Description: " . $row->eco_description .
                                        "<br>+ Status: " . $row->eco_status .
                                        "<br>+ Created by: " . GetValueUser($row->eco_create_by, 'username') .
                                        "<br>+ Date of create: " . $row->eco_create;

                                $message = $message1 . $message2;


                                if (!$isNew) {
                                        $message .= "<br>+ Modified by: " . GetValueUser($row->eco_modified_by, 'username') .
                                                "<br>+ Date of modify: " . $row->eco_modified;
                                }


                                $adminEmail = $me->get('email');
                                $adminName = $me->get('name');
                                if ($MailFrom != '' && $FromName != '') {
                                        $adminName = $FromName;
                                        $adminEmail = $MailFrom;
                                }

                                foreach ($arr_user as $user) {
                                        //tam thoi  JUtility::sendMail( $adminEmail, $adminName, $user, $subject, $message, 1 );    
                                }
                        }
                        //viet loghistory
                        $queryLog = "insert into `apdm_eco_affected`(`eco_id`,`eco_name`,`eco_description`,`eco_status`,`eco_project`,`eco_type`,`eco_field_impact`,`eco_reason`,`eco_what`,`eco_special`,`eco_benefit`,`eco_technical`,`eco_tech_design`,`eco_estimated`,`eco_estimated_cogs`,`eco_target`,`eco_modified`,`eco_modified_by`) values " .
                                "('" . $row->eco_id . "','" . $row->eco_name . "','" . $row->eco_description . "','" . $row->eco_status . "','" . $row->eco_project . "','" . $row->eco_type . "','" . $row->eco_field_impact . "','" . $row->eco_reason . "','" . $row->eco_what . "','" . $row->eco_special . "','" . $row->eco_benefit . "','" . $row->eco_technical . "','" . $row->eco_tech_design . "','" . $row->eco_estimated . "','" . $row->eco_estimated_cogs . "','" . $row->eco_target . "','" . $row->eco_modified . "',$row->eco_modified_by)";
                        $db->setQuery($queryLog);
                        $db->query();
                        switch ($this->getTask()) {
                                case 'apply':
                                        $msg = JText::sprintf('Successfully Saved changes to ECO', $row->eco_name);
                                        $this->setRedirect('index.php?option=com_apdmeco&task=detail&cid[]=' . $row->eco_id, $msg);
                                        break;

                                case 'save':
                                default:
                                        $msg = JText::sprintf('Successfully Saved ECO', $row->eco_name);
                                        $this->setRedirect('index.php?option=com_apdmeco&task=add', $msg);
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
	/**
		Export list with format excel.
	*/
      function export(){
        include_once(JPATH_BASE .DS.'includes'.DS.'PHPExcel.php');
        require_once (JPATH_BASE .DS.'includes'.DS.'PHPExcel'.DS.'RichText.php');        
        require_once(JPATH_BASE .DS.'includes'.DS.'PHPExcel'.DS.'IOFactory.php');   
        require_once('includes/download.class.php');     
        $objPHPExcel = new PHPExcel();                               
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load(JPATH_COMPONENT.DS.'apdm_eco_report.xls'); 
        global $mainframe;
            $me             =& JFactory::getUser();                
            $query_exprot   = JRequest::getVar("query_exprot");
            $total          = JRequest::getVar("total_record");
            $limit          = $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
            $limitstart     = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );       
             $db             =& JFactory::getDBO(); 
            jimport('joomla.html.pagination');
            $pagination = new JPagination( $total, $limitstart, $limit );
            $query = base64_decode($query_exprot);
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
            $objPHPExcel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);  
           
            $objPHPExcel->getActiveSheet()->setCellValue('A5', 'Username: '.$me->get('username'));   
            $objPHPExcel->getActiveSheet()->setCellValue('F5', 'Date Created: '.$date);   
            $nRecord = count($rows);
            $objPHPExcel->getActiveSheet()->getStyle('A5:F'.$nRecord)->getAlignment()->setWrapText(true);
               if ($nRecord > 0){
                    $j=0;
                    $i = 7;        
					$number = 1;
                    foreach ($rows as $row){
                        $a = 'A'.$i;
                        $b='B'.$i;
                        $c='C'.$i;
                        $d = 'D'.$i;
                        $e = 'E'.$i;
                        $f = 'F'.$i;
                        $g = 'G'.$i;
						$h= 'H'.$i;
                        
                        if ($row->info_type ==2) $type = 'Vendor';
                        if ($row->info_type ==3) $type = 'Supplier';
                        if ($row->info_type ==4) $type = 'Manufacture';
                        $status = $row->eco_status;
                      
                        $date_modified = ($row->eco_modified_by) ? JHTML::_('date', $row->eco_modified, '%m/%d/%Y') : 'None';
                        $modified = ($row->eco_modified_by) ? GetValueUser($row->eco_modified_by, 'username') : 'None';
                        $eco_description = strip_tags($row->eco_description);
                        $string_length = strlen($eco_description);
                        if ($string_length > 70 ) {
                            $step_height = round($string_length / 70 );
                        }else{
                            $step_height = 1;
                        }
                        $height = 30 * $step_height;
                        //set heigh or row 
                        $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight($height);               
                        $objPHPExcel->getActiveSheet()->setCellValue($a, $number);
						$objPHPExcel->getActiveSheet()->setCellValue($b, $row->eco_name);
                        $objPHPExcel->getActiveSheet()->setCellValue($c, $eco_description);
                        $objPHPExcel->getActiveSheet()->setCellValue($d, $status);
                        $objPHPExcel->getActiveSheet()->setCellValue($e,  JHTML::_('date', $row->eco_create, '%m/%d/%Y'));
                        $objPHPExcel->getActiveSheet()->setCellValue($f, GetValueUser($row->eco_create_by, 'username'));  
                        $objPHPExcel->getActiveSheet()->setCellValue($g, $date_modified);  
                        $objPHPExcel->getActiveSheet()->setCellValue($h, $modified);  
                        
                        
                        //set format
                        $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($c)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($d)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($e)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($f)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($g)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				      	$objPHPExcel->getActiveSheet()->getStyle($h)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        
                        $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($c)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
                        $objPHPExcel->getActiveSheet()->getStyle($d)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
                        $objPHPExcel->getActiveSheet()->getStyle($e)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
                        $objPHPExcel->getActiveSheet()->getStyle($f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
                        $objPHPExcel->getActiveSheet()->getStyle($g)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
						$objPHPExcel->getActiveSheet()->getStyle($h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
                        
                                                                                                                                    
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
            $objWriter->save($path_export.'APDM_ECO_REPORT.xls');             
            $dFile=new DownloadFile($path_export,'APDM_ECO_REPORT.xls');
            exit; 
            
            
         
    }
	/**
		* Export detail ECO with format excel
	*/
     function export_detail(){
        include_once(JPATH_BASE .DS.'includes'.DS.'PHPExcel.php');
        require_once (JPATH_BASE .DS.'includes'.DS.'PHPExcel'.DS.'RichText.php');        
        require_once(JPATH_BASE .DS.'includes'.DS.'PHPExcel'.DS.'IOFactory.php');   
        require_once('includes/download.class.php');     
        $objPHPExcel = new PHPExcel();                               
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load(JPATH_COMPONENT.DS.'apdm_ecodesc_report.xls'); 
        
        global $mainframe;
            $me             =& JFactory::getUser();            
            $username       = $me->get('username');    
            $id = JRequest::getVar('eco_id');
            $db             =& JFactory::getDBO();  
            $query = 'SELECT * FROM  apdm_eco WHERE eco_id='.$id;
            $db->setQuery( $query);
            $row = $db->loadObject();        
            //get list file
            $db->setQuery("SELECT * FROM apdm_eco_files WHERE eco_id=".$id);
            $list_file  = $db->loadObjectList();                                       
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
            $eco_activate = ($row->eco_activate) ? 'Activated' : 'Non-Active';
           $objPHPExcel->getActiveSheet()->setCellValue('B7', $row->eco_name);  
           $objPHPExcel->getActiveSheet()->setCellValue('B8', $row->eco_project);  
           $objPHPExcel->getActiveSheet()->setCellValue('B9', $row->eco_type);  
           $objPHPExcel->getActiveSheet()->setCellValue('B10', $row->eco_field_impact );  
           $objPHPExcel->getActiveSheet()->setCellValue('B11', $row->eco_reason);  
           $objPHPExcel->getActiveSheet()->setCellValue('B12', $row->eco_what);  
           $objPHPExcel->getActiveSheet()->setCellValue('B13', $row->eco_special);  
           $objPHPExcel->getActiveSheet()->setCellValue('B14', $row->eco_benefit);  
           $objPHPExcel->getActiveSheet()->setCellValue('B15', $row->eco_technical);  
           $objPHPExcel->getActiveSheet()->setCellValue('B16', $row->eco_tech_design);  
           $objPHPExcel->getActiveSheet()->setCellValue('B17', $row->eco_estimated);  
           $objPHPExcel->getActiveSheet()->setCellValue('B18', $row->eco_estimated_cogs);  
           $objPHPExcel->getActiveSheet()->setCellValue('B19', $eco_activate);  
           $objPHPExcel->getActiveSheet()->setCellValue('B20', $row->eco_status);  
           $objPHPExcel->getActiveSheet()->setCellValue('B21', $row->eco_description);                
           
           $modified = ($row->eco_modified_by) ? JHTML::_('date', $row->eco_modified, '%Y-%m-%d %H:%M:%S') : 'None';
           $modified_by = ($row->eco_modified_by) ? GetValueUser($row->eco_modified_by, 'username') : 'None';
           $objPHPExcel->getActiveSheet()->setCellValue('E7', JHTML::_('date', $row->eco_create, '%Y-%m-%d %H:%M:%S'));  
           $objPHPExcel->getActiveSheet()->setCellValue('E8', GetValueUser($row->eco_create_by, 'username'));  
           $objPHPExcel->getActiveSheet()->setCellValue('E9', $modified);  
           $objPHPExcel->getActiveSheet()->setCellValue('E10', $modified_by);  
           $nRecord = count ($list_file);
           if ( $nRecord > 0){
                $j=0;
                $i = 25;  
                foreach ($list_file as $file){
                        $a = 'A'.$i;
                        $b='B'.$i;
                        $c='C'.$i;
                        $filesize = ReadfilesizeECO($file->file_name);                          
                        
                        //set heigh or row                         
                        $objPHPExcel->getActiveSheet()->setCellValue($a, $j+1);
                        $objPHPExcel->getActiveSheet()->setCellValue($b, $file->file_name);
                        $objPHPExcel->getActiveSheet()->setCellValue($c, number_format($filesize, 0, '.', ' '));                         
                        //set format
                        $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($c)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        
                        
                        $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
                        $objPHPExcel->getActiveSheet()->getStyle($c)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        
                                                                                                                                    
                        $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        $objPHPExcel->getActiveSheet()->getStyle($c)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        
                        $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                
                        if ($j%2==0) {
                            $objPHPExcel->getActiveSheet()->getStyle($a.':'.$c)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                            $objPHPExcel->getActiveSheet()->getStyle($a.':'.$c)->getFill()->getStartColor()->setRGB('EEEEEE');
                          
                        }
                       if ($j ==$nRecord-1){
                            $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $objPHPExcel->getActiveSheet()->getStyle($c)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            
                        }                 
                        $i++;
                        $j++;
                }
                
               
           }
           
           
           $path_export = JPATH_SITE.DS.'uploads'.DS.'export'.DS;           
           $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		   $name_file = 'APDM_ECOdesc_REPORT_'.$row->eco_name.'_'.date('m_d_Y').'.xls';
           $objWriter->save($path_export.$name_file);             
           $dFile=new DownloadFile($path_export,$name_file);
           exit;     
                                                        

           
    }
	/**
		* Display list ECO
	*/
    function get_eco(){
        JRequest::setVar( 'layout', 'list'  );
        JRequest::setVar( 'view', 'geteco' );
        parent::display();
    }
	/**
		* Get ECO code 
	*/
	function code_default(){
		 $db             =& JFactory::getDBO(); 
		// $arrExist    = array();
		 
		 $db->setQuery(" SELECT eco_name FROM apdm_eco order by eco_id desc limit 0,1 ");		 
		 $rows = $db->loadObjectList();		 
		 if ( count ($rows) > 0){
		 	$eco_latest = $rows[0]->eco_name;
		 }else{
		 	$eco_latest = 0;
		 }
		$next_eco =  (int) $eco_latest;
		$next_eco++;
 		$number_lenght = strlen ($next_eco);
		switch ($number_lenght){
			case "1":
				$new_eco_name = '0000'.$next_eco;				
			break;
			case "2":
				$new_eco_name = '000'.$next_eco;				
			break;
			case "3":
				$new_eco_name = '00'.$next_eco;				
			break;
			case "4":
				$new_eco_name = '0'.$next_eco;				
			break;
			default: //5 charator
				$new_eco_name = $next_eco;				
			break;
			
			
		}
		/* if ( count ( $rows ) > 0 ){
		 	foreach ( $rows as $row ){
				$arrExist[] = $row->eco_name;
			}
		 }
		

		$number = ECOController::random_number();
		if ( count ($arrExist) > 0  && in_array($number, $arrExist)) {
			$number = ECOController::random_number();
		}
		*/
		echo trim($new_eco_name);
		exit;

		
	}
	/**
	* Random function
	* Return number random
	*/
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

/**
	* Display id & name eco for ajax request.
*/
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
        /**
        Read filesize of file
        */
        function Readfilesize($filename){
                $path = JPATH_SITE.DS.'uploads'.DS.'eco'.DS;   
                $filesize =  ceil ( filesize($path.$filename) / 1000 ) ;
                return $filesize;
        }
        /**
                * Display all files eco
        */	
        function files(){
                JRequest::setVar( 'layout', 'files'  );
                JRequest::setVar( 'view', 'update' );
                parent::display();
        }
        
        /**
                * Display initial eco
        */	
        function initial(){
//                JRequest::setVar( 'layout', 'affected'  );
//                JRequest::setVar( 'view', 'listpns' );
                JRequest::setVar( 'layout', 'initial'  );
                JRequest::setVar( 'view', 'listpns' );                
                parent::display();
        }        
        /**
                * Display all files eco
        */	
        function routes(){
                JRequest::setVar( 'layout', 'default'  );
                JRequest::setVar( 'view', 'routes' );
                parent::display();
        }        
    
        /**
                * Display all files eco
        */	
        function affected(){
//                JRequest::setVar( 'layout', 'affected'  );
//                JRequest::setVar( 'view', 'listpns' );
                JRequest::setVar( 'layout', 'default'  );
                JRequest::setVar( 'view', 'listpns' );                
                parent::display();
        } 
         function approvers(){
                JRequest::setVar( 'layout', 'approvers'  );
                JRequest::setVar( 'view', 'update' );                
                parent::display();
        } 
        function add_approvers(){
                JRequest::setVar( 'layout', 'add_approvers'  );
                JRequest::setVar( 'view', 'update' );                
                parent::display();
        }         
         function addapprove()
         {
                global $mainframe;
                // Check for request forgeries
                JRequest::checkToken() or jexit('Invalid Token');

                $option = JRequest::getCmd('option');
                // Initialize some variables
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $cid = JRequest::getVar('cid', array(0));
                $routes = JRequest::getVar('route');
                $approve_status = JRequest::getVar('approve_status',array());                  
                $approve_note = JRequest::getVar('approve_note',array());
                $title = JRequest::getVar('title',array());
                $mail_user = JRequest::getVar('mail_user',array());
                //$approve_status[$key]
                
                foreach($mail_user as $key => $user)
                {
                        if($user)
                        {
                                //check email exist
                                $db->setQuery('select count(*) from apdm_eco_status where eco_id = ' . $cid[0] . ' and routes_id = '.$routes.' and email = '.$user);
                                $check_exist = $db->loadResult();
                                if ($check_exist==0) {
                                        echo $query = 'insert into apdm_eco_status (eco_id,email,eco_status,routes_id,title) values ('.$cid[0].',"'.$user.'","Inreview",'.$routes.',"'.$title[$key].'") on duplicate key update user_id=user_id';
                                        $db->setQuery($query);
                                        $db->query();
                                }
                              
                                
                        }
                }
                 $msg = JText::sprintf('Successfully Add Approve', $cid[0]);
                $this->setRedirect('index.php?option=com_apdmeco&task=add_approvers&time='.time().'&cid[]=' . $cid[0].'&routes='.$routes, $msg);
                
                
         }
        function saveapprove()
        {
                //echo 3;die;
                global $mainframe;
                // Check for request forgeries
                JRequest::checkToken() or jexit('Invalid Token');

                $option = JRequest::getCmd('option');

                // Initialize some variables
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $cid = JRequest::getVar('cid', array(0));
                $routes = JRequest::getVar('route');
                $approve_status = JRequest::getVar('approve_status',array());                  
                $approve_note = JRequest::getVar('approve_note',array());
                $title = JRequest::getVar('title',array());                
                $mail_user = JRequest::getVar('mail_user',array());
                
                $db->setQuery('select count(*) from apdm_eco_status where eco_id = ' . $cid[0] . ' and routes_id = "' . $routes . '"');                
                $check_approver = $db->loadResult();
                if ($check_approver==0) {
                         $msg = JText::sprintf('Must choose at least 2 person for Review', $cid[0]);
                         return $this->setRedirect('index.php?option=com_apdmeco&task=add_approvers&cid[]=' . $cid[0].'&routes='.$routes, $msg);
                }    
                foreach($mail_user as $key => $user)
                {
                        if($user === $me->get('email'))
                        {                        
                                if($approve_note[0]=="")
                                {
                                        $msg = JText::sprintf('Please input comment before save', $cid[0]);
                                         return $this->setRedirect('index.php?option=com_apdmeco&task=add_approvers&cid[]=' . $cid[0].'&routes='.$routes, $msg);
                                }
                                 $query = 'update apdm_eco_status set eco_status= "' . $approve_status[0] . '", note = "'.$approve_note[0].'" where eco_id = ' . $cid[0] . ' and email= "' . $me->get('email') . '" and routes_id = "'.$routes.'"';
                                $db->setQuery($query);
                                $db->query();                            
                        }
                }                
                $msg = JText::sprintf('Successfully Approve/Reject', $cid[0]);
                $this->setRedirect('index.php?option=com_apdmeco&task=add_approvers&cid[]=' . $cid[0].'&routes='.$routes, $msg);
        }
       function add_routes() {
                JRequest::setVar('layout', 'addroutes');
                JRequest::setVar('view', 'routes');
                parent::display();
        }
       function set_route_eco() {
               
                global $mainframe;
                // Initialize some variables
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $cid = JRequest::getVar('cid', array(0));       
                $id = JRequest::getVar('id');
                $db->setQuery('select count(*) from apdm_eco where eco_id = ' . $cid[0] . ' and eco_create_by = "' . $me->get('id') . '"');
                $check_owner = $db->loadResult();
                if ($check_owner==0) {
                         $msg = JText::sprintf('You are not permission set routes', $cid[0]);
                         return $this->setRedirect('index.php?option=com_apdmeco&task=routes&&t='.time().'&cid[]=' . $cid[0], $msg);
                }   
                $db->setQuery('select count(*) from apdm_eco_status where eco_id = ' . $cid[0] . ' and routes_id = "' . $id . '"');                
                $check_approve = $db->loadResult();
                if ($check_approve<=1) {
                         $msg = JText::sprintf('Must choose at least 2 person to route before set', $cid[0]);
                         return $this->setRedirect('index.php?option=com_apdmeco&task=routes&&t='.time().'&cid[]=' . $cid[0], $msg);
                }     
                $row =& JTable::getInstance('apdmeco');
                $row->load($cid[0]);      
                if ($row->eco_status == 'Released') {
                         $msg = JText::sprintf('Eco released can not set another route', $cid[0]);
                         return $this->setRedirect('index.php?option=com_apdmeco&task=routes&&t='.time().'&cid[]=' . $cid[0], $msg);
                }                   
                
                $query = 'update apdm_eco set eco_routes_id= "' . $id . '" where eco_id = ' . $cid[0] . ' and eco_create_by = "' . $me->get('id') . '"';                
                $db->setQuery($query);
                $db->query();                
                //set route to Inreview
                $query = 'update apdm_eco_routes set status = "Inreview" where id = ' . $id . '';                
                $db->setQuery($query);
                $db->query();
                //reset all review of approvers
                $query = 'update apdm_eco_status set eco_status = "Create", eco_id = ' . $cid[0] . ' where routes_id = ' . $id . '';                
                $db->setQuery($query);
                $db->query();    
                //SEND EMAIL
//                //send email 
//                $row =& JTable::getInstance('apdmeco');
//                $row->load($cid[0]);
//                //$subject = "ECO#".$row->eco_name." ".$IsCreater." by ".$me->get('username')." on ".date('m-d-Y');
//                $subject = "[ADP] ECO " . $row->eco_status . " notice - " . $row->eco_name;
//                $message1 = "Please be noticed that this ECO has been " . $row->eco_status;
//
//                $message2 = "<br>+ ECO #: " . $row->eco_name .
//                        "<br>+ Description: " . $row->eco_description .
//                        "<br>+ Status: " . $row->eco_status .
//                        "<br>+ Created by: " . GetValueUser($row->eco_create_by, 'username') .
//                        "<br>+ Date of create: " . JHTML::_('date', $row->eco_create, '%Y-%m-%d %H:%M:%S');
//
//                $message = $message1 . $message2;
//
//
//                if (!$isNew) {
//                        $message .= "<br>+ Modified by: " . GetValueUser($row->eco_modified_by, 'username') .
//                                "<br>+ Date of modify: " . JHTML::_('date', $row->eco_modified, '%Y-%m-%d %H:%M:%S');
//                }
//                $message .= "<br>Please go to <a href='http://10.10.1.245/ADP/administrator/index.php?option=com_apdmeco&task=detail&cid[]=" . $row->eco_id . "'>ADP</a> to ".$row->eco_status." for this ECO";       
//
//                $adminEmail = $me->get('email');
//                $adminName = $me->get('name');
//                if ($MailFrom != '' && $FromName != '') {
//                        $adminName = $FromName;
//                        $adminEmail = $MailFrom;
//                }
//                $db->setQuery('select email from apdm_eco_status where eco_id = ' . $cid[0] . 'and routes_id = ' . $id);
//                $result = $db->loadObjectList();
//                     if (count($result) > 0){
//                         foreach ($result as $obj){
//                           JUtility::sendMail( $adminEmail, $adminName, $obj->email, $subject, $message, 1 );                                                         
//                         }
//                     }  
                     //end sent email
                $msg = JText::sprintf('Successfully set route', $cid[0]);
                $this->setRedirect('index.php?option=com_apdmeco&task=routes&cid[]=' . $cid[0], $msg);
        }        
       function edit_routes() {
                JRequest::setVar('layout', 'form');
                JRequest::setVar('view', 'routes');
                JRequest::setVar( 'edit', true );
                parent::display();
        }
        function save_routes() {
           echo 4;die;
            
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();           
                $datenow    =& JFactory::getDate(); 
                $name = JRequest::getVar('name');
                $description = JRequest::getVar('description');
                $status = 'Create';
                $due_date = JRequest::getVar('due_date');
                $eco_id = JRequest::getVar('eco_id');
                $created = $datenow->toMySQL();
                $owner = $me->get('id');
                $return = JRequest::getVar('return');                        
                $db->setQuery("INSERT INTO apdm_eco_routes (eco_id,name,description,status,due_date,created,owner) VALUES ('" . $eco_id . "', '" . $name . "', '" . $description . "', '" . $status . "', '" . $due_date . "', '" . $created . "', '" . $owner . "')");
                $db->query();
                $msg = "Successfully Saved Route";
               return $this->setRedirect( 'index.php?option=com_apdmeco&task=routes&time='.time().'&cid[]='.$eco_id, $msg );
                
        }  
  function update_routes() {
           
          
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();      
                $datenow    =& JFactory::getDate();
              //  echo $id = JRequest::getVar('id');die;
                
                $name = JRequest::getVar('name');
                $description = JRequest::getVar('description');
                $status = 'Create';
                $due_date = JRequest::getVar('due_date');
                $eco_id = JRequest::getVar('eco_id');
                $created = $datenow->toMySQL();
                $owner = $me->get('id');
                $return = JRequest::getVar('return');                        
                $db->setQuery("update apdm_eco_routes set eco_id,name,description,status,due_date,created,owner VALUES ('" . $eco_id . "', '" . $name . "', '" . $description . "', '" . $status . "', '" . $due_date . "', '" . $created . "', '" . $owner . "')");
                $db->query();
                $msg = "Successfully Saved Route";
                $this->setRedirect( 'index.php?option=com_apdmeco&task=routes&cid[0]='.$pns_id, $msg );
                
        }          
        function remove_routes()
        {

                $db       =& JFactory::getDBO();
                $cid      = JRequest::getVar( 'eco');  
                $route_id      = JRequest::getVar( 'route_id', array(), '', 'array' );                
                $db->setQuery("update apdm_eco_routes set deleted =1 WHERE  id IN (".implode(",", $route_id).")");
                $db->query();      
                $msg = JText::_('Have deleted successfull.');
                $this->setRedirect( 'index.php?option=com_apdmeco&task=routes&cid[]='.$cid, $msg);
                      //  apdm_eco_routes
        }
        
                /**
                * Display all files eco
        */	
        function demote(){
               
                $db = & JFactory::getDBO();
		$cid = JRequest::getVar( 'cid', array(0) );                
                $me			= & JFactory::getUser();  
                $route = JRequest::getVar('routes');
                //update route status Inreview
                $query = 'update apdm_eco_routes set status= "Create" where eco_id = ' . $cid[0] .' and id ='.$route;
                $db->setQuery($query);
                $db->query();                
                $query = 'update apdm_eco_status set eco_status= "Create" where eco_id = '.$cid[0].' and routes_id ='.$route;
                $db->setQuery($query);
                $db->query();	 
                $query = 'update apdm_eco set eco_status= "Create" where eco_id = ' . $cid[0];
                $db->setQuery($query);
                $db->query();
                $msg = JText::sprintf( 'Successfully Demote',$cid[0]  );
                $this->setRedirect( 'index.php?option=com_apdmeco&task=detail&cid[]='. $cid[0], $msg );

        }
    
        /**
                * Display all files eco
        */	
        function promote() {
                
                $db = & JFactory::getDBO();
                $cid = JRequest::getVar('cid', array(0));
                $me = & JFactory::getUser();
                $route = JRequest::getVar('routes');
                $db->setQuery('select count(*) from apdm_eco_status where eco_id = ' . $cid[0] . ' and routes_id in (select eco_routes_id from apdm_eco where eco_id= "' . $cid[0] . '")');
                $trow = $db->loadResult();
                if ($trow<2) {
                        $msg = JText::sprintf('Must choose at least 2 persons for Review', $cid[0]);                               
                        return $this->setRedirect('index.php?option=com_apdmeco&task=add_approvers&cid[]=' . $cid[0].'&routes='.$route, $msg);
                }
                else{                       
                        $row =& JTable::getInstance('apdmeco');
                        $row->load($cid[0]);  
                        if($row->eco_status =='Create')
                        {                                                        
                                //promote up to inreview
                                $query = 'update apdm_eco set eco_status= "Inreview" where eco_id = ' . $cid[0];
                                $db->setQuery($query);
                                $db->query();
                                //set all pn 
                                $query = 'update apdm_pns set pns_life_cycle= "Inreview" where eco_id = ' . $cid[0] . '';
                                $db->setQuery($query);
                                $db->query();                    
                                //send email Inreview          
                                $row =& JTable::getInstance('apdmeco');
                                $row->load($cid[0]);
                                //$subject = "ECO#".$row->eco_name." ".$IsCreater." by ".$me->get('username')." on ".date('m-d-Y');
                                $subject = "[ADP] ECO " . $row->eco_status . " notice - " . $row->eco_name;
                                $message1 = "Please be noticed that this ECO has been " . $row->eco_status;

                                $message2 = "<br>+ ECO #: " . $row->eco_name .
                                        "<br>+ Description: " . $row->eco_description .
                                        "<br>+ Status: " . $row->eco_status .
                                        "<br>+ Created by: " . GetValueUser($row->eco_create_by, 'username') .
                                        "<br>+ Date of create: " . JHTML::_('date', $row->eco_create, '%Y-%m-%d %H:%M:%S');
                                $message = $message1 . $message2;
                                if (!$isNew) {
                                        $message .= "<br>+ Modified by: " . GetValueUser($row->eco_modified_by, 'username') .
                                                "<br>+ Date of modify: " . JHTML::_('date', $row->eco_modified, '%Y-%m-%d %H:%M:%S');
                                }
                                $message .= "<br>Please go to <a href='http://10.10.1.245/ADP/administrator/index.php?option=com_apdmeco&task=detail&cid[]=" . $row->eco_id . "'>ADP</a> to ".$row->eco_status." for this ECO";       
                                $adminEmail = $me->get('email');
                                $adminName = $me->get('name');
                                if ($MailFrom != '' && $FromName != '') {
                                        $adminName = $FromName;
                                        $adminEmail = $MailFrom;
                                }
                                $db->setQuery('select email from apdm_eco_status where eco_id = ' . $cid[0] . '  and routes_id in (select eco_routes_id from apdm_eco where eco_id= "' . $cid[0] . '")');
                                $result = $db->loadObjectList();
                                     if (count($result) > 0){
                                         foreach ($result as $obj){
                                    //       JUtility::sendMail( $adminEmail, $adminName, $obj->email, $subject, $message, 1 );                                                         
                                         }
                                     }                        
                }
                elseif ($row->eco_status == 'Inreview') {
                        $db->setQuery('select count(*) from apdm_eco_status where eco_id = ' . $cid[0] . ' and routes_id = "' . $route . '"');                
                        $totalApprovers = $db->loadResult();
                        //check all release
                        $db->setQuery('select count(*) from apdm_eco_status where eco_status = "Released" and eco_id = ' . $cid[0] . ' and routes_id = "' . $route . '"');
                        $totalReleased = $db->loadResult();
                        if ($totalApprovers == $totalReleased) {
                                //$row->eco_status = 'Released';//JRequest::getVar('eco_status_tmp');  
                                //update route status Released
                                $query = 'update apdm_eco_routes set status= "Released" where eco_id = ' . $cid[0] .' and id ='.$route;
                                $db->setQuery($query);
                                $db->query();
                                //update eco to Released
                                $query = 'update apdm_eco set eco_status= "Released" where eco_id = ' . $cid[0];
                                $db->setQuery($query);
                                $db->query();
                                //set all pn 
                                $query = 'update apdm_pns set pns_life_cycle= "Released" where eco_id = ' . $cid[0] . '';
                                $db->setQuery($query);
                                $db->query();
                        

                        //send email PRROMOTE RELEASED
                        $row =& JTable::getInstance('apdmeco');
                        $row->load($cid[0]);
                        //$subject = "ECO#".$row->eco_name." ".$IsCreater." by ".$me->get('username')." on ".date('m-d-Y');
                        $subject = "[ADP] ECO " . $row->eco_status . " notice - " . $row->eco_name;
                        $message1 = "Please be noticed that this ECO has been " . $row->eco_status;

                        $message2 = "<br>+ ECO #: " . $row->eco_name .
                                "<br>+ Description: " . $row->eco_description .
                                "<br>+ Status: " . $row->eco_status .
                                "<br>+ Created by: " . GetValueUser($row->eco_create_by, 'username') .
                                "<br>+ Date of create: " . JHTML::_('date', $row->eco_create, '%Y-%m-%d %H:%M:%S');

                        $message = $message1 . $message2;
                        if (!$isNew) {
                                $message .= "<br>+ Modified by: " . GetValueUser($row->eco_modified_by, 'username') .
                                        "<br>+ Date of modify: " . JHTML::_('date', $row->eco_modified, '%Y-%m-%d %H:%M:%S');
                        }
                        $message .= "<br>Please go to <a href='http://10.10.1.245/ADP/administrator/index.php?option=com_apdmeco&task=detail&cid[]=" . $row->eco_id . "'>ADP</a> to ".$row->eco_status." for this ECO";       

                        $adminEmail = $me->get('email');
                        $adminName = $me->get('name');
                        if ($MailFrom != '' && $FromName != '') {
                                $adminName = $FromName;
                                $adminEmail = $MailFrom;
                        }
                        $db->setQuery('select email from apdm_eco_status where eco_id = ' . $cid[0] . ' and routes_id in (select eco_routes_id from apdm_eco where eco_id= "' . $cid[0] . '")');
                        $result = $db->loadObjectList();
                             if (count($result) > 0){
                                 foreach ($result as $obj){
                               //    JUtility::sendMail( $adminEmail, $adminName, $obj->email, $subject, $message, 1 );                                                         
                                 }
                             }
                        $msg = JText::sprintf('Successfully Promote', $cid[0]);
                        $this->setRedirect('index.php?option=com_apdmeco&task=detail&cid[]=' . $cid[0], $msg);
                        }
                        else{
                              $msg = JText::sprintf('All approvers must approve first', $cid[0]);
                              return $this->setRedirect('index.php?option=com_apdmeco&task=add_approvers&cid[]=' . $cid[0].'&routes='.$route, $msg);  
                        }
                        
                }
                }
                
        }

        /*
          * type_id 4
          */        
         function  GetPnManufacture($pns_id){
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
         /*
          * type_id 2
          */
         function GetPnVendor($pns_id)
         {
             $db = & JFactory::getDBO();
             $rows  = array();
             $query = "SELECT p.supplier_id, p.supplier_info, s.info_name FROM apdm_pns_supplier AS p LEFT JOIN apdm_supplier_info AS s ON s.info_id = p.supplier_id WHERE  s.info_deleted=0 AND  s.info_activate=1 AND p.type_id = 2 AND  p.pns_id =".$pns_id;
             $db->setQuery($query);
             $result = $db->loadObjectList();
             if (count($result) > 0){
                 foreach ($result as $obj){
                     $rows[] = array('vendor_name'=>$obj->info_name, 'vendor_info'=>$obj->supplier_info);
                 }
             }
             return $rows;
         }
         /*
          * type_id 3
          */
          function GetPnSupplier($pns_id)
         {
             $db = & JFactory::getDBO();
             $rows  = array();
             $query = "SELECT p.supplier_id, p.supplier_info, s.info_name FROM apdm_pns_supplier AS p LEFT JOIN apdm_supplier_info AS s ON s.info_id = p.supplier_id WHERE  s.info_deleted=0 AND  s.info_activate=1 AND p.type_id = 3 AND  p.pns_id =".$pns_id;
             $db->setQuery($query);
             $result = $db->loadObjectList();
             if (count($result) > 0){
                 foreach ($result as $obj){
                     $rows[] = array('supplier_name'=>$obj->info_name, 'supplier_info'=>$obj->supplier_info);
                 }
             }
             return $rows;
         }
         function approve(){
                $db = & JFactory::getDBO();
		$cid = JRequest::getVar( 'cid', array(0) );                
                $me			= & JFactory::getUser();  
                $select  = $db->setQuery('select eco_status from apdm_eco_status where eco_id = '.$cid[0].' and email= "'.$me->get('email').'"');
                $row = $db->loadObject();        
                 $row->eco_status;
                if (!$row->eco_status) {
                        $query = "INSERT INTO apdm_eco_status (eco_id,email,eco_status) VALUES (" . $cid[0] . ", '" . $me->get('email') . "','Create') ON DUPLICATE KEY UPDATE eco_status = '" . $row->eco_status . "'";
                        $db->setQuery($query);
                        $db->query();
                } elseif ($row->eco_status == 'Create') {
                        $query = 'update apdm_eco_status set eco_status= "Released" where eco_id = ' . $cid[0] . ' and email= "' . $me->get('email') . '"';
                        $db->setQuery($query);
                        $db->query();
                }
                $msg = JText::sprintf('Successfully Approve', $cid[0]);
                $this->setRedirect('index.php?option=com_apdmeco&task=detail&cid[]=' . $cid[0], $msg);
         }
    function saveinitial()
    {          
        $db = & JFactory::getDBO();
        $me = & JFactory::getUser();        
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $eco = JRequest::getVar('eco');
        $pns_id = JRequest::getVar('pns_id');
        $datenow = & JFactory::getDate(); 
        foreach ($cid as $id) {           
                $init_plant_status = JRequest::getVar('init_plant_status_' . $id);
                $init_make_buy = JRequest::getVar('init_make_buy_' . $id); 
                $init_leadtime = JRequest::getVar('init_leadtime_' . $id); 
                $init_buyer = JRequest::getVar('init_buyer_' . $id); 
                $init_supplier = JRequest::getVar('init_supplier_' . $id);              
                $init_modified = $datenow->toMySQL();
                $init_modified_by = $me->get('id');    
                $init_cost = JRequest::getVar('init_cost_' . $id);                 
                $db->setQuery('select count(*) from apdm_pns_initial where pns_id = ' . $id);
                $check_exist = $db->loadResult();
                if ($check_exist==0) {
                        $query = 'insert into apdm_pns_initial (pns_id,init_plant_status,init_make_buy,init_leadtime,init_buyer,init_supplier,init_cost,init_modified,init_modified_by) values ('.$id.',"'.$init_plant_status.'","'.$init_make_buy.'","'.$init_leadtime.'","'.$init_buyer.'","'.$init_supplier.'","'.$init_cost.'","'.$init_modified.'","'.$init_modified_by.'")';
                        $db->setQuery($query);
                        $db->query();
                }      
                else
                {                
                        $db->setQuery("update apdm_pns_initial set init_plant_status='".$init_plant_status."', init_make_buy = '" . $init_make_buy . "',init_leadtime= '" . $init_leadtime . "',init_buyer= '" . $init_buyer . "',init_supplier= '" . $init_supplier . "',init_cost= '" . $init_cost . "',init_modified= '" . $init_modified . "',init_modified_by= '" . $init_modified_by . "'  WHERE  pns_id = " . $id);
                        //echo $db->getQuery();
                        $db->query();
                }
        }
        $msg = "Successfully Saved Initital";
        $this->setRedirect('index.php?option=com_apdmeco&task=initial&cid[]=' . $eco, $msg);        
    }                   
        
}
