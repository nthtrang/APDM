<?php
// $Header: /cvsroot/html2ps/box.table.section.php,v 1.13 2006/07/09 09:07:44 Konstantin Exp $

class TableSectionBox extends GenericContainerBox {
  function &create(&$root, &$pipeline) {
    $box =& new TableSectionBox();
    $box->readCSS($pipeline->getCurrentCSSState());

    // Parse table contents
    $child = $root->first_child();
    while ($child) {
      $child_box =& create_pdf_box($child, $pipeline);
      $box->add_child($child_box);
      $child = $child->next_sibling();
    };

    return $box;
  }
  
  function TableSectionBox() {
    $this->GenericContainerBox();

    // Automatically create at least one table row
    $this->content[] =& new TableRowBox();
  }

  // Overrides default 'add_child' in GenericFormattedBox
  function add_child(&$item) {
    // Check if we're trying to add table cell to current table directly, without any table-rows
    if (!$item->isTableRow()) {
      // Add cell to the last row
      $last_row =& $this->content[count($this->content)-1];
      $last_row->add_child($item);
    } else {
      // If previous row is empty, remove it (get rid of automatically generated table row in constructor)
      if (count($this->content[count($this->content)-1]->content) == 0) {
        array_pop($this->content);
      }
      
      // Just add passed row 
      $this->content[] =& $item;
    };
  }

  function isTableSection() {
    return true;
  }
}
?>