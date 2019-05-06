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
ini_set('display_errors', 1);
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
class SToViewito extends JView
{
	function display($tpl = null)
	{
                
	   // global $mainframe, $option;
        global $mainframe, $option;
        $option             = 'com_apdmpns_sto';
        $db                =& JFactory::getDBO();
        $cid		= JRequest::getVar( 'cid', array(0), '', 'array' );       
        $sto_id		= JRequest::getVar( 'id');       
        $me 		= JFactory::getUser();
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
        
        $db->setQuery("SELECT pns_sto_id,sto_code,sto_po_internal,sto_description,sto_state,sto_created,sto_create_by,sto_completed_date,sto_type,sto_owner,sto_stocker,sto_supplier_id,sto_owner_confirm  from apdm_pns_sto where pns_sto_id=".$sto_id);         
         $sto_row =  $db->loadObject();
        
        $db->setQuery("SELECT sto.*, p.ccs_code, p.pns_code, p.pns_revision,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns AS p LEFT JOIN apdm_pns_sto AS sto on p.pns_id = sto.pns_id WHERE p.pns_deleted =0 AND sto.pns_id=".$cid[0]." order by sto.pns_rev_id desc limit 1");              
        $list_stos = $db->loadObjectList();              
        $lists['pns_id']        = $cid[0];       
        $this->assignRef('stos',        $list_stos);
        
        $db->setQuery("SELECT * FROM jos_users jos inner join apdm_users apd on jos.id = apd.user_id  WHERE user_enable=0 ORDER BY jos.username ");
	$list_user = $db->loadObjectList();	
//         $db->setQuery("SELECT po.*, CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns_po AS po LEFT JOIN apdm_pns AS p on po.pns_id = p.pns_id");
//         $pos_list = $db->loadObjectList();         
//         $this->assignRef('pos_list',        $pos_list);     
//         get supplier         
        $csupplier[0] = JHTML::_('select.option', 0, '- ' . JText::_('Select Supplier') . ' -', 'value', 'text');
        $db->setQuery("SELECT info_id as value,info_name as text FROM apdm_supplier_info s WHERE s.info_type= 3 and s.info_deleted = 0 and s.info_activate = 1");                                      
        $csupplier = array_merge($csupplier, $db->loadObjectList());        
        $lists['ccsupplier'] = JHTML::_('select.genericlist', $csupplier, 'sto_supplier_id', 'class="inputbox" size="1"', 'value', 'text', $sto_row->sto_supplier_id);
        //for PO detailid

         $db->setQuery("SELECT fk.id,fk.qty,fk.location,fk.partstate,p.pns_uom, p.pns_description,p.pns_cpn,p.pns_id,p.pns_stock,p.ccs_code, p.pns_code, p.pns_revision,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns_sto AS sto inner JOIN apdm_pns_sto_fk fk on sto.pns_sto_id = fk.sto_id inner join apdm_pns AS p on p.pns_id = fk.pns_id where sto.pns_sto_id=".$sto_id." group by fk.pns_id order by fk.pns_id desc");
         $pns_list = $db->loadObjectList();         
         $this->assignRef('sto_pn_list',        $pns_list);
         $db->setQuery("SELECT sto.*,fk.id,fk.qty,fk.location,fk.partstate,fk.qty_from,fk.location_from,fk.pns_mfg_pn_id , p.pns_description,p.pns_cpn,p.pns_id,p.pns_stock,p.ccs_code, p.pns_code, p.pns_revision,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns_sto AS sto inner JOIN apdm_pns_sto_fk fk on sto.pns_sto_id = fk.sto_id inner join apdm_pns AS p on p.pns_id = fk.pns_id where sto.pns_sto_id=".$sto_id." order by fk.pns_id desc");
         $pns_list2 = $db->loadObjectList();                  
         $this->assignRef('sto_pn_list2',        $pns_list2);
         
//get ist imag/zip/pdf
                ///get list zip files
                $db->setQuery("SELECT * FROM apdm_pns_sto_files WHERE  file_type = 0 and sto_id=" . $sto_row->pns_sto_id);                 
                $res = $db->loadObjectList();
                if (count($res) > 0) {
                        foreach ($res as $r) {
                                $zips_files[] = array('id' => $r->id, 'zip_file' => $r->file_name);
                        }
                }
                ///get list image files
                $db->setQuery("SELECT * FROM apdm_pns_sto_files WHERE  file_type = 2 and sto_id=" . $sto_row->pns_sto_id);
                $res = $db->loadObjectList();
                if (count($res) > 0) {
                        foreach ($res as $r) {
                                $images_files[] = array('id' => $r->id, 'image_file' => $r->file_name);
                        }
                }
                ///get list pdf files
                $db->setQuery("SELECT * FROM apdm_pns_sto_files WHERE  file_type = 1 and sto_id=" . $sto_row->pns_sto_id);
                $res = $db->loadObjectList();
                if (count($res) > 0) {
                        foreach ($res as $r) {
                                $pdf_files[] = array('id' => $r->id, 'pdf_file' => $r->file_name);
                        }
                }		 
         
        $this->assignRef('sto_row',        $sto_row);
        $lists['zips_files'] = $zips_files;
        $lists['image_files'] = $images_files;
        $lists['pdf_files'] = $pdf_files;		
        $lists['search']= $search;    
        $this->assignRef('lists',        $lists);
        $this->assignRef('stos_list',        $rows);
        $this->assignRef('pagination',    $pagination);  
        $this->assignRef('list_user',	$list_user);
		parent::display($tpl);
	}
}

