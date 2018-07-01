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
class pnsViewlistpns extends JView
{
	function display($tpl = null)
	{
	   // global $mainframe, $option;

        $db                =& JFactory::getDBO();
        $pns_id            = JRequest::getVar('id');       
        $query = "SELECT p.*, CONCAT_WS( '-', p.ccs_code, p.pns_code, p.pns_revision ) AS pns_code_full  FROM apdm_pns AS p  WHERE p.pns_id=".$pns_id." ORDER BY p.ccs_code";    
      
        $db->setQuery( $query);
        $rows = $db->loadObjectList();              
        $lists['pns_id']        = $pns_id;    
        $this->assignRef('lists',        $lists);
        $this->assignRef('rows',        $rows);          
                //get parent
        $row = & JTable::getInstance('apdmpns');
        $row->load($pns_id);   
        $this->assignRef('row',        $row);     
		parent::display($tpl);
	}
}

