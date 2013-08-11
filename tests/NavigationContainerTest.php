<?php

require_once __DIR__ . '/bootstrap.php';

class NavigationContainerTest extends TestCase
{

    public function testAddMenu()
    {
        $object = new \Foundation\Navigation\Container();
        $menu = new \Foundation\Navigation\Menu();
        $object->addMenu($menu);
        $this->assertContains($menu, $object->getMenus());
    }

    public function testAddLink()
    {
        $object = new \Foundation\Navigation\Container();
        $this->assertFalse($object->hasLink());
        $link = new \Foundation\Navigation\Link('test');
        $object->addLink($link);
        $this->assertTrue($object->hasLink());
        $this->assertContains($link, $object->getLinks());
    }
}
