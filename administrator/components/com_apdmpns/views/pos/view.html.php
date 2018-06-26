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
class pnsViewpos extends JView
{
	function display($tpl = null)
	{
	   // global $mainframe, $option;

        $db                =& JFactory::getDBO();
        $cid		= JRequest::getVar( 'cid', array(0), '', 'array' );       
        $me 		= JFactory::getUser();
        JArrayHelper::toInteger($cid, array(0));	
        $row = & JTable::getInstance('apdmpnspo');        
     
        $db->setQuery("SELECT po.*, CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS parent_pns_code  FROM apdm_pns AS p LEFT JOIN apdm_pns_po AS po on p.pns_id = po.pns_id WHERE p.pns_deleted =0 AND po.pns_id=".$cid[0]." order by po.pns_rev_id desc limit 1");        
       
        $list_pos = $db->loadObjectList();              
        $lists['pns_id']        = $cid[0];       
        $this->assignRef('pos',        $list_pos);
//        $nextPo = PNsController::next_rev_roll();
//        $this->assignRef('nextPo',        $nextPo);
		parent::display($tpl);
	}
}

