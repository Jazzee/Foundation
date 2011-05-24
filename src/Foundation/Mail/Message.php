<?php
namespace Foundation\Mail;
/**
 * A single email message
 * @package Foundation\Mail
 * @todo filter name and address when they come in to check that they are valid there is probably a maximum length in a rfc somewhere
 */
class Message{  
  /**
   * Prepended to the subject of every message
   * @var string
   */
  private $_subjectPrefix;
  
  /**
   * The default address to send from if another is not specified
   * @var string
   */
  private $_defaultFrom;
  
  /**
   * Used in testing to ignore the addressee and send everythign to a testing account
   * @var string
   */
  private $_overrideTo;
  
  /**  
   * Address the email is from
   * @var string
   */
  private $_from;
  
  /**
   * Array of addresses to send the email to
   * @var array
   */
  private $_to;
  
  /**
   * Array of addresses to cc the email to
   * @var array
   */
  private $_cc;
  
  /**
   * @var string
   */
  private $_subject;
  
  /**
   * @var string
   */
  private $_body;
  
  /**
   * Construct Message
   * setup the defaults and use and configuration settings
   * @param \Foundation\Config
   */
  public function __construct(\Foundation\Configuration $config){
    $this->_subjectPrefix = $config->getMailSubjectPrefix();
    $this->_defaultFrom = false;
    $this->_overrideTo = false;
    if($config->getMailDefaultFromAddress()){
      $this->_defaultFrom = $this->makeAddress($config->getMailDefaultFromAddress(), $config->getMailDefaultFromName());
    }
    if($config->getMailOverrideToAddress()){
      $this->_overrideTo = $this->makeAddress($config->getMailOverrideToAddress(), $config->getMailOverrideToName());
    }
    
    $this->_to = array();
    $this->_cc = array();
    $this->_subject = '';
    $this->_body = '';
  }
  
  /**
   * Convert an address/name pair into a well formed address
   */
  protected function makeAddress($address, $name){
    return trim("{$name} <{$address}>");
  }
  
  /**
   * Set the From address header
   */
  public function setFrom($address, $name=''){
    $this->_from = $this->makeAddress($address, $name);
  }
  
  /**
   * Get the From address
   * @return string
   */
  public function getFrom(){
    return !empty($this->_from)?$this->_from:$this->_defaultFrom;
  }
  
  /**
   * Add a recipient
   */
  public function addTo($address, $name){
    $this->_to[] = $this->makeAddress($address, $name);
  }
  
  /**
   * Add a carbon copy
   */
  public function addCc($address, $name){
    $this->_cc[] = $this->makeAddress($address, $name);
  }
  
  /**
   * Get an array of all the receipients
   * @return array
   */
  public function getReceipients(){
    if($this->_overrideTo) return array($this->_overrideTo);
    return $this->_to;
  }
  
/**
   * Get an array of all the cced receipients
   * @return array
   */
  public function getCcReceipients(){
    if($this->_overrideTo) return array();
    return $this->_cc;
  }
  
  /**
   * Set the subject
   * @param string $subject
   */
  public function setSubject($subject){
    $this->_subject = $subject;
  }
  
  /**
   * Get the subject
   * @return string
   */
  public function getSubject(){
    return $this->_subjectPrefix . $this->_subject;
  }
  
  /**
   * Set the body
   * @param string $body
   */
  public function setBody($body){
    $this->_body = $body;
  }
  
  /**
   * Get the body
   * @return string
   */
  public function getBody(){
    return $this->_body;
  }
}
?>
