<?php
/**
* @version		$Id: view.html.php 2009-01
* @package		APDM
* @subpackage	Roles
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the Roles component
 * 
 */
class RolesViewRoles extends JView
{
	function display($tpl = null)
	{
		global $mainframe, $option;

		$db				=& JFactory::getDBO();
		$currentUser	=& JFactory::getUser();
		$acl			=& JFactory::getACL();

		$filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order",		'filter_order',	'r.role_name',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",	'filter_order_Dir',	'',			'word' );		
		$filter_user		= $mainframe->getUserStateFromRequest( "$option.filter_user",		'filter_user', 	0,	'int' );
		$filter_modified_by	= $mainframe->getUserStateFromRequest( "$option.filter_modified_by", 'filter_modified_by',0,'int' );
		$filter_date_created= $mainframe->getUserStateFromRequest( "$option.filter_date_created", 'filter_date_created','','string' );
		$filter_date_modified= $mainframe->getUserStateFromRequest( "$option.filter_date_modified", 'filter_date_modified','','string' );
		
		$search				= $mainframe->getUserStateFromRequest( "$option.search",'search', 	'',	'string' );
		$search				= JString::strtolower( $search );

		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
		
		$where = array();
		if (isset( $search ) && $search!= '')
		{
			$searchEscaped = $db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$where[] = 'r.role_name LIKE '.$searchEscaped.' OR r.role_description LIKE '.$searchEscaped;
		}
		if ( $filter_user )
		{			
				$where[] = 'r.role_create_by = '.$filter_user;
			
		}
		if ( $filter_modified_by )
		{			
				$where[] = 'r.role_modified_by = '.$filter_modified_by;
			
		}
		if ($filter_date_created !=''){
			$date_created_array = explode("-", $filter_date_created);
		  $where[] = 'DATE(r.role_create) = \''.$date_created_array[2].'-'.$date_created_array[0].'-'.$date_created_array[1].'\'';
		  $value_date_create = $filter_date_created;
		}else{
			$value_date_create ='';
		}
		if ($filter_date_modified !=''){
			$date_modified_array = explode("-", $filter_date_modified);
			$where[] = 'DATE(r.role_modified) = \''.$date_modified_array[2].'-'.$date_modified_array[0].'-'.$date_modified_array[1].'\'';
		  $value_date_modified = $filter_date_modified;
		}else{
			$value_date_modified ='';
		}
		// exclude any child group id's for this user
	    $orderby = ' ORDER BY '. $filter_order .' '. $filter_order_Dir;
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );

		$query = 'SELECT COUNT(r.role_id)'
		. ' FROM apdm_role AS r'
		. $filter
		. $where
		;
		$db->setQuery( $query );
		$total = $db->loadResult();
		
		jimport('joomla.html.pagination');
		$pagination = new JPagination( $total, $limitstart, $limit );

		$query = 'SELECT r.*, u.username'
			. ' FROM  apdm_role AS r'
			. ' INNER JOIN jos_users AS u ON r.role_create_by = u.id'
			. $filter
			. $where			          
			. $orderby
		;
		//echo $query;
		$db->setQuery( $query, $pagination->limitstart, $pagination->limit );
		$rows = $db->loadObjectList();  
		$n = count( $rows );
		
        //get list user in the dropdown filter
        $query = "SELECT r.role_create_by as value, u.username as text FROM  apdm_role AS r INNER JOIN #__users AS u ON u.id=r.role_create_by GROUP BY r.role_create_by ORDER BY u.username ";		
		$db->setQuery( $query );
		$group[] 		= JHTML::_('select.option',  '0', '- '. JText::_( 'SELECT_CREATE_BY' ) .' -', 'value', 'text' );
		$groups         = array_merge($group, $db->loadObjectList());
		$lists['groups'] 	= JHTML::_('select.genericlist',   $groups, 'filter_user', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', "$filter_user" );
		//get list modified by 
		$query1	= "SELECT r.role_modified_by as value, u.username as text FROM  apdm_role AS r INNER JOIN #__users AS u ON u.id=r.role_modified_by GROUP BY r.role_modified_by ORDER BY u.username ";	
		$db->setQuery( $query1 );
		$group1[] 		= JHTML::_('select.option',  '0', '- '. JText::_( 'SELECT_MODIFIED_BY' ) .' -', 'value', 'text' );
		$groups1         = array_merge($group1, $db->loadObjectList());
		$lists['modified_by'] 	= JHTML::_('select.genericlist',   $groups1, 'filter_modified_by', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', "$filter_modified_by" );
		// table ordering
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;

		// search filter
		$lists['search']= $search;
		$lists['filter_date_created']= $value_date_create;
		$lists['filter_date_modified']= $value_date_modified;

		//$this->assignRef('user',		JFactory::getUser());
		$this->assignRef('lists',		$lists);
		$this->assignRef('items',		$rows);
		$this->assignRef('pagination',	$pagination);

		parent::display($tpl);
	}
}