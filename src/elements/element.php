<?php
/**
 * Form element layout in a yui grid
 * Sets the structure for the element and the individual controls and displays fill in data;
 */
//call any pre rendering functions for validators
$element->preRender(); 
?>
<div<?php $this->renderElement('attributes', array('object'=>$link)); ?>>
<?php if(!empty($element->getInstructions())) echo '<p class="instructions">' . $element->getInstructions() . '</p>'; ?>
<?php foreach($element->getMessages() AS $message) echo "<p class='message'>{$message}</p>"; ?>
  <div class='element yui-gf'>
    <div class='yui-u first label'>
      <?php 
      if(!empty($element->getLabel())){
        echo '<label for="' . $element->getName() . '"';
        if($element->getRequired()) echo ' class="required"';
        echo '>' . $element->getLabel() . ':</label> '; 
      }
      ?>
    </div>
    <div class='yui-u control'>
      <?php
        $view = \Foundation\VC\Config::findElementCacading($className, '', '/control');
        $this->renderElement($view,  array('element'=>$element));
       ?>
      <?php if(!empty($element->getFormat())) echo '<p class="format">' . $element->getFormat() . '</p>'; ?>
    </div>
  </div>
</div>