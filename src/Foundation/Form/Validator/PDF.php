<?php
namespace Foundation\Form\Validator;
/**
 * Ensure the uploaded file is a pdf
 */
class PDF extends AbstractValidator{
  public function validate(\Foundation\Form\Input $input){
    $validMimeTypes = array('application/pdf',
                            'application/pdf; charset=binary',
                            'application/x-pdf',
                            'application/acrobat',
                            'applications/vnd.pdf',
                            'text/pdf',
                            'text/x-pdf');
    $fileArr = $input->get($this->e->getName());
    //simplest check, however the type is sent by the browser and can be forged
    if(!\in_array($fileArr['type'], $validMimeTypes)){
      $this->addError("Your browser is reporting that this is a file of type {$fileArr['type']} which is not a valid PDF.");
      return false;
    }
    //obviously easily changed but check the extension
    $arr = explode('.', $fileArr['name']);
    $extension = array_pop($arr);
    if(strtolower($extension) != 'pdf'){
      $this->addError("This is a file has the extension .{$extension} .pdf is required.");
      return false;
    }
    $finfo = finfo_open(FILEINFO_MIME);
    $mimetype = finfo_file($finfo, $fileArr['tmp_name']);
    finfo_close($finfo);
    if(!\in_array($mimetype, $validMimeTypes)){
      $this->addError("This is a file of type {$mimetype} which is not a valid PDF.");
      return false;
    }
    return true;
  }
}
?>
