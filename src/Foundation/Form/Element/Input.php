<?php
namespace Foundation\Form\Element;

/**
 * An Abstract Input Element
 * @package foundation\form\element
 */
abstract class Input extends AbstractElement{
  /**
   * HTML element attributes
   * @var string
   */
  protected $type;
  protected $maxlength;
  protected $disabled;

  /**
   * Constructor
   */
  public function __construct($field){
    parent::__construct($field);
    $this->type = 'text';
    $this->attributes['disabled'] = 'disabled';
    $this->attributes['type'] = 'type';
    $this->attributes['value'] = 'value';
    $this->attributes['maxlength'] = 'maxlength';
  }
  
  /**
   * Set the disabled
   * @param string $disabled
   */
  public function setDisabled($disabled){
    $this->disabled = $disabled;
  }
  
  /**
   * Get the disabled
   * @return string $disabled
   */
  public function getDisabled(){
    return $this->disabled;
  }
  
  /**
   * Set the type
   * @todo verify type 
   * @param string $type
   */
  public function setType($type){
    $this->type = $type;
  }
  
  /**
   * Get the type
   * @return string $type
   */
  public function getType(){
    return $this->type;
  }
  
  /**
   * Set the maxlength
   * @param string $maxlength
   */
  public function setMaxlength($maxlength){
    $this->maxlength = $maxlength;
  }
  
  /**
   * Get the maxlength
   * @return string $maxlength
   */
  public function getMaxlength(){
    return $this->maxlength;
  }
    
}
?>