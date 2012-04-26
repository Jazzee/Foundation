<?php
namespace Foundation\Form;
/**
 * Interface for form validators
 * 
 * @package Foundation\form\validator
 */
interface Validator
{
  /**
   * Do this before rendering the element
   * Allows validators to affect display - eg required puts class decoration
   */
  function preRender();

  /**
   * Validate Input
   * @param \Foundation\Form\Input $input
   * @return true if valid | false if invalid or failed
   */
  function validate(Input $input);

  /**
   * Validate Input Even if it is null
   * This way we dont' have to accoutn for null input in EVERY validator
   * @param \Foundation\Form\Input $input
   * @return true if valid | false if invalid or failed
   */
  function validateNull(Input $input);
}