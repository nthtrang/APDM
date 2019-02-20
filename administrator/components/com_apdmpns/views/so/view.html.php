<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class pnsViewso extends JView {

        function display($tpl = null) {

                // global $mainframe, $option;
                global $mainframe, $option;
                $option = 'com_apdmpns_so';
                $db = & JFactory::getDBO();
                $cid = JRequest::getVar('cid', array(0), '', 'array');
                $so_id = JRequest::getVar('id');
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
                        $where[] = 'so.so_cuscode LIKE ' . $searchEscaped . '';
                        $where[] = 'wo.wo_code LIKE ' . $searchEscaped . '';
                }
                $where[] ="wop.op_assigner = ".$me->get('id');
                $where[] = " wop.op_status != 'done'";
                $where[] = " wo.wo_state not in('done','cancel')";
                $where[] = " so.so_state not in('done','cancel')";
                
                $where = ( count($where) ? ' WHERE (' . implode(') AND (', $where) . ')' : '' );
                $orderby = ' ORDER BY so.pns_so_id desc';


                //for my task #somanagement
               $query = 'SELECT  wop.*,so.pns_so_id,wo.wo_assigner,so.customer_id as ccs_so_code,wo.pns_wo_id,p.pns_id,wo.wo_state,wo.wo_code,p.pns_description,so.so_cuscode,p.ccs_code, p.pns_code, p.pns_revision,wo.wo_qty,p.pns_uom,wo.wo_start_date,wo.wo_completed_date,DATEDIFF(wop.op_target_date, CURDATE()) as wo_remain_date,wo.wo_delay,wo.wo_rework  '
                        . ' from apdm_pns_wo_op wop '
                        .' inner join apdm_pns_wo wo on wo.pns_wo_id = wop.wo_id'
                        .' inner join apdm_pns_so so on wo.so_id = so.pns_so_id '
                        . ' left join apdm_pns p on  p.pns_id = wo.pns_id '
                      //  . ' left join apdm_ccs AS ccs on  so.customer_id = ccs.ccs_code'
                        . $where
                        . $orderby;

                $db->setQuery($query);
                $rows = $db->loadObjectList();
                //for issue report                                
                $query = "select DATEDIFF(CURDATE(),op_target_date) as step_delay_date,op.*,so.so_cuscode,so.customer_id as ccs_so_code,wo.wo_code,so.pns_so_id,wo.pns_wo_id,wo.wo_delay".
                          " from apdm_pns_wo_op op inner join apdm_pns_wo wo on op.wo_id = wo.pns_wo_id".
                          " inner join  apdm_pns_so so on so.pns_so_id = wo.so_id".
                         # " inner join apdm_ccs ccs on so.customer_id = ccs.ccs_code". //ccs.ccs_code,ccs.ccs_coordinator,
                          " where ".
                          " (((op_status ='pending' or op_status =''  or op_completed_date = '0000-00-00 00:00:00' ) and DATEDIFF(CURDATE(),op_target_date) > 0)".
                       //   " or  (op_status ='done' and op_completed_date != '0000-00-00 00:00:00' and DATEDIFF(CURDATE(),op_delay_date) >= 0)".
                        'or wo.pns_wo_id  in (select op.wo_id '.
                               ' from apdm_pns_wo_op op '.
                               ' inner join  apdm_pns_wo_op_visual vi on op.pns_op_id =vi.pns_op_id '.
                               ' where (op_visual_value1 != "" or op_visual_value2 != "" or op_visual_value3 != "" or op_visual_value4 != "" or op_visual_value5 != "")) '.
                        ' or wo.pns_wo_id  in (select op.wo_id '.
                               ' from apdm_pns_wo_op op '.
                               ' inner join  apdm_pns_wo_op_final fi on op.pns_op_id =fi.pns_op_id '.
                               ' where (op_final_value1 != "" or op_final_value2 != "" or op_final_value3 != "" or op_final_value4 != "" or op_final_value5 != "" or op_final_value6 != "" or op_final_value7 != ""))'.
                          " or op_delay != 0) and op_status != 'done'";
               
                $db->setQuery($query);
                $report_list = $db->loadObjectList();
                $usertype	= $me->get('usertype');
                if ($usertype =='Administrator' || $usertype=="Super Administrator") {
                        $this->assignRef('report_list', $report_list);
                }
                
                //for PO detailid
                $db->setQuery("SELECT fk.*,p.pns_uom,p.pns_cpn, p.pns_description,p.pns_cpn,p.pns_id,p.pns_stock,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code,p.ccs_code, p.pns_code, p.pns_revision  FROM apdm_pns_so AS so inner JOIN apdm_pns_so_fk fk on so.pns_so_id = fk.so_id inner join apdm_pns AS p on p.pns_id = fk.pns_id where so.pns_so_id=" . $so_id);
                $pns_list = $db->loadObjectList();
                $this->assignRef('so_pn_list', $pns_list);

                $db->setQuery("SELECT so.*,so.customer_id as ccs_so_code,max(date(wo.wo_completed_date)) as max_wo_completed,ccs.ccs_coordinator,ccs.ccs_code from apdm_pns_so so inner join apdm_pns_wo wo on so.pns_so_id=wo.so_id left join apdm_ccs ccs on so.customer_id = ccs.ccs_code where so.pns_so_id=" . $so_id);
                $so_row = $db->loadObject();
                $this->assignRef('so_row', $so_row);

                //Status
                $statusValue = array();
                $statusValue[] = JHTML::_('select.option', '', '- ' . JText::_('Select') . ' -', 'value', 'text');
                $statusValue[] = JHTML::_('select.option', 'inprogress', JText::_('In Progress'), 'value', 'text');
                $statusValue[] = JHTML::_('select.option', 'onhold', JText::_('On hold'), 'value', 'text');
                $statusValue[] = JHTML::_('select.option', 'cancel', JText::_('Cancel'), 'value', 'text');
                $statusValue[] = JHTML::_('select.option', 'done', JText::_('Done'), 'value', 'text');
                $classDisabled = 'disabled = "disabled"';
                $defaultStatus = "inprogress";
                if ($so_row->so_state)
                        $defaultStatus = $so_row->so_state;
                $lists['soStatus'] = JHTML::_('select.genericlist', $statusValue, 'so_status', 'class="inputbox " ' . $classDisabled . ' size="1"', 'value', 'text', $defaultStatus);

                $arrStatus = array("inprogress" => JText::_('In Progress'), 'onhold' => JText::_('On hold'), 'cancel' => JText::_('Cancel'), 'done' => JText::_('Done'));

                //Customer
                $cccpn[0] = JHTML::_('select.option', 0, '- ' . JText::_('SELECT_CCS') . ' -', 'value', 'text');
                $db->setQuery("SELECT  ccs_code  as value, CONCAT_WS(' :: ', ccs_code, ccs_name) as text FROM apdm_ccs WHERE ccs_deleted=0 AND ccs_activate= 1 and ccs_cpn = 1 ORDER BY ccs_code ");
                $ccscpn = array_merge($cccpn, $db->loadObjectList());
                $lists['ccscpn'] = JHTML::_('select.genericlist', $ccscpn, 'customer_id', 'class="inputbox" size="1" onchange="getccsCoordinator(this.value)"', 'value', 'text', $so_row->customer_id);
                //get ist imag/zip/pdf
                ///get list cad files
                $db->setQuery("SELECT * FROM apdm_pn_cad WHERE so_id=" . $so_row->pns_so_id);
                $res = $db->loadObjectList();
                if (count($res) > 0) {
                        foreach ($res as $r) {
                                $zips_files[] = array('id' => $r->pns_cad_id, 'zip_file' => $r->cad_file);
                        }
                }
                ///get list image files
                $db->setQuery("SELECT * FROM apdm_pns_image WHERE so_id=" . $so_row->pns_so_id);
                $res = $db->loadObjectList();
                if (count($res) > 0) {
                        foreach ($res as $r) {
                                $images_files[] = array('id' => $r->pns_image_id, 'image_file' => $r->image_file);
                        }
                }
                ///get list pdf files
                $db->setQuery("SELECT * FROM apdm_pns_pdf WHERE so_id=" . $so_row->pns_so_id);
                $res = $db->loadObjectList();
                if (count($res) > 0) {
                        foreach ($res as $r) {
                                $pdf_files[] = array('id' => $r->pns_pdf_id, 'pdf_file' => $r->pdf_file);
                        }
                }
                //get list WO TAB
                $sql = "select wo.pns_wo_id,wo.wo_log,p.pns_id,wo.wo_state,wo.wo_code,p.pns_description,so.so_cuscode,p.ccs_code, p.pns_code, p.pns_revision,wo.wo_qty,p.pns_uom,wo.wo_start_date,wo.wo_completed_date,DATEDIFF(wo.wo_completed_date, CURDATE()) as wo_remain_date,wo.wo_delay,wo.wo_rework " .
                        " from apdm_pns_wo wo inner join apdm_pns_so so on wo.so_id = so.pns_so_id " .
                        " left join apdm_pns p on  p.pns_id = wo.pns_id " .
                        " where so.pns_so_id =" . $so_row->pns_so_id;
                $db->setQuery($sql);
                $wo_lists = $db->loadObjectList();
                $this->assignRef('wo_list', $wo_lists);     
                
                //get WO LOG
                //get list WO TAB HISTORY
                $sql = "select  woh.*,wo.pns_wo_id,wo.wo_log,p.pns_id,wo.wo_state,wo.wo_code,p.pns_description,so.so_cuscode,p.ccs_code, p.pns_code, p.pns_revision,wo.wo_qty,p.pns_uom,wo.wo_start_date,wo.wo_completed_date,DATEDIFF(wo.wo_completed_date, CURDATE()) as wo_remain_date,wo.wo_delay,wo.wo_rework " .
                        " from apdm_pns_wo_history woh inner join apdm_pns_wo wo on woh.wo_id = wo.pns_wo_id ".
                        " inner join apdm_pns_so so on wo.so_id = so.pns_so_id " .
                        " left join apdm_pns p on  p.pns_id = wo.pns_id " .
                        " where so.pns_so_id =" . $so_row->pns_so_id ." order by woh.id desc";
                $db->setQuery($sql);
                $wo_lists_history= $db->loadObjectList();
                $this->assignRef('wo_list_history', $wo_lists_history);     
                
                $lists['zips_files'] = $zips_files;
                $lists['image_files'] = $images_files;
                $lists['pdf_files'] = $pdf_files;
                $lists['search'] = $search;
                $this->assignRef('lists', $lists);
                $this->assignRef('arr_status', $arrStatus);

                $this->assignRef('so_list', $rows);
                $this->assignRef('pagination', $pagination);
                parent::display($tpl);
        }

}

