<?php
/**
 * FileInput element form control;
 */
 ?>
 <!-- MAX_FILE_SIZE -->
 <input type="hidden" name="MAX_FILE_SIZE" value="<?php print $element->getMaxSize() ?>" />
 
 <input<?php
foreach($element->getAttributes() as $memberName => $htmlName){
  $this->renderElement('attribute', array('name'=>$htmlName, 'value'=>$element->$memberName));
}
?>/>