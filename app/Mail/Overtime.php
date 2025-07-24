<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Overtime extends Mailable
{
    use Queueable, SerializesModels;

    public $noti_this;
    public $noti_next;
    public $noti_year;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($noti_this,$noti_next,$noti_year)
    {
        $this->noti_this = $noti_this;
        $this->noti_next = $noti_next;
        $this->noti_year = $noti_year;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('renew.smm@egat.co.th', 'ระบบงาน Smart Maintenance Management')
                    ->subject('แจ้งเตือนล่วงเวลาเกินกรอบที่อนุมัติ')
                    ->view('emails.overtime');
    }
}
