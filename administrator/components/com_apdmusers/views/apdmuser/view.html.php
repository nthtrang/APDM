<?php

/**
* HTML View class for the Apdm user information.
* @package		APDM
* @subpackage	APDM Users
*/

// 
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class apdmusersViewapdmuser extends JView
{
	function display($tpl = null)
	{
		$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );
		$edit		= JRequest::getVar('edit',true);
		$me 		= JFactory::getUser();
		JArrayHelper::toInteger($cid, array(0));

		$db 		=& JFactory::getDBO();
		if ($edit){
			//getinformation of user
			$query = "SELECT u.*, up.* FROM #__users as u LEFT JOIN apdm_users as up ON up.user_id = u.id WHERE u.id=".$cid[0];
			$db->setQuery($query);
			$user = $db->loadObjectList();
			//get role of user
			$query = "SELECT role_id FROM apdm_role_user WHERE user_id=".$cid[0]." GROUP BY role_id ";
			//echo $query;
			$db->setQuery($query);
			$roles = $db->loadObjectList();
			$arr_role = array();
			if (count($roles) > 0){
				foreach ($roles as $obj){
					$arr_role[] = $obj->role_id;
				}
			}
		}else{
			$user = NULL;
		}
		//echo count($arr_role);
		$myuser		=& JFactory::getUser();
		$acl		=& JFactory::getACL();
      
     	
		 $gid_new[] = JHTML::_('select.option', '', JText::_('Select Group'), 'id', 'value');
         $gid_new[] = JHTML::_('select.option', '23', JText::_('User'), 'id', 'value');
		 if ($user[0]->gid != 23) {
         	$gid_new[] = JHTML::_('select.option', '24', JText::_('Administrator'), 'id', 'value');              
		 }
         $lists['gid'] = JHTML::_('select.genericlist',  $gid_new, 'gid', 'class="inputbox" size="4" onChange="DisplayGroupRole(\'role_user\', this)" ', 'id', 'value', $user[0]->gid);  
		// build the html select list
		$lists['block'] 	= JHTML::_('select.booleanlist',  'block', 'class="inputbox" size="1"', $user[0]->user_enable );
		$lists['role'] = '';
		$role_list[0] = JHTML::_('select.option', '', JText::_('Select Roles'), 'id', 'value');
		
		if (count($arr_role) > 0){			
			$db->setQuery("SELECT role_id as id, role_name as value FROM apdm_role GROUP BY role_id ");
			$role_lists  = array_merge($role_list, $db->loadObjectList());
			$lists['role'] = JHTML::_('select.genericlist',  $role_lists, 'role_user[]', 'class="inputbox" size="10" multiple="multiple" ', 'id', 'value', $arr_role); 
			
		}else{
			$lists['role'] = JHTML::_('select.genericlist',  $role_list, 'role_user[]', 'class="inputbox" size="10" multiple="multiple" ', 'id', 'value'); 
		}
		$this->assignRef('me', 		$me);
		$this->assignRef('lists',	$lists);
		$this->assignRef('user',	$user);
		$this->assignRef('contact',	$contact);
		$this->assignRef('userrole', $arr_role);

		parent::display($tpl);
	}
}
