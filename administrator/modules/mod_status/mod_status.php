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
        $type[] = JHTML::_('select.option', 11, JText::_('Inventory'), 'value', 'text');
        $type[] = JHTML::_('select.option', 12, JText::_('SO'), 'value', 'text');
        $type[] = JHTML::_('select.option', 13, JText::_('WO'), 'value', 'text');
        $type[] = JHTML::_('select.option', 14, JText::_('Special Tool'), 'value', 'text');
        $type[] = JHTML::_('select.option', 4, JText::_('Manufacture'), 'value', 'text');        
        $type[] = JHTML::_('select.option', 8, JText::_('Manufacture PN'), 'value', 'text');        
        $type[] = JHTML::_('select.option', 3, JText::_('Supplier'), 'value', 'text');
        $type[] = JHTML::_('select.option', 10, JText::_('Supplier PN'), 'value', 'text');
        $type[] = JHTML::_('select.option', 2, JText::_('Vendor'), 'value', 'text');
        $type[] = JHTML::_('select.option', 9, JText::_('Vendor PN'), 'value', 'text');          
        

       $searchStr = $mainframe->getUserStateFromRequest( "$option.text_search", 'text_search', '','string' );
     
        $searchStr                = JString::strtolower( $searchStr );        
        $clean = JRequest::getVar('clean');
        if($clean=="all")
        {
                $searchStr = $type_filter =  "";  
        }
        $type_filter = JHTML::_('select.genericlist', $type, 'type_filter', 'class="inputbox" size="1"', 'value', 'text', $type_filter);
?>
<script language="javascript">
function submitbutton1(pressbutton) {
			var form = document.adminForm1;		
                       
			if (pressbutton == 'submit') {
				var d = document.adminForm1;                             
				if (d.text_search.value==""){
				//	alert("Please input keyword");
					d.text_search.focus();
					return;				
				}else{
					submitform( pressbutton );
				}
			}
			
		}

function autoSearchWoView(a){
  //  var form = document.adminForm1;
   // setTimeout(function(){
       // submitform('getWoScan');
        window.location = "index.php?option=com_apdmpns&task=getBarcodeScan&wo_code="+a+"&timem=<?php echo time();?>";
  //  }, 1);
}
</script>
<?php
       

        
$search = "<span class=\"search\"><form action=\"index.php?option=com_apdmpns&task=searchall\" method=\"post\" name=\"adminForm1\" onsubmit=\"submitbutton1('submit')\" >".
$search .=         "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Search &nbsp;&nbsp;<input type='text' name='text_search' id='text_search' value='". $searchStr."' class='text_area'  size='20' />&nbsp;&nbsp;Filter &nbsp;&nbsp;";
$search .=         $type_filter;				
$search .=         "&nbsp;&nbsp;<input type='submit' name='btinsersave' value='Go' />";
$search .=         "&nbsp;&nbsp;<a href='index.php?option=com_apdmpns&task=searchall&clean=all'><input type='button' value='Reset'></a>";
$search .=         "&nbsp;&nbsp;<br>Scan Barcode <input type=\"text\" size =\"20\" name='wo_code' value=\"\" onkeyup=\"autoSearchWoView(this.value)\"/><input type=\"hidden\" name=\"option\" value=\"com_apdmpns\"><input type=\"hidden\" name = \"task\" value = \"searchall\" >";
$search .=         "</form></span>";

$output[] = "";
$gettask= JRequest::getVar('task');
$array_task = array("so_detail","somanagement","so_detail_wo","so_detail_support_doc","so_detail_wo_history","wo_detail");
if(in_array($gettask,$array_task))
{
    $output[] = "<a href='index.php?option=com_apdmpns&task=searchadvance&clean=all'><input type='button' style='margin-bottom:1px;line-height:17px;padding:1px 11px 0 18px;' name='searchadvance' value='Advance Search' /></a>";
    //$output[] = "<form  onsubmit=\"submitbutton1('getWoScan')\" action=\"index.php?option=com_apdmpns&task=getWoScan\" method=\"post\" name=\"adminFormView\">Scan WO Barcode: <input type=\"text\" size =\"15\" name='wo_code' value=\"\" onkeyup=\"autoSearchWoView(this)\"/><input type=\"hidden\" name=\"option\" value=\"com_apdmpns\"><input type=\"hidden\" name = \"task\" value = \"somanagement\" ></form>";
//    $output[] = "<input type=\"hidden\" name=\"option\" value=\"com_apdmpns\">";
  //  $output[] = "<input type="\hidden\" name=\"task\" value=\"somanagement\"></form>";
}
//Print the logged in users message
$output[] = "<span class=\"loggedin-users\"><a href=\"index.php?option=com_apdmusers&amp;view=apdmuser&amp;task=profile&amp;cid[]=".$user->get('id')."\">".$user->get('name')."</a></span>";

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