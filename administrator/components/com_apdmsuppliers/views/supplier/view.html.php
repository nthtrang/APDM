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
class apdmsuppliersViewsupplier extends JView
{
	function display($tpl = null)
	{
		global $mainframe, $option;
        
        $type = JRequest::getVar('type');
        $pns_id = JRequest::getVar('pns_id');
		$db				=& JFactory::getDBO();
		 $option =      'option=com_apdmsuppliers&task=get_supplier&tmpl=component';
         
		$filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order",		'filter_order',		's.info_name',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",	'filter_order_Dir',	'',			'word' );
		
		
		$search				= $mainframe->getUserStateFromRequest( "$option.search",			'search', 			'',			'string' );
		$search				= JString::strtolower( $search );

		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
         $suppler_id = array();    
        if ($pns_id){
            $db->setQuery("SELECT supplier_id FROM apdm_pns_supplier WHERE pns_id=".$pns_id." AND type_id=".$type);
            $row_exits = $db->loadObjectList();
           
            if (count($row_exits) > 0){
                foreach ($row_exits as $e){
                    $suppler_id[] = $e->supplier_id;
                }
            }
            
        }
		$where = array();
		$where[] = 's.info_deleted = 0';
        $where[] = 's.info_activate = 1';  
        $where[] = 's.info_type = '.$type; 
        if (count($suppler_id) > 0){
             $where[] = 's.info_id NOT IN ('.implode(",", $suppler_id).') '; 
        }
		if (isset( $search ) && $search!= '')
		{
			$searchEscaped = $db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$where[] = 's.info_name LIKE '.$searchEscaped.' OR s.info_address LIKE '.$searchEscaped.' OR s.info_telfax LIKE '.$searchEscaped.' OR s.info_website LIKE '.$searchEscaped.' OR s.info_contactperson LIKE '.$searchEscaped.' OR s.info_email LIKE'.$searchEscaped.' OR s.info_description LIKE '.$searchEscaped ;
		}	
		
		$orderby = ' ORDER BY '. $filter_order .' '. $filter_order_Dir;
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );

		$query = 'SELECT COUNT(s.info_id)'
		. ' FROM apdm_supplier_info AS s'
		. $filter
		. $where
		;
		
		$db->setQuery( $query );
		$total = $db->loadResult();

		jimport('joomla.html.pagination');
		$pagination = new JPagination( $total, $limitstart, $limit );

		$query = 'SELECT s.* '
			. ' FROM apdm_supplier_info AS s'
			. $filter
			. $where			
			. $orderby
		;
		//echo $query;
		$lists['query'] = base64_encode($query);
		$lists['total_record'] = $total;
		
		$db->setQuery( $query, $pagination->limitstart, $pagination->limit );
		$rows = $db->loadObjectList();
        
		// table ordering
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;
        $lists['type']        = $type; 
        $lists['pns_id']        = $pns_id; 
	                                   
		
		// search filter
		$lists['search']= $search;	
		$this->assignRef('lists',		$lists);
		$this->assignRef('items',		$rows);
		$this->assignRef('pagination',	$pagination);

		parent::display($tpl);
	}
}