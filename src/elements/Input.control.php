<?php
/**
 * Input element form control;
 */
 ?>
 <input<?php
foreach($element->getAttributes() as $memberName => $htmlName){
  $this->renderElement('attribute', array('name'=>$htmlName, 'value'=>$element->$memberName));
}
?>/>