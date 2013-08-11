<?php

require_once __DIR__ . '/bootstrap.php';
;

class VirtualAbstractFileTest extends TestCase
{

    public function testGetMimeType()
    {
        $mimeTypes = array(
          'txt' => 'text/plain',
          'css' => 'text/css',
          'js' => 'application/javascript',
          'htm' => 'text/html',
          'html' => 'text/html',
          'xml' => 'application/xml',
          'swf' => 'application/x-shockwave-flash',
          'flv' => 'video/x-flv',
          'png' => 'image/png',
          'jpe' => 'image/jpeg',
          'jpeg' => 'image/jpeg',
          'jpg' => 'image/jpeg',
          'gif' => 'image/gif',
          'bmp' => 'image/bmp',
          'ico' => 'image/vnd.microsoft.icon',
          'tiff' => 'image/tiff',
          'tif' => 'image/tiff',
          'svg' => 'image/svg+xml',
          'svgz' => 'image/svg+xml',
          'pdf' => 'application/pdf'
        );
        foreach ($mimeTypes as $extenstion => $type) {
            $object = $this->getMockForAbstractClass('\Foundation\Virtual\AbstractFile', array('testfile.' . $extenstion));
            $this->assertSame($type, $object->getMimeType());
        }
        $object = $this->getMockForAbstractClass('\Foundation\Virtual\AbstractFile', array('testfile'));
        $object->expects($this->once())
                ->method('getFileContents')
                ->will($this->returnValue('some text in a file'));
        $this->assertContains('text/plain', $object->getMimeType());

        $type = 'randomtype' . uniqid();
        $object = $this->getMockForAbstractClass('\Foundation\Virtual\AbstractFile', array('testfile'));
        $object->setMimeType($type);
        $this->assertSame($type, $object->getMimeType());
    }
}
