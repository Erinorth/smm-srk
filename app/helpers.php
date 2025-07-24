<?php

    function milestonecondition($Status){
        $complete = "Completed";
        if ( "$Status" == "$complete" ){
            $textcolor = "text-success";
        }
        $textcolor = "text-danger";
        return $textcolor;
    }

    function thaiFullMonth($month)
    {
        $thai_months = [
            '01' => 'มกราคม',
            '02' => 'กุมภาพันธ์',
            '03' => 'มีนาคม',
            '04' => 'เมษายน',
            '05' => 'พฤษภาคม',
            '06' => 'มิถุนายน',
            '07' => 'กรกฎาคม',
            '08' => 'สิงหาคม',
            '09' => 'กันยายน',
            '10' => 'ตุลาคม',
            '11' => 'พฤษจิกายน',
            '12' => 'ธันวาคม',
        ];
        $thmonth = $thai_months[$month];
        return $thmonth;
    }