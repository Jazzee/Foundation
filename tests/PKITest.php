<?php

require_once __DIR__ . '/bootstrap.php';

class PKITest extends TestCase
{

    /**
     * @var \Foundation\PKI
     */
    protected $pki;

    public function setUp()
    {
        $this->pki = new \Foundation\PKI();
    }

    public function testCreate()
    {
        $this->assertTrue($this->pki instanceof \Foundation\PKI);
    }

    public function testGenerateKeys()
    {
        $this->pki->makeKeys();
        $privateKey = $this->pki->getPrivateKey();
        $publicKey = $this->pki->getPublicKey();

        $this->assertTrue(!empty($privateKey));
        $this->assertTrue(!empty($publicKey));
    }

    public function testEncrypt()
    {
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

    public function testExtraKeys()
    {
        $this->setExpectedException('Foundation\Exception');
        $this->pki->makeKeys();
        $this->pki->makeKeys();
    }

    public function testSetKeys()
    {
        $this->pki->makeKeys();
        $publicKey = $this->pki->getPublicKey();
        $this->pki->setPublicKey($publicKey);
        $this->assertEquals($publicKey, $this->pki->getPublicKey());
    }

    public function testBadPrivateKey()
    {
        $this->pki->makeKeys();
        $privateKey = $this->pki->getPrivateKey('123');

        $this->setExpectedException('Foundation\Exception', 'Unable to unlock private key');
        $newPki = new \Foundation\PKI();
        $newPki->setPrivateKey($privateKey, '1234');
    }

    public function testEncryptMissingKey()
    {
        $this->setExpectedException('Foundation\Exception', 'Public key must be set before attempting to encrypt data');
        $this->pki->encrypt('nothing');
    }

    public function testEncryptBadInput()
    {
        $this->setExpectedException('Foundation\Exception', 'Unable to encrypt data successfully');
        $this->pki->makeKeys();
        $this->pki->encrypt('');
    }

    public function testDecryptMissingKey()
    {
        $this->setExpectedException(
            'Foundation\Exception',
            'Private key must be set before attempting to decrypt data'
        );
        $this->pki->decrypt('nothing');
    }

    public function testDecryptWrongKey()
    {
        $this->pki->makeKeys();
        $encrypted = $this->pki->encrypt('testmessage');
        $newPki = new \Foundation\PKI();
        $newPki->makeKeys();
        $this->assertFalse($newPki->decrypt($encrypted));
    }
}
