<?php

/**
 * Created by PhpStorm.
 * User: chris
 * Date: 10/28/15
 * Time: 8:50 AM
 */
class base
{
    static function now() {
        return date('Y-m-d H:i:s');
    }

    static function stack_trace() {
        $entries = array();
        $trace = debug_backtrace();
        foreach($trace as $stack_entry) {
            $entries[] = array("file"=>$stack_entry["file"], "line"=>$stack_entry["line"], "function"=>$stack_entry["function"], "class"=>$stack_entry["class"]);
        }
        return array_reverse($entries);
    }
}