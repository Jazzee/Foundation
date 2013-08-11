<?php
namespace Foundation\Form\Element;

/**
 * A Hidden Input Element
 * 
 * @package Foundation\form\element
 */
class HiddenInput extends Input
{

    /**
     * Only return hidden for type
     * @see Foundation\Form\Element.Input::getType()
     */
    public function getType()
    {
        return 'hidden';
    }

    /**
     * Dont allow the type to be overridden
     * @see Foundation\Form\Element.Input::setType()
     */
    public function setType($type)
    {
        if ($type != 'hidden') {
            $message = "A type of {$type} is not allowed.  Only 'hidden' "
                    . "is allowed for this element";
            throw new \Foundation\Exception($message);
        }
    }
}
