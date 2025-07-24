<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Date;
use Illuminate\Http\Request;
use DateTime;
use DateInterval;
use DatePeriod;

class DateController extends Controller
{
    public function adddate()
    {
        // สร้างวันที่ปัจจุบัน
        $currentDate = new DateTime();

        // เพิ่ม 365 วัน
        $currentDate->add(new DateInterval('P365D'));

        // เก็บข้อมูลต่าง ๆ ที่เกี่ยวข้องกับวันที่
        $date = $currentDate->format('Y-m-d');
        $day = $currentDate->format('j');
        $month = $currentDate->format('n');
        $year = $currentDate->format('Y');
        $semiannual = ceil($month / 6);
        $quarter = ceil($month / 3);
        $week = $currentDate->format('W');
        $dayofweek = $currentDate->format('N');
        $dayofyear = $currentDate->format('z') + 1;

        // สร้าง array สำหรับเก็บข้อมูล
        $form_data = array(
            'Date' => $date,
            'Day' => $day,
            'Month' => $month,
            'Year' => $year,
            'SemiAnnual' => $semiannual,
            'Quarter' => $quarter,
            'Week' => $week,
            'DayofWeek' => $dayofweek,
            'DayofYear' => $dayofyear
        );

        // บันทึกข้อมูลลงฐานข้อมูล
        Date::create($form_data);

        // แสดงข้อความสำเร็จ
        echo 'add Date Success';
    }

    public function dumpdate()
    {
        $begin = new DateTime("2025-07-01");
        $end = new DateTime("2026-07-01");
        $end->modify('+1 day'); // เพิ่ม 1 วันเพื่อให้ครอบคลุมถึงวันที่สิ้นสุด
        //$end = (clone $begin)->modify('+1 year');

        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval, $end);

        foreach ($daterange as $date) {
            $day = $date->format('j');
            $month = $date->format('n');
            $year = $date->format('Y');
            $semiannual = ceil($month / 6);
            $quarter = ceil($month / 3);
            $week = $date->format('W');
            $dayofweek = $date->format('N');
            $dayofyear = $date->format('z') + 1;

            $form_data = array(
                'Date' => $date->format('Y-m-d'),
                'Day' => $day,
                'Month' => $month,
                'Year' => $year,
                'SemiAnnual' => $semiannual,
                'Quarter' => $quarter,
                'Week' => $week,
                'DayofWeek' => $dayofweek,
                'DayofYear' => $dayofyear
            );

            Date::create($form_data);
        }

        dd('dump Date Success');
    }

}
