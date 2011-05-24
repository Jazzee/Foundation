<?php
namespace Foundation\Form\Filter;
/**
 * Make the value safe to use in URLs
 */
class UrlSafe extends AbstractFilter{
  public function filterValue($value){
    return \urlencode($value);
  }
}
?>
