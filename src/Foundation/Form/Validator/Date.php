<?php
namespace Foundation\Form\Validator;
/**
 * Check to see if the input is a date
 * 
 * @package Foundation\form\validator
 * @author  Jon Johnson <jon.johnson@ucsf.edu>
 * @license BSD http://jazzee.org/license.html
 */
class Date extends AbstractValidator
{
  public function validate(\Foundation\Form\Input $input)
  {
    if (!strtotime($input->get($this->e->getName()))) {
      $this->addError('Not a valid date');

      return false;
    }

    return true;
  }
}