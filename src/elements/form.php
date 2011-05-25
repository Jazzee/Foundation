<?php
/**
 * Form element form control;
 */
 ?><div class='form'>
  <p class='required'>indicates a required field</p>
  <form<?php $this->renderElement('attributes', array('object'=>$link)); ?>>
  <?php
  foreach($form->getFields() as $field){
    $this->renderElement('field', array('field'=>$field));
  }
  ?>
  </form>
</div>