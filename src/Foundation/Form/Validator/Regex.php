<?php
namespace Foundation\Form\Validator;
/**
 * Check to see if the element matches the regex
 * @author Jon Johnson <jon.johnson@ucsf.edu>
 * @license http://jazzee.org/license.txt
 * @package foundation
 * @subpackage forms
 */
class Regex extends AbstractValidator{
  public function validate(FormInput $input){
    if(!\preg_match($this->ruleSet, $input->get($this->e->getName()))){
      $this->addError('Does not match requirements for this field');
      return false;
    }
    return true;
  }
}
?>