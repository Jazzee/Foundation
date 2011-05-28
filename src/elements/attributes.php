<?php
/**
 * HTML attributes element
 */
  foreach($object->getAttributes() as $memberName => $htmlName){
  $method = 'get' . ucfirst($memberName);
  if(!method_exists($object, $method)) throw new \Foundation\Exception("Unable to access {$memberName} using {$method} on " . get_class($object));
  $value = $object->$method();
  if(!is_null($value)) print ' ' . $htmlName . '="' . htmlentities($value) . '"';
}