<?php

require_once __DIR__ . '/../../bootstrap.php';

class FormFilterSafeTest extends TestCase
{

    public function testFilter()
    {
        $element = $this->getMockBuilder('\Foundation\Form\Element')
                        ->disableOriginalConstructor()->getMock();
        $object = new \Foundation\Form\Filter\Safe($element);
        $entities = get_html_translation_table(HTML_ENTITIES);
        foreach ($entities as $char => $html) {
            $this->assertEquals(
                $html,
                $object->filterValue(utf8_encode($char))
            );
        }
    }

    /**
     * Test a specfic bug where <something dropped input instead of encoding
     * the < and the text correctly
     */
    public function testLeftBracketFilter()
    {
        $element = $this->getMockBuilder('\Foundation\Form\Element')
                        ->disableOriginalConstructor()->getMock();
        $object = new \Foundation\Form\Filter\Safe($element);
        $testValue = '<something and somethign else';
        $filteredValue = $object->filterValue($testValue);
        $this->assertEquals(
            '&lt;something and somethign else',
            $filteredValue
        );
        $this->assertEquals(
            $testValue,
            \Foundation\Form\Filter\Safe::unFilter($filteredValue)
        );
    }

    public function testUnFilter()
    {
        $element = $this->getMockBuilder('\Foundation\Form\Element')
                        ->disableOriginalConstructor()->getMock();
        $object = new \Foundation\Form\Filter\Safe($element);
        $entities = get_html_translation_table(HTML_ENTITIES);
        foreach ($entities as $char => $html) {
            $this->assertEquals(
                utf8_encode($char),
                Foundation\Form\Filter\Safe::unFilter(utf8_encode($char))
            );
        }
    }
    
    public function testutf8Filter()
    {
        $testString = '™ € На берегу пустынных волн' .
            'Стоял он, дум великих полн,' .
            'И вдаль глядел. Пред ним широко' .
            'Река неслася; бедный чёлн' .
            'По ней стремился одиноко.' .
            'По мшистым, топким берегам' .
            'Чернели избы здесь и там,' .
            'Приют убогого чухонца;' .
            'И лес, неведомый лучам' .
            'В тумане спрятанного солнца,' .
            'Кругом шумел.';
        $element = $this->getMockBuilder('\Foundation\Form\Element')
                        ->disableOriginalConstructor()->getMock();
        $object = new \Foundation\Form\Filter\Safe($element);
        $filtered = $object->filterValue($testString);
        $this->assertEquals(
            $testString,
            Foundation\Form\Filter\Safe::unFilter($filtered)
        );
    }
}
