<?php
namespace Foundation\Form\Validator;
namespace Foundation\Form\Validator;
/**
 * Validation for RankingList Element
 */
class RankingList extends AbstractValidator{

 /**
   * Validate that the minimum answers have been submitted and that there are no duplicates
   * @todo: this isn't working
   * @param \Foundation\Form\Input $input
   */
  public function validate(\Foundation\Form\Input $input){
    $this->addError('Not checking here - need to fix');
    return false;
    $values = array();
    for($i = 0; $i < $this->rankItems; $i++){
      $name = $this->e->getName();
      $value = $input->get($this->e->getName()); 
      if(array_key_exists($i, $value)){
        if(in_array($value, $values)){
          $this->addMessage('You have selected the same item twice');
          return false;
        } else {
          $values[] = $value;
        }
      }
    }
    if(count($values) < $this->minimumItems){
      $this->addMessage('You must rank at least ' . (int)$this->minimumItems . ' items');
      return false;
    }
    return parent::validate($input);
  }
}