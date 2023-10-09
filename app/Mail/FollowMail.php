<?php


namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FollowMail extends Mailable
{
    use Queueable, SerializesModels;

    public $followEmail;

    public function __construct($followEmail)
    {
        $this->followEmail = $followEmail;
    }


    public function build()
    {
        return $this->from(env("MAIL_USERNAME"))
            ->subject('New client')
            ->view('emails.email',["email"=> $this->followEmail]);
    }
}
