<?php
/**
* @version		$Id: view.html.php 10496 2008-07-03 07:08:39Z ircmaxell $
* @package		APDM
* @subpackage	PNS
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
class cpnsViewdownload extends JView
{
	function display($tpl = null)
	{
	   // global $mainframe, $option;

        $db                =& JFactory::getDBO();
		$dirname 			= JRequest::getVar('zdir');
		$dirname_array      = explode("-", $dirname);
		$path 				= '../uploads/pns/cads/'.$dirname_array[0].'/'.$dirname.'/';
//		$path 				= JPATH_ROOT.DS.'uploads'.DS.'pns'.DS.'cads'.DS.$dirname_array[0].DS.$dirname.DS;
		$file_name_zip   =  $dirname.'_'.time();
		//echo $path;
        $this->assignRef('path',        $path);   
		$this->assignRef('ccs_code',        $dirname_array[0]);   
		$this->assignRef('pns_code',        $dirname);   
		 
		$this->assignRef('file_name_zip',   $file_name_zip );   
		
		          
		parent::display($tpl);
	}
}

