<?php
/**
 * FileInput element form control;
 */
 ?>
 <!-- MAX_FILE_SIZE -->
 <input type="hidden" name="MAX_FILE_SIZE" value="<?php print $element->getMaxSize() ?>" />
 
 <input<?php $this->renderElement('attributes', array('object'=>$element)); ?> />