<?php
require_once __DIR__ . '/bootstrap.php';;

class PKITest extends TestCase{
  /**
   * @var \Foundation\PKI
   */
  protected $pki;
  function setUp(){
    $this->pki = new \Foundation\PKI();
  }
  
  function testCreate(){
    $this->assertTrue($this->pki instanceof \Foundation\PKI);
  }
  
  function testGenerateKeys(){
    $this->pki->makeKeys();
    $privateKey = $this->pki->getPrivateKey();
    $publicKey = $this->pki->getPublicKey();
    
    $this->assertTrue(!empty($privateKey));
    $this->assertTrue(!empty($publicKey));
  }
  
  function testEncrypt(){
    $message = 'Here is the secret we must hide';
    $this->pki->makeKeys();
    $privateKey = $this->pki->getPrivateKey('123');
    $publicKey = $this->pki->getPublicKey();
    $encrypted = $this->pki->encrypt($message);
    $this->assertTrue(!empty($encrypted));
    
    $newPki = new \Foundation\PKI();
    $newPki->setPrivateKey($privateKey, '123');
    $decoded = $newPki->decrypt($encrypted);
    $this->assertEquals($message, $decoded);
  }
  
  function testExtraKeys(){
    $this->setExpectedException('Foundation\Exception');
    $this->pki->makeKeys();
    $this->pki->makeKeys();
  }
  
}