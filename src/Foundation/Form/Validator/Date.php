<?php
namespace Foundation\Form\Validator;
/**
 * Check to see if the input is a date
 */
class Date extends AbstractValidator{
  public function validate(\Foundation\Form\Input $input){
    if(!strtotime($input->get($this->e->getName()))){
      $this->addError('Not a valid date');
      return false;
    }
    return true;
  }
}
?>
