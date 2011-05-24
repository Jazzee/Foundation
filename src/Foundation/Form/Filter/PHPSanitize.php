<?php
namespace Foundation\Form\Filter;
/**
 * Apply one of PHPs built in input sanitizers
 */
class PHPSanitize extends AbstractFilter{
  public function filterValue($value){
    $options = null;
    if(is_int($this->ruleSet)){
      $type = $this->ruleSet;
    } else if(is_array($this->ruleSet)){
      $type = array_shift($this->ruleSet);
      if(count($this->ruleSet) > 0){
        $options = array_shift($this->ruleSet);
      }
    } else {
      throw new \Foundation\Error("Invalid ruleset provided to PHPSanitize Filter");
    }
    return \filter_var($value, $type, $options);
  }
}
?>
