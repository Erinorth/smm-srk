<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ToolPM extends Mailable
{
    use Queueable, SerializesModels;

    public $pm;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pm)
    {
        $this->pm = $pm;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('renew.smm@egat.co.th', 'ระบบงาน Smart Maintenance Management')
                    ->subject('เครื่องมือที่ต้องบำรุงรักษาตามกำหนด')
                    ->view('emails.tool_pm');
    }
}
