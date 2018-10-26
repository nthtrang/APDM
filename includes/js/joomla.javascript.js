// <?php !! This fools phpdocumentor into parsing this file
/**
* @version		$Id: joomla.javascript.js 10389 2008-06-03 11:27:38Z pasamio $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL
* Joomla! is Free Software
*/

/**
 * Overlib Styling Declarations to allow CSS class override of styles
 *
 */
var ol_fgclass='ol-foreground';
var ol_bgclass='ol-background';
var ol_textfontclass='ol-textfont';
var ol_captionfontclass='ol-captionfont';
var ol_closefontclass='ol-closefont';

// general utility for browsing a named array or object
function xshow(o) {
	s = '';
	for(e in o) {s += e+'='+o[e]+'\n';}
	alert( s );
}

/**
* Writes a dynamically generated list
* @param string The parameters to insert into the <select> tag
* @param array A javascript array of list options in the form [key,value,text]
* @param string The key to display for the initial state of the list
* @param string The original key that was selected
* @param string The original item value that was selected
*/
function writeDynaList( selectParams, source, key, orig_key, orig_val ) {
	var html = '\n	<select ' + selectParams + '>';
	var i = 0;
	for (x in source) {
		if (source[x][0] == key) {
			var selected = '';
			if ((orig_key == key && orig_val == source[x][1]) || (i == 0 && orig_key != key)) {
				selected = 'selected="selected"';
			}
			html += '\n		<option value="'+source[x][1]+'" '+selected+'>'+source[x][2]+'</option>';
		}
		i++;
	}
	html += '\n	</select>';

	document.writeln( html );
}

/**
* Changes a dynamically generated list
* @param string The name of the list to change
* @param array A javascript array of list options in the form [key,value,text]
* @param string The key to display
* @param string The original key that was selected
* @param string The original item value that was selected
*/
function changeDynaList( listname, source, key, orig_key, orig_val ) {
	var list = eval( 'document.adminForm.' + listname );

	// empty the list
	for (i in list.options.length) {
		list.options[i] = null;
	}
	i = 0;
	for (x in source) {
		if (source[x][0] == key) {
			opt = new Option();
			opt.value = source[x][1];
			opt.text = source[x][2];

			if ((orig_key == key && orig_val == opt.value) || i == 0) {
				opt.selected = true;
			}
			list.options[i++] = opt;
		}
	}
	list.length = i;
}

/**
* Adds a select item(s) from one list to another
*/
function addSelectedToList( frmName, srcListName, tgtListName ) {
	var form = eval( 'document.' + frmName );
	var srcList = eval( 'form.' + srcListName );
	var tgtList = eval( 'form.' + tgtListName );

	var srcLen = srcList.length;
	var tgtLen = tgtList.length;
	var tgt = "x";

	//build array of target items
	for (var i=tgtLen-1; i > -1; i--) {
		tgt += "," + tgtList.options[i].value + ","
	}

	//Pull selected resources and add them to list
	//for (var i=srcLen-1; i > -1; i--) {
	for (var i=0; i < srcLen; i++) {
		if (srcList.options[i].selected && tgt.indexOf( "," + srcList.options[i].value + "," ) == -1) {
			opt = new Option( srcList.options[i].text, srcList.options[i].value );
			tgtList.options[tgtList.length] = opt;
		}
	}
}

function delSelectedFromList( frmName, srcListName ) {
	var form = eval( 'document.' + frmName );
	var srcList = eval( 'form.' + srcListName );

	var srcLen = srcList.length;

	for (var i=srcLen-1; i > -1; i--) {
		if (srcList.options[i].selected) {
			srcList.options[i] = null;
		}
	}
}

function moveInList( frmName, srcListName, index, to) {
	var form = eval( 'document.' + frmName );
	var srcList = eval( 'form.' + srcListName );
	var total = srcList.options.length-1;

	if (index == -1) {
		return false;
	}
	if (to == +1 && index == total) {
		return false;
	}
	if (to == -1 && index == 0) {
		return false;
	}

	var items = new Array;
	var values = new Array;

	for (i=total; i >= 0; i--) {
		items[i] = srcList.options[i].text;
		values[i] = srcList.options[i].value;
	}
	for (i = total; i >= 0; i--) {
		if (index == i) {
			srcList.options[i + to] = new Option(items[i],values[i], 0, 1);
			srcList.options[i] = new Option(items[i+to], values[i+to]);
			i--;
		} else {
			srcList.options[i] = new Option(items[i], values[i]);
	   }
	}
	srcList.focus();
	return true;
}

function getSelectedOption( frmName, srcListName ) {
	var form = eval( 'document.' + frmName );
	var srcList = eval( 'form.' + srcListName );

	i = srcList.selectedIndex;
	if (i != null && i > -1) {
		return srcList.options[i];
	} else {
		return null;
	}
}

function setSelectedValue( frmName, srcListName, value ) {
	var form = eval( 'document.' + frmName );
	var srcList = eval( 'form.' + srcListName );

	var srcLen = srcList.length;

	for (var i=0; i < srcLen; i++) {
		srcList.options[i].selected = false;
		if (srcList.options[i].value == value) {
			srcList.options[i].selected = true;
		}
	}
}

function getSelectedRadio( frmName, srcGroupName ) {
	var form = eval( 'document.' + frmName );
	var srcGroup = eval( 'form.' + srcGroupName );

	return radioGetCheckedValue( srcGroup );
}

// return the value of the radio button that is checked
// return an empty string if none are checked, or
// there are no radio buttons
function radioGetCheckedValue(radioObj) {
	if (!radioObj) {
		return '';
	}
	var n = radioObj.length;
	if (n == undefined) {
		if (radioObj.checked) {
			return radioObj.value;
		} else {
			return '';
		}
	}
	for (var i = 0; i < n; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return '';
}

function getSelectedValue( frmName, srcListName ) {
	var form = eval( 'document.' + frmName );
	var srcList = eval( 'form.' + srcListName );

	i = srcList.selectedIndex;
	if (i != null && i > -1) {
		return srcList.options[i].value;
	} else {
		return null;
	}
}

function getSelectedText( frmName, srcListName ) {
	var form = eval( 'document.' + frmName );
	var srcList = eval( 'form.' + srcListName );

	i = srcList.selectedIndex;
	if (i != null && i > -1) {
		return srcList.options[i].text;
	} else {
		return null;
	}
}

function chgSelectedValue( frmName, srcListName, value ) {
	var form = eval( 'document.' + frmName );
	var srcList = eval( 'form.' + srcListName );

	i = srcList.selectedIndex;
	if (i != null && i > -1) {
		srcList.options[i].value = value;
		return true;
	} else {
		return false;
	}
}

/**
* Toggles the check state of a group of boxes
*
* Checkboxes must have an id attribute in the form cb0, cb1...
* @param The number of box to 'check'
* @param An alternative field name
*/
function checkAll( n, fldName ) {

  if (!fldName) {
     fldName = 'cb';
  }
	var f = document.adminForm;
	var c = f.toggle.checked;
	var n2 = 0;
	for (i=0; i < n; i++) {
		cb = eval( 'f.' + fldName + '' + i );
		if (cb) {
			cb.checked = c;
			n2++;
		}
	}
	if (c) {
		document.adminForm.boxchecked.value = n2;
	} else {
		document.adminForm.boxchecked.value = 0;
	}
}
        function checkboxBom (field) {
                for (i = 0; i < field.length; i++) {
                        if(field[i].checked == true) {
                                uncheckedAll(field);
                        }
                        else {
                                checkedAll(field);
                        }
                }
        }
        function checkedAll(field)
        {
                for (i = 0; i < field.length; i++)
                        field[i].checked = true ;
                
        }

        function uncheckedAll(field)
        {
                for (i = 0; i < field.length; i++)
                        field[i].checked = false ;
        }
// for commodyti code
function checkAllCC( n, fldName ) {
	var f = document.adminForm;
	var c = f.toggle1.checked;
	var n2 = 0;
	for (i=0; i < n; i++) {
		cb = eval( 'f.' + fldName + '' + i );
		if (cb) {
			cb.checked = c;
			n2++;
		}
	}
	if (c) {
		document.adminForm.boxcheckedcc.value = n2;
	} else {
		document.adminForm.boxcheckedcc.value = 0;
	}
}
//for vendor
function checkAllVendor( n, fldName ) {
	var f = document.adminForm;
	var c = f.toggle2.checked;
	var n2 = 0;
	for (i=0; i < n; i++) {
		cb = eval( 'f.' + fldName + '' + i );
		if (cb) {
			cb.checked = c;
			n2++;
		}
	}
	if (c) {
		document.adminForm.boxcheckedv.value = n2;
	} else {
		document.adminForm.boxcheckedv.value = 0;
	}
}
//for supplier
function checkAllSupplier( n, fldName ) {
	
	var f = document.adminForm;
	var c = f.toggle3.checked;
	var n2 = 0;
	for (i=0; i < n; i++) {
		cb = eval( 'f.' + fldName + '' + i );
		if (cb) {
			cb.checked = c;
			n2++;
		}
	}
	if (c) {
		document.adminForm.boxcheckeds.value = n2;
	} else {
		document.adminForm.boxcheckeds.value = 0;
	}
}
//for check all manufacture
function checkAllManufacture( n, fldName ) {
	var f = document.adminForm;
	var c = f.toggle4.checked;
	var n2 = 0;
	for (i=0; i < n; i++) {
		cb = eval( 'f.' + fldName + '' + i );
		if (cb) {
			cb.checked = c;
			n2++;
		}
	}
	if (c) {
		document.adminForm.boxcheckedm.value = n2;
	} else {
		document.adminForm.boxcheckedm.value = 0;
	}
}
///for eco
function checkAllECO( n, fldName ) {
	var f = document.adminForm;
	var c = f.toggle5.checked;
	var n2 = 0;
	for (i=0; i < n; i++) {
		cb = eval( 'f.' + fldName + '' + i );
		if (cb) {
			cb.checked = c;
			n2++;
		}
	}
	if (c) {
		document.adminForm.boxcheckedeco.value = n2;
	} else {
		document.adminForm.boxcheckedeco.value = 0;
	}
}
///for po
function checkAllPO( n, fldName ) {
	var f = document.adminForm;
	var c = f.toggle7.checked;
	var n2 = 0;
	for (i=0; i < n; i++) {
		cb = eval( 'f.' + fldName + '' + i );
		if (cb) {
			cb.checked = c;
			n2++;
		}
	}
	if (c) {
		document.adminForm.boxcheckedpo.value = n2;
	} else {
		document.adminForm.boxcheckedpo.value = 0;
	}
}
//for sto
function checkAllSTO( n, fldName ) {
	var f = document.adminForm;
	var c = f.toggle8.checked;
	var n2 = 0;
	for (i=0; i < n; i++) {
		cb = eval( 'f.' + fldName + '' + i );
		if (cb) {
			cb.checked = c;
			n2++;
		}
	}
	if (c) {
		document.adminForm.boxcheckedsto.value = n2;
	} else {
		document.adminForm.boxcheckedsto.value = 0;
	}
}
//for LOC
function checkAllLOC( n, fldName ) {
	var f = document.adminForm;
	var c = f.toggle8.checked;
	var n2 = 0;
	for (i=0; i < n; i++) {
		cb = eval( 'f.' + fldName + '' + i );
		if (cb) {
			cb.checked = c;
			n2++;
		}
	}
	if (c) {
		document.adminForm.boxcheckedloc.value = n2;
	} else {
		document.adminForm.boxcheckedloc.value = 0;
	}
}
//fo pns
function checkAllPNS( n, fldName ) {
	var f = document.adminForm;
	var c = f.toggle6.checked;
	var n2 = 0;
	for (i=0; i < n; i++) {
		cb = eval( 'f.' + fldName + '' + i );
		if (cb) {
			cb.checked = c;
			n2++;
		}
	}
	if (c) {
		document.adminForm.boxcheckedpns.value = n2;
	} else {
		document.adminForm.boxcheckedpns.value = 0;
	}
}
function listItemTask( id, task ) {
    var f = document.adminForm;
    cb = eval( 'f.' + id );
    if (cb) {
        for (i = 0; true; i++) {
            cbx = eval('f.cb'+i);
            if (!cbx) break;
            cbx.checked = false;
        } // for
        cb.checked = true;
        f.boxchecked.value = 1;
        submitbutton(task);
    }
    return false;
}

function hideMainMenu() {
	if (document.adminForm.hidemainmenu) {
		document.adminForm.hidemainmenu.value=1;
	}
}

function isChecked(isitchecked){
	if (isitchecked == true){
		document.adminForm.boxchecked.value++;
	}
	else {
		document.adminForm.boxchecked.value--;
	}
}


function isCheckedFile(isitchecked, i){
	
	
	var filesize = 'sizefile'+i;

	
	if (isitchecked == true){
		document.adminForm.total.value = parseInt(document.adminForm.total.value) + parseInt( $(filesize).value );
		//total = parseInt(total) + parseInt( $(filesize).value );
		document.adminForm.boxchecked.value++;
	}
	else {
//		total = parseInt( total)  - parseInt ($(filesize).value );
		document.adminForm.total.value = parseInt(document.adminForm.total.value) - parseInt( $(filesize).value );
		document.adminForm.boxchecked.value--;
	}
//	alert(document.adminForm.total.value);
}

function addOption(theSel, theText, theValue){
	  var newOpt = new Option(theText, theValue);
	  var selLength = theSel.length;
	  theSel.options[selLength] = newOpt;
  }
/**
* Default function.  Usually would be overriden by the component
*/
function submitbutton(pressbutton) {
	submitform(pressbutton);
}

/**
* Submit the admin form
*/
function submitform(pressbutton){
	if (pressbutton) {
		document.adminForm.task.value=pressbutton;
	}
	if (typeof document.adminForm.onsubmit == "function") {
		document.adminForm.onsubmit();
	}
	
	document.adminForm.submit();
}

/**
* Submit the control panel admin form
*/
function submitcpform(sectionid, id){
	document.adminForm.sectionid.value=sectionid;
	document.adminForm.id.value=id;
	submitbutton("edit");
}

/**
* Getting radio button that is selected.
*/
function getSelected(allbuttons){
	for (i=0;i<allbuttons.length;i++) {
		if (allbuttons[i].checked) {
			return allbuttons[i].value
		}
	}
	return null;
}

// JS Calendar
var calendar = null; // remember the calendar object so that we reuse
// it and avoid creating another

// This function gets called when an end-user clicks on some date
function selected(cal, date) {
	cal.sel.value = date; // just update the value of the input field
}

// And this gets called when the end-user clicks on the _selected_ date,
// or clicks the "Close" (X) button.  It just hides the calendar without
// destroying it.
function closeHandler(cal) {
	cal.hide();			// hide the calendar

	// don't check mousedown on document anymore (used to be able to hide the
	// calendar when someone clicks outside it, see the showCalendar function).
	Calendar.removeEvent(document, "mousedown", checkCalendar);
}

// This gets called when the user presses a mouse button anywhere in the
// document, if the calendar is shown.  If the click was outside the open
// calendar this function closes it.
function checkCalendar(ev) {
	var el = Calendar.is_ie ? Calendar.getElement(ev) : Calendar.getTargetElement(ev);
	for (; el != null; el = el.parentNode)
	// FIXME: allow end-user to click some link without closing the
	// calendar.  Good to see real-time stylesheet change :)
	if (el == calendar.element || el.tagName == "A") break;
	if (el == null) {
		// calls closeHandler which should hide the calendar.
		calendar.callCloseHandler();Calendar.stopEvent(ev);
	}
}

// This function shows the calendar under the element having the given id.
// It takes care of catching "mousedown" signals on document and hiding the
// calendar if the click was outside.
function showCalendar(id, dateFormat) {
	var el = document.getElementById(id);
	if (calendar != null) {
		// we already have one created, so just update it.
		calendar.hide();		// hide the existing calendar
		calendar.parseDate(el.value); // set it to a new date
	} else {
		// first-time call, create the calendar
		var cal = new Calendar(true, null, selected, closeHandler);
		calendar = cal;		// remember the calendar in the global
		cal.setRange(1900, 2070);	// min/max year allowed

		if ( dateFormat )	// optional date format
		{
			cal.setDateFormat(dateFormat);
		}

		calendar.create();		// create a popup calendar
		calendar.parseDate(el.value); // set it to a new date
	}
	calendar.sel = el;		// inform it about the input field in use
	calendar.showAtElement(el);	// show the calendar next to the input field

	// catch mousedown on the document
	Calendar.addEvent(document, "mousedown", checkCalendar);
	return false;
}

/**
* Pops up a new window in the middle of the screen
*/
function popupWindow(mypage, myname, w, h, scroll) {
	var winl = (screen.width - w) / 2;
	var wint = (screen.height - h) / 2;
	winprops = 'height='+h+',width='+w+',top='+wint+',left='+winl+',scrollbars='+scroll+',resizable'
	win = window.open(mypage, myname, winprops)
	if (parseInt(navigator.appVersion) >= 4) {win.window.focus();}
}

// LTrim(string) : Returns a copy of a string without leading spaces.
function ltrim(str)
{
   var whitespace = new String(" \t\n\r");
   var s = new String(str);
   if (whitespace.indexOf(s.charAt(0)) != -1) {
      var j=0, i = s.length;
      while (j < i && whitespace.indexOf(s.charAt(j)) != -1)
         j++;
      s = s.substring(j, i);
   }
   return s;
}

//RTrim(string) : Returns a copy of a string without trailing spaces.
function rtrim(str)
{
   var whitespace = new String(" \t\n\r");
   var s = new String(str);
   if (whitespace.indexOf(s.charAt(s.length-1)) != -1) {
      var i = s.length - 1;       // Get length of string
      while (i >= 0 && whitespace.indexOf(s.charAt(i)) != -1)
         i--;
      s = s.substring(0, i+1);
   }
   return s;
}

// Trim(string) : Returns a copy of a string without leading or trailing spaces
function trim(str) {
   return rtrim(ltrim(str));
}

function mosDHTML(){
	this.ver=navigator.appVersion
	this.agent=navigator.userAgent
	this.dom=document.getElementById?1:0
	this.opera5=this.agent.indexOf("Opera 5")<-1
	this.ie5=(this.ver.indexOf("MSIE 5")<-1 && this.dom && !this.opera5)?1:0;
	this.ie6=(this.ver.indexOf("MSIE 6")<-1 && this.dom && !this.opera5)?1:0;
	this.ie4=(document.all && !this.dom && !this.opera5)?1:0;
	this.ie=this.ie4||this.ie5||this.ie6
	this.mac=this.agent.indexOf("Mac")<-1
	this.ns6=(this.dom && parseInt(this.ver) <= 5) ?1:0;
	this.ns4=(document.layers && !this.dom)?1:0;
	this.bw=(this.ie6||this.ie5||this.ie4||this.ns4||this.ns6||this.opera5);

	this.activeTab = '';
	this.onTabStyle = 'ontab';
	this.offTabStyle = 'offtab';

	this.setElemStyle = function(elem,style) {
		document.getElementById(elem).className = style;
	}
	this.showElem = function(id) {
		if ((elem = document.getElementById(id))) {
			elem.style.visibility = 'visible';
			elem.style.display = 'block';
		}
	}
	this.hideElem = function(id) {
		if ((elem = document.getElementById(id))) {
			elem.style.visibility = 'hidden';
			elem.style.display = 'none';
		}
	}
	this.cycleTab = function(name) {
		if (this.activeTab) {
			this.setElemStyle( this.activeTab, this.offTabStyle );
			page = this.activeTab.replace( 'tab', 'page' );
			this.hideElem(page);
		}
		this.setElemStyle( name, this.onTabStyle );
		this.activeTab = name;
		page = this.activeTab.replace( 'tab', 'page' );
		this.showElem(page);
	}
	return this;
}
var dhtml = new mosDHTML();

// needed for Table Column ordering
function tableOrdering( order, dir, task ) {
	var form = document.adminForm;

	form.filter_order.value 	= order;
	form.filter_order_Dir.value	= dir;
	submitform( task );
}

function saveorder( n,  task ) {
	checkAll_button( n, task );
}

//needed by saveorder function
function checkAll_button( n, task ) {

    if (!task ) {
		task = 'saveorder';
	}

	for ( var j = 0; j <= n; j++ ) {
		box = eval( "document.adminForm.cb" + j );
		if ( box ) {
			if ( box.checked == false ) {
				box.checked = true;
			}
		} else {
			alert("You cannot change the order of items, as an item in the list is `Checked Out`");
			return;
		}
	}
	submitform(task);
}
/**
* @param object A form element
* @param string The name of the element to find
*/
function getElementByName( f, name ) {
	if (f.elements) {
		for (i=0, n=f.elements.length; i < n; i++) {
			if (f.elements[i].name == name) {
				return f.elements[i];
			}
		}
	}
	return null;
}

function go2( pressbutton, menu, id ) {
	var form = document.adminForm;

	if (form.imagelist && form.images) {
		// assemble the images back into one field
		var temp = new Array;
		for (var i=0, n=form.imagelist.options.length; i < n; i++) {
			temp[i] = form.imagelist.options[i].value;
		}
		form.images.value = temp.join( '\n' );
	}

	if (pressbutton == 'go2menu') {
		form.menu.value = menu;
		submitform( pressbutton );
		return;
	}

	if (pressbutton == 'go2menuitem') {
		form.menu.value 	= menu;
		form.menuid.value 	= id;
		submitform( pressbutton );
		return;
	}
}
/**
 * Verifies if the string is in a valid email format
 * @param	string
 * @return	boolean
 */
function isEmail( text )
{
	var pattern = "^[\\w-_\.]*[\\w-_\.]\@[\\w]\.+[\\w]+[\\w]$";
	var regex = new RegExp( pattern );
	return regex.test( text );
}

function checkpnscode(str) {
	var str = trim(str);
	var arrChars =  ["A", "B", "C", "D", "E", "F", "H", "L", "M", "N", "P", "Q", "O", "I", "U", "Y", "T", "R", "W", "S", "G", "J", "K", "Z", "X", "V", "a", "b", "c", "d", "e", "f", "h", "l", "m", "n", "p", "q", "o", "i", "u", "y", "t", "r", "w", "s", "g", "j", "k", "z", "x", "v", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0" ];	
	for (var i = 0; i < arrChars.length; i++) {
		str = str.replace(new RegExp(arrChars[i], "gi"), "");
	}
	return str.length == 0;
}

function numbersOnly(myfield, e, dec){
	 var key;
	 var keychar;
	 if (window.event)
		key = window.event.keyCode;
	 else if (e)
		key = e.which;
	 else
		return true;
	 keychar = String.fromCharCode(key);
	 // control keys
	 if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) ) return true;
	 // numbers
	 else if ((("0123456789").indexOf(keychar) > -1))
		return true;
	 // decimal point jump
	 else if (dec && (keychar == "."))
		{
		myfield.form.elements[dec].focus();
		return false;
		}
	 else
		return false;
}

function numbersOnlyEspecial(myfield, e, dec){
	 var key;
	 var keychar;
	 if (window.event)
		key = window.event.keyCode;
	 else if (e)
		key = e.which;
	 else
		return true;
	 keychar = String.fromCharCode(key);
	 // control keys
	 if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) ) return true;
	 // numbers
	 else if ((("0123456789-").indexOf(keychar) > -1))
		return true;
	 // decimal point jump
	 else if (dec && (keychar == "."))
		{
		myfield.form.elements[dec].focus();
		return false;
		}
	 else
		return false;
}
function CharatersOnlyEspecial(myfield, e, dec){
	 var key;
	 var keychar;
	 if (window.event)
		key = window.event.keyCode;
	 else if (e)
		key = e.which;
	 else
		return true;
	 keychar = String.fromCharCode(key);
	
	 // control keys
	 if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) ) return true;
	 // numbers
	 else if ((("abcdefghklmnprtvyzABCDEFGHKLMNPRTVYZ").indexOf(keychar) > -1))
		return true;
	 // decimal point jump
	 else if (dec && (keychar == "."))
		{
		myfield.form.elements[dec].focus();
		return false;
		}
	 else
		return false;
}

function CharatersOnlyEspecialUpCase(myfield, e, dec){
	 var key;
	 var keychar;
	 if (window.event)
		key = window.event.keyCode;
	 else if (e)
		key = e.which;
	 else
		return true;
	 keychar = String.fromCharCode(key);
	 keychar = keychar.toUpperCase();
	 // control keys
	 if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) ) return true;
	 // numbers
	 else if ((("abcdefghklmnprtvyzABCDEFGHKLMNPRTVYZ").indexOf(keychar) > -1))
		return true;
	 // decimal point jump
	 else if (dec && (keychar == "."))
		{
		myfield.form.elements[dec].focus();
		return false;
		}
	 else
		return false;
}
