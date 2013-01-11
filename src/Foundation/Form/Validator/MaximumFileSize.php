<?php
namespace Foundation\Form\Validator;
/**
 * Check that the file size is below the maximum
 * Also set the FileInputElement::maxSize value
 * 
 * @package Foundation\form\validator
 * @author  Jon Johnson <jon.johnson@ucsf.edu>
 * @license BSD http://jazzee.org/license.html
 */
class MaximumFileSize extends AbstractValidator
{
  /**
   * Do our own constructor so we can set the maxfilesize and check the ruleSet
   * @param \Foundation\Form\Element $e the element we are validating
   * @param integer $sizeInBytes
   */
  public function __construct(\Foundation\Form\Element $element, $sizeInBytes)
  {
    if (!$integer = \intval($sizeInBytes)) {
      throw new \Foundation\Exception("The ruleset for MaximumFileSize must be an integer. Value: '{$sizeInBytes}'");
    }
    parent::__construct($element, $integer);
    $this->e->setMaxSize($this->ruleSet);
  }

  public function validate(\Foundation\Form\Input $input)
  {
    $fileArr = $input->get($this->e->getName());
    if ($fileArr['size'] > $this->ruleSet) {
      $this->addError('File is too large.  Your file is: ' . \Foundation\Utility::convertBytesToString($fileArr['size'] - $this->ruleSet) . ' bigger than the maximum size of ' . \Foundation\Utility::convertBytesToString($this->ruleSet, 0));

      return false;
    }

    return true;
  }

  public function preRender()
  {
    if (is_null($this->e->getFormat())) {
      $this->e->setFormat('Maximum file size: ' . \Foundation\Utility::convertBytesToString($this->ruleSet, 2) . '.');
    }
  }
}