<?php
namespace Foundation\Form\Element;
/**
 * Element
 * Represents a single element on a form
 * @package Foundation\Form
 */
abstract class AbstractElement extends \Foundation\HTMLElement implements \Foundation\Form\Element{
  /**
   * HTMLElement attributes
   * @var string
   */
  protected $name;
  protected $value;
  protected $accesskey;
  protected $tabindex;
  
  /**
   * The label for this element
   * @var string 
   */
  protected $label;
  
  /**
   * The format string
   * @var string
   */
   protected $format;
   
   /**
    * The Instructions string
    * @var string
    */
   protected $instructions;
    
  /**
   * The default value
   * @var string
   */
  protected $defaultValue;
 
  /**
   * Is this element required
   */
  protected $required;
  
  /**
   * Holds a reference to the field which contains this element
   * @var Field
   */
  protected $field;
  
  /**
   * Holds all of the validators which must be run
   * @var array
   */
  protected $validators;
  
  /**
   * Holds all of the filters which must be run
   * @var array
   */
  protected $filters;
  
  /**
   * Any user level messages to output
   * @var array
   */
  protected $messages;
  
  /**
   * Constructor
   * @param \Foundation\Form\Field $field
   */
  public function __construct(\Foundation\Form\Field $field){
    $this->field = $field;
    parent::__construct();
    $this->required = false;
    $this->messages = array();
    
    $this->attributes['name'] = 'name';
    $this->attributes['value'] = 'value';
    $this->attributes['accesskey'] = 'accesskey';
    $this->attributes['tabindex'] = 'tabindex';
    
    $this->validators = array();
    $this->filters = array();
  }
  
  /**
   * Add a message to the element
   * @param string $text
   */
  public function addMessage($text){
    $this->messages[] = $text;
  }
  
  /**
   * Get Messages
   * @return array
   */
  public function getMessages(){
    return $this->messages;
  }
  
  /**
   * Add a validator
   * @param \Foundation\Form\Validator
   */
  public function addValidator(\Foundation\Form\Validator $validator){
    $this->validators[] = $validator;
  }
  
  /**
   * Add a filter
   * @param \Foundation\Form\Filter
   */
  public function addFilter(\Foundation\Form\Filter $filter){
    $this->filters[] = $filter;
  }

  /**
   * Run any validator preRender methods
   */
  public function preRender(){
    foreach($this->validators as $v) $v->preRender();
  }
    
  /**
   * Validate user input
   * @param FormInput $input
   */
  public function validate(\Foundation\Form\Input $input){
    $valid = true;
    //Null input gets run through the validateNull
    if(is_null($input->get($this->getName()))) {
      foreach($this->validators as $v) if(!$v->validateNull($input)) $valid = false;
    } else {
      foreach($this->validators as $v) if(!$v->validate($input)) $valid = false;
    }
    return $valid;
  }
  
  /**
   * Filter user input
   * @param FormInput $input
   */
  public function filter(\Foundation\Form\Input $input){
    if(is_null($input->get($this->getName()))) return null;
    foreach($this->filters as $f) $f->filter($input->get($this->getName()));
  }
  
  /**
   * Get the Field
   * @return \Foundation\Form\Field
   */
  public function getField(){
    return $this->field;
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
   * Set the name
   * @param string $name
   */
  public function setName($name){
    $this->name = $name;
  }
  
  /**
   * Get the name
   * @return string $name
   */
  public function getName(){
    return $this->name;
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
  
  /**
   * Set the defaultvalue
   * @param string $value
   */
  public function setDefaultValue($value){
    $this->defaultValue = $value;
  }
  
  /**
   * Get the default value
   * @return string $value
   */
  public function getDefaultValue(){
    return $this->defaultValue;
  }
  
  /**
   * Set the accesskey
   * @param string $accesskey
   */
  public function setAccesskey($accesskey){
    $this->accesskey = $accesskey;
  }
  
  /**
   * Get the accesskey
   * @return string $accesskey
   */
  public function getAccesskey(){
    return $this->accesskey;
  }
  
  /**
   * Set the tabindex
   * @param string $tabindex
   */
  public function setTabindex($tabindex){
    $this->tabindex = $tabindex;
  }
  
  /**
   * Get the tabindex
   * @return string $tabindex
   */
  public function getTabindex(){
    return $this->tabindex;
  }
    
}
?>