<?php
ini_set("memory_limit", "128M");
session_start();
require_once('pipeline.class.php');
parse_config_file('html2ps.config');
$g_baseurl = "http://sm-linux/pdf.html";//$_SESSION['urlpdf']; 
$g_config = array(
                  'cssmedia'     => 'screen',
                  'renderimages' => true,
                  'renderforms'  => false,
                  'renderlinks'  => true,
                  'mode'         => 'html',
                  'debugbox'     => false,
                  "output" => 1,
                  'draw_page_border' => false
                  );

$media = Media::predefined('A4');
$media->set_landscape(false);
$media->set_margins(array('left'   => 5,
                          'right'  => 5,
                          'top'    => 5,
                          'bottom' => 5));
$media->set_pixels(1024);

$g_px_scale = mm2pt($media->width() - $media->margins['left'] - $media->margins['right']) / $media->pixels;
$g_pt_scale = $g_px_scale * 1.43; 
$pipeline = new Pipeline;
$pipeline->fetchers[]     = new FetcherURL;
$pipeline->data_filters[] = new DataFilterHTML2XHTML;
$pipeline->parser         = new ParserXHTML;
$pipeline->layout_engine  = new LayoutEngineDefault;
$pipeline->output_driver  = new OutputDriverFPDF($media);
$pipeline->destination    = new DestinationDownload($g_baseurl);

$pipeline->process($g_baseurl, $media); 
?>
