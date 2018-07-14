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
class pnsViewrevroll extends JView
{
	function display($tpl = null)
	{
	   // global $mainframe, $option;

        $db                =& JFactory::getDBO();
        $cid		= JRequest::getVar( 'cid', array(0), '', 'array' );       
        $me 		= JFactory::getUser();
        JArrayHelper::toInteger($cid, array(0));	
        $row = & JTable::getInstance('apdmpnsrev');        
     
        $db->setQuery("SELECT prev.*, CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns AS p LEFT JOIN apdm_pns_rev AS prev on p.pns_id = prev.pns_id left join apdm_eco eco on eco.eco_id = p.eco_id WHERE p.pns_deleted =0 AND prev.pns_id=".$cid[0]." order by prev.pns_rev_id desc limit 1");
        $list_revision = $db->loadObjectList();              
        if(count($list_revision)==0)
        {
               $db->setQuery("insert into apdm_pns_rev(pns_id,ccs_code,pns_code,pns_revision,eco_id,pns_life_cycle) select pns_id,ccs_code,pns_code,pns_revision,eco_id,pns_life_cycle from apdm_pns where pns_id = '" . $cid[0] . "'");
               $db->query();
               $db->setQuery("SELECT prev.*, CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns AS p LEFT JOIN apdm_pns_rev AS prev on p.pns_id = prev.pns_id left join apdm_eco eco on eco.eco_id = p.eco_id WHERE p.pns_deleted =0 AND prev.pns_id=".$cid[0]." order by prev.pns_rev_id desc limit 1");
               $list_revision = $db->loadObjectList();                     
        }
        $lists['pns_id']        = $cid[0];       
        $this->assignRef('revision',        $list_revision);
        $nextRev = PNsController::next_rev_roll();
        $this->assignRef('nextRev',        $nextRev);
		parent::display($tpl);
	}
}

