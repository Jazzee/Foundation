<?php
namespace Foundation\Virtual;

/**
 * Direcotry interface
 * 
 * @package Foundation\virtual
 */
interface Directory
{

    /**
     * Find a File in the virtual direcotry
     * @param $virtualPath
     * @return \Foundation\Virtual\File | \Foundation\Virtual\Directory
     */
    public function find($virtualPath);
}
