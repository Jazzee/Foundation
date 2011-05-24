<?php
namespace Foundation\Virtual;
/**
 * Interface for VirtualFiles
 * @package Foundation\Virtual
 */
interface File{
  /**
   * Get the contents of the file
   * @return string
   */
  function getFileContents();
  
  /**
   * Get the name to send in the header
   * @return string
   */
  function getName();
  
  /**
   * Get the mime type to send in the header
   * @return string
   */
  function getMimeType();
  
  /**
   * Get the Last Modified time so we can send browser cachign info
   * @return \DateTime
   */
  function getLastModified();
  
  /**
   * Output the file to the browser
   */
  function output();
  
}
?>