<?php
/**
 * HTML View class for the PNs component
*/
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class pnsViewsearchsowo extends JView
{
	function display($tpl = null)
	{
	    global $mainframe, $option;
        
        $db                =& JFactory::getDBO();
        $option             = 'com_apdmpns_searchadvance';
        $clean = JRequest::getVar('clean');
      
           $post = JRequest::get('post');
           //var_dump($post);
           
        $search_type                = $mainframe->getUserStateFromRequest( "$option.search_swo_type", 'search_swo_type', '','string' );
        $search_so                = $mainframe->getUserStateFromRequest( "$option.so_cuscode", 'so_cuscode', '','string' );
        $search_wo                = $mainframe->getUserStateFromRequest( "$option.wo_cuscode", 'wo_cuscode', '','string' );
        $so_status                = $mainframe->getUserStateFromRequest( "$option.so_status", 'so_status', '','string' );
        $time_remain              = $mainframe->getUserStateFromRequest( "$option.time_remain", 'time_remain', '','string' );
        $wo_status                = $mainframe->getUserStateFromRequest( "$option.wo_status", 'wo_status', '','string' );
        $employee_id              = $mainframe->getUserStateFromRequest( "$option.employee_id", 'employee_id', '','string' );
        $time_from              = $mainframe->getUserStateFromRequest( "$option.time_from", 'time_from', '','string' );
        $time_to                = $mainframe->getUserStateFromRequest( "$option.time_to", 'time_to', '','string' );
        $wo_op_status                = $mainframe->getUserStateFromRequest( "$option.wo_op_status", 'wo_op_status', '','string' );
        
        $keyword                = $search_so;
        $search_so                = JString::strtolower( $search_so );
        $search_wo                = JString::strtolower( $search_wo );
        
        $limit        = $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
        $limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
        
        if($clean=="all")
        {
                $search_so = $search_wo = $so_status= $time_remain =$wo_status = $employee_id = $time_from =$time_to = $wo_op_status= "";  
        }
       
        $where = array();
        $wherewo = array();
  
        if ($search_type == "searchso" && isset( $search_so ) && $search_so!= '')
        {
            $searchSoEscaped = $db->Quote( '%'.$db->getEscaped( $search_so, false ).'%', false );
           
        }
        if ($search_type == "searchwo" && isset( $search_wo ) && $search_wo!= '')
        {
                
            $searchWoEscaped = $db->Quote( '%'.$db->getEscaped( $search_wo, false ).'%', false );
            $wherewo[] = 'wo.wo_code LIKE '.$searchWoEscaped; 
           
        }
        
        
        $where[] = 'so.so_cuscode LIKE '.$searchSoEscaped;
          
        

        if($so_status)
        {
                if($so_status !='rma')
                {
                        $where[] = 'so.so_state = "'.$so_status.'"'; 
                }
                else {
                        /*$query = "select so_id from apdm_pns_so_fk where rma is not null group by so_id ";
                        $db->setQuery($query);                   
                        $rso_is_rma = $db->loadObjectList();
                        $arrSoRma = array();
                        foreach($rso_is_rma as $r)
                        {
                                $arrSoRma[]=$r->so_id;
                        }
                        $where[] = 'so.pns_so_id IN ('.implode(',', $arrSoRma).')';*/
                        
                         $where[] ='fk.rma is not null';                       
                }                
        }
        if($time_remain)
        {
                $where[] = 'DATEDIFF(so.so_shipping_date, CURDATE()) < '.$time_remain; 
                $wherewo[] ='DATEDIFF(wo.wo_completed_date, CURDATE()) < '.$time_remain;  
        }
        $wo_id_delay = array();
        if(isset($wo_status) && $wo_status =="delay")
        {
                $query = "select DATEDIFF(CURDATE(),op_target_date) as step_delay_date,op.wo_id".
                          " from apdm_pns_wo_op op where op_completed_date = '0000-00-00 00:00:00'  and DATEDIFF(CURDATE(),op_target_date) > 0  group by wo_id";
                $db->setQuery($query);                   
                $rswo_id_delay = $db->loadObjectList();
                if (count($rswo_id_delay) >0){
                        foreach ($rswo_id_delay as $wo){
                           $wo_id_delay[] = $wo->wo_id; 
                        }
                        $wherewo[] = 'wo.pns_wo_id IN ('.implode(',', $wo_id_delay).')';          
                }   
        }
        if(isset($wo_status) && $wo_status =="rma")
        {
                 $wherewo[] = 'wo.wo_rma_active =1';
        }
         $wo_id_rework = array();
        if(isset($wo_status) && $wo_status =="rework")
        {
                 $queryRework = 'select op.wo_id'.
                               ' from apdm_pns_wo_op op '.
                               ' inner join  apdm_pns_wo_op_visual vi on op.pns_op_id =vi.pns_op_id '.
                               ' where (op_visual_value1 != "" or op_visual_value2 != "" or op_visual_value3 != "" or op_visual_value4 != "" or op_visual_value5 != "") '.
                               ' and  op.op_code = "wo_step5"  group by op.wo_id';
                                ' union select op.wo_id'.
                                ' from apdm_pns_wo_op op '.
                                ' inner join  apdm_pns_wo_op_final fi on op.pns_op_id =fi.pns_op_id '.
                                ' where (op_final_value1 != "" or op_final_value2 != "" or op_final_value3 != "" or op_final_value4 != "" or op_final_value5 != "" or op_final_value6 != "" or op_final_value7 != "")'.
                                ' and  op.op_code = "wo_step6" group by op.wo_id';
                $db->setQuery($queryRework);                   
                $rswo_id_rework = $db->loadObjectList();
                if (count($rswo_id_rework) >0){
                        foreach ($rswo_id_rework as $wo){
                           $wo_id_rework[] = $wo->wo_id; 
                        }
                        $wherewo[] = 'wo.pns_wo_id IN ('.implode(',', $wo_id_rework).')';          
                }      
        }
        if($employee_id)
        {                
                $wherewo[] ="wo.wo_assigner = ".$employee_id;
        }
        if($time_from && $time_to)
        {
                $time_from = JHTML::_('date', $time_from, '%Y-%m-%d');
                $time_to = JHTML::_('date', $time_to, '%Y-%m-%d');
                $wherewo[] ="wo.wo_start_date > '".$time_from ."' and wo.wo_completed_date < '".$time_to."'";
        }
        else
        {               
                if($time_from)
                {                        
                        $time_from = JHTML::_('date', $time_from, '%Y-%m-%d');
                        $wherewo[] ="wo.wo_start_date > ".$time_from;
                }
                elseif($time_to)
                {
                        $time_to = JHTML::_('date', $time_to, '%Y-%m-%d');
                        $wherewo[] ="wo.wo_start_date > ".$time_from;
                }
        }
        
        if($wo_op_status)
        {                
                $wherewo[] ="wo.wo_state = '".$wo_op_status."'";
        }
                
        $where = ( count( $where ) ? ' WHERE (' . implode( ') and (', $where ) . ')' : '' );
        $wherewo1 = ( count( $wherewo ) ? ' WHERE (' . implode( ') and (', $wherewo ) . ')' : '' );

        $query = 'SELECT count(*) '.
             ' from apdm_pns_so so left join apdm_ccs ccs on so.customer_id = ccs.ccs_code'.
             ' left join apdm_pns_so_fk fk on so.pns_so_id = fk.so_id'.
             ' left join apdm_pns p on p.pns_id = fk.pns_id'.
              $where;
       //echo $query;
        $db->setQuery( $query );
        $total = $db->loadResult();

        jimport('joomla.html.pagination');
        $pagination = new JPagination( $total, $limitstart, $limit );
       
       $query = 'SELECT so.*,ccs.ccs_coordinator,ccs.ccs_code as ccs_so_code,fk.*,p.pns_uom,p.pns_cpn, p.pns_description,p.pns_cpn,p.pns_id,p.pns_stock,p.ccs_code, p.pns_code, p.pns_revision '.
               ' ,DATEDIFF(so.so_shipping_date, CURDATE()) as so_remain_date'.
             ' from apdm_pns_so so left join apdm_ccs ccs on so.customer_id = ccs.ccs_code'.
             ' left join apdm_pns_so_fk fk on so.pns_so_id = fk.so_id'.
             ' left join apdm_pns p on p.pns_id = fk.pns_id'.
              $where;
      
        $lists['query'] = base64_encode($query);   
        $lists['total_record'] = $total; 
        $db->setQuery( $query, $pagination->limitstart, $pagination->limit );
        //echo $db->getQuery();
        $rows = $db->loadObjectList(); 
              
        //search WO
        $rs_wo = array();
      //  var_dump($wherewo);
        
        if(count( $wherewo )>0){
        $sql = "select wo.pns_wo_id,p.pns_id,wo.wo_state,wo.wo_code,p.pns_description,p.ccs_code, p.pns_code, p.pns_revision,wo.wo_qty,p.pns_uom,wo.wo_start_date,wo.wo_completed_date,DATEDIFF(wo.wo_completed_date, CURDATE()) as wo_remain_date,wo.wo_delay,wo.wo_rework " .
                        " from apdm_pns_wo wo " .
                        " left join apdm_pns p on  p.pns_id = wo.pns_id " .
                        $wherewo1;
                $db->setQuery($sql);                   
                $rs_wo = $db->loadObjectList();    
             
        }
        // table ordering
        $lists['order_Dir']    = $filter_order_Dir;
        $lists['order']        = $filter_order;
        $lists['search']= $search;    
        $this->assignRef('rs_so',       $rows);
        $this->assignRef('rs_wo',       $rs_wo);
		
        $this->assignRef('search_swo_type',       $search_type);
		$this->assignRef('search_so',       $search_so);
        $this->assignRef('search_wo',       $search_wo);
        $this->assignRef('so_status',       $so_status);
        $this->assignRef('time_remain',       $time_remain);
        $this->assignRef('wo_status',       $wo_status);
        $this->assignRef('employee_id',       $employee_id);
        $this->assignRef('time_from',       $time_from);
        $this->assignRef('time_to',       $time_to);
        $this->assignRef('wo_op_status',       $wo_op_status);
        $db->setQuery("SELECT jos.id as value, jos.name as text FROM jos_users jos inner join apdm_users apd on jos.id = apd.user_id  WHERE user_enable=0 ORDER BY jos.username ");
                $list_users = $db->loadObjectList();
                $assigners[] = JHTML::_('select.option', 0, JText::_('Select Assigner'), 'value', 'text');
                $assigners = array_merge($assigners, $list_users);
        $list_user =  JHTML::_('select.genericlist', $assigners, 'employee_id', 'class="inputbox" size="1"', 'value', 'text', $employee_id);
        $this->assignRef('list_assigners',       $list_user);
        
        $this->assignRef('pagination',    $pagination);       
		parent::display($tpl);
	}
}

