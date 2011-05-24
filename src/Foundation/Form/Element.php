<?php
namespace Foundation\Form;
/**
 * Element interface
 */
interface Element{
  
  /**
   * Add a message to the element
   * @param string $text
   */
  function addMessage($text);
  
  /**
   * Get Messages
   * @return array
   */
  function getMessages();
  
  /**
   * Add a validator
   * @param \Foundation\Form\Validator
   */
  function addValidator(Validator $validator);
  
  /**
   * Add a filter
   * @param \Foundation\Form\Filter
   */
  function addFilter(Filter $filter);

  /**
   * Run any validator preRender methods
   */
  public function preRender();
    
  /**
   * Validate user input
   * @param FormInput $input
   */
  function validate(Input $input);
  
  /**
   * Filter user input
   * @param FormInput $input
   */
  function filter(Input $input);
  
  /**
   * Set the name
   * @param string $name
   */
  function setName($name);
  
  /**
   * Get the name
   * @return string $name
   */
  function getName();
  
  /**
   * Set the value
   * @param string $value
   */
  function setValue($value);
  
  /**
   * Get the value
   * @return string $value
   */
  function getValue();
  
  /**
   * Set the defaultvalue
   * @param string $value
   */
  function setDefaultValue($value);
  
  /**
   * Get the default value
   * @return string $value
   */
  function getDefaultValue();
  
  /**
   * Set the accesskey
   * @param string $accesskey
   */
  function setAccesskey($accesskey);
  
  /**
   * Get the accesskey
   * @return string $accesskey
   */
  function getAccesskey();
  
  /**
   * Set the tabindex
   * @param string $tabindex
   */
  function setTabindex($tabindex);
  
  /**
   * Get the tabindex
   * @return string $tabindex
   */
  function getTabindex();
    
}
?>