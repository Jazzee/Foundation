<?php
namespace Foundation\Form\Filter;
/**
 * Make sure input is safe
 * Uses HTML Purifier
 * 
 * @package Foundation\form\filter
 */
class Safe extends AbstractFilter
{
  /**
   * Check to be sure we have the HTML purifier library
   * @param \Foundation\Form\Element $e
   * @param mixed $ruleSet 
   */
  public function  __construct(\Foundation\Form\Element $e, $ruleSet = null)
  {
    parent::__construct($e, $ruleSet);
    require_once 'HTMLPurifier.includes.php';
    require_once 'HTMLPurifier.autoload.php';
    if (!class_exists('HTMLPurifier')) {
      throw new \Foundation\Exception('HTML Purifier is required for the Safe filter and it is not included');
    }
  }

  public function filterValue($value)
  {
    $purifier = new \HTMLPurifier();

    return $purifier->purify($value);
  }
}