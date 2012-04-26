<?php
namespace Foundation\Form\Filter;
/**
 * Format phone numbers nicely into a string
 * 
 * @package Foundation\form\filter
 */
class Phonenumber extends AbstractFilter
{
  public function filterValue($value)
  {
    $number = preg_replace("#[^0-9]#", '', $value);
    $number = str_pad($number, 13, ' ', STR_PAD_LEFT);
    $num = substr($number, -4);
    $pre = substr($number, -7, 3);
    $area = substr($number, -10, 3);
    $country = (int) substr($number, -13, 3);
    if ($country == 1) {
      $country = '';//discard 1 prefix for us numbers
    }
    $string = (!empty($country))?$country . ' ':'';
    $string .= "{$area} {$pre}-{$num}";

    return $string;
  }
}