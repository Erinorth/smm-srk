<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Plan extends Mailable
{
    use Queueable, SerializesModels;

    public $plan;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($plan)
    {
        $this->plan = $plan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('renew.smm@egat.co.th', 'ระบบงาน Smart Maintenance Management')
                    ->subject('แผนงานบำรุงรักษาที่ต้อง Confirmed')
                    ->view('emails.plan');
    }
}
