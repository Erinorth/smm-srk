<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Certificate extends Mailable
{
    use Queueable, SerializesModels;

    public $mail_measuring_all;
    public $mail_man_cer_all;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail_measuring_all,$mail_man_cer_all)
    {
        $this->mail_measuring_all = $mail_measuring_all;
        $this->mail_man_cer_all = $mail_man_cer_all;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('mdc.mmd@egat.co.th', 'ระบบงาน MMD Data Center')
                    ->subject('แจ้งเตือนใบ Certificate ที่ยังขาด')
                    ->view('emails.certificate');
    }
}
