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
 * Roles table
 *
 * @package 	Joomla.Framework
 * @subpackage		Table
 * @since	1.0
 */
class JTableRole extends JTable
{
	/**
	 * Unique role_id
	 *
	 * @var int
	 */
	var $role_id	    	= null;

	/**  	  
	 * @var string
	 */
	var $role_name			 = null;
	/**  	  
	 * @var string
	 */
	var $role_description	 = null;
  	
	/**   	
	 * @var string
	 */
	var $role_create		= null;

	/**
	 * @var string
	 */
	var $role_create_by		= null;

	/**
	 * MD5 encrypted password
	 *
	 * @var string
	 */
	var $role_modified		= null;

	/**
	 * Description
	 *
	 * @var string
	 */
	var $role_modified_by		= null;
	
	/**
	* @param database A database connector object
	*/
	function __construct( &$db )
	{
		parent::__construct( 'apdm_role', 'role_id', $db );

		//initialise
		$this->role_id        = 0;
		
	}
	function check()
	{
		// check for valid name
		if (trim( $this->role_name ) == '') {
			$this->setError(JText::_( 'ALERT_ROLE_NAME_NOT_EMPTY'));
			return false;
		}			
		// check for existing name
		$query = 'SELECT role_id'
		. ' FROM apdm_role '
		. ' WHERE role_name = '.$this->_db->Quote($this->role_name)
		;
		$this->_db->setQuery( $query );
		$xid = intval( $this->_db->loadResult() );
		if ($xid && $xid != intval( $this->role_id )) {
			$this->_error = JText::_( 'ALERT_ROLE_NAME_EXIST' );
			return false;
		}

		return true;
	}
		
}
