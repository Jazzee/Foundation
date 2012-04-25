<?php
/**
 * Textarea element form control
 * @package foundation\form
 */
?>
<textarea<?php $this->renderElement('attributes', array('object'=>$element)); ?>><?php echo $element->getValue() ?></textarea>