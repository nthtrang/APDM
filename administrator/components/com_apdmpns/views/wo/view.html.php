<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class pnsViewwo extends JView {

        function display($tpl = null) {

                // global $mainframe, $option;
                global $mainframe, $option;
                $option = 'com_apdmpns_so';
                $db = & JFactory::getDBO();
                $cid = JRequest::getVar('cid', array(0), '', 'array');
                $wo_id = JRequest::getVar('id');
                $me = JFactory::getUser();
                JArrayHelper::toInteger($cid, array(0));
                $search = $mainframe->getUserStateFromRequest("$option.text_search", 'text_search', '', 'string');
                $keyword = $search;
                $search = JString::strtolower($search);
                $limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
                $limitstart = $mainframe->getUserStateFromRequest($option . '.limitstart', 'limitstart', 0, 'int');
                $where = array();
                if (isset($search) && $search != '') {
                        $searchEscaped = $db->Quote('%' . $db->getEscaped($search, false) . '%', false);
                        $where[] = 'p.po_code LIKE ' . $searchEscaped . ' or p.po_description LIKE ' . $searchEscaped . '';
                }

                $where = ( count($where) ? ' WHERE (' . implode(') AND (', $where) . ')' : '' );
                $orderby = ' ORDER BY p.pns_po_id desc';
                $query = 'SELECT COUNT(p.pns_po_id)'
                        . ' FROM apdm_pns_po AS p'
                        . $where
                ;

                $db->setQuery($query);
                $total = $db->loadResult();

                jimport('joomla.html.pagination');
                $pagination = new JPagination($total, $limitstart, $limit);

                $query = 'SELECT p.* '
                        . ' FROM apdm_pns_po AS p'
                        . $where
                        . $orderby;
                $lists['query'] = base64_encode($query);
                $lists['total_record'] = $total;
                $db->setQuery($query, $pagination->limitstart, $pagination->limit);
                $rows = $db->loadObjectList();


             

                $query = "SELECT DATEDIFF(wo.wo_start_date,CURDATE()) as allow_edit_qty,so.so_shipping_date,so.so_cuscode,ccs.ccs_coordinator,ccs.ccs_code,wo.* " .
                        " from apdm_pns_wo wo left join apdm_ccs AS ccs on  wo.wo_customer_id = ccs.ccs_code " .
                        " left join apdm_pns_so as so on  so.pns_so_id = wo.so_id " .
                        " where pns_wo_id=" . $wo_id;
                $db->setQuery($query);
                $wo_row = $db->loadObject();
                $this->assignRef('wo_row', $wo_row);

                $query = "select pns_id,pns_uom,pns_description,ccs_code, pns_code, pns_revision FROM apdm_pns WHERE pns_id IN (" . $wo_row->pns_id . ") limit 1";
                $db->setQuery($query);
                $rows_part = $db->loadObject();
                $this->assignRef('row_part', $rows_part);

                //echo $query = "select fk.*,pns_uom,pns_description,ccs_code, pns_code, pns_revision FROM apdm_pns p inner join apdm_pns_wo wo on wo.top_pns_id = p.pns_id inner join apdm_pns_so_fk fk on wo.top_pns_id = fk.pns_id  WHERE fk.pns_id IN (" . $wo_row->top_pns_id . ") and  wo.so_id = ".$wo_row->so_id." limit 1";
                //$db->setQuery($query);
                $db->setQuery("SELECT fk.*,ccs.ccs_code as customer_code,ccs.ccs_name as customer_name,p.pns_uom,p.pns_cpn, p.pns_description,p.pns_cpn,p.pns_id,p.pns_stock,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code,p.ccs_code, p.pns_code, p.pns_revision  FROM apdm_pns_so AS so inner join apdm_ccs ccs on  ccs.ccs_code = so.customer_id inner JOIN apdm_pns_so_fk fk on so.pns_so_id = fk.so_id inner join apdm_pns AS p on p.pns_id = fk.pns_id where fk.pns_id = " .  $wo_row->top_pns_id . " and so_id =".$wo_row->so_id." limit 1");                                
                $rows_top_assy = $db->loadObject();
                $this->assignRef('row_top_assy', $rows_top_assy);

                //get operator
                $query = "select * from apdm_pns_wo_op where wo_id = " . $wo_id;
                $db->setQuery($query);
                $op_rows = $db->loadObjectList();
                $op_arr = array();
                foreach ($op_rows as $rop) {
                        $op_arr[$rop->op_code] = array('op_comment' => $rop->op_comment,
                            'op_completed_date' => $rop->op_completed_date,
                            'op_status' => $rop->op_status,
                            'op_assigner' => $rop->op_assigner,
                            'op_target_date' => $rop->op_target_date,
                            'pns_op_id' => $rop->pns_op_id);
                }
                $this->assignRef('op_arr', $op_arr);

                //GET DETAIL STEP 4
                $query = "select op_as.* from apdm_pns_wo_op_assembly op_as inner join apdm_pns_wo_op op on op_as.pns_op_id=  op.pns_op_id where op_as.pns_wo_id =" . $wo_id;
                $db->setQuery($query);
                $wo_assem_rows = $db->loadObjectList();
                $this->assignRef('wo_assem_rows', $wo_assem_rows);
                //GET DETAIL STEP 5
                $query = "select op_vs.* from apdm_pns_wo_op_visual op_vs inner join apdm_pns_wo_op op on op_vs.pns_op_id=  op.pns_op_id where op_vs.pns_wo_id =" . $wo_id;
                $db->setQuery($query);
                $wo_vs_rows = $db->loadObjectList();
                $opvs_arr = array();
                foreach ($wo_vs_rows as $rof) {
                        $opvs_arr[$rof->op_visual_fail_times] = array('op_visual_value1' => $rof->op_visual_value1,
                            'op_visual_value2' => $rof->op_visual_value2,
                            'op_visual_value3' => $rof->op_visual_value3,
                            'op_visual_value4' => $rof->op_visual_value4,
                            'op_visual_value5' => $rof->op_visual_value5);
                }
                $this->assignRef('opvs_arr', $opvs_arr);
                //GET DETAIL STEP 6
                $query = "select op_fn.* from apdm_pns_wo_op_final op_fn inner join apdm_pns_wo_op op on op_fn.pns_op_id=  op.pns_op_id where op_fn.pns_wo_id =" . $wo_id;
                $db->setQuery($query);
                $wo_fn_rows = $db->loadObjectList();
                $opfn_arr = array();
                foreach ($wo_fn_rows as $rov) {
                        $opfn_arr[$rov->op_final_fail_times] = array('op_final_value1' => $rov->op_final_value1,
                            'op_final_value2' => $rov->op_final_value2,
                            'op_final_value3' => $rov->op_final_value3,
                            'op_final_value4' => $rov->op_final_value4,
                            'op_final_value5' => $rov->op_final_value5,
                            'op_final_value6' => $rov->op_final_value6,
                            'op_final_value7' => $rov->op_final_value7);
                }
                $this->assignRef('opfn_arr', $opfn_arr);
                //WO Status
                //Status của WO: Done, On Hold, Cancel, Label Printed, Wire Cut, Kitted, Production, Visual Inspection, Final Inspection, Packaging.
                $statusValue = array();
                $statusValue[] = JHTML::_('select.option', '', '- ' . JText::_('Select') . ' -', 'value', 'text');
                $statusValue[] = JHTML::_('select.option', 'done', JText::_('Done'), 'value', 'text');
                $statusValue[] = JHTML::_('select.option', 'onhold', JText::_('On hold'), 'value', 'text');
                $statusValue[] = JHTML::_('select.option', 'cancel', JText::_('Cancel'), 'value', 'text');
                $statusValue[] = JHTML::_('select.option', 'label_printed', JText::_('Label Printed'), 'value', 'text');
                $statusValue[] = JHTML::_('select.option', 'wire_cut', JText::_('Wire Cut'), 'value', 'text');
                $statusValue[] = JHTML::_('select.option', 'kitted', JText::_('Kitted'), 'value', 'text');
                $statusValue[] = JHTML::_('select.option', 'production', JText::_('Production'), 'value', 'text');
                $statusValue[] = JHTML::_('select.option', 'visual_inspection', JText::_('Visual Inspection'), 'value', 'text');
                $statusValue[] = JHTML::_('select.option', 'final_inspection', JText::_('Final Inspection'), 'value', 'text');
                $statusValue[] = JHTML::_('select.option', 'packaging', JText::_('Packaging'), 'value', 'text');
                $classDisabled = 'disabled = "disabled"';
                $defaultStatus = "inprogress";
                if ($wo_row->wo_state)
                        $defaultStatus = $wo_row->wo_state;
                $lists['soStatus'] = JHTML::_('select.genericlist', $statusValue, 'so_status', 'class="inputbox " ' . $classDisabled . ' size="1"', 'value', 'text', $defaultStatus);

                $arrSoStatus = array("inprogress" => JText::_('In Progress'), 'onhold' => JText::_('On hold'), 'cancel' => JText::_('Cancel'));
                $arrWoStatus = array(
                        'wo_step1' => JText::_('Label Prin'), 
                        'wo_step2' => JText::_('Wire Cut'),
                        'wo_step3'=>JText::_('Kitted'),
                        'wo_step4'=>JText::_('Wire Cut'),
                        'wo_step5'=>JText::_('Kitted'),
                        'wo_step6' =>JText::_('Production'),
                        'wo_step7' => JText::_('Visual Inspection')
                        );

                $db->setQuery("SELECT jos.id as value, jos.name as text FROM jos_users jos inner join apdm_users apd on jos.id = apd.user_id  WHERE user_enable=0 ORDER BY jos.username ");
                $list_users = $db->loadObjectList();
                $assigners[] = JHTML::_('select.option', 0, JText::_('Select Assigner'), 'value', 'text');
                $assigners = array_merge($assigners, $list_users);
              
                if(strtotime(date("Y-m-d")) > strtotime($wo_row->wo_start_date))
                {            
                     $userAsign = GetValueUser($wo_row->wo_assigner, "name");
                     $lists['assigners'] = '<input type = "hidden" value="'.$wo_row->wo_assigner.'" name="wo_assigner"><input type = "text" readonly="readonly" value="'.$userAsign.'" name="wo_assigner_text">';// JHTML::_('select.genericlist', $assigners, 'wo_assigner', 'class="inputbox" size="1" '.$style.'', 'value', 'text', $wo_row->wo_assigner);
                }  
                else {
                        $lists['assigners'] = JHTML::_('select.genericlist', $assigners, 'wo_assigner', 'class="inputbox" size="1"', 'value', 'text', $wo_row->wo_assigner);
                }
                
                

                //get wo po delay
                $query = "select DATEDIFF(CURDATE(),op_target_date) as step_delay_date,op.* ".
                        " from apdm_pns_wo_op op  ".
                        " where op.wo_id = ".$wo_id."".
                        " and ((op_status ='pending' and op_completed_date = '0000-00-00 00:00:00'  and DATEDIFF(CURDATE(),op_target_date) > 0)".
                        " or  (op_status ='done' and op_completed_date != '0000-00-00 00:00:00' and DATEDIFF(CURDATE(),op_delay_date) >= 0)".
						 " or op_delay != 0)";
                $db->setQuery($query);
                $wo_delay = $db->loadObjectList();
                $this->assignRef('wo_delay', $wo_delay);
                
                $queryRework = 'select op.*,vi.op_visual_fail_times as fail_time'.
                               ' from apdm_pns_wo_op op '.
                               ' inner join  apdm_pns_wo_op_visual vi on op.pns_op_id =vi.pns_op_id '.
                               ' where (op_visual_value1 != "" or op_visual_value2 != "" or op_visual_value3 != "" or op_visual_value4 != "" or op_visual_value5 != "") '.
                               ' and  op.wo_id ='.$wo_id.''.
                               ' union'.
                               ' select op.* ,fi.op_final_fail_times as fail_time'.
                               ' from apdm_pns_wo_op op '.
                               ' inner join  apdm_pns_wo_op_final fi on op.pns_op_id =fi.pns_op_id '.
                               ' where (op_final_value1 != "" or op_final_value2 != "" or op_final_value3 != "" or op_final_value4 != "" or op_final_value5 != "" or op_final_value6 != "" or op_final_value7 != "")'.
                               ' and  op.wo_id ='.$wo_id.'';

                $db->setQuery($queryRework);
                $wo_rework = $db->loadObjectList();
                $this->assignRef('wo_rework', $wo_rework);
                //get ist imag/zip/pdf
                $db->setQuery("SELECT * FROM jos_users jos inner join apdm_users apd on jos.id = apd.user_id  WHERE user_enable=0 ORDER BY jos.username ");
                $list_user = $db->loadObjectList();
                //get file LOG uoload
                $db->setQuery("SELECT * FROM apdm_pns_wo_files WHERE wo_id='".$wo_id."'");
                $list_file_log = $db->loadObjectList();
                
                $lists['search'] = $search;
                $this->assignRef('lists', $lists);
                $this->assignRef('list_file_log', $list_file_log);
                $this->assignRef('arr_status', $arrSoStatus);
                $this->assignRef('list_user', $list_user);
                $this->assignRef('wo_list', $rows);
                $this->assignRef('pagination', $pagination);
                             
                parent::display($tpl);
        }

}

