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
class cpnsViewmulti_uploads_form extends JView
{
	function display($tpl = null)
	{
	    global $mainframe, $option;

        $db                =& JFactory::getDBO();
        $option             = 'com_apdmpns';     
        $cid  =    $mainframe->getUserStateFromRequest( "$option.cid",        'cid',  '0',    'array' );         
        $query_pns = " SELECT * FROM apdm_pns WHERE pns_id IN (".implode(",", $cid).") ";   
        $db->setQuery($query_pns);
        $rows = $db->loadObjectList(); 
         $this->assignRef('rows',        $rows);    
       	parent::display($tpl);
	}
}

