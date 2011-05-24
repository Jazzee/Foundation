<?php
require_once __DIR__ . '/bootstrap.php';;
/**
 * @todo Figure out how to test email sending
 */
class MailServerTest extends TestCase{
  
  function testServer(){
    $server = new \Foundation\Mail\Server(new \Foundation\Configuration());
    $this->assertTrue($server instanceof \Foundation\Mail\Server);
  }
}