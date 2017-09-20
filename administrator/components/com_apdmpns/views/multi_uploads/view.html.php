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
class pnsViewmulti_uploads extends JView
{
	function display($tpl = null)
	{
	    global $mainframe, $option;

        $db                =& JFactory::getDBO();
        $option            = 'com_apdmpns';     
        $cid               = JRequest::getVar( 'cid', array(), '', 'array' );    
        
        $list_pns_get = implode(",", $cid);
        $_SESSION['list_pns_upload'] =  $list_pns_get;
        $type_upload        = $mainframe->getUserStateFromRequest( "$option.type_upload",        'type_upload',  '0',    'int' );   
        $bt_next        = $mainframe->getUserStateFromRequest( "$option.bt_next",        'bt_next',  '',    'string' );                
        $form_submit     =  $mainframe->getUserStateFromRequest( "$option.form_submit",    'form_submit',  '0',    'int' );        
        $limit        = $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
        $limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' ); 
       
        if ($bt_next=='next_upload'){  //for submit next            
            $list_pns_post = JRequest::getVar('pns_id');            
            ///get list PNS            
            $query_pns = " SELECT * FROM apdm_pns WHERE pns_deleted=0 AND pns_id NOT IN (".$list_pns_post.")";
         //   echo   $query_pns;
            $db->setQuery($query_pns);
            $rows = $db->loadObjectList();
            jimport('joomla.html.pagination');
            $pagination = new JPagination( count($rows), $limitstart, $limit );
            $db->setQuery( $query_pns, $pagination->limitstart, $pagination->limit );
            $rows = $db->loadObjectList();           
            $this->assignRef('bt_next',        $bt_next);
            $this->assignRef('type_upload',    $type_upload);            
            $this->assignRef('rows',        $rows);
            $this->assignRef('pagination',    $pagination); 
           
            
        }
            $this->assignRef('list_pns_get',    $_SESSION['list_pns_upload']);   
       	parent::display($tpl);
	}
}

