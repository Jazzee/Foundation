<?php
require_once __DIR__ . '/bootstrap.php';;

class MailMessageTest extends TestCase{
  //create address string - duplicates the protected function in Message class
  protected function makeAddress($address, $name){
    return trim("{$name} <{$address}>");
  }
  
  function testMessage(){
    $testAddress = uniqid() . '@example.com';
    $testName = uniqid() . ' Person ' . rand();
    $m = new \Foundation\Mail\Message(new \Foundation\Configuration());
    $this->assertTrue($m instanceof Foundation\Mail\Message);
    $m->setFrom($testAddress, $testName);
    $this->assertSame($m->getFrom(), $this->makeAddress($testAddress, $testName));
    
    for($i=1;$i<5;$i++){
      $m->addTo($i . $testAddress, $i . $testName);
      $m->addCc($i.$i . $testAddress, $i.$i . $testName);
    }
    $receipients = $m->getReceipients();
    $ccReceipients = $m->getCcReceipients();
    for($i=1;$i<5;$i++){
      $this->assertContains($this->makeAddress($i.$testAddress, $i.$testName), $receipients);
      $this->assertContains($this->makeAddress($i.$i.$testAddress, $i.$i.$testName), $ccReceipients);
    }
    
    $subject = uniqid();
    $m->setSubject($subject);
    $this->assertSame($subject, $m->getSubject());
    
    $body = uniqid();
    $m->setBody($body);
    $this->assertSame($body, $m->getBody());
  }
  
  //test the \Foundation\Config overrides we can use
  function testOverrides(){
    $testAddress = 'someone@example.com';
    $testName = 'Person Name';
    $prefix = 'Mail Prefix';
    
    $config = new \Foundation\Configuration();
    $config->setMailSubjectPrefix($prefix);
    $config->setMailDefaultFromAddress($testAddress);
    $config->setMailDefaultFromName($testName);
    $config->setMailOverrideToAddress($testAddress);
    $config->setMailOverrideToName($testName);
    
    $m = new \Foundation\Mail\Message($config);
    
    //if no address is provided
    $this->assertSame($m->getFrom(), $this->makeAddress($testAddress, $testName));
    
    $m->setFrom('new'.$testAddress, 'new'.$testName);
    $this->assertSame($m->getFrom(), $this->makeAddress('new'.$testAddress, 'new'.$testName));
    
    $subject = uniqid();
    $m->setSubject($subject);
    $this->assertSame($prefix.$subject, $m->getSubject());
    
    $m->addTo('nobody@example.com', '');
    $m->addCc('nobody2@example.com', '');
    $this->assertSame($m->getReceipients(), array($this->makeAddress($testAddress, $testName)));
    $ccs = $m->getCcReceipients();
    $this->assertTrue(empty($ccs));
  }
}