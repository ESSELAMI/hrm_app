<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     protected $sbj, $msg;
    public function __construct($subject, $message)
    {
       $this->sbj =  $subject;
       $this->msg =  $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $e_message = $this->msg;
        $e_subject = $this->sbj;
        return $this->view('mail.mail_template',compact('e_message'))->subject($e_subject);
    }
}
