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
class JTableAPDMpns extends JTable
{

	var $pns_id				= null;

	
	var $ccs_code				= null;
                                                                               
        var $eco_id             = null; 
	
	
	var $pns_code			= null;
	
	
	var $pns_revision		= null;

	
	var $pns_type			= null;

	
	var $pns_status			= null;

	
	var $pns_pdf			= null;

	
	var $pns_image			= null;
	

	var $pns_description	= null;
	

	var $pns_create			= null;
	

	var $pns_create_by		= null;
	

	var $pns_modified		= null;	
	
	
	var $pns_modified_by	= null;	
	
	
	var $pns_deleted		= null;
        var $pns_life_cycle		= null;
        var $pns_uom		= null;
        var $pns_cost		= null;
        var $pns_stock		= null;
        var $pns_datein		= null;    
        var $pns_qty_used		= null;           
        var $pns_ref_des		= null;    
        var $pns_find_number		= null;   
        
	/**
	* @param database A database connector object
	*/
	function __construct( &$db )
	{
		parent::__construct( 'apdm_pns', 'pns_id', $db );
	
	}

	
	
}
