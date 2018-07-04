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
class JTableApdmccs  extends JTable
{
	/**
	 * Unique id
	 *
	 * @var int
	 */
	var $ccs_id					= null;

	/**
	 * The users real name (or nickname)
	 *
	 * @var string
	 */
	var $ccs_code				= null;

	/**
	 * The login name
	 *
	 * @var string
	 */
	var $ccs_description		= null;

	/**
	 * The email
	 *
	 * @var string
	 */
	var $ccs_activate			= null;

	/**
	 * MD5 encrypted password
	 *
	 * @var string
	 */
	var $ccs_create				= null;

	/**
	 * Description
	 *
	 * @var string
	 */
	var $ccs_create_by			= null;

	/**
	 * Description
	 *
	 * @var int
	 */
	var $ccs_modified			= null;

	/**
	 * Description
	 *
	 * @var int
	 */
	var $ccs_modified_by		= null;

	/**
	 * The group id number
	 *
	 * @var int
	 */
	var $ccs_deleted			= null;

	/**
	 * The mark is cpn
	 *
	 * @var int
	 */
	var $ccs_cpn			= null;	
        
	/**
	 * The customer name for mpn
	 *
	 * @var string
	 */
	var $ccs_name			= null;	        

	/**
	* @param database A database connector object
	*/
	function __construct( &$db )
	{
		parent::__construct( 'apdm_ccs', 'ccs_id', $db );
	
	}
    function check(){
        if (trim( $this->ccs_code ) == '') {
            $this->setError(JText::sprintf( 'must contain a title', JText::_( 'Category') ));
            return false;
        }
        // check for existing name
        $query = 'SELECT ccs_id'
        . ' FROM apdm_ccs '
        . ' WHERE ccs_code = '.$this->_db->Quote($this->ccs_code)        
        ;
       
        $this->_db->setQuery( $query );   
        $xid = intval( $this->_db->loadResult() );
       
        if ($xid && $xid != intval( $this->ccs_id )) {              
            $this->_error = JText::_( 'This code have exit' );
            return false;
        }
        return true;
    }
    function check_des(){
        if (trim( $this->ccs_description ) == '') {
           // $this->setError(JText::sprintf( 'must contain a title', JText::_( 'Category') ));
            return true;
        }
        // check for existing name
        $query = 'SELECT ccs_id'
        . ' FROM apdm_ccs '
        . ' WHERE ccs_description = '.$this->_db->Quote($this->ccs_description)        
        ;
       
        $this->_db->setQuery( $query );   
        $xid = intval( $this->_db->loadResult() );
       
        if ($xid && $xid != intval( $this->ccs_id )) {              
         //   $this->_error = JText::_( 'This code have exit' );
            return false;
        }
        return true;
    }
	
	
}
