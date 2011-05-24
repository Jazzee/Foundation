<?php
namespace Foundation\Form\Filter;
/**
 * Abstract Filter Class
 */
abstract class AbstractFilter implements \Foundation\Form\Filter{
  /**
   * Holds the element we are filtering
   * @var \Foundation\Form\Element
   */
  protected $e; 
  
  /**
   * Holds the rule set for processing
   * @var mixed
   */
  protected $ruleSet;
  
  /**
   * Constructor
   * @param \Foundation\Form\Element $e
   * @param mixed $ruleSet
   */
  public function  __construct(\Foundation\Form\Element $e, $ruleSet = null){
    $this->e = $e;
    $this->ruleSet = $ruleSet;
  }
  
  /**
   * @see Foundation\Form.Filter::filter()
   */
  abstract public function filter($value);
}
?>