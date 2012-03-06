<?php
/**
 * Form element form control;
 */
 ?><div class='form'>
  <p class='required'>indicates a required field</p>
  <?php foreach($form->getErrorMessages() as $message){?>
    <p class='error'><?php print $message; ?></p>
  <?php } ?>
  <form<?php $this->renderElement('attributes', array('object'=>$form)); ?>>
  <?php
  foreach($form->getFields() as $field){
    $this->renderElement('field', array('field'=>$field));
  }
  ?>
  </form>
</div>