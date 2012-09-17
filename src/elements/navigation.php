<?php
/**
 * View for navigation container
 * @package Foundation\navigation
 */
?>
<div<?php $this->renderElement('attributes', array('object'=>$container)); ?>>
  <ol>
    <?php
    if ($container->hasLink()) {
      foreach ($container->getLinks() as $link) {
        echo '<li class="link">';
          $this->renderElement('link', array('link'=>$link));
        echo '</li>';
      }
    }
    ?>
    <?php
    foreach ($container->getMenus() as $menu) {
      if ($menu->hasLink()) {
        echo '<li class="menu">';
        $this->renderElement('menu', array('menu'=>$menu));
        echo '</li>';
      }
    }
    ?>
  </ol>
</div>