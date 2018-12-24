<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
defined('_JEXEC') or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class pnsViewwo extends JView
{
	function display($tpl = null)
	{
                
	   // global $mainframe, $option;
        global $mainframe, $option;
        $option             = 'com_apdmpns_so';
        $db                =& JFactory::getDBO();
        $cid		= JRequest::getVar( 'cid', array(0), '', 'array' );       
        $so_id		= JRequest::getVar( 'id');       
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
            $where[] = 'p.po_code LIKE '.$searchEscaped.' or p.po_description LIKE '.$searchEscaped.'';        
           
        }  
      
        $where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
        $orderby = ' ORDER BY p.pns_po_id desc';        
        $query = 'SELECT COUNT(p.pns_po_id)'
        . ' FROM apdm_pns_po AS p'
        . $where
        ;

        $db->setQuery( $query );
        $total = $db->loadResult();

        jimport('joomla.html.pagination');
        $pagination = new JPagination( $total, $limitstart, $limit );
        
        $query = 'SELECT p.* '
            . ' FROM apdm_pns_po AS p'
            . $where
            . $orderby;
        $lists['query'] = base64_encode($query);   
        $lists['total_record'] = $total; 
        $db->setQuery( $query, $pagination->limitstart, $pagination->limit );
        $rows = $db->loadObjectList(); 
        
        
        $db->setQuery("SELECT po.*, CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns AS p LEFT JOIN apdm_pns_po AS po on p.pns_id = po.pns_id WHERE p.pns_deleted =0 AND po.pns_id=".$cid[0]." order by po.pns_rev_id desc limit 1");              
        $list_pos = $db->loadObjectList();              
        $lists['pns_id']        = $cid[0];       
        $this->assignRef('pos',        $list_pos);
        
//         $db->setQuery("SELECT po.*, CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns_po AS po LEFT JOIN apdm_pns AS p on po.pns_id = p.pns_id");
//         $pos_list = $db->loadObjectList();         
//         $this->assignRef('pos_list',        $pos_list);     
        //for PO detailid
         $db->setQuery("SELECT fk.*,p.pns_uom, p.pns_description,p.pns_cpn,p.pns_id,p.pns_stock,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code,p.ccs_code, p.pns_code, p.pns_revision  FROM apdm_pns_so AS so inner JOIN apdm_pns_so_fk fk on so.pns_so_id = fk.so_id inner join apdm_pns AS p on p.pns_id = fk.pns_id where so.pns_so_id=".$so_id);
         $pns_list = $db->loadObjectList();         
         $this->assignRef('so_pn_list',        $pns_list);     
         
         $db->setQuery("SELECT * from apdm_pns_so where pns_so_id=".$so_id);
         $so_row =  $db->loadObject();
         $this->assignRef('so_row',        $so_row);
        
         //Status
        $statusValue = array();
        $statusValue[] = JHTML::_('select.option',  '', '- '. JText::_( 'Select' ) .' -', 'value', 'text'); 
        $statusValue[] = JHTML::_('select.option',  'inprogress', JText::_( 'In Progress' ) , 'value', 'text'); 
        $statusValue[] = JHTML::_('select.option',  'onhold', JText::_( 'On hold' ), 'value', 'text'); 
        $statusValue[] = JHTML::_('select.option',  'cancel',  JText::_( 'Cancel' ), 'value', 'text');
        $classDisabled = 'disabled = "disabled"';
        $defaultStatus = "inprogress";
        if($so_row->so_state)
                $defaultStatus=$so_row->so_state;
        $lists['soStatus'] = JHTML::_('select.genericlist', $statusValue, 'so_status', 'class="inputbox " '.$classDisabled.' size="1"', 'value', 'text',$defaultStatus);
        
         $arrStatus=array("inprogress"=>JText::_( 'In Progress' ),'onhold'=> JText::_( 'On hold' ),'cancel'=>  JText::_( 'Cancel' ));

         //Customer
         $cccpn[0] = JHTML::_('select.option',  0, '- '. JText::_( 'SELECT_CCS' ) .' -', 'value', 'text');
		$db->setQuery("SELECT  ccs_code  as value, CONCAT_WS(' :: ', ccs_code, ccs_name) as text FROM apdm_ccs WHERE ccs_deleted=0 AND ccs_activate= 1 and ccs_cpn = 1 ORDER BY ccs_code ");
		$ccscpn = array_merge($cccpn, $db->loadObjectList());
                $lists['ccscpn'] = JHTML::_('select.genericlist',   $ccscpn, 'customer_id', 'class="inputbox" size="1" onchange="getccsCoordinator(this.value)"', 'value', 'text', $so_row->customer_id );        
                //get ist imag/zip/pdf
                ///get list cad files
                $db->setQuery("SELECT * FROM apdm_pn_cad WHERE so_id=".$so_row->pns_so_id);
                $res = $db->loadObjectList();
                if (count($res)>0){
                        foreach ($res as $r){
                            $zips_files[] = array('id'=>$r->pns_cad_id, 'zip_file'=>$r->cad_file);
                        }
                }
                ///get list image files
                $db->setQuery("SELECT * FROM apdm_pns_image WHERE so_id=".$so_row->pns_so_id);
                $res = $db->loadObjectList();
                if (count($res)>0){
                        foreach ($res as $r){
                            $images_files[] = array('id'=>$r->pns_image_id, 'image_file'=>$r->image_file);
                        }
                }      
                ///get list pdf files
                $db->setQuery("SELECT * FROM apdm_pns_pdf WHERE so_id=".$so_row->pns_so_id);
                $res = $db->loadObjectList();
                if (count($res)>0){
                        foreach ($res as $r){
                            $pdf_files[] = array('id'=>$r->pns_pdf_id, 'pdf_file'=>$r->pdf_file);
                        }
                }  
                $lists['zips_files'] = $zips_files;
                $lists['image_files'] = $images_files;
                $lists['pdf_files'] = $pdf_files;            
                $lists['search']= $search;    
                $this->assignRef('lists',        $lists);
                $this->assignRef('arr_status',        $arrStatus);

                $this->assignRef('so_list',        $rows);
                $this->assignRef('pagination',    $pagination);    
                parent::display($tpl);
	}
}

