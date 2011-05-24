<?php
namespace Foundation\Form\Filter;
/**
 * Make the value safe to use in URLs
 */
class UrlSafe extends AbstractFilter{
  public function filter($value){
    return \urlencode($value);
  }
}
?>
