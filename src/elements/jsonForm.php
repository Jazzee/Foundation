<?php
/**
 * JSON Form Element
 * Output a form in json;
 */
$f = $form;
$f->setId('id');
$form = array();
$form['attributes'] = getAttributes($f);

$form['fields'] = array();
foreach($f->getFields() as $fl){
 $field = array(
   'legend' => $fl->getLegend(),
   'instructions' => htmlentities($fl->getInstructions()),
   'attributes' => getAttributes($fl),
   'elements' => array()
 );
 foreach($fl->getElements() as $e){
   $e->preRender();
   $element = array(
     'name' => $e->getName(),
     'class' => $e->getClass(),
     'value' => $e->getValue(),
     'instructions' => htmlentities($e->getInstructions()),
     'format' => htmlentities($e->getFormat()),
     'label' => $e->getLabel(),
     'attributes' => getAttributes($e),
     'messages' => array(),
     'items' => array(),
     'views' => array()
   );
   foreach($e->getMessages() AS $message) $element['messages'][] = $message;
   $name =  get_class($e);
   do{
    $noNameSpaceName = explode('\\', $name);
    $noNameSpaceName = $noNameSpaceName[count($noNameSpaceName) - 1];
    $element['views'][] = $noNameSpaceName;
   } while ($name = get_parent_class($name));
   if(method_exists($e, 'getItems')){
     foreach($e->getItems() as $i){
       $item = array(
         'value' => $i->getValue(),
         'label' => $i->getLabel(),
         'attributes' => getAttributes($i),
       ); 
       $element['items'][] = $item;
     }
   }
   $field['elements'][] = $element;
 }
 $form['fields'][] = $field;
}
?>
"form":<?php print \json_encode($form);

function getAttributes(\Foundation\HTMLElement $object){
  $attributes = array();
  foreach($object->getAttributes() as $memberName => $htmlName){
    $method = 'get' . ucfirst($memberName);
    if(!method_exists($object, $method)) throw new \Foundation\Exception("Unable to access {$memberName} using {$method} on " . get_class($f));
    $value = $object->$method();
    if(!is_null($value)) $attributes[] = array('name' => $htmlName, 'value' => htmlentities($value,ENT_COMPAT,'utf-8'));
  }
  return $attributes;
}