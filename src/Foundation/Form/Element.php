<?php
namespace Foundation\Form;

/**
 * Element interface
 * 
 * @package Foundation\form\element
 */
interface Element
{

    /**
     * Add a message to the element
     * @param string $text
     */
    public function addMessage($text);

    /**
     * Get Messages
     * @return array
     */
    public function getMessages();

    /**
     * Add a validator
     * @param \Foundation\Form\Validator
     */
    public function addValidator(Validator $validator);

    /**
     * Prepend a validator to any onthe stack already
     * @param \Foundation\Form\Validator
     */
    public function prependValidator(Validator $validator);

    /**
     * Add a filter
     * @param \Foundation\Form\Filter
     */
    public function addFilter(Filter $filter);

    /**
     * Prepend a filter to any other ones
     * @param \Foundation\Form\Filter
     */
    public function prependFilter(Filter $filter);

    /**
     * Run any validator preRender methods
     */
    public function preRender();

    /**
     * Process Input
     * 
     * @param \Foundation\Form\Input $input
     * @return boolean
     */
    public function processInput(\Foundation\Form\Input $input);

    /**
     * Set the name
     * @param string $name
     */
    public function setName($name);

    /**
     * Get the name
     * @return string $name
     */
    public function getName();

    /**
     * Set the value
     * @param string $value
     */
    public function setValue($value);

    /**
     * Get the value
     * @return string $value
     */
    public function getValue();

    /**
     * Set the defaultvalue
     * @param string $value
     */
    public function setDefaultValue($value);

    /**
     * Get the default value
     * @return string $value
     */
    public function getDefaultValue();

    /**
     * Set the accesskey
     * @param string $accesskey
     */
    public function setAccesskey($accesskey);

    /**
     * Get the accesskey
     * @return string $accesskey
     */
    public function getAccesskey();

    /**
     * Set the tabindex
     * @param string $tabindex
     */
    public function setTabindex($tabindex);

    /**
     * Get the tabindex
     * @return string $tabindex
     */
    public function getTabindex();

    /**
     * Set the instructions
     * @param string $instructions
     */
    public function setInstructions($instructions);

    /**
     * Get the instructions
     * @return string $instructions
     */
    public function getInstructions();

    /**
     * Set the format
     * @param string $format
     */
    public function setFormat($format);

    /**
     * Get the legend
     * @return string $legend
     */
    public function getFormat();

    /**
     * Convert the element to an array
     * @return array
     */
    public function toArray();
}
