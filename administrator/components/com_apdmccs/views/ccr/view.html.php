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
class CCsViewccr extends JView
{
	function display($tpl = null)
	{
		global $mainframe, $option;

		$db				=& JFactory::getDBO();		
		$option				= 'com_apdmccs&task=trash';
		$filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order",	'filter_order',	'c.ccs_code','cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",	'filter_order_Dir',	'',	'word' );
		$filter_type		= $mainframe->getUserStateFromRequest( "$option.filter_type", 'filter_type', '', 'string' );
		$filter_created_by	= $mainframe->getUserStateFromRequest( "$option.filter_created_by",	'filter_created_by', 0,	'int' );
		$search				= $mainframe->getUserStateFromRequest( "$option.search", 'search', '', 'string' );
		$search				= JString::strtolower( $search );

		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );

		$where = array();
		$where[] = ' c.ccs_deleted=1'.$filter_type;
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
		
		$orderby = ' ORDER BY '. $filter_order .' '. $filter_order_Dir;
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );

		$query = 'SELECT COUNT(c.ccs_id)'
		. ' FROM apdm_ccs AS c'
		. $filter
		. $where
		;
		$db->setQuery( $query );
		$total = $db->loadResult();

		jimport('joomla.html.pagination');
		$pagination = new JPagination( $total, $limitstart, $limit );
		$query	= "SELECT c.*, u.username FROM apdm_ccs as c LEFT JOIN #__users as u ON u.id=c.ccs_create_by "
			. $filter
			. $where
			. $orderby
		;

		$db->setQuery( $query, $pagination->limitstart, $pagination->limit );
		$rows = $db->loadObjectList();
		// get list of Status for dropdown filter
		$active[] = JHTML::_('select.option',  '', '- '. JText::_( 'Select Status' ) .' -');
		$active[] = JHTML::_('select.option',  0, JText::_( 'ACTIVE' ) );
		$active[] = JHTML::_('select.option',  1, JText::_( 'INACTIVE' ) );		
		$lists['active'] = JHTML::_('select.genericlist',   $active, 'filter_type', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', "$filter_type" );
		// Get list of Create By for dropdown filter
		$create[] = JHTML::_('select.option', 0, '- '.JText::_('Select Create By').' -');
		$db->setQuery("select c.ccs_create_by as value, u.username as text FROM apdm_ccs as c LEFT JOIN #__users as u ON u.id=c.ccs_create_by GROUP BY ccs_create_by");
		$creates  = array_merge($create, $db->loadObjectList());
		$lists['create'] = JHTML::_('select.genericlist',   $creates, 'filter_created_by', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', "$filter_created_by" );
		// table ordering
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;

		// search filter
		$lists['search']= $search;

		$this->assignRef('lists',		$lists);
		$this->assignRef('items',		$rows);
		$this->assignRef('pagination',	$pagination);

		parent::display($tpl);
	}
}