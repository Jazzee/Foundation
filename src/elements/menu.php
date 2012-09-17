<?php
/**
 * View for a menu
 * @package Foundation\navigation
 */
?>
<a href='#'><?php echo $menu->getTitle() ?></a>
<ol<?php $this->renderElement('attributes', array('object'=>$menu)); ?>>
<?php
foreach ($menu->getLinks() as $link) {
  echo '<li class="link';
  if ($link->getCurrent()) {
    echo " current";
  }
  echo '">';
  $this->renderElement('link', array('link'=>$link));
  echo '</li>';
}
?>
</ol>
