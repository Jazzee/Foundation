<?php
/**
 * Input element form control;
 * 
 */
?>
 <input type='hidden' name='<?php print $element->getName() ?>' value='<? print $element->getValue() ?>' />
<select name='<?php print $element->getName() ?>-month'>

  <option value=''>&nbsp;</option>
  <?php for($i = 1;$i<=12;$i++){
    print "<option value='{$i}'";
    if(!is_null($element->getValue()) AND date('n',strtotime($element->getValue())) == $i) print ' selected';
    print '>';
    print date('F', strtotime("{$i}/1/1970"));
    print '</option>';
  }?>
</select>
<span>&#47;</span>
<select name='<?php print $element->getName() ?>-year'>
  <option value=''>&nbsp;</option>
  <?php //go forward 5 years and back 50 years for the year dropdown 
  for($i = date('Y', time()+31556926*5);$i >= date('Y', time()-(31556926*50));$i--){
    print "<option value='{$i}'";
    if(!is_null($element->getValue()) AND date('Y',strtotime($element->getValue())) == $i) print ' selected';
    print '>';
    print $i;
    print '</option>';
  }?>
</select>
<?php /* input for year - this works too
<input name='<?php print $element->name ?>-year' size='4' value='
<?php if(!is_null($element->value)){
  print date('Y',strtotime($element->value));
} else {
  print date('Y');
}?>
 ' />
*/ ?>