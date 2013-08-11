<?php
namespace Foundation\Form\Validator;

/**
 * Check to see if the date entered is before a specific date
 * 
 * @package Foundation\form\validator
 * @author  Jon Johnson <jon.johnson@ucsf.edu>
 * @license BSD http://jazzee.org/license.html
 */
class DateAfter extends AbstractValidator
{

    /**
     * Construct 
     * Check the ruleSet
     * @param \Foundation\Form\Element $e
     * @param mixed $ruleSet
     */
    public function __construct(\Foundation\Form\Element $e, $ruleSet)
    {
        if (!\strtotime($ruleSet)) {
            throw new \Foundation\Exception("The ruleset for DateAfter must be a valid PHP date string");
        }
        parent::__construct($e, $ruleSet);
    }

    public function validate(\Foundation\Form\Input $input)
    {
        if (strtotime($input->get($this->e->getName())) < strtotime($this->ruleSet)) {
            $this->addError('Date must be after ' . $this->ruleSet);

            return false;
        }

        return true;
    }
}
