<?php
namespace Foundation\Form\Validator;
/**
 * Scan the input for viruses
 * Uses the php-clamav http://php-clamav.sourceforge.net/
 * Which depends on clamav
 * @author Jon Johnson <jon.johnson@ucsf.edu>
 * @license http://jazzee.org/license.txt
 * @package foundation
 * @subpackage forms
 */
class Virusscan extends AbstractValidator{
  
  /**
   * Do our own constructor so we can check for the php-clamav library
   * @param \Foundation\Form\Element $e the element we are validating
   * @param integer $sizeInBytes
   */
  public function  __construct(\Foundation\Form\Element $element){
    if(!extension_loaded('clamav') or !function_exists('cl_scanfile')){
      throw new \Foundation\Exception("Virusscan validator requires the php-clamav extension.");
    }
    parent::__construct($element);
  }
  
  public function validate(\Foundation\Form\Input $input){
    $fileArr = $input->get($this->e->getName());
    $retcode = cl_scanfile($fileArr['tmp_name'], $virusname);
    if($retcode == CL_VIRUS) {
      unlink($fileArr['tmp_name']);
      $this->addError('Virus Detection Error: ' . cl_pretcode($retcode) . " {$virusname}.");
      return false;
    }
    return true;
  }
}
?>
