<?php
/**
 * View for navigation container
 */
?>
<div<?php $this->renderElement('attributes', array('object'=>$container)); ?>>
  <ol><?php
  foreach($container->getMenus() as $menu){
    if($menu->hasLink()){
      echo '<li>';
      $this->renderElement('menu', array('menu'=>$menu));
      echo '</li>';
    }
  }
  ?></ol>
</div>