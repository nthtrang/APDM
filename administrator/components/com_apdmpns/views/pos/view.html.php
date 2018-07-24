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
class pnsViewpos extends JView
{
	function display($tpl = null)
	{
                
	   // global $mainframe, $option;
        global $mainframe, $option;
        $option             = 'com_apdmpns';
        $db                =& JFactory::getDBO();
        $cid		= JRequest::getVar( 'cid', array(0), '', 'array' );       
        $po_id		= JRequest::getVar( 'id');       
        $me 		= JFactory::getUser();
        JArrayHelper::toInteger($cid, array(0));	       
         $search                = $mainframe->getUserStateFromRequest( "$option.text_search", 'text_search', '','string' );
        $keyword                = $search;
        $search                = JString::strtolower( $search );
        $limit        = $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
        $limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
        $where = array();      
        if (isset( $search ) && $search!= '')
        {
            $searchEscaped = $db->Quote( '%'.$db->getEscaped( $search, false ).'%', false );
            $where[] = 'p.po_code LIKE '.$searchEscaped.' or p.po_description LIKE '.$searchEscaped.'';        
           
        }  
      
        $where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
        
        $query = 'SELECT COUNT(p.pns_po_id)'
        . ' FROM apdm_pns_po AS p'
        . $where
        ;
       //echo $query;
        $db->setQuery( $query );
        $total = $db->loadResult();

        jimport('joomla.html.pagination');
        $pagination = new JPagination( $total, $limitstart, $limit );
        
        $query = 'SELECT p.* '
            . ' FROM apdm_pns_po AS p'
            . $where;
        $lists['query'] = base64_encode($query);   
        $lists['total_record'] = $total; 
        $db->setQuery( $query, $pagination->limitstart, $pagination->limit );
        $rows = $db->loadObjectList(); 
        
        
        $db->setQuery("SELECT po.*, CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns AS p LEFT JOIN apdm_pns_po AS po on p.pns_id = po.pns_id WHERE p.pns_deleted =0 AND po.pns_id=".$cid[0]." order by po.pns_rev_id desc limit 1");              
        $list_pos = $db->loadObjectList();              
        $lists['pns_id']        = $cid[0];       
        $this->assignRef('pos',        $list_pos);
        
//         $db->setQuery("SELECT po.*, CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns_po AS po LEFT JOIN apdm_pns AS p on po.pns_id = p.pns_id");
//         $pos_list = $db->loadObjectList();         
//         $this->assignRef('pos_list',        $pos_list);     
        //for PO detailid
         $db->setQuery("SELECT po.*,fk.id,fk.qty, p.pns_description,p.pns_cpn,p.pns_id,p.pns_stock,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns_po AS po inner JOIN apdm_pns_po_fk fk on po.pns_po_id = fk.po_id inner join apdm_pns AS p on p.pns_id = fk.pns_id where po.pns_po_id=".$po_id);
         $pns_list = $db->loadObjectList();         
         $this->assignRef('po_pn_list',        $pns_list);     
         
         $db->setQuery("SELECT * from apdm_pns_po where pns_po_id=".$po_id);
         $po_row =  $db->loadObject();
         $this->assignRef('po_row',        $po_row);
        $lists['search']= $search;    
        $this->assignRef('lists',        $lists);
        $this->assignRef('pos_list',        $rows);
        $this->assignRef('pagination',    $pagination);    
		parent::display($tpl);
	}
}

