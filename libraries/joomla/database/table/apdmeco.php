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
class JTableAPDMeco extends JTable
{

	var $eco_id				= null;

	var $eco_name			= null;	

	var $eco_description	= null;
	
	var $eco_project		= null;
	
	var $eco_type			= null;
	
	var $eco_field_impact  = null;
	
	var $eco_reason			= null;
	
	var $eco_what			= null;
	
	var $eco_special		= null;
	
	var $eco_benefit        = null;
	
	var $eco_technical       = null;
	
	var $eco_tech_design	= null;
	
	var $eco_estimated 		= null;
	
	var $eco_estimated_cogs		= null;
	
	var $eco_target				= null;
	
	var $eco_status		    = null;	
	
	var $eco_activate	    = null;	

	var $eco_deleted		= null;	

	var $eco_create		= null;		
	
	var $eco_create_by	= null;		
	
	var $eco_modified	= null;	
	
	var $eco_modified_by	= null;
        
        var $eco_lifecycle	= null;

	/**
	* @param database A database connector object
	*/
	function __construct( &$db )
	{
		parent::__construct( 'apdm_eco', 'eco_id', $db );
	
	}
    function check(){
         // check for existing name
       echo $query = 'SELECT  eco_id'
        . ' FROM apdm_eco '
        . ' WHERE eco_name = '.trim($this->_db->Quote($this->eco_name))        
        ;
        
		
        $this->_db->setQuery( $query );   
        $xid = intval( $this->_db->loadResult() );
       
        if ($xid && $xid != intval( $this->eco_id  )) {                          
            return false;
        }else{
		$this->eco_name 			=  strtoupper($this->eco_name);
		$this->eco_description 		=  strtoupper($this->eco_description);
		$this->eco_project			=  strtoupper($this->eco_project);
		$this->eco_reason 			=  strtoupper($this->eco_reason);
		$this->eco_what 			=  strtoupper($this->eco_what);
		$this->eco_special 			=  strtoupper($this->eco_special);
		$this->eco_benefit 			=  strtoupper($this->eco_benefit);
		$this->eco_technical 		=  strtoupper($this->eco_technical);
		$this->eco_tech_design 		=  strtoupper($this->eco_tech_design);
		$this->eco_estimated 		=  strtoupper($this->eco_estimated);
		$this->eco_estimated_cogs 	=  strtoupper($this->eco_estimated_cogs);
		$this->eco_target		 	=  strtoupper($this->eco_target);
                $this->eco_lifecycle		 	=  strtoupper($this->eco_lifecycle);
	//	$this->eco_estimated_cogs 	=  strtoupper($this->eco_estimated_cogs);
		
		
        return true;
        }
          
    }

	
	
}
