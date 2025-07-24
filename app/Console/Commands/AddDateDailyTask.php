<?php

namespace App\Console\Commands;

use App\Models\Date;
use DateInterval;
use DateTime;
use Illuminate\Console\Command;

class AddDateDailyTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add_date_daily:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run add date daily task';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
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
}
