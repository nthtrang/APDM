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
class TToViewitto extends JView
{
	function display($tpl = null)
	{
                
	   // global $mainframe, $option;
        global $mainframe, $option;
        $option             = 'com_apdmpns_tto';
        $db                =& JFactory::getDBO();
        $cid		= JRequest::getVar( 'cid', array(0), '', 'array' );       
        $tto_id		= JRequest::getVar( 'id');       
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
            $where[] = 'p.tto_code LIKE '.$searchEscaped.' or p.tto_description LIKE '.$searchEscaped.'';        
           
        }  
      
        $where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
        $orderby = ' ORDER BY p.pns_tto_id desc';        
        
        $query = 'SELECT COUNT(p.pns_tto_id)'
        . ' FROM apdm_pns_tto AS p'
        . $where
        ;
       //echo $query;
        $db->setQuery( $query );
        $total = $db->loadResult();

        jimport('joomla.html.pagination');
        $pagination = new JPagination( $total, $limitstart, $limit );
        
        $query = 'SELECT p.* '
            . ' FROM apdm_pns_tto AS p'
            . $where
            . $orderby;
        $lists['query'] = base64_encode($query);   
        $lists['total_record'] = $total; 
        $db->setQuery( $query, $pagination->limitstart, $pagination->limit );
        $rows = $db->loadObjectList(); 
        
        $db->setQuery("select tto.*,wo.wo_code from apdm_pns_tto tto left join apdm_pns_wo wo on tto.tto_wo_id = wo.pns_wo_id  where tto.pns_tto_id =".$tto_id);

        $tto_row =  $db->loadObject();

        $db->setQuery("SELECT * FROM jos_users jos inner join apdm_users apd on jos.id = apd.user_id  WHERE user_enable=0 ORDER BY jos.username ");
	$list_user = $db->loadObjectList();	

         $db->setQuery("SELECT fk.id,fk.qty,fk.location,fk.partstate,fk.tto_type_inout,p.pns_uom, p.pns_description,p.pns_cpn,p.pns_id,p.pns_stock,p.ccs_code, p.pns_code, p.pns_revision,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns_tto AS tto inner JOIN apdm_pns_tto_fk fk on tto.pns_tto_id = fk.tto_id inner join apdm_pns AS p on p.pns_id = fk.pns_id where tto.pns_tto_id=".$tto_id." group by fk.pns_id order by fk.pns_id desc");
         $pns_list = $db->loadObjectList();         
         $this->assignRef('tto_pn_list',        $pns_list);
         $db->setQuery("SELECT tto.*,fk.id,fk.qty,fk.location,fk.partstate,fk.qty_from,fk.location_from,fk.tto_type_inout , p.pns_description,p.pns_cpn,p.pns_id,p.pns_stock,p.ccs_code, p.pns_code, p.pns_revision,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns_tto AS tto inner JOIN apdm_pns_tto_fk fk on tto.pns_tto_id = fk.tto_id inner join apdm_pns AS p on p.pns_id = fk.pns_id where tto.pns_tto_id=".$tto_id." order by fk.pns_id desc");
         $pns_list2 = $db->loadObjectList();                  
         $this->assignRef('tto_pn_list2',        $pns_list2);
          
         
        $this->assignRef('tto_row',        $tto_row);	
        $lists['search']= $search;    
        $this->assignRef('lists',        $lists);
        $this->assignRef('ttos_list',        $rows);
        $this->assignRef('pagination',    $pagination);  
        $this->assignRef('list_user',	$list_user);
		parent::display($tpl);
	}
}

