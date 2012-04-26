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
  public function validate(FormInput $input)
  {
    if (!\preg_match($this->ruleSet, $input->get($this->e->getName()))) {
      $this->addError('Does not match requirements for this field');

      return false;
    }

    return true;
  }
}