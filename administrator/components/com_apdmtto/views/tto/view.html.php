<?php
/**
* @version		$Id: view.html.php 10496 2008-07-03 07:08:39Z ircmaxell $
* @package		APDM
* @subpackage	PNS
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
class TToViewtto extends JView
{
	function display($tpl = null)
	{
                
	   // global $mainframe, $option;
        global $mainframe, $option;
        $option             = 'com_apdmtto_tto';
        $db                =& JFactory::getDBO();
        $cid		= JRequest::getVar( 'cid', array(0), '', 'array' );       
        $tto_id		= JRequest::getVar( 'id');
        
        
        JArrayHelper::toInteger($cid, array(0));	       
        $search                = $mainframe->getUserStateFromRequest( "$option.text_search", 'text_search', '','string' );
        $search                = JString::strtolower( $search );
        $limit        = $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
        $limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
        $where = array();      
      
        $where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
        $orderby = ' ORDER BY p.pns_tto_id desc';        
        
        $query = 'SELECT COUNT(p.pns_tto_id)'
        . ' FROM apdm_pns_tto AS p'
        . $where
        ;

        $db->setQuery( $query );
        $total = $db->loadResult();

        jimport('joomla.html.pagination');
        $pagination = new JPagination( $total, $limitstart, $limit );
        
        $query = 'SELECT p.*,DATEDIFF(p.tto_due_date, CURDATE()) + 1 as tto_remain '
            . ' FROM apdm_pns_tto AS p'
            . $where
            . $orderby;
        $lists['query'] = base64_encode($query);   
        $lists['total_record'] = $total; 
        $db->setQuery( $query, $pagination->limitstart, $pagination->limit );

        $rows = $db->loadObjectList(); 

        $lists['search']= $search;    
        $this->assignRef('lists',        $lists);
        $this->assignRef('ttos_list',        $rows);
        $this->assignRef('pagination',    $pagination);  

		parent::display($tpl);
	}
}

