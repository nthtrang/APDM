<?php
/**
* @version		$Id: view.html.php 10496 2009-01
* @package		APDM
* @subpackage	Roles
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the Roles component 
 */
class RolesViewRole extends JView
{
	function display($tpl = null)
	{
		$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );
		$edit		= JRequest::getVar('edit',true);
		$me 		= JFactory::getUser();
		JArrayHelper::toInteger($cid, array(0));

		$db 		=& JFactory::getDBO();
			
		$row =& JTable::getInstance('role');
		$n_user			= 0; //number of user
		if($edit){
			$row->load ($cid[0]);
			// get number user belong this role
			$db->setQuery("SELECT COUNT(user_id) FROM apdm_role_user WHERE role_id=".$cid[0]);
			$n_user 	= $db->loadResult();
		}
		//for value of role
		$db->setQuery("SELECT * FROM apdm_role_component WHERE role_id=".$cid[0]);
		$row_values = $db->loadObjectList();
		$arrCC= array();
		$arrVendor = array();
		$arrSupplier = array();
		$arrManufacture = array();
		$arrECO		= array();
                $arrPO		= array();
                $arrSTO		= array();
		$arrPns 	= array();
		if (count ($row_values) > 0){
			foreach ($row_values as $obj){
				if ($obj->component_id ==1){
					$arrCC[] = $obj->role_value;
				}
				if ($obj->component_id ==2){
					$arrVendor[] = $obj->role_value;
				}
				if ($obj->component_id ==3){
					$arrSupplier[] = $obj->role_value;
				}
				if ($obj->component_id ==4){
					$arrManufacture[] = $obj->role_value;
				}
				if ($obj->component_id==5){
					$arrECO[] = $obj->role_value;
				}
				if ($obj->component_id ==6){
					$arrPns[] = $obj->role_value;
				}
                                //for PO
				if ($obj->component_id==7){
					$arrPO[] = $obj->role_value;
				}
                                //for STO
				if ($obj->component_id==8){
					$arrSTO[] = $obj->role_value;
				} 
                                
			}
		}

		
		$this->assignRef('me', 		$me);		
		$this->assignRef('row',		$row);		
		$this->assignRef('n_user',	$n_user);
		$this->assignRef('role_id',	$cid[0]);	
		$this->assignRef('arrCC',	$arrCC);		
		$this->assignRef('arrVendor',	$arrVendor);		
		$this->assignRef('arrSupplier',	$arrSupplier);		
		$this->assignRef('arrECO',	$arrECO);	
                $this->assignRef('arrPO',	$arrPO);	
                $this->assignRef('arrSTO',	$arrSTO);	
		$this->assignRef('arrManufacture',	$arrManufacture);		
		$this->assignRef('arrPns',	$arrPns);		
		parent::display($tpl);
	}
}
