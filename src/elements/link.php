<?php
/**
 * View for a link
 */
?>
<a<?php $this->renderElement('attributes', array('object'=>$link)); ?>><?php echo $link->getText() ?></a>
