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
	$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );
        $query = "SELECT p.*, CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS pns_code_full FROM apdm_pns AS p LEFT JOIN apdm_pns_parents as pr ON p.pns_id=pr.pns_id LEFT JOIN apdm_ccs AS c ON c.ccs_code = p.ccs_code LEFT JOIN apdm_eco AS e ON e.eco_id=p.eco_id  WHERE  c.ccs_activate= 1 AND c.ccs_deleted=0 AND  p.pns_deleted =0 AND p.eco_id=".$cid[0]." ORDER BY p.ccs_code";        
        $db->setQuery( $query);
        $rows = $db->loadObjectList();              
        $lists['eco_id']        = $cid;    
        $this->assignRef('lists',        $lists);
        $this->assignRef('rows',        $rows);             
        $rowEco = & JTable::getInstance('apdmeco');	
        $rowEco->load($cid[0]);
        $this->assignRef('rowEco',	$rowEco);
		parent::display($tpl);
	}
}

