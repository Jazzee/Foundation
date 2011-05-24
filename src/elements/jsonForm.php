<?php
/**
 * JSON Form Element
 * Output a form in json;
 */
$f = $form;
$form = array();
$form['attributes'] = array();
foreach($f->getAttributes() as $memberName => $htmlName){
  if(isset($f->$memberName)){
    $form['attributes'][] = array(
      'name' => $htmlName,
      'value' => $f->$memberName
    );
  }
 }
 $form['fields'] = array();
 foreach($f->getFields() as $fl){
   $field = array(
     'legend' => $fl->getLegend(),
     'instructions' => $fl->getInstructions(),
     'attributes' => array(),
     'elements' => array()
   );
   foreach($fl->getAttributes() as $memberName => $htmlName){
     $value = $fl->$memberName;
     if(!is_null($value)){
       $field['attributes'][] = array(
         'name' => $htmlName,
         'value' =>$value
       );
     }
   }
   foreach($fl->getElements() as $e){
     $e->preRender();
     $element = array(
       'name' => $e->getName(),
       'class' => $e->getClass(),
       'value' => $e->getValus(),
       'required' => $e->getRequired(),
       'instructions' => $e->getInstructions(),
       'format' => $e->getFormat(),
       'label' => $e->getLabel(),
       'attributes' => array(),
       'messages' => array(),
       'items' => array(),
       'views' => array()
     );
     foreach($e->getMessages() AS $message) $element['messages'][] = $message;
     $pattern = array(
       '/^Form_/',
       '/Element$/'
     );
     $name =  get_class($element);
     do{
       $element['views'][] = $name;
       var_dump('checknames in jsonFormElement: ' , $name);
     } while ($name = get_parent_class($name) AND $name != 'AbstractElement');
     foreach($e->getAttributes() as $memberName => $htmlName){
       if(isset($e->$memberName)){
         $element['attributes'][] = array(
           'name' => $htmlName,
           'value' =>$e->$memberName
         );
       }
     }
     if(method_exists($e, 'getItems')){
       foreach($e->getItems() as $i){
         $item = array(
           'value' => $i->getValue(),
           'label' => $i->getLabel(),
           'attributes' => array(),
         ); 
         foreach($i->getAttributes() as $memberName => $htmlName){
           if(isset($i->$memberName)){
             $item['attributes'][] = array(
               'name' => $htmlName,
               'value' =>$i->$memberName
             );
           }
         }
         $element['items'][] = $item;
       }
     }
     $field['elements'][] = $element;
   }
   $form['fields'][] = $field;
 }
?>
"form":<?php print \json_encode($form); ?>