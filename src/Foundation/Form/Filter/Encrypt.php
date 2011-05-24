<?php
namespace Foundation\Form\Filter;
/**
 * Encrypt the value using the PKI class which is passed as the ruleSet
 */
class Encrypt extends AbstractFilter{
  
  /**
   * Constructor
   * Ensure a valid PKI object is passed
   * @param \Foundation\Form\Element $e
   * @param \Foundation\PKI $pki
   */
  public function  __construct(\Foundation\Form\Element $e,  $pki){
    if(!$pki instanceof \Foundation\PKI){
      throw new \Foundation\Exception('Invalid PKI class passed to Encrypt filter');
    }
    parent::__construct($e, $pki);
  }
  
  public function filterValue($value){
    return $this->ruleSet->encrypt($value);
  }
}
?>
