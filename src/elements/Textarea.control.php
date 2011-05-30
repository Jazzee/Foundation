<?php
/**
 * Textarea element form control;
 */
?>
<textarea<?php $this->renderElement('attributes', array('object'=>$element)); ?>><?php echo $element->getValue() ?></textarea>