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
class apdmsuppliersViewinfo extends JView
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
		$type_info[0] = JHTML::_('select.option',  0, '- '. JText::_( 'SELECT_TYPE' ) .' -');
		$type_info[1] = JHTML::_('select.option',  2, '- '. JText::_( 'VENDOR' ) .' -');
		$type_info[2] = JHTML::_('select.option',  3, '- '. JText::_( 'SUPPLIER' ) .' -');
		$type_info[3] = JHTML::_('select.option',  4, '- '. JText::_( 'MANUFACTURE' ) .' -');
		
		$lists['type_info'] = JHTML::_('select.genericlist',   $type_info, 'info_type', 'class="inputbox" size="1"', 'value', 'text', $row->info_type );
		$lists['activate'] 	= JHTML::_('select.booleanlist',  'info_activate', 'class="inputbox" size="1"', $row->info_activate );
		$this->assignRef('lists',		$lists);
		$this->assignRef('row',	$row);
		parent::display($tpl);
	}
}