<?php
namespace Foundation\Form\Validator;
/**
 * Check if a phone number is feasibly valid
 */
class Phonenumber extends AbstractValidator{
  
  /**
   * 
   * @see jazzee/lib/foundation/src/Foundation/Form/Validator/Foundation\Form\Validator.AbstractValidator::validate()
   */
  public function validate(\Foundation\Form\Input $input){
    //only keep the digits
    $number = preg_replace("#[^0-9]#",'',$input->get($this->e->getName()));
    $length = \strlen($number);
    if($length < 10 OR $length > 13){
      $this->addError('Invalid Phone Number');
      return false;
    }
    return true;
  }
}
?>
