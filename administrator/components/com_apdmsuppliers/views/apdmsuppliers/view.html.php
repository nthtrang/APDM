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
class apdmsuppliersViewapdmsuppliers extends JView
{
	function display($tpl = null)
	{
		global $mainframe, $option;

		$db				=& JFactory::getDBO();
		
		$filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order",		'filter_order',		's.info_name',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",	'filter_order_Dir',	'',			'word' );
		$filter_activate	= $mainframe->getUserStateFromRequest( "$option.filter_activate",	'filter_activate', 	'',	'string' );
		
		$filter_date_modified = $mainframe->getUserStateFromRequest("$option.filter_date_modified", 'filter_date_modified', '', 'string');
		$filter_date_created = $mainframe->getUserStateFromRequest("$option.filter_date_created", 'filter_date_created', '', 'string');
		$filter_created_by = $mainframe->getUserStateFromRequest("$option.filter_created_by", 'filter_created_by', 0, 'int');
		$filter_modified_by = $mainframe->getUserStateFromRequest("$option.filter_modified_by", 'filter_modified_by', 0, 'int');
		
		$search				= $mainframe->getUserStateFromRequest( "$option.search",			'search', 			'',			'string' );
		$search				= JString::strtolower( $search );

		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );

		$where = array();
		$where[] = 's.info_deleted = 0';
		if (isset( $search ) && $search!= '')
		{
			$searchEscaped = $db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$where[] = 's.info_name LIKE '.$searchEscaped.' OR s.info_address LIKE '.$searchEscaped.' OR s.info_telfax LIKE '.$searchEscaped.' OR s.info_website LIKE '.$searchEscaped.' OR s.info_contactperson LIKE '.$searchEscaped.' OR s.info_email LIKE'.$searchEscaped.' OR s.info_description LIKE '.$searchEscaped ;
		}	
		if ( $filter_activate !='')
		{
			$where[] = 's.info_activate = '.$filter_activate;
		}		
		
		if ($filter_date_modified !=''){
			$date_array_modified = explode('-',$filter_date_modified);			
			$where[] = 'DATE(s.info_modified) = \''.$date_array_modified[2].'-'.$date_array_modified[0].'-'.$date_array_modified[1].'\'';
		}
		if ($filter_date_created !=''){
			$date_array_create = explode('-',$filter_date_created);			
			$where[] = 'DATE(s.info_create) = \''.$date_array_create[2].'-'.$date_array_create[0].'-'.$date_array_create[1].'\'';
		}
		
		if ($filter_modified_by){
			$where[] = 's.info_modified_by='.$filter_modified_by;
		}
		
		if ($filter_created_by){
			$where[] = 's.info_created_by='.$filter_created_by;
		}
		

		$orderby = ' ORDER BY '. $filter_order .' '. $filter_order_Dir;
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );

		$query = 'SELECT COUNT(s.info_id)'
		. ' FROM apdm_supplier_info AS s'
		. $filter
		. $where
		;
		//echo $query;
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

		$active[] = JHTML::_('select.option',  '', '- '. JText::_( 'Select Status' ) .' -');
		$active[] = JHTML::_('select.option',  0, JText::_( 'ACTIVE' ) );
		$active[] = JHTML::_('select.option',  1, JText::_( 'INACTIVE' ) );		
		$lists['active'] = JHTML::_('select.genericlist',   $active, 'filter_activate', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', "$filter_activate" );
		
		$create[] = JHTML::_('select.option', 0, '- '.JText::_('FILTER_CREATE_BY').' -');
		$db->setQuery("select c.info_created_by as value, u.name as text FROM apdm_supplier_info as c LEFT JOIN #__users as u ON u.id=c.info_created_by GROUP BY info_created_by");
		$creates  = array_merge($create, $db->loadObjectList());
		$lists['create'] = JHTML::_('select.genericlist',   $creates, 'filter_created_by', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', "$filter_created_by" );
		
		$modified_by[] = JHTML::_('select.option', 0, '- '.JText::_('FILTER_MODIFIED_BY').' -');
		$db->setQuery("select c.info_modified_by as value, u.name as text FROM apdm_supplier_info as c LEFT JOIN #__users as u ON u.id=c.info_modified_by WHERE c.info_modified_by!= 0 GROUP BY info_modified_by");
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