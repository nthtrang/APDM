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
class APDMUsersController extends JController
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
		$this->registerTask( 'profile'  , 	'display'  );
		$this->registerTask( 'apply', 	'save'  );
		$this->registerTask( 'changeprofile', 	'save'  );
		$this->registerTask( 'get_list', 	'display'  );
		$this->registerTask( 'ajax_user', 	'display'  );
		
		
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
			{	
				JRequest::setVar( 'layout', 'form'  );
				JRequest::setVar( 'view', 'apdmuser' );
				JRequest::setVar( 'edit', false );
			} break;
			case 'edit'    :
			{

				JRequest::setVar( 'layout', 'form'  );
				JRequest::setVar( 'view', 'apdmuser' );
				JRequest::setVar( 'edit', true );
			} break;
			case 'profile'    :
			{

				JRequest::setVar( 'layout', 'profile'  );
				JRequest::setVar( 'view', 'apdmuser' );
				JRequest::setVar( 'edit', true );
			} break;
			case 'get_list'    :
			{

				JRequest::setVar( 'layout', 'list'  );
				JRequest::setVar( 'view', 'apdmlist' );
				JRequest::setVar( 'edit', true );
			} break;
			case 'ajax_user'    :
			{

				JRequest::setVar( 'layout', 'list'  );
				JRequest::setVar( 'view', 'apdmajax' );
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
		$acl		=& JFactory::getACL();
		$MailFrom	= $mainframe->getCfg('mailfrom');
		$FromName	= $mainframe->getCfg('fromname');
		$SiteName	= $mainframe->getCfg('sitename');
		$first_name = JRequest::getVar('first_name');
		$user_title = JRequest::getVar('user_title');
		$last_name  = JRequest::getVar('last_name');
		$user_mobile = JRequest::getVar('user_mobile');
		$user_telephone  = JRequest::getVar('user_telephone');
		$block		= JRequest::getVar('block');
		$role_user   = JRequest::getVar('role_user', 0, 'post', 'array');
		$password_get	= JRequest::getVar('password', '', 'post', 'string', JREQUEST_ALLOWRAW);
 		// Create a new JUser object
		$user = new JUser(JRequest::getVar( 'id', 0, 'post', 'int'));
		
		$original_gid = $user->get('gid');

		$post = JRequest::get('post');
		$post['username']	= JRequest::getVar('username', '', 'post', 'username');
		$post['password']	= JRequest::getVar('password', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$post['password2']	= JRequest::getVar('password2', '', 'post', 'string', JREQUEST_ALLOWRAW);
		
		if (!$user->bind($post))
		{
			$mainframe->enqueueMessage(JText::_('CANNOT SAVE THE USER INFORMATION'), 'message');
			$mainframe->enqueueMessage($user->getError(), 'error');
			//$mainframe->redirect( 'index.php?option=com_users', $user->getError() );
			//return false;
			return $this->execute('edit');
		}
		$user->name 	= $first_name." ".$last_name;
		$user->email	= $user->username;
		$user->block	= 0;
		//$objectID 	= $acl->get_object_id( 'users', $user->get('id'), 'ARO' );
		//$groups 	= $acl->get_object_groups( $objectID, 'ARO' );
		//$this_group = strtolower( $acl->get_group_name( $groups[0], 'ARO' ) );
		$isNew 	= ($user->get('id') < 1);
//		if ()
		if (!$user->save())
		{

			$mainframe->enqueueMessage(JText::_('CANNOT SAVE THE USER INFORMATION'), 'message');
			$mainframe->enqueueMessage($user->getError(), 'error');
			return $this->execute('edit');
		}
		/*
			@ For table apdm_users
		*/
/*		$apdm_user		=& JTable::getInstance('apdmuser');	
		
		$apdm_user->user_id			= $user->id;
		$apdm_user->user_firstname	= $first_name;
		$apdm_user->user_lastname	= $last_name;
		$apdm_user->username		= $user->username;
		$apdm_user->user_password	= $user->password_clear;
		$apdm_user->user_email		= $user->email;
		$apdm_user->user_mobile		= $user_mobile;
		$apdm_user->user_telephone	= $user_telephone;
		$apdm_user->user_enable		= $block;
		$apdm_user->user_group		= $user->gid;
		$apdm_user->user_create		= $user->registerDate;
		$apdm_user->user_create_by	= $me->get('id');
		$user_id 					= $user->id;
*/		
		$user_id 					= $user->id;
		//check user_id
		$query_check = "SELECT COUNT(user_id) FROM apdm_users WHERE user_id=".$user_id;
		$db->setQuery($query_check);
		$check 	= $db->loadResult();
		if($check) {
			$query_apdm	= "UPDATE apdm_users SET user_firstname='".$first_name."', user_lastname='".$last_name."', username='".$user->username."', user_password='".md5($password_get)."', user_title='".$user_title."', user_mobile='".$user_mobile."', user_telephone='".$user_telephone."', user_enable=".$block.", user_group=".$user->gid.", user_create='".$user->registerDate."', user_create_by=".$me->get('id')." WHERE user_id=".$user_id;
		}else{
			$query_apdm =" INSERT INTO apdm_users (user_id, user_firstname, user_lastname, username, user_password, user_title, user_mobile, user_telephone, user_enable, user_group, user_create, user_create_by) VALUES (".$user_id.",'".$first_name."', '".$last_name."', '".$user->username."', '".md5($password_get)."', '".$user_title."', '".$user_mobile."', '".$user_telephone."', ".$block.", ".$user->gid.", '".$user->registerDate."', ".$me->get('id').") ";
		}
		$db->setQuery($query_apdm);
		
		if (!$db->query())
		{
				$msg = 'Have a problem';
				$this->setRedirect( 'index.php?option=com_apdmusers', $msg );
		}
		//print_r($apdm_user); exit;
		//delete role befor insert
		$db->setQuery("DELETE FROM apdm_role_user WHERE user_id=".$user_id);
		$db->query();
		if (count($role_user) > 0){ 
			//inert role for user
			//for($i==0; $i<count($role_user); $i++){
			foreach ($role_user as $obj){			
				$db->setQuery("INSERT INTO apdm_role_user (role_id, user_id) VALUES ({$obj}, {$user_id}) ");
				$db->query(); 
			}
		}

		//for rolde of user
		/*
	 	 * Time for the email magic so get ready to sprinkle the magic dust...
	 	 */
	//	if ($isNew)
		//{
			$adminEmail = $me->get('email');
			$adminName	= $me->get('name');

			$subject = 'Welcome to APDM'; //JText::_('NEW_USER_MESSAGE_SUBJECT');
			$message = 'Hi, <br/>';
			$message .= '<p>This your accout to login system <a href="'.URL_SITE.'"> APDM </a>:</p>';
			$message .='<p>Username: '.$user->get('username').'</p>';
			$message .='<p>Password: '.$user->password_clear.'</p>';
			$message .= '<p>Regards</p>';
			//sprintf ( JText::_('NEW_USER_MESSAGE'), $user->get('name'), $SiteName, JURI::root(), $user->get('username'), $user->password_clear );

			if ($MailFrom != '' && $FromName != '')
			{
				$adminName 	= $FromName;
				$adminEmail = $MailFrom;
			}
			JUtility::sendMail( $adminEmail, $adminName, $user->get('email'), $subject, $message, 1 );
	//	}

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

		switch ( $this->getTask() )
		{
		
			case 'changeprofile':
				$msg = JText::sprintf( 'Successfully Saved changes', $user->get('name') );
//				$this->setRedirect( 'index.php?option=com_apdm_users&view=user&task=edit&cid[]='. $user->get('id'), $msg );
					$this->setRedirect( 'index.php?option=com_apdmusers&view=apdmuser&task=profile&cid[]='.$user->get('id'), $msg );
				break;

			case 'apply':
				$msg = JText::sprintf( 'Successfully Saved changes to User', $user->get('name') );
//				$this->setRedirect( 'index.php?option=com_apdm_users&view=user&task=edit&cid[]='. $user->get('id'), $msg );
					$this->setRedirect( 'index.php?option=com_apdmusers&view=apdmuser&task=edit&cid[]='.$user->get('id'), $msg );
				break;

			case 'save':
			default:
				$msg = JText::sprintf( 'Successfully Saved User', $user->get('name') );
				$this->setRedirect( 'index.php?option=com_apdmusers', $msg );
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
			$query = "UPDATE jos_users SET block=1 WHERE id=".$id;
			$db->setQuery($query);
			$db->query();
			$query2 = "UPDATE apdm_users SET user_enable=1 WHERE user_id=".$id;
			$db->setQuery($query2);
			$db->query();
			//for history
			// check for a super admin ... can't delete them
			//$user =& JUser::getInstance((int)$id);
			//$user->delete();
			//$this->logout();
			
		}
		$msg = JText::_('Successfull delete user(s)');
		$this->setRedirect( 'index.php?option=com_apdmusers', $msg);
	}

	/**
	 * Cancels an edit operation
	 */
	function cancel( )
	{
		$this->setRedirect( 'index.php?option=com_apdmusers' );
	}
	function cancel_profile()
	{
			$this->setRedirect( 'index.php' );
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
			$query = "UPDATE apdm_users SET user_enable=".$block." WHERE user_id=".$id;
			$db->setQuery($query);
			$db->query();
		
		}
		$msg = JText::_('SUCCESSFULL_BLOCK_USERS');
		$this->setRedirect( 'index.php?option=com_apdmusers', $msg);
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
	function list_role(){
		$db 	= & JFactory::getDBO();
		$query 	= "SELECT role_id, role_name FROM apdm_role ";
		$db->setQuery($query);
	    $rows = $db->loadObjectList();
        $str = " Select Role ;; ";
         if ( count ($rows) > 0){
             foreach ($rows as $row){
                $str.= $row->role_name.";".$row->role_id.";";

              }

		}                      
          echo $str;
		  exit;
	}
	/*
		Get Value of user
	*/
	function GetValueAPDMUser($id, $value){
		$db  = & JFactory::getDBO();		
		$db->setQuery("SELECT {$value} FROM #__users WHERE id =".$id);
		return $db->loadResult();
		
	}
	/*
		Get Roles of user
	*/
	function GetRoleUser($user_id){
		$db  = & JFactory::getDBO();	
		$arrrole = array();
		$db->setQuery("select ur.role_id, r.role_name FROM apdm_role_user as ur LEFT JOIN apdm_role as r ON r.role_id = ur.role_id WHERE ur.user_id = ".$user_id." GROUP BY role_id ");
		$rows = $db->loadObjectList();
		if (count($rows) > 0){
			foreach ($rows as $row){
				$arrrole[]=  $row->role_name;
			}
		}
		return $arrrole;
	}
	
}
