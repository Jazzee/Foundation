<?php
namespace Foundation\Virtual;

/**
 * Virtual Directory
 * 
 * @package Foundation\virtual
 */
class VirtualDirectory implements Directory
{

    /**
     * Array of absolute file system paths keyed by virtual path
     * @var array
     */
    protected $files;

    /**
     * Array of other Direcotry Objects keyed by virtual path
     */
    protected $directories;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->files = array();
        $this->directories = array();
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
     * Add a virtual path to a new directory
     * Multiple paths can point to the same object and paths can be overridden
     * @param string $virtualName
     * @param Directory $directory
     */
    public function addDirectory($virtualName, Directory $directory)
    {
        $this->directories[$virtualName] = $directory;
    }

    /**
     * Get a virtual directory
     * @param string $virtualName
     * @return Directory
     */
    public function getDirectory($virtualName)
    {
        return $this->directories[$virtualName];
    }

    /**
     * Get a file by searching out paths
     * @param $name
     * @return \Foundation\Virtual\File;
     */
    public function find($name)
    {
        if (\array_key_exists($name, $this->files)) {
            return $this->files[$name];
        }
        //only continue if there is some text left
        if (!empty($name)) {
            //break the name down by seperator
            $arr = \explode('/', $name);
            $first = array_shift($arr);
            if (\array_key_exists($first, $this->directories)) {
                return $this->directories[$first]->find(\implode('/', $arr));
            }
        }
        throw new Exception($name, 404);
    }
}
