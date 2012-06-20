<?php
/**
 * Input element form control
 * @package Foundation\form
 */
 ?>
 <input id="<?php print $element->getName();?>" <?php $this->renderElement('attributes', array('object'=>$element)); ?> />