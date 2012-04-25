<?php
/**
 * Select element form control
 * @package foundation\form
 */
 ?>
 <select <?php $this->renderElement('attributes', array('object'=>$element)); ?>>
<?php foreach($element->getItems() as $item){
  echo '<option';
  if($element->getValue() == $item->getValue()){
    print ' selected="selected"';
  }
  $this->renderElement('attributes', array('object'=>$item));
  print '>' . $item->getLabel() . '</option>';
}
?>
</select>