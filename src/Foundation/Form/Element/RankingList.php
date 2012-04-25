<?php
namespace Foundation\Form\Element;

/**
 * RankingList element
 * @package foundation\form\element
 */
class RankingList extends AbstractElement{
  /**
   * @var array the items in each list
   */
  protected $items;
  
  /**
   * The Number of items to rank
   * @var integer
   */
  protected $totalItems;
  
  /**
   * The minimum required items which must be ranked
   * @var integer
   */
  protected $requiredItems;
  
  /**
   * Constructor
   * Make $value an array
   */
  public function __construct(\Foundation\Form\Field $field){
    parent::__construct($field);
    $this->items = array();
    $this->value = array();
    $this->totalItems = false;
    $this->requiredItems = false;
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
    if(!$this->totalItems OR !$this->requiredItems){
      throw new \Foundation\Exception('RankingListElement requires total items and required items to be set before it is rendered.');
    }
    parent::preRender();
  }
  
  /**
   * Set the total items
   * 
   * @param integer $totalItems
   */
  public function setTotalItems($totalItems){
    $this->totalItems = $totalItems;
  }
  
  /**
   * Set the required items
   * 
   * @param integer $requiredItemd
   */
  public function setrequiredItems($requiredItems){
    $this->requiredItems = $requiredItems;
  }
  
  /**
   * Get the total items
   * 
   * @return integer
   */
  public function getTotalItems(){
    return $this->totalItems;
  }
  
  /**
   * Get the required items
   * 
   * @return integer
   */
  public function getRequiredItems(){
    return $this->requiredItems;
  }
  
  /**
   * New item factory
   * @param string $label
   * @param mixed $value
   */
  public function newItem($value, $label){
    $item = new ListItem;
    $item->setLabel($label);
    $item->setValue($value);
    $this->addItem($item);
    return $item;
  }
  
  /**
   * Add an item to the list
   * @param \Foundation\Form\Element\ListItem $listItem
   */
  public function addItem($listItem){
    if(array_key_exists($listItem->getValue(), $this->items)) throw new \Foundation\Exception($listItem->getValue() . ' is already an item in this list');
    $this->items[$listItem->getValue()] = $listItem;
  }
  
  /**
   * Get the items
   * @return array
   */
  public function getItems(){
    return $this->items;
  }
  
  /**
   * Get the label for an item by value
   * @param string $value
   * @return string
   */
  public function getLabelForValue($value){
    if(array_key_exists($value, $this->items)){
      return $this->items[$value]->getLabel();
    }
    return false;
  }
  
  /**
   * Check item by value
   * @param string $value
   * @return string
   */
  public function inList($value){
    return array_key_exists($value, $this->items);
  }
  
  /**
   * Add list items to the array
   * Add totle and required to array
   */
  public function toArray(){
    $arr = parent::toArray();
    $arr['requiredItems'] = $this->requiredItems;
    $arr['totalItems'] = $this->totalItems;
    $arr['items'] = array();
    foreach($this->items as $i){
      $arr['items'][] = array(
        'value' => $i->getValue(),
        'label' => $i->getLabel()
      );
    }
    return $arr;
  }
  
}
?>