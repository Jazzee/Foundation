<?php
namespace Foundation\Form\Element;
/**
 * A Checkbox Element
 * @package foundation\form\element
 */
class CheckboxList extends ListElement{
  /**
   * Constructor
   * Make $value and array
   */
  public function __construct(\Foundation\Form\Field $field){
    parent::__construct($field);
    $this->value = array();
  }
  
  /**
   * Set the value
   * Checkboxes use an array of values since multiple items can be checked
   * @param $value string|array
   */
  public function setValue($value){
    if(is_array($value)){
      foreach($value as $v){
        $this->value[] = $v;
      }
    } else {
      $this->value[] = $value;
    }
  }
  
}
?>