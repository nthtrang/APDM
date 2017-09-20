<?php
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class apdmsuppliersViewdetail extends JView
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