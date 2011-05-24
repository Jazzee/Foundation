<?php
/**
 * Form element form control;
 */
 ?><div class='form'>
  <p class='required'>indicates a required field</p>
  <form<?
    foreach($form->getAttributes() as $memberName => $htmlName){
      $this->renderElement('attribute', array('name'=>$htmlName, 'value'=>$form->$memberName));
    }
    ?>>
  <?php
  foreach($form->getFields() as $field){
    $this->renderElement('field', array('field'=>$field));
  }
  ?>
  </form>
</div>