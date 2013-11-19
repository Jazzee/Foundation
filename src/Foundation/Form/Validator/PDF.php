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
