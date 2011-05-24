<?php
/**
 * RadioList element form control;
 */
 ?>
 <ol>
<?php foreach($element->getItems() as $id => $item){
  echo "<li><input type='radio'";
  if($element->getValue() == $item->getValue()){
    print ' checked="checked"';
  }
  foreach($item->getAttributes() as $memberName => $htmlName){
    $this->renderElement('attribute', array('name'=>$htmlName, 'value'=>$item->$memberName));
  }
  echo ' name="' . $element->getName() . '" id="' . $element->getName() . "_{$id}\" />" .
      '<label for="' . $element->getName() . "_{$id}\">" . $item->getLabel() . '</label>' .
      '</li>';
}
?>
</ol>