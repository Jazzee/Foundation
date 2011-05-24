<?php
namespace Foundation;
/**
 * Declare an exception class for Foundation
*/
class Exception extends \RuntimeException{
  /**
   * A nice message for the user
   * Allows any exception handler to output somethign nice to the user
   * @var string
   */
  protected $userMessage;
  
  /**  
   * Override the default Exception class constructor
   * Allows nice usermessages to be part of the exception
   * 
   * @param string $sMessage a System (programmer) message
   * @param int $code the programmer specified level
   * @param string $userMessage a nice message to display to end users
   */
  public function __construct($sMessage = NULL, $code = E_ERROR, $userMessage = null){
    if (is_null($userMessage)) $this->userMessage = 'An error has occurred and we could not recover.  Please try your request again.';
    else $this->userMessage = $userMessage;
    parent::__construct($sMessage, $code);
  }
  
  /**  
   * Returns the Nice user message
   * 
   * @return string contents of SELF::uMessage
   */
  public function getUserMessage(){
    return $this->userMessage;
  }
}