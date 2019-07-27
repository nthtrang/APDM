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
#ini_set('display_errors', 1);
#ini_set('display_startup_errors', 1);

jimport( 'joomla.application.component.view');
include_once (JPATH_BASE .DS.'includes'.DS.'PHP-Barcode-111'.DS.'barcode.php');
/**
 * HTML View class for the Users component
 *
 * @static
 * @package		Joomla
 * @subpackage	Users
 * @since 1.0
 */
class QUOViewquo_info extends JView
{
	function display($tpl = null)
	{
                
	   // global $mainframe, $option;
        global $mainframe, $option;
        $option             = 'com_apdmpns_sto';
        $db                =& JFactory::getDBO();
        $cid		= JRequest::getVar( 'cid', array(0), '', 'array' );       
        $quo_id		= JRequest::getVar( 'id');       
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
        
        $db->setQuery("SELECT pns_sto_id,sto_code,sto_po_internal,sto_description,sto_state,sto_created,sto_create_by,sto_completed_date,sto_type,sto_owner,sto_stocker,sto_supplier_id,sto_owner_confirm  from apdm_pns_sto where pns_sto_id=".$quo_id);         
         $sto_row =  $db->loadObject();

        
         
        //for PO detailid
                $db->setQuery("SELECT fk.*,p.pns_uom,p.pns_cpn, p.pns_description,p.pns_cpn,p.pns_id,p.pns_stock,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code,p.ccs_code, p.pns_code, p.pns_revision  FROM apdm_pns_so AS so inner JOIN apdm_pns_so_fk fk on so.pns_so_id = fk.so_id inner join apdm_pns AS p on p.pns_id = fk.pns_id where so.pns_so_id=" . $quo_id);
                $pns_list = $db->loadObjectList();
                $this->assignRef('so_pn_list', $pns_list);

                $db->setQuery("SELECT so.*,so.customer_id as ccs_so_code,max(date(wo.wo_completed_date)) as max_wo_completed,ccs.ccs_coordinator,ccs.ccs_code from apdm_pns_so so inner join apdm_pns_wo wo on so.pns_so_id=wo.so_id left join apdm_ccs ccs on so.customer_id = ccs.ccs_code where so.pns_so_id=" . $quo_id);
                $so_row = $db->loadObject();
                $this->assignRef('so_row', $so_row);
   
 
         //Customer
                $cccpn[0] = JHTML::_('select.option', 0, '- ' . JText::_('SELECT_CCS') . ' -', 'value', 'text');
                $db->setQuery("SELECT  ccs_code  as value, CONCAT_WS(' :: ', ccs_code, ccs_name) as text FROM apdm_ccs WHERE ccs_deleted=0 AND ccs_activate= 1 and ccs_cpn = 1 ORDER BY ccs_code ");
                $ccscpn = array_merge($cccpn, $db->loadObjectList());
                $lists['ccscpn'] = JHTML::_('select.genericlist', $ccscpn, 'customer_id', 'class="inputbox" size="1" onchange="getccsCoordinator(this.value)"', 'value', 'text', $so_row->customer_id);

        $this->assignRef('sto_row',        $sto_row);
        $lists['zips_files'] = $zips_files;
        $lists['image_files'] = $images_files;
        $lists['pdf_files'] = $pdf_files;		
        $lists['search']= $search;    
        $this->assignRef('lists',        $lists);
        $this->assignRef('stos_list',        $rows);
        $this->assignRef('pagination',    $pagination);  
        $this->assignRef('list_user',	$list_user);
		parent::display($tpl);
	}
}

