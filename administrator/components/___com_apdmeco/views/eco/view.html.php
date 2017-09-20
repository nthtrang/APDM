<?php
/**
* Display list list ECO
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
ini_set('display_errors', 0);
class ecoVieweco extends JView
{
	function display($tpl = null)
	{
		global $mainframe, $option;

		$db				=& JFactory::getDBO();
		
		$filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order",		'filter_order',		'e.eco_name',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",	'filter_order_Dir',	'',			'word' );
		$filter_activate	= $mainframe->getUserStateFromRequest( "$option.filter_activate",	'filter_activate', 	0,	'string' );
		
		$filter_date_modified = $mainframe->getUserStateFromRequest("$option.filter_date_modified", 'filter_date_modified', '', 'string');
		$filter_date_created = $mainframe->getUserStateFromRequest("$option.filter_date_created", 'filter_date_created', '', 'string');
		$filter_created_by = $mainframe->getUserStateFromRequest("$option.filter_created_by", 'filter_created_by', 0, 'int');
		$filter_modified_by = $mainframe->getUserStateFromRequest("$option.filter_modified_by", 'filter_modified_by', 0, 'int');
		
		$search				= $mainframe->getUserStateFromRequest( "$option.search",			'search', 			'',			'string' );
		$search				= JString::strtolower( $search );

		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );

		$where = array();
		$where[] = 'e.eco_deleted = 0';
		if (isset( $search ) && $search!= '')
		{
			$searchEscaped = $db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$where[] = 'e.eco_name LIKE '.$searchEscaped.' OR e.eco_description LIKE '.$searchEscaped;
		}	
		if ( $filter_activate !='')
		{
			$where[] = 'e.eco_activate = '.$filter_activate;
		}		
		
		if ($filter_date_modified !=''){
			$date_array_modified = explode('-',$filter_date_modified);			
			$where[] = 'DATE(e.eco_modified) = \''.$date_array_modified[2].'-'.$date_array_modified[0].'-'.$date_array_modified[1].'\'';
		}
		if ($filter_date_created !=''){
			$date_array_create = explode('-',$filter_date_created);			
			$where[] = 'DATE(e.eco_create) = \''.$date_array_create[2].'-'.$date_array_create[0].'-'.$date_array_create[1].'\'';
		}
		
		if ($filter_modified_by){
			$where[] = 'e.eco_modified_by='.$filter_modified_by;
		}
		
		if ($filter_created_by){
			$where[] = 'e.eco_create_by='.$filter_created_by;
		}
		

		$orderby = ' ORDER BY '. $filter_order .' '. $filter_order_Dir;
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );

		$query = 'SELECT COUNT(e.eco_id)'
		. ' FROM apdm_eco AS e'
		. $filter
		. $where
		;
		//echo $query;
		$db->setQuery( $query );
		$total = $db->loadResult();

		jimport('joomla.html.pagination');
		$pagination = new JPagination( $total, $limitstart, $limit );

		$query = 'SELECT e.* '
			. ' FROM apdm_eco AS e'
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
		$active[] = JHTML::_('select.option',  1, JText::_( 'ACTIVE' ) );
		$active[] = JHTML::_('select.option',  0, JText::_( 'INACTIVE' ) );		
		$lists['active'] = JHTML::_('select.genericlist',   $active, 'filter_activate', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', "$filter_activate" );
		
		$create[] = JHTML::_('select.option', 0, '- '.JText::_('FILTER_CREATE_BY').' -');
		$db->setQuery("select c.eco_create_by as value, u.name as text FROM apdm_eco as c LEFT JOIN #__users as u ON u.id=c.eco_create_by GROUP BY eco_create_by");
		$creates  = array_merge($create, $db->loadObjectList());
		$lists['create'] = JHTML::_('select.genericlist',   $creates, 'filter_created_by', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', "$filter_created_by" );
		
		$modified_by[] = JHTML::_('select.option', 0, '- '.JText::_('FILTER_MODIFIED_BY').' -');
		$db->setQuery("select c.eco_modified_by as value, u.name as text FROM apdm_eco as c LEFT JOIN #__users as u ON u.id=c.eco_modified_by WHERE c.eco_modified_by!= 0 GROUP BY eco_modified_by");
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