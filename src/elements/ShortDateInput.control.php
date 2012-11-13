<?php
/**
 * Input element form control
 * @package Foundation\form
 * 
 */
?>
<select name='<?php print $element->getName() ?>-month'>

  <option value=''>&nbsp;</option>
  <?php 
  for ($i = 1; $i<=12; $i++) {
    print "<option value='{$i}'";
    if (!is_null($element->getValue()) AND date('n', strtotime($element->getValue())) == $i) {
      print ' selected';
    }
    print '>';
    print date('F', strtotime("{$i}/1/1970"));
    print '</option>';
  }?>
</select>
<span>&#47;</span>
<select name='<?php print $element->getName() ?>-year'>
  <option value=''>&nbsp;</option>
  <?php //go forward 5 years and back 50 years for the year dropdown 
  for ($i = date('Y', time()+31556926*5); $i >= date('Y', time()-(31556926*50)); $i--) {
    print "<option value='{$i}'";
    if (!is_null($element->getValue()) AND date('Y', strtotime($element->getValue())) == $i) {
      print ' selected';
    }
    print '>';
    print $i;
    print '</option>';
  }?>
</select>