<?php
/**
* To view list update ECO
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class ecoViewupdate extends JView
{
	function display($tpl = null)
	{
		global $mainframe, $option;		

		$db				=& JFactory::getDBO();	
		$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );
		$edit		= JRequest::getVar('edit',true);
		$me 		= JFactory::getUser();
		JArrayHelper::toInteger($cid, array(0));		
		$db 		=& JFactory::getDBO();
		$row = & JTable::getInstance('apdmeco');	
        $arr_file = array();
		if($edit){
			$row->load($cid[0]);
            $db->setQuery("SELECT * FROM apdm_eco_files WHERE eco_id=".$cid[0]);
            $arr_file = $db->loadObjectList();
		}
		//get list user have exist on datbase
		$db->setQuery("SELECT username FROM apdm_users WHERE user_enable=0 ORDER BY username ");
		$list_user = $db->loadObjectList();	
        $eco_activate  = ($row->eco_id) ? $row->eco_activate : 1;
		$lists['activate'] 	= JHTML::_('select.booleanlist',  'eco_activate', 'class="inputbox" size="1"', $eco_activate );
		//for eco actiave (statis)
		//$activate_s[] = JHTML::_('select.option', '', JText::_('SELECT_STATUS') , 'value', 'text'); 
		$activate_s[] = JHTML::_('select.option', 'Pending', JText::_('Pending') , 'value', 'text'); 
		$activate_s[] = JHTML::_('select.option', 'Released', JText::_('Released') , 'value', 'text'); 
		$activate_s[] = JHTML::_('select.option', 'Reject', JText::_('Reject') , 'value', 'text'); 
		$lists['status']   =  JHTML::_('select.genericlist',   $activate_s, 'eco_status', 'class="inputbox" size="1" ', 'value', 'text', $row->eco_status ); 
		
		
        $type[] =    JHTML::_('select.option', JText::_('TYPE_UNASSIGNED'), JText::_('TYPE_UNASSIGNED') , 'value', 'text'); 
        $type[] =    JHTML::_('select.option', JText::_('TYPE_BUSINESS_PROCEDURE'), JText::_('TYPE_BUSINESS_PROCEDURE') , 'value', 'text');   
        $type[] =    JHTML::_('select.option', JText::_('TYPE_DC_CORRECTION'), JText::_('TYPE_DC_CORRECTION') , 'value', 'text');  
        $type[] =    JHTML::_('select.option', JText::_('TYPE_DC_COST_REDUCTION'), JText::_('TYPE_DC_COST_REDUCTION') , 'value', 'text');   
        $type[] =    JHTML::_('select.option', JText::_('TYPE_DC_ENHANCEMENT'), JText::_('TYPE_DC_ENHANCEMENT') , 'value', 'text');   
        $type[] =    JHTML::_('select.option', JText::_('TYPE_DC_MANUFACTURABILITY'), JText::_('TYPE_DC_MANUFACTURABILITY') , 'value', 'text'); 
        $type[] =    JHTML::_('select.option', JText::_('TYPE_DC_PRODUCTION_PROCESS'), JText::_('TYPE_DC_PRODUCTION_PROCESS') , 'value', 'text');  
        $type[] =    JHTML::_('select.option', JText::_('TYPE_DC_SAFETY'), JText::_('TYPE_DC_SAFETY') , 'value', 'text');  
        $type[] =    JHTML::_('select.option', JText::_('TYPE_DC_SERVICEABILITY'), JText::_('TYPE_DC_SERVICEABILITY') , 'value', 'text'); 
        $type[] =    JHTML::_('select.option', JText::_('TYPE_DC_SYSTEM_PERFORMANCE'), JText::_('TYPE_DC_SYSTEM_PERFORMANCE') , 'value', 'text'); 
        $type[] =    JHTML::_('select.option', JText::_('TYPE_DC_VENDOR_DRIVEN'), JText::_('TYPE_DC_VENDOR_DRIVEN') , 'value', 'text');
        $type[] =    JHTML::_('select.option', JText::_('TYPE_NEW_RELEASE_PRERELEASE'), JText::_('TYPE_NEW_RELEASE_PRERELEASE') , 'value', 'text');
        $type[] =    JHTML::_('select.option', JText::_('TYPE_NEW_RELEASE_UNRELEASED'), JText::_('TYPE_NEW_RELEASE_UNRELEASED') , 'value', 'text'); 
        $type[] =    JHTML::_('select.option', JText::_('TYPE_SC_TO_ACTIVE'), JText::_('TYPE_SC_TO_ACTIVE') , 'value', 'text');
        $type[] =    JHTML::_('select.option', JText::_('TYPE_SC_TO_BETA_ORDER'), JText::_('TYPE_SC_TO_BETA_ORDER') , 'value', 'text');  
        $type[] =    JHTML::_('select.option', JText::_('TYPE_SC_TO_PRERELEASE'), JText::_('TYPE_SC_TO_PRERELEASE') , 'value', 'text');     
        $type[] =    JHTML::_('select.option', JText::_('TYPE_VARIANT_CONFIGUARATION'), JText::_('TYPE_VARIANT_CONFIGUARATION') , 'value', 'text');     
        $lists['type']   =  JHTML::_('select.genericlist',   $type, 'eco_type', 'class="inputbox" size="1" ', 'value', 'text', $row->eco_type );  
     
        $field_impact[] =   JHTML::_('select.option', JText::_('VALUE_FIELD_IMPACT_YES'), JText::_('VALUE_FIELD_IMPACT_YES') , 'value', 'text');
        $field_impact[] =   JHTML::_('select.option', JText::_('VALUE_FIELD_IMPACT_NO'), JText::_('VALUE_FIELD_IMPACT_NO') , 'value', 'text');
         $lists['field_impact']   =  JHTML::_('select.genericlist',   $field_impact, 'eco_field_impact', 'class="inputbox" size="1" ', 'value', 'text', $row->eco_field_impact ); 
        
		$this->assignRef('lists',		$lists);
		$this->assignRef('row',	$row);
		$this->assignRef('list_user',	$list_user);
        $this->assignRef('arr_file',    $arr_file);
		parent::display($tpl);
	}
}