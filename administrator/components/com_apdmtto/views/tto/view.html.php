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
class TToViewtto extends JView
{
	function display($tpl = null)
	{
                
	   // global $mainframe, $option;
        global $mainframe, $option;
        $option             = 'com_apdmtto_tto';
        $db                =& JFactory::getDBO();
        $cid		= JRequest::getVar( 'cid', array(0), '', 'array' );       
        $tto_id		= JRequest::getVar( 'id');
        
        
        JArrayHelper::toInteger($cid, array(0));	       
        $search                = $mainframe->getUserStateFromRequest( "$option.text_search", 'text_search', '','string' );
        $search                = JString::strtolower( $search );
        $limit        = $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
        $limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
        
        
        
        $where = array();      
        $where[] = 'p.tto_state != "Done"';
        $where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
        $orderby = ' ORDER BY p.pns_tto_id desc';        
        
        $query = 'SELECT COUNT(p.pns_tto_id)'
        . ' FROM apdm_pns_tto AS p'
        . $where
        ;

        $db->setQuery( $query );
        $total = $db->loadResult();

        jimport('joomla.html.pagination');
        $pagination = new JPagination( $total, $limitstart, $limit );
        
        $query = 'SELECT p.*,DATEDIFF(p.tto_due_date, CURDATE()) + 1 as tto_remain '
            . ' FROM apdm_pns_tto AS p'
            . $where
            . $orderby;
        $lists['query'] = base64_encode($query);   
        $lists['total_record'] = $total; 
        $db->setQuery( $query);
        $rows = $db->loadObjectList(); 
        
        
        $val_date_out_from ="";
        $val_date_out_to="";
        if(JRequest::getVar( 'tto_owner_out_confirm_date_from')){
                $date_out_from = new DateTime(JRequest::getVar( 'tto_owner_out_confirm_date_from'));                
                $tto_date_out_from = $date_out_from->format('Y-m-d');
                $val_date_out_from = $date_out_from->format('m/d/Y');
        }
        if(JRequest::getVar( 'tto_owner_out_confirm_date_to')){
                $date_out_to = new DateTime(JRequest::getVar( 'tto_owner_out_confirm_date_to'));                
                $tto_date_out_to = $date_out_to->format('Y-m-d');
                 $val_date_out_to = $date_out_to->format('m/d/Y');
        }
        $current = new DateTime(); 
        $current_out = $current->format('Y-m-d');          
        $filter_tto_created_by = JRequest::getVar( 'filter_tto_created_by');
        $filter_tto_owner_out_by = JRequest::getVar( 'filter_tto_owner_out_by');

         $clean = JRequest::getVar( 'clean');
        if($clean=="all")
        {                
           $tto_date_out_from = $tto_date_out_to=$filter_tto_created_by="";     
        }
        $where = "where tto.tto_state = 'Done'";

        if($tto_date_out_from && $tto_date_out_to)
        {
                $where .= " and DATE(tto.tto_owner_out_confirm_date) >= '".$tto_date_out_from."'";
                $where .= " and DATE(tto.tto_owner_out_confirm_date) <= '".$tto_date_out_to."'";
        }
        elseif($tto_date_out_to)
        {
                $where .= " and DATE(tto.tto_owner_out_confirm_date <= '".$tto_date_out_to."'";
        }
        elseif($tto_date_out_from)
        {
                $where .= " and DATE(tto.tto_owner_out_confirm_date  >= '".$tto_date_out_from."'";
        }

        if($filter_tto_created_by)
        {
                $where .= " and tto.tto_create_by = '".$filter_tto_created_by."'";
        }
        if($filter_tto_owner_out_by)
        {
                $where .= " and tto.tto_owner_out = '".$filter_tto_owner_out_by."'";
        }
        if(!$tto_date_out_from && !$tto_date_out_to && !$filter_tto_created_by && !$filter_tto_owner_out_by)
        {
            $where .= " and DATE(tto.tto_owner_out_confirm_date) = '".$current_out."'";
        }
        
        $query = "select  tto.*,DATEDIFF(tto.tto_due_date, CURDATE()) + 1 as tto_remain "
                ." from apdm_pns_tto tto "
                . $where;
        $db->setQuery($query);
        $list_tools_done = $db->loadObjectList();         
        $this->assignRef('tools', $list_tools_done);
        
        //Cerated by
        $db->setQuery("SELECT p.tto_create_by as value, u.name as text FROM apdm_pns_tto as p LEFT JOIN jos_users as u ON u.id=p.tto_create_by  GROUP BY p.tto_create_by ORDER BY text "); 
        $create_by[] = JHTML::_('select.option', 0, JText::_('SELECT_CREATED_BY'), 'value', 'text');
        $create_bys = array_merge($create_by, $db->loadObjectList());
        $lists['tto_create_by'] = JHTML::_('select.genericlist', $create_bys, 'filter_tto_created_by', 'class="inputbox" size="1" ', 'value', 'text', $filter_tto_created_by );
        
        //Owner by
        $db->setQuery("SELECT  p.tto_owner_out as value, u.name as text FROM apdm_pns_tto as p LEFT JOIN jos_users as u ON u.id=p.tto_owner_out where p.tto_owner_out_confirm=1  GROUP BY p.tto_owner_out ORDER BY text  ");        
        $modified[] = JHTML::_('select.option', 0, JText::_('Select Owner'), 'value', 'text');
        $modifieds = array_merge($modified, $db->loadObjectList());
        $lists['tto_owner_out'] = JHTML::_('select.genericlist', $modifieds, 'filter_tto_owner_out_by', 'class="inputbox" size="1"  ', 'value', 'text', $filter_tto_owner_out_by );

        $this->assignRef('date_out_from',      $val_date_out_from );
        $this->assignRef('date_out_to',        $val_date_out_to);

        
        $lists['search']= $search;    
        $this->assignRef('lists',        $lists);
        $this->assignRef('ttos_list',        $rows);
        $this->assignRef('pagination',    $pagination);  

		parent::display($tpl);
	}
}

