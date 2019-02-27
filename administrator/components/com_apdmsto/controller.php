<?php
/**
 * @version		$Id: controller.php 10381 2008-06-01 03:35:53Z pasamio $
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

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');
require_once('includes/class.upload.php');  



/**
 * Users Component Controller
 *
 * @package		Joomla
 * @subpackage	Users
 * @since 1.5
 */
class SToController extends JController
{
	/**
	 * Constructor
	 *
	 * @params	array	Controller configuration array
	 */
	function __construct($config = array())
	{
		parent::__construct($config);

		// Register Extra tasks
		$this->registerTask( 'addito'  , 	'display'  );
                $this->registerTask( 'addcustomer'  , 	'display'  );
		$this->registerTask( 'edit'  , 	'display'  );
		$this->registerTask( 'detail'  , 'display'  );
		$this->registerTask( 'trash'  , 'display'  );
		$this->registerTask( 'apply', 	'save'  );
		$this->registerTask( 'flogout', 'logout');
		$this->registerTask( 'unblock', 'block' );
		$this->registerTask( 'code_default', 'GetDefaultCode' );
		$this->registerTask( 'export', 'export' );
	}

	/**
	 * Displays a view
	 */
	function display( )
	{
		
		switch($this->getTask())
		{
			case 'addito':
                        {
				JRequest::setVar( 'layout', 'form'  );
				JRequest::setVar( 'view', 'ito' );
				JRequest::setVar( 'edit', false );                                
                        } break;
			case 'addeto'     :
			{	
				JRequest::setVar( 'layout', 'form'  );
				JRequest::setVar( 'view', 'eto' );
				JRequest::setVar( 'edit', false );
			} break;
			case 'editito'    :
			{				
				JRequest::setVar( 'layout', 'formedit'  );
				JRequest::setVar( 'view', 'ito' );
				JRequest::setVar( 'edit', true );
			} break;
			case 'editeto'    :
			{				
				JRequest::setVar( 'layout', 'formedit'  );
				JRequest::setVar( 'view', 'eto' );
				JRequest::setVar( 'edit', true );
			} break;                
                
			case 'detailito':{
				JRequest::setVar( 'layout', 'view'  );
				JRequest::setVar( 'view', 'ito' );
				JRequest::setVar( 'edit', true );
			}
			break;
			case 'detaileto':{
				JRequest::setVar( 'layout', 'view'  );
				JRequest::setVar( 'view', 'eto' );
				JRequest::setVar( 'edit', true );
			}
			break;                                
			
		}

		parent::display();
	}
        function get_sto_code_default() {
                $db = & JFactory::getDBO();
                $sto_type = JRequest::getVar('sto_type');

                $query = "SELECT count(*)  FROM apdm_pns_sto  WHERE sto_type = '" . $sto_type . "' and date(sto_created) = CURDATE()";
                $db->setQuery($query);
               $pns_latest = $db->loadResult();
               
                $next_pns_code = (int) $pns_latest;
                $next_pns_code++;
                $number = strlen($next_pns_code);
                switch ($number) {
                        case '1':
                                $new_pns_code = '0' . $next_pns_code;
                                break;
                        case '2':
                                $new_pns_code = $next_pns_code;
                                break;
                       
                        default:
                                $new_pns_code = $next_pns_code;
                                break;
                }
                if($sto_type==1)
                        $pre = "I";
                elseif($sto_type==2)
                        $pre = "E";
                elseif($sto_type==3)
                        $pre = "M";
                echo $pre.date('ymd').'-'.$new_pns_code;
                exit;
        }

}
