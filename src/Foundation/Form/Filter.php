<?php
namespace Foundation\Form;

/**
 * Filter Interface
 * 
 * @package Foundation\form\filter
 */
interface Filter
{

    /**
     * Filter the input
     * @param mixed $value
     * @return mixed $value
     */
    public function filterValue($value);
}
