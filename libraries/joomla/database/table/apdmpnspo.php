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
class JTableAPDMpnspo extends JTable {

        var $pns_po_id = null;
        var $pns_id = null;
        var $po_code = null;
        var $po_description = null;
        var $po_file = null;
        var $po_state = null;
        var $po_created = null;
        var $po_create_by = null;

        /**
         * @param database A database connector object
         */
        function __construct(&$db) {
                parent::__construct('apdm_pns_po', 'pns_po_id', $db);
        }

}
