<?php
/**
* @version		$Id: view.html.php 10496 2008-07-03 07:08:39Z ircmaxell $
* @package		APDM
* @subpackage	PNS
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
class ecoViewdashboard extends JView
{
	function display($tpl = null)
	{
                // global $mainframe, $option;
                $db                =& JFactory::getDBO();
                $cid		= JRequest::getVar( 'cid', array(0), '', 'array' );
                $edit		= JRequest::getVar('edit',true);               
                $row = & JTable::getInstance('apdmecoroutes');
                $me = & JFactory::getUser();
                $user_login=$me->get('email');
                $arr_inreview =array();
//echo "SELECT rt.status as route_status,st.*,eco.eco_id as ecoid,eco.eco_create_by,rt.owner,rt.name as route_name,eco.eco_name,eco.eco_description,eco.eco_status FROM apdm_eco_status st inner join apdm_eco_routes rt on st.routes_id = rt.id left join apdm_eco eco on eco.eco_routes_id = rt.id  WHERE st.email = '".$user_login."' and st.eco_status = 'Inreview'";//and st.eco_status = 'Inreview'
                $db->setQuery("SELECT rt.status as route_status,st.*,eco.eco_id as ecoid,eco.eco_create_by,rt.owner,rt.name as route_name,eco.eco_name,eco.eco_description,eco.eco_status FROM apdm_eco_status st inner join apdm_eco_routes rt on st.routes_id = rt.id left join apdm_eco eco on eco.eco_routes_id = rt.id  WHERE st.email = '".$user_login."' and st.eco_status = 'Inreview'");
                $arr_inreview= $db->loadObjectList();
               // echo "SELECT rt.id,rt.status as route_status,eco.eco_id as ecoid,eco.eco_create_by,rt.owner,rt.name as route_name,eco.eco_name,rt.description,eco.eco_status FROM apdm_eco eco  inner join apdm_eco_routes rt on eco.eco_routes_id = rt.id WHERE rt.owner = '".$me->get('id')."' and eco.eco_status = 'Inreview'";
                $db->setQuery("SELECT rt.id,rt.status as route_status,eco.eco_id as ecoid,eco.eco_create_by,rt.owner,rt.name as route_name,eco.eco_name,rt.description,eco.eco_status FROM apdm_eco eco  inner join apdm_eco_routes rt on eco.eco_routes_id = rt.id WHERE rt.owner = '".$me->get('id')."' and eco.eco_status = 'Inreview'");
                $arr_pending= $db->loadObjectList();                
               // $rows = $db->loadObjectList();
                $this->assignRef('arr_inreview',    $arr_inreview);
                 $this->assignRef('arr_pending',    $arr_pending);
                
            //    $this->assignRef('lists',        $lists);

	parent::display($tpl);
	}
}

