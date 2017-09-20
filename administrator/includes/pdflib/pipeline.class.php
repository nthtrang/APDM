<?php

define('DEBUG_MODE',1);
require_once('config.inc.php');

require_once('utils_array.php');
require_once('utils_graphic.php');
require_once('utils_url.php');
require_once('utils_text.php');
require_once('utils_units.php');
require_once('utils_number.php');

require_once('value.color.php');

require_once('config.parse.php');

require_once('flow_context.class.inc.php');
require_once('flow_viewport.class.inc.php');

require_once('output._interface.class.php');
require_once('output._generic.class.php');
require_once('output._generic.pdf.class.php');
require_once('output._generic.ps.class.php');
require_once('output.pdflib.old.class.php');
require_once('output.pdflib.1.6.class.php');
require_once('output.fpdf.class.php');
require_once('output.fastps.class.php');
require_once('output.fastps.l2.class.php');
require_once('output.png.class.php');
// require_once('output.pcl.class.php');

require_once('stubs.common.inc.php');

require_once('media.layout.inc.php');

require_once('box.php');
require_once('box.generic.php');
require_once('box.generic.formatted.php');
require_once('box.container.php');
require_once('box.generic.inline.php');
require_once('box.inline.php');
require_once('box.inline.control.php');

require_once('font.class.php');
require_once('font_factory.class.php');

require_once('box.br.php');
require_once('box.block.php');
require_once('box.page.margin.class.php');
require_once('box.body.php');
require_once('box.block.inline.php');
require_once('box.button.php');
require_once('box.button.submit.php');
require_once('box.button.reset.php');
require_once('box.checkbutton.php');
require_once('box.form.php');
require_once('box.frame.php');
require_once('box.iframe.php');
require_once('box.input.text.php');
require_once('box.input.textarea.php');
require_once('box.input.password.php');
require_once('box.legend.php');
require_once('box.list-item.php');
require_once('box.null.php');
require_once('box.radiobutton.php');
require_once('box.select.php');
require_once('box.table.php');
require_once('box.table.cell.php');
require_once('box.table.cell.fake.php');
require_once('box.table.row.php');
require_once('box.table.section.php');

require_once('box.text.php');
require_once('box.text.string.php');
require_once('box.field.pageno.php');
require_once('box.field.pages.php');

require_once('box.whitespace.php');

require_once('box.img.php'); // Inherited from the text box!
require_once('box.input.img.php');

require_once('box.utils.text-align.inc.php');

require_once('manager.encoding.php');

require_once('ps.unicode.inc.php');
require_once('ps.utils.inc.php');
require_once('ps.whitespace.inc.php');

require_once('ps.image.encoder.inc.php');
require_once('ps.image.encoder.simple.inc.php');
require_once('ps.l2.image.encoder.stream.inc.php');
require_once('ps.l3.image.encoder.stream.inc.php');

require_once('tag.body.inc.php');
require_once('tag.font.inc.php');
require_once('tag.frame.inc.php');
require_once('tag.input.inc.php');
require_once('tag.img.inc.php');
require_once('tag.select.inc.php');
require_once('tag.span.inc.php');
require_once('tag.table.inc.php');
require_once('tag.td.inc.php');
require_once('tag.utils.inc.php');

require_once('tree.navigation.inc.php');

require_once('html.attrs.inc.php');

require_once('xhtml.autoclose.inc.php');
require_once('xhtml.utils.inc.php');
require_once('xhtml.tables.inc.php');
require_once('xhtml.p.inc.php');
require_once('xhtml.lists.inc.php');
require_once('xhtml.deflist.inc.php');
require_once('xhtml.script.inc.php');
require_once('xhtml.entities.inc.php');
require_once('xhtml.comments.inc.php');
require_once('xhtml.style.inc.php');
require_once('xhtml.selects.inc.php');

require_once('background.image.php');
require_once('background.position.php');

require_once('list-style.image.php');

require_once('height.php');
require_once('width.php');

require_once('css.colors.inc.php');

require_once('css.constants.inc.php');
require_once('css.inc.php');
require_once('css.state.class.php');
require_once('css.cache.class.php');
require_once('css.property.handler.class.php');
require_once('css.property.stringset.class.php');
require_once('css.property.sub.class.php');
require_once('css.property.sub.field.class.php');
require_once('css.utils.inc.php');
require_once('css.parse.inc.php');
require_once('css.parse.media.inc.php');

require_once('css.background.color.inc.php');
require_once('css.background.image.inc.php');
require_once('css.background.repeat.inc.php');
require_once('css.background.position.inc.php');
require_once('css.background.inc.php');

require_once('css.border.inc.php');
require_once('css.border.style.inc.php');
require_once('css.border.collapse.inc.php');
require_once('css.bottom.inc.php');
require_once('css.clear.inc.php');
require_once('css.color.inc.php');
require_once('css.html2ps.html.content.inc.php');
require_once('css.html2ps.pseudoelements.inc.php');
require_once('css.content.inc.php');
require_once('css.display.inc.php');
require_once('css.float.inc.php');
require_once('css.font.inc.php');
require_once('css.height.inc.php');
require_once('css.min-height.inc.php');
require_once('css.max-height.inc.php');
require_once('css.left.inc.php');
require_once('css.letter-spacing.inc.php');

require_once('css.list-style-image.inc.php');
require_once('css.list-style-position.inc.php');
require_once('css.list-style-type.inc.php');
require_once('css.list-style.inc.php');

require_once('css.margin.inc.php');
require_once('css.overflow.inc.php');
require_once('css.padding.inc.php');

require_once('css.page-break.inc.php');
require_once('css.page-break-after.inc.php');

require_once('css.position.inc.php');
require_once('css.right.inc.php');
require_once('css.property.declaration.php');
require_once('css.rules.inc.php');
require_once('css.ruleset.class.php');
require_once('css.selectors.inc.php');
require_once('css.text-align.inc.php');
require_once('css.text-decoration.inc.php');
require_once('css.text-transform.inc.php');
require_once('css.text-indent.inc.php');
require_once('css.top.inc.php');
require_once('css.vertical-align.inc.php');
require_once('css.visibility.inc.php');
require_once('css.white-space.inc.php');
require_once('css.width.inc.php');
require_once('css.word-spacing.inc.php');
require_once('css.z-index.inc.php');

require_once('css.pseudo.add.margin.inc.php');
require_once('css.pseudo.align.inc.php');
require_once('css.pseudo.cellspacing.inc.php');
require_once('css.pseudo.cellpadding.inc.php');
require_once('css.pseudo.form.action.inc.php');
require_once('css.pseudo.form.radiogroup.inc.php');
require_once('css.pseudo.link.destination.inc.php');
require_once('css.pseudo.link.target.inc.php');
require_once('css.pseudo.listcounter.inc.php');
require_once('css.pseudo.localalign.inc.php');
require_once('css.pseudo.nowrap.inc.php');
require_once('css.pseudo.table.border.inc.php');

// After all CSS utilities and constants have been initialized, load the default (precomiled) CSS stylesheet
require_once('converter.class.php');
require_once('treebuilder.class.php');
require_once('image.class.php');

require_once('fetched_data._interface.class.php');
require_once('fetched_data._html.class.php');
require_once('fetched_data.url.class.php');
require_once('fetched_data.file.class.php');

require_once('fetcher._interface.class.php');
require_once('fetcher.url.class.php');
require_once('fetcher.local.class.php');

require_once('filter.data._interface.class.php');
require_once('filter.data.doctype.class.php');

require_once('filter.data.utf8.class.php');
require_once('filter.data.ucs2.class.php');

require_once('filter.data.html2xhtml.class.php');
require_once('filter.data.xhtml2xhtml.class.php');

require_once('parser._interface.class.php');
require_once('parser.xhtml.class.php');

require_once('filter.pre._interface.class.php');
require_once('filter.pre.fields.class.php');
require_once('filter.pre.headfoot.class.php');
require_once('filter.pre.footnotes.class.php');

require_once('filter.pre.height-constraint.class.php');

require_once('layout._interface.class.php');
require_once('layout.default.class.php');

require_once('filter.post._interface.class.php');

require_once('filter.output._interface.class.php');
require_once('filter.output.ps2pdf.class.php');
require_once('filter.output.gzip.class.php');

require_once('destination._interface.class.php');
require_once('destination._http.class.php');
require_once('destination.browser.class.php');
require_once('destination.download.class.php');
require_once('destination.file.class.php');

require_once('xml.validation.inc.php');

require_once('content_type.class.php');

class Pipeline {
  var $fetchers;
  var $data_filters;
  var $error_message;
  var $parser;
  var $pre_tree_filters;
  var $layout_engine;
  var $post_tree_filters;
  var $output_driver;
  var $output_filters;
  var $destination;

  var $_base_url;

  var $_page_at_rules;
  var $_counters;
  var $_footnotes;

  var $_cssState;
  var $_css;
  var $_defaultCSS;

  function _addFootnote(&$note_call) {
    $this->_footnotes[] =& $note_call;
  }

  function _fillContent($content) {
    $filled = "";

    while (preg_match("/^.*?('.*?'|\".*?\"|counter\(.*?\))(.*)$/", $content, $matches)) {
      $data    = $matches[1];
      $content = $matches[2];
      
      if ($data{0} != '\'' && $data{0} != '"') {
        $filled .= $this->_fillContentCounter($data);
      } else {
        $filled .= $this->_fillContentString($data);
      };
    };

    return $filled;
  }

  function _fillContentString($content) {
    return css_remove_value_quotes(css_process_escapes($content));
  }

  function _fillContentCounter($content) {
    preg_match("/counter\((.*?)\)/", $content, $matches);
    return $this->_getCounter($matches[1]);
  }

  function _getCounter($counter) {
    if (isset($this->_counters[$counter])) { 
      return $this->_counters[$counter];
    };

    /**
     * CSS  2.1:   Counters  that  are   not  in  the  scope   of  any
     * 'counter-reset',  are assumed  to have  been  reset to  0 by  a
     * 'counter-reset' on the root element.
     */
    return 0;
  }

  function _resetCounter($counter, $value) {
    $this->_counters[$counter] = $value;
  }

  function _incrementCounter($counter, $value) {
    $this->_counters[$counter] += $value;
  }

  function addAtRulePage($at_rule) {
    $this->_page_at_rules[$at_rule->getSelector()][] = $at_rule;
  }


  function Pipeline() {
    $this->_counters = array();
    $this->_footnotes = array();

    $this->_base_url      = array("");
    $this->_page_at_rules = array(CSS_PAGE_SELECTOR_ALL   => array(),
                                  CSS_PAGE_SELECTOR_FIRST => array(),
                                  CSS_PAGE_SELECTOR_LEFT  => array(),
                                  CSS_PAGE_SELECTOR_RIGHT => array());
  }

  function &getDefaultCSS() {
    return $this->_defaultCSS;
  }

  function &getCurrentCSS() {
    return $this->_css[0];
  }

  function &getCurrentCSSState() {
    return $this->_cssState[0];
  }

  function pushCSS() {
    array_unshift($this->_css, new CSSRuleset());
  }

  function popCSS() {
    array_shift($this->_css);
  }

  /**
   * Note that different pages  may define different margin boxes (for
   * example,  left and right  pages may  have different  headers). In
   * this  case, we  should  process  @page rules  in  order of  their
   * specificity (no selector  < :left / :right <  :first) and extract
   * margin boxes to be drawn
   *
   * @param $page_no Integer current page index (1-based)
   * @param $media 
   */
  function _renderMarginBoxes($page_no, &$media) {
    $boxes =& $this->_reflowMarginBoxes($page_no, $media);

    foreach ($boxes as $selector => $box) {
      $boxes[$selector]->show($this->output_driver);
    };
  }

  function &_reflowMarginBoxes($page_no, &$media) {
    $at_rules = $this->_getMarginBoxes($page_no, $media);

    $boxes = array();
    foreach ($at_rules as $at_rule) {
      $boxes[$at_rule->getSelector()] =& BoxPageMargin::create($this, $at_rule);
    };

    foreach ($boxes as $selector => $box) {
      $linebox_started     = false;
      $previous_whitespace = false;
      $boxes[$selector]->reflow_whitespace($linebox_started, $previous_whitespace);
      $boxes[$selector]->reflow_text($this->output_driver);
    };

    foreach ($boxes as $selector => $box) {
      $boxes[$selector]->reflow($this->output_driver, 
                                $media,
                                $boxes);
    };

    return $boxes;
  }

  /**
   * Note that "+" operation on arrays will preserve existing elements; thus
   * we need to process @page rules in order of decreasing specificity
   *
   */
  function _getMarginBoxes($page_no, $media) {
    $applicable_margin_boxes = array();

    /**
     * Check if :first selector is applicable
     */
    if ($page_no == 1) {
      foreach ($this->_page_at_rules[CSS_PAGE_SELECTOR_FIRST] as $rule) {
        $applicable_margin_boxes = $applicable_margin_boxes +  $rule->getAtRuleMarginBoxes();
      };
    };

    /**
     * Check which one of :right/:left selector is applicable (assuming that first page matches :right)
     */
    if ($page_no % 2 == 0) {
      foreach ($this->_page_at_rules[CSS_PAGE_SELECTOR_LEFT] as $rule) {
        $applicable_margin_boxes = $applicable_margin_boxes +  $rule->getAtRuleMarginBoxes();
      };
    } else {
      foreach ($this->_page_at_rules[CSS_PAGE_SELECTOR_RIGHT] as $rule) {
        $applicable_margin_boxes = $applicable_margin_boxes +  $rule->getAtRuleMarginBoxes();
      };
    };

    /**
     * Extract margin boxes from plain @page rules
     */
    foreach ($this->_page_at_rules[CSS_PAGE_SELECTOR_ALL] as $rule) {
      $applicable_margin_boxes = $applicable_margin_boxes +  $rule->getAtRuleMarginBoxes();
    };

    if (!isset($applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_TOP])) { $applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_TOP] = new CSSAtRuleMarginBox(CSS_MARGIN_BOX_SELECTOR_TOP,$this); };
    if (!isset($applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_TOP_LEFT_CORNER])) { $applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_TOP_LEFT_CORNER] = new CSSAtRuleMarginBox(CSS_MARGIN_BOX_SELECTOR_TOP_LEFT_CORNER,$this); };
    if (!isset($applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_TOP_LEFT])) { $applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_TOP_LEFT] = new CSSAtRuleMarginBox(CSS_MARGIN_BOX_SELECTOR_TOP_LEFT,$this); };
    if (!isset($applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_TOP_CENTER])) { $applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_TOP_CENTER] = new CSSAtRuleMarginBox(CSS_MARGIN_BOX_SELECTOR_TOP_CENTER,$this); };
    if (!isset($applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_TOP_RIGHT])) { $applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_TOP_RIGHT] = new CSSAtRuleMarginBox(CSS_MARGIN_BOX_SELECTOR_TOP_RIGHT,$this); };
    if (!isset($applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_TOP_RIGHT_CORNER])) { $applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_TOP_RIGHT_CORNER] = new CSSAtRuleMarginBox(CSS_MARGIN_BOX_SELECTOR_TOP_RIGHT_CORNER,$this); };
    if (!isset($applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_BOTTOM])) { $applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_BOTTOM] = new CSSAtRuleMarginBox(CSS_MARGIN_BOX_SELECTOR_BOTTOM,$this); };
    if (!isset($applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_BOTTOM_LEFT_CORNER])) { $applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_BOTTOM_LEFT_CORNER] = new CSSAtRuleMarginBox(CSS_MARGIN_BOX_SELECTOR_BOTTOM_LEFT_CORNER,$this); };
    if (!isset($applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_BOTTOM_LEFT])) { $applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_BOTTOM_LEFT] = new CSSAtRuleMarginBox(CSS_MARGIN_BOX_SELECTOR_BOTTOM_LEFT,$this); };
    if (!isset($applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_BOTTOM_CENTER])) { $applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_BOTTOM_CENTER] = new CSSAtRuleMarginBox(CSS_MARGIN_BOX_SELECTOR_BOTTOM_CENTER,$this); };
    if (!isset($applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_BOTTOM_RIGHT])) { $applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_BOTTOM_RIGHT] = new CSSAtRuleMarginBox(CSS_MARGIN_BOX_SELECTOR_BOTTOM_RIGHT,$this); };
    if (!isset($applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_BOTTOM_RIGHT_CORNER])) { $applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_BOTTOM_RIGHT_CORNER] = new CSSAtRuleMarginBox(CSS_MARGIN_BOX_SELECTOR_BOTTOM_RIGHT_CORNER,$this); };
    if (!isset($applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_LEFT_TOP])) { $applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_LEFT_TOP] = new CSSAtRuleMarginBox(CSS_MARGIN_BOX_SELECTOR_LEFT_TOP,$this); };
    if (!isset($applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_LEFT_MIDDLE])) { $applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_LEFT_MIDDLE] = new CSSAtRuleMarginBox(CSS_MARGIN_BOX_SELECTOR_LEFT_MIDDLE,$this); };
    if (!isset($applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_LEFT_BOTTOM])) { $applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_LEFT_BOTTOM] = new CSSAtRuleMarginBox(CSS_MARGIN_BOX_SELECTOR_LEFT_BOTTOM,$this); };
    if (!isset($applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_RIGHT_TOP])) { $applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_RIGHT_TOP] = new CSSAtRuleMarginBox(CSS_MARGIN_BOX_SELECTOR_RIGHT_TOP,$this); };
    if (!isset($applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_RIGHT_MIDDLE])) { $applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_RIGHT_MIDDLE] = new CSSAtRuleMarginBox(CSS_MARGIN_BOX_SELECTOR_RIGHT_MIDDLE,$this); };
    if (!isset($applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_RIGHT_BOTTOM])) { $applicable_margin_boxes[CSS_MARGIN_BOX_SELECTOR_RIGHT_BOTTOM] = new CSSAtRuleMarginBox(CSS_MARGIN_BOX_SELECTOR_RIGHT_BOTTOM,$this); };

    return $applicable_margin_boxes;
  }

  function _process_item($data_id, &$media, $offset=0) {
     
    $css_cache = CSSCache::get();

    $this->_defaultCSS = $css_cache->compile("resource://default.css", 
                                             file_get_contents(HTML2PS_DIR.DIRECTORY_SEPARATOR.'default.css'));
    $this->_css      = array();
    $this->pushCSS();

    $this->_cssState = array(new CSSState(CSS::get()));

    $font = $this->_cssState[0]->getProperty(CSS_FONT);
    $font->units2pt(0);
    $this->_cssState[0]->setProperty(CSS_FONT, $font);

    $data = $this->fetch($data_id);
    if ($data == null) { return null; };

    // Run raw data filters
    for ($i=0; $i<count($this->data_filters); $i++) {
      $data = $this->data_filters[$i]->process($data);
    };
    
    // Parse the raw data
    
    $box =& $this->parser->process($data->get_content(), $this);
      
    /**
     * Run obligatory tree filters
     */

    /**
     * height-constraint processing filter;
     */
    $filter = new PreTreeFilterHeightConstraint();
    $filter->process($box, $data, $this);

    /**
     * Footnote support filter
     */
    $filter = new PreTreeFilterFootnotes();
    $filter->process($box, $data, $this);

    // Run pre-layout tree filters
    for ($i=0; $i<count($this->pre_tree_filters); $i++) {
      $this->pre_tree_filters[$i]->process($box, $data, $this);
    };


    /**
     * Auto-detect top/bottom margin size (only if both top and bottom margins have zero value)
     */
    if ($media->margins['top'] == 0 &&
        $media->margins['bottom'] == 0) {
      $boxes = $this->_reflowMarginBoxes(0, $media);

      $media->margins['top'] = max($boxes[CSS_MARGIN_BOX_SELECTOR_TOP]->get_real_full_height(),
                                   $boxes[CSS_MARGIN_BOX_SELECTOR_TOP_LEFT_CORNER]->get_real_full_height(),
                                   $boxes[CSS_MARGIN_BOX_SELECTOR_TOP_LEFT]->get_real_full_height(),
                                   $boxes[CSS_MARGIN_BOX_SELECTOR_TOP_CENTER]->get_real_full_height(),

                                   $boxes[CSS_MARGIN_BOX_SELECTOR_TOP_RIGHT]->get_real_full_height(),
                                   $boxes[CSS_MARGIN_BOX_SELECTOR_TOP_RIGHT_CORNER]->get_real_full_height()) / mm2pt(1);

      $media->margins['bottom'] = max($boxes[CSS_MARGIN_BOX_SELECTOR_BOTTOM]->get_real_full_height(),
                                      $boxes[CSS_MARGIN_BOX_SELECTOR_BOTTOM_LEFT_CORNER]->get_real_full_height(),
                                      $boxes[CSS_MARGIN_BOX_SELECTOR_BOTTOM_LEFT]->get_real_full_height(),
                                      $boxes[CSS_MARGIN_BOX_SELECTOR_BOTTOM_CENTER]->get_real_full_height(),
                                      $boxes[CSS_MARGIN_BOX_SELECTOR_BOTTOM_RIGHT]->get_real_full_height(),
                                      $boxes[CSS_MARGIN_BOX_SELECTOR_BOTTOM_RIGHT_CORNER]->get_real_full_height()) / mm2pt(1);

      $this->output_driver->reset($media);
    };

    $context = new FlowContext;

    /**
     * Extract absolute/fixed positioned boxes
     */
    $positioned_filter = new PostTreeFilterPositioned($context, $this->output_driver);
    $positioned_filter->process($box, null, $this);

    $status = $this->layout_engine->process($box, $media, $this->output_driver, $context);
    if (is_null($status)) { 
      error_log("Pipeline::_process_item: layout routine failed");
      return null; 
    };

    // Run post-layout tree filters
    for ($i=0; $i<count($this->post_tree_filters); $i++) {
      $this->post_tree_filters[$i]->process($box);
    };

    $context->sort_absolute_positioned_by_z_index();

    // Make batch-processing offset
    $box->offset(0, $offset);

    $expected_pages = $this->output_driver->get_expected_pages();
    $this->_resetCounter('pages', $expected_pages);
    $this->_resetCounter('page',  0);

    // Output PDF pages using chosen PDF driver
    for ($i=0; $i<$expected_pages; $i++) {
      $this->_resetCounter('footnote', 0);
      $this->_incrementCounter('page', 1);

      $this->output_driver->save();

      /**
       * Note that margin boxes should be rendered before 'setup_clip', as it will trim all
       * content rendered outside the 'main' page area
       */
      $this->_renderMarginBoxes($i+1, $media);

      $this->output_driver->setup_clip();

      if (is_null($box->show($this->output_driver))) { 
        error_log("Pipeline::_process_item: output routine failed");
        return null; 
      };

      /**
       * Show postponed boxes - relative and floating boxes, as they should be 
       * shown over boxes on the same layer
       */

      $this->output_driver->show_postponed();

      $this->renderAbsolutePositioned($context);
      $this->output_driver->restore();
      $this->renderFixedPositioned($context);
      $this->renderFootnotes();

      global $g_config;
      if ($g_config['draw_page_border']) { 
        $this->output_driver->draw_page_border(); 
      };

      // Add page if currently rendered page is not last
      if ($i < $this->output_driver->get_expected_pages()-1) { 
        $this->output_driver->next_page(); 
      };

      // Restore postponed list for the next page
      $positioned_filter->process($box, null, $this);
      
    };

    // Clear CSS for this item 
    $this->popCSS();
    $this->_defaultCSS = null;

    return true;
  }

  function _output() {
    $filename = $this->output_driver->get_filename();

    for ($i=0; $i<count($this->output_filters); $i++) {
      $filename = $this->output_filters[$i]->process($filename);
    };

    // Determine the content type of the result
    $content_type = null;
    $i = count($this->output_filters)-1;
    while (($i >= 0) && (is_null($content_type))) {
      $content_type = $this->output_filters[$i]->content_type();
      $i--;
    };

    if (is_null($content_type)) {
      $content_type = $this->output_driver->content_type();
    };

    $this->destination->process($filename, $content_type);
  }

  function fetch($data_id) {
    if (count($this->fetchers) == 0) { 
      ob_start();
      include(HTML2PS_DIR.'/templates/error._no_fetchers.tpl');
      $this->error_message = ob_get_contents();
      ob_end_clean();

      return null; 
    };

    // Fetch data
    for ($i=0; $i<count($this->fetchers); $i++) {
      $data = $this->fetchers[$i]->get_data($data_id);

      if ($data != null) {
        $this->push_base_url($this->fetchers[$i]->get_base_url());
        
        return $data;
      };
    };

    return null;
  }
  
  function process($data_id, &$media) {
      global $g_media;         
    $this->_setupScales($media);

   
    $g_media =& $media;

    $this->output_driver->reset($media);
    
    if (!$this->_process_item($data_id, $media)) {          
      print($this->error_message());
      die("HTML2PS Error");
    }
  
    $this->output_driver->close();
    $this->_output();
    $this->output_driver->release();   

    // Non HTML-specific cleanup
    //
    Image::clear_cache();

    global $g_box_uid;

    return true;
  }

  function _setupScales(&$media) {
    global $g_config;
    global $g_px_scale;
    global $g_pt_scale;

    $g_px_scale = floor(mm2pt($media->width() - $media->margins['left'] - $media->margins['right'])) / $media->pixels;

    if ($g_config['scalepoints']) {
      $g_pt_scale = $g_px_scale * 1.33; // This is a magic number, just don't touch it, or everything will explode!
    } else {
      $g_pt_scale = 1.0;
    };
  }

  /**
   * Processes an set of URLs ot once; every URL is rendered on the separate page and 
   * merged to one PDF file.
   *
   * Note: to reduce peak memory requirement, URLs are processed one-after-one.
   *
   * @param Array $data_id_array Array of page identifiers to be processed (usually URLs or files paths)
   * @param Media $media Object describing the media to render for (size, margins, orientaiton & resolution)
   */
  function process_batch($data_id_array, &$media) {
    $this->_setupScales($media);

    $this->output_driver->reset($media);

    $i = 0;
    $offset = 0;
    foreach ($data_id_array as $data_id) {      
      $this->_process_item($data_id, $media, $offset);
      
      $i++;
      if ($i<count($data_id_array)) {
        $this->output_driver->next_page();
        $offset = $this->output_driver->offset;
      };
    };
    $this->output_driver->close();
    $this->_output();
    $this->output_driver->release();   

    // Non HTML-specific cleanup
    //
    Image::clear_cache();

    return true;
  }

  function error_message() {
    $message = file_get_contents(HTML2PS_DIR.'/templates/error._header.tpl');

    $message .= $this->error_message;

    for ($i=0; $i<count($this->fetchers); $i++) {
      $message .= $this->fetchers[$i]->error_message();
    };

    $message .= $this->output_driver->error_message();
    
    $message .= file_get_contents(HTML2PS_DIR.'/templates/error._footer.tpl');
    return $message;
  }

  function push_base_url($url) {
    array_unshift($this->_base_url, $url);
  }

  function pop_base_url() {
    array_shift($this->_base_url);
  }

  function get_base_url() {
    return $this->_base_url[0];
  }

  function guess_url($src) {
    return guess_url($src, $this->get_base_url());
  }

  function renderFootnotes() {
    /**
     * Render every footnote defined (note-call element is visible) on a current page
     */

    $footnote_y = $this->output_driver->getFootnoteTop() - FOOTNOTE_LINE_TOP_GAP - FOOTNOTE_LINE_BOTTOM_GAP;
    $footnote_x = $this->output_driver->getPageLeft();
    $footnotes_found = false;

    foreach ($this->_footnotes as $footnote) {
      // Note that footnote area for current page have been already defined,
      // as show_foonote is called after note-call boxes were placed.
      if ($this->output_driver->contains($footnote->_note_call_box)) { 
        $footnotes_found = true;
        $footnote_y = $footnote->show_footnote($this->output_driver, 
                                               $footnote_x,
                                               $footnote_y);
        $footnote_y -= FOOTNOTE_GAP;
      };
    };

    /**
     * Draw thin line separating footnotes from page content
     */
    if ($footnotes_found) {
      $this->output_driver->setrgbcolor(0,0,0);
      $this->output_driver->moveto($this->output_driver->getPageLeft(),
                                   $this->output_driver->getFootnoteTop() - FOOTNOTE_LINE_TOP_GAP);
      $this->output_driver->lineto($this->output_driver->getPageLeft() + $this->output_driver->getPageWidth()*FOOTNOTE_LINE_PERCENT/100,
                                   $this->output_driver->getFootnoteTop() - FOOTNOTE_LINE_TOP_GAP);
      $this->output_driver->stroke();
    };
  }

  function renderAbsolutePositioned(&$context) {
    for ($j=0, $size = count($context->absolute_positioned); $j<$size; $j++) {
      $current_box =& $context->absolute_positioned[$j];
      if ($current_box->getCSSProperty(CSS_VISIBILITY) === VISIBILITY_VISIBLE) {
        $this->output_driver->save();
        $current_box->_setupClip($this->output_driver);
        if (is_null($current_box->show($this->output_driver))) {
          return null;
        };
        $this->output_driver->restore();
      };
    };
    $this->output_driver->show_postponed_in_absolute();
  }

  function renderFixedPositioned(&$context) {
    for ($j=0, $size = count($context->fixed_positioned); $j<$size; $j++) {
      $current_box =& $context->fixed_positioned[$j];
      if ($current_box->getCSSProperty(CSS_VISIBILITY) === VISIBILITY_VISIBLE) {
        $this->output_driver->save();
        $current_box->_setupClip($this->output_driver);
        if (is_null($current_box->show_fixed($this->output_driver))) { 
          return null;
        };
        $this->output_driver->restore();
      };
    };
    $this->output_driver->show_postponed_in_fixed();
  }
}

?>