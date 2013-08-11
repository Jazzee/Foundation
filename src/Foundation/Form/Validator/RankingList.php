<?php
namespace Foundation\Form\Validator;

/**
 * Validation for RankingList Element
 * 
 * @package Foundation\form\validator
 * @author  Jon Johnson <jon.johnson@ucsf.edu>
 * @license BSD http://jazzee.org/license.html
 */
class RankingList extends AbstractValidator
{

    /**
     * Validate that the minimum answers have been submitted and that there are no duplicates
     * @param \Foundation\Form\Input $input
     */
    public function validate(\Foundation\Form\Input $input)
    {
        $existingChoices = array(); //we put each choice in here so we don't get duplicates
        $values = $input->get($this->e->getName());
        for ($i = 0; $i < $this->e->getTotalItems(); $i++) {
            $value = $values[$i];
            if (!empty($value)) {
                if (in_array($value, $existingChoices)) {
                    $this->e->addMessage('You have selected the same item twice');

                    return false;
                } else {
                    $existingChoices[] = $value;
                }
            }
        }
        if (count($existingChoices) < $this->e->getRequiredItems()) {
            $this->e->addMessage('You must rank at least ' . $this->e->getRequiredItems() . ' items');

            return false;
        }

        return true;
    }
}
