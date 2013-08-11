<?php
namespace Foundation\Virtual;

/**
 * A physical file
 * 
 * @package Foundation\virtual
 */
class RealFile extends AbstractFile
{

    /**
     * The Absolute path to the file
     * @var string
     */
    protected $absolutePath;

    /**
     * The contents of the file
     * @var string
     */
    protected $fileContents;

    /**
     * Constructor
     * @param string $name
     * @param string $absolutePath
     */
    public function __construct($name, $absolutePath)
    {
        parent::__construct($name);
        if (!$this->absolutePath = \realpath($absolutePath) or
            !\is_readable($this->absolutePath)
        ) {
            throw new \Foundation\Exception("Unable to read '{$absolutePath}'.");
        }
        $this->fileContents = false;
    }

    /**
     * Get File Contents
     * Read the file from the filesystem
     * @see Foundation\Virtual.File::getFileContents()
     */
    public function getFileContents()
    {
        if (false !== $this->fileContents) {
            return $this->fileContents;
        }
        if (!is_readable($this->absolutePath) or !$this->fileContents = file_get_contents($this->absolutePath)) {
            throw new Exception($this->name, 404);
        }

        return $this->fileContents;
    }

    /**
     * Get last Modified date from the file system
     * @see Foundation\Virtual.File::getLastModified()
     */
    public function getLastModified()
    {
        $time = filemtime($this->absolutePath);
        $dt = new \DateTime();
        $dt->setTimestamp($time);

        return $dt;
    }
}
