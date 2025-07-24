<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Facility extends Mailable
{
    use Queueable, SerializesModels;

    public $mail_facility_all;
    public $mail_crane_all;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail_facility_all,$mail_crane_all)
    {
        $this->mail_facility_all = $mail_facility_all;
        $this->mail_crane_all = $mail_crane_all;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('mdc.mmd@egat.co.th', 'ระบบงาน MMD Data Center')
                    ->subject('แจ้งเตือนใบ Facility Certificate ที่ยังขาด')
                    ->view('emails.facility');
    }
}
