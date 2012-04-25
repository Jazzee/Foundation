<?php
namespace Foundation\Virtual;
/**
 * Direcotry interface
 * @package foundation\virtual
 */
interface Directory
{
  /**
   * Find a File in the virtual direcotry
   * @param $virtualPath
   * @return \Foundation\Virtual\File | \Foundation\Virtual\Directory
   */
  function find($virtualPath);
}