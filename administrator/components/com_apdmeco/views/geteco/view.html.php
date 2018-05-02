<?php
/**
* Display list ECO when ajax request
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
ini_set('display_errors', 0);

class ecoViewgeteco extends JView
{
	function display($tpl = null)
	{
		global $mainframe, $option;

		$db				=& JFactory::getDBO();
        $filter_order        = $mainframe->getUserStateFromRequest( "$option.filter_order",        'filter_order',        'e.eco_name',    'cmd' );
        $filter_order_Dir    = $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",    'filter_order_Dir',    '',            'word' );
        
		$search				= $mainframe->getUserStateFromRequest( "$option.search",			'search', 			'',			'string' );
		$search				= JString::strtolower( $search );

		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );

		$where = array();
		$where[] = 'e.eco_deleted = 0';
        $where[] = 'e.eco_activate = 1'; 
		if (isset( $search ) && $search!= '')
		{
			$searchEscaped = $db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$where[] = 'e.eco_name LIKE '.$searchEscaped.'  OR e.eco_description LIKE '.$searchEscaped;
		}	    
		

		$orderby = ' ORDER BY '. $filter_order .' '. $filter_order_Dir;
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );

		$query = 'SELECT COUNT(e.eco_id)'
		. ' FROM apdm_eco AS e'
		. $filter
		. $where
		;

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
		
		$db->setQuery( $query, $pagination->limitstart, $pagination->limit );
		$rows = $db->loadObjectList();
                $db->setQuery("SELECT pns_status from apdm_pns WHERE pns_id=".$id);                    
                $this->assignRef('pns_status',$db->loadResult());

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