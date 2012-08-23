<?php
/**
 * RankingList element form control
 * @package Foundation\form
 */
?>
<ol>
<?php
  for ($i = 0; $i < $element->getTotalItems(); $i++) {?>
    <li>
      <div class='label'>
      <label for='<?php print $element->getName() . '_' . $i ?>'><?php print \Foundation\Utility::ordinalValue($i+1)?> choice:</label>
      </div>
      <div class='control<?php
      if ($i<$element->getRequiredItems()) {
        print ' required';
      } ?>'>
      <select name='<?php print $element->getName()?>[]' id='<?php print $element->getName() . '_' . $i ?>'>
      <?php
      if ($i>=$element->getRequiredItems()) {
        print "<option value=''></option>";
      } else {
        print "<option value=''>Select {$element->getLabel()}...</option>";
      } ?>
      <?php
      foreach ($element->getItems() as $item) {
        echo '<option';
        $values = $element->getValue();
        if (isset($values[$i]) and $values[$i] == $item->getValue()) {
          print ' selected="selected"';
        }
        $this->renderElement('attributes', array('object'=>$item));
        print '>' . $item->getLabel() . '</option>';
      }
      ?>
      </select>
    </li>
<?php
  }?>
</ol>