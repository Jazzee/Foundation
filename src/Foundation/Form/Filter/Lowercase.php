<?php
namespace Foundation\Form\Filter;
/**
 * Convert the value to all lowercase
 */
class Lowercase extends AbstractFilter{
  public function filter($value){
    return \strtolower($value);
  }
}
?>
