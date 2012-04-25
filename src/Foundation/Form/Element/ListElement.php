<?php
namespace Foundation\Form\Element;
/**
 * The abstract list class
 * List is a reserved word so use ListElement
 * Select, Radio, Checkbox all descend from here
 * @package foundation\form\element
 */
abstract class ListElement extends AbstractElement{
  protected $items;
  
  /**
   * Constructor
   * Add a list item validator
   * @param Form_Field $field
   */
  public function __construct($field){
    parent::__construct($field);
    $this->items = array();
    $validator = new \Foundation\Form\Validator\ChoiceInList($this, null);
    $this->addValidator($validator);
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
   */
  public function toArray(){
    $arr = parent::toArray();
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