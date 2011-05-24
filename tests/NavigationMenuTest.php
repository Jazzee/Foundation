<?php
require_once __DIR__ . '/bootstrap.php';;

class NavigationMenuTest extends TestCase{
  function testAdd(){
    $object = new \Foundation\Navigation\Menu();
    $link = new \Foundation\Navigation\Link('Test');
    $object->addLink($link);
    $this->assertContains($link, $object->getLinks());
  }
  
}