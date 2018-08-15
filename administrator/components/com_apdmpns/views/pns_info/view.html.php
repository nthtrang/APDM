<?php
defined('_JEXEC') or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class pnsViewpns_info extends JView
{
	function display($tpl = null)
	{
        

		$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );       
                $cd         = JRequest::getVar('cd');  
		$edit		= JRequest::getVar('edit',true);
		$me 		= JFactory::getUser();
		JArrayHelper::toInteger($cid, array(0));		
		$db 		=& JFactory::getDBO();
		$row = & JTable::getInstance('apdmpns');
		$arr_parent = array();
        $arr_vendor = array();
        $arr_supplier = array();
        $arr_mf = array();
        $arr_info_exist = array();
        $arr_info_exist[] = 0;
        $cads_files = array();
        $arr_parent_info = array();
		if($edit){
			$row->load($cid[0]);                                     
            //get array parent part number
            $db->setQuery("SELECT pr.id, pr.pns_id, CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns AS p on pr.pns_id = p.pns_id LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code  WHERE c.ccs_activate=1 AND c.ccs_deleted = 0 AND p.pns_deleted =0 AND pr.pns_parent=".$row->pns_id);
            $list_parent = $db->loadObjectList();
            if (count($list_parent) > 0){
                foreach($list_parent as $p){
                    $arr_parent[] = $p->pns_id;
                    $arr_parent_info[] = array("pns_id"=>$p->pns_id, "pns_code"=>$p->parent_pns_code, 'id'=>$p->id);
                }
            }else{
                $arr_parent[] =0;
            }
            $lists['pns_parent_info'] = $arr_parent_info;
			//get array where user : new fucntio
//echo "SELECT pr.id, pr.pns_parent, CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns AS p on pr.pns_parent = p.pns_id LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code  WHERE c.ccs_activate=1 AND c.ccs_deleted = 0 AND p.pns_deleted =0 AND pr.pns_id=".$row->pns_id;
            $db->setQuery("SELECT pr.id, pr.pns_parent, CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns AS p on pr.pns_parent = p.pns_id LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code  WHERE c.ccs_activate=1 AND c.ccs_deleted = 0 AND p.pns_deleted =0 AND pr.pns_id=".$row->pns_id);
            $list_where_use = $db->loadObjectList();
			$arr_where_use = array();
			if (count($list_where_use) > 0){
				foreach ($list_where_use as $w){
					$arr_where_use[] = array("id"=>$w->pns_parent, "pns_code"=>$w->parent_pns_code);
				}
			}
			$lists['where_use'] = $arr_where_use;
            ///get list parenrt code to view
            $db->setQuery("SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code FROM apdm_pns AS p  LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code WHERE c.ccs_activate= 1 AND c.ccs_deleted=0 AND p.pns_deleted =0  AND p.pns_id IN (".implode(",", $arr_parent).")  ORDER BY parent_pns_code ");
			
            $parent_code_detail = $db->loadObjectList();
            $arr_parent_code_detail = array();
            if (count($parent_code_detail) > 0){
                foreach ($parent_code_detail as $pr){
                    $parent_code_detail_code = $pr->parent_pns_code;
                     if (substr($parent_code_detail_code, -1)=="-"){
                       $parent_code_detail_code = substr($parent_code_detail_code, 0, strlen($parent_code_detail_code)-1);  
                     }
                     $arr_parent_code_detail[] = $parent_code_detail_code;
                }
            }
            //get list vendor have exist
            $db->setQuery("SELECT s.id, s.supplier_id, s.supplier_info, s.type_id, info.info_name FROM apdm_pns_supplier as s LEFT JOIN apdm_supplier_info as info On info.info_id=s.supplier_id WHERE info.info_deleted=0 AND info.info_activate=1 AND s.pns_id=".$row->pns_id);
            $result = $db->loadObjectList();
           
            if (count($result)){
                foreach ($result as $r){
                    if($r->type_id == 2){
                        $arr_vendor[] = array('id'=>$r->id, 'v_id'=>$r->supplier_id, 'v_name'=>$r->info_name, 'v_value'=>$r->supplier_info);
                    }
                    if($r->type_id == 3){
                        $arr_supplier[] = array('id'=>$r->id, 's_id'=>$r->supplier_id, 's_name'=>$r->info_name, 's_value'=>$r->supplier_info);
                    }
                    if($r->type_id == 4){
                        $arr_mf[] = array('id'=>$r->id, 'm_id'=>$r->supplier_id, 'm_name'=>$r->info_name, 'm_value'=>$r->supplier_info);
                    }
                    $arr_info_exist[] = $r->supplier_id;
                }
            }
            ///get list cad files
            $db->setQuery("SELECT * FROM apdm_pn_cad WHERE pns_id=".$row->pns_id);
            $res = $db->loadObjectList();
            if (count($res)>0){
                foreach ($res as $r){
                    $cads_files[] = array('id'=>$r->pns_cad_id, 'cad_file'=>$r->cad_file);
                }
            }
            ///get list image files
            $db->setQuery("SELECT * FROM apdm_pns_image WHERE pns_id=".$row->pns_id);
            $res = $db->loadObjectList();
            if (count($res)>0){
                foreach ($res as $r){
                    $images_files[] = array('id'=>$r->pns_image_id, 'image_file'=>$r->image_file);
                }
            }      
            ///get list pdf files
            $db->setQuery("SELECT * FROM apdm_pns_pdf WHERE pns_id=".$row->pns_id);
            $res = $db->loadObjectList();
            if (count($res)>0){
                foreach ($res as $r){
                    $pdf_files[] = array('id'=>$r->pns_pdf_id, 'pdf_file'=>$r->pdf_file);
                }
            }                  
		}     
		//get list commodity code
		$cc[0] = JHTML::_('select.option',  0, '- '. JText::_( 'SELECT_CCS' ) .' -', 'value', 'text');
		$db->setQuery("SELECT  ccs_code  as value, CONCAT_WS(' :: ', ccs_code, ccs_description) as text FROM apdm_ccs WHERE ccs_deleted=0 AND ccs_activate= 1 and ccs_cpn = 0 ORDER BY ccs_code ");
	//	echo "SELECT CONCAT_WS(' :: ', ccs_code, ccs_description) as value, ccs_code as text FROM apdm_ccs WHERE ccs_deleted=0 AND ccs_activate= 1 ORDER BY ccs_code ";
		$ccs = array_merge($cc, $db->loadObjectList());
                $lists['ccs'] = JHTML::_('select.genericlist',   $ccs, 'ccs_code', 'class="inputbox" size="1"', 'value', 'text', $row->ccs_code );
                //get list commodity code for CPN
		$cccpn[0] = JHTML::_('select.option',  0, '- '. JText::_( 'SELECT_CCS' ) .' -', 'value', 'text');
		$db->setQuery("SELECT  ccs_code  as value, CONCAT_WS(' :: ', ccs_code, ccs_name) as text FROM apdm_ccs WHERE ccs_deleted=0 AND ccs_activate= 1 and ccs_cpn = 1 ORDER BY ccs_code ");
		$ccscpn = array_merge($cccpn, $db->loadObjectList());
                $lists['ccscpn'] = JHTML::_('select.genericlist',   $ccscpn, 'ccs_code', 'class="inputbox" size="1"', 'value', 'text', $row->ccs_code );        
		//get list pns to display parrent        
        //get list eco
        $eco[0] = JHTML::_('select.option',  0, '- '. JText::_( 'SELECT_ECO' ) .' -', 'value', 'text');
        $db->setQuery("SELECT eco_id as value, eco_name as text FROM apdm_eco WHERE eco_deleted=0 AND eco_status= 1 ORDER BY eco_name ");
        $ecos = array_merge($eco, $db->loadObjectList());
        $lists['eco'] = JHTML::_('select.genericlist',   $ecos, 'eco_id', 'class="inputbox" size="1"', 'value', 'text', $row->eco_id );
		//get list pns_type       
		$pns_type_get = ($row->pns_id) ? trim($row->pns_type) : 'Making';
                $pns_type[] = JHTML::_( 'select.option', 'Make', 'Make', 'value', 'text' );
                $pns_type[] = JHTML::_( 'select.option', 'Buy', 'Buy', 'value', 'text' ); 
                $pns_type[] = JHTML::_( 'select.option', 'Reference', 'Reference', 'value', 'text' );          
		$lists['pns_type'] 	= JHTML::_('select.genericlist', $pns_type, 'pns_type', 'class="inputbox" size="1"', 'value', 'text', $pns_type_get );
        //get list vendor
        $vd[] = JHTML::_('select.option', 0, JText::_('SELECT_VENDOR'), 'value', 'text' );
        $db->setQuery("SELECT info_id AS value, info_name AS text FROM apdm_supplier_info WHERE info_type=2 AND info_activate=1 AND info_id NOT IN (".implode(",", $arr_info_exist).") AND info_deleted=0 ORDER BY info_name");
        $nvd = $db->loadObjectList();
        if(count($nvd)>10){
            $lists['count_vd'] =10;
        }else{
            $lists['count_vd'] = count($nvd);
        }
        
        $vds = array_merge($vd, $nvd);
        $lists['vd'] = JHTML::_('select.genericlist',   $vds, 'vendor_id[]', 'class="inputbox" size="1"', 'value', 'text' );
         //get list supplier
        $sp[] = JHTML::_('select.option', 0, JText::_('SELECT_SUPPLIER'), 'value', 'text' );
        $db->setQuery("SELECT info_id AS value, info_name AS text FROM apdm_supplier_info WHERE info_type=3 AND info_activate=1 AND info_deleted=0 AND info_id NOT IN (".implode(",", $arr_info_exist).") ORDER BY info_name");
        $nspp = $db->loadObjectList();
       
        if(count($nspp)>10){
            $lists['count_sp'] =10;
        }else{
            $lists['count_sp'] = count($nspp);
        }
        
        $spps = array_merge($sp, $nspp);
        $lists['spp'] = JHTML::_('select.genericlist',   $spps, 'supplier_id[]', 'class="inputbox" size="1"', 'value', 'text' );
        
         //get list manufacture
        $mf[] = JHTML::_('select.option', 0, JText::_('SELECT_MF'), 'value', 'text' );
        $db->setQuery("SELECT info_id AS value, info_name AS text FROM apdm_supplier_info WHERE info_type=4 AND info_activate=1 AND info_deleted=0 AND info_id NOT IN (".implode(",", $arr_info_exist).") ORDER BY info_name");
        $nmf = $db->loadObjectList();
        if(count($nmf)>10){
            $lists['count_mf'] =10;
        }else{
            $lists['count_mf'] = count($nmf);
        }
        
        $mfs = array_merge($mf, $nmf);
        
        $lists['mf'] = JHTML::_('select.genericlist',   $mfs, 'manufacture_id[]', 'class="inputbox" size="1"', 'value', 'text' );
        //GET list status of PNS
        $status[] = JHTML::_('select.option',  '', '- '. JText::_( 'SELECT_STATUS' ) .' -', 'value', 'text'); 
//        $status[] = JHTML::_('select.option',  'Approval', JText::_( 'Approval' ) , 'value', 'text'); 
//        $status[] = JHTML::_('select.option',  'Cbsolete', JText::_( 'Cbsolete' ), 'value', 'text'); 
//        $status[] = JHTML::_('select.option',  'Pending',  JText::_( 'Pending' ), 'value', 'text'); 
//        $status[] = JHTML::_('select.option',  'Reject',  JText::_( 'Reject' ), 'value', 'text'); 
//        $status[] = JHTML::_('select.option',  'Release', JText::_( 'Release' ), 'value', 'text'); 
//        $status[] = JHTML::_('select.option',  'Submit', JText::_( 'Submit' ), 'value', 'text'); 
        
        $status[] = JHTML::_('select.option',  'Active', JText::_( 'Active' ) , 'value', 'text'); 
        $status[] = JHTML::_('select.option',  'Inactive', JText::_( 'Inactive' ), 'value', 'text'); 
        $status[] = JHTML::_('select.option',  'Obsolete',  JText::_( 'Obsolete' ), 'value', 'text'); 
        $status[] = JHTML::_('select.option',  'DoNotUse',  JText::_( ' Do Not Use' ), 'value', 'text'); 
        $status[] = JHTML::_('select.option',  'Engineering', JText::_( 'Engineering' ), 'value', 'text');         
        //check if status is released => disable option
        $classDisabled = "";
        if($row->pns_life_cycle=='Released')
            $classDisabled = 'disabled = "disabled"';    
        $lists['status'] = JHTML::_('select.genericlist',   $status, 'pns_status', 'class="inputbox" size="1" '.$classDisabled.'', 'value', 'text', $row->pns_status );
        //for edit pns
         $lists['arr_v'] = $arr_vendor;
         $lists['arr_s'] = $arr_supplier;
         $lists['arr_m'] = $arr_mf;
         $lists['cads_files'] = $cads_files;
         $lists['image_files'] = $images_files;
         $lists['pdf_files'] = $pdf_files;
         
		$this->assignRef('lists',	$lists);
		$this->assignRef('row',	$row);
        $this->assignRef('arr_parent_code_detail', $arr_parent_code_detail);
        $this->assignRef('cd', $cd);
        $this->assignRef('pns_status', $row->pns_status);
        //viet add life cycle
        $lifeValue[] = JHTML::_('select.option',  '', '- '. JText::_( 'SELECT_LIFE_CYCLE' ) .' -', 'value', 'text'); 
        $lifeValue[] = JHTML::_('select.option',  'Create', JText::_( 'Create' ) , 'value', 'text'); 
        $lifeValue[] = JHTML::_('select.option',  'Inreview', JText::_( 'In Review' ), 'value', 'text'); 
        $lifeValue[] = JHTML::_('select.option',  'Released',  JText::_( 'Released' ), 'value', 'text');
        $classDisabled = 'disabled = "disabled"';
        $lists['life_cycle'] = JHTML::_('select.genericlist',   $lifeValue, 'pns_life_cycle', 'class="inputbox " '.$classDisabled.' size="1"', 'value', 'text',$row->pns_life_cycle );
        $this->assignRef('pns_life_cycle', $row->pns_life_cycle);
        //viet add pns_uom
        $uomValue[] = JHTML::_('select.option',  '', '- '. JText::_( 'SELECT_UOM' ) .' -', 'value', 'text'); 
        $uomValue[] = JHTML::_('select.option',  'Each', JText::_( 'Each (ea)' ) , 'value', 'text'); 
        $uomValue[] = JHTML::_('select.option',  'Undefined', JText::_( 'Undefined' ), 'value', 'text'); 
        $uomValue[] = JHTML::_('select.option',  'Meter',  JText::_( 'Meter (m)' ), 'value', 'text');
        $uomValue[] = JHTML::_('select.option',  'Centimeter',  JText::_( 'Centimeter (cm)' ), 'value', 'text');
        $uomValue[] = JHTML::_('select.option',  'Foot',  JText::_( 'Foot (ft)' ), 'value', 'text');
        $uomValue[] = JHTML::_('select.option',  'Inch',  JText::_( 'Inch (in)' ), 'value', 'text');
        $uomValue[] = JHTML::_('select.option',  'Gram',  JText::_( 'Gram (g)' ), 'value', 'text');
        $uomValue[] = JHTML::_('select.option',  'Kilogram',  JText::_( 'Kilogram (Kg)' ), 'value', 'text');
        $uomValue[] = JHTML::_('select.option',  'Lbin',  JText::_( 'Lbin' ), 'value', 'text');
        $lists['uom'] = JHTML::_('select.genericlist',   $uomValue, 'pns_uom', 'class="inputbox" size="1"', 'value', 'text',$row->pns_uom );
        $lists['pns_cost'] = $row->pns_cost;
        $lists['pns_datein'] = $row->pns_datein;
        $lists['pns_stock'] = $row->pns_stock;
        $lists['pns_qty_used'] = $row->pns_qty_used;
        //For revision
            $db->setQuery("SELECT prev.*,eco.eco_name, CONCAT_WS( '-', prev.ccs_code, prev.pns_code, prev.pns_revision ) AS parent_pns_code  FROM apdm_pns AS p LEFT JOIN apdm_pns_rev AS prev on p.pns_id = prev.pns_id left join apdm_eco eco on eco.eco_id = p.eco_id WHERE p.pns_deleted =0 AND prev.pns_id=".$row->pns_id);
            $list_revision = $db->loadObjectList();
         $this->assignRef('revision',        $list_revision);
         
         //add PO
         $db->setQuery("SELECT po.*, fk.qty as stock,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns AS p inner JOIN apdm_pns_po_fk fk on p.pns_id = fk.pns_id inner join apdm_pns_po AS po on po.pns_po_id = fk.po_id WHERE fk.pns_id=".$row->pns_id);
         $list_pos = $db->loadObjectList();         
         $this->assignRef('pos',        $list_pos);
         //add Quo
         $db->setQuery("SELECT quo.*, CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns AS p LEFT JOIN apdm_pns_quo AS quo on p.pns_id = quo.pns_id WHERE p.pns_deleted =0 AND quo.pns_id=".$row->pns_id);
         $list_quos = $db->loadObjectList();         
         $this->assignRef('quos',        $list_quos);
                  
         //for STO Tracking
         $db->setQuery("select sto.*,fk.qty as stock from apdm_pns_sto_fk fk inner join apdm_pns pn on fk.pns_id = pn.pns_id  inner join apdm_pns_sto sto on sto.pns_sto_id = fk.sto_id where fk.pns_id=".$row->pns_id);
         $list_stos = $db->loadObjectList();         
         $this->assignRef('stos',        $list_stos);
                           
         
         $db->setQuery("SELECT ccs.ccs_name  FROM apdm_ccs AS ccs WHERE ccs.ccs_code ='".$row->ccs_code."'");         
         $list_ccs = $db->loadObjectList();               
         $this->assignRef('ccs_name',         $list_ccs[0]->ccs_name);
         
              $this->assignRef('pns_uom', $row->pns_uom);             
        parent::display($tpl);
	}
}
