<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ToDo extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $milestone;
    public $calibrate;
    public $pm;
    public $plan;
    public $pmorder;

    public function __construct($milestone,$calibrate,$pm,$plan,$pmorder)
    {
        $this->milestone = $milestone;
        $this->calibrate = $calibrate;
        $this->pm = $pm;
        $this->plan = $plan;
        $this->pmorder = $pmorder;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {        
        return $this->subject('งานที่ต้องดำเนินการ')->markdown('emails.todo');
    }
}
