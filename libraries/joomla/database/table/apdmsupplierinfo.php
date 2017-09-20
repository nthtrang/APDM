<?php
/**
* @version		$Id: user.php 11223 2008-10-29 03:10:37Z pasamio $
* @package		Joomla.Framework
* @subpackage	Table
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Users table
 *
 * @package 	Joomla.Framework
 * @subpackage		Table
 * @since	1.0
 */
class JTableAPDMsupplierInfo extends JTable
{

	var $info_id			= null;

	
	var $info_type			= null;
	
	var $info_name			= null;
	
	var $info_address		= null;

	
	var $info_telfax		= null;

	
	var $info_website		= null;

	
	var $info_contactperson	= null;

	
	var $info_email			= null;
	

	var $info_description	= null;
	

	var $info_activate		= null;
	

	var $info_deleted		= null;
	

	var $info_create		= null;	
	
	
	var $info_created_by	= null;	
	
	
	var $info_modified_by	= null;
	
	
	var $info_modified		= null;


	/**
	* @param database A database connector object
	*/
	function __construct( &$db )
	{
		parent::__construct( 'apdm_supplier_info', 'info_id', $db );
	
	}
     function check(){
         // check for existing name
        $query = 'SELECT  info_id'
        . ' FROM apdm_supplier_info '
        . ' WHERE info_name = '.$this->_db->Quote(trim($this->info_name))    
        . ' AND info_type ='.$this->info_type
        ;
       // echo $query; exit;
        $this->_db->setQuery( $query );   
        $xid = intval( $this->_db->loadResult() );         
        if ($xid && $xid != intval( $this->info_id)) {    
        //echo 'aaa'.$this->info_id;                      exit;
            return false;
        }
		$this->info_name				= strtoupper($this->info_name);
		$this->info_address				= strtoupper($this->info_address);
		$this->info_contactperson		= strtoupper($this->info_contactperson);
		$this->info_description			= strtoupper($this->info_description);
	
		
        return true;
          
    }

	
	
}
