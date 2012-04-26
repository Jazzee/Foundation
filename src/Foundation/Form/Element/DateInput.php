<?php
namespace Foundation\Form\Element;
/**
 * A Date Element
 * 
 * @package Foundation\form\element
 */
class DateInput extends Input
{
  public function __construct($field)
  {
    parent::__construct($field);
    $validator = new \Foundation\Form\Validator\Date($this);
    $this->addValidator($validator);
  }
}