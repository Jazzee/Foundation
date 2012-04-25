<?php
namespace Foundation\Form\Validator;
/**
 * Check to see if the value is the same as another value
 * @package foundation\form\validator
 */
class SameAs extends AbstractValidator{
  public function validate(\Foundation\Form\Input $input){
    if($input->get($this->e->getName()) != $input->get($this->ruleSet)){
      $this->addError('Does not match ' . $this->e->getField()->getForm()->getElementByname($this->ruleSet)->getLabel());
      return false;
    }
    return true;
  }
}
?>