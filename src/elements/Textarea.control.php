<?php
/**
 * Textarea element form control
 * @package Foundation\form
 */
?>
<textarea<?php $this->renderElement('attributes', array('object'=>$element)); ?>><?php echo $element->getValue() ?></textarea>