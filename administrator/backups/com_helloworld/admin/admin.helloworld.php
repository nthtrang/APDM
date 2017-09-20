<?php
/**
* @package HelloWorld
* @version 1.0
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software and parts of it may contain or be derived from the
* GNU General Public License or other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

/*
 * DEVNOTE: This is the 'main' file. 
 * It's the one that will be called when we go to the HELLOWORD component. 
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/*
 * Make sure the user is authorized to view this page
 */
/* get rid of it...must be changed in libraries\joomla\user\authorization.php 
$user = & JFactory::getUser();
   
if (!$user->authorize( 'com_helloword', 'manage' )) {
	$mainframe->redirect( 'index.php', JText::_('ALERTNOTAUTH') );
}
*/
// Load the html class
// DEVNOTE: This will include the admin.helloworld.html.php file, 
// so now we can use anything that it provides!
require_once( JApplicationHelper::getPath( 'admin_html' ) ); 

/*
 * DEVNOTE: $task and $option are obviously defined outside of the scope of our code.
 * The different functions mentioned below are all defined further on.
 * 
 * We defined class helloScreens and 4 function
 * helloworld,helloagain,hellotestfoo,hellodefault
 * 
 * Each of them does nothing else than shows different text.  
 * 
 * $task values are defined in com_helloworld.xml
 *  
 * 		<submenu>
 *			<!-- Note that all & must be escaped to &amp; for the file to be valid XML and be parsed by the installer -->
 *			<menu link="option=com_helloworld&amp;task=helloworld">Hello World!</menu>
 *			<menu link="option=com_helloworld&amp;task=helloagain">Hello Again!</menu>
 *			<menu link="option=com_helloworld&amp;task=hellotestfoo">Testing Foo Function</menu>
 *		</submenu>    
 */ 
switch ($task) {
  case 'helloworld':
    helloScreens::helloworld();
    break;
  case 'helloagain': 
    helloScreens::helloagain();
    break;
  case 'hellotestfoo': 
    helloScreens::hellotestfoo();
    break;
	default:
		helloScreens::hellodefault();
		break;
}
?>
