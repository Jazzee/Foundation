<?php
namespace Foundation\Virtual;
/**
 * Direcotry interface
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