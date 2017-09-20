<?php
/**
* @version		$Id: roles.php 10381 2008-01 
* @package		APDM
* @subpackage	Roles
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/*
 * Make sure the user is authorized to view this page
 */
$user = & JFactory::getUser();
if (!$user->authorize( 'com_users', 'manage' )) {
	$mainframe->redirect( 'index.php', JText::_('ALERTNOTAUTH') );
}

// Require the base controller
require_once (JPATH_COMPONENT.DS.'controller.php');

// Create the controller
$controller	= new RolesController( );

// Perform the Request task
$controller->execute( JRequest::getCmd('task'));
$controller->redirect();