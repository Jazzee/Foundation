<?php
namespace Foundation\Form;
/**
 * Form elements are contained in fields
 * @package Foundation\Form
 */
class Field extends \Foundation\HTMLElement{
  /**
   * Any field level instructions
   * @var string
   */
  public $instructions;
  
  /**
   * The legend for the field
   * @var string
   */
  public $legend;
  
  /**
   * Holds the field elements
   * @var array
   */
  protected $elements;
  
  /**
   * Holds a reference to the form
   * @var \Foundation\Form
   */
  protected $form;
  
  /**
   * Constructor
   * @param \Foundation\Form $form the form that contains this field
   */
  public function __construct(\Foundation\Form $form){
    parent::__construct();
    $this->elements = array();
    $this->form = $form;
  }
  
  /**
   * Create a new form element
   * @param string $type what kind of element to create
   * @param string $name the unique name of the element
   * 
   */
  public function newElement($type, $name){
    $class = __NAMESPACE__ . "\\Element\\{$type}";
    if(!\Doctrine\Common\ClassLoader::classExists($class)){
      throw new \Foundation\Exception(__NAMESPACE__ . "\\{$class} does not exist");
    }
    $element = new $class($this);
    $element->setName($name);
    $this->addElement($element);
    return $element;
  }
  
  /**
   * Add an element
   * @param \Foundation\Form\Element
   */
  public function addElement(Element $element){
    if(array_key_exists($element->getName(), $this->form->getElements())) throw new \Foundation\Exception('An element with the name ' . $element->getName() . ' already exists in this form');
    $this->elements[$element->getName()] = $element;
  }
  
  /**
   * Get the Elements
   * @return array
   */
  public function getElements(){
    return $this->elements;
  }
  
  /**
   * Get the Form
   * @return \Foundation\Form
   */
  public function getForm(){
    return $this->form;
  }
}
?>