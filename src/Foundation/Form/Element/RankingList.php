<?php
namespace Foundation\Form\Element;

/**
 * RankingList element
 */
class RankingList extends ListElement{
  /**
   * The Number of items to rank
   * @var integer
   */
  protected $rankItems;
  
  /**
   * The minimum required items which must be ranked
   * @var integer
   */
  protected $minimumItems;
  
  /**
   * Constructor
   * Make $value an array
   */
  public function __construct(\Foundation\Form\Field $field){
    parent::__construct($field);
    $this->value = array();
    $this->rankItems = false;
    $this->minimumItems = false;
    $validator = new \Foundation\Form\Validator\RankingList($this,null);
    $this->addValidator($validator);
  }
  
  /**
   * Set the value
   * Rankinglist use an array of values since multiple items can be selected
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
  
  /**
   * Check to be sure items and minimumItems are set then run the parent method
   */
  public function preRender(){
    if(!$this->rankItems OR !$this->minimumItems){
      throw new \Foundation\Exception('RankingListElement requires items and minimumItems to be set before it is rendered.');
    }
    parent::preRender();
  }
    
  
  
}
?>