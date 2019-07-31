<?php
/**
 * @version		$Id: controller.php 10381 2008-06-01 03:35:53Z pasamio $
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

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * Users Component Controller
 *
 * @package		Joomla
 * @subpackage	Users
 * @since 1.5
 */
class UsersController extends JController
{
	/**
	 * Constructor
	 *
	 * @params	array	Controller configuration array
	 */
	function __construct($config = array())
	{
		parent::__construct($config);

		// Register Extra tasks
		$this->registerTask( 'add'  , 	'display'  );
		$this->registerTask( 'edit'  , 	'display'  );
		$this->registerTask( 'apply', 	'save'  );
		$this->registerTask( 'flogout', 'logout');
		$this->registerTask( 'unblock', 'block' );
	}

	/**
	 * Displays a view
	 */
	function display( )
	{
		switch($this->getTask())
		{
			case 'add'     :
			{	JRequest::setVar( 'hidemainmenu', 1 );
				JRequest::setVar( 'layout', 'form'  );
				JRequest::setVar( 'view', 'user' );
				JRequest::setVar( 'edit', false );
			} break;
			case 'edit'    :
			{
				JRequest::setVar( 'hidemainmenu', 1 );
				JRequest::setVar( 'layout', 'form'  );
				JRequest::setVar( 'view', 'user' );
				JRequest::setVar( 'edit', true );
			} break;
		}

		parent::display();
	}

	/**
	 * Saves the record
	 */
	function save()
	{
		global $mainframe;

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$option = JRequest::getCmd( 'option');

		// Initialize some variables
		$db			= & JFactory::getDBO();
		$me			= & JFactory::getUser();
		$acl			=& JFactory::getACL();
		$MailFrom	= $mainframe->getCfg('mailfrom');
		$FromName	= $mainframe->getCfg('fromname');
		$SiteName	= $mainframe->getCfg('sitename');

 		// Create a new JUser object
		$user = new JUser(JRequest::getVar( 'id', 0, 'post', 'int'));
		$original_gid = $user->get('gid');

		$post = JRequest::get('post');
		$post['username']	= JRequest::getVar('username', '', 'post', 'username');
		$post['password']	= JRequest::getVar('password', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$post['password2']	= JRequest::getVar('password2', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$post['apdm_user']  = JRequest::getVar('apdm_user', 0, 'post', 'int');
		if (!$user->bind($post))
		{
			$mainframe->enqueueMessage(JText::_('CANNOT SAVE THE USER INFORMATION'), 'message');
			$mainframe->enqueueMessage($user->getError(), 'error');
			//$mainframe->redirect( 'index.php?option=com_users', $user->getError() );
			//return false;
			return $this->execute('edit');
		}

		$objectID 	= $acl->get_object_id( 'users', $user->get('id'), 'ARO' );
		$groups 	= $acl->get_object_groups( $objectID, 'ARO' );
		$this_group = strtolower( $acl->get_group_name( $groups[0], 'ARO' ) );


		if ( $user->get('id') == $me->get( 'id' ) && $user->get('block') == 1 )
		{
			$msg = JText::_( 'You cannot block Yourself!' );
			$mainframe->enqueueMessage($msg, 'message');
			return $this->execute('edit');
		}
		else if ( ( $this_group == 'super administrator' ) && $user->get('block') == 1 ) {
			$msg = JText::_( 'You cannot block a Super Administrator' );
			$mainframe->enqueueMessage($msg, 'message');
			return $this->execute('edit');
		}
		else if ( ( $this_group == 'administrator' ) && ( $me->get( 'gid' ) == 24 ) && $user->get('block') == 1 )
		{
			$msg = JText::_( 'WARNBLOCK' );
			$mainframe->enqueueMessage($msg, 'message');
			return $this->execute('edit');
		}
		else if ( ( $this_group == 'super administrator' ) && ( $me->get( 'gid' ) != 25 ) )
		{
			$msg = JText::_( 'You cannot edit a super administrator account' );
			$mainframe->enqueueMessage($msg, 'message');
			return $this->execute('edit');
		}
		// Are we dealing with a new user which we need to create?
		$isNew 	= ($user->get('id') < 1);
		if (!$isNew)
		{
			// if group has been changed and where original group was a Super Admin
			if ( $user->get('gid') != $original_gid && $original_gid == 25 )
			{
				// count number of active super admins
				$query = 'SELECT COUNT( id )'
					. ' FROM #__users'
					. ' WHERE gid = 25'
					. ' AND block = 0'
				;
				$db->setQuery( $query );
				$count = $db->loadResult();

				if ( $count <= 1 )
				{
					// disallow change if only one Super Admin exists
					$this->setRedirect( 'index.php?option=com_users', JText::_('WARN_ONLY_SUPER') );
					return false;
				}
			}
		}

		/*
	 	 * Lets save the JUser object
	 	 */
		if (!$user->save())
		{

			$mainframe->enqueueMessage(JText::_('CANNOT SAVE THE USER INFORMATION'), 'message');
			$mainframe->enqueueMessage($user->getError(), 'error');
			return $this->execute('edit');
		}

		/*
	 	 * Time for the email magic so get ready to sprinkle the magic dust...
	 	 */
		if ($isNew)
		{
			$adminEmail = $me->get('email');
			$adminName	= $me->get('name');

			$subject = JText::_('NEW_USER_MESSAGE_SUBJECT');
			$message = sprintf ( JText::_('NEW_USER_MESSAGE'), $user->get('name'), $SiteName, JURI::root(), $user->get('username'), $user->password_clear );

			if ($MailFrom != '' && $FromName != '')
			{
				$adminName 	= $FromName;
				$adminEmail = $MailFrom;
			}
			JUtility::sendMail( $adminEmail, $adminName, $user->get('email'), $subject, $message );
		}

		// If updating self, load the new user object into the session
		if ($user->get('id') == $me->get('id'))
		{
			// Get an ACL object
			$acl = &JFactory::getACL();

			// Get the user group from the ACL
			$grp = $acl->getAroGroup($user->get('id'));

			// Mark the user as logged in
			$user->set('guest', 0);
			$user->set('aid', 1);

			// Fudge Authors, Editors, Publishers and Super Administrators into the special access group
			if ($acl->is_group_child_of($grp->name, 'Registered')      ||
			    $acl->is_group_child_of($grp->name, 'Public Backend'))    {
				$user->set('aid', 2);
			}

			// Set the usertype based on the ACL group name
			$user->set('usertype', $grp->name);

			$session = &JFactory::getSession();
			$session->set('user', $user);
		}
	/*	
		if ($post['apdm_user'] && $user->gid < 25 ){ //add  new user for APDM
			//check user 
			$db->setQuery('SELECT COUNT(user_id) FROM apdm_users WHERE user_id='.$user->get('id'));
			$apdm = $db->loadResult();
			if ($apdm){ //update information for this user
				if ($post['password'] !=''){
					$set_pass = ", user_password ='".md5($post['password'])."'";
				}else{
					$set_pass = '';
				}
				
				$query_update = "UPDATE apdm_users SET user_firstname='".$user->name."', username='".$user->username."', user_group=".$user->gid.", user_create_by=".$me->get('id').$set_pass." WHERE user_id=".$user->id;
				$db->setQuery($query_update);
				$db->query();
				
			}else{ //add new apdm user 
				$query_insert = "INSERT INTO apdm_users (user_id, user_firstname, username, user_password, user_title, user_mobile,  user_telephone, user_enable, user_group, user_create, user_create_by) VALUES (".$user->id.", '".$user->name."', '".$user->username."', '".md5($post['password'])."', '', '', '', 0, ".$user->gid.", '".$user->registerDate."', ".$user->id.") ";
				$db->setQuery($query_insert);
				$db->query();
			}
		}
		*/
		switch ( $this->getTask() )
		{
			case 'apply':
				$msg = JText::sprintf( 'Successfully Saved changes to User', $user->get('name') );
				$this->setRedirect( 'index.php?option=com_users&view=user&task=edit&cid[]='. $user->get('id'), $msg );
				break;

			case 'save':
			default:
				$msg = JText::sprintf( 'Successfully Saved User', $user->get('name') );
				$this->setRedirect( 'index.php?option=com_users', $msg );
				break;
		}
	}

	/**
	 * Removes the record(s) from the database
	 */
	function remove()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$db 			=& JFactory::getDBO();
		$currentUser 	=& JFactory::getUser();
		$acl			=& JFactory::getACL();
		$cid 			= JRequest::getVar( 'cid', array(), '', 'array' );

		JArrayHelper::toInteger( $cid );

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select a User to delete', true ) );
		}

		foreach ($cid as $id)
		{
			// check for a super admin ... can't delete them
			$objectID 	= $acl->get_object_id( 'users', $id, 'ARO' );
			$groups 	= $acl->get_object_groups( $objectID, 'ARO' );
			$this_group = strtolower( $acl->get_group_name( $groups[0], 'ARO' ) );

			$success = false;
			if ( $this_group == 'super administrator' )
			{
				$msg = JText::_( 'You cannot delete a Super Administrator' );
			}
			else if ( $id == $currentUser->get( 'id' ) )
			{
				$msg = JText::_( 'You cannot delete Yourself!' );
			}
			else if ( ( $this_group == 'administrator' ) && ( $currentUser->get( 'gid' ) == 24 ) )
			{
				$msg = JText::_( 'WARNDELETE' );
			}
			else
			{
				$user =& JUser::getInstance((int)$id);
				$count = 2;

				if ( $user->get( 'gid' ) == 25 )
				{
					// count number of active super admins
					$query = 'SELECT COUNT( id )'
						. ' FROM #__users'
						. ' WHERE gid = 25'
						. ' AND block = 0'
					;
					$db->setQuery( $query );
					$count = $db->loadResult();
				}

				if ( $count <= 1 && $user->get( 'gid' ) == 25 )
				{
					// cannot delete Super Admin where it is the only one that exists
					$msg = "You cannot delete this Super Administrator as it is the only active Super Administrator for your site";
				}
				else
				{
					// delete user
					$user->delete();
					//well, delete user in the apdm too
					$query = 'DELETE FROM apdm_users WHERE user_id='.$id;
					$db->setQuery($query);
					$db->query();
					$query3 = "DELETE FROM apdm_role_user WHERE user_id=".$id;
	  				$db->setQuery($query3);
					$db->query();
					JRequest::setVar( 'task', 'remove' );
					JRequest::setVar( 'cid', $id );

					// delete user acounts active sessions
					$this->logout();
				}
			}
		}

		$this->setRedirect( 'index.php?option=com_users', $msg);
	}

	/**
	 * Cancels an edit operation
	 */
	function cancel( )
	{
		$this->setRedirect( 'index.php?option=com_users' );
	}

	/**
	 * Disables the user account
	 */
	function block( )
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$db 			=& JFactory::getDBO();
		$acl			=& JFactory::getACL();
		$currentUser 	=& JFactory::getUser();

		$cid 	= JRequest::getVar( 'cid', array(), '', 'array' );
		$block  = $this->getTask() == 'block' ? 1 : 0;

		JArrayHelper::toInteger( $cid );

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select a User to '.$this->getTask(), true ) );
		}
		foreach ($cid as $id)
		{
			// check for a super admin ... can't delete them
			$objectID 	= $acl->get_object_id( 'users', $id, 'ARO' );
			$groups 	= $acl->get_object_groups( $objectID, 'ARO' );
			$this_group = strtolower( $acl->get_group_name( $groups[0], 'ARO' ) );

			$success = false;
			if ( $this_group == 'super administrator' )
			{
				$msg = JText::_( 'You cannot block a Super Administrator' );
			}
			else if ( $id == $currentUser->get( 'id' ) )
			{
				$msg = JText::_( 'You cannot block Yourself!' );
			}
			else if ( ( $this_group == 'administrator' ) && ( $currentUser->get( 'gid' ) == 24 ) )
			{
				$msg = JText::_( 'WARNBLOCK' );
			}
			else
			{
				$user =& JUser::getInstance((int)$id);
				$count = 2;

				if ( $user->get( 'gid' ) == 25 )
				{
					// count number of active super admins
					$query = 'SELECT COUNT( id )'
						. ' FROM #__users'
						. ' WHERE gid = 25'
						. ' AND block = 0'
					;
					$db->setQuery( $query );
					$count = $db->loadResult();
				}

				if ( $count <= 1 && $user->get( 'gid' ) == 25 )
				{
					// cannot delete Super Admin where it is the only one that exists
					$msg = "You cannot block this Super Administrator as it is the only active Super Administrator for your site";
				}
				else
				{
					$user =& JUser::getInstance((int)$id);
					$user->block = $block;
					$user->save();

					if($block)
					{
						JRequest::setVar( 'task', 'block' );
						JRequest::setVar( 'cid', array($id) );

						// delete user acounts active sessions
						$this->logout();
					}
				}
			}
		}

		$this->setRedirect( 'index.php?option=com_users', $msg);
	}

	/**
	 * Force log out a user
	 */
	function logout( )
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		global $mainframe;

		$db		=& JFactory::getDBO();
		$task 	= $this->getTask();
		$cids 	= JRequest::getVar( 'cid', array(), '', 'array' );
		$client = JRequest::getVar( 'client', 0, '', 'int' );
		$id 	= JRequest::getVar( 'id', 0, '', 'int' );

		JArrayHelper::toInteger($cids);

		if ( count( $cids ) < 1 ) {
			$this->setRedirect( 'index.php?option=com_users', JText::_( 'User Deleted' ) );
			return false;
		}

		foreach($cids as $cid)
		{
			$options = array();

			if ($task == 'logout' || $task == 'block') {
				$options['clientid'][] = 0; //site
				$options['clientid'][] = 1; //administrator
			} else if ($task == 'flogout') {
				$options['clientid'][] = $client;
			}

			$mainframe->logout((int)$cid, $options);
		}


		$msg = JText::_( 'User Session Ended' );
		switch ( $task )
		{
			case 'flogout':
				$this->setRedirect( 'index.php', $msg );
				break;

			case 'remove':
			case 'block':
				return;
				break;

			default:
				$this->setRedirect( 'index.php?option=com_users', $msg );
				break;
		}
	}

	function contact()
	{
		$contact_id = JRequest::getVar( 'contact_id', '', 'post', 'int' );
		$this->setRedirect( 'index.php?option=com_contact&atask=edit&cid[]='. $contact_id );
	}
	function apdm()
	{
		global $mainframe;
		$cid 	= JRequest::getVar( 'cid', array(), '', 'array' );
		//get information of this user
		$db		=& JFactory::getDBO();
		$me			= & JFactory::getUser();
		$query = "SELECT * FROM jos_users WHERE id=".$cid[0];
		$db->setQuery($query);
		$row = $db->loadObjectList();
		//check for user have exist or not exist in this table apdm_user
		$query_check = "SELECT user_id FROM apdm_users WHERE user_id=".$cid[0];
		$db->setQuery($query_check);
		$result = $db->loadResult();
		if ($result) {
			$query_apdm =  "UPDATE apdm_users SET user_firstname='".$row[0]->name."',  username='".$row[0]->username."', user_password='".$row[0]->password."',  user_enable=0, user_group=".$row[0]->gid.", user_create='".$row[0]->registerDate."', user_create_by=".$me->get('id')." WHERE user_id=".$cid[0];
		}else{
			$query_apdm =" INSERT INTO apdm_users (user_id, user_firstname, user_lastname, username, user_password, user_title, user_mobile, user_telephone, user_enable, user_group, user_create, user_create_by) VALUES (".$cid[0].",'".$row[0]->name."', '', '".$row[0]->username."', '".$row[0]->password."', '', '', '', 0, ".$row[0]->gid.", '".$row[0]->registerDate."', ".$me->get('id').") ";
		}
		$db->setQuery($query_apdm);
		if (!$db->query())
		{
				$msg = 'Have a problem';
				$this->setRedirect( 'index.php?option=com_users', $msg );
		}else{
			//sent mail inform user
			$MailFrom	= $mainframe->getCfg('mailfrom');
			$FromName	= $mainframe->getCfg('fromname');
			$SiteName	= $mainframe->getCfg('sitename');
                        $SiteUrl	= $mainframe->getCfg('siteurl');
			$adminEmail = $me->get('email');
			$adminName	= $me->get('name');

			$subject = JText::_('APPROVE_MAIL_SUBJECT'); 
			
			$message = 'Welcome to APDM <br/>';
			$message .='<br>+ Username: '.$row[0]->username;
			$message .='<br> + Password: use your current password to access corporate network';
			$message .='<br> + Link: <a href="'.$SiteUrl.'"> APDM </a>';
			
			
			$db->setQuery('SELECT email FROM jos_users WHERE id='.$cid[0]);
			$email_user = $db->loadResult();
			if ($MailFrom != '' && $FromName != '')
			{
				$adminName 	= $FromName;
				$adminEmail = $MailFrom;
			}
			
			JUtility::sendMail( $adminEmail, $adminName, $email_user, $subject, $message, 1 );
			
			$msg = 'User have updated.';
			$this->setRedirect( 'index.php?option=com_users', $msg );
		}
	}
	function notadpm(){
	
		global $mainframe;
		$cid 	= JRequest::getVar( 'cid', array(), '', 'array' );
		//get information of this user
		$db		=& JFactory::getDBO();
		$me			= & JFactory::getUser();
		$query = "UPDATE apdm_users SET user_enable=1 WHERE user_id=".$cid[0];
		$db->setQuery($query);
		if (!$db->query())
		{
				$msg = 'Have a problem';
				$this->setRedirect( 'index.php?option=com_users', $msg );
		}else{
			//sent mail inform user
			$MailFrom	= $mainframe->getCfg('mailfrom');
			$FromName	= $mainframe->getCfg('fromname');
			$SiteName	= $mainframe->getCfg('sitename');
			$adminEmail = $me->get('email');
			$adminName	= $me->get('name');

			$subject = JText::_('SUBJECT_EMAIL_INFROM_USER_DONT_HAVE_PERMISSION_LOGIN_ADMINISTRATOR'); 
			$message = 'Hi, <br/>';
			$message .= '<p>Your accout do not have permission to login system <a href="'.$SiteUrl.'"> APDM </a>:</p>';
			$message .='<p>Please contact with Admin if you have any question.</p>';
			$message .= '<p>Regards</p>';
			$db->setQuery('SELECT email FROM jos_users WHERE id='.$cid[0]);
			$email_user = $db->loadResult();
			if ($MailFrom != '' && $FromName != '')
			{
				$adminName 	= $FromName;
				$adminEmail = $MailFrom;
			}
			
			JUtility::sendMail( $adminEmail, $adminName, $email_user, $subject, $message, 1 );
			
			$msg = 'User have updated.';
			$this->setRedirect( 'index.php?option=com_users', $msg );
		}
	}
}
