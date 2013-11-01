<?php

require_once __DIR__ . '/../../bootstrap.php';

class FormFilterSafeHTMLTest extends TestCase
{

    public function testFilter()
    {
        $element = $this->getMockBuilder('\Foundation\Form\Element')
                        ->disableOriginalConstructor()->getMock();
        $object = new \Foundation\Form\Filter\SafeHTML($element);
        $this->assertEquals(
            "&lt;script&gt;alert('XSS')&lt;/script&gt;»&gt;",
            $object->filterValue("<SCRIPT>alert('XSS')</SCRIPT »>")
        );
        $test = "';alert(String.fromCharCode(88,83,83))//'" .
                ';alert(String.fromCharCode(88,83,83))//"' .
                'alert(String.fromCharCode(88,83,83))//";' .
                'alert(String.fromCharCode(88,83,83))//--></SCRIPT>">' .
                "><SCRIPT>alert(String.fromCharCode(88,83,83))</SCRIPT>";
        $result = "';alert(String.fromCharCode(88,83,83))//'" .
                ';alert(String.fromCharCode(88,83,83))//"alert(String.fromCharCode(88,83,83))//";' .
                'alert(String.fromCharCode(88,83,83))//--&gt;"&gt;&gt;&lt;script&gt;' .
                'alert(String.fromCharCode(88,83,83))&lt;/script&gt;';
        $this->assertEquals($result, $object->filterValue($test));
        
        $linkTarget1 = '<a href="#" target="_top">test</a>';
        $this->assertEquals($linkTarget1, $object->filterValue($linkTarget1));
        
        $linkTarget2 = '<a href="#" target="_blank">test</a>';
        $this->assertEquals($linkTarget2, $object->filterValue($linkTarget2));
    }
}
