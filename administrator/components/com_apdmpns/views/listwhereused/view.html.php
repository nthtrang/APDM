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
ini_set('display_errors', 0);
jimport( 'joomla.application.component.view');

/**
 * HTML View class for the Users component
 *
 * @static
 * @package		Joomla
 * @subpackage	Users
 * @since 1.0
 */
class pnsViewlistwhereused extends JView
{
	function display($tpl = null)
	{
	    global $mainframe, $option;
        
        $db                =& JFactory::getDBO();
        $option             = 'com_apdmpns&task=list_where_used';
        $id               = JRequest::getVar('id');        
        $whereused = JRequest::getVar('task');         
        $filter_order        = $mainframe->getUserStateFromRequest( "$option.filter_order",        'filter_order',        'p.pns_id',    'cmd' );        
        $filter_order_Dir    = $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",    'filter_order_Dir',    'desc',       'word' );      
        
        $filter_status    = $mainframe->getUserStateFromRequest( "$option.filter_status",    'filter_status',     '',    'string' );
        $filter_type      = $mainframe->getUserStateFromRequest( "$option.filter_type",    'filter_type',     '',    'string' );      
        
        $search                = $mainframe->getUserStateFromRequest( "$option.text_search", 'text_search', '','string' );
        $keyword                = $search;
        $search                = JString::strtolower( $search );
        
        $type_filter   = $mainframe->getUserStateFromRequest("$option.type_filter", 'type_filter', 0, 'int');
        
        $limit        = $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
        $limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
        
        
        $where = array();  
        $arrPNsChild = array();
        
        
        if ($filter_status !=''){
            $where[]='p.pns_status ="'.$filter_status.'"';
        }
        
        if ($filter_type !=''){
            $where[]='p.pns_type ="'.$filter_type.'"';            
        }
       $query = "SELECT pns_parent from apdm_pns_parents where pns_id=".$id;    
       			
       $db->setQuery($query);
       $rows = $db->loadObjectList();
       if (count($rows) > 0){
            foreach ($rows as $row){
                $arrPNsChild[] = $row->pns_parent;
            }
       }
       if (count( $arrPNsChild ) > 0)   {
           	$where[] = 'p.pns_id IN ('.implode(",", $arrPNsChild ).') ';
		}
       
       if (isset( $search ) && $search!= '')
        {
            $searchEscaped = $db->Quote( '%'.$db->getEscaped( $search, false ).'%', false );
           
        }
        if ($type_filter){           
            switch($type_filter){
                  case '6': //for information of pns
                    $where[] = 'p.pns_description LIKE '.$searchEscaped;
                  break;
                    case '5': //for code
                    $leght = strlen (trim($keyword));                    
                 if ($leght==16){                                                                        
                       $arr_code = explode("-", trim($keyword));                                                         
                       $db->setQuery("SELECT pns_id FROM apdm_pns WHERE ccs_code=".$arr_code[0]." AND pns_code='".$arr_code[1].'-'.$arr_code[2]."' AND pns_revision='".$arr_code[3]."'");
                       $rs_pns = $db->loadObjectList();
                       $array_pns_id_find = array();
                       if (count($rs_pns) > 0){
                           foreach ($rs_pns as $pn){
                               $array_pns_id_find[] = $pn->pns_id;
                           }
                         
                       }else{
                           $array_pns_id_find[] =0;
                       }
                       $where[] = 'p.pns_id IN ('.implode(",", $array_pns_id_find).') ';
                   }elseif ($leght==13){                       
                       $arr_code = explode("-", trim($keyword));                         
                       $db->setQuery("SELECT pns_id FROM apdm_pns WHERE  ccs_code=".$arr_code[0]." AND pns_code='".$arr_code[1].'-'.$arr_code[2]."'");
                       $rs_pns = $db->loadObjectList();                       
                       if (count($rs_pns) > 1){
                           foreach ($rs_pns as $obj) {
                                $arr_pns_id[] =  $obj->pns_id;
                           }            
                           $where[] = 'p.pns_id IN ('.implode(',', $arr_pns_id).')'; 
                       }else{
                            if(strlen($arr_code[0])==6){
                                 $where[] = 'p.pns_code='.$arr_code[0].'-'.$arr_code[1].' AND p.pns_revision='.$arr_code[2];
                            }else{
                                 $where[] = 'p.pns_id IN (0)';
                            }
                       }
                        
                   }elseif($leght==10){
                         $arr_code = explode("-", trim($keyword));
                         $where[] = 'p.ccs_code ='.$arr_code[0].' AND p.pns_code='.$arr_code[1];
                         
                   }else{      
                     $where[] = 'p.pns_code LIKE '.$searchEscaped.' OR p.pns_revision LIKE '.$searchEscaped. ' OR p.ccs_code LIKE '.$searchEscaped;    
                   }             
                break;
            }
        }

        $orderby = ' ORDER BY '. $filter_order .' '. $filter_order_Dir;
        $where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
        
        $query = 'SELECT COUNT(p.pns_id)'
        . ' FROM apdm_pns AS p'
        . $filter
        . $where
        ;
       //echo $query;
        $db->setQuery( $query );
        $total = $db->loadResult();

        jimport('joomla.html.pagination');
        $pagination = new JPagination( $total, $limitstart, $limit );
      
        if($whereused=="whereused")
        {
              
             $query = 'SELECT p.* '
            . ' FROM apdm_pns AS p'
            . $filter
            . $where            
            . $orderby
                ;              
              $query  =  $where != ""? $query :"";
        }
        else
        {
               
                 $where  = count( $where )? ' where p.pns_deleted = 0 ' . $where:"";
             $query = 'SELECT p.* '
            . ' FROM apdm_pns AS p'
            . $filter
            . $where            
            . $orderby
                ; 
        }
                
        
        $db->setQuery( $query, $pagination->limitstart, $pagination->limit );
        $rows = $db->loadObjectList();        
        //for list filter type
       //$type[] = JHTML::_('select.option', 0, JText::_('SELECT_TYPE_TO_FILTER'), 'value', 'text');
        $type[] = JHTML::_('select.option', 5, JText::_('PN'), 'value', 'text');
        $type[] = JHTML::_('select.option', 6, JText::_('Description'), 'value', 'text');
        $type[] = JHTML::_('select.option', 1, JText::_('ECO'), 'value', 'text');
        $type[] = JHTML::_('select.option', 7, JText::_('MFG PN'), 'value', 'text');
        //$type[] = JHTML::_('select.option', 2, JText::_('Vendor'), 'value', 'text');
        //$type[] = JHTML::_('select.option', 3, JText::_('Supplier'), 'value', 'text');
        //$type[] = JHTML::_('select.option', 4, JText::_('Manufacture'), 'value', 'text');
        $lists['type_filter'] = JHTML::_('select.genericlist', $type, 'type_filter', 'class="inputbox" size="1"', 'value', 'text', $type_filter);
        
        //title where used
        $query = "SELECT p.*, CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS pns_code_full  FROM apdm_pns AS p  WHERE p.pns_id=".$id." ORDER BY p.ccs_code";    
      
        $db->setQuery( $query);
        $rowstitle = $db->loadObjectList();              
        $this->assignRef('title',        $rowstitle);        
        
        //get parent
        $row = & JTable::getInstance('apdmpns');
        $row->load($id);   
        $this->assignRef('row',        $row); 
        //get REV history
         $query = "SELECT parent_id FROM apdm_pns_rev WHERE pns_id='".$id."'";
         $db->setQuery( $query);
        $parent_id = $db->loadResult();   
        
       //echo $query = "SELECT * FROM apdm_pns_rev WHERE parent_id='".$parent_id."' or  pns_id = ".$row->pns_id;
        $query = "SELECT * FROM apdm_pns_rev_history WHERE  pns_id = ".$row->pns_id;

       $db->setQuery($query);
       $rowsHistory = $db->loadObjectList();
       $this->assignRef('rows_history',        $rowsHistory);     
      
        
        // table ordering
        $lists['order_Dir']    = $filter_order_Dir;
        $lists['order']        = $filter_order;
        $lists['search']= $search;    
        $lists['pns_id']        = $id;    
        $this->assignRef('lists',        $lists);
        $this->assignRef('rows',        $rows);     
        $this->assignRef('pagination',    $pagination);   
        $this->assignRef('id',    $id);       
	parent::display($tpl);
	}
}

