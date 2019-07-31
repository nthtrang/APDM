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
class QUOViewroutes extends JView
{
	function display($tpl = null)
	{
	   // global $mainframe, $option;
        $db                =& JFactory::getDBO();
        $cid		= JRequest::getVar( 'cid', array(0), '', 'array' );
        $edit		= JRequest::getVar('edit',true);
        $me 		= JFactory::getUser();
        $row = & JTable::getInstance('apdmecoroutes');
        $route_id		= JRequest::getVar( 'id');
        if($edit){
            $row->load($route_id);
                $query = "SELECT * FROM apdm_eco_routes WHERE  id=".$route_id." and deleted = 0 ORDER BY id desc";
                $db->setQuery( $query);
                $row = $db->loadObjectList();
            $this->assignRef('row',	$row);
        }

        //route
        $routes		= JRequest::getVar('routes');
        $db->setQuery("SELECT DATEDIFF(rt.due_date, CURDATE()) as route_remain_date,rt.status as route_status,st.*,quo.quotation_id,quo.quo_created_by,rt.due_date as route_due_date,st.approved_at,rt.status FROM apdm_eco_status st inner join apdm_eco_routes rt on st.routes_id = rt.id left join apdm_quotation quo on quo.quo_routes_id = rt.id  WHERE rt.id = ".$routes." group by email order by sequence asc");

        $arr_status = $db->loadObjectList();
        $db->setQuery("SELECT * FROM apdm_eco_routes WHERE quotation_id=".$cid[0]." and id=".$routes." order by id desc");
        $arr_route= $db->loadObjectList();
        //get list user have exist on datbase
        $db->setQuery("SELECT * FROM jos_users jos inner join apdm_users apd on jos.id = apd.user_id  WHERE user_enable=0 and  user_id != '".$me->get('id')."' ORDER BY jos.username ");
        $list_user = $db->loadObjectList();

        $this->assignRef('list_user',	$list_user);
        $this->assignRef('arr_route',    $arr_route);
        $this->assignRef('arr_status',    $arr_status);

        $query = "SELECT * FROM apdm_eco_routes WHERE   quotation_id=".$cid[0]." and deleted = 0 ORDER BY id desc";        
        $db->setQuery( $query);
        $rows = $db->loadObjectList();              
        $lists['quo_id']        = $cid;    
        $this->assignRef('lists',        $lists);
        $this->assignRef('rows',        $rows);             
        $this->assignRef('id',        $cid[0]);      
        $db->setQuery("SELECT * from apdm_quotation where quotation_id=".$cid[0]);
        $quo_row =  $db->loadObject();

        $this->assignRef('quo_row',	$quo_row);
	parent::display($tpl);
	}
}

