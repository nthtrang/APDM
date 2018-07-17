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
class ecoViewlistpns extends JView
{
	function display($tpl = null)
	{
	   // global $mainframe, $option;

        $db                =& JFactory::getDBO();
        $me 		= JFactory::getUser();
	$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );
        $query = "SELECT p.*, CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS pns_code_full FROM apdm_pns AS p LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_id LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id  WHERE  c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND p.eco_id=".$cid[0]."  group by pns_id ORDER BY p.ccs_code";        
        $db->setQuery( $query);
        $rows = $db->loadObjectList();              
        $lists['eco_id']        = $cid;    
        $this->assignRef('lists',        $lists);
        $this->assignRef('rows',        $rows);             
        //for initial
        $query = "SELECT p.*,init.init_plant_status,init.init_make_buy,init.init_leadtime,init.init_buyer,init.init_cost,init.init_modified,init.init_modified_by,init.init_supplier, CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS pns_code_full FROM apdm_pns AS p  LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_id  LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code  left join apdm_pns_initial init on init.pns_id = p.pns_id LEFT JOIN apdm_eco AS e ON e.eco_id=init.eco_id WHERE  c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND init.eco_id=".$cid[0]."  group by pns_id ORDER BY p.ccs_code";
        $db->setQuery( $query);
        $rowint = $db->loadObjectList();     
        $this->assignRef('rowint',	$rowint);
        
        $db->setQuery("SELECT p.* FROM apdm_supplier_info as p WHERE p.info_type=4 ");
        $list_manufacture = $db->loadObjectList();
        $this->assignRef('manufacture',	$list_manufacture);
        
        $rowEco = & JTable::getInstance('apdmeco');	
        $rowEco->load($cid[0]);
        $this->assignRef('rowEco',	$rowEco);
        //get list user have exist on datbase
        $db->setQuery("SELECT * FROM jos_users jos inner join apdm_users apd on jos.id = apd.user_id  WHERE user_enable=0 and  user_id != '".$me->get('id')."' ORDER BY jos.username ");
        $list_user = $db->loadObjectList();        
        $this->assignRef('list_user',	$list_user);
		parent::display($tpl);
	}
}

