<?php
/**
 * Checkbox element form control;
 */
 ?>
 <ol>
<?php foreach($element->getItems() as $id => $item){
  echo "<li><input type='checkbox'";
  if(in_array($element->inList($item->getValue()))){
    print ' checked="checked"';
  }
  $this->renderElement('attributes', array('object'=>$link));
  echo ' name="' . $element->getName() . '[]" id="' . $element->getName() . '_{$id}" />' .
      '<label for="' . $element->getName() . '_{$id}">' . $item->getLabel() . '</label>' .
      '</li>';
}

?>
</ol>