<?php
namespace Foundation\Mail;
/**
 * Include Pear::Mail
 */
require_once('Mail.php');
/**
 * Wrapper for sending emails
 * Fascade for Pear Mail
 * @todo: Replace Pear mail with somethign better
 * @package Foundation\Mail
 */
class Server{
  
  /**
   * Holds the Pear Mail class
   * @var Mail
   */
  private $_mail;
  
  /**
   * Parse the connection string to load options
   * @param \Foundation\Config $config
   */
  public function __construct(\Foundation\Configuration $config){
    $this->_mail = null;
    switch($config->getMailServerType()){
      case 'php':
        $this->_mail = \Mail::factory('mail');
      break;
      case 'sendmail':
        $this->_mail = \Mail::factory('sendmail');
      break;
      case 'smtp+ssl':
        $params = array('port' => 'ssl://' . $config->getMailServerHost());
        if($config->getMailServerPort()){
          $params['port'] = $config->getMailServerPort();
        }
        if($config->getMailServerUsername()){
          $params['auth'] = true;
          $params['username'] = $config->getMailServerUsername();
          $params['password'] = $config->getMailServerPassword();
        }
        $this->_mail = \Mail::factory('smtp',$params);
        break;
      case 'smtp':
        $params = array('port' => 'ssl://' . $config->getMailServerHost());
        if($config->getMailServerPort()){
          $params['port'] = $config->getMailServerPort();
        }
        if($config->getMailServerUsername()){
          $params['auth'] = true;
          $params['username'] = $config->getMailServerUsername();
          $params['password'] = $config->getMailServerPassword();
        }
        $this->_mail = \Mail::factory('smtp',$params);
      break;
      default:
        throw new \Foundation\Exception('Unknown Mail Server Type: ' . $config->getMailServerType());
    }
  }
  
  /**
   * Send an email message
   * @param EmailMessage $message
   */
  public function send(EmailMessage $message){
    $headers = array(
      'From' => $message->getFrom(),
      'Subject' => $message->getSubject(),
      'To' => implode(',', $mesage->getReceipients()),
      'Cc' => implode(',', $mesage->getCcReceipients()),
    );
    $receipients = array_merge($message->getReceipients(), $message->getCcReceipients());
    $result = $this->_mail->send($receipients, $headers, $message->getBody());
    if(true === $result) return true;
    throw new \Foundation\Exception('Unable to send email.  Server said: ' . $result->getMessage(), E_NOTICE);
  }
  
}
?>