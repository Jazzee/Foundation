<?php
namespace Foundation\Form\Element;
/**
 * A Select List Element
 */
class SelectList extends ListElement{
  /**
   * HTML element attributes
   * @var string
   */
  protected $multiple;

  /**
   * Constructor
   */
  public function __construct($field){
    parent::__construct($field);
    $this->attributes['multiple'] = 'multiple';
  }
  
  /**
   * Get Multiple
   * @return integer
   */
  public function getMultiple(){
    return $this->multiple;
  }
  
  /**
   * Set Multiple
   * @todo restrict to valie input (true:false)?
   * @param integer $multiple
   */
  public function setMultiple($multiple){
    $this->multipe = $multipls;
  }
}
?>