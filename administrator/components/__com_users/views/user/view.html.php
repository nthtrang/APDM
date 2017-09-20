<?php
/**
* @version		$Id: view.html.php 10496 2008-07-03 07:08:39Z ircmaxell $
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
class UsersViewUser extends JView
{
	function display($tpl = null)
	{
		$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );
		$edit		= JRequest::getVar('edit',true);
		$me 		= JFactory::getUser();
		JArrayHelper::toInteger($cid, array(0));

		$db 		=& JFactory::getDBO();
		if($edit)
			$user 		=& JUser::getInstance( $cid[0] );
		else
			$user 		=& JUser::getInstance();

		$myuser		=& JFactory::getUser();
		$acl		=& JFactory::getACL();
      
     
		// Check for post data in the event that we are returning
		// from a unsuccessful attempt to save data
		$post = JRequest::get('post');
		if ( $post ) {
			$user->bind($post);
		}

		if ( $user->get('id'))
		{
			$query = 'SELECT *'
			. ' FROM #__contact_details'
			. ' WHERE user_id = '.(int) $cid[0]
			;
			$db->setQuery( $query );
			$contact = $db->loadObjectList();
		}
		else
		{
			$contact 	= NULL;
			// Get the default group id for a new user
			$config		= &JComponentHelper::getParams( 'com_users' );
			$newGrp		= $config->get( 'new_usertype' );
			$user->set( 'gid', $acl->get_group_id( $newGrp, null, 'ARO' ) );
		}

		$userObjectID 	= $acl->get_object_id( 'users', $user->get('id'), 'ARO' );
        
		$userGroups 	= $acl->get_object_groups( $userObjectID, 'ARO' );
        
		$userGroupName 	= strtolower( $acl->get_group_name( $userGroups[0], 'ARO' ) );
        
		$myObjectID 	= $acl->get_object_id( 'users', $myuser->get('id'), 'ARO' );
		$myGroups 		= $acl->get_object_groups( $myObjectID, 'ARO' );
		$myGroupName 	= strtolower( $acl->get_group_name( $myGroups[0], 'ARO' ) );;
       
		// ensure user can't add/edit group higher than themselves	
        
		if ( $userGroupName == $myGroupName && $myGroupName == 'administrator')
		{
			// administrators can't change each other
			$lists['gid'] = '<input type="hidden" name="gid" value="'. $user->get('gid') .'" /><strong>'. JText::_( 'Administrator' ) .'</strong>';
		}
		elseif ($me->get('gid')==24){
                $gid_new[0] = JHTML::_('select.option', '', JText::_('Select Group'), 'id', 'value');
                $gid_new[1] = JHTML::_('select.option', '23', JText::_('Manager'), 'id', 'value');
                $gid_new[2] = JHTML::_('select.option', '24', JText::_('Administrator'), 'id', 'value');              
                $lists['gid'] = JHTML::_('select.genericlist',  $gid_new, 'gid', 'class="inputbox" size="4" onChange="DisplayRole()" ', 'id', 'value', $user->get('gid'));       
        }
        else{ 
		
			$gtree = $acl->get_group_children_tree( null, 'USERS', false );

			// remove users 'above' me
			//$i = 0;
			//while ($i < count( $gtree )) {
			//	if ( in_array( $gtree[$i]->value, (array)$excludeGroups ) ) {
			//		array_splice( $gtree, $i, 1 );
			//	} else {
			//		$i++;
			//	}
			//}

			$lists['gid'] 	= JHTML::_('select.genericlist',   $gtree, 'gid', 'size="10"', 'value', 'text', $user->get('gid') );
		}

		// build the html select list
		$lists['block'] 	= JHTML::_('select.booleanlist',  'block', 'class="inputbox" size="1"', $user->get('block') );

		// build the html select list
		$lists['sendEmail'] = JHTML::_('select.booleanlist',  'sendEmail', 'class="inputbox" size="1"', $user->get('sendEmail') );

		$this->assignRef('me', 		$me);
		$this->assignRef('lists',	$lists);
		$this->assignRef('user',	$user);
		$this->assignRef('contact',	$contact);

		parent::display($tpl);
	}
}
