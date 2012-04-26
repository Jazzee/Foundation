<?php
namespace Foundation\Form\Element;
/**
 * A Button Input Element
 * 
 * @package Foundation\form\element
 */
class ButtonInput extends Input
{
  /**
   * Dont allow the type to be overridden
   * @see Foundation\Form\Element.Input::setType()
   */
  public function setType($type)
  {
    if (!\in_array($type, array('submit','button','reset'))) {
      throw new \Foundation\Exception("A type of {$type} is not allowed.  Only 'button', 'submit' and 'reset' are allowed for this element");
    }
    parent::setType($type);
  }
}