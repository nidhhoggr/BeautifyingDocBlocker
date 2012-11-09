<?php
$string = "11/1/2012 09:26:38 AM";
$date = date("Y-m-d", strtotime($string));
$today = date("Y-m-d");
var_dump(date_diff($date, $today));
function date_diff($date1, $date2)
{
    $current = $date1;
    $datetime2 = date_create($date2);
    $count = 0;
    while (date_create($current) < $datetime2) {
        $current = gmdate("Y-m-d", strtotime("+1 day", strtotime($current)));
        $count++;

    }
    return $count;

}

