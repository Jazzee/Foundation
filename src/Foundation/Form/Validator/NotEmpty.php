<?php
namespace Foundation\Form\Validator;

/**
 * Check to see if the value is empty
 * 
 * @package Foundation\form\validator
 * @author  Jon Johnson <jon.johnson@ucsf.edu>
 * @license BSD http://jazzee.org/license.html
 */
class NotEmpty extends AbstractValidator
{

    public function validateNull(\Foundation\Form\Input $input)
    {
        if (is_null($input->get($this->e->getName()))) {
            $this->addError('This field is required and you left it blank');

            return false;
        }

        return true;
    }

    public function preRender()
    {
        $this->e->addClass('required');
    }
}
