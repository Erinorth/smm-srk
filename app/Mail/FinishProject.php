<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FinishProject extends Mailable
{
    use Queueable, SerializesModels;

    public $near_finish;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($near_finish)
    {
        $this->near_finish = $near_finish;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('mdc.mmd@egat.co.th', 'ระบบงาน MMD Data Center')
                    ->subject('แจ้งเตือนงานที่ใกล้จะถึงวันสิ้นสุด')
                    ->view('emails.finishproject');
    }
}
