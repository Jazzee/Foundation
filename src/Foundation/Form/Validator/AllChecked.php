<?php
namespace Foundation\Form\Validator;

/**
 * Force the user to check every checkbox
 * Use full for aggreements and confirmations
 *
 * @package Foundation\form\validator
 * @author  Jon Johnson <jon.johnson@ucsf.edu>
 * @license BSD http://jazzee.org/license.html
 */
class AllChecked extends AbstractValidator
{

    public function validate(\Foundation\Form\Input $input)
    {
        //work with an array so checkboxes and multi select can be validated in the same way
        if (!\is_array($input->get($this->e->getName()))) {
            $checked = array($input->get($this->e->getName()));
        } else {
            $checked = $input->get($this->e->getName());
        }
        foreach ($this->e->getItems() as $item) {
            if (!in_array($item->getValue(), $checked)) {
                $this->addError('You did not check ' . $item->getLabel());
            }
        }

        return true;
    }
}
