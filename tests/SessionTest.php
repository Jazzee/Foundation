<?php
require_once __DIR__ . '/bootstrap.php';;

class SessionTest extends TestCase{
  
  
  function testSetup(){
    $s  = new \Foundation\Session();
    $vars = array(
      'name', 
      'use_only_cookies',
      'hash_function',
      'save_path',
      'cookie_secure',
      'gc_maxlifetime',
      'gc_probability',
      'gc_divisor',
      'cookie_lifetime',
      'cookie_path',
      'cookie_domain'
    );
    foreach($vars as $name){
      $this->assertEquals($s->getConfigVariable($name), ini_get('session.' . $name));
    }
  }
  
}