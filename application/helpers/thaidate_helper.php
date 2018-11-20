<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('thai_date'))
{
       function thai_date($dates) {
         $thai_month = array(
            "0" => "",
            "1" => "มกราคม",
            "2" => "กุมภาพันธ์",
            "3" => "มีนาคม",
            "4" => "เมษายน",
            "5" => "พฤษภาคม",
            "6" => "มิถุนายน",
            "7" => "กรกฎาคม",
            "8" => "สิงหาคม",
            "9" => "กันยายน",
            "10" => "ตุลาคม",
            "11" => "พฤศจิกายน",
            "12" => "ธันวาคม"
        );
       

        list($date, $datetime) = explode(",", $dates);      
        list($day, $month,$year) = explode("-", date('d-m-Y', strtotime($datetime)));
        
        $year=(string)intval($year)+543;
        return $day." ".$thai_month[intval($month)]." ".$year ;
    }
}



