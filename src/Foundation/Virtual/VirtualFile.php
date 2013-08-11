<?php
namespace Foundation\Virtual;

/**
 * Virtual File
 * Used to create a File when all we have is the binary contents
 * 
 * @package Foundation\virtual
 */
class VirtualFile extends AbstractFile
{

    /**
     * The contents of the file
     * @var string
     */
    protected $fileContents;

    /**
     * The last modified object
     * @var \DateTime
     */
    protected $lastModified;

    /**
     * Constructor
     * @param string $name
     * @param string $fileContents
     * @param string $lastModified
     */
    public function __construct($name, $fileContents, $lastModified = 'now')
    {
        parent::__construct($name);
        $this->fileContents = $fileContents;
        $this->lastModified = new \DateTime($lastModified);
    }

    /**
     * Get File Contents
     * Read the file from the filesystem
     * @see Foundation\Virtual.File::getFileContents()
     */
    public function getFileContents()
    {
        return $this->fileContents;
    }

    /**
     * Get last Modified date from the file system
     * @see Foundation\Virtual.File::getLastModified()
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }
}
