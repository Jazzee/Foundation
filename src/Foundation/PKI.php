<?php
namespace Foundation;
/**
 * Foundation class for simplyfying Public Key Encyption
 * Use the php OpenSSL library to encrypt and decrypt data
 * @package foundation
 */
class PKI{
  /**
   * Public Key
   * @var string
   */
  private $_publicKey;
  
  /**
   * Hold the openSSL resource
   * @var resource
   */
  private $_openSSL;
  
  /**
   * Constructor
   */
  public function __construct(){
    $this->_openSSL = false;
  }
  /**
   * Destrcutor 
   * Free the OpenSSL resource
   */
  public function __destruct(){
    if($this->_openSSL){
      openssl_free_key($this->_openSSL);
    }
  }
  
  /**
   * Set the private key
   * Resets the public key
   * @param string $key
   * @param string $password the private key password
   */
  public function setPrivateKey($key, $password = ''){
    if(!$this->_openSSL = openssl_pkey_get_private($key, $password)){
      throw new Exception('Unable to unlock private key');
    }
    // Extract the public key
    $details = openssl_pkey_get_details($this->_openSSL);
    $this->_publicKey = $details["key"];
  }
  
  /**
   * Set the public key
   * @param string $key
   */
  public function setPublicKey($key){
    $this->_publicKey = $key;
  }
  
  /**
   * Get the private key
   * @param string $password optionall password can be used to protect the key
   * @return string
   */
  public function getPrivateKey($password = ''){
    $key = '';
    // Extract private key
    openssl_pkey_export($this->_openSSL, $key, $password);
    return $key;
  }
  
  /**
   * Get the public key
   * @return string
   */
  public function getPublicKey(){
    return $this->_publicKey;
  }
  
  /**
   * Generate public/private keys
   * @return bool
   */
  public function makeKeys(){
    if($this->_openSSL){
      throw new Exception('Tried to generate new PKI keys when some already exist');
    }
    //Generate a new key
    $this->_openSSL = openssl_pkey_new();
    
    // Extract the public key
    $details = openssl_pkey_get_details($this->_openSSL);
    $this->_publicKey = $details["key"];
  }
  
  /**
   * Encrypt data with public key
   * @param mixed $value
   * @return string
   */
  public function encrypt($value){
    if(is_null($this->_publicKey)){
      throw new Foundation\Exception('Public key must be set before attempting to encrypt data');
    }
    //Declare reference variables
    $envelopeKeys = array();
    $encryptedData = '';
    //encrypt the data into an envelope with individual keys for each public key
    if(!openssl_seal($value, $encryptedData, $envelopeKeys, array($this->_publicKey))){
      throw new Foundation\Exception('Unable to encrypt data successfully');
    }
    //get the first key out of the envelope and use it
    return $this->encode($envelopeKeys[0], $encryptedData);
    
  }
  
  /**
   * Decrypt data with private key
   * @return mixed 
   */
  public function decrypt($value){
    if(is_null($this->_openSSL)){
      throw new Foundation_Exception('Private key must be set before attempting to decrypt data');
    }
    if(openssl_open($this->decodeData($value), $value, $this->decodeKey($value), $this->_openSSL)){
      return $value;
    }
    return false;
  }
  
  /**
   * Encode the encrypted value and key into a single string
   * To ensure easy transport base64 the strings seperated by a new line
   * @param blob $key the key we used to encrypt the data
   * @param blob $data the encrypted data
   * @return string
   */
  private function encode($key, $value){
    return base64_encode($key) . "\n" . base64_encode($value);
  }
  
  /**
   * Get the key from the encoded string
   * @param string $string
   * @return blob
   */
  private function decodeKey($string){
    $arr = explode("\n",$string);
    return base64_decode($arr[0]);
  }
  
  /**
   * Get the encrypted string from the encoded string
   * @param string $string
   * @return blob
   */
  private function decodeData($string){
    $arr = explode("\n",$string);
    return base64_decode($arr[1]);
  }
}
?>