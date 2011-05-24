<?php
namespace Foundation\Form\Validator;
/**
 * Check that the input string is at least the minimum length
 */
class MinimumLength extends AbstractValidator{
  /**
   * Construct 
   * Check the ruleSet
   * @param \Foundation\Form\Element $e
   * @param mixed $ruleSet
   */
  public function  __construct(\Foundation\Form\Element $e, $ruleSet){
    if(!\is_int($ruleSet)){
      throw new \Foundation\Exception("The ruleset for MinimumLength must be an integer");
    }
    parent::__construct($e, $ruleSet);
  }
  
  public function validate(\Foundation\Form\Input $input){
    if(strlen($input->get($this->e->getName())) < $this->ruleSet){
      $this->addError('Input is too small.  Your input is: ' . ($this->ruleSet - strlen($input->get($this->e->getName()))) . ' characters smaller than the minimum size of ' . $this->ruleSet);
      return false;
    }
    return true;
  }
  
  public function preRender(){
    $format = $this->e->getFormat() . " Minimum length: {$this->ruleSet} characters. ";
    $this->e->setFormat($format);
  }
}
?>
