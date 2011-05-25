<?php
/**
 * View for a menu
 */
?>
<?php echo $menu->getTitle() ?>
<ol<?php $this->renderElement('attributes', array('object'=>$menu)); ?>>
<?php
foreach($menu->getLinks() as $link){
  echo '<li';
  if($link->getCurrent()){
    echo " class='current'";
  }
  echo '>';
  $this->renderElement('link', array('link'=>$link));
  echo '</li>';
}
?>
</ol>
