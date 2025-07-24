<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestMan extends Mailable
{
    use Queueable, SerializesModels;

    public $request_man;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request_man)
    {
        $this->request_man = $request_man;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('renew.smm@egat.co.th', 'ระบบงาน Smart Maintenance Management')
                    ->subject('แจ้งเตือนการขอสนับสนุนผู้ปฏิบัติงานในงานบำรุงรักษา')
                    ->view('emails.request_man');
    }
}
