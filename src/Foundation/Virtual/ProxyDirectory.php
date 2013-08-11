<?php
namespace Foundation\Virtual;

/**
 * Proxy Directory
 * 
 * @package Foundation\virtual
 */
class ProxyDirectory implements Directory
{

    /**
     * Array of absolute file system paths keyed by virtual path
     * @var array
     */
    protected $files;

    /**
     * @var string the file system path
     */
    protected $absolutePath;

    /**
     * @var the VirtualDirectory we represent
     */
    protected $virtualDirectory;

    /**
     * Constructor
     * @param string $absolutePath;
     */
    public function __construct($absolutePath)
    {
        $this->files = array();
        if (!$this->absolutePath = \realpath($absolutePath) or
            !\is_dir($this->absolutePath) or
            !\is_readable($this->absolutePath)
        ) {
            throw new \Foundation\Exception("Unable to read '{$absolutePath}' directory.");
        }
        $this->virtualDirectory = false;
    }

    /**
     * Add a virtual path to a physical file
     * Multiple paths can point to the same object and paths can be overridden
     * @param string $virtualName
     * @param AbstractFile $file
     */
    public function addFile($virtualName, File $file)
    {
        $this->files[$virtualName] = $file;
    }

    /**
     * Load the resource as a VirtualDirectory and search it for files
     * @see Foundation\Virtual.Directory::find()
     */
    public function find($pathName)
    {
        if (\array_key_exists($pathName, $this->files)) {
            return $this->files[$pathName];
        }

        if (false != $this->virtualDirectory) {
            return $this->virtualDirectory->find($pathName);
        }
        $this->virtualDirectory = new VirtualDirectory();

        $dir = new \DirectoryIterator($this->absolutePath);
        foreach ($dir as $file) {
            if (!$file->isDot() and $file->isReadable()) {
                if ($file->isFile()) {
                    $this->virtualDirectory->addFile(
                        $file->getFilename(),
                        new RealFile($file->getFilename(), $file->getPathName())
                    );
                } elseif ($file->isDir()) {
                    $this->virtualDirectory->addDirectory(
                        $file->getFilename(),
                        new ProxyDirectory($file->getPathName())
                    );
                }
            }
        }

        return $this->find($pathName);
    }
}
