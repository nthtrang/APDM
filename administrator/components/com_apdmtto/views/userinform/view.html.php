<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class TToViewuserinform extends JView {

        function display($tpl = null) {

                // global $mainframe, $option;
                global $mainframe, $option;
                $option = 'com_apdmpns_sto';
                $db = & JFactory::getDBO();
                $cid = JRequest::getVar('cid', array(0), '', 'array');
                $tto_id = JRequest::getVar('tto_id');
                $tto_type_inout		=  JRequest::getVar( 'tto_type_inout');
                //check if click = 2
                $isOutConfirm = 1;
                $tto_owner_out = 0;
                if($tto_type_inout==1)//confirm in
                {
                        $query = 'select *  FROM apdm_pns_tto where pns_tto_id  = '.$tto_id;
                        $db->setQuery( $query );
                        $tto_row =  $db->loadObject();
                        $isOutConfirm = $tto_row->tto_owner_out_confirm;
                        $tto_owner_out = $tto_row->tto_owner_out;
                }                
                $me = JFactory::getUser();
                JArrayHelper::toInteger($cid, array(0));

                $query = 'select count(*) from apdm_pns_tto_fk where tto_id = '.$tto_id . ' and tto_type_inout = 2';
                $db->setQuery( $query );
                $total = $db->loadResult();
                $query = 'select count(*) from apdm_pns_tto_fk where tto_id = '.$tto_id.' and tto_type_inout =  2 and qty!=0';
                $db->setQuery( $query );
                $totalFullFill = $db->loadResult();
                $checkFullFill =1;
                if($total == 0 || $total!=$totalFullFill)
                {
                      $checkFullFill=0;  
                }
                $this->assignRef('checkFullFill',        $checkFullFill);   
                $this->assignRef('isOutConfirm',        $isOutConfirm);
                $this->assignRef('userOutConfirm',        $tto_owner_out);
                
                parent::display($tpl);
        }

}

