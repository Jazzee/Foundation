<?php
namespace Foundation\Form\Validator;
/**
 * Check usr input to make sure it was an option in the list
 */
class ChoiceInList extends AbstractValidator{
  public function validate(\Foundation\Form\Input $input){
    //work with an array so checkboxes and multi select can be validated in the same way
    if(!\is_array($input->get($this->e->getName()))) $arr = array($input->get($this->e->getName()));
    else $arr = $input->get($this->e->getName());
    foreach($arr as $value){
      if(!$this->e->inList($value)){
        $this->addError('Your chose an invalid option');
        return false;
      }
    }
    return true;
  }
}
?>