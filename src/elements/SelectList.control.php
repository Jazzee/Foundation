<?php
/**
 * Select element form control;
 */
 ?>
 <select <?php
foreach($element->getAttributes() as $memberName => $htmlName){
  $this->renderElement('attribute', array('name'=>$htmlName, 'value'=>$element->$memberName));
}
?>>
<?php foreach($element->getItems() as $item){
  echo '<option';
  if($element->value == $item->value){
    print ' selected="selected"';
  }
  foreach($item->getAttributes() as $memberName => $htmlName){
    $this->renderElement('attribute', array('name'=>$htmlName, 'value'=>$item->$memberName));
  }
  echo ">{$item->label}</option>";
}
?>
</select>