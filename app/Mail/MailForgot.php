<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class MailForgot extends Mailable
{

    use Queueable, SerializesModels;

    public $mailData;
  
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    public function build()
    {
        $today =  Carbon::now()->toDateTimeString(); 
        return $this->subject('Forgot Password Account')->markdown('emails.forgot');
    }

}