<?php
namespace Foundation\Form\Element;

/**
 * A Short Date Element
 * Just the month and year
 */
class ShortDateInput extends Input{
    
  /**
   * Transform ShortDate input into a valid date
   * @see Form_Element::validate()
   */
  public function validate(FormInput $input){
    if(!empty($input->get($this->getName() . '-month')) and !empty($input->get($this->getName() . '-year'))){
      //create a date using the first day of the month
      $input->set($this->getName(), $input->get($this->getName() . '-month') . '-' . $input->get($this->getName() . '-year') . '-1');
    } else if(!is_null($input->get($this->getName()))){
      $arr = explode(' ', $input->get($this->getName));
      $input->set($this->getName(), "{$arr[0]} 1 {$arr[1]}");
    }
    return parent::validate($input);
  }
}
?>