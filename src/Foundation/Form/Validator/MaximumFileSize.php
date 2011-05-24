<?php
namespace Foundation\Form\Validator;
/**
 * Check that the file size is below the maximum
 * Also set the FileInputElement::maxSize value
 * @author Jon Johnson <jon.johnson@ucsf.edu>
 * @license http://jazzee.org/license.txt
 * @package foundation
 * @subpackage forms
 */
class MaximumFileSize extends AbstractValidator{
  
  /**
   * Do our own constructor so we can set the maxfilesize and check the ruleSet
   * @param Form_Element $e the element we are validating
   * @param mixed $ruleSet rules set to use might be an array of rules or just a value to match
   */
  public function  __construct(Form_Element $e, $ruleSet){
    if(!\is_int($ruleSet)){
      throw new \Foundation\Exception("The ruleset for MaximumFileSize must be an integer");
    }
    parent::__construct($e,$ruleSet,$set);
    $this->e->setMaxSize($this->ruleSet);
  }
  
  public function validate(\Foundation\Form\Input $input){
    $fileArr = $input->get($this->e->getName());
    if($fileArr['size'] > $this->ruleSet){
      $this->addError('File is too large.  Your file is: ' . \convertBytesToString($fileArr['size'] - $this->ruleSet) . ' bigger than the maximum size of ' . \convertBytesToString($this->ruleSet, 0));
      return false;
    }
    return true;
  }
  
  public function preRender(){
    $format = $this->e->getForms() . ' Maximum file size: ' . convertBytesToString($this->ruleSet, 0) . '. ';
    $this->e->setFormat($format);
  }
}
?>
