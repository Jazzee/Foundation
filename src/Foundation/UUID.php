<?php
namespace Foundation;
/**
 * Generate UUIDs 
 * 
 * Required php5-uuid funtctions
 * Stolen from comments in PHP manual: http://www.php.net/manual/en/function.uniqid.php
 */
class UUID {
  
  public static function v1() {
    if (!function_exists('uuid_create'))
      throw new Exception('uuid_create function required.  Install php5-uuid package.');

    uuid_create(&$context);
    uuid_make($context, UUID_MAKE_V1);
    uuid_export($context, UUID_FMT_STR, &$uuid);
    return trim($uuid);
  }

  /**
   * Generates version 3 UUID: MD5 hash of URL
   */
  public static function v3($i_url) {
    if (!function_exists('uuid_create'))
      throw new Exception('uuid_create function required.  Install php5-uuid package.');

    if (!strlen($i_url))
      $i_url = self::v1();

    uuid_create(&$context);
    uuid_create(&$namespace);

    uuid_make($context, UUID_MAKE_V3, $namespace, $i_url);
    uuid_export($context, UUID_FMT_STR, &$uuid);
    return trim($uuid);
  }

  /**
   * Generates version 4 UUID: random
   */
  public static function v4() {
    if (!function_exists('uuid_create'))
      throw new Exception('uuid_create function required.  Install php5-uuid package.');

    uuid_create(&$context);

    uuid_make($context, UUID_MAKE_V4);
    uuid_export($context, UUID_FMT_STR, &$uuid);
    return trim($uuid);
  }

  /**
   * Generates version 5 UUID: SHA-1 hash of URL
   */
  public static function v5($i_url) {
    if (!function_exists('uuid_create'))
      throw new Exception('uuid_create function required.  Install php5-uuid package.');

    if (!strlen($i_url))
      $i_url = self::v1();

    uuid_create(&$context);
    uuid_create(&$namespace);

    uuid_make($context, UUID_MAKE_V5, $namespace, $i_url);
    uuid_export($context, UUID_FMT_STR, &$uuid);
    return trim($uuid);
  }
}
?>