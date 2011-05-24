<?php
namespace Foundation\Form\Validator;
/**
 * Check to see if the value is a number
 */
class Integer extends AbstractValidator{
  public function validate(\Foundation\Form\Input $input){
    if(!\filter_var($input->get($this->e->getName()), FILTER_VALIDATE_INT)){
      $this->addError('An integer is required for this field');
      return false;
    }
    return true;
  }
}
?>
