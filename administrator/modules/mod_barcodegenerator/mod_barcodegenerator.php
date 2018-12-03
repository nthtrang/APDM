<?

/**
 * @package Module Barcode Generator for Joomla! 1.5
 * @version $Id: mod_barcodegenerator.php 599 2010-10-10 23:26:33Z you $
 * @author Alex Barr
 * @copyright (C) 2010- Alex Barr
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/


defined( '_JEXEC' ) or die( 'Restricted access' );

$code=$_POST["code"];
$thick=$_POST["thick"];
$text=$_POST["text"];
$text=strip_tags($text);
$rot=$_POST["rot"];
$r=$_POST["r"];



if ($code!="" && $thick!="" && $text!="" && $rot!="" && $r!="") {

if ($r==1) {$r2="8";}
if ($r==2) {$r2="10";}


echo "<a name=\"Barcode\"><strong>Barcode Image</strong></a><br /><br />";

echo "<img src=\"http://graphicwebdesignservices.com/administrator/barcodes/html/image.php?code=".$code."&amp;o=1&amp;dpi=72&amp;t=".$thick."&amp;r=".$r."&amp;rot=".$rot."&amp;text=".$text."&amp;f1=Arial.ttf&amp;f2=".$r2."&amp;a1=&amp;a2=&amp;a3=\" alt=\"Barcode Image\">";

echo "<br />";echo "<br />";
}


$domain = $_SERVER['HTTP_HOST'];
$path = $_SERVER['SCRIPT_NAME'];
$queryString = $_SERVER['QUERY_STRING'];
$url = "http://" . $domain . $path;
$url3 = "http://" . $domain . $_SERVER['REQUEST_URI'];
$mystring1="?";
$s1=strpos($url3,$mystring1);
if($s1==0) {$url2=$url3;}
if($s1!=0) {$url2=substr($url3,0,$s1);}
$path = $url2."#Barcode";

echo "<table style=\"width: 100%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\"><tr><td valign=\"top\">";
echo "<form action=\"".$path."\" method=\"post\" >";

echo "<strong>Text</strong><br />";
echo "<input name=\"text\" value=\"".$text."\" type=text size=\"21\" >";
echo "<br /><br />";

echo "<strong>Thickness</strong><br />";
echo "<select name=\"thick\" >";
echo "<option value=\"20\">20</option>";
echo "<option value=\"30\">30</option>";
echo "<option value=\"40\">40</option>";
echo "<option value=\"50\">50</option>";
echo "<option value=\"60\">60</option>";
echo "</select>";
echo "<br />";
echo "<br />";

echo "<strong>Image Size</strong><br />";
echo "<select name=\"r\" >";
echo "<option value=\"1\">Small</option>";
echo "<option value=\"2\">Large</option>";
echo "</select>";
echo "<br />";
echo "<br />";

echo "<strong>Rotation</strong><br />";
echo "<select name=\"rot\" >";
echo "<option value=\"0\">0</option>";
echo "<option value=\"90\">90</option>";
echo "<option value=\"180\">180</option>";
echo "<option value=\"270\">270</option>";
echo "</select>";
echo "<br />";
echo "<br />";

echo "<strong>Barcode Standard</strong><br />";
echo "<select name=\"code\" >";
echo "<option value=\"codabar\">Codabar</option> ";
echo "<option value=\"code11\">Code 11</option>";
echo "<option value=\"code39\">Code 39</option>";
echo "<option value=\"code39extended\">Code 39 Extended</option>";
echo "<option value=\"code93\">Code 93</option>";
echo "<option value=\"code128\">Code 128</option>";
echo "<option value=\"ean8\">EAN-8</option>";
echo "<option value=\"ean13\">EAN-13</option>";
echo "<option value=\"gs1128\">GS1-128 (EAN-128)</option>";
echo "<option value=\"isbn\">ISBN-10 / ISBN-13</option>";
echo "<option value=\"i25\">Interleaved 2 of 5</option>";
echo "<option value=\"s25\">Standard 2 of 5</option>";
echo "<option value=\"msi\">MSI Plessey</option>";
echo "<option value=\"upca\">UPC-A</option>";
echo "<option value=\"upce\">UPC-E</option>";
echo "<option value=\"upcext2\">UPC Extension 2 Digits</option>";
echo "<option value=\"upcext5\">UPC Extension 5 Digits</option>";
echo "<option value=\"postnet\">PostNet</option>";
echo "<option value=\"othercode\">Other Barcode</option>";
echo "</select>";
echo "<br />";
echo "<br />";
echo "<input type=\"submit\" value=\"Generate\" name=\"B1\">";
echo "</form><br />";

//DON'T REMOVE THIS LINK - DO NOT VIOLATE GNU/GPL LICENSE!!!
echo "<a href=\"http://makemoneyscripts.com\">Make Money Scripts</a>";
//DON'T REMOVE THIS LINK - DO NOT VIOLATE GNU/GPL LICENSE!!!
echo "</td></tr></table>";









?>



