<?php
namespace Foundation\Virtual;
/**
 * Declare an exception class for Foundation\Virtual
 * Allows us to easily send error codes
*/
class Exception extends \Foundation\Exception{
  protected $httpErrorCode;
  /**  
   * Override the default Exception class constructor
   * Take the file name and the Error code and create a new Exception
   * 
   * @param string $fileName
   * @param int $httpErrorCode HTTP error code
   */
  public function __construct($fileName, $httpErrorCode){
    $this->httpErrorCode = $httpErrorCode;
    $message = "Attempting to access {$fileName} resulted in {$errorCode}";
    parent::__construct($message);
  }
  
  /**  
   * Returns httd error code
   * 
   * @return integer
   */
  public function getHttpErrorCode(){
    return $this->httpErrorCode;
  }
}