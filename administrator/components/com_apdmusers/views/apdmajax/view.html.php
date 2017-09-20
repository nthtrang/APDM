<?php

/**
* HTML View class for the Apdm user  request by ajax.
* @package		APDM
* @subpackage	APDM Users
*/
// 
defined('_JEXEC') or die( 'Restricted access' );
ini_set('display_errors', 0);
jimport( 'joomla.application.component.view');


class apdmusersViewapdmajax extends JView
{
	function display($tpl = null)
	{
		global $mainframe, $option;

		$db				=& JFactory::getDBO();
		$cids 	= JRequest::getVar( 'cid', array(), '', 'array' );
		$where = array();
		$where[] = 'a.user_id IN('.implode(",", $cids).')';
		$where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );

		$query = 'SELECT a.*, u.email '
				. ' FROM apdm_users AS a LEFT JOIN jos_users AS u ON u.id=a.user_id'						
				. $where
				
		;	

		$db->setQuery( $query );
		$rows = $db->loadObjectList();			
		$this->assignRef('items',		$rows);
		parent::display($tpl);
	}
}