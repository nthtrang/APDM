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
			        if ($handle->uploaded) {			
			          $handle->Process($path_eco);			 
			          if ($handle->processed) {
						$arr_file[]   = $handle->file_dst_name;
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

//                           if(JRequest::getVar('eco_status_tmp')=='Released')
//                           {
                               //viet add historyapprove       
                                $query = 'update apdm_eco_status set eco_status= "'.JRequest::getVar('eco_status_tmp').'" where eco_id = '.$row->eco_id.' and email= "'.$me->get('email').'"';
                                $db->setQuery($query);
                                $db->query();	 
                        //   }
                           $db->setQuery('select count(*) from apdm_eco_status where eco_id = '.$row->eco_id.'');
                		 $totalApprovers = $db->loadResult();
                           //check all release
                                 $db->setQuery('select count(*) from apdm_eco_status where eco_status = "Create" and eco_id = '.$row->eco_id.'');
                		 $totalPending = $db->loadResult();
                                if ($totalPending>0){
                                      $row->eco_status = 'Create';//JRequest::getVar('eco_status_tmp');  
                                      $row->store();    
                                }
                           //check all release
                                 $db->setQuery('select count(*) from apdm_eco_status where eco_status = "Released" and eco_id = '.$row->eco_id.'');
                		 $totalReleased = $db->loadResult();
                                if ($totalApprovers == $totalReleased){
                                      $row->eco_status = 'Released';//JRequest::getVar('eco_status_tmp');  
                                      $row->store();    
                                }
                                  //check all reject
                                 $db->setQuery('select count(*) from apdm_eco_status where eco_status = "Inreview" and eco_id = '.$row->eco_id.'');
                		 $totalReject = $db->loadResult();
                                if ($totalApprovers == $totalReject){
                                      $row->eco_status = 'Inreview';//JRequest::getVar('eco_status_tmp');  
                                      $row->store();    
                                }
                                
                            if($row->eco_status=='Released')
                            {
                                $query = 'update apdm_pns set pns_status= "Release" where eco_id = '.$row->eco_id.'';
                                $db->setQuery($query);
                                $db->query();
                                             
                            }
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
                            
			    //$subject = "ECO#".$row->eco_name." ".$IsCreater." by ".$me->get('username')." on ".date('m-d-Y');
				$subject = "[ADP] ECO ".$row->eco_status." notice - ".$row->eco_name;
			    $message1 = "Please be noticed that this ECO has been ".$row->eco_status;
				
				if ($row->eco_status!='Released'){
				$subject = "[ADP] ECO Approval request - ".$row->eco_name;
				$message1 = "Please go to <a href='http://10.10.1.245/ADP/administrator/index.php?option=com_apdmeco&task=detail&cid[]=".$row->eco_id."'>ADP</a> to approve/reject for this ECO";
                                
                                foreach ($arr_user as $user){
                                          $query = "INSERT INTO apdm_eco_status (eco_id,email,eco_status) VALUES (".$row->eco_id.", '".$user."','".$row->eco_status."') ON DUPLICATE KEY UPDATE eco_status = '".$row->eco_status."'";
                                         $db->setQuery($query);
                                        $db->query();
                                }
				}
				

				$message2 = "<br>+ ECO #: ".$row->eco_name.
									    "<br>+ Description: ".$row->eco_description. 
							            "<br>+ Status: ".$row->eco_status.


							            "<br>+ Created by: ".GetValueUser($row->eco_create_by, 'username').
							            "<br>+ Date of create: ".$row->eco_create;
				
				$message = $message1 . $message2;
				

				if (!$isNew){
					$message .= "<br>+ Modified by: ".GetValueUser($row->eco_modified_by, 'username').
											 "<br>+ Date of modify: ".$row->eco_modified;
				}			  

					
                $adminEmail = $me->get('email');
                $adminName    = $me->get('name');
                if ($MailFrom != '' && $FromName != '')
                    {
                        $adminName     = $FromName;
                        $adminEmail = $MailFrom;
                    }
   
			    foreach ($arr_user as $user){
             //tam thoi  JUtility::sendMail( $adminEmail, $adminName, $user, $subject, $message, 1 );    
                                
			    }
			    
		    }
		    //viec loghistory
                    $queryLog = "insert into `apdm_eco_affected`(`eco_id`,`eco_name`,`eco_description`,`eco_status`,`eco_project`,`eco_type`,`eco_field_impact`,`eco_reason`,`eco_what`,`eco_special`,`eco_benefit`,`eco_technical`,`eco_tech_design`,`eco_estimated`,`eco_estimated_cogs`,`eco_target`,`eco_modified`,`eco_modified_by`) values ".
                            "('".$row->eco_id."','".$row->eco_name."','".$row->eco_description."','".$row->eco_status."','".$row->eco_project."','".$row->eco_type."','".$row->eco_field_impact."','".$row->eco_reason."','".$row->eco_what."','".$row->eco_special."','".$row->eco_benefit."','".$row->eco_technical."','".$row->eco_tech_design."','".$row->eco_estimated."','".$row->eco_estimated_cogs."','".$row->eco_target."','".$row->eco_modified."',$row->eco_modified_by)";
                            $db->setQuery($queryLog);
                    $db->query();
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
                * Display all files eco
        */	
        function affected(){
                JRequest::setVar( 'layout', 'affected'  );
                JRequest::setVar( 'view', 'update' );
                parent::display();
        }       
                /**
                * Display all files eco
        */	
        function demote(){
                $db = & JFactory::getDBO();
		$cid = JRequest::getVar( 'cid', array(0) );                
                $me			= & JFactory::getUser();  
                $select  = $db->setQuery('select eco_status from apdm_eco_status where eco_id = '.$cid[0].' and email= "'.$me->get('email').'"');
                $row = $db->loadObject();        
                 $row->eco_status;
                if(!$row->eco_status)
                {
                        $query = "INSERT INTO apdm_eco_status (eco_id,email,eco_status) VALUES (".$cid[0].", '".$me->get('email')."','Create') ON DUPLICATE KEY UPDATE eco_status = '".$row->eco_status."'";
                        $db->setQuery($query);
                        $db->query();
                }
                elseif($row->eco_status!='Create')
                {
                        $query = 'update apdm_eco_status set eco_status= "Create" where eco_id = '.$cid[0].' and email= "'.$me->get('email').'"';
                        $db->setQuery($query);
                        $db->query();	 
                }
                $db->setQuery('select count(*) from apdm_eco_status where eco_id = '.$cid[0].'');
                $totalApprovers = $db->loadResult();
                //check all release
                $db->setQuery('select count(*) from apdm_eco_status where eco_status = "Create" and eco_id = '.$cid[0].'');
                $totalPending = $db->loadResult();
                if ($totalPending>0){
                        // $row->eco_status = 'Create';//JRequest::getVar('eco_status_tmp');    
                        $query = 'update apdm_eco set eco_status= "Create" where eco_id = '.$cid[0];
                        $db->setQuery($query);
                        $db->query();
                }
         $msg = JText::sprintf( 'Successfully Demote',$cid[0]  );
				    $this->setRedirect( 'index.php?option=com_apdmeco&task=detail&cid[]='. $cid[0], $msg );

        }
    
        /**
                * Display all files eco
        */	
        function promote(){
                $db = & JFactory::getDBO();
		$cid = JRequest::getVar( 'cid', array(0) );                
                $me			= & JFactory::getUser();  
                $select  = $db->setQuery('select eco_status from apdm_eco_status where eco_id = '.$cid[0].' and email= "'.$me->get('email').'"');
                $row = $db->loadObject();        
                 $row->eco_status;
                if(!$row->eco_status)
                {
                        $query = "INSERT INTO apdm_eco_status (eco_id,email,eco_status) VALUES (".$cid[0].", '".$me->get('email')."','Create') ON DUPLICATE KEY UPDATE eco_status = '".$row->eco_status."'";
                        $db->setQuery($query);
                        $db->query();
                }
                elseif($row->eco_status=='Create')
                {
                        $query = 'update apdm_eco_status set eco_status= "Inreview" where eco_id = '.$cid[0].' and email= "'.$me->get('email').'"';
                        $db->setQuery($query);
                        $db->query();	 
                }
                           $db->setQuery('select count(*) from apdm_eco_status where eco_id = '.$cid[0].'');
                		 $totalApprovers = $db->loadResult();
                           //check all release
                                 $db->setQuery('select count(*) from apdm_eco_status where eco_status = "Create" and eco_id = '.$cid[0].'');
                		 $totalPending = $db->loadResult();
                                if ($totalPending>0){
                                     // $row->eco_status = 'Create';//JRequest::getVar('eco_status_tmp');    
                                        $query = 'update apdm_eco set eco_status= "Inreview" where eco_id = '.$cid[0];
                                        $db->setQuery($query);
                                        $db->query();
                                }
                           //check all release
                                 $db->setQuery('select count(*) from apdm_eco_status where eco_status = "Released" and eco_id = '.$cid[0].'');
                		 $totalReleased = $db->loadResult();
                                if ($totalApprovers == $totalReleased){
                                      //$row->eco_status = 'Released';//JRequest::getVar('eco_status_tmp');  
                                        $query = 'update apdm_eco set eco_status= "Released" where eco_id = '.$cid[0];
                                        $db->setQuery($query);
                                        $db->query(); 
                                }
                                  //check all reject
                                 $db->setQuery('select count(*) from apdm_eco_status where eco_status = "Inreview" and eco_id = '.$cid[0].'');
                		 $totalReject = $db->loadResult();
                                if ($totalApprovers == $totalReject){
                                    //  $row->eco_status = 'Inreview';//JRequest::getVar('eco_status_tmp');  
                                        $query = 'update apdm_eco set eco_status= "Released" where eco_id = '.$cid[0];
                                        $db->setQuery($query);
                                        $db->query();    
                                }
                                $msg = JText::sprintf( 'Successfully Promote',$cid[0]  );
				    $this->setRedirect( 'index.php?option=com_apdmeco&task=detail&cid[]='. $cid[0], $msg );
                                            
        }     
}
