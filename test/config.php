<?php
/**
 * Include autoloader.
 */

define("INSTALL_PATH", realpath(__DIR__ . "/.."));

require INSTALL_PATH .  "/vendor/autoload.php";

foreach (glob(__DIR__ . "/mock/*.php") as $file) {
    require $file;
}
