<?php
/**
 * Form Field element form control;
 */
 ?><fieldset<?
foreach($field->getAttributes() as $memberName => $htmlName){
  $this->renderElement('attribute', array('name'=>$htmlName, 'value'=>$field->$memberName));
}
?>>
<?php if(!empty($field->getLegend())){
  echo '<legend>' . $field->getLegend() . '</legend>';
}?>

<?php if(!empty($field->getInstructions())){
  echo '<div class="instructions">' . $field->getInstructions() . '</div>';
}
?>

<?php foreach($field->getElements() as $element){
  $this->renderElement('element', array('element'=>$element));
}
?>
</fieldset>