<?php
namespace Foundation\Form\Filter;

/**
 * Make sure input is safe
 * 
 * @package Foundation\form\filter
 */
class Safe extends AbstractFilter
{
    /**
     * Filter the value to be safe by encoding all of the
     * HTML entities
     * @param string $value
     * @return string
     */
    public function filterValue($value)
    {
        return htmlentities($value, ENT_COMPAT, 'UTF-8', false);
    }
    
    /**
     * Undo a Filter to get the original value
     * @param string $value
     * @return string
     */
    public static function unFilter($value){
        return html_entity_decode($value, ENT_COMPAT, 'UTF-8');
    }
}
