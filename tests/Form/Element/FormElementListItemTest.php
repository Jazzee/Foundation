<?php

require_once __DIR__ . '/../../bootstrap.php';
;

class FormElementListItem extends TestCase
{

    protected $field;

    public function setUp()
    {
        $form = new \Foundation\Form();
        $this->field = $form->newField();
    }

    public function testDefaultAttributes()
    {
        $object = new \Foundation\Form\Element\ListItem();
        $this->assertNull($object->getDisabled());
        $this->assertNull($object->getValue());
        $this->assertNull($object->getLabel());
    }

    public function testSetProperties()
    {
        $object = new \Foundation\Form\Element\ListItem($this->field);
        $value = uniqid();
        $attributes = array(
          'class',
          'dir',
          'id',
          'lang',
          'style',
          'title',
          'xmlLang',
          'disabled',
          'value'
        );
        foreach ($attributes as $memberName) {
            $set = 'set' . ucfirst($memberName);
            $object->$set($value);
        }
        foreach ($attributes as $memberName) {
            $get = 'get' . ucfirst($memberName);
            $this->assertEquals($value, $object->$get(), "Wrong value for {$memberName}");
        }

        $object->setLabel($value);
        $this->assertEquals($value, $object->getLabel());

        $this->assertEmpty($object->getMetadataString());
        $object->addMetadata($value);
        $this->assertContains($value, $object->getMetadataString());
    }
}
