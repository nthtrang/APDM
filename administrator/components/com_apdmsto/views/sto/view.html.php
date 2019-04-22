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

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the Users component
 *
 * @static
 * @package		Joomla
 * @subpackage	Users
 * @since 1.0
 */
class SToViewsto extends JView
{
	function display($tpl = null)
	{
                
	   // global $mainframe, $option;
        global $mainframe, $option;
        $option             = 'com_apdmsto_sto';
        $db                =& JFactory::getDBO();
        $cid		= JRequest::getVar( 'cid', array(0), '', 'array' );       
        $sto_id		= JRequest::getVar( 'id');
        
        
        JArrayHelper::toInteger($cid, array(0));	       
         $search                = $mainframe->getUserStateFromRequest( "$option.text_search", 'text_search', '','string' );
        $search                = JString::strtolower( $search );
        $limit        = $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
        $limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
        $where = array();      
        if (isset( $search ) && $search!= '')
        {
          //  $searchEscaped = $db->Quote( '%'.$db->getEscaped( $search, false ).'%', false );
        //    $where[] = 'p.sto_code LIKE '.$searchEscaped.' or p.sto_description LIKE '.$searchEscaped.'';        
           
        }
        else
        {
                $where[] = 'p.sto_type = 2 and p.sto_state != "Done"';
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
       // $db->setQuery( $query, $pagination->limitstart, $pagination->limit );
         $db->setQuery( $query );
        $rows = $db->loadObjectList(); 
        
        
//        $db->setQuery("SELECT sto.*, p.ccs_code, p.pns_code, p.pns_revision  FROM apdm_pns AS p LEFT JOIN apdm_pns_sto AS sto on p.pns_id = sto.pns_id WHERE p.pns_deleted =0 AND sto.pns_id=".$cid[0]." order by sto.pns_rev_id desc limit 1");              
//        $list_stos = $db->loadObjectList();              
//        $lists['pns_id']        = $cid[0];       
//        $this->assignRef('stos',        $list_stos);
        
        //get list warehouse
        $qty_from	=       JRequest::getVar( 'qty_from');
        $qty_to		=       JRequest::getVar( 'qty_to');
        $pn_code_wr     =       JRequest::getVar( 'pn_code_wr');
        $clean		= JRequest::getVar( 'clean');
        if($clean=="all")
        {
           $qty_from = $qty_to= $pn_code_wr= "";     
        }
        $where = "where p.pns_deleted = 0 and  p.pns_stock + (inventory_in.qty_in - inventory_out.qty_out) <= 10 and  p.pns_stock + (inventory_in.qty_in - inventory_out.qty_out) >0";
        if($qty_from && $qty_to)
        {
                $where = "where p.pns_deleted = 0 and  p.pns_deleted = 0 and p.pns_stock + (inventory_in.qty_in - inventory_out.qty_out) >= ".$qty_from;
                $where .= " and p.pns_stock + (inventory_in.qty_in - inventory_out.qty_out) <= ".$qty_to;
        }
        elseif($qty_to)
        {
                $where = "where p.pns_deleted = 0 and  p.pns_stock + (inventory_in.qty_in - inventory_out.qty_out) <= ".$qty_to;
        }
        elseif($qty_from)
        {
                $where = "where p.pns_deleted = 0 and  p.pns_stock + (inventory_in.qty_in - inventory_out.qty_out) >= ".$qty_from;
        }
        $wherePN = "";
        if($pn_code_wr)
        {
                $pn_id = getPnsIdfromPnCode($pn_code_wr);
                if($pn_id)
                {
                        $arr_mf_id = array();
                         //echo 'SELECT * FROM apdm_supplier_info ASI LEFT JOIN apdm_pns_supplier APS ON ASI.info_id = APS.supplier_id WHERE ASI.info_deleted=0 AND ASI.info_type =4 AND (APS.supplier_info LIKE '.$searchEscaped.'OR ASI.info_description LIKE '.$searchEscaped.' ) group by ASI.info_id';
                        $db->setQuery('SELECT * FROM apdm_supplier_info ASI LEFT JOIN apdm_pns_supplier APS ON ASI.info_id = APS.supplier_id WHERE ASI.info_deleted=0 AND ASI.info_type =4 AND APS.pns_id = "'.$pn_id.'" group by ASI.info_id');
                        
                        $rs_mf = $db->loadObjectList();   
                    
                    if (count($rs_mf) > 0){
                        foreach ($rs_mf as $mf){
                           $arr_mf_id[] = $mf->info_id;
                        }
                        $arr_mf_id = array_unique($arr_mf_id);                       

                        $db->setQuery("SELECT pns_id FROM apdm_pns_supplier WHERE type_id = 4 AND supplier_id IN (".implode(",",$arr_mf_id).")");
                        $rs_ps_mf = $db->loadObjectList();
                        $pns_id_mf = array();
                       
                        if(count($rs_ps_mf) > 0){
                                foreach ($rs_ps_mf as $obj){
                                    $pns_id_mf[] = $obj->pns_id;        
                                }
                                $pns_id_mf = array_unique($pns_id_mf);
                                $wherePN = ' AND p.pns_deleted = 0 and p.pns_id IN ('.implode(',', $pns_id_mf).')';
                        }else{
                                $wherePN = ' AND p.pns_deleted = 0 and p.pns_id IN ('.$pn_id.')';
                        }           
                    }                       
                }
        }
        $query = "select inventory_in.*,inventory_out.*,p.pns_stock,p.pns_stock + (inventory_in.qty_in - inventory_out.qty_out) as inventory,p.* from apdm_pns p "
                ." inner join( select sum(fk1.qty) as qty_in,fk1.pns_id from  apdm_pns_sto_fk fk1 left join apdm_pns_sto sto1 on sto1.pns_sto_id = fk1.sto_id where sto1.sto_type=1 group by fk1.pns_id) inventory_in "
                ." on p.pns_id = inventory_in.pns_id"
                ." inner join( select sum(fk2.qty) as qty_out,fk2.pns_id  from  apdm_pns_sto_fk fk2 left join apdm_pns_sto sto2 on sto2.pns_sto_id = fk2.sto_id and sto2.sto_type=2 group by fk2.pns_id) inventory_out "
                ." on p.pns_id = inventory_out.pns_id "
                //." where p.pns_stock + (inventory_in.qty_in - inventory_out.qty_out) < 10";
                .$where
                ."  group by p.pns_id order by p.pns_id desc  limit 100";



        $query = 'SELECT p.* '
            . ' FROM apdm_pns AS p'
            . ' where p.pns_id in (select fk.pns_id from apdm_pns_sto_fk fk) '.$wherePN 
        ;
        
        $db->setQuery($query);
        $warehouse = $db->loadObjectList();

        $lists['search']= $search;    
        $this->assignRef('lists',        $lists);
        $this->assignRef('stos_list',        $rows);
        $this->assignRef('qty_to',        $qty_to);
        $this->assignRef('qty_from',        $qty_from);
        $this->assignRef('pn_code_wr',        $pn_code_wr);
         $this->assignRef('warehouse_list',        $warehouse);
        $this->assignRef('pagination',    $pagination);  

		parent::display($tpl);
	}
}

