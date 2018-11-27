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
class pnsViewstos extends JView
{
	function display($tpl = null)
	{
                
	   // global $mainframe, $option;
        global $mainframe, $option;
        $option             = 'com_apdmpns_sto';
        $db                =& JFactory::getDBO();
        $cid		= JRequest::getVar( 'cid', array(0), '', 'array' );       
        $sto_id		= JRequest::getVar( 'id');       
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
            $where[] = 'p.sto_code LIKE '.$searchEscaped.' or p.sto_description LIKE '.$searchEscaped.'';        
           
        }  
      
        $where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
        $orderby = ' ORDER BY p.pns_sto_id desc';        
        
        $query = 'SELECT COUNT(p.pns_sto_id)'
        . ' FROM apdm_pns_sto AS p'
        . $where
        ;
       //echo $query;
        $db->setQuery( $query );
        $total = $db->loadResult();

        jimport('joomla.html.pagination');
        $pagination = new JPagination( $total, $limitstart, $limit );
        
        $query = 'SELECT p.* '
            . ' FROM apdm_pns_sto AS p'
            . $where
            . $orderby;
        $lists['query'] = base64_encode($query);   
        $lists['total_record'] = $total; 
        $db->setQuery( $query, $pagination->limitstart, $pagination->limit );
        $rows = $db->loadObjectList(); 
        
        
        $db->setQuery("SELECT sto.*, CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns AS p LEFT JOIN apdm_pns_sto AS sto on p.pns_id = sto.pns_id WHERE p.pns_deleted =0 AND sto.pns_id=".$cid[0]." order by sto.pns_rev_id desc limit 1");              
        $list_stos = $db->loadObjectList();              
        $lists['pns_id']        = $cid[0];       
        $this->assignRef('stos',        $list_stos);
        
//         $db->setQuery("SELECT po.*, CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns_po AS po LEFT JOIN apdm_pns AS p on po.pns_id = p.pns_id");
//         $pos_list = $db->loadObjectList();         
//         $this->assignRef('pos_list',        $pos_list);     
        //for PO detailid

         $db->setQuery("SELECT fk.id,fk.qty,fk.location,fk.partstate, p.pns_description,p.pns_cpn,p.pns_id,p.pns_stock,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns_sto AS sto inner JOIN apdm_pns_sto_fk fk on sto.pns_sto_id = fk.sto_id inner join apdm_pns AS p on p.pns_id = fk.pns_id where sto.pns_sto_id=".$sto_id." group by fk.pns_id order by fk.pns_id desc");
         $pns_list = $db->loadObjectList();         
         $this->assignRef('sto_pn_list',        $pns_list);
         $db->setQuery("SELECT sto.*,fk.id,fk.qty,fk.location,fk.partstate, p.pns_description,p.pns_cpn,p.pns_id,p.pns_stock,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns_sto AS sto inner JOIN apdm_pns_sto_fk fk on sto.pns_sto_id = fk.sto_id inner join apdm_pns AS p on p.pns_id = fk.pns_id where sto.pns_sto_id=".$sto_id." order by fk.pns_id desc");
         $pns_list2 = $db->loadObjectList();                  
         $this->assignRef('sto_pn_list2',        $pns_list2);
         
         $db->setQuery("SELECT * from apdm_pns_sto where pns_sto_id=".$sto_id);
         $sto_row =  $db->loadObject();
         $this->assignRef('sto_row',        $sto_row);
        $lists['search']= $search;    
        $this->assignRef('lists',        $lists);
        $this->assignRef('stos_list',        $rows);
        $this->assignRef('pagination',    $pagination);    
		parent::display($tpl);
	}
}

