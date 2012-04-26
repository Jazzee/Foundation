<?php
namespace Foundation\Form\Validator;
/**
 * Check that a number is within a range
 * 
 * @package Foundation\form\validator
 * @author  Jon Johnson <jon.johnson@ucsf.edu>
 * @license BSD http://jazzee.org/license.html
 */
class NumberRange extends AbstractValidator
{
  /**
   * Construct 
   * Check the ruleSet
   * @param \Foundation\Form\Element $e
   * @param mixed $ruleSet
   */
  public function  __construct(\Foundation\Form\Element $e, $ruleSet)
  {
    if (!\is_array($ruleSet) OR !isset($ruleSet[0]) OR !isset($ruleSet[1])) {
      throw new \Foundation\Exception("The ruleset for NumberRange must be an array with two elements.");
    }
    parent::__construct($e, $ruleSet);
  }

  public function validate(\Foundation\Form\Input $input)
  {
    if ($input->get($this->e->getName()) < $this->ruleSet[0] OR $input->get($this->e->getName()) > $this->ruleSet[1]) {
      $this->addError("Value must be between {$this->ruleSet[0]} and {$this->ruleSet[1]}");

      return false;
    }

    return true;
  }

  public function preRender()
  {
    $this->e->format .=  "Between {$this->ruleSet[0]} and {$this->ruleSet[1]}.";
  }
}