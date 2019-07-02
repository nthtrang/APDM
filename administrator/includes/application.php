<?php
/**
* @version		$Id: application.php 10382 2008-06-01 06:56:02Z pasamio $
* @package		Joomla
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

jimport('joomla.application.component.helper');

/**
* Joomla! Application class
*
* Provide many supporting API functions
*
* @package		Joomla
* @final
*/
class JAdministrator extends JApplication
{
	/**
	* Class constructor
	*
	* @access protected
	* @param	array An optional associative array of configuration settings.
	* Recognized key values include 'clientId' (this list is not meant to be comprehensive).
	*/
	function __construct($config = array())
	{
		$config['clientId'] = 1;
		parent::__construct($config);

		//Set the root in the URI based on the application name
		JURI::root(null, str_replace('/'.$this->getName(), '', JURI::base(true)));
	}

	/**
	* Initialise the application.
	*
	* @access public
	* @param array An optional associative array of configuration settings.
	*/
	function initialise($options = array())
	{
		// if a language was specified it has priority
		// otherwise use user or default language settings
		if (empty($options['language']))
		{
			$user = & JFactory::getUser();
			$lang	= $user->getParam( 'admin_language' );

			// Make sure that the user's language exists
			if ( $lang && JLanguage::exists($lang) ) {
				$options['language'] = $lang;
			} else {
				$params = JComponentHelper::getParams('com_languages');
				$client	=& JApplicationHelper::getClientInfo($this->getClientId());
				$options['language'] = $params->get($client->name, 'en-GB');
			}
		}

		// One last check to make sure we have something
		if ( ! JLanguage::exists($options['language']) ) {
			$options['language'] = 'en-GB';
		}

		parent::initialise($options);
	}

	/**
	* Route the application
	*
	* @access public
	*/
	function route()
	{

	}

	/**
	 * Return a reference to the JRouter object.
	 *
	 * @access	public
	 * @return	JRouter.
	 * @since	1.5
	 */
	function &getRouter()
	{
		$router =& parent::getRouter('administrator');
		return $router;
	}

	/**
	* Dispatch the application
	*
	* @access public
	*/
	function dispatch($component)
	{
		$document	=& JFactory::getDocument();
		$user		=& JFactory::getUser();

		switch($document->getType())
		{
			case 'html' :
			{
				$document->setMetaData( 'keywords', $this->getCfg('MetaKeys') );

				if ( $user->get('id') ) {
					$document->addScript( JURI::root(true).'/includes/js/joomla.javascript.js');
				}

				JHTML::_('behavior.mootools');
			} break;

			default : break;
		}

		$document->setTitle( htmlspecialchars_decode($this->getCfg('sitename' )). ' - ' .JText::_( 'Administration' ));
		$document->setDescription( $this->getCfg('MetaDesc') );

		$contents = JComponentHelper::renderComponent($component);
		$document->setBuffer($contents, 'component');
	}

	/**
	* Display the application.
	*
	* @access public
	*/
	function render()
	{
		$component	= JRequest::getCmd('option');
		$template	= $this->getTemplate();
		$file 		= JRequest::getCmd('tmpl', 'index');

		if($component == 'com_login') {
			$file = 'login';
		}

		$params = array(
			'template' 	=> $template,
			'file'		=> $file.'.php',
			'directory'	=> JPATH_THEMES
		);

		$document =& JFactory::getDocument();
		$data = $document->render($this->getCfg('caching'), $params );
		JResponse::setBody($data);
	}

	/**
	* Login authentication function
	*
	* @param	array 	Array( 'username' => string, 'password' => string )
	* @param	array 	Array( 'remember' => boolean )
	* @access public
	* @see JApplication::login
	*/
	function login($credentials, $options = array())
	{
		//The minimum group
		$options['group'] = 'Public Backend';

		 //Make sure users are not autoregistered
		$options['autoregister'] = false;

		//Set the application login entry point
		if(!array_key_exists('entry_url', $options)) {
			$options['entry_url'] = JURI::base().'index.php?option=com_user&task=login';
		}

		$result = parent::login($credentials, $options);

		if(!JError::isError($result))
		{
			$lang = JRequest::getCmd('lang');
			$lang = preg_replace( '/[^A-Z-]/i', '', $lang );
			$this->setUserState( 'application.lang', $lang  );

			JAdministrator::purgeMessages();
		}

		return $result;
	}

	/**
	 * Get the template
	 *
	 * @return string The template name
	 * @since 1.0
	 */
	function getTemplate()
	{
		static $template;

		if (!isset($template))
		{
			// Load the template name from the database
			$db =& JFactory::getDBO();
			$query = 'SELECT template'
				. ' FROM #__templates_menu'
				. ' WHERE client_id = 1'
				. ' AND menuid = 0'
				;
			$db->setQuery( $query );
			$template = $db->loadResult();

			$template = JFilterInput::clean($template, 'cmd');

			if (!file_exists(JPATH_THEMES.DS.$template.DS.'index.php')) {
				$template = 'khepri';
			}
		}

		return $template;
	}

	/**
	* Purge the jos_messages table of old messages
	*
	* static method
	* @since 1.5
	*/
	function purgeMessages()
	{
		$db		=& JFactory::getDBO();
		$user	=& JFactory::getUser();

		$userid = $user->get('id');

		$query = 'SELECT *'
		. ' FROM #__messages_cfg'
		. ' WHERE user_id = ' . (int) $userid
		. ' AND cfg_name = "auto_purge"'
		;
		$db->setQuery( $query );
		$config = $db->loadObject( );

		// check if auto_purge value set
		if (is_object( $config ) and $config->cfg_name == 'auto_purge' )
		{
			$purge 	= $config->cfg_value;
		}
		else
		{
			// if no value set, default is 7 days
			$purge 	= 7;
		}
		// calculation of past date

		// if purge value is not 0, then allow purging of old messages
		if ($purge > 0)
		{
			// purge old messages at day set in message configuration
			$past =& JFactory::getDate(time() - $purge * 86400);
			$pastStamp = $past->toMySQL();

			$query = 'DELETE FROM #__messages'
			. ' WHERE date_time < ' . $db->Quote( $pastStamp )
			. ' AND user_id_to = ' . (int) $userid
			;
			$db->setQuery( $query );
			$db->query();
		}
	}

   /**
	* Deprecated, use JURI::root() instead.
	*
	* @since 1.5
	* @deprecated As of version 1.5
	* @see JURI::root()
	*/
	function getSiteURL()
	{
	   return JURI::root();
	}
	/*
		* to insert history of user
	*/	
	function HistoryUser($where, $what, $todoid){
		$db			=& JFactory::getDBO();
		$user		= & JFactory::getUser();
		$datenow 	=& JFactory::getDate();
		$datetime 	= $datenow->toMySQL();
		$query = "	INSERT INTO apdm_user_history (history_date, history_where, history_what, history_todo_id, user_id) VALUES (
					'".$datetime."', ".$where.", '".$what."', ".$todoid.", ".$user->get('id').")";
		$db->setQuery($query);
		$db->query();
		return true;
	}
	/*
		* get role of user on component
	*/
	function RoleOnComponent($component_id){
		$db 		= & JFactory::getDBO();
		$user		= & JFactory::getUser();
		$user_id = $user->get("id");
		$usertype	= $user->get('usertype');
		$db->setQuery("SELECT role_id FROM  apdm_role_user WHERE user_id=".$user->get("id"));
		$role_result = $db->loadObjectList();
		$arr_role = array();
		$arr_value = array();
		if ($usertype =='Administrator' || $usertype=="Super Administrator") {
			$arr_value = array("V", "W", "E", "D", "R","S");
		}else{
			if (count($role_result) > 0){
				foreach ($role_result as $obj){
					$arr_role[] = $obj->role_id;
				}
			}
			if (count($arr_role) > 0){			
				$db->setQuery("SELECT  role_value from apdm_role_component where role_id IN (".implode(",", $arr_role).") AND component_id=".$component_id);
				$result = $db->loadObjectList();
				if (count($result) > 0){
					foreach ($result as $obj){
						$arr_value[] = $obj->role_value;
					}
				}
			}
		}
		
		return $arr_value;
	
	}
	function isAPDM($userid)
	{
		$db		=& JFactory::getDBO();
		$query = "SELECT user_id FROM apdm_users WHERE user_enable=0 AND user_id=".$userid;
		
		$db->setQuery($query);
		$result = $db->loadResult();
		if ($result){
			return true;
		}else{
			return false;
		}
		
	}
}
function GetValueUser($id, $value){
	$db		=& JFactory::getDBO();
	$query = "SELECT {$value} FROM #__users WHERE id=".$id;
	$db->setQuery($query);
	$result = $db->loadResult();
	return $result;
}
function GetListPnsParent($pns){
        $db = & JFactory::getDBO();      
        $query = "SELECT pr.pns_id FROM apdm_pns_parents as pr LEFT JOIN apdm_pns as p ON p.pns_id=pr.pns_id  WHERE p.pns_deleted=0 AND pns_parent = ".$pns;    
        $result = '';
        $db->setQuery($query);
        $rs = $db->loadObjectList();
        if (count($rs) > 0){
            foreach ($rs as $obj){
                $result .= $obj->pns_id.', ';         
                $result .= GetListPnsParent($obj->pns_id);     
            }            
        
        }        
        return $result;    
       
      
    }
function GetNameCCs($ccs_id){
        $db = & JFactory::getDBO();
        $db->setQuery("SELECT ccs_code FROM apdm_ccs WHERE ccs_id=".$ccs_id);
        return $db->loadResult();
    }
 function GetECO($eco_id){
        $db = & JFactory::getDBO();
        $db->setQuery("SELECT eco_name FROM apdm_eco WHERE eco_id=".$eco_id);
        return $db->loadResult();
    }
  function GetEcoValue($eco_id){
        $db = & JFactory::getDBO();
        $db->setQuery('SELECT eco_name FROM apdm_eco WHERE eco_id ='.$eco_id);
        return $db->loadResult();
    }
        function GetToolPnValue($pns_id)
        {
                $db = & JFactory::getDBO();
                $db->setQuery("select tto_code from apdm_pns_tto tto inner join apdm_pns_tto_fk fk on tto.pns_tto_id = fk.tto_id and tto_state = 'Using' where fk.pns_id = '".$pns_id."'");
                return $db->loadResult();
        }
  function CalculateToolRemainValue($pns_id)
        {
                $db = & JFactory::getDBO();
                $db->setQuery("select pns_stock from apdm_pns where pns_id='".$pns_id."'");
                $db->query();  
                $rows = $db->loadObjectList();
                $CurrentStock = $rows[0]->pns_stock;
                //get Stock IN
                $db->setQuery("select  sum(qty) from apdm_pns_sto_fk fk inner join apdm_pns pn on fk.pns_id = pn.pns_id  inner join apdm_pns_sto sto on sto.pns_sto_id = fk.sto_id and sto_type = 1 where fk.pns_id='".$pns_id."'");
                $db->query();
                $StockIn = $db->loadResult();
                //$StockIn = $rows->qty_in;
                //get Stock OUT
                $db->setQuery("select  sum(qty)  from apdm_pns_sto_fk fk inner join apdm_pns pn on fk.pns_id = pn.pns_id  inner join apdm_pns_sto sto on sto.pns_sto_id = fk.sto_id and sto_type = 2 where fk.pns_id='".$pns_id."'");
                $db->query();
                 $StockOut = $db->loadResult();
                //$StockOut = $rows->qty_out;
                $inventory =  round($CurrentStock + ($StockIn-$StockOut),2);
                if($inventory<0)
                     $inventory = 0;
                //get Tool out
                $db->setQuery("SELECT sum(fk.qty) FROM apdm_pns_tto AS tto  inner JOIN apdm_pns_tto_fk fk on tto.pns_tto_id = fk.tto_id where fk.pns_id=".$pns_id." and fk.tto_type_inout = 2 and tto.tto_state = 'Using' and tto.tto_owner_out_confirm != 0  order by fk.pns_id desc");                
                $ToolOut = $db->loadResult();    
                if($ToolOut)
                {
                     $inventory   = $inventory - $ToolOut;
                }
               /* $db->setQuery("SELECT sum(fk.qty) FROM apdm_pns_tto AS tto  inner JOIN apdm_pns_tto_fk fk on tto.pns_tto_id = fk.tto_id where fk.pns_id=".$pns_id." and fk.tto_type_inout = 2 and tto.tto_state = 'Done' and tto.tto_owner_out_confirm != 0  order by fk.pns_id desc");
                $ToolIn = $db->loadResult();   
                if($ToolIn)
                {
                     $inventory   = $inventory + $ToolIn;
                }*/
                if($inventory<0)
                     $inventory = 0;
                return $inventory;                                                                
        }   
        function CalculateInventoryValue($pns_id)
        {
                $db = & JFactory::getDBO();
                $db->setQuery("select pns_stock from apdm_pns where pns_id='".$pns_id."'");
                $db->query();  
                $rows = $db->loadObjectList();
                $CurrentStock = $rows[0]->pns_stock;
                //get Stock IN
                $db->setQuery("select  sum(qty) from apdm_pns_sto_fk fk inner join apdm_pns pn on fk.pns_id = pn.pns_id  inner join apdm_pns_sto sto on sto.pns_sto_id = fk.sto_id and sto_type = 1 where fk.pns_id='".$pns_id."'");
                $db->query();
               $StockIn = $db->loadResult();
                //$StockIn = $rows->qty_in;
                //get Stock OUT
                $db->setQuery("select  sum(qty)  from apdm_pns_sto_fk fk inner join apdm_pns pn on fk.pns_id = pn.pns_id  inner join apdm_pns_sto sto on sto.pns_sto_id = fk.sto_id and sto_type = 2 where fk.pns_id='".$pns_id."'");
                $db->query();
                 $StockOut = $db->loadResult();
                //$StockOut = $rows->qty_out;
                $inventory =  round($CurrentStock + ($StockIn-$StockOut),2);
                if($inventory<0)
                     $inventory = 0;
                return $inventory;                                
                exit;                
        }
        function CalculateInventoryLocationPartValue($pns_id,$location,$partState)
        {
            $db = & JFactory::getDBO();
            //get Stock IN
            $db->setQuery("select  sum(qty) from apdm_pns_sto_fk fk inner join apdm_pns pn on fk.pns_id = pn.pns_id  inner join apdm_pns_sto sto on sto.pns_sto_id = fk.sto_id and sto_type = 1 where fk.location='".$location."' and fk.partstate ='".$partState."'");
            $db->query();
            $StockIn = $db->loadResult();
            //$StockIn = $rows->qty_in;
            //get Stock OUT
            $db->setQuery("select  sum(qty)  from apdm_pns_sto_fk fk inner join apdm_pns pn on fk.pns_id = pn.pns_id  inner join apdm_pns_sto sto on sto.pns_sto_id = fk.sto_id and sto_type = 2 where fk.pns_id = '".$pns_id."' and fk.location='".$location."' and fk.partstate ='".$partState."'");
            $db->query();
            $StockOut = $db->loadResult();
            //$StockOut = $rows->qty_out;
            $inventory =  round(($StockIn-$StockOut),2);
            if($inventory<0)
                $inventory = 0;
            return $inventory;
            exit;
        }
        function CalculateInventoryLocationPartValueForTool($pns_id,$location,$partState)
        {
            $db = & JFactory::getDBO();
            $db->setQuery("select pns_stock from apdm_pns where pns_id='".$pns_id."'");
            $db->query();
            $rows = $db->loadObjectList();
            $CurrentStock = $rows[0]->pns_stock;
            //get Stock IN
            $db->setQuery("select  sum(qty) from apdm_pns_sto_fk fk inner join apdm_pns pn on fk.pns_id = pn.pns_id  inner join apdm_pns_sto sto on sto.pns_sto_id = fk.sto_id and sto_type = 1 where fk.pns_id = '".$pns_id."' and fk.location='".$location."' and fk.partstate ='".$partState."'");
            $db->query();
            $StockIn = $db->loadResult();
            //$StockIn = $rows->qty_in;
            //get Stock OUT
            $db->setQuery("select  sum(qty)  from apdm_pns_sto_fk fk inner join apdm_pns pn on fk.pns_id = pn.pns_id  inner join apdm_pns_sto sto on sto.pns_sto_id = fk.sto_id and sto_type = 2 where fk.pns_id = '".$pns_id."' and fk.location='".$location."' and fk.partstate ='".$partState."'");
            $db->query();
            $StockOut = $db->loadResult();          
            //$StockOut = $rows->qty_out;
                $inventory =  round($CurrentStock + ($StockIn-$StockOut),2);
                if($inventory<0)
                     $inventory = 0;
                //get Tool out
                $db->setQuery("SELECT sum(fk.qty) FROM apdm_pns_tto AS tto  inner JOIN apdm_pns_tto_fk fk on tto.pns_tto_id = fk.tto_id where fk.pns_id=".$pns_id." and fk.tto_type_inout = 2 and tto.tto_state = 'Using' and tto.tto_owner_out_confirm != 0 and fk.location='".$location."' and fk.partstate ='".$partState."' order by fk.pns_id desc");
                $ToolOut = $db->loadResult();
                if($ToolOut)
                {
                     $inventory   = $inventory - $ToolOut;
                }
               /* $db->setQuery("SELECT sum(fk.qty) FROM apdm_pns_tto AS tto  inner JOIN apdm_pns_tto_fk fk on tto.pns_tto_id = fk.tto_id where fk.pns_id=".$pns_id." and fk.tto_type_inout = 2 and tto.tto_state = 'Done' and tto.tto_owner_out_confirm != 0  order by fk.pns_id desc");
                $ToolIn = $db->loadResult();   
                if($ToolIn)
                {
                     $inventory   = $inventory + $ToolIn;
                }*/
                if($inventory<0)
                     $inventory = 0;
                return $inventory;          
        }   
        function getPnsIdfromPnCode($pn_code)
        {            
                $db =& JFactory::getDBO();
                $db->setQuery("select pns_id FROM apdm_pns where  CONCAT_WS( '-', ccs_code, pns_code, pns_revision) = '". trim($pn_code) ."' and pns_revision !='' ");
                $pns_id = $db->loadResult();
                if ($pns_id) {
                    return $pns_id;
                }
                //in case without revision
                $db->setQuery("select pns_id FROM apdm_pns where  CONCAT_WS( '-', ccs_code, pns_code) = '". trim($pn_code) ."' and pns_revision = ''");
                $pns_id = $db->loadResult();
                if ($pns_id) {
                    return $pns_id;
                }
                return 0;
                $arrPn = explode("-", $pn_code);
        //A02-200263-0A
                $ccs_code = $arrPn[0];
                $pns_code = $arrPn[1];
                $pns_revision = $arrPn[2];
        //K01-0262499-000

                if($arrPn[4])
                {
                    $pns_code = $arrPn[1]."-".$arrPn[2]."-".$arrPn[3];
                    $pns_revision = $arrPn[4];
                }
                elseif($arrPn[3] &&!$arrPn[4])
                {
                    $pns_code = $arrPn[1]."-".$arrPn[2];
                    $pns_revision = $arrPn[3];

                }
                if($arrPn[3] || $arrPn[4])
                {
                       // $pns_revision = $arrPn[3];
                        $query = "select pns_id from apdm_pns where ccs_code = '".$ccs_code."' and pns_code = '".$pns_code."' and pns_revision = '".$pns_revision."'";

                }
                else {
                        if(preg_match("/^[0-9]+$/i", $arrPn[2]))
                        {
                            $pns_code = $arrPn[1]."-".$arrPn[2];
                            $query = "select pns_id from apdm_pns where ccs_code = '".$ccs_code."' and pns_code = '".$pns_code."'";
                        }
                        else
                        {
                            $pns_code = $arrPn[1];
                            $pns_revision = $arrPn[2];
                            $query = "select pns_id from apdm_pns where ccs_code = '".$ccs_code."' and pns_code = '".$pns_code."' and pns_revision = '".$pns_revision."'";
                        }
                }
                $db->setQuery($query);
               return $pns_id = $db->loadResult();    
        }
        function GetManufacture($pns_id,$type=4) {
            $db = & JFactory::getDBO();
            $rows = array();
            $query = "SELECT p.supplier_id, p.supplier_info, s.info_name FROM apdm_pns_supplier AS p LEFT JOIN apdm_supplier_info AS s ON s.info_id = p.supplier_id WHERE  s.info_deleted=0 AND  s.info_activate=1 AND p.type_id = ".$type." AND  p.pns_id =" . $pns_id;

            $db->setQuery($query);
            $result = $db->loadObjectList();
            if (count($result) > 0) {
                foreach ($result as $obj) {
                    $rows[] = array('mf' => $obj->info_name, 'v_mf' => $obj->supplier_info);
                }
            }
            return $rows;
        }
function CalculateInventoryValueforView($pns_id)
{
    $db = & JFactory::getDBO();
    $db->setQuery("select pns_stock from apdm_pns where pns_id='".$pns_id."'");
    $db->query();
    $rows = $db->loadObjectList();
    $CurrentStock = $rows[0]->pns_stock;
    //get Stock IN
    $db->setQuery("select  sum(qty) from apdm_pns_sto_fk fk inner join apdm_pns pn on fk.pns_id = pn.pns_id  inner join apdm_pns_sto sto on sto.pns_sto_id = fk.sto_id and sto_type = 1 and sto.sto_owner_confirm = 1 where fk.pns_id='".$pns_id."'");
    $db->query();
    $StockIn = $db->loadResult();
    //$StockIn = $rows->qty_in;
    //get Stock OUT
    $db->setQuery("select  sum(qty)  from apdm_pns_sto_fk fk inner join apdm_pns pn on fk.pns_id = pn.pns_id  inner join apdm_pns_sto sto on sto.pns_sto_id = fk.sto_id and sto_type = 2 and sto.sto_owner_confirm = 1 where fk.pns_id='".$pns_id."'");
    $db->query();
    $StockOut = $db->loadResult();
    //$StockOut = $rows->qty_out;
    $inventory =  round($CurrentStock + ($StockIn-$StockOut),2);
    if($inventory<0)
        $inventory = 0;
    return $inventory;
    exit;
}
function getdir($path=".") {
  
global $dirarray,$conf,$dirsize;    

if ($dir = opendir($path)) {
  while (false !== ($entry = @readdir($dir))) {
     if (($entry!=".")&&($entry!="..")) {
          $lastdot = strrpos($entry,".");
        $ext = chop(strtolower(substr($entry,$lastdot+1)));
        $fname = substr($entry,0,$lastdot);
        if ($path!=".") $newpath = $path."/".$entry;
        else $newpath = $entry;
        $newpath = str_replace("//","/",$newpath);

        if (($entry!="NDKziper.php")&&($entry!="ndkziper.txt")&&($entry!=$conf['dir'])) {
            $dirarray[] = $newpath;
            if ($fsize=@filesize($newpath)) $dirsize+=$fsize;
            if (is_dir($newpath)) getdir($newpath);
        } 
       
       }
  }
}
}// end func

function limit_text($string, $word_count=100)
    {
      $trimmed = "";
       $string = strip_tags($string);
      $string = preg_replace("/\040+/"," ", trim($string));
      $stringc = explode(" ",$string);
      if($word_count >= sizeof($stringc))
      {
       // nothing to do, our string is smaller than the limit.
        return $string;
      }
      elseif($word_count < sizeof($stringc))
      {
       // trim the string to the word count
       for($i=0;$i<$word_count;$i++)
       {
        $trimmed .= $stringc[$i]." ";
       }
       
       if(substr($trimmed, strlen(trim($trimmed))-1, 1) == '.')
         return trim($trimmed).'...';
       else
         return trim($trimmed).'...';
      }
    }

function Readfilesize($folder, $filename, $ccs=null, $pns=null){
      $path_pns = JPATH_SITE.DS.'uploads'.DS.'pns'.DS;   
      $filesize = '';
      switch ($folder){
          case "cads":
                $path_pns .= $folder.DS.$ccs.DS.$pns.DS;    
          break;                
          default: //images; pdf
            $path_pns .= $folder.DS;       
          break;
      }
		if ( file_exists($path_pns.$filename) ) {
            $filesize =  ceil( filesize($path_pns.$filename) / 1000 );
		}else{
			$filesize = 0;
		}
      return $filesize;
   }
function ReadfilesizeECO($filename){
      $path = JPATH_SITE.DS.'uploads'.DS.'eco'.DS;   
      $filesize =  ceil ( filesize($path.$filename) / 1000 ) ;
      return $filesize;
   }
