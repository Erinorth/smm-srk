<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ToolCalibrate extends Mailable
{
    use Queueable, SerializesModels;

    public $calibrate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($calibrate)
    {
        $this->calibrate = $calibrate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('renew.smm@egat.co.th', 'ระบบงาน Smart Maintenance Management')
                    ->subject('เครื่องมือที่ต้องสอบเทียบ')
                    ->view('emails.tool_calibrate');
    }
}
