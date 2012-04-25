<?php
/**
 * JSON Form Element
 * Output a form in json
 * @package foundation\form
 */
$f = $form;
$f->setId('id');
$form = array();
$form['attributes'] = getAttributes($f);

$form['fields'] = array();
foreach($f->getFields() as $fl){
 $field = array(
   'legend' => $fl->getLegend(),
   'instructions' => $fl->getInstructions(),
   'attributes' => getAttributes($fl),
   'elements' => array()
 );
 foreach($fl->getElements() as $e){
   $e->preRender();
   $element = $e->toArray();
   $element['attributes'] = getAttributes($e);
   $element['messages'] = array();
   $element['views'] = array();
   foreach($e->getMessages() AS $message) $element['messages'][] = $message;
   $name =  get_class($e);
   do{
    $noNameSpaceName = explode('\\', $name);
    $noNameSpaceName = $noNameSpaceName[count($noNameSpaceName) - 1];
    $element['views'][] = $noNameSpaceName;
   } while ($name = get_parent_class($name));
   $field['elements'][] = $element;
 }
 $form['fields'][] = $field;
}
?>
"form":<?php print \json_encode($form, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

/**
 * Get JSON attributes
 * @package foundation\form
 */
function getAttributes(\Foundation\HTMLElement $object){
  $attributes = array();
  foreach($object->getAttributes() as $memberName => $htmlName){
    $method = 'get' . ucfirst($memberName);
    if(!method_exists($object, $method)) throw new \Foundation\Exception("Unable to access {$memberName} using {$method} on " . get_class($f));
    $value = $object->$method();
    if(!is_null($value)) $attributes[] = array('name' => $htmlName, 'value' => $value);
  }
  return $attributes;
}