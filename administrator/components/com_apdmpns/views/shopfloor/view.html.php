<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');
//include_once(JPATH_BASE .DS.'includes'.DS.'php-barcode-generator-master'.DS.'src'.DS.'BarcodeGenerator.php');
//include_once(JPATH_BASE .DS.'includes'.DS.'php-barcode-generator-master'.DS.'src'.DS.'BarcodeGeneratorHTML.php');
include_once (JPATH_BASE .DS.'includes'.DS.'PHP-Barcode-111'.DS.'barcode.php');
class pnsViewshopfloor extends JView {

        function display($tpl = null) {

                // global $mainframe, $option;
                global $mainframe, $option;
                $option = 'com_apdmpns_floor';
                $db = & JFactory::getDBO();
                $me = JFactory::getUser();
                JArrayHelper::toInteger($cid, array(0));

        $filter_order        = $mainframe->getUserStateFromRequest( "$option.filter_order",        'filter_order',        'p.pns_id',    'cmd' );        
        $filter_order_Dir    = $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",    'filter_order_Dir',    'desc',       'word' );      
        if(!$filter_order)
        {
            $filter_order = 'wo.wo_state';
            $filter_order_Dir = "desc";
        }
                $search_step                = $mainframe->getUserStateFromRequest( "$option.step", 'step', '','string' );
                $search = $mainframe->getUserStateFromRequest("$option.text_search", 'text_search', '', 'string');
                $keyword = $search;
                $search = JString::strtolower($search);
                $limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
                $limitstart = $mainframe->getUserStateFromRequest($option . '.limitstart', 'limitstart', 0, 'int');
                $where1 = array();
                if (isset($search) && $search != '') {
                        $searchEscaped = $db->Quote('%' . $db->getEscaped($search, false) . '%', false);
                        $where1[] = 'wo.wo_code LIKE ' . $searchEscaped . ' or CONCAT_WS( "-",so.customer_id, so.so_cuscode) LIKE ' . $searchEscaped . ' or ccs.ccs_name  LIKE ' . $searchEscaped . ' or CONCAT_WS("-",p2.ccs_code, p2.pns_code, p2.pns_revision)  LIKE ' . $searchEscaped . '  or CONCAT_WS( "-",p.ccs_code, p.pns_code, p.pns_revision) like ' . $searchEscaped . '' ;
                }
                if (isset( $search_step ) && $search_step!= '')
                {        
                    $where1[] = 'wo.wo_state = "'.$search_step.'"';
                }

                $where = ( count($where1) ? ' WHERE (' . implode(') AND (', $where1) . ')' : '' );
                
                $group_by = "group by wo.pns_wo_id";
                $orderby = ' ORDER BY '. $filter_order .' '. $filter_order_Dir;
                  $query = " select  COUNT(wo.pns_wo_id)
                         from apdm_pns_wo wo
                        left join apdm_pns p on wo.pns_id = p.pns_id
                        left join apdm_pns p2 on p2.pns_id = wo.top_pns_id
                        left join apdm_pns_so so on so.pns_so_id = wo.so_id
                        left join apdm_ccs ccs on ccs.ccs_code = so.customer_id
                        left join apdm_pns_wo_op st1 on st1.wo_id =wo.pns_wo_id and st1.op_code = 'wo_step1'
                        left join apdm_pns_wo_op st2 on st2.wo_id =wo.pns_wo_id and st2.op_code = 'wo_step2'
                        left join apdm_pns_wo_op st3 on st3.wo_id =wo.pns_wo_id and st3.op_code = 'wo_step3'
                        left join apdm_pns_wo_op st4 on st4.wo_id =wo.pns_wo_id and st4.op_code = 'wo_step4'
                        left join apdm_pns_wo_op st5 on st5.wo_id =wo.pns_wo_id and st5.op_code = 'wo_step5'
                        left join apdm_pns_wo_op st6 on st6.wo_id =wo.pns_wo_id and st6.op_code = 'wo_step6'
                        left join apdm_pns_wo_op st7 on st7.wo_id =wo.pns_wo_id and st7.op_code = 'wo_step7' " .
                        $where;

                        

                $db->setQuery($query);
                 $total = $db->loadResult();

                jimport('joomla.html.pagination');
                $pagination = new JPagination($total, $limitstart, $limit);

               
                $query = "
                        select wo.pns_wo_id,so.pns_so_id,p.pns_cpn as pn_cpn,p2.pns_cpn as pn_top_cpn,
                        wo.pns_id,wo.top_pns_id,wo.wo_code,wo.wo_state,CONCAT_WS( '-',p.ccs_code, p.pns_code, p.pns_revision) as part_number,
                        CONCAT_WS( '-',p2.ccs_code, p2.pns_code, p2.pns_revision) as top_pn,so.so_cuscode, 
                        CONCAT_WS( '-',so.customer_id, so.so_cuscode) as so_number,ccs.ccs_name, wo.wo_qty
                        ,p.pns_revision,so.so_shipping_date,wo.wo_completed_date
                        ,st1.op_completed_date as step1_complete_date,st1.op_assigner as step1_assigner,st1.op_total_time as step1_op_total_time,st1.op_rework_f_total_time as step1_op_rework_f_total_time,st1.op_rework_s_total_time as step1_op_rework_s_total_time
                        ,st2.op_completed_date as step2_complete_date,st2.op_assigner as step2_assigner,st2.op_total_time as step2_op_total_time,st2.op_rework_f_total_time as step2_op_rework_f_total_time,st2.op_rework_s_total_time as step2_op_rework_s_total_time
                        ,st3.op_completed_date as step3_complete_date,st3.op_assigner as step3_assigner,st3.op_total_time as step3_op_total_time,st3.op_rework_f_total_time as step3_op_rework_f_total_time,st3.op_rework_s_total_time as step3_op_rework_s_total_time
                        ,st4.op_completed_date as step4_complete_date,st4.op_assigner as step4_assigner,st4.op_total_time as step4_op_total_time,st4.op_rework_f_total_time as step4_op_rework_f_total_time,st4.op_rework_s_total_time as step4_op_rework_s_total_time
                        ,st5.op_completed_date as step5_complete_date,st5.op_assigner as step5_assigner,st5.op_total_time as step5_op_total_time,st5.op_rework_f_total_time as step5_op_rework_f_total_time,st5.op_rework_s_total_time as step5_op_rework_s_total_time
                        ,st6.op_completed_date as step6_complete_date,st6.op_assigner as step6_assigner,st6.op_total_time as step6_op_total_time,st6.op_rework_f_total_time as step6_op_rework_f_total_time,st6.op_rework_s_total_time as step6_op_rework_s_total_time
                        ,st7.op_completed_date as step7_complete_date,st7.op_assigner as step7_assigner,st7.op_total_time as step7_op_total_time,st7.op_rework_f_total_time as step7_op_rework_f_total_time,st7.op_rework_s_total_time as step7_op_rework_s_total_time
                        from apdm_pns_wo wo
                        left join apdm_pns p on wo.pns_id = p.pns_id
                        left join apdm_pns p2 on p2.pns_id = wo.top_pns_id
                        left join apdm_pns_so so on so.pns_so_id = wo.so_id
                        left join apdm_ccs ccs on ccs.ccs_code = so.customer_id
                        left join apdm_pns_wo_op st1 on st1.wo_id =wo.pns_wo_id and st1.op_code = 'wo_step1'
                        left join apdm_pns_wo_op st2 on st2.wo_id =wo.pns_wo_id and st2.op_code = 'wo_step2'
                        left join apdm_pns_wo_op st3 on st3.wo_id =wo.pns_wo_id and st3.op_code = 'wo_step3'
                        left join apdm_pns_wo_op st4 on st4.wo_id =wo.pns_wo_id and st4.op_code = 'wo_step4'
                        left join apdm_pns_wo_op st5 on st5.wo_id =wo.pns_wo_id and st5.op_code = 'wo_step5'
                        left join apdm_pns_wo_op st6 on st6.wo_id =wo.pns_wo_id and st6.op_code = 'wo_step6'
                        left join apdm_pns_wo_op st7 on st7.wo_id =wo.pns_wo_id and st7.op_code = 'wo_step7' ".
                        $where .                        
                        $group_by .                        
                        $orderby;
                $lists['query'] = base64_encode($query);
                $lists['total_record'] = $total;
                $db->setQuery($query, $pagination->limitstart, $pagination->limit);
                
                $rows = $db->loadObjectList();  
                
                 $wostep[] = JHTML::_('select.option',  '',  JText::_( 'Select Step' ), 'value', 'text'); 
                $wostep[] = JHTML::_('select.option',  'doc_reparation', JText::_( 'Doc. Preparation By' ), 'value', 'text'); 
                $wostep[] = JHTML::_('select.option',  'label_printed', JText::_( 'Label Printed' ), 'value', 'text'); 
                $wostep[] = JHTML::_('select.option',  'wire_cut', JText::_( 'Wire Cut' ) , 'value', 'text'); 
                $wostep[] = JHTML::_('select.option',  'kitted', JText::_( 'Kitted' ), 'value', 'text'); 
                $wostep[] = JHTML::_('select.option',  'production',  JText::_( 'Production' ), 'value', 'text'); 
                $wostep[] = JHTML::_('select.option',  'final_inspection',  JText::_( 'Final Inspection' ), 'value', 'text'); 
                $wostep[] = JHTML::_('select.option',  'packaging', JText::_( 'Packaging' ), 'value', 'text');  
                $wostep[] = JHTML::_('select.option',  'done', JText::_( 'Done' ), 'value', 'text');  
                $wostep[] = JHTML::_('select.option',  'onhold', JText::_( 'On hold' ), 'value', 'text');  
                $wostep[] = JHTML::_('select.option',  'cancel', JText::_( 'Cancel' ), 'value', 'text');                  
                $list_step =  JHTML::_('select.genericlist', $wostep, 'step', 'class="inputbox" size="1"', 'value', 'text', $search_step);
                $this->assignRef('list_step',       $list_step);
                $lists['order_Dir']    = $filter_order_Dir;
                $lists['order']        = $filter_order;
                $lists['search'] = $search;
                $this->assignRef('lists',        $lists);
                $this->assignRef('rows', $rows);
                $this->assignRef('pagination', $pagination);
                             
                parent::display($tpl);
        }

}

