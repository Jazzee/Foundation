<?php
require_once __DIR__ . '/bootstrap.php';;

class NavigationContainerTest extends TestCase{
  function testAdd(){
    $object = new \Foundation\Navigation\Container();
    $menu = new \Foundation\Navigation\Menu();
    $object->addMenu($menu);
    $this->assertContains($menu, $object->getMenus());
  }
  
}