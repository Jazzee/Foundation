<?php
namespace Foundation\Form\Validator;

/**
 * Ensure the uploaded PDF is not encrypted
 *
 * @package Foundation\form\validator
 * @author  Jon Johnson <jon.johnson@ucsf.edu>
 * @license BSD http://jazzee.org/license.html
 */
class PDFNotEncrypted extends AbstractValidator
{

  public function validate(\Foundation\Form\Input $input)
  {

    $fileArr = $input->get($this->e->getName());
    $contents = file_get_contents($fileArr['tmp_name']);
    if (strpos($contents, '/Encrypt')) {
      $this->addError("This PDF file appears to be password protected or encrypted and cannot be accepted by our system.");
      return false;
    }
    return true;
  }

}