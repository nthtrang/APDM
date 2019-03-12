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
class pnsViewgetpnsforeco extends JView
{
	function display($tpl = null)
	{
	    global $mainframe, $option;
        
        $db                =& JFactory::getDBO();
        $option             = 'com_apdmpns&task=get_list_child';
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
        $where[] = 'p.pns_deleted = 0 and pns_life_cycle in ("Create")';
        
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
		
        if ($id){ //get pns_child have exist
            $arrPNsChild  = array();
            $arrPNsChild[] = $id;
			
            $query = "SELECT pns_id from apdm_pns_parents where pns_parent=".$id;
            
            $db->setQuery($query);
            $row_pns_parents = $db->loadObjectList();            
            if (count($row_pns_parents) > 0){
                foreach ($row_pns_parents as $obj){
                    $arrPNsChild[] = $obj->pns_id;
                }
            }
            //get list pns_parent of this pns
            $query = " SELECT pns_parent FROM apdm_pns_parents WHERE pns_id=".$id;
            $db->setQuery($query);
            $row_pns_ = $db->loadObjectList();
            if ( count ($row_pns_) > 0 ){
                foreach ($row_pns_ as $obj_){
                    $arrPNsChild[] = $obj_->pns_parent;
                    //check for parent of parent wtih level 1
                    $db->setQuery("SELECT pns_parent FROM apdm_pns_parents WHERE pns_id=".$obj_->pns_parent);                    
                    $rows1 = $db->loadObjectList();
                    if (count($rows1) > 0){
                            foreach ($rows1 as $obj1){
                                $arrPNsChild[] = $obj1->pns_parent;
                                ///check for parent level 2
                                $db->setQuery("SELECT pns_parent FROM apdm_pns_parents WHERE pns_id=".$obj1->pns_parent);                    
                                $rows2 = $db->loadObjectList();
                                if ( count ($rows2 ) > 0){
                                    foreach ($rows2 as $obj2){
                                        $arrPNsChild[] = $obj2->pns_parent;
                                        //check for levle 3
                                        $db->setQuery("SELECT pns_parent FROM apdm_pns_parents WHERE pns_id=".$obj2->pns_parent);                    
                                        $rows3 = $db->loadObjectList();
                                        if ( count ($rows3) > 0 ){
                                            foreach ($rows3 as $obj3){
                                                $arrPNsChild[] = $obj3->pns_parent;
                                                //check for level 4
                                                $db->setQuery("SELECT pns_parent FROM apdm_pns_parents WHERE pns_id=".$obj3->pns_parent);                    
                                                $rows4 = $db->loadObjectList();
                                                if (count($rows4) > 0){
                                                    foreach($rows4 as $obj4){
                                                        $arrPNsChild[] = $obj4->pns_parent;
                                                        //check for levle 5
                                                        $db->setQuery("SELECT pns_parent FROM apdm_pns_parents WHERE pns_id=".$obj4->pns_parent);                    
                                                        $rows5 = $db->loadObjectList();
                                                        if  ( count ($rows5) > 0 ){
                                                            foreach ($rows5 as $obj5 ){
                                                                $arrPNsChild[] = $obj5->pns_parent;
                                                                //check for level 6
                                                                $db->setQuery("SELECT pns_parent FROM apdm_pns_parents WHERE pns_id=".$obj5->pns_parent);                    
                                                                $rows6 = $db->loadObjectList();
                                                                if ( count ($rows6) > 0 ){
                                                                    foreach ($rows6 as $obj6){
                                                                        $arrPNsChild[] = $obj6->pns_parent;
                                                                        //check for level 7
                                                                        $db->setQuery("SELECT pns_parent FROM apdm_pns_parents WHERE pns_id=".$obj6->pns_parent);                    
                                                                        $rows7 = $db->loadObjectList();
                                                                        if ( count ($rows7) > 0 ){
                                                                            foreach ($rows7 as $obj7){
                                                                                $arrPNsChild[] = $obj7->pns_parent;
                                                                                //check for level 8
                                                                                $db->setQuery("SELECT pns_parent FROM apdm_pns_parents WHERE pns_id=".$obj7->pns_parent);                    
                                                                                $rows8 = $db->loadObjectList();
                                                                                if ( count( $rows8) > 0){
                                                                                    foreach ($rows8 as $obj8){
                                                                                        $arrPNsChild[] = $obj8->pns_parent;
                                                                                        //check for level 9
                                                                                        $db->setQuery("SELECT pns_parent FROM apdm_pns_parents WHERE pns_id=".$obj8->pns_parent);                    
                                                                                        $rows9 = $db->loadObjectList();
                                                                                        if ( count ($rows9) > 0){
                                                                                            foreach ($rows9 as $obj9){
                                                                                                $arrPNsChild[] = $obj9->pns_parent;
                                                                                                //check forlevel 10;
                                                                                                 $db->setQuery("SELECT pns_parent FROM apdm_pns_parents WHERE pns_id=".$obj9->pns_parent);                    
                                                                                                 $rows10 = $db->loadObjectList();
                                                                                                 if (count($rows10) > 0){
                                                                                                     foreach ($rows10 as $obj10){
                                                                                                         $arrPNsChild[] = $obj10->pns_parent;
                                                                                                     }
                                                                                                 }
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                    }
                    
                }
            }
            
			
            if (count( $arrPNsChild ) > 0)   {
            	$where[] = 'p.pns_id NOT IN ('.implode(",", $arrPNsChild ).') ';
			}
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
                case '7': //Manufacture PN                         
                    $arr_mf_id = array();
                         //echo 'SELECT * FROM apdm_supplier_info ASI LEFT JOIN apdm_pns_supplier APS ON ASI.info_id = APS.supplier_id WHERE ASI.info_deleted=0 AND ASI.info_type =4 AND (APS.supplier_info LIKE '.$searchEscaped.'OR ASI.info_description LIKE '.$searchEscaped.' ) group by ASI.info_id';
                    $db->setQuery('SELECT * FROM apdm_supplier_info ASI LEFT JOIN apdm_pns_supplier APS ON ASI.info_id = APS.supplier_id WHERE ASI.info_deleted=0 AND ASI.info_type =4 AND APS.supplier_info LIKE '.$searchEscaped.'  group by ASI.info_id');
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
                case '6': //for information of pns
                    $where[] = 'p.pns_description LIKE '.$searchEscaped;
                break;
                case '5': //for code
                    //  $where[] = 'p.pns_code_full LIKE '.$searchEscaped;
                  //  echo $search; exit;
                $leght = strlen (trim($keyword));                    
//                 if ($leght==16){                                                                        
//                       $arr_code = explode("-", trim($keyword));                                                         
//                       $db->setQuery("SELECT pns_id FROM apdm_pns WHERE ccs_code=".$arr_code[0]." AND pns_code='".$arr_code[1].'-'.$arr_code[2]."' AND pns_revision='".$arr_code[3]."'");
//                       $rs_pns = $db->loadObjectList();
//                       $array_pns_id_find = array();
//                       if (count($rs_pns) > 0){
//                           foreach ($rs_pns as $pn){
//                               $array_pns_id_find[] = $pn->pns_id;
//                           }
//                         
//                       }else{
//                           $array_pns_id_find[] =0;
//                       }
//                       $where[] = 'p.pns_id IN ('.implode(",", $array_pns_id_find).') ';
//                   }elseif ($leght==13){                       
//                       $arr_code = explode("-", trim($keyword));                         
//                       $db->setQuery("SELECT pns_id FROM apdm_pns WHERE  ccs_code=".$arr_code[0]." AND pns_code='".$arr_code[1].'-'.$arr_code[2]."'");
//                       $rs_pns = $db->loadObjectList();                       
//                       if (count($rs_pns) > 1){
//                           foreach ($rs_pns as $obj) {
//                                $arr_pns_id[] =  $obj->pns_id;
//                           }            
//                           $where[] = 'p.pns_id IN ('.implode(',', $arr_pns_id).')'; 
//                       }else{
//                            if(strlen($arr_code[0])==6){
//                                 $where[] = 'p.pns_code='.$arr_code[0].'-'.$arr_code[1].' AND p.pns_revision='.$arr_code[2];
//                            }else{
//                                 $where[] = 'p.pns_id IN (0)';
//                            }
//                       }
//                        
//                   }else
                   if($leght==10){
                         $arr_code = explode("-", trim($keyword));
                         $where[] = 'p.ccs_code ='.$arr_code[0].' AND p.pns_code='.$arr_code[1];
                         
                   }else{
                           if($searchEscaped){
                     $arr_code = explode("-", trim($keyword));
                         $where[] = '(p.ccs_code LIKE "%'.$arr_code[0].'%" AND p.pns_code like "%'.$arr_code[1].'%") or (p.pns_code LIKE '.$searchEscaped.' OR p.pns_revision LIKE '.$searchEscaped. ' OR p.ccs_code LIKE '.$searchEscaped.')';
                           }
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
       //echo $query;
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
        //$type[] = JHTML::_('select.option', 0, JText::_('SELECT_TYPE_TO_FILTER'), 'value', 'text');
        $type[] = JHTML::_('select.option', 5, JText::_('PN'), 'value', 'text');
        $type[] = JHTML::_('select.option', 6, JText::_('Description'), 'value', 'text');
        $type[] = JHTML::_('select.option', 1, JText::_('ECO'), 'value', 'text');
        $type[] = JHTML::_('select.option', 7, JText::_('MFG PN'), 'value', 'text');
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

