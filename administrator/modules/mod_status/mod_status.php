<?php
/**
* @version		$Id: mod_status.php 10381 2008-06-01 03:35:53Z pasamio $
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

global $task;

// Initialize some variables
$config		=& JFactory::getConfig();
$user		=& JFactory::getUser();
$db			=& JFactory::getDBO();
$lang		=& JFactory::getLanguage();
$session	=& JFactory::getSession();

$sid	= $session->getId();
$output = array();

// Legacy Mode
if (defined('_JLEGACY')) {
	$output[] = '<span class="legacy-mode">'.JText::_('Legacy').': '._JLEGACY.'</span>';
}

// Print the preview button
//$output[] = "<span class=\"preview\"><a href=\"".JURI::root()."\" target=\"_blank\">".JText::_('Preview')."</a></span>";

// Get the number of unread messages in your inbox
$query = 'SELECT COUNT(*)'
. ' FROM #__messages'
. ' WHERE state = 0'
. ' AND user_id_to = '.(int) $user->get('id');
$db->setQuery( $query );
$unread = $db->loadResult();

if (JRequest::getInt('hidemainmenu')) {
	$inboxLink = '<a>';
} else {
	$inboxLink = '<a href="index.php?option=com_messages">';
}

// Print the inbox message
/*if ($unread) {
	$output[] = $inboxLink.'<span class="unread-messages">'.$unread.'</span></a>';
} else {
	$output[] = $inboxLink.'<span class="no-unread-messages">'.$unread.'</span></a>';
}*/

// Get the number of logged in users
$query = 'SELECT COUNT( session_id )'
. ' FROM #__session'
. ' WHERE guest <> 1'
;
$db->setQuery($query);
$online_num = intval( $db->loadResult() );
//print search box
//
//$search_type = <select name="type_filter" id="type_filter" class="inputbox" size="1"><option value="0" selected="selected"> Select Type To Filter</option><option value="5">Part Number</option><option value="1"> ECO</option><option value="7">PO</option><option value="3"> Supplier</option><option value="4"> Manufacture</option><option value="6">PNs Description</option></select>
//
    //for list filter type
global $mainframe, $option;
$type_filter   = $mainframe->getUserStateFromRequest("$option.type_filter", 'type_filter', 0, 'int');
        $type[] = JHTML::_('select.option', 0, JText::_('Search all'), 'value', 'text');
        $type[] = JHTML::_('select.option', 5, JText::_('PN'), 'value', 'text');
        $type[] = JHTML::_('select.option', 6, JText::_('Description'), 'value', 'text');
        $type[] = JHTML::_('select.option', 1, JText::_('ECO'), 'value', 'text');
        $type[] = JHTML::_('select.option', 7, JText::_('PO'), 'value', 'text');
        $type[] = JHTML::_('select.option', 11, JText::_('STO'), 'value', 'text');
        $type[] = JHTML::_('select.option', 4, JText::_('Manufacture'), 'value', 'text');        
        $type[] = JHTML::_('select.option', 8, JText::_('Manufacture PN'), 'value', 'text');        
        $type[] = JHTML::_('select.option', 3, JText::_('Supplier'), 'value', 'text');
        $type[] = JHTML::_('select.option', 10, JText::_('Supplier PN'), 'value', 'text');
        $type[] = JHTML::_('select.option', 2, JText::_('Vendor'), 'value', 'text');
        $type[] = JHTML::_('select.option', 9, JText::_('Vendor PN'), 'value', 'text');          
        $type_filter = JHTML::_('select.genericlist', $type, 'type_filter', 'class="inputbox" size="1"', 'value', 'text', $type_filter);
?>
<script language="javascript">
function submitbutton1(pressbutton) {
        
			var form = document.adminForm1;		
                       
			if (pressbutton == 'submit') {
				var d = document.adminForm1;                             
				if (d.text_search.value==""){
					alert("Please input keyword");	
					d.text_search.focus();
					return;				
				}else{
					submitform( pressbutton );
				}
			}
			
		}

</script>
<?php
       
       $searchStr = $mainframe->getUserStateFromRequest( "$option.text_search", 'text_search', '','string' );
     
        $searchStr                = JString::strtolower( $searchStr );
$search = "<span class=\"search\"><form action=\"index.php?option=com_apdmpns&task=searchall\" method=\"post\" name=\"adminForm1\" onsubmit=\"submitbutton1('submit')\" >".
$search .=         "Search what<input type='text' name='text_search' id='text_search' value='". $searchStr."' class='text_area'  size='25' />&nbsp;&nbsp;Filter With";
$search .=         $type_filter;				
$search .=         "<input type='submit' name='btinsersave' value='Go' />";
$search .=         "<button onclick='document.adminForm.text_search.value='';document.adminForm.type_filter.value=0;document.adminForm.filter_status.value='';document.adminForm.filter_type.value='';document.adminForm.filter_created_by.value=0;document.adminForm.filter_modified_by.value=0;document.adminForm.submit();'>Reset</button>";
$search .=         "</form></span>";
$output[] = "";
//Print the logged in users message
$output[] = "<span class=\"loggedin-users\">".$online_num."</span>";

if ($task == 'edit' || $task == 'editA' || JRequest::getInt('hidemainmenu') ) {
	 // Print the logout message
	 $output[] = "<span class=\"logout\">".JText::_('Logout')."</span>";
} else {
	// Print the logout message
	$output[] = "<span class=\"logout\"><a href=\"index.php?option=com_login&amp;task=logout\">".JText::_('Logout')."</a></span>";
}
$output[] = $search;
// reverse rendering order for rtl display
if ( $lang->isRTL() ) {
	$output = array_reverse( $output );
}

// output the module
foreach ($output as $item){
	echo $item;
}