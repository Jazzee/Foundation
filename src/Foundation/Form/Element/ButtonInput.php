<?php
namespace Foundation\Form\Element;
/**
 * A Button Input Element
 */
class ButtonInput extends Input{
  
  /**
   * Only return button for type
   * @see Foundation\Form\Element.Input::getType()
   */
  public function getType(){
    return 'button';
  }
  
  /**
   * Dont allow the type to be overridden
   * @see Foundation\Form\Element.Input::setType()
   */
  public function setType($type){
    if($type != 'button') throw new \Foundation\Exception("A type of {$type} is not allowed.  Only 'button' is allowed for this element");
  }
}
?>