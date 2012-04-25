<?php
namespace Foundation\Form\Element;

/**
 * Textarea Element
 * @package foundation\form\element
 */
class Textarea extends AbstractElement{
  /**
   * HTML element attributes
   * @var string
   */
  protected $cols;
  protected $rows;
  protected $disabled;
  protected $readonly;

  /**
   * Constructor
   */
  public function __construct($field){
    parent::__construct($field);
    $this->attributes['cols'] = 'cols';
    $this->attributes['rows'] = 'rows';
    $this->attributes['disabled'] = 'disabled';
    $this->attributes['readonly'] = 'readonly';
  }
  
  /**
   * Set the cols
   * @param string $cols
   */
  public function setCols($cols){
    $this->cols = $cols;
  }
  
  /**
   * Get the cols
   * @return string $cols
   */
  public function getCols(){
    return $this->cols;
  }
  
  /**
   * Set the rows
   * @param string $rows
   */
  public function setRows($rows){
    $this->rows = $rows;
  }
  
  /**
   * Get the rows
   * @return string $rows
   */
  public function getRows(){
    return $this->rows;
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
   * Set the readonly
   * @param string $readonly
   */
  public function setReadonly($readonly){
    $this->readonly = $readonly;
  }
  
  /**
   * Get the readonly
   * @return string $readonly
   */
  public function getReadonly(){
    return $this->readonly;
  }
    
}
?>