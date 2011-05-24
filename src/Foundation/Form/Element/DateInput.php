<?php
namespace Foundation\Form\Element;
/**
 * A Date Element
 */
class DateInput extends Input{
  /**
   * Make a \DateTime object out of the value
   * @param array $values
   */
  public function setValue($value){
    $this->value = \DateTime($value);
  }
}
?>