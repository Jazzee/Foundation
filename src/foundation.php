<?php
/**
 * Jazzee Foundation Bootstrap
 * Complete basic setup for Jazzee\Foundation
 * Checks PHP version
 * Checks for required PEAR Includes
 * Sets up LIbraries
 * @package Foundation
 */
require __DIR__ . '/../vendor/autoload.php';

//load the helper functions
require_once('functions.php');

//load lightVC
require_once(__DIR__ . '/../lib/lightvc/lightvc.php');

//load the portable password hasher
require_once(__DIR__ . '/../lib/phpass/PasswordHash.class.php');