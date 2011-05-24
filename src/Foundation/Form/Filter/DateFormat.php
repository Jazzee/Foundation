<?php
namespace Foundation\Form\Filter;
/**
 * Convert value to a nice date
 */
class DateFormat extends AbstractFilter{
  public function filter($value){
    return date($this->ruleSet, strtotime($value));
  }
}
?>
