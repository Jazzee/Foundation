<?php
namespace Foundation\Form\Element;
/**
 * A Password Input Element
 * @package foundation\form\element
 */
class PasswordInput extends Input{
  
  /**
   * Only return hidden for type
   * @see Foundation\Form\Element.Input::getType()
   */
  public function getType(){
    return 'password';
  }
  
  /**
   * Dont allow the type to be overridden
   * @see Foundation\Form\Element.Input::setType()
   */
  public function setType($type){
    if($type != 'password') throw new \Foundation\Exception("A type of {$type} is not allowed.  Only 'password' is allowed for this element");
  }
}
?>