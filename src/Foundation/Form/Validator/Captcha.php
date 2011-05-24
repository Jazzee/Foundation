<?php
namespace Foundation\Form\Validator;
/**
 * Check to see if the captcha was valid
 * @author Jon Johnson <jon.johnson@ucsf.edu>
 * @license http://jazzee.org/license.txt
 * @package foundation
 * @subpackage forms
 */
class Captcha extends AbstractValidator{
  /**
   * The verification server
   */
  const VERIFY_SERVER = 'www.google.com';
  
  /**
   * Use ValidateNull becuase the actual input for the element is not what is important
   * @param \Foundation\Form\Input $input
   */
  public function validateNull(\Foundation\Form\Input $input){
    //discard empty submissions
    if (
      $input->get('recaptcha_challenge_field') == null || 
      \strlen($input->get('recaptcha_challenge_field')) == 0 || 
      $input->get('recaptcha_response_field') == null || 
      \strlen($input->get('recaptcha_response_field')) == 0) {
        $this->e->errorString = 'incorrect-captcha-sol';
        $this->addError('');
        return false;
    }

    $response = $this->http_post (self::VERIFY_SERVER, "/verify", array (
      'privatekey' => $this->ruleSet,
      'remoteip' => $_SERVER['REMOTE_ADDR'],
      'challenge' => $input->get('recaptcha_challenge_field'),
      'response' => $input->get('recaptcha_response_field')
     )
    );

    $answers = explode ("\n", $response [1]);
    if (trim($answers[0]) == 'false') {
      $this->e->errorString = $answers[1];
      $this->addError('');
      return false;
    }
    return true;
  }
  
  /**
   * Encodes the given data into a query string format
   * @param $data - array of string elements to be encoded
   * @return string - encoded request
   */
  private function qsencode ($data) {
    $req = "";
    foreach ( $data as $key => $value )
      $req .= $key . '=' . \urlencode( \stripslashes($value) ) . '&';
    // Cut the last '&'
    $req=substr($req,0,\strlen($req)-1);
    return $req;
  }
  
  /**
   * Submits an HTTP POST to a reCAPTCHA server
   * @param string $host
   * @param string $path
   * @param array $data
   * @param int port
   * @return array response
   */
  private function http_post($host, $path, $data, $port = 80) {
    $req = $this->qsencode ($data);
  
    $http_request  = "POST $path HTTP/1.0\r\n";
    $http_request .= "Host: $host\r\n";
    $http_request .= "Content-Type: application/x-www-form-urlencoded;\r\n";
    $http_request .= "Content-Length: " . \strlen($req) . "\r\n";
    $http_request .= "User-Agent: reCAPTCHA/PHP\r\n";
    $http_request .= "\r\n";
    $http_request .= $req;
  
    $response = '';
    if( false == ( $fs = @\fsockopen($host, $port, $errno, $errstr, 10) ) ) {
      throw new \Foundation\Exception('reCaptcha could not open network socket');
    }
  
    \fwrite($fs, $http_request);
  
    while ( !\feof($fs) )
      $response .= \fgets($fs, 1160); // One TCP-IP packet
    \fclose($fs);
    $response = \explode("\r\n\r\n", $response, 2);
  
    return $response;
  }
}