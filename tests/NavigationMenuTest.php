<?php

require_once __DIR__ . '/bootstrap.php';

class NavigationMenuTest extends TestCase
{

    public function testAdd()
    {
        $object = new \Foundation\Navigation\Menu();
        $this->assertFalse($object->hasLink());
        $link = new \Foundation\Navigation\Link('Test');
        $object->addLink($link);
        $this->assertTrue($object->hasLink());
        $this->assertContains($link, $object->getLinks());
    }

    public function testSort()
    {
        $count = 5;
        $object = new \Foundation\Navigation\Menu();
        for ($i = $count; $i >= 0; $i--) {
            $link = new \Foundation\Navigation\Link('Test' . $i);
            $object->addLink($link);
        }
        $links = $object->getLinks();
        for ($i = $count; $i >= 0; $i--) {
            $this->assertArrayHasKey($count - $i, $links);
            $this->assertEquals('Test' . $i, $links[$count - $i]->getText());
        }
        $object->sortLinks();
        $links = $object->getLinks();
        for ($i = 0; $i <= $count; $i++) {
            $this->assertArrayHasKey($i, $links);
            $this->assertEquals('Test' . $i, $links[$i]->getText());
        }
    }
}