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
class QUOViewroutes extends JView
{
	function display($tpl = null)
	{
	   // global $mainframe, $option;
                $db                =& JFactory::getDBO();
                $cid		= JRequest::getVar( 'cid', array(0), '', 'array' );
                $edit		= JRequest::getVar('edit',true);               
                $row = & JTable::getInstance('apdmecoroutes');
                $route_id		= JRequest::getVar( 'id');
                if($edit){
                    $row->load($route_id);
                        $query = "SELECT * FROM apdm_eco_routes WHERE  id=".$route_id." and deleted = 0 ORDER BY id desc";        
                        $db->setQuery( $query);
                        $row = $db->loadObjectList();                        
                    $this->assignRef('row',	$row);
                }
       
        $query = "SELECT * FROM apdm_eco_routes WHERE   quotation_id=".$cid[0]." and deleted = 0 ORDER BY id desc";        
        $db->setQuery( $query);
        $rows = $db->loadObjectList();              
        $lists['quo_id']        = $cid;    
        $this->assignRef('lists',        $lists);
        $this->assignRef('rows',        $rows);             
        $this->assignRef('id',        $cid[0]);      
        $db->setQuery("SELECT * from apdm_quotation where quotation_id=".$quo_id);         
        $quo_row =  $db->loadObject();

        $this->assignRef('quo_row',	$quo_row);
	parent::display($tpl);
	}
}

