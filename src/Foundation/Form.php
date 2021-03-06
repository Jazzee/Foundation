<?php
namespace Foundation;

/**
 * Create Dynamic Forms
 * 
 * @package Foundation\form
 */
class Form extends HTMLElement
{

    /**
     * HTML element attributes
     * @var string
     */
    protected $action;
    protected $accept_charset;
    protected $enctype;
    protected $method;
    protected $name;

    /**
     * The form fields
     * @var array 
     */
    protected $fields;

    /**
     * The hidden field
     * @var Form_Field
     */
    protected $hidden;

    /**
     * The button field
     * @var Form_Field
     */
    protected $buttons;

    /**
     * Anti CSRF Token
     * @var string
     */
    protected $csrfToken;

    /**
     * Form wide error messages
     * @var array 
     */
    protected $errorMessages;

    /**
     * Constructor
     * Create the special hidden and button fields
     */
    public function __construct()
    {
        parent::__construct();
        $this->setAcceptCharset('UTF-8');
        $this->setMethod('post');
        $this->fields = array();
        $this->attributes['action'] = 'action';
        $this->attributes['enctype'] = 'enctype';
        $this->attributes['method'] = 'method';
        $this->attributes['acceptCharset'] = 'accept-charset';
        $this->attributes['name'] = 'name';

        $this->hidden = new Form\Field($this);
        $this->hidden->addClass('hidden');
        $this->buttons = new Form\Field($this);
        $this->buttons->addClass('buttons');
        $this->errorMessages = array();
    }

    /**
     * Create a new form field
     * @param array $attributes
     * @return \Foundation\Form\Field
     */
    public function newField()
    {
        $field = new Form\Field($this);
        $this->addField($field);

        return $field;
    }

    /**
     * Add a Field
     * @param \Foundation\Form\Field
     */
    public function addField(Form\Field $field)
    {
        $this->fields[] = $field;
    }

    /**
     * Get the fields
     * @return array
     */
    public function getFields()
    {
        $fields = $this->fields;
        $fields[] = $this->buttons;
        $fields[] = $this->hidden;

        return $fields;
    }

    /**
     * Create hidden element
     * @param string $id 
     * @param string $value
     */
    public function newHiddenElement($name, $value)
    {
        $e = $this->hidden->newElement('HiddenInput', $name);
        $e->setValue($value);
        $e->setDefaultValue($value);

        return $e;
    }

    /**
     * Create button element
     * @param string $type
     * @param string $title
     */
    public function newButton($type, $value)
    {
        $e = $this->buttons->newElement('ButtonInput', $type);
        $e->setValue($value);
        $e->setDefaultValue($value);
        $e->setType($type);

        return $e;
    }

    /**
     * Set the anti CSRF Token
     * @param string $token
     */
    public function setCSRFToken($token)
    {
        $this->csrfToken = $token;
        if ($element = $this->getElementByName('antiCSRFToken')) {
            $element->setValue($token);
        } else {
            $this->newHiddenElement('antiCSRFToken', $token);
        }
    }

    /**
     * Add an error message
     * @param string $message 
     */
    public function addErrorMessage($message)
    {
        $this->errorMessages[] = $message;
    }

    /**
     * Add an error message
     * @return array
     */
    public function getErrorMessages()
    {
        return $this->errorMessages;
    }

    /**
     * Process form input
     * If there is no input or a validation error then return false
     * @param array $arr
     * @return true|false if errors
     */
    public function processInput($arr)
    {
        if (empty($arr)) {
            return false;
        }
        $error = false;
        $input = new Form\Input($arr);
        if ($this->csrfToken and $input->get('antiCSRFToken') != $this->csrfToken) {
            $message = 'For your security your input was not accepted because your '
                    . 'identity could not be verified.  Your session may have expired, '
                    . 'or there may have been a problem with our connection.  '
                    . 'You may try submitting this form again or refreshing the page.';
            $this->addErrorMessage($message);
            $error = true;
        }

        foreach ($this->getElements() as $element) {
            if (!$element->processInput($input)) {
                $error = true;
            }
        }
        if (!$error) {
            return $input;
        }

        return false;
    }

    /**
     * Get All the elements in all the fields
     * @return Element array
     */
    public function getElements()
    {
        $elements = array();
        foreach ($this->getFields() as $field) {
            $elements = array_merge($elements, $field->getElements());
        }

        return $elements;
    }

    /**
     * Get element by name
     * @todo this is proably not an efficient way of going about this - maybe sort them first?
     * @param string $name
     * @return \Foundation\Form\Element
     */
    public function getElementByName($name)
    {
        $elements = $this->getElements();
        foreach ($elements as $element) {
            if ($element->getName() == $name) {
                return $element;
            }
        }

        return false;
    }

    /**
     * Set Form_Element::value to the user input
     * @param Input $input
     */
    public function setElementValues(Form\Input $input)
    {
        foreach ($this->getElements() as $element) {
            $element->setValue($input->get($element->getName()));
        }
    }

    /**
     * Set all the elements to their default value
     */
    public function applyDefaultValues()
    {
        foreach ($this->getElements() as $element) {
            $element->setValue($element->getDefaultValue());
        }
    }

    /**
     * Restet/Clear the form object
     * Usefull when the object needs to stick around, but the form is different
     */
    public function reset()
    {
        $this->hidden = new Form\Field($this);
        $this->hidden->class = 'hidden';
        $this->buttons = new Form\Field($this);
        $this->buttons->class = 'buttons';
        $this->fields = array();
    }

    /**
     * Set the action
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * Get the action
     * @return string $action
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set the enctype
     * @param string $enctype
     */
    public function setEnctype($enctype)
    {
        $this->enctype = $enctype;
    }

    /**
     * Get the enctype
     * @return string $enctype
     */
    public function getEnctype()
    {
        return $this->enctype;
    }

    /**
     * Set the method
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * Get the method
     * @return string $method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set the acceptCharset
     * @param string $acceptCharset
     */
    public function setAcceptCharset($acceptCharset)
    {
        $this->acceptCharset = $acceptCharset;
    }

    /**
     * Get the acceptCharset
     * @return string $acceptCharset
     */
    public function getAcceptCharset()
    {
        return $this->acceptCharset;
    }

    /**
     * Set the name
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the name
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }
}
