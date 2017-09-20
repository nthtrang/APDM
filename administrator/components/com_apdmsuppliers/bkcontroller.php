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

/**
 * Supplier Infor Component Controller
 *
 * @package		Joomla
 * @subpackage	Users
 * @since 1.5
 */
class apdmsuppliersController extends JController
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
		$this->registerTask( 'apply', 	'save'  );
		$this->registerTask( 'detail', 	'display');
		$this->registerTask( 'unblock', 'block' );
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
				JRequest::setVar( 'layout', 'add_info'  );
				JRequest::setVar( 'view', 'info' );
				JRequest::setVar( 'edit', false );
			} break;
			case 'edit'    :
			{
				
				JRequest::setVar( 'layout', 'add_info'  );
				JRequest::setVar( 'view', 'info' );
				JRequest::setVar( 'edit', true );
			} break;
			case 'detail'    :
			{
				
				JRequest::setVar( 'layout', 'detail'  );
				JRequest::setVar( 'view', 'detail' );
				JRequest::setVar( 'edit', true );
			} break;
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
		$row = & JTable::getInstance('apdmsupplierinfo');		
		if (!$row->bind(JRequest::get('post'))) {
			JError::raiseError( 500, $db->stderr() );
			return false;
		}
		
		$row->info_id = (int) $row->info_id;
		$isNew = true;		
		
		if ($row->info_id) {
			$isNew = false;
			$datenow =& JFactory::getDate();
			$row->info_modified 	= $datenow->toMySQL();
			$row->info_modified_by 	= $me->get('id');
		}
		$row->info_created_by 	= $row->info_created_by ? $row->info_created_by : $me->get('id');

		if ($row->info_create && strlen(trim( $row->info_create )) <= 10) {
			$row->info_create 	.= ' 00:00:00';
		}
		$config =& JFactory::getConfig();
		$tzoffset = $config->getValue('config.offset');
		$date =& JFactory::getDate($row->info_create, $tzoffset);
		$row->info_create = $date->toMySQL();
		
		if (!$row->check()){
            $msg = JText::_( 'This name have exist. Please input orther name. (Note: Please contact with admin for this case)' );
			if ($row->info_id) {
			      $this->setRedirect( 'index.php?option=com_apdmsuppliers&task=edit&cid[]='.$row->info_id, $msg );
			}else{
	            $this->setRedirect( 'index.php?option=com_apdmsuppliers&task=add', $msg );
			}
        }else{
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
			    JAdministrator::HistoryUser($row->info_type, $what, $row->info_id);
		    }
		    switch ( $this->getTask() )
		    {
			    case 'apply':
				    $msg = JText::sprintf( 'Successfully Saved changes to Information', $row->info_name );
				    $this->setRedirect( 'index.php?option=com_apdmsuppliers&task=detail&cid[]='. $row->info_id, $msg );
				    break;

			    case 'save':
			    default:
				    $msg = JText::sprintf( 'Successfully Saved information', $row->info_name );
				    $this->setRedirect( 'index.php?option=com_apdmsuppliers&task=add', $msg );
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
			$query = "UPDATE apdm_supplier_info SET  info_deleted=1, info_modified='".$datenow->toMySQL()."', info_modified_by = ".$currentUser->get('id')." WHERE info_id=".$id;
			$db->setQuery($query);
			$db->query();
			$query1  = "SELECT info_type FROM apdm_supplier_info WHERE info_id=".$id;
			$db->setQuery($query1);
			$type_info = $db->loadResult();
			JAdministrator::HistoryUser($type_info, 'D', $id);
			//SET UPDATE FOR PmS
			
		}		
		$msg = JText::_('ALERT_DETELE_INFO');
		$this->setRedirect( 'index.php?option=com_apdmsuppliers', $msg);
	}

	/**
	 * Cancels an edit operation
	 */
	function cancel( )
	{
		$this->setRedirect( 'index.php?option=com_apdmsuppliers' );
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
             $name = 'Info_Report';
             require_once( JPATH_COMPONENT.DS.'infor.xls.php' );
            //  ob_end_clean();
             header("Content-type: application/vnd.ms-excel"); 
             header("Content-Disposition: attachment; filename=".$name.".xls"); 
             header("Pragma: no-cache"); 
             header("Expires: 0"); 
            exit;
        // CCsController::downContent('eee.xls',$content);
       //   exit;
         
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
			JError::raiseError(500, JText::_( 'Select a record to '.$this->getTask(), true ) );
		}
		foreach ($cid as $id)
		{
			$query = "UPDATE apdm_supplier_info SET  info_activate=".$block.", info_modified='".$datenow->toMySQL()."', info_modified_by = ".$currentUser->get('id')." WHERE info_id=".$id;
			$db->setQuery($query);
			$db->query();			
			//set update PNs
			//set history
			$query1  = "SELECT info_type FROM apdm_supplier_info WHERE info_id=".$id;
			$db->setQuery($query1);
			$type_info = $db->loadResult();
			JAdministrator::HistoryUser($type_info, 'E', $id);
			
		}
		$msg = JText::_('ALERT_ACTIVATE_INFO');
		$this->setRedirect( 'index.php?option=com_apdmsuppliers', $msg);
	}
    function get_supplier(){
        JRequest::setVar( 'layout', 'list'  );
        JRequest::setVar( 'view', 'supplier' );
        parent::display();
    }
    function ajax_supplier(){
       
        $db             =& JFactory::getDBO();    
        $cid             = JRequest::getVar( 'cid', array(), '', 'array' );   
        $type   = JRequest::getVar('type');
        if ($type==2){
            $name_check = 'vendor_id';
            $name_value = 'vendor_info';
        }
        if ($type==3){
            $name_check = 'supplier_id';
            $name_value = 'spp_info';
        }
        if ($type==4){
            $name_check = 'manufacture_id';
            $name_value = 'mf_info';
        }
        $query = "SELECT info_id, info_name FROM apdm_supplier_info WHERE info_id IN (".implode(",", $cid).")";       
        $db->setQuery($query);
        $rows = $db->loadObjectList();        
        $result = '';
        foreach ($rows as $row){
            $result .= '<tr>';
            $result .= '<td>'.$row->info_name.' <input type="hidden" value="'.$row->info_id.'" name="'.$name_check.'[]" /></td><td><input type="text" value="" name="'.$name_value.'[]" size="50" /></td>';
            $result .='</tr>';
        }
        echo $result;
        exit;
    }
	
}
