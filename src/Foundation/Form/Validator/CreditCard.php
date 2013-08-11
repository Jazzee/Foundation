<?php
namespace Foundation\Form\Validator;

/**
 * Check to see if a credit card number is valid
 * The rule set should contain an array of valid credit card type constants
 * 
 * @package Foundation\form\validator
 * @author  Jon Johnson <jon.johnson@ucsf.edu>
 * @license BSD http://jazzee.org/license.html
 */
class CreditCard extends AbstractValidator
{
    /**
     * Error for invalid card number
     * @const string
     */

    const ERROR_INVALID = 'Invalid credit card number';

    /**
     * Error if card type is not accepted
     * @const string
     */
    const ERROR_NOT_ACCEPTED = 'We do not accept this type of credit card.';

    /**
     * Credit card type constants 
     */
    const AMERICAN_EXPRESS = 2;
    const DINERS_CLUB = 4;
    const DISCOVER = 8;
    const JCB = 16;
    const MASTER_CARD = 32;
    const VISA = 64;

    public function validate(\Foundation\Form\Input $input)
    {
        $value = $input->get($this->e->getName());
        $number = \filter_var($value, FILTER_SANITIZE_NUMBER_INT);
        if (!$this->passesLuhnCheck($number)) {
            $this->addError(self::ERROR_INVALID);

            return false;
        }
        $type = $this->discoverCardType($value);
        if (!in_array($type, $this->ruleSet)) {
            $this->addError(self::ERROR_NOT_ACCEPTED);

            return false;
        }

        return true;
    }

    /**
     * Discover the credit card type from its number
     * @param integer $number
     * @return integer card type constant
     */
    protected function discoverCardType($number)
    {
        $types = array(
          //Prefix 34 or 37 15 digits.
          self::AMERICAN_EXPRESS => '#^3[47][0-9]{13}$#',
          //prefix 300-305 36, 38 length 14 or 16
          self::DINERS_CLUB => '#^3(?:0[0-5]|[68][0-9])[0-9]{11}$#',
          //prefix 6011,622,64,65 length 16
          self::DISCOVER => '#^6(?:011|5[0-9]{2})[0-9]{12}$#',
          //Prefix 2131,1800 length 15 - prefix 35 length 16
          self::JCB => '#^(?:2131|1800|35\d{3})\d{11}$#',
          //Prefix 51,52,53,54,55 length 16
          self::MASTER_CARD => '#^5[1-5][0-9]{14}$#',
          //prefix 4 length 16 (only expired cards have 13 except for some test cards 4222222222222 so we leave it in)
          self::VISA => '#^4[0-9]{12}(?:[0-9]{3})?$#'
        );
        foreach ($types as $int => $patern) {
            if (\preg_match($patern, $number)) {

                return $int;
            }
        }

        return false;
    }

    /**
     * Luhn Check on the number
     * Inspired by: http://en.wikipedia.org/wiki/Luhn_algorithm
     * @param string $number
     * @return boolean
     */
    public function passesLuhnCheck($number)
    {
        $sum = 0;
        $alt = false;
        //go backwards through the number so we don't double the check digit
        for ($i = \strlen($number) - 1; $i >= 0; $i--) {
            //double every other number
            if ($alt) {
                $digit = $number[$i] * 2;
                //if the value is two digits subtract 9 to make a single digit
                if ($digit > 9) {
                    $digit = $digit - 9;
                }
            } else {
                $digit = $number[$i];
            }
            $sum += $digit;
            $alt = !$alt;
        }
        //the result should be evenly divisble by 10

        return $sum % 10 == 0;
    }

    /**
     * Get the credit card types and their names
     * @return Array
     */
    public static function listTypes()
    {
        return array(
          self::AMERICAN_EXPRESS => 'American Express',
          self::DINERS_CLUB => 'Diners Club',
          self::DISCOVER => 'Discover',
          self::JCB => 'JCB',
          self::MASTER_CARD => 'Master Card',
          self::VISA => 'Visa'
        );
    }
}
