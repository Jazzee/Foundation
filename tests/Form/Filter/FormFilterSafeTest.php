<?php

require_once __DIR__ . '/../../bootstrap.php';

class FormFilterSafeTest extends TestCase
{

    public function testFilter()
    {
        $element = $this->getMockBuilder('\Foundation\Form\Element\ListElement')
                        ->disableOriginalConstructor()->getMock();
        $object = new \Foundation\Form\Filter\Safe($element);
        $entities = get_html_translation_table(HTML_ENTITIES);
        foreach ($entities as $char => $html) {
            $this->assertEquals($html, $object->filterValue($char));
        }
    }
}
