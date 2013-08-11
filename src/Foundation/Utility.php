<?php
namespace Foundation;

/**
 * Usefull utility functions
 * 
 * @package Foundation
 */
class Utility
{

    /**
     * Convert ini values like 2M into bytes
     * Copied from http://www.php.net/manual/en/function.ini-get.php
     * @param string $value
     * 
     * @return integer bytes
     */
    public static function convertIniShorthandValue($value)
    {
        $value = trim($value);
        $last = strtolower($value[strlen($value) - 1]);
        switch ($last) {
            //go from top to bottom and multiply every time
            case 'g':
                $value *= 1024;
                 //no break multipliers
            case 'm':
                $value *= 1024;
                 //no break multipliers
            case 'k':
                $value *= 1024;
        }

        return $value;
    }

    /**
     * Convert a file size in bytes to a nice format
     * From http://www.php.net/manual/en/function.filesize.php#91477
     * @param float   $bytes     what we are converting
     * @param integer $precision rounded down to this precision
     * 
     * @return string
     */
    public static function convertBytesToString($bytes, $precision = 2)
    {
        $units = array('b', 'k', 'm', 'g', 't');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . $units[$pow];
    }

    /**
     * Create gramatically correct ordinals from integer values
     * @param integer $num
     * 
     * @return string
     * 
     */
    public static function ordinalValue($num)
    {
        if ($num % 100 > 10 and $num % 100 < 14) {
            $suffix = 'th';
        } else {
            $r = $num % 10;
            switch ($r) {
                case 0:
                    $suffix = 'th';
                    break;
                case 1:
                    $suffix = 'st';
                    break;
                case 2:
                    $suffix = 'nd';
                    break;
                case 3:
                    $suffix = 'rd';
                    break;
                default:
                    $suffix = 'th';
                    break;
            }
        }

        return "{$num}<sup>{$suffix}</sup>";
    }

    /**
     * Check and array of values for null values
     * Javascript posts a string 'null' this function looks through an array
     * with the purpose of converting that to php null type
     * @param array $arr
     * 
     * @return array
     */
    public static function replaceNullString($arr)
    {
        foreach (array_keys($arr, 'null', true) as $key) {
            $arr[$key] = null;
        }

        return $arr;
    }

    /**
     * Get a preview thumbnail for a pdf
     * @param string  $blob
     * @param integer $width
     * @param integer $height
     * 
     * @return blob
     */
    public static function thumbnailPDF($blob, $width, $height)
    {
        try {
            $im = new imagick;
            $im->readimageblob($blob);
            $im->setiteratorindex(0);
            $im->setImageFormat("png");
            $im->scaleimage($width, $height);
        } catch (ImagickException $e) {
            $im = new imagick;
            $im->readimage(realpath(__DIR__ . '/media/default_pdf_logo.png'));
            $im->scaleimage($width, $height);
        }

        return $im->getimageblob();
    }

    /**
     * Check if the ip is in a range
     * Network ranges can be specified as:
     * 1. Wildcard format:     1.2.3.*
     * 2. CIDR format:         1.2.3/24  OR  1.2.3.4/255.255.255.0
     * 3. Start-End IP format: 1.2.3.0-1.2.3.255
     * Source website: http://www.pgregg.com/projects/php/ip_in_range/
     * Version 1.2
     *
     * This software is Donationware - if you feel you have benefited from
     * the use of this tool then please consider a donation. The value of
     * which is entirely left up to your discretion.
     * http://www.pgregg.com/donate/
     * 
     * 
     * @param string $ip
     * @param string $range
     * @return boolean
     */
    public static function ipInRange($ip, $range)
    {
        if (strpos($range, '/') !== false) {
            // $range is in IP/NETMASK format
            list($range, $netmask) = explode('/', $range, 2);
            if (strpos($netmask, '.') !== false) {
                // $netmask is a 255.255.0.0 format
                $netmask = str_replace('*', '0', $netmask);
                $netmask_dec = ip2long($netmask);
                return ( (ip2long($ip) & $netmask_dec) == (ip2long($range) & $netmask_dec) );
            } else {
                // $netmask is a CIDR size block
                // fix the range argument
                $x = explode('.', $range);
                while (count($x) < 4) {
                    $x[] = '0';
                }
                list($a, $b, $c, $d) = $x;
                $range = sprintf(
                    "%u.%u.%u.%u",
                    empty($a) ? '0' : $a,
                    empty($b) ? '0' : $b,
                    empty($c) ? '0' : $c,
                    empty($d) ? '0' : $d
                );
                $range_dec = ip2long($range);
                $ip_dec = ip2long($ip);

                # Strategy 1 - Create the netmask with 'netmask' 1s and then fill it to 32 with 0s
                #$netmask_dec = bindec(str_pad('', $netmask, '1') . str_pad('', 32-$netmask, '0'));
                # Strategy 2 - Use math to create it
                $wildcard_dec = pow(2, (32 - $netmask)) - 1;
                $netmask_dec = ~ $wildcard_dec;

                return (($ip_dec & $netmask_dec) == ($range_dec & $netmask_dec));
            }
        } else {
            // range might be 255.255.*.* or 1.2.3.0-1.2.3.255
            if (strpos($range, '*') !== false) { // a.b.*.* format
                // Just convert to A-B format by setting * to 0 for A and 255 for B
                $lower = str_replace('*', '0', $range);
                $upper = str_replace('*', '255', $range);
                $range = "$lower-$upper";
            }

            if (strpos($range, '-') !== false) { // A-B format
                list($lower, $upper) = explode('-', $range, 2);
                $lower_dec = (float) sprintf("%u", ip2long($lower));
                $upper_dec = (float) sprintf("%u", ip2long($upper));
                $ip_dec = (float) sprintf("%u", ip2long($ip));
                return ( ($ip_dec >= $lower_dec) && ($ip_dec <= $upper_dec) );
            }

            return false;
        }
    }
}
