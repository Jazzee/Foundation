<?php
namespace Foundation\Form\Filter;
/**
 * Read the file contents as a CSV and return the array of lines
 * 
 * @package Foundation\form\filter
 */
class CSVArray extends AbstractFilter
{
  public function filterValue($value)
  {
    ini_set("auto_detect_line_endings", true);
     //some other filter might have preprocessed the file already
    if (!is_array($value)) {
      return $value;
    }
    if (
        array_key_exists('tmp_name', $value) AND
        is_uploaded_file($value['tmp_name']) AND
        $handle = \fopen($value['tmp_name'], 'r')
    ) {
      $values = array();
      while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $values[] = $data;
      }

      return $values;
    }

    return null; //failed to get any data from the file
  }
}