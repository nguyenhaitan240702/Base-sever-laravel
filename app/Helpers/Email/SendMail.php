<?php

namespace App\Helpers\Email;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class SendMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public function __construct() {
        //
    }
    public function build($subject = 'Welcome to our Website', $view = 'emails.welcome'): SendMail
    {
        return $this->subject($subject)->view($view); // Customize mail with view
    }
}
