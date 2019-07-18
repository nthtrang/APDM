<?php
/**
* @version		$Id: view.html.php 10381 2008-06-01 03:35:53Z pasamio $
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

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the Users component
 *
 * @static
 * @package		Joomla
 * @subpackage	Users
 * @since 1.0
 */
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
                $arr_status = array();

                $arr_affected = array();
		if($edit){
			$row->load($cid[0]);
            $db->setQuery("SELECT * FROM apdm_eco_files WHERE eco_id=".$cid[0]);
            $arr_file = $db->loadObjectList();
            
            //viec loadd affected
            $db->setQuery("SELECT * FROM apdm_eco_affected WHERE eco_id=".$cid[0]." order by id desc");
            $arr_affected = $db->loadObjectList();
            //viet status	
            
            $routes		= JRequest::getVar('routes');
            $db->setQuery("SELECT DATEDIFF(rt.due_date, CURDATE()) as route_remain_date,rt.status as route_status,st.*,eco.eco_id,eco.eco_create_by,rt.due_date as route_due_date,st.approved_at,rt.status FROM apdm_eco_status st inner join apdm_eco_routes rt on st.routes_id = rt.id left join apdm_eco eco on eco.eco_routes_id = rt.id  WHERE rt.id = ".$routes." group by email order by sequence asc");
            $arr_status = $db->loadObjectList();
		}
		//get list user have exist on datbase
		$db->setQuery("SELECT * FROM jos_users jos inner join apdm_users apd on jos.id = apd.user_id  WHERE user_enable=0 and  user_id != '".$me->get('id')."' ORDER BY jos.username ");
		$list_user = $db->loadObjectList();	
                $eco_activate  = ($row->eco_id) ? $row->eco_activate : 1;
		$lists['activate'] 	= JHTML::_('select.booleanlist',  'eco_activate', 'class="inputbox" size="1"', $eco_activate );
		//for eco actiave (statis)
		//$status_s[] = JHTML::_('select.option', '', JText::_('SELECT_STATUS') , 'value', 'text'); 
		$status_s[] = JHTML::_('select.option', 'Create', JText::_('Create') , 'value', 'text'); 
		$status_s[] = JHTML::_('select.option', 'Inreview', JText::_('In Review') , 'value', 'text'); 
		$status_s[] = JHTML::_('select.option', 'Released', JText::_('Released') , 'value', 'text'); 
                //check if status is released => disable option
                $classDisabled = "";
               // if($row->eco_status=='Released')
                    $classDisabled = 'disabled = "disabled"';   
		$lists['status']   =  JHTML::_('select.genericlist',   $status_s, 'eco_status_tmp', 'class="inputbox" size="1" '.$classDisabled.'', 'value', 'text', $row->eco_status ); 
		
                //viec chnage status=lifecycle
                $life_cycle_s[] = JHTML::_('select.option', 'Create', JText::_('Create') , 'value', 'text'); 
		$life_cycle_s[] = JHTML::_('select.option', 'Inreview', JText::_('In Review') , 'value', 'text'); 
		$life_cycle_s[] = JHTML::_('select.option', 'eleased', JText::_('Released') , 'value', 'text'); 
		 $classDisabled = "";
                if($row->eco_lifecycle=='Released')
                    $classDisabled = 'disabled = "disabled"';   
		$lists['lifecycle']   =  JHTML::_('select.genericlist',   $life_cycle_s, 'eco_lifecycle', 'class="inputbox" size="1" '.$classDisabled.'', 'value', 'text', $row->eco_lifecycle ); 
/*    
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
*/		                
		for ($i=1; $i<=JText::_('ECO_TYPE_NUM'); $i++)
			{
				$type[] =    JHTML::_('select.option', JText::_('ECO_TYPE_'.$i), JText::_('ECO_TYPE_'. $i) , 'value', 'text'); 
			}
		
		$lists['type']   =  JHTML::_('select.genericlist',   $type, 'eco_type', 'class="inputbox" size="1" ', 'value', 'text', $row->eco_type );  
        
       // $field_impact[] =   JHTML::_('select.option', JText::_('VALUE_FIELD_IMPACT'), JText::_('VALUE_FIELD_IMPACT') , 'value', 'text');
        $field_impact[] =   JHTML::_('select.option', JText::_('VALUE_FIELD_IMPACT_YES'), JText::_('VALUE_FIELD_IMPACT_YES') , 'value', 'text');
        $field_impact[] =   JHTML::_('select.option', JText::_('VALUE_FIELD_IMPACT_NO'), JText::_('VALUE_FIELD_IMPACT_NO') , 'value', 'text');
         $lists['field_impact']   =  JHTML::_('select.genericlist',   $field_impact, 'eco_field_impact', 'class="inputbox" size="1" ', 'value', 'text', $row->eco_field_impact ); 
         //$row->eco_status
        //$activate = array('0'=>'No', '1'=>'Yes');
        //$lists['activate']     = JHTML::_('select.radiolist',  $activate, 'info_activate', 'class="inputbox" size="1"' );
		$this->assignRef('lists',		$lists);
		$this->assignRef('row',	$row);
		$this->assignRef('list_user',	$list_user);
        $this->assignRef('arr_file',    $arr_file);
        $this->assignRef('arr_affected',    $arr_affected);
        
        $db->setQuery("SELECT * FROM apdm_eco_routes WHERE eco_id=".$cid[0]." and id=".$routes." order by id desc");
            $arr_route= $db->loadObjectList();
            $this->assignRef('arr_route',    $arr_route);
        $this->assignRef('arr_status',    $arr_status);
        $rowEco = & JTable::getInstance('apdmeco');
        $rowEco->load($cid[0]);
        $this->assignRef('rowEco',	$rowEco);
		parent::display($tpl);
	}
}