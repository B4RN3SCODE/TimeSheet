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

    static function GetBillingCycle($input_date = null) {
        $input_date = ($input_date == null) ? date("Y-m-d") : $input_date;
        $interval = new DateInterval('P2W');
        $daterange = new DatePeriod($GLOBALS["STARTDATE"], $interval ,$GLOBALS["ENDDATE"]);
        foreach($daterange as $date){
            $start_date = $date->format("Y-m-d");
            $end_date = $date->modify("+13 days")->format("Y-m-d");
            if(check_in_range($start_date,$end_date,date("Y-m-d"))) {
                return array("StartDate"=>$start_date,"EndDate"=>$end_date);
            }
        }
    }
}