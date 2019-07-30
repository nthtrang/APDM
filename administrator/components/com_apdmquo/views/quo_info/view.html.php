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
        $task		= JRequest::getVar( 'quo_detail');       
        $me 		= JFactory::getUser();                        
        $db->setQuery('select quotation_id from apdm_quotation where  quotation_id = "'.$quo_id.'"');                
        $result = $db->loadResult();
        if(!$result && $task =="quo_detail")
        {
                $msg .= "Quotation does not exist!";                
                $app =& JFactory::getApplication();
                $app->redirect('index.php?option=com_apdmquo',$msg);
        }
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
        
        $db->setQuery("SELECT * from apdm_quotation where quotation_id=".$quo_id);         
         $quo_row =  $db->loadObject();

        
         
        //for PN list
                $db->setQuery("SELECT fk.*,p.pns_uom,p.pns_cpn, p.pns_description,p.pns_cpn,p.pns_id,p.pns_stock,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code,p.ccs_code, p.pns_code, p.pns_revision  FROM apdm_quotation AS quo inner JOIN apdm_quotation_pn_fk fk on quo.quotation_id = fk.quotation_id inner join apdm_pns AS p on p.pns_id = fk.pns_id where quo.quotation_id=" . $quo_id);
                $pns_list = $db->loadObjectList();
                $this->assignRef('quo_pn_list', $pns_list);

 //get formtemplate
                $db->setQuery("SELECT * from apdm_quotation_template where id = 1");
                $template_row = $db->loadObject();
                $this->assignRef('template_row', $template_row);
   
         //Customer
                $cccpn[0] = JHTML::_('select.option', 0, '- ' . JText::_('SELECT_CCS') . ' -', 'value', 'text');
                $db->setQuery("SELECT  ccs_code  as value, CONCAT_WS(' :: ', ccs_code, ccs_name) as text FROM apdm_ccs WHERE ccs_deleted=0 AND ccs_activate= 1 and ccs_cpn = 1 ORDER BY ccs_code ");
                $ccscpn = array_merge($cccpn, $db->loadObjectList());
                $lists['ccscpn'] = JHTML::_('select.genericlist', $ccscpn, 'customer_id', 'class="inputbox" size="1" onchange="getccsCoordinator(this.value)"', 'value', 'text', $quo_row->customer_id);

        $this->assignRef('quo_row',        $quo_row);

        $lists['search']= $search;    
        $this->assignRef('lists',        $lists);
        $this->assignRef('stos_list',        $rows);
        $this->assignRef('pagination',    $pagination);  
        $this->assignRef('list_user',	$list_user);
		parent::display($tpl);
	}
}

