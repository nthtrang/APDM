<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class SToViewuserinform extends JView {

        function display($tpl = null) {

                // global $mainframe, $option;
                $db = & JFactory::getDBO();
                $sto_id = JRequest::getVar('sto_id');
                JArrayHelper::toInteger($cid, array(0));
                $query = 'select count(*) from apdm_pns_sto_fk where pns_id !=0 and sto_id = '.$sto_id;
                $db->setQuery( $query );
                $total = $db->loadResult();
                $query = 'select count(*) from apdm_pns_sto_fk where pns_id !=0 and sto_id = '.$sto_id.' and qty!=0';
                $db->setQuery( $query );
                $totalFullFill = $db->loadResult();
                $checkFullFill =1;
                if($total == 0 || $total!=$totalFullFill)
                {
                      $checkFullFill=0;
                }
                $this->assignRef('checkFullFill',        $checkFullFill);
                parent::display($tpl);
        }

}

