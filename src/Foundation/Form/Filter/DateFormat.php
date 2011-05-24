<?php
namespace Foundation\Form\Filter;
/**
 * Convert value to a nice date
 */
class DateFormat extends AbstractFilter{
  public function filterValue($value){
    return date($this->ruleSet, strtotime($value));
  }
}
?>
