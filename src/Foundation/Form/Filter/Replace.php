<?php
namespace Foundation\Form\Filter;
/**
 * Replace elements of a string
 * 
 * @package Foundation\form\filter
 */
class Replace extends AbstractFilter
{
  public function filterValue($value)
  {
    return \str_replace($this->ruleSet['pattern'], $this->ruleSet['replace'], $value);
  }
}