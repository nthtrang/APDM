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
class SToVieweto extends JView
{
	function display($tpl = null)
	{
		global $mainframe, $option;

		$db				=& JFactory::getDBO();		

		$filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order",	'filter_order',	'c.ccs_code','cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",	'filter_order_Dir',	'',	'word' );
		$filter_type		= $mainframe->getUserStateFromRequest( "$option.filter_type", 'filter_type', '', 'string' );
		$filter_created_by	= $mainframe->getUserStateFromRequest( "$option.filter_created_by",	'filter_created_by', 0,	'int' );
		$filter_modified_by	= $mainframe->getUserStateFromRequest( "$option.filter_modified_by", 'filter_modified_by', 0, 'int' );
		$search				= $mainframe->getUserStateFromRequest( "$option.search", 'search', '', 'string' );
		$search				= JString::strtolower( $search );
		
		$filter_date_created = $mainframe->getUserStateFromRequest("$option.filter_date_created", 'filter_date_created', '', 'string');
		$filter_date_modified = $mainframe->getUserStateFromRequest("$option.filter_date_modified", 'filter_date_modified', '', 'string');

		

		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );

		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );

		$where = array();
		$where[] = ' c.ccs_deleted=0';
		if (isset( $search ) && $search!= '')
		{
			$searchEscaped = $db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$where[] = 'c.ccs_code LIKE '.$searchEscaped.' OR c.ccs_description LIKE '.$searchEscaped;
		}
		if ( $filter_type !='')
		{
			$where[] = ' c.ccs_activate='.$filter_type;
		}
		if ( $filter_created_by )
		{
			$where[] = 'c.ccs_create_by ='.$filter_created_by;
		}
		if ( $filter_modified_by )
		{
			$where[] = 'c.ccs_modified_by ='.$filter_modified_by;
		}
		if ($filter_date_created !=''){
			$date_array_created = explode('-',$filter_date_created);			
			$where[] = 'DATE(c.ccs_create) = \''.$date_array_created[2].'-'.$date_array_created[0].'-'.$date_array_created[1].'\'';
		}
		if ($filter_date_modified !=''){
			$date_array_modified = explode('-',$filter_date_modified);			
			$where[] = 'DATE(c.ccs_modified) = \''.$date_array_modified[2].'-'.$date_array_modified[0].'-'.$date_array_modified[1].'\'';
		}
		$orderby = ' ORDER BY '. $filter_order .' '. $filter_order_Dir;
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );

		$query = 'SELECT COUNT(c.ccs_id)'
		. ' FROM apdm_ccs AS c'
		. $filter
		. $where
		;
		//echo $query;
		$db->setQuery( $query );
		$total = $db->loadResult();

		jimport('joomla.html.pagination');
		$pagination = new JPagination( $total, $limitstart, $limit );
		$query	= "SELECT c.*, u.username FROM apdm_ccs as c LEFT JOIN #__users as u ON u.id=c.ccs_create_by "
			. $filter
			. $where
			. $orderby
		;
		//echo $query;
		$lists['query'] = base64_encode($query);
		$lists['total_record'] = $total;
		$db->setQuery( $query, $pagination->limitstart, $pagination->limit );
		$rows = $db->loadObjectList();

		// get list of Status for dropdown filter
		$active[] = JHTML::_('select.option',  '', '- '. JText::_( 'Select Status' ) .' -');
		$active[] = JHTML::_('select.option',  0, JText::_( 'INACTIVE' ) );
		$active[] = JHTML::_('select.option',  1, JText::_( 'ACTIVE' ) );		
		$lists['active'] = JHTML::_('select.genericlist',   $active, 'filter_type', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', "$filter_type" );
		// Get list of Create By for dropdown filter
		$create[] = JHTML::_('select.option', 0, '- '.JText::_('FILTER_CREATE_BY').' -');
		$db->setQuery("select c.ccs_create_by as value, u.name as text FROM apdm_ccs as c LEFT JOIN #__users as u ON u.id=c.ccs_create_by GROUP BY ccs_create_by");
		$creates  = array_merge($create, $db->loadObjectList());
		$lists['create'] = JHTML::_('select.genericlist',   $creates, 'filter_created_by', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', "$filter_created_by" );
		
		$modified_by[] = JHTML::_('select.option', 0, '- '.JText::_('FILTER_MODIFIED_BY').' -');
		$db->setQuery("select c.ccs_modified_by as value, u.name as text FROM apdm_ccs as c LEFT JOIN #__users as u ON u.id=c.ccs_modified_by WHERE c.ccs_modified_by!= 0 GROUP BY ccs_modified_by");
		$modified_bys  = array_merge($modified_by, $db->loadObjectList());
		$lists['modified'] = JHTML::_('select.genericlist',   $modified_bys, 'filter_modified_by', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', "$filter_modified_by" );
		// table ordering
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;
		$lists['filter_date_created'] = $filter_date_created;
		$lists['filter_date_modified'] = $filter_date_modified;
		// search filter
		$lists['search']= $search;

		$this->assignRef('lists',		$lists);
		$this->assignRef('items',		$rows);
		$this->assignRef('pagination',	$pagination);

		parent::display($tpl);
	}
}