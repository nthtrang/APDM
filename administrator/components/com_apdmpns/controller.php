<?php
/**
 * PNS Component Controller
 *
 * @package		APDM
 * @subpackage	PNS
 * @since 1.5
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
require_once('includes/class.upload.php');
require_once('includes/download.class.php');
require_once('includes/zip.class.php');
require_once('includes/system_defines.php');
ini_set('display_errors', 0);

class PNsController extends JController {

        /**
         * Constructor
         *
         * @params	array	Controller configuration array
         */
        function __construct($config = array()) {
                parent::__construct($config);
                // Register Extra tasks
                $this->registerTask('add', 'display');
                $this->registerTask('edit', 'display');
                $this->registerTask('detail', 'display');
                $this->registerTask('apply', 'save');
                $this->registerTask('remove_info', 'remove_info');
                $this->registerTask('unblock', 'block');
                $this->registerTask('listpns', 'list_pns');
                $this->registerTask('export', 'export');
                $this->registerTask('multi_upload', 'multi_upload');
                $this->registerTask('next_upload', 'next_upload');
                $this->registerTask('next_upload_step2', 'next_upload_step2');
                $this->registerTask('ajax_list_pns', 'ajax_list_pns');
                $this->registerTask('list_child', 'list_child');
                $this->registerTask('list_where_used', 'list_where_used');
                $this->registerTask('ajax_list_bom_child', 'ajax_list_bom_child');
                $this->registerTask('bom', 'bom');
                $this->registerTask('whereused', 'whereused');
                $this->registerTask('specification', 'specification');
                $this->registerTask('mep', 'mep');
                $this->registerTask('rev', 'rev');
                $this->registerTask('update_rev_roll', 'update_rev_roll');
                $this->registerTask('save_rev_roll', 'save_rev_roll');
                $this->registerTask('dash', 'dash');
                $this->registerTask('get_dash_up', 'get_dash_up');
                $this->registerTask('searchall', 'searchall');
                $this->registerTask('po', 'po');
                $this->registerTask('pomanagement', 'pomanagement');
                $this->registerTask('locatecode', 'locatecode');
                $this->registerTask('save_sales_order', 'save_sales_order');
                $this->registerTask('searchadvance', 'searchadvance');
                $this->registerTask('sto', 'sto');
                
                
                
                
        }

        /**
         * Displays a view
         */
        function display() {
                switch ($this->getTask()) {
                        case 'addpncus' : {
                                        JRequest::setVar('layout', 'formcus');
                                        JRequest::setVar('view', 'pns_info');
                                        JRequest::setVar('edit', false);
                                } break;
                        case 'add' : {
                                        JRequest::setVar('layout', 'form');
                                        JRequest::setVar('view', 'pns_info');
                                        JRequest::setVar('edit', false);
                                } break;
                        case 'edit' : {
                                        JRequest::setVar('layout', 'form_edit');
                                        JRequest::setVar('view', 'pns_info');
                                        JRequest::setVar('edit', true);
                                } break;
                        case 'editmpn' : {
                                        JRequest::setVar('layout', 'formcus_edit');
                                        JRequest::setVar('view', 'pns_info');
                                        JRequest::setVar('edit', true);
                                } break;                        
                        case 'detail': {

                                        JRequest::setVar('layout', 'detail');
                                        JRequest::setVar('view', 'pns_info');
                                        JRequest::setVar('edit', true);
                                }
                                break;
                        case 'detailmpn': {

                                        JRequest::setVar('layout', 'detailmpn');
                                        JRequest::setVar('view', 'pns_info');
                                        JRequest::setVar('edit', true);
                                }
                                break;   
                        case 'updatestock':{
                                        JRequest::setVar('layout', 'form_editstock');
                                        JRequest::setVar('view', 'pns_info');
                                        JRequest::setVar('edit', true);
                        }
                        break;
                        
                }
                parent::display();
        }

        /**
          Asign layout and view to display list PNS
         */
        function list_pns() {
                JRequest::setVar('layout', 'default');
                JRequest::setVar('view', 'listpns');
                parent::display();
        }

        /*
          Asign template to display list download files cads
         */

        function download_all_cads() {
                JRequest::setVar('layout', 'default');
                JRequest::setVar('view', 'download');
                parent::display();
        }

        /*
         * Asign template to display multi upload files
         */

        function multi_upload() {
                JRequest::setVar('layout', 'default');
                JRequest::setVar('view', 'multi_uploads');
                parent::display();
        }

        /*
         * Asign template to display next step for multi upload
         */

        function next_upload() {

                JRequest::setVar('layout', 'list_pns');
                JRequest::setVar('view', 'multi_uploads');
                parent::display();
        }

        /*
         * Asign template for multi upload file pdf
         */

        function next_upload_step2() {
                JRequest::setVar('layout', 'from_upload_pdf');
                JRequest::setVar('view', 'multi_uploads_form');
                parent::display();
        }

        /*
         * Asign template for multi upload cads file
         */

        function next_upload_step1() {
                JRequest::setVar('layout', 'from_upload_cad');
                JRequest::setVar('view', 'multi_uploads_form');
                parent::display();
        }

        /*
         * Asign template for get list child PNS  for PNS
         */

        function get_list_child() {
                JRequest::setVar('layout', 'default');
                JRequest::setVar('view', 'getpnschild');
                parent::display();
        }

        /*
         * Asign template for get list child PNS  for BOM PNS
         */

        function get_list_bom_child() {
                JRequest::setVar('layout', 'bomchild');
                JRequest::setVar('view', 'getpnschild');
                parent::display();
        }

        /*
         * Asign template for get list PNs to add more child for PNs
         */

        function list_child() {
                JRequest::setVar('layout', 'default');
                JRequest::setVar('view', 'listchild');
                parent::display();
        }

        /*
         * Asign template for displat list parent of Pns
         */

        function list_where_used() {
                JRequest::setVar('layout', 'default');
                JRequest::setVar('view', 'listwhereused');
                parent::display();
        }

        /*
         * Asign template for displat list child of Pns
         */

        function whereused() {
                JRequest::setVar('layout', 'whereused');
                JRequest::setVar('view', 'listwhereused');
                parent::display();
        }

        /*
         * Asign template for displat list child of Pns
         */

        function specification() {
                JRequest::setVar('layout', 'specification');
                JRequest::setVar('view', 'pns_info');
                JRequest::setVar('edit', true);
                parent::display();
        }

        /*
         * Asign template for displat list child of Pns
         */

        function mep() {
                JRequest::setVar('layout', 'mep');
                JRequest::setVar('view', 'pns_info');
                JRequest::setVar('edit', true);
                parent::display();
        }

        /*
         * Asign template for displat list child of Pns
         */

        function rev() {
                JRequest::setVar('layout', 'rev');
                JRequest::setVar('view', 'pns_info');
                JRequest::setVar('edit', true);
                parent::display();
        }

        /*
         * Asign template for get list child PNS  for BOM PNS
         */

        function get_pns_rev() {
                JRequest::setVar('layout', 'default');
                JRequest::setVar('view', 'revroll');
                parent::display();
        }

        function update_rev_roll() {
                $db = & JFactory::getDBO();
                $id = JRequest::getVar('id');
                $rev = JRequest::getVar('rev');
                $pns_id = JRequest::getVar('pns_id');
                $query = "UPDATE apdm_pns SET pns_revision='" . $rev . "' WHERE pns_id=" . $pns_id;
                $db->setQuery($query);
                $db->query();
                $msg = JText::_('Successfully Saved Rev Roll');
                $this->setRedirect('index.php?option=com_apdmpns&task=detail&cid[0]=' . $pns_id, $msg);
        }

        /*
         * Asign template for displat list child of Pns
         */

        function dash() {
                JRequest::setVar('layout', 'dash');
                JRequest::setVar('view', 'pns_info');
                JRequest::setVar('edit', true);
                parent::display();
        }

        /*
         * 
         * add bom tab in pn detail
         */

        function bom() {
                JRequest::setVar('layout', 'bom');
                JRequest::setVar('view', 'listpns');
                parent::display();
        }

        /*
         * 
         * add bom tab in pn detail
         */

        function searchall() {                
                JRequest::setVar('layout', 'default');
                JRequest::setVar('view', 'searchall');
                parent::display();
        }

        /**
         *
          funcntion get list PNs child for ajax request
         */
        function ajax_list_pns() {

                $db = & JFactory::getDBO();
                $cid = JRequest::getVar('cid', array(), '', 'array');
                $query = "select pns_id, CONCAT_WS( '-', ccs_code, pns_code, pns_revision) AS pns_full_code FROM apdm_pns WHERE pns_id IN (" . implode(",", $cid) . ")";
                $db->setQuery($query);
                $rows = $db->loadObjectList();
                $str = '';
                foreach ($rows as $row) {
                        $str .= '<p><input checked="checked" type="checkbox" name="pns_child[]" value="' . $row->pns_id . '" /> ' . $row->pns_full_code . '</p>';
                }
                echo $str;
                exit;
        }

        /**
         *
          funcntion get list PNs child for ajax request
         */
        function ajax_list_bom_child() {

                $db = & JFactory::getDBO();
                $id = JRequest::getVar('id');
                $pns_child = JRequest::getVar('cid', array(), '', 'array');
                //for parent of pns
                $arr_pns_waring = array();
                $arr_parent_id = array();
                if (count($pns_child) > 0) {
                        foreach ($pns_child as $pn) {
                                $db->setQuery("INSERT INTO apdm_pns_parents (pns_id, pns_parent) VALUES (" . $pn . ", " . $id . ")");
                                $db->query();
                        }
                }
        }

        /*
         * To save multi upload file cad (this function backup)
         */

        function save_multi_upload_cad_1() {
                global $mainframe;
                $db = & JFactory::getDBO();
                $pns_id = JRequest::getVar('pns_id', array(), '', 'array');
                $pns_code = JRequest::getVar('pns_code', array(), '', 'array');
                $ccs_code = JRequest::getVar('ccs_code', array(), '', 'array');
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'cads' . DS;
                $me = & JFactory::getUser();
                $datenow = & JFactory::getDate();
                $pns_cads = array();
                for ($i = 0; $i < count($pns_id); $i++) {
                        $cadfile = 'pns_cad';
                        $path_cad = $path_pns . DS . $ccs_code[$i] . DS . $pns_code[$i] . DS;

                        if ($_FILES[$cadfile]['size'] > 0) {
                                $handle = new Upload($_FILES[$cadfile]);
                                if ($handle->uploaded) {
                                        $handle->process($path_cad);
                                        if ($handle->processed) {
                                                $file_cad_name = $handle->file_dst_name;
                                                $pns_cads[] = array('pns_id' => $pns_id[$i], 'cad_file' => $file_cad_name, 'date_create' => $datenow->toMySQL(), 'created_by' => $me->get('id'));
                                        }
                                }
                        }
                }
                //save information in the table apdm_pns_cad
                foreach ($pns_cads as $obj) {
                        $query = "INSERT INTO apdm_pn_cad (pns_id, cad_file, date_create, created_by) VALUES (" . $obj['pns_id'] . ", '" . $obj['cad_file'] . "', '" . $obj['date_create'] . "', " . $obj['created_by'] . ")";
                        $db->setQuery($query);
                        $db->query();
                }
                JRequest::setVar('layout', 'default');
                JRequest::setVar('view', 'multi_uploads_form');
                parent::display();
        }

        /*
         * To save multi upload file pdf
         */

        function save_multi_upload_pdf() {
                global $mainframe;
                $db = & JFactory::getDBO();
                $pns_id = JRequest::getVar('pns_id', array(), '', 'array');
                $pns_code = JRequest::getVar('pns_code', array(), '', 'array');

                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'pdf' . DS;
                $path_pns_img = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'images' . DS;
                for ($i = 0; $i < count($pns_id); $i++) {
                        $db->setQuery("SELECT pns_pdf FROM apdm_pns WHERE pns_id=" . $pns_id[$i]);
                        $pns_pdf = $db->loadResult();
                        if ($pns_pdf) {
                                if (file_exists($path_pns . $pns_pdf)) {
                                        @unlink($path_pns . $pns_pdf);
                                }
                        }
                        $file_name = 'file' . $pns_id[$i];
                        if ($_FILES[$file_name]['size'] > 0) {
                                //upload file
                                $upload_pdf = new Upload($_FILES[$file_name]);

                                $upload_pdf->file_new_name_body = $pns_code[$i];

                                if ($upload_pdf->uploaded) {
                                        $upload_pdf->process($path_pns);
                                        // print_r($upload_pdf); exit;
                                        if ($upload_pdf->processed) {
                                                $pns_pdf = $upload_pdf->file_dst_name;
                                                //update database 
                                                $query = "UPDATE apdm_pns SET pns_pdf='" . $pns_pdf . "' WHERE pns_id=" . $pns_id[$i];
                                                $db->setQuery($query);
                                                $db->query();
                                        }
                                }
                        }
                        //for image upload
                        $file_img = 'file_img' . $pns_id[$i];
                        if ($_FILES[$file_img]['size'] > 0) {
                                $upload_img = new Upload($_FILES[$file_img]);
                                $upload_img->file_new_name_body = $pns_code[$i];
                                if ($upload_img->uploaded) {
                                        $upload_img->process($path_pns_img);
                                        if ($upload_img->processed) {
                                                $pns_img = $upload_img->file_dst_name;
                                                //update databse
                                                $query = "UPDATE apdm_pns SET pns_image='" . $pns_img . "' WHERE pns_id=" . $pns_id[$i];
                                                $db->setQuery($query);
                                                $db->query();
                                        }
                                }
                        }
                }

                JRequest::setVar('layout', 'default');
                JRequest::setVar('view', 'multi_uploads_form');
                parent::display();
        }

        /*
         * To save multi upload file cad
         */

        function save_multi_upload_cad() {
                global $mainframe;
                $db = & JFactory::getDBO();
                $pns_id = JRequest::getVar('pns_id', array(), '', 'array');
                $pns_code = JRequest::getVar('pns_code', array(), '', 'array');
                $ccs_code = JRequest::getVar('ccs_code', array(), '', 'array');
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'cads' . DS;
                $me = & JFactory::getUser();
                $datenow = & JFactory::getDate();
                $pns_cads = array();
                for ($i = 0; $i < count($pns_id); $i++) {
                        for ($j = 1; $j <= 20; $j++) {
                                $cadfile = 'pns_cad' . $j . $pns_id[$i];
                                $path_cad = $path_pns . DS . $ccs_code[$i] . DS . $pns_code[$i] . DS;
                                if ($_FILES[$cadfile]['size'] > 0) {
                                        if (!move_uploaded_file($_FILES[$cadfile]['tmp_name'], $path_cad . $_FILES[$cadfile]['name'])) {
                                                $arr_error_upload_cads[] = $_FILES[$cadfile]['name'];
                                        } else {
                                                $file_cad_name = $_FILES[$cadfile]['name'];
                                                $pns_cads[] = array('pns_id' => $pns_id[$i], 'cad_file' => $file_cad_name, 'date_create' => $datenow->toMySQL(), 'created_by' => $me->get('id'));
                                        }
                                }
                        }
                }
                //save information in the table apdm_pns_cad
                foreach ($pns_cads as $obj) {
                        $query = "INSERT INTO apdm_pn_cad (pns_id, cad_file, date_create, created_by) VALUES (" . $obj['pns_id'] . ", '" . $obj['cad_file'] . "', '" . $obj['date_create'] . "', " . $obj['created_by'] . ")";
                        $db->setQuery($query);
                        $db->query();
                }
                JRequest::setVar('layout', 'default');
                JRequest::setVar('view', 'multi_uploads_form');
                parent::display();
        }

        /*
         * Get rev roll for Pns
         */

        function rev_roll() {
                global $arrCharacter;
                $db = & JFactory::getDBO();
                // $arrLast    = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'K', 'L', 'M', 'N', 'P', 'R', 'T', 'V', 'Y', 'Z');
                $pns_code = JRequest::getVar('pns_code');
                $ccs_code = JRequest::getVar('ccs_code');
                $query = "SELECT pns_revision FROM apdm_pns WHERE ccs_code='" . $ccs_code . "' AND pns_code='" . $pns_code . "' AND pns_deleted=0 order by pns_revision DESC LIMIT 0, 1";
                $db->setQuery($query);
                $rows = $db->loadObjectList();
                $last_revision = trim($rows[0]->pns_revision);
                $firstChar = $last_revision{0};
                $lastChar = $last_revision{1};
                $newfirstChar = '';
                $newLastChar = '';
                //check for last char
                $i = 0;
                $itemp = 0;
                foreach ($arrCharacter as $char) {
                        if ($char == $lastChar) {
                                $itemp = $i;
                        }
                        $i++;
                }

                if ($itemp == count($arrCharacter) - 1) { //last char of array
                        $newLastChar = 'A';

                        //get new first Char
                        $j = 0;
                        $jTemp = 0;
                        foreach ($arrCharacter as $char_first) {
                                if ($char_first == $firstChar) {
                                        $jTemp = $j;
                                }
                                $j++;
                        }

                        if ($jTemp == count($arrCharacter) - 1) {
                                $newfirstChar = '0';
                        } else {
                                $newfirstChar = $arrCharacter[$jTemp + 1];
                        }
                } else {
                        $newfirstChar = $firstChar;
                        $newLastChar = $arrCharacter[$itemp + 1];
                }
                $new_code = $newfirstChar . $newLastChar;



                //for change by request Khang
                /*
                  $arrExist   = array();
                  if (count($rows) > 0){
                  foreach ($rows as $row){
                  $arrExist[] = $row->pns_revision;
                  }
                  }
                  $new_code  = PNsController::RandomRevision();
                  if (count($arrExist) > 0 && in_array($new_code, $arrExist)){
                  $new_code  = PNsController::RandomRevision();
                  } */
                echo $new_code;
                exit;
        }

        /*
          Get random revision
         */

        function RandomRevision() {
                $arrChar = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'K', 'M', 'N', 'P', 'R', 'T', 'V', 'Y', 'Z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'K', 'M', 'N', 'P', 'R', 'T', 'V', 'Y', 'Z');
                //new code random
                $arr_get = array_rand($arrChar, 2);
                $arr_result = array();
                foreach ($arr_get as $key) {
                        $arr_result[] = $arrChar[$key];
                }
                $new_code = implode("", $arr_result);
                return $new_code;
        }

        /*
         * Get rev roll for Pns
         */

        function next_rev_roll() {
                global $arrCharacter;
                $db = & JFactory::getDBO();
                // $arrLast    = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'K', 'L', 'M', 'N', 'P', 'R', 'T', 'V', 'Y', 'Z');
                $cid = JRequest::getVar('cid', array(0), '', 'array');
                $ccs_code = JRequest::getVar('ccs_code');
                $query = "SELECT p.pns_revision FROM apdm_pns AS p LEFT JOIN apdm_pns_rev AS prev on p.pns_id = prev.pns_id left join apdm_eco eco on eco.eco_id = p.eco_id WHERE p.pns_deleted =0 AND prev.pns_id='".$cid[0]."' order by prev.pns_rev_id desc limit  0, 1";
                $db->setQuery($query);
                $rows = $db->loadObjectList();
                $last_revision = trim($rows[0]->pns_revision);
                $firstChar = $last_revision{0};
                $lastChar = $last_revision{1};
                $newfirstChar = '';
                $newLastChar = '';
                //check for last char
                $i = 0;
                $itemp = 0;
                foreach ($arrCharacter as $char) {
                        if ($char == $lastChar) {
                                $itemp = $i;
                        }
                        $i++;
                }

                if ($itemp == count($arrCharacter) - 1) { //last char of array
                        $newLastChar = 'A';

                        //get new first Char
                        $j = 0;
                        $jTemp = 0;
                        foreach ($arrCharacter as $char_first) {
                                if ($char_first == $firstChar) {
                                        $jTemp = $j;
                                }
                                $j++;
                        }

                        if ($jTemp == count($arrCharacter) - 1) {
                                $newfirstChar = '0';
                        } else {
                                $newfirstChar = $arrCharacter[$jTemp + 1];
                        }
                } else {
                        $newfirstChar = $firstChar;
                        $newLastChar = $arrCharacter[$itemp + 1];
                }
                $new_code = $newfirstChar . $newLastChar;



                //for change by request Khang
                /*
                  $arrExist   = array();
                  if (count($rows) > 0){
                  foreach ($rows as $row){
                  $arrExist[] = $row->pns_revision;
                  }
                  }
                  $new_code  = PNsController::RandomRevision();
                  if (count($arrExist) > 0 && in_array($new_code, $arrExist)){
                  $new_code  = PNsController::RandomRevision();
                  } */
                return $new_code;
                // exit;
        }

        function save_rev_roll() {
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $datenow = & JFactory::getDate();
                $pns_id = JRequest::getVar('pns_id');
                $ccs_code = JRequest::getVar('ccs_code');
                $pns_code = JRequest::getVar('pns_code');
                $pns_revision = JRequest::getVar('pns_revision');
                $eco_id = JRequest::getVar('eco_id');
                $pns_modified = $datenow->toMySQL();
                $pns_modified_by = $me->get('id');
                $pns_life_cycle = JRequest::getVar('pns_life_cycle');
                $return = JRequest::getVar('return');                
                $db->setQuery("INSERT INTO apdm_pns_rev (pns_id,ccs_code,pns_code,pns_revision,eco_id,pns_modified,pns_modified_by,pns_life_cycle,parent_id) VALUES (" . $pns_id . ", '" . $ccs_code . "', '" . $pns_code . "', '" . $pns_revision . "', '" . $eco_id . "', '" . $pns_modified . "', '" . $pns_modified_by . "', '" . $pns_life_cycle . "','".$pns_id."')");                  
                // $db->query();
                //Insett into PN
                $query = "INSERT INTO apdm_pns (ccs_code,pns_code,pns_revision,pns_type,pns_status,pns_pdf,pns_image,pns_description,pns_create,pns_create_by,pns_modified,pns_modified_by,pns_deleted,pns_life_cycle,pns_uom,pns_cost,pns_stock,pns_datein,pns_qty_used,pns_ref_des,pns_find_number,pns_cpn)";
                $query .= "SELECT '".$ccs_code."','".$pns_code."','".$pns_revision."',pns_type,pns_status,pns_pdf,pns_image,pns_description,'".$pns_modified."','".$pns_modified_by."','".$pns_modified."','".$pns_modified_by."',0,'".$pns_life_cycle."',pns_uom,pns_cost,pns_stock,pns_datein,pns_qty_used,pns_ref_des,pns_find_number,pns_cpn FROM apdm_pns WHERE pns_id = $pns_id";
                $db->setQuery($query);
                $db->query();
                $last_id = $db->insertid();
                
                //$getlast_id = "select pns_id from apdm_pns where ccs_code ='".$ccs_code."' and pns_code = '".$pns_code."' and pns_revision = '".$pns_revision."'";
               // $db->setQuery($getlast_id);
                //$last_id = $db->loadResult();
                $db->setQuery("insert into apdm_pns_rev(pns_id,ccs_code,pns_code,pns_revision,pns_life_cycle,parent_id) select ".$last_id.",ccs_code,pns_code,pns_revision,pns_life_cycle,".$pns_id." from apdm_pns where pns_id = '" . $last_id . "'");
                $db->query();
               //Make folder for download
                $folder = $ccs_code . '-' . $pns_code . '-' . $pns_revision;
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS;
                $path_pns_cads = $path_pns . 'cads' . DS . $ccs_code . DS . $folder . DS;
                $upload = new upload($_FILES['']);
                $upload->r_mkdir($path_pns_cads, 0777); 
                //copy file zip to folder pns_cad
                $file_zip = $path_pns . 'cads' . DS . 'zip.php';
                copy($file_zip, $path_pns_cads . 'zip.php');                
                $msg = "Successfully Saved Rev Roll";
                $this->setRedirect('index.php?option=com_apdmpns&task=doneRedirectRevPn&pns_id=' . $pns_id, $msg);
        }
        function doneRedirectRevPn() {
                $pns_id = JRequest::getVar('pns_id');
            // $msg = "Successfully Saved Rev Roll";
           return $this->setRedirect('index.php?option=com_apdmpns&task=rev&cid[0]=' . $pns_id, $msg); 
        }

        function get_dash_up() {


                $db = & JFactory::getDBO();
                $pns_code = JRequest::getVar('pns_code');
                $ccs_code = JRequest::getVar('ccs_code');
                $pns_id = JRequest::getVar('pns_id');
                $query = "SELECT pns_code  FROM apdm_pns  WHERE ccs_code = '" . $ccs_code . "' ORDER BY pns_id DESC LIMIT 0, 1 ";
                $db->setQuery($query);
                $rows = $db->loadObject();
                if ($rows) { //267890-00
                        $temp = explode("-", $rows->pns_code);
                        $pns_latest = $temp[1];
                } else {
                        $pns_latest = 0;
                }

                $next_pns_code = (int) $pns_latest;
                $next_pns_code++;
                $number = strlen($next_pns_code);
                switch ($number) {
                        case '1':
                                $new_pns_code = '0' . $next_pns_code;
                                break;
                        case '2':
                                $new_pns_code = $next_pns_code;
                                break;
                        default:
                                $new_pns_code = $next_pns_code;
                                break;
                }
                echo $new_pns_code;
                exit;
        }

        /*
          Get code defaut : Ajax request
         */

        function code_default() {
                $db = & JFactory::getDBO();
                $ccs_code = JRequest::getVar('ccs_code');

                $query = "SELECT pns_code  FROM apdm_pns  WHERE ccs_code = '" . $ccs_code . "' ORDER BY pns_id DESC LIMIT 0, 1 ";
                $db->setQuery($query);
                $rows = $db->loadObject();
                if ($rows) { //267890-00
                        $temp = explode("-", $rows->pns_code);
                        $pns_latest = $temp[0];
                } else {
                        $pns_latest = 0;
                }

                $next_pns_code = (int) $pns_latest;
                $next_pns_code++;
                $number = strlen($next_pns_code);
                switch ($number) {
                        case '1':
                                $new_pns_code = '00000' . $next_pns_code;
                                break;
                        case '2':
                                $new_pns_code = '0000' . $next_pns_code;
                                break;
                        case '3':
                                $new_pns_code = '000' . $next_pns_code;
                                break;
                        case '4':
                                $new_pns_code = '00' . $next_pns_code;
                                break;
                        case '5':
                                $new_pns_code = '0' . $next_pns_code;
                                break;
                        default:
                                $new_pns_code = $next_pns_code;
                                break;
                }
                //$arr_char = array('A', 'A', 'A','A', 'A', 'A','B', 'B', 'B', 'B', 'B', 'B', 'C','C','C','C','C','C', 'D','D','D', 'D','D','D', 'E','E','E', 'E','E','E', 'F','F', 'F', 'F','F', 'F', 'G','G','G', 'G','G','G', 'H','H','H', 'H','H','H', 'I', 'I', 'I', 'I', 'I', 'I', 'J','J','J', 'J','J','J', 'K','K', 'K', 'K','K', 'K', 'M','M','M', 'M','M','M', 'N', 'N', 'N', 'N', 'N', 'N', 'O','O','O', 'O','O','O', 'P','P','P', 'P','P','P', 'Q','Q','Q', 'Q','Q','Q', 'R','R', 'R', 'R','R', 'R', 'S','S','S', 'S','S','S', 'T','T','T', 'T','T','T', 'U','U','U', 'U','U','U', 'V','V', 'V', 'V','V', 'V','W','W','W', 'W','W','W', 'X','X','X', 'X','X','X', 'Y','Y','Y', 'Y','Y','Y', 'Z','Z','Z', 'Z','Z','Z', '1', '1', '1', '1', '1', '1', '2', '2', '2', '2', '2', '2', '3', '3', '3', '3', '3', '3','4', '4', '4', '4', '4', '4', '5', '5', '5', '5', '5', '5', '6', '6', '6', '6', '6', '6', '7', '7', '7', '7', '7', '7', '8', '8', '8', '8', '8', '8', '9', '9', '9', '9', '9', '9', '0', '0', '0', '0', '0', '0',);
                /* $arr_char = array('1', '1', '1', '1', '1', '1', '2', '2', '2', '2', '2', '2', '3', '3', '3', '3', '3', '3','4', '4', '4', '4', '4', '4', '5', '5', '5', '5', '5', '5', '6', '6', '6', '6', '6', '6', '7', '7', '7', '7', '7', '7', '8', '8', '8', '8', '8', '8', '9', '9', '9', '9', '9', '9', '0', '0', '0', '0', '0', '0');
                  $arr_get = array_rand($arr_char, 6);
                  $arr_result = array();
                  foreach ($arr_get as $obj){
                  $arr_result[] = $arr_char[$obj];
                  }
                  $code = implode("", $arr_result); */
                echo $new_pns_code;
                exit;
        }

        /**
         * Saves the record
         */
        function save() {

                global $mainframe;
                $pns_parent = JRequest::getVar('pns_parent', array(), '', 'array');
                $pns_child = JRequest::getVar('pns_child', array(), '', 'array');
                // Initialize some variables
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $row = & JTable::getInstance('apdmpns');
                $datenow = & JFactory::getDate();
                $post = JRequest::get('post');
                if (!$row->bind($post)) {
                        JError::raiseError(500, $db->stderr());
                        return false;
                }
                $row->pns_id = (int) $row->pns_id;
                $isNew = true;
                $pns_code = trim($post['pns_code']);

                //check pns_code
                if (strlen($pns_code) < 6) {
                        $new = '';
                        for ($i = 0; $i < 6 - strlen($pns_code); $i++) {
                                $new .='0';
                        }
                }
               
                $pns_version = $post['pns_version'];
                if(JRequest::getVar('mpn')==1)
                {
                        $row->pns_cpn  =1;//set CPN                        
                        $pns_code_check = $pns_code;
                        $pns_revision = ($post['pns_revision'] != '') ? strtoupper($post['pns_revision']) : '';
                }
                else
                {   
                        $pns_code = $new . $pns_code;
                        $pns_code_check = $pns_code . "-" . $pns_version;
                        $pns_revision = ($post['pns_revision'] != '') ? strtoupper($post['pns_revision']) : 'AA';
                }
                //$pns_revision = ($post['pns_revision'] != '') ? strtoupper($post['pns_revision']) : 'AA';
                //check for pns code in database
                if ($pns_revision != "") {
                        $query_check = "SELECT pns_id FROM apdm_pns WHERE ccs_code='" . $row->ccs_code . "' AND pns_code = '" . $pns_code_check . "' AND pns_revision='" . $pns_revision . "'";
                } else {
                        $query_check = "SELECT pns_id FROM apdm_pns WHERE ccs_code='" . $row->ccs_code . "' AND pns_code = '" . $pns_code_check . "'";
                }
                
                $db->setQuery($query_check);
                $result_check = $db->loadResult();
                if ($result_check > 0) {
                        $thisPns = $row->ccs_code . '-' . $pns_code_check . '-' . $pns_revision;
                        $msg = JText::_('This Part Number (' . $thisPns . ') Have exist. Please check list again. (Please check with administrator if you dont found.)');
                        $this->setRedirect('index.php?option=com_apdmpns', $msg);
                        return false;
                }

                $row->pns_code = $pns_code_check;
                //get ccs 
                // $db->setQuery("SELECT ccs_code FROM apdm_ccs WHERE ccs_id=".$row->ccs_id);
                $ccs_code = $row->ccs_code;

                 $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS;
                $row->pns_create = $datenow->toMySQL();
                //$row->pns_image = $pns_imge;
                //$row->pns_pdf = $pns_pdf;
                $row->pns_create_by = $me->get('id');
                $row->pns_revision = $pns_revision;
                $row->pns_description = strtoupper($post['pns_description']);
                $row->po_id = JRequest::getVar('pns_po_id');
                //save information of Pns in datbase
                
                if (!$row->store()) {
                        JError::raiseError(500, $db->stderr());
                        return false;
                } else {
                        ///for cad file   
                        //create folder for this pns
                        if ($pns_revision) {
                                $folder = $ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                        } else {
                                $folder = $ccs_code . '-' . $row->pns_code;
                        }
                        $path_pns_cads = $path_pns . 'cads' . DS . $ccs_code . DS . $folder . DS;
                        $upload = new upload($_FILES['']);
                        $upload->r_mkdir($path_pns_cads, 0777);
                        //copy file zip to folder pns_cad
                        $file_zip = $path_pns . 'cads' . DS . 'zip.php';
                        copy($file_zip, $path_pns_cads . 'zip.php');
                        $arr_file_uplad = array();
                        $arr_error_upload_cads = array();
                        for ($i = 1; $i <= 20; $i++) {
                                if ($_FILES['pns_cad' . $i]['size'] > 0) {
                                        if (!move_uploaded_file($_FILES['pns_cad' . $i]['tmp_name'], $path_pns_cads . $_FILES['pns_cad' . $i]['name'])) {
                                                $arr_error_upload_cads[] = $_FILES['pns_cad' . $i]['name'];
                                        } else {
                                                $arr_file_uplad[] = $_FILES['pns_cad' . $i]['name'];
                                        }
                                }
                        }

                        if (count($arr_file_uplad) > 0) {
                                foreach ($arr_file_uplad as $file) {
                                        $db->setQuery("INSERT INTO apdm_pn_cad (pns_id, cad_file, date_create, created_by) VALUES (" . $row->pns_id . ", '" . $file . "', '" . $datenow->toMySQL() . "', " . $me->get('id') . " ) ");
                                        $db->query();
                                }
                        }
                        //for upload file image
                        ///for pns cads/image/pdf
                       
                        $path_cads = $path_pns . 'cads' . DS . $ccs_code . DS . $folder . DS;  


                       //upload new images
                        $arr_error_upload_image = array();
                        $arr_image_upload = array();
                        for ($i = 1; $i <= 20; $i++) {
                                if ($_FILES['pns_image' . $i]['size'] > 0) {
                                        $imge = new upload($_FILES['pns_image' . $i]);
                                        if ($pns_revision != "") {
                                                $imge->file_new_name_body = $ccs_code . "_" . str_replace("-", "_", $pns_code) . "_" . $pns_revision . "_" . time()."_".$i;
                                        } else {
                                                $imge->file_new_name_body = $ccs_code . "_" . str_replace("-", "_", $pns_code) . "_" . time()."_".$i;
                                        }

                                        if (file_exists($path_pns_cads . $imge->file_new_name_body . "." . $imge->file_src_name_ext)) {

                                                @unlink($path_pns_cads .  $imge->file_new_name_body . "." . $imge->file_src_name_ext);
                                        }
                                        if ($imge->uploaded) {
                                                $imge->Process($path_pns_cads);
                                                if ($imge->processed) {
                                                        $arr_image_upload[] = $imge->file_dst_name;
                                                } else {
                                                        $arr_error_upload_image[] = $_FILES['pns_imge' . $i]['name'];
                                                }
                                        }
                                }
                        }
                        if (count($arr_image_upload) > 0) {
                                foreach ($arr_image_upload as $file) {
                                        $db->setQuery("INSERT INTO apdm_pns_image (pns_id,image_file,date_created,created_by) VALUES (" . $row->pns_id . ", '" . $file . "', '" . $datenow->toMySQL() . "', " . $me->get('id') . " ) ");
                                        $db->query();
                                }
                        }        

                        //upload new pdf
                        $arr_error_upload_pdf = array();
                        $arr_pdf_upload = array();
                        for ($i = 1; $i <= 20; $i++) {
                                if ($_FILES['pns_pdf' . $i]['size'] > 0) {
                                        $imge = new upload($_FILES['pns_pdf' . $i]);
                                        if ($pns_revision != "") {
                                                $imge->file_new_name_body = $ccs_code . "_" . str_replace("-", "_", $pns_code) . "_" . $pns_revision . "_" . time()."_".$i;
                                        } else {
                                                $imge->file_new_name_body = $ccs_code . "_" . str_replace("-", "_", $pns_code) . "_" . time()."_".$i;
                                        }

                                        if (file_exists($path_pns_cads . $imge->file_new_name_body . "." . $imge->file_src_name_ext)) {

                                                @unlink($path_pns_cads . $imge->file_new_name_body . "." . $imge->file_src_name_ext);
                                        }
                                        if ($imge->uploaded) {
                                                $imge->Process($path_pns_cads);
                                                if ($imge->processed) {
                                                        $arr_pdf_upload[] = $imge->file_dst_name;
                                                } else {
                                                        $arr_error_upload_pdf[] = $_FILES['pns_pdf' . $i]['name'];
                                                }
                                        }
                                }
                        }
                        if (count($arr_pdf_upload) > 0) {
                                foreach ($arr_pdf_upload as $file) {
                                        $db->setQuery("INSERT INTO apdm_pns_pdf (pns_id,pdf_file,date_created,created_by) VALUES (" . $row->pns_id . ", '" . $file . "', '" . $datenow->toMySQL() . "', " . $me->get('id') . " ) ");
                                        $db->query();
                                }
                        }                        
                        
                        //for vendor    vendor_info
                        $vendors = JRequest::getVar('vendor_id', array(), '', 'array');
                        $vendors_infos = JRequest::getVar('vendor_info', array(), '', 'array');
                        if (count($vendors) > 0) {
                                for ($i = 0; $i < count($vendors); $i++) {
                                        if ($vendors[$i] > 0) {
                                                $query = 'INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (' . $row->pns_id . ', ' . $vendors[$i] . ', "' . $vendors_infos[$i] . '", 2)';
                                                $db->setQuery($query);
                                                $db->query();
                                        }
                                }
                        }
                        //for supplier
                        $supplier = JRequest::getVar('supplier_id', array(), '', 'array');
                        $supplier_info = JRequest::getVar('spp_info', array(), '', 'array');
                        if (count($supplier) > 0) {
                                for ($i = 0; $i < count($supplier); $i++) {
                                        if ($supplier[$i] > 0) {
                                                $query = 'INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (' . $row->pns_id . ', ' . $supplier[$i] . ', "' . $supplier_info[$i] . '", 3)';
                                                $db->setQuery($query);
                                                $db->query();
                                        }
                                }
                        }
                        //for manufacture
                        $manufacture = JRequest::getVar('manufacture_id', array(), '', 'array');
                        $mf_info = JRequest::getVar('mf_info', array(), '', 'array');
                        if (count($manufacture) > 0) {
                                for ($i = 0; $i < count($manufacture); $i++) {
                                        if ($manufacture[$i] > 0) {
                                                $query = 'INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (' . $row->pns_id . ', ' . $manufacture[$i] . ', "' . $mf_info[$i] . '", 4)';
                                                $db->setQuery($query);
                                                $db->query();
                                        }
                                }
                        }
                        //for parent of pns
                        $arr_pns_waring = array();
                        $arr_parent_id = array();
                        if (count($pns_child) > 0) {
                                foreach ($pns_child as $pn) {
                                        $db->setQuery("INSERT INTO apdm_pns_parents (pns_id, pns_parent) VALUES (" . $pn . ", " . $row->pns_id . ")");
                                        $db->query();
                                }
                        }
                }//for save database of pns 
                $text_mess = '';
                if (count($arr_pns_waring) > 0) {
                        $text_mess = JText::_(' You have missing with some add PNs Parent below: ');
                        foreach ($arr_pns_waring as $aaa) {
                                $text_mess .= '"' . $aaa['pns'] . '" => ' . $aaa['mess'] . '; ';
                        }
                }
                if (count($arr_error_upload_cads) > 0) {
                        $text_mess .= JText::_(' Some file CADs can not upload.');
                        $text_mess .= '( ' . implode(";", $arr_error_upload_cads) . ')';
                }
                ///update history
                JAdministrator::HistoryUser(6, 'W', $row->pns_id);
                switch ($this->getTask()) {
                        case 'apply':
                                //update POS
                                if(JRequest::getVar('pns_po_id')!=0)
                                {    
                                        $db->setQuery("INSERT INTO apdm_pns_po_fk (pns_id,po_id) VALUES ( '" . $row->pns_id . "'," . JRequest::getVar('pns_po_id'). ")");
                                        $db->query();                                                                             
                                }
                                //update QuoS
                                if(JRequest::getVar('pns_quo_id')!=0)
                                {
                                        $db->setQuery("update apdm_pns_quo set pns_id = ".$row->pns_id." where pns_quo_id = '".JRequest::getVar('pns_quo_id')."'");
                                        $db->query();                                
                                }        
                                //add inital
                                if($row->eco_id){
                                        $db->setQuery('select count(*) from apdm_pns_initial where pns_id = ' . $row->pns_id.' AND eco_id = '.$row->eco_id.'');
                                        $check_exist = $db->loadResult();
                                        if ($check_exist==0) {
                                                $query = 'insert into apdm_pns_initial (pns_id,init_plant_status,init_make_buy,init_leadtime,eco_id) values ('.$row->pns_id.',"Unreleased","Unassign","3","'.$row->eco_id.'")';
                                                $db->setQuery($query);
                                                $db->query();
                                        } 
                                }

                                //insert  rev history
                                $db->setQuery("insert into apdm_pns_rev(pns_id,ccs_code,pns_code,pns_revision,eco_id,pns_life_cycle,parent_id) select pns_id,ccs_code,pns_code,pns_revision,eco_id,pns_life_cycle,".$rows->pns_id." from apdm_pns where pns_id = '" . $row->pns_id . "'");
                                $db->query();
                                $msg = JText::_('Successfully Saved Part Number') . $text_mess;
                                $return = JRequest::getVar('return');
                                $eco_id = JRequest::getVar('eco_id');
                                if ($return) {
                                       return $this->setRedirect('index.php?option=com_apdmeco&task=affected&cid[]=' . $eco_id, $msg);
                                } else {
                                       return $this->setRedirect('index.php?option=com_apdmpns&task=detail&cid[0]=' . $row->pns_id, $msg);
                                }
                                break;

                        case 'save':
                        default:
                                //update POS
                                if(JRequest::getVar('pns_po_id')!=0)
                                {    
                                        $db->setQuery("INSERT INTO apdm_pns_po_fk (pns_id,po_id) VALUES ( '" . $row->pns_id . "'," . JRequest::getVar('pns_po_id'). ")");
                                        $db->query();                                                                             
                                }
                                //update QuoS
                                if(JRequest::getVar('pns_quo_id')!=0)
                                {
                                        $db->setQuery("update apdm_pns_quo set pns_id = ".$row->pns_id." where pns_quo_id = '".JRequest::getVar('pns_quo_id')."'");
                                        $db->query();                                
                                }    
                                //add inital
                                if($row->eco_id){
                                        $db->setQuery('select count(*) from apdm_pns_initial where pns_id = ' . $row->pns_id.' AND eco_id = '.$row->eco_id.'');
                                        $check_exist = $db->loadResult();
                                        if ($check_exist==0) {
                                                $query = 'insert into apdm_pns_initial (pns_id,init_plant_status,init_make_buy,init_leadtime,eco_id) values ('.$row->pns_id.',"Unreleased","Unassign","3","'.$row->eco_id.'")';
                                                $db->setQuery($query);
                                                $db->query();
                                        } 
                                }                                                                   
                                //insert  rev history
                                $db->setQuery("insert into apdm_pns_rev(pns_id,ccs_code,pns_code,pns_revision,eco_id,pns_life_cycle,parent_id) select pns_id,ccs_code,pns_code,pns_revision,eco_id,pns_life_cycle,".$rows->pns_id." from apdm_pns where pns_id = '" . $row->pns_id . "'");
                                $db->query();                                
                                $msg = JText::_('Successfully Saved Part Number') . ': ' . $row->ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision . ' ' . $text_mess;
                                $return = JRequest::getVar('return');
                                $eco_id = JRequest::getVar('eco_id');
                                if ($return) {
                                        $this->setRedirect('index.php?option=com_apdmeco&task=affected&cid[]=' . $eco_id, $msg);
                                } else {
                                        if(JRequest::getVar('mpn')==1)
                                        {
                                                return $this->setRedirect('index.php?option=com_apdmpns&task=addpncus', $msg);
                                        }
                                        else
                                        {
                                              return  $this->setRedirect('index.php?option=com_apdmpns&task=add', $msg); 
                                        }
                                        
                                }
                                
                                $this->setRedirect('index.php?option=com_apdmpns&task=add', $msg);
                                break;
                }
        }

        function edit_pns_dash() {

                global $mainframe;
                // Initialize some variables
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $row = & JTable::getInstance('apdmpns');
                $datenow = & JFactory::getDate();
                $post = JRequest::get('post');

                //      $pns_parent = JRequest::getVar('pns_parent',  array(), '', 'array');
                //      $pns_child = JRequest::getVar('pns_child',  array(), '', 'array');
                $pns_id = JRequest::getVar('pns_id');
                $pns_revision_old = JRequest::getVar('pns_revision_old');
                $eco_id = JRequest::getVar('eco_id');
                $pns_type = JRequest::getVar('pns_type');
                $pns_description = JRequest::getVar('pns_description');
                $pns_code_old = JRequest::getVar('pns_code_old');
                $pns_revision = JRequest::getVar('pns_revision');
                $pns_code = JRequest::getVar('pns_code');
                $pns_version = JRequest::getVar('pns_version');
                $new_pns_code = $pns_code . "-" . $pns_version;
                if ($new_pns_code === $pns_code_old) {
                        $msg = JText::_('Dash Roll not change');
                        $this->setRedirect('index.php?option=com_apdmpns&task=dash&cid[0]=' . $pns_id, $msg);
                        return;
                }

                $ccs_code = JRequest::getVar('ccs_code');
                $db->setQuery("insert into apdm_pns (ccs_code,pns_code,pns_revision,eco_id,pns_type,pns_status,pns_pdf,pns_image,pns_description,pns_create,pns_create_by,pns_modified,pns_modified_by,pns_deleted,pns_life_cycle,pns_uom,pns_cost,pns_stock,pns_datein,pns_qty_used,pns_ref_des,pns_find_number) select ccs_code,'" . $new_pns_code . "',pns_revision,'" . $eco_id . "','" . $pns_type . "',pns_status,pns_pdf,pns_image,'" . $pns_description . "',pns_create,pns_create_by,pns_modified,pns_modified_by,pns_deleted,'Create',pns_uom,pns_cost,pns_stock,pns_datein,pns_qty_used,pns_ref_des,pns_find_number from apdm_pns where pns_id='" . $pns_id . "'");
                $db->query();

                //getnew pnsID

                $query = "SELECT pns_id  FROM apdm_pns  WHERE pns_code = '" . $new_pns_code . "'  and  ccs_code = '" . $ccs_code . "' ORDER BY pns_id DESC LIMIT 0, 1 ";
                $db->setQuery($query);
                $rows = $db->loadObject();
                //insert  rev history
                $db->setQuery("insert into apdm_pns_rev(pns_id,ccs_code,pns_code,pns_revision,eco_id,pns_life_cycle,parent_id) select pns_id,ccs_code,pns_code,pns_revision,eco_id,pns_life_cycle,".$rows->pns_id." from apdm_pns where pns_id = '" . $rows->pns_id . "'");
                $db->query();
                $msg = JText::_('Successfully Saved Dash Roll');

                $this->setRedirect('index.php?option=com_apdmpns&task=dash&cid[0]=' . $rows->pns_id, $msg);
        }

        /**
         * @desc save edit pns
         */
        function edit_specification() {
                
        }
        function edit_pns_stock()
        {
                 global $mainframe;
                // Initialize some variables
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $pns_cost = strtoupper($post['pns_cost']);
                $pns_id = JRequest::getVar('pns_id');
                $db->setQuery("UPDATE apdm_pns SET pns_cost='" . JRequest::getVar('pns_cost') . "',pns_stock ='" . JRequest::getVar('pns_stock') . "',pns_datein ='" . JRequest::getVar('pns_datein') . "',pns_qty_used ='" . JRequest::getVar('pns_qty_used') . "' WHERE pns_id=" . $pns_id);
                $db->query();
                $msg = JText::_('Successfully Update Stock Part Number');
                $this->setRedirect('index.php?option=com_apdmpns&task=detail&cid[]=' . $pns_id, $msg);               
        }
        function edit_pns() {

                global $mainframe;
                // Initialize some variables
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $row = & JTable::getInstance('apdmpns');
                $datenow = & JFactory::getDate();
                $post = JRequest::get('post');
                $pns_parent = JRequest::getVar('pns_parent', array(), '', 'array');
                $pns_child = JRequest::getVar('pns_child', array(), '', 'array');
                $pns_revision_old = JRequest::getVar('pns_revision_old');
                $pns_revision = JRequest::getVar('pns_revision');
                $pns_code = JRequest::getVar('pns_code');
                $ccs_code = JRequest::getVar('ccs_code');
                $pns_cost = strtoupper($post['pns_cost']);
                $pns_type = JRequest::getVar('pns_type');
                $eco_id = strtoupper($post['eco_id']);
                $pns_description = strtoupper($post['pns_description']);
                $redirect = JRequest::getVar('redirect');
                if (!$row->bind($post)) {
                        JError::raiseError(500, $db->stderr());
                        return false;
                }

                $row->pns_life_cycle = JRequest::getVar('pns_life_cycle');
                
                ///for pns cads/image/pdf
                if ($pns_revision) {
                        $folder = $ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                } else {
                        $folder = $ccs_code . '-' . $row->pns_code;
                }
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS;
                $path_cads = $path_pns . 'cads' . DS . $ccs_code . DS . $folder . DS;                
               
                $pns_id = JRequest::getVar('pns_id');
                $row = & JTable::getInstance('apdmpns');
                $row->load($pns_id);

                if ($pns_revision == $pns_revision_old) {

                        //upload new images
                        $arr_error_upload_image = array();
                        $arr_image_upload = array();
                        for ($i = 1; $i <= 20; $i++) {
                                if ($_FILES['pns_image' . $i]['size'] > 0) {
                                        $imge = new upload($_FILES['pns_image' . $i]);
                                        if ($pns_revision != "") {
                                                $imge->file_new_name_body = $ccs_code . "_" . str_replace("-", "_", $pns_code) . "_" . $pns_revision . "_" . time()."_".$i;
                                        } else {
                                                $imge->file_new_name_body = $ccs_code . "_" . str_replace("-", "_", $pns_code) . "_" . time()."_".$i;
                                        }

                                        if (file_exists($path_cads . $imge->file_new_name_body . "." . $imge->file_src_name_ext)) {

                                                @unlink($path_cads .  $imge->file_new_name_body . "." . $imge->file_src_name_ext);
                                        }
                                        if ($imge->uploaded) {
                                                $imge->Process($path_cads);
                                                if ($imge->processed) {
                                                        $arr_image_upload[] = $imge->file_dst_name;
                                                } else {
                                                        $arr_error_upload_image[] = $_FILES['pns_imge' . $i]['name'];
                                                }
                                        }
                                }
                        }
                        if (count($arr_image_upload) > 0) {
                                foreach ($arr_image_upload as $file) {
                                        $db->setQuery("INSERT INTO apdm_pns_image (pns_id,image_file,date_created,created_by) VALUES (" . $row->pns_id . ", '" . $file . "', '" . $datenow->toMySQL() . "', " . $me->get('id') . " ) ");
                                        $db->query();
                                }
                        }
                        //upload new pdf
                        $arr_error_upload_pdf = array();
                        $arr_pdf_upload = array();
                        for ($i = 1; $i <= 20; $i++) {
                                if ($_FILES['pns_pdf' . $i]['size'] > 0) {
                                        $imge = new upload($_FILES['pns_pdf' . $i]);
                                        if ($pns_revision != "") {
                                                $imge->file_new_name_body = $ccs_code . "_" . str_replace("-", "_", $pns_code) . "_" . $pns_revision . "_" .  substr(str_shuffle("0123456789"), 0, 4)."_".$i;
                                        } else {
                                                $imge->file_new_name_body = $ccs_code . "_" . str_replace("-", "_", $pns_code) . "_" .  substr(str_shuffle("0123456789"), 0, 4)."_".$i;
                                        }

                                        if (file_exists($path_cads . $imge->file_new_name_body . "." . $imge->file_src_name_ext)) {

                                                @unlink($path_cads . $imge->file_new_name_body . "." . $imge->file_src_name_ext);
                                        }
                                        if ($imge->uploaded) {
                                                $imge->Process($path_cads);
                                                if ($imge->processed) {
                                                        $arr_pdf_upload[] = $imge->file_dst_name;
                                                } else {
                                                        $arr_error_upload_pdf[] = $_FILES['pns_pdf' . $i]['name'];
                                                }
                                        }
                                }
                        }
                        if (count($arr_pdf_upload) > 0) {
                                foreach ($arr_pdf_upload as $file) {
                                        $db->setQuery("INSERT INTO apdm_pns_pdf (pns_id,pdf_file,date_created,created_by) VALUES (" . $row->pns_id . ", '" . $file . "', '" . $datenow->toMySQL() . "', " . $me->get('id') . " ) ");
                                        $db->query();
                                }
                        }
                        //no change pns revision
                        //upload file pdf
//        if ($_FILES['pns_pdf']['size'] > 0){
//            $pdf = new upload($_FILES['pns_pdf']);
//            if ($pns_revision !=""){              
//                $pdf->file_new_name_body = $ccs_code."_".str_replace("-", "_",$pns_code)."_".$pns_revision;
//                
//            }else{
//                $pdf->file_new_name_body = $ccs_code."_".str_replace("-", "_",$pns_code);
//              
//            }   
//             if (file_exists($path_pns.'pdf'.DS.$pdf->file_new_name_body.'.'.$pdf->file_src_name_ext)) { 
//           
//                unlink($path_pns.'pdf'.DS.$pdf->file_new_name_body.'.'.$pdf->file_src_name_ext);
//           
//            }
//            if ($pdf->uploaded){
//                $pdf->process($path_pns.'pdf'.DS);
//                if ($pdf->processed){
//                    $pns_pdf = $pdf->file_dst_name;
//                }
//            }
//            
//        }else{
//            $pns_pdf = JRequest::getVar('old_pns_pdf');   
//        } 
                        $row->pns_modified = $datenow->toMySQL();
                        $row->pns_modified_by = $me->get('id');
                        $row->pns_description = $pns_description;
                        $row->pns_cost = JRequest::getVar('pns_cost');
                        $row->pns_stock = JRequest::getVar('pns_stock');
                        $row->pns_type = JRequest::getVar('pns_type');
                        $row->pns_status = JRequest::getVar('pns_status');
                        $row->pns_datein = JRequest::getVar('pns_datein');
                        $row->pns_uom = JRequest::getVar('pns_uom');                        
                        $row->pns_qty_used = JRequest::getVar('pns_qty_used');
                        $row->pns_life_cycle = JRequest::getVar('pns_life_cycle');
                        $row->pns_cost = JRequest::getVar('pns_cost');      
                        $row->eco_id = JRequest::getVar('eco_id');  
                        //$row->po_id = JRequest::getVar('pns_po_id');  
                        if (!$row->store()) {
                                $msg = JText::_('Successfully Saved Part Number');
                                $this->setRedirect('index.php?option=com_apdmpns&task=edit&cid[]=' . $row->pns_id, $msg);
                        }
                        //update QuoS
                        if(JRequest::getVar('pns_quo_id')!=0)
                        {
                                $db->setQuery("update apdm_pns_quo set pns_id = ".$row->pns_id." where pns_quo_id = '".JRequest::getVar('pns_quo_id')."'");
                                $db->query();                                                                
                        }  
                        //update QuoS
                        if(JRequest::getVar('pns_po_id')!=0)
                        {
                                $db->setQuery("INSERT INTO apdm_pns_po_fk (pns_id,po_id) VALUES ( '" . $row->pns_id . "'," . JRequest::getVar('pns_po_id') . ")");
                                $db->query();                                                               
                        }       
                        //add inital
                        if($row->eco_id){
                                $db->setQuery('select count(*) from apdm_pns_initial where pns_id = ' . $row->pns_id.' AND eco_id = '.$row->eco_id.'');
                                $check_exist = $db->loadResult();
                                if ($check_exist==0) {
                                        $query = 'insert into apdm_pns_initial (pns_id,init_plant_status,init_make_buy,init_leadtime,eco_id) values ('.$row->pns_id.',"Unreleased","Unassign","3","'.$row->eco_id.'")';
                                        $db->setQuery($query);
                                        $db->query();
                                } 
                        }                        
                        //for pans parent
                        //for parent of pns
                        $arr_pns_waring = array();
                        $arr_parent_id = array();
                        if (count($pns_child) > 0) {
                                foreach ($pns_child as $child) {                                        
                                        $db->setQuery("INSERT INTO apdm_pns_parents (pns_id, pns_parent) VALUES (" . $child . ", " . $row->pns_id . ")");
                                        $db->query();
                                }
                        }

                        ///for vendor and supplier and manufacture
                        $v_exist = JRequest::getVar('v_exist', array(), '', 'array');
                        $v_exist_value = JRequest::getVar('v_exist_value', array(), '', 'array');
                        $vendor_id = JRequest::getVar('vendor_id', array(), '', 'array');
                        $vendor_info = JRequest::getVar('vendor_info', array(), '', 'array');

                        $s_exist = JRequest::getVar('s_exist', array(), '', 'array');
                        $s_exist_value = JRequest::getVar('s_exist_value', array(), '', 'array');
                        $supplier_id = JRequest::getVar('supplier_id', array(), '', 'array');
                        $spp_info = JRequest::getVar('spp_info', array(), '', 'array');

                        $m_exist = JRequest::getVar('m_exist', array(), '', 'array');
                        $m_exist_value = JRequest::getVar('m_exist_value', array(), '', 'array');
                        $manufacture_id = JRequest::getVar('manufacture_id', array(), '', 'array');
                        $mf_info = JRequest::getVar('mf_info', array(), '', 'array');

                        //update vendor
                        if (count($v_exist) > 0) {

                                for ($i = 0; $i < count($v_exist); $i++) {
                                        $db->setQuery("UPDATE apdm_pns_supplier SET supplier_info='" . $v_exist_value[$i] . "' WHERE id=" . $v_exist[$i]);
                                        $db->query();
                                }
                        }
                        //ad new vendor
                        if (count($vendor_id) > 0) {
                                for ($i = 0; $i < count($vendor_id); $i++) {
                                        if ($vendor_id[$i] > 0) {
                                                $db->setQuery("INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (" . $row->pns_id . ", " . $vendor_id[$i] . ", '" . $vendor_info[$i] . "', 2) ");
                                                $db->query();
                                        }
                                }
                        }
                        //update supplier
                        if (count($s_exist) > 0) {
                                for ($i = 0; $i < count($s_exist); $i++) {
                                        $db->setQuery("UPDATE apdm_pns_supplier SET supplier_info='" . $s_exist_value[$i] . "' WHERE id=" . $s_exist[$i]);
                                        $db->query();
                                }
                        }
                        //add new supplier
                        if (count($supplier_id) > 0) {
                                for ($i = 0; $i < count($supplier_id); $i++) {
                                        if ($supplier_id[$i] > 0) {
                                                $db->setQuery("INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (" . $row->pns_id . ", " . $supplier_id[$i] . ", '" . $spp_info[$i] . "', 3) ");
                                                $db->query();
                                        }
                                }
                        }
                        //update manufacture
                        if (count($m_exist) > 0) {
                                for ($i = 0; $i < count($m_exist); $i++) {
                                        $db->setQuery("UPDATE apdm_pns_supplier SET supplier_info='" . $m_exist_value[$i] . "' WHERE id=" . $m_exist[$i]);
                                        $db->query();
                                }
                        }
                        //add new manufacture
                        if (count($manufacture_id) > 0) {
                                for ($i = 0; $i < count($manufacture_id); $i++) {
                                        if ($manufacture_id[$i] > 0) {
                                                $db->setQuery("INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (" . $row->pns_id . ", " . $manufacture_id[$i] . ", '" . $mf_info[$i] . "', 4) ");
                                                $db->query();
                                        }
                                }
                        }
                        ///for pns cads
                        if ($pns_revision) {
                                $folder = $ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                        } else {
                                $folder = $ccs_code . '-' . $row->pns_code;
                        }
                        $path_pns_cads = $path_pns . 'cads' . DS . $ccs_code . DS . $folder . DS;
                        $arr_error_upload_cads = array();
                        $arr_file_uplad = array();
                        for ($i = 1; $i <= 20; $i++) {
                                if ($_FILES['pns_cad' . $i]['size'] > 0) {
                                        $cad = new upload($_FILES['pns_cad' . $i]);
                                        if (file_exists($path_pns_cads . $_FILES['pns_cad' . $i]['name'])) {
                                                @unlink($path_pns_cads . $_FILES['pns_cad' . $i]['name']);
                                        }
                                        if (!move_uploaded_file($_FILES['pns_cad' . $i]['tmp_name'], $path_pns_cads . $_FILES['pns_cad' . $i]['name'])) {
                                                $arr_error_upload_cads[] = $_FILES['pns_cad' . $i]['name'];
                                        } else {
                                                $arr_file_uplad[] = $_FILES['pns_cad' . $i]['name'];
                                        }
                                }
                        }
                        if (count($arr_file_uplad) > 0) {
                                foreach ($arr_file_uplad as $file) {
                                        $db->setQuery("INSERT INTO apdm_pn_cad (pns_id, cad_file, date_create, created_by) VALUES (" . $row->pns_id . ", '" . $file . "', '" . $datenow->toMySQL() . "', " . $me->get('id') . " ) ");
                                        $db->query();
                                }
                        }
                        ///update history
                        JAdministrator::HistoryUser(6, 'E', $row->pns_id);
                        $text_mess = '';
                        if (count($arr_pns_waring) > 0) {
                                $text_mess = JText::_(' You have missing with some add PNs Parent below: ');
                                foreach ($arr_pns_waring as $aaa) {
                                        $text_mess .= '"' . $aaa['pns'] . '" => ' . $aaa['mess'] . '; ';
                                }
                        }
                        $msg = JText::_('Successfully Saved Part.') . $text_mess;
                        if (isset($redirect) && $redirect != "") {
                                $this->setRedirect('index.php?option=com_apdmpns&task=' . $redirect . '&cid[]=' . $row->pns_id, $msg);
                        } else {
                                $this->setRedirect('index.php?option=com_apdmpns&task=detail&cid[]=' . $row->pns_id, $msg);
                        }
                } else { //to change pns revision
                        //ad new pns with 
                        $pns_id_exist = $row->pns_id;

                        $row->pns_id = 0;
                        $row->pns_create = $datenow->toMySQL();
                        $row->pns_create_by = $me->get('id');
                        $row->ccs_code = $ccs_code;
                        $row->pns_code = $pns_code;
                        $row->pns_revision = strtoupper($pns_revision);
                        $row->pns_deleted = 0;
                        $row->po_id = JRequest::getVar('pns_po_id');
                        $row->pns_description = strtoupper($post['pns_description']);
                        if ($_FILES['pns_imge']['size'] > 0) {
                                $imge = new upload($_FILES['pns_imge']);
                                $imge->file_new_name_body = $ccs_code . "_" . str_replace("-", "_", $pns_code) . "_" . $pns_revision;
                                if (file_exists($path_cads . $imge->file_new_name_body . "." . $imge->file_src_name_ext)) {
                                        @unlink($path_cads . $imge->file_new_name_body . "." . $imge->file_src_name_ext);
                                }
                                if ($imge->uploaded) {
                                        $imge->Process($path_cads);
                                        if ($imge->processed) {
                                                $pns_imge = $imge->file_dst_name;
                                        }
                                }
                        } else {
                                ///copy new file image
                                $pns_imge_old = JRequest::getVar('old_pns_image');
                                $copy_img = new upload($path_cads . $pns_imge_old);
                                $copy_img->file_new_name_body = $ccs_code . "_" . str_replace("-", "_", $pns_code) . "_" . $pns_revision;
                                if (file_exists($path_cads . $copy_img->file_new_name_body . "." . $copy_img->file_src_name_ext)) {
                                        @unlink($path_cads . $copy_img->file_new_name_body . "." . $copy_img->file_src_name_ext);
                                }
                                if ($copy_img->uploaded) {
                                        $copy_img->process($path_pns);

                                        if ($copy_img->processed) {
                                                $pns_imge = $copy_img->file_dst_name;
                                        }
                                }
                        }
                        //upload file pdf
                        if ($_FILES['pns_pdf']['size'] > 0) {
                                $pdf = new upload($_FILES['pns_pdf']);
                                $pdf->file_new_name_body = $ccs_code . "_" . str_replace("-", "_", $pns_code) . "_" . $pns_revision;
                                if (file_exists($path_cads . $pdf->file_new_name_body . '.' . $pdf->file_src_name_ext)) {
                                        @unlink($path_cads . $pdf->file_new_name_body . '.' . $pdf->file_src_name_ext);
                                }
                                if ($pdf->uploaded) {
                                        $pdf->process($path_cads);
                                        if ($pdf->processed) {
                                                $pns_pdf = $pdf->file_dst_name;
                                        }
                                }
                        } else {
                                //copy new file pdf
                                $pns_pdf_old = JRequest::getVar('old_pns_pdf');
                                $copy_pdf = new upload($path_cads . $pns_pdf_old);
                                $copy_pdf->file_new_name_body = $ccs_code . "_" . str_replace("-", "_", $pns_code) . "_" . $pns_revision;

                                if (file_exists($path_cads . $copy_pdf->file_new_name_body . "." . $copy_pdf->file_src_name_ext)) {
                                        @unlink($path_cads . $copy_pdf->file_new_name_body . "." . $copy_pdf->file_src_name_ext);
                                }
                                $copy_pdf->file_new_name_body = $ccs_code . "_" . str_replace("-", "_", $pns_code) . "_" . $pns_revision;

                                if ($copy_pdf->uploaded) {
                                        $copy_pdf->process($path_cads);

                                        if ($copy_pdf->processed) {
                                                $pns_pdf = $copy_pdf->file_dst_name;
                                        }
                                }
                        }
                        $row->pns_image = $pns_imge;
                        $row->pns_pdf = $pns_pdf;
                        if (!$row->store()) {
                                $msg = JText::_('Have a problem with Saved Part Number');
                                $this->setRedirect('index.php?option=com_apdmpns&task=detail&cid[]=' . $row->pns_id, $msg);
                        }
                        //add new pns_paretn
                        $arr_pns_waring = array();
                        $arr_parent_id = array();
                        if (count($pns_child) > 0) {
                                foreach ($pns_child as $child) {
                                        $db->setQuery("INSERT INTO apdm_pns_parents (pns_id, pns_parent) VALUES (" . $child . ", " . $row->pns_id . ")");
                                        $db->query();
                                }
                        }
                        ///update history
                        JAdministrator::HistoryUser(6, 'W', $row->pns_id);

                        ///for vendor and supplier and manufacture
                        $v_exist_id = JRequest::getVar('v_exist_id', array(), '', 'array');
                        $v_exist_value = JRequest::getVar('v_exist_value', array(), '', 'array');
                        $vendor_id = JRequest::getVar('vendor_id', array(), '', 'array');
                        $vendor_info = JRequest::getVar('vendor_info', array(), '', 'array');

                        $s_exist_id = JRequest::getVar('s_exist_id', array(), '', 'array');
                        $s_exist_value = JRequest::getVar('s_exist_value', array(), '', 'array');
                        $supplier_id = JRequest::getVar('supplier_id', array(), '', 'array');
                        $spp_info = JRequest::getVar('spp_info', array(), '', 'array');

                        $m_exist_id = JRequest::getVar('m_exist_id', array(), '', 'array');
                        $m_exist_value = JRequest::getVar('m_exist_value', array(), '', 'array');
                        $manufacture_id = JRequest::getVar('manufacture_id', array(), '', 'array');
                        $mf_info = JRequest::getVar('mf_info', array(), '', 'array');
                        //update vendor
                        if (count($v_exist_id) > 0) {

                                for ($i = 0; $i < count($v_exist_id); $i++) {
                                        $db->setQuery("INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (" . $row->pns_id . ", " . $v_exist_id[$i] . ", '" . $v_exist_value[$i] . "', 2) ");
                                        $db->query();
                                }
                        }
                        //ad new vendor
                        if (count($vendor_id) > 0) {
                                for ($i = 0; $i < count($vendor_id); $i++) {
                                        if ($vendor_id[$i] > 0) {
                                                $db->setQuery("INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (" . $row->pns_id . ", " . $vendor_id[$i] . ", '" . $vendor_info[$i] . "', 2) ");
                                                $db->query();
                                        }
                                }
                        }
                        //update supplier
                        if (count($s_exist_id) > 0) {
                                for ($i = 0; $i < count($s_exist_id); $i++) {
                                        $db->setQuery("INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (" . $row->pns_id . ", " . $s_exist_id[$i] . ", '" . $s_exist_value[$i] . "', 3) ");
                                        $db->query();
                                }
                        }
                        //add new supplier
                        if (count($supplier_id) > 0) {
                                for ($i = 0; $i < count($supplier_id); $i++) {
                                        if ($supplier_id[$i] > 0) {
                                                $db->setQuery("INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (" . $row->pns_id . ", " . $supplier_id[$i] . ", '" . $spp_info[$i] . "', 3) ");
                                                $db->query();
                                        }
                                }
                        }
                        //update manufacture
                        if (count($m_exist_id) > 0) {
                                for ($i = 0; $i < count($m_exist_id); $i++) {
                                        $db->setQuery("INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (" . $row->pns_id . ", " . $m_exist_id[$i] . ", '" . $m_exist_value[$i] . "', 4) ");
                                        $db->query();
                                }
                        }
                        //add new manufacture
                        if (count($manufacture_id) > 0) {
                                for ($i = 0; $i < count($manufacture_id); $i++) {
                                        if ($manufacture_id[$i] > 0) {
                                                $db->setQuery("INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (" . $row->pns_id . ", " . $manufacture_id[$i] . ", '" . $mf_info[$i] . "', 4) ");
                                                $db->query();
                                        }
                                }
                        }
                        //file cad
                        //create folder for this pns
                        $folder = $ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                        $path_pns_cads = $path_pns . 'cads' . DS . $ccs_code . DS . $folder . DS;
                        $upload = new upload($_FILES['']);
                        $upload->r_mkdir($path_pns_cads, 0777);
                        //copy file zip ne
                        $file_zip = $path_pns . 'cads' . DS . 'zip.php';
                        copy($file_zip, $path_pns_cads . 'zip.php');
                        $arr_file_uplad = array();
                        $arr_error_upload_cads = array();
                        for ($i = 1; $i <= 20; $i++) {
                                if ($_FILES['pns_cad' . $i]['size'] > 0) {
                                        if (!move_uploaded_file($_FILES['pns_cad' . $i]['tmp_name'], $path_pns_cads . $_FILES['pns_cad' . $i]['name'])) {
                                                $arr_error_upload_cads[] = $_FILES['pns_cad' . $i]['name'];
                                        } else {
                                                $arr_file_uplad[] = $_FILES['pns_cad' . $i]['name'];
                                        }
                                }
                        }
                        ///move file exist in odl foder to new folder
                        $db->setQuery("SELECT * FROM apdm_pn_cad WHERE pns_id=" . $pns_id_exist);
                        $files = $db->loadObjectList();

                        if (count($files) > 0) {
                                //$arr_file_exist = array(); 
                                //get folder old file 
                                $querypn = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS text FROM apdm_pns AS p  LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code WHERE p.pns_deleted =0  AND p.pns_id =" . $pns_id_exist;
                                $db->setQuery($querypn);
                                $rs = $db->loadObject();
                                $pns_folder_exist = trim($rs->text);
                                $path_pns_exist = $path_pns . 'cads' . DS . $ccs_code . DS . $pns_folder_exist . DS;
                                foreach ($files as $file) {

                                        if (copy($path_pns_exist . $file->cad_file, $path_pns_cads . $file->cad_file)) {
                                                $arr_file_uplad[] = $file->cad_file;
                                        }
                                }
                        }

                        if (count($arr_file_uplad) > 0) {
                                foreach ($arr_file_uplad as $file) {
                                        $db->setQuery("INSERT INTO apdm_pn_cad (pns_id, cad_file, date_create, created_by) VALUES (" . $row->pns_id . ", '" . $file . "', '" . $datenow->toMySQL() . "', " . $me->get('id') . " ) ");
                                        $db->query();
                                }
                        }

                        $text_mess = '';
                        if (count($arr_pns_waring) > 0) {
                                $text_mess = JText::_(' You have missing with some add PNs Parent below: ');
                                foreach ($arr_pns_waring as $aaa) {
                                        $text_mess .= '"' . $aaa['pns'] . '" => ' . $aaa['mess'] . '; ';
                                }
                        }
                        if (count($arr_error_upload_cads) > 0) {
                                $text_mess .= JText::_('Have error with some file CADs upload: ');
                                $text_mess .= "( " . implode(";", $arr_error_upload_cads) . " )";
                        }
                        $msg = JText::_('Successfully Saved Part Number. Please change ECO for this Part Number') . $text_mess;
                        $this->setRedirect('index.php?option=com_apdmpns&task=detail&cid[0]=' . $row->pns_id, $msg);
                } //end else
        }

        /**
         * Removes the record(s) from the database
         */
        function remove() {
                // Check for request forgeries     		

                $db = & JFactory::getDBO();
                $currentUser = & JFactory::getUser();
                $cid = JRequest::getVar('cid', array(), '', 'array');

                JArrayHelper::toInteger($cid);

                if (count($cid) < 1) {
                        JError::raiseError(500, JText::_('Select a User to delete', true));
                }

                foreach ($cid as $id) {
                        // check for a super admin ... can't delete them
                        $query = "UPDATE apdm_pns SET pns_deleted=1 WHERE pns_id=" . $id;                        
                        $db->setQuery($query);
                        $db->query();
                        //
                        $query = "Delete from apdm_pns_initial WHERE pns_id=" . $id;                        
                        $db->setQuery($query);
                        $db->query();     
                        $query = "Delete from apdm_pns_pdf WHERE pns_id=" . $id;                        
                        $db->setQuery($query);
                        $db->query();           
                        $query = "Delete from apdm_pns_image WHERE pns_id=" . $id;                        
                        $db->setQuery($query);
                        $db->query();                                   
                        
                        ///update history
                        JAdministrator::HistoryUser(6, 'D', $id);
                }
                $msg = "Have successfuly delete pns";
                $return = JRequest::getVar('return');
                if ($return) {
                        $this->setRedirect('index.php?option=com_apdmpns&task=listpns&id=' . $return, $msg);
                } else {
                        $this->setRedirect('index.php?option=com_apdmpns', $msg);
                }
        }

        /**
         * Removes the record(s) from the database
         */
        function addbomchild() {
                $bar = & JToolBar::getInstance('toolbar');
                $cid = JRequest::getVar('cid', array(), '', 'array');
                $bar->appendButton('Link', 'menus', 'Menus', "index.php?option=com_menus");
                JArrayHelper::toInteger($cid);

                if (count($cid) < 1) {
                        JError::raiseError(500, JText::_('Select a User to delete', true));
                }

                foreach ($cid as $id) {
                        
                }
                // Add an upload button
                $bar->appendButton('Popup', 'new', "TEST", "index.php?option=com_apdmpns&task=get_list_bom_child&tmpl=component&id=00", 850, 500);
        }

        /**
         * Removes the record(s) from the database
         */
        function removepnbom() {
                // Check for request forgeries     		

                $db = & JFactory::getDBO();
                $currentUser = & JFactory::getUser();
                $cid = JRequest::getVar('cid', array(), '', 'array');
               
              //  JArrayHelper::toInteger($cid);

                if (count($cid) < 1) {
                        JError::raiseError(500, JText::_('Select a Bom to delete', true));
                }
                foreach ($cid as $id) {
                        echo $id;
                        $pns = explode("_", $id);
                        $pns_id = $pns[0];
                        $parent_id = $pns[2];
                        // check for a super admin ... can't delete them
                        //$query = "UPDATE apdm_pns SET pns_deleted=1 WHERE pns_id=" . $id;
                        //$db->setQuery($query);
                        //$db->query();
                        $db->setQuery("DELETE FROM apdm_pns_parents WHERE pns_id =" . $pns_id . " and pns_parent = ".$parent_id."");
                        $db->query();
                        ///update history
                        //JAdministrator::HistoryUser(6, 'D', $id);
                }
                $msg = "Have successfuly Remove pns";
                $return = JRequest::getVar('return');
                if ($return) {
                        $this->setRedirect('index.php?option=com_apdmpns&task=bom&id=' . $return, $msg);
                } else {
                        $this->setRedirect('index.php?option=com_apdmpns', $msg);
                }
        }

        /**
         * Cancels an edit operation
         */
        function cancel() {
                $return = JRequest::getVar('return');
                if ($return) {
                        $this->setRedirect('index.php?option=com_apdmpns&task=listpns&id=' . $return);
                } else {
                        $this->setRedirect('index.php?option=com_apdmpns');
                }
        }

        /**
         * @desc Cancel list pns
         */
        function cancel_listpns() {
                global $mainframe, $option;
                $option = 'com_apdmpns';
                $mainframe->getUserStateFromRequest("$option.text_search", 'text_search', '', 'string');
                $mainframe->setUserState("$option.type_filter", 0);
                $mainframe->setUserState("$option.text_search", '');
                $this->setRedirect('index.php?option=com_apdmpns');
        }

        /**
         * @desc Remove organization
         */
        function remove_info() {
                $db = & JFactory::getDBO();
                $id = JRequest::getVar('id');
                $pns_id = JRequest::getVar('pns_id');
                $db->setQuery("DELETE FROM apdm_pns_supplier WHERE id=" . $id);
                $db->query();
                $msg = JText::_('Have delete information successfully.');
                $this->setRedirect('index.php?option=com_apdmpns&task=mep&cid[]=' . $pns_id, $msg);
        }

        /**
         * @desc Remove organization
         */
        function remove_infomf() {
                $db = & JFactory::getDBO();
                $id = JRequest::getVar('id');
                $pns_id = JRequest::getVar('pns_id');
                $db->setQuery("DELETE FROM apdm_pns_supplier WHERE id=" . $id);
                $db->query();
                $msg = JText::_('Have delete information successfully.');
                $this->setRedirect('index.php?option=com_apdmpns&task=mep&cid[]=' . $pns_id, $msg);
        }

        /**
         * @desc Remove image PNs
         * */
        function remove_img() {
                $db = & JFactory::getDBO();
                $id = JRequest::getVar('id');
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'images' . DS;
                $row = & JTable::getInstance('apdmpns');
                $row->load($id);
                $pns_image = $row->pns_image;
                $handle = new upload($path_pns . $pns_image);
                $handle->file_dst_pathname = $path_pns . $pns_image;
                $handle->clean();
                $row->pns_image = "";
                if ($row->store()) {
                        $msg = JText::_('Have delete image successfully.');
                } else {
                        $msg = JText::_('Have a problem with remove image.');
                }
                $this->setRedirect('index.php?option=com_apdmpns&task=specification&cid[]=' . $id, $msg);
        }

        /**
         * @desc  Remove file cads
         */
        function remove_imgs() {
                $db = & JFactory::getDBO();
                $id = JRequest::getVar('id');
                $pid = JRequest::getVar('pid');
                //get name file cad
                $query = "SELECT * FROM apdm_pns_image WHERE pns_image_id=" . $id;
                $db->setQuery($query);
                $row = $db->loadObject();
                $pns_id = $row->pns_id;
                $file_name = $row->image_file;
                //get folder file cad          
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS;

                $handle = new upload($path_pns . $file_name);
                $handle->file_dst_pathname = $path_pns . $file_name;
                $handle->clean();

                $db->setQuery("DELETE FROM apdm_pns_image WHERE pns_image_id=" . $id);
                $db->query();
                $msg = JText::_('Have successfuly delete image file');
                $this->setRedirect('index.php?option=com_apdmpns&task=specification&cid[]=' . $pns_id, $msg);
        }

        /**
         * @desc  Remove file cads
         */
        function remove_pdfs() {
                $db = & JFactory::getDBO();
                $id = JRequest::getVar('id');
                $pid = JRequest::getVar('pid');
                //get name file cad
                $query = "SELECT * FROM apdm_pns_pdf WHERE pns_pdf_id=" . $id;
                $db->setQuery($query);
                $row = $db->loadObject();
                $pns_id = $row->pns_id;
                $file_name = $row->pdf_file;
                //get folder file cad          
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS;

                $handle = new upload($path_pns . $file_name);
                $handle->file_dst_pathname = $path_pns . $file_name;
                $handle->clean();

                $db->setQuery("DELETE FROM apdm_pns_pdf WHERE pns_pdf_id=" . $id);
                $db->query();
                $msg = JText::_('Have successfuly delete pdf file');
                $this->setRedirect('index.php?option=com_apdmpns&task=specification&cid[]=' . $pns_id, $msg);
        }

        /**
         * @desc  remove pns pdf file     
         */
        function remove_pdf() {
                $db = & JFactory::getDBO();
                $id = JRequest::getVar('id');
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'pdf' . DS;
                $row = & JTable::getInstance('apdmpns');
                $row->load($id);
                $pns_pdf = $row->pns_pdf;
                $handle = new upload($path_pns . $pns_pdf);
                $handle->file_dst_pathname = $path_pns . $pns_pdf;
                $handle->clean();
                $row->pns_pdf = "";
                if ($row->store()) {
                        $msg = JText::_('Have delete pdf successfully.');
                } else {
                        $msg = JText::_('Have a problem with remove pdf.');
                }
                $this->setRedirect('index.php?option=com_apdmpns&task=specification&cid[]=' . $id, $msg);
        }

        /**
         * @desc  Remove file cads
         */
        function remove_cad() {
                $db = & JFactory::getDBO();
                $id = JRequest::getVar('id');
                //get name file cad
                $query = "SELECT * FROM apdm_pn_cad WHERE pns_cad_id=" . $id;
                $db->setQuery($query);
                $row = $db->loadObject();
                $pns_id = $row->pns_id;
                $file_name = $row->cad_file;
                //get folder file cad
                $querypn = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS pns_code, p.ccs_code FROM apdm_pns AS p  WHERE  p.pns_id =" . $pns_id;
                $db->setQuery($querypn);
                $pns = $db->loadObject();
                $pns_code = $pns->pns_code;
                $ccs_code = $pns->ccs_code;
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'cads' . DS . $ccs_code . DS . $pns_code . DS;

                $handle = new upload($path_pns . $file_name);
                $handle->file_dst_pathname = $path_pns . $file_name;
                $handle->clean();

                $db->setQuery("DELETE FROM apdm_pn_cad WHERE pns_cad_id=" . $id);
                $db->query();
                $msg = JText::_('Have successfuly delete cad file');
                $this->setRedirect('index.php?option=com_apdmpns&task=specification&cid[]=' . $pns_id, $msg);
        }

        /**
         * @desc remove all file cads of PNs  
         */
        function remove_all_cad() {
                $db = & JFactory::getDBO();
                $pns_id = JRequest::getVar('pns_id');
                //get folder file cad
                $querypn = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS pns_code, p.ccs_code FROM apdm_pns AS p  WHERE  p.pns_id =" . $pns_id;
                $db->setQuery($querypn);
                $pns = $db->loadObject();
                $pns_code = $pns->pns_code;
                $ccs_code = $pns->ccs_code;

                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'cads' . DS . $ccs_code . DS . $pns_code . DS;

                $query = "SELECT * FROM apdm_pn_cad WHERE pns_id=" . $pns_id;
                $db->setQuery($query);
                $rows = $db->loadObjectList();
                if (count($rows) > 0) {
                        foreach ($rows as $row) {
                                $file_cad = $row->cad_file;
                                $handle = new upload($path_pns . $file_cad);
                                $handle->file_dst_pathname = $path_pns . $file_cad;
                                $handle->clean();
                        }
                }
                $db->setQuery("DELETE FROM apdm_pn_cad WHERE pns_id=" . $pns_id);
                $db->query();
                $msg = JText::_('All file cad have deleted');
                $this->setRedirect('index.php?option=com_apdmpns&task=edit&cid[]=' . $pns_id, $msg);
        }

        /**
         * @desc remove all file cads of PNs  
         */
        function remove_all_pdfs() {
                $db = & JFactory::getDBO();
                $pns_id = JRequest::getVar('pns_id');
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'pdf' . DS;

                $query = "SELECT * FROM apdm_pns_pdf WHERE pns_id=" . $pns_id;
                $db->setQuery($query);
                $rows = $db->loadObjectList();
                if (count($rows) > 0) {
                        foreach ($rows as $row) {
                                $file_pdf = $row->pdf_file;
                                $handle = new upload($path_pns . $file_pdf);
                                $handle->file_dst_pathname = $path_pns . $file_pdf;
                                $handle->clean();
                        }
                }
                $db->setQuery("DELETE FROM apdm_pns_pdf WHERE pns_id=" . $pns_id);
                $db->query();
                $msg = JText::_('All file pdf have deleted');
                $this->setRedirect('index.php?option=com_apdmpns&task=specification&cid[]=' . $pns_id, $msg);
        }

        /**
         * @desc remove all file cads of PNs  
         */
        function remove_all_images() {
                $db = & JFactory::getDBO();
                $pns_id = JRequest::getVar('pns_id');
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'images' . DS;

                $query = "SELECT * FROM apdm_pns_image WHERE pns_id=" . $pns_id;
                $db->setQuery($query);
                $rows = $db->loadObjectList();
                if (count($rows) > 0) {
                        foreach ($rows as $row) {
                                $image_file = $row->image_file;
                                $handle = new upload($path_pns . image_file);
                                $handle->file_dst_pathname = $path_pns . image_file;
                                $handle->clean();
                        }
                }
                $db->setQuery("DELETE FROM apdm_pns_image WHERE pns_id=" . $pns_id);
                $db->query();
                $msg = JText::_('All file image have deleted');
                $this->setRedirect('index.php?option=com_apdmpns&task=specification&cid[]=' . $pns_id, $msg);
        }

        /*
          Remove PNS child
         */

        function remove_parent() {
                $db = & JFactory::getDBO();
                //$id = JRequest::getVar('id');
                $cid = JRequest::getVar('cid', array(), '', 'array');
                $pns_id = JRequest::getVar('id');

                $db->setQuery('DELETE FROM apdm_pns_parents WHERE pns_id IN (' . implode(",", $cid) . ') AND pns_parent=' . $pns_id);
                $db->query();
                $msg = JText::_('PNS Parent have deleted.');
                JRequest::setVar('id', $pns_id);
                JRequest::setVar('tmpl', 'component');
                JRequest::setVar('layout', 'ajax');
                JRequest::setVar('view', 'listchild');

                parent::display();
        }

        /**
         * @desc Read file size
         */
        function Readfilesize($folder, $filename, $ccs=null, $pns=null) {
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS;
                $filesize = '';
                //PNsController::Readfilesize('images', $image['image_file'], $this->row->ccs_code, $folder);
               /* switch ($folder) {
                        case "cads":
                                $path_pns .= $folder . DS . $ccs . DS . $pns . DS;
                                break;
                        case "images":
                              echo  $path_pns .= $folder . DS;
                                break;
                        default: //images; pdf
                            echo    $path_pns .= $folder . DS;
                                break;
                }*/
               $path_pns .= $folder . DS . $ccs . DS . $pns . DS;

                if (file_exists($path_pns . $filename)) {
                        $filesize = ceil(filesize($path_pns . $filename) / 1000);
                } else {
                        $filesize = 0;
                }
                return $filesize;
        }

        /**
         * Download file
         * */
        function download() {
                $pns_id = JRequest::getVar('id');
                $row = & JTable::getInstance('apdmpns');
                $row->load($pns_id);
                $file_name = $row->pns_pdf;
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'pdf' . DS;
                $dFile = new DownloadFile($path_pns, $file_name);
                exit;
        }

        /**
         * @desc Download imge of PNs
         */
        function download_img() {
                $pns_id = JRequest::getVar('id');
                $row = & JTable::getInstance('apdmpns');
                $row->load($pns_id);
                $file_name = $row->pns_image;
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'images' . DS;
                $dFile = new DownloadFile($path_pns, $file_name);
                exit;
        }

        /**
         * @desc Download imge of PNs
         */
        function download_imgs() {
                $db = & JFactory::getDBO();
                $pns_id = JRequest::getVar('pid');
                $image_id = JRequest::getVar('id');


                $query = "SELECT img.pns_id,img.image_file,p.pns_code,p.ccs_code,p.pns_revision FROM apdm_pns_image img inner join apdm_pns p on img.pns_id = p.pns_id WHERE pns_image_id=" . $image_id;
                $db->setQuery($query);
                $row = $db->loadObject();
                
                ///for pns cads/image/pdf
                if ($row->pns_revision) {
                        $folder = $row->ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                } else {
                        $folder = $row->ccs_code . '-' . $row->pns_code;
                }
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS;
                $path_cads = $path_pns . 'cads' . DS . $row->ccs_code . DS . $folder . DS;                   
                
                $pns_id = $row->pns_id;
                $file_name = $row->image_file;
                return $dFile = new DownloadFile($path_cads, $file_name);
                exit;
        }

        /**
         * @desc Download imge of PNs
         */
        function download_pdfs() {
                $db = & JFactory::getDBO();
                $pns_id = JRequest::getVar('pid');
                $image_id = JRequest::getVar('id');
                $query = "SELECT pdf.pns_id,pdf.pdf_file,p.pns_code,p.ccs_code,p.pns_revision FROM apdm_pns_pdf pdf inner join apdm_pns p on pdf.pns_id = p.pns_id WHERE pns_pdf_id=" . $image_id;
                $db->setQuery($query);
                $row = $db->loadObject();
                
                ///for pns cads/image/pdf
                if ($row->pns_revision) {
                        $folder = $row->ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                } else {
                        $folder = $row->ccs_code . '-' . $row->pns_code;
                }
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS;
                $path_cads = $path_pns . 'cads' . DS . $row->ccs_code . DS . $folder . DS;   
               
                //$pns_id = $row->pns_id;
                $file_name = $row->pdf_file;
                //$path_pns = $path_cads;
                $dFile = new DownloadFile($path_cads, $file_name);
                exit;
        }
        function download_allpdfs()
        {
                $db = & JFactory::getDBO();                
                $pn_id = JRequest::getVar('id');
                $query = "SELECT pdf.pns_id,pdf.pdf_file,p.pns_code,p.ccs_code,p.pns_revision FROM apdm_pns_pdf pdf inner join apdm_pns p on pdf.pns_id = p.pns_id WHERE pdf.pns_id =" . $pn_id;
                $db->setQuery($query);
                $rows = $db->loadObjectList();
                

                foreach($rows as $row)
                {
                        ///for pns cads/image/pdf
                        if ($row->pns_revision) {
                                $folder = $row->ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                        } else {
                                $folder = $row->ccs_code . '-' . $row->pns_code;
                        }
                        $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS;
                        $path_cads = $path_pns . 'cads' . DS . $row->ccs_code . DS . $folder . DS;                           
                        $pns_id = $rowr->pns_id;
                        $file_name = $row->pdf_file;
                        //$path_pns = $path_cads;
                        $dFile = new DownloadFile($path_cads, $file_name);
                }
                exit;
        }
        function checkexistPdf($pn_id)
        {
                $db = & JFactory::getDBO();                
                $db->setQuery("SELECT pdf_file FROM apdm_pns_pdf WHERE pns_id=" . $pn_id);
                $pns_pdf = $db->loadResult();
                if ($pns_pdf) {
                        return 1;
                }
                return 0;
        }
        function checkexistSpec($pn_id)
        {
                $db = & JFactory::getDBO();                
                $db->setQuery("SELECT pdf_file FROM apdm_pns_pdf WHERE pns_id=" . $pn_id);
                $pns_pdf = $db->loadResult();
                $db->setQuery("SELECT cad_file FROM apdm_pn_cad WHERE pns_id=" . $pn_id);
                $pns_cad = $db->loadResult();
                $db->setQuery("SELECT image_file FROM apdm_pns_image WHERE pns_id=" . $pn_id);
                $pns_img = $db->loadResult();                
                if ($pns_pdf || $pns_cad || $pns_img) {
                        return 1;
                }
                return 0;
        }                
        /**
         * @desc Download cad file of PNs
         */
        function download_cad() {
                $db = & JFactory::getDBO();
                $pns_cad_id = JRequest::getVar('id');
                $query = "SELECT * FROM apdm_pn_cad WHERE pns_cad_id=" . $pns_cad_id;
                $db->setQuery($query);
                $row = $db->loadObject();
                $pns_id = $row->pns_id;
                $file_name = $row->cad_file;

                $querypn = "SELECT p.pns_code,p.ccs_code,p.pns_revision FROM apdm_pns AS p  WHERE  p.pns_id =" . $pns_id;
                $db->setQuery($querypn);
                $pns = $db->loadObject();
                $pns_code = $pns->pns_code;
                $ccs_code = $pns->ccs_code;
                if (substr($pns_code, -1) == "-") {
                        $pns_code = substr($pns_code, 0, strlen($pns_code) - 1);
                }
                
 ///for pns cads/image/pdf
                if ($pns->pns_revision) {
                        $folder = $pns->ccs_code . '-' . $pns->pns_code . '-' . $pns->pns_revision;
                } else {
                        $folder = $pns->ccs_code . '-' . $pns->pns_code;
                }
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS;
                $path_cads = $path_pns . 'cads' . DS . $pns->ccs_code . DS . $folder . DS;   
                
                //$path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'cads' . DS . $ccs_code . DS . $pns_code . DS;

                $dFile = new DownloadFile($path_cads, $file_name);
                exit;
        }

        /*
          Download all cad file
         */

        function download_cad_all_pns() {
                global $dirarray, $conf, $dirsize;

                //$conf['dir'] = "zipfiles";
                $conf['dir'] = "../uploads/pns/cads/PNsZip";
                $db = & JFactory::getDBO();
                $pns_id = JRequest::getVar('pns_id');
                $querypn = "SELECT p.ccs_code,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS pns_code FROM apdm_pns AS p  WHERE  p.pns_id =" . $pns_id;
                $db->setQuery($querypn);
                $pns = $db->loadObject();
                $pns_code = $pns->pns_code;
                if (substr($pns_code, -1) == "-") {
                        $pns_code = substr($pns_code, 0, strlen($pns_code) - 1);
                }
                //bom

                PNsController::export_bom();


                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'cads' . DS . $pns->ccs_code . DS . $pns_code . DS;
                 
                $dirarray = array();
                $dirsize = 0;
                $zdirsize = 0;
                $zdir[] = $path_pns;
                

                $dirarray = array();
                $dirsize = 0;
                $zdirsize = 0;
                for ($i = 0; $i < count($zdir); $i++) {
                     
                        $ffile = $zdir[$i];
                        if (is_dir($ffile)) {
                                getdir($ffile);
                        } else {

                                if ($fsize = @filesize($ffile))
                                        $zdirsize+=$fsize;
                        }
                }

                $zdirsize+=$dirsize;

                for ($i = 0; $i < count($dirarray); $i++) {
                        $zdir[] = $dirarray[$i];
                }

                if (!@is_dir($conf['dir'])) {
                        $res = @mkdir($conf['dir'], 0777);
                        if (!$res)
                                $txtout = "Cannot create dir !<br>";
                } else
                        @chmod($conf['dir'], 0777);



//
//                $zdirsize+=$dirsize;
//                for ($i = 0; $i < count($dirarray); $i++) {
//                        $zdir[] = $dirarray[$i];
//                }

                
                if (!@is_dir($conf['dir'])) {
                        $res = @mkdir($conf['dir'], 0777);
                        if (!$res)
                                $txtout = "Cannot create dir !<br>";
                } else
                        @chmod($conf['dir'], 0777);

                $zipname = 'zipfile_' . $pns_code;
                $zipname = str_replace("/", "", $zipname);
                //if (empty($zipname)) $zipname="NDKzip";
                $zipname.=".zip";

                $ziper = new zipfile();
                $ziper->addFiles($zdir);
                $ziper->output("{$conf['dir']}/{$zipname}");

                if ($fsize = @filesize("{$conf['dir']}/{$zipname}"))
                        $zipsize = $fsize;
                else
                        $zipsize = 0;


                $zdirsize = PNsController::size_format($zdirsize);
                $zipsize = PNsController::size_format($zipsize);
                $archive_file_name = $conf['dir'] . '/' . $zipname;

                header("Content-type: application/zip");
                header("Content-Disposition: attachment; filename=$archive_file_name");
                header("Pragma: no-cache");
                header("Expires: 0");
                readfile("$archive_file_name");
                $this->setRedirect('index.php?option=com_apdmpns&task=bom&id=' . $pns_id);
                exit;
        }
        function getAllfilesPn($pns_id)
        {
            $db =& JFactory::getDBO();
            ///get list cad files
            $db->setQuery("SELECT pdf_file as file_name FROM apdm_pns_pdf WHERE pns_id=".$pns_id ." union SELECT image_file as file_name FROM apdm_pns_image WHERE pns_id=".$pns_id ."  union SELECT cad_file  as file_name FROM apdm_pn_cad WHERE pns_id=".$pns_id);
            $res = $db->loadObjectList();
            $cads_files = array();
            if (count($res)>0){
                foreach ($res as $r){
                    $cads_files[] = $r->file_name;
                }
            }
            return $cads_files;
        }
        function download_all_bompns() {

                global $dirarray, $conf, $dirsize;

                //$conf['dir'] = "zipfiles";
                $conf['dir'] = "../uploads/pns/cads/PNsZip";
                $db = & JFactory::getDBO();
                $pns_id = JRequest::getVar('pns_id');
                $querypn = "SELECT p.ccs_code, CONCAT(p.ccs_code,'-',p.pns_code,if(p.pns_revision = '','','-'),p.pns_revision) AS pns_code,p.pns_id FROM apdm_pns AS p  WHERE  p.pns_id =" . $pns_id;
                $db->setQuery($querypn);
                $pns = $db->loadObject();
                $pns_code = $pns->pns_code;
                if (substr($pns_code, -1) == "-") {
                        $pns_code = substr($pns_code, 0, strlen($pns_code) - 1);
                }
                //bom
                PNsController::export_bom();
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'cads' . DS . $pns->ccs_code . DS . $pns_code . DS;
                 
                $dirarray = array();
                $dirsize = 0;
                $zdirsize = 0;
                $list_files = array();
                if(is_dir($path_pns))
                {
                        //$list_files[] = PNsController::getAllfilesPn($pns->pns_id);
                        $db->setQuery("SELECT pdf_file as file_name FROM apdm_pns_pdf WHERE pns_id=".$pns->pns_id ." union SELECT image_file as file_name FROM apdm_pns_image WHERE pns_id=".$pns->pns_id ."  union SELECT cad_file  as file_name FROM apdm_pn_cad WHERE pns_id=".$pns->pns_id);
                        $res = $db->loadObjectList();
                        if (count($res)>0){
                            foreach ($res as $r){
                                $list_files[] = $r->file_name;
                            }
                        }
                        $zdir[] = $path_pns;
                }
                $list_pns2 = PNsController::DisplayPnsAllChildId($pns->pns_id);
                foreach ($list_pns2 as $row2){                       
                        
                        $path_pns2 = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'cads' . DS . $row2->ccs_code . DS . $row2->text . DS;       
                        if(is_dir($path_pns2)){
                            //    $list_files[]  = PNsController::getAllfilesPn($row2->pns_id);
                            $db->setQuery("SELECT pdf_file as file_name FROM apdm_pns_pdf WHERE pns_id=".$row2->pns_id ." union SELECT image_file as file_name FROM apdm_pns_image WHERE pns_id=".$row2->pns_id ."  union SELECT cad_file  as file_name FROM apdm_pn_cad WHERE pns_id=".$row2->pns_id);
                            $res = $db->loadObjectList();
                            if (count($res)>0){
                                foreach ($res as $r){
                                    $list_files[] = $r->file_name;
                                }
                            }
                               $zdir[] =  $path_pns2;
                        }
                        $list_pns3 = PNsController::DisplayPnsAllChildId($row2->pns_id);
                        foreach ($list_pns3 as $row3){                       
                                $path_pns3 = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'cads' . DS . $row3->ccs_code . DS . $row3->text . DS;       
                                if(is_dir($path_pns3)){
                                       // $list_files[]  = PNsController::getAllfilesPn($row3->pns_id);
                                    $db->setQuery("SELECT pdf_file as file_name FROM apdm_pns_pdf WHERE pns_id=".$row3->pns_id ." union SELECT image_file as file_name FROM apdm_pns_image WHERE pns_id=".$row3->pns_id ."  union SELECT cad_file  as file_name FROM apdm_pn_cad WHERE pns_id=".$row3->pns_id);
                                    $res = $db->loadObjectList();
                                    if (count($res)>0){
                                        foreach ($res as $r){
                                            $list_files[] = $r->file_name;
                                        }
                                    }
                                        $zdir[] =  $path_pns3;
                                 }
                                 $list_pns4 = PNsController::DisplayPnsAllChildId($row3->pns_id);
                                foreach ($list_pns4 as $row4){                       
                                        $path_pns4 = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'cads' . DS . $row4->ccs_code . DS . $row4->text . DS;       
                                        if(is_dir($path_pns4)){
                                                $zdir[] =  $path_pns4;
                                        }
                                         $list_pns5 = PNsController::DisplayPnsAllChildId($row4->pns_id);
                                        foreach ($list_pns5 as $row5){                       
                                                $path_pns5 = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'cads' . DS . $row5->ccs_code . DS . $row5->text . DS;       
                                                if(is_dir($path_pns5)){
                                                      $zdir[] =  $path_pns5;
                                                }
                                                 $list_pns6 = PNsController::DisplayPnsAllChildId($row5->pns_id);
                                                foreach ($list_pns6 as $row6){                       
                                                        $path_pns6 = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'cads' . DS . $row6->ccs_code . DS . $row6->text . DS;       
                                                        if(is_dir($path_pns6)){
                                                              $zdir[] =  $path_pns6;
                                                        }
                                                         $list_pns7 = PNsController::DisplayPnsAllChildId($row6->pns_id);
                                                        foreach ($list_pns7 as $row7){                       
                                                                $path_pns7 = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'cads' . DS . $row7->ccs_code . DS . $row7->text . DS;       
                                                                if(is_dir($path_pns7)){
                                                                      $zdir[] =  $path_pns7;
                                                                }
                                                                 $list_pns8 = PNsController::DisplayPnsAllChildId($row7->pns_id);
                                                                foreach ($list_pns8 as $row8){                       
                                                                       $path_pns8 = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'cads' . DS . $row8->ccs_code . DS . $row8->text . DS;       
                                                                        if(is_dir($path_pns8)){
                                                                                $zdir[] =  $path_pns8;
                                                                        }
                                                                         $list_pns9 = PNsController::DisplayPnsAllChildId($row8->pns_id);
                                                                        foreach ($list_pns9 as $row9){                       
                                                                                $path_pns9 = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'cads' . DS . $row9->ccs_code . DS . $row9->text . DS;       
                                                                                if(is_dir($path_pns9)){
                                                                                      $zdir[] =  $path_pns9;
                                                                                }
                                                                                 $list_pns10 = PNsController::DisplayPnsAllChildId($row9->pns_id);
                                                                                foreach ($list_pns10 as $row10){                       
                                                                                        $path_pns10 = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'cads' . DS . $row10->ccs_code . DS . $row10->text . DS;       
                                                                                         if(is_dir($path_pns9)){
                                                                                                 $zdir[] =  $path_pns10;
                                                                                         }

                                                                                }
                                                                        }
                                                                }
                                                        }
                                                }
                                        }
                                }
                        }
                }

                $dirarray = array();
                $dirsize = 0;
                $zdirsize = 0;
                for ($i = 0; $i < count($zdir); $i++) {
                     
                        $ffile = $zdir[$i];
                        if (is_dir($ffile)) {
                                getdir($ffile);
                        } else {

                                if ($fsize = @filesize($ffile))
                                        $zdirsize+=$fsize;
                        }
                }

                $zdirsize+=$dirsize;

                for ($i = 0; $i < count($dirarray); $i++) {
                        $zdir[] = $dirarray[$i];
                }

                //chua xongv


            for ($i = 0; $i < count($dirarray); $i++) {
                 $fName= substr(end(explode("\\", $dirarray[$i])),1);
                if(in_array($fName, $list_files))
                {
                    $zdir1[] = $dirarray[$i];
                }
            }
            //get Bom

            $zdir1[] = $path_pns . "/".$pns_code.'_APDM_BOM_REPORT.xls';
                if (!@is_dir($conf['dir'])) {
                        $res = @mkdir($conf['dir'], 0777);
                        if (!$res)
                                $txtout = "Cannot create dir !<br>";
                } else
                        @chmod($conf['dir'], 0777);



//
//                $zdirsize+=$dirsize;
//                for ($i = 0; $i < count($dirarray); $i++) {
//                        $zdir[] = $dirarray[$i];
//                }

                

                if (!@is_dir($conf['dir'])) {
                        $res = @mkdir($conf['dir'], 0777);
                        if (!$res)
                                $txtout = "Cannot create dir !<br>";
                } else
                        @chmod($conf['dir'], 0777);

                $zipname = 'zipfile_' . $pns_code;
                $zipname = str_replace("/", "", $zipname);
                //if (empty($zipname)) $zipname="NDKzip";
                $zipname.=".zip";

                $ziper = new zipfile();
                $ziper->addFiles($zdir1);
                $ziper->output("{$conf['dir']}/{$zipname}");

                if ($fsize = @filesize("{$conf['dir']}/{$zipname}"))
                        $zipsize = $fsize;
                else
                        $zipsize = 0;


                $zdirsize = PNsController::size_format($zdirsize);
                $zipsize = PNsController::size_format($zipsize);
                $archive_file_name = $conf['dir'] . '/' . $zipname;

                header("Content-type: application/zip");
                header("Content-Disposition: attachment; filename=$archive_file_name");
                header("Pragma: no-cache");
                header("Expires: 0");
                readfile("$archive_file_name");
                $this->setRedirect('index.php?option=com_apdmpns&task=bom&id=' . $pns_id);
                exit;
        }
        function GetNameCCs($ccs_id) {
                $db = & JFactory::getDBO();
                $db->setQuery("SELECT ccs_code FROM apdm_ccs WHERE ccs_id=" . $ccs_id);
                return $db->loadResult();
        }

        function GetECO($eco_id) {
                $db = & JFactory::getDBO();
                $db->setQuery("SELECT eco_name FROM apdm_eco WHERE eco_id=" . $eco_id);
                return $db->loadResult();
        }
        function GetECOId($eco_name) {
                $db = & JFactory::getDBO();
                $db->setQuery("SELECT eco_id FROM apdm_eco WHERE eco_name=' " . $eco_name."'");
                return $db->loadResult();
        }
        /**
         * @desc Display list child pns 
         */
        function DisplayPnsChild($pns_id, $cd) {
                $vcd = $cd;
                $db = & JFactory::getDBO();
                $sql = 'SELECT pr.pns_id, p.ccs_code FROM apdm_pns_parents as pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE p.pns_deleted = 0 AND pr.pns_parent=' . $pns_id . ' ORDER BY p.ccs_code';
                $db->setQuery($sql);
                $rs = $db->loadObjectList();
                if (count($rs) > 0) {
                        $resutl = '<ul>';
                        foreach ($rs as $obj) {
                                //get information of PNs
                                $querypn = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS text, e.eco_name, p.    pns_description, p.pns_type, p.pns_status FROM apdm_pns AS p  LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND p.pns_id=" . $obj->pns_id;
                                //   echo  $querypn;
                                $db->setQuery($querypn);
                                $row = $db->loadObject();
                                $pns_code = $row->text;
                                $type = substr($row->pns_type, 0, 1);
                                // echo $type;
                                $status = $row->pns_status;
                                if (substr($pns_code, -1) == "-") {
                                        $pns_code = substr($pns_code, 0, strlen($pns_code) - 1);
                                }
                                $resutl .= '<li>';
                                $resutl .= '<p><input  type="checkbox" onclick="isChecked(this.checked);" value="' . $obj->pns_id . '" name="cid[]"  /> <a href="index.php?option=com_apdmpns&task=detail&cid[]=' . $obj->pns_id . '&cd=' . $vcd . '" title="' . JText::_('Click to see detail PNs') . '">' . $pns_code . '</a></p> ';
                                $resutl .= PNsController::DisplayPnsChild($obj->pns_id, $vcd);

                                $resutl .= '</li>';
                        }
                        $resutl .= '</ul>';
                }

                return $resutl;
        }

        function DisplayPnsChildId($pns_id, $cd) {
                $vcd = $cd;
                $db = & JFactory::getDBO();
                $sql = 'SELECT pr.pns_id, p.ccs_code FROM apdm_pns_parents as pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE p.pns_deleted = 0 AND pr.pns_parent=' . $pns_id . ' ORDER BY p.ccs_code ';
                $db->setQuery($sql);
                $rs = $db->loadObjectList();
                if (count($rs) > 0) {
                        $result = '';
                        foreach ($rs as $obj) {
                                //get information of PNs
                                $querypn = "SELECT CONCAT(p.ccs_code,'-',p.pns_code,if(p.pns_revision = '','','-'),p.pns_revision)  AS text, e.eco_name, p.    pns_description, p.pns_type, p.pns_status FROM apdm_pns AS p  LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND p.pns_id=" . $obj->pns_id;
                                //   echo  $querypn;
                                $db->setQuery($querypn);
                                $row = $db->loadObject();
                                $pns_code = $row->text;
                                $type = substr($row->pns_type, 0, 1);
                                // echo $type;
                                $status = $row->pns_status;
                                if (substr($pns_code, -1) == "-") {
                                        $pns_code = substr($pns_code, 0, strlen($pns_code) - 1);
                                }
                                $result .= $obj->pns_id . ',';
                                $result .= PNsController::DisplayPnsChildId($obj->pns_id, $vcd);
                        }
                }

                return $result;
        }

        /*
         * save stock for PO/PN
         */        
        function saveqtyfk() {
                $db = & JFactory::getDBO();
                $cid = JRequest::getVar('cid', array(), '', 'array');
                $fkid = JRequest::getVar('id');               
                foreach ($cid as $id) {
                        $stock = JRequest::getVar('qty_' . $id);                     
                        $db->setQuery("update apdm_pns_po_fk set qty=" . $stock . " WHERE  id = " . $id);
                        $db->query();
                }
                $msg = "Successfully Saved Part Number";
                $this->setRedirect('index.php?option=com_apdmpns&task=po_detail&id=' . $fkid, $msg);
        }        
        /*
         * save stock for STO/PN
         */
        function saveqtyStofk() {
                $db = & JFactory::getDBO();
                $cid = JRequest::getVar('cid', array(), '', 'array');
               
                $fkid = JRequest::getVar('id');               
                foreach ($cid as $pnsid) {
                        $obj = explode("_", $pnsid);
                        $pns=$obj[0];
                        $ids = explode(",",$obj[1]);                        
                        foreach ($ids as $id) {                                
                                $stock = JRequest::getVar('qty_'. $pns .'_' . $id);      
                                $location = JRequest::getVar('location_' . $pns .'_' . $id);         
                                $partState = JRequest::getVar('partstate_' . $pns .'_' . $id);   
                                //get sto_type
                                $db->setQuery("select fk.qty,sto.sto_type,fk.pns_id,fk.sto_id,fk.partstate,fk.location,loc.location_code from apdm_pns_sto sto inner join apdm_pns_sto_fk fk on sto.pns_sto_id = fk.sto_id inner join apdm_pns_location loc on fk.location = loc.pns_location_id where fk.id =  ".$id);                               
                                $stoChecker= $db->loadObject();                                
                                if($stoChecker->sto_type==2)//if is out stock
                                {                                       
                                        $db->setQuery("select sum(fk.qty) as total_qty from apdm_pns_sto sto inner join apdm_pns_sto_fk fk on sto.pns_sto_id = fk.sto_id where fk.pns_id = '".$pnsid."' and fk.partstate = '".$partState."' and fk.location = '".$location."'  and sto.sto_type = 1");                                     
                                        $qtyInCheck = round($db->loadResult(),2);
                                        $db->setQuery("select sum(fk.qty) as total_qty from apdm_pns_sto sto inner join apdm_pns_sto_fk fk on sto.pns_sto_id = fk.sto_id where fk.pns_id = '".$pnsid."' and fk.partstate = '".$partState."' and fk.location = '".$location."'  and sto.sto_type = 2 and fk.id != ".$id);                                     
                                        $qtyOutCheck = $db->loadResult();
                                        $currentOutStock = $stock+$qtyOutCheck;
                                        if($currentOutStock > $qtyInCheck)
                                        {
                                                $msg = "Qty just input at row have Part State:".$stoChecker->partstate.",Location:".$stoChecker->location_code." must less than $qtyInCheck";
                                                return $this->setRedirect('index.php?option=com_apdmpns&task=sto_detail&id=' . $fkid, $msg);
                                        }                                         
                                }
                                $db->setQuery("update apdm_pns_sto_fk set qty=" . $stock . ", location='" . $location . "', partstate='" . $partState . "' WHERE  id = " . $id);                        
                                $db->query();                                
                        }
                }
                $msg = "Successfully Saved Part Number";
                $this->setRedirect('index.php?option=com_apdmpns&task=sto_detail&id=' . $fkid, $msg);
        }                
        function saveref() {
                $db = & JFactory::getDBO();
                $cid = JRequest::getVar('cid', array(), '', 'array');
                $pns_id = JRequest::getVar('pns_id');
               
                foreach ($cid as $id) {
			$pnsid = explode("_", $id);
                        $id = $pnsid[0];
                         $step = $pnsid[1];
                        $pr_id = $pnsid[2];
                         $find_number = JRequest::getVar('find_number_' . $id.'_'.$step);
                        $ref_des = JRequest::getVar('ref_des_' . $id.'_'.$step);
                       // $checkref = explode(",", $ref_des);    
                        $stock = JRequest::getVar('stock_' . $id.'_'.$step);
                        $arr_fail=array();
//                        if (in_array(null, $checkref)) {
//                                $arr_fail[] =$id;
//                                 continue;   
//                        }
                        
//                        if(count($checkref)!=$stock )
//                         {
//                                $arr_fail[] =$id;
//                                continue;   
//                         }                        
                        $db->setQuery("update apdm_pns_parents set stock='" . $stock . "', find_number = '" . $find_number . "',ref_des= '" . $ref_des . "' WHERE  pns_id = " . $id ." and pns_parent = ".$pr_id);                        
                        $db->query();
                }
                if(count($arr_fail)>0)
                {
                        $msg = "Total Ref des mismatch with Qty:".  implode(",", $arr_fail);
                }
                else
                {
                        $msg = "Successfully Saved Part Number";
                }
                $this->setRedirect('index.php?option=com_apdmpns&task=bom&id=' . $pns_id, $msg);
        }

        function DisplayPnsAllChildId($pns_id) {
                $db = & JFactory::getDBO();
                $rows = array();
                $db->setQuery('SELECT pr.pns_id as pns_bom_id,pr.*,CONCAT(p.ccs_code,"-",p.pns_code,if(p.pns_revision = "","","-"),p.pns_revision)  AS text, e.eco_name, p.pns_description, p.pns_type, p.pns_status,p.* FROM apdm_pns AS p LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_id LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND pr.pns_parent in (' . $pns_id . ')');                                
                return $result = $db->loadObjectList();
        }

        function DisplayPnsAllParentId($pns_id) {
                $db = & JFactory::getDBO();
                $rows = array();
                $db->setQuery('SELECT p.*,CONCAT_WS( "-", p.ccs_code, p.pns_code, p.pns_revision ) AS text, e.eco_name, p.    pns_description, p.pns_type, p.pns_status FROM apdm_pns AS p LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_parent LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND pr.pns_id in (' . $pns_id . ')');
                return $result = $db->loadObjectList();
        }

        function GetEcoValue($eco_id) {
                $db = & JFactory::getDBO();
                $db->setQuery('SELECT eco_name FROM apdm_eco WHERE eco_id =' . $eco_id);
                return $db->loadResult();
        }
        function GetPoValue($po_id) {
                $db = & JFactory::getDBO();
                $db->setQuery('SELECT po_code FROM apdm_pns_po WHERE pns_po_id =' . $po_id);
                return $db->loadResult();
        }        

        function GetArrPartNumberParent($pns_id) {
                $db = & JFactory::getDBO();
                $sql = 'SELECT pr.pns_parent FROM apdm_pns_parents as pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE p.pns_deleted = 0 AND pr.pns_id=' . $pns_id . ' ORDER BY ccs_code';
                $db->setQuery($sql);
                $rs = $db->loadObjectList();
                $arr_parent_code = array();
                if (count($rs) > 0) {
                        foreach ($rs as $obj) {
                                $querypn = "SELECT CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS text FROM apdm_pns AS p  LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code WHERE c.ccs_activate= 1 AND c.ccs_deleted=0 AND   p.pns_deleted =0 AND p.pns_id=" . $obj->pns_id;
                                $db->setQuery($querypn);
                                $row = $db->loadObject();
                                $pns_code = $row->text;
                                if (substr($pns_code, -1) == "-") {
                                        $pns_code = substr($pns_code, 0, strlen($pns_code) - 1);
                                }
                                $arr_parent_code[] = $pns_code;
                        }
                }
                return $arr_parent_code;
        }

        /*
         * Get list array id of origanization
         */

        function GetArrInfo($pns_id, $type_id) {
                $db = & JFactory::getDBO();
                $arr_pns_info = array();
                $db->setQuery("SELECT CONCAT_WS('=>', i.info_name, p.supplier_info) as information FROM apdm_pns_supplier as p LEFT JOIN apdm_supplier_info as i ON i.info_id = p.supplier_id WHERE p.type_id=" . $type_id . " AND p.pns_id=" . $pns_id);
                $rs = $db->loadObjectList();
                if (count($rs) > 0) {
                        foreach ($rs as $obj) {
                                $arr_pns_info[] = $obj->information;
                        }
                }
                return $arr_pns_info;
        }

        /*
         * Export BOM with format excel
         */

        function export_bom() {                
                include_once(JPATH_BASE . DS . 'includes' . DS . 'PHPExcel.php');
                require_once (JPATH_BASE . DS . 'includes' . DS . 'PHPExcel' . DS . 'RichText.php');
                require_once(JPATH_BASE . DS . 'includes' . DS . 'PHPExcel' . DS . 'IOFactory.php');
                require_once('includes/download.class.php');
                ini_set("memory_limit", "512M");
                @set_time_limit(1000000);
                $objPHPExcel = new PHPExcel();
                $objReader = PHPExcel_IOFactory::createReader('Excel5'); //Excel5
                $objPHPExcel = $objReader->load(JPATH_COMPONENT . DS . 'apdm_pn_bom_new_report.xls');

                global $mainframe;
                $me = & JFactory::getUser();
                $pns_id = JRequest::getVar('pns_id');
                $username = $me->get('username');
                $db = & JFactory::getDBO();
                $query = 'SELECT * FROM apdm_pns WHERE pns_id=' . $pns_id;
                $db->setQuery($query);
                $row1 = $db->loadObject();            
                 //level 0
                $row = $row1;
                $listPNs = array();
                if ($row->pns_revision) {
                        $pns_code = $row->ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                } else {
                        $pns_code = $row->ccs_code . '-' . $row->pns_code;
                }
                $manufacture = PNsController::GetManufacture($pns_id);                                                                          
                $listPNs[] = array(
                    "pns_code" => $pns_code,
                    "pns_level" => 0,
                 //   "eco" => GetEcoValue($row->eco_id),
                    "pns_type" => $row->pns_type,
                    "pns_des" => $row->pns_description,                   
                    "find_number" => $row->find_number,                    
                    "ref_des" => $row->ref_des,
                    "stock" => $row->stock,
                    "pns_uom" => $row->pns_uom,
                    "v_mf" => $manufacture[0]['v_mf'],
                    "mf" => $manufacture[0]['mf'],
                   // "pns_life_cycle" => $row->pns_life_cycle,
                    "tool_pn" => GetToolPnValue($row->pns_id),
                    "pns_date" => JHTML::_('date', $row->pns_create, '%m/%d/%Y')
                );                                                                                          
                $pnsCodeLevelZero = $pns_code; 
                
                
                $db->setQuery('SELECT pr.pns_id as pns_bom_id,pr.*,CONCAT_WS( "-", p.ccs_code, p.pns_code, p.pns_revision ) AS text, e.eco_name, p.    pns_description, p.pns_type, p.pns_status,p.* FROM apdm_pns AS p LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_id LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND pr.pns_parent in (' . $pns_id . ')');                               
                $list_pns = $db->loadObjectList();
               // $listPNs = array();                           
                foreach ($list_pns as $row){
                        if ($row->pns_revision) {
                                $pns_code = $row->ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                        } else {
                                $pns_code = $row->ccs_code . '-' . $row->pns_code;
                        }
                        $manufacture = PNsController::GetManufacture($row->pns_id);
                        $listPNs[] = array(
                            "pns_code" => $pns_code,
                            "pns_level" => 1,
                            //"eco" => GetEcoValue($row->eco_id),
                            "pns_type" => $row->pns_type,
                            "pns_des" => $row->pns_description,
                            //"pns_status" => $row->pns_status,
                            "find_number" => $row->find_number,                    
                            "ref_des" => $row->ref_des,
                            "stock" => $row->stock,
                            "pns_uom" => $row->pns_uom,
                            "v_mf" => $manufacture[0]['v_mf'],
                            "mf" => $manufacture[0]['mf'],
                            //"pns_life_cycle" => $row->pns_life_cycle,
                            "tool_pn" => GetToolPnValue($row->pns_id),
                            "pns_date" => JHTML::_('date', $row->pns_create, '%m/%d/%Y')

                        );                
                //get list child
                //$query = "SELECT pr.*, p.ccs_code FROM apdm_pns_parents as pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=" . $pns_id . " ORDER BY p.ccs_code ";                                         
                 $list_pns_c1 = $this->DisplayPnsAllChildId($row->pns_id); 
                //for level 2
                foreach ($list_pns_c1 as $result1) {                        
                        if ($result1->pns_revision) {
                                $pns_code1 = $result1->ccs_code . '-' . $result1->pns_code . '-' . $result1->pns_revision;
                        } else {
                                $pns_code1 = $result1->ccs_code . '-' . $result1->pns_code;
                        }
                        $manufacture = PNsController::GetManufacture($result1->pns_id);
                        $listPNs[] = array(
                            "pns_code" => $pns_code1,
                            "pns_level" => 2,
                      //      "eco" => $result1->eco_name,
                            "pns_type" => $result1->pns_type,
                            "pns_des" => $result1->pns_description,
//                            "pns_status" => $result1->pns_status,
                            "find_number" => $result1->find_number, 
                            "ref_des" => $result1->ref_des,
                            "stock" => $result1->stock,
                            "pns_uom" => $result1->pns_uom,
                            "v_mf" => $manufacture[0]['v_mf'],
                            "mf" => $manufacture[0]['mf'],                            
                      //      "pns_life_cycle" => $result1->pns_life_cycle,
                            "tool_pn" => GetToolPnValue($result1->pns_id),
                            "pns_date" => JHTML::_('date', $result1->pns_create, '%m/%d/%Y')
                        );
                        ///check for child of level 3
                        //$db->setQuery("SELECT pr.*,  p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=" . $obj1->pns_id . " ORDER BY p.ccs_code");
//                        $db->setQuery('SELECT pr.pns_id as pns_bom_id,pr.*,CONCAT_WS( "-", p.ccs_code, p.pns_code, p.pns_revision ) AS text, e.eco_name, p.    pns_description, p.pns_type, p.pns_status,p.* FROM apdm_pns AS p LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_id LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND pr.pns_parent in (' . $result1->pns_id . ')');
//                        $rows2 = $db->loadObjectList();
                        $list_pns_c2 = $this->DisplayPnsAllChildId($result1->pns_id); 
                        if (count($list_pns_c2) > 0) {
                                foreach ($list_pns_c2 as $result2) {
                                        if ($result2->pns_revision) {
                                                $pns_code2 = $result2->ccs_code . '-' . $result2->pns_code . '-' . $result2->pns_revision;
                                        } else {
                                                $pns_code2 = $result2->ccs_code . '-' . $result2->pns_code;
                                        }
                                        $manufacture = PNsController::GetManufacture($result2->pns_id);
                                        $listPNs[] = array(
                                            "pns_code" => $pns_code2,
                                            "pns_level" => 3,
                                     //       "eco" => $result2->eco_name,
                                            "pns_type" => $result2->pns_type,
                                            "pns_des" => $result2->pns_description,
//                                            "pns_status" => $result2->pns_status,
                                            "find_number" => $result2->find_number, 
                                            "ref_des" => $result2->ref_des,
                                            "stock" => $result2->stock,
                                            "pns_uom" => $result2->pns_uom,
                                            "v_mf" => $manufacture[0]['v_mf'],
                                                "mf" => $manufacture[0]['mf'],
                                      //      "pns_life_cycle" => $result2->pns_life_cycle,
                                            "tool_pn" => GetToolPnValue($result2->pns_id),
                                            "pns_date" => JHTML::_('date', $result2->pns_create, '%m/%d/%Y')
                                        );
                                        
                                        //check for level 4
                                        //$db->setQuery("SELECT pr.*,  p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=" . $obj2->pns_id . " ORDER BY p.ccs_code");
                                        $list_pns_c3 = $this->DisplayPnsAllChildId($result2->pns_id);    
                                        
                                        if(isset($list_pns_c3)&& sizeof($list_pns_c3)>0){
                                                foreach ($list_pns_c3 as $result3) {
                                                        if ($result3->pns_revision) {
                                                                $pns_code3 = $result3->ccs_code . '-' . $result3->pns_code . '-' . $result3->pns_revision;
                                                        } else {
                                                                $pns_code3 = $result3->ccs_code . '-' . $result3->pns_code;
                                                        }
                                                        $manufacture = PNsController::GetManufacture($result3->pns_id);
                                                        $listPNs[] = array(
                                                            "pns_code" => $pns_code3,
                                                            "pns_level" => 4,
                                         //                   "eco" => $result3->eco_name,
                                                            "pns_type" => $result3->pns_type,
                                                            "pns_des" => $result3->pns_description,
//                                                            "pns_status" => $result3->pns_status,
                                                            "find_number" => $result3->find_number,
                                                            "ref_des" => $result3->ref_des,
                                                            "stock" => $result3->stock,
                                                            "pns_uom" => $result3->pns_uom,
                                                            "v_mf" => $manufacture[0]['v_mf'],
                                                                "mf" => $manufacture[0]['mf'],
                                          //                  "pns_life_cycle" => $result3->pns_life_cycle,
                                                            "tool_pn" => GetToolPnValue($result3->pns_id),
                                                            "pns_date" => JHTML::_('date', $result3->pns_create, '%m/%d/%Y')
                                                        );
                                                        //check for level 5
                                                                $list_pns_c4 = $this->DisplayPnsAllChildId($result3->pns_id);                                                         if (count($rows4) > 0) {
                                                                foreach ($list_pns_c4 as $result4) {
                                                                        if ($result4->pns_revision) {
                                                                                $pns_code4 = $result4->ccs_code . '-' . $result4->pns_code . '-' . $result4->pns_revision;
                                                                        } else {
                                                                                $pns_code4 = $result4->ccs_code . '-' . $result4->pns_code;
                                                                        }
                                                                        $manufacture = PNsController::GetManufacture($result4->pns_id);
                                                                        $listPNs[] = array(
                                                                            "pns_code" => $pns_code4,
                                                                            "pns_level" => 5,
                                                                      //      "eco" => $result4->eco_name,
                                                                            "pns_type" => $result4->pns_type,
                                                                            "pns_des" => $result4->pns_description,
//                                                                            "pns_status" => $result4->pns_status,
                                                                            "find_number" => $result4->find_number, 
                                                                            "ref_des" => $result4->ref_des,
                                                                            "stock" => $result4->stock,
                                                                            "pns_uom" => $result4->pns_uom,
                                                                            "v_mf" => $manufacture[0]['v_mf'],
                                                                                "mf" => $manufacture[0]['mf'],
                                                                         //   "pns_life_cycle" => $result4->pns_life_cycle,
                                                                            "tool_pn" => GetToolPnValue($result4->pns_id),
                                                                            "pns_date" => JHTML::_('date', $result4->pns_create, '%m/%d/%Y')
                                                                        );
                                                                        //check for level 6
                                                                        $list_pns_c5 = $this->DisplayPnsAllChildId($result4->pns_id);    
                                                                        if (count($list_pns_c5) > 0) {
                                                                                foreach ($list_pns_c5 as $result5) {
                                                                                        if ($result4->pns_revision) {
                                                                                                $pns_code5 = $result5->ccs_code . '-' . $result5->pns_code . '-' . $result5->pns_revision;
                                                                                        } else {
                                                                                                $pns_code5 = $result5->ccs_code . '-' . $result5->pns_code;
                                                                                        }
                                                                                        $manufacture = PNsController::GetManufacture($result5->pns_id);
                                                                                        $listPNs[] = array(
                                                                                            "pns_code" => $pns_code5,
                                                                                            "pns_level" => 6,
                                                                                        //    "eco" => $result5->eco_name,
                                                                                            "pns_type" => $result5->pns_type,
                                                                                            "pns_des" => $result5->pns_description,
//                                                                                            "pns_status" => $result5->pns_status,
                                                                                            "find_number" => $result5->find_number, 
                                                                                            "ref_des" => $result5->ref_des,
                                                                                            "stock" => $result5->stock,
                                                                                            "pns_uom" => $result5->pns_uom,
                                                                                            "v_mf" => $manufacture[0]['v_mf'],
                                                                                            "mf" => $manufacture[0]['mf'],
                                                                                         //   "pns_life_cycle" => $result5->pns_life_cycle,
                                                                                            "tool_pn" => GetToolPnValue($result5->pns_id),
                                                                                            "pns_date" => JHTML::_('date', $result5->pns_create, '%m/%d/%Y')
                                                                                        );
                                                                                        //check for level 7
                                                                                        $list_pns_c6 = $this->DisplayPnsAllChildId($result5->pns_id); 
                                                                                        if (count($list_pns_c6) > 0) {
                                                                                                foreach ($list_pns_c6 as $result6) {
                                                                                                        if ($result6->pns_revision) {
                                                                                                                $pns_code6 = $result6->ccs_code . '-' . $result6->pns_code . '-' . $result6->pns_revision;
                                                                                                        } else {
                                                                                                                $pns_code6 = $result6->ccs_code . '-' . $result6->pns_code;
                                                                                                        }
                                                                                                        $manufacture = PNsController::GetManufacture($result6->pns_id);
                                                                                                        $listPNs[] = array(
                                                                                                            "pns_code" => $pns_code6,
                                                                                                            "pns_level" => 7,
                                                                                                        //    "eco" => GetEcoValue($result6->eco_id),
                                                                                                            "pns_type" => $result6->pns_type,
                                                                                                            "pns_des" => $result6->pns_description,
//                                                                                                            "pns_status" => $result6->pns_status,
                                                                                                            "find_number" => $result6->find_number, 
                                                                                                            "ref_des" => $result6->ref_des,
                                                                                                            "stock" => $result6->stock,
                                                                                                            "pns_uom" => $result6->pns_uom,
                                                                                                            "v_mf" => $manufacture[0]['v_mf'],
                                                                                                            "mf" => $manufacture[0]['mf'],
                                                                                                          //  "pns_life_cycle" => $result6->pns_life_cycle,
                                                                                                            "tool_pn" => GetToolPnValue($result6->pns_id),
                                                                                                            "pns_date" => JHTML::_('date', $result6->pns_create, '%m/%d/%Y')
                                                                                                        );
                                                                                                        // check for level 8
                                                                                                        $list_pns_c7 = $this->DisplayPnsAllChildId($result6->pns_id);
                                                                                                        if (count($list_pns_c7) > 0) {
                                                                                                                foreach ($list_pns_c7 as $result7) {
                                                                                                                        if ($result7->pns_revision) {
                                                                                                                                $pns_code7 = $result7->ccs_code . '-' . $result7->pns_code . '-' . $result7->pns_revision;
                                                                                                                        } else {
                                                                                                                                $pns_code7 = $result7->ccs_code . '-' . $result7->pns_code;
                                                                                                                        }
                                                                                                                        $manufacture = PNsController::GetManufacture($result7->pns_id);
                                                                                                                        $listPNs[] = array(
                                                                                                                            "pns_code" => $pns_code7,
                                                                                                                            "pns_level" => 8,
                                                                                                                         //   "eco" => $result7->eco_name,
                                                                                                                            "pns_type" => $result7->pns_type,
                                                                                                                            "pns_des" => $result7->pns_description,
//                                                                                                                            "pns_status" => $result7->pns_status,
                                                                                                                            "find_number" => $result7->find_number, 
                                                                                                                            "ref_des" => $result7->ref_des,
                                                                                                                            "stock" => $result7->stock,                                                                                                                                            
                                                                                                                            "pns_uom" => $result7->pns_uom,
                                                                                                                            "v_mf" => $manufacture[0]['v_mf'],
                                                                                                                            "mf" => $manufacture[0]['mf'],
                                                                                                                        //    "pns_life_cycle" => $result7->pns_life_cycle,
                                                                                                                            "tool_pn" => GetToolPnValue($result7->pns_id),
                                                                                                                            "pns_date" => JHTML::_('date', $result7->pns_create, '%m/%d/%Y')
                                                                                                                        );
                                                                                                                        //check for level 9
                                                                                                                        $list_pns_c8 = $this->DisplayPnsAllChildId($result7->pns_id);
                                                                                                                        if (count($list_pns_c8) > 0) {
                                                                                                                                foreach ($list_pns_c8 as $result8) { 
                                                                                                                                        if ($result8->pns_revision) {
                                                                                                                                                $pns_code8 = $result8->ccs_code . '-' . $result8->pns_code . '-' . $result8->pns_revision;
                                                                                                                                        } else {
                                                                                                                                                $pns_code8 = $result8->ccs_code . '-' . $result8->pns_code;
                                                                                                                                        }
                                                                                                                                        $manufacture = PNsController::GetManufacture($result8->pns_id);
                                                                                                                                        $listPNs[] = array(
                                                                                                                                            "pns_code" => $pns_code8,
                                                                                                                                            "pns_level" => 9,
                                                                                                                                        //    "eco" => $result8->eco_name,
                                                                                                                                            "pns_type" => $result8->pns_type,
                                                                                                                                            "pns_des" => $result8->pns_description,
//                                                                                                                                            "pns_status" => $result8->pns_status,
                                                                                                                                            "find_number" => $result8->find_number, 
                                                                                                                                            "ref_des" => $result8->ref_des,
                                                                                                                                            "stock" => $result8->stock,          
                                                                                                                                            "pns_uom" => $result8->pns_uom,
                                                                                                                                            "v_mf" => $manufacture[0]['v_mf'],
                                                                                                                                                "mf" => $manufacture[0]['mf'],
                                                                                                                                       //     "pns_life_cycle" => $result8->pns_life_cycle,
                                                                                                                                            "tool_pn" => GetToolPnValue($result8->pns_id),
                                                                                                                                            "pns_date" => JHTML::_('date', $result8->pns_create, '%m/%d/%Y')
                                                                                                                                        );
                                                                                                                                        //check for level 10;
                                                                                                                                        $list_pns_c9 = $this->DisplayPnsAllChildId($result8->pns_id);
                                                                                                                                        if (count($list_pns_c9) > 0) {
                                                                                                                                                foreach ($list_pns_c9 as $result9) { 
                                                                                                                                                        if ($result9->pns_revision) {
                                                                                                                                                                $pns_code9 = $result9->ccs_code . '-' . $result9->pns_code . '-' . $result9->pns_revision;
                                                                                                                                                        } else {
                                                                                                                                                                $pns_code9 = $result9->ccs_code . '-' . $result9->pns_code;
                                                                                                                                                        }
                                                                                                                                                        $manufacture = PNsController::GetManufacture($result9->pns_id);
                                                                                                                                                        $listPNs[] = array(
                                                                                                                                                            "pns_code" => $pns_code9,
                                                                                                                                                            "pns_level" => 10,
                                                                                                                                                       //     "eco" => $result9 > eco_name,
                                                                                                                                                            "pns_type" => $result9->pns_type,
                                                                                                                                                            "pns_des" => $result9->pns_description,
//                                                                                                                                                            "pns_status" => $result9->pns_status,
                                                                                                                                                            "find_number" => $result9->find_number,
                                                                                                                                                            "ref_des" => $result9->ref_des,
                                                                                                                                                            "stock" => $result9->stock,
                                                                                                                                                            "pns_uom" => $result9->pns_uom,
                                                                                                                                                            "v_mf" => $manufacture[0]['v_mf'],
                                                                                                                                                            "mf" => $manufacture[0]['mf'],
                                                                                                                                                       //     "pns_life_cycle" => $result9->pns_life_cycle,
                                                                                                                                                            "tool_pn" => GetToolPnValue($result9->pns_id),
                                                                                                                                                            "pns_date" => JHTML::_('date', $result9->pns_create, '%m/%d/%Y')
                                                                                                                                                        );
                                                                                                                                                }
                                                                                                                                        }
                                                                                                                                }
                                                                                                                        }
                                                                                                                }
                                                                                                        }
                                                                                                }
                                                                                        }
                                                                                }
                                                                        }
                                                                }
                                                        }
                                                }
                                        }
                                }
                        }
                }
                }                
                $user_name = $me->get('name');
                $date = JHTML::_('date', date("Y-m-d"), '%m/%d/%Y');
                //for Execl
                $styleThinBlackBorderOutline = array(
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ),
                );

                $objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);

                $objPHPExcel->getActiveSheet()->setCellValue('A5', 'Username: ' . $me->get('username'));
                $objPHPExcel->getActiveSheet()->setCellValue('F5', 'Date Created: ' . $date);               
                $nRecord = count($listPNs);
                
                $objPHPExcel->getActiveSheet()->getStyle('A7:F' . $nRecord)->getAlignment()->setWrapText(true);
                if ($nRecord > 0) {
                        $jj = 0;
                        $ii = 7;
                        $number = 1;
                        foreach ($listPNs as $pns) {
                                $a = 'A' . $ii;
                                $b = 'B' . $ii;
                                $c = 'C' . $ii;
                                $d = 'D' . $ii;
                                $e = 'E' . $ii;
                                $f = 'F' . $ii;
                                $g = 'G' . $ii;
                                $h = 'H' . $ii;//for pns_find_number
                                $i = 'I' . $ii;
                                $j = 'J' . $ii;
                                $k = 'K' . $ii;
                                $l = 'L' . $ii;
                                $m = 'M' . $ii;
                                //set heigh or row 
                                $objPHPExcel->getActiveSheet()->getRowDimension($ii)->setRowHeight(30);
                                $objPHPExcel->getActiveSheet()->setCellValue($a, $number);
                                $objPHPExcel->getActiveSheet()->setCellValue($b, $pns['pns_level']);
                                $objPHPExcel->getActiveSheet()->setCellValue($c, $pns['pns_code']);
                                $objPHPExcel->getActiveSheet()->setCellValue($d, $pns['pns_des']);//
                                $objPHPExcel->getActiveSheet()->setCellValue($e, $pns['find_number']);
                                $objPHPExcel->getActiveSheet()->setCellValue($f, $pns['stock']);
                                $objPHPExcel->getActiveSheet()->setCellValue($g, $pns['pns_uom']);//
                                $objPHPExcel->getActiveSheet()->setCellValue($h, $pns['v_mf']);
                                $objPHPExcel->getActiveSheet()->setCellValue($i, $pns['mf']);
                                $objPHPExcel->getActiveSheet()->setCellValue($j, $pns['tool_pn']);                                
                                $objPHPExcel->getActiveSheet()->setCellValue($k, $pns['pns_type']);
                                $objPHPExcel->getActiveSheet()->setCellValue($l, $pns['ref_des']);
                                $objPHPExcel->getActiveSheet()->setCellValue($m, $pns['pns_date']);

                                //set format
                                $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($c)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($d)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($e)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($f)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);
                                $objPHPExcel->getActiveSheet()->getStyle($g)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($h)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($k)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($l)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($m)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


                                $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($c)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($d)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($e)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
                                $objPHPExcel->getActiveSheet()->getStyle($g)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($l)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($m)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



                                $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($c)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($d)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($e)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($f)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($g)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($h)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($j)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($k)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($l)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($m)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                                $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                if ($jj % 2 == 0) {
                                       $objPHPExcel->getActiveSheet()->getStyle($a . ':' . $h)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                                        $objPHPExcel->getActiveSheet()->getStyle($a . ':' . $h)->getFill()->getStartColor()->setRGB('EEEEEE');
                                }
                                if ($jj == $nRecord - 1) {
                                        $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($c)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($d)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($e)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($f)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($g)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($h)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($j)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($k)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($l)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($m)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                }
                                $ii++;
                                $jj++;
                                $number++;
                        }
                }
//                $path_export = JPATH_SITE . DS . 'uploads' . DS . 'export' . DS;
//                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//                $objWriter->save($path_export . 'APDM_BOM_REPORT.xls');
//                $dFile = new DownloadFile($path_export, 'APDM_BOM_REPORT.xls');
                //tmp
                if ($row1->pns_revision) {
                        $name = $row1->ccs_code . '-' . $row1->pns_code . '-' . $row1->pns_revision;
                } else {
                        $name = $row1->ccs_code . '-' . $row1->pns_code;
                }                                                 
                $path_export = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'cads' . DS . $row1->ccs_code . DS . $name . DS;
                
                if (!@is_dir($path_export)) {
                        $res = @mkdir($path_export, 0777);
                        if (!$res)
                                $txtout = "Cannot create dir !<br>";
                } else
                {
                        @chmod($path_export, 0777);
                }                
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                if (file_exists($path_export . $name .'_APDM_BOM_REPORT.xls')) {
                        @unlink($path_export . $name .'_APDM_BOM_REPORT.xls');
                }
                $objWriter->save($path_export . $name .'_APDM_BOM_REPORT.xls');
                //  $dFile = new DownloadFile($path_export, $name.'_APDM_BOM_REPORT.xls');                
                //     exit;
        }

        function export_whereused() {

                include_once(JPATH_BASE . DS . 'includes' . DS . 'PHPExcel.php');
                require_once (JPATH_BASE . DS . 'includes' . DS . 'PHPExcel' . DS . 'RichText.php');
                require_once(JPATH_BASE . DS . 'includes' . DS . 'PHPExcel' . DS . 'IOFactory.php');
                require_once('includes/download.class.php');
                ini_set("memory_limit", "512M");
                ini_set("error_reporting", "E_ALL");
                @set_time_limit(1000000);
                $objPHPExcel = new PHPExcel();
                $objReader = PHPExcel_IOFactory::createReader('Excel5'); //Excel5
                $objPHPExcel = $objReader->load(JPATH_COMPONENT . DS . 'apdm_pn_whereused_report.xls');
                global $mainframe;
                $me = & JFactory::getUser();
                $pns_id = JRequest::getVar('pns_id');
                $username = $me->get('username');
                $db = & JFactory::getDBO();
                $query = 'SELECT * FROM apdm_pns WHERE pns_id=' . $pns_id;

                $db->setQuery($query);
                $row = $db->loadObject();
                $list_rev = $this->DisplayAllRevValue($row->pns_id); 
               
               $rev = array();
              
                foreach($list_rev as $rev)
                {                                
                        $arr_rev[]= $rev->pns_revision;                       
                }
                $listPNs = array();
                $listPNs[] = array(
                    "pns_code" => $row->ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision,
                    "pns_level" => 0,
                    "eco" => GetEcoValue($row->eco_id),
                    "pns_des" => $row->pns_description,
                    "pns_rev" => implode("<>",$arr_rev),
                    "pns_current_rev" => $row->pns_revision,
                    //"pns_status" => $row->pns_status,
                    "pns_state" => $row->pns_life_cycle,
                    "pns_type" => $row->pns_type,
                    "pns_date" => JHTML::_('date', $row->pns_create, '%m/%d/%Y')
                );
                
                //get list child
                //$query = "SELECT pr.*, p.ccs_code FROM apdm_pns_parents as pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_id=".$pns_id." ORDER BY p.ccs_code ";       
           
                $query = "SELECT p.*, CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS pns_code_full  FROM apdm_pns AS p  WHERE p.pns_id=" . $pns_id . " ORDER BY p.ccs_code";
                $db->setQuery($query);
                $rows = $db->loadObjectList();
                //$db->setQuery('SELECT p.*,pr.pns_id,CONCAT_WS( "-", p.ccs_code, p.pns_code, p.pns_revision ) AS text, e.eco_name, p.    pns_description, p.pns_type, p.pns_status FROM apdm_pns AS p LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_parent LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND pr.pns_id in ('.$pns_id.')');
                //for level 2            
                $query1 = "SELECT p.*,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p   LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_parent LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code  LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id  WHERE  c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND pr.pns_id in (" . $pns_id . ")";
                $db->setQuery($query1);
                $result1 = $db->loadObjectList();
                if (isset($result1) && sizeof($result1) > 0) {
                        foreach ($result1 as $obj1) {
                                $list_rev = $this->DisplayAllRevValue($obj1->pns_id); 
                                foreach($list_rev as $rev)
                                {
                                        $arr_rev1[]= $rev->pns_revision;
                                }
                                $listPNs[] = array(
                                    "pns_code" => $obj1->full_pns_code,
                                    "pns_level" => "-1",
                                    "eco" => $obj1->eco_name,
                                    "pns_des" => $obj1->pns_description,
                                    "pns_rev" => implode("<>",$arr_rev1),
                                    "pns_current_rev" => $obj1->pns_revision,
                                   // "pns_status" => $obj1->pns_status,
                                    "pns_state" => $obj1->pns_life_cycle,
                                    "pns_type" => $obj1->pns_type,
                                    "pns_date" => JHTML::_('date', $obj1->pns_create, '%m/%d/%Y')
                                );
                                ///check for child of level 3
                                $query2 = "SELECT p.*,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p   LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_parent LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code  LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id  WHERE  c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND pr.pns_id in (" . $obj1->pns_id . ")";
                                $db->setQuery($query2);
                                $result2 = $db->LoadObjectList();
                                if (isset($result2) && sizeof($result2) > 0) {
                                        foreach ($result2 as $obj2) {
                                                $list_rev = $this->DisplayAllRevValue($obj2->pns_id); 
                                                foreach($list_rev as $rev)
                                                {
                                                        $arr_rev2[]= $rev->pns_revision;
                                                }
                                                $listPNs[] = array(
                                                    "pns_code" => $obj2->full_pns_code,
                                                    "pns_level" => "-2",
                                                    "eco" => $obj2->eco_name,                                                    
                                                    "pns_des" => $obj2->pns_description,
                                                    "pns_rev" => implode("<>",$arr_rev2),
                                                    "pns_current_rev" => $obj2->pns_revision,
                                                  //  "pns_status" => $obj2->pns_status,
                                                    "pns_state" => $obj2->pns_life_cycle,
                                                    "pns_type" => $obj2->pns_type,
                                                    "pns_date" => JHTML::_('date', $obj2->pns_create, '%m/%d/%Y')
                                                );
                                                //check for level 4
                                                $query3 = "SELECT p.*,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p   LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_parent LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code  LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id  WHERE  c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND pr.pns_id in (" . $obj2->pns_id . ")";
                                                $db->setQuery($query3);
                                                $result3 = $db->LoadObjectList();
                                                if (isset($result3) && sizeof($result3) > 0) {
                                                        foreach ($result3 as $obj3) {
                                                                $list_rev = $this->DisplayAllRevValue($obj3->pns_id); 
                                                                foreach($list_rev as $rev)
                                                                {
                                                                        $arr_rev3[]= $rev->pns_revision;
                                                                }                                                                
                                                                $listPNs[] = array(
                                                                    "pns_code" => $obj3->full_pns_code,
                                                                    "pns_level" => "-3",
                                                                    "eco" => $obj3->eco_name,                                                                    
                                                                    "pns_des" => $obj3->pns_description,
                                                                    "pns_rev" => implode("<>",$arr_rev3),
                                                                    "pns_current_rev" => $obj3->pns_revision,
                                                                  //  "pns_status" => $obj3->pns_status,
                                                                    "pns_state" => $obj3->pns_life_cycle,
                                                                    "pns_type" => $obj3->pns_type,
                                                                    "pns_date" => JHTML::_('date', $obj3->pns_create, '%m/%d/%Y')
                                                                );
                                                                //check for level 5
                                                                $query4 = "SELECT p.*,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p   LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_parent LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code  LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id  WHERE  c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND pr.pns_id in (" . $obj3->pns_id . ")";
                                                                $db->setQuery($query4);
                                                                $result4 = $db->LoadObjectList();
                                                                if (isset($result4) && sizeof($result4) > 0) {
                                                                        foreach ($result4 as $obj4) {
                                                                                $list_rev = $this->DisplayAllRevValue($obj4->pns_id); 
                                                                                foreach($list_rev as $rev)
                                                                                {
                                                                                        $arr_rev4[]= $rev->pns_revision;
                                                                                } 
                                                                                $listPNs[] = array(
                                                                                    "pns_code" => $obj4->full_pns_code,
                                                                                    "pns_level" => "-4",
                                                                                    "eco" => $obj4->eco_name,                                                                                    
                                                                                    "pns_des" => $obj4->pns_description,
                                                                                    "pns_rev" => implode("<>",$arr_rev4),
                                                                                    "pns_current_rev" => $obj4->pns_revision,
                                                                                 //   "pns_status" => $obj4->pns_status,
                                                                                    "pns_state" => $obj4->pns_life_cycle,
                                                                                    "pns_type" => $obj4->pns_type,
                                                                                    "pns_date" => JHTML::_('date', $obj4->pns_create, '%m/%d/%Y')
                                                                                );
                                                                                //check for level 6
                                                                                $query5 = "SELECT p.*,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p   LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_parent LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code  LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id  WHERE  c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND pr.pns_id in (" . $obj4->pns_id . ")";
                                                                                $db->setQuery($query5);
                                                                                $result5 = $db->LoadObjectList();
                                                                                if (isset($result5) && sizeof($result5) > 0) {
                                                                                        foreach ($result5 as $obj5) {
                                                                                                $list_rev = $this->DisplayAllRevValue($obj5->pns_id); 
                                                                                                foreach($list_rev as $rev)
                                                                                                {
                                                                                                        $arr_rev5[]= $rev->pns_revision;
                                                                                                }                                                                                                
                                                                                                $listPNs[] = array(
                                                                                                    "pns_code" => $obj5->full_pns_code,
                                                                                                    "pns_level" => "-5",
                                                                                                    "eco" => $obj5->eco_name,                                                                                                    
                                                                                                    "pns_des" => $obj5->pns_description,
                                                                                                    "pns_rev" => implode("<>",$arr_rev5),
                                                                                                    "pns_current_rev" => $obj5->pns_revision,
                                                                                                  //  "pns_status" => $obj5->pns_status,
                                                                                                    "pns_state" => $obj5->pns_life_cycle,
                                                                                                    "pns_type" => $obj5->pns_type,
                                                                                                    "pns_date" => JHTML::_('date', $obj5->pns_create, '%m/%d/%Y')
                                                                                                );
                                                                                                //check for level 7
                                                                                                $query6 = "SELECT p.*,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p   LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_parent LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code  LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id  WHERE  c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND pr.pns_id in (" . $obj5->pns_id . ")";
                                                                                                $db->setQuery($query6);
                                                                                                $result6 = $db->LoadObjectList();
                                                                                                if (isset($result6) && sizeof($result6) > 0) {
                                                                                                        foreach ($result6 as $obj6) {
                                                                                                                $list_rev = $this->DisplayAllRevValue($obj6->pns_id); 
                                                                                                                foreach($list_rev as $rev)
                                                                                                                {
                                                                                                                        $arr_rev6[]= $rev->pns_revision;
                                                                                                                }   
                                                                                                                $listPNs[] = array(
                                                                                                                    "pns_code" => $obj6->full_pns_code,
                                                                                                                    "pns_level" => "-6",
                                                                                                                    "eco" => GetEcoValue($obj6->eco_id),                                                                                                                    
                                                                                                                    "pns_des" => $obj6->pns_description,
                                                                                                                    "pns_rev" => implode("<>",$arr_rev6),
                                                                                                                    "pns_current_rev" => $obj6->pns_revision,
                                                                                                                 //   "pns_status" => $obj6->pns_status,
                                                                                                                    "pns_state" => $obj6->pns_life_cycle,
                                                                                                                    "pns_type" => $obj6->pns_type,
                                                                                                                    "pns_date" => JHTML::_('date', $obj6->pns_create, '%m/%d/%Y')
                                                                                                                );
                                                                                                                // check for level 8
                                                                                                                $query7 = "SELECT p.*,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p   LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_parent LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code  LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id  WHERE  c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND pr.pns_id in (" . $obj6->pns_id . ")";
                                                                                                                $db->setQuery($query7);
                                                                                                                $result7 = $db->LoadObjectList();
                                                                                                                if (isset($result7) && sizeof($result7) > 0) {
                                                                                                                        foreach ($result7 as $obj7) {
                                                                                                                                $list_rev = $this->DisplayAllRevValue($obj7->pns_id); 
                                                                                                                                foreach($list_rev as $rev)
                                                                                                                                {
                                                                                                                                        $arr_rev7[]= $rev->pns_revision;
                                                                                                                                } 
                                                                                                                                $listPNs[] = array(
                                                                                                                                    "pns_code" => $obj7->full_pns_code,
                                                                                                                                    "pns_level" => "-7",
                                                                                                                                    "eco" => $obj7->eco_name,                                                                                                                                    
                                                                                                                                    "pns_des" => $obj7->pns_description,
                                                                                                                                    "pns_rev" => implode("<>",$arr_rev7),
                                                                                                                                    "pns_current_rev" => $obj7->pns_revision,
                                                                                                                                  //  "pns_status" => $obj7->pns_status,
                                                                                                                                    "pns_state" => $obj7->pns_life_cycle,
                                                                                                                                    "pns_type" => $obj7->pns_type,
                                                                                                                                    "pns_date" => JHTML::_('date', $obj7->pns_create, '%m/%d/%Y')
                                                                                                                                );
                                                                                                                                //check for level 9
                                                                                                                                $query8 = "SELECT p.*,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p   LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_parent LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code  LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id  WHERE  c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND pr.pns_id in (" . $obj7->pns_id . ")";
                                                                                                                                $db->setQuery($query8);
                                                                                                                                $result8 = $db->LoadObjectList();
                                                                                                                                if (isset($result8) && sizeof($result8) > 0) {
                                                                                                                                        foreach ($result8 as $obj8) {
                                                                                                                                                $list_rev = $this->DisplayAllRevValue($obj8->pns_id); 
                                                                                                                                                foreach($list_rev as $rev)
                                                                                                                                                {
                                                                                                                                                        $arr_rev8[]= $rev->pns_revision;
                                                                                                                                                } 
                                                                                                                                                $listPNs[] = array(
                                                                                                                                                    "pns_code" => $obj8->full_pns_code,
                                                                                                                                                    "pns_level" => "-8",
                                                                                                                                                    "eco" => $obj8->eco_name,                                                                                                                                                    
                                                                                                                                                    "pns_des" => $obj8->pns_description,
                                                                                                                                                    "pns_rev" => implode("<>",$arr_rev8),
                                                                                                                                                    "pns_current_rev" => $obj8->pns_revision,
                                                                                                                                                  //  "pns_status" => $obj8->pns_status,
                                                                                                                                                    "pns_state" => $obj8->pns_life_cycle,
                                                                                                                                                    "pns_type" => $obj8->pns_type,
                                                                                                                                                    "pns_date" => JHTML::_('date', $obj8->pns_create, '%m/%d/%Y')
                                                                                                                                                );
                                                                                                                                                //check for level 10;
                                                                                                                                                $query9 = "SELECT p.*,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS full_pns_code, e.eco_name, p.pns_type, p.pns_status, p.pns_description, p.pns_create  FROM apdm_pns AS p   LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_parent LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code  LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id  WHERE  c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND pr.pns_id in (" . $obj8->pns_id . ")";
                                                                                                                                                $db->setQuery($query9);
                                                                                                                                                $result9 = $db->LoadObjectList();
                                                                                                                                                if (isset($result9) && sizeof($result9) > 0) {
                                                                                                                                                        foreach ($result9 as $obj9) {
                                                                                                                                                                $list_rev = $this->DisplayAllRevValue($obj9->pns_id); 
                                                                                                                                                                foreach($list_rev as $rev)
                                                                                                                                                                {
                                                                                                                                                                        $arr_rev9[]= $rev->pns_revision;
                                                                                                                                                                } 
                                                                                                                                                                $listPNs[] = array(
                                                                                                                                                                    "pns_code" => $obj9->full_pns_code,
                                                                                                                                                                    "pns_level" => "-9",
                                                                                                                                                                    "eco" => $obj9 > eco_name,                                                                                                                                                                    
                                                                                                                                                                    "pns_des" => $obj9->pns_description,
                                                                                                                                                                    "pns_rev" => implode("<>",$arr_rev9),
                                                                                                                                                                    "pns_current_rev" => $obj9->pns_revision,
                                                                                                                                                                 //   "pns_status" => $obj9->pns_status,
                                                                                                                                                                    "pns_state" => $obj9->pns_life_cycle,
                                                                                                                                                                    "pns_type" => $obj9->pns_type,
                                                                                                                                                                    "pns_date" => JHTML::_('date', $obj9->pns_create, '%m/%d/%Y')
                                                                                                                                                                );
                                                                                                                                                        }
                                                                                                                                                }//check for level 10;
                                                                                                                                        }
                                                                                                                                }//check for level 9;
                                                                                                                        }
                                                                                                                }//check for level 8;
                                                                                                        }
                                                                                                }//check for level 7;
                                                                                        }
                                                                                }//check for level 6;
                                                                        }
                                                                }//check for level 5;
                                                        }
                                                }//check for level 4;
                                        }
                                }//check for level 3;        
                        }
                }
                $user_name = $me->get('name');
                $date = JHTML::_('date', date("Y-m-d"), '%m/%d/%Y');
                //for Execl
                $styleThinBlackBorderOutline = array(
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ),
                );
                $objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);

                $objPHPExcel->getActiveSheet()->setCellValue('A5', 'Username: ' . $me->get('username'));
                $objPHPExcel->getActiveSheet()->setCellValue('F5', 'Date Created: ' . $date);
               
                $nRecord = count($listPNs);
                
                $objPHPExcel->getActiveSheet()->getStyle('A7:F' . $nRecord)->getAlignment()->setWrapText(true);
                if ($nRecord > 0) {
                        $jj = 0;
                        $ii = 7;
                        $number = 1;
                      
                        foreach ($listPNs as $pns) {
                                
                                $a = 'A' . $ii;
                                $b = 'B' . $ii;
                                $c = 'C' . $ii;
                                $d = 'D' . $ii;
                                $e = 'E' . $ii;
                                $f = 'F' . $ii;
                                $g = 'G' . $ii;
                                $h = 'H' . $ii;
                                $i = 'I' . $ii;
                                $j = 'J' . $ii;
                          //      $k = 'K' . $ii;
                                
                                
                                //set heigh or row 
                                $objPHPExcel->getActiveSheet()->getRowDimension($ii)->setRowHeight(30);
                                $objPHPExcel->getActiveSheet()->setCellValue($a, $number);
                                $objPHPExcel->getActiveSheet()->setCellValue($b, $pns['pns_code']);
                                $objPHPExcel->getActiveSheet()->setCellValue($c, $pns['pns_level']);
                                $objPHPExcel->getActiveSheet()->setCellValue($d, $pns['eco']);
                                $objPHPExcel->getActiveSheet()->setCellValue($e, $pns['pns_des']);
                                $objPHPExcel->getActiveSheet()->setCellValue($f, $pns['pns_rev']);
                                $objPHPExcel->getActiveSheet()->setCellValue($g, $pns['pns_current_rev']);
                                $objPHPExcel->getActiveSheet()->setCellValue($h, $pns['pns_state']);
                                $objPHPExcel->getActiveSheet()->setCellValue($i, $pns['pns_type']);
                                $objPHPExcel->getActiveSheet()->setCellValue($j, $pns['pns_date']);
                         //       $objPHPExcel->getActiveSheet()->setCellValue($k, $pns['pns_date']);
                                
                          
                                //set format
                                $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);                               
                                $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);                               
                                $objPHPExcel->getActiveSheet()->getStyle($c)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);                                
                                $objPHPExcel->getActiveSheet()->getStyle($d)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);                                
                                $objPHPExcel->getActiveSheet()->getStyle($e)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);                                
                                $objPHPExcel->getActiveSheet()->getStyle($f)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);                                
                                $objPHPExcel->getActiveSheet()->getStyle($g)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);                                
                                $objPHPExcel->getActiveSheet()->getStyle($h)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);                                
                                $objPHPExcel->getActiveSheet()->getStyle($i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);                                
                                $objPHPExcel->getActiveSheet()->getStyle($j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);                                
                            //    $objPHPExcel->getActiveSheet()->getStyle($k)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                
                                $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($c)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($d)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($e)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
                                $objPHPExcel->getActiveSheet()->getStyle($g)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            //    $objPHPExcel->getActiveSheet()->getStyle($k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                


                                $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($c)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($d)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($e)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($f)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($g)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($h)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($j)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                              //  $objPHPExcel->getActiveSheet()->getStyle($k)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                



                                $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                                if ($jj % 2 == 0) {                                                                                
                                        $objPHPExcel->getActiveSheet()->getStyle($a . ':' . $j)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                                        
                                        $objPHPExcel->getActiveSheet()->getStyle($a . ':' . $j)->getFill()->getStartColor()->setRGB('EEEEEE');                                        
                                }
                                if ($jj == $nRecord - 1) {
                                        
                                        $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($c)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($d)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($e)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($f)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($g)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($h)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($j)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                               //         $objPHPExcel->getActiveSheet()->getStyle($k)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                   
                                }
                                $ii++;
                                $jj++;
                                $number++;
                                
                                
                        }
                }
                $path_export = JPATH_SITE . DS . 'uploads' . DS . 'export' . DS;
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save($path_export . 'APDM_WHEREUSED_REPORT.xls');
                $dFile = new DownloadFile($path_export, 'APDM_WHEREUSED_REPORT.xls');
                exit;
        }

        /*
         * Export list PNs with format excel
         */

        function export() {
                include_once(JPATH_BASE . DS . 'includes' . DS . 'PHPExcel.php');
                require_once (JPATH_BASE . DS . 'includes' . DS . 'PHPExcel' . DS . 'RichText.php');
                require_once(JPATH_BASE . DS . 'includes' . DS . 'PHPExcel' . DS . 'IOFactory.php');
                require_once('includes/download.class.php');
                ini_set("memory_limit", "252M");
                @set_time_limit(1000000);
                $objPHPExcel = new PHPExcel();
                $objReader = PHPExcel_IOFactory::createReader('Excel5');
                $objPHPExcel = $objReader->load(JPATH_COMPONENT . DS . 'apdm_pn_report.xls');
                global $mainframe;
                $me = & JFactory::getUser();
                $username = $me->get('username');
                $date = JHTML::_('date', time(), JText::_('DATE_FORMAT_LC2'));
                $query_exprot = JRequest::getVar("query_exprot");
                $total = JRequest::getVar("total_record");
                $limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
                $limitstart = $mainframe->getUserStateFromRequest($option . '.limitstart', 'limitstart', 0, 'int');

                $db = & JFactory::getDBO();
                $query = base64_decode($query_exprot);
                jimport('joomla.html.pagination');
                $pagination = new JPagination($total, $limitstart, $limit);
                $db->setQuery($query, $pagination->limitstart, $pagination->limit);
                $rows = $db->loadObjectList();
                $user_name = $me->get('name');
                $date = JHTML::_('date', date("Y-m-d"), '%m/%d/%Y');
                //for Execl
                $styleThinBlackBorderOutline = array(
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ),
                );

                $objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('E5')->getFont()->setBold(true);

                $objPHPExcel->getActiveSheet()->setCellValue('A5', 'Username: ' . $me->get('username'));
                $objPHPExcel->getActiveSheet()->setCellValue('E5', 'Date Created: ' . date('d/m/Y'));
                $nRecord = count($rows);
                $objPHPExcel->getActiveSheet()->getStyle('A7:F' . $nRecord)->getAlignment()->setWrapText(true);
                if ($nRecord > 0) {
                        $j = 0;
                        $i = 7;
                        $number = 1;
                        foreach ($rows as $row) {
                                $a = 'A' . $i;
                                $b = 'B' . $i;
                                $c = 'C' . $i;
                                $d = 'D' . $i;
                                $e = 'E' . $i;
                                $f = 'F' . $i;
                                $g = 'G' . $i;
                                $pns_code = $row->ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                                //set heigh or row 
                                $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(30);
                                $objPHPExcel->getActiveSheet()->setCellValue($a, $number);
                                $objPHPExcel->getActiveSheet()->setCellValue($b, $pns_code);
                                $objPHPExcel->getActiveSheet()->setCellValue($c, GetECO($row->eco_id));
                                $objPHPExcel->getActiveSheet()->setCellValue($d, $row->pns_type);
                                $objPHPExcel->getActiveSheet()->setCellValue($e, $row->pns_description);
                                $objPHPExcel->getActiveSheet()->setCellValue($f, $row->pns_status);
                                $objPHPExcel->getActiveSheet()->setCellValue($g, JHTML::_('date', $row->pns_create, '%m/%d/%Y'));

                                //set format
                                $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($c)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($d)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($e)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);
                                $objPHPExcel->getActiveSheet()->getStyle($f)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($g)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


                                $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($c)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($d)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($e)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
                                $objPHPExcel->getActiveSheet()->getStyle($f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($g)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);




                                $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($c)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($d)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($e)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($f)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($g)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


                                $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                                if ($j % 2 == 0) {
                                        $objPHPExcel->getActiveSheet()->getStyle($a . ':' . $g)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                                        $objPHPExcel->getActiveSheet()->getStyle($a . ':' . $g)->getFill()->getStartColor()->setRGB('EEEEEE');
                                }
                                if ($j == $nRecord - 1) {
                                        $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($c)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($d)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($e)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($f)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($g)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                }
                                $i++;
                                $j++;
                                $number++;
                        }
                }
                $path_export = JPATH_SITE . DS . 'uploads' . DS . 'export' . DS;
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save($path_export . 'APDM_PN_REPORT.xls');
                $dFile = new DownloadFile($path_export, 'APDM_PN_REPORT.xls');
                exit;
        }

        /*
          Export PNs detail
         */

        function export_detail() {
                include_once(JPATH_BASE . DS . 'includes' . DS . 'PHPExcel.php');
                require_once (JPATH_BASE . DS . 'includes' . DS . 'PHPExcel' . DS . 'RichText.php');
                require_once(JPATH_BASE . DS . 'includes' . DS . 'PHPExcel' . DS . 'IOFactory.php');                
                require_once('includes/download.class.php');               
                ini_set("memory_limit", "252M");
                @set_time_limit(1000000);
                $objPHPExcel = new PHPExcel();
                $objReader = PHPExcel_IOFactory::createReader('Excel5');
                $objPHPExcel = $objReader->load(JPATH_COMPONENT . DS . 'apdm_pndesc_report.xls');
                global $mainframe;
                $me = & JFactory::getUser();
                $username = $me->get('username');
                $id = JRequest::getVar('pns_id');
                $db = & JFactory::getDBO();
                $query = 'SELECT * FROM apdm_pns WHERE pns_id=' . $id;
                $db->setQuery($query);
                $row = $db->loadObject();
                //Select list vendor
                $db->setQuery("SELECT p.*, v.info_name FROM apdm_pns_supplier as P LEFT JOIN apdm_supplier_info as v on v.info_id = p.supplier_id WHERE p.pns_id=" . $row->pns_id . " AND p.type_id=2 ");
                $list_vendor = $db->loadObjectList();
                //select list supperlier
                $db->setQuery("SELECT p.*, s.info_name FROM apdm_pns_supplier as P LEFT JOIN apdm_supplier_info as s on s.info_id = p.supplier_id WHERE p.pns_id=" . $row->pns_id . " AND p.type_id=3 ");
                $list_superlier = $db->loadObjectList();

                //select list manufacture
                $db->setQuery("SELECT p.*, m.info_name FROM apdm_pns_supplier as P LEFT JOIN apdm_supplier_info as m on m.info_id = p.supplier_id WHERE p.pns_id=" . $row->pns_id . " AND p.type_id=4 ");
                $list_manufacture = $db->loadObjectList();

                //select cads file
                $db->setQuery("SELECT * FROM apdm_pn_cad WHERE pns_id=" . $row->pns_id);
                $list_cads = $db->loadObjectList();
                //for Execl
                $styleThinBlackBorderOutline = array(
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ),
                );
                $objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('E5')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue('A5', 'Username: ' . $me->get('username'));
                $objPHPExcel->getActiveSheet()->setCellValue('E5', 'Date Created: ' . date('m/d/Y'));
                //detail
                $pns_code = $row->ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                $pns_name = $row->ccs_code . '_' . $row->pns_code . '_' . $row->pns_revision;
                $pns_modified = ($row->pns_modified_by) ? JHTML::_('date', $row->pns_modified, '%m-%d-%Y %H:%M:%S') : 'None';
                $pns_modified_by = ($row->pns_modified_by) ? GetValueUser($row->pns_modified_by, "username") : 'None';
                $pns_pdf = ($row->pns_pdf != '') ? $row->pns_pdf : 'None';
                $objPHPExcel->getActiveSheet()->setCellValue('B7', $pns_code);
            
                
                $objPHPExcel->getActiveSheet()->setCellValue('B8', GetEcoValue($row->eco_id));
                $objPHPExcel->getActiveSheet()->setCellValue('B9', $row->pns_status);
                $objPHPExcel->getActiveSheet()->setCellValue('B10', JHTML::_('date', $row->pns_create, '%m-%d-%Y %H:%M:%S'));
                $objPHPExcel->getActiveSheet()->setCellValue('B11', $row->pns_type);
                $objPHPExcel->getActiveSheet()->setCellValue('B12', GetValueUser($row->pns_create_by, "username"));
                $objPHPExcel->getActiveSheet()->setCellValue('B13', $pns_modified);
                $objPHPExcel->getActiveSheet()->setCellValue('B14', $pns_modified_by);
                $objPHPExcel->getActiveSheet()->setCellValue('B15', $row->pns_description);

                $objPHPExcel->getActiveSheet()->setCellValue('E19', $pns_pdf);
                //For Vendor
                $nVendor = count($list_vendor);
                $i_vendor = 18;
                if ($nVendor > 0) {

                        $objPHPExcel->getActiveSheet()->mergeCells('A' . $i_vendor . ':' . 'B' . $i_vendor);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $i_vendor)->getFont()->setBold(true);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $i_vendor)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
                        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i_vendor, 'Vendor:');
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $i_vendor)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
                        //for header list Vendor
                        $i_vendor++;
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $i_vendor)->getFont()->setBold(true);
                        $objPHPExcel->getActiveSheet()->getStyle('B' . $i_vendor)->getFont()->setBold(true);
                        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i_vendor, 'Vendor Name');
                        $objPHPExcel->getActiveSheet()->setCellValue('B' . $i_vendor, 'Vendor PNs');
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $i_vendor)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                        $objPHPExcel->getActiveSheet()->getStyle('B' . $i_vendor)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

                        $objPHPExcel->getActiveSheet()->getStyle('A' . $i_vendor)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('B' . $i_vendor)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $i_vendor . ':B' . $i_vendor)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $i_vendor . ':B' . $i_vendor)->getFill()->getStartColor()->setARGB('FF808080');

                        $j_vendor = 0;
                        foreach ($list_vendor as $vendor) {
                                $i_vendor++;
                                $a = 'A' . $i_vendor;
                                $b = 'B' . $i_vendor;
                                $objPHPExcel->getActiveSheet()->setCellValue($a, $vendor->info_name);
                                $objPHPExcel->getActiveSheet()->setCellValue($b, $vendor->supplier_info);

                                $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);
                                $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);

                                $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
                                $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);

                                $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                                $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                                if ($j_vendor % 2 == 0) {
                                        $objPHPExcel->getActiveSheet()->getStyle($a . ':' . $b)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                                        $objPHPExcel->getActiveSheet()->getStyle($a . ':' . $b)->getFill()->getStartColor()->setRGB('EEEEEE');
                                }
                                if ($j_vendor == $nVendor - 1) {
                                        $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                }
                                $j_vendor++;
                        }
                        $i_vendor++;
                }
                //For Supplier
                $i_super = $i_vendor;
                $nSuper = count($list_superlier);
                if ($nSuper > 0) {

                        $objPHPExcel->getActiveSheet()->mergeCells('A' . $i_super . ':' . 'B' . $i_super);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $i_super)->getFont()->setBold(true);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $i_super)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
                        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i_super, 'Supplier:');
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $i_super)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
                        //for header list Vendor
                        $i_super++;
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $i_super)->getFont()->setBold(true);
                        $objPHPExcel->getActiveSheet()->getStyle('B' . $i_super)->getFont()->setBold(true);
                        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i_super, 'Supplier Name');
                        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i_super, 'Supplier PNs');
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $i_super)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                        $objPHPExcel->getActiveSheet()->getStyle('B' . $i_super)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

                        $objPHPExcel->getActiveSheet()->getStyle('A' . $i_super . ':B' . $i_super)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $i_super . ':B' . $i_super)->getFill()->getStartColor()->setARGB('FF808080');

                        $objPHPExcel->getActiveSheet()->getStyle('A' . $i_super)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('B' . $i_super)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $j_super = 0;
                        foreach ($list_superlier as $super) {
                                $i_super++;
                                $a = 'A' . $i_super;
                                $b = 'B' . $i_super;
                                $objPHPExcel->getActiveSheet()->setCellValue($a, $super->info_name);
                                $objPHPExcel->getActiveSheet()->setCellValue($b, $super->supplier_info);

                                $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);
                                $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);

                                $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
                                $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);

                                $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                                $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                                if ($j_super % 2 == 0) {
                                        $objPHPExcel->getActiveSheet()->getStyle($a . ':' . $b)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                                        $objPHPExcel->getActiveSheet()->getStyle($a . ':' . $b)->getFill()->getStartColor()->setRGB('EEEEEE');
                                }
                                if ($j_super == $nSuper - 1) {
                                        $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                }
                                $j_super++;
                        }
                        $i_super++;
                }
                // For manuafacture
                $i_m = $i_super;
                $nMan = count($list_manufacture);
                if ($nMan > 0) {

                        $objPHPExcel->getActiveSheet()->mergeCells('A' . $i_m . ':' . 'B' . $i_m);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $i_m)->getFont()->setBold(true);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $i_m)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
                        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i_m, 'Manufacture:');
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $i_m)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
                        //for header list Vendor
                        $i_m++;
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $i_m)->getFont()->setBold(true);
                        $objPHPExcel->getActiveSheet()->getStyle('B' . $i_m)->getFont()->setBold(true);
                        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i_m, 'Manufacture Name');
                        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i_m, 'Manufacture PNs');
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $i_m)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                        $objPHPExcel->getActiveSheet()->getStyle('B' . $i_m)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

                        $objPHPExcel->getActiveSheet()->getStyle('A' . $i_m . ':B' . $i_m)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $i_m . ':B' . $i_m)->getFill()->getStartColor()->setARGB('FF808080');

                        $objPHPExcel->getActiveSheet()->getStyle('A' . $i_m)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('B' . $i_m)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $j_m = 0;
                        foreach ($list_manufacture as $man) {
                                $i_m++;
                                $a = 'A' . $i_m;
                                $b = 'B' . $i_m;
                                $objPHPExcel->getActiveSheet()->setCellValue($a, $super->info_name);
                                $objPHPExcel->getActiveSheet()->setCellValue($b, $super->supplier_info);

                                $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);
                                $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);

                                $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
                                $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);

                                $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                                $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                                if ($j_m % 2 == 0) {
                                        $objPHPExcel->getActiveSheet()->getStyle($a . ':' . $b)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                                        $objPHPExcel->getActiveSheet()->getStyle($a . ':' . $b)->getFill()->getStartColor()->setRGB('EEEEEE');
                                }
                                if ($j_m == $nMan - 1) {
                                        $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                }
                                $j_m++;
                        }
                        $i_m++;
                }
                // format fie image
                if ($row->pns_image != '') {
                        $pns_imge = '../uploads/pns/images/' . $row->pns_image;
                        $objDrawing = new PHPExcel_Worksheet_Drawing();
                        $objDrawing->setName('PNs image');
                        $objDrawing->setDescription('PNs imgae');
                        $objDrawing->setPath($pns_imge);
                        $objDrawing->setCoordinates('E7');
                        $objDrawing->setHeight(60);
                        $objDrawing->setWidth('200');
                        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
                }
                $nCdas = count($list_cads);
                if ($nCdas > 0) {
                        $i_file = 24;
                        $folder_pns = $row->ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                        $j_file = 0;
                        //Mercel
                        $objPHPExcel->getActiveSheet()->mergeCells('D22:F22');
                        $objPHPExcel->getActiveSheet()->getStyle('D22')->getFont()->setBold(true);
                        $objPHPExcel->getActiveSheet()->setCellValue('D22', 'List File CADs');
                        $objPHPExcel->getActiveSheet()->getStyle('D22')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('D22')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
                        //for head file
                        $objPHPExcel->getActiveSheet()->setCellValue('D23', 'No.');
                        $objPHPExcel->getActiveSheet()->setCellValue('E23', 'Name ');
                        $objPHPExcel->getActiveSheet()->setCellValue('F23', 'Size (KB) ');
                        $objPHPExcel->getActiveSheet()->getStyle('D23')->getFont()->setBold(true);
                        $objPHPExcel->getActiveSheet()->getStyle('E23')->getFont()->setBold(true);
                        $objPHPExcel->getActiveSheet()->getStyle('F23')->getFont()->setBold(true);
                        $objPHPExcel->getActiveSheet()->getStyle('D23:F23')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                        $objPHPExcel->getActiveSheet()->getStyle('D23:F23')->getFill()->getStartColor()->setARGB('FF808080');
                        $objPHPExcel->getActiveSheet()->getStyle('D23')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                        $objPHPExcel->getActiveSheet()->getStyle('E23')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                        $objPHPExcel->getActiveSheet()->getStyle('F23')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                        $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS;
//$fp = fopen ($path_pns."file.txt", "w"); 
                        foreach ($list_cads as $cad) {
                                $d = 'D' . $i_file;
                                $e = 'E' . $i_file;
                                $f = 'F' . $i_file;

                                $filesize = PNsController::Readfilesize('cads', $cad->cad_file, $row->ccs_code, $folder_pns);


                                //	fwrite($fp, $filesize.'  \r\n ');	


                                $objPHPExcel->getActiveSheet()->setCellValue($d, $j_file + 1);
                                $objPHPExcel->getActiveSheet()->setCellValue($e, $cad->cad_file);
                                $objPHPExcel->getActiveSheet()->setCellValue($f, $filesize);

                                $objPHPExcel->getActiveSheet()->getStyle($d)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);
                                $objPHPExcel->getActiveSheet()->getStyle($e)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);
                                $objPHPExcel->getActiveSheet()->getStyle($f)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);

                                $objPHPExcel->getActiveSheet()->getStyle($d)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
                                $objPHPExcel->getActiveSheet()->getStyle($e)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
                                $objPHPExcel->getActiveSheet()->getStyle($f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);

                                $objPHPExcel->getActiveSheet()->getStyle($d)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($e)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($f)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                                $objPHPExcel->getActiveSheet()->getStyle($d)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                                if ($j_file % 2 == 0) {
                                        $objPHPExcel->getActiveSheet()->getStyle($d . ':' . $f)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                                        $objPHPExcel->getActiveSheet()->getStyle($d . ':' . $f)->getFill()->getStartColor()->setRGB('EEEEEE');
                                }
                                if ($j_file == $nCdas - 1) {
                                        $objPHPExcel->getActiveSheet()->getStyle($d)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($e)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($f)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                }
                                $i_file++;
                                $j_file++;
                        }
                }
                //	fclose($fp);
                $path_export = JPATH_SITE . DS . 'uploads' . DS . 'export' . DS;
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $name_file = 'APDM_PNdesc_REPORT_' . $pns_name . '_' . date('d_m_Y');
                $objWriter->save($path_export . $name_file . '.xls');
                $dFile = new DownloadFile($path_export, $name_file . '.xls');
                exit;
        }

        function GetArrayPNsChild($pns) {
                $db = & JFactory::getDBO();
                // $query 	= "SELECT * FROM apdm_pns_parents WHERE pns_parent=".$pns.' ORDER BY ccs_code ';	
                $query = "SELECT pr.*, p.ccs_code FROM apdm_pns_parents as pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id  WHERE p.pns_deleted=0 AND pr.pns_parent = " . $pns . ' ORDER BY p.ccs_code';

                $db->setQuery($query);
                $rows = $db->loadObjectList();
                if (count($rows) > 0) {
                        foreach ($rows as $row) {
                                $arrChild[] = $row->pns_id;
                                $arrChild[] = PNsController::GetArrayPNsChild($row->pns_id);
                        }
                }
                return $arrChild;
        }

        function GetListPnsParent($pns) {
                $db = & JFactory::getDBO();
                $query = "SELECT pr.pns_id, p.ccs_code FROM apdm_pns_parents as pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id  WHERE p.pns_deleted=0 AND pr.pns_parent = " . $pns . ' ORDER BY p.ccs_code';

                $result = '';
                $db->setQuery($query);
                $rs = $db->loadObjectList();
                if (count($rs) > 0) {
                        foreach ($rs as $obj) {
                                $result .= $obj->pns_id . ', ';
                                $result .= PNsController::GetListPnsParent($obj->pns_id);
                        }
                }
                return $result;
        }

        function GetManufacture($pns_id,$type=4) {
                $db = & JFactory::getDBO();
                $rows = array();
                $query = "SELECT p.supplier_id, p.supplier_info, s.info_name FROM apdm_pns_supplier AS p LEFT JOIN apdm_supplier_info AS s ON s.info_id = p.supplier_id WHERE  s.info_deleted=0 AND  s.info_activate=1 AND p.type_id = ".$type." AND  p.pns_id =" . $pns_id;

                $db->setQuery($query);
                $result = $db->loadObjectList();
                if (count($result) > 0) {
                        foreach ($result as $obj) {
                                $rows[] = array('mf' => $obj->info_name, 'v_mf' => $obj->supplier_info);
                        }
                }
                return $rows;
        }

        function GetChildParentNumber($pns_id) {
                $db = & JFactory::getDBO();
                $result = 0;
                $query = " SELECT COUNT(pr.id) FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns AS p ON p.pns_id= pr.pns_id INNER JOIN apdm_ccs as c ON c.ccs_code = p.ccs_code WHERE p.pns_deleted = 0 AND c.ccs_deleted = 0 AND c.ccs_activate =1 AND pns_parent=" . $pns_id;
                $db->setQuery($query);
                $result = $db->loadResult();
                return $result;
        }

        function GetChildWhereNumber($pns_id) {
                $db = & JFactory::getDBO();
                $db->setQuery("SELECT pr.id, pr.pns_parent, CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns AS p on pr.pns_parent = p.pns_id LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code  WHERE c.ccs_activate=1 AND c.ccs_deleted = 0 AND p.pns_deleted =0 AND pr.pns_id=" . $pns_id);
                $list_where_use = $db->loadObjectList();
                $arr_where_use = array();
                if (count($list_where_use) > 0) {
                        foreach ($list_where_use as $w) {
                                $arr_where_use[] = array("id" => $w->pns_parent, "pns_code" => $w->parent_pns_code);
                        }
                }
                return $arr_where_use;
        }

        function size_format($bytes="") {
                $retval = "";
                if ($bytes >= 1048576) {
                        $retval = round($bytes / 1048576 * 100) / 100 . " MB";
                } else if ($bytes >= 1024) {
                        $retval = round($bytes / 1024 * 100) / 100 . " KB";
                } else {
                        $retval = $bytes . " bytes";
                }
                return $retval;
        }

        function GetInForValue($field, $table, $key, $keyvalue) {

                $db = & JFactory::getDBO();
                $query = "SELECT {$field} FROM {$table} WHERE {$key}=" . $keyvalue;
                $db->setQuery($query);
                $result = $db->loadResult();
                return $result;
        }

        function GetValuePns($field, $pns_id) {

                $db = & JFactory::getDBO();
                $query = "SELECT $field FROM apdm_pns WHERE pns_id=" . $pns_id;
                $db->setQuery($query);
                $result = $db->loadResult();
                return $result;
        }

        function GetEcoNumber($pns_id) {
                $db = & JFactory::getDBO();
                $db->setQuery("SELECT e.eco_name FROM apdm_eco AS e LEFT JOIN apdm_pns AS p ON p.eco_id = e.eco_id WHERE pns_id=" . $pns_id);
                $result = $db->loadResult();
                return $result;
        }

        function getcurrentdir($path=".") {
                global $conf;
                $dirarr = array();
                if ($dir = opendir($path)) {
                        while (false !== ($entry = @readdir($dir))) {
                                if (($entry != ".") && ($entry != "..")) {
                                        $lastdot = strrpos($entry, ".");
                                        $ext = chop(strtolower(substr($entry, $lastdot + 1)));
                                        $fname = substr($entry, 0, $lastdot);
                                        if ($path != ".")
                                                $newpath = $path . "/" . $entry;
                                        else
                                                $newpath = $entry;
                                        $newpath = str_replace("//", "/", $newpath);

                                        if (($entry != "NDKziper.php") && ($entry != "ndkziper.txt") && ($entry != $conf['dir'])) {
                                                $dirarr[] = $newpath;
                                        }
                                }
                        }
                }
                return $dirarr;
        }

        // end func

        function get_list_pns_eco() {
                JRequest::setVar('layout', 'default');
                JRequest::setVar('view', 'getpnsforeco');
                parent::display();
        }
        //for init
        function get_list_pns_eco_init() {
                JRequest::setVar('layout', 'default');
                JRequest::setVar('view', 'getpnsforinit');
                parent::display();
        }    
        //for po
        function get_list_pns_po() {
                JRequest::setVar('layout', 'default');
                JRequest::setVar('view', 'getpnsforpos');
                parent::display();
        }            
        //for sto
        function get_list_pns_sto() {
                JRequest::setVar('layout', 'default');
                JRequest::setVar('view', 'getpnsforstos');
                parent::display();
        }
        function get_list_pns_eto() {
                JRequest::setVar('layout', 'default');
                JRequest::setVar('view', 'getpnsforeto');
                parent::display();
        }                
        function get_list_pns_sto_movelocation() {
                JRequest::setVar('layout', 'default');
                JRequest::setVar('view', 'getpnsforstom');
                parent::display();
        }
        function ajax_add_pns() {
                $db = & JFactory::getDBO();
                $pns = JRequest::getVar('cid', array(), '', 'array');
                $cid = JRequest::getVar('eco', array(), '', 'array');
                $db->setQuery("update apdm_pns set eco_id = " . $cid[0] . " WHERE  pns_id IN (" . implode(",", $pns) . ")");            
                $db->query();
                //add eco into REV
                $db->setQuery("update apdm_pns_rev set eco_id = " . $cid[0] . " WHERE  pns_id IN (" . implode(",", $pns) . ")");            
                $db->query();
                
                //add to inital
                foreach($pns as $pn_id)
                {
                        
                        $db->setQuery('select count(*) from apdm_pns_initial where pns_id = ' . $pn_id.' AND eco_id = '.$cid[0].'');
                        $check_exist = $db->loadResult();
                        if ($check_exist==0) {
                          echo      $query = 'insert into apdm_pns_initial (pns_id,init_plant_status,init_make_buy,init_leadtime,eco_id) values ('.$pn_id.',"Unreleased","Unassign","3","'.$cid[0].'")';
                                $db->setQuery($query);
                                $db->query();
                        }                              
                }
                
        }
        function ajax_add_pns_init() {
                $db = & JFactory::getDBO();
                $pns = JRequest::getVar('cid', array(), '', 'array');
                $cid = JRequest::getVar('eco', array(), '', 'array');
               // $db->setQuery("update apdm_pns set eco_id = " . $cid[0] . " WHERE  pns_id IN (" . implode(",", $pns) . ")");
                //$db->query();
                foreach($pns as $id)
                {
                        //check status PNS first
                        $get_status = "select pns_life_cycle from apdm_pns where pns_id = '".$id."'";
                        $db->setQuery($get_status);
                        $status = $db->loadResult();                
                        if($status=="Released")
                        {
                                $db->setQuery('select count(*) from apdm_pns_initial where pns_id = ' . $id.' AND eco_id = '.$cid[0].'');
                                $check_exist = $db->loadResult();
                                if ($check_exist==0) {
                                        $query = 'insert into apdm_pns_initial (pns_id,init_plant_status,init_make_buy,init_leadtime,eco_id) values ('.$id.',"Unreleased","Unassign","3","'.$cid[0].'")';
                                        $db->setQuery($query);
                                        $db->query();
                                }      
                                
                        }
                         
                }
                return $msg = JText::_('Have deleted successfull.');
        }        

        function ajax_add_pns_pos() {
                $db = & JFactory::getDBO();
                $pns = JRequest::getVar('cid', array(), '', 'array');
                $po_id = JRequest::getVar('po_id');
                //$db->setQuery("update apdm_pns set po_id = " . $po_id . " WHERE  pns_id IN (" . implode(",", $pns) . ")");
                //$db->query();
                //innsert to FK table
                foreach($pns as $pn_id)
                {
                        $db->setQuery("INSERT INTO apdm_pns_po_fk (pns_id,po_id) VALUES ( '" . $pn_id . "'," . $po_id . ")");
                        $db->query();                         
                }                 
                return $msg = JText::_('Have add pns successfull.');
        }     
        function ajax_add_pns_stos() {
                $db = & JFactory::getDBO();
                $pns = JRequest::getVar('cid', array(), '', 'array');
                $sto_id = JRequest::getVar('sto_id');                  
                //innsert to FK table                
                foreach($pns as $pn_id)
                {
                        $location="";
                        $partstate="";
                        $db->setQuery("select sto_type from apdm_pns_sto where pns_sto_id ='".$sto_id."'");
                        $sto_type = $db->loadResult(); 
                        if($sto_type==2)
                        {
                                $db->setQuery("SELECT stofk.* from apdm_pns_sto_fk stofk inner join apdm_pns_sto sto on stofk.sto_id = sto.pns_sto_id WHERE stofk.pns_id= '".$pn_id."' and sto.sto_type = 1  AND stofk.sto_id != '".$sto_id."' order by stofk.id desc limit 1");
                                $row = $db->loadObject();        
                                $location = $row->location;
                                $partState = $row->partstate;                        
                        }
                        $db->setQuery("INSERT INTO apdm_pns_sto_fk (pns_id,sto_id,location,partstate) VALUES ( '" . $pn_id . "','" . $sto_id . "','" . $location . "','" . $partState . "')");
                        $db->query();                         
                }                 
                return $msg = JText::_('Have add pns successfull.');
        }               
        function ajax_add_pns_eto() {
                $db = & JFactory::getDBO();
                $fk_ids = JRequest::getVar('cid', array(), '', 'array');
                $sto_id = JRequest::getVar('sto_id');                  
                //innsert to FK table        
                $location ="";
                $partState="";
                foreach($fk_ids as $fk_id)
                {
                        $db->setQuery("SELECT stofk.* from apdm_pns_sto_fk stofk inner join apdm_pns_sto sto on stofk.sto_id = sto.pns_sto_id WHERE stofk.id= '".$fk_id."' and sto.sto_type = 1  order by stofk.id desc limit 1");
                        $row = $db->loadObject();        
                        $location = $row->location;
                        $partState = $row->partstate; 
                        $pns_id = $row->pns_id; 
                        $db->setQuery("INSERT INTO apdm_pns_sto_fk (pns_id,sto_id,location,partstate) VALUES ( '" . $pns_id . "','" . $sto_id . "','" . $location . "','" . $partState . "')");
                        $db->query();                         
                }                 
                return $msg = JText::_('Have add PN to ETO successfull.');
        }               
        function ajax_add_pns_stos_movelocation() {
                $db = & JFactory::getDBO();
                $pns = JRequest::getVar('cid', array(), '', 'array');
                $stoId = JRequest::getVar('sto_id');
                $partStateArr   = array('OH-G','OH-D','IT-G','IT-D','OO','Prototype');        
                //innsert to FK table      
                foreach($pns as $pn_id)
                {             
                        $get_status = "select count(id) from apdm_pns_sto_fk where pns_id = '".$pn_id."' and sto_id = '".$stoId."'";
                        $db->setQuery($get_status);
                        $status = $db->loadResult();  
                        if($status)
                        {
                              return $msg = JText::_('The PN already add into MTO');
                              die;
                        }
                        $query = "select partstate from apdm_pns_sto_fk where  pns_id = '".$pn_id."'  and partstate!= '' group by partstate";
                        $db->setQuery($query);
                        $resultPartstate = $db->loadObjectList();                          
                        if (count($resultPartstate) > 0) {
                                $array_loacation= array();
                                foreach ($resultPartstate as $partState) {
                                                
                                        //get total qty                
                                       $query = "select fk.pns_id,loc.location_code,fk.qty,fk.sto_id,fk.location ,sto.sto_type ".
                                                "from apdm_pns_sto_fk fk ".
                                                "inner join apdm_pns_location loc on fk.location=loc.pns_location_id ".
                                                "inner join apdm_pns_sto sto on fk.sto_id = sto.pns_sto_id ".
                                                "where fk.pns_id = ".$pn_id." and fk.partstate = '".$partState->partstate."' and sto.sto_type in (1,2)";
                                        
                                      $db->setQuery($query);
                                        $result = $db->loadObjectList();
                                        if (count($result) > 0) {
                                                $array_loacation=array();
                                                foreach ($result as $obj) {
                                                        if($obj->sto_type==1 )
                                                            $array_loacation[$obj->location] = $array_loacation[$obj->location] + $obj->qty;
                                                        else
                                                             $array_loacation[$obj->location] =$array_loacation[$obj->location] - $obj->qty;   

                                                }                                                                        

                                        }
                                        //get calculate move location
                                        $query = "select loc.location_code,fk.qty,fk.sto_id ,sto.sto_type,fk.location,fk.location_from ".
                                                "from apdm_pns_sto_fk fk ".
                                                "inner join apdm_pns_location loc on fk.location_from=loc.pns_location_id ".
                                                "inner join apdm_pns_sto sto on fk.sto_id = sto.pns_sto_id ".
                                                "where fk.pns_id = ".$pn_id." and fk.partstate = '".$partState->partstate."' and sto.sto_type in (3)";
                                        $db->setQuery($query);
                                        $result = $db->loadObjectList();
                                        if (count($result) > 0) {
                                                //$array_loacation=array();
                                                foreach ($result as $obj) {
                                                        $array_loacation[$obj->location_from] =$array_loacation[$obj->location_from] - $obj->qty;   
                                                }
                                        }
                                         //get calculate move location
                                       /* $query = "select loc.location_code,fk.qty,fk.sto_id ,sto.sto_type,fk.location,fk.location_from  ".
                                                "from apdm_pns_sto_fk fk ".
                                                "inner join apdm_pns_location loc on fk.location=loc.pns_location_id ".
                                                "inner join apdm_pns_sto sto on fk.sto_id = sto.pns_sto_id ".
                                                "where fk.pns_id = ".$pn_id." and fk.partstate = '".$partState->partstate."' and sto.sto_type in (3)";
                                        $db->setQuery($query);
                                        $result = $db->loadObjectList();
                                        if (count($result) > 0) {
                                                //$array_loacation=array();
                                                foreach ($result as $obj) {
                                                        $array_loacation[$obj->location] =$array_loacation[$obj->location] + $obj->qty;   
                                                }
                                        }       */                                 
                                        if(isset($array_loacation) && sizeof($array_loacation)>0)
                                        {
                                                foreach($array_loacation as $location=>$qty)
                                                {
                                                        if($qty)
                                                        {
                                                                $db->setQuery("INSERT INTO apdm_pns_sto_fk (pns_id,sto_id,qty_from,location_from,partstate) VALUES ( '" . $pn_id . "','" . $stoId . "','" . $qty . "','" . $location . "','" . $partState->partstate . "')");
                                                                $db->query();                         
                                                        }

                                                }
                                        }
                                        ///end calculate movelocation
                                }   
                        }
                }                                
                return $msg = JText::_('Have add pns successfull.');
        }                     
        function removepns() {
                $db = & JFactory::getDBO();
                $pns = JRequest::getVar('cid', array(), '', 'array');
                $cid = JRequest::getVar('eco', array(), '', 'array');
                foreach($pns as $pn_id)
                {
                        $get_status = "select pns_life_cycle from apdm_pns where pns_id = '".$pn_id."'";
                        $db->setQuery($get_status);
                        $status = $db->loadResult();                
                        //check if PN Released only remove at tab Ininital
                        if($status!="Released")
                        {        
                                $db->setQuery("update apdm_pns set eco_id = 0 WHERE  pns_id = ".$pn_id."");
                                $db->query();  
                        }
                        $db->setQuery("delete from apdm_pns_initial  WHERE  pns_id = ".$pn_id." and eco_id = ".$cid[0]);
                        $db->query();   

                }                                     
                $msg = JText::_('Have deleted successfull.');
                return $this->setRedirect('index.php?option=com_apdmeco&task=affected&cid[]=' . $cid[0], $msg);
        }
        /*
         * Remove PNS out of PO in PO management 
         */
        function removepnspos() {
                $db = & JFactory::getDBO();
                $pnsfk = JRequest::getVar('cid', array(), '', 'array');
                $po_id = JRequest::getVar('po_id');
//                $db->setQuery("update apdm_pns set po_id = 0 WHERE  pns_id IN (" . implode(",", $pns) . ")");
//                $db->query();    
                foreach($pnsfk as $fk_id)
                {
                        $db->setQuery("DELETE FROM apdm_pns_po_fk WHERE id = '" . $fk_id . "' AND po_id = " . $po_id . "");
                        $db->query();                    
                }
                $msg = JText::_('Have removed successfull.');
                return $this->setRedirect('index.php?option=com_apdmpns&task=po_detail&id=' . $po_id, $msg);
        }        
        /*
         * Remove PNS out of STO in STO management 
         */
        function removepnsstos() {
                $db = & JFactory::getDBO();
                $pnsfk = JRequest::getVar('cid', array(), '', 'array');                
                $sto_id = JRequest::getVar('sto_id');
//                $db->setQuery("update apdm_pns set po_id = 0 WHERE  pns_id IN (" . implode(",", $pns) . ")");
//                $db->query();    
                foreach($pnsfk as $fk_id)
                {
                        $db->setQuery("DELETE FROM apdm_pns_sto_fk WHERE id = '" . $fk_id . "' AND sto_id = " . $sto_id . "");
                        $db->query();                    
                }
                $msg = JText::_('Have removed successfull.');
                return $this->setRedirect('index.php?option=com_apdmpns&task=sto_detail&id=' . $sto_id, $msg);
        }   
         function removepnsstos_movelocation() {
                $db = & JFactory::getDBO();
                $pnsfk = JRequest::getVar('cid', array(), '', 'array');                
                $sto_id = JRequest::getVar('sto_id');   
                foreach($pnsfk as $fk_id)
                {
                        $db->setQuery("DELETE FROM apdm_pns_sto_fk WHERE id = '" . $fk_id . "' AND sto_id = " . $sto_id . "");
                        $db->query();                    
                }
                $msg = JText::_('Have removed successfull.');
                return $this->setRedirect('index.php?option=com_apdmpns&task=sto_detail_movelocation&id=' . $sto_id, $msg);
        }   
        /*
         * Remove PNS out of STO in STO management 
         */
        function removeAllpnsstos() {
                $db = & JFactory::getDBO();
                $pnsfk = JRequest::getVar('cid', array(), '', 'array');           
                $sto_id = JRequest::getVar('sto_id'); 
                foreach($pnsfk as $fk_ids){
                        $obj = explode("_", $fk_ids);
                        $pns=$obj[0];
                        $ids = explode(",",$obj[1]);
                        foreach ($ids as $fk_id)                 
                        {                                
                                $db->setQuery("DELETE FROM apdm_pns_sto_fk WHERE id = '" . $fk_id . "' AND sto_id = " . $sto_id . "");
                                $db->query();                    
                        }
                }
                $msg = JText::_('Have removed Part successfull.');
                return $this->setRedirect('index.php?option=com_apdmpns&task=sto_detail&id=' . $sto_id, $msg);
        }   
        /*
         * Remove PNS out of STO in STO management 
         */
        function removeAllpnsstoLocation() {
                $db = & JFactory::getDBO();
                $pnsfk = JRequest::getVar('cid', array(), '', 'array');           
                $sto_id = JRequest::getVar('sto_id'); 
                foreach($pnsfk as $fk_ids){
                        $obj = explode("_", $fk_ids);
                        $pns=$obj[0];
                        $ids = explode(",",$obj[1]);
                        foreach ($ids as $fk_id)                 
                        {                                
                                $db->setQuery("DELETE FROM apdm_pns_sto_fk WHERE id = '" . $fk_id . "' AND sto_id = " . $sto_id . "");
                                $db->query();                    
                        }
                }
                $msg = JText::_('Have removed Part successfull.');
                return $this->setRedirect('index.php?option=com_apdmpns&task=sto_detail_movelocation&id=' . $sto_id, $msg);
        }           
        
        /*
         * List PO asign to PNS
         */

        
        function po() {
                JRequest::setVar('layout', 'po');
                JRequest::setVar('view', 'pns_info');
                JRequest::setVar('edit', true);
                parent::display();
        }
        function po_detail() {
                JRequest::setVar('layout', 'po_detail_pns');
                JRequest::setVar('view', 'pos');
                parent::display();
        }        
        /*
         * List PO asign to PNS
         */

        function stomanagement() {            
                JRequest::setVar('layout', 'sto_list');
                JRequest::setVar('view', 'stos');
                parent::display();
        }        
        /*
         * List PO asign to PNS
         */

        function sto() {
                JRequest::setVar('layout', 'sto');
                JRequest::setVar('view', 'pns_info');
                parent::display();
        }        
        /*
         * List PO asign to PNS
         */

        function pomanagement() {            
                JRequest::setVar('layout', 'po_list');
                JRequest::setVar('view', 'pos');
                parent::display();
        }  
        /*
         * Detail Stock PNS
         */        
        function sto_detail() {
                JRequest::setVar('layout', 'sto_detail_pns');
                JRequest::setVar('view', 'stos');
                parent::display();
        }  
        /*
         * Asign template for get list child PNS  for BOM PNS
         */

        function get_pns_po() {
                JRequest::setVar('layout', 'default');
                JRequest::setVar('view', 'pos');
                parent::display();
        }
        function add_po() {
                JRequest::setVar('layout', 'add_po');
                JRequest::setVar('view', 'pos');
                parent::display();
        }   
        
        function edit_po() {
                JRequest::setVar('layout', 'edit_po');
                JRequest::setVar('view', 'pos');
                parent::display();
        }  
        /*
         * Edit stock include ITO/ETO
         */
        
        function edit_sto() {
                JRequest::setVar('layout', 'edit_sto');
                JRequest::setVar('view', 'stos');
                parent::display();
        }   
        /*
         * Add new ETO
         */        
        
        function add_stoe() {
                JRequest::setVar('layout', 'add_stoe');
                JRequest::setVar('view', 'stos');
                parent::display();
        }   
        /*
         * Add new ITO
         */             
        function add_stoi() {
                JRequest::setVar('layout', 'add_stoi');
                JRequest::setVar('view', 'stos');
                parent::display();
        }           
        
        /*
         * Asign template for get list child PNS  for BOM PNS
         */

        function get_pns_ponew() {
                JRequest::setVar('layout', 'posnew');
                JRequest::setVar('view', 'pos');
                parent::display();
        }        

        function save_pns_po() {
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $datenow = & JFactory::getDate();
                $pns_id = JRequest::getVar('pns_id');
                $po_code = JRequest::getVar('po_code');
                $qty = JRequest::getVar('qty');                
                $po_description = JRequest::getVar('po_description');
                $po_state = "Create"; //JRequest::getVar('po_state');
                $pns_created = $datenow->toMySQL();
                $pns_created_by = $me->get('id');
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS;
                //upload attached POs
                if ($_FILES['po_file']['size'] > 0) {
                        $attached = new upload($_FILES['po_file']);
                        $attached->file_new_name_body = $pns_id . "_" . str_replace("-", "_", $po_code);
                        if (file_exists($path_pns . 'images' . DS . $attached->file_new_name_body . "." . $attached->file_src_name_ext)) {

                                @unlink($path_pns . 'images' . DS . $attached->file_new_name_body . "." . $attached->file_src_name_ext);
                        }
                        if ($attached->uploaded) {
                                $attached->Process($path_pns . 'images' . DS);
                                if ($attached->processed) {
                                        $po_file = $attached->file_dst_name;
                                }
                        }
                }
                
                //$pns_life_cycle = JRequest::getVar('pns_life_cycle');
                $return = JRequest::getVar('return');
                $db->setQuery("INSERT INTO apdm_pns_po (po_code,qty,po_description,po_file,po_state,po_created,po_create_by) VALUES ( '" . $po_code . "','" . $qty . "', '" . $po_description . "', '" . $po_file . "', '" . $po_state . "', '" . $pns_created . "', '" . $pns_created_by . "')");
                $db->query();
                //get last ID PO
                $db->setQuery("select pns_po_id,po_code from apdm_pns_po where po_code='".$po_code."'");
                $db->query();  
                $rows = $db->loadObjectList(); 
                //innsert to FK table
                $db->setQuery("INSERT INTO apdm_pns_po_fk (pns_id,po_id) VALUES ( '" . $pns_id . "'," . $rows[0]->pns_po_id . ")");
                $db->query();                
                $msg = "Successfully Saved Pos";
                $this->setRedirect('index.php?option=com_apdmpns&task=po&cid[0]=' . $pns_id, $msg);
                exit;
        }
        function save_po() {
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $datenow = & JFactory::getDate();
                $po_code = JRequest::getVar('po_code');
                $po_code_prefix = JRequest::getVar('po_code_prefix');
                $po_description = JRequest::getVar('po_description');
                $po_state = "Create"; //JRequest::getVar('po_state');
                $pns_created = $datenow->toMySQL();
                $pns_created_by = $me->get('id');
                $qty = JRequest::getVar('qty');
                $po_code = $po_code.'-'.$po_code_prefix;
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS;
                //check exist first
                $db->setQuery("select count(*) from apdm_pns_po where po_code = '" . $po_code."'");
                $check_exist = $db->loadResult();
                if ($check_exist!=0) {    
                        $msg = "The PO already exist!";
                        $this->setRedirect('index.php?option=com_apdmpns&task=stomanagement', $msg);
                        return;
                }                       
                //upload attached POs
                if ($_FILES['po_file']['size'] > 0) {
                        $attached = new upload($_FILES['po_file']);
                        $attached->file_new_name_body =   str_replace("-", "_", $po_code);
                        if (file_exists($path_pns . 'images' . DS . $attached->file_new_name_body . "." . $attached->file_src_name_ext)) {

                                @unlink($path_pns . 'images' . DS . $attached->file_new_name_body . "." . $attached->file_src_name_ext);
                        }
                        if ($attached->uploaded) {
                                $attached->Process($path_pns . 'images' . DS);
                                if ($attached->processed) {
                                        $po_file = $attached->file_dst_name;
                                }
                        }
                }
                
                //$pns_life_cycle = JRequest::getVar('pns_life_cycle');
                $return = JRequest::getVar('return');
                $db->setQuery("INSERT INTO apdm_pns_po (po_code,qty,po_description,po_file,po_state,po_created,po_create_by) VALUES ('" . $po_code . "','" . $qty . "', '" . $po_description . "', '" . $po_file . "', '" . $po_state . "', '" . $pns_created . "', '" . $pns_created_by . "')");
                $db->query();
                $msg = "Successfully Saved Pos";
                return $this->setRedirect('index.php?option=com_apdmpns&task=pomanagement', $msg);
                exit;
        }        
        
        function save_editpo() {
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $datenow = & JFactory::getDate();
                $po_code = JRequest::getVar('po_code');
                $po_description = JRequest::getVar('po_description');
                $po_id = JRequest::getVar('po_id');
                $qty = JRequest::getVar('qty');
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS;
                //check exist first
                $db->setQuery("select count(*) from apdm_pns_po where po_code = '" . $po_code."' and pns_po_id != ".$po_id."");                
                $check_exist = $db->loadResult();
                if ($check_exist!=0) {    
                        $msg = "The PO already exist!";
                        $this->setRedirect('index.php?option=com_apdmpns&task=pomanagement', $msg);
                        return;
                }                    
                //upload attached POs
                $query = "update apdm_pns_po set po_code = '".$po_code."',qty = '".$qty."',po_description='".$po_description."' where pns_po_id=".$po_id."";
                if ($_FILES['po_file']['size'] > 0) {
                        $attached = new upload($_FILES['po_file']);
                        $attached->file_new_name_body = str_replace("-", "_", $po_code)."_".time();
                        if (file_exists($path_pns . 'images' . DS . $attached->file_new_name_body . "." . $attached->file_src_name_ext)) {

                                @unlink($path_pns . 'images' . DS . $attached->file_new_name_body . "." . $attached->file_src_name_ext);
                        }
                        if ($attached->uploaded) {
                                $attached->Process($path_pns . 'images' . DS);
                                if ($attached->processed) {
                                        $po_file = $attached->file_dst_name;
                                        $query = "update apdm_pns_po set po_code = '".$po_code."',qty = '".$qty."',po_description='".$po_description."',po_file='".$po_file."' where pns_po_id=".$po_id."";
                                }
                        }
                }                                                
                $return = JRequest::getVar('return');     
                $db->setQuery($query);
                $db->query();
                $msg = "Successfully Saved Posss";
                return $this->setRedirect('index.php?option=com_apdmpns&task=pomanagement', $msg);
                exit;
        }              
        function save_pns_posnew() {
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $datenow = & JFactory::getDate();
                $pns_id = JRequest::getVar('pns_id');
                $po_code = JRequest::getVar('po_code');
                $po_description = JRequest::getVar('po_description');
                $po_state = "Create"; //JRequest::getVar('po_state');
                $pns_created = $datenow->toMySQL();
                $pns_created_by = $me->get('id');
                $qty = JRequest::getVar('qty');
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS;
                //upload attached POs
                if ($_FILES['po_file']['size'] > 0) {
                        $attached = new upload($_FILES['po_file']);
                        $attached->file_new_name_body = $pns_id . "_" . str_replace("-", "_", $po_code);
                        if (file_exists($path_pns . 'images' . DS . $attached->file_new_name_body . "." . $attached->file_src_name_ext)) {

                                @unlink($path_pns . 'images' . DS . $attached->file_new_name_body . "." . $attached->file_src_name_ext);
                        }
                        if ($attached->uploaded) {
                                $attached->Process($path_pns . 'images' . DS);
                                if ($attached->processed) {
                                        $po_file = $attached->file_dst_name;
                                }
                        }
                }
                //$pns_life_cycle = JRequest::getVar('pns_life_cycle');
                $return = JRequest::getVar('return');
                $db->setQuery("INSERT INTO apdm_pns_po (po_code,po_description,po_file,po_state,po_created,po_create_by) VALUES ('" . $po_code . "', '" . $po_description . "', '" . $po_file . "', '" . $po_state . "', '" . $pns_created . "', '" . $pns_created_by . "')");
                $db->query();
                $db->setQuery("select pns_po_id,po_code from apdm_pns_po where po_code='".$po_code."'");
                $db->query();  
                $rows = $db->loadObjectList();
               echo $result = $rows[0]->pns_po_id.'^'.$rows[0]->po_code;
                exit;
        }
        function download_po() {
                $pns_id = JRequest::getVar('id');
                $row = & JTable::getInstance('apdmpnspo');
                $row->load($pns_id);
                $file_name = $row->po_file;
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'images' . DS;
                $dFile = new DownloadFile($path_pns, $file_name);
                exit;
        }

        function download_sto() {
                $db = & JFactory::getDBO();
                $id = JRequest::getVar('id');
                $db->setQuery("select sto_file from apdm_pns_sto where pns_sto_id ='".$id."'");
                $sto_file = $db->loadResult();               
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'images' . DS;
                $dFile = new DownloadFile($path_pns, $sto_file);
                exit;
        }        
        function remove_po() {
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $datenow = & JFactory::getDate();
                $pns_id = JRequest::getVar('pns_id');
                $po_id = JRequest::getVar('id');
                $db->setQuery("DELETE FROM apdm_pns_po_fk WHERE pns_id = '" . $pns_id . "' AND po_id = " . $po_id . "");
                $db->query();        
                $msg = "Successfully Delete Pos";
                $this->setRedirect('index.php?option=com_apdmpns&task=po&cid[0]=' . $pns_id, $msg);
        }
        /*
         * Edit STOCK ITO/ETO
         */
        function save_editsto() {
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $datenow = & JFactory::getDate();
                $sto_code = JRequest::getVar('sto_code');
                $sto_owner = JRequest::getVar('sto_owner');
                $sto_description = JRequest::getVar('sto_description');
                $sto_id = JRequest::getVar('sto_id');
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS;
                //check exist first
                $db->setQuery("select count(*) from apdm_pns_sto where sto_code = '" . $sto_code."' and pns_sto_id !=  ".$sto_id."");
                $check_exist = $db->loadResult();
                if ($check_exist!=0) {    
                        $msg = "The ITO/ETO already exist!";
                        $this->setRedirect('index.php?option=com_apdmpns&task=stomanagement', $msg);
                        return;
                }                   
                //upload attached POs
                $query = "update apdm_pns_sto set sto_code = '".$sto_code."',sto_description='".$sto_description."',sto_owner = '".$sto_owner."' where pns_sto_id=".$sto_id."";
                if ($_FILES['sto_file']['size'] > 0) {
                        $attached = new upload($_FILES['sto_file']);
                        $attached->file_new_name_body = str_replace("-", "_", $sto_code)."_".time();
                        if (file_exists($path_pns . 'images' . DS . $attached->file_new_name_body . "." . $attached->file_src_name_ext)) {

                                @unlink($path_pns . 'images' . DS . $attached->file_new_name_body . "." . $attached->file_src_name_ext);
                        }
                        if ($attached->uploaded) {
                                $attached->Process($path_pns . 'images' . DS);
                                if ($attached->processed) {
                                        $sto_file = $attached->file_dst_name;
                                        $query = "update apdm_pns_sto set sto_code = '".$sto_code."',sto_description='".$sto_description."',sto_file='".$sto_file."' where pns_sto_id=".$sto_id."";
                                }
                        }
                }                                           
                $return = JRequest::getVar('return');     
                $db->setQuery($query);
                $db->query();
                $msg = "Successfully Saved Stock";
                return $this->setRedirect('index.php?option=com_apdmpns&task=stomanagement', $msg);
                exit;
        }        
        /*
         * Save new stock ITO
         */
        function save_stoi() {
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $datenow = & JFactory::getDate();
                $sto_code = JRequest::getVar('sto_code');
                $sto_owner = JRequest::getVar('sto_owner');
                $sto_code_prefix = JRequest::getVar('sto_code_prefix');
                $sto_description = JRequest::getVar('sto_description');
                $sto_state = "Create"; //JRequest::getVar('sto_state');
                $pns_created = $datenow->toMySQL();
                $pns_created_by = $me->get('id');                
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS;
                $sto_code = $sto_code.'-'.$sto_code_prefix;
                //check exist first
                $db->setQuery("select count(*) from apdm_pns_sto where sto_code = '" . $sto_code."'");
                $check_exist = $db->loadResult();
                if ($check_exist!=0) {    
                        $msg = "The ITO already exist!";
                        $this->setRedirect('index.php?option=com_apdmpns&task=stomanagement', $msg);
                        return;
                }            
                //upload attached POs
                if ($_FILES['sto_file']['size'] > 0) {
                        $attached = new upload($_FILES['sto_file']);
                        $attached->file_new_name_body =  "_" . str_replace("-", "_", $sto_code);
                        if (file_exists($path_pns . 'images' . DS . $attached->file_new_name_body . "." . $attached->file_src_name_ext)) {

                                @unlink($path_pns . 'images' . DS . $attached->file_new_name_body . "." . $attached->file_src_name_ext);
                        }
                        if ($attached->uploaded) {
                                $attached->Process($path_pns . 'images' . DS);
                                if ($attached->processed) {
                                        $sto_file = $attached->file_dst_name;
                                }
                        }
                }
                //$pns_life_cycle = JRequest::getVar('pns_life_cycle');
                $return = JRequest::getVar('return');
                $db->setQuery("INSERT INTO apdm_pns_sto (sto_code,sto_description,sto_file,sto_state,sto_created,sto_create_by,sto_type,sto_owner) VALUES ('" . $sto_code . "', '" . $sto_description . "', '" . $sto_file . "', '" . $sto_state . "', '" . $pns_created . "', '" . $pns_created_by . "',1,'".$sto_owner."')");
                $db->query();
                $msg = "Successfully Saved Stock";
                $this->setRedirect('index.php?option=com_apdmpns&task=stomanagement', $msg);
                exit;
        }        
        /*
         * Save new stock ETO
         */
        function save_stoe() {
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $datenow = & JFactory::getDate();
                $sto_code = JRequest::getVar('sto_code');
                $sto_owner = JRequest::getVar('sto_owner');
                $sto_code_prefix = JRequest::getVar('sto_code_prefix');
                $sto_description = JRequest::getVar('sto_description');
                $sto_state = "Create"; //JRequest::getVar('sto_state');
                $pns_created = $datenow->toMySQL();
                $pns_created_by = $me->get('id');                
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS;
                $sto_code = $sto_code.'-'.$sto_code_prefix;
                //check exist first
                $db->setQuery("select count(*) from apdm_pns_sto where sto_code = '" . $sto_code."'");
                $check_exist = $db->loadResult();
                if ($check_exist!=0) {    
                        $msg = "The ETO already exist!";
                        $this->setRedirect('index.php?option=com_apdmpns&task=stomanagement', $msg);
                        return;
                }                       
                //upload attached POs
                if ($_FILES['sto_file']['size'] > 0) {
                        $attached = new upload($_FILES['sto_file']);
                        $attached->file_new_name_body =  "_" . str_replace("-", "_", $sto_code);
                        if (file_exists($path_pns . 'images' . DS . $attached->file_new_name_body . "." . $attached->file_src_name_ext)) {

                                @unlink($path_pns . 'images' . DS . $attached->file_new_name_body . "." . $attached->file_src_name_ext);
                        }
                        if ($attached->uploaded) {
                                $attached->Process($path_pns . 'images' . DS);
                                if ($attached->processed) {
                                        $sto_file = $attached->file_dst_name;
                                }
                        }
                }
                //$pns_life_cycle = JRequest::getVar('pns_life_cycle');
                $return = JRequest::getVar('return');
                $db->setQuery("INSERT INTO apdm_pns_sto (sto_code,sto_description,sto_file,sto_state,sto_created,sto_create_by,sto_type,sto_owner) VALUES ('" . $sto_code . "', '" . $sto_description . "', '" . $sto_file . "', '" . $sto_state . "', '" . $pns_created . "', '" . $pns_created_by . "',2,'".$sto_owner."')");
                $db->query();
                $msg = "Successfully Saved Stock";
                $this->setRedirect('index.php?option=com_apdmpns&task=stomanagement', $msg);
                exit;
        }                
        function save_stom() {
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $datenow = & JFactory::getDate();
                $sto_code = JRequest::getVar('sto_code');
                $sto_owner = JRequest::getVar('sto_owner');
                $sto_code_prefix = JRequest::getVar('sto_code_prefix');
                $sto_description = JRequest::getVar('sto_description');
                $sto_state = "Create"; //JRequest::getVar('sto_state');
                $pns_created = $datenow->toMySQL();
                $pns_created_by = $me->get('id');                
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS;
                $sto_code = $sto_code.'-'.$sto_code_prefix;
                //check exist first
                $db->setQuery("select count(*) from apdm_pns_sto where sto_code = '" . $sto_code."'");
                $check_exist = $db->loadResult();
                if ($check_exist!=0) {    
                        $msg = "The Move Location Code already exist!";
                        $this->setRedirect('index.php?option=com_apdmpns&task=stomanagement', $msg);
                        return;
                }            
                //upload attached POs
                if ($_FILES['sto_file']['size'] > 0) {
                        $attached = new upload($_FILES['sto_file']);
                        $attached->file_new_name_body =  "_" . str_replace("-", "_", $sto_code);
                        if (file_exists($path_pns . 'images' . DS . $attached->file_new_name_body . "." . $attached->file_src_name_ext)) {

                                @unlink($path_pns . 'images' . DS . $attached->file_new_name_body . "." . $attached->file_src_name_ext);
                        }
                        if ($attached->uploaded) {
                                $attached->Process($path_pns . 'images' . DS);
                                if ($attached->processed) {
                                        $sto_file = $attached->file_dst_name;
                                }
                        }
                }
                //$pns_life_cycle = JRequest::getVar('pns_life_cycle');
                $return = JRequest::getVar('return');
                $db->setQuery("INSERT INTO apdm_pns_sto (sto_code,sto_description,sto_file,sto_state,sto_created,sto_create_by,sto_type,sto_owner) VALUES ('" . $sto_code . "', '" . $sto_description . "', '" . $sto_file . "', '" . $sto_state . "', '" . $pns_created . "', '" . $pns_created_by . "',3,'".$sto_owner."')");
                $db->query();
                $msg = "Successfully Saved Move Location";
                $this->setRedirect('index.php?option=com_apdmpns&task=stomanagement', $msg);
                exit;
        }                
        /*
         * Asign template for get list child PNS  for BOM PNS
         */

        function get_pns_quonew() {
                JRequest::setVar('layout', 'quonew');
                JRequest::setVar('view', 'quo');
                parent::display();
        }          
        function save_pns_quonew() {
                
                
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $datenow = & JFactory::getDate();
                $pns_id = JRequest::getVar('pns_id');
                $quo_code = JRequest::getVar('quo_code');
                $quo_description = JRequest::getVar('quo_description');
                $quo_state = "Create"; //JRequest::getVar('po_state');
                $pns_created = $datenow->toMySQL();
                $pns_created_by = $me->get('id');
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS;
                //upload attached POs
                if ($_FILES['quo_file']['size'] > 0) {
                        $attached = new upload($_FILES['quo_file']);
                        $attached->file_new_name_body = $pns_id . "_" . str_replace("-", "_", $po_code);
                        if (file_exists($path_pns . 'images' . DS . $attached->file_new_name_body . "." . $attached->file_src_name_ext)) {

                                @unlink($path_pns . 'images' . DS . $attached->file_new_name_body . "." . $attached->file_src_name_ext);
                        }
                        if ($attached->uploaded) {
                                $attached->Process($path_pns . 'images' . DS);
                                if ($attached->processed) {
                                        $po_file = $attached->file_dst_name;
                                }
                        }
                }
                //$pns_life_cycle = JRequest::getVar('pns_life_cycle');
                $return = JRequest::getVar('return');
                $db->setQuery("INSERT INTO apdm_pns_quo (quo_code,quo_description,quo_file,quo_state,quo_created,quo_create_by) VALUES ('" . $quo_code . "', '" . $quo_description . "', '" . $quo_file . "', '" . $quo_state . "', '" . $pns_created . "', '" . $pns_created_by . "')");
                $db->query();
                $db->setQuery("select pns_quo_id,quo_code from apdm_pns_quo where quo_code='".$quo_code."'");
                $db->query();  
                $rows = $db->loadObjectList();
               echo $result = $rows[0]->pns_quo_id.'^'.$rows[0]->quo_code;
                exit;
        }        

        /*
         * Export BOM with format excel
         */

        function export_bom_xls() {
                include_once(JPATH_BASE . DS . 'includes' . DS . 'PHPExcel.php');
                require_once (JPATH_BASE . DS . 'includes' . DS . 'PHPExcel' . DS . 'RichText.php');
                require_once(JPATH_BASE . DS . 'includes' . DS . 'PHPExcel' . DS . 'IOFactory.php');
                require_once('includes/download.class.php');
                ini_set("memory_limit", "512M");
                @set_time_limit(1000000);
                $objPHPExcel = new PHPExcel();
                $objReader = PHPExcel_IOFactory::createReader('Excel5'); //Excel5
                $objPHPExcel = $objReader->load(JPATH_COMPONENT . DS . 'apdm_pn_bom_new_report.xls');

                global $mainframe;

                $me = & JFactory::getUser();
                $pns_id = JRequest::getVar('pns_id');
                $username = $me->get('username');
                $db = & JFactory::getDBO();
                //level 0
                $query = 'SELECT * FROM apdm_pns WHERE pns_id=' . $pns_id;
                $db->setQuery($query);
                $row = $db->loadObject();
                
                        $listPNs = array();
                        if ($row->pns_revision) {
                                $pns_code = $row->ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                        } else {
                                $pns_code = $row->ccs_code . '-' . $row->pns_code;
                        }
                        $manufacture = PNsController::GetManufacture($pns_id);                    
                        $listPNs[] = array(
                            "pns_code" => $pns_code,
                            "pns_level" => 0,
                          //  "eco" => GetEcoValue($row->eco_id),
                            "pns_type" => $row->pns_type,
                            "pns_des" => $row->pns_description,
                           // "pns_status" => $row->pns_status,
                            "find_number" => $row->find_number,                    
                            "ref_des" => $row->ref_des,
                            "stock" => $row->stock,
                            "pns_uom" => $row->pns_uom,
                            "v_mf" => $manufacture[0]['v_mf'],
                            "mf" => $manufacture[0]['mf'],
                       //     "pns_life_cycle" => $row->pns_life_cycle,
                            "tool_pn" => GetToolPnValue($row->pns_id),
                            "pns_date" => JHTML::_('date', $row->pns_create, '%m/%d/%Y')

                        );                                 
                $pnsCodeLevelZero = $pns_code; 
                
                //get childs
                $db->setQuery('SELECT pr.pns_id as pns_bom_id,pr.*,CONCAT_WS( "-", p.ccs_code, p.pns_code, p.pns_revision ) AS text, e.eco_name, p.    pns_description, p.pns_type, p.pns_status,p.* FROM apdm_pns AS p LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_id LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND pr.pns_parent in (' . $pns_id . ')');                
                $list_pns = $db->loadObjectList();
               // $listPNs = array();
               
                
                foreach ($list_pns as $row){
                        if ($row->pns_revision) {
                                $pns_code = $row->ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                        } else {
                                $pns_code = $row->ccs_code . '-' . $row->pns_code;
                        }
                        $manufacture = PNsController::GetManufacture($row->pns_id);
                        $listPNs[] = array(
                            "pns_code" => $pns_code,
                            "pns_level" => 1,
                        //    "eco" => GetEcoValue($row->eco_id),
                            "pns_type" => $row->pns_type,
                            "pns_des" => $row->pns_description,
                           // "pns_status" => $row->pns_status,
                            "find_number" => $row->find_number,                    
                            "ref_des" => $row->ref_des,
                            "stock" => $row->stock,
                            "pns_uom" => $row->pns_uom,
                            "v_mf" => $manufacture[0]['v_mf'],
                            "mf" => $manufacture[0]['mf'],
                         //   "pns_life_cycle" => $row->pns_life_cycle,
                            "tool_pn" => GetToolPnValue($row->pns_id),
                            "pns_date" => JHTML::_('date', $row->pns_create, '%m/%d/%Y')

                        );                
                //get list child
                //$query = "SELECT pr.*, p.ccs_code FROM apdm_pns_parents as pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=" . $pns_id . " ORDER BY p.ccs_code ";
                $db->setQuery('SELECT pr.pns_id as pns_bom_id,pr.*,CONCAT_WS( "-", p.ccs_code, p.pns_code, p.pns_revision ) AS text, e.eco_name, p.    pns_description, p.pns_type, p.pns_status,p.* FROM apdm_pns AS p LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_id LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND pr.pns_parent in (' . $row->pns_id . ')');                                
                $rows = $db->loadObjectList();                               
                //for level 2
                foreach ($rows as $result1) {
                        if ($result1->pns_revision) {
                                $pns_code1 = $result1->ccs_code . '-' . $result1->pns_code . '-' . $result1->pns_revision;
                        } else {
                                $pns_code1 = $result1->ccs_code . '-' . $result1->pns_code;
                        }
                        $manufacture = PNsController::GetManufacture($result1->pns_id);
                        $listPNs[] = array(
                            "pns_code" => $pns_code1,
                            "pns_level" => 2,
                         //   "eco" => $result1->eco_name,
                            "pns_type" => $result1->pns_type,
                            "pns_des" => $result1->pns_description,
                         //   "pns_status" => $result1->pns_status,
                            "find_number" => $result1->find_number, 
                            "ref_des" => $result1->ref_des,
                            "stock" => $result1->stock,
                            "pns_uom" => $result1->pns_uom,
                            "v_mf" => $manufacture[0]['v_mf'],
                            "mf" => $manufacture[0]['mf'],
                         //   "pns_life_cycle" => $result1->pns_life_cycle,
                            "tool_pn" => GetToolPnValue($result1->pns_id),
                            "pns_date" => JHTML::_('date', $result1->pns_create, '%m/%d/%Y')
                        );
                        ///check for child of level 3
                        //$db->setQuery("SELECT pr.*,  p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=" . $obj1->pns_id . " ORDER BY p.ccs_code");
                        $db->setQuery('SELECT pr.pns_id as pns_bom_id,pr.*,CONCAT_WS( "-", p.ccs_code, p.pns_code, p.pns_revision ) AS text, e.eco_name, p.    pns_description, p.pns_type, p.pns_status,p.* FROM apdm_pns AS p LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_id LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND pr.pns_parent in (' . $result1->pns_id . ')');
                        $rows2 = $db->loadObjectList();
                        if (count($rows2) > 0) {
                                foreach ($rows2 as $result2) {
                                        if ($result2->pns_revision) {
                                                $pns_code2 = $result2->ccs_code . '-' . $result2->pns_code . '-' . $result2->pns_revision;
                                        } else {
                                                $pns_code2 = $result2->ccs_code . '-' . $result2->pns_code;
                                        }
                                        $manufacture = PNsController::GetManufacture($result2->pns_id);
                                        $listPNs[] = array(
                                            "pns_code" => $pns_code2,
                                            "pns_level" => 3,
                                     //       "eco" => $result2->eco_name,
                                            "pns_type" => $result2->pns_type,
                                            "pns_des" => $result2->pns_description,
                                          //  "pns_status" => $result2->pns_status,
                                            "find_number" => $result2->find_number, 
                                            "ref_des" => $result2->ref_des,
                                            "stock" => $result2->stock,
                                            "pns_uom" => $result2->pns_uom,
                                             "v_mf" => $manufacture[0]['v_mf'],
                                                "mf" => $manufacture[0]['mf'],
                                       //     "pns_life_cycle" => $result2->pns_life_cycle,
                                            "tool_pn" => GetToolPnValue($result2->pns_id),
                                            "pns_date" => JHTML::_('date', $result2->pns_create, '%m/%d/%Y')
                                        );
                                        //check for level 4
                                        //$db->setQuery("SELECT pr.*,  p.ccs_code FROM apdm_pns_parents AS pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id WHERE pr.pns_parent=" . $obj2->pns_id . " ORDER BY p.ccs_code");
                                        $db->setQuery('SELECT pr.pns_id as pns_bom_id,pr.*,CONCAT_WS( "-", p.ccs_code, p.pns_code, p.pns_revision ) AS text, e.eco_name, p.    pns_description, p.pns_type, p.pns_status,p.* FROM apdm_pns AS p LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_id LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND pr.pns_parent in (' . $result2->pns_id . ')');                                        
                                        $rows3 = $db->loadObjectList();
                                        if (count($rows3) > 0) {
                                                foreach ($rows3 as $result3) {
                                                        if ($result3->pns_revision) {
                                                                $pns_code3 = $result3->ccs_code . '-' . $result3->pns_code . '-' . $result3->pns_revision;
                                                        } else {
                                                                $pns_code3 = $result3->ccs_code . '-' . $result3->pns_code;
                                                        }
                                                        $manufacture = PNsController::GetManufacture($result3->pns_id);
                                                        $listPNs[] = array(
                                                            "pns_code" => $pns_code3,
                                                            "pns_level" => 4,
                                                         //   "eco" => $result3->eco_name,
                                                            "pns_type" => $result3->pns_type,
                                                            "pns_des" => $result3->pns_description,
                                                          //  "pns_status" => $result3->pns_status,
                                                            "find_number" => $result3->find_number,
                                                            "ref_des" => $result3->ref_des,
                                                            "stock" => $result3->stock,
                                                            "pns_uom" => $result3->pns_uom,
                                                            "v_mf" => $manufacture[0]['v_mf'],
                                                                "mf" => $manufacture[0]['mf'],
                                                          //  "pns_life_cycle" => $result3->pns_life_cycle,
                                                            "tool_pn" => GetToolPnValue($result3->pns_id),
                                                            "pns_date" => JHTML::_('date', $result3->pns_create, '%m/%d/%Y')
                                                        );
                                                        //check for level 5
                                                        $db->setQuery('SELECT pr.pns_id as pns_bom_id,pr.*,CONCAT_WS( "-", p.ccs_code, p.pns_code, p.pns_revision ) AS text, e.eco_name, p.    pns_description, p.pns_type, p.pns_status,p.* FROM apdm_pns AS p LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_id LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND pr.pns_parent in (' . $result3->pns_id . ')');                                        
                                                        $rows4 = $db->loadObjectList();
                                                        if (count($rows4) > 0) {
                                                                foreach ($rows4 as $result4) {
                                                                        if ($result4->pns_revision) {
                                                                                $pns_code4 = $result4->ccs_code . '-' . $result4->pns_code . '-' . $result4->pns_revision;
                                                                        } else {
                                                                                $pns_code4 = $result4->ccs_code . '-' . $result4->pns_code;
                                                                        }
                                                                        $manufacture = PNsController::GetManufacture($result4->pns_id);
                                                                        $listPNs[] = array(
                                                                            "pns_code" => $pns_code4,
                                                                            "pns_level" => 5,
                                                                       //     "eco" => $result4->eco_name,
                                                                            "pns_type" => $result4->pns_type,
                                                                            "pns_des" => $result4->pns_description,
                                                                        //    "pns_status" => $result4->pns_status,
                                                                            "find_number" => $result4->find_number, 
                                                                            "ref_des" => $result4->ref_des,
                                                                            "stock" => $result4->stock,
                                                                            "pns_uom" => $result4->pns_uom,
                                                                            "v_mf" => $manufacture[0]['v_mf'],
                                                                             "mf" => $manufacture[0]['mf'],
                                                                         //   "pns_life_cycle" => $result4->pns_life_cycle,
                                                                            "tool_pn" => GetToolPnValue($result4->pns_id),
                                                                            "pns_date" => JHTML::_('date', $result4->pns_create, '%m/%d/%Y')
                                                                        );
                                                                        //check for level 6
                                                                        $db->setQuery('SELECT pr.pns_id as pns_bom_id,pr.*,CONCAT_WS( "-", p.ccs_code, p.pns_code, p.pns_revision ) AS text, e.eco_name, p.    pns_description, p.pns_type, p.pns_status,p.* FROM apdm_pns AS p LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_id LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND pr.pns_parent in (' . $result4->pns_id . ')');                                        
                                                                        $rows5 = $db->LoadObjectList();
                                                                        if (count($rows5) > 0) {
                                                                                foreach ($rows5 as $result5) {
                                                                                        if ($result4->pns_revision) {
                                                                                                $pns_code5 = $result5->ccs_code . '-' . $result5->pns_code . '-' . $result5->pns_revision;
                                                                                        } else {
                                                                                                $pns_code5 = $result5->ccs_code . '-' . $result5->pns_code;
                                                                                        }
                                                                                        $manufacture = PNsController::GetManufacture($result5->pns_id);
                                                                                        $listPNs[] = array(
                                                                                            "pns_code" => $pns_code5,
                                                                                            "pns_level" => 6,
                                                                                         //   "eco" => $result5->eco_name,
                                                                                            "pns_type" => $result5->pns_type,
                                                                                            "pns_des" => $result5->pns_description,
                                                                                          //  "pns_status" => $result5->pns_status,
                                                                                            "find_number" => $result5->find_number, 
                                                                                            "ref_des" => $result5->ref_des,
                                                                                            "stock" => $result5->stock,
                                                                                            "pns_uom" => $result5->pns_uom,
                                                                                            "v_mf" => $manufacture[0]['v_mf'],
                                                                                                "mf" => $manufacture[0]['mf'],
                                                                                        //    "pns_life_cycle" => $result5->pns_life_cycle,
                                                                                            "tool_pn" => GetToolPnValue($result5->pns_id),
                                                                                            "pns_date" => JHTML::_('date', $result5->pns_create, '%m/%d/%Y')
                                                                                        );
                                                                                        //check for level 7
                                                                                        $db->setQuery('SELECT pr.pns_id as pns_bom_id,pr.*,CONCAT_WS( "-", p.ccs_code, p.pns_code, p.pns_revision ) AS text, e.eco_name, p.    pns_description, p.pns_type, p.pns_status,p.* FROM apdm_pns AS p LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_id LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND pr.pns_parent in (' . $result5->pns_id . ')');                                        
                                                                                        $rows6 = $db->LoadObjectList();
                                                                                        if (count($rows6) > 0) {
                                                                                                foreach ($rows6 as $result6) {
                                                                                                        if ($result6->pns_revision) {
                                                                                                                $pns_code6 = $result6->ccs_code . '-' . $result6->pns_code . '-' . $result6->pns_revision;
                                                                                                        } else {
                                                                                                                $pns_code6 = $result6->ccs_code . '-' . $result6->pns_code;
                                                                                                        }
                                                                                                        $manufacture = PNsController::GetManufacture($result6->pns_id);
                                                                                                        $listPNs[] = array(
                                                                                                            "pns_code" => $pns_code6,
                                                                                                            "pns_level" => 7,
                                                                                                         //   "eco" => GetEcoValue($result6->eco_id),
                                                                                                            "pns_type" => $result6->pns_type,
                                                                                                            "pns_des" => $result6->pns_description,
                                                                                                            //"pns_status" => $result6->pns_status,
                                                                                                            "find_number" => $result6->find_number, 
                                                                                                            "ref_des" => $result6->ref_des,
                                                                                                            "stock" => $result6->stock,
                                                                                                            "pns_uom" => $result6->pns_uom,
                                                                                                             "v_mf" => $manufacture[0]['v_mf'],
                                                                                                                "mf" => $manufacture[0]['mf'],                                                                                                            
                                                                                                          //  "pns_life_cycle" => $result6->pns_life_cycle,
                                                                                                            "tool_pn" => GetToolPnValue($result6->pns_id),
                                                                                                            "pns_date" => JHTML::_('date', $result6->pns_create, '%m/%d/%Y')
                                                                                                        );
                                                                                                        // check for level 8
                                                                                                        $db->setQuery('SELECT pr.pns_id as pns_bom_id,pr.*,CONCAT_WS( "-", p.ccs_code, p.pns_code, p.pns_revision ) AS text, e.eco_name, p.    pns_description, p.pns_type, p.pns_status,p.* FROM apdm_pns AS p LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_id LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND pr.pns_parent in (' . $result6->pns_id . ')');
                                                                                                        $rows7 = $db->LoadObjectList();
                                                                                                        if (count($rows7) > 0) {
                                                                                                                foreach ($rows7 as $result7) {
                                                                                                                        if ($result7->pns_revision) {
                                                                                                                                $pns_code7 = $result7->ccs_code . '-' . $result7->pns_code . '-' . $result7->pns_revision;
                                                                                                                        } else {
                                                                                                                                $pns_code7 = $result7->ccs_code . '-' . $result7->pns_code;
                                                                                                                        }
                                                                                                                        $manufacture = PNsController::GetManufacture($result7->pns_id);
                                                                                                                        $listPNs[] = array(
                                                                                                                            "pns_code" => $pns_code7,
                                                                                                                            "pns_level" => 8,
                                                                                                                            //"eco" => $result7->eco_name,
                                                                                                                            "pns_type" => $result7->pns_type,
                                                                                                                            "pns_des" => $result7->pns_description,
                                                                                                                           // "pns_status" => $result7->pns_status,
                                                                                                                            "find_number" => $result7->find_number, 
                                                                                                                            "ref_des" => $result7->ref_des,
                                                                                                                            "stock" => $result7->stock,                                                                                                                                            
                                                                                                                            "pns_uom" => $result7->pns_uom,
                                                                                                                            "v_mf" => $manufacture[0]['v_mf'],
                                                                                                                                "mf" => $manufacture[0]['mf'], 
                                                                                                                          //  "pns_life_cycle" => $result7->pns_life_cycle,
                                                                                                                            "tool_pn" => GetToolPnValue($result7->pns_id),
                                                                                                                            "pns_date" => JHTML::_('date', $result7->pns_create, '%m/%d/%Y')
                                                                                                                        );
                                                                                                                        //check for level 9
                                                                                                                        $db->setQuery('SELECT pr.pns_id as pns_bom_id,pr.*,CONCAT_WS( "-", p.ccs_code, p.pns_code, p.pns_revision ) AS text, e.eco_name, p.    pns_description, p.pns_type, p.pns_status,p.* FROM apdm_pns AS p LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_id LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND pr.pns_parent in (' . $result7->pns_id . ')');
                                                                                                                        $rows8 = $db->LoadObjectList();
                                                                                                                        if (count($rows8) > 0) {
                                                                                                                                foreach ($rows8 as $result8) { 
                                                                                                                                        if ($result8->pns_revision) {
                                                                                                                                                $pns_code8 = $result8->ccs_code . '-' . $result8->pns_code . '-' . $result8->pns_revision;
                                                                                                                                        } else {
                                                                                                                                                $pns_code8 = $result8->ccs_code . '-' . $result8->pns_code;
                                                                                                                                        }
                                                                                                                                        $manufacture = PNsController::GetManufacture($result8->pns_id);
                                                                                                                                        $listPNs[] = array(
                                                                                                                                            "pns_code" => $pns_code8,
                                                                                                                                            "pns_level" => 9,
                                                                                                                                           // "eco" => $result8->eco_name,
                                                                                                                                            "pns_type" => $result8->pns_type,
                                                                                                                                            "pns_des" => $result8->pns_description,
                                                                                                                                           // "pns_status" => $result8->pns_status,
                                                                                                                                            "find_number" => $result8->find_number, 
                                                                                                                                            "ref_des" => $result8->ref_des,
                                                                                                                                            "stock" => $result8->stock,          
                                                                                                                                            "pns_uom" => $result8->pns_uom,
                                                                                                                                            "v_mf" => $manufacture[0]['v_mf'],
                                                                                                                                                 "mf" => $manufacture[0]['mf'], 
                                                                                                                                          //  "pns_life_cycle" => $result8->pns_life_cycle,
                                                                                                                                            "tool_pn" => GetToolPnValue($result18->pns_id),
                                                                                                                                            "pns_date" => JHTML::_('date', $result8->pns_create, '%m/%d/%Y')
                                                                                                                                        );
                                                                                                                                        //check for level 10;
                                                                                                                                        $db->setQuery('SELECT pr.pns_id as pns_bom_id,pr.*,CONCAT_WS( "-", p.ccs_code, p.pns_code, p.pns_revision ) AS text, e.eco_name, p.    pns_description, p.pns_type, p.pns_status,p.* FROM apdm_pns AS p LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_id LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND pr.pns_parent in (' . $result8->pns_id . ')');
                                                                                                                                        $rows9 = $db->LoadObjectList();
                                                                                                                                        if (count($rows9) > 0) {
                                                                                                                                                foreach ($rows9 as $result9) { 
                                                                                                                                                        if ($result9->pns_revision) {
                                                                                                                                                                $pns_code9 = $result9->ccs_code . '-' . $result9->pns_code . '-' . $result9->pns_revision;
                                                                                                                                                        } else {
                                                                                                                                                                $pns_code9 = $result9->ccs_code . '-' . $result9->pns_code;
                                                                                                                                                        }
                                                                                                                                                        $manufacture = PNsController::GetManufacture($result9->pns_id);
                                                                                                                                                        $listPNs[] = array(
                                                                                                                                                            "pns_code" => $pns_code9,
                                                                                                                                                            "pns_level" => 10,
                                                                                                                                                           // "eco" => $result9 > eco_name,
                                                                                                                                                            "pns_type" => $result9->pns_type,
                                                                                                                                                            "pns_des" => $result9->pns_description,
                                                                                                                                                           // "pns_status" => $result9->pns_status,
                                                                                                                                                            "find_number" => $result9->find_number,
                                                                                                                                                            "ref_des" => $result9->ref_des,
                                                                                                                                                            "stock" => $result9->stock,
                                                                                                                                                            "pns_uom" => $result9->pns_uom,
                                                                                                                                                             "v_mf" => $manufacture[0]['v_mf'],
                                                                                                                                                                "mf" => $manufacture[0]['mf'], 
                                                                                                                                                          //  "pns_life_cycle" => $result9->pns_life_cycle,
                                                                                                                                                            "tool_pn" => GetToolPnValue($result9->pns_id),
                                                                                                                                                            "pns_date" => JHTML::_('date', $result9->pns_create, '%m/%d/%Y')
                                                                                                                                                        );
                                                                                                                                                }
                                                                                                                                        }
                                                                                                                                }
                                                                                                                        }
                                                                                                                }
                                                                                                        }
                                                                                                }
                                                                                        }
                                                                                }
                                                                        }
                                                                }
                                                        }
                                                }
                                        }
                                }
                        }
                }
                }
                
                $user_name = $me->get('name');
                $date = JHTML::_('date', date("Y-m-d"), '%m/%d/%Y');
                //for Execl
                $styleThinBlackBorderOutline = array(
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ),
                );

                $objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);

                $objPHPExcel->getActiveSheet()->setCellValue('A5', 'Username: ' . $me->get('username'));
                $objPHPExcel->getActiveSheet()->setCellValue('F5', 'Date Created: ' . $date);
                
                $nRecord = count($listPNs);
                $objPHPExcel->getActiveSheet()->getStyle('A7:F' . $nRecord)->getAlignment()->setWrapText(true);
                if ($nRecord > 0) {
                        $jj = 0;
                        $ii = 7;
                        $number = 1;
                        foreach ($listPNs as $pns) {
                                $a = 'A' . $ii;
                                $b = 'B' . $ii;
                                $c = 'C' . $ii;
                                $d = 'D' . $ii;
                                $e = 'E' . $ii;
                                $f = 'F' . $ii;
                                $g = 'G' . $ii;
                                $h = 'H' . $ii;//for pns_find_number
                                $i = 'I' . $ii;
                                $j = 'J' . $ii;
                                $k = 'K' . $ii;
                                $l = 'L' . $ii;
                                $m = 'M' . $ii;
                                //set heigh or row                                 
                                $objPHPExcel->getActiveSheet()->getRowDimension($ii)->setRowHeight(30);
                                $objPHPExcel->getActiveSheet()->setCellValue($a, $number );
                                $objPHPExcel->getActiveSheet()->setCellValue($b, $pns['pns_level']);
                                $objPHPExcel->getActiveSheet()->setCellValue($c, $pns['pns_code']);
                                $objPHPExcel->getActiveSheet()->setCellValue($d, $pns['pns_des']);//
                                $objPHPExcel->getActiveSheet()->setCellValue($e, $pns['find_number']);
                                $objPHPExcel->getActiveSheet()->setCellValue($f, $pns['stock']);
                                $objPHPExcel->getActiveSheet()->setCellValue($g, $pns['pns_uom']);//
                                $objPHPExcel->getActiveSheet()->setCellValue($h, $pns['v_mf']);
                                $objPHPExcel->getActiveSheet()->setCellValue($i, $pns['mf']);
                                $objPHPExcel->getActiveSheet()->setCellValue($j, $pns['tool_pn']);                                
                                $objPHPExcel->getActiveSheet()->setCellValue($k, $pns['pns_type']);
                                $objPHPExcel->getActiveSheet()->setCellValue($l, $pns['ref_des']);
                                $objPHPExcel->getActiveSheet()->setCellValue($m, $pns['pns_date']);

                                //set format
                                $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($c)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($d)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($e)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($f)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);
                                $objPHPExcel->getActiveSheet()->getStyle($g)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($h)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($k)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($l)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($m)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


                                $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($c)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($d)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($e)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
                                $objPHPExcel->getActiveSheet()->getStyle($g)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($l)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($m)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



                                $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($c)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($d)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($e)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($f)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($g)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($h)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($j)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($k)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($l)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($m)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                                $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                if ($jj % 2 == 0) {
                                       $objPHPExcel->getActiveSheet()->getStyle($a . ':' . $h)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                                        $objPHPExcel->getActiveSheet()->getStyle($a . ':' . $h)->getFill()->getStartColor()->setRGB('EEEEEE');
                                }
                                if ($jj == $nRecord - 1) {
                                        $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($c)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($d)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($e)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($f)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($g)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($h)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($j)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($k)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($l)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($m)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                }
                                $ii++;
                                $jj++;
                                $number++;
                        }
                }
                $path_export = JPATH_SITE . DS . 'uploads' . DS . 'export' . DS;
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save($path_export . 'APDM_BOM_REPORT.xls');
                $dFile = new DownloadFile($path_export, 'APDM_BOM_REPORT.xls');

        }        
        function DisplayAllRevValue($pns_id) {
                $db = & JFactory::getDBO();
                $rows = array();                
                $db->setQuery("SELECT prev.*,eco.eco_name, CONCAT_WS( '-', prev.ccs_code, prev.pns_code, prev.pns_revision ) AS parent_pns_code  FROM apdm_pns AS p LEFT JOIN apdm_pns_rev AS prev on p.pns_id = prev.pns_id inner join apdm_eco eco on eco.eco_id = p.eco_id WHERE p.pns_deleted =0 AND prev.pns_id=".$pns_id);
                return $list_revision = $db->loadObjectList();             
        }        
        function GetImagePreview($pns_id)
        {
                $db = & JFactory::getDBO();
                $db->setQuery("select image_file from apdm_pns_image where pns_id ='".$pns_id."' limit 1");
                return $db->loadResult();                
        }
        function CalculateInventoryValue($pns_id)
        {
                $db = & JFactory::getDBO();
                $db->setQuery("select pns_stock from apdm_pns where pns_id='".$pns_id."'");
                $db->query();  
                $rows = $db->loadObjectList();
                $CurrentStock = $rows[0]->pns_stock;
                //get Stock IN
                $db->setQuery("select  sum(qty) from apdm_pns_sto_fk fk inner join apdm_pns pn on fk.pns_id = pn.pns_id  inner join apdm_pns_sto sto on sto.pns_sto_id = fk.sto_id and sto_type = 1 where fk.pns_id='".$pns_id."'");
                $db->query();
               $StockIn = $db->loadResult();
                //$StockIn = $rows->qty_in;
                //get Stock OUT
                $db->setQuery("select  sum(qty)  from apdm_pns_sto_fk fk inner join apdm_pns pn on fk.pns_id = pn.pns_id  inner join apdm_pns_sto sto on sto.pns_sto_id = fk.sto_id and sto_type = 2 where fk.pns_id='".$pns_id."'");
                $db->query();
                 $StockOut = $db->loadResult();
                //$StockOut = $rows->qty_out;
                $inventory =  round($CurrentStock + ($StockIn-$StockOut),2);
                if($inventory<0)
                     $inventory = 0;
                return $inventory;                                
                exit;                
        }
    function CalculateInventoryValueforView($pns_id)
    {
        $db = & JFactory::getDBO();
        $db->setQuery("select pns_stock from apdm_pns where pns_id='".$pns_id."'");
        $db->query();
        $rows = $db->loadObjectList();
        $CurrentStock = $rows[0]->pns_stock;
        //get Stock IN
        $db->setQuery("select  sum(qty) from apdm_pns_sto_fk fk inner join apdm_pns pn on fk.pns_id = pn.pns_id  inner join apdm_pns_sto sto on sto.pns_sto_id = fk.sto_id and sto_type = 1 and sto.sto_owner_confirm = 1 where fk.pns_id='".$pns_id."'");
        $db->query();
        $StockIn = $db->loadResult();
        //$StockIn = $rows->qty_in;
        //get Stock OUT
        $db->setQuery("select  sum(qty)  from apdm_pns_sto_fk fk inner join apdm_pns pn on fk.pns_id = pn.pns_id  inner join apdm_pns_sto sto on sto.pns_sto_id = fk.sto_id and sto_type = 2 and sto.sto_owner_confirm = 1 where fk.pns_id='".$pns_id."'");
        $db->query();
        $StockOut = $db->loadResult();
        //$StockOut = $rows->qty_out;
        $inventory =  round($CurrentStock + ($StockIn-$StockOut),2);
        if($inventory<0)
            $inventory = 0;
        return $inventory;
        exit;
    }
        function CalculateQtyUsedValue($pns_id)
        {
                $db = & JFactory::getDBO();
                //get Stock OUT
                $db->setQuery("select  sum(qty) as qty_out from apdm_pns_sto_fk fk inner join apdm_pns pn on fk.pns_id = pn.pns_id  inner join apdm_pns_sto sto on sto.pns_sto_id = fk.sto_id and sto_type = 2 where fk.pns_id='".$pns_id."'");
                $db->query();  
                $rows = $db->loadObjectList();
                $StockOut = round($rows[0]->qty_out,2);      
                return $StockOut;
                exit;                
        }        

        function locatecode() {
                JRequest::setVar('layout', 'loca_list');
                JRequest::setVar('view', 'location');
                parent::display();
        }        
        function edit_location() {
                JRequest::setVar('layout', 'edit_loca');
                JRequest::setVar('view', 'location');
                parent::display();
        }          
        
        function save_editloca() {
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $datenow = & JFactory::getDate();
                $currentUser = & JFactory::getUser();
                $location_code = JRequest::getVar('location_code');
                $location_description = JRequest::getVar('location_description');
                $location_status = JRequest::getVar('location_status');
                $location_id = JRequest::getVar('pns_location_id');
 
                //check exist first
                $db->setQuery("select count(*) from apdm_pns_location where location_code = '" . $location_code."' and pns_location_id != ".$location_id."");                
                $check_exist = $db->loadResult();
                if ($check_exist!=0) {    
                        $msg = "The Location Code already exist!";
                        $this->setRedirect('index.php?option=com_apdmpns&task=locatecode', $msg);
                        return;
                }                              
                $query =  "update apdm_pns_location set location_code = '".$location_code."',location_description='".$location_description."',location_status='".$location_status."',location_updated='".$datenow->toMySQL()."',location_updated_by =".$currentUser->get('id')." where pns_location_id=".$location_id."";                
                $return = JRequest::getVar('return');     
                $db->setQuery($query);
                $db->query();
                $msg = "Successfully Saved Code Location";
                return $this->setRedirect('index.php?option=com_apdmpns&task=locatecode', $msg);
                exit;
        }                      
        
        function add_location() {
                JRequest::setVar('layout', 'add_loca');
                JRequest::setVar('view', 'location');
                parent::display();
        }   
        function save_location() {
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $datenow = & JFactory::getDate();
                $currentUser = & JFactory::getUser();
                $location_code = JRequest::getVar('location_code');
                $location_description = JRequest::getVar('location_description');
                $location_status = 1;//JRequest::getVar('location_status');
              
                //check exist first
                $db->setQuery("select count(*) from apdm_pns_location where location_code = '" . $location_code."'");
                $check_exist = $db->loadResult();
                if ($check_exist!=0) {    
                        $msg = "The Location Code already exist!";
                        $this->setRedirect('index.php?option=com_apdmpns&task=locatecode', $msg);
                        return;
                }                       
              //insert into `apdm_pns_location`(`pns_location_id`,`location_code`,`location_description`,`location_status`,`location_created`,`location_updated`,`location_create_by`,`location_updated_by`) values ( NULL,'A0101','A0101A0101A0101A0101A0101','1','2018-10-23','156','2018-10-23','156')
                //$pns_life_cycle = JRequest::getVar('pns_life_cycle');
                $return = JRequest::getVar('return');               
                $db->setQuery("insert into `apdm_pns_location`(`location_code`,`location_description`,`location_status`,`location_created`,`location_updated`,`location_created_by`,`location_updated_by`) values ('" . $location_code . "','". $location_description . "', '" . $location_status . "','".$datenow->toMySQL()."', '".$datenow->toMySQL()."',".$currentUser->get('id').",".$currentUser->get('id').")");
                $db->query();
  /*              return  $redirect = '<script language="javascript" type="text/javascript">'
                            . 'window.parent.location.reload();'
                            . '</script>';*/
               // $msg = "Successfully Saved Location ";
                return $this->setRedirect('index.php?option=com_apdmpns&task=locatecode');
        }
        function locatecodetemp()
        {
            $msg = "Successfully Saved Location ";
            return $this->setRedirect('index.php?option=com_apdmpns&task=locatecode', $msg);
        }
        function GetLocationCodeList() {
                $db = & JFactory::getDBO();
                $rows = array();
                $query = "SELECT pns_location_id, location_code FROM apdm_pns_location WHERE  location_status =1";
                $db->setQuery($query);
                return $result = $db->loadObjectList();               
        }
         function GetCodeLocation($pns_location_id) {
                $db = & JFactory::getDBO();                
                $db->setQuery("SELECT location_code FROM apdm_pns_location WHERE pns_location_id=" . $pns_location_id);                
                return $db->loadResult();
        }
 /**
         * Removes the record(s) from the database
         */
        function removepnlocation() {
                // Check for request forgeries     		

                $db = & JFactory::getDBO();
                $currentUser = & JFactory::getUser();
                $cid = JRequest::getVar('cid', array(), '', 'array');
               
              //  JArrayHelper::toInteger($cid);

                if (count($cid) < 1) {
                        JError::raiseError(500, JText::_('Select a Code Location to delete', true));
                }
                foreach ($cid as $id) {
                        $db->setQuery("DELETE FROM apdm_pns_location WHERE pns_location_id =" . $id);
                        $db->query();
                }
                $msg = "Have successfuly Remove Code Location";
                return $this->setRedirect('index.php?option=com_apdmpns&task=locatecode', $msg);
        }    
        function GetStoFrommPns($pns_id,$sto_id) {
                $db = & JFactory::getDBO();
                $rows = array();
                //$query = "SELECT fk.id  FROM apdm_pns_sto AS sto inner JOIN apdm_pns_sto_fk fk on sto.pns_sto_id = fk.sto_id inner join apdm_pns AS p on p.pns_id = fk.pns_id where fk.pns_id=".$pns_id;
                $query = "SELECT pns_id,id FROM apdm_pns_sto_fk WHERE pns_id = ".$pns_id ." and sto_id = ".$sto_id;

                $db->setQuery($query);
                $result = $db->loadObjectList();
                if (count($result) > 0) {
                        foreach ($result as $obj) {
                                $rows[] = $obj->id;
                        }
                }
                return $rows;
        }        
        function GetQtyFromPartStatePns($partState,$pns_id,$sto_type)
        {
                $db = & JFactory::getDBO();
                $rows = array();
                //$query = "SELECT fk.id  FROM apdm_pns_sto AS sto inner JOIN apdm_pns_sto_fk fk on sto.pns_sto_id = fk.sto_id inner join apdm_pns AS p on p.pns_id = fk.pns_id where fk.pns_id=".$pns_id;
                $query = "SELECT sum(qty) FROM apdm_pns_sto_fk fk inner join apdm_pns_sto sto on fk.sto_id = sto.pns_sto_id  WHERE fk.pns_id = ".$pns_id." and fk.partstate = '".$partState."' and sto.sto_type =".$sto_type;
                $db->setQuery($query);
                return $db->loadResult();
        }
        function GetLocationFromPartStatePns($partState,$pns_id)
        {
                $db = & JFactory::getDBO();
                $rows = array();
                //$query = "SELECT fk.id  FROM apdm_pns_sto AS sto inner JOIN apdm_pns_sto_fk fk on sto.pns_sto_id = fk.sto_id inner join apdm_pns AS p on p.pns_id = fk.pns_id where fk.pns_id=".$pns_id;
                //$query = "select loc.location_code,fk.qty,fk.sto_id from apdm_pns_sto_fk fk inner join apdm_pns_location loc on fk.location=loc.pns_location_id where fk.pns_id = ".$pns_id." and fk.partstate = '".$partState."'";
               $query = "select loc.location_code,fk.qty,fk.sto_id ,fk.pns_mfg_pn_id,sto.sto_type ".
                        "from apdm_pns_sto_fk fk ".
                        "inner join apdm_pns_location loc on fk.location=loc.pns_location_id ".
                        "inner join apdm_pns_sto sto on fk.sto_id = sto.pns_sto_id ".
                        "where sto.sto_owner_confirm = 1  and  fk.pns_id = ".$pns_id." and fk.partstate = '".$partState."' and sto.sto_type in (1,2)";
                $db->setQuery($query);
                $result = $db->loadObjectList();
                if (count($result) > 0) {
                        $array_loacation=array();
                        foreach ($result as $obj) {
                                if($obj->sto_type==1 )
                                    $array_loacation[$obj->pns_mfg_pn_id] = $array_loacation[$obj->pns_mfg_pn_id] + $obj->qty;
                                elseif($obj->sto_type==2)
                                     $array_loacation[$obj->pns_mfg_pn_id] =$array_loacation[$obj->pns_mfg_pn_id] - $obj->qty;
                                
                        }
                }
                //get calculate move location
                $query = "select loc.location_code,fk.qty,fk.sto_id ,fk.pns_mfg_pn_id,sto.sto_type ".
                        "from apdm_pns_sto_fk fk ".
                        "inner join apdm_pns_location loc on fk.location_from=loc.pns_location_id ".
                        "inner join apdm_pns_sto sto on fk.sto_id = sto.pns_sto_id ".
                        "where sto.sto_owner_confirm = 1  and  fk.pns_id = ".$pns_id." and fk.partstate = '".$partState."' and sto.sto_type in (3)";
                $db->setQuery($query);
                $result = $db->loadObjectList();
                if (count($result) > 0) {
                        //$array_loacation=array();
                        foreach ($result as $obj) {
                                     $array_loacation[$obj->location_code] =$array_loacation[$obj->location_code] - $obj->qty;
                        }
                }
                //get row fromlocation display newline
                //get calculate move location
                $query = "select loc.location_code,fk.qty,fk.sto_id,fk.pns_mfg_pn_id ,sto.sto_type ".
                        "from apdm_pns_sto_fk fk ".
                        "inner join apdm_pns_location loc on fk.location=loc.pns_location_id ".
                        "inner join apdm_pns_sto sto on fk.sto_id = sto.pns_sto_id ".
                        "where sto.sto_owner_confirm = 1  and  fk.pns_id = ".$pns_id." and fk.partstate = '".$partState."' and sto.sto_type in (3)";
                $db->setQuery($query);
                $result = $db->loadObjectList();
                if (count($result) > 0) {
                        //$array_loacation=array();
                        foreach ($result as $obj) {
                                     $array_loacation[$obj->location_code] =$array_loacation[$obj->location_code] + $obj->qty;
                        }
                }
                
                $arr_loc =array();
                foreach($array_loacation as $key=>$val)
                {
                        if($val)
                        {
                                $arr_loc[$key]= $val;
                        }
                                
                }
                
                return $arr_loc;
        }    
        function GetMfgPnFromPartStatePns($partState,$pns_id)
        {
                $db = & JFactory::getDBO();
                $rows = array();
                //$query = "SELECT fk.id  FROM apdm_pns_sto AS sto inner JOIN apdm_pns_sto_fk fk on sto.pns_sto_id = fk.sto_id inner join apdm_pns AS p on p.pns_id = fk.pns_id where fk.pns_id=".$pns_id;
                //$query = "select loc.location_code,fk.qty,fk.sto_id from apdm_pns_sto_fk fk inner join apdm_pns_location loc on fk.location=loc.pns_location_id where fk.pns_id = ".$pns_id." and fk.partstate = '".$partState."'";
               $query = "select loc.location_code,fk.qty,fk.sto_id ,fk.pns_mfg_pn_id,sto.sto_type ".
                        "from apdm_pns_sto_fk fk ".
                        "inner join apdm_pns_location loc on fk.location=loc.pns_location_id ".
                        "inner join apdm_pns_sto sto on fk.sto_id = sto.pns_sto_id ".
                        "where sto.sto_owner_confirm = 1  and  fk.pns_id = ".$pns_id." and fk.partstate = '".$partState."' and sto.sto_type in (1,2)";
                $db->setQuery($query);
                $result = $db->loadObjectList();
                if (count($result) > 0) {
                        $array_loacation=array();
                        foreach ($result as $obj) {
                                if($obj->sto_type==1 )
                                    $array_loacation[$obj->pns_mfg_pn_id] = $obj->location_code;
                                elseif($obj->sto_type==2)
                                     $array_loacation[$obj->pns_mfg_pn_id] = $obj->location_code;
                                
                        }
                }
                //get calculate move location
                $query = "select loc.location_code,fk.qty,fk.sto_id ,fk.pns_mfg_pn_id,sto.sto_type ".
                        "from apdm_pns_sto_fk fk ".
                        "inner join apdm_pns_location loc on fk.location_from=loc.pns_location_id ".
                        "inner join apdm_pns_sto sto on fk.sto_id = sto.pns_sto_id ".
                        "where sto.sto_owner_confirm = 1  and  fk.pns_id = ".$pns_id." and fk.partstate = '".$partState."' and sto.sto_type in (3)";
                $db->setQuery($query);
                $result = $db->loadObjectList();
                if (count($result) > 0) {
                        //$array_loacation=array();
                        foreach ($result as $obj) {
                                     $array_loacation[$obj->location_code] =$obj->pns_mfg_pn_id;
                        }
                }
                //get row fromlocation display newline
                //get calculate move location
                $query = "select loc.location_code,fk.qty,fk.sto_id,fk.pns_mfg_pn_id ,sto.sto_type ".
                        "from apdm_pns_sto_fk fk ".
                        "inner join apdm_pns_location loc on fk.location=loc.pns_location_id ".
                        "inner join apdm_pns_sto sto on fk.sto_id = sto.pns_sto_id ".
                        "where sto.sto_owner_confirm = 1  and  fk.pns_id = ".$pns_id." and fk.partstate = '".$partState."' and sto.sto_type in (3)";
                $db->setQuery($query);
                $result = $db->loadObjectList();
                if (count($result) > 0) {
                        //$array_loacation=array();
                        foreach ($result as $obj) {
                                     $array_loacation[$obj->location_code] =$obj->pns_mfg_pn_id;
                        }
                }
                return $array_loacation;
                $arr_loc =array();
                foreach($array_loacation as $key=>$val)
                {
                        if($val)
                        {
                                $arr_loc[$key]= $val;
                        }
                                
                }
                
                return $arr_loc;
        }    
        function iesto_prefix_default() {
                $db = & JFactory::getDBO();
                $sto_type = JRequest::getVar('sto_type');

                $query = "SELECT count(*)  FROM apdm_pns_sto  WHERE sto_type = '" . $sto_type . "' and date(sto_created) = CURDATE()";
                $db->setQuery($query);
               $pns_latest = $db->loadResult();
               
                $next_pns_code = (int) $pns_latest;
                $next_pns_code++;
                $number = strlen($next_pns_code);
                switch ($number) {
                        case '1':
                                $new_pns_code = '0' . $next_pns_code;
                                break;
                        case '2':
                                $new_pns_code = $next_pns_code;
                                break;
                       
                        default:
                                $new_pns_code = $next_pns_code;
                                break;
                }
                echo $new_pns_code;
                exit;
        }
        function getPartStatePn($partState,$pns_id)
        {
                $db = & JFactory::getDBO();
                $rows = array();
                $query = "select fk.pns_id,fk.sto_id ,sto.sto_type,fk.partstate ".
                        " from apdm_pns_sto_fk fk  ".
                        "inner join apdm_pns_sto sto on fk.sto_id = sto.pns_sto_id ".
                        " where fk.pns_id = ".$pns_id." and sto.sto_type=1 and fk.partstate != '' group by fk.partstate ";
                $db->setQuery($query);
                $result = $db->loadObjectList();
                if (count($result) > 0) {
                        $partStateArr=array();
                        foreach ($result as $obj) {
                                if($obj->sto_type==1 )
                                {
                                    //$array_partstate[$obj->partstate] = $obj->partstate;                                
                                    $partStateArr[] = JHTML::_('select.option', $obj->partstate, strtoupper($obj->partstate) , 'value', 'text');                                                                          
                                }
                        }
                }
                
                return $partStateArr;
        }
        function ajax_getlocpn_partstate($pnsId,$fkId,$currentLoc,$partState)
        {
                //&partstate='+partState+'&pnsid='+pnsId+'&fkid'+fkId+'&currentloc='+currentLoc;
                
                $db = & JFactory::getDBO();
                $rows = array();
                $pnsId = JRequest::getVar('pnsid');
                $fkId = JRequest::getVar('fkid');
                $currentLoc = JRequest::getVar('currentloc');
                $partState = JRequest::getVar('partstate');
                $query = "select fk.pns_id,fk.sto_id ,sto.sto_type,fk.partstate,fk.location,loc.location_code ".
                        " from apdm_pns_sto_fk fk  ".
                        " inner join apdm_pns_location loc on loc.pns_location_id=location ".
                        " inner join apdm_pns_sto sto on fk.sto_id = sto.pns_sto_id ".
                        " where fk.pns_id = ".$pnsId." and sto.sto_type=1 and fk.partstate = '".$partState."'";
                $db->setQuery($query);
                $result = $db->loadObjectList();
                if (count($result) > 0) {
                        $locationArr=array();
                        foreach ($result as $obj) {
                                if($obj->sto_type==1 )
                                {
                                    //$array_partstate[$obj->partstate] = $obj->partstate;                                
                                    $locationArr[] = JHTML::_('select.option', $obj->location, $obj->location_code , 'value', 'text');                                                                          
                                }
                        }
                }
                
               echo JHTML::_('select.genericlist',   $locationArr, 'location_'.$pnsId.'_'.$fkId, 'class="inputbox" size="1" ', 'value', 'text', $currentLoc); 
                exit;
                //return $locationArr;  
        }
        function getLocationPartStatePn($partState,$pnsId)
        {
                $db = & JFactory::getDBO();
                $rows = array();
                $query = "select fk.pns_id,fk.sto_id ,sto.sto_type,fk.partstate,fk.location,loc.location_code ".
                        " from apdm_pns_sto_fk fk  ".
                        " inner join apdm_pns_location loc on loc.pns_location_id=location ".
                        " inner join apdm_pns_sto sto on fk.sto_id = sto.pns_sto_id ".
                        " where fk.pns_id = ".$pnsId." and sto.sto_type=1 and fk.partstate = '".$partState."' group by loc.location_code";
                $db->setQuery($query);
                $result = $db->loadObjectList();
                if (count($result) > 0) {
                        $locationArr=array();
                        foreach ($result as $obj) {
                                if($obj->sto_type==1 )
                                {
                                    //$array_partstate[$obj->partstate] = $obj->partstate;                                
                                    $locationArr[] = JHTML::_('select.option', $obj->location, $obj->location_code , 'value', 'text');                                                                          
                                }
                        }
                }
                return $locationArr;
        }
        function download_all_images_pns() {
                global $dirarray, $conf, $dirsize;

                //$conf['dir'] = "zipfiles";
                $conf['dir'] = "../uploads/pns/cads/PNsZip";
                $db = & JFactory::getDBO();
                $pns_id = JRequest::getVar('pns_id');
                $querypn = "SELECT p.ccs_code,p.ccs_code, p.pns_code, p.pns_revision FROM apdm_pns AS p  WHERE  p.pns_id =" . $pns_id;
                $db->setQuery($querypn);
                $pns = $db->loadObject();
//                $pns_code = $pns->pns_code;
//                if (substr($pns_code, -1) == "-") {
//                        $pns_code = substr($pns_code, 0, strlen($pns_code) - 1);
//                }
                if ($pns->pns_revision) {
                        $folder = $pns->ccs_code . '-' . $pns->pns_code . '-' . $pns->pns_revision;
                } else {
                        $folder = $pns->ccs_code . '-' . $pns->pns_code;
                }
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'cads' . DS . $pns->ccs_code . DS . $folder . DS;
                //getall images belong PN
                $query = "SELECT img.pns_id,img.image_file,p.pns_code,p.ccs_code,p.pns_revision FROM apdm_pns_image img inner join apdm_pns p on img.pns_id = p.pns_id WHERE p.pns_id=" . $pns_id;
                $db->setQuery($query);                
                $rows = $db->loadObjectList();
                $arrImgs = array();
                if (count($rows) > 0) {
                        foreach ($rows as $row) {
                                $arrImgs[] = $row->image_file;
                        }
                }                                                
                $zdir[] = $path_pns;

                $dirarray = array();
                $dirsize = 0;
                $zdirsize = 0;
                for ($i = 0; $i < count($zdir); $i++) {
                     
                        $ffile = $zdir[$i];
                        if (is_dir($ffile)) {
                                getdir($ffile);
                        } else {

                                if ($fsize = @filesize($ffile))
                                        $zdirsize+=$fsize;
                        }
                }

                $zdirsize+=$dirsize;

                for ($i = 0; $i < count($dirarray); $i++) {
                        echo  $dirarray[$i];        
                        $fName= substr(end(explode("\\", $dirarray[$i])),1);
                        if(in_array($fName, $arrImgs))                                
                        {
                                $zdir[] = $dirarray[$i];
                        }
                }

                if (!@is_dir($conf['dir'])) {
                        $res = @mkdir($conf['dir'], 0777);
                        if (!$res)
                                $txtout = "Cannot create dir !<br>";
                } else
                {
                        @chmod($conf['dir'], 0777);
                }

                if (!@is_dir($conf['dir'])) {
                        $res = @mkdir($conf['dir'], 0777);
                        if (!$res)
                                $txtout = "Cannot create dir !<br>";
                } else
                        @chmod($conf['dir'], 0777);

                $zipname = 'zipfile_' . $pns_code;
                $zipname = str_replace("/", "", $zipname);
                //if (empty($zipname)) $zipname="NDKzip";
                $zipname.=".zip";

                $ziper = new zipfile();
                $ziper->addFiles($zdir);
                $ziper->output("{$conf['dir']}/{$zipname}");

                if ($fsize = @filesize("{$conf['dir']}/{$zipname}"))
                        $zipsize = $fsize;
                else
                        $zipsize = 0;


                $zdirsize = PNsController::size_format($zdirsize);
                $zipsize = PNsController::size_format($zipsize);
                $archive_file_name = $conf['dir'] . '/' . $zipname;

                header("Content-type: application/zip");
                header("Content-Disposition: attachment; filename=$archive_file_name");
                header("Pragma: no-cache");
                header("Expires: 0");
                readfile("$archive_file_name");
                $this->setRedirect('index.php?option=com_apdmpns&task=specification&cid[]=' . $pns_id);
                exit;
        }
        function download_all_pdfs_pns() {
                global $dirarray, $conf, $dirsize;

                //$conf['dir'] = "zipfiles";
                $conf['dir'] = "../uploads/pns/cads/PNsZip";
                $db = & JFactory::getDBO();
                $pns_id = JRequest::getVar('pns_id');
                $querypn = "SELECT p.ccs_code,p.ccs_code, p.pns_code, p.pns_revision FROM apdm_pns AS p  WHERE  p.pns_id =" . $pns_id;
                $db->setQuery($querypn);
                $pns = $db->loadObject();
//                $pns_code = $pns->pns_code;
//                if (substr($pns_code, -1) == "-") {
//                        $pns_code = substr($pns_code, 0, strlen($pns_code) - 1);
//                }
                if ($pns->pns_revision) {
                        $folder = $pns->ccs_code . '-' . $pns->pns_code . '-' . $pns->pns_revision;
                } else {
                        $folder = $pns->ccs_code . '-' . $pns->pns_code;
                }
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'cads' . DS . $pns->ccs_code . DS . $folder . DS;
                //getall images belong PN
                $query = "SELECT pdf.pns_id,pdf.pdf_file,p.pns_code,p.ccs_code,p.pns_revision FROM apdm_pns_pdf pdf inner join apdm_pns p on pdf.pns_id = p.pns_id WHERE p.pns_id=" . $pns_id;
                $db->setQuery($query);                            
                $rows = $db->loadObjectList();
                $arrPdfs = array();
                if (count($rows) > 0) {
                        foreach ($rows as $row) {
                                $arrPdfs[] = $row->pdf_file;
                        }
                }                                                
                $zdir[] = $path_pns;

                $dirarray = array();
                $dirsize = 0;
                $zdirsize = 0;
                for ($i = 0; $i < count($zdir); $i++) {
                     
                        $ffile = $zdir[$i];
                        if (is_dir($ffile)) {
                                getdir($ffile);
                        } else {

                                if ($fsize = @filesize($ffile))
                                        $zdirsize+=$fsize;
                        }
                }

                $zdirsize+=$dirsize;

                for ($i = 0; $i < count($dirarray); $i++) {
                        echo  $dirarray[$i];        
                        $fName= substr(end(explode("\\", $dirarray[$i])),1);
                        if(in_array($fName, $arrPdfs))                                
                        {
                                $zdir[] = $dirarray[$i];
                        }
                }

                if (!@is_dir($conf['dir'])) {
                        $res = @mkdir($conf['dir'], 0777);
                        if (!$res)
                                $txtout = "Cannot create dir !<br>";
                } else
                {
                        @chmod($conf['dir'], 0777);
                }

                if (!@is_dir($conf['dir'])) {
                        $res = @mkdir($conf['dir'], 0777);
                        if (!$res)
                                $txtout = "Cannot create dir !<br>";
                } else
                        @chmod($conf['dir'], 0777);

                $zipname = 'zipfile_' . $pns_code;
                $zipname = str_replace("/", "", $zipname);
                //if (empty($zipname)) $zipname="NDKzip";
                $zipname.=".zip";

                $ziper = new zipfile();
                $ziper->addFiles($zdir);
                $ziper->output("{$conf['dir']}/{$zipname}");

                if ($fsize = @filesize("{$conf['dir']}/{$zipname}"))
                        $zipsize = $fsize;
                else
                        $zipsize = 0;


                $zdirsize = PNsController::size_format($zdirsize);
                $zipsize = PNsController::size_format($zipsize);
                $archive_file_name = $conf['dir'] . '/' . $zipname;

                header("Content-type: application/zip");
                header("Content-Disposition: attachment; filename=$archive_file_name");
                header("Pragma: no-cache");
                header("Expires: 0");
                readfile("$archive_file_name");
                $this->setRedirect('index.php?option=com_apdmpns&task=specification&cid[]=' . $pns_id);
                exit;
        }        
        function download_all_cads_pns() {
                global $dirarray, $conf, $dirsize;

                //$conf['dir'] = "zipfiles";
                $conf['dir'] = "../uploads/pns/cads/PNsZip";
                $db = & JFactory::getDBO();
                $pns_id = JRequest::getVar('pns_id');
                $querypn = "SELECT p.ccs_code,p.ccs_code, p.pns_code, p.pns_revision FROM apdm_pns AS p  WHERE  p.pns_id =" . $pns_id;
                $db->setQuery($querypn);
                $pns = $db->loadObject();
//                $pns_code = $pns->pns_code;
//                if (substr($pns_code, -1) == "-") {
//                        $pns_code = substr($pns_code, 0, strlen($pns_code) - 1);
//                }
                if ($pns->pns_revision) {
                        $folder = $pns->ccs_code . '-' . $pns->pns_code . '-' . $pns->pns_revision;
                } else {
                        $folder = $pns->ccs_code . '-' . $pns->pns_code;
                }
                $path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'cads' . DS . $pns->ccs_code . DS . $folder . DS;
                //getall images belong PN
                $query = "SELECT * FROM apdm_pn_cad WHERE pns_id=" . $pns_id;
                $db->setQuery($query);                            
                $rows = $db->loadObjectList();
                $arrCads = array();
                if (count($rows) > 0) {
                        foreach ($rows as $row) {
                                $arrCads[] = $row->cad_file;
                        }
                }           
                $zdir[] = $path_pns;

                $dirarray = array();
                $dirsize = 0;
                $zdirsize = 0;
                for ($i = 0; $i < count($zdir); $i++) {
                     
                        $ffile = $zdir[$i];
                        if (is_dir($ffile)) {
                                getdir($ffile);
                        } else {

                                if ($fsize = @filesize($ffile))
                                        $zdirsize+=$fsize;
                        }
                }

                $zdirsize+=$dirsize;

                for ($i = 0; $i < count($dirarray); $i++) {
                        echo  $dirarray[$i];        
                        $fName= substr(end(explode("\\", $dirarray[$i])),1);
                        if(in_array($fName, $arrCads))                                
                        {
                                $zdir[] = $dirarray[$i];
                        }
                }

                if (!@is_dir($conf['dir'])) {
                        $res = @mkdir($conf['dir'], 0777);
                        if (!$res)
                                $txtout = "Cannot create dir !<br>";
                } else
                {
                        @chmod($conf['dir'], 0777);
                }

                if (!@is_dir($conf['dir'])) {
                        $res = @mkdir($conf['dir'], 0777);
                        if (!$res)
                                $txtout = "Cannot create dir !<br>";
                } else
                        @chmod($conf['dir'], 0777);

                $zipname = 'zipfile_' . $folder;
                $zipname = str_replace("/", "", $zipname);
                //if (empty($zipname)) $zipname="NDKzip";
                $zipname.=".zip";

                $ziper = new zipfile();
                $ziper->addFiles($zdir);
                $ziper->output("{$conf['dir']}/{$zipname}");

                if ($fsize = @filesize("{$conf['dir']}/{$zipname}"))
                        $zipsize = $fsize;
                else
                        $zipsize = 0;


                $zdirsize = PNsController::size_format($zdirsize);
                $zipsize = PNsController::size_format($zipsize);
                $archive_file_name = $conf['dir'] . '/' . $zipname;

                header("Content-type: application/zip");
                header("Content-Disposition: attachment; filename=$archive_file_name");
                header("Pragma: no-cache");
                header("Expires: 0");
                readfile("$archive_file_name");
                $this->setRedirect('index.php?option=com_apdmpns&task=specification&cid[]=' . $pns_id);
                exit;
        }
        function po_prefix_default() {
                $db = & JFactory::getDBO();
                $query = "SELECT count(*)  FROM apdm_pns_po  WHERE  date(po_created) = CURDATE()";
                $db->setQuery($query);
                $pns_latest = $db->loadResult();
               
                $next_poprf_code = (int) $pns_latest;
                $next_poprf_code++;
                $number = strlen($next_poprf_code);
                switch ($number) {
                        case '1':
                                $new_poprf_code = '0' . $next_poprf_code;
                                break;
                        case '2':
                                $new_poprf_code = $next_poprf_code;
                                break;
                       
                        default:
                                $new_poprf_code = $next_poprf_code;
                                break;
                }
                echo $new_poprf_code;
                exit;
        }       
        function move_location()
        {
                JRequest::setVar('layout', 'add_stom');
                JRequest::setVar('view', 'stos');
                parent::display();    
        }
        function sto_detail_movelocation() {
                JRequest::setVar('layout', 'sto_detail_pns_movelocation');
                JRequest::setVar('view', 'stos');
                parent::display();
        }  
 /*
         * save stock for STO/PN
         */
        function saveqtyStofk_movelocation() {
                $db = & JFactory::getDBO();
                $cid = JRequest::getVar('cid', array(), '', 'array');
               
                $fkid = JRequest::getVar('id');               
                foreach ($cid as $pnsid) {
                        $obj = explode("_", $pnsid);
                        $pns=$obj[0];
                        $ids = explode(",",$obj[1]);                        
                        foreach ($ids as $id) {                                
                                $stock = JRequest::getVar('qty_'. $pns .'_' . $id);      
                                $location = JRequest::getVar('location_' . $pns .'_' . $id);                                         
                                //get sto_type
                                $db->setQuery("select fk.qty_from,fk.location_from,fk.id as id_from from  apdm_pns_sto_fk fk where fk.id =  ".$id);                               
                                $fkFrom= $db->loadObject();                                   
                                if($fkFrom->qty_from < $stock)//validate stock input
                                {                                       
                                        $msg = "The Destination Qty must less than Source Qty";
                                        return $this->setRedirect('index.php?option=com_apdmpns&task=sto_detail_movelocation&id=' . $fkid, $msg);                                       
                                }
                                if($stock && $location==0)
                                {
                                        $msg = "Must choose Destination Location and input Qty together";
                                        return $this->setRedirect('index.php?option=com_apdmpns&task=sto_detail_movelocation&id=' . $fkid, $msg);                                       
                                }
                                
                                $db->setQuery("update apdm_pns_sto_fk set qty=" . $stock . ", location='" . $location . "' WHERE  id = " . $id);                        
                                $db->query();
                                //updatestock from
                               // $db->setQuery("update apdm_pns_sto_fk set qty=" . $stock . ", location='" . $fkFrom->location_from . "' WHERE  id = " . $fkFrom->id_from);                        
                               // $db->query();
                        }
                }
                $msg = "Successfully Saved Part Number";
                $this->setRedirect('index.php?option=com_apdmpns&task=sto_detail_movelocation&id=' . $fkid, $msg);
        }                    
        /*
         * List SO
         */

        function somanagement() {            
                JRequest::setVar('layout', 'so_list');
                JRequest::setVar('view', 'so');
                parent::display();
        }    
        function add_so() {
                JRequest::setVar('layout', 'add_so');
                JRequest::setVar('view', 'so');                      
                parent::display();
        }   
        function add_wo() {
                JRequest::setVar('layout', 'add_wo');
                JRequest::setVar('view', 'wo');
                parent::display();
        } 
        /*
         * Asign template for get list child PNS  for PNS
         */

        function get_list_pns_so() {
                JRequest::setVar('layout', 'default');
                JRequest::setVar('view', 'getpnsso');
                parent::display();
        }   
        /**
         *
          funcntion get list PNs child for ajax request
         */
        function ajax_list_pns_so() {

                $db = & JFactory::getDBO();
                $cid = JRequest::getVar('cid', array(), '', 'array');
                $query = "select pns_id,pns_uom,pns_description, CONCAT_WS( '-', ccs_code, pns_code, pns_revision) AS pns_full_code,ccs_code, pns_code, pns_revision FROM apdm_pns WHERE pns_id IN (" . implode(",", $cid) . ")";
                $db->setQuery($query);
                $rows = $db->loadObjectList();
                $str = '<table class="admintable" cellspacing="1" width="60%"><tr>'.
                        '<td class="key">#</td>'.
                        '<td class="key">TOP ASSY PN</td>'.
                        '<td class="key">Description</td>'.
                        '<td class="key">Qty</td>'.
                        '<td class="key">UOM</td>'.
                        '<td class="key">Unit Price</td>'.
                        '<td class="key">F.A Required</td>'.
                        '<td class="key">ESD Required</td>'.
                        '<td class="key">COC Required</td><input type="hidden" name="boxcheckedpn" value="'.count($rows).'" /></tr>';                                                                  
                foreach ($rows as $row) {
                         if ($row->pns_revision) {
                                $pnNumber = $row->ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                        } else {
                                $pnNumber = $row->ccs_code . '-' . $row->pns_code;
                        }                        
                        $str .= '<tr>'.
                                ' <td><input checked="checked" type="checkbox" name="pns_child[]" value="' . $row->pns_id . '" /></td>'.
                                ' <td class="key">'.$pnNumber.'</td>'.
                                ' <td class="key">'.$row->pns_description.'</td>'.
                                ' <td class="key"><input style="width: 70px" onKeyPress="return numbersOnly(this, event);" type="text" value="" id="qty['.$row->pns_id.']"  name="qty['.$row->pns_id.']" /></td>'.
                                ' <td class="key">'.$row->pns_uom.'</td>'.
                                ' <td class="key"><input style="width: 70px" onKeyPress="return numbersOnlyEspecialFloat(this, event);" type="text" value="" id="price['.$row->pns_id.']"  name="price['.$row->pns_id.']" /></td>'.
                                ' <td class="key"><input checked="checked" type="checkbox" name="fa_required['.$row->pns_id.']" value="1" /> </td>'.
                                ' <td class="key"><input checked="checked" type="checkbox" name="esd_required['.$row->pns_id.']" value="1" /> </td>'.
                                ' <td class="key"><input checked="checked" type="checkbox" name="coc_required['.$row->pns_id.']" value="1" /> </td>';
                }
                $str .='</table>';
                echo $str;
                exit;
        }      
        function check_so_exist()
        {
                 $db = & JFactory::getDBO();
                $so_code= JRequest::getVar('so_code');       
                $customer_id  = JRequest::getVar('customer_id');     
                 //check so exist or not
                $db->setQuery('select count(*) from apdm_pns_so where  so_cuscode = "'.$so_code.'" and customer_id= "' .$customer_id.'"');               
                $check_so_exist = $db->loadResult();
                if ($check_so_exist!=0) { 
                        echo 1;
                        exit;
                }
                echo 0;
                exit;
                
        }
        function save_sales_order()
        {
                // Initialize some variables
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                //$row = & JTable::getInstance('apdmpnso');
                $datenow = & JFactory::getDate();
                $post = JRequest::get('post');                        
                $startdate = new DateTime($post['so_start_date']);
                $shipping_date = new DateTime($post['so_shipping_date']);
                $so_start_date = $startdate->format('Y-m-d'); 
                $so_shipping_date = $shipping_date->format('Y-m-d'); 
                $soNumber = $post['so_cuscode'];
                //check so exist or not
                $db->setQuery('select count(*) from apdm_pns_so where  so_cuscode = "'.$soNumber.'" and customer_id= "' .$post['customer_id'].'"');               
                $check_so_exist = $db->loadResult();
                if ($check_so_exist!=0) {
                        $msg = JText::_('The SO already exist please add another SO number');
                         return $this->setRedirect('index.php?option=com_apdmpns&task=add_so', $msg);

                }
                $db->setQuery("INSERT INTO apdm_pns_so (customer_id,so_coordinator,so_cuscode,so_shipping_date,so_start_date,so_state,so_created,so_created_by,so_updated,so_updated_by,so_type) VALUES ('" . $post['customer_id'] . "', '" . $post['so_coordinator'] . "', '" . $post['so_cuscode'] . "', '" . $so_shipping_date . "', '" . $so_start_date . "', '" .  $post['so_state']. "','" . $datenow->toMySQL() . "', " . $me->get('id') . ",'" . $datenow->toMySQL() . "', " . $me->get('id') . ",0)");
                $db->query();     
                //getLast SO ID
                $so_id = $db->insertid();
                if($so_id)
                {
                        $listPns = $post['pns_child'];
                        //insert to PN ASYY
                        if($listPns)
                        {
                                foreach($listPns as $pnId)
                                {
                                      $db->setQuery("INSERT INTO apdm_pns_so_fk (pns_id,so_id,qty,price,fa_required,esd_required,coc_required) VALUES ('" . $pnId . "', '" . $so_id . "', '" . $post['qty'][$pnId] . "', '" . $post['price'][$pnId]  . "', '" . $post['fa_required'][$pnId] . "', '" .  $post['esd_required'][$pnId]. "','" . $post['coc_required'][$pnId]. "') on duplicate key update qty = '". $post['qty'][$pnId]."',price='".$post['price'][$pnId]."' ");
                                      $db->getQuery();
                                      $db->query();                                   
                                }                                
                        }
                        $path_upload = JPATH_SITE . DS . 'uploads' . DS . 'so' . DS;
                        $folder = $so_id."-".$post['so_cuscode'];

                        $path_so_zips = $path_upload  .DS. $folder . DS .'zips'. DS;
                        $upload = new upload($_FILES['']);
                        $upload->r_mkdir($path_so_zips, 0777);                        
                        $arr_file_upload = array();
                        $arr_error_upload_zips = array();
                        for ($i = 1; $i <= 20; $i++) {                                
                                if ($_FILES['pns_zip' . $i]['size'] > 0) {
                                        if (!move_uploaded_file($_FILES['pns_zip' . $i]['tmp_name'], $path_so_zips . $_FILES['pns_zip' . $i]['name'])) {
                                                $arr_error_upload_zips[] = $_FILES['pns_zip' . $i]['name'];
                                        } else {
                                                $arr_file_upload[] = $_FILES['pns_zip' . $i]['name'];
                                        }
                                }
                        }

                        if (count($arr_file_upload) > 0) {
                                foreach ($arr_file_upload as $file) {
                                        $db->setQuery("INSERT INTO apdm_pn_cad (so_id, cad_file, date_create, created_by) VALUES (" . $so_id . ", '" . $file . "', '" . $datenow->toMySQL() . "', " . $me->get('id') . " ) ");
                                        $db->query();
                                }
                        }
                        //for upload file image
                        ///for pns cads/image/pdf
                       //upload new images
                        $path_so_images = $path_upload  .DS. $folder . DS .'images'. DS;
                        $upload = new upload($_FILES['']);
                        $upload->r_mkdir($path_so_images, 0777);
                        $arr_error_upload_image = array();
                        $arr_image_upload = array();
                        for ($i = 1; $i <= 20; $i++) {
                                if ($_FILES['pns_image' . $i]['size'] > 0) {
                                        $imge = new upload($_FILES['pns_image' . $i]);
                                        $imge->file_new_name_body = $soNumber . "_" . time()."_".$i;    
                                        if (file_exists($path_so_images . $imge->file_new_name_body . "." . $imge->file_src_name_ext)) {

                                                @unlink($path_so_images .  $imge->file_new_name_body . "." . $imge->file_src_name_ext);
                                        }
                                        if ($imge->uploaded) {
                                                $imge->Process($path_so_images);
                                                if ($imge->processed) {
                                                        $arr_image_upload[] = $imge->file_dst_name;
                                                } else {
                                                        $arr_error_upload_image[] = $_FILES['pns_imge' . $i]['name'];
                                                }
                                        }
                                }
                        }
                        if (count($arr_image_upload) > 0) {
                                foreach ($arr_image_upload as $file) {
                                        $db->setQuery("INSERT INTO apdm_pns_image (so_id,image_file,date_created,created_by) VALUES (" . $so_id . ", '" . $file . "', '" . $datenow->toMySQL() . "', " . $me->get('id') . " ) ");
                                        $db->query();
                                }
                        }        

                        //upload new pdf
                        $path_so_pdfs = $path_upload  .DS. $folder . DS .'pdfs'. DS;
                        $upload = new upload($_FILES['']);
                        $upload->r_mkdir($path_so_pdfs, 0777);
                        $arr_error_upload_pdf = array();
                        $arr_pdf_upload = array();
                        for ($i = 1; $i <= 20; $i++) {
                                if ($_FILES['pns_pdf' . $i]['size'] > 0) {
                                        $imge = new upload($_FILES['pns_pdf' . $i]);
                                        $imge->file_new_name_body = $soNumber . "_" . time()."_".$i;                                       

                                        if (file_exists($path_so_pdfs . $imge->file_new_name_body . "." . $imge->file_src_name_ext)) {

                                                @unlink($path_so_pdfs . $imge->file_new_name_body . "." . $imge->file_src_name_ext);
                                        }
                                        if ($imge->uploaded) {
                                                $imge->Process($path_so_pdfs);
                                                if ($imge->processed) {
                                                        $arr_pdf_upload[] = $imge->file_dst_name;
                                                } else {
                                                        $arr_error_upload_pdf[] = $_FILES['pns_pdf' . $i]['name'];
                                                }
                                        }
                                }
                        }
                        if (count($arr_pdf_upload) > 0) {
                                foreach ($arr_pdf_upload as $file) {
                                        $db->setQuery("INSERT INTO apdm_pns_pdf (so_id,pdf_file,date_created,created_by) VALUES (" . $so_id . ", '" . $file . "', '" . $datenow->toMySQL() . "', " . $me->get('id') . " ) ");
                                        $db->query();
                                }
                        }                        
                        
                     
                }//for save database of pns 
               
                $msg = JText::_('Successfully Saved So');
                return $this->setRedirect('index.php?option=com_apdmpns&task=so_detail&id=' . $so_id, $msg);
                               
        }
        function so_detail()
        {
                JRequest::setVar('layout', 'so_detail');
                JRequest::setVar('view', 'so');
                 parent::display();
        }
        function getCcsDescription($ccs_code)
	{
		$db =& JFactory::getDBO();               
                $ccs_description = "";
                $query = " SELECT ccs_description FROM apdm_ccs WHERE ccs_code='".$ccs_code."'";
		$db->setQuery($query);
		return $db->loadResult();
                
	}    
         function getCcsName($ccs_code)
	{
		$db =& JFactory::getDBO();               
                $ccs_description = "";
                $query = " SELECT ccs_name FROM apdm_ccs WHERE ccs_code='".$ccs_code."'";
		$db->setQuery($query);
		return $db->loadResult();
                
	} 
        /*
         * Remove SO
         */
        function deleteso() {
                $db = & JFactory::getDBO();                
                $so_id = JRequest::getVar('so_id');
                $db->setQuery("DELETE FROM apdm_pns_so WHERE pns_so_id = '" . $so_id . "'");
                $db->query();                    
                $db->setQuery("DELETE FROM apdm_pns_so_fk WHERE so_id = '" . $so_id . "'");
                $db->query();                    
                $msg = JText::_('Have removed successfull.');
                return $this->setRedirect('index.php?option=com_apdmpns&task=somanagement', $msg);
        }       
                /*
         * Remove SO
         */
  
        function ajax_deleteso()
        {
                $db = & JFactory::getDBO();
                $so_id = JRequest::getVar('so_id');
                $password =  JRequest::getVar('passwd', '', 'post', 'string', JREQUEST_ALLOWRAW);
                $username = JRequest::getVar('username', '', 'method', 'username');
                $query = "select count(*) from apdm_users where user_password = md5('".$password."') and username='".$username."'";
                $db->setQuery($query);
                $isLogin = $db->loadResult();
                if($isLogin)
                {
                        $db->setQuery("DELETE FROM apdm_pns_so WHERE pns_so_id = '" . $so_id . "'");
                        $db->query();                    
                        $db->setQuery("DELETE FROM apdm_pns_so_fk WHERE so_id = '" . $so_id . "'");
                        $db->query();     
                        echo 1;
                }
                else
                {
                        echo 0;
                }
                die;
                
        }
        function editso()
        {
                JRequest::setVar('layout', 'edit_so');
                JRequest::setVar('view', 'so');
                JRequest::setVar('edit', true);
                parent::display();
        }
/**
         * @desc Read file size
         */
        function readfilesizeSo($folder_so, $filename,$type) {
                $path_so = JPATH_SITE . DS . 'uploads' . DS . 'so' . DS;
                $filesize = '';               
                $path_so .= $folder_so . DS . $type . DS;
                if (file_exists($path_so . $filename)) {
                        $filesize = ceil(filesize($path_so . $filename) / 1000);
                } else {
                        $filesize = 0;
                }
                return $filesize;
        }      
        /**
         * @desc Read file size
         */
        function readfilesizeWoLog($folder_wo_id, $filename,$type=0) {
                $path_wo = JPATH_SITE . DS . 'uploads' . DS . 'wo' . DS;
                $filesize = '';               
                $path_wo .=  $folder_wo_id . DS;                 
                if (file_exists($path_wo . $filename)) {
                        $filesize = ceil(filesize($path_wo . $filename) / 1000);
                } else {
                        $filesize = 0;
                }
                return $filesize;
        }    
        /**
         * @desc Download imge of PNs
         */
        function download_img_so() {
                $db = & JFactory::getDBO();
                $so_id = JRequest::getVar('so_id');
                $image_id = JRequest::getVar('id');
                $query = "SELECT img.so_id,img.image_file,p.pns_so_id,p.so_cuscode FROM apdm_pns_image img inner join apdm_pns_so p on img.so_id = p.pns_so_id WHERE pns_image_id=" . $image_id;
                $db->setQuery($query);
                $row = $db->loadObject();                
                ///for pns cads/image/pdf              
                $folder = $row->pns_so_id . '-' . $row->so_cuscode;                
                $path_so = JPATH_SITE . DS . 'uploads' . DS . 'so' . DS;
                $path_images = $path_so  . DS . $folder . DS . 'images' . DS;                                                   
                $file_name = $row->image_file;
                $dFile = new DownloadFile($path_images, $file_name);
                exit;
        }        
      
/**
         * @desc Download imge of PNs
         */
        function download_pdfs_so() {
                $db = & JFactory::getDBO();
                $so_id = JRequest::getVar('so_id');
                $image_id = JRequest::getVar('id');
                $query = "SELECT pdf.pns_id,pdf.pdf_file,p.pns_so_id,p.so_cuscode FROM apdm_pns_pdf pdf inner join apdm_pns_so p on pdf.so_id = p.pns_so_id WHERE pns_pdf_id=" . $image_id;
                $db->setQuery($query);
                $row = $db->loadObject();                
               ///for pns cads/image/pdf              
                $folder = $row->pns_so_id . '-' . $row->so_cuscode;                
                $path_so = JPATH_SITE . DS . 'uploads' . DS . 'so' . DS;
                $path_pdfs = $path_so  . DS . $folder . DS . 'pdfs' . DS;                          
                $file_name = $row->pdf_file;
                //$path_pns = $path_cads;
                $dFile = new DownloadFile($path_pdfs, $file_name);
                exit;
        }        
  /**
         * @desc Download cad file of PNs
         */
        function download_zip_so() {
                $db = & JFactory::getDBO();
                $zip_id = JRequest::getVar('id');
                $query = "SELECT zip.cad_file,p.pns_so_id,p.so_cuscode FROM apdm_pn_cad zip inner join apdm_pns_so p on zip.so_id = p.pns_so_id WHERE pns_cad_id=" . $zip_id;
                $db->setQuery($query);
                $row = $db->loadObject();    
                ///for pns cads/image/pdf              
                $folder = $row->pns_so_id . '-' . $row->so_cuscode;                
                $path_so = JPATH_SITE . DS . 'uploads' . DS . 'so' . DS;
                $path_cads = $path_so  . DS . $folder . DS . 'zips' . DS;                          
                $file_name = $row->cad_file; 
                $dFile = new DownloadFile($path_cads, $file_name);
                exit;
        }       
/**
         * @desc Download cad file of PNs
         */
        function download_file_wo_log() {
                $db = & JFactory::getDBO();
                $file_id = JRequest::getVar('id');
                $query = "SELECT * from apdm_pns_wo_files WHERE id=" . $file_id;
                $db->setQuery($query);
                $row = $db->loadObject();    
                ///for pns cads/image/pdf              
                $folder = $row->wo_id;                
                $path_so = JPATH_SITE . DS . 'uploads' . DS . 'wo' . DS;
                $path_cads = $path_so  . DS . $folder . DS;                          
                $file_name = $row->file_name; 
                $dFile = new DownloadFile($path_cads, $file_name);
                exit;
        }            
        function so_detail_support_doc()
        {
                JRequest::setVar('layout', 'so_detail_doc');
                JRequest::setVar('view', 'so');
                 parent::display();
        }
        function save_doc_so()
        {
                global $mainframe;
                // Initialize some variables
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                $row = & JTable::getInstance('apdmpns');
                $datenow = & JFactory::getDate();                
                $so_id = JRequest::getVar('so_id');       
                
                //get so info
                $db->setQuery("SELECT * from apdm_pns_so where pns_so_id=".$so_id);
                $so_row =  $db->loadObject();                
                $soNumber = $so_row->so_cuscode;
                //Save upload new                
                $path_upload = JPATH_SITE . DS . 'uploads' . DS . 'so' ;
                $folder = $so_id."-".$so_row->so_cuscode;

                $path_so_zips = $path_upload  .DS. $folder . DS .'zips'. DS;
                $upload = new upload($_FILES['']);
                $upload->r_mkdir($path_so_zips, 0777);                        
                $arr_file_upload = array();
                $arr_error_upload_zips = array();
                for ($i = 1; $i <= 20; $i++) {					
                        if ($_FILES['pns_zip' . $i]['size'] > 0) {
								if($_FILES['pns_zip' . $i]['size']<20000000)
								{
									if (!move_uploaded_file($_FILES['pns_zip' . $i]['tmp_name'], $path_so_zips . $_FILES['pns_zip' . $i]['name'])) {
											$arr_error_upload_zips[] = $_FILES['pns_zip' . $i]['name'];
									} else {
											$arr_file_upload[] = $_FILES['pns_zip' . $i]['name'];
									}
								}
								else
								{        
									$msg = JText::_('Please upload file ZIP less than 20MB.');
								        return $this->setRedirect('index.php?option=com_apdmpns&task=so_detail_support_doc&id='.$so_id, $msg);    
								}
                        }
                        
                }
                if (count($arr_file_upload) > 0) {
                        foreach ($arr_file_upload as $file) {
                                $db->setQuery("INSERT INTO apdm_pn_cad (so_id, cad_file, date_create, created_by) VALUES (" . $so_id . ", '" . $file . "', '" . $datenow->toMySQL() . "', " . $me->get('id') . " ) ");
                                $db->query();
                        }
                }
               //upload new images
                $path_so_images = $path_upload  .DS. $folder . DS .'images'. DS;
                $upload = new upload($_FILES['']);
                $upload->r_mkdir($path_so_images, 0777);
                $arr_error_upload_image = array();
                $arr_image_upload = array();
                for ($i = 1; $i <= 20; $i++) {
                        if ($_FILES['pns_image' . $i]['size'] > 0) {
                                $imge = new upload($_FILES['pns_image' . $i]);
                                $imge->file_new_name_body = $soNumber . "_" . time()."_".$i;    
                                if (file_exists($path_so_images . $imge->file_new_name_body . "." . $imge->file_src_name_ext)) {

                                        @unlink($path_so_images .  $imge->file_new_name_body . "." . $imge->file_src_name_ext);
                                }
                                if ($imge->uploaded) {
                                        $imge->Process($path_so_images);
                                        if ($imge->processed) {
                                                $arr_image_upload[] = $imge->file_dst_name;
                                        } else {
                                                $arr_error_upload_image[] = $_FILES['pns_imge' . $i]['name'];
                                        }
                                }
                        }
                }
                if (count($arr_image_upload) > 0) {
                        foreach ($arr_image_upload as $file) {
                                $db->setQuery("INSERT INTO apdm_pns_image (so_id,image_file,date_created,created_by) VALUES (" . $so_id . ", '" . $file . "', '" . $datenow->toMySQL() . "', " . $me->get('id') . " ) ");
                                $db->query();
                        }
                }        

                //upload new pdf
                $path_so_pdfs = $path_upload  .DS. $folder . DS .'pdfs'. DS;
                $upload = new upload($_FILES['']);
                $upload->r_mkdir($path_so_pdfs, 0777);
                $arr_error_upload_pdf = array();
                $arr_pdf_upload = array();
                for ($i = 1; $i <= 20; $i++) {
                        if ($_FILES['pns_pdf' . $i]['size'] > 0) {
								if($_FILES['pns_pdf' . $i]['size']<20000000)
								{
									$imge = new upload($_FILES['pns_pdf' . $i]);
									$imge->file_new_name_body = $soNumber . "_" . time()."_".$i;                                       

									if (file_exists($path_so_pdfs . $imge->file_new_name_body . "." . $imge->file_src_name_ext)) {

											@unlink($path_so_pdfs . $imge->file_new_name_body . "." . $imge->file_src_name_ext);
									}
									if ($imge->uploaded) {
											$imge->Process($path_so_pdfs);
											if ($imge->processed) {
													$arr_pdf_upload[] = $imge->file_dst_name;
											} else {
													$arr_error_upload_pdf[] = $_FILES['pns_pdf' . $i]['name'];
											}
									}
								}
								else
								{
										$msg = JText::_('Please upload file PDF less than 20MB.');
										return $this->setRedirect('index.php?option=com_apdmpns&task=so_detail_support_doc&id='.$so_id, $msg);         
								}
                        }
                        
                }
                if (count($arr_pdf_upload) > 0) {
                        foreach ($arr_pdf_upload as $file) {
                                $db->setQuery("INSERT INTO apdm_pns_pdf (so_id,pdf_file,date_created,created_by) VALUES (" . $so_id . ", '" . $file . "', '" . $datenow->toMySQL() . "', " . $me->get('id') . " ) ");
                                $db->query();
                        }
                }     
                $msg = JText::_('Successfully Saved So Supporting Doc');
                $return = JRequest::getVar('return');
               
                if ($return) {
                       return $this->setRedirect('index.php?option=com_apdmpns&task=so_detail_support_doc&id='.$so_id, $msg);
                } else {
                       return $this->setRedirect('index.php?option=com_apdmpns&task=so_detail&id=' . $so_id, $msg);
                }                
                                        
        }
        function download_all_images_so() {
                global $dirarray, $conf, $dirsize;

                //$conf['dir'] = "zipfiles";
                $conf['dir'] = "../uploads/pns/cads/PNsZip";
                $db = & JFactory::getDBO();
                $so_id = JRequest::getVar('so_id');
                $db->setQuery("SELECT * from apdm_pns_so where pns_so_id=".$so_id);
                $so_row =  $db->loadObject();                
                $soNumber = $so_row->so_cuscode;
                //Save upload new                
                $path_upload = JPATH_SITE . DS . 'uploads' . DS . 'so' ;
                $folder = $so_id."-".$so_row->so_cuscode;
                $path_so_images = $path_upload  .DS. $folder . DS .'images'. DS;                
                               
                //getall images belong PN
                
                $query = "SELECT img.so_id,img.image_file,p.pns_so_id,p.so_cuscode FROM apdm_pns_image img inner join apdm_pns_so p on img.so_id = p.pns_so_id WHERE img.so_id=" . $so_id;                
                $db->setQuery($query);                
                $rows = $db->loadObjectList();
                $arrImgs = array();
                if (count($rows) > 0) {
                        foreach ($rows as $row) {
                                $arrImgs[] = $row->image_file;
                        }
                }                                                
                $zdir[] = $path_so_images;

                $dirarray = array();
                $dirsize = 0;
                $zdirsize = 0;
                for ($i = 0; $i < count($zdir); $i++) {
                     
                        $ffile = $zdir[$i];
                        if (is_dir($ffile)) {
                                getdir($ffile);
                        } else {

                                if ($fsize = @filesize($ffile))
                                        $zdirsize+=$fsize;
                        }
                }

                $zdirsize+=$dirsize;

                for ($i = 0; $i < count($dirarray); $i++) {
                        echo  $dirarray[$i];        
                        $fName= substr(end(explode("\\", $dirarray[$i])),1);
                        if(in_array($fName, $arrImgs))                                
                        {
                                $zdir[] = $dirarray[$i];
                        }
                }

                if (!@is_dir($conf['dir'])) {
                        $res = @mkdir($conf['dir'], 0777);
                        if (!$res)
                                $txtout = "Cannot create dir !<br>";
                } else
                {
                        @chmod($conf['dir'], 0777);
                }

                if (!@is_dir($conf['dir'])) {
                        $res = @mkdir($conf['dir'], 0777);
                        if (!$res)
                                $txtout = "Cannot create dir !<br>";
                } else
                        @chmod($conf['dir'], 0777);

                $zipname = 'zipfile_' . $soNumber;
                $zipname = str_replace("/", "", $zipname);
                //if (empty($zipname)) $zipname="NDKzip";
                $zipname.=".zip";

                $ziper = new zipfile();
                $ziper->addFiles($zdir);
                $ziper->output("{$conf['dir']}/{$zipname}");

                if ($fsize = @filesize("{$conf['dir']}/{$zipname}"))
                        $zipsize = $fsize;
                else
                        $zipsize = 0;


                $zdirsize = PNsController::size_format($zdirsize);
                $zipsize = PNsController::size_format($zipsize);
                $archive_file_name = $conf['dir'] . '/' . $zipname;

                header("Content-type: application/zip");
                header("Content-Disposition: attachment; filename=$archive_file_name");
                header("Pragma: no-cache");
                header("Expires: 0");
                readfile("$archive_file_name");
                $this->setRedirect('index.php?option=com_apdmpns&task=so_detail_support_doc&id=' . $so_id);
                exit;
        }                
        function download_all_pdfs_so() {
                global $dirarray, $conf, $dirsize;

                //$conf['dir'] = "zipfiles";
                $conf['dir'] = "../uploads/pns/cads/PNsZip";
                $db = & JFactory::getDBO();
                $so_id = JRequest::getVar('so_id');
                $db->setQuery("SELECT * from apdm_pns_so where pns_so_id=".$so_id);
                $so_row =  $db->loadObject();                
                $soNumber = $so_row->so_cuscode;
                //Save upload new                
                $path_upload = JPATH_SITE . DS . 'uploads' . DS . 'so' ;
                $folder = $so_id."-".$so_row->so_cuscode;
                $path_so_images = $path_upload  .DS. $folder . DS .'pdfs'. DS;                
                               
                //getall images belong PN
                $query = "SELECT pdf.pns_id,pdf.pdf_file,p.pns_so_id,p.so_cuscode FROM apdm_pns_pdf pdf inner join apdm_pns_so p on pdf.so_id = p.pns_so_id WHERE pdf.so_id =" . $so_id;
                $db->setQuery($query);
                $rows = $db->loadObjectList();                 
                $arrImgs = array();
                if (count($rows) > 0) {
                        foreach ($rows as $row) {
                                $arrImgs[] = $row->pdf_file;
                        }
                }                                                
                $zdir[] = $path_so_images;

                $dirarray = array();
                $dirsize = 0;
                $zdirsize = 0;
                for ($i = 0; $i < count($zdir); $i++) {
                     
                        $ffile = $zdir[$i];
                        if (is_dir($ffile)) {
                                getdir($ffile);
                        } else {

                                if ($fsize = @filesize($ffile))
                                        $zdirsize+=$fsize;
                        }
                }

                $zdirsize+=$dirsize;

                for ($i = 0; $i < count($dirarray); $i++) {
                        echo  $dirarray[$i];        
                        $fName= substr(end(explode("\\", $dirarray[$i])),1);
                        if(in_array($fName, $arrImgs))                                
                        {
                                $zdir[] = $dirarray[$i];
                        }
                }

                if (!@is_dir($conf['dir'])) {
                        $res = @mkdir($conf['dir'], 0777);
                        if (!$res)
                                $txtout = "Cannot create dir !<br>";
                } else
                {
                        @chmod($conf['dir'], 0777);
                }

                if (!@is_dir($conf['dir'])) {
                        $res = @mkdir($conf['dir'], 0777);
                        if (!$res)
                                $txtout = "Cannot create dir !<br>";
                } else
                        @chmod($conf['dir'], 0777);

                $zipname = 'zipfile_' . $soNumber;
                $zipname = str_replace("/", "", $zipname);
                //if (empty($zipname)) $zipname="NDKzip";
                $zipname.=".zip";

                $ziper = new zipfile();
                $ziper->addFiles($zdir);
                $ziper->output("{$conf['dir']}/{$zipname}");

                if ($fsize = @filesize("{$conf['dir']}/{$zipname}"))
                        $zipsize = $fsize;
                else
                        $zipsize = 0;


                $zdirsize = PNsController::size_format($zdirsize);
                $zipsize = PNsController::size_format($zipsize);
                $archive_file_name = $conf['dir'] . '/' . $zipname;

                header("Content-type: application/zip");
                header("Content-Disposition: attachment; filename=$archive_file_name");
                header("Pragma: no-cache");
                header("Expires: 0");
                readfile("$archive_file_name");
                $this->setRedirect('index.php?option=com_apdmpns&task=so_detail_support_doc&id=' . $so_id);
                exit;
        }                
        
        function download_all_cads_so() {
                global $dirarray, $conf, $dirsize;

                //$conf['dir'] = "zipfiles";
                $conf['dir'] = "../uploads/pns/cads/PNsZip";
                $db = & JFactory::getDBO();
                $so_id = JRequest::getVar('so_id');
                $db->setQuery("SELECT * from apdm_pns_so where pns_so_id=".$so_id);
                $so_row =  $db->loadObject();                
                $soNumber = $so_row->so_cuscode;
                //Save upload new                
                $path_upload = JPATH_SITE . DS . 'uploads' . DS . 'so' ;
                $folder = $so_id."-".$so_row->so_cuscode;
                $path_so_images = $path_upload  .DS. $folder . DS .'zips'. DS;                
                               
                //getall images belong PN
                $query = "SELECT zip.cad_file,p.pns_so_id,p.so_cuscode FROM apdm_pn_cad zip inner join apdm_pns_so p on zip.so_id = p.pns_so_id WHERE zip.so_id =" . $so_id;
                $db->setQuery($query);
                $rows = $db->loadObjectList();                                                
                $arrImgs = array();
                if (count($rows) > 0) {
                        foreach ($rows as $row) {
                                $arrImgs[] = $row->cad_file;
                        }
                }                                                
                $zdir[] = $path_so_images;
                $dirarray = array();
                $dirsize = 0;
                $zdirsize = 0;
                for ($i = 0; $i < count($zdir); $i++) {
                     
                        $ffile = $zdir[$i];
                        if (is_dir($ffile)) {
                                getdir($ffile);
                        } else {

                                if ($fsize = @filesize($ffile))
                                        $zdirsize+=$fsize;
                        }
                }

                $zdirsize+=$dirsize;

                for ($i = 0; $i < count($dirarray); $i++) {
                        echo  $dirarray[$i];        
                        $fName= substr(end(explode("\\", $dirarray[$i])),1);
                        if(in_array($fName, $arrImgs))                                
                        {
                                $zdir[] = $dirarray[$i];
                        }
                }

                if (!@is_dir($conf['dir'])) {
                        $res = @mkdir($conf['dir'], 0777);
                        if (!$res)
                                $txtout = "Cannot create dir !<br>";
                } else
                {
                        @chmod($conf['dir'], 0777);
                }

                if (!@is_dir($conf['dir'])) {
                        $res = @mkdir($conf['dir'], 0777);
                        if (!$res)
                                $txtout = "Cannot create dir !<br>";
                } else
                        @chmod($conf['dir'], 0777);

                $zipname = 'zipfile_' . $soNumber;
                $zipname = str_replace("/", "", $zipname);
                //if (empty($zipname)) $zipname="NDKzip";
                $zipname.=".zip";

                $ziper = new zipfile();
                $ziper->addFiles($zdir);
                $ziper->output("{$conf['dir']}/{$zipname}");

                if ($fsize = @filesize("{$conf['dir']}/{$zipname}"))
                        $zipsize = $fsize;
                else
                        $zipsize = 0;


                $zdirsize = PNsController::size_format($zdirsize);
                $zipsize = PNsController::size_format($zipsize);
                $archive_file_name = $conf['dir'] . '/' . $zipname;

                header("Content-type: application/zip");
                header("Content-Disposition: attachment; filename=$archive_file_name");
                header("Pragma: no-cache");
                header("Expires: 0");
                readfile("$archive_file_name");
                $this->setRedirect('index.php?option=com_apdmpns&task=so_detail_support_doc&id=' . $so_id);
                exit;
        }         
/**
         * @desc  Remove file cads
         */
        function remove_imgs_so() {
                $db = & JFactory::getDBO();
                $id = JRequest::getVar('id');
                $so_id = JRequest::getVar('so_id');
                //unlink first
                //get name file cad
                $query = "SELECT img.so_id,img.image_file,p.pns_so_id,p.so_cuscode FROM apdm_pns_image img inner join apdm_pns_so p on img.so_id = p.pns_so_id WHERE img.pns_image_id=" . $id;
                $db->setQuery($query);
                $row = $db->loadObject();                 
                $path_upload = JPATH_SITE . DS . 'uploads' . DS . 'so' ;
                $folder = $row->so_id."-".$row->so_cuscode;
                $path_so_images = $path_upload  .DS. $folder . DS .'images'. DS;                                 
                $file_name = $row->image_file;
                //get folder file cad          
                $handle = new upload($path_so_images . $file_name);
                $handle->file_dst_pathname = $path_so_images . $file_name;
                $handle->clean();                               
                
                $db->setQuery("DELETE FROM apdm_pns_image WHERE pns_image_id=" . $id);
                $db->query();
                $msg = JText::_('Have successfuly delete image file');
                $this->setRedirect('index.php?option=com_apdmpns&task=so_detail_support_doc&id=' . $so_id, $msg);
        }              
 /**
         * @desc  Remove file cads
         */
        function remove_pdfs_so() {
                $db = & JFactory::getDBO();
                $id = JRequest::getVar('id');
                $so_id = JRequest::getVar('so_id');
                $query = "SELECT pdf.so_id,pdf.pdf_file,p.pns_so_id,p.so_cuscode FROM apdm_pns_pdf pdf inner join apdm_pns_so p on pdf.so_id = p.pns_so_id WHERE pdf.pns_pdf_id=" . $id;
                $db->setQuery($query);
                $row = $db->loadObject();
                $path_upload = JPATH_SITE . DS . 'uploads' . DS . 'so' ;
                $folder = $row->so_id."-".$row->so_cuscode;
                $path_so_images = $path_upload  .DS. $folder . DS .'pdfs'. DS;                                 
                $file_name = $row->pdf_file;
                //get folder file cad          
                $handle = new upload($path_so_images . $file_name);
                $handle->file_dst_pathname = $path_so_images . $file_name;
                $handle->clean();                                                     
                $db->setQuery("DELETE FROM apdm_pns_pdf WHERE pns_pdf_id=" . $id);
                $db->query();
                $msg = JText::_('Have successfuly delete pdf file');
                $this->setRedirect('index.php?option=com_apdmpns&task=so_detail_support_doc&id=' . $so_id, $msg);
        }        
        /**
         * @desc  Remove file cads
         */
        function remove_zip_so() {
                $db = & JFactory::getDBO();
                $id = JRequest::getVar('id');
                $so_id = JRequest::getVar('so_id');           
                $query = "SELECT zip.so_id,zip.cad_file,p.pns_so_id,p.so_cuscode FROM apdm_pn_cad zip inner join apdm_pns_so p on zip.so_id = p.pns_so_id WHERE zip.pns_cad_id =" . $id;
                $db->setQuery($query);
                $row = $db->loadObject(); 
                $path_upload = JPATH_SITE . DS . 'uploads' . DS . 'so' ;
                $folder = $row->so_id."-".$row->so_cuscode;
                $path_so_images = $path_upload  .DS. $folder . DS .'zips'. DS;                                 
                $file_name = $row->cad_file;
                //get folder file cad          
                $handle = new upload($path_so_images . $file_name);
                $handle->file_dst_pathname = $path_so_images . $file_name;
                $handle->clean();                     
                
                $db->setQuery("DELETE FROM apdm_pn_cad WHERE pns_cad_id=" . $id);
                $db->query();
                $msg = JText::_('Have successfuly delete zip file');
                $this->setRedirect('index.php?option=com_apdmpns&task=so_detail_support_doc&id=' . $so_id, $msg);
        }      
 /**
         * @desc  Remove file cads
         */
        function remove_file_wo_log() {
                $db = & JFactory::getDBO();
                $id = JRequest::getVar('id');
                $wo_id = JRequest::getVar('woid');           
                $query = "SELECT * from apdm_pns_wo_files WHERE id =" . $id;
                $db->setQuery($query);
                $row = $db->loadObject(); 
                $path_upload = JPATH_SITE . DS . 'uploads' . DS . 'wo' ;
                $folder = $row->wo_id;
                $path_so_images = $path_upload  .DS. $folder . DS;                                 
                $file_name = $row->file_name;
                //get folder file cad          
                $handle = new upload($path_so_images . $file_name);
                $handle->file_dst_pathname = $path_so_images . $file_name;
                $handle->clean();                     
                
                $db->setQuery("DELETE FROM apdm_pns_wo_files WHERE id=" . $id);
                $db->query();
                $msg = JText::_('Have successfuly delete file');
                $this->setRedirect('index.php?option=com_apdmpns&task=wo_log&id=' . $wo_id, $msg);
        }              
        /*
         * Asign template for get list child PNS  for PNS
         */

        function get_list_pns_so_edit() {
                JRequest::setVar('layout', 'pn_child_editso');
                JRequest::setVar('view', 'getpnsso');
                parent::display();
        }           
    /**
         *
          funcntion get list PNs child for ajax request
         */
        function ajax_list_pns_so_edit() {

                $db = & JFactory::getDBO();
                $cid = JRequest::getVar('cid', array(), '', 'array');
                $so_id = JRequest::getVar('so_id');   
                $str = '<table class="admintable" cellspacing="1" width="80%"><tr>'.
                        '<td class="key">#</td>'.
                        '<td class="key">TOP ASSY PN</td>'.
                        '<td class="key">Description</td>'.
                        '<td class="key">Qty</td>'.
                        '<td class="key">UOM</td>'.
                        '<td class="key">Unit Price</td>'.
                        '<td class="key">F.A Required</td>'.
                        '<td class="key">ESD Required</td>'.
                        '<td class="key">COC Required</td></tr>';                     
                //get curent pns was addinto SO
                $db->setQuery("SELECT fk.*,p.pns_uom, p.pns_description,p.pns_cpn,p.pns_id,p.pns_stock,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code,p.ccs_code, p.pns_code, p.pns_revision  FROM apdm_pns_so AS so inner JOIN apdm_pns_so_fk fk on so.pns_so_id = fk.so_id inner join apdm_pns AS p on p.pns_id = fk.pns_id where so.pns_so_id=".$so_id);                
                $rows = $db->loadObjectList();
                $arrPnsExist=array(0);
                foreach ($rows as $row) {
                        $arrPnsExist[]=$row->pns_id;
                         if ($row->pns_revision) {
                                $pnNumber = $row->ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                        } else {
                                $pnNumber = $row->ccs_code . '-' . $row->pns_code;
                        }  
                        $fachecked="";
                        if($row->fa_required)
                        {
                                $fachecked = 'checked="checked"';
                        }
                        $esdchecked="";
                        if($row->esd_required)
                        {
                                $esdchecked = 'checked="checked"';
                        }
                        $cocchecked="";
                        if($row->coc_required)
                        {
                                $cocchecked = 'checked="checked"';
                        }
                                
                        $str .= '<tr>'.
                                ' <td><input checked="checked" type="checkbox" name="pns_child[]" value="' . $row->pns_id . '" /> </td>'.
                                ' <td class="key">'.$pnNumber.'</td>'.
                                ' <td class="key">'.$row->pns_description.'</td>'.
                                ' <td class="key"><input style="width: 70px" onKeyPress="return numbersOnly(this, event);" type="text" value="'.$row->qty.'" id="qty['.$row->pns_id.']"  name="qty['.$row->pns_id.']" /></td>'.
                                ' <td class="key">'.$row->pns_uom.'</td>'.
                                ' <td class="key"><input style="width: 70px" onKeyPress="return numbersOnlyEspecialFloat(this, event);" type="text" value="'.$row->price.'" id="price['.$row->pns_id.']"  name="price['.$row->pns_id.']" /></td>'.
                                ' <td class="key"><input '.$fachecked.' type="checkbox" name="fa_required['.$row->pns_id.']" value="'.$row->fa_required.'" /> </td>'.
                                ' <td class="key"><input '.$esdchecked.'  type="checkbox" name="esd_required['.$row->pns_id.']" value="'.$row->esd_required.'" /> </td>'.
                                ' <td class="key"><input '.$cocchecked.'  type="checkbox" name="coc_required['.$row->pns_id.']" value="'.$row->coc_required.'" /> </td>';
                }                
                 
                $query = "select pns_id,pns_uom,pns_description, CONCAT_WS( '-', ccs_code, pns_code, pns_revision) AS pns_full_code,ccs_code, pns_code, pns_revision FROM apdm_pns WHERE pns_id IN (" . implode(",", $cid) . ") and pns_id not in (" . implode(",", $arrPnsExist) . ")";
                $db->setQuery($query);
                $rows1 = $db->loadObjectList();                                                              
                foreach ($rows1 as $row) {
                         if ($row->pns_revision) {
                                $pnNumber = $row->ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                        } else {
                                $pnNumber = $row->ccs_code . '-' . $row->pns_code;
                        }                        
                        $str .= '<tr>'.
                                ' <td><input checked="checked" type="checkbox" name="pns_child[]" value="' . $row->pns_id . '" /> </td>'.
                                ' <td class="key">'.$pnNumber.'</td>'.
                                ' <td class="key">'.$row->pns_description.'</td>'.
                                ' <td class="key"><input style="width: 70px" onKeyPress="return numbersOnly(this, event);" type="text" value="" id="qty['.$row->pns_id.']"  name="qty['.$row->pns_id.']" /></td>'.
                                ' <td class="key">'.$row->pns_uom.'</td>'.
                                ' <td class="key"><input style="width: 70px" onKeyPress="return numbersOnlyEspecialFloat(this, event);" type="text" value="" id="price['.$row->pns_id.']"  name="price['.$row->pns_id.']" /></td>'.
                                ' <td class="key"><input checked="checked" type="checkbox" name="fa_required['.$row->pns_id.']" value="1" /> </td>'.
                                ' <td class="key"><input checked="checked" type="checkbox" name="esd_required['.$row->pns_id.']" value="1" /> </td>'.
                                ' <td class="key"><input checked="checked" type="checkbox" name="coc_required['.$row->pns_id.']" value="1" /> </td>';
                }      
                $tol = count($rows)+count($rows1);
                echo $str .'<tr><td><input type="hidden" name="boxcheckedpn" value="'.$tol.'" /></td></tr></table>';
                exit;
        }             
        function save_editso()
        {
                 // Initialize some variables
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                //$row = & JTable::getInstance('apdmpnso');
                $datenow = & JFactory::getDate();
                $post = JRequest::get('post');    
                $so_log =  JRequest::getVar( 'so_log', '', 'post', 'string', JREQUEST_ALLOWHTML );
                $so_id = $post['so_id'];
                $soNumber = $post['so_cuscode'];
                $sql= " update apdm_pns_so set customer_id ='" . $post['customer_id'] . "'".
                        ",so_coordinator = '" . $post['so_coordinator'] . "'".
                        ",so_cuscode = '" . $post['so_cuscode'] . "'".
                        ",so_shipping_date = '" . $post['so_shipping_date'] . "'".
                        ",so_start_date = '" . $post['so_start_date'] . "'".
                        ",so_updated = '" . $datenow->toMySQL() . "'".
                        ",so_updated_by = '" . $me->get('id') . "'".
                        ",so_log = '" . $so_log . "'".
                        " where pns_so_id ='".$so_id."' ";
                $db->setQuery($sql);
                $db->query();     
                // SO ID                
                if($so_id)
                {
                        $listPns = $post['pns_child'];
                        //insert to PN ASYY
                        if($listPns)
                        {
                                foreach($listPns as $pnId)
                                {
                                        //'" . $post['fa_required'][$pnId] . "', '" .  $post['esd_required'][$pnId]. "','" . $post['coc_required'][$pnId]. "'                                        
                                       $fa=0;
                                       if($post['fa_required'][$pnId])
                                               $fa = 1;
                                       $esd=0;
                                       if($post['esd_required'][$pnId])
                                               $esd = 1; 
                                       $coc=0;
                                       if($post['coc_required'][$pnId])
                                               $coc = 1; 
                                      $db->setQuery("INSERT INTO apdm_pns_so_fk (pns_id,so_id,qty,price,fa_required,esd_required,coc_required) VALUES ('" . $pnId . "', '" . $so_id . "', '" . $post['qty'][$pnId] . "', '" . $post['price'][$pnId]  . "', '" . $fa . "', '" .  $esd. "','" . $coc. "') on duplicate key update qty = '". $post['qty'][$pnId]."',price='".$post['price'][$pnId]."',fa_required= '" . $fa . "',esd_required='" . $esd . "',coc_required='" . $coc. "'");                                      
                                      $db->query();                                   
                                }                                
                        }
                     
                }//for save database of pns 
               
                $msg = JText::_('Successfully Updated So');
                return $this->setRedirect('index.php?option=com_apdmpns&task=so_detail&id=' . $so_id, $msg);                
        }
         /*
         * save RMA for SO/PN
         */        
        function savermafk() {
                $db = & JFactory::getDBO();
                $cid = JRequest::getVar('cid', array(), '', 'array');
                $so_id = JRequest::getVar('so_id');           
                 //CHECK ALL WO DONE OR NOT
                //tmp allow save RMA withstatus !=cancel
                $query ="select count(*) from apdm_pns_so where so_state != 'cancel' and pns_so_id = ".$so_id;
                $db->setQuery($query);
                $soDone = $db->loadResult();
                if($soDone)
                {                                       
                        foreach ($cid as $id) {
                                $rma = JRequest::getVar('rma_' . $id);                     
                                $db->setQuery("update apdm_pns_so_fk set rma=" . $rma . " WHERE  id = " . $id);
                                $db->query();
                        }
                        $db->setQuery("update apdm_pns_so set so_state = 'inprogress',so_is_rma =1  WHERE  pns_so_id = ".$so_id);
                        $db->getQuery();
                        $db->query(); 
                        $msg = "Successfully Saved RMA";
                }
                else
                {
                        $msg = "The SO not complete can not Saved RMA";
                }
               
                
                $this->setRedirect('index.php?option=com_apdmpns&task=so_detail&id=' . $so_id, $msg);
        }        
        
        
        function so_detail_wo()
        {
                JRequest::setVar('layout', 'so_detail_wo');
                JRequest::setVar('view', 'so');
                parent::display();
        }        
        /*
         * Asign template for get list child PNS  for PNS
         */

        function get_list_pns_wo() {
                JRequest::setVar('layout', 'pns_wo');
                JRequest::setVar('view', 'getpnsso');
                parent::display();
        }          
/**
         *
          funcntion get list PNs child for ajax request
         */
        function ajax_list_pns_wo() {

                $db = & JFactory::getDBO();
                $cid = JRequest::getVar('cid', array(), '', 'array');
                $query = "select pns_id,pns_uom,pns_description, CONCAT_WS( '-', ccs_code, pns_code, pns_revision) AS pns_full_code,ccs_code, pns_code, pns_revision FROM apdm_pns WHERE pns_id IN (" . implode(",", $cid) . ") limit 1";
                $db->setQuery($query);
                $rows = $db->loadObjectList();
                $str = '<table class="admintable" cellspacing="1" width="60%"><tr>'.
                        '<td class="key">#</td>'.
                        '<td class="key">PN</td>'.
                        '<td class="key">Description</td>'.                        
                        '<td class="key">UOM</td>';                                                  
                foreach ($rows as $row) {
                         if ($row->pns_revision) {
                                $pnNumber = $row->ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                        } else {
                                $pnNumber = $row->ccs_code . '-' . $row->pns_code;
                        }                        
                        $str .= '<tr>'.
                                ' <td><input checked="checked" type="checkbox" name="pns_child[]" value="' . $row->pns_id . '" /> </td>'.
                                ' <td class="key">'.$pnNumber.'</td>'.
                                ' <td class="key">'.$row->pns_description.'</td>'.                               
                                ' <td class="key">'.$row->pns_uom.'</td>';                              
                }
                $str .='</table>';
                echo $str;
                exit;
        }             
        function get_so_ajax()
        {
                JRequest::setVar( 'layout', 'list'  );
                JRequest::setVar( 'view', 'getso' );
                parent::display();
        }
        function ajax_so_towo()
        {
                $db = & JFactory::getDBO();
                $cid             = JRequest::getVar( 'cid', array(), '', 'array' );       
                $id = $cid[0];
                $db->setQuery("SELECT so.*,ccs.ccs_coordinator,ccs.ccs_code from apdm_pns_so so inner join apdm_ccs ccs on so.customer_id = ccs.ccs_code where so.pns_so_id=".$id);                
                $row =  $db->loadObject();   
                $soNumber = $row->so_cuscode;
                if($row->ccs_code)
                {
                       $soNumber = $row->ccs_code."-".$soNumber;
                }                     
                $result = $id.'^'.$soNumber.'^'.$row->so_shipping_date.'^'.$row->so_is_rma.'^'.$row->so_start_date;
                echo $result;
                exit;
        }
        function get_list_assy_wo()
        {
                JRequest::setVar('layout', 'pns_assy_wo');
                JRequest::setVar('view', 'getpnssoassy');
                parent::display();  
        }
        
/**
         *
          funcntion get list PNs child for ajax request
         */
        function ajax_list_pns_assy_wo() {

                $db = & JFactory::getDBO();
                $cid = JRequest::getVar('cid', array(), '', 'array');
                $so_id = JRequest::getVar('so_id');
                $db->setQuery("SELECT fk.*,ccs.ccs_code as customer_code,ccs.ccs_name as customer_name,p.pns_uom,p.pns_cpn, p.pns_description,p.pns_cpn,p.pns_id,p.pns_stock,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code,p.ccs_code, p.pns_code, p.pns_revision  FROM apdm_pns_so AS so inner join apdm_ccs ccs on  ccs.ccs_code = so.customer_id inner JOIN apdm_pns_so_fk fk on so.pns_so_id = fk.so_id inner join apdm_pns AS p on p.pns_id = fk.pns_id where fk.pns_id IN (" . implode(",", $cid) . ") and so_id =".$so_id." limit 1");                
                $rows = $db->loadObjectList();                         
                $str = '<table class="admintable" cellspacing="1" width="60%">';                                                  
                foreach ($rows as $row) {
                         if ($row->pns_revision) {
                                $pnNumber = $row->ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                        } else {
                                $pnNumber = $row->ccs_code . '-' . $row->pns_code;
                        }            
                        $fachecked="";
                        if($row->fa_required)
                                $fachecked = 'checked="checked"';
                        $esdchecked="";
                        if($row->esd_required)
                                $esdchecked = 'checked="checked"';
                        $cocchecked="";
                        if($row->coc_required)
                                $cocchecked = 'checked="checked"';
                        $str .=  '<tr> <td class="key">FA<input '.$fachecked.' type="checkbox" name="fa_required['.$row->pns_id.']" value="1" /> </td>'.
                                ' <td class="key">ESD<input '.$esdchecked.'  type="checkbox" name="esd_required['.$row->pns_id.']" value="1" /> </td>'.
                                ' <td class="key">COC<input '.$cocchecked.'  type="checkbox" name="coc_required['.$row->pns_id.']" value="1" /> </td></tr>';
                }
                $str .='</table>';
                $result = $row->pns_id.'^'.$row->customer_code.'^'.$row->customer_name.'^'.$pnNumber.'^'.$str.'^'.$so_id;                
                echo $result;
                exit;                                                                 
        }
        function save_works_order()
        {
                // Initialize some variables
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                //$row = & JTable::getInstance('apdmpnso');
                $datenow = & JFactory::getDate();
                $post = JRequest::get('post');         
               // var_dump($post);die;               
                $soNumber = $post['so_cuscode'];
                $partNumber = $post['pns_child'];
                $woStatus= "label_printed";//Label Printed
                $sql = "INSERT INTO apdm_pns_wo (so_id,wo_code,wo_qty,pns_id,top_pns_id,wo_customer_id,wo_state,wo_start_date,wo_completed_date,wo_created,wo_created_by,wo_assigner,wo_updated,wo_updated_by,wo_rma_active) ".
                       " VALUES ('" . $post['so_id'] . "', '" . $post['wo_code'] . "', '" . $post['wo_qty'] . "', '" . $partNumber[0] . "', '" . $post['top_pns_id'] . "', '" . $post['wo_customer_id'] . "', '" . $woStatus . "', '" .  $post['wo_start_date']. "', '" .  $post['wo_completed_date']. "','" . $datenow->toMySQL() . "', '" . $me->get('id') . "','".$post['wo_assigner']."','" . $datenow->toMySQL() . "', '" . $me->get('id') . "','".$post['wo_rma_active']."')";
                $db->setQuery($sql);
                $db->query();     
                //getLast SO ID
                $wo_id = $db->insertid();
                if($wo_id)
                {               
                        //Insert step1
						$woStatus1 = 'pending';
						$woStatusTitle1 = 'Pending';
						if($post['op_assigner1']==0)
						{
							$woStatus1= 'done';	
							$WostatusTitle1= 'Done';							
						}						
                        $sql = "INSERT INTO apdm_pns_wo_op (wo_id,op_code,op_status,op_title,op_comment,op_completed_date,op_assigner,op_target_date,op_updated,op_updated_by)".
                                " VALUES ('" . $wo_id . "','wo_step1','".$woStatus1."','".$WostatusTitle1."','".$post['op_comment1']."','".$post['op_completed_date1']."','".$post['op_assigner1']."','".$post['op_target_date1']."','" . $datenow->toMySQL() . "'," . $me->get('id') . ")";
                        $db->setQuery($sql);
                        $db->query();
                        //Insert step2
						$woStatus2 = 'pending';
						$woStatusTitle2 = 'Pending';
						if($post['op_assigner2']==0)
						{
							$woStatus2= 'done';	
							$WostatusTitle2= 'Done';							
						}	
                        $sql = "INSERT INTO apdm_pns_wo_op (wo_id,op_code,op_status,op_title,op_comment,op_completed_date,op_assigner,op_target_date,op_updated,op_updated_by)".
                                " VALUES ('" . $wo_id . "','wo_step2','".$woStatus2."','".$WostatusTitle2."','".$post['op_comment2']."','".$post['op_completed_date2']."','".$post['op_assigner2']."','".$post['op_target_date2']."','" . $datenow->toMySQL() . "'," . $me->get('id') . ")";
                        $db->setQuery($sql);
                        $db->query();
                        //Insert step3						
						$woStatus3 = 'pending';
						$woStatusTitle3 = 'Pending';
						if($post['op_assigner3']==0)
						{
							$woStatus3= 'done';	
							$WostatusTitle3= 'Done';							
						}
                        $sql = "INSERT INTO apdm_pns_wo_op (wo_id,op_code,op_status,op_title,op_comment,op_completed_date,op_assigner,op_target_date,op_updated,op_updated_by)".
                                " VALUES ('" . $wo_id . "','wo_step3','".$woStatus3."','".$WostatusTitle3."','".$post['op_comment3']."','".$post['op_completed_date3']."','".$post['op_assigner3']."','".$post['op_target_date3']."','" . $datenow->toMySQL() . "'," . $me->get('id') . ")";
                        $db->setQuery($sql);
                        $db->query();
                        //Insert step4
						$woStatus4 = 'pending';
						$woStatusTitle4 = 'Pending';
						if($post['op_assigner4']==0)
						{
							$woStatus4= 'done';	
							$WostatusTitle4= 'Done';							
						}
                        $sql = "INSERT INTO apdm_pns_wo_op (wo_id,op_code,op_status,op_title,op_comment,op_completed_date,op_assigner,op_target_date,op_updated,op_updated_by)".
                                " VALUES ('" . $wo_id . "','wo_step4','".$woStatus4."','".$WostatusTitle4."','".$post['op_comment4']."','".$post['op_completed_date4']."','".$post['op_assigner4']."','".$post['op_target_date4']."','" . $datenow->toMySQL() . "'," . $me->get('id') . ")";
                        $db->setQuery($sql);
                        $db->query();
                        $wo_op_step4_id = $db->insertid();
                        if($wo_op_step4_id)
                        {
                                for($i=1;$i<=4;$i++)
                                {                                                    
                                        $sql = "INSERT INTO apdm_pns_wo_op_assembly(pns_wo_id,pns_op_id,op_assembly_value1,op_assembly_value2,op_assembly_value3,op_assembly_value4,op_assembly_value5,op_assembly_updated,op_assembly_updated_by) ".
                                           " VALUES ('" . $wo_id . "','" . $wo_op_step4_id . "','".$post['op_assembly_value1'][$i]."','".$post['op_assembly_value2'][$i]."','".$post['op_assembly_value3'][$i]."','".$post['op_assembly_value4'][$i]."','".$post['op_assembly_value5'][$i]."','" . $datenow->toMySQL() . "'," . $me->get('id') . ")"; 
                                        $db->setQuery($sql);
                                        $db->query();
                                }
                        }
                        //Insert step5
						$woStatus5 = 'pending';
						$woStatusTitle5 = 'Pending';
						if($post['op_assigner5']==0)
						{
							$woStatus5= 'done';	
							$WostatusTitle5= 'Done';							
						}
                        $sql = "INSERT INTO apdm_pns_wo_op (wo_id,op_code,op_status,op_title,op_comment,op_completed_date,op_assigner,op_target_date,op_updated,op_updated_by)".
                                " VALUES ('" . $wo_id . "','wo_step5','".$woStatus5."','".$WostatusTitle5."','".$post['op_comment5']."','".$post['op_completed_date5']."','".$post['op_assigner5']."','".$post['op_target_date5']."','" . $datenow->toMySQL() . "'," . $me->get('id') . ")";
                        $db->setQuery($sql);
                        $db->query();
                        $wo_op_step5_id = $db->insertid();
                        if($wo_op_step5_id)
                        {
                                for($i=1;$i<=2;$i++)
                                {                                                    
                                        $sql = "INSERT INTO apdm_pns_wo_op_visual(pns_wo_id,pns_op_id,op_visual_value1,op_visual_value2,op_visual_value3,op_visual_value4,op_visual_value5,op_visual_updated,op_visual_updated_by,op_visual_fail_times) ".
                                           " VALUES ('" . $wo_id . "','" . $wo_op_step5_id . "','".$post['op_visual_value1'][$i]."','".$post['op_visual_value2'][$i]."','".$post['op_visual_value3'][$i]."','".$post['op_visual_value4'][$i]."','".$post['op_visual_value5'][$i]."','" . $datenow->toMySQL() . "'," . $me->get('id') . ",".$i.")"; 
                                        $db->setQuery($sql);
                                        $db->query();
                                }
                        }
                        //Insert step6
						$woStatus6 = 'pending';
						$woStatusTitle6 = 'Pending';
						if($post['op_assigner6']==0)
						{
							$woStatus6= 'done';	
							$WostatusTitle6= 'Done';							
						}
                        $sql = "INSERT INTO apdm_pns_wo_op (wo_id,op_code,op_status,op_title,op_comment,op_completed_date,op_assigner,op_target_date,op_updated,op_updated_by)".
                                " VALUES ('" . $wo_id . "','wo_step6','".$woStatus6."','".$WostatusTitle6."','".$post['op_comment6']."','".$post['op_completed_date6']."','".$post['op_assigner6']."','".$post['op_target_date6']."','" . $datenow->toMySQL() . "'," . $me->get('id') . ")";
                        $db->setQuery($sql);
                        $db->query();
                        $wo_op_step6_id = $db->insertid();
                        if($wo_op_step6_id)
                        {
                                for($i=1;$i<=2;$i++)
                                {                                                    
                                        $sql = "INSERT INTO apdm_pns_wo_op_final(pns_wo_id,pns_op_id,op_final_value1,op_final_value2,op_final_value3,op_final_value4,op_final_value5,op_final_value6,op_final_value7,op_final_updated,op_final_updated_by,op_final_fail_times) ".
                                           " VALUES ('" . $wo_id . "','" . $wo_op_step6_id . "','".$post['op_final_value1'][$i]."','".$post['op_final_value2'][$i]."','".$post['op_final_value3'][$i]."','".$post['op_final_value4'][$i]."','".$post['op_final_value5'][$i]."','".$post['op_final_value6'][$i]."','".$post['op_final_value7'][$i]."','" . $datenow->toMySQL() . "'," . $me->get('id') . ",".$i.")"; 
                                        $db->setQuery($sql);
                                        $db->query();
                                }
                        }
                        //Insert step7
						$woStatus7 = 'pending';
						$woStatusTitle7 = 'Pending';
						if($post['op_assigner7']==0)
						{
							$woStatus7= 'done';	
							$WostatusTitle7= 'Done';							
						}
                        $sql = "INSERT INTO apdm_pns_wo_op (wo_id,op_code,op_status,op_title,op_comment,op_completed_date,op_assigner,op_target_date,op_updated,op_updated_by)".
                                " VALUES ('" . $wo_id . "','wo_step7','".$woStatus7."','".$WostatusTitle7."','".$post['op_comment7']."','".$post['op_completed_date7']."','".$post['op_assigner7']."','".$post['op_target_date7']."','" . $datenow->toMySQL() . "'," . $me->get('id') . ")";
                        $db->setQuery($sql);
                        $db->query();    

						//check lastest status 
                        $sql = "select count(*) from apdm_pns_wo_op where wo_id =".$wo_id." and op_assigner !=0  and op_status != 'done'   order by op_code desc";
                        $db->setQuery($sql);                        
                        $totalWodone = $db->loadResult();
                        if($totalWodone==0)
                        {
                                $status ="done";
                        }
                        else
                        {
                                /*$sql = "select * from apdm_pns_wo_op where wo_id =".$wo_id." and op_assigner !=0  and op_status = 'done'   order by op_code desc limit 1";
                                $db->setQuery($sql);    
                                $woResult = $db->loadObjectList();
                                if(count($woResult))
                                {
                                        foreach($woResult as $r)
                                        {                                               
                                                switch($r->op_code)
                                                {
                                                        case 'wo_step1':
                                                                if($r->op_status=='done')
                                                                {
                                                                        $status ="wire_cut";
                                                                }
                                                                break;
                                                        case 'wo_step2':
                                                                if($r->op_status=='done')
                                                                {
                                                                        $status ="kitted";
                                                                }
                                                                break;    
                                                        case 'wo_step3':
                                                                if($r->op_status=='done')
                                                                {
                                                                        $status ="production";
                                                                }
                                                                break;
                                                        case 'wo_step4':
                                                                if($r->op_status=='done')
                                                                {
                                                                        $status ="visual_inspection";
                                                                }
                                                                break;    
                                                        case 'wo_step5':
                                                                if($r->op_status=='done')
                                                                {
                                                                        $status ="final_inspection";
                                                                }
                                                                break;
                                                        case 'wo_step6':
                                                                if($r->op_status=='done')
                                                                {
                                                                        $status ="packaging";
                                                                }
                                                                break;   
                                                        case 'wo_step7':
                                                                if($r->op_status=='done')
                                                                {
                                                                        $status ="done";
                                                                }
                                                                break;                                                

                                                }
                                        }
                                }
                                else
                                {*/
                                     $sql = "select * from apdm_pns_wo_op where wo_id =".$wo_id." and op_assigner !=0  and op_status != 'done'   order by op_code asc limit 1";
                                     $db->setQuery($sql);                                              
                                     $row = $db->loadObject();
                                     switch($row->op_code)
                                                {
                                                        case 'wo_step1':
                                                                $status ="label_printed";
                                                                break;
                                                        case 'wo_step2':
                                                                $status ="wire_cut";                                                                
                                                                break;    
                                                        case 'wo_step3':
                                                                $status ="kitted";
                                                                break;
                                                        case 'wo_step4':
                                                                $status ="production";
                                                                break;    
                                                        case 'wo_step5':
                                                                $status ="visual_inspection";
                                                                break;
                                                        case 'wo_step6':
                                                                $status ="final_inspection";                                                                
                                                                break;   
                                                        case 'wo_step7':
                                                                $status ="packaging";
                                                                break;             
                                                        default:
                                                                $status ="done";

                                                }
                                     
                               // }
                        }
                        $sql= " update apdm_pns_wo set ".
                                " wo_state = '" . $status . "'".    
                                " ,op_start_date = '" . $datenow->toMySQL() . "'".    
                                " where pns_wo_id ='".$wo_id."' ";
                        $db->setQuery($sql);
                        $db->query();   						
                }   
                
                $msg = JText::_('Successfully Saved WO');
                $return = JRequest::getVar('so_id');
               
                if ($return) {
                       return $this->setRedirect('index.php?option=com_apdmpns&task=so_detail_wo&id='.$return, $msg);
                } else {
                       return $this->setRedirect('index.php?option=com_apdmpns&task=wo_detail&id=' . $wo_id, $msg);
                }                 
        }
        function wo_autoincrement_default() {
                $db = & JFactory::getDBO();
                $query = "SELECT pns_wo_id  FROM apdm_pns_wo order by pns_wo_id desc limit 1";//  WHERE  date(po_created) = CURDATE()
                $db->setQuery($query);
                $wo_latest = $db->loadResult();
               
                $next_wo_code = (int) $wo_latest;
                $next_wo_code++;
                $number = strlen($next_wo_code);
                 switch ($number) {
                        case '1':
                                $new_wo_code = '0000000' . $next_wo_code;
                                break;
                        case '2':
                                $new_wo_code = '000000' . $next_wo_code;
                                break;
                        case '3':
                                $new_wo_code = '00000' . $next_wo_code;
                                break;
                        case '4':
                                $new_wo_code = '0000' . $next_wo_code;
                                break;
                        case '5':
                                $new_wo_code = '000' . $next_wo_code;
                                break;
                        case '6':
                                $new_wo_code = '00' . $next_wo_code;
                                break;
                        case '7':
                                $new_wo_code = '0' . $next_wo_code;
                                break;
                        default:
                                $new_wo_code = $next_wo_code;
                                break;
                }
                echo $new_wo_code;               
        }   
        function wo_detail()
        {
                JRequest::setVar('layout', 'wo_detail');
                JRequest::setVar('view', 'wo');
                 parent::display();
        }
        function printwopdf()
        {
                JRequest::setVar('layout', 'wo_detail_print');
                JRequest::setVar('view', 'wo');
                 parent::display();
        }
        
        /*
         * Remove WO
         */
        function deletewo() {
                $db = & JFactory::getDBO();                
                $wo_id = JRequest::getVar('wo_id');
                $db->setQuery("DELETE FROM apdm_pns_wo WHERE pns_wo_id = '" . $wo_id . "'");
                $db->query();                    
                $db->setQuery("DELETE FROM apdm_pns_wo_op WHERE wo_id = '" . $wo_id . "'");
                $db->query();   
                $db->setQuery("DELETE FROM apdm_pns_wo_op_assembly WHERE pns_wo_id = '" . $wo_id . "'");
                $db->query();   
                $db->setQuery("DELETE FROM apdm_pns_wo_op_final WHERE pns_wo_id = '" . $wo_id . "'");
                $db->query();   
                $db->setQuery("DELETE FROM apdm_pns_wo_op_visual WHERE pns_wo_id = '" . $wo_id . "'");
                $db->query();   
                $msg = JText::_('Have removed successfull.');
                return $this->setRedirect('index.php?option=com_apdmpns&task=somanagement', $msg);
        }    
        function editwo()
        {
                
                JRequest::setVar('layout', 'edit_wo');
                JRequest::setVar('view', 'wo');
                //JRequest::setVar('edit', true);
                parent::display();
        }        
        function save_editwo()
        {
                 // Initialize some variables
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();
                //$row = & JTable::getInstance('apdmpnso');
                $datenow = & JFactory::getDate();
                $post = JRequest::get('post');  
                //var_dump($post);die;
                $partNumber = $post['pns_child'];
                $wo_id = $post['wo_id'];
                $soNumber = $post['so_cuscode'];                 
                // SO ID                
                if($wo_id)
                {
                       //Update step1
                        $status = "label_printed";
                        $wopoStatus1="";
                        $wopoStatusTitle1="";
                        if($post['op_completed_date1']!="0000-00-00 00:00:00" && $post['op_assigner1']!=0)
                        {
                                //$status ="wire_cut";
                                $wopoStatus1 = "done";
                                $wopoStatusTitle1 = "Done";
                                //check done with pass day target
                                $query ="select DATEDIFF('".$post['op_completed_date1']."',date(op_target_date))  from apdm_pns_wo_op where op_code = 'wo_step1' and op_delay_check=0 and wo_id = ".$wo_id;
                                $db->setQuery($query);
                                $delayt = $db->loadResult();
                                //if datecomplte input diff with current target date will be reset op_delay_check for count up 1
                                if($delayt>0)
                                {
                                        $sql= " update apdm_pns_wo_op set op_completed_date ='" . $post['op_completed_date1'] . "'".
                                                 " ,op_delay_check = 1 , op_delay = op_delay + 1  ".
                                                 " where op_code = 'wo_step1' and wo_id = ".$wo_id;
                                         $db->setQuery($sql);
                                         $db->query();  
                                }
                                //set start date for next step
                                $sql = "update apdm_pns_wo_op set op_start_date='".$datenow->toMySQL()."',op_updated_by='" . $me->get('id') . "' where op_code = 'wo_step2' and wo_id = ".$wo_id;
                                $db->setQuery($sql);
                                $db->query(); 
                        }
						elseif($post['op_assigner1']==0)
						{
						//	$status ="wire_cut";
							$wopoStatus1 = "done";
							$wopoStatusTitle1 = "done";
						}
                        
                        $sql = "update apdm_pns_wo_op set op_target_date='" . $post['op_target_date1'] . "', op_status ='".$wopoStatus1."', op_title ='".$wopoStatusTitle1."', op_comment = '".$post['op_comment1']."',op_delay_date = '".$post['op_completed_date1']."',op_completed_date = '".$post['op_completed_date1']."',op_assigner ='".$post['op_assigner1']."',op_updated='".$datenow->toMySQL()."',op_updated_by='" . $me->get('id') . "' where op_code = 'wo_step1' and wo_id = ".$wo_id;                                              
                        $db->setQuery($sql);
                        $db->query();                                                
                        //check update op_target_date for implement count number delay step
                        //op_target_date='".$post['op_target_date1']."',
                        $query ="select DATEDIFF('".$post['op_target_date1']."',date(op_target_date))  from apdm_pns_wo_op where op_code = 'wo_step1' and wo_id = ".$wo_id;
                        $db->setQuery($query);
                        $delayt = $db->loadResult();
                        //if datecomplte input diff with current target date will be reset op_delay_check for count up 1
                        if($delayt>0)
                        {
                                $sql= " update apdm_pns_wo_op set op_target_date ='" . $post['op_target_date1'] . "'".
                                         " ,op_delay_check = 0 ".
                                         " where op_code = 'wo_step1' and wo_id = ".$wo_id;
                                 $db->setQuery($sql);
                                 $db->query();                                   
                        }
                        //end op 1
                        
                        //Update step2
                        $wopoStatus2="";
                        $wopoStatusTitle2="";
                        if($post['op_completed_date2']!="0000-00-00 00:00:00"  && $post['op_assigner2']!=0)
                        {
                                //$status ="kitted";
                                $wopoStatus2 = "done";
                                $wopoStatusTitle2 = "Done";
                                //check done with pass day target
                                $query ="select DATEDIFF('".$post['op_completed_date2']."',date(op_target_date))  from apdm_pns_wo_op where op_code = 'wo_step2' and op_delay_check=0 and wo_id = ".$wo_id;
                                $db->setQuery($query);
                                $delayt = $db->loadResult();
                                //if datecomplte input diff with current target date will be reset op_delay_check for count up 1
                                if($delayt>0)
                                {
                                        $sql= " update apdm_pns_wo_op set op_completed_date ='" . $post['op_completed_date2'] . "'".
                                                 " ,op_delay_check = 1, op_delay = op_delay + 1".
                                                 " where op_code = 'wo_step2' and wo_id = ".$wo_id;
                                         $db->setQuery($sql);
                                         $db->query();  
                                }
                                //set start date for next step
                                $sql = "update apdm_pns_wo_op set op_start_date='".$datenow->toMySQL()."',op_updated_by='" . $me->get('id') . "' where op_code = 'wo_step3' and wo_id = ".$wo_id;
                                $db->setQuery($sql);
                                $db->query(); 
                        }elseif($post['op_assigner2']==0)
						{
							//$status ="kitted";
							$wopoStatus2 = "done";
							$wopoStatusTitle2 = "done";
						}						
                        $sql = "update apdm_pns_wo_op set op_target_date='" . $post['op_target_date2'] . "',op_status ='".$wopoStatus2."', op_title ='".$wopoStatusTitle2."',op_comment = '".$post['op_comment2']."',op_delay_date = '".$post['op_completed_date2']."',op_completed_date = '".$post['op_completed_date2']."',op_assigner ='".$post['op_assigner2']."',op_updated='".$datenow->toMySQL()."',op_updated_by='" . $me->get('id') . "' where op_code = 'wo_step2' and wo_id = ".$wo_id;
                        $db->setQuery($sql);
                        $db->query();                         
                        //check update op_target_date for implement count number delay step
                        //,op_target_date='".$post['op_target_date2']."'
                        $query ="select DATEDIFF('".$post['op_target_date2']."',date(op_target_date))  from apdm_pns_wo_op where op_code = 'wo_step2' and wo_id = ".$wo_id;
                        $db->setQuery($query);
                        $delayt = $db->loadResult();
                        //if datecomplte input diff with current target date will be reset op_delay_check for count up 1
                        if($delayt>0)
                        {
                                $sql= " update apdm_pns_wo_op set op_target_date ='" . $post['op_target_date2'] . "'".
                                         " ,op_delay_check = 0 ".
                                         " where op_code = 'wo_step2' and wo_id = ".$wo_id;
                                 $db->setQuery($sql);
                                 $db->query();  
                        }
                        //end op 2
                        
                        //Update step3
                        $wopoStatus3="";
                        $wopoStatusTitle3="";
                        if($post['op_completed_date3']!="0000-00-00 00:00:00"  && $post['op_assigner3']!=0)
                        {
                               // $status ="production";
                                $wopoStatus3 = "done";
                                $wopoStatusTitle3 = "Done";
                                //check done with pass day target
                                $query ="select DATEDIFF('".$post['op_completed_date3']."',date(op_target_date))  from apdm_pns_wo_op where op_code = 'wo_step3' and op_delay_check=0 and wo_id = ".$wo_id;
                                $db->setQuery($query);
                                $delayt = $db->loadResult();
                                //if datecomplte input diff with current target date will be reset op_delay_check for count up 1
                                if($delayt>0)
                                {
                                        $sql= " update apdm_pns_wo_op set op_completed_date ='" . $post['op_completed_date3'] . "'".
                                                 " ,op_delay_check = 1 , op_delay = op_delay + 1".
                                                 " where op_code = 'wo_step3' and wo_id = ".$wo_id;
                                         $db->setQuery($sql);
                                         $db->query();  
                                }
                                //set start date for next step
                                $sql = "update apdm_pns_wo_op set op_start_date='".$datenow->toMySQL()."',op_updated_by='" . $me->get('id') . "' where op_code = 'wo_step4' and wo_id = ".$wo_id;
                                $db->setQuery($sql);
                                $db->query(); 
                        }elseif($post['op_assigner3']==0)
						{
							//$status ="production";
							$wopoStatus3 = "done";
							$wopoStatusTitle3 = "done";
						}	                       
                        $sql = "update apdm_pns_wo_op set op_target_date='" . $post['op_target_date3'] . "',op_status ='".$wopoStatus3."', op_title ='".$wopoStatusTitle3."',op_comment = '".$post['op_comment3']."',op_delay_date = '".$post['op_completed_date3']."',op_completed_date = '".$post['op_completed_date3']."',op_assigner ='".$post['op_assigner3']."',op_updated='".$datenow->toMySQL()."',op_updated_by='" . $me->get('id') . "' where op_code = 'wo_step3' and wo_id = ".$wo_id;
                        $db->setQuery($sql);
                        $db->query();
                        
                        //check update op_target_date for implement count number delay step
                        //,op_target_date='".$post['op_target_date2']."'
                        $query ="select DATEDIFF('".$post['op_target_date3']."',date(op_target_date))  from apdm_pns_wo_op where op_code = 'wo_step3' and wo_id = ".$wo_id;
                        $db->setQuery($query);
                        $delayt = $db->loadResult();
                        //if datecomplte input diff with current target date will be reset op_delay_check for count up 1
                        if($delayt>0)
                        {
                                $sql= " update apdm_pns_wo_op set op_target_date ='" . $post['op_target_date3'] . "'".
                                         " ,op_delay_check = 0 ".
                                         " where op_code = 'wo_step3' and wo_id = ".$wo_id;
                                 $db->setQuery($sql);
                                 $db->query();  
                        }
                        //end op 3
                        
                        //Update step4     
                        $wopoStatus4="";
                        $wopoStatusTitle4="";
                        if($post['op_completed_date4']!="0000-00-00 00:00:00" && $post['op_assigner4']!=0)
                        {
                                //$status ="visual_inspection";
                                $wopoStatus4 = "done";
                                $wopoStatusTitle4 = "Done";
                                //check done with pass day target
                                $query ="select DATEDIFF('".$post['op_completed_date4']."',date(op_target_date))  from apdm_pns_wo_op where op_code = 'wo_step4' and op_delay_check=0 and wo_id = ".$wo_id;
                                $db->setQuery($query);
                                $delayt = $db->loadResult();
                                //if datecomplte input diff with current target date will be reset op_delay_check for count up 1
                                if($delayt>0)
                                {
                                        $sql= " update apdm_pns_wo_op set op_completed_date ='" . $post['op_completed_date4'] . "'".
                                                 " ,op_delay_check = 1 , op_delay = op_delay + 1".
                                                 " where op_code = 'wo_step4' and wo_id = ".$wo_id;
                                         $db->setQuery($sql);
                                         $db->query();  
                                }
                                 //set start date for next step
                                $sql = "update apdm_pns_wo_op set op_start_date='".$datenow->toMySQL()."',op_updated_by='" . $me->get('id') . "' where op_code = 'wo_step5' and wo_id = ".$wo_id;
                                $db->setQuery($sql);
                                $db->query(); 
                        }elseif($post['op_assigner4']==0)
						{
							//$status ="visual_inspection";
							$wopoStatus4 = "done";
							$wopoStatusTitle4 = "done";
						}
                        $sql = "update apdm_pns_wo_op set op_target_date='" . $post['op_target_date4'] . "',op_status ='".$wopoStatus4."', op_title ='".$wopoStatusTitle4."',op_comment = '".$post['op_comment4']."',op_delay_date = '".$post['op_completed_date4']."',op_completed_date = '".$post['op_completed_date4']."',op_assigner ='".$post['op_assigner4']."',op_updated='".$datenow->toMySQL()."',op_updated_by='" . $me->get('id') . "' where op_code = 'wo_step4' and wo_id = ".$wo_id;
                        $db->setQuery($sql);
                        $db->query();
                       
                        //check update op_target_date for implement count number delay step
                        //,op_target_date='".$post['op_target_date2']."'
                        $query ="select DATEDIFF('".$post['op_target_date4']."',date(op_target_date))  from apdm_pns_wo_op where op_code = 'wo_step4' and wo_id = ".$wo_id;
                        $db->setQuery($query);
                        $delayt = $db->loadResult();
                        //if datecomplte input diff with current target date will be reset op_delay_check for count up 1
                        if($delayt>0)
                        {
                                $sql= " update apdm_pns_wo_op set op_target_date ='" . $post['op_target_date4'] . "'".
                                         " ,op_delay_check = 0 ".
                                         " where op_code = 'wo_step4' and wo_id = ".$wo_id;
                                 $db->setQuery($sql);
                                 $db->query();  
                        }
                        //end op 4                      
                        //update apdm_pns_wo_op_assembly
                        $op_assemble_id = $post['op_assemble_id'];
                        if(sizeof($op_assemble_id))
                        {
                                foreach($op_assemble_id as $assem_id)
                                {                                                    
                                        $sql = "update apdm_pns_wo_op_assembly set op_assembly_value1 = '".$post['op_assembly_value1'][$assem_id]."',op_assembly_value2='".$post['op_assembly_value2'][$assem_id]."',op_assembly_value3='".$post['op_assembly_value3'][$assem_id]."',op_assembly_value4='".$post['op_assembly_value4'][$assem_id]."',op_assembly_value5='".$post['op_assembly_value5'][$assem_id]."',op_assembly_updated='" . $datenow->toMySQL() . "',op_assembly_updated_by = " . $me->get('id') . " where id=".$assem_id." and pns_wo_id =".$wo_id;                                          
                                        $db->setQuery($sql);
                                        $db->query();
                                }
                        }
                        //Update step5                       
                        $wopoStatus5="";
                        $wopoStatusTitle5="";
                        if($post['op_completed_date5']!="0000-00-00 00:00:00" && $post['op_assigner5']!=0)
                        {
                                //$status ="final_inspection";
                                $wopoStatus5 = "done";
                                $wopoStatusTitle5 = "Done";
                                //check done with pass day target
                                $query ="select DATEDIFF('".$post['op_completed_date5']."',date(op_target_date))  from apdm_pns_wo_op where op_code = 'wo_step5' and op_delay_check=0 and wo_id = ".$wo_id;
                                $db->setQuery($query);
                                $delayt = $db->loadResult();
                                //if datecomplte input diff with current target date will be reset op_delay_check for count up 1
                                if($delayt>0)
                                {
                                        $sql= " update apdm_pns_wo_op set op_completed_date ='" . $post['op_completed_date5'] . "'".
                                                 " ,op_delay_check = 1 , op_delay = op_delay + 1".
                                                 " where op_code = 'wo_step5' and wo_id = ".$wo_id;
                                         $db->setQuery($sql);
                                         $db->query();  
                                }                        
                                 //set start date for next step
                                $sql = "update apdm_pns_wo_op set op_start_date='".$datenow->toMySQL()."',op_updated_by='" . $me->get('id') . "' where op_code = 'wo_step6' and wo_id = ".$wo_id;
                                $db->setQuery($sql);
                                $db->query(); 
                        }elseif($post['op_assigner5']==0)
						{
							//$status ="final_inspection";
							$wopoStatus5 = "done";
							$wopoStatusTitle5 = "done";
						}
                        $sql = "update apdm_pns_wo_op set op_target_date='" . $post['op_target_date5'] . "',op_status ='".$wopoStatus5."', op_title ='".$wopoStatusTitle5."',op_comment = '".$post['op_comment5']."',op_delay_date = '".$post['op_completed_date5']."',op_completed_date = '".$post['op_completed_date5']."',op_assigner ='".$post['op_assigner5']."',op_updated='".$datenow->toMySQL()."',op_updated_by='" . $me->get('id') . "' where op_code = 'wo_step5' and wo_id = ".$wo_id;
                        $db->setQuery($sql);
                        $db->query();
                        
                        //check update op_target_date for implement count number delay step
                        //,op_target_date='".$post['op_target_date2']."'
                        $query ="select DATEDIFF('".$post['op_target_date5']."',date(op_target_date))  from apdm_pns_wo_op where op_code = 'wo_step5' and wo_id = ".$wo_id;
                        $db->setQuery($query);
                        $delayt = $db->loadResult();
                        //if datecomplte input diff with current target date will be reset op_delay_check for count up 1
                        if($delayt>0)
                        {
                                $sql= " update apdm_pns_wo_op set op_target_date ='" . $post['op_target_date5'] . "'".
                                         " ,op_delay_check = 0 ".
                                         " where op_code = 'wo_step5' and wo_id = ".$wo_id;
                                 $db->setQuery($sql);
                                 $db->query();  
                        }
                        //end op 5                                  
                       
                       //get op_id from step 5
                        $sql = "select pns_op_id from apdm_pns_wo_op where op_code = 'wo_step5' and wo_id = ".$wo_id;
                        $db->setQuery($sql);
                        $pns_op_id = $db->loadResult();
                        if($pns_op_id)
                        {
                                for($i=1;$i<=2;$i++)
                                {                                                    
                                        $sql = "update apdm_pns_wo_op_visual set op_visual_value1='".$post['op_visual_value1'][$i]."',op_visual_value2='".$post['op_visual_value2'][$i]."',op_visual_value3='".$post['op_visual_value3'][$i]."',op_visual_value4='".$post['op_visual_value3'][$i]."',op_visual_value5='".$post['op_visual_value5'][$i]."',op_visual_updated='" . $datenow->toMySQL() . "',op_visual_updated_by=" . $me->get('id') . " where op_visual_fail_times = ".$i." and pns_op_id = ".$pns_op_id." and pns_wo_id=".$wo_id;                                      
                                        $db->setQuery($sql);
                                        $db->query();                                        
                                }                                                                
                        }
                        //Update step6                        
                        $wopoStatus6 = "";
                        $wopoStatusTitle6 = "";
                        if($post['op_completed_date6']!="0000-00-00 00:00:00" && $post['op_assigner6']!=0)
                        {
                                //$status ="packaging";
                                $wopoStatus6 = "done";
                                $wopoStatusTitle6 = "Done";
                                //check done with pass day target
                                $query ="select DATEDIFF('".$post['op_completed_date6']."',date(op_target_date))  from apdm_pns_wo_op where op_code = 'wo_step6' and op_delay_check=0 and wo_id = ".$wo_id;
                                $db->setQuery($query);
                                $delayt = $db->loadResult();
                                //if datecomplte input diff with current target date will be reset op_delay_check for count up 1
                                if($delayt>0)
                                {
                                        $sql= " update apdm_pns_wo_op set op_completed_date ='" . $post['op_completed_date6'] . "'".
                                                 " ,op_delay_check = 1 , op_delay = op_delay + 1".
                                                 " where op_code = 'wo_step6' and wo_id = ".$wo_id;
                                         $db->setQuery($sql);
                                         $db->query();  
                                }                     
                                //set start date for next step
                                $sql = "update apdm_pns_wo_op set op_start_date='".$datenow->toMySQL()."',op_updated_by='" . $me->get('id') . "' where op_code = 'wo_step7' and wo_id = ".$wo_id;
                                $db->setQuery($sql);
                                $db->query(); 
                        }elseif($post['op_assigner6']==0)
						{
						//	$status ="final_inspection";
							$wopoStatus6 = "done";
							$wopoStatusTitle6 = "done";
						}
                        $sql = "update apdm_pns_wo_op set op_target_date='" . $post['op_target_date6'] . "',op_status ='".$wopoStatus6."', op_title ='".$wopoStatusTitle6."',op_comment = '".$post['op_comment6']."',op_delay_date = '".$post['op_completed_date6']."',op_completed_date = '".$post['op_completed_date6']."',op_assigner ='".$post['op_assigner6']."',op_updated='".$datenow->toMySQL()."',op_updated_by='" . $me->get('id') . "' where op_code = 'wo_step6' and wo_id = ".$wo_id;
                        $db->setQuery($sql);
                        $db->query();       
                         
                        //check update op_target_date for implement count number delay step
                        //,op_target_date='".$post['op_target_date2']."'
                        $query ="select DATEDIFF('".$post['op_target_date6']."',date(op_target_date))  from apdm_pns_wo_op where op_code = 'wo_step6' and wo_id = ".$wo_id;
                        $db->setQuery($query);
                        $delayt = $db->loadResult();
                        //if datecomplte input diff with current target date will be reset op_delay_check for count up 1
                        if($delayt>0)
                        {
                                $sql= " update apdm_pns_wo_op set op_target_date ='" . $post['op_target_date6'] . "'".
                                         " ,op_delay_check = 0 ".
                                         " where op_code = 'wo_step6' and wo_id = ".$wo_id;
                                 $db->setQuery($sql);
                                 $db->query();  
                        }
                        //end op 6                        
                       //get op_id from step 6
                        $sql = "select pns_op_id from apdm_pns_wo_op where op_code = 'wo_step6' and wo_id = ".$wo_id;
                        $db->setQuery($sql);
                        $pns_op_id = $db->loadResult();
                        if($pns_op_id)
                        {
                                for($i=1;$i<=2;$i++)
                                {                                                    
                                        $sql = "update apdm_pns_wo_op_final set op_final_value1='".$post['op_final_value1'][$i]."',op_final_value2='".$post['op_final_value2'][$i]."',op_final_value3='".$post['op_final_value3'][$i]."',op_final_value4='".$post['op_final_value4'][$i]."',op_final_value5='".$post['op_final_value5'][$i]."',op_final_value6='".$post['op_final_value6'][$i]."',op_final_value7='".$post['op_final_value7'][$i]."',op_final_updated='" . $datenow->toMySQL() . "',op_final_updated_by=" . $me->get('id') . " where op_final_fail_times = ".$i." and pns_op_id = ".$pns_op_id." and pns_wo_id=".$wo_id;                                      
                                        $db->setQuery($sql);
                                        $db->query();
                                }
                        }
                       
                         //Update step7
                        $wopoStatus7 = "";
                        $wopoStatusTitle7 = "";
                        if($post['op_completed_date7']!="0000-00-00 00:00:00" && $post['op_assigner7']!=0)
                        {
                               // $status ="done";
                                $wopoStatus7 = "done";
                                $wopoStatusTitle7 = "Done";
                                //check done with pass day target
                                $query ="select DATEDIFF('".$post['op_completed_date7']."',date(op_target_date))  from apdm_pns_wo_op where op_code = 'wo_step7' and op_delay_check=0 and wo_id = ".$wo_id;
                                $db->setQuery($query);
                                $delayt = $db->loadResult();
                                //if datecomplte input diff with current target date will be reset op_delay_check for count up 1
                                if($delayt>0)
                                {
                                        $sql= " update apdm_pns_wo_op set op_completed_date ='" . $post['op_completed_date7'] . "'".
                                                 " ,op_delay_check = 1 , op_delay = op_delay + 1".
                                                 " where op_code = 'wo_step7' and wo_id = ".$wo_id;
                                         $db->setQuery($sql);
                                         $db->query();  
                                }                                 
                        }
                        elseif($post['op_assigner7']==0)
						{
						//	$status ="final_inspection";
							$wopoStatus7 = "done";
							$wopoStatusTitle7 = "done";
						}
                                
                        $sql = "update apdm_pns_wo_op set op_target_date='" . $post['op_target_date7'] . "',op_status ='".$wopoStatus7."', op_title ='".$wopoStatusTitle7."',op_comment = '".$post['op_comment7']."',op_delay_date = '".$post['op_completed_date7']."',op_completed_date = '".$post['op_completed_date7']."',op_assigner ='".$post['op_assigner7']."',op_updated='".$datenow->toMySQL()."',op_updated_by='" . $me->get('id') . "' where op_code = 'wo_step7' and wo_id = ".$wo_id;
                        $db->setQuery($sql);
                        $db->query();   
                        //check update op_target_date for implement count number delay step
                        //,op_target_date='".$post['op_target_date2']."'
                        $query ="select DATEDIFF('".$post['op_target_date7']."',date(op_target_date))  from apdm_pns_wo_op where op_code = 'wo_step7' and wo_id = ".$wo_id;
                        $db->setQuery($query);
                        $delayt = $db->loadResult();
                        //if datecomplte input diff with current target date will be reset op_delay_check for count up 1
                        if($delayt>0)
                        {
                                $sql= " update apdm_pns_wo_op set op_target_date ='" . $post['op_target_date7'] . "'".
                                         " ,op_delay_check = 0 ".
                                         " where op_code = 'wo_step7' and wo_id = ".$wo_id;
                                 $db->setQuery($sql);
                                 $db->query();  
                        }
                        //end op 7        
                        //check lastest status 
                        $sql = "select count(*) from apdm_pns_wo_op where wo_id =".$wo_id." and op_assigner !=0  and op_status != 'done'   order by op_code desc";
                        $db->setQuery($sql);                        
                        $totalWodone = $db->loadResult();
                        if($totalWodone==0)
                        {
                                $status ="done";
                        }
                        else
                        {
                               /* $sql = "select * from apdm_pns_wo_op where wo_id =".$wo_id." and op_assigner !=0  and op_status = 'done'   order by op_code desc limit 1";
                                $db->setQuery($sql);    
                                $woResult = $db->loadObjectList();
                                if(count($woResult))
                                {
                                        foreach($woResult as $r)
                                        {                                               
                                                switch($r->op_code)
                                                {
                                                        case 'wo_step1':
                                                                if($r->op_status=='done')
                                                                {
                                                                        $status ="wire_cut";
                                                                }
                                                                break;
                                                        case 'wo_step2':
                                                                if($r->op_status=='done')
                                                                {
                                                                        $status ="kitted";
                                                                }
                                                                break;    
                                                        case 'wo_step3':
                                                                if($r->op_status=='done')
                                                                {
                                                                        $status ="production";
                                                                }
                                                                break;
                                                        case 'wo_step4':
                                                                if($r->op_status=='done')
                                                                {
                                                                        $status ="visual_inspection";
                                                                }
                                                                break;    
                                                        case 'wo_step5':
                                                                if($r->op_status=='done')
                                                                {
                                                                        $status ="final_inspection";
                                                                }
                                                                break;
                                                        case 'wo_step6':
                                                                if($r->op_status=='done')
                                                                {
                                                                        $status ="packaging";
                                                                }
                                                                break;   
                                                        case 'wo_step7':
                                                                if($r->op_status=='done')
                                                                {
                                                                        $status ="done";
                                                                }
                                                                break;                                                

                                                }
                                        }
                                }
                                else
                                {*/
                                     $sql = "select * from apdm_pns_wo_op where wo_id =".$wo_id." and op_assigner !=0  and op_status != 'done'   order by op_code asc limit 1";
                                     $db->setQuery($sql);                                              
                                     $row = $db->loadObject();
                                     switch($row->op_code)
                                                {
                                                        case 'wo_step1':
                                                                $status ="label_printed";
                                                                break;
                                                        case 'wo_step2':
                                                                $status ="wire_cut";                                                                
                                                                break;    
                                                        case 'wo_step3':
                                                                $status ="kitted";
                                                                break;
                                                        case 'wo_step4':
                                                                $status ="production";
                                                                break;    
                                                        case 'wo_step5':
                                                                $status ="visual_inspection";
                                                                break;
                                                        case 'wo_step6':
                                                                $status ="final_inspection";                                                                
                                                                break;   
                                                        case 'wo_step7':
                                                                $status ="packaging";
                                                                break;             
                                                        default:
                                                                $status ="done";

                                                }
                                     
                               // }
                        }
                        $sql= " update apdm_pns_wo set so_id ='" . $post['so_id'] . "'".
                                ",wo_qty = '" . $post['wo_qty'] . "'".
                                ",pns_id = '" .  $partNumber[0] . "'".
                                ",top_pns_id = '" . $post['top_pns_id'] . "'".
                                ",wo_customer_id = '" . $post['wo_customer_id'] . "'".
                                ",wo_state = '" . $status . "'".
                                ",wo_start_date = '" . $post['wo_start_date'] . "'".
                                //",wo_completed_date = '" . $post['wo_completed_date'] . "'".
                                ",wo_updated = '" . $datenow->toMySQL() . "'".
                                ",wo_updated_by = '" . $me->get('id') . "'".
                                ",wo_assigner = '" . $post['wo_assigner'] . "'".
                                ",wo_rma_active='".$post['wo_rma_active']."'".
                                " where pns_wo_id ='".$wo_id."' ";
                        $db->setQuery($sql);
                        $db->query();   
                        //check update wo_completed_date for implement count number delay
                        $query ="select DATEDIFF('".$post['wo_completed_date']."',date(wo_completed_date))  from apdm_pns_wo where pns_wo_id = ".$wo_id;
                        $db->setQuery($query);
                        $delayt = $db->loadResult();
                        //if datecomplte input diff with current complete datewill reset wo_delay_check for count up 1
                        if($delayt>0)
                        {
                                $sql= " update apdm_pns_wo set wo_completed_date ='" . $post['wo_completed_date'] . "'".
                                         " ,wo_delay_check = 0 ".
                                         " where pns_wo_id ='".$wo_id."' ";
                                 $db->setQuery($sql);
                                 $db->query();  
                        }
                        //CHECK ALL WO DONE OR NOT
                        $query ="select count(*) from apdm_pns_wo where so_id = ".$post['so_id'];
                        $db->setQuery($query);
                        $totalWo = $db->loadResult();
                        $query ="select count(*) from apdm_pns_wo where so_id = ".$post['so_id']."  and wo_state= 'done'";
                        $db->setQuery($query);
                        $totalWoDone = $db->loadResult();
                        //SO have 4 status:onhold,cancel,done,inprogress
                        if($totalWoDone == $totalWo)//all WO done
                        {
                                 $sql= "update apdm_pns_so set so_state = 'done' where pns_so_id = ".$post['so_id'];
                                 $db->setQuery($sql);
                                 $db->query();
                        }                        
                        
                }//for save database of pns 
               
                $msg = JText::_('Successfully Updated wo') . $text_mess;
                return $this->setRedirect('index.php?option=com_apdmpns&task=wo_detail&id=' . $wo_id, $msg);                
        }
        function getWoStatus($code)
        {
                $statusValue = array();
                $statusValue[0] = JText::_('Select');
                $statusValue['done'] = JText::_('Done');
                $statusValue['onhold'] = JText::_('On hold');
                $statusValue['cancel'] =  JText::_('Cancel');
                $statusValue['label_printed'] = JText::_('Label Printed');
                $statusValue['wire_cut'] = JText::_('Wire Cut');
                $statusValue['kitted'] = JText::_('Kitted');
                $statusValue['production'] = JText::_('Production');
                $statusValue['visual_inspection'] =  JText::_('Visual Inspection');
                $statusValue['final_inspection'] =  JText::_('Final Inspection');
                $statusValue['packaging'] = JText::_('Packaging');
                echo $statusValue[$code];
        }
        function getWoStep($stepCode)
        {
                $stepValue = array();                
                $stepValue['wo_step1'] = JText::_('Label Printed');
                $stepValue['wo_step2'] = JText::_('Wire Cut');
                $stepValue['wo_step3'] = JText::_('Kitted');
                $stepValue['wo_step4'] = JText::_('Production');
                $stepValue['wo_step5'] =  JText::_('Visual Inspection');
                $stepValue['wo_step6'] =  JText::_('Final Inspection');
                $stepValue['wo_step7'] = JText::_('Packaging');
                echo $stepValue[$stepCode];
        }
        function getSoStatus($statusCode)
        {
                $arrSoStatus =array();   
                $arrSoStatus['inprogress']= JText::_('In Progress');
                $arrSoStatus['onhold'] = JText::_('On Hold');
                $arrSoStatus['cancel'] = JText::_('Cancel');
                $arrSoStatus['done']= JText::_('Done');                               
                echo $arrSoStatus[$statusCode];
        }
        function wo_log()
        {
                JRequest::setVar('layout', 'wo_log');
                JRequest::setVar('view', 'wo');
                //JRequest::setVar('edit', true);
                parent::display();
        }
        function get_list_wo_so()
        {
                JRequest::setVar('layout', 'woforso');
                JRequest::setVar('view', 'getwoforso');
                parent::display();
        }
        function ajax_add_wo_so() {
                $db = & JFactory::getDBO();
                $wo = JRequest::getVar('cid', array(), '', 'array');
                $cid = JRequest::getVar('id', array(), '', 'array');
                $query = "SELECT pns_id,so_id  FROM apdm_pns_so_fk  WHERE so_id = '" . $cid[0] . "' ORDER BY pns_id DESC LIMIT 0, 1 ";
                $db->setQuery($query);
                $row = $db->loadObject();
                
                $db->setQuery("update apdm_pns_wo set so_id = " . $cid[0] . ",top_pns_id = ".$row->pns_id." WHERE  pns_wo_id IN (" . implode(",", $wo) . ")");
                $db->getQuery();
                $db->query();                                
        }
        /*
         * Remove PNS out of STO in STO management 
         */
        function removewoso() {
                $db = & JFactory::getDBO();
                $woids = JRequest::getVar('cid', array(), '', 'array');                        
                $so_id = JRequest::getVar('so_id'); 
                foreach($woids as $wo_id){                                                                                       
                                $db->setQuery("update apdm_pns_wo set so_id = 0,top_pns_id=0 WHERE pns_wo_id = '" . $wo_id . "' AND so_id = " . $so_id . "");
                                $db->query();                                            
                }
                $msg = JText::_('Have removed WO successfull.');
                return $this->setRedirect('index.php?option=com_apdmpns&task=so_detail_wo&id=' . $so_id, $msg);
        }   
        function onholdso()
        {
                $db = & JFactory::getDBO();
                $so_id = JRequest::getVar('id');
                //write log changed wo
                $me = & JFactory::getUser();                
                $datenow = & JFactory::getDate();
                $db->setQuery("SELECT pns_wo_id,so_id,wo_state FROM apdm_pns_wo WHERE so_id=" .$so_id);
                $rows = $db->loadObjectList();          
                $statusAllowHold = array('onhold','done');
                foreach ($rows as $row) {       
                        if(!in_array($row->wo_state,$statusAllowHold)){
                                $db->setQuery("INSERT INTO apdm_pns_wo_history (wo_id, pre_status,cur_status, wo_log_created, wo_log_created_by,wo_log_content) VALUES (" . $row->pns_wo_id . ", '" . $row->wo_state . "','onhold','" . $datenow->toMySQL() . "'," . $me->get('id') . ",'Onhold So') ");                        
                                $db->query();                       
                                $db->setQuery("update apdm_pns_wo set wo_state = 'onhold',wo_state_history ='" . $row->wo_state . "'  WHERE  pns_wo_id = ".$row->pns_wo_id);
                                $db->getQuery();
                                $db->query();   
                        }
                }                                        
                $db->setQuery("update apdm_pns_so set so_state = 'onhold'  WHERE  pns_so_id = ".$so_id);
                $db->getQuery();
                $db->query();                                 
                $msg = JText::_('Have On Hold  successfull.');
                return $this->setRedirect('index.php?option=com_apdmpns&task=so_detail&id=' . $so_id, $msg);
        }
        function inprogressso()
        {
                $db = & JFactory::getDBO();
                $so_id = JRequest::getVar('id');
                //write log changed wo
                $me = & JFactory::getUser();                
                $datenow = & JFactory::getDate();
                $db->setQuery("SELECT pns_wo_id,so_id,wo_state,wo_state_history FROM apdm_pns_wo WHERE so_id=" .$so_id);
                $rows = $db->loadObjectList();              
                foreach ($rows as $row) {  
                        if($row->wo_state=='onhold')
                        {
                                $db->setQuery("INSERT INTO apdm_pns_wo_history (wo_id, pre_status,cur_status, wo_log_created, wo_log_created_by,wo_log_content) VALUES (" . $row->pns_wo_id . ", '" . $row->wo_state . "','" . $row->wo_state_history . "','" . $datenow->toMySQL() . "'," . $me->get('id') . ",'Inprogress So' ) ");                        
                                $db->query();    
                                $db->setQuery("update apdm_pns_wo set wo_state = '" . $row->wo_state_history . "'  WHERE  pns_wo_id = ".$row->pns_wo_id);
                                $db->getQuery();
                                $db->query(); 
                        }
                }                
                
                $db->setQuery("update apdm_pns_so set so_state = 'inprogress'  WHERE  pns_so_id = ".$so_id);
                $db->getQuery();
                $db->query(); 
                $msg = JText::_('Have In Progress SO successfull.');
                return $this->setRedirect('index.php?option=com_apdmpns&task=so_detail&id=' . $so_id, $msg);                                
        }        
        function cancelSo()
        {
                JRequest::setVar('layout', 'inform');
                JRequest::setVar('view', 'userinform');
                parent::display();
        }
        function ajax_cancelso()
        {
                $db = & JFactory::getDBO();
                $datenow = & JFactory::getDate();
                $me = & JFactory::getUser();  
                $so_id = JRequest::getVar('so_id');
                $password =  JRequest::getVar('passwd', '', 'post', 'string', JREQUEST_ALLOWRAW);
                $username = JRequest::getVar('username', '', 'method', 'username');
                $query = "select count(*) from apdm_users where user_password = md5('".$password."') and username='".$username."'";
                $db->setQuery($query);
                $isLogin = $db->loadResult();
                if($isLogin)
                {                        
                        $db->setQuery("SELECT pns_wo_id,so_id,wo_state,wo_state_history FROM apdm_pns_wo WHERE so_id = ".$so_id);                        
                        $rows = $db->loadObjectList();  
                        $statusAllowCancel = array('cancel','done');
                        foreach ($rows as $row) {   
                                if(!in_array($row->wo_state,$statusAllowCancel)){
                                        $db->setQuery("INSERT INTO apdm_pns_wo_history (wo_id, pre_status,cur_status, wo_log_created, wo_log_created_by,wo_log_content) VALUES (" . $row->pns_wo_id . ", '" . $row->wo_state . "','cancel','" . $datenow->toMySQL() . "'," . $me->get('id') . " ,'Cancel So') ");                        
                                        $db->query();                            
                                        $db->setQuery("update apdm_pns_wo set wo_state ='cancel',wo_state_history ='" . $row->wo_state . "'  WHERE  pns_wo_id = ".$row->pns_wo_id);
                                        $db->getQuery();
                                        $db->query();                            
                                }
                        }                                  
                        $db->setQuery("update apdm_pns_so set so_state = 'cancel'  WHERE  pns_so_id = ".$so_id);
                        $db->getQuery();
                        $db->query();  
                        echo 1;
                }
                else
                {
                        echo 0;
                }
                die;                
        }
 /**
         * Cancels an edit operation
         */
        function cancelWo() {
                $wo_id = JRequest::getVar('wo_id');
                if ($wo_id) {
                        $this->setRedirect('index.php?option=com_apdmpns&task=wo_detail&id=' . $wo_id);
                } else {
                        $this->setRedirect('index.php?option=com_apdmpns&task=somanagement');
                }
        }        
       function getWoStepLog($op_id,$log_type=0)
        {
                $db = & JFactory::getDBO();
                $query = "select * FROM apdm_pns_wo_op_log WHERE log_type=".$log_type." and op_id =".$op_id;
                $db->setQuery($query);
                return $rows = $db->loadObjectList();                 
        }
        function save_log_wo()
        {
               // Initialize some variables
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();                
                $datenow = & JFactory::getDate();
                $post = JRequest::get('post');  
                $wo_log =  JRequest::getVar( 'wo_log', '', 'post', 'string', JREQUEST_ALLOWHTML );
                if($wo_log)
                {
                        $db->setQuery("update apdm_pns_wo set wo_log = '".$wo_log."'  WHERE  pns_wo_id = ".$post['wo_id']);
                        $db->getQuery();
                        $db->query(); 
                }
               
                if($_FILES['wo_log_zip']['size']>0){                                        
                        $path_upload = JPATH_SITE . DS . 'uploads' . DS . 'wo';
                        $folder = $post['wo_id'];

                        $path_wo_zips = $path_upload  .DS. $folder . DS;
                        $upload = new upload($_FILES['']);
                        $upload->r_mkdir($path_wo_zips, 0777);                        
                        $arr_file_upload = array();
                        $arr_error_upload_zips = array();
                       // for ($i = 1; $i <= 20; $i++) {       
                        if ($_FILES['wo_log_zip']['size'] > 0) {
								if($_FILES['wo_log_zip']['size']<20000000)
								{
									if (!move_uploaded_file($_FILES['wo_log_zip' . $i]['tmp_name'], $path_wo_zips . $_FILES['wo_log_zip']['name'])) {
											$arr_error_upload_zips[] = $_FILES['wo_log_zip']['name'];
									} else {
											$arr_file_upload[] = $_FILES['wo_log_zip']['name'];
									}
								}
								else
								{
									$msg = JText::_('Please upload file less than 20MB.');
										return $this->setRedirect('index.php?option=com_apdmpns&task=wo_log&id='.$post['wo_id'], $msg);    
								}
                        }
                        
                        
                       // }
                        if (count($arr_file_upload) > 0) {
                                foreach ($arr_file_upload as $file) {
                                        $db->setQuery("INSERT INTO apdm_pns_wo_files (wo_id, file_name,file_type, wo_file_create, wo_file_created_by) VALUES (" . $post['wo_id'] . ", '" . $file . "',0, '" . $datenow->toMySQL() . "', " . $me->get('id') . " ) ");
                                        $db->query();
                                }
                        }      
                }
                if($_FILES['wo_log_pdf']['size']>0){                                        
                        $path_upload = JPATH_SITE . DS . 'uploads' . DS . 'wo' . DS;
                        $folder = $post['wo_id'];

                        $path_wo_zips = $path_upload  .DS. $folder . DS;
                        $upload = new upload($_FILES['']);
                        $upload->r_mkdir($path_wo_zips, 0777);                        
                        $arr_file_upload = array();
                        $arr_error_upload_zips = array();
                       // for ($i = 1; $i <= 20; $i++) {                              
                                if ($_FILES['wo_log_pdf']['size'] > 0) {
									if($_FILES['wo_log_pdf']['size']<20000000)
									{
                                        if (!move_uploaded_file($_FILES['wo_log_pdf' . $i]['tmp_name'], $path_wo_zips . $_FILES['wo_log_pdf']['name'])) {
                                                $arr_error_upload_zips[] = $_FILES['wo_log_pdf']['name'];
                                        } else {
                                                $arr_file_upload[] = $_FILES['wo_log_pdf']['name'];
                                        }
									}
									else
									{
										$msg = JText::_('Please upload file less than 20MB.');
											return $this->setRedirect('index.php?option=com_apdmpns&task=wo_log&id='.$post['wo_id'], $msg);    
									}
                                }
                                
                       // }

                        if (count($arr_file_upload) > 0) {
                                foreach ($arr_file_upload as $file) {
                                        $db->setQuery("INSERT INTO apdm_pns_wo_files (wo_id, file_name,file_type, wo_file_create, wo_file_created_by) VALUES (" . $post['wo_id'] . ", '" . $file . "', 1,'" . $datenow->toMySQL() . "', " . $me->get('id') . " ) ");
                                        $db->query();
                                }
                        }      
                }       
                if($_FILES['wo_log_image']['size']>0){                                        
                        $path_upload = JPATH_SITE . DS . 'uploads' . DS . 'wo' . DS;
                        $folder = $post['wo_id'];

                        $path_wo_zips = $path_upload  .DS. $folder . DS;
                        $upload = new upload($_FILES['']);
                        $upload->r_mkdir($path_wo_zips, 0777);                        
                        $arr_file_upload = array();
                        $arr_error_upload_zips = array();
                       // for ($i = 1; $i <= 20; $i++) {                                
                                if ($_FILES['wo_log_image']['size'] > 0) {
									if($_FILES['wo_log_image']['size']<20000000)
									{
                                        if (!move_uploaded_file($_FILES['wo_log_image' . $i]['tmp_name'], $path_wo_zips . $_FILES['wo_log_image']['name'])) {
                                                $arr_error_upload_zips[] = $_FILES['wo_log_image']['name'];
                                        } else {
                                                $arr_file_upload[] = $_FILES['wo_log_image']['name'];
                                        }
									}
									else
									{
										$msg = JText::_('Please upload file less than 20MB.');
											return $this->setRedirect('index.php?option=com_apdmpns&task=wo_log&id='.$post['wo_id'], $msg);    
									}
                                }
                                
                       // }

                        if (count($arr_file_upload) > 0) {
                                foreach ($arr_file_upload as $file) {
                                        $db->setQuery("INSERT INTO apdm_pns_wo_files (wo_id, file_name,file_type, wo_file_create, wo_file_created_by) VALUES (" . $post['wo_id'] . ", '" . $file . "', 2,'" . $datenow->toMySQL() . "', " . $me->get('id') . " ) ");
                                        $db->query();
                                }
                        }      
                }                  
                //save log for delay
                foreach($post['op_log_comment'] as $id=>$val)
                {                     
                        if($val)
                        {
                                $query = "INSERT INTO apdm_pns_wo_op_log (wo_id,op_id,op_log_assigner,op_log_comment,op_log_updated,op_log_updated_by,log_type) VALUES (" . $post['wo_id'] . ", '" . $id . "', '" . $me->get('id') . "', '".$val."','". $datenow->toMySQL()."'," . $me->get('id') . ",0)";
                                $db->setQuery($query);
                                $db->query();
                        }
                }
                //save log for rework
                foreach($post['op_logrework_comment'] as $id=>$val)
                {                    
                        if($val)
                        {
                                $failtime = $post['fail_time'][$id];
                                $query = "INSERT INTO apdm_pns_wo_op_log (wo_id,op_id,op_log_assigner,op_log_comment,op_log_updated,op_log_updated_by,log_type) VALUES (" . $post['wo_id'] . ", '" . $id . "', '" . $me->get('id') . "', '".$val."','". $datenow->toMySQL()."'," . $me->get('id') . ",$failtime)";
                                $db->setQuery($query);
                                $db->query();
                        }
                }
                
                return $this->setRedirect('index.php?option=com_apdmpns&task=wo_log&id='.$post['wo_id']);
        }
        function getReworkStep($wo_id,$step=0)
        {
                $db = & JFactory::getDBO();
                if($step==="wo_step5"){
                        
                 $queryRework = 'select count(*) as rework_time'.
                               ' from apdm_pns_wo_op op '.
                               ' inner join  apdm_pns_wo_op_visual vi on op.pns_op_id =vi.pns_op_id '.
                               ' where (op_visual_value1 != "" or op_visual_value2 != "" or op_visual_value3 != "" or op_visual_value4 != "" or op_visual_value5 != "") '.
                               ' and  op.wo_id ='.$wo_id.' and op.op_code = "wo_step5"';
                 $db->setQuery($queryRework);
                 $row = $db->loadResult();    
                }    
                elseif($step==="wo_step6"){
                   $queryRework = 'select count(*) as rework_time'.
                               ' from apdm_pns_wo_op op '.
                               ' inner join  apdm_pns_wo_op_final fi on op.pns_op_id =fi.pns_op_id '.
                               ' where (op_final_value1 != "" or op_final_value2 != "" or op_final_value3 != "" or op_final_value4 != "" or op_final_value5 != "" or op_final_value6 != "" or op_final_value7 != "")'.
                               ' and  op.wo_id ='.$wo_id.' and op.op_code = "wo_step6"';
                  $db->setQuery($queryRework);
                  $row = $db->loadResult();    
                }
                elseif($step===0)
                {
                        
                        $queryRework = 'select count(*) as rework_time'.
                               ' from apdm_pns_wo_op op '.
                               ' inner join  apdm_pns_wo_op_visual vi on op.pns_op_id =vi.pns_op_id '.
                               ' where (op_visual_value1 != "" or op_visual_value2 != "" or op_visual_value3 != "" or op_visual_value4 != "" or op_visual_value5 != "") '.
                               ' and  op.wo_id ='.$wo_id.' and op.op_code = "wo_step5"';
                         $db->setQuery($queryRework);
                          $rowStep5 = $db->loadResult(); 
                          $queryRework = ' select count(*) as rework_time'.
                               ' from apdm_pns_wo_op op '.
                               ' inner join  apdm_pns_wo_op_final fi on op.pns_op_id =fi.pns_op_id '.
                               ' where (op_final_value1 != "" or op_final_value2 != "" or op_final_value3 != "" or op_final_value4 != "" or op_final_value5 != "" or op_final_value6 != "" or op_final_value7 != "")'.
                               ' and  op.wo_id ='.$wo_id.' and op.op_code = "wo_step6"';
                           $db->setQuery($queryRework);
                          $rowStep6 = $db->loadResult(); 
                         $row = $rowStep5+$rowStep6;
                }
               return $row;
                
                            
        }
        function getDelayTimes($wo_id)
        {
                $db = & JFactory::getDBO();
                $query = "select DATEDIFF(CURDATE(),op_target_date) as step_delay_date".
                          " from apdm_pns_wo_op op inner join apdm_pns_wo wo on op.wo_id = wo.pns_wo_id".
                          " inner join  apdm_pns_so so on so.pns_so_id = wo.so_id".
                          " inner join apdm_ccs ccs on so.customer_id = ccs.ccs_code".
                          " where wo.pns_wo_id = ".$wo_id." and op_status ='pending' and op_completed_date = '0000-00-00 00:00:00'  and DATEDIFF(CURDATE(),op_target_date) > 0";
                
                 $db->setQuery($query);
                return $row = $db->loadResult();  
        }
        function removestos()
        {
                $db = & JFactory::getDBO();
                $cid = JRequest::getVar('cid', array(), '', 'array');
                JArrayHelper::toInteger($cid);
                if (count($cid) < 1) {
                        JError::raiseError(500, JText::_('Select a STO to delete', true));
                }
                foreach ($cid as $id) {
                        $db->setQuery("DELETE FROM apdm_pns_sto_fk WHERE sto_id = '" . $id . "'");
                        $db->query();                    
                        $db->setQuery("DELETE FROM apdm_pns_sto WHERE pns_sto_id = '" . $id . "'");
                        $db->query();                    
                }
                $msg = JText::_('Have removed successfull.');
                return $this->setRedirect('index.php?option=com_apdmpns&task=stomanagement', $msg);
        }
        function removepos()
        {
                $db = & JFactory::getDBO();
                $cid = JRequest::getVar('cid', array(), '', 'array');
                JArrayHelper::toInteger($cid);
                if (count($cid) < 1) {
                        JError::raiseError(500, JText::_('Select a PO to delete', true));
                }
                foreach ($cid as $id) {
                        $db->setQuery("DELETE FROM apdm_pns_po_fk WHERE po_id = '" . $id . "'");
                        $db->query();                    
                        $db->setQuery("DELETE FROM apdm_pns_po WHERE pns_po_id = '" . $id . "'");
                        $db->query();                    
                }
                $msg = JText::_('Have removed successfull.');
                return $this->setRedirect('index.php?option=com_apdmpns&task=pomanagement', $msg);
        }
        function getSofomId($so_id)
{
    $db = & JFactory::getDBO();
    $db->setQuery("SELECT so.*,ccs.ccs_coordinator,ccs.ccs_code from apdm_pns_so so inner join apdm_ccs ccs on so.customer_id = ccs.ccs_code where so.pns_so_id=".$so_id);
    $row =  $db->loadObject();
    $soNumber = $row->so_cuscode;
    if($row->ccs_code)
    {
        $soNumber = $row->ccs_code."-".$soNumber;
    }
    $array = array();
    $array['so_id'] = $so_id;
    $array['so_code'] = $soNumber;
    $array['so_shipping_date'] = $row->so_shipping_date;
    $array['so_start_date'] = $row->so_start_date;
    return $array;
}
          /*
         * 
         * add bom tab in pn detail
         */

        function searchadvance() {
                JRequest::setVar('layout', 'default');
                JRequest::setVar('layout', 'default');
                JRequest::setVar('view', 'searchsowo');
                parent::display();
        }
        function rmTopAssysSo() {
                $db = & JFactory::getDBO();
                $cid = JRequest::getVar('cid', array(), '', 'array');
                $so_id = JRequest::getVar('so_id');           
                 //CHECK ALL WO DONE OR NOT
                //tmp allow save RMA withstatus !=cancel
                $query ="select count(*) from apdm_pns_so where so_state != 'done' and pns_so_id = ".$so_id;
                $db->setQuery($query);
                $soDone = $db->loadResult();
                if($soDone)
                {                                       
                        foreach ($cid as $id) {                                                   
                                $db->setQuery("delete from apdm_pns_so_fk  WHERE  id = " . $id . " and so_id = ".$so_id);
                                $db->query();
                        }                       
                }
                else
                {
                        $msg = "The SO Status is Doneso  can not remove PN";
                }
               
                
                $this->setRedirect('index.php?option=com_apdmpns&task=so_detail&id=' . $so_id, $msg);
        }     
        function informDelSo()
        {
                JRequest::setVar('layout', 'inform_del_so');
                JRequest::setVar('view', 'userinform');
                parent::display();
        }
        function onholdwopop()
        {
                JRequest::setVar('layout', 'onholdpopup');
                JRequest::setVar('view', 'wo');                 
                $woids = JRequest::getVar('wo_ids');                    
                JRequest::setVar('woids', $woids);
                parent::display();
        }
        function saveonholdwo()
        {
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();  
                $so_id = JRequest::getVar('id');
                $wo_ids = JRequest::getVar('wo_ids');
                $wo_log_content = JRequest::getVar('wo_history_reason');
                //write log changed wo                             
                $datenow = & JFactory::getDate();
                $db->setQuery("SELECT pns_wo_id,so_id,wo_state FROM apdm_pns_wo WHERE pns_wo_id in (" .$wo_ids.")");               
                $rows = $db->loadObjectList();     
                $StatusallowHold = array('onhold','done');
                foreach ($rows as $row) {     
                        if(!in_array($row->wo_state, $StatusallowHold)){
                                $db->setQuery("INSERT INTO apdm_pns_wo_history (wo_id, pre_status,cur_status, wo_log_created, wo_log_created_by,wo_log_content) VALUES (" . $row->pns_wo_id . ", '" . $row->wo_state . "','onhold','" . $datenow->toMySQL() . "'," . $me->get('id') . " ,'".$wo_log_content."') ");                        
                                $db->query();                            
                                $db->setQuery("update apdm_pns_wo set wo_state = 'onhold',wo_state_history ='" . $row->wo_state . "'  WHERE  pns_wo_id = ".$row->pns_wo_id);
                                $db->getQuery();
                                $db->query();   
                        }
                }                                   
        }        
        function inprogresswopop()
        {
                JRequest::setVar('layout', 'inprogresswopop');
                JRequest::setVar('view', 'wo');                 
                $woids = JRequest::getVar('wo_ids');                    
                JRequest::setVar('woids', $woids);
                parent::display();
        }
        function  saveinprogresswo()
        {
                
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();  
                $so_id = JRequest::getVar('id');
                $wo_ids = JRequest::getVar('wo_ids');
                $wo_log_content = JRequest::getVar('wo_history_reason');
                //write log changed wo                             
                $datenow = & JFactory::getDate();
                $db->setQuery("SELECT pns_wo_id,so_id,wo_state,wo_state_history FROM apdm_pns_wo WHERE pns_wo_id in (" .$wo_ids.")");               
                $rows = $db->loadObjectList();              
                foreach ($rows as $row) {       
                        if($row->wo_state=='onhold')
                        {
                                $db->setQuery("INSERT INTO apdm_pns_wo_history (wo_id, pre_status,cur_status, wo_log_created, wo_log_created_by,wo_log_content) VALUES (" . $row->pns_wo_id . ", '" . $row->wo_state . "','" . $row->wo_state_history . "','" . $datenow->toMySQL() . "'," . $me->get('id') . " ,'".$wo_log_content."') ");                        
                                $db->query();                            
                                $db->setQuery("update apdm_pns_wo set wo_state ='" . $row->wo_state_history . "'  WHERE  pns_wo_id = ".$row->pns_wo_id);
                                $db->getQuery();
                                $db->query();   
                        }
                }                                      
        }            
        
        function informcancelwopop()
        {
                JRequest::setVar('layout', 'inform_cancel_wo');
                JRequest::setVar('view', 'userinform');                 
                $woids = JRequest::getVar('wo_ids');                    
                JRequest::setVar('woids', $woids);
                parent::display();
        }
        function ajax_cancelwo()
        {
                $db = & JFactory::getDBO();
                $so_id = JRequest::getVar('so_id');
                $password =  JRequest::getVar('passwd', '', 'post', 'string', JREQUEST_ALLOWRAW);
                $username = JRequest::getVar('username', '', 'method', 'username');
                $query = "select count(*) from apdm_users where user_password = md5('".$password."') and username='".$username."'";
                $db->setQuery($query);
                $isLogin = $db->loadResult();
                if($isLogin)
                {   
                        echo 1;
                }
                else
                {
                        echo 0;
                }
                die;
                
        }        
        function cancelwopop()
        {
                JRequest::setVar('layout', 'cancelwopop');
                JRequest::setVar('view', 'wo');                 
                $woids = JRequest::getVar('wo_ids');                    
                JRequest::setVar('woids', $woids);
                parent::display();
        }       
        function  savecancelwopop()
        {
                
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();  
                $so_id = JRequest::getVar('id');
                $wo_ids = JRequest::getVar('wo_ids');
                $wo_log_content = JRequest::getVar('wo_history_reason');
                //write log changed wo                             
                $datenow = & JFactory::getDate();
                $db->setQuery("SELECT pns_wo_id,so_id,wo_state,wo_state_history FROM apdm_pns_wo WHERE pns_wo_id in (" .$wo_ids.")");               
                $rows = $db->loadObjectList();              
                $StatusallowCancel = array('cancel','done');                                       				
                foreach ($rows as $row) {   
                        if(!in_array($row->wo_state, $StatusallowCancel))
                        {
                                $db->setQuery("INSERT INTO apdm_pns_wo_history (wo_id, pre_status,cur_status, wo_log_created, wo_log_created_by,wo_log_content) VALUES (" . $row->pns_wo_id . ", '" . $row->wo_state . "','cancel','" . $datenow->toMySQL() . "'," . $me->get('id') . " ,'".$wo_log_content."') ");                        
                                $db->query();                            
                                $db->setQuery("update apdm_pns_wo set wo_state ='cancel',wo_state_history ='" . $row->wo_state . "'  WHERE  pns_wo_id = ".$row->pns_wo_id);
                                $db->getQuery();
                                $db->query();                            
                        }
                }                                      
        } 
        function so_detail_wo_history()
        {
                JRequest::setVar('layout', 'so_detail_wo_history');
                JRequest::setVar('view', 'so');
                parent::display();
        }
        function getTopAssysWo($woId)
        {
                 $db = & JFactory::getDBO();
                $db->setQuery('select p.pns_cpn,p.pns_id,p.ccs_code, p.pns_code, p.pns_revision from apdm_pns p inner join apdm_pns_wo wo on p.pns_id = wo.top_pns_id where wo.pns_wo_id =' . $woId);
                $row =  $db->loadObject();
                 if ($row->pns_revision) {
                        $partNumber = $row->ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                } else {
                        $partNumber = $row->ccs_code . '-' . $row->pns_code;
                }            
                if ($row->pns_cpn == 1)
                        $link = '<a href="index.php?option=com_apdmpns&amp;task=detailmpn&cid[0]=' . $row->pns_id.'">'.$partNumber.'</a>';
                else
                        $link = '<a href="index.php?option=com_apdmpns&amp;task=detail&cid[0]=' . $row->pns_id.'">'.$partNumber.'</a>'; 
                return $link;                
        }
		function getcoordinatorso($ccs_code)
		{
			$db =& JFactory::getDBO();					
			$ccs_coordinator = 0;
			$query = " SELECT ccs_coordinator FROM apdm_ccs WHERE ccs_code='".$ccs_code."'";
			$db->setQuery($query);
			$ccs_coordinator = $db->loadResult();
			echo $ccs_coordinator;

		}        
		function checkStepBeforeDone($step,$wo_id)
		{
			$db =& JFactory::getDBO();	
			$lastNumber = substr($step, -1);
			$sql = "SELECT count(*) FROM `apdm_pns_wo_op` WHERE  SUBSTR(op_code, -1) < ".$lastNumber." and `wo_id` = '".$wo_id."' and op_assigner != 0  and op_status != 'done'";
			$db->setQuery($sql);
			$check_exist = $db->loadResult();
			if ($check_exist==0) {				
				return 1;
			}			
			return 0;
											
		}
		function print_bom_pns()
        {
            JRequest::setVar('layout', 'bom_print');
            JRequest::setVar('view', 'listpns');
            parent::display();
        }
        function GetEtoPns($pns_id)
        {
                $db =& JFactory::getDBO();	
                $query = "SELECT p.pns_id,fk.qty,fk.sto_id,sto.sto_state  FROM apdm_pns_sto_fk AS fk inner JOIN apdm_pns_sto sto on sto.pns_sto_id = fk.sto_id inner join apdm_pns AS p on p.pns_id = fk.pns_id where fk.pns_id = ".$pns_id." and sto.sto_isdelivery_good = 1 and sto.sto_type = 2 and sto.sto_state = 'InTransit'";
                $db->setQuery($query);
                return $db->loadObjectList();

                
        }
        function quickViewWo()
        {
            JRequest::setVar('layout', 'scanscreen');
            JRequest::setVar('view', 'wo');
            parent::display();
        }
        function getWoScan()
        {
            $db =& JFactory::getDBO();
            $wo_code = JRequest::getVar('wo_code');
            $query = "SELECT pns_wo_id FROM apdm_pns_wo where wo_code  = '".trim($wo_code)."'";
            $db->setQuery($query);
            $pns_wo_id = $db->loadResult();
            if ($pns_wo_id) {
                return $this->setRedirect('index.php?option=com_apdmpns&task=wo_detail&id='.$pns_wo_id);
            }
            return  $this->setRedirect('index.php?option=com_apdmpns&task=somanagement');
        }
        function get_pntoolboom()
        {                
                JRequest::setVar('layout', 'default');
                JRequest::setVar('view', 'getpnstoolbom');
                parent::display();
        }
        function ajax_add_pnstool_bom()
        {
                $db = & JFactory::getDBO();
                $pns = JRequest::getVar('cid', array(), '', 'array');
                $parent_id = JRequest::getVar('pns_id');                  
                //innsert to FK table                
                foreach($pns as $pn_id)
                {
                        $db->setQuery("INSERT INTO apdm_pns_tool_bom (pns_id,pns_tool_id) VALUES ( '" . $parent_id . "','" . $pn_id . "')");
                        $db->query();                         
                }                 
                return $msg = JText::_('Have add Tool PN successfull.');
        }
        function ajax_scanadd_pnstool_bom()
        {
                $db = & JFactory::getDBO();
                $parent_id = JRequest::getVar('pns_id');   
                $pns_code = JRequest::getVar('pns_code');   
                $arrPn = explode("-", $pns_code);
        //A02-200263-0A
                $ccs_code = $arrPn[0];
                $pns_code = $arrPn[1];
                $pns_revision = $arrPn[2];
        //K01-0262499-000

                if($arrPn[4])
                {
                    $pns_code = $arrPn[1]."-".$arrPn[2]."-".$arrPn[3];
                    $pns_revision = $arrPn[4];
                }
                elseif($arrPn[3] &&!$arrPn[4])
                {
                    $pns_code = $arrPn[1]."-".$arrPn[2];
                    $pns_revision = $arrPn[3];

                }
                if($arrPn[3] || $arrPn[4])
                {
                       // $pns_revision = $arrPn[3];
                        $query = "select pns_id from apdm_pns where ccs_code = '".$ccs_code."' and pns_code = '".$pns_code."' and pns_revision = '".$pns_revision."'";

                }
                else {
                        if(preg_match("/^[0-9]+$/i", $arrPn[2]))
                        {
                            $pns_code = $arrPn[1]."-".$arrPn[2];
                            $query = "select pns_id from apdm_pns where ccs_code = '".$ccs_code."' and pns_code = '".$pns_code."'";
                        }
                        else
                        {
                            $pns_code = $arrPn[1];
                            $pns_revision = $arrPn[2];
                            $query = "select pns_id from apdm_pns where ccs_code = '".$ccs_code."' and pns_code = '".$pns_code."' and pns_revision = '".$pns_revision."'";
                        }
                }
                $db->setQuery($query);
                $pns_id = $db->loadResult();                                           
                $msg = JText::_('Have add PN successfull.');  
                if(!$pn_id || $pn_id==$parent_id)
                {
                        $msg = JText::_('Can not add this PN.');  
                }
                else
                {
                        $db->setQuery("INSERT INTO apdm_pns_tool_bom (pns_id,pns_tool_id) VALUES ( '" . $parent_id . "','" . $pn_id . "')");
                        $db->query(); 
                }              
                $db = & JFactory::getDBO();
                $db->setQuery("select tool.id,p.pns_cpn, p.pns_life_cycle, p.pns_description,p.pns_cpn,p.pns_id,p.pns_stock,p.ccs_code, p.pns_code, p.pns_revision,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  from apdm_pns  p inner join apdm_pns_tool_bom tool on p.pns_id = tool.pns_tool_id where tool.pns_id = ".$parent_id);
                $rows= $db->loadObjectList();     
                 $str = '<table class="adminlist" cellspacing="1" width="100%"><tr>'.
                        '<th width="2%" align="center" class="key">No.</th>'.
                        '<th  align="center" width="15%" class="key">Tool PN</th>'.
                        '<th align="center" width="5%" class="key"></th>'.
                        '</tr>';
                 $i=0;
                foreach ($rows as $row) {
                        $i++;
                        if($row->pns_cpn==1)
                                $link_pndetail 	= 'index.php?option=com_apdmpns&task=detailmpn&cid[0]='.$row->pns_id;
                        else
                                $link_pndetail 	= 'index.php?option=com_apdmpns&task=detail&cid[0]='.$row->pns_id;
                         if ($row->pns_revision) {
                                $pnNumber = $row->ccs_code . '-' . $row->pns_code . '-' . $row->pns_revision;
                        } else {
                                $pnNumber = $row->ccs_code . '-' . $row->pns_code;
                        }           
                      $link_remove = "index.php?option=com_apdmpns&task=removetoolbom&id=".$row->id."&pns_id=". $parent_id;
                        $str .= '<tr>'.
                                ' <td width="2%"  align="center">'.$i.'</td>'.
                                ' <td align="left"><a href="'.$link_pndetail.'" />'.$pnNumber.'</a></td>'.                                
                                ' <td align="center"><a href="'.$link_remove.'" />Remove</a></td></tr>';
                }
                $str .='</table>';
                echo $str.'^^^'.$msg;
                exit;
                
                
        }        
        
        function getToolPnAddtoBom($pns_id)
        {
                $db = & JFactory::getDBO();
                $db->setQuery("select tool.id, p.pns_life_cycle, p.pns_description,p.pns_cpn,p.pns_id,p.pns_stock,p.ccs_code, p.pns_code, p.pns_revision,CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  from apdm_pns  p inner join apdm_pns_tool_bom tool on p.pns_id = tool.pns_tool_id where tool.pns_id = ".$pns_id);
                return $db->loadObjectList();                
        }
        function removetoolbom()
        {
                $db = & JFactory::getDBO();
                $parent_id = JRequest::getVar('pns_id');      
                $id = JRequest::getVar('id');  
                $query = "Delete from apdm_pns_tool_bom WHERE id=" . $id ." and pns_id = ".$parent_id;                        
                $db->setQuery($query);
                $db->query();
                $msg = JText::_('Have add remove Tool PN successfull.');
                $query = "select pns_cpn from apdm_pns where pns_id = ".$parent_id;
                $db->setQuery($query);
                $pns_cpn = $db->loadResult();
                if($pns_cpn==1)
                        $link 	= 'index.php?option=com_apdmpns&task=detailmpn&cid[0]='.$parent_id;	
                else
                        $link 	= 'index.php?option=com_apdmpns&task=detail&cid[0]='.$parent_id;	
                return $this->setRedirect($link,$msg);
        }
        function getBarcodeScan()
        {
                // ECO,ITO,ETO,TTO,WO 
                $db =& JFactory::getDBO();
                $bar_code = JRequest::getVar('wo_code');
                $leght = strlen (trim($bar_code));
                if($leght==5)
                {
                        $query = "SELECT eco_id FROM apdm_eco where eco_name  = ' ".trim($bar_code)."'";
                        $db->setQuery($query);
                        $eco_id = $db->loadResult();
                        if($eco_id){
                                return $this->setRedirect('index.php?option=com_apdmeco&task=detail&scan=1&cid[]=' . $eco_id);
                        }
                        else
                        {
                                $msg = 'Not found any ECO';
                               // return $this->setRedirect('index.php?option=com_apdmeco&task=dashboard',$msg);
                         }
                }
                elseif($leght==8)
                {
                        $query = "SELECT pns_wo_id FROM apdm_pns_wo where wo_code =  '".trim($bar_code)."'";
                        $db->setQuery($query);
                        $wo_id = $db->loadResult();
                        if($wo_id){
                                return $this->setRedirect('index.php?option=com_apdmpns&task=wo_detail&scan=1&id=' . $wo_id);                        
                        }
                         else
                        {
                                $msg = 'Not found any WO';
                                //return $this->setRedirect('index.php?option=com_apdmeco&task=dashboard',$msg);
                         }
                }
                else
                {                        
                        if(preg_match("/I/i",$bar_code))
                        {
                                $query = "SELECT pns_sto_id FROM apdm_pns_sto where sto_code  = '".trim($bar_code)."'";
                                $db->setQuery($query);
                                $ito_id = $db->loadResult();
                                if($ito_id)
                                {
                                        return $this->setRedirect('index.php?option=com_apdmsto&task=ito_detail&scan=1&id=' . $ito_id);                                
                                }
                                else
                                {
                                        $msg = 'Not found any ITO';
                                       // return $this->setRedirect('index.php?option=com_apdmeco&task=dashboard',$msg);
                                 }
                        }
                        elseif(preg_match("/E/i",$bar_code))
                        {
                                $query = "SELECT pns_sto_id FROM apdm_pns_sto where sto_code  = '".trim($bar_code)."'";
                                $db->setQuery($query);
                                $eto_id = $db->loadResult();
                                if($eto_id){
                                        return $this->setRedirect('index.php?option=com_apdmsto&task=eto_detail&scan=1&id=' . $eto_id);                                                                
                                }
                                else
                                {
                                        $msg = 'Not found any ETO';
                                      //  return $this->setRedirect('index.php?option=com_apdmeco&task=dashboard',$msg);
                                 }
                        }
                         elseif(preg_match("/T/i",$bar_code))
                         {
                                 
                                $query = "SELECT pns_tto_id FROM apdm_pns_tto where tto_code = '".trim($bar_code)."'";
                                $db->setQuery($query);
                                $tto_id = $db->loadResult();
                                if($tto_id)
                                {
                                        return $this->setRedirect('index.php?option=com_apdmtto&task=tto_detail&scan=1&id=' . $tto_id);                                
                                }
                                else
                                {
                                        $msg = 'Not found any Tool';
                                       // return $this->setRedirect('index.php?option=com_apdmeco&task=dashboard&i='.time(),$msg);
                                      
                                 }
                        }
                        else{//for PN
                            $pns_id = PNsController::getPnsIdfromPnCode($bar_code);
                            if($pns_id) {
                                $query = "select pns_cpn from apdm_pns where pns_id = " . $pns_id;
                                $db->setQuery($query);
                                $pns_cpn = $db->loadResult();
                                $link = 'index.php?option=com_apdmpns&task=detail&cid[0]=' . $pns_id;
                                if ($pns_cpn == 1)
                                    $link = 'index.php?option=com_apdmpns&task=detailmpn&cid[0]=' . $pns_id;
                                return $this->setRedirect($link);
                            }
                            else
                            {
                                    $msg = 'Not found any PN';
                                //return $this->setRedirect('index.php?option=com_apdmeco&task=dashboard',$msg);
                            }
                        }
                }
            return  $this->setRedirect('index.php?option=com_apdmeco&task=dashboard',$msg);
        }
        function getPnsIdfromPnCode($pn_code)
        {            
                $db =& JFactory::getDBO();
                $arrPn = explode("-", $pn_code);
        //A02-200263-0A
                $ccs_code = $arrPn[0];
                $pns_code = $arrPn[1];
                $pns_revision = $arrPn[2];
        //K01-0262499-000

                if($arrPn[4])
                {
                    $pns_code = $arrPn[1]."-".$arrPn[2]."-".$arrPn[3];
                    $pns_revision = $arrPn[4];
                }
                elseif($arrPn[3] &&!$arrPn[4])
                {
                    $pns_code = $arrPn[1]."-".$arrPn[2];
                    $pns_revision = $arrPn[3];

                }
                if($arrPn[3] || $arrPn[4])
                {
                       // $pns_revision = $arrPn[3];
                        $query = "select pns_id from apdm_pns where ccs_code = '".$ccs_code."' and pns_code = '".$pns_code."' and pns_revision = '".$pns_revision."'";

                }
                else {
                        if(preg_match("/^[0-9]+$/i", $arrPn[2]))
                        {
                            $pns_code = $arrPn[1]."-".$arrPn[2];
                            $query = "select pns_id from apdm_pns where ccs_code = '".$ccs_code."' and pns_code = '".$pns_code."'";
                        }
                        else
                        {
                            $pns_code = $arrPn[1];
                            $pns_revision = $arrPn[2];
                            $query = "select pns_id from apdm_pns where ccs_code = '".$ccs_code."' and pns_code = '".$pns_code."' and pns_revision = '".$pns_revision."'";
                        }
                }
                $db->setQuery($query);
               return $pns_id = $db->loadResult();    
        }
        function copy_filespec_pns()
        {
                global $dirarray, $conf, $dirsize;
                $db = & JFactory::getDBO();
                $me = & JFactory::getUser();                
                $datenow = & JFactory::getDate();
                
                $src  = JPATH_SITE . DS . 'uploads' . DS . 'temp' . DS; 
                $src_dest = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS. 'cads'. DS ;     
                chdir($src); // in this way glob() can give us just the file names
                //T04-123456789---sdfsdfsd (1).pdf
               // foreach(glob('T04-123456789---*') as $name) {
              //      rename($src.$name, $dest.$name);
               // }
              //  shell_exec("cp -r $src $dest");               
                
                $zdir[] = $src;

                $dirarray = array();
                $dirsize = 0;
                $zdirsize = 0;
                for ($i = 0; $i < count($zdir); $i++) {
                     
                        $ffile = $zdir[$i];
                        if (is_dir($ffile)) {
                                getdir($ffile);
                        } else {

                                if ($fsize = @filesize($ffile))
                                        $zdirsize+=$fsize;
                        }
                }

                $zdirsize+=$dirsize;

                for ($i = 0; $i < count($dirarray); $i++) {
                        $zdir[] = $dirarray[$i];
                        
                }
                
                foreach($zdir as $file)   {   
                        if (is_file($file)){
                        $data = implode("",file($file));
                         $file= substr(end(explode("\\", $file)),1);     
                                  list($pns,$prefix_file) = explode("---", $file);
  
                                $pns_arr = explode("-", $pns);
                                $dest = $src_dest . DS . $pns_arr[0]. DS . $pns;
                                $arr_success = array();
                                $arr_fail = array();
                                 $file_name =  $pns.'---'.$prefix_file;
                                if(rename($src.$file, $dest . DS.$file_name))
                                {
                                        $pns_id = PNsController::getPnsIdfromPnCode($pns);
                                        if($pns_id){
                                                $arr_succes[$file_name]=  $pns_id;                                         
                                                $db->setQuery("INSERT INTO apdm_pn_cad (pns_id, cad_file, date_create, created_by) VALUES (" . $pns_id . ", '" . $file_name . "', '" . $datenow->toMySQL() . "', " . $me->get('id') . " ) ");
                                                $db->query();
                                        }
                                        
                                }
                                else
                                {
                                        $arr_fail[]=  $file;
                                }
                        }
		}
                echo "Import Specification Complete with result below";
                echo "<br>";
                echo "Sucesssfull:<br>";
                $arr =array();
                foreach ($arr_succes as $file_name =>$pns_id)
                {
                        $arr[]= "<a href='index.php?option=com_apdmpns&task=specification&cid[]=".$pns_id."'>".$file_name."</a><br>";
                }
                echo "<br>Failed:";
                foreach ($arr_fail as $val)
                {
                        $arr[] = $val."<br>";
                }
                
                 $file = fopen($src."import_spec_result.txt","w");                 
                 fwrite($file,  implode("\n", $arr));
                $file_name = "import_spec_result.txt";
                file_put_contents($src.$file_name, implode("\n", $arr) . "\n", FILE_APPEND);
                fclose($file);
                // $path_pns = JPATH_COMPONENT . DS ;
                $dFile = new DownloadFile($src, $file_name);
                return $this->setRedirect('index.php?option=com_apdmpns',"Import Done" );

        }
        function getTtofromWo($wo_id)        
        {
                  $db = & JFactory::getDBO();            
                  $db->setQuery("select tto.pns_tto_id,tto.tto_code,fk.location,loc.location_code from apdm_pns_tto tto inner join apdm_pns_tto_fk fk on tto.pns_tto_id = fk.tto_id inner join apdm_pns_location loc on loc.pns_location_id=fk.location where tto.tto_wo_id = '".$wo_id."' group by loc.location_code");
                  $rows = $db->loadObjectList();
                $str = array();
                $i=1;
                foreach ($rows as $row) {
                         $str[$i]= "<a href='index.php?option=com_apdmtto&task=tto_detail&id=".$row->pns_tto_id."'>".$row->location_code."</a><br>";
                         $i++;
                }
                return $str;
                
//                  if ($rows) {
//                          echo "<a href='index.php?option=com_apdmtto&task=tto_detail&id=".$rows->pns_tto_id."'>".$rows->tto_code."</a><br>";
//                  }                                                                        
        }
        function checkPnExist($customer_code,$customer_pn,$rev)
        {
                $db = & JFactory::getDBO(); 
                $db->setQuery('select pns_id from apdm_pns where ccs_code = "' . $customer_code .'" AND pns_code = "'.$customer_pn.'" and pns_revision = "'.$rev.'"');
                $pns_id = $db->loadResult();
                if ($pns_id) {
                        return $pns_id;
                }
                return 0;
        }
        function autoInsertPn($ccs_code,$pns_code,$pns_revision,$pns_description,$eco_name,$pns_find_number,$pns_ref_des,$pns_uom,$mfr_name,$mfg_pn)
        {
                $db = & JFactory::getDBO(); 
                $me = & JFactory::getUser();
                $datenow = & JFactory::getDate();                
                $pns_created = $datenow->toMySQL();
                $pns_created_by = $me->get('id');
                $eco_id = PNsController::GetECOId($eco_name);
                
                $ccs_id = PNsController::checkCcsId($ccs_code);
               /* if(!$ccs_id)
                {
                        $db->setQuery("INSERT INTO apdm_ccs (ccs_code,ccs_description,ccs_activate,ccs_create,ccs_create_by) ".
                                "  VALUES ('" . $ccs_code . "','" . $ccs_code . "','1','".$pns_created."','".$pns_created_by."')");                               
                        $db->query();                            
                }
               */
               if($pns_revision=="")
               {
                   $pns_revision_val = "";
               }
               else
               {
                   $pns_revision_val = $pns_revision;
               }
                $db->setQuery("INSERT INTO apdm_pns (ccs_code,pns_code,pns_revision,pns_description,eco_id,pns_find_number,pns_ref_des,pns_uom,pns_create,pns_create_by) ".
                      "  VALUES ('" . $ccs_code . "','" . $pns_code . "','" . $pns_revision_val . "','" . substr($pns_description,0,40) . "','" . $eco_id . "','" . $pns_find_number . "','" . $pns_ref_des . "','" . $pns_uom . "','".$pns_created."','".$pns_created_by."')");
                $db->query();
                //getLast PN ID
               return $pns_id = $db->insertid();
                
                
        }
        function checkCcsId($ccs_code)
	{
		$db =& JFactory::getDBO();               
                $ccs_description = "";
                $query = " SELECT ccs_id FROM apdm_ccs WHERE ccs_code='".$ccs_code."'";
		$db->setQuery($query);
		return $db->loadResult();
                
	}
    function checkMfrId($mfr_name)
    {
        $db =& JFactory::getDBO();
        $query = " SELECT info_id FROM apdm_supplier_info WHERE info_name='".$mfr_name."'";
        $db->setQuery($query);
        return $db->loadResult();

    }

        function importBom()
        {                
                include_once(JPATH_BASE . DS . 'includes' . DS . 'PHPExcel.php');
                require_once (JPATH_BASE . DS . 'includes' . DS . 'PHPExcel' . DS . 'RichText.php');
                require_once(JPATH_BASE . DS . 'includes' . DS . 'PHPExcel' . DS . 'IOFactory.php');
                require_once('includes/download.class.php');
                ini_set("memory_limit", "512M");
                @set_time_limit(1000000);
               $objPHPExcel = new PHPExcel();
              //  $objReader = PHPExcel_IOFactory::createReader('Excel5'); //Excel5
               // $objPHPExcel = $objReader->load(JPATH_COMPONENT . DS . 'IMPORT_BOM_TEMPALTE.xlsx');

                
                
                global $mainframe;
                $me = & JFactory::getUser();
                $pns_id = JRequest::getVar('pns_id');
                $username = $me->get('username');
                $db = & JFactory::getDBO();


                //process upload file
                $path_bom_file = JPATH_SITE . DS . 'uploads'  . DS;
                $upload = new upload($_FILES['']);
                $upload->r_mkdir($path_bom_file, 0777);                
                $bom_upload = "";
                         if ($_FILES['bom_file']['size'] > 0) {                                
                            if($_FILES['bom_file']['size']<20000000)
                            {                                                                 
                                $ext = pathinfo($_FILES['bom_file']['name'], PATHINFO_EXTENSION);
                                if($ext=="xls"){
                                        if (file_exists($path_bom_file . $_FILES['bom_file']['name'])) {

                                                @unlink($path_bom_file .  $_FILES['bom_file']['name']);
                                        }
                                        if (!move_uploaded_file($_FILES['bom_file']['tmp_name'], $path_bom_file . $_FILES['bom_file']['name'])) {
                                                $msg = JText::_('Upload fail, please try again');
                                                return $this->setRedirect('index.php?option=com_apdmpns&task=import_bom_pns', $msg);
                                        } else {
                                            $bom_upload = $_FILES['bom_file']['name'];
                                        }
                                }
                                else
                                {
                                        $msg = JText::_('Please upload file type is xls.');
                                        return $this->setRedirect('index.php?option=com_apdmpns&task=import_bom_pns', $msg);                                        
                                }
                            }
                            else
                            {
                                $msg = JText::_('Please upload file less than 20MB.');
                                return $this->setRedirect('index.php?option=com_apdmpns&task=import_bom_pns', $msg);
                            }
                        }
                        else{
                                $msg = JText::_('Please select an excel file first.');
                                return $this->setRedirect('index.php?option=com_apdmpns&task=import_bom_pns', $msg);
                        }
                                              
                  //Use whatever path to an Excel file you need.
                  //$inputFileName = JPATH_COMPONENT . DS . 'IMPORT_BOM_TEMPALTE.xls';
                        $inputFileName =  $path_bom_file.$bom_upload;
                        try {                    
                                $objReader = PHPExcel_IOFactory::createReader('Excel5');
                                $objPHPExcel = $objReader->load($inputFileName);
                        } catch (Exception $e) {
                                $msg = 'Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage();
                                return $this->setRedirect('index.php?option=com_apdmpns&task=import_bom_pns', $msg);
                        }

                
                  $sheet = $objPHPExcel->getSheet(0);
                   $highestRow = $sheet->getHighestRow();
                   $highestColumn = $sheet->getHighestColumn();
//var_dump($objPHPExcel->getActiveSheet()->toArray(null,true,true,true));
                    for ($row = 1; $row <= 1; $row++) { 
                            $rowData = $sheet->toArray('A1:' . $highestColumn . '1',  null, true, false);
                    }
                    $header = $rowData[1];
                    $mess=array();
                    if($rowData[1][0]!="Level")
                    {
                            $mess[] =  "Err:Wrong format at A1. Must be 'Level'";
                    }                   
                    if($rowData[1][1]!="Customer Code")
                    {
                            $mess[] =  "Err:Wrong format at B1. Must be 'Customer Code'";
                    }
                    if($rowData[1][2]!="Customer PN")
                    {
                            $mess[] =  "Err:Wrong format at C1. Must be 'Customer PN'";
                    }
                    if($rowData[1][3]!="Rev.")
                    {
                            $mess[] =  "Err:Wrong format at D1. Must be 'Rev.'";
                    }
                    if($rowData[1][4]!="Description")
                    {
                            $mess[] =  "Err:Wrong format at E1. Must be 'Description'";
                    }
                    if($rowData[1][5]!="ECO number")
                    {
                            $mess[] =  "Err:Wrong format at F1. Must be 'ECO number";
                    }
                    if($rowData[1][6]!="Find number")
                    {
                            $mess[] =  "Err:Wrong format at G1. Must be 'Find number'";
                    }
                    if($rowData[1][7]!="Ref Des")
                    {
                            $mess[] =  "Err:Wrong format at H1. Must be 'Ref Des'";
                    }
                    if($rowData[1][8]!="Qty.")
                    {
                            $mess[] =  "Err:Wrong format at I1. Must be 'Qty.'";
                    }
                    if($rowData[1][9]!="UOM")
                    {
                            $mess[] =  "Err:Wrong format at J1. Must be 'UOM'";
                    }
                    if($rowData[1][10]!="MFR name")
                    {
                            $mess[] =  "Err:Wrong format at K1. Must be 'MFR name'";
                    }
                    if($rowData[1][11]!="MFG PN")
                    {
                            $mess[] =  "Err:Wrong format at L1. Must be 'MFG PN'";
                    }

                
                for ($row = 1; $row <= $highestRow; $row++) { 
                $rowData = $sheet->toArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
                }

                  // print_r($rowData);   
                //for level 0
                $parent0 = 0;
                $parent1 = 0;
                $parent2 = 0;
                $parent3 = 0;
                $parent4 = 0;
                $parent5 = 0;
                $me = & JFactory::getUser();
                $datenow = & JFactory::getDate();
                $_created = $datenow->toMySQL();
                $_created_by = $me->get('id');
                $arr_err=array();
                for($line=2;$line<=$highestRow;$line++)
                {
                        if($rowData[$line][3]!="")
                            $pn_code = $rowData[$line][1]."-".$rowData[$line][2]."-".$rowData[$line][3];
                        else
                            $pn_code = $rowData[$line][1]."-".$rowData[$line][2];
                        //start import with level 0
                        if($rowData[$line][0]==""){
                            $arr_err[$line]    = "Err:".$pn_code. " have Level at column A".$line ." is null";
                            continue;
                        }
                        //check MFR
                        $mfr_id = PNsController::checkMfrId($rowData[$line][10]);
                        if(!$mfr_id)
                        {
                            $arr_err[$line]    = "Err:"."MFR name at column K".$line ." is not found";
                           /* $query = 'INSERT INTO apdm_supplier_info (info_type, info_name, info_description, info_activate,info_create,info_created_by) VALUES(4,"'.$rowData[$line][10].'","'.$rowData[$line][10].'",1,"'.$_created.'","'.$_created_by.'")';
                            $db->setQuery($query);
                            $db->query();
                            $mfr_id = $db->insertid();*/
                        }

                        if($rowData[$line][1]=="")//
                        {
                            $arr_err[$line]    = "Err:Customer Code at column B".$line ." is not null";
                        }
                        if($rowData[$line][2]=="")
                        {
                            $arr_err[$line]    = "Err:Customer PN at column C".$line ." is not null";
                        }                        
                        if($rowData[$line][4]=="")
                        {
                            $arr_err[$line]    = "Err:".$pn_code. " have Description at column E".$line ." is not null";
                        }
                        if($rowData[$line][5]!="")//eco
                        {
                            $eco_id = PNsController::GetECOId($rowData[$line][5]);
                            if(!$eco_id){
                                    $arr_err[$line]    = "Err:".$pn_code. " have ECO number at column F".$line ." is not found";
                            }

                        }
                        if($rowData[$line][9]=="")//uom
                        {
                            $arr_err[$line]    = "Err:".$pn_code. " have UOM at column J".$line ." is null";
                        }
                        if($rowData[$line][0]!=0){//if != level 0 not check MFR
                                if($rowData[$line][8]=="")//qty
                                {
                                    $arr_err[$line]    = "Err:".$pn_code. " have QTY at column I".$line ." is null";
                                }
                                if($rowData[$line][10]=="")
                                {
                                    $arr_err[$line]    = "Err:".$pn_code. " have MFR name at column K".$line ." is null";
                                }  
                                if($rowData[$line][11]=="")
                                {
                                    $arr_err[$line]    = "Err:".$pn_code. " have MFG PN at column L".$line ." is null";
                                }  
                        }

                        if($rowData[$line][0]=='0')
                        {
                                $pns_id = PNsController::checkPnExist($rowData[$line][1],$rowData[$line][2],$rowData[$line][3]);
                                if(!$pns_id){
                                        if(strlen($rowData[$line][4])>40)
                                        {
                                            $arr_err[$line]    = "Err:".$pn_code. " have Description at column L".$line ."  very long";
                                        }
                                        $pns_id = PNsController::autoInsertPn($rowData[$line][1],$rowData[$line][2],$rowData[$line][3],$rowData[$line][4],$rowData[$line][5],$rowData[$line][6],$rowData[$line][7],$rowData[$line][9]);
                                        $mess[$line] = "Import sucessfull PN ". $pn_code;
                                }

                                    $eco_id = PNsController::GetECOId($rowData[$line][5]);
                                    $db->setQuery('select pns_life_cycle from apdm_pns where pns_id  = "'.$pns_id.'"');                             
                                    $status = $db->loadResult();
                                    if($status == "Create" && $eco_id)
                                    {
                                        $query = 'update apdm_pns set eco_id = "'.$eco_id.'" where  pns_id  = "'.$pns_id.'"';
                                        $db->setQuery($query);
                                        $db->query();
                                    }
                                    else{
                                        $arr_err[$line]    = "Err:".$pn_code. " have ECO number at column F".$line ." is not found";
                                    }

                                $parent0 = $pns_id;                                                                                                                              
                                //insert MFG
                                if($mfr_id) {
                                    $query = 'INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (' . $pns_id . ', ' . $mfr_id . ', "' . $rowData[$line][11] . '", 4)';
                                    $db->setQuery($query);
                                    $db->query();
                                }
                                
                        }
                        //start import with level 1
                        if($rowData[$line][0]==1)
                        {    
                                
                                $pns_id = PNsController::checkPnExist($rowData[$line][1],$rowData[$line][2],$rowData[$line][3]);
                                if(!$pns_id){
                                        if(strlen($rowData[$line][4])>40)
                                        {
                                            $arr_err[$line]    = "Err:".$pn_code. " have Description at column L".$line ."  very long";
                                        }
                                        $pns_id = PNsController::autoInsertPn($rowData[$line][1],$rowData[$line][2],$rowData[$line][3],$rowData[$line][4],$rowData[$line][5],$rowData[$line][6],$rowData[$line][7],$rowData[$line][9]);
                                        $mess[$line] = "Import sucessfull PN ". $pn_code;
                                }                               
                                $parent1 = $pns_id;
                            $eco_id = PNsController::GetECOId($rowData[$line][5]);
                            $db->setQuery('select pns_life_cycle from apdm_pns where pns_id  = "'.$pns_id.'"');
                            $status = $db->loadResult();
                            if($status == "Create" && $eco_id)
                            {
                                $query = 'update apdm_pns set eco_id = "'.$eco_id.'" where  pns_id  = "'.$pns_id.'"';
                                $db->setQuery($query);
                                $db->query();
                            }
                            else{
                                $arr_err[$line]    = "Err:".$pn_code. " have ECO number at column F".$line ." is not found";
                            }


                            if($pns_id!=$parent0) {
                                if($mfr_id) {
                                    //insert MFG
                                    $query = 'INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (' . $pns_id . ', ' . $mfr_id . ', "' . $rowData[$line][11] . '", 4)';
                                    $db->setQuery($query);
                                    $db->query();
                                }
                                $db->setQuery("INSERT INTO apdm_pns_parents (pns_id, pns_parent,ref_des,find_number,stock) VALUES (" . $pns_id . ", " . $parent0 . ",'" . $rowData[$line][7] . "','" . $rowData[$line][6] . "','" . $rowData[$line][8] . "')");
                                $db->query();
                                // echo "<br> ".$rowData[$line][1]." level 1 parent  ".$parent0;
                                $mess[$line] = "Import sucessfull " . $pn_code ." into BOM";
                            }
                            else
                            {
                                $arr_err[$line]    = "Err:".$pn_code. " Can not add same PN with parent for BOM";
                            }
                        }
                      
                        if($rowData[$line][0]==2)
                        {
                                $pns_id = PNsController::checkPnExist($rowData[$line][1],$rowData[$line][2],$rowData[$line][3]);
                                if(!$pns_id){
                                        if(strlen($rowData[$line][4])>40)
                                        {
                                            $arr_err[$line]    = "Err:".$pn_code. " have Description at column L".$line ."  very long";
                                        }
                                        $pns_id = PNsController::autoInsertPn($rowData[$line][1],$rowData[$line][2],$rowData[$line][3],$rowData[$line][4],$rowData[$line][5],$rowData[$line][6],$rowData[$line][7],$rowData[$line][9]);
                                        $mess[$line] = "Import sucessfull PN ". $pn_code;
                                }                               
                                $parent2 = $pns_id;
                            $eco_id = PNsController::GetECOId($rowData[$line][5]);
                            $db->setQuery('select pns_life_cycle from apdm_pns where pns_id  = "'.$pns_id.'"');
                            $status = $db->loadResult();
                            if($status == "Create" && $eco_id)
                            {
                                $query = 'update apdm_pns set eco_id = "'.$eco_id.'" where  pns_id  = "'.$pns_id.'"';
                                $db->setQuery($query);
                                $db->query();
                            }
                            else{
                                $arr_err[$line]    = "Err:".$pn_code. " have ECO number at column F".$line ." is not found";
                            }

                            if($pns_id!=$parent1) {
                                if($mfr_id) {
                                    //insert MFG
                                    $query = 'INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (' . $pns_id . ', ' . $mfr_id . ', "' . $rowData[$line][11] . '",4)';
                                    $db->setQuery($query);
                                    $db->query();
                                }
                                $db->setQuery("INSERT INTO apdm_pns_parents (pns_id, pns_parent,ref_des,find_number,stock) VALUES (" . $pns_id . ", " . $parent1 . ",'" . $rowData[$line][7] . "','" . $rowData[$line][6] . "','" . $rowData[$line][8] . "')");
                                $db->query();
                                $$mess[$line] = "Import sucessfull " . $pn_code ." into BOM";
                            }
                            else
                            {
                                $arr_err[$line]    = "Err:".$pn_code. " Can not add same PN with parent for BOM";
                            }
                                
                        }
                       
                        if($rowData[$line][0]==3)
                        {
                                $pns_id = PNsController::checkPnExist($rowData[$line][1],$rowData[$line][2],$rowData[$line][3]);
                                if(!$pns_id){
                                        if(strlen($rowData[$line][4])>40)
                                        {
                                            $arr_err[$line]    = "Err:".$pn_code. " have Description at column L".$line ."  very long";
                                        }
                                        $pns_id = PNsController::autoInsertPn($rowData[$line][1],$rowData[$line][2],$rowData[$line][3],$rowData[$line][4],$rowData[$line][5],$rowData[$line][6],$rowData[$line][7],$rowData[$line][9]);
                                        $mess[$line] = "Import sucessfull PN ". $pn_code;
                                }                               
                                $parent3 = $pns_id;
                            $eco_id = PNsController::GetECOId($rowData[$line][5]);
                            $db->setQuery('select pns_life_cycle from apdm_pns where pns_id  = "'.$pns_id.'"');
                            $status = $db->loadResult();
                            if($status == "Create" && $eco_id)
                            {
                                $query = 'update apdm_pns set eco_id = "'.$eco_id.'" where  pns_id  = "'.$pns_id.'"';
                                $db->setQuery($query);
                                $db->query();
                            }
                            else{
                                $arr_err[$line]    = "Err:".$pn_code. " have ECO number at column F".$line ." is not found";
                            }

                            if($pns_id!=$parent2) {
                                if($mfr_id) {
                                    //insert MFG
                                    $query = 'INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (' . $pns_id . ', ' . $mfr_id . ', "' . $rowData[$line][11] . '", 4)';
                                    $db->setQuery($query);
                                    $db->query();
                                }
                                $db->setQuery("INSERT INTO apdm_pns_parents (pns_id, pns_parent,ref_des,find_number,stock) VALUES (" . $pns_id . ", " . $parent2 . ",'".$rowData[$line][7]."','".$rowData[$line][6]."','".$rowData[$line][8]."')");                               
                                $db->query();
                                $mess[$line] = "Import sucessfull " . $pn_code ." into BOM";
                            }
                            else
                            {
                                $arr_err[$line]    = "Err:".$pn_code. " Can not add same PN with parent for BOM";
                            }
                        }
                        if($rowData[$line][0]==4)
                        {
                               $pns_id = PNsController::checkPnExist($rowData[$line][1],$rowData[$line][2],$rowData[$line][3]);
                                if(!$pns_id){
                                        if(strlen($rowData[$line][4])>40)
                                        {
                                            $arr_err[$line]    = "Err:Description at column L".$line ."  very long";
                                        }
                                        $pns_id = PNsController::autoInsertPn($rowData[$line][1],$rowData[$line][2],$rowData[$line][3],$rowData[$line][4],$rowData[$line][5],$rowData[$line][6],$rowData[$line][7],$rowData[$line][9]);
                                        $mess[$line] = "Import sucessfull PN ". $pn_code;
                                }                               
                                $parent4 = $pns_id;
                            $eco_id = PNsController::GetECOId($rowData[$line][5]);
                            $db->setQuery('select pns_life_cycle from apdm_pns where pns_id  = "'.$pns_id.'"');
                            $status = $db->loadResult();
                            if($status == "Create" && $eco_id)
                            {
                                $query = 'update apdm_pns set eco_id = "'.$eco_id.'" where  pns_id  = "'.$pns_id.'"';
                                $db->setQuery($query);
                                $db->query();
                            }
                            else{
                                $arr_err[$line]    = "Err:".$pn_code. " have ECO number at column F".$line ." is not found";
                            }

                            if($pns_id!=$parent3) {
                                if($mfr_id) {
                                    //insert MFG
                                    $query = 'INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (' . $pns_id . ', ' . $mfr_id . ', "' . $rowData[$line][11] . '", 4)';
                                    $db->setQuery($query);
                                    $db->query();
                                }
                                $db->setQuery("INSERT INTO apdm_pns_parents (pns_id, pns_parent,ref_des,find_number,stock) VALUES (" . $pns_id . ", " . $parent3 . ",'".$rowData[$line][7]."','".$rowData[$line][6]."','".$rowData[$line][8]."')");                               
                                $db->query();
                                $mess[$line] = "Import sucessfull PN ". $pn_code;
                            }
                            else
                            {
                                $arr_err[$line]    = "Err:".$pn_code. " Can not add same PN with parent for BOM";
                            }
                        }
                        if($rowData[$line][0]==5)
                        {
                                $pns_id = PNsController::checkPnExist($rowData[$line][1],$rowData[$line][2],$rowData[$line][3]);
                                if(!$pns_id){
                                        if(strlen($rowData[$line][4])>40)
                                        {
                                            $arr_err[$line]    = $pn_code. " have Description at column L".$line ."  very long";
                                        }
                                        $pns_id = PNsController::autoInsertPn($rowData[$line][1],$rowData[$line][2],$rowData[$line][3],$rowData[$line][4],$rowData[$line][5],$rowData[$line][6],$rowData[$line][7],$rowData[$line][9]);
                                        $mess[$line] = "Import sucessfull PN ". $pn_code;
                                }                               
                                $parent5 = $pns_id;
                            $eco_id = PNsController::GetECOId($rowData[$line][5]);
                            $db->setQuery('select pns_life_cycle from apdm_pns where pns_id  = "'.$pns_id.'"');
                            $status = $db->loadResult();
                            if($status == "Create" && $eco_id)
                            {
                                $query = 'update apdm_pns set eco_id = "'.$eco_id.'" where  pns_id  = "'.$pns_id.'"';
                                $db->setQuery($query);
                                $db->query();
                            }
                            else{
                                $arr_err[$line]    = "Err:".$pn_code. " have ECO number at column F".$line ." is not found";
                            }

                            if($pns_id!=$parent4) {
                                if($mfr_id) {
                                    //insert MFG
                                    $query = 'INSERT INTO apdm_pns_supplier (pns_id, supplier_id, supplier_info, type_id) VALUES (' . $pns_id . ', ' . $mfr_id . ', "' . $rowData[$line][11] . '", 4)';
                                    $db->setQuery($query);
                                    $db->query();
                                }
                                $db->setQuery("INSERT INTO apdm_pns_parents (pns_id, pns_parent,ref_des,find_number,stock) VALUES (" . $pns_id . ", " . $parent4 . ",'".$rowData[$line][7]."','".$rowData[$line][6]."','".$rowData[$line][8]."')");                               
                                $db->query();
                                $mess[$line] = "Import sucessfull " . $pn_code ." into BOM";
                            }
                            else
                            {
                                $arr_err[$line]    = "Err:".$pn_code. " Can not add same PN with parent for BOM";
                            }
                        }
                }  
                //$inputFileName =  $path_bom_file.
               // $file = fopen($path_bom_file.$bom_upload."_result.txt","w");
                //echo fwrite($file,  implode("\n", $arr_err));
              //  $file_name = $bom_upload.time()."_result.txt";
             //   file_put_contents($path_bom_file.$file_name, implode("\n", $arr_err) . "\n", FILE_APPEND);
               // fclose($file);
                
                //write_ log
                $result = array_merge($arr_err, $mess);
                $objReader = PHPExcel_IOFactory::createReader('Excel5'); //Excel5
                $objPHPExcel = $objReader->load($path_bom_file .'IMPORT_BOM_TEMPALTE_REPORT.xls');
                $nRecord = count($result);
                //$objPHPExcel->getSheet(0);
                $objPHPExcel->getActiveSheet()->getStyle('A7:F' . $nRecord)->getAlignment()->setWrapText(true);
                if ($nRecord > 0) {
                        $jj = 0;
                        $ii = 1;
                        $number = 1;
                        foreach ($result as $ms) {
                                $a = 'A' . $ii;
                                $b = 'B' . $ii;
                                //$c = 'C' . $ii;
                               
                                //set heigh or row                                 
                                $objPHPExcel->getActiveSheet()->getRowDimension($ii)->setRowHeight(30);
                                $objPHPExcel->getActiveSheet()->setCellValue($a, $number );
                                $objPHPExcel->getActiveSheet()->setCellValue($b, $ms);                             

                                //set format
                                $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                              

                                $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                          

                                $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                               

                                $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                
                                if ($jj == $nRecord - 1) {
                                        $objPHPExcel->getActiveSheet()->getStyle($a)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                        $objPHPExcel->getActiveSheet()->getStyle($b)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                                                       }
                                $ii++;
                                $jj++;
                                $number++;
                        }
                }
                $path_export = JPATH_SITE . DS . 'uploads'  . DS;
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save($path_export . "Report_".$bom_upload);
                $dFile = new DownloadFile($path_export, "Report_".$bom_upload);
                
                return $this->setRedirect('index.php?option=com_apdmpns&task=import_bom_pns&importresult='.$file_name,"Import Done" );
        }
        function import_bom_pns()
        {
                JRequest::setVar('layout', 'importbom');
                JRequest::setVar('view', 'listpns');
                parent::display();     
        }
        function downloadBomTemplate() {
                //$path_pns = JPATH_SITE . DS . 'uploads' . DS . 'pns' . DS . 'pdf' . DS;
                $path_pns = JPATH_COMPONENT . DS ;
                $dFile = new DownloadFile($path_pns, 'IMPORT_BOM_TEMPALTE.xls');
                exit;
        }
        function downloadBomImportResult()
        {
                $importresult = JRequest::getVar('importresult'); 
                $path_pns = JPATH_SITE . DS . 'uploads'. DS;
                $dFile = new DownloadFile($path_pns, $importresult);
                exit;
        }
        function getCadfiles($pns_id)        
        {
                 $db =& JFactory::getDBO();
                ///get list cad files
                        $db->setQuery("SELECT * FROM apdm_pn_cad WHERE pns_id=".$pns_id);
                        $res = $db->loadObjectList();
                        $cads_files = array();
                        if (count($res)>0){
                                foreach ($res as $r){
                                    $cads_files[] = array('id'=>$r->pns_cad_id, 'cad_file'=>$r->cad_file);
                                }
                        }
                        return $cads_files;                        
        }
        function getImagefiles($pns_id)        
        {
                $db =& JFactory::getDBO();
                        ///get list image files
                        $db->setQuery("SELECT * FROM apdm_pns_image WHERE pns_id=".$pns_id);
                        $res = $db->loadObjectList();
                        $images_files = array();
                        if (count($res)>0){
                                foreach ($res as $r){
                                        $images_files[] = array('id'=>$r->pns_image_id, 'image_file'=>$r->image_file);
                                }
                        }     
                        return $images_files;
        }
         function getPdffiles($pns_id)        
        {
                 $db =& JFactory::getDBO();
                        ///get list pdf files
                        $db->setQuery("SELECT * FROM apdm_pns_pdf WHERE pns_id=".$pns_id);
                        $res = $db->loadObjectList();
                        $pdf_files = array();
                        if (count($res)>0){
                                foreach ($res as $r){
                                        $pdf_files[] = array('id'=>$r->pns_pdf_id, 'pdf_file'=>$r->pdf_file);
                                }
                        }            
                        return $pdf_files;
        }
        function getPnsRevHistory($pns_id)
        {
                $db =& JFactory::getDBO();
               $query = "SELECT pns_parent from apdm_pns_rev_history where pns_id=".$pns_id;
               $db->setQuery($query);
               $rows = $db->loadObjectList();
               if (count($rows) > 0){
                    foreach ($rows as $row){
                        $arrPNsChild[] = $row->pns_parent;
                    }
               }
               
               $where = array();
                if (count( $arrPNsChild ) > 0)   {
                        $where[] = 'p.pns_id IN ('.implode(",", $arrPNsChild ).') ';
                         $where = ( count( $where ) ? ' WHERE (' . implode( ') AND (', $where ) . ')' : '' );
                $query = 'SELECT p.* '
                    . ' FROM apdm_pns AS p'            
                    . $where;     
                $db->setQuery($query);
              return $db->loadObjectList();
                }
             return "";  
                
             
        }
        function getPnsCodefromId($pns_id)
        {
                 $db =& JFactory::getDBO();
                $querypn = "SELECT p.ccs_code, CONCAT(p.ccs_code,'-',p.pns_code,if(p.pns_revision = '','','-'),p.pns_revision) AS pns_code,p.pns_id FROM apdm_pns AS p  WHERE  p.pns_id =" . $pns_id;
                $db->setQuery($querypn);
                $pns = $db->loadObject();
                $pns_code = $pns->pns_code;
                if (substr($pns_code, -1) == "-") {
                        $pns_code = substr($pns_code, 0, strlen($pns_code) - 1);
                }
                return $pns_code;
        }
        function DisplayPnsAllBomChildHistory($pns_id) {
                $db = & JFactory::getDBO();
                $rows = array();
                $db->setQuery('SELECT pr.pns_id as pns_bom_id,pr.*,CONCAT(p.ccs_code,"-",p.pns_code,if(p.pns_revision = "","","-"),p.pns_revision)  AS text, e.eco_name, p.pns_description, p.pns_type, p.pns_status,p.* FROM apdm_pns AS p LEFT JOIN apdm_pns_bom_history as pr ON p.pns_id=pr.pns_id LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id WHERE c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND pr.pns_parent in (' . $pns_id . ')');                                
                return $result = $db->loadObjectList();
        }        
        function GetMfgPnCode($mfgId) {
                $db = & JFactory::getDBO();                
                $db->setQuery("SELECT p.supplier_info FROM apdm_pns_supplier AS p LEFT JOIN apdm_supplier_info AS s ON s.info_id = p.supplier_id left join apdm_pns_sto_fk fk on fk.pns_mfg_pn_id = p.id WHERE  s.info_deleted=0 AND  s.info_activate=1 AND p.type_id = 4 AND  p.id =" . $mfgId);                                
                return $db->loadResult();
    }
}

