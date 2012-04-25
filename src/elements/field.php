<?php
/**
 * Form Field element form control
 * @package foundation\form
 */
 ?><fieldset<?php $this->renderElement('attributes', array('object'=>$field)); ?>>
<?php if(!is_null($field->getLegend())){
  echo '<legend>' . $field->getLegend() . '</legend>';
}?>

<?php if(!is_null($field->getInstructions())){
  echo '<div class="instructions">' . $field->getInstructions() . '</div>';
}
?>

<?php foreach($field->getElements() as $element){
  $this->renderElement('element', array('element'=>$element));
}
?>
</fieldset>