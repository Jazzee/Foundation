<?php
namespace Foundation\Virtual;

/**
 * An abstract file type
 * 
 * @package Foundation\virtual
 */
abstract class AbstractFile implements File
{

    /**
     * The mimetype of file
     * @var string
     */
    protected $mimeType;

    /**
     * The name of the file
     * @var string
     */
    protected $name;

    /**
     * Constructor
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->mimeType = false;
    }

    /**
     * Guess the mime type file contents
     * @param string $fileContents
     * @return string
     */
    protected function guessMimeType($fileContents)
    {
        //first try a simple extension type
        $mimeTypes = array(
          'txt' => 'text/plain',
          'css' => 'text/css',
          'js' => 'application/javascript',
          'htm' => 'text/html',
          'html' => 'text/html',
          'xml' => 'application/xml',
          'swf' => 'application/x-shockwave-flash',
          'flv' => 'video/x-flv',
          'png' => 'image/png',
          'jpe' => 'image/jpeg',
          'jpeg' => 'image/jpeg',
          'jpg' => 'image/jpeg',
          'gif' => 'image/gif',
          'bmp' => 'image/bmp',
          'ico' => 'image/vnd.microsoft.icon',
          'tiff' => 'image/tiff',
          'tif' => 'image/tiff',
          'svg' => 'image/svg+xml',
          'svgz' => 'image/svg+xml',
          'pdf' => 'application/pdf'
        );
        $arr = explode('.', $this->getName());
        $end = array_pop($arr);
        $extension = strtolower($end);

        if (array_key_exists($extension, $mimeTypes)) {
            return $mimeTypes[$extension];
        }

        //then attempt to detect the type from the context
        $finfo = new \finfo(FILEINFO_MIME);
        $mimetype = $finfo->buffer($fileContents);
        unset($finfo);

        return $mimetype;
    }

    /**
     * @see File::getName
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the mime type
     * Guess it if we haven't set it yet.
     */
    public function getMimeType()
    {
        if (!$this->mimeType) {
            $this->mimeType = $this->guessMimeType($this->getFileContents());
        }

        return $this->mimeType;
    }

    /**
     * Set the Mime type manually
     * @param string $mimeType
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }

    /**
     * Output the file
     */
    public function output()
    {
        if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) and false !== $this->getLastModified()) {
            $headerLastModified = new \DateTime($_SERVER['HTTP_IF_MODIFIED_SINCE']);
            $headerLastModified->setTimezone(new \DateTimeZone('GMT'));
            //is the last modified time identical to the last time the file was modified)
            if ($headerLastModified == $this->getLastModified()) {
                // This is a cached file send the file time back with a 304 Not Modified header
                header('Last-Modified: ' . $this->getLastModified()->format('D, d M Y H:i:s e'), true, 304);
                exit(0);
            }
        }
        if ($this->getLastModified()) {
            header('Last-Modified: ' . $this->getLastModified()->format('D, d M Y H:i:s e'));
        }
        $contents = $this->getFileContents();
        header('Content-Type: ' . $this->getMimeType());
        header('Content-Disposition: inline; filename=' . $this->niceName($this->getName()));
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($contents));
        print $contents;
        exit(0);
    }

    /**
     * Create a nice file name
     * Stolen and modified from wordpress
     * Removes special characters that are illegal in filenames on certain
     * operating systems and special characters requiring special escaping
     * to manipulate at the command line. Replaces spaces and consecutive
     * dashes with a single dash. Trim period, dash and underscore from beginning
     * and end of filename.
     *
     * This isn't a security issues - it is a usability improvement so the downloaded files 
     * Will display correctly in Windows.
     * @param string $filename
     * @return string 
     */
    public function niceName($filename)
    {
        $filenameRaw = $filename;
        $specialChars = array(
          "?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&",
          "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}"
        );
        $filename = str_replace($specialChars, '', $filename);
        $filename = preg_replace('/[\s-]+/', '-', $filename);
        $filename = trim($filename, '.-_');

        return $filename;
    }
}
