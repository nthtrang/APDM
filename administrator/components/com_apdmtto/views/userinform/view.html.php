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
                if($tto_type_inout==1)
                {
                        $query = 'select tto_owner_out_confirm FROM apdm_pns_tto where pns_tto_id  = '.$tto_id;
                        $db->setQuery( $query );
                        $isOutConfirm = $db->loadResult();
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
                
                parent::display($tpl);
        }

}

