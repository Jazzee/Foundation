<?php
/**
 * View for a link
 * @package Foundation\navigation
 */
?>
<a<?php $this->renderElement('attributes', array('object'=>$link)); ?>><?php echo $link->getText() ?></a>
