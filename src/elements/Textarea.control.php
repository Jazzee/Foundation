<?php
/**
 * Textarea element form control;
 */
?>
<textarea<?php
foreach($element->getAttributes() as $memberName => $htmlName){
  $this->renderElement('attribute', array('name'=>$htmlName, 'value'=>$element->$memberName));
}
?>><?php echo $element->value ?></textarea>