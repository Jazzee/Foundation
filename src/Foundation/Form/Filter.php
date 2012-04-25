<?php
namespace Foundation\Form;
/**
 * Filter Interface
 * @package foundation\form\filter
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