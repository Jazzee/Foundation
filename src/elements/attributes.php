<?php
/**
 * HTML attributes element
 */
foreach($object->getAttributes() as $memberName => $htmlName){
  $method = 'get' . ucfirst($memberName);
  $value = $object->$method();
  if(!is_null($value)) print ' ' . $htmlName . '="' . htmlentities($value) . '"';
}