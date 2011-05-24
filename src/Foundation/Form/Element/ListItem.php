<?php 
namespace Foundation\Form\Element;
/**
 * A single item for an element list
 * Radio, Checkbox, and select lists use these
 */
class ListItem extends \Foundation\HTMLElement {
  /**
   * HTML element attributes
   * @var string
   */
  protected $disabled;
  protected $value;
  
  /**
   * The label for this option
   * @var string
   */
  protected $label;
  
  public function __construct(){
    parent::__construct();
    $this->attributes['disabled'] = 'disabled';
    $this->attributes['value'] = 'value';
    
  }
  
  /**
   * set the label
   * @param string $name
   */
  public function setLabel($label){
    $this->label = $label;
  }
  
  /**
   * Get the label
   * @return string $label
   */
  public function getLabel(){
    return $this->label;
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
   * Set the value
   * @param string $value
   */
  public function setValue($value){
    $this->value = $value;
  }
  
  /**
   * Get the value
   * @return string $value
   */
  public function getValue(){
    return $this->value;
  }
}
?>