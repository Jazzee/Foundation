<?php
/**
 * View for navigation container
 */
?>
<div<?
foreach($container->getAttributes() as $memberName => $htmlName){
  $this->renderElement('attribute', array('name'=>$htmlName, 'value'=>$container->$memberName));
}
?>>
  <ol><?php
  foreach($navigation->getMenus() as $menu){
    if($menu->hasLink()){
      echo '<li>';
      $this->renderElement('menu', array('menu'=>$menu));
      echo '</li>';
    }
  }
  ?></ol>
</div>