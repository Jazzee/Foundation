<?php
namespace Foundation\Form\Validator;

/**
 * Use the passed object to validate the input
 * 
 * @package Foundation\form\validator
 * @author  Jon Johnson <jon.johnson@ucsf.edu>
 * @license BSD http://jazzee.org/license.html
 */
class SpecialObject extends AbstractValidator
{

    /**
     * Construct 
     * Check the ruleSet
     * 
     * @param \Foundation\Form\Element $e
     * @param array $ruleSet
     */
    public function __construct(\Foundation\Form\Element $e, $ruleSet)
    {
        if (!\is_array($ruleSet)) {
            throw new \Foundation\Exception("The ruleset for SpecialObject must be an array");
        }
        if (!\array_key_exists('object', $ruleSet) or
            !\array_key_exists('method', $ruleSet) or
            !\array_key_exists('errorMessage', $ruleSet)
        ) {
            throw new \Foundation\Exception(
                "The ruleset for SpecialObject must be an array with keys 'object', 'method', and 'errorMessage'"
            );
        }
        if (!\method_exists($ruleSet['object'], $ruleSet['method'])) {
            throw new \Foundation\Exception(
                "The " . get_class($ruleSet['object']) .
                " object has no method {$ruleSet['method']} as specified in SpecialObject ruleset"
            );
        }
        parent::__construct($e, $ruleSet);
    }

    public function validate(\Foundation\Form\Input $input)
    {
        $method = $this->ruleSet['method'];
        $object = $this->ruleSet['object'];
        if (!$object->$method($input->get($this->e->getName()))) {
            $this->addError($this->ruleSet['errorMessage']);

            return false;
        }

        return true;
    }
}
