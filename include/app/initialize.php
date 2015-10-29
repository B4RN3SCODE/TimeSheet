<?php

include_once "include/functions.php";
/*
 * Autoloader
 */
function loadClass($class) {
    if (file_exists('classes/'.$class.'.php')) { // Load class
        include "classes/$class.php";
    } else if(strpos($class,"TS") === 0) { // Load core
        if(file_exists("include/core/$class.php")) {
            include "include/core/$class.php";
        }
    } else if(strpos($class,"Controller")){ // Load controller
        $module = substr($class,0,strpos($class,"Controller"));
        if(file_exists("controllers/$module/$class.php")) {
            include "controllers/$module/$class.php";
        }
    } else {
        throw new Exception("Unable to load class: $class");
    }
}
spl_autoload_register('loadClass');