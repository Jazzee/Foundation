<?php
namespace Foundation\Virtual;

/**
 * Interface for VirtualFiles
 * 
 * @package Foundation\virtual
 */
interface File
{

    /**
     * Get the contents of the file
     * @return string
     */
    public function getFileContents();

    /**
     * Get the name to send in the header
     * @return string
     */
    public function getName();

    /**
     * Get the mime type to send in the header
     * @return string
     */
    public function getMimeType();

    /**
     * Get the Last Modified time so we can send browser cachign info
     * @return \DateTime
     */
    public function getLastModified();

    /**
     * Output the file to the browser
     */
    public function output();
}
