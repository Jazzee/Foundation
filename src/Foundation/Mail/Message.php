<?php
namespace Foundation\Mail;
/**
 * Include PHPMailer
 */
require_once(realpath(__DIR__ . '/../../../lib/phpmailer/class.phpmailer.php'));
/**
 * A single email message
 * 
 * Override PHPMailer to add configuration based setup
 * and some extra functionality
 *
 */
class Message extends \PHPMailer
{
  /**
   * Prepended to the subject of every message
   * @var string
   */
  private $_subjectPrefix;
  
  /**
   * Used in testing to ignore the addressee and send everythign to a testing account
   * @var boolean
   */
  private $_isToOverridden;
  
  /**
   * Constructor
   * 
   * Setup the server configuration in the construcor
   */
  public function __construct(\Foundation\Configuration $config){
    $this->exceptions = true;
    parent::__construct(true);
    $this->_subjectPrefix = $config->getMailSubjectPrefix();
    switch($config->getMailServerType()){
      case 'php': //we don't need to do any addtional setup for PHP mail
      break;
      case 'sendmail':
        $this->IsSendmail();
      break;
      case 'smtp+ssl':
        $this->SMTPSecure();
      case 'smtp':
        $this->IsSMTP();
        $this->Host = $config->getMailServerHost();
        if($config->getMailServerPort()){
          $this->Port = $config->getMailServerPort();
        }
        if($config->getMailServerUsername()){
          $this->SMTPAuth();
          $this->Username = $config->getMailServerUsername();
          $this->Password = $config->getMailServerPassword();
        }
      break;
    }
    //set the from address to the default and override it later
    if($config->getMailDefaultFromAddress()){
      $this->SetFrom($config->getMailDefaultFromAddress(), $config->getMailDefaultFromName(), false);
    }
    if($config->getMailOverrideToAddress()){
      $this->AddAddress($config->getMailOverrideToAddress(), $config->getMailOverrideToName());
      $this->_isToOverridden = true;
    }
  }
  
  /**
   * If overrideto is set don't add addresses
   * otherwise pass off to the parent
   * @see jazzee/lib/foundation/lib/phpmailer/PHPMailer::AddAddress()
   */
  public function AddAddress($address, $name = '') {
    if($this->_isToOverridden) return true;
    return parent::AddAddress($address, $name);
  }
  
  /**
   * If overrideto is set don't add addresses
   * otherwise pass off to the parent
   * @see jazzee/lib/foundation/lib/phpmailer/PHPMailer::AddAddress()
   */
  public function AddCC($address, $name = '') {
    if($this->_isToOverridden) return true;
    return parent::AddCC($address, $name);
  }
  
  /**
   * If overrideto is set don't add addresses
   * otherwise pass off to the parent
   * @see jazzee/lib/foundation/lib/phpmailer/PHPMailer::AddAddress()
   */
  public function AddBCC($address, $name = '') {
    if($this->_isToOverridden) return true;
    return parent::AddBCC($address, $name);
  } 
}
?>
