<?php
namespace Foundation\Form\Validator;

/**
 * Input must match a specific string.
 * User full for text boxes that require a user to type CONFIRM or DELETE, etc.
 *
 * @package Foundation\form\validator
 * @author  Jon Johnson <jon.johnson@ucsf.edu>
 * @license BSD http://jazzee.org/license.html
 */
class SpecificString extends AbstractValidator
{

    /**
     * Construct
     * Check the ruleSet
     *
     * @param \Foundation\Form\Element $e
     * @param mixed $ruleSet
     */
    public function __construct(\Foundation\Form\Element $e, $ruleSet)
    {
        if (\is_null($ruleSet)) {
            throw new \Foundation\Exception("The ruleset for SpeicifcString must be set.");
        }
        parent::__construct($e, $ruleSet);
    }

    public function validate(\Foundation\Form\Input $input)
    {
        if ($input->get($this->e->getName()) != $this->ruleSet) {
            $this->addError('You must type ' . $this->ruleSet . ' in this box.');

            return false;
        }

        return true;
    }
}
