<?php
namespace Foundation\Form;

/**
 * User input from a form
 *
 * @package Foundation\form
 */
class Input
{

  /**
   * Read/Write store of user input
   * Will be acted on by Filters and Proccesed by Validators
   * @var array
   */
  protected $input = array();

  /**
   * Read Only raw original input
   * @var array
   */
  protected $rawInput = array();

  /**
   * Constructor
   * Take the user input and fill the containers
   * @param array $input
   */
  public function __construct($input)
  {
    $this->rawInput = $input;
    foreach ($input as $key => $value) {
      //get rid of magic quotes
      if (get_magic_quotes_gpc()) {
        if (is_array($value)) {
          foreach ($value as $key2 => $value2) {
            $value[$key2] = \stripslashes($value2);
          }
        } else {
          $value = \stripslashes($value);
        }
      }
      if ($value === '') {
        $value = null; //convert empty strings to null values
      }
      $this->set($key, $value);
    }
  }

  /**
   * Store data
   * @param string $name the name of the data
   * @param mixed $value the value to store
   */
  public function set($name, $value)
  {
    $this->input[$name] = $value;
  }

  /**
   * Retrieve data
   * @param string $name the name of the data
   * @return mixed input data if it is set null if it isn't
   */
  public function get($name)
  {
    if (array_key_exists($name, $this->input)) {
      return $this->input[$name];
    }

    return null;
  }

  /**
   * Check if a property is set
   * @param string $name
   */
  public function checkIsset($name)
  {
    return isset($this->input[$name]);
  }

  /**
   * Unset a property
   * @param string $name
   */
  public function delete($name)
  {
    unset($this->input[$name]);
  }

}