<?php
/**
* @version		$Id: view.html.php 10496 2008-07-03 07:08:39Z ircmaxell $
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
class recylebinViewpns extends JView
{
	function display($tpl = null)
	{
		 global $mainframe, $option;

        $db                =& JFactory::getDBO();
        $option             = 'com_apdmrecylebin&task=pns';
       
        $filter_order        = $mainframe->getUserStateFromRequest( "$option.filter_order",        'filter_order',        'p.pns_id',    'cmd' );        
        $filter_order_Dir    = $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",    'filter_order_Dir',    'desc',       'word' );      
        
        $search                = $mainframe->getUserStateFromRequest( "$option.search", 'search', '','string' );
        $keyword                = $search;
        $search                = JString::strtolower( $search );
        
        $limit        = $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
        $limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
        
        
        $where = array();  
        $where[] = 'p.pns_deleted = 1';        
        
       if (isset( $search ) && $search!= '')
        {
          
            $searchEscaped = $db->Quote( '%'.$db->getEscaped( $search, false ).'%', false );
            $where[] = ' CONCAT_WS( "-", p.ccs_code, p.pns_code, p.pns_revision ) LIKE '.$searchEscaped.' OR p.pns_description LIKE '.$searchEscaped; 
           
        }
        $orderby = ' ORDER BY '. $filter_order .' '. $filter_order_Dir;
        $where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
        
        $query = 'SELECT COUNT(p.pns_id)'
        . ' FROM apdm_pns AS p'
        . ' LEFT JOIN apdm_ccs AS c ON c.ccs_id = p.ccs_id '
        . $filter
        . $where
        ;
       
        $db->setQuery( $query );
        $total = $db->loadResult();
        jimport('joomla.html.pagination');
        $pagination = new JPagination( $total, $limitstart, $limit );
        
        $query = 'SELECT p.*, e.eco_name, CONCAT_WS( "-", p.ccs_code, p.pns_code, p.pns_revision ) AS pns_full_code '
                . ' FROM apdm_pns AS p '                
                . ' LEFT JOIN apdm_eco AS e ON e.eco_id = p.eco_id '
                . $filter
                . $where            
                . $orderby
        ;
        $db->setQuery( $query, $pagination->limitstart, $pagination->limit );
        $rows = $db->loadObjectList(); 
        
         // table ordering
        $lists['order_Dir']    = $filter_order_Dir;
        $lists['order']        = $filter_order;
        $lists['search']= $search;    
        $this->assignRef('lists',        $lists);
        $this->assignRef('rows',        $rows);
        $this->assignRef('pagination',    $pagination); 
		parent::display($tpl);
	}
}
