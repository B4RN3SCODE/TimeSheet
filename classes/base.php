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

    static function GetBillingCycle($input_date = null, DateTime $start_date = null, DateTime $end_date = null) {
        $start_date = ($start_date == null) ? $GLOBALS["STARTDATE"] : $start_date;
        $input_date = ($input_date == null) ? date("Y-m-d") : $input_date;
        $end_date = ($end_date == null) ? $GLOBALS["ENDDATE"] : $end_date;
        $daterange = new DatePeriod($start_date, new DateInterval('P2W'), $end_date);
        foreach($daterange as $date){
            $start_date = $date->format("Y-m-d");
            $end_date = $date->modify("+13 days")->format("Y-m-d");
            if(check_in_range($start_date,$end_date,$input_date)) {
                // Ensure that the current billing cycle is in the table.
                $TimeSheetPeriod = new TimeSheetPeriod();
                $TimeSheetPeriod->setCycleStart($start_date);
                $TimeSheetPeriod->setCycleEnd($end_date);
                $TimeSheetPeriod->save();
                return array("StartDate"=>$start_date,"EndDate"=>$end_date,"Period"=>$TimeSheetPeriod->getId());
            }
        }
        $end_date = new DateTime($end_date);
        return self::GetBillingCycle(new DateTime($start_date), $input_date, new DateTime($end_date->modify("+1 year")->format("Y-m-d")));
    }
}