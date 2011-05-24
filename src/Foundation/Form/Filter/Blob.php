<?php
/**
 * Pull the file contents out and set them as the value
 */
class Blob extends AbstractFilter{
  public function filter($value){
    if(!is_array($value)) //some other filter might have preprocessed the file already
      return $value;
    if(array_key_exists('tmp_name', $value))
      if(is_uploaded_file($value['tmp_name']) AND $string = \file_get_contents($value['tmp_name']))
        return $string;
    
    return null; //failed to get any data from the file
  }
}
?>
