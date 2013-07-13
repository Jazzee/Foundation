<?php
namespace Foundation\Form\Validator;
/**
 * Check to see if the input is a valid regular expression
 * 
 * @package Foundation\form\validator
 * @author  Jon Johnson <jon.johnson@ucsf.edu>
 * @license BSD http://jazzee.org/license.html
 */
class IsRegex extends AbstractValidator
{
  public function validate(\Foundation\Form\Input $input)
  {
    if (@preg_match($input->get($this->e->getName()), null) === false) {
      $this->addError('Not a valid regular expression');

      return false;
    }

    return true;
  }
}