<?php
/**
 * Form element layout in a yui grid
 * Sets the structure for the element and the individual controls and displays fill in data
 * @package foundation\form
 */
//call any pre rendering functions for validators
$element->preRender(); 
?>
<div<?php $this->renderElement('attributes', array('object'=>$element)); ?>>
<?php if(!is_null($element->getInstructions())) echo '<p class="instructions">' . $element->getInstructions() . '</p>'; ?>
  <div class='element yui-gf'>
    <div class='yui-u first label'>
      <?php 
      if(!is_null($element->getLabel())){
        echo '<label for="' . $element->getName() . '">' . $element->getLabel() . ':</label> '; 
      }
      ?>
    </div>
    <div class='yui-u control'>
      <?php
        $view = \Foundation\VC\Config::findElementCacading(get_class($element), '', '.control');
        $this->renderElement($view,  array('element'=>$element));
       ?>
      <?php foreach($element->getMessages() AS $message) echo "<p class='message'>{$message}</p>"; ?>
      <?php if(!is_null($element->getFormat())) echo '<p class="format">' . $element->getFormat() . '</p>'; ?>
    </div>
  </div>
</div>