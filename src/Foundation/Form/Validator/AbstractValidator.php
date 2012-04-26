<?php
namespace Foundation\Form\Validator;
/**
 * Abstract class to define form element validators
 * 
 * @package Foundation\form\validator
 * @author  Jon Johnson <jon.johnson@ucsf.edu>
 * @license BSD http://jazzee.org/license.html
 */
abstract class AbstractValidator implements \Foundation\Form\Validator
{
  /**
   * Holds the element we are validating
   * @var \Foundation\From\Element
   */
  protected $e;

  /**
   * RuleSet to use might be an array of rules or just a value to match
   * @var mixed
   */
  protected $ruleSet;

  /**
   * Construct
   * @param \Foundation\Form\Element $e
   * @param mixed $ruleSet
   */
  public function  __construct(\Foundation\Form\Element $e, $ruleSet = false)
  {
    $this->e = $e;
    $this->ruleSet = $ruleSet;
  }

  /**
   * Add an error to the element
   * @param string $text error text
   */
  protected function addError($text)
  {
    $this->e->addMessage($text);
  }

  /**
   * Default to doing nothing
   * @see Foundation\Form.Validator::preRender()
   */
  public function preRender()
  {

  }

  /**
   * Validate Input
   */
  public function validate(\Foundation\Form\Input $input)
  {
    return true;
  }

  /**
   * Validate Null Input
   */
  public function validateNull(\Foundation\Form\Input $input)
  {
    return true;
  }
}