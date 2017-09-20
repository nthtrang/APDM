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
 * Users Component Controller
 *
 * @package		Joomla
 * @subpackage	Users
 * @since 1.5
 */
class HistoryController extends JController
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
	}

	/**
	 * Displays a view
	 */
	function display( )
	{
		switch($this->getTask())
		{
			case 'add'     :
			{	JRequest::setVar( 'hidemainmenu', 1 );
				JRequest::setVar( 'layout', 'form'  );
				JRequest::setVar( 'view', 'user' );
				JRequest::setVar( 'edit', false );
			} break;
			case 'edit'    :
			{
				JRequest::setVar( 'hidemainmenu', 1 );
				JRequest::setVar( 'layout', 'form'  );
				JRequest::setVar( 'view', 'user' );
				JRequest::setVar( 'edit', true );
			} break;
		}

		parent::display();
	}
	/**
	 * Removes the record(s) from the database
	 */
	function remove()
	{
		
		$db 			=& JFactory::getDBO();
		$cid 			= JRequest::getVar( 'cid', array(), '', 'array' );

		JArrayHelper::toInteger( $cid );

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select a User to delete', true ) );
		}

		foreach ($cid as $id)
		{
			$query = "DELETE FROM apdm_user_history WHERE history_id =".$id;  
            $db->setQuery($query);
            $db->query();
		}
        $msg = JText::_('Have deleted successfull.');
		$this->setRedirect( 'index.php?option=com_history', $msg);
	}

	/**
	 * Cancels an edit operation
	 */
	function cancel( )
	{
		$this->setRedirect( 'index.php' );
	}
    /**
    * @desc Get information of action
    */
    function getInformation($action, $com_id, $id){
        $infor_action = "";
        $infor_com = "";
        $infor_id = "";
        $result = '';
        $db             =& JFactory::getDBO();  
        switch($action){
            case 'W':
                $infor_action= 'Add new ';
            break;
            case 'E':
                $infor_action= 'Edit ';
            break;
            case 'D':
                $infor_action= 'Delete ';
            break;
            case 'R':
                $infor_action= 'Resore ';
            break;
            
        }
       //get inforaation of com_id
       $query_com = "SELECT component_name FROM apdm_component WHERE component_id=".$com_id;
       $db->setQuery($query_com);
       $infor_com = 'on '.$db->loadResult();
       //get information of id to do
       switch ($com_id){
           case '1':
               
                $query= "SELECT ccs_code FROM apdm_ccs WHERE ccs_id=".$id;
                $db->setQuery($query);
                $infor_id  = $db->loadResult();                
                
           break;
           case '5':
                $query= "SELECT eco_name FROM apdm_eco WHERE eco_id=".$id;
                $db->setQuery($query);
                $infor_id  = $db->loadResult();                
                
                
           break;
           case '6':
                $table = "apdm_pns";
                $field_get = "pns_code";
                $field_key = "pns_id";
                
                $query= "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) as pns_code_new  FROM apdm_pns as p LEFT JOIN apdm_ccs as c ON c.ccs_code=p.ccs_code WHERE p.pns_id=".$id;
                $db->setQuery($query);
                $infor_id  = $db->loadResult();  
                
           break;
           
           default:  //2, 3, 4 : vendor; supplier; manufacture                  
                $query= "SELECT info_name FROM apdm_supplier_info WHERE info_id=".$id;
                $db->setQuery($query);
                $infor_id  = $db->loadResult();                              
           break;
           
       }
       if ($infor_id) {
        $result =   $infor_action.$infor_id.' '.$infor_com;
       }
       return $result;
    }
    

}
