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
class JTableAPDMUser extends JTable
{
	/**
	 * Unique id
	 *
	 * @var int
	 */
	var $id				= null;

	/**
	 * The users real name (or nickname)
	 *
	 * @var string
	 */
	var $user_firstname			= null;

	/**
	 * The login name
	 *
	 * @var string
	 */
	var $user_lastname		= null;

	/**
	 * The email
	 *
	 * @var string
	 */
	var $username			= null;

	/**
	 * MD5 encrypted password
	 *
	 * @var string
	 */
	var $user_password		= null;

	/**
	 * Description
	 *
	 * @var string
	 */
	var $user_title			= null;

	/**
	 * Description
	 *
	 * @var int
	 */
	var $user_mobile			= null;

	/**
	 * Description
	 *
	 * @var int
	 */
	var $user_telephone			= null;

	/**
	 * The group id number
	 *
	 * @var int
	 */
	var $user_enable			= null;

	/**
	 * Description
	 *
	 * @var datetime
	 */
	var $user_group				= null;

	/**
	 * Description
	 *
	 * @var datetime
	 */
	var $user_create			= null;

	/**
	 * Description
	 *
	 * @var string activation hash
	 */
	var $user_create_by			= null;


	/**
	* @param database A database connector object
	*/
	function __construct( &$db )
	{
		parent::__construct( 'apdm_users', 'id', $db );
	
	}

	
	
}
