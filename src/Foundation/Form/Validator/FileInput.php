<?php
namespace \Foundation\Form\Validator;
/**
 * File input falidator
 */
class FileInput extends AbstractValidator{
  
  /**
   * Files need to do some initial validation to ensure they were uploaded successfully
   * @param \Foundation\Form\Input $input
   */
  public function validate(\Foundation\Form\Input $input){
    $fileArr = $input->get($this->e->getName());
    //if no file was updaed
    if($fileArr['size'] == 0 AND $fileArr['name'] === ''){
      $input->set($this->e->getName(), null); //set the file upload to null
    } else {
      //look for upload errors
      if($fileArr['error'] != \UPLOAD_ERR_OK){
        switch($fileArr['error']){
          case \UPLOAD_ERR_INI_SIZE:
          case \UPLOAD_ERR_FORM_SIZE:
            $text = 'Your file is greater than the maximum allowed size of ' . \convertBytesToString($this->maxSize);
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
        //write any error messages to the validationSet
        $this->addError($text);
        return false;
      }
    }
    return true;
  }
}