<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PMOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $mail_all_NC;
    public $mail_all_C_last_week;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail_all_NC,$mail_all_C_last_week)
    {
        $this->mail_all_NC = $mail_all_NC;
        $this->mail_all_C_last_week = $mail_all_C_last_week;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('renew.smm@egat.co.th', 'ระบบงาน Smart Maintenance Management')
                    ->subject('แจ้งเตือนเลข PM Order ที่ยังไม่ได้ปิด')
                    ->view('emails.pmorder');
    }
}
