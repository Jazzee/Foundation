<?php
namespace Foundation\Form\Element;
/**
 * A File Element
 */
class FileInput extends Input{
  /**
   * The maximum size in bytes
   * @var string 
   */
  protected $maxSize;
  public function __construct($field){
    parent::__construct($field);
    $this->attributes['maxsize'] = 'maxsize';
    //set the encoding type for the parent form
    $field->getForm()->setEncType('multipart/form-data');
    $this->type = 'file';
    
    $validator = new \Foundation\Form\Validator\FileInput($this, null);
    $this->addValidator($validator);
  }
  
  /**
   * Only return file for type
   * @see Foundation\Form\Element.Input::getType()
   */
  public function getType(){
    return 'file';
  }
  
  /**
   * Dont allow the type to be overridden
   * @see Foundation\Form\Element.Input::setType()
   */
  public function setType($type){
    if($type != 'file') throw new \Foundation\Exception("A type of {$type} is not allowed.  Only 'file' is allowed for this element");
  }
  
  /**
   * Get Value (no value for files)
   * @return null
   */
  public function getValue(){
    return null;
  }
  
  /**
   * Get the maxSize value
   * if no value is set return the PHP upload_max_filesize ini value
   * @return integer max size in bytes
   */
  public function getMaxSize(){
    if(is_null($this->maxSize)){
      return \convertIniShorthandValue(\ini_get('upload_max_filesize'));
    }
    return $this->maxSize;
  }
  
  /**
   * Set the maximum upload size
   * do some checking to make sure we aren't futilely setting the size larger than one of the ini options can use 
   * @param integer $maxSize max size in bytes
   */
  public function setMaxSize($maxSize){
    $maxSize = \convertIniShorthandValue($maxSize);
    if($maxSize > \convertIniShorthandValue(\ini_get('upload_max_filesize')))
      throw new \Foundation\Exception('Attempting to set FileInput::maxSize to a value greater than PHP INI upload_max_filesize');
    if($maxSize > \convertIniShorthandValue(\ini_get('post_max_size')))
      throw new \Foundation\Exception('Attempting to set FileInput::maxSize to a value greater than PHP INI post_max_size');
    $this->maxSize = $maxSize;
  }
}
?>