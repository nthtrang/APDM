<?php
session_start();
ini_set("display_error", 1);
error_reporting(E_ALL);
ini_set("memory_limit", "252M");
define( '_JEXEC', 1 );

define('JPATH_BASE', dirname(__FILE__) );

define('DS', DIRECTORY_SEPARATOR);
require_once( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once( JPATH_BASE .DS.'includes'.DS.'framework.php' );
$pdf_lib_path = JPATH_BASE.DS."includes".DS."pdflib".DS;
global $pdf_lib_path,$g_baseurl,$g_css_index,$g_stylesheet_title,$g_config ;
$file = $_REQUEST['f'];
$query = (isset($_REQUEST['q'])) ? $_REQUEST['q'] : '';
$limit = (isset($_REQUEST['l'])) ? $_REQUEST['l'] : 0;
$limistart = (isset($_REQUEST['ls'])) ? $_REQUEST['ls'] : 0;
$username  = $_REQUEST['u'];
$total    = (isset($_REQUEST['t'])) ? $_REQUEST['t'] : 0 ;
$id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : 0;
if ($id){
$g_baseurl =  "http://".$_SERVER['HTTP_HOST'].dirname( $_SERVER['PHP_SELF'])."/".$file."?id=".$id."&u=".$username;

}else{
$g_baseurl =  "http://".$_SERVER['HTTP_HOST'].dirname( $_SERVER['PHP_SELF'])."/".$file."?q=".$query."&l=".$limit."&ls=".$limistart."&u=".$username."&t=".$total;
}

//set name file report
switch ($file){
	case "ccs_list.php":
		$name_file = 'APDM_CC_REPORT_';
	break;
	case "eco_list.php":
		$name_file = 'APDM_ECO_REPORT_';
	break;
	case "eco_detail.php":
		$name_file = 'APDM_ECO_DETAIL_REPORT_';
	break;
	case "organ_list.php":
		$name_file = 'APDM_ORG_REPORT_';
	break;
	case "org_detail.php":
		$name_file = 'APDM_ORG_DETAIL_REPORT_';
	break;
	case "pns_list.php":
		$name_file = 'APDM_PNs_REPORT_';
	break;
	case "pns_bom.php":
		$name_file = 'APDM_PNsBOM_REPORT_';
	break;
	case "pns_detail.php":
		$name_file = 'APDM_PNsDetail_REPORT_';
	break;
}

//$g_baseurl = "http://localhost:8080/www/adpm/administrator/eco_pdf.php";
@set_time_limit(100000);
require_once($pdf_lib_path.'pipeline.factory.class.php');
ini_set("user_agent", DEFAULT_USER_AGENT);
// Add HTTP protocol if none specified
if (!preg_match("/^https?:/",$g_baseurl)) {
  $g_baseurl = 'http://'.$g_baseurl;
}

$g_css_index = 0;
// Title of styleshee to use (empty if no preferences are set)
$g_stylesheet_title = "";
$g_config = Array
(
    "cssmedia" => "screen",
    "media" => "A4",
    "scalepoints" => 1,
    "renderimages" => 1,
    "renderfields" => 1,
    "renderforms" =>'' ,
    "pslevel" => 3,
    "renderlinks" => 1,
    "pagewidth" => '1024',
    "landscape" => 0,
    "method" => "fpdf",
    "margins" => Array
        (
            "left" => 0,
            "right" => 0,
            "top" => 0,
            "bottom" => 0,
        ),

    "encoding" =>"utf-8" ,
    "ps2pdf" => "",
    "compress" => "",
    "output" => 2,
    "pdfversion" => 1.5,
    "transparency_workaround" => '',
    "imagequality_workaround" => '',
    "draw_page_border" => '',
    "debugbox" => '',
    "html2xhtml" => 1,
    "mode" => 'html',
	'smartpagebreak'=>1
);
parse_config_file($pdf_lib_path.'html2ps.config');

// begin processing
$g_media = Media::predefined($g_config['media']);
$g_media->set_landscape($g_config['landscape']);
$g_media->set_margins($g_config['margins']);
$g_media->set_pixels($g_config['pagewidth']);

// Initialize the coversion pipeline
$pipeline = new Pipeline();
// Configure the fetchers
$pipeline->fetchers[] = new FetcherURL();
// Configure the data filters
$pipeline->data_filters[] = new DataFilterDoctype();
$pipeline->data_filters[] = new DataFilterUTF8($g_config['encoding']);
$pipeline->data_filters[] = new DataFilterHTML2XHTML();
$pipeline->parser = new ParserXHTML();
// "PRE" tree filters
$pipeline->pre_tree_filters = array();

?>
<?php
ob_start();
$header_html = ob_get_contents();
include_once('pdftemplate_header.php');
ob_end_clean();
ob_start();
?>
<?php
//$footer = ob_get_contents();

$footer_html    = '';
$filter = new PreTreeFilterHeaderFooter($header_html, $footer_html);

$pipeline->pre_tree_filters[] = $filter;

$pipeline->pre_tree_filters[] = new PreTreeFilterHTML2PSFields();
$pipeline->layout_engine = new LayoutEngineDefault();
$pipeline->post_tree_filters = array();

// Configure the output format
$image_encoder = new PSL3ImageEncoderStream();
$pipeline->output_driver = new OutputDriverFPDF();

ob_end_clean();
$pipeline->destination = new  DestinationDownload($name_file.time());
$status = $pipeline->process($g_baseurl, $g_media);
if ($status == null) {
  print($pipeline->error_message());
  error_log("Error in conversion pipeline");
  die(); 
}

?>