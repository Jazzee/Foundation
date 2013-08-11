<?php
namespace Foundation\VC;

/**
 * Authorization for a single action
 * 
 * @package Foundation\vc
 */
class ActionAuth
{

    /**
     * A human readable name for the action's functionality
     * @var string
     */
    public $name;

    /**
     * Constructor
     * @param string $name
     */
    public function __construct($name = '')
    {
        $this->name = $name;
    }
}
