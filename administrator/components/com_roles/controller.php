<?php
/**
 * @version		$Id: controller.php  2009-01-01 
 * @package		APDM
 * @subpackage	Roles 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * Roles Component Controller
 *
 * @subpackage	Roles 
 */
class RolesController extends JController
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
		$this->registerTask( 'flogout', 'logout');
		$this->registerTask( 'unblock', 'block' );
	}

	/**
	 * Displays a view
	 */
	function display( )
	{
		switch($this->getTask())
		{
			case 'add'     :
			{	//JRequest::setVar( 'hidemainmenu', 1 );
				JRequest::setVar( 'layout', 'form'  );
				JRequest::setVar( 'view', 'role' );
				JRequest::setVar( 'edit', false );
			} break;
			case 'edit'    :
			{
				//JRequest::setVar( 'hidemainmenu', 1 );
				JRequest::setVar( 'layout', 'form'  );
				JRequest::setVar( 'view', 'role' );
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
		//JRequest::checkToken() or jexit( 'Invalid Token' );
		$option = JRequest::getCmd( 'option');
		// Initialize some variables
		$db			= & JFactory::getDBO();
		$me			= & JFactory::getUser();
		$post		= JRequest::get( 'post' );
		$row		=& JTable::getInstance('role');	
			
		$datenow =& JFactory::getDate();
		
		if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
		
		if (!$row->check()) {
			$msg = JText::sprintf( 'ALERT_ROLE_NAME_EXIST',  $row->role_name );
			$mainframe->redirect( 'index.php?option=com_roles&view=role&task=edit&cid[]='. $role_id, $msg );
			exit;
		}
		$isNew = true;
		if ($row->role_id) {
			$isNew = false;			
			$row->role_modified		= $datenow->toMySQL();
			$row->role_modified_by 	= $me->get('id');
		}
		$row->role_create_by 	= $row->role_create_by ? $row->role_create_by : $me->get('id');
		if ($row->role_create && strlen(trim( $row->role_create )) <= 10) {
			$row->role_create 	.= ' 00:00:00';
		}

		$config =& JFactory::getConfig();
		$tzoffset = $config->getValue('config.offset');
		$date =& JFactory::getDate($row->role_create, $tzoffset);
		$row->role_create = $date->toMySQL();
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		$role_id = $row->role_id;		
		$row->checkin();
		//delete all value of role before insert
		$db->setQuery("DELETE FROM apdm_role_component WHERE role_id=".$role_id);
		$db->query();
		//for value of component
		$c		= JRequest::getVar( 'cc', array(0), '', 'array' );
		$v		= JRequest::getVar( 'v', array(0), '', 'array' );
		$s		= JRequest::getVar( 'v', array(0), '', 'array' );
		$m		= JRequest::getVar( 'v', array(0), '', 'array' );
		$eco	= JRequest::getVar( 'eco', array(0), '', 'array' );
        $po	= JRequest::getVar( 'po', array(0), '', 'array' );
        $sto	= JRequest::getVar( 'sto', array(0), '', 'array' );
        $tto	= JRequest::getVar( 'tto', array(0), '', 'array' );
        $loc	= JRequest::getVar( 'loc', array(0), '', 'array' );
		$p	= JRequest::getVar( 'p', array(0), '', 'array' );
        $swo	= JRequest::getVar( 'swo', array(0), '', 'array' );
		if (count($c) > 0){
			//update for vendor
			foreach ($c as $commodity){
				$query = "INSERT INTO apdm_role_component (role_id, component_id, role_value) VALUES({$role_id}, 1, '{$commodity}')";
				$db->setQuery($query);
				$db->query();
			}
		}
		if (count($v) > 0){
			//update for vendor
			foreach ($v as $vendor){
				$query = "INSERT INTO apdm_role_component (role_id, component_id, role_value) VALUES({$role_id}, 2, '{$vendor}')";
				$db->setQuery($query);
				$db->query();
			}
		}
		if (count($s) > 0){
			//update for vendor
			foreach ($s as $supplier){
				$query = "INSERT INTO apdm_role_component (role_id, component_id, role_value) VALUES({$role_id}, 3, '{$supplier}')";
				$db->setQuery($query);
				$db->query();
			}
		}
		if (count($m) > 0){
			//update for vendor
			foreach ($m as $manufacture){
				$query = "INSERT INTO apdm_role_component (role_id, component_id, role_value) VALUES({$role_id}, 4, '{$manufacture}')";
				$db->setQuery($query);
				$db->query();
			}
		}
		if (count($eco) > 0){
			//update for vendor
			foreach ($eco as $ecoobject){
				$query = "INSERT INTO apdm_role_component (role_id, component_id, role_value) VALUES({$role_id}, 5, '{$ecoobject}')";
				$db->setQuery($query);
				$db->query();
			}
		}
           
		if (count($p) > 0){
			//update for vendor
			foreach ($p as $pns){
				$query = "INSERT INTO apdm_role_component (role_id, component_id, role_value) VALUES({$role_id}, 6, '{$pns}')";
				$db->setQuery($query);
				$db->query();
			}
		}
		if (count($po) > 0){
			//update for PO
			foreach ($po as $poobject){
				$query = "INSERT INTO apdm_role_component (role_id, component_id, role_value) VALUES({$role_id}, 7, '{$poobject}')";
				$db->setQuery($query);
				$db->query();
			}
		}  
		if (count($sto) > 0){
			//update for STO
			foreach ($sto as $stoobject){
				$query = "INSERT INTO apdm_role_component (role_id, component_id, role_value) VALUES({$role_id}, 8, '{$stoobject}')";
				$db->setQuery($query);
				$db->query();
			}
		}
        if (count($loc) > 0){
			//update for STO
			foreach ($loc as $locobject){
				$query = "INSERT INTO apdm_role_component (role_id, component_id, role_value) VALUES({$role_id}, 9, '{$locobject}')";
				$db->setQuery($query);
				$db->query();
			}
		}
		if (count($swo) > 0){
			//update for STO
			foreach ($swo as $swoobject){
				$query = "INSERT INTO apdm_role_component (role_id, component_id, role_value) VALUES({$role_id}, 10, '{$swoobject}')";
				$db->setQuery($query);
				$db->query();
			}
		}
        if (count($tto) > 0){
            //update for TTO
            foreach ($tto as $ttoobject){
                $query = "INSERT INTO apdm_role_component (role_id, component_id, role_value) VALUES({$role_id}, 11, '{$ttoobject}')";
                $db->setQuery($query);
                $db->query();
            }
        }
		//end value of component
		switch ( $this->getTask() )
		{
			case 'apply':
				//$msg = JText::sprintf( 'Successfully Saved changes to role', $row->role_name );
				//$this->setRedirect( 'index.php?option=com_roles&view=role&task=edit&cid[]='. $role_id, $msg );
				$msg = JText::sprintf( 'Successfully Saved Role', $row->role_name );
				$this->setRedirect( 'index.php?option=com_roles', $msg );
				break;

			case 'save':
			default:
				$msg = JText::sprintf( 'Successfully Saved Role', $row->role_name );
				$this->setRedirect( 'index.php?option=com_roles&task=add', $msg );
				break;
		}
	}

	/**
	 * Removes the record(s) from the database
	 */
	function remove()
	{
		// Check for request forgeries
		//JRequest::checkToken() or jexit( 'Invalid Token' );

		$db 			=& JFactory::getDBO();		
		$cid 			= JRequest::getVar( 'cid', array(), '', 'array' );

		JArrayHelper::toInteger( $cid );

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select a role to delete', true ) );
		}
		$arrCanNotDelete = array();
		$arrDelete = array();
		$i =0 ;
		foreach ($cid as $id)
		{
			//check for role : if role have assign for user so can not delete
			$check_role =& RolesController::CountNumberUserOfRole($id);
			if ($check_role){
				$arrCanNotDelete[] = $id;
			}else{
				$i++;
				$arrDelete[] = $i;
				$db->setQuery('DELETE FROM apdm_role WHERE role_id='.$id);
				$db->query();
				$db->setQuery('DELETE FROM apdm_role_component  WHERE role_id='.$id);
				$db->query();
			}
		}
		$arrNameRole = array();
		if (count($arrCanNotDelete) > 0){
			foreach ($arrCanNotDelete as $obj){
				$db->setQuery("SELECT role_name FROM apdm_role WHERE role_id=".$obj);
				$arrNameRole[] = $db->loadResult();
			}
		}
		if (count($arrNameRole) > 0  && count($arrDelete) == 0 ){
			$msg = 'There are roles ( '.implode(";", $arrNameRole).' ) can not delete. Them already assign for user. You must empty it before delete.';
		}
		if (count($arrNameRole) > 0&& count($arrDelete) > 0 ) {
			$msg = 'Role have deleted. But there are roles ( '.implode(";", $arrNameRole).' ) can not delete. Them already assign for user. You must empty it before delete.';
		}
		if (count($arrNameRole) == 0 && count($arrDelete) > 0 ){
			$msg = 'Role have deleted.';
		}
		
		$this->setRedirect( 'index.php?option=com_roles', $msg);
	}

	/**
	 * Cancels an edit operation
	 */
	function cancel( )
	{
		$this->setRedirect( 'index.php?option=com_roles' );
	}

	
	function GetNameUser($userid){
		$db = & JFactory::getDBO();
		$db->setQuery("select username FROM #__users WHERE id=".$userid);
		$result = $db->loadResult();
		return $result;
	}
	function CountNumberUserOfRole($role_id){
		$db = & JFactory::getDBO();
		$db->setQuery("SELECT COUNT(user_id) FROM apdm_role_user WHERE role_id=".$role_id);
		$result = $db->loadResult();
		return $result;
	}
	
}
