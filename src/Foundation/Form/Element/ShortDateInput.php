<?php
namespace Foundation\Form\Element;

/**
 * A Short Date Element
 * Just the month and year
 * @package foundation\form\element
 */
class ShortDateInput extends Input{
  
  public function __construct($field){
    parent::__construct($field);
    $validator = new \Foundation\Form\Validator\Date($this);
    $this->addValidator($validator);
  }
  /**
   * Transform input into a valid date string
   * @see Foundation\Form\Element.AbstractElement::processInput()
   */
  public function processInput(\Foundation\Form\Input $input){
    if(!is_null($input->get($this->getName() . '-month')) and !is_null($input->get($this->getName() . '-year'))){
      //create a date using the first day of the month
      $input->set($this->getName(), $input->get($this->getName() . '-year') . '-' . $input->get($this->getName() . '-month') . '-1');
    } else if(!is_null($input->get($this->getName()))){
      $arr = explode(' ', $input->get($this->getName()));
      $input->set($this->getName(), "{$arr[1]}-{$arr[0]}-1");
    }
    return parent::processInput($input);
  }
}
?>