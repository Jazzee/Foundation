<?php
namespace Foundation\Form\Filter;

/**
 * Make sure input is safe
 * 
 * @package Foundation\form\filter
 */
class Safe extends AbstractFilter
{
    public function filterValue($value)
    {
        return htmlentities($value);
    }
}
