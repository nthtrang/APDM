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
class historyViewhistory extends JView
{
	function display($tpl = null)
	{
		global $mainframe, $option;

		$db				=& JFactory::getDBO();
		

		$filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order",		'filter_order',		'h.history_date',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",	'filter_order_Dir',	'',			'word' );
		$filter_user		= $mainframe->getUserStateFromRequest( "$option.filter_user",		'filter_user', 		0,			'int' );
		$filter_com		    = $mainframe->getUserStateFromRequest( "$option.filter_com",		'filter_com', 		0,			'int' );
		
		

		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );

		$where = array();
		
		if ( $filter_user )
		{
			$where[] = 'h.user_id = '.$filter_user;
		}
		
		if ($filter_com){
			$where[] = 'h.history_where = '.$filter_com;
		}
        
		$orderby = ' ORDER BY '. $filter_order .' '. $filter_order_Dir;
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );

		$query = 'SELECT COUNT(h.history_id)'
		. ' FROM apdm_user_history AS h'
		. $filter
		. $where
		;
		$db->setQuery( $query );
		$total = $db->loadResult();

		jimport('joomla.html.pagination');
		$pagination = new JPagination( $total, $limitstart, $limit );

		$query = 'SELECT h.*, u.username,  u.id, c.component_name '
				. ' FROM apdm_user_history as h '
				. ' LEFT JOIN #__users as u ON u.id = h.user_id '
                . ' LEFT JOIN apdm_component AS c ON c.component_id=h.history_where'
				. $filter
				. $where
				. $orderby
		;	
		//  echo $query;
		$db->setQuery( $query, $pagination->limitstart, $pagination->limit );
		$rows = $db->loadObjectList();		
		
		$com[] 		    = JHTML::_('select.option',  '0', '- '. JText::_( 'HISTORY_SELECT_COMPONENT' ) .' -', 'value', 'text' );
        $db->setQuery("Select component_id as value, component_name as text from apdm_component order by component_name");
        $coms = array_merge($com, $db->loadObjectList());		
		$lists['com'] 	= JHTML::_('select.genericlist',   $coms, 'filter_com', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', "$filter_com" );
			
		//get list created by
		$created[] = JHTML::_('select.option', 0, '- '.JText::_('HISTORY_SELECT_USER').' -', 'value', 'text');
		$db->setQuery("SELECT h.user_id as value, u.username  as text FROM apdm_user_history as h LEFT JOIN jos_users as u ON u.id=h.user_id WHERE u.block = 0 GROUP BY h.user_id ");
		$creates  = array_merge($created, $db->loadObjectList());
		$lists['users'] = JHTML::_('select.genericlist', $creates, 'filter_user', 'class="inputbox" size="1" onchange="document.adminForm.submit();"', 'value', 'text', $filter_user);
		// table ordering
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;
		
		
		$this->assignRef('lists',		$lists);
		$this->assignRef('items',		$rows);
		$this->assignRef('pagination',	$pagination);

		parent::display($tpl);
	}
}