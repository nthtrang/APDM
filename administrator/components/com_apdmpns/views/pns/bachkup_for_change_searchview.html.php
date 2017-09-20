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
class pnsViewpns extends JView
{
	function display($tpl = null)
	{
	    global $mainframe, $option;
        
        $db                =& JFactory::getDBO();
        $option             = 'com_apdmpns';
       
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
        $where[] = 'p.pns_deleted = 0';
        
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
                case '1': //ECO
                    $arr_eco_id = array();
                    //select table ECO with keyword input     
                    $db->setQuery('SELECT eco_id FROM apdm_eco WHERE eco_deleted= 0 AND (eco_name LIKE '.$searchEscaped.' OR  eco_description LIKE '.$searchEscaped .' )');
                    $rs_eco = $db->loadObjectList();
                    if (count($rs_eco) >0){
                        foreach ($rs_eco as $eco){
                           $arr_eco_id[] = $eco->eco_id; 
                        }
                        
                    }else{
                        $arr_eco_id[] = -1;
                    }
                break;
                case '2': //Vendor
                    $arr_vendor_id = array();
                    $db->setQuery('SELECT info_id FROM apdm_supplier_info WHERE info_deleted=0 AND info_type =2 AND ( info_name LIKE '.$searchEscaped.' OR info_address LIKE '.$searchEscaped.' OR info_telfax LIKE '.$searchEscaped.' OR info_website LIKE '.$searchEscaped.' OR info_contactperson LIKE '.$searchEscaped.' OR info_email LIKE '.$searchEscaped.' OR info_description LIKE '.$searchEscaped.' )');
                    $rs_vendor = $db->loadObjectList();
                    if (count($rs_vendor) > 0){
                        foreach ($rs_vendor as $vendor){
                            $arr_vendor_id[] = $vendor->info_id;
                        }
                    }else{
                        $arr_vendor_id[] =-1;
                    }
                break;
                 case '3': //Supplier
                    $arr_supplier_id = array();
                    $db->setQuery('SELECT info_id FROM apdm_supplier_info WHERE info_deleted=0 AND info_type =3 AND ( info_name LIKE '.$searchEscaped.' OR info_address LIKE '.$searchEscaped.' OR info_telfax LIKE '.$searchEscaped.' OR info_website LIKE '.$searchEscaped.' OR info_contactperson LIKE '.$searchEscaped.' OR info_email LIKE '.$searchEscaped.' OR info_description LIKE '.$searchEscaped.' )');
                    $rs_supplier = $db->loadObjectList();
                    if (count($rs_supplier) > 0){
                        foreach ($rs_supplier as $supplier){
                            $arr_supplier_id[] = $supplier->info_id;
                        }
                    }else{
                        $arr_supplier_id[] = -1;
                    }
                break;
                 case '4': //Manufacture
                    $arr_mf_id = array();
                    $db->setQuery('SELECT info_id FROM apdm_supplier_info WHERE info_deleted=0 AND info_type =4 AND ( info_name LIKE '.$searchEscaped.' OR info_address LIKE '.$searchEscaped.' OR info_telfax LIKE '.$searchEscaped.' OR info_website LIKE '.$searchEscaped.' OR info_contactperson LIKE '.$searchEscaped.' OR info_email LIKE '.$searchEscaped.' OR info_description LIKE '.$searchEscaped.' )');
                    $rs_mf = $db->loadObjectList();
                    if (count($rs_mf) > 0){
                        foreach ($rs_mf as $mf){
                            $arr_mf_id[] = $mf->info_id;
                        }
                    }else{
                        $arr_mf_id[] = -1;
                    }
                break;
                case '6': //for information of pns
                    $where[] = 'p.pns_description LIKE '.$searchEscaped;
                break;
                case '5': //for code
                  //  echo $search; exit;
                   $leght = strlen (trim($keyword));       
                   if ($leght==17){
                     
                       $arr_code = explode("-", trim($keyword));                        //get ccd
                       $db->setQuery("SELECT ccs_id FROM apdm_ccs WHERE ccs_code='".$arr_code[0]."'");
                       $ccs_id = $db->loadResult();   
                      // echo "SELECT pns_id FROM apdm_pns WHERE ccs_id=".$ccs_id." AND pns_code='".$arr_code[1].'-'.$arr_code[2]."' AND pns_revision=".$arr_code[3];
                      // exit;                  
                       $db->setQuery("SELECT pns_id FROM apdm_pns WHERE ccs_id=".$ccs_id." AND pns_code='".$arr_code[1].'-'.$arr_code[2]."' AND pns_revision='".$arr_code[3]."'");
                       $rs_pns = $db->loadObjectList();
                       if (count($rs_pns) > 0){
                           // echo 'OK'.$rs_pns[0]->pns_id;
                          $mainframe->redirect('index.php?option=com_apdmpns&task=listpns&id='.$rs_pns[0]->pns_id);
                           exit;
                       }else{
                          // e0cho 'KO co ';
                           $mainframe->redirect('index.php?option=com_apdmpns&task=listpnsempty');
                           exit;
                       }
                   }elseif ($leght==13){
                       $arr_code = explode("-", trim($keyword));  
                       
                        //get ccs_id
                       $db->setQuery("SELECT ccs_id FROM apdm_ccs WHERE ccs_code='".$arr_code[0]."'");
                       $ccs_id = $db->loadResult();
                      // echo "SELECT pns_id FROM apdm_pns WHERE ccs_id=".$ccs_id." AND pns_code='".$arr_code[1].'-'.$arr_code[2]."'"; exit;
                       $db->setQuery("SELECT pns_id FROM apdm_pns WHERE pns_revision='' AND ccs_id=".$ccs_id." AND pns_code='".$arr_code[1].'-'.$arr_code[2]."'");
                       $rs_pns = $db->loadObjectList();
                      // echo "SELECT pns_id FROM apdm_pns WHERE ccs_id=".$ccs_id." AND pns_code='".$arr_code[1].'-'.$arr_code[2];
                     
                       if (count($rs_pns) > 1){
                           foreach ($rs_pns as $obj) {
                                $arr_pns_id[] =  $obj->pns_id;
                           }
                           $where[] = 'p.pns_id IN ('.implode(',', $arr_pns_id).')'; 
                       }elseif(count($rs_pns==1)){
                          $mainframe->redirect('index.php?option=com_apdmpns&task=listpns&id='.$rs_pns[0]->pns_id);
                         
                          // echo 'OK1'.$rs_pns[0]->pns_id;    
                           exit;  
                       }else{
                            // echo 'o co';
                           $mainframe->redirect('index.php?option=com_apdmpns&task=listpnsempty');
                           exit;
                       }
                       
                   }else{
                       $where[] = 'p.pns_code LIKE '.$searchEscaped;
                   }
                   
                break;
            }
            
        }
        
        if(count($arr_vendor_id) > 0){           
            //get list pns have this vendor
            $pns_id_vendor = array();
            $db->setQuery("SELECT pns_id FROM apdm_pns_supplier WHERE type_id = 2 AND supplier_id IN (".implode(",",$arr_vendor_id).") ");
            $rs_ps_vd = $db->loadObjectList();
            if(count($rs_ps_vd) > 0){
                foreach ($rs_ps_vd as $obj){
                    $pns_id_vendor[] = $obj->pns_id;        
                }
                $pns_id_vendor =array_unique($pns_id_vendor);     
                $where[] = 'p.pns_id IN ('.implode(',', $pns_id_vendor).')';
            }else{
                $where[] = 'p.pns_id IN (0)';
            }              
        }
       if(count($arr_supplier_id) > 0){
            //get list pns have this supplier
            $pns_id_sp = array();
            $db->setQuery("SELECT pns_id FROM apdm_pns_supplier WHERE type_id = 3 AND supplier_id IN (".implode(",",$arr_supplier_id).")");
            $rs_ps_sp = $db->loadObjectList();
            if(count($rs_ps_sp) > 0){
                foreach ($rs_ps_sp as $obj){
                    $pns_id_sp[] = $obj->pns_id;        
                }
                $pns_id_sp = array_unique($pns_id_sp);
                $where[] = 'p.pns_id IN ('.implode(',', $pns_id_sp).')';
            }else{
                $where[] = 'p.pns_id IN (0)';
            } 
            
            
            
        }
         if(count($arr_mf_id) > 0){
            //get list pns have this supplier
            $pns_id_mf = array();
            $db->setQuery("SELECT pns_id FROM apdm_pns_supplier WHERE type_id = 3 AND supplier_id IN (".implode(",",$arr_mf_id).")");
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
        if (count($arr_eco_id) > 0) {
            $where[] = 'p.eco_id IN ('.implode(',', $arr_eco_id).')';
        }
        
        $orderby = ' ORDER BY '. $filter_order .' '. $filter_order_Dir;
        $where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
        
        $query = 'SELECT COUNT(p.pns_id)'
        . ' FROM apdm_pns AS p'
        . $filter
        . $where
        ;
       // echo $query;
        $db->setQuery( $query );
        $total = $db->loadResult();

        jimport('joomla.html.pagination');
        $pagination = new JPagination( $total, $limitstart, $limit );
        
        $query = 'SELECT p.* '
            . ' FROM apdm_pns AS p'
            . $filter
            . $where            
            . $orderby
        ;
        $lists['query'] = base64_encode($query);   
        $lists['total_record'] = $total; 
        $db->setQuery( $query, $pagination->limitstart, $pagination->limit );
        $rows = $db->loadObjectList(); 
         ///get information for filter
        $status[] = JHTML::_('select.option',  '', '- '. JText::_( 'SELECT_STATUS' ) .' -', 'value', 'text'); 
        $status[] = JHTML::_('select.option',  'Approval', JText::_( 'Approval' ) , 'value', 'text'); 
        $status[] = JHTML::_('select.option',  'Cbsolete', JText::_( 'Cbsolete' ), 'value', 'text'); 
        $status[] = JHTML::_('select.option',  'Pending',  JText::_( 'Pending' ), 'value', 'text'); 
        $status[] = JHTML::_('select.option',  'Reject',  JText::_( 'Reject' ), 'value', 'text'); 
        $status[] = JHTML::_('select.option',  'Release', JText::_( 'Release' ), 'value', 'text'); 
        $status[] = JHTML::_('select.option',  'Submit', JText::_( 'Submit' ), 'value', 'text'); 
        $lists['status'] = JHTML::_('select.genericlist',   $status, 'filter_status', 'class="inputbox" size="1"  onchange="document.adminForm.submit( );"', 'value', 'text', $filter_status );
        
        $pns_type[] = JHTML::_( 'select.option', '', JText::_('SELECT_TYPE'), 'value', 'text' );
        $pns_type[] = JHTML::_( 'select.option', 'Making', 'Making', 'value', 'text' );
        $pns_type[] = JHTML::_( 'select.option', 'Buying', 'Buying', 'value', 'text' ); 
        $pns_type[] = JHTML::_( 'select.option', 'Reference', 'Reference', 'value', 'text' );          
        $lists['pns_type']   = JHTML::_('select.genericlist', $pns_type, 'filter_type', 'class="inputbox" size="1"  onchange="document.adminForm.submit( );"', 'value', 'text', $filter_type );
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
        $type[] = JHTML::_('select.option', 0, JText::_('SELECT_TYPE_TO_FILTER'), 'value', 'text');
        $type[] = JHTML::_('select.option', 1, JText::_('ECO'), 'value', 'text');
        $type[] = JHTML::_('select.option', 2, JText::_('Vendor'), 'value', 'text');
        $type[] = JHTML::_('select.option', 3, JText::_('Supplier'), 'value', 'text');
        $type[] = JHTML::_('select.option', 4, JText::_('Manufactory'), 'value', 'text');
        $type[] = JHTML::_('select.option', 5, JText::_('Part Number Code'), 'value', 'text');
        $type[] = JHTML::_('select.option', 6, JText::_('PNs Description'), 'value', 'text');
        $lists['type_filter'] = JHTML::_('select.genericlist', $type, 'type_filter', 'class="inputbox" size="1"', 'value', 'text', $type_filter);
        
        
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

