<?php
/**
 * View for a menu
 */
?>
<?php echo $menu->getTitle() ?>
<ol<?
foreach($menu->getAttributes() as $memberName => $htmlName){
  $this->renderElement('attribute', array('name'=>$htmlName, 'value'=>$menu->$memberName));
}
?>>
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
