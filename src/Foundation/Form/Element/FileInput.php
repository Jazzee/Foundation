<?php
namespace Foundation\Form\Element;
/**
 * A File Element
 * 
 * @package Foundation\form\element
 */
class FileInput extends Input
{
  /**
   * The maximum size in bytes
   * @var string 
   */
  protected $maxSize;
  public function __construct($field)
  {
    parent::__construct($field);
    $this->attributes['maxsize'] = 'maxsize';
    //set the encoding type for the parent form
    $field->getForm()->setEncType('multipart/form-data');
    $this->type = 'file';
  }

  /**
   * Fileinput has soem work done pre validation
   * @param FormInput $input
   * @return boolean
   */
  protected function validate(\Foundation\Form\Input $input)
  {
    $fileArr = $input->get($this->getName());
    //if no file was updaed
    if ($fileArr['size'] == 0 AND $fileArr['name'] === '') {
      $input->set($this->getName(), null); //set the file upload to null
    } else {
      //look for upload errors
      if ($fileArr['error'] != \UPLOAD_ERR_OK) {
        switch ($fileArr['error']) {
          case \UPLOAD_ERR_INI_SIZE:
          case \UPLOAD_ERR_FORM_SIZE:
            $text = 'Your file is greater than the maximum allowed size of ' . \Foundation\Utility::convertBytesToString($this->getMaxSize());
              break;
          case \UPLOAD_ERR_PARTIAL:
            $text = 'Your file upload was stopped before it completed.  This is probably a temporary problem with your connection to our server.  Please try again.';
              break;
          case UPLOAD_ERR_NO_FILE:
            $text = 'No file was uploaded';
              break;
          //the rest of the errors are configuration errors and throw exceptions
          case UPLOAD_ERR_NO_TMP_DIR:
            throw new \Foundation\Exception('Unable to upload file: no temporary directory was found.', \E_USER_ERROR, 'The server encountered an error uploading your file.  Please try again.');
              break;
          case UPLOAD_ERR_CANT_WRITE:
            throw new \Foundation\Exception('Unable to upload file: could not write to disk.', E_USER_ERROR, 'The server encountered an error uploading your file.  Please try again.');
              break;
          case \UPLOAD_ERR_EXTENSION:
            throw new \Foundation\Exception('Unable to upload file: A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop.', E_USER_ERROR, 'The server encountered an error uploading your file.  Please try again.');
              break;
          default:
            $text = 'There was an error uploading your file.  Please try again.';
        }
        //get rid of the input because there isn't realy a file
        $input->set($this->getName(), null);
        //write any error messages to the validationSet
        $this->addMessage($text);

        return false;
      }
    }

    return parent::validate($input);
  }

  /**
   * Only return file for type
   * @see Foundation\Form\Element.Input::getType()
   */
  public function getType()
  {
    return 'file';
  }

  /**
   * Dont allow the type to be overridden
   * @see Foundation\Form\Element.Input::setType()
   */
  public function setType($type)
  {
    if ($type != 'file') {
      throw new \Foundation\Exception("A type of {$type} is not allowed.  Only 'file' is allowed for this element");
    }
  }

  /**
   * Get Value (no value for files)
   * @return null
   */
  public function getValue()
  {
    return null;
  }

  /**
   * Get the maxSize value
   * if no value is set return the PHP upload_max_filesize ini value
   * @return integer max size in bytes
   */
  public function getMaxSize()
  {
    if (is_null($this->maxSize)) {
      return \Foundation\Utility::convertIniShorthandValue(\ini_get('upload_max_filesize'));
    }

    return $this->maxSize;
  }

  /**
   * Set the maximum upload size
   * do some checking to make sure we aren't futilely setting the size larger than one of the ini options can use 
   * @param integer $maxSize max size in bytes
   */
  public function setMaxSize($maxSize)
  {
    $maxSize = Foundation\Utility::convertIniShorthandValue($maxSize);
    if ($maxSize > Foundation\Utility::convertIniShorthandValue(\ini_get('upload_max_filesize'))) {
      throw new \Foundation\Exception('Attempting to set FileInput::maxSize to a value greater than PHP INI upload_max_filesize');
    }
    if ($maxSize > Foundation\Utility::convertIniShorthandValue(\ini_get('post_max_size'))) {
      throw new \Foundation\Exception('Attempting to set FileInput::maxSize to a value greater than PHP INI post_max_size');
    }
    $this->maxSize = $maxSize;
  }
}