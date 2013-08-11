<?php
namespace Foundation\Form\Validator;

/**
 * Check to see if the element matches the regex
 * 
 * @package Foundation\form\validator
 * @author  Jon Johnson <jon.johnson@ucsf.edu>
 * @license BSD http://jazzee.org/license.html
 */
class Regex extends AbstractValidator
{

    protected $errorMessage = 'Does not match requirements for this field';

    public function validate(\Foundation\Form\Input $input)
    {
        if (!\preg_match($this->ruleSet, $input->get($this->e->getName()))) {
            $this->addError($this->errorMessage);

            return false;
        }

        return true;
    }

    /**
     * Set the custom regex error message
     * @param string $errorMessage
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }
}
