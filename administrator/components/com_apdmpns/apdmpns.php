<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Require the base controller
require_once (JPATH_COMPONENT.DS.'controller.php');

// Create the controller
$controller	= new PNsController( );
    //echo 'Test'.JRequest::getCmd('task');    exit;
// Perform the Request task
$controller->execute( JRequest::getCmd('task'));
$controller->redirect();