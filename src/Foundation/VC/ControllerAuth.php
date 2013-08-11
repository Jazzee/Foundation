<?php
namespace Foundation\VC;

/**
 * Define Authorization settings for a controller
 * 
 * @package Foundation\vc
 */
class ControllerAuth
{

    /**
     * A human readable name for the controllers functionality
     * @var string
     */
    public $name;

    /**
     * An array of ActionAuth classes for the controllers actions
     * @var array
     */
    protected $actions;

    /**
     * Add an action
     * @param string $name the name of the action
     * @param ActionAuth $action
     */
    public function addAction($name, ActionAuth $action)
    {
        $this->actions[$name] = $action;
    }

    /**
     * Get the actions
     */
    public function getActions()
    {
        return $this->actions;
    }
}
