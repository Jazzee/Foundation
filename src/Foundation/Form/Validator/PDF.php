<?php
namespace Foundation\Form\Validator;

/**
 * Ensure the uploaded file is a pdf
 * 
 * @package Foundation\form\validator
 * @author  Jon Johnson <jon.johnson@ucsf.edu>
 * @license BSD http://jazzee.org/license.html
 */
class PDF extends AbstractValidator
{

    public function validate(\Foundation\Form\Input $input)
    {
        $validMimeTypes = array('application/pdf',
          'application/pdf; charset=binary',
          'application/x-pdf',
          'application/acrobat',
          'applications/vnd.pdf',
          'text/pdf',
          'text/x-pdf');
        $fileArr = $input->get($this->e->getName());

        //There are some default types that sometiems get sent with files so we allow them seeperatly
        //octet-stream is the default mime type for any unknown binary
        // and application/download are old ways a server can force a file to be downloaed
        //firefox sometimes sends these types when its own PDF type has been overridden
        //Do this seperatly becuase it isn't really a valid mime types and shouldn't pass the file info check
        $defaultTypes = array(
          'application/octet-stream',
          'application/octetstream',
          'binary/octet-stream',
          'binary/octetstream',
          'application/force-download',
          'application/download'
        );
        //simplest check, however the type is sent by the browser and can be forged
        if (!\in_array($fileArr['type'], $validMimeTypes) and !\in_array($fileArr['type'], $defaultTypes)) {
            $this->addError(
                "Your browser is reporting that this is a file of type {$fileArr['type']} which is not a valid PDF."
            );

            return false;
        }
        //obviously easily changed but check the extension
        $arr = explode('.', $fileArr['name']);
        $extension = array_pop($arr);
        if (strtolower($extension) != 'pdf') {
            $this->addError("This is a file has the extension .{$extension} .pdf is required.");

            return false;
        }
        $finfo = finfo_open(FILEINFO_MIME);
        $mimetype = finfo_file($finfo, $fileArr['tmp_name']);
        finfo_close($finfo);
        if (!\in_array($mimetype, $validMimeTypes)) {
            $this->addError("This is a file of type {$mimetype} which is not a valid PDF.");

            return false;
        }

        return true;
    }
}
