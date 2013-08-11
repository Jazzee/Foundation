<?php
namespace Foundation\Form\Validator;

/**
 * Check to see if the date entered is after the date in another element
 * 
 * @package Foundation\form\validator
 * @author  Jon Johnson <jon.johnson@ucsf.edu>
 * @license BSD http://jazzee.org/license.html
 */
class DateAfterElement extends AbstractValidator
{

    public function validate(\Foundation\Form\Input $input)
    {
        if (strtotime($input->get($this->e->getName())) <= strtotime($input->get($this->ruleSet))) {
            $this->addError(
                'Must be after date in ' . $this->e->getField()->getForm()->getElementByName($this->ruleSet)->getLabel()
            );

            return false;
        }

        return true;
    }
}
