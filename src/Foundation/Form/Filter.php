<?php
namespace Foundation\Form;
/**
 * Filter Interface
 */
interface Filter{
  
  /**
   * Filter the input
   * @param mixed $value
   * @return mixed $value
   */
  function filterValue($value);
}
?>