<?php

include_once("include/data/DBCon.php");
include_once "include/functions.php";
include_once("include/app/glob.php");
include_once("include/app/config.php");

/*
 * Autoloader
 */
function loadClass($class) {
    if (file_exists('classes/'.$class.'.php')) { // Load class
        include "classes/$class.php";
    } else if(strpos($class,"Array")) {
        $class = substr($class,0,strpos($class, "Array"));
        if(file_exists("classes/$class.php"))
            include "classes/$class.php";
    } else if(strpos($class,"TS") === 0) { // Load core
        if(file_exists("include/core/$class.php")) {
            include "include/core/$class.php";
        }
    } else if(strpos($class,"Controller")) { // Load controller
        $module = substr($class, 0, strpos($class, "Controller"));
        if (file_exists("controllers/$module/$class.php")) {
            include "controllers/$module/$class.php";
        }
    } else if(strpos($class,"ServiceAdapter")) { // Load service adapter
        $module = substr($class, 0, strpos($class, "ServiceAdapter"));
        if(file_exists("services/$module/$class.php")) {
            include "services/$module/$class.php";
        }
    } else {
        echo "<pre>";
        throw new Exception("Unable to load class: $class");
        echo "</pre>";
    }
}
spl_autoload_register('loadClass');