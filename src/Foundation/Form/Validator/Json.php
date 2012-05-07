<?php
namespace Foundation\Form\Validator;
/**
 * Check to see if the input is valid json
 * 
 * @package Foundation\form\validator
 * @author  Jon Johnson <jon.johnson@ucsf.edu>
 * @license BSD http://jazzee.org/license.html
 */
class Json extends AbstractValidator
{
  public function validate(\Foundation\Form\Input $input)
  {
    if (null === json_decode($input->get($this->e->getName()))) {
      $error = '';
      switch (json_last_error()) {
        case JSON_ERROR_DEPTH:
            $error = 'Maximum stack depth exceeded';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            $error = 'Underflow or the modes mismatch';
        break;
        case JSON_ERROR_CTRL_CHAR:
            $error = 'Unexpected control character found';
        break;
        case JSON_ERROR_SYNTAX:
            $error = 'Syntax error, malformed JSON';
        break;
        case JSON_ERROR_UTF8:
            $error = 'Malformed UTF-8 characters, possibly incorrectly encoded';
        break;
        default:
            $error = 'Unknown error';
        break;
      }
      $this->addError('Error Decoding JSON: ' . $error);
      
      return false;
    }

    return true;
  }
}