<?php
namespace Foundation\Form\Filter;
/**
 * Convert value to a nice date
 * @package foundation\form\filter
 */
class DateFormat extends AbstractFilter{
  public function filterValue($value){
    return date($this->ruleSet, strtotime($value));
  }
}
?>
