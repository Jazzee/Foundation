<?php
namespace Foundation\Form\Validator;
/**
 * Check if a phone number is feasibly valid
 * 
 * @package Foundation\form\validator
 * @author  Jon Johnson <jon.johnson@ucsf.edu>
 * @license BSD http://jazzee.org/license.html
 */
class Phonenumber extends AbstractValidator
{
  public function validate(\Foundation\Form\Input $input)
  {
    //only keep the digits
    $number = preg_replace("#[^0-9]#", '', $input->get($this->e->getName()));
    $length = \strlen($number);
    if ($length < 10 OR $length > 13) {
      $this->addError('Invalid Phone Number');

      return false;
    }

    return true;
  }

  public function preRender()
  {
    if (is_null($this->e->getFormat())) {
      $this->e->setFormat('10 digit phone number.');
    }
  }
}