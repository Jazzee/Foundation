<?php
namespace Foundation\Form\Element;

/**
 * A single item for an element list
 * Radio, Checkbox, and select lists use these
 * 
 * @package Foundation\form\element
 */
class ListItem extends \Foundation\HTMLElement
{

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

    /**
     * An array of metadata attributes for describing the list item
     * @var array
     */
    protected $metadata;

    public function __construct()
    {
        parent::__construct();
        $this->attributes['disabled'] = 'disabled';
        $this->attributes['value'] = 'value';
        $this->attributes['metadataString'] = 'data-metadata';
        $this->clearMetadata();
    }

    /**
     * set the label
     * @param string $name
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * Get the label
     * @return string $label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the disabled
     * @param string $disabled
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;
    }

    /**
     * Get the disabled
     * @return string $disabled
     */
    public function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * Set the value
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get the value
     * @return string $value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Add some metadata
     * @param string $data
     */
    public function addMetadata($data)
    {
        $this->metadata[] = $data;
    }

    /**
     * Get the metadata as a string
     * @return string
     */
    public function getMetadataString()
    {
        return implode(' ', $this->metadata);
    }

    public function clearMetadata()
    {
        $this->metadata = array();
    }
}
