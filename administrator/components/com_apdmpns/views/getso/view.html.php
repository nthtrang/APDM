<?php
/**
* Display list ECO when ajax request
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
ini_set('display_errors', 0);

class  pnsViewgetso extends JView
{
	function display($tpl = null)
	{
		global $mainframe, $option;

		$db				=& JFactory::getDBO();
                $filter_order        = $mainframe->getUserStateFromRequest( "$option.filter_order",        'filter_order',        'so.so_cuscode',    'cmd' );
                $filter_order_Dir    = $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",    'filter_order_Dir',    '',            'word' );
        
		$search				= $mainframe->getUserStateFromRequest( "$option.search",			'search', 			'',			'string' );
		$search				= JString::strtolower( $search );

		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );

		$where = array();
                $where[] = 'so.so_state not in ("done","cancel")';
		if (isset( $search ) && $search!= '')
		{
                        $search1 = explode("-", $search);
			$searchEscaped = $db->Quote( '%'.$db->getEscaped( $search1[1], true ).'%', false );
                        $searchEscaped2 = $db->Quote( '%'.$db->getEscaped( $search1[1], true ).'%', false );
			$where[] = 'so.so_cuscode LIKE '.$searchEscaped.'  OR so.so_cuscode LIKE '.$searchEscaped2.' or so.customer_id LIKE '.$searchEscaped.'  OR so.customer_id LIKE '.$searchEscaped2;
		}	    
		

		$orderby = ' ORDER BY '. $filter_order .' '. $filter_order_Dir;
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );

		$query = 'SELECT COUNT(so.pns_so_id)'
		. ' FROM apdm_pns_so AS so'
                .'  inner join apdm_ccs ccs on so.customer_id = ccs.ccs_code '
		. $filter
		. $where
		;

		$db->setQuery( $query );
		$total = $db->loadResult();

		jimport('joomla.html.pagination');
		$pagination = new JPagination( $total, $limitstart, $limit );

		$query = 'SELECT so.*,ccs.ccs_coordinator,ccs.ccs_code '
			. ' FROM apdm_pns_so AS so'
                        .'  inner join apdm_ccs ccs on so.customer_id = ccs.ccs_code '
			. $filter
			. $where			
			. $orderby
		;
		
		$db->setQuery( $query, $pagination->limitstart, $pagination->limit );
		$rows = $db->loadObjectList();
                
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