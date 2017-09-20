<?php
/**
 * @package		APDM
 * @subpackage	UECO
*/


// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Require the base controller
require_once (JPATH_COMPONENT.DS.'controller.php');

// Create the controller
$controller	= new ECOController( );

// Perform the Request task
$controller->execute( JRequest::getCmd('task'));
$controller->redirect();