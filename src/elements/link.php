<?php
/**
 * View for a link
 * @package foundation\navigation
 */
?>
<a<?php $this->renderElement('attributes', array('object'=>$link)); ?>><?php echo $link->getText() ?></a>
