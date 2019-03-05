<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class SToViewuserinform extends JView {

        function display($tpl = null) {

                // global $mainframe, $option;
                global $mainframe, $option;
                $option = 'com_apdmpns_sto';
                $db = & JFactory::getDBO();
                $cid = JRequest::getVar('cid', array(0), '', 'array');
                $sto_id = JRequest::getVar('sto_id');
                $me = JFactory::getUser();
                JArrayHelper::toInteger($cid, array(0));
                $query = 'select count(*) from apdm_pns_sto_fk where sto_id = '.$sto_id;
                $db->setQuery( $query );
                $total = $db->loadResult();
                $query = 'select count(*) from apdm_pns_sto_fk where sto_id = '.$sto_id.' and qty!=0';
                $db->setQuery( $query );
                $totalFullFill = $db->loadResult();
                $checkFullFill =1;
                if($total!=$totalFullFill)
                {
                      $checkFullFill=0;  
                }
                $this->assignRef('checkFullFill',        $checkFullFill);
                parent::display($tpl);
        }

}

