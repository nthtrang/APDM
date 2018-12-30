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
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
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
                 global $mainframe, $option,$option1;
                 
                $db                =& JFactory::getDBO();
                $cid		= JRequest::getVar( 'cid', array(0), '', 'array' );
                $edit		= JRequest::getVar('edit',true);               
                $row = & JTable::getInstance('apdmecoroutes');
                $me = & JFactory::getUser();
                $user_login=$me->get('email');
                $option             = 'com_apdmeco&task=dashboard&tmpl=inreview';
                $option1             = 'com_apdmeco&task=dashboard&tmpl=pending';
                $limit        = 5;//$mainframe->getUserStateFromRequest( 'global.list.limit', 'limit',2 , 'int' );//$mainframe->getCfg('list_limit')
                $limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
                
                $limit1        = 5;//$mainframe->getUserStateFromRequest( 'global.list.limit', 'limit',2 , 'int' );//$mainframe->getCfg('list_limit')
                $limitstart1 = $mainframe->getUserStateFromRequest( $option1.'.limitstart1', 'limitstart1', 0, 'int' );

               // jimport('joomla.html.pagination');
                
                $arr_inreview =array();
                $query= "SELECT rt.due_date as route_due_date,rt.id as route_id,rt.status as route_status,st.*,eco.eco_id as ecoid,eco.eco_create_by,rt.owner,rt.name as route_name,eco.eco_name,eco.eco_description,eco.eco_status FROM apdm_eco_status st inner join apdm_eco_routes rt on st.routes_id = rt.id inner join apdm_eco eco on eco.eco_routes_id = rt.id  WHERE st.email = '".$user_login."' and st.eco_status = 'Inreview' and rt.status='Started'";
                $db->setQuery($query);
                
                $arr_inreview= $db->loadObjectList();
                $total_inreview = count($arr_inrevieww);          
               // $pagination_inreview = new JPagination( $total_inreview, $limitstart1, $limit1 );       
               // $this->assignRef('total_record_inreview',    $total_inreview);
             //   echo  $pagination_inreview->limit1;
               // $db->setQuery( $query, $pagination_inreview->limitstart, $pagination_inreview->limit);
                //$arr_inreview= $db->loadObjectList();
                
               // jimport('joomla.html.pagination');
                //MY PENDING TASK
               // echo "SELECT rt.id,rt.status as route_status,eco.eco_id as ecoid,eco.eco_create_by,rt.owner,rt.name as route_name,eco.eco_name,rt.description,eco.eco_status FROM apdm_eco eco  inner join apdm_eco_routes rt on eco.eco_routes_id = rt.id WHERE rt.owner = '".$me->get('id')."' and eco.eco_status = 'Inreview'";
                $query = "SELECT rt.due_date as route_due_date,rt.id,rt.status as route_status,eco.eco_id as ecoid,eco.eco_create_by,rt.owner,rt.name as route_name,eco.eco_name,rt.description,eco.eco_status FROM apdm_eco eco  inner join apdm_eco_routes rt on eco.eco_routes_id = rt.id WHERE rt.owner = '".$me->get('id')."' and eco.eco_status = 'Inreview'";
                //$db->setQuery("SELECT rt.id,rt.status as route_status,eco.eco_id as ecoid,eco.eco_create_by,rt.owner,rt.name as route_name,eco.eco_name,rt.description,eco.eco_status FROM apdm_eco eco  inner join apdm_eco_routes rt on eco.eco_routes_id = rt.id WHERE rt.owner = '".$me->get('id')."' and eco.eco_status = 'Inreview'");
                $db->setQuery($query);
                $arr_pending= $db->loadObjectList();  
             //   $total_pending = count($arr_pendingq);                
              //  $pagination_pending = new JPagination( $total_pending, $limitstart, $limit );       
             //   $this->assignRef('total_record_pending',    $total_pending);
              //  $db->setQuery( $query, $pagination_pending->limitstart, $pagination_pending->limit );
              
                $arr_pending = $db->loadObjectList();                 
               // $rows = $db->loadObjectList();
              //  $this->assignRef('pagination_inreview',    $pagination_inreview);   
             //    $this->assignRef('pagination_pending',    $pagination_pending);   
                $this->assignRef('arr_inreview',    $arr_inreview);
                 $this->assignRef('arr_pending',    $arr_pending);
                
            //    $this->assignRef('lists',        $lists);

	parent::display($tpl);
	}
}

