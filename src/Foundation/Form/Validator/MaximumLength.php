<?php
namespace Foundation\Form\Validator;
/**
 * Check that the input string is below the max */
class MaximumLength extends AbstractValidator{
  /**
   * Construct 
   * Check the ruleSet
   * @param \Foundation\Form\Element $e
   * @param mixed $ruleSet
   */
  public function  __construct(\Foundation\Form\Element $e, $ruleSet){
    if(!\is_int($ruleSet)){
      throw new \Foundation\Exception("The ruleset for MaximumLength must be an integer");
    }
    parent::__construct($e, $ruleSet);
  }
  
  public function validate(\Foundation\Form\Input $input){
    if(strlen($input->get($this->e->getName())) > $this->ruleSet){
      $this->addError('Input is too large.  Your input is: ' . (strlen($input->get($this->e->getName())) - $this->ruleSet) . ' characters bigger than the maximum size of ' . $this->ruleSet);
      return false;
    }
    return true;
  }
  
  public function preRender(){
    $format = $this->e->getFormat() . " Maximum length: {$this->ruleSet} characters. ";
    $this->e->setFormat($format);
  }
}
?>
