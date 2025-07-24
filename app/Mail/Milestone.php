<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Milestone extends Mailable
{
    use Queueable, SerializesModels;

    public $milestone;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($milestone)
    {
        $this->milestone = $milestone;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('renew.smm@egat.co.th', 'ระบบงาน SMM')
                    ->subject('Mile Stone ที่ต้องดำเนินการ')
                    ->view('emails.milestone');
    }
}
