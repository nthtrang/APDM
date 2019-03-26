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
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
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
class pnsViewgetpnstoolbom extends JView
{
	function display($tpl = null)
	{
	    global $mainframe, $option;
        
        $db                =& JFactory::getDBO();
        $option             = 'com_apdmsto&task=get_list_child';
        $id               = JRequest::getVar('id');
        
        $filter_order        = $mainframe->getUserStateFromRequest( "$option.filter_order",        'filter_order',        'p.pns_id',    'cmd' );        
        $filter_order_Dir    = $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",    'filter_order_Dir',    'desc',       'word' );      
        
        $filter_status    = $mainframe->getUserStateFromRequest( "$option.filter_status",    'filter_status',     '',    'string' );
        $filter_type      = $mainframe->getUserStateFromRequest( "$option.filter_type",    'filter_type',     '',    'string' );
        
        $filter_created_by    = $mainframe->getUserStateFromRequest( "$option.filter_created_by",    'filter_created_by',     0,    'int' );
        $filter_modified_by    = $mainframe->getUserStateFromRequest( "$option.filter_modified_by",    'filter_modified_by',     0,    'int' ); 
        
        $search                = $mainframe->getUserStateFromRequest( "$option.text_search", 'text_search', '','string' );
        $keyword                = $search;
        $search                = JString::strtolower( $search );
        
        $type_filter   = $mainframe->getUserStateFromRequest("$option.type_filter", 'type_filter', 0, 'int');
        
        $limit        = $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
        $limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
        
        
        $where = array();  
        $where[] = 'p.ccs_code = "206" ';//and po_id = 0
        
        if ($filter_status !=''){
            $where[]='p.pns_status ="'.$filter_status.'"';
        }
        
        if ($filter_type !=''){
            $where[]='p.pns_type ="'.$filter_type.'"';            
        }
        if($filter_created_by){
            $where[] = 'p.pns_create_by ='.$filter_created_by;          
        }
        if($filter_modified_by){
            $where[] = 'p.pns_modified_by ='.$filter_modified_by;
        }
		
       if (isset( $search ) && $search!= '')
        {
            $searchEscaped = $db->Quote( '%'.$db->getEscaped( $search, false ).'%', false );
           
        }
       
        if ($type_filter){           
            switch($type_filter){
               case '9': //Manufacture
                    $arr_tool_id = array();
                    $db->setQuery('select fk.pns_id from apdm_pns_sto_fk fk inner join apdm_pns_location apl on fk.location = apl.pns_location_id inner join apdm_pns_sto aps on fk.sto_id = aps.pns_sto_id and sto_type = 1 inner join apdm_pns p on fk.pns_id = p.pns_id and p.ccs_code = "206" AND ( apl.location_code LIKE '.$searchEscaped.' OR apl.location_description LIKE '.$searchEscaped.')');                    
                    $rs_mf = $db->loadObjectList();
                    if (count($rs_mf) > 0){
                        foreach ($rs_mf as $mf){
                            $arr_tool_id[] = $mf->pns_id;
                        }
                        $arr_tool_id = array_unique($arr_tool_id);
                        $where[] = 'p.pns_id IN ('.implode(',', $arr_tool_id).')';
                    }
                    
                break;
                case '7': //Manufacture PN                         
                    $arr_mf_id = array();
                         //echo 'SELECT * FROM apdm_supplier_info ASI LEFT JOIN apdm_pns_supplier APS ON ASI.info_id = APS.supplier_id WHERE ASI.info_deleted=0 AND ASI.info_type =4 AND (APS.supplier_info LIKE '.$searchEscaped.'OR ASI.info_description LIKE '.$searchEscaped.' ) group by ASI.info_id';
                    $db->setQuery('SELECT * FROM apdm_supplier_info ASI LEFT JOIN apdm_pns_supplier APS ON ASI.info_id = APS.supplier_id WHERE ASI.info_deleted=0 AND ASI.info_type =4 AND APS.supplier_info LIKE '.$searchEscaped.' group by ASI.info_id');
                   // echo $db->getQuery();
                    $rs_mf = $db->loadObjectList();                   
                    if (count($rs_mf) > 0){
                        foreach ($rs_mf as $mf){
                           $arr_mf_id[] = $mf->info_id;
                        }
                        $arr_mf_id = array_unique($arr_mf_id);                       
                    }else{
                        $arr_mf_id[] = -1;
                    }                     
                    break;                
                
                case '5': //for code
                    $leght = strlen (trim($keyword));                    
                    if($leght==10){
                         $arr_code = explode("-", trim($keyword));
                         $where[] = 'p.ccs_code ="'.$arr_code[0].'" AND p.pns_code like "%'.$arr_code[1].'%"';
                         
                   }else{  
                           if($keyword)
                           {
                                 $arr_code = explode("-", trim($keyword));
                                 $where[] = 'p.ccs_code LIKE "%'.$arr_code[0].'%" and p.pns_code like "%'.$arr_code[1] .'-'.$arr_code[2].'%" and p.pns_revision LIKE "%'.$arr_code[3].'%"';
                                 //$where[] = 'p.pns_code LIKE '.$searchEscaped.' OR p.pns_revision LIKE '.$searchEscaped. ' OR p.ccs_code LIKE '.$searchEscaped;    
                           }
                     
                   }          
                break;
            }
            
        }
        
         if(count($arr_mf_id) > 0){
            //get list pns have this supplier
            $pns_id_mf = array();
            $db->setQuery("SELECT pns_id FROM apdm_pns_supplier WHERE type_id = 4 AND supplier_id IN (".implode(",",$arr_mf_id).")");
            $rs_ps_mf = $db->loadObjectList();
            if(count($rs_ps_mf) > 0){
                foreach ($rs_ps_mf as $obj){
                    $pns_id_mf[] = $obj->pns_id;        
                }
               $pns_id_mf = array_unique($pns_id_mf);
                $where[] = 'p.pns_id IN ('.implode(',', $pns_id_mf).')';
            }else{
                $where[] = 'p.pns_id IN (0)';
            }           
            
        }
            
        $orderby = ' ORDER BY '. $filter_order .' '. $filter_order_Dir;
        $where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
        //$where = ( count( $where ) ? ' WHERE p.pns_deleted = 0 and (' . implode( ') or (', $where ) . ')' : '' );
                
//        $query = "SELECT  COUNT(p.pns_id)  FROM apdm_pns_sto AS sto inner JOIN apdm_pns_sto_fk fk on sto.pns_sto_id = fk.sto_id  and sto.sto_type =1  inner join apdm_pns AS p on p.pns_id = fk.pns_id "
          $query = "SELECT COUNT(fk.id) FROM apdm_pns "
                        . $filter
                        . $where                                          
                        ." group by fk.id"
                        . $orderby ;
       //echo $query;
        $db->setQuery( $query );
        $total = $db->loadResult();

        jimport('joomla.html.pagination');
        $pagination = new JPagination( $total, $limitstart, $limit );
        
//        $query = 'SELECT p.* '
//            . ' FROM apdm_pns AS p'
//            . $filter
//            . $where            
//            . $orderby
//        ;
        
//        $query = "SELECT fk.id,fk.qty,fk.location,fk.partstate,p.pns_life_cycle,p.pns_uom, p.pns_description,p.pns_cpn,p.pns_id,p.pns_stock,p.ccs_code, p.pns_code, p.pns_revision,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns_sto AS sto inner JOIN apdm_pns_sto_fk fk on sto.pns_sto_id = fk.sto_id  and sto.sto_type =1  inner join apdm_pns AS p on p.pns_id = fk.pns_id "
//                        . $filter
//                        . $where                                          
//                        ." group by fk.pns_id"
//                        . $orderby ;
         
          $query = "SELECT p.pns_life_cycle, p.pns_description,p.pns_cpn,p.pns_id,p.pns_stock,p.ccs_code, p.pns_code, p.pns_revision,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM  apdm_pns AS p "
                        . $filter
                        . $where                                                                  
                        . $orderby ;
//         $db->setQuery( $query2 );
//         $pns_list2 = $db->loadObjectList();                  
//         $this->assignRef('sto_pn_list2',        $pns_list2);
        
        
        $lists['query'] = base64_encode($query);   
        $lists['total_record'] = $total; 
        $db->setQuery( $query, $pagination->limitstart, $pagination->limit );
        $rows = $db->loadObjectList(); 
         ///get information for filter
          
             ///Cerated by
        $db->setQuery("SELECT p.pns_create_by as value, u.name as text FROM apdm_pns as p LEFT JOIN jos_users as u ON u.id=p.pns_create_by WHERE p.pns_deleted=0  GROUP BY p.pns_create_by ORDER BY text "); 
        $create_by[] = JHTML::_('select.option', 0, JText::_('SELECT_CREATED_BY'), 'value', 'text');
        $create_bys = array_merge($create_by, $db->loadObjectList());
        $lists['pns_create_by'] = JHTML::_('select.genericlist', $create_bys, 'filter_created_by', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $filter_created_by );
        
        //Modified by
        $db->setQuery("SELECT p.pns_modified_by as value, u.name as text FROM apdm_pns as p LEFT JOIN jos_users as u ON u.id=p.pns_modified_by WHERE p.pns_deleted=0 AND p.pns_modified_by !=0  GROUP BY p.pns_modified_by ORDER BY text ");        
        $modified[] = JHTML::_('select.option', 0, JText::_('SELECT_MODIFIED_BY'), 'value', 'text');
        $modifieds = array_merge($modified, $db->loadObjectList());
        
        $lists['pns_modified_by'] = JHTML::_('select.genericlist', $modifieds, 'filter_modified_by', 'class="inputbox" size="1"  onchange="document.adminForm.submit( );"', 'value', 'text', $filter_modified_by );
        //for list filter type
       //$type[] = JHTML::_('select.option', 0, JText::_('SELECT_TYPE_TO_FILTER'), 'value', 'text');
        $type[] = JHTML::_('select.option', 5, JText::_('Part Number'), 'value', 'text');
        $type[] = JHTML::_('select.option', 7, JText::_('MFG PN'), 'value', 'text');
        $type[] = JHTML::_('select.option', 9, JText::_('Tool ID'), 'value', 'text');
        //$type[] = JHTML::_('select.option', 2, JText::_('Vendor'), 'value', 'text');
        //$type[] = JHTML::_('select.option', 3, JText::_('Supplier'), 'value', 'text');
        //$type[] = JHTML::_('select.option', 4, JText::_('Manufacture'), 'value', 'text');
        $lists['type_filter'] = JHTML::_('select.genericlist', $type, 'type_filter', 'class="inputbox" size="1"', 'value', 'text', $type_filter);
        
        $db->setQuery("SELECT pns_status from apdm_pns WHERE pns_id=".$id);                    
        $this->assignRef('pns_status',$db->loadResult());
      

         
        // table ordering
        $lists['order_Dir']    = $filter_order_Dir;
        $lists['order']        = $filter_order;
        $lists['search']= $search;    
        $this->assignRef('lists',        $lists);
        $this->assignRef('rows',        $rows);
        $this->assignRef('pagination',    $pagination);   
        $this->assignRef('id',    $id);       
		parent::display($tpl);
	}
}

