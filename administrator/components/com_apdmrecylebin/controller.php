<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');
require_once('includes/class.upload.php');
/**
 * Users Component Controller
 *
 * @package		Apdm
 * @subpackage	Recyle Bin
 * @since 1.5
 */
class RecyleBinController extends JController
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
		$this->registerTask( 'ccs'  , 	'display'  );
		$this->registerTask( 'info'  , 	'display'  );
        $this->registerTask( 'infodetail', 'display'  );  
		$this->registerTask( 'eco', 	'display'  );
		$this->registerTask( 'pns',     'display');		
        $this->registerTask( 'pnsdetail',     'display');  
		$this->registerTask( 'ecodetail',     'display');        
        
	}

	/**
	 * Displays a view
	 */
	function display( )
	{
		$msg = JText::_('YOU_HAVE_NOT_PERMISION_THIS_FUNCTION');
		switch($this->getTask())
		{
			case 'ccs'     :			{	
				$role1 = JAdministrator::RoleOnComponent(1); //CCS
				if (in_array("R", $role1)) {
					JRequest::setVar( 'layout', 'default'  );
					JRequest::setVar( 'view', 'ccs' );
				}else{

        			$this->setRedirect( 'index.php?option=com_apdmrecylebin', $msg);
				}
				
			} break;
			case 'info'    :
			{
				$role2 = JAdministrator::RoleOnComponent(2); //VD, SP, MF
				if (in_array("R", $role2)) {
					JRequest::setVar( 'layout', 'default'  );
					JRequest::setVar( 'view', 'info' );
				}else{
					$this->setRedirect( 'index.php?option=com_apdmrecylebin', $msg);
				}
				
			} break;
            case 'infodetail'    :
            {
                JRequest::setVar( 'layout', 'detail'  );
                JRequest::setVar( 'view', 'infodetail' );
                
            } break;
            case 'eco'    :
            {
				$role5 = JAdministrator::RoleOnComponent(5); 
				if (in_array("R", $role5)) {
                	JRequest::setVar( 'layout', 'default'  );
                	JRequest::setVar( 'view', 'eco' );
				}else{
					$this->setRedirect( 'index.php?option=com_apdmrecylebin', $msg);
				}
                
            } break;
			case 'ecodetail':
			{
				$role5 = JAdministrator::RoleOnComponent(5); 
				if (in_array("R", $role5)) {
                	JRequest::setVar( 'layout', 'detail'  );
                	JRequest::setVar( 'view', 'eco_detail' );
				}else{
					$this->setRedirect( 'index.php?option=com_apdmrecylebin', $msg);
				}
			}
			break;
             case 'pns'    :
            {
				$role6 = JAdministrator::RoleOnComponent(6); 
				if (in_array("R", $role6)){
					JRequest::setVar( 'layout', 'default'  );
					JRequest::setVar( 'view', 'pns' );
				}else{
					$this->setRedirect( 'index.php?option=com_apdmrecylebin', $msg);
				}

                
            } break;
            case 'pnsdetail':
                JRequest::setVar( 'layout', 'detail'  );
                JRequest::setVar( 'view', 'pns_detail' );
            break;
            
		}

		parent::display();
	}
    function delete_ccs(){
         JRequest::checkToken() or jexit( 'Invalid Token' );

        $db             =& JFactory::getDBO();
    
        $cid             = JRequest::getVar( 'cid', array(), '', 'array' );

        JArrayHelper::toInteger( $cid );

        if (count( $cid ) < 1) {
            JError::raiseError(500, JText::_( 'Select a Commodity Code to delete', true ) );
        }
		//get commodity code before delete
			$db->setQuery("SELECT * FROM apdm_ccs WHERE ccs_id IN ( ".implode(",", $cid)." )");
			$row = $db->loadObjectlist();
			$arrCode = array();
			foreach ($rows as $row){
				$arrCode[] = $row->ccs_code;
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
			//delete table history
			$db->setQuery("DELETE FROM apdm_user_history WHERE history_where=1 AND history_todo_id=".$id);
			$db->query();
            
        }
		//delete all folder of ccs
		foreach ($arrCode as $obj){
			$path_pns = JPATH_SITE.DS.'uploads'.DS.'pns'.DS.'cads'.DS.$obj.DS;
			@rmdir($path_pns);
		}
        $msg = JText::_('DELETE_COMMODITY_CODE_SUCCESSFUL');
        $this->setRedirect( 'index.php?option=com_apdmrecylebin&task=ccs', $msg);
    }
    function restore_ccs()
    {
        // Check for request forgeries
        JRequest::checkToken() or jexit( 'Invalid Token' );

        $db             =& JFactory::getDBO();
        $me                 =& JFactory::getUser();    
        $cid             = JRequest::getVar( 'cid', array(), '', 'array' );
        $datenow =& JFactory::getDate();
        $ccs_modified         = $datenow->toMySQL();
        $ccs_modified_by     = $me->get('id');

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
            JAdministrator::HistoryUser(1, 'R', $id);
            
        }
        $msg = JText::_('RESTORE_COMMODITY_CODE_SUCCESSFUL');
        $this->setRedirect( 'index.php?option=com_apdmrecylebin&task=ccs', $msg);
    }
    function delete_info(){
         JRequest::checkToken() or jexit( 'Invalid Token' );

        $db             =& JFactory::getDBO();
    
        $cid             = JRequest::getVar( 'cid', array(), '', 'array' );

        JArrayHelper::toInteger( $cid );

        if (count( $cid ) < 1) {
            JError::raiseError(500, JText::_( 'Select a Commodity Code to delete', true ) );
        }

        foreach ($cid as $id)
        {
            //for CCS
            $query = "DELETE FROM apdm_supplier_info WHERE info_id=".$id;
            $db->setQuery($query);
            $db->query();           
			//delete table history
			$db->setQuery("DELETE FROM apdm_user_history WHERE history_where IN (2, 3, 4) AND history_todo_id=".$id);
			$db->query();  
            
        }
        $msg = JText::_('DELETE_INFO_SUPPLIER_SUCCESSFUL');
        $this->setRedirect( 'index.php?option=com_apdmrecylebin&task=info', $msg);
    }
    function restore_info()
    {
        // Check for request forgeries
        JRequest::checkToken() or jexit( 'Invalid Token' );

        $db             =& JFactory::getDBO();
        $me                 =& JFactory::getUser();    
        $cid             = JRequest::getVar( 'cid', array(), '', 'array' );
        $datenow =& JFactory::getDate();
        $info_modified         = $datenow->toMySQL();
        $info_modified_by    = $me->get('id');

        JArrayHelper::toInteger( $cid );

        if (count( $cid ) < 1) {
            JError::raiseError(500, JText::_( 'Select a Commodity Code to restore', true ) );
        }

        foreach ($cid as $id)
        {
            //for CCS
            $query = "UPDATE apdm_supplier_info SET info_deleted=0, info_modified='".$info_modified."', info_modified_by=".$info_modified_by." WHERE info_id=".$id;
         
            $db->setQuery($query);
            $db->query();      
            $db->setQuery("SELECT info_type FROM apdm_supplier_info WHERE info_id=".$id);     
            $re = $db->loadResult();
            JAdministrator::HistoryUser($re, 'R', $id);
        }
                        
        $msg = JText::_('RESTORE_INFO_SUPPLIER_SUCCESSFUL');
        $this->setRedirect( 'index.php?option=com_apdmrecylebin&task=info', $msg);
    }  
    
     function delete_eco(){
         JRequest::checkToken() or jexit( 'Invalid Token' );

        $db             =& JFactory::getDBO();
    
        $cid             = JRequest::getVar( 'cid', array(), '', 'array' );

        JArrayHelper::toInteger( $cid );

        if (count( $cid ) < 1) {
            JError::raiseError(500, JText::_( 'Select a ECO to delete', true ) );
        }
         $path_eco = JPATH_SITE.DS.'uploads'.DS.'eco'.DS; 
        foreach ($cid as $id)
        {
            //for CCS
            //get name file PDF
            $db->setQuery("SELECT eco_pdf FROM apdm_eco WHERE eco_id=".$id);
            $eco_file = $db->loadResult();
            $query = "DELETE FROM apdm_eco WHERE eco_id=".$id;
            $db->setQuery($query);            
            $db->query();     
            $remove_pdf = new Upload();
            $remove_pdf->file_src_pathname = $path_eco.$eco_file;
            $remove_pdf->clean();
			//set ECO for pns_code
			$db->setQuery ("UPDATE apdm_pns SET eco_id=0 WHERE eco_id=".$id);
			$db->query();
			//history
            $db->setQuery("DELETE FROM apdm_user_history WHERE history_where=5 AND history_todo_id=".$id);
			$db->query();
            
            //remove file PDF        
            
        }
        $msg = JText::_('DELETE_ECO_SUCCESSFUL');
        $this->setRedirect( 'index.php?option=com_apdmrecylebin&task=eco', $msg);
    }
    function restore_eco()
    {
        // Check for request forgeries
        JRequest::checkToken() or jexit( 'Invalid Token' );

        $db              =& JFactory::getDBO();
        $me              =& JFactory::getUser();    
        $cid             = JRequest::getVar( 'cid', array(), '', 'array' );
        $datenow         =& JFactory::getDate();
        $eco_modified    = $datenow->toMySQL();
        $eco_modified_by = $me->get('id');

        JArrayHelper::toInteger( $cid );

        if (count( $cid ) < 1) {
            JError::raiseError(500, JText::_( 'Select a ECO to restore', true ) );
        }

        foreach ($cid as $id)
        {
            //for CCS
            $query = "UPDATE apdm_eco SET eco_deleted=0, eco_modified='".$eco_modified."', eco_modified_by=".$eco_modified_by." WHERE eco_id=".$id;         
            $db->setQuery($query);
            $db->query();                 
            JAdministrator::HistoryUser(5, 'R', $id);
        }
                        
        $msg = JText::_('RESTORE_ECO_SUCCESSFUL');
        $this->setRedirect( 'index.php?option=com_apdmrecylebin&task=eco', $msg);
    }       
	  
	/**
	 * Cancels an edit operation
	 */
	function cancel_info( )
	{
		$this->setRedirect( 'index.php?option=com_apdmrecylebin&task=info' );
	}
    /**
    * @desc Delete PNs
    */
    function delete_pns(){
        
        $db             =& JFactory::getDBO();    
        $cid             = JRequest::getVar( 'cid', array(), '', 'array' );

        JArrayHelper::toInteger( $cid );

        if (count( $cid ) < 1) {
            JError::raiseError(500, JText::_( 'Select a PNs to delete', true ) );
        }
       foreach ($cid as $id) {
           //get information
           $db->setQuery("SELECT p.pns_pdf, p.pns_image, CONCAT_WS( '-', c.ccs_code, p.pns_code, p.pns_revision ) AS pns_full_code FROM apdm_pns AS p LEFT JOIN apdm_ccs AS c ON c.ccs_id=p.ccs_id WHERE p.pns_id=".$id);
           $row = $db->loadObject();
           $pns_pdf = $row->pns_pdf;
           $pns_image = $row->pns_image;
           $pns_code = $row->pns_full_code;
           if (substr($pns_code, -1)=="-"){
               $pns_code = substr($pns_code, 0, strlen($pns_code)-1);  
            }
           $db->setQuery('DELETE FROM apdm_pns WHERE  pns_id='.$id);
           $db->query();
           //delete all pns_parent
           $db->setQuery("DELETE FROM apdm_pns_parents WHERE pns_id=".$id." OR pns_parent=".$id);
           $db->query();           
           //delete all pns_cad file
           $arr_pns_cad = array();
           $db->setQuery("SELECT cad_file FROM apdm_pn_cad WHERE pns_id =".$id);
           $row_cads = $db->loadObjectList();
           if (count($row_cads) > 0){
               foreach ($row_cads as $cad){
                   $arr_pns_cad[] = $cad->cad_file;
               }
           }
           $db->setQuery("DELETE FROM apdm_pn_cad WHERE pns_id=".$id);
           $db->query();
           //delete file pdf and file image
           $path_pns = JPATH_SITE.DS.'uploads'.DS.'pns'.DS;     
           if ($pns_image !=""){
               $path_img = $path_pns.'images'.DS.$pns_image;
               $remove_image = new Upload($path_img);
               $remove_image->file_dst_pathname = $path_img;
               $remove_image->clean();
           }
            if ($pns_pdf !=""){
               $path_pdf = $path_pns.'pdf'.DS.$pns_pdf;
               $remove_pdf = new Upload($path_pdf);
               $remove_pdf->file_dst_pathname = $path_pdf;
               $remove_pdf->clean();
           }
           //delete file cad
          $path_cad = $path_pns.'cads'.DS.$pns_code.DS;
          if (count($arr_pns_cad) > 0) {
              foreach ($arr_pns_cad as $file_cad){
                  $remove_cad = new Upload($path_cad.$file_cad);
                  $remove_cad->file_dst_pathname = $path_cad.$file_cad;
                  $remove_cad->clean();
              }
          }
          //remove folder 
          rmdir($path_cad);
          //delete all information of table history
          $db->setQuery("DELETE FROM apdm_user_history WHERE history_where=6 AND history_todo_id=".$id);
          $db->query();
           
       }
        $msg = JText::_('DELETE_PNS_SUCCESSFUL');
        $this->setRedirect( 'index.php?option=com_apdmrecylebin&task=pns', $msg);
    
    }
    function restore_pns(){
        $db              =& JFactory::getDBO();
        $me              =& JFactory::getUser();    
        $cid             = JRequest::getVar( 'cid', array(), '', 'array' );
        $datenow         =& JFactory::getDate();
        $pns_modified    = $datenow->toMySQL();
        $pns_modified_by = $me->get('id');

        JArrayHelper::toInteger( $cid );

        if (count( $cid ) < 1) {
            JError::raiseError(500, JText::_( 'Select a PNs to restore', true ) );
        }

        foreach ($cid as $id)
        {
            //for CCS
            $query = "UPDATE apdm_pns SET pns_deleted=0, pns_modified='".$pns_modified."', pns_modified_by=".$pns_modified_by." WHERE pns_id=".$id;         
            $db->setQuery($query);
            $db->query();                 
            JAdministrator::HistoryUser(6, 'R', $id);
        }
                        
        $msg = JText::_('RESTORE_PNS_SUCCESSFUL');
        $this->setRedirect( 'index.php?option=com_apdmrecylebin&task=pns', $msg);
    }
    function cancel_pns(){
         $this->setRedirect( 'index.php?option=com_apdmrecylebin&task=pns');
    }
	function cancel_detaileco(){
		 $this->setRedirect( 'index.php?option=com_apdmrecylebin&task=eco');
	}
	function Readfilesizeeco($filename){
      $path = JPATH_SITE.DS.'uploads'.DS.'eco'.DS;   
      $filesize =  ceil ( filesize($path.$filename) /1000 );
      return $filesize;
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
            $filesize =  ceil (filesize($path_pns.$filename) / 1000 );
      return $filesize;
   }
	
	}
    
