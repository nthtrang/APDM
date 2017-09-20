<?php
/**
* @version		$Id: view.html.php 10381 2008-06-01 03:35:53Z pasamio $
* @package		Joomla
* @subpackage	Users
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
class recylebinViewinfodetail extends JView
{
	function display($tpl = null)
	{
		global $mainframe, $option;		

		$db				=& JFactory::getDBO();	
		$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );
		$edit		= JRequest::getVar('edit',true);
		$me 		= JFactory::getUser();
		JArrayHelper::toInteger($cid, array(0));		
		$db 		=& JFactory::getDBO();
		$row = & JTable::getInstance('apdmsupplierinfo');	
		if($edit){
			$row->load($cid[0]);
		}
		//get list type info
		if ($row->info_type ==2) $lists['type_info'] = 'Vendor';
		if ($row->info_type ==3) $lists['type_info'] = 'Supplier';
		if ($row->info_type ==4) $lists['type_info'] = 'Manufacture';		
		$this->assignRef('lists',		$lists);
		$this->assignRef('row',	$row);
		parent::display($tpl);
	}
}