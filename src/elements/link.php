<?php
/**
 * View for a link
 */
?>
<a<?
foreach($link->getAttributes() as $memberName => $htmlName){
  $this->renderElement('attribute', array('name'=>$htmlName, 'value'=>$link->$memberName));
}
?>><?php echo $link->getText() ?></a>
