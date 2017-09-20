<?php
/**
* HTML View class for the Apdm user list request by ajax.
* @package		APDM
* @subpackage	APDM Users
*/
// 
defined('_JEXEC') or die( 'Restricted access' );
ini_set('display_errors', 0);
jimport( 'joomla.application.component.view');


class apdmusersViewapdmlist extends JView
{
	function display($tpl = null)
	{
		global $mainframe, $option;

		$db				=& JFactory::getDBO();
		$currentUser	=& JFactory::getUser();
		$acl			=& JFactory::getACL();

		$filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order",		'filter_order',		'u.name',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",	'filter_order_Dir',	'',			'word' );
		$filter_type		= $mainframe->getUserStateFromRequest( "$option.filter_type",		'filter_type', 		0,			'string' );
		$filter_role		= $mainframe->getUserStateFromRequest( "$option.filter_role",		'filter_role', 		0,			'int' );
		$filter_block		= $mainframe->getUserStateFromRequest( "$option.filter_block",		'filter_block', 	'-1',			'int' );
		$filter_created_by	= $mainframe->getUserStateFromRequest("$option.filter_created_by", 'filter_created_by', 0, 'int');
		$filter_date_created= $mainframe->getUserStateFromRequest( "$option.filter_date_created", 'filter_date_created','','string' );
		$search				= $mainframe->getUserStateFromRequest( "$option.search",'search', '','string' );
		$search				= JString::strtolower( $search );

		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
	
		
		$where = array();
		$where[] = 'a.user_enable =0 ';
		if (isset( $search ) && $search!= '')
		{
			$searchEscaped = $db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$where[] = 'a.username LIKE '.$searchEscaped.' OR a.user_title LIKE '.$searchEscaped.' OR a.user_lastname LIKE '.$searchEscaped.' OR a.user_firstname LIKE '.$searchEscaped.' OR u.name like '.$searchEscaped;
		}
		if ( $filter_type )
		{
			$where[] = 'a.user_group = '.$filter_type;
		}
		if ( $filter_block !='-1' )
		{
			$where[] = 'a.user_enable = '.$filter_block;
		}
		if ($filter_created_by){
			$where[] = 'a.user_create_by = '.$filter_created_by;
		}
		if ($filter_date_created != ''){
			$arr_date = explode('-', $filter_date_created);
			$where[] = 'DATE(a.user_create) = \''.$arr_date[2].'-'.$arr_date[0].'-'.$arr_date[1].'\'';
		}
		if ( $filter_role )
		{
		
			$db->setQuery("SELECT user_id FROM apdm_role_user WHERE role_id=".$filter_role." GROUP BY user_id ");
			$result = $db->loadObjectList();			
			if (count($result)> 0){
				$arrUserId = array();
				foreach ($result as $obj){
					$arrUserId[] = $obj->user_id;
				}
				$where[] = 'a.user_id IN('.implode(",", $arrUserId).')';
			}	
			
		}
		


		$orderby = ' ORDER BY '. $filter_order .' '. $filter_order_Dir;
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );

		$query = 'SELECT COUNT(a.user_id)'
		. ' FROM apdm_users AS a'
		. $filter
		. $where
		;
		$db->setQuery( $query );
		$total = $db->loadResult();

		jimport('joomla.html.pagination');
		$pagination = new JPagination( $total, $limitstart, $limit );

		$query = 'SELECT a.*, u.email, u.name, u.id, u.lastvisitDate '
				. ' FROM apdm_users AS a'
				. ' INNER JOIN #__users as u ON u.id = a.user_id '
				. $filter
				. $where
				. $orderby
		;	
		
		$db->setQuery( $query, $pagination->limitstart, $pagination->limit );
		$rows = $db->loadObjectList();		
		
		$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_( 'SELECT_GROUP' ) .' -' );
		$types[] 		= JHTML::_('select.option',  '23', '- '. JText::_( 'GROUP_USER' ) .' -' );
		$types[] 		= JHTML::_('select.option',  '24', '- '. JText::_( 'GROUP_ADMIN' ) .' -' );		
		
		$lists['type'] 	= JHTML::_('select.genericlist',   $types, 'filter_type', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', "$filter_type" );
		// get list of Log Status for dropdown filter
		$block[] = JHTML::_('select.option',  '-1', '- '. JText::_( 'SELECT_STATUS' ) .' -');
		$block[] = JHTML::_('select.option',  0, JText::_( 'ENABLE' ) );
		$block[] = JHTML::_('select.option',  1, JText::_( 'UNENABLE' ) );
		$lists['block'] = JHTML::_('select.genericlist',   $block, 'filter_block', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', "$filter_block" );
		//get list role of user
		$query_role = "SELECT ur.role_id as value, r.role_name as text
						FROM apdm_role_user AS ur
						LEFT JOIN apdm_role AS r ON r.role_id = ur.role_id
						GROUP BY value
						ORDER BY value
						";
	
		$db->setQuery($query_role);
		$role[] = JHTML::_('select.option', 0, '- '.JText::_('SELECT_ROLE').' -', 'value', 'text');
		$roles	= array_merge($role, $db->loadObjectList());
		$lists['role'] = JHTML::_('select.genericlist',   $roles, 'filter_role', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', "$filter_role" );
		
		//get list created by
		$created[] = JHTML::_('select.option', 0, '- '.JText::_('SELECT_CREATED_BY').' -', 'value', 'text');
		$db->setQuery("SELECT a.user_create_by as value, u.name as text FROM apdm_users as a LEFT JOIN jos_users as u ON u.id=a.user_create_by GROUP BY a.user_create_by ");
		$creates  = array_merge($created, $db->loadObjectList());
		$lists['created_by'] = JHTML::_('select.genericlist', $creates, 'filter_created_by', 'class="inputbox" size="1" onchange="document.adminForm.submit();"', 'value', 'text', $filter_created_by);
		// table ordering
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;
		$lists['filter_date_created'] = $filter_date_created;
		// search filter
		$lists['search']= $search;
		//print_r($rows);
		$this->assignRef('user',		JFactory::getUser());
		$this->assignRef('lists',		$lists);
		$this->assignRef('items',		$rows);
		$this->assignRef('pagination',	$pagination);

		parent::display($tpl);
	}
}