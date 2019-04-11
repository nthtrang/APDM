<?php
/**
* Display list ECO when ajax request
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
ini_set('display_errors', 0);

class  SToViewgetso extends JView
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
        $where[] = 'so.so_state not in ("onhold","cancel")';
		if (isset( $search ) && $search!= '')
		{
            $arr_code = explode("-", trim($search));
            $searchEscaped = $db->Quote( '%'.$db->getEscaped( $arr_code[1], true ).'%', false );
			$where[] = 'so.so_cuscode LIKE '.$searchEscaped.' and so.customer_id = "'.$arr_code[0].'"';
		}	    
		

		$orderby = ' ORDER BY '. $filter_order .' '. $filter_order_Dir;
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
        //select wo.pns_wo_id,wo.wo_code, so.so_cuscode,so.customer_id as ccs_so_code,ccs.ccs_coordinator,ccs.ccs_name,ccs.ccs_code from apdm_pns_wo wo left join apdm_pns_so so on so.pns_so_id=wo.so_id left join apdm_ccs ccs on so.customer_id = ccs.ccs_code where wo.pns_wo_id = 77
        $query = 'SELECT count(*)'
            . ' from apdm_pns_so so left join apdm_ccs ccs on so.customer_id = ccs.ccs_code '
		    . $where
		;

		$db->setQuery( $query );
		$total = $db->loadResult();

		jimport('joomla.html.pagination');
		$pagination = new JPagination( $total, $limitstart, $limit );

		$query = 'SELECT  so.pns_so_id,so.so_cuscode,so.customer_id as ccs_so_code,ccs.ccs_coordinator,ccs.ccs_name,ccs.ccs_code '
			. ' from apdm_pns_so so left join apdm_ccs ccs on so.customer_id = ccs.ccs_code '
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