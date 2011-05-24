<?php
namespace Foundation\Form\Validator;
/**
 * Check to see if the date entered is before the date in another element
 */
class DateBeforeElement extends AbstractValidator{
  public function validate(\Foundation\Form\Input $input){
    if(strtotime($input->get($this->e->getName())) >= strtotime($input->get($this->ruleSet))){
      $this->addError('Must be before date in ' . $this->e->getField()->getForm()->getElementByName($this->ruleSet)->getLabel());
      return false;
    }
    return true;
  }
}
?>
